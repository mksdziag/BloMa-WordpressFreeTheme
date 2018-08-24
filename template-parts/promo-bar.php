<div class="promo-bar">  
	<ul class="promo-bar__list">
	<?php 
   // the query
   $the_query = new WP_Query( array(
			'posts_per_page' => 3,
      'ignore_sticky_posts' => 1,
      'meta_key' => '_thumbnail_id',
   )); 
	?>



	<?php if ( $the_query->have_posts() ) : ?>
  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

		<li class="promo-bar__list-item" 
		style="background-image: linear-gradient(rgba(77, 77, 77, 0.6), rgba(77, 77, 77, 0.6)), url('<?php echo get_the_post_thumbnail_url(); ?>');">
							
		
			<header class="entry-header">
		
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
						?>
					</div><!-- .entry-meta -->
					<?php endif; ?>
				</div> <!-- .entry-header__content-->
			</header><!-- .entry-header -->
		
			
	  </li>




  <?php endwhile; ?>
  <?php wp_reset_postdata(); ?>

	</ul>
	<!-- <?php else : ?>
		<p><?php __('No News'); ?></p>
	<?php endif; ?> -->


</div>