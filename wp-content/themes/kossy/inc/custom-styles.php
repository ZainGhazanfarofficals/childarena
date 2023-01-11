<?php
if ( !function_exists ('kossy_custom_styles') ) {
	function kossy_custom_styles() {
		global $post;	
		
		ob_start();	
		?>
		
			<?php
				$font_source = kossy_get_config('font_source');
				$main_font = kossy_get_config('main_font');
				$main_font = isset($main_font['font-family']) ? $main_font['font-family'] : false;
				$main_google_font_face = kossy_get_config('main_google_font_face');
			?>
			<?php if ( ($font_source == "1" && $main_font) || ($font_source == "2" && $main_google_font_face) ): ?>
				h1, h2, h3, h4, h5, h6, .widget-title,.widgettitle
				{
					font-family: 
					<?php if ( $font_source == "2" ) echo '\'' . $main_google_font_face . '\','; ?>
					<?php if ( $font_source == "1" ) echo '\'' . $main_font . '\','; ?> 
					sans-serif;
				}
			<?php endif; ?>
			/* Second Font */
			<?php
				$secondary_font = kossy_get_config('secondary_font');
				$secondary_font = isset($secondary_font['font-family']) ? $secondary_font['font-family'] : false;
				$secondary_google_font_face = kossy_get_config('secondary_google_font_face');
			?>
			<?php if ( ($font_source == "1" && $secondary_font) || ($font_source == "2" && $secondary_google_font_face) ): ?>
				body
				{
					font-family: 
					<?php if ( $font_source == "2" ) echo '\'' . $secondary_google_font_face . '\','; ?>
					<?php if ( $font_source == "1" ) echo '\'' . $secondary_font . '\','; ?> 
					sans-serif;
				}			
			<?php endif; ?>

			
			<?php if ( kossy_get_config('main_color') != "" ) : ?>
				/* seting background main */
				.widget-banner:hover .btn-readmore,
				.wishlist-icon .count, .mini-cart .count,
				.bg-theme
				{
					background-color: <?php echo esc_html( kossy_get_config('main_color') ) ?> ;
				}
				/* setting color*/
				.dark-menu-sidebar .navbar-offcanvas .navbar-nav li:hover > .icon-toggle, .dark-menu-sidebar .navbar-offcanvas .navbar-nav li:hover > a, .dark-menu-sidebar .navbar-offcanvas .navbar-nav li.active > .icon-toggle, .dark-menu-sidebar .navbar-offcanvas .navbar-nav li.active > a,
				.navbar-nav.megamenu .dropdown-menu li > a:hover, .navbar-nav.megamenu .dropdown-menu li > a:active,
				.address-contact .number-phone,
				.widget_meta ul li a:hover, .widget_meta ul li a:active, .widget_archive ul li a:hover, .widget_archive ul li a:active, .widget_recent_entries ul li a:hover, .widget_recent_entries ul li a:active, .widget_categories ul li a:hover, .widget_categories ul li a:active,
				.wishlist-icon:hover, .wishlist-icon:active, .mini-cart:hover, .mini-cart:active,
				.grid-banner-category .title::before,
				.widget-action .font-second,
				.widget-action.classic .title,
				.widget-action.st_white1 .sub_title,
				.widget-banner.st_right .title,
				.widget-banner.st_left .subtitle,
				.apus-shop-menu ul.apus-categories li.current-cat > a,
				.apus-price-filter li.current, .apus-price-filter li.active, .apus-product-sorting li.current, .apus-product-sorting li.active,
				.apus-price-filter li a:hover, .apus-price-filter li a:active, .apus-product-sorting li a:hover, .apus-product-sorting li a:active,
				a:hover,a:active,a:focus,
				.btn-link{
					color: <?php echo esc_html( kossy_get_config('main_color') ) ?>;
				}
				/* setting border color*/

				.border-theme{
					border-color: <?php echo esc_html( kossy_get_config('main_color') ) ?> !important;
				}
				.tabs-v1 .nav-tabs li:focus > a:focus, .tabs-v1 .nav-tabs li:focus > a:hover, .tabs-v1 .nav-tabs li:focus > a, .tabs-v1 .nav-tabs li:hover > a:focus, .tabs-v1 .nav-tabs li:hover > a:hover, .tabs-v1 .nav-tabs li:hover > a, .tabs-v1 .nav-tabs li.active > a:focus, .tabs-v1 .nav-tabs li.active > a:hover, .tabs-v1 .nav-tabs li.active > a,
				.product-block p.price, .product-block span.price, .woocommerce div.product p.price, .woocommerce div.product span.price,
				.text-theme{
					color: <?php echo esc_html( kossy_get_config('main_color') ) ?> !important;
				}
			<?php endif; ?>

			<?php if ( kossy_get_config('button_color') != "" ) : ?>
				/* check button color */
				.btn-theme.btn-outline
				{
					color: <?php echo esc_html( kossy_get_config('button_color') ); ?>;
				}

				/* check second background color */
				.apus-loadmore-btn,
				.add-fix-top,
				.btn-theme
				{
					background-color: <?php echo esc_html( kossy_get_config('button_color') ); ?>;
				}
				/* check second border color */

				.btn-outline.btn-theme,
				.btn-theme
				{
					border-color: <?php echo esc_html( kossy_get_config('button_color') ); ?>;
				}

			<?php endif; ?>

			<?php if ( kossy_get_config('button_hover_color') != "" ) : ?>
				.text-theme-second
				{
					color: <?php echo esc_html( kossy_get_config('button_hover_color') ); ?>;
				}
				/* check second background color */
				.apus-loadmore-btn:hover,
				.apus-loadmore-btn:active,
				.apus-loadmore-btn:focus,
				.product-block.grid .yith-wcwl-add-to-wishlist a:not(.add_to_wishlist),
				.product-block.grid .compare:hover, .product-block.grid .compare:active,
				.product-block.grid .groups-button .add-cart .added_to_cart:hover, .product-block.grid .groups-button .add-cart .added_to_cart:active, .product-block.grid .groups-button .add-cart .button:hover, .product-block.grid .groups-button .add-cart .button:active,
				.product-block.grid .groups-button .add-cart .added_to_cart,
				.product-block.grid .yith-wcwl-add-to-wishlist a:hover,
				.product-block.grid .compare.added,
				.product-block.grid .compare.added::before,
				.add-fix-top:focus, .add-fix-top:active, .add-fix-top:hover,
				.btn-theme.btn-outline:hover, .btn-outline.viewmore-products-btn:hover, .btn-theme.btn-outline:active, .btn-outline.viewmore-products-btn:active,
				.btn-theme:hover, .btn-theme:focus, .btn-theme:active, .btn-theme.active, .open > .btn-theme.dropdown-toggle
				{
					background-color: <?php echo esc_html( kossy_get_config('button_hover_color') ); ?>;
				}

				.btn-theme.btn-outline:hover, .btn-outline.viewmore-products-btn:hover, .btn-theme.btn-outline:active, .btn-outline.viewmore-products-btn:active,
				.btn-theme:hover, .btn-theme:focus, .btn-theme:active, .btn-theme.active
				{
					border-color: <?php echo esc_html( kossy_get_config('button_hover_color') ); ?>;
				}

			<?php endif; ?>

			/***************************************************************/
			/* Top Bar *****************************************************/
			/***************************************************************/
			/* Top Bar Backgound */
			<?php $topbar_bg = kossy_get_config('topbar_bg'); ?>
			<?php if ( !empty($topbar_bg) ) :
				$image = isset($topbar_bg['background-image']) ? str_replace(array('http://', 'https://'), array('//', '//'), $topbar_bg['background-image']) : '';
				$topbar_bg_image = $image && $image != 'none' ? 'url('.esc_url($image).')' : $image;
			?>
				#apus-topbar {
					<?php if ( isset($topbar_bg['background-color']) && $topbar_bg['background-color'] ): ?>
				    background-color: <?php echo esc_html( $topbar_bg['background-color'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($topbar_bg['background-repeat']) && $topbar_bg['background-repeat'] ): ?>
				    background-repeat: <?php echo esc_html( $topbar_bg['background-repeat'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($topbar_bg['background-size']) && $topbar_bg['background-size'] ): ?>
				    background-size: <?php echo esc_html( $topbar_bg['background-size'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($topbar_bg['background-attachment']) && $topbar_bg['background-attachment'] ): ?>
				    background-attachment: <?php echo esc_html( $topbar_bg['background-attachment'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($topbar_bg['background-position']) && $topbar_bg['background-position'] ): ?>
				    background-position: <?php echo esc_html( $topbar_bg['background-position'] ) ?>;
				    <?php endif; ?>
				    <?php if ( $topbar_bg_image ): ?>
				    background-image: <?php echo esc_html( $topbar_bg_image ) ?>;
				    <?php endif; ?>
				}
			<?php endif; ?>
			/* Top Bar Color */
			<?php if ( kossy_get_config('topbar_text_color') != "" ) : ?>
				#apus-topbar {
					color: <?php echo esc_html(kossy_get_config('topbar_text_color')); ?>;
				}
			<?php endif; ?>
			/* Top Bar Link Color */
			<?php if ( kossy_get_config('topbar_link_color') != "" ) : ?>
				#apus-topbar a {
					color: <?php echo esc_html(kossy_get_config('topbar_link_color')); ?>;
				}
			<?php endif; ?>

			<?php if ( kossy_get_config('topbar_link_color_hover') != "" ) : ?>
				#apus-topbar a:hover ,#apus-topbar a:active, #apus-topbar a:focus{
					color: <?php echo esc_html(kossy_get_config('topbar_link_color_hover')); ?>;
				}
			<?php endif; ?>

			/***************************************************************/
			/* Header *****************************************************/
			/***************************************************************/
			/* Header Backgound */
			<?php $header_bg = kossy_get_config('header_bg'); ?>
			<?php if ( !empty($header_bg) ) :
				$image = isset($header_bg['background-image']) ? str_replace(array('http://', 'https://'), array('//', '//'), $header_bg['background-image']) : '';
				$header_bg_image = $image && $image != 'none' ? 'url('.esc_url($image).')' : $image;
			?>	#apus-header .sticky-header,
				.dark-menu-sidebar,
				#apus-header {
					<?php if ( isset($header_bg['background-color']) && $header_bg['background-color'] ): ?>
				    background-color: <?php echo esc_html( $header_bg['background-color'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($header_bg['background-repeat']) && $header_bg['background-repeat'] ): ?>
				    background-repeat: <?php echo esc_html( $header_bg['background-repeat'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($header_bg['background-size']) && $header_bg['background-size'] ): ?>
				    background-size: <?php echo esc_html( $header_bg['background-size'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($header_bg['background-attachment']) && $header_bg['background-attachment'] ): ?>
				    background-attachment: <?php echo esc_html( $header_bg['background-attachment'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($header_bg['background-position']) && $header_bg['background-position'] ): ?>
				    background-position: <?php echo esc_html( $header_bg['background-position'] ) ?>;
				    <?php endif; ?>
				    <?php if ( $header_bg_image ): ?>
				    background-image: <?php echo esc_html( $header_bg_image ) ?>;
				    <?php endif; ?>
				}
			<?php endif; ?>
			/* Header Color */
			<?php if ( kossy_get_config('header_text_color') != "" ) : ?>
				.dark-menu-sidebar,
				#apus-header {
					color: <?php echo esc_html(kossy_get_config('header_text_color')); ?>;
				}
			<?php endif; ?>
			/* Header Link Color */
			<?php if ( kossy_get_config('header_link_color') != "" ) : ?>
				.dark-menu-sidebar a,
				#apus-header a {
					color: <?php echo esc_html(kossy_get_config('header_link_color'));?> ;
				}
			<?php endif; ?>
			/* Header Link Color Active */
			<?php if ( kossy_get_config('header_link_color_active') != "" ) : ?>
				.dark-menu-sidebar a:hover,
				.dark-menu-sidebar a:active,
				#apus-header .active > a,
				#apus-header a:active,
				#apus-header a:hover {
					color: <?php echo esc_html(kossy_get_config('header_link_color_active')); ?>;
				}
			<?php endif; ?>

			/* Menu Link Color */
			<?php if ( kossy_get_config('main_menu_link_color') != "" ) : ?>
				.navbar-nav.megamenu > li > a{
					color: <?php echo esc_html(kossy_get_config('main_menu_link_color'));?> !important;
				}
			<?php endif; ?>
			
			/* Menu Link Color Active */
			<?php if ( kossy_get_config('main_menu_link_color_active') != "" ) : ?>
				.navbar-nav.megamenu > li:hover > a,
				.navbar-nav.megamenu > li.active > a,
				.navbar-nav.megamenu > li > a:hover,
				.navbar-nav.megamenu > li > a:active
				{
					color: <?php echo esc_html(kossy_get_config('main_menu_link_color_active')); ?> !important;
				}
			<?php endif; ?>
			<?php if ( kossy_get_config('main_menu_link_color_active') != "" ) : ?>
				.navbar-nav.megamenu > li.active > a,
				.navbar-nav.megamenu > li:hover > a{
					border-color: <?php echo esc_html(kossy_get_config('main_menu_link_color_active'));?> !important;
				}
			<?php endif; ?>

			/***************************************************************/
			/* Main Content *****************************************************/
			/***************************************************************/
			/*  Backgound */
			<?php $main_content_bg = kossy_get_config('main_content_bg'); ?>
			<?php if ( !empty($main_content_bg) ) :
				$image = isset($main_content_bg['background-image']) ? str_replace(array('http://', 'https://'), array('//', '//'), $main_content_bg['background-image']) : '';
				$main_content_bg_image = $image && $image != 'none' ? 'url('.esc_url($image).')' : $image;
			?>
				#apus-main-content {
					<?php if ( isset($main_content_bg['background-color']) && $main_content_bg['background-color'] ): ?>
				    background-color: <?php echo esc_html( $main_content_bg['background-color'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($main_content_bg['background-repeat']) && $main_content_bg['background-repeat'] ): ?>
				    background-repeat: <?php echo esc_html( $main_content_bg['background-repeat'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($main_content_bg['background-size']) && $main_content_bg['background-size'] ): ?>
				    background-size: <?php echo esc_html( $main_content_bg['background-size'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($main_content_bg['background-attachment']) && $main_content_bg['background-attachment'] ): ?>
				    background-attachment: <?php echo esc_html( $main_content_bg['background-attachment'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($main_content_bg['background-position']) && $main_content_bg['background-position'] ): ?>
				    background-position: <?php echo esc_html( $main_content_bg['background-position'] ) ?>;
				    <?php endif; ?>
				    <?php if ( $main_content_bg_image ): ?>
				    background-image: <?php echo esc_html( $main_content_bg_image ) ?>;
				    <?php endif; ?>
				}
			<?php endif; ?>
			/* main_content Color */
			<?php if ( kossy_get_config('main_content_text_color') != "" ) : ?>
				#apus-main-content {
					color: <?php echo esc_html(kossy_get_config('main_content_text_color')); ?>;
				}
			<?php endif; ?>
			<?php if ( kossy_get_config('main_content_border_color') != "" ) : ?>
				.woocommerce ul.product_list_widget,
				.widget-service,
				.details-product .apus-woocommerce-product-gallery-thumbs .slick-slide .thumbs-inner,
				.tabs-v1 .tab-content > div,
				.woocommerce ul.product_list_widget li,
				.service-item,
				.details-product .apus-woocommerce-product-gallery-wrapper,
				.product-categories {
					border-color: <?php echo esc_html(kossy_get_config('main_content_border_color')); ?>;
				}
			<?php endif; ?>
			/* main_content Link Color */
			<?php if ( kossy_get_config('main_content_link_color') != "" ) : ?>
				#apus-main-content a:not([class]) {
					color: <?php echo esc_html(kossy_get_config('main_content_link_color')); ?>;
				}
			<?php endif; ?>

			/* main_content Link Color Hover*/
			<?php if ( kossy_get_config('main_content_link_color_hover') != "" ) : ?>
				#apus-main-content a:not([class]):hover,#apus-main-content a:not([class]):active, #apus-main-content a:not([class]):focus {
					color: <?php echo esc_html(kossy_get_config('main_content_link_color_hover')); ?>;
				}
			<?php endif; ?>

			/***************************************************************/
			/* Footer *****************************************************/
			/***************************************************************/
			/* Footer Backgound */
			<?php $footer_bg = kossy_get_config('footer_bg'); ?>
			<?php if ( !empty($footer_bg) ) :
				$image = isset($footer_bg['background-image']) ? str_replace(array('http://', 'https://'), array('//', '//'), $footer_bg['background-image']) : '';
				$footer_bg_image = $image && $image != 'none' ? 'url('.esc_url($image).')' : $image;
			?>
				#apus-footer {
					<?php if ( isset($footer_bg['background-color']) && $footer_bg['background-color'] ): ?>
				    background-color: <?php echo esc_html( $footer_bg['background-color'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($footer_bg['background-repeat']) && $footer_bg['background-repeat'] ): ?>
				    background-repeat: <?php echo esc_html( $footer_bg['background-repeat'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($footer_bg['background-size']) && $footer_bg['background-size'] ): ?>
				    background-size: <?php echo esc_html( $footer_bg['background-size'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($footer_bg['background-attachment']) && $footer_bg['background-attachment'] ): ?>
				    background-attachment: <?php echo esc_html( $footer_bg['background-attachment'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($footer_bg['background-position']) && $footer_bg['background-position'] ): ?>
				    background-position: <?php echo esc_html( $footer_bg['background-position'] ) ?>;
				    <?php endif; ?>
				    <?php if ( $footer_bg_image ): ?>
				    background-image: <?php echo esc_html( $footer_bg_image ) ?>;
				    <?php endif; ?>
				}
			<?php endif; ?>
			/* Footer Heading Color*/
			<?php if ( kossy_get_config('footer_heading_color') != "" ) : ?>
				#apus-footer h1, #apus-footer h2, #apus-footer h3, #apus-footer h4, #apus-footer h5, #apus-footer h6 ,#apus-footer .widget-title {
					color: <?php echo esc_html(kossy_get_config('footer_heading_color')); ?> !important;
				}
			<?php endif; ?>
			/* Footer Color */
			<?php if ( kossy_get_config('footer_text_color') != "" ) : ?>
				#apus-footer {
					color: <?php echo esc_html(kossy_get_config('footer_text_color')); ?>;
				}
			<?php endif; ?>
			/* Footer Link Color */
			<?php if ( kossy_get_config('footer_link_color') != "" ) : ?>
				#apus-footer a {
					color: <?php echo esc_html(kossy_get_config('footer_link_color')); ?>;
				}
			<?php endif; ?>

			/* Footer Link Color Hover*/
			<?php if ( kossy_get_config('footer_link_color_hover') != "" ) : ?>
				#apus-footer a:hover {
					color: <?php echo esc_html(kossy_get_config('footer_link_color_hover')); ?>;
				}
			<?php endif; ?>


			/***************************************************************/
			/* Copyright *****************************************************/
			/***************************************************************/
			/* Copyright Backgound */
			<?php $copyright_bg = kossy_get_config('copyright_bg'); ?>
			<?php if ( !empty($copyright_bg) ) :
				$image = isset($copyright_bg['background-image']) ? str_replace(array('http://', 'https://'), array('//', '//'), $copyright_bg['background-image']) : '';
				$copyright_bg_image = $image && $image != 'none' ? 'url('.esc_url($image).')' : $image;
			?>
				.apus-copyright {
					<?php if ( isset($copyright_bg['background-color']) && $copyright_bg['background-color'] ): ?>
				    background-color: <?php echo esc_html( $copyright_bg['background-color'] ) ?> !important;
				    <?php endif; ?>
				    <?php if ( isset($copyright_bg['background-repeat']) && $copyright_bg['background-repeat'] ): ?>
				    background-repeat: <?php echo esc_html( $copyright_bg['background-repeat'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($copyright_bg['background-size']) && $copyright_bg['background-size'] ): ?>
				    background-size: <?php echo esc_html( $copyright_bg['background-size'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($copyright_bg['background-attachment']) && $copyright_bg['background-attachment'] ): ?>
				    background-attachment: <?php echo esc_html( $copyright_bg['background-attachment'] ) ?>;
				    <?php endif; ?>
				    <?php if ( isset($copyright_bg['background-position']) && $copyright_bg['background-position'] ): ?>
				    background-position: <?php echo esc_html( $copyright_bg['background-position'] ) ?>;
				    <?php endif; ?>
				    <?php if ( $copyright_bg_image ): ?>
				    background-image: <?php echo esc_html( $copyright_bg_image ) ?> !important;
				    <?php endif; ?>
				}
			<?php endif; ?>

			/* Footer Color */
			<?php if ( kossy_get_config('copyright_text_color') != "" ) : ?>
				.apus-copyright {
					color: <?php echo esc_html(kossy_get_config('copyright_text_color')); ?>;
				}
			<?php endif; ?>
			/* Footer Link Color */
			<?php if ( kossy_get_config('copyright_link_color') != "" ) : ?>
				.apus-copyright a {
					color: <?php echo esc_html(kossy_get_config('copyright_link_color')); ?>;
				}
			<?php endif; ?>

			/* Footer Link Color Hover*/
			<?php if ( kossy_get_config('copyright_link_color_hover') != "" ) : ?>
				.apus-copyright a:hover {
					color: <?php echo esc_html(kossy_get_config('copyright_link_color_hover')); ?>;
				}
			<?php endif; ?>

			/* Woocommerce Breadcrumbs */
			<?php if ( kossy_get_config('breadcrumbs') == "0" ) : ?>
			.woocommerce .woocommerce-breadcrumb,
			.woocommerce-page .woocommerce-breadcrumb
			{
				display:none;
			}
			<?php endif; ?>



	<?php
		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$lines = explode("\n", $content);
		$new_lines = array();
		foreach ($lines as $i => $line) {
			if (!empty($line)) {
				$new_lines[] = trim($line);
			}
		}
		
		return implode($new_lines);
	}
}
