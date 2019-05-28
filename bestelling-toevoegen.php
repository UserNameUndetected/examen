<?php
session_start();

// include and initize page class
include 'src/page.php';
$page = new page('Bestellingen beheren', false, true, true);
?>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 bg-light p-2">
        <div class="h4 m-0 mb-5 font-weight-bold mb-2">Tafel <?php echo $_SESSION['bestelTafel']; ?></div>

        <?php

        //fetch for subgerechten within gerecht
        foreach ($page->fetchAccessorySubgerechten($_GET['gerecht']) as $subgerecht) {
            echo '<div class="h5 m-0 mb-5 font-weight-bold mb-2">' . $subgerecht['subgerecht'] . '<div>';

            //fetch for menuitems within subgerechten
            foreach ($page->fetchAccessoryMenuitems($subgerecht['subgerechtcode']) as $menuitem) {
                echo '<button class="w-100 p-1 mb-2 selectMenuitem" value="' . $menuitem['menuitemcode'] . '">' . $menuitem['menuitem'] . '</button>';
            }
        }
        ?>

    </div>
    <div class="col-md-1"></div>
</div>

<!-- script -->
<script type="text/javascript">

  $('.selectMenuitem').on('click', function () {

    //base variables of selected item
    var menuitemVal = $(this).val();
    var menuitemText = $(this).text();

    //ask amount of items (until gives good answer)
    do {
      var aantalitems = parseInt(window.prompt("Hoe veel " + menuitemText + " wilt u bestellen?", "1"), 10);
    } while (isNaN(aantalitems) || aantalitems > 100 || aantalitems < 1);

    if (confirm("Je staat op het punt om " + aantalitems + "x " + menuitemText + " te bestellen, weet je dit zeker?")) {
      $.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: {
          'menuitemVal': menuitemVal,
          'aantalitems': aantalitems,
        },
        success: function (e) {
          console.log(e);
          alert('Gelukt, de bestelling is toegevoegd!');
        },
        error: function (e) {
          alert('Er is iets fout gegaan tijdens het verwijderen van de levering')
        }
      });
    }
  });
</script>