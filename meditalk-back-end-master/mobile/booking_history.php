<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
         body{background:white;}
         .table > thead > tr > td,
         .table > tbody > tr > td,
         .table > tfoot > tr > td {
            border: 0px;
            color:gray;
        }
        .table{
            background: white;
            margin-top:7%;
        }
        
    </style>
</head>
<body>
    
    
    <div>
        <?php
            $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
            $user_id = mysqli_real_escape_string($con,$_GET['user_id']);
            $bf_objs = mysqli_query(
                $con,
                "SELECT * FROM BookingForm WHERE user_id='$user_id'"
            );
            if(mysqli_num_rows($bf_objs)>0){
                while($row=mysqli_fetch_array($bf_objs)){
                    $user_obj = mysqli_fetch_array(mysqli_query(
                            $con,
                            "SELECT * FROM User WHERE user_id='$row[user_id]'"
                    ));
                    $hp_obj = mysqli_fetch_array(mysqli_query(
                            $con,
                            "SELECT * FROM Hospital WHERE hp_id='$row[hp_id]'"
                    ));
                    $staff_obj = mysqli_fetch_array(mysqli_query(
                            $con,
                            "SELECT * FROM MedicalStaff WHERE ms_num='$row[ms_id]'"
                    ));
        ?>

        <table class="table">
            <!--이름-->
            <tr>
                <td class="text-left">이름</td>
                <td class="text-right"><?=$user_obj['user_name']?></td>
            </tr>
            <!--병원명-->
            <tr>
                <td class="text-left">병원명</td>
                <td class="text-right"><?=$hp_obj['hp_name']?></td>
            </tr>
            <!--예약시간-->
            <tr>
                <td class="text-left">예약시간</td>
                <td class="text-right"><?=$row['bf_date']." ".$row['bf_time']?></td>
            </tr>
            <!--담당의사-->
            <tr>
                <td class="text-left">담당의사</td>
                <td class="text-right"><?=$staff_obj['ms_name']?></td>
            </tr>
            <!--상태-->
            <tr>
                <td class="text-left">상태</td>
                <?php
                 if($row['bf_status'] == 0){
                ?>
                    <td class="text-right">예약취소</td>
                <?php
                 }else{
                ?>
                    <td class="text-right">진료완료</td>
                <?php
                 }
                ?>
            </tr>
            
        </table>
        <hr style="border-width:2px;">
        <?php
            }
        }else{
        ?>
           <div id="search-result-msg" class="text-center">
                <div>
                    <img src="/mobile/online_booking/img/search-result.jpg">
                    <p>예약 내역이 없습니다.</p>
                </div>
            </div>
        <?php
        }
        ?>

        
    </div>
    <script>
        var h = (window.innerHeight - 170)/2;
        
        $("#search-result-msg").css({
            "width":"100%",
            "position":"absolute",
            "top":h+"px"
        });
    </script>    
    
</body>
</html>