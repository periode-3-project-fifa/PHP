<?php
/**
 * Created by PhpStorm.
 * User: Bas
 * Date: 15-4-2019
 * Time: 11:03
 */
// connect naar de database
$dbHost = 'localhost';
$dbName = 'fifa';
$dbUser = 'root';
$dbPass = '';

$db = new PDO(
    "mysql:host=$dbHost;dbname=$dbName",
    $dbUser,
    $dbPass
);
// hier vang die de error op 
$db->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);

if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    // session is niet gestard
    session_start();
}
