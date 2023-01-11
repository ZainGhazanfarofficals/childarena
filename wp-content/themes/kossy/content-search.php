<?php
/**
 * The template part for displaying results in search pages
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Kossy
 * @since Kossy 1.0
 */
?>
<article <?php post_class('post post-layout post-grid-v1'); ?>>
    <div class="content">
        <div class="top-info-grid">
            <span class="author"><span class="sub"><?php echo esc_html__('by','kossy'); ?></span> <a class="name-author" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                <?php echo get_the_author(); ?>
            </a></span>
            <span class="date-post"><?php the_time( get_option('date_format', 'd M, Y') ); ?></span>
            <span class="comments"><?php comments_number( esc_html__('0 Comments', 'kossy'), esc_html__('1 Comment', 'kossy'), esc_html__('% Comments', 'kossy') ); ?></span>
        </div>
        <?php if (get_the_title()) { ?>
            <h4 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
        <?php } ?>
        <?php if(get_the_excerpt()) {?>
            <div class="excerpt"><?php echo kossy_substring( get_the_excerpt(), 12, '[…]' ); ?></div>
        <?php } ?>
        <a class="btn-more" href="<?php the_permalink(); ?>"><?php echo esc_html__('Read More','kossy'); ?><i class="arrow_right"></i> </a>
    </div>
</article>