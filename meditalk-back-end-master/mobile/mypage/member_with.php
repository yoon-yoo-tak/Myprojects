<?php
    $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");

    $id = mysqli_real_escape_string($con,$_POST['id']);
    $pw = mysqli_real_escape_string($con,$_POST['pw']);

    $select_query = "SELECT FROM User WHERE user_id='$id' AND user_pw='$pw'";
    $arr = array();
    header('Content-Type: application/json');
    if(empty(mysqli_fetch_array(mysqli_query($con,$select_query))){
        $arr['success'] = false;
    }else{
        $arr['success'] = true;
        $query = "DELETE FROM User WHERE user_id='$id'";
        mysqli_query($con,$query);
    }
    echo json_encode($arr);

?>