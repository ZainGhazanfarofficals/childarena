<?php

$GLOBALS['comment'] = $comment;
$add_below = '';

?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
	<div class="the-comment">
		<?php if(get_avatar($comment, 100)){ ?>
			<div class="avatar">
				<?php echo get_avatar($comment, 100); ?>
			</div>
		<?php } ?>
		<div class="comment-box">
			<div class="comment-author meta">
				<strong><?php echo get_comment_author_link() ?></strong>
				<span class="date"><i class="text-theme icon_clock" aria-hidden="true"></i><?php printf(esc_html__('%1$s', 'kossy'), get_comment_date()) ?></span><br/>
				
			</div>
			<div class="comment-text">
				<?php if ($comment->comment_approved == '0') : ?>
				<em><?php esc_html_e('Your comment is awaiting moderation.', 'kossy') ?></em>
				<br />
				<?php endif; ?>
				<?php comment_text() ?>
			</div>
			<?php comment_reply_link(array_merge( $args, array( 'reply_text' => esc_html__(' Reply', 'kossy'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			<?php edit_comment_link(esc_html__('Edit', 'kossy'),'  ','') ?>
		</div>
	</div>
</li>