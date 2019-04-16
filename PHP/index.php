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
require 'config.php'
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

        </div>
        <div class="quaterfinals">

        </div>
        <div class="halffinals">

        </div>
        <div class="finals">

        </div>
    </div>
<?php require 'footer.php'; ?>