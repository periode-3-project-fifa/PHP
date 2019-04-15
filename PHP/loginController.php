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

//register
if ( $_POST['type'] == 'register' ) {
    //variabelen met email, password
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordconfirm = $_POST['passwordconfirm'];

    //password hashen
    $passwordhashed = password_hash($password, PASSWORD_DEFAULT);


    //checken of het een echt email is.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "This is no valid email";
        header("location: register.php?msg=$message");
        exit;
    }


    $count=$db->prepare("select * from users where email=:email");

    $count->bindParam(":email",$email);

    $count->execute();

    $no=$count->rowCount();

    if($no >0 ){
        $message = "Email bestaat al!";
        echo "<script type='text/javascript'>alert('$message');</script>";

        header("location: register.php?msg=$message");
        exit;
    }

    //checken of passwords overeen komen met elkaar
    if ($_POST['password'] != $_POST['passwordconfirm']) {

        $message = "Wachtwoord komt niet overeen!";
        echo "<script type='text/javascript'>alert('$message');</script>";

    }

    //Checkt of password met elkaar overeenkomen, zoja dan gaat hij door.
    if ($_POST['password'] == $_POST['passwordconfirm']) {

        $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            ':email' => $email,
            ':password' => $passwordhashed
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


