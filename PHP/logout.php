<?php
/**
 * Created by PhpStorm.
 * User: Bas
 * Date: 16-4-2019
 * Time: 12:43
 */

require 'config.php';
// hier log je uit en destroy je session en ga je weer terug naar de index.php
session_start();
session_destroy();
header('location: index.php');