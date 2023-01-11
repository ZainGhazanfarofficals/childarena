<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$img = wp_get_attachment_image_src($image, 'full');
?>
<div class="widget-banner-img  <?php echo esc_attr($el_class); ?>">
    <?php if ( $url ) { ?>
        <a class="link-img" href="<?php echo esc_url($url); ?>">
    <?php } ?>
        <?php echo trim(kossy_get_attachment_thumbnail($image, 'full')); ?>
    <?php if ( $url ) { ?>
        </a>
    <?php } ?>
    <div class="infor">
        <?php if($style != 'style1'){ ?>
            <?php if ($subtitle!=''): ?>
                <h3 class="subtitle">
                    <?php echo trim( $subtitle ); ?>
                </h3>
            <?php endif; ?>
        <?php } ?>
        <?php if ($title!=''): ?>
            <h3 class="title">
                <?php if ( $url ) { ?>
                    <a href="<?php echo esc_url($url); ?>">
                <?php } ?>
                    <?php echo trim( $title ); ?>
                <?php if ( $url ) { ?>
                    </a>
                <?php } ?>
            </h3>
        <?php endif; ?>
        <?php if($style == 'style1'){ ?>
            <?php if ($subtitle!=''): ?>
                <h3 class="subtitle">
                    <?php echo trim( $subtitle ); ?>
                </h3>
            <?php endif; ?>
        <?php } ?>
    </div>
</div>