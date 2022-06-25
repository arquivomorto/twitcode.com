<form action="signup.php" class="hide" id="formSignup" method="post">
    <h2><?php __("Criar conta");?>
    </h2>
    <label for="name"><?php __('Nome');?></label><br>
    <input type="text" id="name" maxlength="32" minlegth="2" name="name"><br>
    <label for="email"><?php __('Email');?></label><br>
    <input type="email" id="email" maxlength="64" minlegth="6" name="email"><br>
    <label for="password"><?php __('Senha');?></label><br>
    <input type="password" id="password" maxlength="8" minlegth="256" name="password"><br>
    <button type="submit"><?php __("Criar conta");?></button>
    <p>
        <a href="javascript:showFormSignin();"><?php __("Entrar");?></a>
    </p>
</form>
<script>
    function showFormSignin() {
        $('#formSignup').hide();
        $('#formSignin').show();
    }

</script>
