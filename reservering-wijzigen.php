<?php
session_start();

// include and initize page class
include 'src/page.php';
$page = new page('Reservering wijzigen', true, true);

if (isset($_POST['reservationTafel']) && isset($_POST['reservationDatum']) && isset($_POST['reservationTijd'])) {
    $reservation = $page->getReservationByKey($_POST['reservationTafel'], $_POST['reservationDatum'], $_POST['reservationTijd']);
} else {
    header('Location: reserveringen.php');
}

?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">

        <div class="bg-light p-2">

            <div class="alert d-none" id="messageBox" role="alert"></div>

            <form id="reserveringToevoegen" method="post" action="">

                <label for="reserveringDate">Datum:</label>
                <input type="date" class="w-100 p-1 mb-2" id="reserveringDate" name="reserveringDate"
                       value="<?php echo $reservation['datum']; ?>" required>

                <label for="reserveringTijd">Tijd:</label>
                <input type="time" class="w-100 p-1 mb-2" id="reserveringTijd" name="reserveringTijd"
                       value="<?php echo $reservation['tijd']; ?>" required>

                <label for="reserveringTafel">Tafelnummer:</label>
                <input type="number" class="w-100 p-1 mb-2" id="reserveringTafel" name="reserveringTafel"
                       value="<?php echo $reservation['tafel']; ?>" required>

                <label for="reserveringAantal">Aantal:</label>
                <input type="number" class="w-100 p-1 mb-2" id="reserveringAantal" name="reserveringAantal"
                       value="<?php echo $reservation['aantal']; ?>" required>

                <label for="reserveringAantal">Allergieën (niet verplict):</label>
                <input type="text" class="w-100 p-1 mb-2" id="reserveringAllergieen" name="reserveringAllergieen"
                       value="<?php echo $reservation['allergieen']; ?>">

                <label for="reserveringTelefoonnummer">Opmerkingen (niet verplict):</label>
                <input type="text" class="w-100 p-1 mb-2" id="reserveringOpmerking" name="reserveringOpmerking"
                       value="<?php echo $reservation['opmerkingen']; ?>">

                <label for="reserveringTelefoonnummer">Aanwezig:</label><br>
                <?php if ($reservation['gebruikt'] === 1) { ?>
                    <input type="radio" name="aanwezig" value="1" checked> De klant is aanwezig<br>
                    <input type="radio" name="aanwezig" value="0" class="mb-4"> De klant is niet aanwezig
                <?php } else { ?>
                    <input type="radio" name="aanwezig" value="1"> De klant is aanwezig<br>
                    <input type="radio" name="aanwezig" value="0" class="mb-4" checked> De klant is niet aanwezig
                <?php } ?>

                <!-- Old PK values -->
                <input type="hidden" id="savedDatum" value="<?php echo $reservation['datum']; ?>" required>
                <input type="hidden" id="savedTijd" value="<?php echo $reservation['tijd']; ?>" required>
                <input type="hidden" id="savedTafel" value="<?php echo $reservation['tafel']; ?>" required>

                <input type="button" class="w-100 p-1 mb-2" id="reserveringWijzigen" name="reserveringWijzigen" value="Wijzigen">

            </form>

        </div>

    </div>
    <div class="col-md-3"></div>
</div>

<!-- Script -->
<script type="text/javascript">
  //Onclick submit button send ajax call
  $('#reserveringWijzigen').on('click', function () {

    //get form values
    let datum = $('#reserveringDate').val();
    let tijd = $('#reserveringTijd').val();
    let tafel = $('#reserveringTafel').val();
    let aantal = $('#reserveringAantal').val();
    let allergieen = $('#reserveringAllergieen').val();
    let opmerkingen = $('#reserveringOpmerking').val();
    let savedDatum = $('#savedDatum').val();
    let savedTijd = $('#savedTijd').val();
    let savedTafel = $('#savedTafel').val();
    let aanwezig = $('input[name=aanwezig]:checked').val();

    //if form values are set
    if (datum.length !== 0 && tijd.length !== 0 && tafel.length !== 0 && aantal.length !== 0 && savedDatum.length !== 0 && savedTijd.length !== 0 && savedTafel.length !== 0) {

      // ajax call
      $.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: {
          'datum': datum,
          'tijd': tijd,
          'tafel': tafel,
          'aantal': aantal,
          'allergieen': allergieen,
          'opmerkingen': opmerkingen,
          'savedDatum': savedDatum,
          'savedTijd': savedTijd,
          'savedTafel': savedTafel,
          'aanwezig': aanwezig,
        },
        success: function (e) {
          $('#messageBox').removeClass('d-none alert-danger').addClass('alert-success').html('Gelukt, het product is succesvol toegevoegd/gewijzigd!')
        },
        error: function (e) {
          $('#messageBox').removeClass('d-none alert-success').addClass('alert-danger').html('Er is iets fout gegaan tijdens het toevoegen/wijzigen van het product!')
        }
      });

      //if form values are not set
    } else {
      $('#messageBox').removeClass('d-none alert-success').addClass('alert-danger').html('Het is verplicht om alle velden in te vullen!')
    }
  })
</script>