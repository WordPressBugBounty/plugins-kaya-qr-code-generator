<?php

/**
 * Kaya QR Code Generator - Metabox.
 * The Kaya QR Code metabox display the Shortcode generator assistant to the admin interface.
 * The Shortcode generator assistant is available on pages, posts, WooCommerce products and all other public custom post types.
 */

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly
}

/**
 * Calls the QRCodeMetaBox Metabox class on the page edit screen.
 */
function wpkqcg_call_Metabox_qrcodemetabox()
{
	return new WPKQCG_Metabox_qrcodemetabox();
}
if (is_admin())
{
	add_action('load-post.php', 'wpkqcg_call_Metabox_qrcodemetabox');
	add_action('load-post-new.php', 'wpkqcg_call_Metabox_qrcodemetabox');
}

/** 
 * QRCodeMetaBox Metabox Class.
 *
 * @class WPKQCG_Metabox_qrcodemetabox
 */
class WPKQCG_Metabox_qrcodemetabox
{
	/**
	 * Construct the Metabox and Hook into the appropriate actions.
	 */
	public function __construct()
	{
		add_action('add_meta_boxes', array(&$this, 'add_page_meta_box'));
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_page_meta_box()
	{
		// include the WPKQCG_qrcode_generator class
		require_once(WPKQCG_PLUGIN_PATH . 'lib/class.crud_qrcode_generator.php');
		// init WPKQCG_qrcode_generator object
		$kayaQRCodeGenerator = new WPKQCG_qrcode_generator();

		// check if current role is allowed
		$currentRoleAllowed = wpkqcg_admin_isCurrentRoleAllowed($kayaQRCodeGenerator);

		// return if current role is not allowed
		if (!$currentRoleAllowed)
		{
			return;
		}

		// Get meta box context
		$metaBoxContext = isset($kayaQRCodeGenerator->data->_shortcode_assistant_metabox_context) ? $kayaQRCodeGenerator->data->_shortcode_assistant_metabox_context : 'normal';
		if (!in_array($metaBoxContext, array('normal', 'advanced')))
		{
			$metaBoxContext = 'normal';
		}

		// Get meta box priority
		$metaBoxPriority = isset($kayaQRCodeGenerator->data->_shortcode_assistant_metabox_priority) ? $kayaQRCodeGenerator->data->_shortcode_assistant_metabox_priority : 'high';
		if (!in_array($metaBoxPriority, array('high', 'core', 'default', 'low')))
		{
			$metaBoxPriority = 'high';
		}

		// Get alowed post types
		$postTypes = wpkqcg_admin_getAllowedPostTypes($kayaQRCodeGenerator, array(), array('wpkqcg_admin_dashboard'));

		add_meta_box(
			'wpkqcg-page-meta-box-qrcodemetabox',
			'Kaya QR Code Generator',
			array(&$this, 'render_meta_box_content'),
			$postTypes,
			$metaBoxContext,
			$metaBoxPriority,
			null
		);
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content($post)
	{
		// include the WPKQCG_qrcode_generator class
		require_once(WPKQCG_PLUGIN_PATH . 'lib/class.crud_qrcode_generator.php');
		// init WPKQCG_qrcode_generator object
		$kayaQRCodeGenerator = new WPKQCG_qrcode_generator();

		// get form fields and default values
		$formFieldsHTML = WPKQCG_Forms_QRCode::display_form_fields_options();
		$formFieldsDefaultValues = WPKQCG_Forms_QRCode::get_fields_default_value();

		// check for light form settings
		$isGeneratorCollapsed = false;
		if (isset($kayaQRCodeGenerator->data->{'_shortcode_assistant_light'}) && $kayaQRCodeGenerator->data->{'_shortcode_assistant_light'})
		{
			$isGeneratorCollapsed = true;
		}

		// shortcode preparation
		$shortcodeGenerated = '[kaya_qrcode]';

		// img preview preparation
		$currentPostID			= isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : false);
		$currentPostPermalink	= (!empty($currentPostID) ? get_permalink($currentPostID) : '');
		$currentAdminURL		= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$formFieldsValidated	= WPKQCG_Forms_QRCode::validate_fields($formFieldsDefaultValues);

		// notice html
		$qrcodeNoticeHTML = '<div class="wpkqcg-shortcode-generator-notice">';
		$qrcodeNoticeHTML .= '<p>';
		$qrcodeNoticeHTML .= '<strong>' . esc_html__('About this generator', 'kaya-qr-code-generator') . '</strong>';
		$qrcodeNoticeHTML .= '</p>';
		$qrcodeNoticeHTML .= '<p>';
		$qrcodeNoticeHTML .= esc_html__('This generator helps you build a QR code shortcode. Its fields do not modify the post content or add custom fields to the post.', 'kaya-qr-code-generator');
		$qrcodeNoticeHTML .= '</p>';
		$qrcodeNoticeHTML .= '<p>';
		$qrcodeNoticeHTML .= esc_html__('Once generated, copy the shortcode and insert it into a Shortcode block or directly into your content.', 'kaya-qr-code-generator');
		$qrcodeNoticeHTML .= '</p>';
		$qrcodeNoticeHTML .= '</div>';


		// shortcode html
		$qrcodeShortcodeHTML = '<input type="hidden" id="wpkqcg_shortcode_generator_sc_name" value="kaya_qrcode" />';
		$qrcodeShortcodeHTML .= '<input type="hidden" id="wpkqcg_shortcode_generator_sc_name_dynamic" value="kaya_qrcode_dynamic" />';
		$qrcodeShortcodeHTML .= '<input type="hidden" id="wpkqcg_shortcode_generator_fields_default" value="' . esc_attr(json_encode($formFieldsDefaultValues)) . '" />';
		$qrcodeShortcodeHTML .= '<div style="display:flex;align-items:center;gap:12px;overflow-x:auto;margin-top:16px;padding:14px 16px;background:rgba(0,0,0,.07);border:1px solid #dcdcde;border-radius:5px;">'
			. '<code id="wpkqcg_shortcode_generator_display" style="display:block;flex:1 1 auto;min-width:0;color:#1d2327;background-color:transparent;font-size:13px;line-height:1.6;white-space:pre-wrap;word-break:break-word;" >'
			. esc_html($shortcodeGenerated)
			. '</code>'
			. '<button 
			type="button" 
			style="flex:0 0 auto;margin:0;padding:0;color:#2271b1;background:0 0;border:0;box-shadow:none;font-size:12px;font-weight:600;line-height:1.4;text-decoration:none;cursor:pointer;" 
			id="wpkqcg_shortcode_generator_copy" 
			data-copy-text="' . esc_attr__('Copy', 'kaya-qr-code-generator') . '"
			data-copied-text="' . esc_attr__('Copied', 'kaya-qr-code-generator') . '"
			aria-label="' . esc_attr__('Copy shortcode', 'kaya-qr-code-generator') . '"
			>'
			. esc_html__('Copy', 'kaya-qr-code-generator')
			. '</button>'
			. '</div>';

		// img html
		$qrcodeImgHTML = '<input type="hidden" id="wpkqcg_shortcode_generator_content_post_id" value="' . esc_attr($currentPostID) . '" />';
		$qrcodeImgHTML .= '<input type="hidden" id="wpkqcg_shortcode_generator_content_url_admin" value="' . esc_attr(esc_url($currentAdminURL)) . '" />';
		$qrcodeImgHTML .= '<input type="hidden" id="wpkqcg_shortcode_generator_content_url_default" value="' . esc_attr(esc_url($currentPostPermalink)) . '" />';
		$qrcodeImgHTML .= '<div id="wpkqcg_shortcode_generator_preview_img" style="flex-direction: column; align-items: center; justify-content: center;">';
		$qrcodeImgHTML .= '<div><center>' . wpkqcg_doDisplayQRCode($formFieldsValidated) . '</center></div>';
		$qrcodeImgHTML .= '<div><center>';
		$qrcodeImgHTML .= '<button type="button" onclick="wpkqcg_qrcode_preview_download();" id="wpkqcg_shortcode_generator_preview_open" class="button button-secondary is-button is-default is-large">' . esc_html__('Download QR Code', 'kaya-qr-code-generator') . '</button>';
		$qrcodeImgHTML .= '</center></div></div>';

		// alert permalink html
		$qrcodeAlertHTML = '<div id="wpkqcg_shortcode_generator_preview_permalink_alert" style="display:none;color:#000;background-color:#ddffff;border:1px solid #ccc;padding:16px 32px;">';
		$qrcodeAlertHTML .= esc_html__('The post must be saved for a QR Code preview with the permalink as content.', 'kaya-qr-code-generator');
		$qrcodeAlertHTML .= '</div>';

		// alert dynamic html
		$qrcodeAlertHTML .= '<div id="wpkqcg_shortcode_generator_preview_dynamic_alert" style="display:none;color:#000;background-color:#ddffff;border:1px solid #ccc;padding:16px 32px;">';
		$qrcodeAlertHTML .= esc_html__('The QR code preview is not available with dynamic content.', 'kaya-qr-code-generator');
		$qrcodeAlertHTML .= '</div>';

		// set light form display
		$formClass = '';
		$formStyle = '';
		$formToggle = '';
		if ($isGeneratorCollapsed)
		{
			$formClass	= 'wpkqcg_shortcode_generator_hide';
			$formStyle	= 'display: none;';
			$formToggle	= '<br /><button type="button" onclick="wpkqcg_qrcode_light_form_toggle();" id="wpkqcg_shortcode_generator_form_open" class="components-button button-primary is-primary">' . esc_html__('Show / Hide the Shortcode generator', 'kaya-qr-code-generator') . '</button><br /><br />';
		}

		// set metabox HTML content
		$output = '';

		// $output .= $formToggle;

		$output .= '<style>';
		$output .= '
		.wpkqcg-shortcode-generator-notice {
			margin: 20px 0;
			padding: 12px 16px;
			background-color: #f6f7f7;
			border: 1px solid #dcdcde;
			border-left: 4px solid #2271b1;
			border-radius: 4px;
			color: #50575e;
		}
		.wpkqcg-shortcode-generator-notice p {
			margin: 0 0 8px;
			line-height: 1.5;
		}
		.wpkqcg-shortcode-generator-notice p:last-child {
			margin-bottom: 0;
		}
		.wpkqcg-shortcode-generator-notice strong {
			color: #1d2327;
		}
		#wpkqcg-page-meta-box-qrcodemetabox table tr th {
			padding: 0;
		}
		#wpkqcg-page-meta-box-qrcodemetabox table tr th h3 {
			padding-left: 10px;
			color: #273476;
		}
		.ks-wp-dashboard-page-settings-fields {
			margin: 20px 1rem 0;
			padding: 0 1rem 1rem;
			background-color: #fafbfe;
			border-radius: 8px;
		}
		.ks-wp-dashboard-page-settings-fields h4 {
			margin: 20px -1rem;
			padding: 10px;
			color: #121836;
			font-size: 16px;
			font-weight: 600;
			line-height: 1.4;
			background-color: #f1f3fb;
			border: 1px solid #dcdcde;
			border-top-left-radius: 8px;
			border-top-right-radius: 8px;
		}
		.ks-wp-dashboard-page-settings-fields label {
			display: flex;
			align-items: center;
			gap: 6px;
			padding: 4px 0;
			margin: 16px 0 8px;
			line-height: 1;
		}
		.ks-wp-dashboard-page-settings-fields p.description {
			display: block;
			padding: 4px 0;
			margin: 4px 0 16px;
			font-size: 13px !important;
		}
			';
		$output .= '</style>';
		$output .= '<table class="form-table"><tbody>';
		$output .= '<tr>';
		$output .= '<td valign="top" style="vertical-align: top;"><center><h3>' . esc_html__('QR Code preview', 'kaya-qr-code-generator') . '</h3></center>' . $qrcodeImgHTML . $qrcodeAlertHTML . '</td>';
		$output .= '<td valign="top" style="vertical-align: top;"><h3>' . esc_html__('Generated shortcode', 'kaya-qr-code-generator') . '</h3>' . $qrcodeShortcodeHTML . '<br /><br />' . $formToggle . '</td>';
		$output .= '</tr>';
		$output .= '</tbody></table>';

		$output .= '<table class="form-table ' . esc_attr($formClass) . '" style="' . esc_attr($formStyle) . '"><tbody>';
		$output .= '<tr><td>' . $qrcodeNoticeHTML . '</td></tr>';
		$output .= '<tr><th><h3>' . esc_html__('Shortcode generator', 'kaya-qr-code-generator') . '</h3></th></tr>';
		$output .= '<tr><td><div class="ks-wp-dashboard-page-settings-fields">' . $formFieldsHTML . '</div></td></tr>';
		$output .= '</tbody></table>';


		$output .= "<script>
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
		</script>";

		// display metabox HTML content
		echo $output;
	}
}
