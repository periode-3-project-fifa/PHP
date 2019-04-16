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
?>
    <META HTTP-EQUIV="refresh" CONTENT="15">
    </head>
<body class="<?=$pagename?>">
<div class="container">
    <div class="navigation">
        <div class="head">
            <i class="far fa-futbol"></i>
            <h1>VoetbalPoules</h1>
            <i class="far fa-futbol"></i>
        </div>
        <div class="login_register">
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
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
                    <div class="pouleteam">
                        <h4>T1</h4>
                    </div>
                    <div class="pouleteam">
                        <h4>T2</h4>
                    </div>
                    <div class="pouleteam">
                        <h4>T3</h4>
                    </div>
                    <div class="pouleteam">
                        <h4>T4</h4>
                    </div>
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
                <h3>Kwartfinales</h3>
            </div>
            <div class="boxx kwartfinale">

            </div>
        </div>
        <div class="halffinals">
            <div class="heading">
                <h3>Halvefinales</h3>
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