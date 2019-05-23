<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 4/18/2019
 * Time: 8:50 AM
 */

$pagename = 'Playschedule';
$pagetitle = 'Play Schedule';

require 'header.php';

//Select de items die ik nodig heb, maar dat zijn id's. Met een Inner Join kan ik toch de namen showen.
$sql = "SELECT round, teams_a.name AS home, teams_b.name AS away, poules.homescore, poules.awayscore FROM `poules`
INNER JOIN teams as teams_a 
ON teams_a.id = poules.home
INNER JOIN teams as teams_b
ON teams_b.id = poules.away";
$query = $db->query($sql);
$poules = $query->fetchAll(PDO::FETCH_ASSOC);


?>
    </head>
    <body class="<?=$pagename?>">
        <div class="main_top">
            <div class="Poules">
                <div class="heading">
                    <h3>Poule A</h3>
                </div>
                <div class="playschedule">

                    <?php
                    //foreach om alles te laten zien op de site.
                        foreach ($poules AS $game) {
                           echo "<h2>Round:  " . $game ['round'] . "</h2><BR>";
                            echo $game['home'] . " - " . $game['away'] .  "<br>" . "<strong><i>Eind score: ". $game['homescore'] . " - " . $game['awayscore'] . "</i></strong><BR>";

                        }
                    ?>

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


