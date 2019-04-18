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
                <h1>Team aanmaken en Player</h1>
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
                <input type="hidden" name="type" value="register">
                    <div class="container-2">
                        <label for="team"><b class="register-team">Team naam</b></label>
                        <input type="text" placeholder="Enter Team Name">
                        <h2>Player name</h2>
                        <label for="player"><b class="register-player">Speler 1</b></label>
                        <input type="text" placeholder="Enter player name">

                        <label for="player"><b class="register-player">Speler 2</b></label>
                        <input type="text" placeholder="Enter player name">

                        <label for="player"><b class="register-player">Speler 3</b></label>
                        <input type="text" placeholder="Enter player name">

                        <label for="player"><b class="register-player">Speler 4</b></label>
                        <input type="text" placeholder="Enter player name">

                        <label for="player"><b class="register-player">Speler 5</b></label>
                        <input type="text" placeholder="Enter player name">

                        <label for="player"><b class="register-player">Speler 6</b></label>
                        <input type="text" placeholder="Enter player name">

                        <button class= "playerbutton" type="submit" value="Create new contact">Aanmaken</button>
                    </div>
            </form>
        </div>
    </div>
</main>

<?php require 'footer.php'; ?>