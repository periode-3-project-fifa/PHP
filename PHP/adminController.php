<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 5/9/2019
 * Time: 12:18 PM
 */
require 'config.php';

if ( $_SERVER['REQUEST_METHOD'] != 'POST'){
    header('location: admin.php');
    exit;
}
// hier zet hij de teams in poules
$sql = "INSERT INTO poules (teampoules) VALUES (:teampoules) ORDER BY RAND";
$prepare = $db->prepare($sql);
$prepare->execute([
    ':teampoules' => $teampoules
]);


exit;

