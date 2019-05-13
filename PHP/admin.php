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

<?php
    foreach ($teams as $team) {
        $teamNameList[] = $team['name'];
        $members = $teamNameList;
        $schedule = scheduler($members);
    }

    function scheduler($members){
        if (count($members) != 10){
            array_push($members,"not enough teams");
        }
        $away = array_splice($members,(count($members)/2));
        $home = $members;
        for ($i=0; $i < count($home)+count($away)-1; $i++){
            for ($j=0; $j<count($home); $j++){
                $round[$i][$j]["Home"]=$home[$j];
                $round[$i][$j]["Away"]=$away[$j];
            }
            if(count($home)+count($away)-1 > 2){
                array_unshift($away,array_shift(array_splice($home,1,1)));
                array_push($home,array_pop($away));
            }
        }
        return $round;

    }


    foreach($schedule AS $round => $games){
    echo "Round: ".($round+1)."<BR>";
    foreach($games AS $play){
        echo $play["Home"]." - ".$play["Away"]."<BR>";
    }
    echo "<BR>";
    }

?>

<?= require 'footer.php';?>
