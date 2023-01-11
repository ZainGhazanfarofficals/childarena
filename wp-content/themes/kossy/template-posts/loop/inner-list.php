<?php 
$thumbsize = !isset($thumbsize) ? kossy_get_config( 'blog_item_thumbsize', 'full' ) : $thumbsize;
$thumb = kossy_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout post-list-item'); ?>>
    <div class="list-inner ">
        <div class="row flex-middle">
            <?php
                if ( !empty($thumb) ) {
                    ?>
                    <div class="image col-xs-5">
                        <?php echo trim($thumb); ?>
                    </div>
                    <?php
                }
            ?>
            <div class="content <?php echo esc_attr(!empty($thumb)?'col-xs-7':'col-xs-12'); ?>">
                <?php if (get_the_title()) { ?>
                    <h4 class="entry-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h4>
                <?php } ?>
                <div class="top-info-grid">
                    <span class="author"><span class="sub"><?php echo esc_html__('by','kossy'); ?></span> <a class="name-author" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                        <?php echo get_the_author(); ?>
                    </a></span>
                    <span class="date-post"><?php the_time( get_option('date_format', 'd M, Y') ); ?></span>
                    <span class="comments"><?php comments_number( esc_html__('0 Comments', 'kossy'), esc_html__('1 Comment', 'kossy'), esc_html__('% Comments', 'kossy') ); ?></span>
                </div>
                <?php if(get_the_excerpt()) {?>
                    <div class="excerpt hidden-xs"><?php echo kossy_substring( get_the_excerpt(), 22, '...' ); ?></div>
                <?php } ?>
            </div>
        </div>
    </div>
</article>