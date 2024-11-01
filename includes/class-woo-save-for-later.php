<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Woo_Save_For_Later
 * @subpackage Woo_Save_For_Later/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woo_Save_For_Later
 * @subpackage Woo_Save_For_Later/includes
 * @author     Multidots <inquiry@multidots.in>
 */
class Woo_Save_For_Later {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woo_Save_For_Later_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'woo-save-for-later';
		$this->version     = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woo_Save_For_Later_Loader. Orchestrates the hooks of the plugin.
	 * - Woo_Save_For_Later_i18n. Defines internationalization functionality.
	 * - Woo_Save_For_Later_Admin. Defines all hooks for the admin area.
	 * - Woo_Save_For_Later_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-save-for-later-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-save-for-later-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo-save-for-later-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woo-save-for-later-public.php';

		$this->loader = new Woo_Save_For_Later_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woo_Save_For_Later_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woo_Save_For_Later_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Woo_Save_For_Later_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'dot_store_menu_save_for_later_lite' );
		//$this->loader->add_action( 'admin_menu',$plugin_admin, 'woo_save_for_later_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'create_defaults_save_for_later_page' );
		$this->loader->add_action( 'page_row_actions', $plugin_admin, 'remove_page_trash_link', 10, 2 );
		$this->loader->add_action( 'admin_post_wsfl-submit-form', $plugin_admin, 'woo_save_for_later_add_option' );
		$this->loader->add_action( 'admin_post_nopriv_wsfl-submit-form', $plugin_admin, 'woo_save_for_later_add_option' );


		$this->loader->add_action( 'admin_init', $plugin_admin, 'welcome_woocommerce_save_for_later_screen_do_activation_redirect' );
		//$this->loader->add_action('admin_menu', $plugin_admin, 'welcome_pages_screen_woocommerce_save_for_later');
		//$this->loader->add_action('woocommerce_save_for_later_other_plugins', $plugin_admin, 'woocommerce_save_for_later_other_plugins');
		//$this->loader->add_action('woocommerce_save_for_later_about', $plugin_admin, 'woocommerce_save_for_later_about');
		//$this->loader->add_action('woocommerce_save_for_later_premium_feauter', $plugin_admin, 'woocommerce_save_for_later_premium_feauter');
		$this->loader->add_action( 'admin_print_footer_scripts', $plugin_admin, 'woocommerce_save_for_later_pointers_footer' );
		// $this->loader->add_action( 'admin_menu', $plugin_admin, 'welcome_screen_woocommerce_save_for_later_remove_menus', 999 );

		$this->loader->add_action( 'admin_head', $plugin_admin, 'welcome_screen_woocommerce_save_for_later_remove_menus' );


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woo_Save_For_Later_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter( 'woocommerce_paypal_args', $plugin_public, 'paypal_bn_code_filter_woo_save_from_later', 99, 1 );
		$this->loader->add_action( 'template_include', $plugin_public, 'wsfl_assign_view_template' );
		$this->loader->add_filter( 'woocommerce_cart_item_name', $plugin_public, 'wsfl_add_link_in_cart_list', 15, 3 );
		$this->loader->add_filter( 'woocommerce_before_cart_contents', $plugin_public, 'wsfl_save_later_nonce', 15, 3 );
		$this->loader->add_action( 'wp_ajax_wsfl_add_save_for_later', $plugin_public, 'wsfl_add_save_for_later' );
		$this->loader->add_action( 'wp_ajax_nopriv_wsfl_add_save_for_later', $plugin_public, 'wsfl_add_save_for_later' );
		$this->loader->add_action( 'wp_ajax_wsfl_remove_save_for_later', $plugin_public, 'wsfl_remove_save_for_later' );
		$this->loader->add_action( 'wp_ajax_nopriv_wsfl_remove_save_for_later', $plugin_public, 'wsfl_remove_save_for_later' );
		$this->loader->add_action( 'wp_ajax_wsfl_add_product_to_cart', $plugin_public, 'wsfl_add_product_to_cart' );
		$this->loader->add_action( 'wp_ajax_nopriv_wsfl_add_product_to_cart', $plugin_public, 'wsfl_add_product_to_cart' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woo_Save_For_Later_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
