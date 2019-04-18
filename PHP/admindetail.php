<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 4/18/2019
 * Time: 9:05 AM
 */

$id = $_GET['id'];
$sql = "SELECT * FROM teams WHERE id = :id";
$prepare = $db->prepare($sql);
$prepare-> execute([
    ':id' => $id
]);
$team = $prepare->fetch(PDO::FETCH_ASSOC);

?>
