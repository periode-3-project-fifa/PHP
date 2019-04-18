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

//login


if ( $_POST['type'] === 'login' ) {

    $errMsg = '';

    // Get data from FORM
    $email = $_POST['email'];
    $password = $_POST['password'];


    if($email == '')
        $errMsg = 'Enter email';
    if($password == '')
        $errMsg = 'Enter password';

    if($errMsg == '') {
        try {

            $stmt = $db->prepare('SELECT id, email, password FROM users WHERE email = :email');
            $stmt->execute(array(
                ':email' => $email
            ));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if($data == false){
                $errMsg = "User $email not found.";
            }
            else {
                if(password_verify($password, $data['password'])) {


                    $_SESSION['email'] = $data['email'];


                    $_SESSION['id'] = $data['id'];

                    header("Location: index.php");
                    exit;
                }
                else
                    $errMsg = 'Password not match.';
            }
        }
        catch(PDOException $e) {
            $errMsg = $e->getMessage();
        }
    }

    exit;
}


//register
if ( $_POST['type'] == 'register' ) {


    //variabelen met email, password
    $email = $_POST['email'];
    $password = $_POST['password'];


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

if ( $_POST['type'] == 'registerteamplayer' ) {

    $teamname = $_POST['teamname'];
    $players = $_POST['players'];


    $sql = "INSERT INTO teams (name, players_count) VALUES (:name, :players_count)";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':name' => $teamname,
        ':players_count' => $players
    ]);

    $msg = "Team is succesvol aangemaakt!";
    header("location: index.php?msg=$msg");
    exit;
}
//adminpage edit team
if ($_POST['type'] == 'edit'){
    $id = $_GET['id'];
    $name = $_POST['teamname'];

    $sql = "UPDATE teams SET name = :name WHERE id = :id";

    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $id,
        ':name' => $name
    ]);


    $msg = 'succesvol veranderd';
    header("location: ./admin.php?msg=$msg");
    exit;
}
//adminpage delete team
if ($_POST['type'] == 'delete'){

    $id = $_GET['id'];

    $sql = "DELETE FROM teams WHERE id = :id";

    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $id
    ]);

    $msg = 'succesvol verwijderd';
    header("location: ./admin.php?msg=$msg");
    exit;
}