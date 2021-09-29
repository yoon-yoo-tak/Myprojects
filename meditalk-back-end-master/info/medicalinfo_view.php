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
        html,body{height: 100%;}
        #hp-name-box{
            display: inline-block;
            position: relative;
        }
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td {
        border: 0px;
        margin:0px;
        }
        .attribute{
            color:rgb(52,68,110);
        }
        .attrvalue{
            color:rgb(152,169,181);
            margin-right:3%;
        }
        .med-table{
           
           border-top:1px solid rgb(214,214,214);
           border-bottom:1px solid rgb(214,214,214);
       }
      
      .med-row >  td{
           
           padding:16px;
      }
      .share-btn{
          width:80%;
          height:50px;
          border-radius: 24px;
          background: rgb(52,68,110);
          line-height: 50px;
          text-align: center;
          color:white;
          margin:0 auto;
          margin-top:5%;
      }
    </style>
</head>
<body>
    <?php
        $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
        $pk  = mysqli_real_escape_string($con,$_GET['pk']);
        $row = mysqli_fetch_array(mysqli_query($con,"
            SELECT * FROM Prescription WHERE id='$pk'
        "));
        $hp = mysqli_fetch_array(mysqli_query($con,"
        SELECT * FROM Hospital WHERE hp_id='$row[hp_id]'
        "));
        $book = mysqli_fetch_array(mysqli_query($con,"
            SELECT BookingForm.bf_date,BookingForm.bf_time,MedicalStaff.ms_name FROM BookingForm 
            JOIN MedicalStaff ON MedicalStaff.ms_num=BookingForm.ms_id
            WHERE number='$row[book_id]'
        "));
        $book_date=  $book['bf_date']." ".date("H:i",strtotime($book['bf_time']));

        $medicine = mysqli_query($con,"
            SELECT * FROM MedicineInfo WHERE prs_id='$row[id]'
        ");
    ?>
    <div>
        <div class="text-right" style="width:92%; margin-top:3%;">
            <img src="img/logo.png" width="50" height="60">
        </div>
        <div style="margin-top:6%; margin-left:5%;">
            <div id="hp-name-box" >
                <img style="position: absolute;right:0px; top:0px;" src="img/circle.png">
                <h4 style="color:rgb(52,68,110); margin-right:20px;"><?=$hp['hp_name']?></h4>
            </div>
            <h4 style="color:rgb(52,68,110); margin:0;">병원 예약서 및 검진 정보</h4>
        </div>
        <div style="margin-left:3%; margin-top:7%;">
            <table class="table">
                <tr>
                    <td><span class="attribute">발급일</span></td>
                    <td class="text-right"><span class="attrvalue"><?=$row['create_date']?></span></td>
                </tr>
                <tr>
                    <td><span class="attribute">병원명</span></td>
                    <td class="text-right"><span class="attrvalue"><?=$hp['hp_name']?></span></td>
                </tr>
                <tr>
                    <td><span class="attribute">담당의사</span></td>
                    <td class="text-right"><span class="attrvalue"><?=$book['ms_name']?></span></td>
                </tr>
            </table>    
        </div>
        <div style="width: 100%; border:2px dashed rgb(229,229,229); margin-bottom: 23px;"></div>
        <div style="margin-left:3%; margin-top:7%;">
            <table class="table">
                <tr>
                    <td class="attribute">진료항목</td>
                    <td class="text-right attrvalue"><?=$row['care_item']?></td>
                </tr>
                <tr>
                    <td class="attribute">예약시간</td>
                    <td class="text-right attrvalue"><?=$book_date?></td>
                </tr>
            </table>
        </div>
        <table class='med-table'>
            <?php
               while($m = mysqli_fetch_array($medicine)){
            ?>
            <tr class='med-row row'>
                <td width="50%">
                    <?=$m['name']?>
                </td>
                <td   style="width:100px; border-left:1px dotted rgb(214,214,214); border-right:1px dashed  rgb(214,214,214); border-left:1px dashed rgb(214,214,214); border-right:1px dotted  rgb(214,214,214);">
                    <?=$m['count']?>정
                </td>
                <td style="width:100px;">
                    <?=$m['number_doses']?>회
                </td>
                   
            </tr>
            <?php
               }
            ?>
        </table> 
     </div>   
</body>
</html>