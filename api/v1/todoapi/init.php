<?php
$path = __DIR__;
$classes = $path . '/classes/';
include_once $classes . "DBcontroller.php";
$db = new DBcontroller();
$db->connect();
