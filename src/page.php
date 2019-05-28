<?php

/**
 * Class page
 */
class page
{
    private $title;
    public $db;

    /**
     * page constructor.
     * @param string $title
     * @param bool $sidebar
     * @param bool $connection
     */
    public function __construct(string $title, bool $sidebar, bool $connection, bool $bestellingSidebar = false)
    {
        // define base folder
        define('ROOT', $_SERVER["DOCUMENT_ROOT"] . '/excellenttaste/');

        // bind parameters to variables
        $this->title = $title;

        // require header and functions
        require ROOT . 'includes/header.php';
        require ROOT . 'includes/functions.php';

        // require sidebar of sidebar is true
        $sidebar ? $this->generateSidebar() : NULL;

        // require bestelling sidebar of bestellingSidebar is true
        $bestellingSidebar ? $this->generateBestellingSidebar() : NULL;

        // create connection if $connection is true
        $connection ? $this->createConnection() : NULL;
    }

    /**
     * Generates sidebar if $sidebar = true
     */
    private function generateSidebar()
    {
        require ROOT . 'includes/sidebar.php';
    }

    /**
     * Generates sidebar if $sidebar = true
     */
    private function generateBestellingSidebar()
    {
        require ROOT . 'includes/bestelling-sidebar.php';
    }

    /**
     * Creates database connection if $connection = true
     */
    private function createConnection()
    {
        require ROOT . 'src/PDO.class.php';
        $this->db = new DB();
    }

    /**
     * @return array
     */
    public function fetchGerechten()
    {
        $gerechten = [];

        foreach ($this->db->query("SELECT * FROM `gerecht`") as $gerecht) {
            $gerechten[] = array($gerecht['gerechtcode'], $gerecht['gerecht']);
        }

        return $gerechten;
    }

    /**
     * @return array
     * Fetches all subgerechten
     */
    public function fetchSubgerechten()
    {
        $gerechten = [];

        foreach ($this->db->query("SELECT * FROM `subgerecht`") as $subgerecht) {
            $gerechten[] = array($subgerecht['subgerechtcode'], $subgerecht['subgerecht']);
        }

        return $gerechten;
    }

    /**
     * @param $id
     * @return mixed
     * Fetches Subgerechten that belong to a gerecht
     */
    public function fetchAccessorySubgerechten($id)
    {
        return $this->db->query('SELECT `subgerechtcode`,`subgerecht` FROM `subgerecht` WHERE `gerechtcode` = :id', array('id' => $id));
    }

    /**
     * @param $id
     * @return mixed
     * Returns all items in subgerecht
     */
    public function fetchAccessoryMenuitems($id)
    {
        return $this->db->query('SELECT * FROM `menuitem` WHERE `subgerechtcode` = :id', array('id' => $id));
    }

    /**
     * @param $id
     * @return mixed
     * returns accessory gerechtcode from subgerechtcode
     */
    public function fetchAccessoryGerechtcode($id)
    {
        return $this->db->single("SELECT `gerechtcode` FROM `subgerecht` WHERE `subgerechtcode` = :subgerechtcode", array('subgerechtcode' => $id));
    }

    /**
     * @param int $id
     * @return mixed
     * Fetches menu item by id
     */
    public function fetchMenuitem(int $id)
    {
        return $this->db->row('SELECT * FROM `menuitem` WHERE `menuitemcode` = :id', array('id' => $id));
    }

    /**
     * @param string $type
     * @return string
     */
    public function generateMenu(string $type)
    {
        $menu = '';
        $menuQuery = '';

        //Get query from menutype
        switch ($type) {
            case 'dranken':
                $menuQuery = "SELECT * FROM `gerecht` WHERE `gerechtcode` = '4'";
                break;
            case 'gerechten':
                $menuQuery = "SELECT * FROM `gerecht` WHERE `gerechtcode` != '4'";
                break;
            default:
                break;
        }

        //Loop through `gerecht`
        foreach ($this->db->query($menuQuery) as $gerecht) {
            //Display gerechten title
            $menu .= '<div class="bg-light p-2 h4 m-0 font-weight-bold">' . $gerecht['gerecht'] . '</div>';

            //loop through subgerechten
            foreach ($this->db->query("SELECT * FROM `subgerecht` WHERE `gerechtcode` = '" . $gerecht['gerechtcode'] . "'") as $subgerecht) {
                //Display subgerecht title
                $menu .= '
            <div class="bg-light p-2 h5 m-0 font-weight-bold border">' . $subgerecht['subgerecht'] . '</div>
            <table class="table bg-light m-0">
                <thead>
                    <tr>
                        <th class="w-10">Code</th>
                        <th class="w-50">Product</th>
                        <th class="w-10">Prijs</th>
                        <th class="w-10">Wijzigen</th>
                        <th class="w-10">Verwijderen</th>
                    </tr>
                </thead>
                <tbody>';

                //loop through menuitems
                foreach ($this->db->query("SELECT * FROM `menuitem` WHERE `subgerechtcode` = '" . $subgerecht['subgerechtcode'] . "'") as $item) {
                    $menu .= '
                    <tr>
                        <td class="w-10">' . $item['menuitemcode'] . '</td>
                        <td class="w-50">' . $item['menuitem'] . '</td>
                        <td class="w-10">€' . $item['prijs'] . ',-</td>
                        <td class="w-10">
                            <form method="post" action="product-beheer.php">
                                <input type="hidden" name="menuItemCode" value="' . $item['menuitemcode'] . '">
                                <input type="submit" name="menuItemWijzigen" value="Wijzigen" class="btn-link btn-none">
                            </form>
                        </td>
                        <td class="w-10">
                            <div class="btn-link verwijderItem" id="item-' . $item['menuitemcode'] . '">Verwijderen</div>
                        </td>
                    </tr>';

                }
                //close table
                $menu .= '                
                </tbody>
            </table>';
            }

            //breakline to split tables
            $menu .= '<br>';
        }

        //return menu
        return $menu;
    }

    /**
     * @param string $klantnaam
     * @param string $telefoon
     * @return mixed
     * Get client data by klantnaam and telefoon
     */
    public function getClient(string $klantnaam, string $telefoon)
    {
        return $this->db->row("SELECT * FROM `klant` WHERE `klantnaam` = :klantnaam AND `telefoon` = :telefoon", array('klantnaam' => $klantnaam, 'telefoon' => $telefoon));
    }

    /**
     * @param string $klantnaam
     * @param string $telefoon
     * @return mixed
     * Get ID from client
     */
    public function getClientID(string $klantnaam, string $telefoon)
    {
        return $this->getClient($klantnaam, $telefoon)['klantid'];
    }

    /**
     * @param string $klantnaam
     * @param string $telefoon
     * @return bool
     * Check if client exists in table `klant`
     */
    public function checkIfClientExists(string $klantnaam, string $telefoon)
    {
        return $this->getClient($klantnaam, $telefoon) ? true : false;
    }

    /**
     * @param string $klantnaam
     * @param string $telefoon
     * Function creates a new client
     */
    public function createClient(string $klantnaam, string $telefoon)
    {
        $this->db->query("INSERT INTO `klant` (`klantid`, `klantnaam`, `telefoon`) VALUES (NULL, :klantnaam, :telefoon);", array('klantnaam' => $klantnaam, 'telefoon' => $telefoon));
    }

    /**
     * @param $id
     * @return mixed
     * Check if client has denied a reservation before
     */
    public function clientDeniedReservation($id)
    {
        return $this->db->query("SELECT * FROM `reservering` WHERE `klantid` = :klantid AND `gebruikt` = 0", array('klantid' => $id));
    }

    /**
     * @param string $tafel
     * @param $datum
     * @param $tijd
     * @param string $klantid
     * @param string $aantal
     * @return mixed
     * Creates a new reservation
     */
    public function createReservation(string $tafel, $datum, $tijd, string $klantid, string $aantal, $allergieen, $opmerkingen)
    {
        return $this->db->query("INSERT INTO `reservering` (`tafel`, `datum`, `tijd`, `klantid`, `aantal`, `gebruikt`, `allergieen`, `opmerkingen`) VALUES (:tafel, :datum, :tijd, :klantid, :aantal, false, :allergieen, :opmerkingen);", array('tafel' => $tafel, 'datum' => $datum, 'tijd' => $tijd, 'klantid' => $klantid, 'aantal' => $aantal, 'allergieen' => $allergieen, 'opmerkingen' => $opmerkingen));
    }

    /**
     * @param $sessionID
     * @return mixed|string
     * Removes session and returns session value
     */
    public function sessionsMessages($sessionID)
    {
        $sessionValue = '';

        if (isset($_SESSION[$sessionID])) {
            $sessionValue = $_SESSION[$sessionID];
            unset($_SESSION[$sessionID]);
        }

        return $sessionValue;
    }

    /**
     * @return string
     * Get all upcomming reservations
     */
    public function getReservations(bool $vandaag)
    {
        if ($vandaag) {
            $reservations = $this->db->query("SELECT reservering.tafel, reservering.datum, reservering.tijd, reservering.aantal, reservering.gebruikt, reservering.allergieen, reservering.gebruikt, reservering.opmerkingen, klant.klantnaam, klant.telefoon FROM `reservering` INNER JOIN klant ON reservering.klantid = klant.klantid WHERE `datum` = CURDATE() ORDER BY `datum`, `tijd`");
        } else {
            $reservations = $this->db->query("SELECT reservering.tafel, reservering.datum, reservering.tijd, reservering.aantal, reservering.gebruikt, reservering.allergieen, reservering.gebruikt, reservering.opmerkingen, klant.klantnaam, klant.telefoon FROM `reservering` INNER JOIN klant ON reservering.klantid = klant.klantid ORDER BY `datum`, `tijd`");
        }


        $return = '<table class="table bg-light m-0">
                <thead>
                    <tr>
                        <th class="w-10">Datum</th>
                        <th class="w-10">Tijd</th>
                        <th class="w-10">Naam</th>
                        <th class="w-10">Tafel</th>
                        <th class="w-10">Aantal</th>
                        <th class="w-10">Telefoon</th>
                        <th class="w-10">Allergieën</th>
                        <th class="w-10">Opmerkingen</th>
                        <th class="w-10">Aanwezig</th>
                        <th class="w-10">Wijzigen</th>
                        <th class="w-10">Verwijderen</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($reservations as $reservation) {
            //Text if client is present
            $aanwezigName = $reservation['gebruikt'] === 1 ? 'Ja' : 'Nee';

            $return .= '
            <tr>
                <td>' . $reservation['datum'] . '</td>
                <td>' . $reservation['tijd'] . '</td>
                <td>' . $reservation['klantnaam'] . '</td>
                <td>' . $reservation['tafel'] . '</td>
                <td>' . $reservation['aantal'] . '</td>
                <td>' . $reservation['telefoon'] . '</td>
                <td>' . $reservation['allergieen'] . '</td>
                <td>' . $reservation['opmerkingen'] . '</td>
                <td>' . $aanwezigName . '</td>
                <td>
                    <form method="post" action="reservering-wijzigen.php">
                        <input type="hidden" name="reservationTafel" value="' . $reservation['tafel'] . '">
                        <input type="hidden" name="reservationDatum" value="' . $reservation['datum'] . '">
                        <input type="hidden" name="reservationTijd" value="' . $reservation['tijd'] . '">
                        <input type="submit" name="reservationWijzigen" value="Wijzigen" class="btn-link btn-none">
                    </form>
                </td>
                <td>
                    <form method="post" action="reservering-wijzigen.php">
                        <input type="hidden" class="verwijderTafel" value="' . $reservation['tafel'] . '">
                        <input type="hidden" class="verwijderDatum" value="' . $reservation['datum'] . '">
                        <input type="hidden" class="verwijderTijd" value="' . $reservation['tijd'] . '">
                        <input type="button" value="Verwijderen" class="btn-link btn-none reservationVerwijderen">
                    </form>
                </td>
            </tr>
            ';
        }

        return $return . '</tbody></table>';
    }

    /**
     * @param $tafel
     * @param $datum
     * @param $tijd
     * @return mixed
     * Get reservation data by tafel, datum and tijd
     */
    public function getReservationByKey($tafel, $datum, $tijd)
    {
        return $this->db->row("SELECT * FROM `reservering` WHERE `tafel` = :tafel AND `datum` = :datum AND `tijd` = :tijd", array('tafel' => $tafel, 'datum' => $datum, 'tijd' => $tijd));
    }

    /**
     * @param $type
     * @return mixed
     * Returns list of things that need to get delivered
     */
    public function getDeliverList($type)
    {
        if ($type === 'ober') {
            return $this->db->query("SELECT `bestelling`.`id`, `bestelling`.`tafel`, `bestelling`.`datum`, `bestelling`.`tijd`, `bestelling`.`geleverd`, `bestelling`.`aantal`, `bestelling`.`prijs`, `menuitem`.`gerechtcode`,`menuitem`.`subgerechtcode`, `menuitem`.`menuitem` FROM `bestelling` INNER JOIN `menuitem` ON `bestelling`.`menuitemcode` = `menuitem`.`menuitemcode` WHERE `bestelling`.`datum` = CURDATE() AND `bestelling`.`geleverd` = 1 ORDER BY geleverd, tafel, datum, tijd");
        } else {
            return $this->db->query("SELECT `bestelling`.`id`, `bestelling`.`tafel`, `bestelling`.`datum`, `bestelling`.`tijd`, `bestelling`.`geleverd`, `bestelling`.`aantal`, `bestelling`.`prijs`, `menuitem`.`gerechtcode`,`menuitem`.`subgerechtcode`, `menuitem`.`menuitem` FROM `bestelling` INNER JOIN `menuitem` ON `bestelling`.`menuitemcode` = `menuitem`.`menuitemcode` WHERE `bestelling`.`datum` = CURDATE() ORDER BY geleverd, tafel, datum, tijd");
        }
    }

    /**
     * @param string $type
     * @return string
     * Generates the delivery list for cook and ober
     */
    public function generateDeliveryList(string $type)
    {

        //return and save variable
        $currentTable = '';
        $return_data = '';

        switch ($type) {
            case 'barman':
                $allowed_array = [4];
                break;
            case 'kok':
                $allowed_array = [1, 2, 3, 5];
                break;
            case 'ober':
                $allowed_array = [1, 2, 3, 4, 5];
                break;
        }

        //Loop through all deliveries
        foreach ($this->getDeliverList($type) as $delivery) {

            //Check if delivery is assigned to current role/page
            if (in_array($delivery['gerechtcode'], $allowed_array)) {

                //Create new table for each new tafel
                if ($currentTable !== $delivery['tafel']) {

                    //Only end table if there is a table tag opened
                    if ($currentTable !== '') {
                        $return_data .= '
                        </tbody>
                    </table>';
                    }

                    //Create beginning of the table
                    $return_data .= '
                    <div class="bg-light p-2 h5 m-0 font-weight-bold border">Tafel - ' . $delivery['tafel'] . '</div>
                    <table class="table bg-light m-0 mb-2">
                        <thead>
                            <tr>
                                <th class="w-25">Tijd</th>
                                <th class="w-25">Product</th>
                                <th class="w-25">Aantal</th>
                                <th class="w-25">Geserveerd</th>
                            </tr>
                        </thead>
                        <tbody>';

                    //Current table is new table
                    $currentTable = $delivery['tafel'];
                }

                //Insert data in table
                $return_data .= '
                <tr>
                    <td>' . $delivery['tijd'] . '</td>
                    <td>' . $delivery['menuitem'] . '</td>
                    <td>' . $delivery['aantal'] . '</td>
                    <td>
                        <form method="post" action="reservering-wijzigen.php">
                            <input type="hidden" class="bestellingID" value="' . $delivery['id'] . '">';
                $return_data .= $delivery['geleverd'] === 0 ? '<input type="button" value="Klaarzetten voor serveren" class="btn-link text-info btn-none bestellingGeleverd">' : '<div class="text-success"><i class="fa fa-check"></i> Klaar om te serveren</div>';
                $return_data .= '
                        </form>
                    </td>
                </tr>';
            }
        }

        //return table
        if ($return_data === '') {
            return '<div class="bg-light p-2 h5 m-0 font-weight-bold border">Je bent helemaal bij, er zijn geen nieuwe bestellingen geplaatst</div>';
        } else {
            return $return_data;
        }
    }

    /**
     * @return mixed
     * Returns all reserverd tables of today
     */
    public function getReservationTables()
    {
        return $this->db->query("SELECT * FROM `reservering` WHERE `datum` = CURDATE()");
    }

    /**
     * @return string
     * Generates a dropdown for reservations of today
     */
    public function createReservationTableDropwdown()
    {
        $dropdown = '
        <select class="w-100 p-2 mb-2 tafelSelect" id="tafelSelect">
            <option selected disabled>-- Selecteer een tafel --</option>';

        //Loop through reserved tables
        foreach ($this->getReservationTables() as $table) {
            $dropdown .= '<option value="' . $table['tafel'] . '">Tafel ' . $table['tafel'] . '</option>';

        }

        return $dropdown . '</select>';
    }

    /**
     * @param $id
     * @param $amount
     * @return float|int
     * Returns price of item(s)
     */
    public function getItemPrice($id, $amount)
    {
        $pricePerItem = $this->db->single('SELECT `prijs` FROm `menuitem` WHERE `menuitemcode` = :menuitemcode', array('menuitemcode' => $id));

        return $pricePerItem * $amount;
    }

    /**
     * @param $tafel
     * @return mixed
     * Returns all bestelling from a table
     */
    public function getBestellingenFromTable($tafel)
    {
        return $this->db->query("SELECT `bestelling`.`aantal`, `bestelling`.`prijs`, `menuitem`.`menuitem` FROM `bestelling` INNER JOIN `menuitem` ON `bestelling`.`menuitemcode` = `menuitem`.`menuitemcode` WHERE `datum` = CURDATE() AND `tafel` = :tafel AND `geleverd` = 1", array('tafel' => $tafel));
    }

    /**
     * @param $date
     * @return mixed
     * Get omzet from date
     */
    public function getOmzetDate($date) {
        return $this->db->single("SELECT SUM(`prijs`) FROM `bestelling` WHERE `datum` = :datum AND `geleverd` = 1", array('datum' => $date));
    }

    /**
     * @return string
     * Creates table with content
     */
    public function getWeekomzet() {
        $return_weekomzet = '';

        // Start date
        $date = date('Y-m-d', strtotime('-7 days'));
        // End date
        $end_date = date("Y-m-d");
        // Total omzet
        $omzet = 0;

        //start creating container + table
        $return_weekomzet .= '
        <div class="container-fluid">
            <div class="bg-light p-2">
                <table class="table bg-light m-0 mb-2">
                    <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Dag</th>
                            <th>Omzet</th>
                        </tr>
                    </thead>
                    <tbody>';

        //loop through dates
        while (strtotime($date) <= strtotime($end_date)) {
            $nameOfDay = date('l', strtotime($date));
            $omzetCurrentDate = $this->getOmzetDate($date);
            $omzet += $omzetCurrentDate;

            $return_weekomzet .= '
                <tr>
                    <td>'.$date.'</td>
                    <td>'.$nameOfDay.'</td>
                    <td>€'.($omzetCurrentDate + 0).',-</td>
                </tr>';
            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
        }

        //create total row + close table and div
        $return_weekomzet .= '
                            <tr>
                                <td><b>Totaal</b></td>
                                <td></td>
                                <td><b>€'.$omzet.',-</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>';

        return $return_weekomzet;
    }

    /**
     * Generates footer on class destroy
     */
    public function __destruct()
    {
        require ROOT . 'includes/footer.php';
    }
}