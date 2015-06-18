<?php
/*
    Extension Name: Bootstrap Template Functions
    Version: 1.0
    Description: Custom template functions for the Bootstrap Starter theme.
*/



/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
if ( ! function_exists( 'rf_page_menu_args' ) ) :
function rf_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
endif; // rf_page_menu_args

add_filter( 'wp_page_menu_args', 'rf_page_menu_args' );



/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
if ( ! function_exists( 'rf_wp_title' ) ) :
function rf_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || (!is_object($page) && $page >= 2) )
		$title .= " $sep " . sprintf( __( 'Page %s', 'framework' ), max( $paged, $page ) );

	return $title;
}
endif; // rf_wp_title

add_filter( 'wp_title', 'rf_wp_title', 10, 2 );



/**
 * Display navigation to next/previous pages when applicable
 */
if ( ! function_exists( 'rf_next_prev_post_nav' ) ) :
function rf_next_prev_post_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'framework' ); ?></h1>
		<ul class="pager">

		<?php if ( is_single() ) : // navigation links for single posts ?>

			<?php previous_post_link( '<li class="nav-previous previous">%link</li>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'framework' ) . '</span> %title' ); ?>
			<?php next_post_link( '<li class="nav-next next">%link</li>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'framework' ) . '</span>' ); ?>

		<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

			<?php if ( get_next_posts_link() ) : ?>
			<li class="nav-previous previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'framework' ) ); ?></li>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<li class="nav-next next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'framework' ) ); ?></li>
			<?php endif; ?>

		<?php endif; ?>

		</ul>
	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // rf_next_prev_post_nav



/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
if ( ! function_exists( 'rf_list_comment' ) ) :
function rf_list_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'media' ); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'framework' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'framework' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body media">
			<a class="pull-left" href="#">
				<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			</a>

			<div class="media-body">
				<div class="media-body-wrap panel panel-default">

					<div class="panel-heading">
						<h5 class="media-heading"><?php printf( __( '%s <span class="says">says:</span>', 'framework' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?></h5>
						<div class="comment-meta">
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
								<time datetime="<?php comment_time( 'c' ); ?>">
									<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'framework' ), get_comment_date(), get_comment_time() ); ?>
								</time>
							</a>
							<?php edit_comment_link( __( '<span style="margin-left: 5px;" class="glyphicon glyphicon-edit"></span> Edit', 'framework' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					</div>

					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'framework' ); ?></p>
					<?php endif; ?>

					<div class="comment-content panel-body">
						<?php comment_text(); ?>
					</div><!-- .comment-content -->

					<?php comment_reply_link(
						array_merge(
							$args, array(
								'add_below' => 'div-comment',
								'depth' 	=> $depth,
								'max_depth' => $args['max_depth'],
								'before' 	=> '<footer class="reply comment-reply panel-footer">',
								'after' 	=> '</footer><!-- .reply -->'
							)
						)
					); ?>

				</div>
			</div><!-- .media-body -->

		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for rf_list_comment()



/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
if ( ! function_exists( 'rf_posted_on' ) ) :
function rf_posted_on( $echo = true ) {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$time_string = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		$time_string
	);

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string_update = '<time class="updated" datetime="%1$s">%2$s</time>';
		$time_string_update = sprintf( $time_string_update,
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);
		$time_string_update = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			$time_string_update
		);
		$time_string .= __(', updated on ', 'framework') . $time_string_update;
	}

	$posted_on = sprintf( __( '<span class="posted-on">Posted on %1$s</span><span class="byline"> by %2$s</span>', 'framework' ),
		$time_string,
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'framework' ), get_the_author() ) ),
			esc_html( get_the_author() )
		)
	);

	if ( $echo ) {
		echo $posted_on;
	} else {
		return $posted_on;
	}
}
endif;



/**
 * Returns true if a blog has more than 1 category
 */
if ( ! function_exists( 'rf_categorized_blog' ) ) :
function rf_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so rf_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so rf_categorized_blog should return false
		return false;
	}
}
endif;



/**
 * Flush out the transients used in rf_categorized_blog
 */
if ( ! function_exists( 'rf_category_transient_flusher' ) ) :
function rf_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
endif;
add_action( 'edit_category', 'rf_category_transient_flusher' );
add_action( 'save_post',     'rf_category_transient_flusher' );

