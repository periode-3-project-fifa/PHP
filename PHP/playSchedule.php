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

$sql = "SELECT * FROM poules";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);

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


