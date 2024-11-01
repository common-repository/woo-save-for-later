<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Woo_Save_For_Later
 * @subpackage Woo_Save_For_Later/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Save_For_Later
 * @subpackage Woo_Save_For_Later/public
 * @author     Multidots <inquiry@multidots.in>
 */
class Woo_Save_For_Later_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Save_For_Later_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Save_For_Later_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-save-for-later-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Save_For_Later_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Save_For_Later_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script('jquery');
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-save-for-later-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( 'jquery', 'wsflurl', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}


	public function wsfl_assign_view_template( $template ) {
		global $post;

		if ( ! isset( $post ) ) {
			return $template;
		}

		$this->templates = array( 'wsfl-page-template.php' => __( 'Default - Save For Later', WSFL_PLUGIN_SLUG ) );

		if ( ! isset( $this->templates[ get_post_meta( $post->ID, '_wp_page_template', true ) ] ) ) {
			return $template;
		}

		$file = plugin_dir_path( __FILE__ ) . 'template/' . get_post_meta( $post->ID, '_wp_page_template', true );

		if ( file_exists( $file ) ) {
			return $file;
		}

		return $template;

	}

	public function wsfl_add_link_in_cart_list( $product_name, $cart_item, $cart_item_key ) {
		global $woocommerce;
		if ( ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			$cart = $woocommerce->cart->get_cart();

			$product_id = $cart[ $cart_item_key ]['product_id'];

			$getPluginOption = get_option( WSFL_PLUGIN_OPTION_ADD_KEY );
			$getPluginOption = maybe_unserialize( $getPluginOption );

			$text_link = '';

			if ( $getPluginOption != '' && ! empty( $getPluginOption ) && ! empty( $getPluginOption['page_link_text'] ) && $getPluginOption['page_link_text'] != '' ) {
				$text_link = $getPluginOption['page_link_text'];
			}

			$href = '<div class="wsfl_button"><a href="#" rel="" id="' . $product_id . '" class="set_wsfl_save_for_later" title="' . $text_link . '" >' .
			        $text_link .
			        '</a></div>';

			return apply_filters( 'wsfl_save_for_later_link', $product_name . $href, $product_name, $cart_item, $cart_item_key );
		}

		return $product_name;
	}

	/**
	 * Add nonce on the cart page.
	 */
	public function wsfl_save_later_nonce() {
		wp_nonce_field( 'wsfl_add_save_for_later', 'wsfl_dot_nonce' );
	}

	public function wsfl_add_save_for_later() {
		global $woocommerce;

		// Check nonce.
		check_ajax_referer( 'wsfl_add_save_for_later', 'nonce' );

		$getCurrentUserID = get_current_user_id();
		$productID        = isset( $_POST['productID'] ) && ! empty( $_POST['productID'] ) ? absint( $_POST['productID'] ) : '';
		$cart             = $woocommerce->cart->get_cart();

		$cartquantity = 0;

		if ( $cart != '' && ! empty( $cart ) ) {
			foreach ( $cart as $key => $value ) {
				$product_id = absint( $cart[ $key ]['product_id'] );

				if ( $product_id === $productID ) {
					$cartquantity = $cart[ $key ]['quantity'];
				}
			}
		}

		$encodeUserID = md5( $getCurrentUserID );
		$cookieName   = WSFL_PLUGIN_COOKIE_NAME . $encodeUserID;

		$productArr = array();
		if ( ! empty( $productID ) && $productID != '' ) {

			$productArr[ $productID ] = $cartquantity;
			$serializeArr             = maybe_serialize( $productArr );

			if ( ! isset( $_COOKIE[ $cookieName ] ) ) {
				setcookie( $cookieName, $serializeArr, time() + ( 60 * 60 * 24 * 30 ), "/" );

				foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
					if ( $cart_item['product_id'] == $productID ) {
						$woocommerce->cart->remove_cart_item( $cart_item_key );
						$woocommerce->cart->calculate_totals();
					}
				}
			} else {
				$cookieProductArr = maybe_unserialize( stripslashes( $_COOKIE[ $cookieName ] ) );
				if ( ! array_key_exists( $productID, $cookieProductArr ) ) {
					$cookieProductArr[ $productID ] = $cartquantity;

					$serializeMultipleArr = maybe_serialize( $cookieProductArr );
					setcookie( $cookieName, '', time() - 999999, '/' );
					setcookie( $cookieName, $serializeMultipleArr, time() + ( 60 * 60 * 24 * 30 ), "/" );

					foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
						if ( $cart_item['product_id'] == $productID ) {
							$woocommerce->cart->remove_cart_item( $cart_item_key );
							$woocommerce->cart->calculate_totals();
						}
					}
				} else {
					echo "1";
				}
			}
		}
		die();
	}

	public function wsfl_remove_save_for_later() {

		check_ajax_referer( 'dot_save_for_later_action', 'nonce' );

		$getCurrentUserID = get_current_user_id();
		$encodeUserID     = md5( $getCurrentUserID );
		$cookieName       = WSFL_PLUGIN_COOKIE_NAME . $encodeUserID;

		$productID = isset( $_POST['productID'] ) ? $_POST['productID'] : '';

		$cookieProductArr = maybe_unserialize( stripslashes( $_COOKIE[ $cookieName ] ) );
		unset( $cookieProductArr[ $productID ] );

		$serializeArr = maybe_serialize( $cookieProductArr );
		setcookie( $cookieName, '', time() - 999999, '/' );
		setcookie( $cookieName, $serializeArr, time() + ( 60 * 60 * 24 * 30 ), "/" );

		die();
	}

	public function wsfl_add_product_to_cart() {
		global $woocommerce;

		check_ajax_referer( 'dot_save_for_later_action', 'nonce' );

		$getCurrentUserID = get_current_user_id();
		$encodeUserID     = md5( $getCurrentUserID );
		$cookieName       = WSFL_PLUGIN_COOKIE_NAME . $encodeUserID;

		$productID        = ( $_POST['productID'] ) ? $_POST['productID'] : '';
		$cookieProductArr = maybe_unserialize( stripslashes( $_COOKIE[ $cookieName ] ) );

		$woocommerce->cart->add_to_cart( $productID, $cookieProductArr[ $productID ] );
		$woocommerce->cart->calculate_totals();

		unset( $cookieProductArr[ $productID ] );

		$serializeArr = maybe_serialize( $cookieProductArr );
		setcookie( $cookieName, '', time() - 999999, '/' );
		setcookie( $cookieName, $serializeArr, time() + ( 60 * 60 * 24 * 30 ), "/" );

		die();
	}

	/**
	 * BN code added
	 */
	function paypal_bn_code_filter_woo_save_from_later( $paypal_args ) {
		$paypal_args['bn'] = 'Multidots_SP';

		return $paypal_args;
	}
}