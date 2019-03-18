<form method="post" action="index.php">
    <input type="hidden" value="2" name="step">
    <div class="row">
        <div class="input-field col s4">
            <select name="sourceServer">
                <?php
                foreach ($bejzerkop->serverList as $key => $server) { ?>
                    <option value="<?= $key ?>"><?= $key ?></option>
                <?php } ?>
            </select>
            <label>Source server</label>
        </div>
        <div class="col s2"></div>

        <div class="input-field col s4">
            <select name="destinationServer">
                <?php
                end($bejzerkop->serverList);
                $endKey = key($bejzerkop->serverList);
                foreach ($bejzerkop->serverList as $key => $server) {
                    $selected = ($endKey == $key) ? "selected" : ""; ?>
                    <option value="<?= $key ?>" <?= $selected ?> ><?= $key ?></option>
                <?php } ?>
            </select>
            <label>Destination server</label>
        </div>
    </div>
    <div class="row text-center">
        <button class="waves-effect waves-light btn-large">MOVING ON...</button>
    </div>

</form>
<script>
    $(document).ready(function () {
        $('select').formSelect();
    });
</script>