<?php
    
    $is_save = $_POST['is_id_save'];
    $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
    $id = mysqli_real_escape_string($con,$_POST['user_id']);
    $pw = mysqli_real_escape_string($con,$_POST['user_pw']);
    #$id =  $_POST['user_id'];
    #$pw =  $_POST['user_pw'];
    $query = "SELECT * FROM Hospital WHERE hp_id='$id' AND hp_pw='$pw'";
    $result = mysqli_query($con,$query);
    if(empty(mysqli_fetch_array($result))){
        header("Location:/index.html");
    }else{
        
        if($is_save=="saveid"){
            setcookie('user_id',$id,time()+86400*30*12);
        }else{
            setcookie('user_id',"",time()-86400*30*12);
        }
        session_start();
        $_SESSION['user_id'] = $id;
        header("Location:/main.php");
        
    }

?>