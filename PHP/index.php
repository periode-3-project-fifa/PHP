<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 4/15/2019
 * Time: 10:15 AM
 */

$pagetitle = 'Home';
$pagename = 'index';
require 'header.php';
$sql = "SELECT * FROM teams";
$query =$db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);
?>

    <META HTTP-EQUIV="refresh" CONTENT="15">
    </head>
<body class="<?=$pagename?>">
<div class="container">
    <div class="navigation">
        <div class="head">
            <i class="far fa-futbol"></i>
            <h1>Voetbal Poules</h1>
            <i class="far fa-futbol"></i>
        </div>
        <div class="login_register">
            <?php
            if ( isset($_SESSION['id']) ) {
                echo "<a href='teamplayer.php'>Team aanmaken</a>";
                echo "<a href='logout.php'>logout</a>";
            } else {
                echo "<a href='login.php'>Login</a> &nbsp;  &nbsp; <a href='register.php'> Register </a>";
            }
            ?>
        </div>
    </div>
</div>
    <div class="main_top">
        <div class="uitslagen">
            <div class="heading">
            <h3>Uitslagen</h3>
            </div>
            <div class="box uitslag">

            </div>
        </div>
        <div class="teams">
            <div class="heading">
                <h3>Teams</h3>
            </div>
            <div class="box teams">
                <select size="<?=count($teams)?>" name="" id="">
                    <?php
                    foreach ($teams as $team) {
                        $name = htmlentities($team['name']);

                        echo "<option> {$team['name']}</option>";
                    }
                    ?>
                </select>

            </div>
        </div>
        <div class="spelers">
            <div class="heading">
                <h3>Spelers</h3>
            </div>
            <div class="box spelers">

            </div>
        </div>
    </div>
    <div class="main_bottom">
        <div class="poules">
            <div class="heading">
                <h3>Poules</h3>
            </div>
            <div class="boxx de_poules">
                <div class="poule_A">
                    <h3>Poule A</h3>
                    <?php
                    echo '<ol>';
                    foreach ($teams as $team) {
                        $name = htmlentities($team['name']);

                        echo "<li><a href='detail.php?id={$team['id']}'> {$team['name']}</a></li>";
                    }
                    echo '</ol>'
                    ?>
                </div>
                <div class="poule_B">
                    <h3>Poule B</h3>
                    <div class="pouleteam">
                        <h4>T5</h4>
                    </div>
                    <div class="pouleteam">
                        <h4>T6</h4>
                    </div>
                    <div class="pouleteam">
                        <h4>T7</h4>
                    </div>
                    <div class="pouleteam">
                        <h4>T8</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="quaterfinals">
            <div class="heading">
                <h3>Kwart Finales</h3>
            </div>
            <div class="boxx kwartfinale">

            </div>
        </div>
        <div class="halffinals">
            <div class="heading">
                <h3>Halve Finales</h3>
            </div>
            <div class="boxx halvefinale">

            </div>
        </div>
        <div class="finals">
            <div class="heading">
                <h3>Finale</h3>
            </div>
            <div class="boxx finale">

            </div>
        </div>
    </div>
<?php require 'footer.php'; ?>
