<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 4/15/2019
 * Time: 10:15 AM
 */

$pagename = 'registerbody';
$pagetitle = 'Register';
require 'header.php';

require 'config.php'
?>
    </head>
<body class="<?=$pagename?>">

<header class = "register-header">
        <div class="container">
            <div class="register-navigation">
                <h1>FIFA Voetbal Toernooi Register</h1>
                <div class="register-controler">
                    <a href="index.php" class="border-login">Home</a>
                    <a href="login.php">Login</a>
                </div>
            </div>
        </div>
</header>
    
<main class = "register">
    <div class="container">
        <div class="background-register">
            <h2>Register FIFA</h2>
            <form action="loginController.php" method="post">
                <input type="hidden" name="type" value="register">
                    <div class="container">
                        <label for="email"><b class="register-email">Email</b></label>
                        <input type="email" placeholder="Enter Email" name="email" id="email" >

                        <label for="psw"><b class="register-password">Password</b></label>
                        <input type="password" placeholder="Enter Password" name="password">

                        <label for="psw"><b class="register-password-reapeat">Voer opnieuw Password in</b></label>
                        <input type="password" placeholder="Enter Password again" name="passwordconfirm" >

                        <button class= "registerbutton" type="submit" value="Create new contact">Register</button>
                    </div>
            </form>
        </div>
    </div>
</main>
<?php require 'footer.php'; ?>