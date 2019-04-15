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
<div class="container">
    <div class="navigation">
        <h1>VoetbalPoules</h1>
        <div class="login_register">
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>
    </div>
</div>
    <div class="main_top">
        <div class="uitslagen">
            <h3>Uitslagen</h3>
            <div class="uitslag">

            </div>
        </div>
        <div class="teams">
            <h3>Teams</h3>
        </div>
        <div class="spelers">
            <h3>Spelers</h3>
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