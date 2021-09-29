<?php
    $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
    $user_id = mysqli_real_escape_string($con,$_POST['user_id']);

    $pre=mysqli_fetch_array(mysqli_query($con,"
        SELECT * FROM Prescription WHERE user_id='$user_id' ORDER BY id DESC
    "));
    
    $medicine=mysqli_query($con,"
        SELECT * FROM MedicineInfo WHERE prs_id='$pre[id]'
    ");
    $total_cnt = mysqli_num_rows($medicine);
    $sum;
    while($row=mysqli_fetch_array($medicine)){
        $sum+=$row['number_doses'];
    }
    $json = array();
    if(mysqli_num_rows($medicine)>0){
        $json['count']= (int)$sum/$total_cnt;
        $json['success']=true;
    }else{
        $json['success']=false;
    }    
    header('Content-Type: application/json');
    echo json_encode($json);

?>