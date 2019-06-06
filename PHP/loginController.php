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
            $stmt = $db->prepare('SELECT id, email, password, admin FROM users WHERE email = :email');
            $stmt->execute(array(
                ':email' => $email
            ));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if($email == false){
                $errMsg = "User $email not found.";
            }

            else {
                if(password_verify($password, $data['password'])) {


                    $_SESSION['email'] = $data['email'];

                    $_SESSION['id'] = $data['id'];

                    $_SESSION['admin'] = $data['admin'];

                    if ($data['admin'] == 1){
                        header("Location: admin.php?");
                        exit;
                    }
                    else{
                        header("Location: index.php");
                        exit;
                    }
                }
                else {
                    $errMsg = 'Account bestaat niet.';
                    header("Location: login.php?msg=$errMsg");
                }
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

    if($_POST['password'] == ""){
        $msg = "Wachtwoord mag niet leeg zijn!";
        header("location: register.php?msg=$msg");

    }
    else {
        //Checkt of password met elkaar overeenkomen, zoja dan gaat hij door.
        if ($_POST['password'] == $_POST['passwordconfirm']) {

            $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
            $prepare = $db->prepare($sql);
            $prepare->execute([
                ':email' => $email,
                ':password' => $passwordhashed
            ]);

            $msg = "Account is succesvol aangemaakt!";
            header("location: login.php?msg=$msg");
            exit;
        } else {
            $messagefail = "wachtwoorden komen niet overeen!";
            header("location: register.php?msg=$messagefail");
        }
    }
}
//addMembers

if ( $_POST['type'] == 'registerteamplayer' ) {

    $teamname = $_POST['teamname'];
    $players = $_POST['players'];


    $sql = "INSERT INTO teams (name, players_count) VALUES (:names, :players_count)";


    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':names' => $teamname,
        ':players_count' => $players
    ]);


    $last_id = $db->lastInsertId();


    $msg = "Team is succesvol aangemaakt!";
    header("location: addmembers.php?id=$last_id");
    exit;
}

//adminpage edit team
if ($_POST['type'] == 'edit'){
    $id = $_GET['id'];
    $name = $_POST['teamname'];

    $sql = "SELECT * from teams where id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'id' => $id
    ]);

    $team = $prepare->fetch(PDO::FETCH_ASSOC);
    $player_count = $team['players_count'];

    $sql = "UPDATE teams SET name = :name WHERE id = :id";

    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $id,
        ':name' => $name
    ]);
    if ($player_count == 6){
        $p1 = $_POST['player1'];
        $p2 = $_POST['player2'];
        $p3 = $_POST['player3'];
        $p4 = $_POST['player4'];
        $p5 = $_POST['player5'];
        $p6 = $_POST['player6'];
        $sql = "update player_names set (player_1, player_2, player_3, player_4, player_5, player_6) value(:p1,:p2,:p3,:p4,:p5,:p6)
where team_id = :id";
        $prepare = $db->prepare($sql);
        $prepare->execute([
                'id' => $id,
                'p1' => $p1,
                'p2' => $p2,
                'p3' => $p3,
                'p4' => $p4,
                'p5' => $p5,
                'p6' => $p6
            ]);
    }
    else if ($player_count == 7){
        $p1 = $_POST['player1'];
        $p2 = $_POST['player2'];
        $p3 = $_POST['player3'];
        $p4 = $_POST['player4'];
        $p5 = $_POST['player5'];
        $p6 = $_POST['player6'];
        $p7 = $_POST['player7'];

        $sql = "update player_names set (player_1 = :p1, player_2 = :p2, player_3 = :p3, player_4 = :p4, player_5 = :p5, player_6 = :p6, player_7 = :p7)
 where team_id = :id";

        $prepare = $db->prepare($sql);
        $prepare->execute([
            ':id' => $id,
            ':p1' => $p1,
            ':p2' => $p2,
            ':p3' => $p3,
            ':p4' => $p4,
            ':p5' => $p5,
            ':p6' => $p6,
            ':p7' => $p7
        ]);
    }
    else if ($player_count == 8){
        $p1 = $_POST['player1'];
        $p2 = $_POST['player2'];
        $p3 = $_POST['player3'];
        $p4 = $_POST['player4'];
        $p5 = $_POST['player5'];
        $p6 = $_POST['player6'];
        $p7 = $_POST['player7'];
        $p8 = $_POST['player8'];
        $sql = "update player_names set (player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8) value 
(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8) where team_id = :id";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            'id' => $id,
            'p1' => $p1,
            'p2' => $p2,
            'p3' => $p3,
            'p4' => $p4,
            'p5' => $p5,
            'p6' => $p6,
            'p7' => $p7,
            'p8' => $p8
        ]);
    }
    else if ($player_count == 9){
        $p1 = $_POST['player1'];
        $p2 = $_POST['player2'];
        $p3 = $_POST['player3'];
        $p4 = $_POST['player4'];
        $p5 = $_POST['player5'];
        $p6 = $_POST['player6'];
        $p7 = $_POST['player7'];
        $p8 = $_POST['player8'];
        $p9 = $_POST['player9'];
        $sql = "update player_names set (player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9) value
 (:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9) where team_id = :id";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            'id' => $id,
            'p1' => $p1,
            'p2' => $p2,
            'p3' => $p3,
            'p4' => $p4,
            'p5' => $p5,
            'p6' => $p6,
            'p7' => $p7,
            'p8' => $p8,
            'p9' => $p9
        ]);
    }
    else if ($player_count == 10){
        $p1 = $_POST['player1'];
        $p2 = $_POST['player2'];
        $p3 = $_POST['player3'];
        $p4 = $_POST['player4'];
        $p5 = $_POST['player5'];
        $p6 = $_POST['player6'];
        $p7 = $_POST['player7'];
        $p8 = $_POST['player8'];
        $p9 = $_POST['player9'];
        $p10 = $_POST['player10'];
        $sql = "update player_names set (player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9, player_10)
 value (:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10) where team_id = :id";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            'id' => $id,
            'p1' => $p1,
            'p2' => $p2,
            'p3' => $p3,
            'p4' => $p4,
            'p5' => $p5,
            'p6' => $p6,
            'p7' => $p7,
            'p8' => $p8,
            'p9' => $p9,
            'p10' => $p10
        ]);
    }
    else if ($player_count == 11){
        $p1 = $_POST['player1'];
        $p2 = $_POST['player2'];
        $p3 = $_POST['player3'];
        $p4 = $_POST['player4'];
        $p5 = $_POST['player5'];
        $p6 = $_POST['player6'];
        $p7 = $_POST['player7'];
        $p8 = $_POST['player8'];
        $p9 = $_POST['player9'];
        $p10 = $_POST['player10'];
        $p11 = $_POST['player11'];
        $sql = "update player_names set (player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9, player_10
, player_11) value (:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11) where team_id = :id";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            'id' => $id,
            'p1' => $p1,
            'p2' => $p2,
            'p3' => $p3,
            'p4' => $p4,
            'p5' => $p5,
            'p6' => $p6,
            'p7' => $p7,
            'p8' => $p8,
            'p9' => $p9,
            'p10' => $p10,
            'p11' => $p11
            ]);
    }
    else if ($player_count == 12){
        $p1 = $_POST['player1'];
        $p2 = $_POST['player2'];
        $p3 = $_POST['player3'];
        $p4 = $_POST['player4'];
        $p5 = $_POST['player5'];
        $p6 = $_POST['player6'];
        $p7 = $_POST['player7'];
        $p8 = $_POST['player8'];
        $p9 = $_POST['player9'];
        $p10 = $_POST['player10'];
        $p11 = $_POST['player11'];
        $p12 = $_POST['player12'];
        $sql = "update player_names set (player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9, player_10
, player_11, player_12) value (:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12) where team_id = :id";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            'id' => $id,
            'p1' => $p1,
            'p2' => $p2,
            'p3' => $p3,
            'p4' => $p4,
            'p5' => $p5,
            'p6' => $p6,
            'p7' => $p7,
            'p8' => $p8,
            'p9' => $p9,
            'p10' => $p10,
            'p11' => $p11,
            'p12' => $p12
            ]);
    }
    else if ($player_count == 13){
    $p1 = $_POST['player1'];
    $p2 = $_POST['player2'];
    $p3 = $_POST['player3'];
    $p4 = $_POST['player4'];
    $p5 = $_POST['player5'];
    $p6 = $_POST['player6'];
    $p7 = $_POST['player7'];
    $p8 = $_POST['player8'];
    $p9 = $_POST['player9'];
    $p10 = $_POST['player10'];
    $p11 = $_POST['player11'];
    $p12 = $_POST['player12'];
    $p13 = $_POST['player13'];
    $sql = "update player_names set (player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9, player_10
, player_11, player_12, player_13) value (:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13) where team_id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        'id' => $id,
        'p1' => $p1,
        'p2' => $p2,
        'p3' => $p3,
        'p4' => $p4,
        'p5' => $p5,
        'p6' => $p6,
        'p7' => $p7,
        'p8' => $p8,
        'p9' => $p9,
        'p10' => $p10,
        'p11' => $p11,
        'p12' => $p12,
        'p13' => $p13]);
    }
    else if ($player_count == 14){
        $p1 = $_POST['player1'];
        $p2 = $_POST['player2'];
        $p3 = $_POST['player3'];
        $p4 = $_POST['player4'];
        $p5 = $_POST['player5'];
        $p6 = $_POST['player6'];
        $p7 = $_POST['player7'];
        $p8 = $_POST['player8'];
        $p9 = $_POST['player9'];
        $p10 = $_POST['player10'];
        $p11 = $_POST['player11'];
        $p12 = $_POST['player12'];
        $p13 = $_POST['player13'];
        $p14 = $_POST['player14'];
        $sql = "update player_names set (player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9, player_10
, player_11, player_12, player_13, player_14,) value (:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14) where team_id = :id";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            'id' => $id,
            'p1' => $p1,
            'p2' => $p2,
            'p3' => $p3,
            'p4' => $p4,
            'p5' => $p5,
            'p6' => $p6,
            'p7' => $p7,
            'p8' => $p8,
            'p9' => $p9,
            'p10' => $p10,
            'p11' => $p11,
            'p12' => $p12,
            'p13' => $p13,
            'p14' => $p14
            ]);
    }
    else if ($player_count == 15){
        $p1 = $_POST['player1'];
        $p2 = $_POST['player2'];
        $p3 = $_POST['player3'];
        $p4 = $_POST['player4'];
        $p5 = $_POST['player5'];
        $p6 = $_POST['player6'];
        $p7 = $_POST['player7'];
        $p8 = $_POST['player8'];
        $p9 = $_POST['player9'];
        $p10 = $_POST['player10'];
        $p11 = $_POST['player11'];
        $p12 = $_POST['player12'];
        $p13 = $_POST['player13'];
        $p14 = $_POST['player14'];
        $p15 = $_POST['player15'];
        $sql = "update player_names set (player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9, player_10
, player_11, player_12, player_13, player_14, player_15) value (:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15) where team_id = :id";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            'id' => $id,
            'p1' => $p1,
            'p2' => $p2,
            'p3' => $p3,
            'p4' => $p4,
            'p5' => $p5,
            'p6' => $p6,
            'p7' => $p7,
            'p8' => $p8,
            'p9' => $p9,
            'p10' => $p10,
            'p11' => $p11,
            'p12' => $p12,
            'p13' => $p13,
            'p14' => $p14,
            'p15' => $p15
        ]);
    }

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

    $sql2 = "DELETE FROM player_names WHERE team_id = :id";
    $prepare2 = $db->prepare($sql2);
    $prepare2->execute([
        ':id' => $id
    ]);

    $msg = 'succesvol verwijderd';
    header("location: ./admin.php?msg=$msg");
    exit;
}

//save schedule
if ($_POST['type'] == 'teamSchedule')
{

    $sql = "SELECT * FROM teams";
    $query = $db->query($sql);
    $teams = $query->fetchAll(PDO::FETCH_ASSOC);

     function scheduler($members)
    {
        if (count($members) != 10) {
            array_push($members, "10 teams are needed");
        }
        $away = array_splice($members, (count($members) / 2));
        $home = $members;
        for ($i = 0; $i < count($home) + count($away) - 1; $i++) {
            for ($j = 0; $j < count($home); $j++) {
                $round[$i][$j]["Home"] = $home[$j];
                $round[$i][$j]["Away"] = $away[$j];
            }
            $splicedArray = array_splice($home, 1, 1);
            $shiftedArray = array_shift($splicedArray);
            if (count($home) + count($away) - 1 > 2) {
                array_unshift($away, $shiftedArray);
                array_push($home, array_pop($away));
            }
        }
        return $round;
    }

    foreach ($teams as $team) {
        $teamNameList[] = $team['id'];
        $members = $teamNameList;
        $schedule = scheduler($members);
    }
    $ronde = 1;

    foreach($schedule as $round) {

        foreach($round as $game) {


            $home = $game['Home'];
            $away = $game['Away'];
            $sql = "INSERT INTO poules(round, home, away) VALUES (:round, :home, :away)";
            $prepare = $db->prepare($sql);
            $prepare->execute([
                ':round' => $ronde,
                ':home' => $home,
                ':away' => $away
            ]);

        }
        $ronde++;
    }
    header("Location: ./admin.php");

}



if ($_POST['type'] == 'score') {

    $idpoule = $_GET['id'];
    $homescore = $_POST['homescore'];
    $awayscore = $_POST['awayscore'];

    $sql = "UPDATE poules SET homescore = :homescore, awayscore = :awayscore WHERE id = :id";

    $prepare = $db->prepare($sql);

    $prepare->execute([
        ':id' => $idpoule,
        ':homescore' => $homescore,
        ':awayscore' => $awayscore
    ]);



    $msg = 'succesvol toegevoegd';
    header("location: ./admin.php?msg=$msg");
    exit;
}

if ($_POST['type'] == 'add_players') {

    $team_id = $_GET['id'];


    $sql = "SELECT * FROM teams WHERE id = :id";

    $prepare = $db->prepare($sql);

    $prepare->execute([
        ':id' => $team_id
    ]);

    $team = $prepare->fetch(PDO::FETCH_ASSOC);

    $player_amount = $team['players_count'];

    $player1 = $_POST['player1'];
    $player2 = $_POST['player2'];
    $player3 = $_POST['player3'];
    $player4 = $_POST['player4'];
    $player5 = $_POST['player5'];
    $player6 = $_POST['player6'];
    if ($player_amount > 6) {
        $player7 = $_POST['player7'];
        if ($player_amount > 7) {
            $player8 = $_POST['player8'];
            if ($player_amount > 8) {
                $player9 = $_POST['player9'];
                if ($player_amount > 9) {
                    $player10 = $_POST['player10'];
                    if ($player_amount > 10) {
                        $player11 = $_POST['player11'];
                        if ($player_amount > 11) {
                            $player12 = $_POST['player12'];
                            if ($player_amount > 12) {
                                $player13 = $_POST['player13'];
                                if ($player_amount > 13) {
                                    $player14 = $_POST['player14'];
                                    if ($player_amount > 14) {
                                        $player15 = $_POST['player15'];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    if ($player_amount == 6) {

        $sql = "INSERT INTO player_names
(team_id, player_1, player_2, player_3, player_4, player_5, player_6)
VALUE (:id, :p1, :p2,:p3,:p4,:p5,:p6)";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            'id' => $team_id,
            'p1' => $player1,
            'p2' => $player2,
            'p3' => $player3,
            'p4' => $player4,
            'p5' => $player5,
            'p6' => $player6,
        ]);
    } else {
        if ($player_amount == 7) {
            $sql = "INSERT INTO player_names
(team_id, player_1, player_2, player_3, player_4, player_5, player_6, player_7)
VALUE (:id, :p1, :p2,:p3,:p4,:p5,:p6, :p7)";
            $prepare = $db->prepare($sql);
            $prepare->execute([
                'id' => $team_id,
                'p1' => $player1,
                'p2' => $player2,
                'p3' => $player3,
                'p4' => $player4,
                'p5' => $player5,
                'p6' => $player6,
                'p7' => $player7
            ]);}
            else if ($player_amount == 8) {
                $sql = "INSERT INTO player_names
(team_id, player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8)
VALUE (:id, :p1, :p2,:p3,:p4,:p5,:p6, :p7, :p8)";
                $prepare = $db->prepare($sql);
                $prepare->execute([
                    'id' => $team_id,
                    'p1' => $player1,
                    'p2' => $player2,
                    'p3' => $player3,
                    'p4' => $player4,
                    'p5' => $player5,
                    'p6' => $player6,
                    'p7' => $player7,
                    'p8' => $player8
                ]);}
            else if ($player_amount == 9) {
                $sql = "INSERT INTO player_names
(team_id, player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9)
VALUE (:id, :p1, :p2,:p3,:p4,:p5,:p6, :p7, :p8, :p9)";
                $prepare = $db->prepare($sql);
                $prepare->execute([
                    'id' => $team_id,
                    'p1' => $player1,
                    'p2' => $player2,
                    'p3' => $player3,
                    'p4' => $player4,
                    'p5' => $player5,
                    'p6' => $player6,
                    'p7' => $player7,
                    'p8' => $player8,
                    'p9' => $player9
                ]);}
            else if ($player_amount == 10) {
                    $sql = "INSERT INTO player_names
(team_id, player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9, player_10)
VALUE (:id, :p1, :p2,:p3,:p4,:p5,:p6, :p7, :p8, :p9, :p10)";
                    $prepare = $db->prepare($sql);
                    $prepare->execute([
                        'id' => $team_id,
                        'p1' => $player1,
                        'p2' => $player2,
                        'p3' => $player3,
                        'p4' => $player4,
                        'p5' => $player5,
                        'p6' => $player6,
                        'p7' => $player7,
                        'p8' => $player8,
                        'p9' => $player9,
                        'p10' => $player10
                    ]);}
            else if ($player_amount == 11) {
                $sql = "INSERT INTO player_names
(team_id, player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9, player_10,
player_11)
VALUE (:id, :p1, :p2,:p3,:p4,:p5,:p6, :p7, :p8, :p9, :p10, :p11)";
                $prepare = $db->prepare($sql);
                $prepare->execute([
                    'id' => $team_id,
                    'p1' => $player1,
                    'p2' => $player2,
                    'p3' => $player3,
                    'p4' => $player4,
                    'p5' => $player5,
                    'p6' => $player6,
                    'p7' => $player7,
                    'p8' => $player8,
                    'p9' => $player9,
                    'p10' => $player10,
                    'p11' => $player11
                ]);}
            else if ($player_amount == 12) {
                $sql = "INSERT INTO player_names
(team_id, player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9, player_10,
player_11, player_12)
VALUE (:id, :p1, :p2,:p3,:p4,:p5,:p6, :p7, :p8, :p9, :p10, :p11, :p12)";
                $prepare = $db->prepare($sql);
                $prepare->execute([
                    'id' => $team_id,
                    'p1' => $player1,
                    'p2' => $player2,
                    'p3' => $player3,
                    'p4' => $player4,
                    'p5' => $player5,
                    'p6' => $player6,
                    'p7' => $player7,
                    'p8' => $player8,
                    'p9' => $player9,
                    'p10' => $player10,
                    'p11' => $player11,
                    'p12' => $player12
                ]);}
            else if ($player_amount == 13) {
                $sql = "INSERT INTO player_names
(team_id, player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9, player_10,
player_11, player_12, player_13)
VALUE (:id, :p1, :p2,:p3,:p4,:p5,:p6, :p7, :p8, :p9, :p10, :p11, :p12, :p13)";
                $prepare = $db->prepare($sql);
                $prepare->execute([
                    'id' => $team_id,
                    'p1' => $player1,
                    'p2' => $player2,
                    'p3' => $player3,
                    'p4' => $player4,
                    'p5' => $player5,
                    'p6' => $player6,
                    'p7' => $player7,
                    'p8' => $player8,
                    'p9' => $player9,
                    'p10' => $player10,
                    'p11' => $player11,
                    'p12' => $player12,
                    'p13' => $player13
                ]);}
            else if ($player_amount == 14) {
                $sql = "INSERT INTO player_names
(team_id, player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9, player_10,
player_11, player_12, player_13, player_14)
VALUE (:id, :p1, :p2,:p3,:p4,:p5,:p6, :p7, :p8, :p9, :p10, :p11, :p12, :p13, :p14)";
                $prepare = $db->prepare($sql);
                $prepare->execute([
                    'id' => $team_id,
                    'p1' => $player1,
                    'p2' => $player2,
                    'p3' => $player3,
                    'p4' => $player4,
                    'p5' => $player5,
                    'p6' => $player6,
                    'p7' => $player7,
                    'p8' => $player8,
                    'p9' => $player9,
                    'p10' => $player10,
                    'p11' => $player11,
                    'p12' => $player12,
                    'p13' => $player13,
                    'p14' => $player14
                ]);}
            else if ($player_amount == 15) {
                $sql = "INSERT INTO player_names
(team_id, player_1, player_2, player_3, player_4, player_5, player_6, player_7, player_8, player_9, player_10,
player_11, player_12, player_13, player_14, player_15)
VALUE (:id, :p1, :p2,:p3,:p4,:p5,:p6, :p7, :p8, :p9, :p10, :p11, :p12, :p13, :p14, :p15)";
                $prepare = $db->prepare($sql);
                $prepare->execute([
                    'id' => $team_id,
                    'p1' => $player1,
                    'p2' => $player2,
                    'p3' => $player3,
                    'p4' => $player4,
                    'p5' => $player5,
                    'p6' => $player6,
                    'p7' => $player7,
                    'p8' => $player8,
                    'p9' => $player9,
                    'p10' => $player10,
                    'p11' => $player11,
                    'p12' => $player12,
                    'p13' => $player13,
                    'p14' => $player14,
                    'p15' => $player15
                ]);}
    }

    $msg = "succesvol aangemaakt";
    header("location: index.php?msg=$msg");
    exit;
}

if ($_POST['type'] == 'generate_key') {

    $key = uniqid();


    $sql = "INSERT INTO api_keys (api_key) value (:key)";

    $prepare = $db->prepare($sql);
    $prepare->execute([
        'key' => $key
    ]);

    echo "<script type='text/javascript'>alert(".$key.");</script";

   $msg = "key: $key succesvol aangemaakt";
   header("location: admin.php?msg=$msg?key=$key");
   exit;
}



    if($_POST['type'] == 'points')
        $sql = "SELECT * FROM poules";
$query = $db->query($sql);
$score = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($score as $mscore){
            $homescore = $mscore['homescore'];
            $awayscore = $mscore['awayscore'];
            $id = $mscore['id'];
            $homeid = $mscore['home'];
            $awayid = $mscore['away'];



            if ($homescore > $awayscore ){
                ///TODO:
                /// 1. haal de punten van het hometeam op (innerjoin)
                /// 2. zorg dat daar drie punten bij komen
                /// 3. sla het totaal aantal punten weer op
                $sql = "UPDATE teams SET points = points + 3 WHERE id = :homeid";

                $prepare = $db->prepare($sql);

                $prepare->execute([
                    ':homeid' => $homeid
                ]);
                $msg = "Punten succesvol toegevoegd";
                header("location: admin.php?msg=$msg");
            }
            else if ($awayscore > $homescore){
                ///TODO:
                /// 1. haal de punten van het awayteam op (innerjoin)
                /// 2. zorg dat daar drie punten bij komen
                /// 3. sla het totaal aantal punten weer op
                $sql = "UPDATE teams SET points = points + 3 WHERE id = :awayid";

                $prepare = $db->prepare($sql);

                $prepare->execute([
                    ':awayid' => $awayid
                ]);
                $msg = "Punten succesvol toegevoegd";
                header("location: admin.php?msg=$msg");

            }
            /*else if($awayscore===$homescore){
                /// TODO
                /// 1. haal de punten op van het hometeam en het awayteam
                /// 2. zorg dat bij beide een punt bij komt
                /// 3. sla het totaal aantal punten weer op
                $sql = "UPDATE teams SET points = points + 1 WHERE id = :awayid";

                $prepare = $db->prepare($sql);

                $prepare->execute([
                    ':awayid' => $awayid
                ]);
                $sql = "update teams set points = points + 1 where id = :homeid";
                $prepare = $db->prepare($sql);
                $prepare->execute([
                    ':homeid' => $homeid
                ]);

            }
            */

        }
