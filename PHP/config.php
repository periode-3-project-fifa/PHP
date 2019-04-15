<?php
/**
 * Created by PhpStorm.
 * User: Bas
 * Date: 15-4-2019
 * Time: 11:03
 */

$dbHost = 'localhost';
$dbName = 'fifa';
$dbUser = 'root';
$dbPass = '';

$db = new PDO(
    "mysql:host=$dbHost;dbname=$dbName",
    $dbUser,
    $dbPass
);

$db->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);