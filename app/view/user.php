<?php
if(!empty($user['username'])){
    $title='@'.$user['username'].' ('.$user['name'].')';
}else{
    $title=$user['name'];
}     

$data['title']=$title;
$view('inc/header', $data);
?>
<script src="js/holder.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col3 profile text-center">
            <div class="text-center">
                <img alt="Avatar" class="avatar" height="260" src="holder.js/260x260" width="260">
            </div>
            <h1 class="name">
                <?php $e($user['name']);?>
                <?php if (!empty($user['username'])) {?>
                <span class="username">@<?php $e($user['username']);?></span>
                <?php }?>
            </h1>
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
        </div>
        <div class="col7">
            123 <?php __('mensagens no último ano');?><br>
            <!-- <img alt="Contribuições" src="holder.js/967x200"> -->

            <!-- https://github.com/bachvtuan/Github-Contribution-Graph -->
            <div class="text-center">
                <div id="github_chart_1"></div>
            </div>
        </div>
        <div class="col2">
            sidebar
        </div>
    </div>
</div>

<style>
    .profile a {
        color: #333333;
        text-decoration: none;
    }

    .profile a:hover {
        color: navy;
        text-decoration: underline;
    }

    .profile .avatar {
        border-radius: 50%;
        box-shadow: 0 0 0 1px gray;
    }

    .profile .username {
        clear: both;
        display: block;
        color: gray;
        font-size: 0.75em;
    }

    @media (prefers-color-scheme: dark) {
        .profile a {
            color: #1d9bf0;
            text-decoration: underline;
        }
    }

</style>

<script>
    //Generate random number between min and max
    function randomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    }

    function getRandomTimeStamps(min, max, fromDate, isObject) {
        var return_list = [];

        var entries = randomInt(min, max);
        for (var i = 0; i < entries; i++) {
            var day = fromDate ? new Date(fromDate.getTime()) : new Date();

            //Genrate random
            var previous_date = randomInt(0, 365);
            if (!fromDate) {
                previous_date = -previous_date;
            }
            day.setDate(day.getDate() + previous_date);

            if (isObject) {
                var count = randomInt(1, 20);
                return_list.push({
                    timestamp: day.getTime(),
                    count: count
                });
            } else {
                return_list.push(day.getTime());
            }


        }

        return return_list;

    }
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
    });

</script>
