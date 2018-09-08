<?php 

session_start();

require_once 'config.inc.php';

if(isset($_POST['submit'])){
// Submission of reservations    
    
// Check if user is admin
if($_POST['teacher'] == ''){
    $u_res = $_SESSION['u_id'];
} else {
    $sql = "SELECT * FROM users WHERE user_uid='{$_POST['teacher']}'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck == 0) {
        echo "ERROR: Teacher not found";
        $_SESSION['error'] = "Teacher Not Found";
        header("Location: ../form/reservation.php?user=error");
        exit();
    }
    $row = mysqli_fetch_assoc($result);
    $u_res = $row['user_id'];
}

for($p = 1; $p <= 9; $p++) {
    for($c = 1; $c <= 7; $c++){
        // Go through checkbox TODO: Add unable to book multiple lab per period            
        if(isset($_POST["{$p}_{$c}"])){
            $sql = "SELECT * FROM reservations WHERE date_id={$_SESSION['d_id']} && period_id=$p && cl_id=$c";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            // Check if reservation not already made
            if ($resultCheck == 0){
                $sql = "INSERT INTO reservations (date_id, user_id , period_id, cl_id)
                        VALUES ({$_SESSION['d_id']}, $u_res, $p, $c)";
                if(mysqli_query($conn, $sql)){
                // For debugging purpose only
                    echo "Records inserted successfully.$p.$c ";
                } else{
                    echo "ERROR: Could not able to execute insertion";
                }
            } else{
                echo "ERROR: Reservation already exists";
            }
            
        }
    }
}
header("Location: ../form/reservation.php");
exit();
    
} elseif(isset($_POST['delete'])){
// Deleting Reservations
for($p = 1; $p <= 9; $p++) {
    for($c = 1; $c <= 7; $c++){
        // Go through checkbox TODO: Add unable to book multiple lab per period            
        if(isset($_POST["{$p}_{$c}"])){
            echo "Pass";
            // Check if reservation exists
            $sql = "DELETE FROM reservations WHERE date_id={$_SESSION['d_id']} && period_id=$p && cl_id=$c";
            if(mysqli_query($conn, $sql)){
                // For debugging purpose only
                echo "Records deleted successfully.$p.$c ";
            } else{
                echo "ERROR: Could not able to execute deletion";
            }
        }
    }
}
header("Location: ../form/reservation.php");
exit();
}
?>