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
    <h2>Add New Days</h2>
    
    <!- Form to Add User ->
    <form action="../include/addDay.inc.php" method="POST">
    <div>
            <span style="width:100px;display:inline-block;">Year:</span>
            <input type="text" name='year'><br>
            <span style="width:100px;display:inline-block;">Month:</span>
            <input type="text" name='month'><br>
            <span style="width:100px;display:inline-block;">Day:</span>
            <input type="text" name='day'><br>
            <span style="width:100px;display:inline-block;"><b>Even or Odd?</b></span> <br>
            <span style="width:85px;display:inline-block;">ODD:</span>
            <input type="radio" id="roleChoice1" name='type' value="odd"/>
            <span style="width:60px;display:inline-block;">EVEN:</span>
            <input type="radio" id="roleChoice2" name='type' value="even"/> <br>
        
            <!- Confirm that information within the form is correct ->
            <button class="button" name="add" onclick="return confirm('Are you sure you want to add the day? Once added, a day cannot be destroyed!');">Add Day</button> 
    </div> 
    </form>
    
    <form action="../index.php">
        <button class="button">Return to Home</button> 
    </form>
    
    <!- Confirm Success of the Insertion ->
    <font color="red"><?php if(isset($_SESSION['error']) && $_SESSION['error'] == "success"){echo "Date Added Successfully!"; unset($_SESSION['error']);}?></font>
</body>  