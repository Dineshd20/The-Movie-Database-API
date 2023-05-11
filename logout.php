<?php
session_start();
if (isset($_SESSION["User_id"]) && isset($_SESSION["User_name"]))
{
    unset($_SESSION["User_id"]);
   unset($_SESSION["User_name"]);


    session_destroy();
    header("Location: login.php");
   die;
}else{
    header("Location: Main.html");
    
}