<?php

// include and initize page class
include 'src/page.php';
$page = new page('Ober', true, true);

//display delivery content
echo $page->generateDeliveryList('ober');
?>

<!-- script -->
<script src="js/menu.js"></script>