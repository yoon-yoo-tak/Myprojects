<?php
     $con     = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
     $keyword = mysqli_real_escape_string($con,$_POST['keyword']);
     $pre_obj = mysqli_query($con,"
        SELECT * FROM Prescription WHERE care_item like '%$keyword%'
    ");
    $pre_list = array();
    while($row=mysqli_fetch_array($pre_obj)){
        array_push($pre_list,array($row['id'],$row['care_item']));
    }
    header('Content-Type: application/json');
    echo json_encode($pre_list);

?>