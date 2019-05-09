<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 5/9/2019
 * Time: 12:18 PM
 */

if ( $_SERVER['REQUEST_METHOD'] != 'POST'){
    header('location: index.php');
    exit;
}