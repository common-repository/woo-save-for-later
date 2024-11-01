<?php
/**
 * Template Name: Default - Save For Later
 *
 * A template used to demonstrate how to include the template
 * using this plugin.
 *
 * @package    Aretk Crea.
 * @since      1.0.0
 * @version    1.0.0
 */
get_header();
global $wpdb, $product, $wp, $post;

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	$getCurrentUserID = get_current_user_id();
	$encodeUserID     = md5( $getCurrentUserID );
	$cookieName       = WSFL_PLUGIN_COOKIE_NAME . $encodeUserID;

	$getWSFLCookie = isset( $_COOKIE[ $cookieName ] ) ? $_COOKIE[ $cookieName ] : '';
	$getWSFLCookie = maybe_unserialize( stripslashes( $getWSFLCookie ) );

	if ( ! empty( $getWSFLCookie ) ) { ?>
		<div class="wsfl_cart_contain">
			<table id="wsfl_main_contain" width="100%" cellpadding="0" cellspacing="0">
				<thead>
				<tr>
					<th>No</th>
					<th>Image</th>
					<th>Product name</th>
					<th>Quantity</th>
					<th>Price</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>

				<?php
				$counter = 0;
				foreach ( $getWSFLCookie as $key => $value ) {
					$counter          = $counter + 1;
					$productArr       = get_post( $key );
					$getProductImage  = wp_get_attachment_image_src( get_post_thumbnail_id( $key ) );
					$product          = wc_get_product( $key );
					$current_currency = get_woocommerce_currency_symbol( get_woocommerce_currency() );

					$regularPrice = (int) $product->get_regular_price();
					$salePrice    = (int) $product->get_sale_price();

					$PriceHtml           = '';
					$productRegularPrice = $current_currency . number_format( $regularPrice, 2, '.', ' ' );
					$productSalePrice    = $current_currency . number_format( $salePrice, 2, '.', ' ' );

					if ( ! empty( $salePrice ) && $salePrice > 0 ) {
						$PriceHtml .= '<p ="class="regular_price"><strike>' . $productRegularPrice . '</strike></p><p class="sale_price">' . $productSalePrice . '</p>';
					} else {
						$PriceHtml .= '<p class="regular_price">' . $productRegularPrice . '</p>';
					} ?>
					<?php if ( $counter % 2 == 0 ) { ?>
						<tr class="even">
					<?php } else { ?>
						<tr class="odd">
					<?php } ?>
					<td><?php echo $counter; ?></td>
					<td><img src="<?php echo esc_url( $getProductImage[0] ); ?>" width="50px" height="50px" alt="<?php echo esc_attr( $productArr->post_title ); ?>"></td>
					<td><a target="_blank" href="<?php echo get_the_permalink( $key ); ?>"><?php echo esc_attr( $productArr->post_title ); ?></a></td>
					<td><?php echo $value; ?></td>
					<td><?php echo $PriceHtml; ?></td>
					<td>
						<a href="javascript:void(0);" class="wsfl_add_product_to_cart" id="<?php echo esc_attr( $key ); ?>" data-nonce="<?php echo wp_create_nonce( 'dot_save_for_later_action' );?>" >
							<img src="<?php echo esc_url( WSFL_PLUGIN_PATH . '/images/wsfl_add_to_cart.png' ); ?>" alt="Add to cart">
						</a>
						<a href="javascript:void(0);" class="remove_product_to_wsfl" id="<?php echo esc_attr( $key ); ?>" data-nonce="<?php echo wp_create_nonce( 'dot_save_for_later_action' );?>">
							<img src="<?php echo esc_url( WSFL_PLUGIN_PATH . '/images/wsfl_trash.png' ); ?>" alt="Remove">
						</a>
					</td>
					</tr>

				<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } else {
		echo "<h3>No Product set in save for later.!!!</h3>";
	}
}

get_footer();