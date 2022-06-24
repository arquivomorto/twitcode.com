<?php
$data['title']=__('Erro', false);
$view('inc/header', $data);
?>
<div class="container">
    <div class="row">
        <div class="col12">
            <br><br><br>
        </div>
    </div>
    <div class="row">
        <div class="col4"></div>
        <div class="col4">
            <h1><?php __('Erro');?>
            </h1>
            <?php
                print '<ul>';
                foreach ($error as $value) {
                    switch ($value) {
                        case '404':
                            print '<li>'.__('Página não encontrada', false).'</li>';
                        break;                            
                        case 'invalidName':
                            print '<li>'.__('Nome inválido', false).'</li>';
                        break;
                        case 'invalidEmail':
                            print '<li>'.__('Email inválido', false).'</li>';
                        break;
                        case 'invalidPassword':
                            print '<li>'.__('Senha inválida', false).'</li>';
                        break;
                        default:
                            print '<li>'.__('Erro desconhecido', false).'</li>';
                        break;
                    }
                }
                print '</ul>';
            ?>
            <p>
                <a href="javascript:history.back(-1);">
                    <?php __('Voltar');?>
                </a>
            </p>
        </div>
    </div>
</div>
