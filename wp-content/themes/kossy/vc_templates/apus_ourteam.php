<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$members = (array) vc_param_group_parse_atts( $members );
if ( !empty($members) ):
?>
	<div class="widget-ourteam <?php echo esc_attr($el_class); ?>">
	    <?php if ($title!=''): ?>
	        <h3 class="widget-title">
	            <?php echo esc_attr( $title ); ?>
	        </h3>
	    <?php endif; ?>
	    <div class="widget-content">
	    	<div class="row">
	    		<?php foreach ($members as $item): ?>
	    			<div class="col-sm-6 col-xs-12 col-md-<?php echo esc_attr(12/$columns); ?>">	
						<div class="item-team">
							<div class="avarta">
								<?php if ( isset($item['image']) && !empty($item['image']) ): ?>
				                    <?php echo trim(kossy_get_attachment_thumbnail($item['image'], 'full')); ?>
			                    <?php endif; ?>
			                    <div class="social-team">
				                    <?php if ( isset($item['facebook']) && !empty($item['facebook']) ): ?>
				                    	<a href="<?php echo esc_url( $item['facebook'] ); ?>"><i class="fa fa-facebook"></i></a>
				                    <?php endif; ?>
				                    <?php if ( isset($item['twitter']) && !empty($item['twitter']) ): ?>
				                    	<a href="<?php echo esc_url( $item['twitter'] ); ?>"><i class="fa fa-twitter"></i></a>
				                    <?php endif; ?>
				                    <?php if ( isset($item['google']) && !empty($item['google']) ): ?>
				                    	<a href="<?php echo esc_url( $item['google'] ); ?>"><i class="fa fa-google-plus"></i></a>
				                    <?php endif; ?>
				                    <?php if ( isset($item['linkin']) && !empty($item['linkin']) ): ?>
				                    	<a href="<?php echo esc_url( $item['linkin'] ); ?>"><i class="fa fa-linkedin"></i></a>
				                    <?php endif; ?>
			                    </div>	
		                    </div>
		                    <div class="inner-content">
			                    <div class="info ">
				                    <?php if ( isset($item['name']) && !empty($item['name']) ): ?>
				                    	<h3 class="name-team"><?php echo trim($item['name']); ?></h3>
				                    <?php endif; ?>
				                    <?php if ( isset($item['job']) && !empty($item['job']) ): ?>
				                    	<div class="job-team"><?php echo trim($item['job']); ?></div>
				                    <?php endif; ?>
			                    </div>
			                    
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php endif; ?>