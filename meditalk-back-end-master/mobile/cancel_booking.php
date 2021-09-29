<?php
    $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
    $user_id = mysqli_real_escape_string($con,$_POST['user_id']);
    $number = mysqli_real_escape_string($con,$_POST['bf_number']);
    $query = "UPDATE BookingForm SET bf_status=0 WHERE number='$number'";
    mysqli_query($con,$query);
    header("Location:booking_status.php?user_id=".$user_id);
?>