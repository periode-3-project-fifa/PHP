<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 20-5-2019
 * Time: 09:04
 */
require 'config.php';
$sql = "
SELECT teams.name,poules.round
FROM poules 
INNER join teams ON teams.id = poules.home or teams.id = poules.away";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);

//var_dump();
