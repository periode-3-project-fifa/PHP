<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 4/15/2019
 * Time: 10:15 AM
 */

$pagename = 'register';
$pagetitle = 'Register';
require 'header.php';

require 'config.php'
?>

<header class = "register-header">
        <div class="container">
            <div class="register-navigation">
                <h1>FIFA Voetbal Toernooi Register</h1>
                <div class="register-controler">
                    <a href="index.php">Home</a>
                </div>
            </div>
        </div>
</header>
    
<main class = "register">
    <div class="container">
        <h2>Register FIFA</h2>
        <form action="loginController.php" method="post">
            <input type="hidden" name="type" value="register">

            <div class="container">
                <label for="email"><b>Email</b></label>
                <input type="email" placeholder="Enter Email" name="email" id="email" >

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password">

                <label for="psw"><b>Voer opnieuw Password in</b></label>
                <input type="password" placeholder="Enter Password again" name="passwordconfirm" >

                <button class= "registerbutton" type="submit" value="Create new contact">Register</button>
            </div>

        </form>
    </div>
</main>


<?php require 'footer.php';
?>