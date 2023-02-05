<?php
include "./dbconn.php";

$query = "SELECT * FROM users";
$dataSQL = mysqli_query($db, $query) or die(mysqli_error($db));

$user_data = $dataSQL->fetch_all(MYSQLI_ASSOC);

foreach ($user_data as $user) {
    $hash = password_hash($user["pass_org"], PASSWORD_DEFAULT);
    $id = $user["id_user"];
    $query = "UPDATE users SET pass = '$hash' WHERE id_user='$id'";
    $dataSQL = mysqli_query($db, $query) or die(mysqli_error($db));
}

if ($dataSQL) {
    echo "ok";
}