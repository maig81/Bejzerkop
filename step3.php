<?php

$bejzerkop = new Bejzerkop();
$siteUrl = isset($_POST['siteurl']) ? $_POST['siteurl'] : "";
$bejzerkop->databaseCopy($_POST['sourceServer'], $_POST['sourceDatabase'], $_POST['destinationServer'], $_POST['destinationDatabase'], $siteUrl);

?>

<script>
    window.location.href = "done.php";
</script>