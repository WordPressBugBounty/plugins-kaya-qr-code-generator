<?php

/**
 * Kaya QR Code Generator - Admin Page Sidebar
 * Displays Kaya QR Code Generator admin page sidebar.
 */

/**
 * Displays QR Code Generator page sidebar.
 */
function wpkqcg_admin_doPageSidebar()
{
	if (!current_user_can('manage_options'))
	{
		wp_die('<p>' . __('You do not have sufficient permissions.') . '</p>');
	}

?>
	<!-- Review -->
	<div class="ks-wp-dashboard-page-card">

		<div class="ks-wp-dashboard-page-card-header">
			<?php esc_html_e('Your feedback matters', 'kaya-qr-code-generator'); ?>
		</div>

		<div class="ks-wp-dashboard-page-card-body">
			<h5 class="ks-wp-dashboard-page-card-title">

				<?php esc_html_e('Is this plugin useful to you?', 'kaya-qr-code-generator'); ?> ⭐
			</h5>

			<p class="ks-wp-dashboard-page-card-text">
				<?php esc_html_e(
					'Your review helps other users discover this plugin and encourages me to keep improving it.',
					'kaya-qr-code-generator'
				); ?>
			</p>

			<p class="ks-wp-dashboard-page-card-text">
				<a href="<?php echo esc_url('https://wordpress.org/support/plugin/kaya-qr-code-generator/reviews/?rate=5#new-post'); ?>"
					class="ks-wp-dashboard-page-btn ks-wp-dashboard-page-btn-primary"
					target="_blank"
					rel="noopener noreferrer"
					title="<?php esc_attr_e('Rate and review this plugin at WordPress.org', 'kaya-qr-code-generator'); ?>">
					<?php esc_html_e('Leave a review', 'kaya-qr-code-generator'); ?>
				</a>
			</p>

		</div>
	</div>
<?php

}
