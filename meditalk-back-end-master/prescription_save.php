<?php
        header("Content-Type: image/png");
        $con = mysqli_connect('localhost','meditalk','huiyih135!','meditalk');

        $user_id         = mysqli_real_escape_string($con,$_POST['user_id']);
        $hp_id           = mysqli_real_escape_string($con,$_POST['hp_id']);
        $bf_time         = mysqli_real_escape_string($con,$_POST['booking_time']);
        $care_item       = mysqli_real_escape_string($con,$_POST['care_item']);
        $bf_number       = mysqli_real_escape_string($con,$_POST['bf_number']);
        $med_row_max_cnt = (int)mysqli_real_escape_string($con,$_POST['med_row_max_cnt']);
        $create_date     = date("Y-m-d"); 
        $feedback        = mysqli_real_escape_string($con,$_POST['feedback']);
        $prs_id = mysqli_num_rows(mysqli_query($con,"SELECT * FROM Prescription;"));
            $prs_query = "INSERT INTO Prescription VALUES(
                '$prs_id',
                '$user_id',
                '$hp_id',
                '$bf_number',
                '$bf_time',
                '$care_item',
                '$create_date',
                '$feedback'
            )";
            mysqli_query($con,$prs_query);
        $hp = mysqli_fetch_array(mysqli_query($con,"
                SELECT * FROM Hospital WHERE hp_id='$hp_id'
        "));

        $book_form = mysqli_fetch_array(mysqli_query($con,"
                SELECT BookingForm.bf_date,BookingForm.bf_time,MedicalStaff.ms_name FROM BookingForm 
                JOIN MedicalStaff ON MedicalStaff.ms_num=BookingForm.ms_id
                WHERE number='$bf_number'
        "));
        
         

        //이미지 생성
             $font = "./nanum.ttf";
            
            $booking_date=  $book_form['bf_date']." ".date("H:i",strtotime($book_form['bf_time']));
            
            $im     = imagecreatefrompng("medical_info.png");
            $purple = imagecolorallocate($im, 52, 68, 110);
            $gary   = imagecolorallocate($im, 152, 160, 181);
            //병원이름 
            imagettftext($im, 15, 0, 55, 99, $purple, $font, $hp['hp_name']); 
            //발급일
            imagettftext($im, 10, 0, 255, 161, $gary, $font, $create_date); 
            //병원이름
            imagettftext($im, 10, 0, 255, 196, $gary, $font, $hp['hp_name']); 
            //의료진
            imagettftext($im, 10, 0, 255, 231, $gary, $font, $book_form['ms_name']); 
            //진료항목
            imagettftext($im, 10, 0, 220, 318, $gary, $font, $care_item); 
            //예약시간
            imagettftext($im, 10, 0, 220, 355, $gary, $font,$booking_date); 
            $save = "./info/img/img".$prs_id.".png";
            imagepng($im,$save);
            imagedestroy($im);

        //end
            $cnt = 1;
            while($cnt <= $med_row_max_cnt){
                $name = mysqli_real_escape_string($con,$_POST['name'.$cnt]);
                $count=mysqli_real_escape_string($con,$_POST['count'.$cnt]);
                $number_doses = mysqli_real_escape_string($con,$_POST['number_doses'.$cnt]);
                $query = "INSERT INTO MedicineInfo VALUES(
                    '$prs_id',
                    '$name',
                    '$count',
                    '$number_doses'
                )";

                mysqli_query($con,$query);
                $cnt++;
            }
        //예약서 상태 변환
        $query = "UPDATE BookingForm SET bf_status=2 WHERE bf_number='$bf_number'";
        mysqli_query($con,$query);    
       header("Location:/main.php");
    ?>