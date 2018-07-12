<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bloma
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<header class="<?php if ( is_home()) { 
	echo 'entry-header entry-header--index';
	 } else { 
		 echo 'entry-header';
	 }
		 ; ?> ">
		<?php bloma_post_thumbnail(); ?>
	<div class="entry-header__content">

		<?php
		bloma_categories();
		
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
			
			if ( 'post' === get_post_type() ) :
				?>
			<div class="entry-meta">
				<?php
				bloma_posted_on();
				bloma_posted_by();
				?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</div> <!-- .entry-header__content-->
	</header><!-- .entry-header -->


	<div class="entry-content">
		<?php
		     
      the_excerpt();
          
          ?>
          <a href="<?php echo esc_url( get_permalink() ) ?>" class="read-more__link--archive">read more...</a>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php bloma_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
