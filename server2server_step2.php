<?php
require __DIR__ . '/vendor/autoload.php';
include("views/header.php");

$bejzerkop = new \Bejzerkop\Bejzerkop();
?>


<h4>Server->Server</h4>
<form method="post" action="server2server_step3.php">
    <input type="hidden" value="<?= $_POST['sourceServer'] ?>" name="sourceServer">
    <input type="hidden" value="<?= $_POST['destinationServer'] ?>" name="destinationServer">

    <div class="row">
        <div class="input-field col s4">
            <?= $_POST['sourceServer'] ?> databases:
            <?php
            foreach ($bejzerkop->databaseList($_POST['sourceServer']) as $database): ?>
                <p>
                    <label>
                        <input name="sourceDatabase" type="radio" value="<?= $database ?>"/>
                        <span><?= $database ?></span>
                    </label>
                </p>
            <?php endforeach; ?>
        </div>
        <div class="col s2">
            <br>
            <div class="chip">-></div>
        </div>
        <div class="input-field col s4">
            <?= $_POST['destinationServer'] ?> databases:
            <?php
            foreach ($bejzerkop->databaseList($_POST['destinationServer']) as $database): ?>
                <p>
                    <label>
                        <input name="destinationDatabase" type="radio" value="<?= $database ?>"/>
                        <span><?= $database ?></span>
                    </label>
                </p>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="row">
        <div class="col s6">
            <input type="text" name="siteurl" placeholder="optional siteurl and home change">
        </div>
        <div class="col s6">
            <button type="button" id="bejzkop" class="waves-effect waves-light btn-large">BEJZKOP!</button>
        </div>
    </div>
    <button id="bejzkopConfirm" class="waves-effect waves-light btn-large red darken-4" style="display: none">
        ARE YOU 100% SURE??? DESTINATION DATABASE WILL BE OVERWRITTEN! IF YOU SCREW UP, YOU WILL ANSWER TO THE HIGHER POWER!!
    </button>


</form>

<script>
    $(document).ready(function () {
        $("#bejzkop").click(function(){
            if ($('input:checked').length != 2 ) {
                alert("SELECT SOURCE AND DESTINATION, GOD DAMN IT! :)")
            } else {
                $('input:not(:checked)').closest('p').hide('fast');
                $(this).hide('fast');
                $("#bejzkopConfirm").show('fast');
            }
        });
    })
</script>


<?php include("views/footer.php"); ?>