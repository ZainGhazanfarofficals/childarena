<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_search = false;
$is_taxonomy = false;

// Config
if ( ! empty( $_REQUEST['s'] ) ) { // Is search query set and not empty?
    $is_search = true;
    $results_bar_class = ' is-search';
    $esc_button_text = sprintf( esc_html__( 'Search results for &ldquo;%s&rdquo;', 'kossy' ), '<span>' . esc_html( $_REQUEST['s'] ) . '</span>' );
} else if ( is_product_taxonomy() ) {
    
    if ( !is_product_category() ) {
        $is_taxonomy = true;
        $current_term = $GLOBALS['wp_query']->get_queried_object();

        $results_bar_class = ' is-tag';
        $esc_button_text = sprintf( esc_html__( 'Products tagged &ldquo;%s&rdquo;', 'kossy' ), '<span>' . esc_html( $current_term->name ) . '</span>' );
    }
}

// Get shop page URL
$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );

// Button "href" value
$button_href = $shop_page_url;

if ( $is_search || $is_taxonomy ) :
?>

    <div class="apus-results">
        <a href="<?php echo esc_url( $shop_page_url ); ?>" class="apus-results-reset">
            <i class="ti-close"></i>
            <?php echo trim($esc_button_text); ?>
        </a>
    </div>

<?php endif;

$filters = kossy_count_filtered();

if ( $filters ): ?>
    <div class="apus-results">
        <a href="<?php echo esc_url( $shop_page_url ); ?>" class="apus-results-reset">
            <i class="ti-close"></i>
            <?php printf(__('Filters (%s)', 'kossy'), $filters); ?>
        </a>
    </div>
<?php endif;