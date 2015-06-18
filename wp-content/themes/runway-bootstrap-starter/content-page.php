<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package runway-bootstrap-starter
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( function_exists('rf_has_custom_header') && !rf_has_custom_header() ) : ?>
		<header class="page-header main-header">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'framework' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Edit', 'framework' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->
