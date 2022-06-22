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
        <div class="col5 text-center-mobile">
            <h1>Twitcode</h1>
            <p>Compartilhe códigos com o mundo</p>
        </div>
        <div class="col3 text-center">
            <form action="signin.php" method="post">
                <label for="email"><?php __('Email');?></label><br>
                <input type="email" id="email" name="email"><br>
                <label for="password"><?php __('Senha');?></label><br>
                <input type="password" id="password" name="password"><br>
                <button type="submit"><?php __("Entrar");?></button>
            </form>
            <hr>
            <button onclick="document.location='signup.php';">
                <?php __("Criar nova conta");?>
            </button>
        </div>
    </div>
</div>
