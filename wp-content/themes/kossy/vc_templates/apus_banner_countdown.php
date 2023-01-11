<?php 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$time = strtotime( $input_datetime );

?>
<div class="banner-countdown-widget <?php echo esc_attr($el_class.' '.$style_widget); ?>">
    <?php if ($subtitle!=''): ?>
        <h3 class="sub-title">
            <?php echo esc_attr( $subtitle ); ?>
        </h3>
    <?php endif; ?>
    <?php if ($title!=''): ?>
        <h3 class="widget-title">
            <?php echo esc_attr( $title ); ?>
        </h3>
    <?php endif; ?>

	<div class="countdown-wrapper">
	    <div class="apus-countdown" data-time="timmer"
	         data-date="<?php echo date('m',$time).'-'.date('d',$time).'-'.date('Y',$time).'-'. date('H',$time) . '-' . date('i',$time) . '-' .  date('s',$time) ; ?>">
	    </div>
	</div>
	<?php if ( !empty($btn_url) && !empty($btn_text) ) { ?>
	    <a class="btn btn-theme btn-outline" href="<?php echo esc_attr($btn_url); ?>" ><?php echo esc_attr($btn_text); ?> <i class="fa fa-angle-right"></i> </a>
    <?php } ?>
</div>