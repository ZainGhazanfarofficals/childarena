<?php
/**
 *	The template for displaying the shop header
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="apus-shop-header">
    <div class="apus-shop-menu">
        <div class="row">
            <div class="col-xs-12">
                <div class="wrapper-filter clearfix">
                    <?php if ( kossy_get_config('product_archive_top_categories')) { ?>
                    <div class="pull-left">
                        <ul id="apus-categories" class="apus-categories">
                            <?php kossy_category_menu(); ?>
                        </ul>
                    </div>
                    <?php } ?>
                    <?php if ( kossy_get_config('product_archive_top_filter')) { ?>
                        <?php if ( is_active_sidebar( 'shop-top-sidebar' ) ) { ?>
                            <span class="show-filter pull-right">
                                <?php echo esc_html__('Filters','kossy') ?><i class="ti-angle-down" aria-hidden="true"></i>
                            </span>
                        <?php } ?>
                    <?php } ?>
                </div>
                <?php if ( kossy_get_config('product_archive_top_filter')) { ?>
                    <?php if ( is_active_sidebar( 'shop-top-sidebar' ) ) { ?>
                        <div class="shop-top-sidebar-wrapper">
                            <div class="shop-top-sidebar-wrapper-inner">
                                <?php dynamic_sidebar( 'shop-top-sidebar' ); ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>