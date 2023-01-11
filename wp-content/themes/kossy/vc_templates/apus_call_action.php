<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
?>
<div class="clearfix widget-action <?php echo esc_attr($el_class.' '.$style); ?>">
    <?php if($style == 'titletop') {?>
        <?php if(wpb_js_remove_wpautop( $content, true )){ ?>
            <div class="title">
                <?php echo wpb_js_remove_wpautop( $content, true ); ?>
            </div>
        <?php } ?>
    <?php } ?>
    <?php if($sub_title!=''): ?>
        <div class="sub_title">
           <?php echo esc_attr( $sub_title ); ?>
        </div>
    <?php endif; ?>
    <?php if($style != 'titletop') {?>
        <?php if(wpb_js_remove_wpautop( $content, true )){ ?>
            <div class="title">
                <?php echo wpb_js_remove_wpautop( $content, true ); ?>
            </div>
        <?php } ?>
    <?php } ?>
    <?php if (!empty($des)) { ?>
        <div class="des">
            <?php echo trim( $des ); ?>
        </div>
    <?php } ?>
    <?php if(trim($linkbutton1)!='' || trim($linkbutton2)!='' ){ ?>
        <div class="action">
            <?php if(trim($linkbutton1)!=''){ ?>
            <a class="btn <?php echo esc_attr( $buttons1 ); ?>" href="<?php echo esc_attr( $linkbutton1 ); ?>"> <span><?php echo trim( $textbutton1 ); ?></span> </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>