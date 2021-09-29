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
        


        #date-table{
            width:100%;
            height:64vh;
        }
       #date-table th{
            font-size: 15px;
            color:rgb(106,107,107);
            text-align:center;
       }
       #date-table td{
         
         font-size:20px;
       }
       .deactive{
           display:inline-block;
           width:40px;
           height:40px;
           color:rgb(106,107,107);
           background: white;
           text-align: center;
           line-height:40px;
       }
       .actived{
           display:inline-block;
           width:40px;
           height:40px;
           color:white;
           background: rgb(29,210,193);
           border-radius: 23px;
           text-align: center;
           line-height:40px;
       }
       .booking-time-box{
        width:100%;
        height:50px;
        overflow-x:auto;
        white-space: nowrap;
       
       }
       .booking-time{
         display:inline-block;
          width:86px;
          height:50px;
          color:rgb(52,68,110);
          background:rgb(230,230,230);
          border-radius:25px;
          text-align: center;
          line-height:50px;
          margin-left:7%;

       }
       .time-active{
         background:rgb(52,68,110);
         color:white;

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
       #dialog,
       #alert{
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
       #alert{
           height:109px;
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
       }
       .dialog-yes-btn,
       .dialog-confirm-btn{
            display:inline-block;
            width:42%;
            height:30px;
            background:rgb(53,214,199);
            color:white;
            border-radius:5px;
            text-align:center;
            line-height:30px;
       }
       .dialog-confirm-btn{
          margin-left:56%; 
          margin-top:5%;
       }
       #month-left,
       #month-right{
           color:rgb(52,68,110);
       }
    </style>
</head>
<body>
    <script>
        
        var d_instance = new Date();
        var nYear = d_instance.getFullYear();
        var nMonth = d_instance.getMonth()+1;
        //var nDay  = d_instance.getDate();
        
        
    </script>
    
    <?php
        function check_count($date,$time){
            return "5";
        }
    ?>
    
    <div width="98%" style="margin-bottom:4%; margin-left:2%;">
        <div style="display:inline-block; width:45%;">
            <img  src="img/left.png" onclick="back();">
        </div>
        <div style="display:inline-block; widt50%;">
            <img src="img/icon_sm.png">
        </div>
    </div>
    <h3 style="width:90%; margin:0 auto; color:rgb(52,68,110);">예약 날짜 선택</h3>    
    <hr style="border-color:rgb(210,210,210);">
    <div style="width:90%; margin:0 auto;">
        <h3>
            <i class="glyphicon glyphicon-chevron-left" id="month-left"></i>
            <span id="month" style="color:rgb(52,68,110);"></span>
            <i class="glyphicon glyphicon-chevron-right" id="month-right"></i>
        </h3>
        
        <table id="date-table">
              <tr>
                  <th>SUN</th>
                  <th>MON</th>
                  <th>TUE</th>
                  <th>WED</th>
                  <th>THU</th>
                  <th>FRI</th>
                  <th>SAT</th>
              </tr>
                 
        </table>
        
    </div>
    <h3 style="width:90%; margin:0 auto; margin-top:10vh; color:rgb(52,68,110);">방문 시간 선택</h3>    
    <hr style="border-color:rgb(210,210,210);">
    <div style="width:90%; margin:0 auto;">
       <div class="booking-time-box">
            <!--<span class="booking-time click-btn">10:30</span>
            <span class="booking-time click-btn" style="margin-left:20px;">11:00</span>
            <span class="booking-time click-btn" style="margin-left:20px;">11:30</span>-->
            
            
       </div>
       
       <div style="margin-top:10vh; text-align:center;">
           <!-- <div>
                <span class="step-num step-active">1</span>
                <span class="step-line"></span>
                <span class="step-num">2</span>
                <span class="step-line"></span>
                <span class="step-num">3</span>
            </div>-->
            <img src="img/step1.png">
       </div>  
    </div>
    <div id="dialog-box" class="dialog" style="display:none;"></div>
    <div id="dialog" class="dialog" style="display:none; color:rgb(52,68,110);">
       <h3 class="dialog-title" style="text-align:center;">예약 날짜 확인</h3>
       <p style="color:rgb(52,68,110); text-align:center;">
            <b><span class="dialog-content"></span></b><br>
            방문하실 날짜가 맞나요?
       </p>
       <span class="dialog-no-btn">날짜 변경하기</span>
       <span class="dialog-yes-btn">예</span>
    </div>
    <div id="alert" style="display:none;">
        <h3 class="dialog-title" style="text-align:center;"></h3>
        <p style="color:rgb(52,68,110); text-align:center;">
            
            예약할수 없습니다.
       </p>
         
         <span class="dialog-confirm-btn">확인</span>
    </div> 
    <form action="medical_staff.php" style="display:none;" id="form" method="POST">
        <input type='hidden' id="hp_id" name="hp_pk" value="<?= $_POST['hp_pk']?>">
        <input id="bDate" type="date" name="booking_date" style="display:none;">
        <input id="bTime" type="time" name="booking_time" style='display:none;'>
    </form>
    <script>
        function back(){
            window.android.back();
        }
        var week_arr = [
            [],
            ['mon_s_time','mon_e_time'],
            ['tue_s_time','tue_e_time'],
            ['wed_s_time','wed_e_time'],
            ['thu_s_time','thu_e_time'],
            ['fri_s_time','fri_e_time'],
            ['sta_s_time','sta_e_time']
        ]
        var h = (window.innerHeight-$("#dialog").height())/2;
        $("#dialog").css({
            "left":"10%",
            "top":h+"px"
        });
        $("#alert").css({
            "left":"10%",
            "top":h+"px"
        });
        
        var bk_obj;
        make_calendar(nYear,nMonth);
        // 달 -
        $("#month-left").click(function(){
            nMonth--;
            $(".month-number").remove();
            if(nMonth < 1){
                nMonth=12;    
                nYear--;
            }
            make_calendar(nYear,nMonth);
        });
        // 달 +
        $("#month-right").click(function(){
            nMonth++;
            $(".month-number").remove();
            if(nMonth > 12){
                nMonth=1;
                nYear++;    
            }
            make_calendar(nYear,nMonth);
        });
        
        $(document).on("click",".deactive",function(){
          $(".actived").attr("class","deactive");
            $(this).attr("class","actived");
            var dd = parseInt($(this).text());
            var date = new Date();
            var month = nMonth;

            if(month < 10){
                month = "0"+month;
            }
            if(dd<10){
                dd = "0"+dd;
            }
            var today_date = parseInt(date.getFullYear()+""+(date.getMonth()+1)+""+date.getDate());
            var book_date  = parseInt(nYear+""+month+""+dd);
        
            if(book_date >= today_date ){
                
                
                $("#bDate").val(nYear+"-"+nMonth+"-"+dd);
                ajax();
            }else{
                $("#alert").css("display","block");
                $("#dialog-box").css("display","block");
            }    
        });
        $(".dialog-confirm-btn").click(function(){
            $("#alert").css("display","none");
            $("#dialog-box").css("display","none");
        });
        
        $(document).on("click",".booking-time",function(){
            $(".time-active").removeClass('time-active');
           $(this).addClass('time-active');
           
            $("#bTime").val($(this).text());
           
        });

        $(document).on("click",".click-btn",function(){
            if( $(".month-number > td > span").hasClass('actived') &&
                $(".click-btn").hasClass('time-active'))
              {
                 //다음 페이지 이동 구역
                 
                var date_time = $("#bDate").val()+" "+$("#bTime").val();
                
           
                $(".dialog").css("display","block");
                $(".dialog-content").text(date_time);
              }
        });

        // 달력 숫자 만들기 
        function make_calendar(year,month){
          var first_week =  year+"-"+month+"-"+"01";
          var index = new Date(first_week).getDay();
          var lastDay = ( new Date(year, month, 0) ).getDate();
          $("#month").text((month)+"월");
          var number= 1;
          for(var i=0; i<5; i++){
              var tr = $("<tr class='month-number'></tr>");
              for(var j=0; j<7; j++){
                  var td="";
                  if( (j >= index || number != 1) && (number <= lastDay))
                      td = $("<td><span class='deactive click-btn'>"+(number++)+"</span></td>");
                  else
                      td = $("<td></td>");
                  tr.append(td);
              }
              $("#date-table").append(tr);
          }
    }   

    function ajax(){
       
        var index = new Date($("#bDate").val()).getDay();
        var user_id = window.android.getUserId();
        
        //var user_id = "poapo";
        $.ajax({
                type : 'POST',
                url : "online_booking_date_ajax.php",
                data : {
                    'user_id':user_id,
                    'hp_id':$("#hp_id").val(),
                    'b_date':$("#bDate").val()
                },
                success : function (data) {
                  
                    bk_obj = data[1];
        
                    make_time_tag(data[0][week_arr[index][0]],data[0][week_arr[index][1]],data[0]['care_gap']);
                }
            });
    }
    function count_time(time){
        
        var arr = bk_obj.filter(function (n) {
                return n == time;
            });

        return arr.length;    

    }
    function make_time_tag(start_time,end_time,care_gap){
        var start_date = new Date($("#bDate").val()+" "+start_time);
        var end_date = new Date($("#bDate").val()+" "+end_time);
        end_date.setMinutes(end_date.getMinutes()-15);
        var start=0;
        var end = 1;
        $(".booking-time-box").empty();
        //alert(bk_obj[0])
        //alert(count_time("09:15:00"));
        var count=0;
        
        while(start < end){
            hour = start_date.getHours();
            minute = start_date.getMinutes();
            if(hour < 10){
                hour = "0"+hour; 
            }
            if(minute < 10){
                minute = "0"+minute;
            }
           if(count_time(hour+":"+minute+":00") < 2){ 
                var tag = $("<span class='booking-time click-btn' style='font-size:25px;'>"+hour+":"+minute+"</span>");
                $(".booking-time-box").append(tag);
           }
            start_date.setMinutes(start_date.getMinutes()+care_gap);
            start=parseInt(start_date.getHours()+""+start_date.getMinutes());
            end=parseInt(end_date.getHours()+""+end_date.getMinutes());
        }
    }
    //예 버튼 클릭시
    $(".dialog-yes-btn").click(function(){
            $("#form").submit();
    });
    //날짜 변경하기 클릭시
    $(".dialog-no-btn").click(function(){
        $(".actived").attr("class","deactive");
        $(".time-active").removeClass('time-active');
        $(".dialog").css("display","none");
        $(".booking-time-box").empty();
    });
    </script>

</body>
</html>