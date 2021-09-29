<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
</head>
<?php
    $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
    session_start();
    $hp_id = $_SESSION['user_id'];
    $now_date = date("Y-m-d");
    $now_time = date("H:i:s");
    $query = "SELECT * FROM BookingForm WHERE hp_id='$hp_id' AND bf_date='$now_date' AND bf_status=1";
    
?>
<body>
    <table class="table table-hover">
        <tr>
            <th>대기순서</th>
            <th>예약일시</th>
            <th>병원</th>
            <th>이름</th>
        </tr>

        <?php
            if(empty(mysqli_fetch_array(mysqli_query($con,$query)))){
        ?>
            <tr>
                <td colspan="4" class="text-center">예약 내용이 없습니다.</td>
            </tr>    
            <?php }
             $result= mysqli_query($con,$query);
            ?>
    <?php 
        

        
        while($row=mysqli_fetch_array($result)){
            $hp_query = "SELECT * FROM Hospital WHERE hp_id='$row[hp_id]'";
            $user_query = "SELECT * FROM User WHERE user_id='$row[user_id]'";
            $hp = mysqli_fetch_array(mysqli_query($con,$hp_query));
            $user = mysqli_fetch_array(mysqli_query($con,$user_query));

    ?>   
            
            <tr>
                <td><?=$row['bf_waiting_order']?></td>
                <td><?=$row['bf_date']." ".$row['bf_time']?></td>
                <td><?=$hp['hp_name']?></td>
                <td><?=$user['user_name']?></td>
            </tr>
    <?php }?>
    </table>
</body>
</html>