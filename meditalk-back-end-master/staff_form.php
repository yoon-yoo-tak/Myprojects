<?php
    $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
    
    $cnt =(int) mysqli_real_escape_string($con,$_POST['count']);
    session_start();
    $hp_id = $_SESSION['user_id'];
    for($i=1; $i<=$cnt; $i++){
        $ms_name = mysqli_real_escape_string($con,$_POST['ms_name'.$i]);
        $ms_position = mysqli_real_escape_string($con,$_POST['ms_position'.$i]);
        $query = "INSERT INTO MedicalStaff(hp_id,ms_name,ms_position) VALUES('$hp_id','$ms_name','$ms_position')";
        mysqli_query($con,$query);

    }
    header("Location:/main.php");

?>