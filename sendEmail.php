<?php

require __DIR__ . '/vendor/autoload.php';

$bejzerkop = new \Bejzerkop\Bejzerkop();

// TODO ADD MULTIPLE EMAILS

$serverName = 'localhost';
$databaseName = $_POST['sourceDatabase'];
if (isset($_POST['customEmail']) && !empty($_POST['customEmail']) ) {
    $emailAddress = $_POST['customEmail'];
} else {
    $emailAddress = $_POST['destinationEmail'];
}
$sentMail = $bejzerkop->sendDatabaseToEmail($serverName, $databaseName, $emailAddress);

include("views/header.php");

if ($sentMail):?>
Email poslat na <?= $emailAddress ?>
<?php else: ?>
Doshlo je do erora, bre!
<?php endif; ?>
