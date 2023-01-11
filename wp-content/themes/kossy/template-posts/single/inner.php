<?php
$post_format = get_post_format();
global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="top-info">
        <?php if ( $post_format == 'gallery' ) {
            $gallery = kossy_post_gallery( get_the_content(), array( 'size' => 'full' ) );
        ?>
            <div class="entry-thumb <?php echo  (empty($gallery) ? 'no-thumb' : ''); ?>">
                <?php echo trim($gallery); ?>
            </div>
        <?php } elseif( $post_format == 'link' ) {
                $format = kossy_post_format_link_helper( get_the_content(), get_the_title() );
                $title = $format['title'];
                $link = kossy_get_link_attributes( $title );
                $thumb = kossy_post_thumbnail('', $link);
                echo trim($thumb);
            } else { ?>
            <div class="entry-thumb <?php echo  (!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
                <?php
                    $thumb = kossy_post_thumbnail();
                    echo trim($thumb);
                ?>
            </div>
        <?php } ?>
    </div>
	<div class="entry-content-detail">
        <div class="top-info-grid">
            <span class="author"><span class="sub"><?php echo esc_html__('by','kossy'); ?></span> <a class="name-author" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                <?php echo get_the_author(); ?>
            </a></span>
            <span class="date-post"><?php the_time( get_option('date_format', 'd M, Y') ); ?></span>
            <span class="comments"><?php comments_number( esc_html__('0 Comments', 'kossy'), esc_html__('1 Comment', 'kossy'), esc_html__('% Comments', 'kossy') ); ?></span>
        </div>
        <?php if (get_the_title()) { ?>
            <h4 class="entry-title">
                <?php the_title(); ?>
            </h4>
        <?php } ?>
    	<div class="single-info info-bottom">
            <div class="entry-description">
                <?php
                    if ( $post_format == 'gallery' ) {
                        $gallery_filter = kossy_gallery_from_content( get_the_content() );
                        echo trim($gallery_filter['filtered_content']);
                    } else {
                        the_content();
                    }
                ?>
            </div><!-- /entry-content -->
    		<?php
    		wp_link_pages( array(
    			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'kossy' ) . '</span>',
    			'after'       => '</div>',
    			'link_before' => '<span>',
    			'link_after'  => '</span>',
    			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'kossy' ) . ' </span>%',
    			'separator'   => '',
    		) );
    		?>
    		<div class="tag-social clearfix">
                <div class="pull-left">
                    <?php kossy_post_tags(); ?>
                </div>
                <div class="pull-right">
    			 <?php if( kossy_get_config('show_blog_social_share', false) ) {
    					get_template_part( 'template-parts/sharebox' );
    				} ?>
                </div>
    		</div>
    	</div>
    </div>
</article>