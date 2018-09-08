<?php
session_start();

include_once '../include/config.inc.php';

if($_SESSION['u_role']!='admin'){
    echo "ERROR: User does not have permission to access this page";
    header("Location: ../index.php");
    exit();
}

if(!isset($_SESSION['u_uid'])){
    header("Location: ../index.php");
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
    <h2>Add Class</h2>
    
    <!- Form to Add User ->
    <form action="../include/addClass.inc.php" method="POST">
    <div>
        <span style="width:100px;display:inline-block;">Teacher username:</span>
        <input type="text" name='teacher'><br>
        <span style="width:100px;display:inline-block;">Period:</span>
        <input type="text" name='period'><br>
        
        <span style="width:100px;display:inline-block;">Type:</span>
        <div>
            <input type='checkbox' name='even' value='even'><span style="width:40px;display:inline-block;">Even</span> 
            <input type='checkbox' name='odd' value='odd'><span style="width:40px;display:inline-block;">Odd</span> 
        </div>
        
        
        <span style="width:100px;display:inline-block;">Computer Lab:</span>
        <div>
            <input type='checkbox' name='1' value=1><span style="width:40px;display:inline-block;">CL1</span> 
            <input type='checkbox' name='2' value=2><span style="width:40px;display:inline-block;">CL2</span> 
            <input type='checkbox' name='3' value=3><span style="width:40px;display:inline-block;">CL3</span> 
            <input type='checkbox' name='4' value=4><span style="width:40px;display:inline-block;">CL4</span> 
            <input type='checkbox' name='5' value=5><span style="width:40px;display:inline-block;">CL5</span> 
            <input type='checkbox' name='6' value=6><span style="width:40px;display:inline-block;">CL6</span> 
            <input type='checkbox' name='7' value=7><span style="width:40px;display:inline-block;">Lib</span> 
        </div>
        
        
        <!- Confirm that information within the form is correct ->
        <button class="button" name="add" onclick="return confirm('Are you sure you want to add the day? Once added, a day cannot be destroyed!');">Add Day</button> 
    </div> 
    </form>
    
    <form action="../index.php">
        <button class="button">Return to Home</button> 
    </form>
    
    <!- Confirm Success of the Insertion ->
    <font color="red"><?php if(isset($_SESSION['error']) && $_SESSION['error'] == "success"){echo "Class Added Successfully!"; unset($_SESSION['error']);}if(isset($_SESSION['error']) && $_SESSION['error'] == "teacher"){echo "Teacher does not exist";unset($_SESSION['error']);}if(isset($_SESSION['error']) && $_SESSION['error'] == "misc"){echo "Miscellaneous error";unset($_SESSION['error']);}?></font>
</body>  