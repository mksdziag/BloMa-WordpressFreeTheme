<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bloma
 */

if ( ! function_exists( 'bloma_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function bloma_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( '%s', 'post date', 'bloma' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'bloma_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */

	 function bloma_posted_by() {
	 	$byline = sprintf(
	 		/* translators: %s: post author. */
	 		esc_html_x( 'by %s', 'post author', 'bloma' ),
	 		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	 	);

	 	echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	 }
endif;

if ( ! function_exists( 'bloma_categories' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function bloma_categories() {
		/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( '| ', 'bloma' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( '%1$s', 'bloma' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}
			}
endif;

if ( ! function_exists( 'bloma_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function bloma_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			// $categories_list = get_the_category_list( esc_html__( ', ', 'bloma' ) );
			// if ( $categories_list ) {
			// 	/* translators: 1: list of categories. */
			// 	printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'bloma' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			// }

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ' ', 'list item separator', 'bloma' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( '%1$s', 'bloma' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'bloma' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}
		
		?>
		<!-- Share entry footer bar -->
		<div class="share-bar">

			<ul class="share-bar__list"><span class="share-bar__title">Share </span>
				<li class="share-bar__list-item">
				<a href="https://twitter.com/share?ref_src=twsrc%5Etfw"  target="_blank" class="share-bar__link" ><i class="share-bar__icon icon-twitter"></i></a>
				</li>
				<li class="share-bar__list-item">
					<a href="https://www.pinterest.com/pin/create/button/?url=<?php the_permalink( ); ?>&description=<?php the_title( ); ?>" target="_blank" class="share-bar__link fb-share-button"><i class="share-bar__icon icon-pinterest"></i></a>
				</li>
				<li class="share-bar__list-item">
					<a href="https://facebook.com/sharer/sharer.php?u=<?php the_permalink( ); ?>" target="_blank" class="share-bar__link fb-share-button"><i class="share-bar__icon icon-facebook-squared"></i></a>
				</li>
			</ul>
		</div>
							
		<?php 
							
							
			edit_post_link(
					sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'bloma' ),
					array(
						'span' => array(
						'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'bloma_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function bloma_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;


function bloma_excerpt_more($more) {
return ' ...';

	
};

add_filter( 'excerpt_more', 'bloma_excerpt_more' );



if ( ! function_exists( 'bloma_socialbar' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */

	 function bloma_socialbar($socialBarExtraClass = NULL) { ?>

		<div class="social-bar__wrapper <? echo $socialBarExtraClass ?>">
			<ul class="social-bar__list">
			<?php  if (get_option('myInstagram')){ ?>
				<li class="social-bar__list-item">
					<a href="https://<?php echo get_option('myInstagram'); ?>" target="_blank" class="social-bar__link"><i class="social-bar__icon icon-instagram"></i></a>
				</li>
				<?php } ?>
			<?php  if (get_option('myYoutube')){ ?>
				<li class="social-bar__list-item">
					<a href="https://<?php echo get_option('myYoutube'); ?>" target="_blank" class="social-bar__link"><i class="social-bar__icon icon-youtube-play"></i></a>
				</li>
				<?php } ?>
			<?php  if (get_option('myBehance')){ ?>
				<li class="social-bar__list-item">
					<a href="https://<?php echo get_option('myBehance'); ?>" target="_blank" class="social-bar__link"><i class="social-bar__icon icon-behance"></i></a>
				</li>
				<?php } ?>
			<?php  if (get_option('myPinterest')){ ?>
				<li class="social-bar__list-item">
					<a href="https://<?php echo get_option('myPinterest'); ?>" target="_blank" class="social-bar__link"><i class="social-bar__icon icon-pinterest"></i></a>
				</li>
				<?php } ?>
			<?php  if (get_option('myFacebook')){ ?>
				<li class="social-bar__list-item">
					<a href="https://<?php echo get_option('myFacebook'); ?>" target="_blank" class="social-bar__link"><i class="social-bar__icon icon-facebook-squared"></i></a>
				</li>
				<?php } ?>
			<?php  if (get_option('myGooglePlus')){ ?>
				<li class="social-bar__list-item">
					<a href="https://<?php echo get_option('myGooglePlus'); ?>" target="_blank" class="social-bar__link"><i class="social-bar__icon icon-gplus"></i></a>
				</li>
				<?php } ?>
			</ul>
		</div>
		<?php }
endif;

if ( ! function_exists( 'bloma_instagram_bar' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */

	 function bloma_instagram_bar() { 
		 $instagramLink = get_option('myInstagram'); ?>

		<div class="instagram-bar__wrapper">
			<ul class="instagram-bar__list">
				<li class="instagram-bar__list-item">
					<a href="<?php echo $instagramLink ?>" target="_blank" title="my instagram profile" alt="my instagram profile" class="instagram-bar__link" style="background-image: url('https://picsum.photos/500/500/?image=600')"></a>
				</li>
				<li class="instagram-bar__list-item">
					<a href="https://<?php echo $instagramLink ?>" target="_blank" title="my instagram profile" alt="my instagram profile" class="instagram-bar__link" style="background-image:url('https://picsum.photos/500/500/?image=611')"></a>
				</li>
				<li class="instagram-bar__list-item">
					<a href="https://<?php echo $instagramLink ?>" target="_blank" title="my instagram profile" alt="my instagram profile" class="instagram-bar__link" style="background-image:url('https://picsum.photos/500/500/?image=421')"></a>
				</li>
				<li class="instagram-bar__list-item">
					<a href="https://<?php echo $instagramLink ?>" target="_blank" title="my instagram profile" alt="my instagram profile" class="instagram-bar__link" style="background-image:url('https://picsum.photos/500/500/?image=343')"></a>
				</li>
				<li class="instagram-bar__list-item">
					<a href="https://<?php echo $instagramLink ?>" target="_blank" title="my instagram profile" alt="my instagram profile" class="instagram-bar__link" style="background-image:url('https://picsum.photos/500/500/?image=604')"></a>
				</li>
				<li class="instagram-bar__list-item">
					<a href="https://<?php echo $instagramLink ?>" target="_blank" title="my instagram profile" alt="my instagram profile" class="instagram-bar__link" style="background-image:url('https://picsum.photos/500/500/?image=615')"></a>
				</li>
				<li class="instagram-bar__list-item">
					<a href="https://<?php echo $instagramLink ?>" target="_blank" title="my instagram profile" alt="my instagram profile" class="instagram-bar__link" style="background-image:url('https://picsum.photos/500/500/?image=676')"></a>
				</li>
				<li class="instagram-bar__list-item">
					<a href="https://<?php echo $instagramLink ?>" target="_blank" title="my instagram profile" alt="my instagram profile" class="instagram-bar__link" style="background-image:url('https://picsum.photos/500/500/?image=427')"></a>
				</li>
				
				
			</ul>
		</div>

		
		<?php }
endif;

