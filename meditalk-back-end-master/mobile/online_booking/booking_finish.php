<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <style>
        #hp-name-box{
            display: inline-block;
            margin-left:3%;
            position: relative;
        }
        .text-box{
            width:100%; 
            height:16vh; 
            text-align: center; 
            line-height: 20vh; 
            position: relative; 
            margin-top:30%;
            margin-bottom:30%;
        }
        .back-circle{
            width:20vh; 
            height:20vh; 
            position:absolute;
            top:-30%;
            right:23%;
            background:rgb(29,210,193);
            border-radius:50%;
        }
        .wait-time-box{
            
            text-align: right; 
            font-size: 22px; 
            margin-right:10%;
        }
        .step-num{
          display:inline-block;
          width:32px;
          height:32px;
          color:rgb(220,220,220);
          background:rgb(230,230,230);
          border-radius:15px;
          text-align:center;
          line-height:32px;
          margin:0px;
          padding:0px;
       }
       .step-line{
          display:inline-block;
          width:10%;
          height:3px;
          background:rgb(230,230,230);
          margin:0px;
          padding:0px;  
          position:relative;
          top:-3px;
       }
       .step-active{
          color:white;
          background:rgb(52,68,110);
       }
       .step-line-active{
        background:rgb(52,68,110);
       }
       .table > thead > tr > td,
     .table > tbody > tr > td,
    .table > tfoot > tr > td {
    border: 0px;
  
    }
    </style>
</head>
<body>
    <?php 
         $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
         $hp_id = mysqli_real_escape_string($con,$_POST['hp_pk']);
         $hp_name = mysqli_real_escape_string($con,$_POST['hp_name']);
         $user_id = mysqli_real_escape_string($con,$_POST['user_id']);
         $ms_id = mysqli_real_escape_string($con,$_POST['booking_staff']);
         $booking_date = mysqli_real_escape_string($con,$_POST['booking_date']);
         $booking_time = mysqli_real_escape_string($con,$_POST['booking_time']);
        
         $user_query = "SELECT * FROM User WHERE user_id='$user_id'";
         $user_obj = mysqli_fetch_array(mysqli_query($con,$user_query));
         $now_date = date("Y-m-d");

         $bk_select_query = "SELECT * FROM BookingForm WHERE hp_id='$hp_id' AND bf_date='$booking_date'";
         
         
        $bk_obj = mysqli_query($con,$bk_select_query);
        $bk_row_cnt = mysqli_num_rows($bk_obj)+1;  
         
         
         
        $query = "INSERT INTO BookingForm(hp_id,user_id,ms_id,bf_waiting_order,bf_date,bf_time,bf_status) VALUES(
                                                '$hp_id',
                                                '$user_id',
                                                '$ms_id',
                                                '$bk_row_cnt',
                                                '$booking_date',
                                                '$booking_time',
                                                '1'
                                              )";
        mysqli_query($con,$query);                                      
        if($bk_row_cnt < 10){
            $bk_row_cnt = "00".$bk_row_cnt;
            
        }else if($bk_row_cnt<100){
            $bk_row_cnt = "0".$bk_row_cnt;
            
        }
        $staff_obj = mysqli_fetch_array(mysqli_query(
            $con,
            "SELECT * FROM MedicalStaff WHERE hp_id='$hp_id' AND ms_num='$ms_id'"
        ));
    ?>
    <div width="97%" style="margin-bottom:7%; margin-left:3%;">
        <div style="display:inline-block; width:37%;">
            <img  src="img/left.png" onclick="back();">
        </div>
        <div style="display:inline-block;">
            <h3 style="display:inline;color:rgb(52,68,110); position: absolute; top:-8px;">대기순서</h3>
        </div>
    </div>
    <!--병원이름-->
    <div>
        <div id="hp-name-box">
            <img style="position: absolute;right:0px; top:0px;" src="img/circle.png">
            <h3 style="color:rgb(52,68,110); margin-right:20px;"><?=$hp_name?></h3>
        </div>
    </div>
    <!--대기순서-->
    <div class="text-box">
        <div class="back-circle"></div>
        <div style="width:100%;position: absolute;">
            <span id="user-name" style="color:rgb(52,68,110); font-size:22px;"><?=$user_obj['user_name']?>님</span>
            <span><b style="color:rgb(52,68,110); font-size:52px;"><?=$bk_row_cnt?></b></span>
            <span style="color:rgb(52,68,110); font-size:22px;">순서입니다</span>
        </div>
    </div>
    <hr style="border-color:black; border-width:2px;">
    <table class="table">
        <!--예약시간-->
        <tr>
            <td class="text-left">예약시간</td>
            <td class="text-right"><?=$booking_date." ".$booking_time?></td>
        </tr>
        <!--담당의사-->
        <tr>
            <td class="text-left">담당의사</td>
            <td class="text-right"><?=$staff_obj['ms_name']?></td>
        </tr>
         
    </table>    
    <!--단계-->
    <div style="margin-top:39%; text-align:center;">
        <!--<div>
            <span class="step-num step-active">1</span>
            <span class="step-line step-line-active"></span>
            <span class="step-num step-active">2</span>
            <span class="step-line step-line-active"></span>
            <span class="step-num step-active">3</span>
        </div>-->
        <img src="img/step3.png">   
    </div>
    <script>
        function back(){
            window.android.back();
        }
    </script>
</body>
</html>