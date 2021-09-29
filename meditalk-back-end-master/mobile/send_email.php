<?php
  $to = "ryongho1997@gmail.com";

  $subject = "PHP 메일 발송";

  $contents = "PHP mail()함수를 이용한 메일 발송 테스트";

  $headers = "From: ryongho1997@gmail.com\r\n";



  mail($to, $subject, $contents, $headers);

?>