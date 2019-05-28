<?php

// include and initize page class
include 'src/page.php';
$page = new page('Kok', true, true);

//display delivery content
echo $page->generateDeliveryList('kok');
?>

<!-- script -->
<script src="js/menu.js"></script>