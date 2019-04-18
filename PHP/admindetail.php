<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 4/18/2019
 * Time: 9:05 AM
 */
$pagename = "edit_page";
$pagetitle = "Edit This";
require 'header.php';
$id = $_GET['id'];
$sql = "SELECT * FROM teams WHERE id = :id";
$prepare = $db->prepare($sql);
$prepare-> execute([
    ':id' => $id
]);

$team = $prepare->fetch(PDO::FETCH_ASSOC);

?>
<form action="" method="post">
    <input type="hidden" name="type" value="edit">
    <div class="container-2">
        <label for="team"><b class="register-team">Team naam</b></label>
        <input type="text" value="<?=$team['name']?>">
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

        <button class= "editBtn" type="submit" value="Create new contact">Edit</button>
    </div>
</form>

<?= require 'footer.php';