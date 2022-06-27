<div class="col3 off-menu-esquerdo profile text-center">
    <div class="text-center">
        <img alt="Avatar" height="260" src="holder.js/260x260" width="260">
    </div>
    <h2 class="name">
        <?php $e($user['name']);?>
        <?php if (!empty($user['username'])) {?>
        <span class="username">@<?php $e($user['username']);?></span>
        <?php }?>
    </h2>
    <?php if (!empty($user['bio'])) {?>
    <p><?php $e($user['bio']);?>
    </p>
    <?php }?>
    <!-- <p>
                <i aria-hidden="true" class="fa fa-users"></i>
                <b>123</b> seguidores &bull;
                <b>123</b> seguindo
            </p> -->
    <p>
        <!-- site -->
        <?php if (!empty($user['site'])) {?>
        <i aria-hidden="true" class="fa fa-link"></i>
        <a href="https://hackergaucho.com/" rel="nofollow me">
            https://hackergaucho.com/
        </a><br>
        <?php }?>

        <!-- github -->
        <?php if (!empty($user['github'])) {?>
        <i aria-hidden="true" class="fa fa-github"></i>
        <a href="https://github.com/hackergaucho" rel="nofollow me" title="Github">
            @andercoutos
        </a><br>
        <?php }?>

        <!-- twitter -->
        <?php if (!empty($user['twitter'])) {?>
        <i aria-hidden="true" class="fa fa-twitter"></i>
        <a href="https://twitter.com/hackergaucho" rel="nofollow me" title="Twitter">
            @hackergaucho
        </a><br>
        <?php }?>
    </p>
