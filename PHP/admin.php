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
</head>
<body>
<ol>
    <?php
    foreach ($teams as $team){
        $teamname = $team['name'];
        $teamid = $team['id'];
        echo "<li><a href='admindetail.php?id=$teamid'>$teamname</a></li>";
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
    foreach ($teams as $team) {
        $teamNameList[] = $team['name'];
        $members = $teamNameList;
        $schedule = scheduler($members);
    }

    function scheduler($members)
    {
        if (count($members) < 10) {
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


?>


    <?php

    //Select de items die ik nodig heb, maar dat zijn id's. Met een Inner Join kan ik toch de namen showen.
   $sql = "SELECT round, teams_a.name AS home, teams_b.name AS away, poules.id FROM `poules`
INNER JOIN teams as teams_a 
ON teams_a.id = poules.home
INNER JOIN teams as teams_b
ON teams_b.id = poules.away";
$query = $db->query($sql);
$poules = $query->fetchAll(PDO::FETCH_ASSOC);



    //foreach om alles te laten zien op de site.
    foreach ($poules AS $game) {
        echo "<h4>Round:  " . $game ['round'] . "</h4><BR>";
        echo $game['home'] . " - " . $game['away'] . "<BR>";

    ?> <form action="loginController.php?id=<?=$game['id']?>" method='POST'>
    <?php
    echo   "<input type='hidden' name='type' value='score'>";
    echo   "<input type='text' name='homescore'  maxlength='2' required>";
    echo  "<input type='text' name='awayscore'  maxlength='2' required>";
    echo   "<input type='submit' value='Save'>";
    echo "</form>";
    }

    ?>
<?= require 'footer.php';?>
