<?php
session_start();

// include and initize page class
include 'src/page.php';
$page = new page('Reserveringen alle', true, true);
?>

<!-- Button add reservation and todays reservations -->
<div class="mb-3">
    <a href="reservering-toevoegen.php" class="bg-light p-2 h6">Reservering toevoegen</a>
    <a href="reserveringen.php" class="bg-light p-2 h6">Reserveringen vandaag</a>
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

    <h4>Reserveringen alle</h4>
    <?php echo $page->getReservations(false); ?>
</div>

<!-- script -->
<script src="js/menu.js"></script>
