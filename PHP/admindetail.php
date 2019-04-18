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
<form action="loginController.php?id=<?=$id?>" method="post">
    <input type="hidden" name="type" value="edit">
    <div class="container-2">
        <div class="form-group">
        <label for="team"><b class="register-team">Team naam</b></label>
        <input name="teamname" type="text" value="<?=$team['name']?>">
        </div>
        <h2>Player name</h2>
        <div class="form-group">
            <label for="player"><b class="register-player">Speler 1</b></label>
            <input type="text" placeholder="Enter player name">
        </div>
        <div class="form-group">
            <label for="player"><b class="register-player">Speler 2</b></label>
            <input type="text" placeholder="Enter player name">
        </div>
        <div class="form-group">
            <label for="player"><b class="register-player">Speler 3</b></label>
            <input type="text" placeholder="Enter player name">
        </div>
        <div class="form-group">
            <label for="player"><b class="register-player">Speler 4</b></label>
            <input type="text" placeholder="Enter player name">
        </div>
        <div class="form-group">
            <label for="player"><b class="register-player">Speler 5</b></label>
            <input type="text" placeholder="Enter player name">
        </div>
        <div class="form-group">
            <label for="player"><b class="register-player">Speler 6</b></label>
            <input type="text" placeholder="Enter player name">
        </div>

        <input class="editBtn" type="submit" value="edit">
    </div>
</form>
    <form action="loginController.php?id=<?=$id?>" method="post">
        <input type="hidden" name="type" value="delete">

        <input type="submit" class="removeBtn" value="delete">
    </form>

<?= require 'footer.php';