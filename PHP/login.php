<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 4/15/2019
 * Time: 10:15 AM
 */

$pagename = 'login';
$pagetitle = 'login';


require 'header.php';
if( isset($_GET['msg'])){
    echo $_GET['msg'];
}
?>
    </head>
<body class="<?=$pagename?>">

<header class = "register-header">
        <div class="container">
            <div class="register-navigation">
                <h1>FIFA Voetbal Toernooi Login</h1>
                <div class="register-controler">
                    <a href="index.php" class="border-login">Home</a>
                    <a href="register.php">Register</a>
                </div>
            </div>
        </div>
</header>

<main class = "login">  
    <div class="container">
        <div class="">
            <h2>Login FIFA</h2>
            <form action="logincontroller.php"  method="post">
                <input type="hidden" name="type" value="login">
                <div class="imgcontainer">
                    <img src="../img/banner.jpg" alt="Avatar" class="avatar">
                </div>
                <div class="container-2">
                    <label for="email"><b class="login-email">Email</b></label>
                    <input class="login_field" type="email" placeholder="Enter Email" name="email" required>
                    <label for="psw"><b class="login-password">Password</b></label>
                    <input class="login_field" type="password" placeholder="Enter Password" name="password" required>
                    <input type="submit" value="Login" class="login-a">
                
                </div>
            </form>   
        </div>
    </div>
</main>


<?php require 'footer.php'; ?>