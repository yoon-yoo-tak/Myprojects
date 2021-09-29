<?php
    $id = $_POST['user_id'];
    $pw = $_POST['user_pw'];

    $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");

    $query = "SELECT * FROM User WHERE user_id='$id' AND user_pw='$pw'";
    $result = mysqli_query($con,$query);
    header('Content-type: application/json');
   $arr = array();
   $row = mysqli_fetch_array($result);
   if(empty($row)){
       $arr['success'] = false;
        
    }else{
       $arr['success'] = true;
       $arr['user_name'] = $row['user_name'];
       $arr['user_email'] = $row['user_email'];
       $arr['user_phone']= $row['user_phone'];
       $arr['user_addr']  = $row['user_addr'];	
    }
   echo json_encode($arr);


?>