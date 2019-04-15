<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 4/15/2019
 * Time: 10:15 AM
 */

$pagename = 'register';
$pagetitle = 'Register';
require 'header.php';?>
<?php require 'footer.php'; ?>
    
<main class = "register">
    <div class="container">
        <h2>Register FIFA</h2>
        <form action="" method="post">
            <input type="hidden" name="type" value="register">

            <div class="container">
                <label for="uname"><b>Email</b></label>
                <input type="email" placeholder="Enter Email" name="email" id="email" >

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password">

                <label for="psw"><b>Voer opnieuw Password in</b></label>
                <input type="password" placeholder="Enter Password again" name="password1" >

                <button class= "registerbutton" type="submit" value="Create new contact">Register</button>

                <button class="back" type ="back"><a href="index.php">Back to home page</a></button>
            </div>

        </form>
    </div>
</main>

</body>
</html>