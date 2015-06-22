<?php
/* Template Name: Email Test */
get_header();
$headers = 'From: My Name <myname@sajidshah.com>' . "\r\n\\";
wp_mail('syedsajidshah@live.com', 'The subject', 'The message',  $headers); 

get_footer(); ?>