<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package runway-bootstrap-starter
 */

get_header(); ?>

	<section class="error-container error-404 not-found">

		<header class="page-header">
			<h2 class="page-title"><?php _e( 'Whaaaaat??!?!!1', 'framework' ); ?></h2>
			<p class="lead"><?php _e( "It seems the page you're looking for isn't here.", 'framework' ); ?></p>
		</header><!-- .page-header -->

		<div class="404-search-box">
			<p><?php _e( 'Try looking somewhere else and you might get lucky!', 'framework' ); ?></p>
			<?php get_search_form(); ?>
			<br>
			<br>
		</div>

	</section>

<?php get_footer(); ?>