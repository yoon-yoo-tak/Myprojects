<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   
</head>
<body>
    <?php
        $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
        $pk  = mysqli_real_escape_string($con,$_GET['index']);
        $user_id = mysqli_real_escape_string($con,$_GET['user_id']);
        $pre = mysqli_fetch_array(mysqli_query($con,"
            SELECT * FROM Prescription WHERE id='$pk'
        "));
    ?>
    <div width="97%" style="margin-bottom:4%; margin-left:3%;">
        <img src="img/left.png" onclick="back();">
        <div class="text-center" style="display: inline-block; margin-left: 32%;">
            <span style="font-size:20px; color: rgb(52, 68, 110); position: relative; top:5px;">
                의료정보
            </span>
        </div>  
    </div>
    <div class="content" width="100%" style="margin-top:10%;">
        <?=$pre['feedback']?>
    </div>

    <script>
        $(".content > p > img").css({
            "width":"100%"

        });
        function back(){
            window.location.href="medical_board.php?user_id=<?=$user_id?>";
        }
    </script>
</body>
</html>