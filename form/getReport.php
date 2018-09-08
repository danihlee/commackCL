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
    <h2>Get Reports</h2>
    
    <form class="report-form" action="../include/getReport.inc.php" method="POST">
            <input type="text"      name="teacher"          placeholder="Input Teacher usernames">
    </form>
    
    
    
    <button class="button" name="help" onclick="List teachers with spaces between usernames (ex: ebiagi rsuchopar kdow bgerson lboritz)">Help</button> 
    
</body>    
</html>