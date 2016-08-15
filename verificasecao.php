<?php
session_start();

if(!isset($_SESSION["id_peladeiro"])){
    header("Location: index.php");
    exit;
}
