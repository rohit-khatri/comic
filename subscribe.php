<?php

require_once 'MainlService.php';

session_start();

if ($_SESSION['token']==$_POST['token']) {
  if (time() >= $_SESSION['token-expire']) {
    return [
        'status' => 400, 
        'message' => 'Bad Request'
    ];
  } else {
    unset($_SESSION['token']);
    unset($_SESSION['token-expire']);
    
    $emailBody = "<p>We have received a request for subscription of your email address, <".$_POST['email']."> to this mailing list.</p>
    <p>To confirm you wish to be added to this mailing list visit:</p>
    https://xkcd.com/newsletter/confirm/".base64_encode($_POST['email'])."
    <p>If you do not wish to be subscribed no action is required.</p>";
    return [
        'status' => 200, 
        'message' => 'OK'
    ];
  }
} else { 
    return [
        'status' => 400, 
        'message' => 'Bad Request'
    ];
}