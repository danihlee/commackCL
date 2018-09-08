<?php 
session_start();

include_once '../include/config.inc.php';

if(isset($_POST['change-pwd'])){
    // Fetch previous password and user data
    $sql = "SELECT * FROM users WHERE user_id='{$_SESSION['u_id']}'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    if($row['user_pwd'] != $_POST['old'] || $_POST['new']!=$_POST['confirm']){
        // Check that New Password Matches and Old Password Matches
        $_SESSION['error'] = "Not Match";
        header("Location: ../form/settings.php?pwd=error");
        exit();
    } else{
        // Update information once confirmation received
        $sql = "UPDATE users SET user_pwd = '{$_POST['new']}' WHERE user_id='{$_SESSION['u_id']}';";
        
        if(mysqli_query($conn, $sql)){
            echo "Settings updated successfully";
            $_SESSION['error'] = "Success";
        } else {
            echo "ERROR: Settings failed to update";
        }
    }
header("Location: ../form/settings.php");
exit();
}
?>