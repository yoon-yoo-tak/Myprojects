<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        #hp-name-box{
            display: inline-block;
            position: relative;
        }
        .text-box{
            width:100%; 
            height:16vh; 
            text-align: center; 
            line-height: 20vh; 
            position: relative; 
            margin-top:30%;
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
    </style>
</head>
<body>
    <div width="100%" style="margin-bottom:7%;">
        <div style="display:inline-block; width:30%;">
            <img  src="img/left.png">
        </div>
        <div style="display:inline-block; width:60%;">
            <h3 style="display:inline;color:rgb(52,68,110); position: relative; top:-7px;">대기순서</h3>
        </div>
    </div>
    <!--병원이름-->
    <div>
        <div id="hp-name-box">
            <img style="position: absolute;right:0px; top:0px;" src="img/circle.png">
            <h3 style="color:rgb(52,68,110); margin-right:20px;">메디톡병원</h3>
        </div>
    </div>
    <!--대기순서-->
    <div class="text-box">
        <div class="back-circle"></div>
        <div style="width:100%;position: absolute;">
            <span id="user-name" style="color:rgb(52,68,110); font-size:22px;">룡호님</span>
            <span><b style="color:rgb(52,68,110); font-size:52px;">012</b></span>
            <span style="color:rgb(52,68,110); font-size:22px;">순서입니다</span>
        </div>
    </div>
    <!--예상 대기시간-->
    <div  width="100%"class="wait-time-box">
        <p style="color:rgb(52,68,110);">예상대기시간 <b>15분</b></p>
    </div>
    <!--단계-->
    <div style="margin-top:40%;">
            <span class="step-num">1</span>
            <span class="step-line"></span>
            <span class="step-num">2</span>
            <span class="step-line"></span>
            <span class="step-num step-active">3</span>
            <span class="step-line"></span>
            <span class="step-num">4</span>
            <span class="step-line"></span>
            <span class="step-num">5</span>
    </div>
</body>
</html>