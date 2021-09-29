<?php
    $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");

    $query = "INSERT INTO Hospital values(
                '$_POST[user_id]',
                '$_POST[user_pw]',
                '$_POST[hospital_name]',
                '$_POST[user_name]',
                '$_POST[user_email]',
                '$_POST[user_phone]',
                '$_POST[hospital_addr]',
	    '$_POST[hp_lat]',
 	    '$_POST[hp_lng]'
             
            )";
    $result = mysqli_query($con,$query);

    
    if($result == false){
        echo "<script>alert(".mysqli_error($con).")</script>";
    }else{
      echo "<script>alert('success')</script>";
   }

?>