<?php

$view('inc/header', $data);
?>
<div class="container">
    <div class="row">
        <div class="col12">
            <br><br><br>
        </div>
    </div>
    <div class="row">
        <div class="col2"></div>
        <div class="col4 text-center-mobile">
            <h1>Twitcode</h1>
            <p>Microblog para devs</p>
        </div>
        <div class="col4 text-center">
            <?php $view("form/signin");?>
            <?php $view("form/signup");?>            
        </div>
    </div>
</div>
