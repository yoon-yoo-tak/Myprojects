<?php
    $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
    session_start();    
    $hp_id = $_SESSION['user_id'];
    $mon_s_time = mysqli_real_escape_string($con, $_POST['mon_s_time']);
    $mon_e_time = mysqli_real_escape_string($con, $_POST['mon_e_time']);
    $tue_s_time = mysqli_real_escape_string($con, $_POST['tue_s_time']);
    $tue_e_time = mysqli_real_escape_string($con, $_POST['tue_e_time']);
    $wed_s_time = mysqli_real_escape_string($con, $_POST['wed_s_time']);
    $wed_e_time = mysqli_real_escape_string($con, $_POST['wed_e_time']);
    $thu_s_time = mysqli_real_escape_string($con, $_POST['thu_s_time']);
    $thu_e_time = mysqli_real_escape_string($con, $_POST['thu_e_time']);
    $fri_s_time = mysqli_real_escape_string($con, $_POST['fri_s_time']);
    $fri_e_time = mysqli_real_escape_string($con, $_POST['fri_e_time']);
    $sta_s_time = mysqli_real_escape_string($con, $_POST['sta_s_time']);
    $sta_e_time = mysqli_real_escape_string($con, $_POST['sta_e_time']);
    $lunch_s_time = mysqli_real_escape_string($con, $_POST['lunch_s_time']);
    $lunch_e_time = mysqli_real_escape_string($con, $_POST['lunch_e_time']);
    $care_gap = mysqli_real_escape_string($con, $_POST['care_gap']);

    $query = "INSERT INTO OfficeHours VALUES(
                                             '$hp_id',
                                             '$mon_s_time',
                                             '$mon_e_time',
                                             '$tue_s_time',
                                             '$tue_e_time',
                                             '$wed_s_time',
                                             '$wed_e_time',
                                             '$thu_s_time',
                                             '$thu_e_time',
                                             '$fri_s_time',
                                             '$fri_e_time',
                                             '$sta_s_time',
                                             '$sta_e_time',
                                             '$lunch_s_time',
                                             '$lunch_e_time',
                                             '$care_gap'
                                            )";
    $result = mysqli_query($con,$query);  
    if($result){
        echo "<script>alert(success)</script>";
        header("Location:/main.php");
    }else{
        echo "<script>alert(".mysqli_error($con).")</script>";
    }                                      
    
?>