<?php
/* Template Name: Email Test */

$headers = 'From: My Name <myname@sajidshah.com>' . "\r\n\\";
$test = mail('syedsajidshah@live.com, dijast@gmail.com', 'The subject', 'The message');
//$test = mail('caffeinated@example.com', 'My Subject', $message);
 
if($test) echo "SUCCESS";
else echo "FAILED"; 
?>