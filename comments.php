<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to govpress_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package GovPress
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _nx( 'Jeden komentarz na temat &ldquo;%2$s&rdquo;', '%1$s komentarze na temat &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'govpress' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'govpress' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Starsze komentarze', 'govpress' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Nowsze komentarze &rarr;', 'govpress' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 55,
					'max_depth'	  => '3'
				) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'govpress' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'govpress' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'govpress' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'govpress' ); ?></p>
	<?php endif; ?>

	<?php 
		if(is_user_logged_in())
	    {
	       comment_form();  
	    }
	    else
	    {
	        $comment_args = array(
	            'comment_notes_before' => 'Twój adres email nie zostanie opublikowany. Pola, których wypełnienie jest wymagane, są oznaczone symbolem * <br><br> <b>Teraz masz możliwość komentowania za pomocą swojego profilu na Facebooku.</b>
	            <a href="http://woofla.pl/wp-login.php?loginFacebook=1&amp;redirect=' . get_permalink($post->ID) . '" rel="nofollow"><div class="new-fb-btn new-fb-1 new-fb-default-anim"><div class="new-fb-1-1"><div class="new-fb-1-1-1">ZALOGUJ SIĘ</div></div></div></a>'
	        );
	        comment_form($comment_args);
	        
	    }
	?>

</div><!-- #comments -->
