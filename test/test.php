<?php
include "../controllers/dbconn.php";

$query = "SELECT * from casa";

$data = mysqli_query($db, $query);
var_dump($data);
// if (isset($_COOKIE["PHPSESSID"])) {
//     session_start();
// }
// var_dump($_POST);
// var_dump($_SESSION);
// var_dump($_COOKIE);