<?php
/**
 * Created by PhpStorm.
 * User: Bas
 * Date: 16-4-2019
 * Time: 12:43
 */

require 'config.php';

session_start();
session_destroy();
header('location: index.php');