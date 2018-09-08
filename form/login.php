<?php 
session_start();

include_once '../include/config.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Commack Computer Lab Login</title>
    <style type="text/css">
        
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        
    </style>
</head>
    
<h1>Commack Computer Lab Login</h1>

<section class="container">
    <div class="wrapper">
        <h2>Enter User Credentials</h2>
        <form class="login-form" action="../include/login.inc.php" method="POST">
            <input type="text"      name="uid"          placeholder="Teacher username">
            <input type="password"  name="pwd"          placeholder="Password">
            <button type="submit"   name="login-submit">Login</button>
        </form>
    </div>
</section>
    
<!- Error Message if Password or Username is incorrect->
<font color="red"><?php if(isset($_SESSION['error']) && $_SESSION['error'] == "incorrect"){echo "Incorrect Password/Username"; unset($_SESSION['error']);}?></font>
</html>