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
<ul>
<?php
foreach ($teams as $team){
    $teamname = $team['name'];
    $teamid = $team['id'];
    echo "<li><a href='admindetail.php?id=$teamid'>$teamname met ID is $teamid</a></li>";
}
?>
    <form action="loginController.php" method="post">
        <input type="button" value="shuffle">
    </form>
</ul>
<?= require 'footer.php';?>
