<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$img = wp_get_attachment_image_src($image, 'full');
$bg_color = $bg_color?'style="background-color:'. $bg_color .';"' : "";
?>
<div class="widget-banner clearfix <?php echo esc_attr($el_class.$style);if(isset($img[0])) echo ' has-img'; ?>" <?php echo trim($bg_color); ?>>
    <?php if($style == 'st_right inner_center') { ?>
        <div class="infor">
            <?php if ($subtitle!=''): ?>
                <h3 class="subtitle">
                    <?php echo trim( $subtitle ); ?>
                </h3>
            <?php endif; ?>
            <?php if ($title!=''): ?>
                <h3 class="title">
                    <?php echo trim( $title ); ?>
                </h3>
            <?php endif; ?>
            <?php if ( !empty($url)) { ?>
                <div class="more">
                  <a href="<?php echo esc_url($url); ?>" class="btn-readmore"><?php echo trim( $textbutton ); ?></a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <?php if ( $url ) { ?>
        <a class="link-img" href="<?php echo esc_url($url); ?>">
    <?php } ?>
        <?php echo trim(kossy_get_attachment_thumbnail($image, 'full')); ?>
    <?php if ( $url ) { ?>
        </a>
    <?php } ?>
    <?php if($style != 'st_right inner_center') { ?>
        <div class="infor">
            <?php if ($subtitle!=''): ?>
                <h3 class="subtitle">
                    <?php echo trim( $subtitle ); ?>
                </h3>
            <?php endif; ?>
            <?php if ($title!=''): ?>
                <h3 class="title">
                    <?php echo trim( $title ); ?>
                </h3>
            <?php endif; ?>
            <?php if ( !empty($url)) { ?>
                <div class="more">
                  <a href="<?php echo esc_url($url); ?>" class="btn-readmore"><?php echo trim( $textbutton ); ?></a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>