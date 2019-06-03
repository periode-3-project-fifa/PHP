<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 6/3/2019
 * Time: 10:57 AM
 */

require "header.php";
if($_SESSION['admin'] != 1){
    header("Location: index.php");
}
?>

<form action="loginController.php" method="post" class="genkeyform">
    <input type="hidden" name="type" value="generate_key">
    <label for="key">Key: </label>
    <input name='key' type="text" placeholder="Vul de key in">
    <input type="submit" >
</form>
