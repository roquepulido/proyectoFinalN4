<?php

$host = "php_8_mysql";
$user = "root";
$pass = "pass";
$database = "Uni";
$db = mysqli_connect($host, $user, $pass, $database) or die('MySQL connect failed. ' . mysqli_connect_error());