<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 5/13/2019
 * Time: 8:53 AM
 */

$pagetitle = 'Add members';
$pagename = 'addMembersPage';

require 'header.php';


$id = $_GET['id'];

$sql = "SELECT * FROM teams Where id = :id";
$prepare = $db->prepare($sql);
$prepare-> execute([
    ':id' => $id
]);
// hier toevoeg je de speleres
$team = $prepare->fetch(PDO::FETCH_ASSOC);


    $playercount = $team['players_count'];

    echo "<form action='loginController.php?id=$id' method='post'>";

    echo "<input type='hidden' name='type' value='add_players'>";
echo "<div class='container-3'>";
// hier loop die door de aantal spelers die moeten worden toegevoegd moet worden
for ($i = 1; $i <= $playercount; $i++){
    echo "<div class='container-4' style='max-width: 100px'>";
        echo "<label for='Player'><b>Speler $i</b></label>";
        echo "<input required type='text' name='player$i' placeholder='Voer de naam van speler $i in'>";
        echo "</div>";
    }
echo "</div>";

    echo "<input type='submit'>";
    echo "</form>";
