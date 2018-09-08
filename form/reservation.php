<?php 

session_start();

include_once '../include/config.inc.php';

if(!isset($_SESSION['u_uid'])){
    session_destroy();
    header("Location: ../index.php");
    exit();
}

if(!isset($_SESSION['d_id'])){
    $_SESSION['d_id'] =1;
}
// echo $_SESSION['d_id']; //Debugging Point

// Helper functions
function dbCheckDateID($d_id, $conn){
    // Check if Day with id exists
    $sql = "SELECT * FROM days WHERE date_id=$d_id";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    return $resultCheck > 0;
}

function dbCheckDate($d_year, $d_month, $d_day, $conn){
    // Check if Day with year, month, combination exists
    $sql = "SELECT * FROM days WHERE date_year=$d_year && date_month=$d_month &&                                                date_day=$d_day";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    return $resultCheck > 0;
}

function dbGetDate($d_id, $conn){
    // Return date given by id
    if(dbCheckDateID($d_id, $conn)){
        $sql = "SELECT * FROM days WHERE date_id=$d_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row['date_odd'] % 2 == 0){
            $type = "EVEN";
        } else{
            $type = "ODD";
        }
        
        $date = $type . " Day " .
                $row['date_month'] . "/" . $row['date_day'] . "/" . $row['date_year'];
        return $date;
    } else{
        return "";
    }
}

function checkReservation($d_id, $period, $cl_id, $conn){
    // Check if there is a reservation 
    $sql = "SELECT * FROM reservations WHERE date_id=$d_id && period_id=$period && cl_id=$cl_id";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck < 1){
        return 0;
    }
    // Return username of user associated with reservation
    $row = mysqli_fetch_assoc($result);
    $sql = "SELECT * FROM users WHERE user_id={$row['user_id']}";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['user_uid'];
}
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
    
    <body>
        <h1>Commack Computer Lab System</h1>
        <!- Teacher Name ->
        <h2>Welcome <?php echo "{$_SESSION['u_first']} {$_SESSION['u_last']}"?></h2>
        <!- Date and Type info ->
        <h2> <?php echo dbGetDate($_SESSION['d_id'], $conn); ?> </h2>
        
        <!- Change Date ->
        <form action="../include/setDate.inc.php" method="POST">
        <div>
            <span style="width:100px;display:inline-block;">Year:</span>
            <input type="text" name='year'><br>
            <span style="width:100px;display:inline-block;">Month (1-12):</span>
            <input type="text" name='month'><br>
            <span style="width:100px;display:inline-block;">Day:</span>
            <input type="text" name='day'><br>
            <button class="button" name="cust-day">Custom Day</button> 
        </div>    
        <div>
            <button class="button" name="prev-day">Previous Day</button> 
            <button class="button" name="next-day">Next Day</button> 
        </div>
        </form>
        
        <!- Submit Reservations ->
        <form action="../include/reservation.inc.php" method="POST">
        <div>
            <!- Special Admin Priveledge to make reservations for other users -> 
            <span <?php if($_SESSION['u_role']!='admin'){echo "style=display:none;";} else{echo "style=width:100px;display:inline-block;";}?>>Teacher:</span>
            <input type="text" name='teacher' <?php if($_SESSION['u_role']!='admin'){echo "style=display:none;";}?>>
            <br>
        </div>
            
        <!- Error Message ->
        <font color="red"><?php if(isset($_SESSION['error']) && $_SESSION['error'] == "Teacher Not Found"){echo $_SESSION['error']; unset($_SESSION['error']);}?></font>
        
        <!- Checkbox Form Array ->
        <div>
            <span style="width:70px;display:inline-block;">Period 1</span>
            <input type='checkbox' name='1.1' value='1.1' 
            <?php 
                   // For each checkbox check if user is admin and if reservation exists
                   $u_id = checkReservation($_SESSION['d_id'], 1, 1, $conn); 
                   if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] &&                     $_SESSION['u_role']!='admin'){
                       echo "disabled";
                   }
            ?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL1';}?> </span>
            
            <input type='checkbox' name='1.2' value='1.2' <?php $u_id = checkReservation($_SESSION['d_id'], 1, 2, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL2';}?></span>
            
            <input type='checkbox' name='1.3' value='1.3' <?php $u_id = checkReservation($_SESSION['d_id'], 1, 3, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL3';}?></span>
            
            <input type='checkbox' name='1.4' value='1.4' <?php $u_id = checkReservation($_SESSION['d_id'], 1, 4, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL4';}?></span>
            
            <input type='checkbox' name='1.5' value='1.5' <?php $u_id = checkReservation($_SESSION['d_id'], 1, 5, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL5';}?></span>
            
            <input type='checkbox' name='1.6' value='1.6' <?php $u_id = checkReservation($_SESSION['d_id'], 1, 6, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL6';}?></span>
            
            <input type='checkbox' name='1.7' value='1.7' <?php $u_id = checkReservation($_SESSION['d_id'], 1, 7, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'Lib';}?></span>
        </div>     

        <div>
            <span style="width:70px;display:inline-block;">Period 2</span>
            <input type='checkbox' name='2.1' value='2.1' <?php $u_id = checkReservation($_SESSION['d_id'], 2, 1, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"> <?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL1';}?></span>
            
            <input type="checkbox" name='2.2' value='2.2' <?php $u_id = checkReservation($_SESSION['d_id'], 2, 2, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL2';}?></span>
            
            <input type='checkbox' name='2.3' value='2.3' <?php $u_id = checkReservation($_SESSION['d_id'], 2, 3, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL3';}?></span>
            
            <input type="checkbox" name='2.4' value='2.4' <?php $u_id = checkReservation($_SESSION['d_id'], 2, 4, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL4';}?></span>
            
            <input type='checkbox' name='2.5' value='2.5' <?php $u_id = checkReservation($_SESSION['d_id'], 2, 5, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL5';}?></span>
            
            <input type='checkbox' name='2.6' value='2.6' <?php $u_id = checkReservation($_SESSION['d_id'], 2, 6, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL6';}?></span>
            
            <input type='checkbox' name='2.7' value='2.7' <?php $u_id = checkReservation($_SESSION['d_id'], 2, 7, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'Lib';}?></span>
        </div>      

        <div>
            <span style="width:70px;display:inline-block;">Period 3</span>
            <input type='checkbox' name='3.1' value='3.1' <?php $u_id = checkReservation($_SESSION['d_id'], 3, 1, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL1';}?></span>
            
            <input type="checkbox" name='3.2' value='3.2' <?php $u_id = checkReservation($_SESSION['d_id'], 3, 2, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL2';}?></span>
            
            <input type='checkbox' name='3.3' value='3.3' <?php $u_id = checkReservation($_SESSION['d_id'], 3, 3, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL3';}?></span>
            
            <input type="checkbox" name='3.4' value='3.4' <?php $u_id = checkReservation($_SESSION['d_id'], 3, 4, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL4';}?></span>
            
            <input type='checkbox' name='3.5' value='3.5' <?php $u_id = checkReservation($_SESSION['d_id'], 3, 5, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL5';}?></span>
            
            <input type='checkbox' name='3.6' value='3.6' <?php $u_id = checkReservation($_SESSION['d_id'], 3, 6, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL6';}?></span>
            
            <input type='checkbox' name='3.7' value='3.7' <?php $u_id = checkReservation($_SESSION['d_id'], 3, 7, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'Lib';}?></span>
        </div>      

        <div>
            <span style="width:70px;display:inline-block;">Period 4</span>
            <input type='checkbox' name='4.1' value='4.1' <?php $u_id = checkReservation($_SESSION['d_id'], 4, 1, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL1';}?></span>
            
            <input type="checkbox" name='4.2' value='4.2' <?php $u_id = checkReservation($_SESSION['d_id'], 4, 2, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL2';}?></span>
            
            <input type='checkbox' name='4.3' value='4.3' <?php $u_id = checkReservation($_SESSION['d_id'], 4, 3, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL3';}?></span>
            
            <input type="checkbox" name='4.4' value='4.4' <?php $u_id = checkReservation($_SESSION['d_id'], 4, 4, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL4';}?></span>
            
            <input type='checkbox' name='4.5' value='4.5' <?php $u_id = checkReservation($_SESSION['d_id'], 4, 5, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL5';}?></span>
            
            <input type='checkbox' name='4.6' value='4.6' <?php $u_id = checkReservation($_SESSION['d_id'], 4, 6, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL6';}?></span>
            
            <input type='checkbox' name='4.7' value='4.7' <?php $u_id = checkReservation($_SESSION['d_id'], 4, 7, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'Lib';}?></span>
        </div>      

        <div>
            <span style="width:70px;display:inline-block;">Period 5</span>
            <input type='checkbox' name='5.1' value='5.1' <?php $u_id = checkReservation($_SESSION['d_id'], 5, 1, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL1';}?></span>
            
            <input type="checkbox" name='5.2' value='5.2' <?php $u_id = checkReservation($_SESSION['d_id'], 5, 2, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL2';}?></span>
            
            <input type='checkbox' name='5.3' value='5.3' <?php $u_id = checkReservation($_SESSION['d_id'], 5, 3, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL3';}?></span>
            
            <input type="checkbox" name='5.4' value='5.4' <?php $u_id = checkReservation($_SESSION['d_id'], 5, 4, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL4';}?></span>
            
            <input type='checkbox' name='5.5' value='5.5' <?php $u_id = checkReservation($_SESSION['d_id'], 5, 5, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL5';}?></span>
            
            <input type='checkbox' name='5.6' value='5.6' <?php $u_id = checkReservation($_SESSION['d_id'], 5, 6, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL6';}?></span>
            
            <input type='checkbox' name='5.7' value='5.7' <?php $u_id = checkReservation($_SESSION['d_id'], 5, 7, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'Lib';}?></span>
        </div>      

        <div>
            <span style="width:70px;display:inline-block;">Period 6</span>
            <input type='checkbox' name='6.1' value='6.1' <?php $u_id = checkReservation($_SESSION['d_id'], 6, 1, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL1';}?></span>
            
            <input type="checkbox" name='6.2' value='6.2' <?php $u_id = checkReservation($_SESSION['d_id'], 6, 2, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL2';}?></span>
            
            <input type='checkbox' name='6.3' value='6.3' <?php $u_id = checkReservation($_SESSION['d_id'], 6, 3, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL3';}?></span>
            
            <input type="checkbox" name='6.4' value='6.4' <?php $u_id = checkReservation($_SESSION['d_id'], 6, 4, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL4';}?></span>
            
            <input type='checkbox' name='6.5' value='6.5' <?php $u_id = checkReservation($_SESSION['d_id'], 6, 5, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL5';}?></span>
            
            <input type='checkbox' name='6.6' value='6.6' <?php $u_id = checkReservation($_SESSION['d_id'], 6, 6, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL6';}?></span>
            
            <input type='checkbox' name='6.7' value='6.7' <?php $u_id = checkReservation($_SESSION['d_id'], 6, 7, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'Lib';}?></span>
        </div>     
        
        <div>
            <span style="width:70px;display:inline-block;">Period 7</span>
            <input type='checkbox' name='7.1' value='7.1' <?php $u_id = checkReservation($_SESSION['d_id'], 7, 1, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL1';}?></span>
            
            <input type="checkbox" name='7.2' value='7.2' <?php $u_id = checkReservation($_SESSION['d_id'], 7, 2, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL2';}?></span>
            
            <input type='checkbox' name='7.3' value='7.3' <?php $u_id = checkReservation($_SESSION['d_id'], 7, 3, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL3';}?></span>
            
            <input type="checkbox" name='7.4' value='7.4' <?php $u_id = checkReservation($_SESSION['d_id'], 7, 4, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL4';}?></span>
            
            <input type='checkbox' name='7.5' value='7.5' <?php $u_id = checkReservation($_SESSION['d_id'], 7, 5, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL5';}?></span>
            
            <input type='checkbox' name='7.6' value='7.6' <?php $u_id = checkReservation($_SESSION['d_id'], 7, 6, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL6';}?></span>
            
            <input type='checkbox' name='7.7' value='7.7' <?php $u_id = checkReservation($_SESSION['d_id'], 7, 7, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'Lib';}?></span>
        </div>    

        <div>
            <span style="width:70px;display:inline-block;">Period 8</span>
            <input type='checkbox' name='8.1' value='8.1' <?php $u_id = checkReservation($_SESSION['d_id'], 8, 1, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL1';}?></span>
            
            <input type="checkbox" name='8.2' value='8.2' <?php $u_id = checkReservation($_SESSION['d_id'], 8, 2, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL2';}?></span>
            
            <input type='checkbox' name='8.3' value='8.3' <?php $u_id = checkReservation($_SESSION['d_id'], 8, 3, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL3';}?></span>
            
            <input type="checkbox" name='8.4' value='8.4' <?php $u_id = checkReservation($_SESSION['d_id'], 8, 4, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL4';}?></span>
            
            <input type='checkbox' name='8.5' value='8.5' <?php $u_id = checkReservation($_SESSION['d_id'], 8, 5, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL5';}?></span>
            
            <input type='checkbox' name='8.6' value='8.6' <?php $u_id = checkReservation($_SESSION['d_id'], 8, 6, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL6';}?></span>
            
            <input type='checkbox' name='8.7' value='8.7' <?php $u_id = checkReservation($_SESSION['d_id'], 8, 7, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'Lib';}?></span>
        </div>     

        <div>
            <span style="width:70px;display:inline-block;">Period 9</span>
            <input type='checkbox' name='9.1' value='9.1' <?php $u_id = checkReservation($_SESSION['d_id'], 9, 1, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL1';}?></span>
            
            <input type="checkbox" name='9.2' value='9.2' <?php $u_id = checkReservation($_SESSION['d_id'], 9, 2, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL2';}?></span>
            
            <input type='checkbox' name='9.3' value='9.3' <?php $u_id = checkReservation($_SESSION['d_id'], 9, 3, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL3';}?></span>
            
            <input type="checkbox" name='9.4' value='9.4' <?php $u_id = checkReservation($_SESSION['d_id'], 9, 4, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL4';}?></span>
            
            <input type='checkbox' name='9.5' value='9.5' <?php $u_id = checkReservation($_SESSION['d_id'], 9, 5, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL5';}?></span>
            
            <input type='checkbox' name='9.6' value='9.6' <?php $u_id = checkReservation($_SESSION['d_id'], 9, 6, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'CL6';}?></span>
            
            <input type='checkbox' name='9.7' value='9.7' <?php $u_id = checkReservation($_SESSION['d_id'], 9, 7, $conn); if(!is_int($u_id) && $u_id != $_SESSION['u_uid'] && $_SESSION['u_role']!='admin'){echo "disabled";}?>/>
            <span style="width:40px;display:inline-block;"><?php if(!is_int($u_id)){echo $u_id;} else{echo 'Lib';}?></span>
        </div> 
            <button class="button" name='submit'>Submit Reservations</button> 
            <button class="button" name='delete'>Delete Reservations</button> 
        </form>
        
        <form action="../index.php">
        <button class="button">Return to Home</button> 
        </form>
    </body>
</html>