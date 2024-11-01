<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Woo_Save_For_Later
 * @subpackage Woo_Save_For_Later/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Save_For_Later
 * @subpackage Woo_Save_For_Later/admin
 * @author     Multidots <inquiry@multidots.in>
 */
class Woo_Save_For_Later_Admin {

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

	public $dot_pages = array();

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->dot_pages = array(
			'save_for_later',
			'wsfl-add-new',
			'wsfl-premium',
			'wsfl-get-started',
			'wsfl-information',
			'wsfl-edit-fee',
		);

	}

	/**
	 * Register the stylesheets for the admin area.
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
		wp_enqueue_style( 'wp-pointer' );

		if (
			isset( $_GET['page'] )
			&& ! empty( $_GET['page'] )
			&& in_array( $_GET['page'], $this->dot_pages, true )
		) {
			wp_enqueue_style( $this->plugin_name . '-choose-css', plugin_dir_url( __FILE__ ) . 'css/chosen.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-jquery-ui-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . 'font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . '-webkit-css', plugin_dir_url( __FILE__ ) . 'css/webkit.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name . 'main-style', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), 'all' );
			wp_enqueue_style( $this->plugin_name . 'media-css', plugin_dir_url( __FILE__ ) . 'css/media.css', array(), 'all' );
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-save-for-later-admin.css', array( 'wp-jquery-ui-dialog' ), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_script( 'wp-pointer' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-save-for-later-admin.js', array( 'jquery', 'jquery-ui-dialog' ), $this->version, false );

		if (
			isset( $_GET['page'] )
			&& ! empty( $_GET['page'] )
			&& in_array( $_GET['page'], $this->dot_pages, true )
		) {
			wp_enqueue_style( 'wp-jquery-ui-dialog' );
			wp_enqueue_script( 'jquery-ui-accordion' );
			wp_enqueue_script( $this->plugin_name . '-choose-js', plugin_dir_url( __FILE__ ) . 'js/chosen.jquery.min.js', array(
				'jquery',
				'jquery-ui-datepicker',
			), $this->version, false );
			wp_localize_script( $this->plugin_name, 'coditional_vars', array( 'plugin_url' => plugin_dir_url( __FILE__ ) ) );
			wp_enqueue_script( $this->plugin_name . '-tablesorter-js', plugin_dir_url( __FILE__ ) . 'js/jquery.tablesorter.js', array( 'jquery' ), $this->version, false );
		}
	}

	public function dot_store_menu_save_for_later_lite() {
		global $GLOBALS;
		if ( empty( $GLOBALS['admin_page_hooks']['dots_store'] ) ) {
			add_menu_page(
				'DotStore Plugins', __( 'DotStore Plugins' ), 'manage_option', 'dots_store', array(
				$this,
				'dot_store_menu_page',
			), WSFL_PLUGIN_URL . 'admin/images/menu-icon.png', 25
			);
		}
		add_submenu_page( 'dots_store', 'Get Started', 'Get Started', 'manage_options', 'wsfl-get-started', array( $this, 'wsfl_get_started_page' ) );
		add_submenu_page( 'dots_store', 'Premium Version', 'Premium Version', 'manage_options', 'wsfl-premium', array( $this, 'premium_version_wsfl_page' ) );
		add_submenu_page( 'dots_store', 'Introduction', 'Introduction', 'manage_options', 'wsfl-information', array( $this, 'wsfl_information_page' ) );
		add_submenu_page( 'dots_store', 'WooCommerce Save For Later ', __( 'WooCommerce Save For Later ' ), 'manage_options', 'save_for_later', array(
			$this,
			'wsfl_fee_list_page',
		) );
	}

	public function dot_store_menu_page() {
	}

	public function wsfl_information_page() {
		require_once( 'partials/wsfl-information-page.php' );
	}

	public function premium_version_wsfl_page() {
		require_once( 'partials/wsfl-premium-version-page.php' );
	}

	public function wsfl_get_started_page() {
		require_once( 'partials/wsfl-get-started-page.php' );
	}

	public function wsfl_fee_list_page() {
		require_once( 'partials/wsfl-list-page.php' );
	}

	public function woo_save_for_later_admin_menu() {
		// add_menu_page(WSFL_PLUGIN_ADMIN_MENU_SLUG, __(WSFL_PLUGIN_ADMIN_MENU_NAME, WSFL_PLUGIN_SLUG), 'manage_options', WSFL_PLUGIN_ADMIN_MENU_TITLE, 'woo_save_for_later_admin_menu_custom');

		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && ! is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) {
			wp_die( "<strong>" . WSFL_PLUGIN_NAME . "</strong> Plugin requires <strong>WooCommerce</strong> <a href='" . get_admin_url( null, 'plugins.php' ) . "'>Plugins page</a>." );
		}
		$current_user            = wp_get_current_user();
		$wbl_plugin_notice_shown = get_option( 'wbl_plugin_notice_shown' );
		if ( ! $wbl_plugin_notice_shown ) {
			?>
			<div id="dotstore_subscribe_dialog">
				<p><?php _e( 'Subscribe for the latest plugin update and get notified when we update our plugin and launch new products for free!', WSFL_PLUGIN_TEXT_DOMAIN ); ?></p>
				<p><input type="text" id="txt_user_sub_wsfl" class="regular-text" name="txt_user_sub_wsfl" value="<?php echo $current_user->user_email; ?>"></p>
			</div>
		<?php }
		$getPluginOption   = get_option( WSFL_PLUGIN_OPTION_ADD_KEY );
		$getPluginOption   = maybe_unserialize( $getPluginOption );
		$getPluginLinkText = '';
		if ( $getPluginOption != '' && ! empty( $getPluginOption ) && ! empty( $getPluginOption['page_link_text'] ) && $getPluginOption['page_link_text'] != '' ) {
			$getPluginLinkText = $getPluginOption['page_link_text'];
		}
		?>
		<div class="wsfl-main-container" id="wsfl_main_contain_ids">
			<fieldset class="wsfl-global">
				<legend>
					<div class="wsfl-legennd-header"><h2><?php echo __( WSFL_PLUGIN_MENU_PAGE_TITLE, WSFL_PLUGIN_SLUG ); ?></h2></div>
				</legend>
				<div class="wsfl-field-contain">
					<form id="wsfl_plugin_form_id" method="post" action="<?php echo get_admin_url(); ?>admin-post.php" enctype="multipart/form-data" novalidate="novalidate">
						<input type='hidden' name='action' value='wsfl-submit-form' />
						<input type='hidden' name='wsfl_action_which' value='add' />
						<table class="form-table">
							<tbody>
							<tr>
								<th><?php echo __( WSFL_PLUGIN_PAGE_TEXT, WSFL_PLUGIN_SLUG ); ?></th>
								<td class="set_fonts">
									<input type="text" value="<?php echo ( $getPluginLinkText ) ? $getPluginLinkText : 'Save for Later'; ?>" name="wsfl_page_text_title"
									       class="set_wsfl_text_title">
								</td>
							</tr>
							<tr>
								<th><?php echo __( WSFL_PLUGIN_PAGE_NAME, WSFL_PLUGIN_SLUG ); ?></th>
								<td class="set_fonts">
									<input type="text" readonly value="Save For Later" name="wsfl_page_name" class="set_wsfl_page_name">
								</td>
							</tr>
							</tbody>
						</table>
						<p class="submit">
							<input type="submit" value="<?php echo __( WSFL_PLUGIN_SAVE_BUTTON_TITLE, WSFL_PLUGIN_SLUG ); ?>" class="button button-primary"
							       id="wsfl_submit_plugin" name="wsfl_submit_plugin">
							<input type="reset" value="<?php echo __( WSFL_PLUGIN_RESET_BUTTON_TITLE, WSFL_PLUGIN_SLUG ); ?>" class="button button-primary"
							       id="wsfl_reset_plugin" name="wsfl_reset_plugin">
						</p>
					</form>
				</div>
			</fieldset>

		</div>
		<?php
	}

	public function woo_save_for_later_add_option() {
		$pluginAction   = isset( $_POST['wsfl_action_which'] ) ? $_POST['wsfl_action_which'] : '';
		$pluginPageText = isset( $_POST['wsfl_page_text_title'] ) ? $_POST['wsfl_page_text_title'] : 'Save for Later';
		$pluginPageName = isset( $_POST['wsfl_page_name'] ) ? $_POST['wsfl_page_name'] : 'Save for Later';
		$wsflOptionArr  = array();

		if ( ! empty( $pluginAction ) && isset( $pluginAction ) && $pluginAction === 'add' ) {
			$wsflOptionArr['page_link_text'] = $pluginPageText;
			$wsflOptionArr['page_title']     = $pluginPageName;
			$wsflOptionArr                   = maybe_serialize( $wsflOptionArr );

			update_option( WSFL_PLUGIN_OPTION_ADD_KEY, $wsflOptionArr );
		}

		wp_safe_redirect( site_url( "/wp-admin/admin.php?page=" . WSFL_PLUGIN_ADMIN_MENU_TITLE ) );
		exit();
	}

	public function create_defaults_save_for_later_page() {
		$pages        = get_pages();
		$wsflPageName = 'Save For Later';
		$wsflPageSlug = 'save-for-later';

		$listings_page = array( 'slug' => $wsflPageSlug, 'title' => $wsflPageName );

		$listing_detail_found = 0;

		// listing page
		foreach ( $pages as $page ) {
			$apage = $page->post_name;

			if ( $apage === $wsflPageSlug ) {
				$listing_detail_found = 1;
				break;
			}
			$listing_detail_found = 0;
		}

		if ( 1 !== $listing_detail_found ) {
			$page_id = wp_insert_post( array(
				'post_title'  => $listings_page['title'],
				'post_type'   => 'page',
				'post_name'   => $listings_page['slug'],
				'post_status' => 'publish',
			) );
			add_post_meta( $page_id, '_wp_page_template', 'wsfl-page-template.php' );
		}

		$post_id = isset( $_GET['post'] ) && ! empty( $_GET['post'] ) ? $_GET['post'] : '';

		if ( ! empty( $post_id ) && is_numeric( $post_id ) ) {
			$listing_detail = get_the_title( $post_id );
			if ( $listing_detail === $wsflPageName ) {
				remove_post_type_support( 'page', 'editor' );
				remove_meta_box( 'authordiv', 'page', 'normal' ); //removes comments status
				remove_meta_box( 'categorydiv', 'page', 'normal' ); //removes comments
				remove_meta_box( 'commentstatusdiv', 'page', 'normal' ); //removes author
				remove_meta_box( 'commentsdiv', 'page', 'normal' ); //removes Comments metabox
				remove_meta_box( 'formatdiv', 'page', 'normal' ); //removes Formats metabox
				remove_meta_box( 'pageparentdiv', 'page', 'normal' ); //removes Attributes metabox
				remove_meta_box( 'postcustom', 'page', 'normal' ); //removes Custom fields metabox
				remove_meta_box( 'postexcerpt', 'page', 'normal' ); //removes Excerpt metabox
				remove_meta_box( 'postimagediv', 'page', 'side' ); //removes Featured image metabox
				remove_meta_box( 'revisionsdiv', 'page', 'normal' ); //removes Revisions metabox
				remove_meta_box( 'slugdiv', 'page', 'normal' ); //removes Slug metabox
				remove_meta_box( 'submitdiv', 'page', 'normal' ); //removes Date, status, and update/save metabox
				remove_meta_box( 'trackbacksdiv', 'page', 'normal' ); //removes Trackbacks metabox
			}
		}
	}

	public function remove_page_trash_link( $actions, $post ) {
		global $current_screen;

		if (
			'page' === $current_screen->post_type
			&& ( "Save For Later" === $post->post_title || "save-for-later" === $post->post_name )
		) {
			unset( $actions['edit'] );
			unset( $actions['view'] );
			unset( $actions['trash'] );
			unset( $actions['inline hide-if-no-js'] );
		}

		return $actions;
	}

	/**
	 * Set the welcome screen in save for later plugin
	 */
	public function welcome_woocommerce_save_for_later_screen_do_activation_redirect() {

		if ( ! get_transient( '_welcome_screen_woocommerce_save_for_later_activation_redirect_data' ) ) {
			return;
		}

		// Delete the redirect transient
		delete_transient( '_welcome_screen_woocommerce_save_for_later_activation_redirect_data' );

		// if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
		}
		// Redirect to extra cost welcome  page
		wp_safe_redirect( add_query_arg( array( 'page' => 'wsfl-get-started' ), admin_url( 'admin.php' ) ) );
	}

	public function welcome_pages_screen_woocommerce_save_for_later() {
		add_dashboard_page(
			'WooCommerce-Save-For-Later Dashboard', 'WooCommerce Save For Later Dashboard', 'read', 'woocommerce-save-for-later', array(
				&$this,
				'welcome_screen_content_woocommerce_save_for_later',
			)
		);
	}

	public function welcome_screen_woocommerce_save_for_later_remove_menus() {
		remove_submenu_page( 'index.php', 'woocommerce-save-for-later' );
		remove_submenu_page( 'dots_store', 'wsfl-information' );
		remove_submenu_page( 'dots_store', 'wsfl-premium' );
		remove_submenu_page( 'dots_store', 'wsfl-get-started' );
	}

	/**
	 * Function For display admin side notice
	 */
	public function woocommerce_save_for_later_pointers_footer() {

		$admin_pointers = woocommerce_save_for_later_admin_pointers();
		?>
		<script type="text/javascript">
					/* <![CDATA[ */
					(function( $ ) {
			  <?php
			  foreach ($admin_pointers as $pointer => $array) {
			  if ($array['active']) {
			  ?>
						$( '<?php echo esc_js( $array['anchor_id'] ); ?>' ).pointer( {
							content: '<?php echo esc_js( $array['content'] ); ?>',
							position: {
								edge: '<?php echo esc_js( $array['edge'] ); ?>',
								align: '<?php echo esc_js( $array['align'] ); ?>'
							},
							close: function() {
								$.post( ajaxurl, {
									pointer: '<?php echo esc_js( $pointer ); ?>',
									action: 'dismiss-wp-pointer'
								} );
							}
						} ).pointer( 'open' );
			  <?php
			  }
			  }
			  ?>
					})( jQuery );
					/* ]]> */
		</script>
		<?php
	}

}

function woocommerce_save_for_later_admin_pointers() {

	$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
	$version   = '1_0'; // replace all periods in 1.0 with an underscore
	$prefix    = 'woocommerce_save_for_later_admin_pointers' . $version . '_';

	$new_pointer_content = '<h3>' . __( 'Welcome to WooCommerce Save For Later' ) . '</h3>';
	$new_pointer_content .= '<p>' . __( 'WooCommerce Save For Later plugin allows to customers to save particular product and keeps them saved for later purchase.' ) . '</p>';

	return array(
		$prefix . 'woocommerce_save_for_later_admin_pointers' => array(
			'content'   => $new_pointer_content,
			'anchor_id' => '#toplevel_page_save_for_later',
			'edge'      => 'left',
			'align'     => 'left',
			'active'    => ( ! in_array( $prefix . 'woocommerce_save_for_later_admin_pointers', $dismissed ) ),
		),
	);
}
