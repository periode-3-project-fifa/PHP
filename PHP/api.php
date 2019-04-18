<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 18-4-2019
 * Time: 09:51
 */
require 'config.php';
$sql = "SELECT * FROM teams";
$query =$db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);

('Content-Type: application/json');
$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);

echo json_encode($arr);