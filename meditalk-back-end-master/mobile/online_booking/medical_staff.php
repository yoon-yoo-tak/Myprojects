<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--제이쿼리-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <style>
        #hp-name-box{
            display: inline-block;
            position: relative;
        }
        .staff-name{
            position: absolute; 
            left:3%;
            top:3vh;
            color:rgb(52,68,110);
        }
        .wait-time{
            display: inline-block; 
            text-align: right; 
            position: absolute; 
            right:16%;
            top:3vh;
            color:rgb(52,68,110);
        }
        .check-box{
            margin-left:3%;
            margin-top:20px;
            position: relative;
        }
        input[type="checkbox"] + label{
            
            display: inline-block;
            width:35px;
            height: 35px;
            margin-top:3vh;
            border:1px solid rgb(29,210,193);
            border-radius: 20px;
            cursor: pointer;
            float:left;
            position: relative;
        }
        input[type="checkbox"]:checked + label:before {
            
            content: '\2714';
            display: inline-block;
            width:35px;
            height: 35px;
            text-align: center;
            line-height: 35px;
            background:rgb(29,210,193);
            color:rgb(52,68,110);  
            border-radius: 20px;
            position: absolute;
            left:0px;
            top:0px;
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
           height:190px;
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
        $hp_id = mysqli_real_escape_string($con,$_POST['hp_pk']);
        $hp_booking_date = mysqli_real_escape_string($con,$_POST['booking_date']);
        $hp_booking_time = mysqli_real_escape_string($con,$_POST['booking_time']);
        $staff_query = "SELECT * FROM MedicalStaff WHERE hp_id='$hp_id'";
        $hp_query = "SELECT * FROM Hospital WHERE hp_id='$hp_id'";
        $hp_row = mysqli_fetch_array(mysqli_query($con,$hp_query));
       
    ?>
    <div id="header" width="97%" style="margin-bottom:3%;">
        <div style="display:inline-block; width:30%;">
            <img  src="img/left.png" onclick="back();">
        </div>
        <div style="display:inline-block; width:60%;">
            <h3 style="display:inline;color:rgb(52,68,110); position: relative; top:-7px;">진료실 선택하기</h3>
        </div>
    </div>
    <!--병원이름-->
    <div id="center"  width="97%" style="margin-left:3%;">
        <div id="hp-name-box">
            <img style="position: absolute;right:0px; top:0px;" src="img/circle.png">
            <h3 style="color:rgb(52,68,110); margin-right:20px;"><?=$hp_row['hp_name']?></h3>
        </div>
    </div>    
    <hr style="border:1px solid rgb(210,210,210);">
    <!--의료진-->
    <div id="staff-list-box">
       <?php
            $result = mysqli_query($con,$staff_query);
            $cnt = 1;
            while($row=mysqli_fetch_array($result)){
                $pos = "";
                if($row['ms_position'] == 1){
                    $pos = "원장님";
                }else{
                    $pos = "선생님";
                }
                $bk_query = "SELECT * FROM BookingForm WHERE bf_date='$hp_booking_date' AND
                                                             bf_time='$hp_booking_time' AND
                                                             ms_id='$row[ms_num]' AND
                                                             NOT bf_status=0";
                if(mysqli_num_rows(mysqli_query($con,$bk_query)) > 0){
                    continue;
                }                                             
        ?>         
        <div style="position: relative; border-bottom:1px solid rgb(210,210,210); height: 13vh;">
            <span class="staff-name" id="sn<?=$cnt?>"><b><?= $row['ms_name']?></b> <?=$pos?></span>
            <div style="position: absolute; right:3%;">
                <input type="checkbox" cnt=<?=$cnt?> class="cb" pk="<?=$row['ms_num']?>" id="cb<?=$cnt?>"style="display: none;">
                <label for="cb<?=$cnt?>"></label>
            </div>
        </div>
       <?php
            $cnt++;
        }
       ?>
         
    </div>
    <div id="step" style="text-align:center;">
            <!--<div>    
                <span class="step-num step-active">1</span>
                <span class="step-line step-line-active"></span>
                <span class="step-num step-active">2</span>
                <span class="step-line"></span>
                <span class="step-num">3</span>
            </div>-->
            <img src="img/step2.png">
    </div>
    <div id="dialog-box" class="dialog" style="display:none;"></div>
    <div id="dialog" class="dialog" style="display:none; color:rgb(52,68,110);">
       <h3 class="dialog-title" style="text-align:center;">진료실 선택</h3>
       <p style="color:rgb(52,68,110); text-align:center;">
            <b><span class="dialog-content"></span></b><br>
            예약 하시겠습니까?
       </p>
       <span class="dialog-no-btn">취소</span>
       <span class="dialog-yes-btn">예</span>
    </div> 
    <form action="booking_finish.php" method="POST" style="display:none;" id="form">
        <input type="hidden" name="hp_pk" value="<?=$hp_id?>">
        <input type="hidden" name="hp_name" value="<?=$hp_row['hp_name']?>">
        <input type="hidden" name="user_id" id="user-id">
        <input type="date" style="display:none;" name="booking_date" value="<?=$hp_booking_date?>">
        <input type="time" style="display:none;" name="booking_time" value="<?=$hp_booking_time?>"> 
        <input type="hidden" name="booking_staff" id="booking_staff">
    </form>    
    <script>
        function back(){
            window.android.back();
        }
        var h = (window.innerHeight-$("#dialog").height())/2;
        $("#dialog").css({
            "left":"10%",
            "top":h+"px"
        });
        var height = $(window).height() - $("#header").height() - $("#center").height() - $("#staff-list-box").height();
        $("#step").css("margin-top",(height-80)+"px");
        var user_id=window.android.getUserId();
        $("#user-id").val(user_id);
        $(".cb").click(function(){
            $(".cb").prop("checked",false);
            $(this).prop("checked",true);
            var cnt = $(this).attr("cnt");
            $(".dialog-content").text($("#sn"+cnt).text());
            $(".dialog").css("display","block");
            $("#booking_staff").val($(this).attr('pk'));
        });
        //예 
        $(".dialog-yes-btn").click(function(){
            
            $("#form").submit();
        });
        //취소
        $(".dialog-no-btn").click(function(){
            $(".cb").prop("checked",false);
            $(".dialog").css("display","none");
        });

    </script>    
</body>
</html>