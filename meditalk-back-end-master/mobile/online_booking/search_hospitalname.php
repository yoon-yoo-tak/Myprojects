<?php
    
    $con     = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
    $keyword = mysqli_real_escape_string($con,$_POST['keyword']);

    $hp_obj = mysqli_query($con,"
        SELECT * FROM Hospital WHERE hp_name like '%$keyword%'
    ");
    $week    = array(
                        0,
                        array("mon_s_time","mon_e_time"),
                        array("tue_s_time","tue_e_time"),
                        array("wed_s_time","wed_e_time"),
                        array("thu_s_time","thu_e_time"),
                        array("fri_s_time","fri_e_time"),
                        array("sta_s_time","sta_e_time")
                    ) ;
    $weekday = $week[date('w' , strtotime(date("Y-m-d")))];

    $hp_list = array();
    while($row=mysqli_fetch_array($hp_obj)){
        $query = mysqli_query($con,"
            SELECT * FROM OfficeHours WHERE hp_id='$row[hp_id]'
        ");
        $time_obj = mysqli_fetch_array($query);
        $hp_list[$row['hp_id']]=array(
            'hp_name' => $row['hp_name'],
            'hp_addr' => $row['hp_addr'],
            'time_s'  => date("H:i",strtotime($time_obj[$weekday[0]])),
            'time_e'  => date("H:i",strtotime($time_obj[$weekday[1]]))
        );
    }
   
    header('Content-Type: application/json');
    echo json_encode($hp_list);
?>