<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
?>
<div class="widget-text-heading <?php echo esc_attr($el_class).' '.esc_attr($style); ?>">
    <?php if ( trim($title)!='' ) { ?>
        <h3 class="title">
            <?php echo trim( $title ); ?>
        </h3>
    <?php } ?>
    <?php if (!empty($des)) { ?>
        <div class="des">
            <?php echo trim( $des ); ?>
        </div>
    <?php } ?>
</div>