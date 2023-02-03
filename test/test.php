<?php
if (isset($_COOKIE["PHPSESSID"])) {
    session_start();
}
var_dump($_POST);
var_dump($_SESSION);
var_dump($_COOKIE);