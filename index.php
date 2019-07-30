<?php

use Bejzerkop\Bejzerkop;

require __DIR__ . '/vendor/autoload.php';
include("views/header.php");

$bejzerkop = new Bejzerkop();
?>

<div class="container">

    <?php if (isset($_GET['copy'])) {
        echo "<h3 class='center green-text darken-3'>Iskopirano</h3>";
    }
    ?>

    <div class="row">
        <div class="col m6 s12">
            <h4 class="center">Server->Server</h4>
            <form method="post" action="server2server_step2.php">
                <div class="row">
                    <div class="input-field col s6">
                        <select name="sourceServer">
                            <?php
                            foreach ($bejzerkop->serverList as $key => $server) {
                                ?>
                                <option value="<?= $key ?>"><?= $key ?></option>
                                <?php
                            } ?>
                        </select>
                        <label>Source server</label>
                    </div>

                    <div class="input-field col s6">
                        <select name="destinationServer">
                            <?php
                            end($bejzerkop->serverList);
                            $endKey = key($bejzerkop->serverList);
                            foreach ($bejzerkop->serverList as $key => $server) {
                                $selected = ($endKey == $key) ? "selected" : ""; ?>
                                <option value="<?= $key ?>" <?= $selected ?> ><?= $key ?></option>
                                <?php
                            } ?>
                        </select>
                        <label>Destination server</label>
                    </div>
                </div>
                <div class="row center">
                    <button class="waves-effect waves-light btn-large">MOVING ON...</button>
                </div>
            </form>
        </div>

        <div class="col m6 s12">
            <h4 class="center">Localhost->email</h4>
            <form action="sendEmail.php" method="POST">
                <div class="row">
                    <!-- LOCALHOST DATABASE LIST -->
                    <div class="col s4">
                        <?php foreach ($bejzerkop->databaseList('localhost') as $database): ?>
                            <p>
                                <label>
                                    <input name="sourceDatabase" type="radio" value="<?= $database ?>" required/>
                                    <span><?= $database ?></span>
                                </label>
                            </p>
                        <?php endforeach; ?>
                    </div>

                    <div class="col s2"></div>

                    <!-- USER LIST -->
                    <div class="col s4">
                        <?php foreach ($bejzerkop->emailList as $userName => $userEmail): ?>
                            <p>
                                <label>
                                    <input name="destinationEmail" type="radio" value="<?= $userEmail ?>"/>
                                    <span><?= $userName ?></span>
                                </label>
                            </p>
                        <?php endforeach; ?>
                        <input type="text" placeholder="Custom email" name="customEmail">
                        <button class="waves-effect waves-light btn-large">SEND TO EMAIL</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('select').formSelect();
    });
</script>

<?php include("views/footer.php"); ?>
