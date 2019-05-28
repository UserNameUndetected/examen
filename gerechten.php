<?php

// include and initize page class
include 'src/page.php';
$page = new page('Gerechten', true, true);

//add product button
echo '<div class="mb-3"><a href="product-beheer.php" class="p-2 bg-light h6">Product toevoegen</a></div>';

//generate menu dranken
echo $page->generateMenu('gerechten');
?>

<!-- script -->
<script src="js/menu.js"></script>