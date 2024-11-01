<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'header/plugin-header.php' );
global $wpdb;
$current_user = wp_get_current_user();
?>

	<div class="wcpfc-main-table res-cl">
		<h2><?php _e( 'Quick info', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?></h2>
		<table class="table-outer">
			<tbody>
			<tr>
				<td class="fr-1"><?php _e( 'Product Type', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?></td>
				<td class="fr-2"><?php _e( 'WooCommerce Plugin', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?></td>
			</tr>
			<tr>
				<td class="fr-1"><?php _e( 'Product Name', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?></td>
				<td class="fr-2"><?php _e( $plugin_name, WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?></td>
			</tr>
			<tr>
				<td class="fr-1"><?php _e( 'Installed Version', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?></td>
				<td class="fr-2"><?php _e( 'Free Version', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?><?php echo $plugin_version; ?></td>
			</tr>
			<tr>
				<td class="fr-1"><?php _e( 'License & Terms of use', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?></td>
				<td class="fr-2"><a target="_blank"
				                    href="http://t.signauxdeux.com/e1t/c/5/f18dQhb0SmZ58dDMPbW2n0x6l2B9nMJW7sM9dn7dK_MMdBzM2-04?t=https%3A%2F%2Fstore.multidots.com%2Fterms-conditions%2F&si=4973901068632064&pi=61378fda-f5e5-4125-c521-28a4597b13d6">
						<?php _e( 'Click here', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?></a>
					<?php _e( 'to view license and terms of use.', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?>
				</td>
			</tr>
			<tr>
				<td class="fr-1"><?php _e( 'Help & Support', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?></td>
				<td class="fr-2 wcpfc-information">
					<ul>
						<li><a target="_blank"
						       href="<?php echo site_url( 'wp-admin/admin.php?page=wsfl-get-started' ); ?>"><?php _e( 'Quick Start', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?></a>
						</li>
						<li><a target="_blank"
						       href="https://store.multidots.com/docs/plugins/woocommerce-save-for-later-cart-enhancement/"><?php _e( 'Guide Documentation', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?></a>
						</li>
						<li><a target="_blank"
						       href="http://t.signauxdeux.com/e1t/c/5/f18dQhb0SmZ58dDMPbW2n0x6l2B9nMJW7sM9dn7dK_MMdBzM2-04?t=https%3A%2F%2Fstore.multidots.com%2Fdotstore-support-panel%2F&si=4973901068632064&pi=61378fda-f5e5-4125-c521-28a4597b13d6"><?php _e( 'Support Forum', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?></a>
						</li>
					</ul>
				</td>
			</tr>
			<tr>
				<td class="fr-1"><?php _e( 'Localization', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?></td>
				<td class="fr-2"><?php _e( 'English', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?>
					, <?php _e( 'Spanish', WOO_SAVE_FOR_LATER_TEXT_DOMAIN ); ?></td>
			</tr>

			</tbody>
		</table>
	</div>
<?php require_once( 'header/plugin-sidebar.php' ); ?>