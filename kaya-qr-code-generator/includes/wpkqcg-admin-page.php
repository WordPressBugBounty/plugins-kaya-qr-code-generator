<?php

/**
 * Kaya QR Code Generator - Admin Page.
 * Displays the admin plugin page.
 *
 * @since 1.4.1
 */

/**
 * Display QR Code Generator Page.
 */
function wpkqcg_admin_doOptionPage()
{
	if (!current_user_can('manage_options'))
	{
		wp_die('<p>' . __('You do not have sufficient permissions.') . '</p>');
	}

	$wpkqcg_active_tab = 'overview';

	$wpkqcg_footer = sprintf(/* translators: 1: Plugin Name 2: Plugin Version */__('%1$s - Version %2$s', 'kaya-qr-code-generator'), 'Kaya QR Code Generator', WPKQCG_VERSION);
?>
	<div class="ks-wp-dashboard-page-container">
		<div class="ks-wp-dashboard-page-row">

			<div class="ks-wp-dashboard-page-header">
				<div class="ks-wp-dashboard-page-header-title">
					<h1>Kaya QR Code Generator</h1>
				</div>
			</div>

			<div class="ks-wp-dashboard-page-content">


				<!-- TABS -->
				<nav class="ks-wp-dashboard-page-content-card-full ks-wp-dashboard-page-tabs" aria-label="<?php esc_attr_e('Plugin sections', 'kaya-qr-code-generator'); ?>">

					<button
						type="button"
						class="ks-wp-dashboard-page-tab is-active"
						id="wpkqcg-tab-overview"
						aria-controls="wpkqcg-panel-overview"
						aria-selected="true"
						data-tab="overview">
						<?php esc_html_e('Overview', 'kaya-qr-code-generator'); ?>
					</button>

					<button
						type="button"
						class="ks-wp-dashboard-page-tab"
						id="wpkqcg-tab-generator"
						aria-controls="wpkqcg-panel-generator"
						aria-selected="false"
						data-tab="generator">
						<?php esc_html_e('Shortcode generator', 'kaya-qr-code-generator'); ?>
					</button>

					<button
						type="button"
						class="ks-wp-dashboard-page-tab"
						id="wpkqcg-tab-settings"
						aria-controls="wpkqcg-panel-settings"
						aria-selected="false"
						data-tab="settings">
						<?php esc_html_e('Settings', 'kaya-qr-code-generator'); ?>
					</button>

				</nav>


				<!-- OVERVIEW -->
				<div
					id="wpkqcg-panel-overview"
					class="ks-wp-dashboard-page-tab-panel is-active"
					role="tabpanel"
					aria-labelledby="wpkqcg-tab-overview">

					<div class="ks-wp-dashboard-page-header-intro">

						<h2><?php esc_html_e('QR Code Generator', 'kaya-qr-code-generator'); ?></h2>

						<p>
							<?php esc_html_e('Create and display QR codes in your WordPress content using shortcodes, the built-in Gutenberg block or widgets.', 'kaya-qr-code-generator'); ?>
						</p>

						<p>
							<?php esc_html_e('You can write a shortcode manually, use the Shortcode generator to create one without having to remember its options, or add a QR code directly with the Gutenberg block.', 'kaya-qr-code-generator'); ?>
						</p>

						<p>
							<?php esc_html_e('The Shortcode generator is also available directly in supported WordPress editors, so you can create a QR code where you are already working.', 'kaya-qr-code-generator'); ?>
						</p>

					</div>

					<div class="ks-wp-dashboard-page-content-grid">

						<div class="ks-wp-dashboard-page-content-card ks-wp-dashboard-page-content-card-full">

							<h2 class="ks-wp-dashboard-page-content-card-title">
								<?php esc_html_e('Shortcode examples', 'kaya-qr-code-generator'); ?>
							</h2>

							<p class="ks-wp-dashboard-page-content-card-description">
								<?php esc_html_e('There are two shortcodes available, depending on whether the QR code content is static or generated dynamically.', 'kaya-qr-code-generator'); ?>
							</p>

							<div class="ks-wp-dashboard-page-shortcode-examples">

								<div class="ks-wp-dashboard-page-shortcode-example">

									<div class="ks-wp-dashboard-page-shortcode-example-header">
										<h3>
											<?php esc_html_e('Static content', 'kaya-qr-code-generator'); ?>
										</h3>
										<span class="ks-wp-dashboard-page-shortcode-example-tag">
											kaya_qrcode
										</span>
									</div>

									<p>
										<?php esc_html_e('Use this shortcode when the QR code content is entered directly in the shortcode. If no content is specified, the URL of the current page is used automatically.', 'kaya-qr-code-generator'); ?>
									</p>

									<div class="ks-wp-dashboard-page-shortcode-example-code">
										<code>[kaya_qrcode]</code>
										<span>
											<?php esc_html_e('Uses the current page URL as QR code content.', 'kaya-qr-code-generator'); ?>
										</span>
									</div>

									<div class="ks-wp-dashboard-page-shortcode-example-code">
										<code>[kaya_qrcode content="https://example.com"]</code>
										<span>
											<?php esc_html_e('Encodes the specified text, URL or other content.', 'kaya-qr-code-generator'); ?>
										</span>
									</div>

								</div>

								<div class="ks-wp-dashboard-page-shortcode-example">

									<div class="ks-wp-dashboard-page-shortcode-example-header">
										<h3>
											<?php esc_html_e('Dynamic content', 'kaya-qr-code-generator'); ?>
										</h3>
										<span class="ks-wp-dashboard-page-shortcode-example-tag">
											kaya_qrcode_dynamic
										</span>
									</div>

									<p>
										<?php esc_html_e('Use this shortcode when the QR code content comes from another shortcode. The content between the opening and closing tags is processed before generating the QR code.', 'kaya-qr-code-generator'); ?>
									</p>

									<div class="ks-wp-dashboard-page-shortcode-example-code">
										<code>[kaya_qrcode_dynamic][another_shortcode_content][/kaya_qrcode_dynamic]</code>
										<span>
											<?php esc_html_e('Encodes the content generated by another shortcode.', 'kaya-qr-code-generator'); ?>
										</span>
									</div>

								</div>

							</div>

							<p class="ks-wp-dashboard-page-content-card-note">
								<?php esc_html_e('Additional options can be added to either shortcode. Use the Shortcode generator to create them without having to write the options manually.', 'kaya-qr-code-generator'); ?>
							</p>

						</div>

					</div>

				</div>



				<!-- GENERATOR -->
				<div
					id="wpkqcg-panel-generator"
					class="ks-wp-dashboard-page-tab-panel"
					role="tabpanel"
					aria-labelledby="wpkqcg-tab-generator"
					hidden>

					<div class="ks-wp-dashboard-page-header-intro">

						<h2><?php esc_html_e('Shortcode generator', 'kaya-qr-code-generator'); ?></h2>

						<p>
							<?php esc_html_e('Create a QR code shortcode without manually entering its options.', 'kaya-qr-code-generator'); ?>
						</p>

						<p>
							<?php esc_html_e('Choose the settings you need below. The shortcode and QR code preview will update automatically.', 'kaya-qr-code-generator'); ?>
						</p>

						<div class="ks-wp-dashboard-page-info">
							<p>
								<strong><?php esc_html_e('This is a shortcode creation tool, not a plugin setting.', 'kaya-qr-code-generator'); ?></strong>
								<?php esc_html_e('You can also use the generator directly in supported WordPress editors.', 'kaya-qr-code-generator'); ?>
							</p>
						</div>

					</div>

					<div class="ks-wp-dashboard-page-content-grid">

						<div class="ks-wp-dashboard-page-content-card ks-wp-dashboard-page-content-card-full">

							<h2 class="ks-wp-dashboard-page-content-card-title">
								<?php esc_html_e('QR Code generator', 'kaya-qr-code-generator'); ?>
							</h2>

							<?php
							// get form fields and default values
							$formFieldsHTML = WPKQCG_Forms_QRCode::display_form_fields_options();
							$formFieldsDefaultValues = WPKQCG_Forms_QRCode::get_fields_default_value();

							// shortcode preparation
							$shortcodeGenerated = '[kaya_qrcode]';

							// img preview preparation
							$currentPostID			= false;
							$currentPostPermalink	= '';
							$currentAdminURL		= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
							$formFieldsValidated	= WPKQCG_Forms_QRCode::validate_fields($formFieldsDefaultValues);

							// shortcode html
							$qrcodeShortcodeHTML = '<input type="hidden" id="wpkqcg_shortcode_generator_sc_name" value="kaya_qrcode" />';
							$qrcodeShortcodeHTML .= '<input type="hidden" id="wpkqcg_shortcode_generator_sc_name_dynamic" value="kaya_qrcode_dynamic" />';
							$qrcodeShortcodeHTML .= '<input type="hidden" id="wpkqcg_shortcode_generator_fields_default" value="' . esc_attr(json_encode($formFieldsDefaultValues)) . '" />';

							$qrcodeShortcodeHTML .= '<div class="ks-wp-dashboard-page-generated-shortcode">';
							$qrcodeShortcodeHTML .= '<code id="wpkqcg_shortcode_generator_display">' . esc_html($shortcodeGenerated) . '</code>';
							$qrcodeShortcodeHTML .= '<button 
								type="button" 
								class="ks-wp-dashboard-page-generated-shortcode-copy" 
								id="wpkqcg_shortcode_generator_copy" 
								data-copy-text="' . esc_attr__('Copy', 'kaya-qr-code-generator') . '"
								data-copied-text="' . esc_attr__('Copied', 'kaya-qr-code-generator') . '"
								aria-label="' . esc_attr__('Copy shortcode', 'kaya-qr-code-generator') . '"
								>';
							$qrcodeShortcodeHTML .= esc_html__('Copy', 'kaya-qr-code-generator');
							$qrcodeShortcodeHTML .= '</button>';
							$qrcodeShortcodeHTML .= '</div>';


							// img html
							$qrcodeImgHTML = '<input type="hidden" id="wpkqcg_shortcode_generator_content_post_id" value="' . esc_attr($currentPostID) . '" />';
							$qrcodeImgHTML .= '<input type="hidden" id="wpkqcg_shortcode_generator_content_url_admin" value="' . esc_attr(esc_url($currentAdminURL)) . '" />';
							$qrcodeImgHTML .= '<input type="hidden" id="wpkqcg_shortcode_generator_content_url_default" value="' . esc_attr(esc_url($currentPostPermalink)) . '" />';
							$qrcodeImgHTML .= '<div id="wpkqcg_shortcode_generator_preview_img">';
							$qrcodeImgHTML .= '<div>' . wpkqcg_doDisplayQRCode($formFieldsValidated) . '</div>';
							$qrcodeImgHTML .= '<div>';
							$qrcodeImgHTML .= '<button type="button" onclick="wpkqcg_qrcode_preview_download();" id="wpkqcg_shortcode_generator_preview_open" class="button button-secondary is-button is-default is-large">' . esc_html__('Download QR code', 'kaya-qr-code-generator') . '</button>';
							$qrcodeImgHTML .= '</div></div>';

							// alert permalink html
							$qrcodeAlertHTML = '<div id="wpkqcg_shortcode_generator_preview_permalink_alert" class="ks-wp-dashboard-page-generator-alert" style="display:none;">';
							$qrcodeAlertHTML .= esc_html__('The QR code preview is not available on the plugin settings page when using the permalink as content.', 'kaya-qr-code-generator');
							$qrcodeAlertHTML .= '</div>';

							// alert dynamic html
							$qrcodeAlertHTML .= '<div id="wpkqcg_shortcode_generator_preview_dynamic_alert" class="ks-wp-dashboard-page-generator-alert" style="display:none;">';
							$qrcodeAlertHTML .= esc_html__('The QR code preview is not available with dynamic content.', 'kaya-qr-code-generator');
							$qrcodeAlertHTML .= '</div>';

							?>

							<div class="ks-wp-dashboard-page-settings-preview">
								<div class="ks-wp-dashboard-page-settings-section-header">
									<h3><?php esc_html_e('Generated shortcode', 'kaya-qr-code-generator'); ?></h3>
									<p>
										<?php esc_html_e('Shortcode generated from the current settings.', 'kaya-qr-code-generator'); ?>
									</p>
								</div>

								<?= $qrcodeShortcodeHTML; ?>

								<script>
									document.addEventListener('DOMContentLoaded', function() {
										const copyButton = document.getElementById('wpkqcg_shortcode_generator_copy');
										const shortcodeDisplay = document.getElementById('wpkqcg_shortcode_generator_display');

										if (!copyButton || !shortcodeDisplay) {
											return;
										}

										copyButton.addEventListener('click', function() {
											const shortcode = shortcodeDisplay.textContent;
											const copyText = copyButton.getAttribute('data-copy-text');
											const copiedText = copyButton.getAttribute('data-copied-text');

											if (!shortcode) {
												return;
											}

											navigator.clipboard.writeText(shortcode).then(function() {
												copyButton.textContent = copiedText;

												window.setTimeout(function() {
													copyButton.textContent = copyText;
												}, 1500);
											});
										});
									});
								</script>
							</div>

							<div class="ks-wp-dashboard-page-settings-preview">
								<div class="ks-wp-dashboard-page-settings-section-header">
									<h3><?php esc_html_e('QR code preview', 'kaya-qr-code-generator'); ?></h3>
									<p>
										<?php esc_html_e('Preview generated from the current settings.', 'kaya-qr-code-generator'); ?>
									</p>
								</div>

								<?= $qrcodeImgHTML . $qrcodeAlertHTML; ?>
							</div>

							<div class="ks-wp-dashboard-page-settings-section-header ks-wp-dashboard-page-settings-section-header-spaced">
								<h3><?php esc_html_e('Generator settings', 'kaya-qr-code-generator'); ?></h3>
								<p>
									<?php esc_html_e('Configure the options used to generate the shortcode.', 'kaya-qr-code-generator'); ?>
								</p>
							</div>

							<div class="ks-wp-dashboard-page-settings-fields">
								<?= $formFieldsHTML; ?>
							</div>

						</div>


					</div>

				</div>


				<!-- SETTINGS -->
				<div
					id="wpkqcg-panel-settings"
					class="ks-wp-dashboard-page-tab-panel"
					role="tabpanel"
					aria-labelledby="wpkqcg-tab-settings"
					hidden>

					<div class="ks-wp-dashboard-page-header-intro">

						<h2><?php esc_html_e('QR Code Generator settings', 'kaya-qr-code-generator'); ?></h2>

						<p>
							<?php esc_html_e('Configure where the shortcode generator is available and set the default QR code colors.', 'kaya-qr-code-generator'); ?>
						</p>

					</div>

					<div class="ks-wp-dashboard-page-content-grid">

						<div class="ks-wp-dashboard-page-content-card ks-wp-dashboard-page-content-card-full">

							<h2 class="ks-wp-dashboard-page-content-card-title">
								<?php esc_html_e('Settings', 'kaya-qr-code-generator'); ?>
							</h2>

							<?php

							// include the WPKQCG_qrcode_generator class
							require_once(WPKQCG_PLUGIN_PATH . 'lib/class.crud_qrcode_generator.php');
							// init WPKQCG_qrcode_generator object
							$kayaQRCodeGenerator = new WPKQCG_qrcode_generator();

							// QR Code Generator variables texts
							$wpkqcg_textSave			= __('Save Changes', 'kaya-qr-code-generator');
							$wpkqcg_textReset			= __('Reset settings', 'kaya-qr-code-generator');
							$wpkqcg_textResetConfirm	= __('Do you want to delete the current settings?', 'kaya-qr-code-generator');

							// QR Code Generator customs roles inputs
							$wpkqcg_customRoles = wpkqcg_admin_getUsersRoles();
							$wpkqcg_customRoles_inputs = '';
							foreach ($wpkqcg_customRoles as $i_role)
							{
								$roleKey = esc_attr($i_role['id']);
								$roleValue = esc_html(translate_user_role($i_role['name']));

								$wpkqcg_customRoles_inputs .= '<label for="wpkqcg_shortcode_assistant_to_' . $roleKey . '">';
								$wpkqcg_customRoles_inputs .= '<input id="wpkqcg_shortcode_assistant_to_' . $roleKey . '" name="wpkqcg[data][_shortcode_assistant_to_' . $roleKey . ']" value="1" type="checkbox" ' .
									checked(
										!empty($kayaQRCodeGenerator->data->{'_shortcode_assistant_to_' . $roleKey}),
										true,
										false
									) .
									'>';
								$wpkqcg_customRoles_inputs .=  $roleValue;
								$wpkqcg_customRoles_inputs .= '</label>';
							}

							// QR Code Generator public post types
							$wpkqcg_postTypes = wpkqcg_admin_getAllPostTypesAsList();
							unset($wpkqcg_postTypes['wpkqcg_admin_dashboard']);
							$wpkqcg_postTypes_inputs = '';
							foreach ($wpkqcg_postTypes as $i_postTypeKey => $i_postTypeValue)
							{
								$postType_key	= esc_attr($i_postTypeKey);
								$postTypeObj	= get_post_type_object($postType_key);
								$postTypeValue	= esc_html($postTypeObj->label);

								$wpkqcg_postTypes_inputs .= '<label for="wpkqcg_shortcode_assistant_in_' . $postType_key . '">';
								$wpkqcg_postTypes_inputs .= '<input id="wpkqcg_shortcode_assistant_in_' . $postType_key . '" name="wpkqcg[data][_shortcode_assistant_in_' . $postType_key . ']" value="1" type="checkbox" ' . ((isset($kayaQRCodeGenerator->data->{'_shortcode_assistant_in_' . $postType_key}) && $kayaQRCodeGenerator->data->{'_shortcode_assistant_in_' . $postType_key}) ? 'checked' : '') . '>';
								$wpkqcg_postTypes_inputs .=  $postTypeValue;
								$wpkqcg_postTypes_inputs .= '</label>';
							}

							// QR Code Generator light form input
							$wpkqcg_lightForm_inputs = '<label for="wpkqcg_shortcode_assistant_light">';
							$wpkqcg_lightForm_inputs .= '<input id="wpkqcg_shortcode_assistant_light" name="wpkqcg[data][_shortcode_assistant_light]" value="1" type="checkbox" ' . ((isset($kayaQRCodeGenerator->data->{'_shortcode_assistant_light'}) && $kayaQRCodeGenerator->data->{'_shortcode_assistant_light'}) ? 'checked' : '') . '>';
							$wpkqcg_lightForm_inputs .=  __('Activate', 'kaya-qr-code-generator');
							$wpkqcg_lightForm_inputs .= '</label>';

							// QR Code Generator meta box context inputs
							$wpkqcg_metaboxContext_inputs = '<select id="wpkqcg_shortcode_assistant_metabox_context" name="wpkqcg[data][_shortcode_assistant_metabox_context]">';
							$wpkqcg_metaboxContext_inputs .= '<option value="normal" ' . ((isset($kayaQRCodeGenerator->data->{'_shortcode_assistant_metabox_context'}) && $kayaQRCodeGenerator->data->{'_shortcode_assistant_metabox_context'} == 'normal') ? 'selected="selected"' : '') . '>' . esc_html__('Normal location', 'kaya-qr-code-generator') . '</option>';
							$wpkqcg_metaboxContext_inputs .= '<option value="advanced" ' . ((isset($kayaQRCodeGenerator->data->{'_shortcode_assistant_metabox_context'}) && $kayaQRCodeGenerator->data->{'_shortcode_assistant_metabox_context'} == 'advanced') ? 'selected="selected"' : '') . '>' . esc_html__('Advanced location', 'kaya-qr-code-generator') . '</option>';
							$wpkqcg_metaboxContext_inputs .= '</select>';

							// QR Code Generator meta box priority inputs
							$wpkqcg_metaboxPriority_inputs = '<select id="wpkqcg_shortcode_assistant_metabox_priority" name="wpkqcg[data][_shortcode_assistant_metabox_priority]">';
							$wpkqcg_metaboxPriority_inputs .= '<option value="high" ' . ((isset($kayaQRCodeGenerator->data->{'_shortcode_assistant_metabox_priority'}) && $kayaQRCodeGenerator->data->{'_shortcode_assistant_metabox_priority'} == 'high') ? 'selected="selected"' : '') . '>' . esc_html__('High priority', 'kaya-qr-code-generator') . '</option>';
							$wpkqcg_metaboxPriority_inputs .= '<option value="core" ' . ((isset($kayaQRCodeGenerator->data->{'_shortcode_assistant_metabox_priority'}) && $kayaQRCodeGenerator->data->{'_shortcode_assistant_metabox_priority'} == 'core') ? 'selected="selected"' : '') . '>' . esc_html__('Core priority', 'kaya-qr-code-generator') . '</option>';
							$wpkqcg_metaboxPriority_inputs .= '<option value="default" ' . ((isset($kayaQRCodeGenerator->data->{'_shortcode_assistant_metabox_priority'}) && $kayaQRCodeGenerator->data->{'_shortcode_assistant_metabox_priority'} == 'default') ? 'selected="selected"' : '') . '>' . esc_html__('Default priority', 'kaya-qr-code-generator') . '</option>';
							$wpkqcg_metaboxPriority_inputs .= '<option value="low" ' . ((isset($kayaQRCodeGenerator->data->{'_shortcode_assistant_metabox_priority'}) && $kayaQRCodeGenerator->data->{'_shortcode_assistant_metabox_priority'} == 'low') ? 'selected="selected"' : '') . '>' . esc_html__('Low priority', 'kaya-qr-code-generator') . '</option>';
							$wpkqcg_metaboxPriority_inputs .= '</select>';

							// QR Code Generator default image color input
							$wpkqcg_imageDefaultColor_inputs = '<input id="wpkqcg_shortcode_assistant_image_defaultColor" name="wpkqcg[data][_shortcode_assistant_image_defaultColor]" type="text" class="wp-kqcg-color-picker" value="' . (isset($kayaQRCodeGenerator->data->{'_shortcode_assistant_image_defaultColor'}) ? $kayaQRCodeGenerator->data->{'_shortcode_assistant_image_defaultColor'} : '#000000') . '" />';

							// QR Code Generator default image background-color input
							$wpkqcg_imageDefaultBGColor_inputs = '<input id="wpkqcg_shortcode_assistant_image_defaultBGColor" name="wpkqcg[data][_shortcode_assistant_image_defaultBGColor]" type="text" class="wp-kqcg-color-picker" value="' . (isset($kayaQRCodeGenerator->data->{'_shortcode_assistant_image_defaultBGColor'}) ? $kayaQRCodeGenerator->data->{'_shortcode_assistant_image_defaultBGColor'} : '#FFFFFF') . '" />';

							?>

							<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">

								<div class="ks-wp-dashboard-page-settings-section-header">
									<h3><?php esc_html_e('Shortcode generator availability', 'kaya-qr-code-generator'); ?></h3>
									<p>
										<?php esc_html_e('Configure where the shortcode generator is available in the WordPress administration.', 'kaya-qr-code-generator'); ?>
									</p>
								</div>

								<div class="ks-wp-dashboard-page-settings-fields">

									<h4><?php esc_html_e('Generator display', 'kaya-qr-code-generator'); ?></h4>

									<label><strong><?php esc_html_e('Display the shortcode generator for these user roles', 'kaya-qr-code-generator'); ?></strong></label>
									<div class="ks-wp-dashboard-page-roles">
										<?php echo $wpkqcg_customRoles_inputs; ?>
									</div>
									<label><strong><?php esc_html_e('Display the shortcode generator for these post types', 'kaya-qr-code-generator'); ?></strong></label>
									<div class="ks-wp-dashboard-page-posts">
										<?php echo $wpkqcg_postTypes_inputs; ?>
									</div>

									<label><strong><?php esc_html_e('Collapsed shortcode generator in editor', 'kaya-qr-code-generator'); ?></strong></label>
									<?php echo $wpkqcg_lightForm_inputs; ?>
									<p class="description">
										<?php esc_html_e('Display only the generated shortcode and QR code preview by default. The full generator can be shown or hidden with the toggle button.', 'kaya-qr-code-generator'); ?>
									</p>


									<h4><?php esc_html_e('Generator meta box', 'kaya-qr-code-generator'); ?></h4>

									<label for="wpkqcg_shortcode_assistant_metabox_context"><strong><?php esc_html_e('Meta box location', 'kaya-qr-code-generator'); ?></strong></label>
									<?php echo $wpkqcg_metaboxContext_inputs; ?>
									<p class="description"><?php esc_html_e('Choose where the generator meta box is displayed in the editor.', 'kaya-qr-code-generator'); ?></p>

									<label for="wpkqcg_shortcode_assistant_metabox_priority"><strong><?php esc_html_e('Meta box priority', 'kaya-qr-code-generator'); ?></strong></label>
									<?php echo $wpkqcg_metaboxPriority_inputs; ?>
									<p class="description"><?php esc_html_e('Choose the display priority of the generator meta box in the editor.', 'kaya-qr-code-generator'); ?></p>

								</div>

								<div class="ks-wp-dashboard-page-settings-section-header ks-wp-dashboard-page-settings-section-header-spaced">
									<h3><?php esc_html_e('QR Code defaults', 'kaya-qr-code-generator'); ?></h3>
									<p>
										<?php esc_html_e('Set the default colors used when no colors are specified in a shortcode, block or widget.', 'kaya-qr-code-generator'); ?>
									</p>
								</div>

								<div class="ks-wp-dashboard-page-settings-fields">

									<h4><?php esc_html_e('Default colors', 'kaya-qr-code-generator'); ?></h4>

									<label><strong><?php esc_html_e('Default QR Code color', 'kaya-qr-code-generator'); ?></strong></label>
									<?php echo $wpkqcg_imageDefaultColor_inputs; ?>
									<p class="description"><?php esc_html_e('Used when no QR Code color is specified in a shortcode, block or widget.', 'kaya-qr-code-generator'); ?></p>

									<label><strong><?php esc_html_e('Default background color', 'kaya-qr-code-generator'); ?></strong></label>
									<?php echo $wpkqcg_imageDefaultBGColor_inputs; ?>
									<p class="description"><?php esc_html_e('Used when no background color is specified in a shortcode, block or widget.', 'kaya-qr-code-generator'); ?></p>

								</div>

								<?php

								wp_nonce_field(
									'wpkqcg_crud_' . get_current_user_id(),
									'wpkqcg_crud_edit',
									true,
									true
								);

								?>

								<input type="hidden" name="wpkqcg[id]" value="<?php echo esc_attr($kayaQRCodeGenerator->id); ?>" />
								<input type="hidden" name="wpkqcg_action" value="edit" />
								<input type="hidden" name="action" value="wpkqcg_qr_code_generator_form">
								<input type="hidden" name="wpkqcg_target" value="qr_code_generator" />

								<div class="ks-wp-dashboard-page-form-actions">

									<input
										class="ks-wp-dashboard-page-btn ks-wp-dashboard-page-btn-primary"
										type="submit"
										name="save_qr_code_generator"
										value="<?php echo esc_attr($wpkqcg_textSave); ?>" />

								</div>

							</form>

							<div class="ks-wp-dashboard-page-settings-danger">

								<div class="ks-wp-dashboard-page-settings-section-header">

									<h3>
										<?php esc_html_e('Reset settings', 'kaya-qr-code-generator'); ?>
									</h3>

									<p>
										<?php esc_html_e('Delete the current saved settings and restore the default configuration.', 'kaya-qr-code-generator'); ?>
									</p>

								</div>

								<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">

									<input type="hidden" name="wpkqcg[id]" value="<?php echo esc_attr($kayaQRCodeGenerator->id); ?>" />
									<input type="hidden" name="wpkqcg_action" value="delete" />
									<input type="hidden" name="action" value="wpkqcg_qr_code_generator_form" />
									<input type="hidden" name="wpkqcg_target" value="qr_code_generator" />

									<?php

									wp_nonce_field(
										'wpkqcg_crud_' . get_current_user_id(),
										'wpkqcg_crud_delete',
										true,
										true
									);

									?>

									<div class="ks-wp-dashboard-page-form-actions">

										<input
											class="ks-wp-dashboard-page-btn ks-wp-dashboard-page-btn-warning"
											type="submit"
											name="delete_qr_code_generator"
											value="<?php echo esc_attr($wpkqcg_textReset); ?>"
											onclick="return confirm('<?php echo esc_js($wpkqcg_textResetConfirm); ?>');" />
									</div>

								</form>

							</div>

						</div>
					</div>


				</div>

			</div>

			<div class="ks-wp-dashboard-page-sidebar">
				<?php
				if (is_file(plugin_dir_path(__FILE__) . 'wpkqcg-admin-page-sidebar.php'))
				{
					include_once plugin_dir_path(__FILE__) . 'wpkqcg-admin-page-sidebar.php';
					wpkqcg_admin_doPageSidebar();
				}
				if (is_file(plugin_dir_path(__FILE__) . 'kayastudio-admin-page-sidebar.php'))
				{
					include_once plugin_dir_path(__FILE__) . 'kayastudio-admin-page-sidebar.php';
					kayastudio_plugins_admin_doMainPageSidebar();
				}
				?>
			</div>

			<div class="ks-wp-dashboard-page-footer">
				<div class="ks-wp-dashboard-page-footer-version">
					<p><?php echo esc_html($wpkqcg_footer); ?></p>
				</div>
			</div>


		</div>
	</div>

<?php
}
