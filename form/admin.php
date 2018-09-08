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
    <h2>Admin Settings</h2>
    <a href='addUser.php'>Add New Users</a> <br>
    <a href='addDay.php'>Add New Day</a> <br>
    <a href='addClass.php'>Add New Class</a> <br>
    <a href='getReport.php'>Get Report</a> <br>
    <a href='settings.php'></a> <br>
    
</body>    
</html>