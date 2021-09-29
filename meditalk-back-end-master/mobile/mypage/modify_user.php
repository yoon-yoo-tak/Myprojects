<?php
        $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
        $user_id = mysqli_real_escape_string($con,$_POST['user_id']);
        $user_email = mysqli_real_escape_string($con,$_POST['user_email']);
        $user_phone = mysqli_real_escape_string($con,$_POST['user_phone']);
        $user_addr = mysqli_real_escape_string($con,$_POST['user_addr']);

        $query = "UPDATE User SET user_email='$user_email' WHERE user_id='$user_id'";
        $result = mysqli_query($con,$query);
        $arr = array();
        header('Content-Type: application/json');
        if($result){
            $arr['success'] = true;
            $arr['user_email'] = $user_email;
            
        }else{
            $arr['success'] = false;
        }
        echo json_encode($arr);


  ?>
 