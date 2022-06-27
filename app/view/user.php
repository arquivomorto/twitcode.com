<?php
if (is_null($user['username'])) {
    $user['username']=(string) $user['id'];
}
if (!empty($user['username'])) {
    $title='@'.$user['username'].' ('.$user['name'].')';
} else {
    $title=$user['name'];
}

$data['title']=$title;
$view('inc/header', $data);
?>
<script src="js/holder.min.js"></script>

<?php $view("dialog/dialogMessage");?>

<div class="container">

    <div class="menu-left text-center">
        <h1 class="desktop">TwitCode</h1>
        <h1 class="mobile">TC</h1>
        <a href="javascript:messageOpenDialog();"
            title="<?php __('Escrever');?>">
            <i class="fa fa-pencil" aria-hidden="true"></i>
            <span class="desktop"><?php __('Escrever');?></span>
        </a>
        <?php if ($isAuth) {?>
        <?php
                $url=$siteUrl.'/logout.php?tokenExpiration='.$isAuth['token_expiration'];
                ?>
        <a href="<?php print $url;?>"
            title="<?php __('Sair');?>">
            <i class="fa fa-times" aria-hidden="true"></i>
            <span class="desktop"><?php __('Sair');?></span>
        </a>
        <?php }
            ?>
    </div>


    <div class="row off-menu-left">
        <?php $view("menu/menuUser", ['user'=>$user]);?>
    </div>
    <div class="col9">
        <div class="desktop">
            123 <?php __('mensagens no último ano');?><br>
            <!-- <img alt="Contribuições" src="holder.js/967x200"> -->

            <!-- https://github.com/bachvtuan/Github-Contribution-Graph -->
            <div class="text-center">
                <div id="github_chart_1"></div>
            </div>
            <output></output>
        </div>
    </div>
</div>
</div>


<script>
    $(function() {
        $('#github_chart_1').github_graph({
            //Generate random entries from 50-> 200 entries
            data: getRandomTimeStamps(50, 500, null, false),
            texts: ['mensagem', 'mensagens'],
            colors: ['#eeeeee', '#d6e685', '#8cc665', '#44a340', '#44a340'],
            // callback when click on selected date
            click: function(date, count) {
                alert(count + ' mensagens em ' + date);
            }
        });

        // enviar mensagem
        $('#message').keydown(function(e) {
            if (e.keyCode == 13) {
                $("#frmMessage").submit();
            }
        });

        $("#frmMessage").submit(function(e) {
            e.preventDefault();
            messageSend();
            return false;
        });
    });

</script>
