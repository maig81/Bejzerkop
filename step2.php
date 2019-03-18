<form method="post" action="index.php">
    <input type="hidden" value="3" name="step">
    <input type="hidden" value="<?= $_POST['sourceServer'] ?>" name="sourceServer">
    <input type="hidden" value="<?= $_POST['destinationServer'] ?>" name="destinationServer">

    <div class="row">
        <div class="input-field col s4">
            <?= $_POST['sourceServer'] ?> baze:
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
            <?= $_POST['destinationServer'] ?> baze:
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
    <button id="bejzkopConfirm" class="waves-effect waves-light btn-large red darken-4" style="display: none">DA LI SI 100% SIGURAN? DESTINACIJA ĆE BITI PREGAŽENA, A AKO ZASEREŠ ODGOVARAĆEŠ VIŠOJ INSTANCI!!!</button>


</form>

<script>
    $(document).ready(function () {
        $("#bejzkop").click(function(){
            if ($('input:checked').length !=2 ) {
                alert("MORAŠ IZABRATI OBE BAZE, SUNCE TI POLJUBIM!")
            } else {
                $('input:not(:checked)').closest('p').hide('fast');
                $(this).hide('fast');
                $("#bejzkopConfirm").show('fast');
            }
        });
    })
</script>