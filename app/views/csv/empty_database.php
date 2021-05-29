
<?php $this->layout('layout') ?>
<div class="container">
<?php if (isset($answer)){
    echo $answer;
}else{
    $this->section('content');
}?>
<br>
<br>
<a href="/" class="btn btn-primary">
    General page
</a>
</div>