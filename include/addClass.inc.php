<?php 
session_start();

include_once '../include/config.inc.php';

// Check that user is admin and that forms were submitted
if(isset($_POST['add']) && $_SESSION['u_role']=='admin'){
    $type = 0; # 0: both, 1: even, -1:odd
    
    if(isset($_POST['even'])){
        $type = $type + 1;
    } if(isset($_POST['odd'])){
        $type = $type - 1;
    }
    
    $cl = NULL;
    for($c = 1; $c <= 7; $c++){
        if(isset($_POST["$c"])){
            $cl = $c;
        }
    };
    
    #Query to the user_id based on the username
    $sql = "SELECT user_id FROM users WHERE user_uid='{$_POST['teacher']}'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck == 0){
        $_SESSION['error']='teacher';
        header("Location: ../form/addClass.php"); exit();
    }
    $teacher = mysqli_fetch_assoc($result);

    $period = (int) $_POST['period'];
    
    $d_day = 1;
    $sql = "SELECT * FROM days WHERE date_id = $d_day;";
    $day = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($day);
    $day = mysqli_fetch_assoc($day);

    while($resultCheck != 0){
    
        if(($type == 1) and ($day['date_odd'] == 1)){
            $d_day ++;
            $sql = "SELECT * FROM days WHERE date_id = $d_day;";
            $day = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($day);
            $day = mysqli_fetch_assoc($day);
            echo "{$resultCheck}";
            continue;
        } if(($type == -1) and ($day['date_odd'] == 0)){
            $d_day ++;
            $sql = "SELECT * FROM days WHERE date_id = $d_day;";
            $day = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($day);
            $day = mysqli_fetch_assoc($day);
            echo "{$resultCheck}";
            continue;
        }
        
        $q_reservation = "INSERT INTO reservations(date_id, user_id, period_id, cl_id) VALUES($d_day, {$teacher['user_id']}, $period, $cl);";
        if(mysqli_query($conn, $q_reservation)){
            $d_day ++;
            $sql = "SELECT * FROM days WHERE date_id = $d_day";
            $day = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($day);
            $day = mysqli_fetch_assoc($day);
        } else{
            $_SESSION['error']='misc';
            header('Location: ../form/addClass.php');
            exit();
        }
    }
    
    $_SESSION['error']='success';
    header('Location: ../form/addClass.php');
    exit();
} else{
    header("Location: ../form/addClass.php");
    exit();
}


?>