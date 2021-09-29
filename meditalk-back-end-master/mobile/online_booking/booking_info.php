<?php
  $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
  $user_id = mysqli_real_escape_string($con,$_POST['user_id']);
  
  $query = "SELECT * FROM BookingForm WHERE user_id='$user_id' AND
                                            bf_status=1";

  
  $row = mysqli_fetch_array(mysqli_query($con,$query));                                          
  $query = "SELECT * FROM Hospital WHERE hp_id='$row[hp_id]'";
  $hp_obj = mysqli_fetch_array(mysqli_query($con,$query));
  if(!empty($row)){
    $row['hp_name'] = $hp_obj['hp_name'];
    $row['empty']=false;
  }else{
      $row['empty'] = true;
  }
  
  header('Content-Type: application/json');

  echo json_encode($row);
?>