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
if($_SESSION['admin'] != 1){
    header("Location: index.php");
}
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
        <?php
        $playercount = $team['players_count'];
        $y = 1;
        for ($i = 0; $i < $playercount; $i++) {
            echo "<div class='form-group' >";
            echo "<label for='player' ><b class='register-player' > Speler $y </b ></label >";
            echo "<input type = 'text' placeholder='Enter player name' >";
            echo "</div>";
            $y++;
        }
        ?>
        <input class="editBtn" type="submit" value="edit">
    </div>
</form>
    <form action="loginController.php?id=<?=$id?>" method="post">
        <input type="hidden" name="type" value="delete">

        <input type="submit" class="removeBtn" value="delete">
    </form>

<?= require 'footer.php';