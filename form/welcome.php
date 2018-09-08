<?php 
session_start();

include_once '../include/config.inc.php';

?>

<!DOCTYPE HTML>
<head>
    <meta charset="UTF-8">
    
    <title>Commack Computer Lab Login</title>
    <style type="text/css">
        
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        
    </style>
</head>

<html lang = "en">
    <head>
        <title>main.html</title>
        <meta charset = "UTF-8" />
    </head>
    <body>
        <h1>Commack Computer Lab Systems</h1>
        <h2>Welcome <?php echo "{$_SESSION['u_first']} {$_SESSION['u_last']}"; ?></h2>
        
        <!- Menu of User Action Options ->
        <a href='reservation.php'>Make a Reservation</a> <br>
        <a href='settings.php'>Edit Account Details</a> <br>
        <a href='admin.php'
           <?php if($_SESSION['u_role']!='admin'){echo "style=display:none;";}?>> 
            Admin Settings <br>
        </a>
        
        <form class="logout-form" action="../include/logout.inc.php" method="POST">
            <button type="submit" name="logout-submit">Logout</button>
        </form>
    </body>
</html>