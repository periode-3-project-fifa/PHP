<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 6/3/2019
 * Time: 10:57 AM
 */

$pagename = "genkeyspage";
$pagetitle = "Generate a Key";
require "header.php";
if($_SESSION['admin'] != 1){
    header("Location: index.php");
}
?>

<form action="logincontroller.php" method="post" class="genkeyform">
    <input type="hidden" name="type" value="generate_key">
    <label for="key">Key: </label>
    <input name='key' type="text" placeholder="Vul de key in" required minlength="6">
    <input type="submit" >
</form>
