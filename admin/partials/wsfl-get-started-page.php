<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'header/plugin-header.php' );
global $wpdb;
$current_user            = wp_get_current_user();
$wbl_plugin_notice_shown = get_option( 'wbl_plugin_notice_shown1' );
?>

	<div class="wcpfc-main-table res-cl">
		<h2>Thanks For Installing WooCommerce Save For Later Cart Enhancement</h2>
		<table class="table-outer">
			<tbody>
			<tr>
				<td class="fr-2">
					<p class="block gettingstarted"><strong>Getting Started </strong></p>
					<p class="block textgetting">
						This plugin allows customers to save products and keeps them saved for later purchase. This tool can be handy if they are not sure to purchase any item
						which is in the cart.
					</p>
					<p class="block textgetting">
						<strong>Step 1 :</strong> Add Custom text for save for later button / link.
					<p class="block textgetting">Once you have activated the plugin,You will get this interface to add custom text for save for later button / link.</p>
					<span class="gettingstarted">
                        <img style="border: 2px solid #e9e9e9;margin-top: 3%;" src="<?php echo esc_url( WSFL_PLUGIN_URL . 'admin/images/1_wsfl.png' ); ?>">
                    </span>
					</p>
					<p class="block gettingstarted textgetting">
						<strong>Step 2 :</strong> View saves for later link on checkout page
						<span class="gettingstarted">
                            <img style="border: 2px solid #e9e9e9;margin-top: 3%;" src="<?php echo esc_url( WSFL_PLUGIN_URL . 'admin/images/2_wsfl.png' ); ?>">
                        </span>
					<p class="block textgetting">Clicking the link "<b>Save For Later</b>", products are removed from the cart and move to the separated list that you can find at
						the top of the "save for later page".
					</p>
					</p>

					<p class="block gettingstarted textgetting">
						<strong>Step 3 :</strong> Automatically Generate "Save For Later Page" at checkout
					<p class="block textgetting">The installation and activate the plugin will create automatically the "Save for Later" page: it will show the product list that
						users have moved from the cart to save for later.</p>
					<span class="gettingstarted">
                        <img style="border: 2px solid #e9e9e9;margin-top: 3%;" src="<?php echo esc_url( WSFL_PLUGIN_URL . 'admin/images/3_wsfl.png' ); ?>">
                    </span>
					</p>
					<p class="block gettingstarted textgetting">
						<strong>Please note:</strong> This plugin is only compatible for WooCommerce version (2.4.0 and more)
					</p>

				</td>
			</tr>
			</tbody>
		</table>
	</div>
<?php require_once( 'header/plugin-sidebar.php' ); ?>