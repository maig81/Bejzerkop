<?php
require_once "inc/Bejzerkop.php";

$bejzerkop = new Bejzerkop();
?>
<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>BEJZERKOP</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="SitePoint">

    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
    <script
        src="http://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

</head>

<body>
    <div class="container">
        <h1>BEJZERKOP</h1>
            <?php
                if (isset($_POST['step'])) {
                    include "step" . $_POST['step'] . ".php";
                } else {
                    include "step1.php";
                }
            ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>


