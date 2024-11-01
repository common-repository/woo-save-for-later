<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'header/plugin-header.php' );
global $wpdb;
$current_user = wp_get_current_user();

if (
	! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )
	&& ! is_plugin_active_for_network( 'woocommerce/woocommerce.php' )
) {
	wp_die( "<strong>" . WSFL_PLUGIN_NAME . "</strong> Plugin requires <strong>WooCommerce</strong> <a href='" . get_admin_url( null, 'plugins.php' ) . "'>Plugins page</a>." );
}

$getPluginOption   = get_option( WSFL_PLUGIN_OPTION_ADD_KEY );
$getPluginOption   = maybe_unserialize( $getPluginOption );
$getPluginLinkText = '';

if (
	'' !== $getPluginOption
	&& ! empty( $getPluginOption )
	&& ! empty( $getPluginOption['page_link_text'] )
	&& '' !== $getPluginOption['page_link_text']
) {
	$getPluginLinkText = $getPluginOption['page_link_text'];
}
?>
	<div class="wcpfc-main-table res-cl">
		<h2><?php echo __( WSFL_PLUGIN_MENU_PAGE_TITLE, WSFL_PLUGIN_SLUG ); ?></h2>

		<form id="wsfl_plugin_form_id" method="post" action="<?php echo esc_url( get_admin_url() . 'admin-post.php' ); ?>" enctype="multipart/form-data" novalidate="novalidate">
			<input type='hidden' name='action' value='wsfl-submit-form' />
			<input type='hidden' name='wsfl_action_which' value='add' />

			<table class="form-table table-outer product-fee-table">
				<tbody>
				<tr>
					<th class="titledesc" scope="row"><?php echo __( WSFL_PLUGIN_PAGE_TEXT, WSFL_PLUGIN_SLUG ); ?></th>
					<td class="set_fonts forminp mdtooltip">
						<input type="text" value="<?php echo ( $getPluginLinkText ) ? esc_attr( $getPluginLinkText ) : 'Save for Later'; ?>" name="wsfl_page_text_title"
						       class="set_wsfl_text_title">
					</td>
				</tr>
				<tr>
					<th class="titledesc" scope="row"><?php echo __( WSFL_PLUGIN_PAGE_NAME, WSFL_PLUGIN_SLUG ); ?></th>
					<td class="set_fonts forminp mdtooltip">
						<input type="text" readonly value="Save For Later" name="wsfl_page_name" class="set_wsfl_page_name">
					</td>
				</tr>
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" value="<?php echo __( WSFL_PLUGIN_SAVE_BUTTON_TITLE, WSFL_PLUGIN_SLUG ); ?>" class="button button-primary" id="wsfl_submit_plugin"
				       name="wsfl_submit_plugin">
				<input type="reset" value="<?php echo __( WSFL_PLUGIN_RESET_BUTTON_TITLE, WSFL_PLUGIN_SLUG ); ?>" class="button button-primary" id="wsfl_reset_plugin"
				       name="wsfl_reset_plugin">
			</p>
		</form>
	</div>

<?php require_once( 'header/plugin-sidebar.php' ); ?>