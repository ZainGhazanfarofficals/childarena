<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$members = (array) vc_param_group_parse_atts( $members );
if ( !empty($members) ):
?>
	<div class="widget-stage <?php echo esc_attr($el_class); ?>">
	    <div class="widget-content">
    		<?php foreach ($members as $item): ?>
				<div class="item-stage clearfix">
                    <?php if ( isset($item['number']) && !empty($item['number']) ): ?>
                    	<div class="info-left">
                    		<?php echo trim($item['number']); ?>
                    	</div>
                    <?php endif; ?>
                    <div class="right-stage">
	                    <?php if ( isset($item['name']) && !empty($item['name']) ): ?>
	                    	<h3 class="stage-title"><?php echo trim($item['name']); ?></h3>
	                    <?php endif; ?>
	                    <?php if ( isset($item['des']) && !empty($item['des']) ): ?>
	                    	<div class="des"><?php echo trim($item['des']); ?></div>
	                    <?php endif; ?>
                    </div>	
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>