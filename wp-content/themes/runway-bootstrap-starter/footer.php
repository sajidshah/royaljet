<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package runway-bootstrap-starter
 */
?>

	<?php do_action('output_layout','end'); // Layout Manager - End Layout ?> 

	</div><!-- close #middle -->

	<?php if ( !is_page_template( 'templates/cover.php' ) ) : ?>

		<!-- Footer
		================================================== -->
		<footer id="footer">
			<div class="container-fluid">
			  <div class="row">
				<div class="col-sm-3 col-sm-offset-1">
					<h3>Footer Menu</h3>
					<?php 
						// Main navbar (right)
						wp_nav_menu( array(
							'menu'              => 'footer-menu',
							'theme_location'    => 'footer-menu',
							'container'         => false,
							'menu_class'        => '',
							
						));
					?>
				</div>
				<div class="col-sm-4">
					<h3>Disclaimer</h3>
					Royal Jets do not own or operate any aircraft. Royal Jets acts as agent for the Royalty Members
				</div>
				<div class="col-sm-3">
					<h3>Get in Touch</h3>
					1100 New Hwy<br>
					Farmingdale, New York 11735<br>
					Freephone:+1 877 626 6952 <br>FAX:+ +1 877 626 6952<br>
					E-mail: Info@royaljets.com
				</div>
			  </div>
			  <div class="footer_copyright text-center">RoyalJets &copy; <a href="<?php echo site_url('privacy-policy');?>">Privacy Policy</a></div>
			</div>
		</footer>

	<?php endif; ?>


<?php wp_footer(); ?>

</body>
</html>