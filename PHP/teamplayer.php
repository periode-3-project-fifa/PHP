<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 4/15/2019
 * Time: 10:15 AM
 */

$pagename = 'teamplayer';
$pagetitle = 'teamplayer';
require 'header.php';?>
    </head>
<body class="<?=$pagename?>">

<header class = "register-header">
        <div class="container">
            <div class="register-navigation">
                <h1>Team aanmaken</h1>
                <div class="register-controler">
                    <a href="index.php" class="border-team">Home</a>   
                </div>
            </div>
        </div>
</header>

<main class="teamplayermake">
    <div class="container">
        <div class="background-teamplayer">
            <h2>Team aanmaken</h2>
            <form action="" method="post">
                <input type="hidden" name="type" value="registerteamplayer">
                    <div class="container-2">
                        <label for="team"><b class="register-team">Team naam</b></label>
                        <input type="text" placeholder="Enter Team Name">
                        <label for="player"><b class="register-player">Voer aantal spelers in</b></label>
                        <input type="number" placeholder="Voer aantal spelers in" min="6" max="15">

                        <button class= "playerbutton" type="submit" value="Create new contact">Aanmaken</button>
                    </div>
            </form>
        </div>
    </div>
</main>

<?php require 'footer.php'; ?>
