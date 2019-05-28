<?php
session_start();

// include and initize page class
include 'src/page.php';
$page = new page('Bestellingen beheren', false, true, true);

//bind tafel id to session. Return to bestellingen is session is not set.
if (isset($_POST['tableSelectedID'])) {
    $_SESSION['bestelTafel'] = $_POST['tableSelectedID'];
} else if (!isset($_SESSION['bestelTafel'])) {
    header('Location: bestellingen.php');
}
?>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 bg-light p-2">
        <div class="h4 m-0 mb-5 font-weight-bold mb-2">Tafel <?php echo $_SESSION['bestelTafel']; ?></div>

        <?php
        foreach ($page->fetchGerechten() as $gerecht) {
            echo '<button class="w-100 p-1 mb-5 selectGerecht" value="' . $gerecht[0] . '">' . $gerecht[1] . '</button>';
        }
        ?>

    </div>
    <div class="col-md-1"></div>
</div>

<!-- script -->
<script type="text/javascript">
  //Bind new gerecht to selectedGerecht
  $('.selectGerecht').on('click', function () {
    window.location = 'bestelling-toevoegen.php?gerecht=' + $(this).val();
  })
</script>