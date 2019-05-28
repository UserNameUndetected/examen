<?php

// include and initize page class
include 'src/page.php';
$page = new page('Product wijzigen', true, true);

if (isset($_POST['submitProductBeheer'])) {
    print_r($_POST);
}

//base values
$menuitemName = '';
$gerechtcode = '';
$prijs = '';
$type = 'create';
$menuitemcode = NULL;
$subgerechtcode = NULL;

// generate form
$generateForm = '';

// user wants to update a menuitem
if (isset($_POST['menuItemCode']) && isset($_POST['menuItemWijzigen'])) {
    $generateForm .= '<div class="bg-light p-2 h4 m-0 font-weight-bold">Wijzigen product</div>';
    $menuitem = $page->fetchMenuitem($_POST['menuItemCode']);

    // bind data to variables
    $menuitemName = $menuitem['menuitem'];
    $gerechtcode = $menuitem['gerechtcode'];
    $subgerechtcode = $menuitem['subgerechtcode'];
    $prijs = $menuitem['prijs'];
    $type = 'update';
    $menuitemcode = $_POST['menuItemCode'];

// user wants to create a menuitem
} else {
    $generateForm .= '<div class="bg-light p-2 h4 m-0 font-weight-bold">Toevoegen product</div>';
}

$generateForm .= '
    <div class="bg-light p-2">
        <fieldset class="border p-4">
        <legend  class="w-auto h4">Gegevens product</legend>
            <form id="productBeheerFom">
                <div class="form-group row">
                    <label for="naamGerecht" class="col-sm-4 col-form-label">Naam gerecht:</label>
                    <div class="col-sm-8">
                        <input type="text" class="w-100 p-1" id="naamGerecht" value="' . $menuitemName . '" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="soortGerecht" class="col-sm-4 col-form-label">Soort gerecht:</label>
                    <div class="col-sm-8">
                        ' . generateDropdown($page->fetchSubgerechten(), 'soortGerecht', 'soortGerecht', $subgerechtcode) . '
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="prijs" class="col-sm-4 col-form-label">Prijs:</label>
                    <div class="col-sm-8">
                        <input type="text" class="w-100 p-1" id="prijs" value="' . $prijs . '" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-5">
                        <input type="hidden" name="type" id="type" value="' . $type . '">
                        <input type="hidden" name="menuitemcode" id="menuitemcode" value="' . $menuitemcode . '">
                        <input type="button" class="w-100 p-1" name="submitProductBeheer" id="submitButton" value="Ok">
                    </div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-5">
                        <input type="button" class="w-100 p-1" id="annuleren" value="Annuleren">
                    </div>
                </div>
            </form>
        </fieldset>
        
        <div class="alert d-none" id="messageBox" role="alert">
        </div>
    </div>';
?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <!-- display form -->
        <?php echo $generateForm; ?>
    </div>
    <div class="col-md-3"></div>
</div>


<script type="text/javascript">

  //Onclick annuleren return user to previous page
  $('#annuleren').on('click', function () {
    history.back();
  });

  //Onclick submit button send ajax call
  $('#submitButton').on('click', function () {

    //get form values
    let naamGerecht = $('#naamGerecht').val();
    let soortGerecht = $('#soortGerecht').val();
    let prijs = $('#prijs').val();
    let type = $('#type').val();
    let menuitemcode = $('#menuitemcode').val();


    //if form values are set
    if (naamGerecht.length !== 0 && soortGerecht.length !== 0 && prijs.length !== 0) {

      // ajax call
      $.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: {
          'naamGerecht': naamGerecht,
          'soortGerecht': soortGerecht,
          'prijs': prijs,
          'type': type,
          'menuitemcode': menuitemcode,
        },
        success: function () {
          $('#messageBox').removeClass('d-none alert-danger').addClass('alert-success').html('Gelukt, het product is succesvol toegevoegd/gewijzigd!')
        },
        error: function () {
          $('#messageBox').removeClass('d-none alert-success').addClass('alert-danger').html('Er is iets fout gegaan tijdens het toevoegen/wijzigen van het product!')
        }
      });

      //if form values are not set
    } else {
      $('#messageBox').removeClass('d-none alert-success').addClass('alert-danger').html('Het is verplicht om alle velden in te vullen!')
    }
  })
</script>
