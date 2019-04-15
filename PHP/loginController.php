<?php
/**
 * Created by PhpStorm.
 * User: Bas
 * Date: 15-4-2019
 * Time: 11:04
 */

if ( $_SERVER['REQUEST_METHOD'] != 'POST'){
    header('location: index.php');
    exit;
}


require 'config.php';

if ( $_POST['type'] == 'register' ) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordconfirm = $_POST['passwordconfirm'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "This is no valid email";
        header("location: register.php?msg=$message");
        exit;
    }

    if ($_POST['password'] != $_POST['password_confirm']) {

        $message = "Wachtwoord komt niet overeen!";
        echo "<script type='text/javascript'>alert('$message');</script>";

    }

    if ($_POST['password'] == $_POST['passwordconfirm']) {

        $sql = "INSERT INTO register (email, password) VALUES (:email, :password)";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            ':email' => $email,
            ':password' => $password
        ]);

        $msg = "Account is succesvol aangemaakt!";
        header("location: index.php?msg=$msg");
        exit;
    }
    else{
        $messagefail = "Probeer het opnieuw!";
        header("location: register.php?msg=$messagefail");
    }
}


