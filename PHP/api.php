<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 18-4-2019
 * Time: 09:51
 */
require 'config.php';

$key = 'hardcodedkey1234';
    

if($_GET['key'] == $key)
{
    $sql = "SELECT poules.id AS id, teams_a.name AS home, teams_b.name AS away, poules.homescore AS homescore, poules.awayscore AS awayscore FROM `poules`
INNER JOIN teams as teams_a 
ON teams_a.id = poules.home
INNER JOIN teams as teams_b
ON teams_b.id = poules.away";

        $query = $db->query($sql);
        $poules = $query->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');

        echo json_encode($poules);
}