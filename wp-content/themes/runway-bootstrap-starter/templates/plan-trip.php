<?php /*
Template Name: Plan Trip
 * 
 */

$user = new WP_User( $user_ID );
$black = (in_array('member_black', $user->roles)) ? true : false;

if(!$black) return_404();						
 
  get_header(); ?>


<iframe style="border:0;" src="http://public.airplanemanager.com/Plugins/Quoting/?background-color=fff"
width="800" height="575"></iframe>
	
	
<?php get_footer(); ?>
