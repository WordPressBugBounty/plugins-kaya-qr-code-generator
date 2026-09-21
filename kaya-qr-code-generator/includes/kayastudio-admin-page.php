<?php

/**
 * Kaya Studio - Admin Main Page
 * Displays Kaya Studio admin main page.
 *
 * @version 1.1.0
 */

/**
 * Displays Kaya Studio page.
 */
if (!function_exists('kayastudio_plugins_admin_doMainPage'))
{
	function kayastudio_plugins_admin_doMainPage()
	{
		if (!current_user_can('edit_posts'))
		{
			wp_die('<p>' . esc_html__('You do not have sufficient permissions.') . '</p>');
		}

		global $wp_kayastudio_dashboard_pluginsList;
		$pluginsList = $wp_kayastudio_dashboard_pluginsList->getPluginList();

?>
		<div class="ks-wp-dashboard-page-container">
			<div class="ks-wp-dashboard-page-row">

				<div class="ks-wp-dashboard-page-header">
					<div class="ks-wp-dashboard-page-header-title">
						<h1>Kaya Studio</h1>
					</div>
				</div>

				<div class="ks-wp-dashboard-page-content">

					<div class="ks-wp-dashboard-page-header-intro">
						<h2><?php esc_html_e('WordPress plugins', 'kaya-qr-code-generator'); ?></h2>
						<p>
							<?php esc_html_e(
								'Free plugins developed by Kaya Studio to add useful features to WordPress.',
								'kaya-qr-code-generator'
							); ?>
						</p>
					</div>

					<div class="ks-wp-dashboard-page-content-grid">

						<?php foreach ($pluginsList as $i_plugin) : ?>

							<div class="ks-wp-dashboard-page-content-card">
								<h2 class="ks-wp-dashboard-page-content-card-title">
									<?php echo esc_html($i_plugin['title']); ?>
								</h2>

								<p>
									<?php echo esc_html($i_plugin['page_text']); ?>
								</p>

								<p class="ks-wp-dashboard-page-content-card-action">
									<a
										href="<?php echo esc_url(admin_url('admin.php?page=' . $i_plugin['page_slug'])); ?>"
										class="ks-wp-dashboard-page-btn ks-wp-dashboard-page-btn-primary"
										title="<?php echo esc_attr($i_plugin['page_name']); ?>">
										<?php echo esc_html($i_plugin['page_name']); ?>
									</a>
								</p>
							</div>

						<?php endforeach; ?>

						<div class="ks-wp-dashboard-page-content-card ks-wp-dashboard-page-content-card-all-plugins">
							<h2 class="ks-wp-dashboard-page-content-card-title">
								<?php esc_html_e('Free WordPress plugins by Kaya Studio', 'kaya-qr-code-generator'); ?>
							</h2>

							<p>
								<?php esc_html_e(
									'These plugins are developed independently and maintained in my spare time to provide simple and useful solutions for WordPress.',
									'kaya-qr-code-generator'
								); ?>
							</p>

							<p class="ks-wp-dashboard-page-content-card-action">
								<a
									href="<?php echo esc_url('https://profiles.wordpress.org/kayastudio#content-plugins'); ?>"
									class="ks-wp-dashboard-page-btn ks-wp-dashboard-page-btn-secondary"
									target="_blank"
									rel="noopener noreferrer"
									title="<?php esc_attr_e('Discover all plugins by Kaya Studio', 'kaya-qr-code-generator'); ?>">
									<?php esc_html_e('Discover all plugins', 'kaya-qr-code-generator'); ?>
								</a>
							</p>
						</div>

					</div>

				</div>

				<div class="ks-wp-dashboard-page-sidebar">
					<?php

					if (is_file(WPKQCG_PLUGIN_PATH . 'includes/kayastudio-admin-page-sidebar.php'))
					{
						include_once WPKQCG_PLUGIN_PATH . 'includes/kayastudio-admin-page-sidebar.php';
						kayastudio_plugins_admin_doMainPageSidebar();
					}

					?>
				</div>

			</div>
		</div>
<?php

	}
}
