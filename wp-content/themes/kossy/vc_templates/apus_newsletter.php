<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
?>
<div class="widget-newletter clearfix <?php echo esc_attr($el_class.' '.$style);?>">
	<div class="top-inner">
    <?php if ($title!=''): ?>
        <h3 class="widget-title">
            <span><?php echo esc_attr( $title ); ?></span>
        </h3>
    <?php endif; ?>
    <?php if (!empty($description)) { ?>
		<div class="description">
			<?php echo trim( $description ); ?>
		</div>
	<?php } ?>
	</div>
	<div class="content"> 
		<?php
			if ( function_exists( 'mc4wp_show_form' ) ) {
			  	try {
			  	    $form = mc4wp_get_form(); 
					mc4wp_show_form( $form->ID );
				} catch( Exception $e ) {
				 	esc_html_e( 'Please create a newsletter form from Mailchip plugins', 'kossy' );	
				}
			}
		?>
	</div>
</div>