<?php 

session_start();

include_once '../include/config.inc.php';

?>

<html lang = "en">
    <head>
    <meta charset="UTF-8">
    
    <title>Commack Computer Lab Login</title>
    <style type="text/css">
        
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        
    </style>
    </head>
    
    <h1>Commack Computer Lab System</h1>
    <!- Teacher Name ->
    <h2>Settings for <?php echo "{$_SESSION['u_first']} {$_SESSION['u_last']}"?></h2>
    
    <form action="../include/settings.inc.php" method="POST">
        <section>
        <div>
            <h2>Change Password</h2>
            <span style="width:100px;display:inline-block;">Old Password:</span>
            <input type="password" name='old'><br>
            <span style="width:100px;display:inline-block;">New Password:</span>
            <input type="password" name='new'><br>
            <span style="width:100px;display:inline-block;">Confirm Pass:</span>
            <input type="password" name='confirm'><br>
            <button class="button" name="change-pwd">Change Password</button> 
        </div> 
        </section>
        
        <!- If previously submitted the form display error/success message ->
        <font color="red"><?php if(isset($_SESSION['error']) && $_SESSION['error'] == "Not Match"){echo "Passwords do not match"; unset($_SESSION['error']);} elseif(isset($_SESSION['error']) && $_SESSION['error'] == "Success"){echo "Password Successfully Updated"; unset($_SESSION['error']);}?></font>
    </form>
    
    <form action="../index.php">
    <button class="button">Return to Home</button> 
    </form>
</html>