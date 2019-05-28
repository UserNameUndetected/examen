<?php

// include and initize page class
include 'src/page.php';
$page = new page('Bestellingen', true, true);
?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">

        <div class="bg-light p-2">

            <form id="reserveringToevoegen" method="post" action="bestelling-beheren.php">

                <label for="tafelSelect">Selecteer tafel:</label>
                <?php echo $page->createReservationTableDropwdown(); ?>

                <input type="input" name="tableSelectedID" id="tableSelectedID" class="d-none">
                <input type="submit" name="tableSelectSubmit" id="tableSelectSubmit" class="d-none">

            </form>

        </div>

    </div>
    <div class="col-md-3"></div>
</div>

<!-- script -->
<script type="text/javascript">

  //On change tafel, submit form
  $('#tafelSelect').on('change', function () {
    //Set value of id
    $('#tableSelectedID').val($('.tafelSelect').val());

    //submit form
    $('#tableSelectSubmit').click();
  })
</script>
