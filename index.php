<?php

session_start();

if(isset($_SESSION['u_id'])){
    header("Location: form/welcome.php");
    exit();
} else{
    header("Location: form/login.php");
    exit();
}
?>