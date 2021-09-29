<?php 
    $con = mysqli_connect("localhost", "meditalk", "huiyih135!", "meditalk");


    $user_id = $_POST["user_id"];
    $user_pw = $_POST["user_pw"];
    $user_name = $_POST["user_name"];
    $user_age = $_POST["user_age"];
    $user_email = $_POST["user_email"];
    $user_phone = $_POST["user_phone"];
    $user_gender = $_POST["user_gender"];
    $user_addr = $_POST["user_addr"];

   $query = "INSERT INTO User VALUES('$user_id',
				  '$user_pw',
				  '$user_email',
				  '$user_name',
				  )";

$arr = array();
$result = mysqli_query($con,$query);
if($result){
	echo "<script> window.android.success();</script>";
}else{
  echo "<script> window.android.fail();</script>";
  header('Location:/mobile/m_register.html');
   
}


  


?>