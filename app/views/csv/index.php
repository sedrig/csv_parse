<?php $this->layout('layout') ?>
<div class="container">
    <?php
    if (isset($answer)){
        echo $answer;
    }
    ?>
    <form  method="post" enctype="multipart/form-data">
            <br><br>
            <input type="file" id="file" accept=".csv" name="csv">
            <br><br>
            <button class="btn btn-success" type="submit" formaction="/csv/store">Import</button>
    </form>
    <br><br>
    <a href="/csv/delete" class="btn btn-warning">
        Clear all records
    </a>
    <br><br>
    <a href="/csv/table" class="btn btn-primary">
        View results
    </a>

</div>

