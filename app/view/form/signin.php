<form action="signin.php" id="formSignin" method="post">
    <label for="email"><?php __('Email');?></label><br>
    <input type="email" id="email" name="email"><br>
    <label for="password"><?php __('Senha');?></label><br>
    <input type="password" id="password" name="password"><br>
    <button type="submit"><?php __("Entrar");?></button>
    <hr>
    <button onclick="showFormSignup();">
        <?php __("Criar nova conta");?>
    </button>
</form>
<script>
    function showFormSignup() {
        $('#formSignin').hide();
        $('#formSignup').show();
    }

</script>
