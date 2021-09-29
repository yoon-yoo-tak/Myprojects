<?php
    $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
    $user_id = mysqli_real_escape_string($con,$_POST['user_id']);
    $c_pw= mysqli_real_escape_string($con,$_POST['c_pw']);
    $n_pw= mysqli_real_escape_string($con,$_POST['n_pw']);
    $select_query = "SELECT * FROM User WHERE user_id='$user_id' AND user_pw='$c_pw'";
    $arr = array();
    header('Content-Type: application/json');
    $select_res = mysqli_query($con,$select_query);
    if(empty(mysqli_fetch_array($select_res))){
        $arr['success'] = false;        

     }else{

        $query = "UPDATE User SET user_pw='$n_pw' WHERE user_id='$user_id'";
        mysqli_query($con,$query);
        $arr['success'] = true;
        

    }
    
    echo json_encode($arr);
?>