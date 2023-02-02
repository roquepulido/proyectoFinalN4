<?php session_start();

if (!isset($_SESSION["login"])) {
    header("Location:./views/login.php");
}