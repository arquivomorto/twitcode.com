<html>
    <body>
        <p>
            <b>
                <?php
                __("Confirmação de email");
                ?>
            </b>
        </p>
        <p>
            <?php
            __("Olá");
            print ' <b>';
            $e($name);
            print '</b>';
            ?>
        </p>
        <p>
            <?php
            $href=$siteUrl.'/confirmation.php?id='.$id.'&code='.$code;
            ?>
            <a href="<?php print $href;?>">
                <?php
            __('Clique aqui para confirmar sua conta')
            ?>
            </a>
        </p>
        <p>
            <?php
            __('Atenciosamente');
            ?><br>
            <a href="https://twitcode.com">Twitcode</a>
        </p>
    </body>
</html>
