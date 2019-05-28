<?php

// include and initize page class
include 'src/page.php';
$page = new page('Weekomzet', true, true);

echo $page->getWeekomzet();
?>