<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 18-4-2019
 * Time: 09:51
 */
require 'config.php';
if ()
$sql = "SELECT * FROM teams";
$query =$db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');

echo json_encode($teams);