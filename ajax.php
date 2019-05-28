<?php
session_start();

// include and initize page class
include 'src/page.php';
$page = new page('Ajax', false, true);

//Adding/Updating a gerecht
//check if all necessary data is set
if (isset($_POST['naamGerecht']) && isset($_POST['soortGerecht']) && isset($_POST['prijs']) && isset($_POST['type'])) {

    //values
    $gerechtcode = $page->fetchAccessoryGerechtcode($_POST['soortGerecht']);
    $subgerechtcode = $_POST['soortGerecht'];
    $menuitem = $_POST['naamGerecht'];
    $prijs = str_replace(',', '.', $_POST['prijs']);

    //update product
    if ($_POST['type'] === 'update') {
        $menuitemcode = $_POST['menuitemcode'];
        $page->db->query("UPDATE `menuitem` SET `gerechtcode` = :gerechtcode, `subgerechtcode` = :subgerechtcode, `menuitem` = :menuitem, `prijs` = :prijs WHERE `menuitemcode` = :menuitemcode;", array('gerechtcode' => $gerechtcode, 'subgerechtcode' => $subgerechtcode, 'menuitem' => $menuitem, 'prijs' => $prijs, 'menuitemcode' => $menuitemcode));
    //create new product
    } else if ($_POST['type'] === 'create') {
        $page->db->query("INSERT INTO `menuitem` (`gerechtcode`, `subgerechtcode`, `menuitemcode`, `menuitem`, `prijs`) VALUES (:gerechtcode, :subgerechtcode, NULL, :menuitem, :prijs);", array('gerechtcode' => $gerechtcode, 'subgerechtcode' => $subgerechtcode, 'menuitem' => $menuitem, 'prijs' => $prijs));
    }
}

//deleteing a gerecht
//Check if all necessary data is set
if (isset($_POST['deleteMenuitemcode'])) {
    $page->db->query("DELETE FROM `menuitem` WHERE `menuitemcode` = :menuitemcode", array('menuitemcode' => $_POST['deleteMenuitemcode']));
}

//update reservering
if (isset($_POST['datum']) && isset($_POST['tijd']) && isset($_POST['tafel']) && isset($_POST['aantal']) && isset($_POST['allergieen']) && isset($_POST['opmerkingen']) && isset($_POST['savedDatum']) && isset($_POST['savedTijd']) && isset($_POST['savedTafel'])) {
    $page->db->query("UPDATE `reservering` SET `datum` = :datum, `tijd` = :tijd, `tafel` = :tafel, `aantal` = :aantal, `allergieen` = :allergieen, `opmerkingen` = :opmerkingen, `gebruikt` = :gebruikt WHERE `datum` = :datum2 AND `tijd` = :tijd2 AND `tafel` = :tafel2", array('datum'=> $_POST['datum'], 'tijd'=> $_POST['tijd'], 'tafel'=> $_POST['tafel'], 'aantal'=> $_POST['aantal'], 'allergieen'=> $_POST['allergieen'], 'opmerkingen'=> $_POST['opmerkingen'], 'gebruikt' => $_POST['aanwezig'], 'datum2'=> $_POST['savedDatum'], 'tijd2'=> $_POST['savedTijd'], 'tafel2'=> $_POST['savedTafel']));
}

//delete reservering
if (isset($_POST['verwijderDatum']) && isset($_POST['verwijderTijd']) && isset($_POST['verwijderTafel'])) {
    $page->db->query("DELETE FROM `reservering` WHERE `datum` = :datum AND `tijd` = :tijd AND `tafel` = :tafel", array('datum' => $_POST['verwijderDatum'], 'tijd' => $_POST['verwijderTijd'], 'tafel' => $_POST['verwijderTafel']));
}

//Product delivered
if (isset($_POST['bestellingID'])) {
    $page->db->query("UPDATE `bestelling` SET `geleverd` = '1' WHERE `bestelling`.`id` = :id", array('id' => $_POST['bestellingID']));
}

//Data necessary for bestelling and bon
$datum = date("Y-m-d");
$tijd = date("H:i:s", time());

//Add new items to bestellingen
if (isset($_POST['menuitemVal']) && isset($_POST['aantalitems'])) {
    $tafel = $_SESSION['bestelTafel'];
    $menuitemcode = $_POST['menuitemVal'];
    $aantal = $_POST['aantalitems'];
    $prijs = $page->getItemPrice($menuitemcode, $aantal);

    $page->db->query("INSERT INTO `bestelling`(`id`, `tafel`, `datum`, `tijd`, `menuitemcode`, `aantal`, `prijs`, `geleverd`) VALUES (NULL, :tafel, :datum, :tijd, :menuitemcode, :aantal, :prijs, 0)", array('tafel' => $tafel, 'datum' => $datum, 'tijd' => $tijd, 'menuitemcode' => $menuitemcode, 'aantal' => $aantal, 'prijs' => $prijs));
}

//Add new row to bon
if (isset($_POST['bonBetaalwijze'])) {
    $tafel = $_SESSION['bestelTafel'];

    //Check if table has already paid, if not pay
    $checkIfAlreadyBetaald = $page->db->query("SELECT * FROM `bon` WHERE `tafel` = :tafel AND `datum` = :datum;", array('tafel' => $tafel, 'datum' => $datum));
    if (empty($checkIfAlreadyBetaald)) {
        $page->db->query("INSERT INTO `bon` (`id`, `tafel`, `datum`, `tijd`, `betalingswijze`) VALUES (NULL, :tafel, :datum, :tijd, :betalingswijze);", array('tafel' => $tafel, 'datum' => $datum, 'tijd' => $tijd, 'betalingswijze' => $_POST['bonBetaalwijze']));
    }
}