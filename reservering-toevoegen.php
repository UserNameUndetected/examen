<?php
session_start();

// include and initize page class
include 'src/page.php';
$page = new page('Reservering toevoegen', true, true);

// Check if form is submitted
if (isset($_POST['reserveringSubmit'])) {
    //Get form values
    $klantnaam = $_POST['reserveringNaam'];
    $datum = $_POST['reserveringDate'];
    $tijd = $_POST['reserveringTijd'];
    $tafel = $_POST['reserveringTafel'];
    $aantal = $_POST['reserveringAantal'];
    $telefoon = $_POST['reserveringTelefoonnummer'];
    $allergieen = $_POST['reserveringAllergieen'];
    $opmerkingen = $_POST['reserveringOpmerking'];

    //creates a new client if client does not exist
    if (!$page->checkIfClientExists($klantnaam, $telefoon)) {
        $page->createClient($klantnaam, $telefoon);
    }

    //get client id
    $klantid = $page->getClientID($klantnaam, $telefoon);

    //check if client denied reservation before
    if (!empty($page->clientDeniedReservation($klantid))) {
        $_SESSION['clientReservationDenied'] = 'Deze klant heeft zich eerder gereserveerd maar is toen niet gekomen';
    }

    //create reservation
    if ($page->createReservation($tafel, $datum, $tijd, $klantid, $aantal, $allergieen, $opmerkingen)) {
        $_SESSION['reservationResultsSuccess'] = 'Gelukt, de reservatie voor deze klant is geplaatst';
    } else {
        $_SESSION['reservationResultsDanger'] = 'Mislukt, er is iets fout gegaan tijdens het reserveren van de klant';
    }

    //sends user to reserveringen.php
    header('Location: reserveringen.php');
}
?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">

        <div class="bg-light p-2">

            <form id="reserveringToevoegen" method="post" action="">

                <label for="reserveringNaam">Naam:</label>
                <input type="text" class="w-100 p-1 mb-2" id="reserveringNaam" name="reserveringNaam" value="" required>

                <label for="reserveringDate">Datum:</label>
                <input type="date" class="w-100 p-1 mb-2" id="reserveringDate" name="reserveringDate" value="" required>

                <label for="reserveringTijd">Tijd:</label>
                <input type="time" class="w-100 p-1 mb-2" id="reserveringTijd" name="reserveringTijd" value="" required>

                <label for="reserveringTafel">Tafelnummer:</label>
                <input type="number" class="w-100 p-1 mb-2" id="reserveringTafel" name="reserveringTafel" value="" required>

                <label for="reserveringAantal">Aantal:</label>
                <input type="number" class="w-100 p-1 mb-2" id="reserveringAantal" name="reserveringAantal" value="" required>

                <label for="reserveringTelefoonnummer">Telefoonnummer:</label>
                <input type="tel" class="w-100 p-1 mb-2" id="reserveringTelefoonnummer" name="reserveringTelefoonnummer" value="" required>

                <label for="reserveringAantal">Allergieën (niet verplict):</label>
                <input type="text" class="w-100 p-1 mb-2" id="reserveringAllergieen" name="reserveringAllergieen" value="">

                <label for="reserveringTelefoonnummer">Opmerkingen (niet verplict):</label>
                <input type="text" class="w-100 p-1 mb-2" id="reserveringOpmerking" name="reserveringOpmerking" value="">

                <input type="submit" class="w-100 p-1 mb-2" id="reserveringSubmit" name="reserveringSubmit" value="Reservering aanmaken">

            </form>

        </div>

    </div>
    <div class="col-md-3"></div>
</div>