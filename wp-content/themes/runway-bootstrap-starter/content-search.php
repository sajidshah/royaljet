<?php
/**
 * The content for each Search Result.
 * 
 * @package runway-bootstrap-starter
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('search-result'); ?>>
	<header class="search-header">
		<h3 class="search-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-meta">
		<p><a href="<?php the_permalink(); ?>" class="btn btn-primary" role="button"><?php _e('Read more...', 'framework' ); ?></a></p>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
