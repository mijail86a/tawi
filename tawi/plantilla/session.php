<?php
    session_start();
    if(!isset($_SESSION["id"]) || empty($_SESSION["id"])){
        header('Location: index.php');
    }
    include_once '../lib/followme.lib.php';
    $datos = new lib_follow();
    $id = $_SESSION["id"];
    $datos->id = $id;