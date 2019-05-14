<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 4/18/2019
 * Time: 8:50 AM
 */

require 'header.php';

$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);

?>
    </head>
        <body>
        <div class="main_top">
            <div class="Poules">
                <div class="heading">
                    <h3>Poule A</h3>
                </div>
                <div class="playschedule">

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
                            $splicedArray = array_splice($home,1,1);
                            $shiftedArray = array_shift($splicedArray);
                            if(count($home)+count($away)-1 > 2){
                                array_unshift($away, $shiftedArray);
                                array_push($home,array_pop($away));
                            }
                        }
                        return $round;

                    }


                    foreach($schedule AS $round => $games){
                        echo "<div class='rounds'><h3>Ronde: ".($round+1)."</h3>";
                        foreach($games AS $play){
                            echo "<div class='singleround'><p>".$play["Home"]."</p>"."<p style='color:orangered'><strong>-VS-</strong></p>"."<p>".$play["Away"]."</p></div>";
                        }
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>

            <div class="Poules">
                <div class="heading">
                    <h3>Poule B</h3>
                </div>
                <div class="box poules">

                </div>
            </div>

        </div>
        </body>
    <?= require 'footer.php';?>


