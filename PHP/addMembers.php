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
$sql = "SELECT * FROM teams WHERE id = :id";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);
echo "<ul>";
foreach ($teams as $team) {
    echo '<li>' . $team['name'] . '</li>';
};
echo "</ul>";
$team['name'];