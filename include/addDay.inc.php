<?php 
session_start();

include_once '../include/config.inc.php';

// Check that user is admin and that forms were submitted
if(isset($_POST['add']) && $_SESSION['u_role']=='admin'){
    if($_POST['type']=="even"){
        $type = 0; 
    } else{
        $type = 1;
    }
    // Add User
    $sql = "INSERT INTO days (date_odd, date_year, date_month, date_day) VALUES ('$type', 
    '{$_POST['year']}', '{$_POST['month']}', '{$_POST['day']}');";
    if(mysqli_query($conn, $sql)){
        echo "Successfully Added";
    } else{
        echo "ERROR: Date not added";
        exit();
    }
    
    $_SESSION['error']='success';
    header('Location: ../form/addDay.php');
    exit();
} else{
    header("Location: ../form/addDay.php");
    exit();
}


?>