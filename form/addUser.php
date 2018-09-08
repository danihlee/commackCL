<?php
session_start();

include_once '../include/config.inc.php';

if($_SESSION['u_role']!='admin'){
    echo "ERROR: User does not have permission to access this page";
    exit();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Commack Computer Lab Login</title>
    <style type="text/css">
        
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        
    </style>
</head>

<body>
    
    <h1>Commack Computer Lab</h1>
    <h2>Add New Users</h2>
    
    <!- Form to Add User ->
    <form action="../include/addUser.inc.php" method="POST">
    <div>
            <span style="width:100px;display:inline-block;">First Name:</span>
            <input type="text" name='first'><br>
            <span style="width:100px;display:inline-block;">Last Name:</span>
            <input type="text" name='last'><br>
            <span style="width:100px;display:inline-block;">Email:</span>
            <input type="text" name='email'><br>
            <span style="width:100px;display:inline-block;">Username:</span>
            <input type="text" name='uid'><br>
            <span style="width:100px;display:inline-block;">Password:</span>
            <input type="text" name='pwd'><br>
            <span style="width:100px;display:inline-block;"><b>Role of User?</b></span> <br>
            <span style="width:85px;display:inline-block;">Basic User:</span>
            <input type="radio" id="roleChoice1" name='role' value="user"/>
            <span style="width:60px;display:inline-block;">Admin:</span>
            <input type="radio" id="roleChoice2" name='role' value="admin"/> <br>
        
            <!- Confirm that information within the form is correct ->
            <button class="button" name="add" onclick="return confirm('Are you sure you want to add the user? Once added, a user cannot be destroyed!');">Add User</button> 
    </div> 
    </form>
    
    <form action="../index.php">
        <button class="button">Return to Home</button> 
    </form>
    
    <!- Confirm Success of the Insertion ->
    <font color="red"><?php if(isset($_SESSION['error']) && $_SESSION['error'] == "success"){echo "User Added Successfully!"; unset($_SESSION['error']);}?></font>
</body>    