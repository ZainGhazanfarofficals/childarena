<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if (isset($category) && !empty($category)):
	$category = get_term_by( 'slug', $category, 'product_cat' );
	if ( !empty($category) ):
		?>
		<div class="widget-categorybanner">
			<?php if($style == 'style2'){ ?>
				<div class="grid-banner-category2 <?php echo esc_attr($el_class); ?>">
			        <div class="category-wrapper">
			        	<a class="link-action" href="<?php echo esc_url(get_term_link($category)); ?>">
			                <?php
				                if ( isset($image) && $image ) {
				                	echo trim(kossy_get_attachment_thumbnail($image, 'full'));
				                }
			                ?>
			                <div class="info">
			                	<span class="sub"><?php echo esc_html__('SHOP BY','kossy') ?></span>
			                	<h2 class="title" data-title="<?php echo esc_attr($category->name); ?>">
			                		<?php if ( !empty($title) ) { ?>
		                                <?php echo trim($title); ?>
		                            <?php } else { ?>
		                                <?php echo trim($category->name); ?>
		                            <?php } ?>
		                        </h2>
		                    </div>
		                </a>
			        </div>
		        </div>
	        <?php }else{ ?>
	        	<div class="grid-banner-category <?php echo esc_attr($el_class); ?>">
			        <div class="category-wrapper">
			        	<a class="link-action" href="<?php echo esc_url(get_term_link($category)); ?>">
			                <?php
				                if ( isset($image) && $image ) {
				                	echo trim(kossy_get_attachment_thumbnail($image, 'full'));
				                }
			                ?>
			                <div class="info">
			                	<h2 class="title" data-title="<?php echo esc_attr($category->name); ?>">
			                		<?php if ( !empty($title) ) { ?>
		                                <?php echo trim($title); ?>
		                            <?php } else { ?>
		                                <?php echo trim($category->name); ?>
		                            <?php } ?>
		                        </h2>
		                    </div>
		                </a>
			        </div>
		        </div>
	        <?php } ?>
		</div>
		<?php
	endif;
endif;