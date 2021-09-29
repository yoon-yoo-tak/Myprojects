<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <!--제이쿼리-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <style>
        body{background:rgb(210,210,210);}
        #hp-name-box{
            display: inline-block;
            position: relative;
        }
        .text-box{
            width:100%; 
            height:16vh; 
            text-align: center; 
            line-height: 20vh; 
            background:white;
            position: relative; 
            margin-top:20%;
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
#dialog-box{
        width:100%;
           height:100%;
           position:fixed;
           left:0px;
           top:0px;
           opacity:0.5;
           background:black;
           z-index:9;
       }
       #dialog{
           width:80%;
           height:150px;
           z-index:999;
           position:fixed;
           left:0px;
           top:0px;
           color:black;
           background:white;
           border-radius:15px;

       }
       .dialog-no-btn{
            display:inline-block;
            width:42%;
            height:30px;
            background:rgb(216,216,216);
            color:rgb(52,68,110);
            border-radius:5px;
            text-align:center;
            line-height:30px;
            margin-left:8%;
            margin-top:5%;
       }
       .dialog-yes-btn{
            display:inline-block;
            width:42%;
            height:30px;
            background:rgb(53,214,199);
            color:white;
            border-radius:5px;
            text-align:center;
            line-height:30px;
            margin-top:5%;
       }
    </style>
</head>
<body>
    <?php 
    $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
    $user_id = mysqli_real_escape_string($con,$_GET['user_id']);
    $bf_query = "SELECT * FROM BookingForm WHERE user_id='$user_id' AND bf_status='1' ORDER BY bf_date,bf_time";
    $obj = mysqli_query($con,$bf_query);             
    while($row = mysqli_fetch_array($obj)){
        $bk_row_cnt = $row['bf_waiting_order'];
        if($bk_row_cnt < 10){
            $bk_row_cnt = "00".$bk_row_cnt;
            
        }else if($bk_row_cnt<100){
            $bk_row_cnt = "0".$bk_row_cnt;
            
        }
         $hp_obj = mysqli_fetch_array(mysqli_query(
             $con,
             "SELECT * FROM Hospital WHERE hp_id='$row[hp_id]'"
            ));
         $user_obj = mysqli_fetch_array(mysqli_query(
            $con,
            "SELECT * FROM User WHERE user_id='$row[user_id]'"
        ));
         $ms_obj = mysqli_fetch_array(mysqli_query(
             $con,
             "SELECT * FROM MedicalStaff WHERE ms_num='$row[ms_id]'"
         ));   
    ?>
    <div style="margin-top:10%; background:white;">
    <!--병원이름-->
    <div>
        <div id="hp-name-box">
            <img style="position: absolute;right:0px; top:0px;" src="img/circle.png">
            <h3 style="color:rgb(52,68,110); margin-right:20px;"><?=$hp_obj['hp_name']?></h3>
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
            <td class="text-right"><?=$row['bf_date']." ".$row['bf_time']?></td>
        </tr>
        <!--담당의사-->
        <tr>
            <td class="text-left">담당의사</td>
            <td class="text-right"><?=$ms_obj['ms_name']?></td>
        </tr>
        <!--예약취소 버튼-->    
        <tr>
            <td></td>
            <td class="text-right"><a class='cancle-btn' bf_number="<?=$row['number']?>">예약취소</a></td>
        </tr>    
    </table>    
    </div>
    <?php
    }
    ?>
    <div id="dialog-box" class="dialog" style="display:none;"></div>
    <div id="dialog" class="dialog" style="display:none; color:rgb(52,68,110);">
       <h3 class="dialog-title" style="text-align:center;">예약취소</h3>
       <p style="color:rgb(52,68,110); text-align:center;">
            예약취소 하겠습니까?
       </p>
       <span class="dialog-no-btn">아니오</span>
       <span class="dialog-yes-btn">예</span>
    </div>
    <form id="form" action="cancel_booking.php" method="POST">
        <input type="hidden" name="user_id" value="<?=$user_id?>">
        <input type="hidden" name="bf_number" id="bf_number"value="">
    </form>
    <script>
        
        var h = (window.innerHeight-$("#dialog").height())/2;
        $("#dialog").css({
            "left":"10%",
            "top":h+"px"
        });
        //예약취소 버튼 클릭시
        $(".cancle-btn").click(function(){
            $(".dialog").css("display","block");
            $("#bf_number").val($(this).attr('bf_number'));
        });
        //dialog yes btn
        $(".dialog-yes-btn").click(function(){
            $("#form").submit();
        });
        //dialog no btn
        $(".dialog-no-btn").click(function(){
            $(".dialog").css("display","none");
            
        });
    </script>    
</body>
</html>