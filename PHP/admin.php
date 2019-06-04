<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 4/18/2019
 * Time: 8:50 AM
 */

$pagename = "adminpage";
$pagetitle = "Je bent Admin";
require 'header.php';
$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);
if($_SESSION['admin'] != 1){
    header("Location: index.php");
}
?>
<ol>
    <?php
    foreach ($teams as $team){
        $teamname = $team['name'];
        $teamid = $team['id'];
        echo "<a class='team_list'' href='admindetail.php?id=$teamid'><li>$teamname</li></a>";
    }
    ?>
</ol>
<form action="loginController.php" method="post">
    <input type="submit" name="type" id="teamSchedule" value="teamSchedule">
<!--    <input type="hidden" name="scores" >-->
<!--        <input type="submit" name="type" id="Save" value="Save">-->
<!--        <input type="text" name="type" id="homescore">-->
<!--        <input type="text" name="type" id="awayscore">-->
</form>
<?php
//slecteerd alles uit de database
    foreach ($teams as $team) {
        $teamNameList[] = $team['name'];
        $members = $teamNameList;
        $schedule = scheduler($members);
    }

    function scheduler($members)
    {   //er moeten 10 teams zijn of meer
        if (count($members) < 10) {
            array_push($members, "10 teams are needed");
        }
        //hier wordt de eerste value van members verwijderd uit de array
        $away = array_splice($members, (count($members) / 2));
        $home = $members;
        //hier worden alle home teams ingedeeld
        for ($i = 0; $i < count($home) + count($away) - 1; $i++) {

            for ($j = 0; $j < count($home); $j++) {
                $round[$i][$j]["Home"] = $home[$j];
                $round[$i][$j]["Away"] = $away[$j];



            }
        // hier wordt bij elk home team een away team toegewezen
            $splicedArray = array_splice($home, 1, 1);
            $shiftedArray = array_shift($splicedArray);
            if (count($home) + count($away) - 1 > 2) {
                array_unshift($away, $shiftedArray);
                array_push($home, array_pop($away));
            }


        }
        return $round;





    }


?>
<form action="loginController.php" method="post">
    <input type="submit" name="type" id="points" value="points">
</form>

<?php
    //selecteert de grootste ronde uit de database.
    $sql = "SELECT max(round) as maxRound FROM poules";
    $maxRounds = $db->query($sql)->fetch(PDO::FETCH_ASSOC);


    //Select de items die ik nodig heb, maar dat zijn id's. Met een Inner Join kan ik toch de namen showen.
   $sql = "SELECT round, teams_a.name AS home, teams_b.name AS away, poules.id, poules.homescore, poules.awayscore FROM `poules`
INNER JOIN teams as teams_a 
ON teams_a.id = poules.home
INNER JOIN teams as teams_b
ON teams_b.id = poules.away";
$query = $db->query($sql);
$poules = $query->fetchAll(PDO::FETCH_ASSOC);





    //telt hoeveel rondes er zijn en pakt er 1 van.
    for ($i = 1; $i <= $maxRounds['maxRound']; $i++) {
        echo "<h3>Round:  " . $i . "</h3><BR>";

        //foreach om alles te laten zien op de site.
        foreach ($poules AS $game) {
            if ($game['round'] == $i) {
                echo "<br>" . $game['home'] . " - " . $game['away'] .  "<br>" . "<strong><i>Eind score: ". $game['homescore'] . " - " . $game['awayscore'] . "</i></strong><BR>";

                 ?> <form action="loginController.php?id=<?=$game['id']?>" method='POST'>
                 <?php
                 echo   "<input type='hidden' name='type' value='score'>";
                 echo   "<input type='number' name='homescore'  maxlength='2' required>";
                 echo  "<input type='number' name='awayscore'  maxlength='2' required>";
                 echo   "<input type='submit' value='Save'>";
                 echo "</form>";
            }

        }
    }

                 $sql = "SELECT teams.points as points FROM `teams`
INNER JOIN poules
ON homescore = awayscore";
$query = $db->query($sql);
$score = $query->fetchAll(PDO::FETCH_ASSOC);

    if($_POST['type'] == 'points')
                 foreach ($score as $mscore){
                     $homescore = $mscore['homescore'];
                     $awayscore = $mscore['awayscore'];
                     var_dump($homescore); die;
                     $id = $poules['id'];
                     $points = $poules['points'];

                     if ($homescore > $awayscore ){
                        ///TODO:
                         /// 1. haal de punten van het hometeam op (innerjoin)
                         /// 2. zorg dat daar drie punten bij komen
                         /// 3. sla het totaal aantal punten weer op
                         ///
                         $sql = "UPDATE teams SET points = :points + 3 WHERE id = :id";

                         $prepare = $db->prepare($sql);

                         $prepare->execute([
                             ':points' => $points,
                             ':id' => $id

                         ]);
                     }
                     else if ($awayscore > $homescore){
                         ///TODO:
                         /// 1. haal de punten van het awayteam op (innerjoin)
                         /// 2. zorg dat daar drie punten bij komen
                         /// 3. sla het totaal aantal punten weer op

                     }
                     else {
                         /// TODO
                         /// 1. haal de punten op van het hometeam en het awayteam
                         /// 2. zorg dat bij beide een punt bij komt
                         /// 3. sla het totaal aantal punten weer op

                     }

                 }
?>
<?= require 'footer.php';?>
