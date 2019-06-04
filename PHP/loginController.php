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
    header("location: addMembers.php?id=$last_id");
    exit;
}
//addMembers

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
(team_id, player_one, player_two, player_three, player_four, player_five, player_six)
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
(team_id, player_one, player_two, player_three, player_four, player_five, player_six, player_seven)
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
(team_id, player_one, player_two, player_three, player_four, player_five, player_six, player_seven, player_eight)
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
(team_id, player_one, player_two, player_three, player_four, player_five, player_six, player_seven, player_eight, player_nine)
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
(team_id, player_one, player_two, player_three, player_four, player_five, player_six, player_seven, player_eight, player_nine, player_ten)
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
(team_id, player_one, player_two, player_three, player_four, player_five, player_six, player_seven, player_eight, player_nine, player_ten,
player_eleven)
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
(team_id, player_one, player_two, player_three, player_four, player_five, player_six, player_seven, player_eight, player_nine, player_ten,
player_eleven, player_twelve)
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
(team_id, player_one, player_two, player_three, player_four, player_five, player_six, player_seven, player_eight, player_nine, player_ten,
player_eleven, player_twelve, player_thirteen)
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
(team_id, player_one, player_two, player_three, player_four, player_five, player_six, player_seven, player_eight, player_nine, player_ten,
player_eleven, player_twelve, player_thirteen, player_fourteen)
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
(team_id, player_one, player_two, player_three, player_four, player_five, player_six, player_seven, player_eight, player_nine, player_ten,
player_eleven, player_twelve, player_thirteen, player_fourteen, player_fifteen)
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

    $key = $_POST['key'];

    $count=$db->prepare("select * from api_keys");

    $count->bindParam("api_key",$key);

    $count->execute();

    $no=$count->rowCount();

    if($no >0 ){
        $message = "Key bestaat al!";
        echo "<script type='text/javascript'>alert('$message');</script>";

        header("location: gen_keys.php?msg=$message");
        exit;
    }

    $sql = "INSERT INTO api_keys (api_key) value (:key)";

    $prepare = $db->prepare($sql);
    $prepare->execute([
        'key' => $key
    ]);

   $msg = "key succesvol aangemaakt";
   header("location: admin.php?msg=$msg");
   exit;
}
