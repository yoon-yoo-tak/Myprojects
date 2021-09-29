<?php
 
    $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
    $user_id = mysqli_real_escape_string($con,$_POST['user_id']);
    $hp_id = mysqli_real_escape_string($con,$_POST['hp_id']);
    $b_date = mysqli_real_escape_string($con,$_POST['b_date']);
    
    $time_query = "SELECT * FROM OfficeHours WHERE hp_id='$hp_id'";
    $bk_query = "SELECT * FROM BookingForm WHERE hp_id='$hp_id' AND bf_date='$b_date' AND NOT bf_status=0";
    $oh_set = mysqli_fetch_array(mysqli_query($con,$time_query));
    $result =mysqli_query($con,$bk_query);
    $time_arr = array();
    while($row=mysqli_fetch_array($result)){
        array_push($time_arr,$row['bf_time']);
    }
   
    $set = array($oh_set,$time_arr);
    header('Content-Type: application/json');
    echo json_encode($set);
?>