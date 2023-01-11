<?php

global $post;
$args = array( 'position' => 'top', 'animation' => 'true' );
?>
<div class="apus-social-share">
		<div class="bo-social-icons bo-sicolor social-radius-rounded">
		<span class="title"><?php esc_html_e('Share Link:','kossy'); ?> </span>
		<?php if ( kossy_get_config('facebook_share', 1) ): ?>
 
			<a class="bo-social-facebook" data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>" href="http://www.facebook.com/sharer.php?s=100&p&#91;url&#93;=<?php the_permalink(); ?>&p&#91;title&#93;=<?php the_title(); ?>" target="_blank" title="<?php esc_attr_e('Share on facebook', 'kossy'); ?>">
				<i class="fa fa-facebook"></i>
			</a>
 
		<?php endif; ?>
		<?php if ( kossy_get_config('twitter_share', 1) ): ?>
 
			<a class="bo-social-twitter"  data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>" href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" target="_blank" title="<?php esc_attr_e('Share on Twitter', 'kossy'); ?>">
				<i class="fa fa-twitter"></i>
			</a>
 
		<?php endif; ?>
		<?php if ( kossy_get_config('linkedin_share', 1) ): ?>
 
			<a class="bo-social-linkedin"  data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>" href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" target="_blank" title="<?php esc_attr_e('Share on LinkedIn', 'kossy'); ?>">
				<i class="fa fa-linkedin"></i>
			</a>
 
		<?php endif; ?>
		<?php if ( kossy_get_config('tumblr_share', 1) ): ?>
 
			<a class="bo-social-tumblr" data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>" href="http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink()); ?>&amp;name=<?php echo urlencode($post->post_title); ?>&amp;description=<?php echo urlencode(get_the_excerpt()); ?>" target="_blank" title="<?php esc_attr_e('Share on Tumblr', 'kossy'); ?>">
				<i class="fa fa-tumblr"></i>
			</a>
 
		<?php endif; ?>
		<?php if ( kossy_get_config('google_share', 1) ): ?>
 
			<a class="bo-social-google" data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
	'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" title="<?php esc_attr_e('Share on Google plus', 'kossy'); ?>">
				<i class="fa fa-google-plus"></i>
			</a>
 
		<?php endif; ?>
		<?php if ( kossy_get_config('pinterest_share', 1) ): ?>
 
			<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
			<a class="bo-social-pinterest" data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&amp;description=<?php echo urlencode($post->post_title); ?>&amp;media=<?php echo urlencode($full_image[0]); ?>" target="_blank" title="<?php esc_attr_e('Share on Pinterest', 'kossy'); ?>">
				<i class="fa fa-pinterest"></i>
			</a>
 
		<?php endif; ?>
	</div>
</div>	