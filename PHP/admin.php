<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 4/18/2019
 * Time: 8:50 AM
 */

$pagename = "adminpage";
$pagetitle = "U bent Admin";
require 'header.php';
$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);
if($_SESSION['admin'] != 1){
    header("Location: index.php");
}
$sqlid = "SELECT * FROM `poules`";
$queryid = $db->query($sqlid);
$id = $queryid->fetchAll(PDO::FETCH_ASSOC);

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


?>


    <?php
    foreach ($schedule AS $round => $games) {
        echo "Round: " . ($round + 1) . "<BR>";
        foreach ($games AS $play) {
            echo $play["Home"] . " - " . $play["Away"] . "<BR>";
            ?> <form action="loginController.php?id=<?=$id?>" method='POST'>
            <?php
            echo   "<input type='hidden' name='type' value='score'>";
            echo   "<input type='text' name='homescore'  maxlength='2'>";
            echo  "<input type='text' name='awayscore'  maxlength='2'>";
            echo   "<input type='submit' value='Save'>";
            echo "</form>";

        }
        echo "<BR>";

    }
    ?>
?>
<?= require 'footer.php';?>
