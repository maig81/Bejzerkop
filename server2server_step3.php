<?php
require __DIR__ . '/vendor/autoload.php';

$bejzerkop = new \Bejzerkop\Bejzerkop();
$siteUrl = isset($_POST['siteurl']) ? $_POST['siteurl'] : "";
$bejzerkop->databaseCopy($_POST['sourceServer'], $_POST['sourceDatabase'], $_POST['destinationServer'], $_POST['destinationDatabase'], $siteUrl);

header("Location: index.php?copy=ok", true, 301);
exit();

?>
