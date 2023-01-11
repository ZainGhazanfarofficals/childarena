<?php
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}
$args = array(
	'post_type' => 'post',
	'posts_per_page' => $number_post
);

$query = new WP_Query($args);
if($query->have_posts()):
?>
<div class="post-widget">
<ul class="posts-list">
<?php
	while($query->have_posts()):$query->the_post();
?>
	<li>
		<article class="post post-list">
		    <div class="entry-content">
		    	<?php
					if(has_post_thumbnail()){
				?>
					<a href="<?php the_permalink(); ?>" class="image pull-left">
						<?php the_post_thumbnail( 'kossy-post-small' ); ?>
					</a>
				<?php } ?>
				<div class="content-info">
			         <?php
			              if (get_the_title()) {
			              ?>
			                  <h4 class="entry-title">
			                      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			                  </h4>
			              <?php
			          }
			        ?>
			        <div class="bottom-info">
				        <span class="date-post"><i class="icon_clock_alt" aria-hidden="true"></i><?php the_time( get_option('date_format', 'd M, Y') ); ?></span>
				        <span class="author"> <?php echo esc_html__('by','kossy') ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
			                <?php echo get_the_author(); ?>
			            </a></span>
		            </div>
			    </div>
		    </div>
		</article>
	</li>
<?php endwhile; ?>
<?php wp_reset_postdata(); ?>
</ul>
</div>
<?php endif; ?>