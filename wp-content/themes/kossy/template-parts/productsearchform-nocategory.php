<?php if ( kossy_get_config('show_searchform') ):
	$class = kossy_get_config('enable_autocompleate_search', true) ? ' apus-autocompleate-input' : '';
?>
	<div class="apus-search-form search-fix clearfix">
		<div class="inner-search">
			<div class="heading-search clearfix">
				<div class="pull-left title-top-search"><?php echo esc_html__('Just start searching...','kossy') ?></div>
				<div class="pull-right">
					<span class="close-search-fix"> <i class="ti-close"></i></span>
				</div>
			</div>
			<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
				<div class="main-search">
					<?php if ( kossy_get_config('enable_autocompleate_search', true) ) echo '<div class="twitter-typeahead">'; ?>
				  		<input type="text" placeholder="<?php esc_attr_e( 'Search products here...', 'kossy' ); ?>" name="s" class="apus-search form-control <?php echo esc_attr($class); ?>"/>
					<?php if ( kossy_get_config('enable_autocompleate_search', true) ) echo '</div>'; ?>
				</div>
				<input type="hidden" name="post_type" value="product" class="post_type" />
			</form>
		</div>
	</div>
<?php endif; ?>