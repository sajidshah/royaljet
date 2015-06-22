<?php
/* Template Name: Email Test */

$headers = 'From: My Name <myname@sajidshah.com>' . "\r\n\\";
$test = wp_mail('syedsajidshah@live.com', 'The subject', 'The message',  $headers);
//mail('caffeinated@example.com', 'My Subject', $message);
 
if($test) echo "SUCCESS";
else echo "FAILED"; 
?>