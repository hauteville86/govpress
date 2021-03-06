<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package GovPress
 */

if ( ! function_exists( 'govpress_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * If the wp_pagenavi plugin is installed, it's pagination will be used.
 * See: http://wordpress.org/plugins/wp-pagenavi/
 *
 * @return void
 */
function govpress_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'govpress' ); ?></h1>
		<div class="nav-links">

			<?php if ( function_exists( 'wp_pagenavi' ) ) {

				wp_pagenavi();

			} else { ?>

				<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'govpress' ) ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'govpress' ) ); ?></div>
				<?php endif; ?>

			<?php } ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'govpress_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @return void
 */
function govpress_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'govpress' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'govpress' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link',     'govpress' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'govpress_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function govpress_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">Opublikowane %1$s</span><span class="byline"> przez %2$s</span>', 'govpress' ),
		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		)
	);
	
	echo '<p>';
  	comments_popup_link( '0 komentarzy - rozpocznij dyskusję!', '1 komentarz', '% komentarzy', 'comments-link', 
  	'Komentarze są wyłączone dla tego artykułu');
  	echo '</p>';
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 */
function govpress_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so govpress_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so govpress_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in govpress_categorized_blog.
 */
function govpress_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'govpress_category_transient_flusher' );
add_action( 'save_post',     'govpress_category_transient_flusher' );

/**
 * Removes wp-pagenavi styling since it is handled by theme
 */

function govfresh_deregister_styles() {
	wp_deregister_style( 'wp-pagenavi' );
}
add_action( 'wp_print_styles', 'govfresh_deregister_styles', 100 );
