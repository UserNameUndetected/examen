<?php
session_start();

// include and initize page class
include 'src/page.php';
$page = new page('Reserveringen vandaag', true, true);
?>

<!-- Button add reservering -->
<div class="mb-3">
    <a href="reservering-toevoegen.php" class="bg-light p-2 h6">Reservering toevoegen</a>
    <a href="reservering-alle.php" class="bg-light p-2 h6">Alle reserveringen</a>
    <a href="bestellingen.php" class="bg-light p-2 h6">Bestelling invoeren</a>
</div>

<div class="bg-light p-2">

    <div class="alert alert-success messageBox d-none" role="alert">
        <?php echo $page->sessionsMessages('reservationResultsSuccess'); ?>
    </div>

    <div class="alert alert-danger messageBox d-none" role="alert">
        <?php echo $page->sessionsMessages('clientReservationDenied'); ?>
        <?php echo $page->sessionsMessages('reservationResultsDanger'); ?>
    </div>

    <h4>Reserveringen vandaag</h4>

    <?php echo $page->getReservations(true); ?>
</div>

<!-- script -->
<script src="js/menu.js"></script>

