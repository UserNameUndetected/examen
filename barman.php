<?php

// include and initize page class
include 'src/page.php';
$page = new page('Barman', true, true);

//display delivery content
echo $page->generateDeliveryList('barman');
?>

<!-- script -->
<script src="js/menu.js"></script>