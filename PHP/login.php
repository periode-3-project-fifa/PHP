<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 4/15/2019
 * Time: 10:15 AM
 */

$pagename = 'login';
$pagetitle = 'login';
require 'header.php';?>
    </head>
<body class="<?=$pagename?>">
<main class = "login">  
    <div class="container">
        <h2>Login FIFA</h2>

        <form action="loginController.php"  method="post">
            <input type="hidden" name="type" value="login">
                <div class="container">
                    <label for="email"><b>Email</b></label>
                    <input type="email" placeholder="Enter Email" name="email" required>

                    <label for="psw"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="password" required>

                    <button type="submit"><a href="index.php">Login</a></button>
                
                    <button type="button" class="cancelbtn" onclick="window.location.href='register.php'">register</button>
                </div>    
        </form>
                
    </div>
</main>


<?php require 'footer.php'; ?>