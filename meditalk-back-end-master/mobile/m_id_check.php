<?php
$con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");

$user_id = $_GET['user_id'];

$query = "SELECT * FROM User WHERE user_id='$user_id'";
$result = mysqli_query($con,$query);
$result_arr = mysqli_fetch_array($result);
$arr = array();
header('Content-Type: application/json');
if(empty($result_arr)){
     $arr['success'] = 1;
     echo json_encode($arr);
}else{

     $arr['success'] = 0;
     echo json_encode($arr);

}


?>