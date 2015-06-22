<?php
/* Template Name: Email Test */
get_header();
$headers = 'From: My Name <myname@sajidshah.com>' . "\r\n\\";
$test = wp_mail('syedsajidshah@live.com', 'The subject', 'The message',  $headers); 
if($test) echo "SUCCESS";
else echo "FAILED"; 

get_footer(); ?>