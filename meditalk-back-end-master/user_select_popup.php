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
        .search-form{
            display:inline-block;
            width:60%;
            height:36px;
            border:1px solid rgb(210,210,210);
            border-radius:6px;
            margin-left:20%;
            margin-top:30px;
        }
        
        .search-field:focus{
            outline: none; 
        }
    </style>
</head>
<body>
    <?php
      $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
      $name = mysqli_real_escape_string($con,$_POST['name']);
      $query = "SELECT * FROM User WHERE user_name='$name'";
      $user = mysqli_query($con,$query);
      
      
    ?>
    <form method="POST">
        <div class="search-form">
            <i class="glyphicon glyphicon-search"></i>
            <input type="search" value="<?=$name?>" name="name" class="search-field" placeholder="성함을 입력하세요." style="height:33px;border:0px;">
        </div>
        <input type="submit"  class="btn" value="검색">
    </form>
    
    <table class="table table-hover">
        <tr>
            <th>대기번호</th>
            <th>예약날짜</th> 
            <th>성명</th>
            <th></th>
        </tr>
        <?php
            
            if(empty(mysqli_fetch_array($user))){
        ?>
                <tr>
                    <td colspan="4" class="text-center">검색내용이 없습니다.</td>
                </tr>
        <?php }?>
                
        <?php
             $query = "SELECT * FROM User WHERE user_name='$name'";
             $user = mysqli_query($con,$query);
             $cnt=0;
             $now_date = date("Y-m-d");
            while($row= mysqli_fetch_array($user)){
                
               // $bk_query = "SELECT * FROM BookingForm WHERE user_id='$row[user_id]' AND bf_date='$now_date' AND bf_status='1'";
               $bk_query = "SELECT * FROM BookingForm WHERE user_id='$row[user_id]' AND bf_status=1 AND bf_date='$now_date'";
                $bk = mysqli_fetch_array(mysqli_query($con,$bk_query));

             if(!empty($bk)){
        ?>
            <tr>
                
                <td><?=$bk['bf_waiting_order']?></td>
                <td><?=$bk['bf_date']." ".$bk['bf_time']?></td>
                <td class="user_name<?=$cnt?>"><?=$row['user_name']?></td>
                <td class="btn btn-default select-btn" cnt='<?=$cnt?>'>선택</td>
                <!--user_id-->
                <input type="hidden" class="user_pk<?=$cnt?>" value="<?=$row['user_id']?>">
                <!--예약시간-->
                <input type="hidden" class="booking_time<?=$cnt?>" value="<?=$bk['bf_time']?>">
                <!--병원 아이디 -->
                <input type="hidden" class="hp_id<?=$cnt?>" value="<?=$bk['hp_id']?>">
                <!--에약서 번호-->
                <input type="hidden" class="bf_number<?=$cnt?>" value="<?=$bk['number']?>">
            </tr>
        <?php
             }

            $cnt ++;
            }
        ?>
    </table>
    <script>
        $(".select-btn").click(function(){
            var cnt = $(this).attr('cnt');
            $("#user_pk",opener.document).val($(".user_pk"+cnt).val());
            $("#user_name",opener.document).val($(".user_name"+cnt).text());
            $("#booking_time",opener.document).val($(".booking_time"+cnt).val());
            $("#hp_id",opener.document).val($(".hp_id"+cnt).val());
            $("#bf_number",opener.document).val($(".bf_number"+cnt).val());
            window.close();
        });
    </script>
</body>
</html>