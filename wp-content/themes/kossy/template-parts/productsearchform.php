<?php if ( kossy_get_config('show_searchform') ):
	$class = kossy_get_config('enable_autocompleate_search', true) ? ' apus-autocompleate-input' : '';
?>
	<div class="apus-search-form">
		<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
			<?php 
				$args = array(
				    'show_count' => 0,
				    'hierarchical' => true,
				    'show_uncategorized' => 0
				);
				echo '<div class="select-category">';
					wc_product_dropdown_categories( $args );
				echo '</div>';
			?>
			<div class="main-search">
				<?php if ( kossy_get_config('enable_autocompleate_search', true) ) echo '<div class="twitter-typeahead">'; ?>
			  		<input type="text" placeholder="<?php esc_attr_e( 'What do you need?', 'kossy' ); ?>" name="s" class="apus-search form-control <?php echo esc_attr($class); ?>"/>
				<?php if ( kossy_get_config('enable_autocompleate_search', true) ) echo '</div>'; ?>
			</div>
			<input type="hidden" name="post_type" value="product" class="post_type" />
			
			<button type="submit" class="btn btn-theme radius-0"><?php esc_html_e('SEARCH', 'kossy'); ?></button>
		</form>
	</div>
<?php endif; ?>