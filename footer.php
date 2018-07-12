<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bloma
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

	<?php

			bloma_instagram_bar(); /* Including bloma instagram bar widget*/
			bloma_socialbar('footer-social-bar'); /* Including bloma social bar widget*/

			wp_nav_menu( array(
				'theme_location' => 'menu-2',
				'menu_id'        => 'footer-menu',
				'menu_class'     => 'footer-nav',
				'container'      => 'nav',
			) );
			?>
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'bloma' ) ); ?>"> 
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'bloma' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'bloma' ), 'bloma', '<a href="http://github.com/mksdziag">mksdziag</a>' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
