<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
   <style>
       *{padding:0; margin:0;}
       .header-text{
            display: inline-block;
            width:69%;
            margin-left:11%;
            position: relative;
       }
       .header-p{
           
           font-size: 25px;
           color:rgb(52,68,110);
       }
       .symptom{
           color:rgb(52, 68, 110);
           font-weight: bold;
       }
       ul{
           list-style: none;
           
       }
      ul li{
          text-align: center;
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
        $user_id = mysqli_real_escape_string($con,$_GET['user_id']);
        $user = mysqli_fetch_array(mysqli_query($con,"
            SELECT * FROM User WHERE user_id='$user_id'
        "));

        $pre=mysqli_fetch_array(mysqli_query($con,"
            SELECT * FROM Prescription WHERE user_id='$user[user_id]' ORDER BY id DESC
        "));
        
        $list = null;
        if(!empty($pre)){
            /*$list = mysqli_query($con,"
                SELECT * FROM Prescription WHERE care_item like '%$pre[care_item]%'
            ");*/
            $list = mysqli_query($con,"
                SELECT * FROM Prescription WHERE care_item like '%$pre[care_item]%' ORDER BY id DESC
            ");
        }else{
            /*$list = mysqli_query($con,"
                SELECT * FROM Prescription ORDER BY id DESC LIMIT 10; 
            ");*/
            $list = mysqli_query($con,"
                SELECT * FROM Prescription ORDER BY id DESC LIMIT 10
            ");
        }


    
    ?>
    
    <div width="97%" style="margin-bottom:4%; margin-left:3%;">
        <img src="img/left.png" onclick="back();">
        <div class="text-center" style="display: inline-block; margin-left: 32%;">
            <span style="font-size:20px; color: rgb(52, 68, 110); position: relative; top:5px;">
                의료정보
            </span>
        </div>  
        <div style="display: inline-block; margin-left: 29%;">
            <i id='search-hospital-btn' class="glyphicon glyphicon-search" style="font-size:20px;" onclick="searchPage();"></i>
        </div>
    </div>
    <?php 
            if(!empty($pre)){
        ?>
      
    <div style="margin-top:15%;">
        
        
        <p class="header-p" style="margin-left:11%;"><?=$user['user_name']?>님의</p>
        <div class="header-text">
            <img style="position: absolute;right:0px; top:-11px;" src="img/circle.png">
            <p class="header-p">
                증상은 <span class="symptom"><?= $pre['care_item'] ?></span>입니다
            </p>
        </div>
        
    </div>
    <?php
            }
        ?>
    <hr>
    <ul>
        <?php
        if(mysqli_num_rows($list)>0){
            while($row=mysqli_fetch_array($list)){
                $hp    = mysqli_fetch_array(mysqli_query($con,"
                                SELECT * FROM Hospital WHERE hp_id='$row[hp_id]'
                         "));

                $book  = mysqli_fetch_array(mysqli_query($con,"
                                SELECT * FROM BookingForm WHERE number='$row[book_id]'
                         "));         
                $staff = mysqli_fetch_array(mysqli_query($con,"
                                SELECT * FROM MedicalStaff WHERE ms_num='$book[ms_id]'
                        "));
        ?>
            <li class="item" pk="<?=$row['id']?>">
                <img width="60%"src="img/board_logo.png">
                <table class="table">
                    <tr>
                        <td></td>
                        <td style="color:rgb(52,68,110);">증상</td>
                        <td style="color:rgb(52,68,110);"><b><?=$row['care_item']?></b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="color:rgb(52,68,110);">병원명</td>
                        <td style="color:rgb(52,68,110);"><b><?=$hp['hp_name']?></b></td>
                        <td></td>
                    </tr>    
                    <tr>
                        <td></td>
                        <td style="color:rgb(52,68,110);">담당의사</td>
                        <td style="color:rgb(52,68,110);"><b><?=$staff['ms_name']?></b></td>
                        <td></td>
                    </tr>
                    
                </table>    
                <!-- <p style="color:rgb(52,68,110); font-weight: bold;"></p> -->
            </li>
            <hr>
        <?php
            }
        }else{  
        ?>
            <div id="search-result-msg" class="text-center">
            <div>
                <img src="/mobile/online_booking/img/search-result.jpg">
                <p>의료정보가 없습니다.</p>
            </div>
        </div>
        <?php
        }
        ?>
    </ul>
    <script>
        var h = (window.innerHeight - 170)/2;
        
        $("#search-result-msg").css({
            "width":"100%",
            "position":"absolute",
            "top":h+"px"
        });
        $(".item").click(function(){
            var pk = $(this).attr("pk");
            window.location.href="medical_board_detail.php?index="+pk+"& user_id=<?=$user_id?>";
        });
        function back(){
            window.android.back();
        }
        function searchPage(){
            window.location.href="online_booking/search_medical_info.html?user_id=<?=$user_id?>";
        }
    </script>
</body>
</html>