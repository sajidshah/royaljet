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
				<div class="col-lg-12">
					<ul class="list-inline">
						<li><a href="#">Getting Started</a></li>
						<li>&middot;</li>
						<li><a href="#">Templates</a></li>
						<li>&middot;</li>
						<li><a href="#">Elements</a></li>
						<li>&middot;</li>
						<li><a href="#">Customize</a></li>
						<li>&middot;</li>
						<li><a href="#">Download</a></li>
					</ul>
					<p>
						<small>
							A starter theme built with <a href="http://getbootstrap.com" rel="nofollow">Bootstrap</a> and enhanced with the <a href="http://runwaywp.com" rel="nofollow">Runway WordPress framework</a>.<br>
							Copyright &copy; 2014. Created by the team at <a href="http://para.llel.us" rel="nofollow">Parallelus</a>.
						</small>
					</p>
				</div>
			  </div>
			</div>
		</footer>

	<?php endif; ?>


<?php wp_footer(); ?>

</body>
</html>