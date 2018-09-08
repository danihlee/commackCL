<?php

session_start();

if(isset($_POST['login-submit'])){
    
    include_once 'config.inc.php';
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    
    // Check if login creds empty
    if(empty($uid) || empty($pwd)){
        header("Location: ../form/login.php?login=error");
        exit();
    } else{
        // Query to DB to check login
        $sql = "SELECT * FROM users WHERE user_uid='$uid'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck < 1){
            // Check if the username is the db
            $_SESSION['error'] = "incorrect";
            header("Location: ../form/login.php?login=error");
            exit();
        } else{
            if ($row = mysqli_fetch_assoc($result)){
                //De-hash password- Seems unnecessary because no confidential info is stored in DB
                // $hashedPwd = password_verify($pwd, $row['user_pwd']);
                $hashedPwd = ($pwd == $row['user_pwd']);
                if($hashedPwd == false){
                    $_SESSION['error'] = "incorrect";
                    header("Location: ../form/login.php?login=error");
                    exit();
                } elseif($hashedPwd == true) {
                    //Log in the user
                    $_SESSION['u_id']    = $row['user_id'];
                    $_SESSION['u_first'] = $row['user_first'];
                    $_SESSION['u_last']  = $row['user_last'];
                    $_SESSION['u_email'] = $row['user_email'];
                    $_SESSION['u_uid']   = $row['user_uid'];
                    
                    // Query to DB to role association table
                    $sql = "SELECT user_roles.role_id
                            FROM user_roles WHERE user_roles.user_id={$_SESSION['u_id']}";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    // Query to DB to role table
                    echo $row[$field];
                    $sql = "SELECT roles.role_name
                            FROM roles WHERE roles.role_id={$row['role_id']}";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    
                    $_SESSION['u_role']    = $row['role_name'];
                    header("Location: ../index.php");
                    exit();
                }
            }
        }
    }
} else{
    header("Location: ../form/login.php?login=error");
    exit();
}
?>