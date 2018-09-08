<?php 
// Script to change the date on reservation form
session_start();

require_once 'config.inc.php';

// Helper Functions for checking date
function dbCheckDateID($d_id, $conn){
    // Check if Day with id exists
    $sql = "SELECT * FROM days WHERE date_id=$d_id";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    return $resultCheck > 0;
}

function dbCheckDate($d_year, $d_month, $d_day, $conn, $returnID){
    // Check if Day with year, month, combination exists
    $sql = "SELECT * FROM days WHERE date_year=$d_year && date_month=$d_month &&                                                date_day=$d_day";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    
    if($returnID){
        return $row['date_id'];
    }
    return $resultCheck > 0;
}

// Previous Day Button
if(isset($_POST['prev-day'])){
    if(dbCheckDateID($_SESSION['d_id']-1, $conn)){
        $_SESSION['d_id'] -= 1;
        header("Location: ../form/reservation.php");
        exit();
    } else{
        header("Location: ../form/reservation.php?date=error");
        exit();
    }
} 
// Next Day Button
elseif(isset($_POST['next-day'])){
    if(dbCheckDateID($_SESSION['d_id']+1, $conn)){
        $_SESSION['d_id'] += 1;
        header("Location: ../form/reservation.php");
        exit();
    } else{
        header("Location: ../form/reservation.php?date=error");
        exit();
    }
} 

// Custom Day Button
elseif(isset($_POST['cust-day'])){
    if(empty($_POST['year']) || empty($_POST['month']) || empty($_POST)){
        // Check Text Boxes for empty input
        header("Location: ../form/reservation.php?date=error");
        exit();
    } else{
        $year  = (int) ltrim(rtrim($_POST['year']));
        $month = (int) ltrim(rtrim($_POST['month']));
        $day   = (int) ltrim(rtrim($_POST['day']));
        
        if(dbCheckDate($year, $month, $day, $conn, false)){
            $_SESSION['d_id'] = dbCheckDate($year, $month, $day, $conn, true);
            header("Location: ../form/reservation.php");
            exit();
        } else{
            echo "err";
            header("Location: ../form/reservation.php?date=error");
            exit();
        }
    }
} 
?>