<?php
session_start();

// include and initize page class
include 'src/page.php';
$page = new page('Bon maken', false, true, true);

//Check if session is set
if (!isset($_SESSION['bestelTafel'])) {
    header('Location: bestellingen.php');
}
?>

<!-- Print stylesheet -->
<link rel="stylesheet" type="text/css" href="css/print.css">

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 bg-light p-2">
        <div class="h4 m-0 mb-2 font-weight-bold">Bon voor tafel <?php echo $_SESSION['bestelTafel']; ?></div>

        <!-- Betaalwijze input -->
        <label for="bonBetaalwijze">Betaalwijze:</label>
        <select class="w-100 p-1 mb-2" id="bonBetaalwijze" name="bonBetaalwijze">
            <option selected disabled>-- Selecteer een betaalwijze --</option>
            ';
            <option value="pin">Pin</option>
            <option value="con">Contant</option>
        </select>

        <!-- Betaald input -->
        <label for="bonBedrag" id="bonBedragLabel" class="d-none">Bedrag:</label>
        <input type="number" class="w-100 p-1 mb-2 d-none" id="bonBedrag" name="bonBedrag" value="" required>

        <div class="printDiv bg-white">
            <div class="h5 m-0 mb-2 font-weight-bold mb-2 p-2" id="printDiv">Restaurant Excellent Taste</div>

            <div class="bonInhoud border p-2 border-dark">

                <table class="table bg-light m-0">
                    <thead>
                    <tr>
                        <th>Aantal</th>
                        <th>Product</th>
                        <th>Prijs</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $totaalPrijs = 0;

                    foreach ($page->getBestellingenFromTable($_SESSION['bestelTafel']) as $bestelling) {

                        $totaalPrijs += $bestelling['prijs'];

                        echo '
                            <tr>
                                <td>' . $bestelling['aantal'] . ' x</td>
                                <td>' . $bestelling['menuitem'] . '</td>
                                <td>' . $bestelling['prijs'] . '</td>
                            </tr>';
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>-------</td>
                    </tr>
                    <tr>
                        <td>Totaal</td>
                        <td></td>
                        <td id="totaalBedrag"><?php echo number_format($totaalPrijs, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Betaald</td>
                        <td></td>
                        <td id="betaaldBedrag">---</td>
                    </tr>
                    <tr>
                        <td>Terug</td>
                        <td></td>
                        <td id="terugBedrag">---</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <button class="mt-2" onclick="printBon()">Bon printen</button>

    </div>
    <div class="col-md-1"></div>
</div>

<!-- script -->
<script type="text/javascript">

  // function to update data in database
  function updateDatabase() {
    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      data: {
        'bonBetaalwijze': bonBetaalwijze
      }
    });
  }

  function printBon() {
    if (bonBetaalwijze === 'pin') {
      updateDatabase();
      window.print();
    } else if (bonBetaalwijze === 'con') {
      if (!isNaN(betaaldBedrag)) {
        updateDatabase();
        window.print();
      } else {
        alert('Je moet eerst het bedrag invoeren dat de klant heeft betaald');
      }
    } else {
      alert('Je moet eerst de betaalwijze invoeren voordat je de bon kan uitprinten');
    }
  }

  var bonBetaalwijze;
  var betaaldBedrag;
  var terugBedrag;
  var totaalbedrag = $('#totaalBedrag').text();

  // On change select betaalwijze
  $('#bonBetaalwijze').on('change', function () {

    bonBetaalwijze = $(this).val();

    switch (bonBetaalwijze) {
      case 'pin':
        // Set values of betaald and terug
        $('#betaaldBedrag').text(totaalbedrag);
        $('#terugBedrag').text('0');

        // remove bedrag input
        $('#bonBedrag').addClass('d-none');
        $('#bonBedragLabel').addClass('d-none');
        break;
      case 'con':
        // Set values of betaald and terug
        $('#betaaldBedrag').text('---');
        $('#terugBedrag').text('---');

        // show bedrag input
        $('#bonBedrag').removeClass('d-none');
        $('#bonBedragLabel').removeClass('d-none');
        break;
      default:
        break;
    }
  });

  // On change bedrag (only when betaalwijze = pin)
  $('#bonBedrag').on('input', function () {
    betaaldBedrag = $(this).val();
    terugBedrag = totaalbedrag - betaaldBedrag;

    // Set values of betaald and terug
    $('#betaaldBedrag').text(betaaldBedrag);
    //Only show if terug if client has payed more than the total price
    if (terugBedrag < 0) {
      $('#terugBedrag').text(Math.abs(terugBedrag).toFixed(2));
    } else {
      $('#terugBedrag').text(0);
    }
  });
</script>
