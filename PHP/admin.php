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

?>
</head>
<body>
<ul>
<?php
foreach ($teams as $team){
    echo "<li><a href='admindetail.php?id={$team['id']}'> {$team['name']}</a> met ID is {$team['id']}</li>";
}
?>
</ul>
<?= require 'footer.php';?>
