<?php 
session_start();

include_once '../include/config.inc.php';

// Check that user is admin and that forms were submitted
if(isset($_POST['add']) && $_SESSION['u_role']=='admin'){
    if($_POST['role']=="admin"){
        $role = 1; 
    } else{
        $role = 2;
    }
    // Add User
    $sql = "INSERT INTO users (user_first, user_last, user_uid, user_pwd, user_email) VALUES ('{$_POST['first']}', '{$_POST['last']}', '{$_POST['uid']}', '{$_POST['pwd']}', '{$_POST['email']}');";
    if(mysqli_query($conn, $sql)){
        echo "Successfully Added";
    } else{
        echo "ERROR: User not added";
        exit();
    }

    // Link to user_roles
    $sql = "INSERT INTO user_roles(user_id, role_id) VALUES (LAST_INSERT_ID(), $role);";
    if(mysqli_query($conn, $sql)){
        echo "Successfully Linked";
    } else{
        echo "ERROR: User not linked";
        exit();
    }
    $_SESSION['error']='success';
    header('Location: ../form/addUser.php');
    exit();
} else{
    header("Location: ../form/addUser.php");
    exit();
}


?>