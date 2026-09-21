<?php

/** 
 * Kaya QR Code Generator - QRCode Forms Class
 * Set QRCode Forms.
 */

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly
}

class WPKQCG_Forms_QRCode
{
	/**
	 * return Array of fields strucutre
	 */
	private static function get_fields()
	{

		// include the WPKQCG_qrcode_generator class
		require_once(WPKQCG_PLUGIN_PATH . 'lib/class.crud_qrcode_generator.php');
		// init WPKQCG_qrcode_generator object
		$kayaQRCodeGenerator = new WPKQCG_qrcode_generator();

		//	Fields setting
		$fields = array(

			// Title settings

			array(
				'_meta_type'       => 'section_head',
				'_meta_slug'       => 'section_title',
				'_label'           => __('Title', 'kaya-qr-code-generator'),
				'_description'     => '',
				'_class'           => '',
				'_value_default'   => ''
			),

			array(
				'_meta_type'       => 'text',
				'_meta_slug'       => 'title',
				'_label'           => __('Title', 'kaya-qr-code-generator'),
				'_description'     => __('Optional title displayed above the QR code.', 'kaya-qr-code-generator'),
				'_class'           => 'widefat',
				'_value_default'   => ''
			),

			array(
				'_meta_type'       => 'select',
				'_meta_slug'       => 'title_level',
				'_label'           => __('Heading level', 'kaya-qr-code-generator'),
				'_description'     => __('Choose the heading level for the title. The default is h2.', 'kaya-qr-code-generator'),
				'_options'         => array(
					'1'   => 'h1',
					'2'   => 'h2',
					'3'   => 'h3',
					'4'   => 'h4',
					'5'   => 'h5',
					'6'   => 'h6'
				),
				'_value_default'   => '2'
			),

			array(
				'_meta_type'       => 'select',
				'_meta_slug'       => 'title_align',
				'_label'           => __('Title alignment', 'kaya-qr-code-generator'),
				'_description'     => __('Choose how the title is aligned horizontally.', 'kaya-qr-code-generator'),
				'_options'         => array(
					'alignnone'   => __('None', 'kaya-qr-code-generator'),
					'alignleft'   => __('Left', 'kaya-qr-code-generator'),
					'aligncenter' => __('Center', 'kaya-qr-code-generator'),
					'alignright'  => __('Right', 'kaya-qr-code-generator')
				),
				'_value_default'   => 'alignnone'
			),

			// Content settings

			array(
				'_meta_type'       => 'section_head',
				'_meta_slug'       => 'section_content',
				'_label'           => __('Content', 'kaya-qr-code-generator'),
				'_description'     => '',
				'_class'           => '',
				'_value_default'   => ''
			),

			array(
				'_meta_type'       => 'text',
				'_meta_slug'       => 'content',
				'_label'           => __('Content to encode', 'kaya-qr-code-generator'),
				'_description'     => __('Enter the text, URL or other content to encode in the QR code. Leave empty to automatically use the current page URL.', 'kaya-qr-code-generator'),
				'_class'           => 'widefat',
				'_value_default'   => ''
			),

			array(
				'_meta_type'       => 'checkbox',
				'_meta_slug'       => 'dynamic_content',
				'_label'           => __('Process dynamic content', 'kaya-qr-code-generator'),
				'_description'     => __('Enable this option to process other shortcodes contained in the QR code content.', 'kaya-qr-code-generator'),
				'_value_default'   => 0
			),

			array(
				'_meta_type'       => 'text',
				'_meta_slug'       => 'querystring',
				'_label'           => __('Query string', 'kaya-qr-code-generator'),
				'_description'     => __('Optional query parameters added to the current page URL. Do not include the initial "?". This option is only available when the content field is empty.', 'kaya-qr-code-generator'),
				'_class'           => 'widefat',
				'_value_default'   => ''
			),

			array(
				'_meta_type'       => 'text',
				'_meta_slug'       => 'anchor',
				'_label'           => __('URL anchor', 'kaya-qr-code-generator'),
				'_description'     => __('Optional anchor added to the current page URL. Do not include the initial "#". This option is only available when the content field is empty.', 'kaya-qr-code-generator'),
				'_class'           => 'widefat',
				'_value_default'   => ''
			),

			// Image settings

			array(
				'_meta_type'       => 'section_head',
				'_meta_slug'       => 'section_image',
				'_label'           => __('QR code image', 'kaya-qr-code-generator'),
				'_description'     => '',
				'_class'           => '',
				'_value_default'   => ''
			),

			array(
				'_meta_type'       => 'select',
				'_meta_slug'       => 'ecclevel',
				'_label'           => __('Error correction level', 'kaya-qr-code-generator'),
				'_description'     => __('Determines how much of the QR code can be damaged or obscured while remaining readable.', 'kaya-qr-code-generator'),
				'_options'         => array(
					'L' => __('Low ~7%', 'kaya-qr-code-generator'),
					'M' => __('Medium ~15%', 'kaya-qr-code-generator'),
					'Q' => __('Quartile ~25%', 'kaya-qr-code-generator'),
					'H' => __('High ~30%', 'kaya-qr-code-generator')
				),
				'_value_default'   => 'L'
			),

			array(
				'_meta_type'       => 'number',
				'_meta_slug'       => 'size',
				'_label'           => __('Size', 'kaya-qr-code-generator'),
				'_description'     => __('Set the QR code size in pixels. Leave empty to use the automatic size.', 'kaya-qr-code-generator'),
				'_value_default'   => ''
			),

			array(
				'_meta_type'       => 'select',
				'_meta_slug'       => 'border',
				'_label'           => __('Border width', 'kaya-qr-code-generator'),
				'_description'     => __('Set the width of the empty margin around the QR code. The default is 4.', 'kaya-qr-code-generator'),
				'_options'         => array(
					'1'  => '1',
					'2'  => '2',
					'3'  => '3',
					'4'  => '4',
					'5'  => '5',
					'6'  => '6',
					'7'  => '7',
					'8'  => '8',
					'9'  => '9',
					'10' => '10'
				),
				'_value_default'   => '4'
			),

			array(
				'_meta_type'       => 'color',
				'_meta_slug'       => 'color',
				'_label'           => __('QR code color', 'kaya-qr-code-generator'),
				'_description'     => __('Choose the color of the QR code. Leave empty to use the default color.', 'kaya-qr-code-generator'),
				'_value_default'   => isset($kayaQRCodeGenerator->data->_shortcode_assistant_image_defaultColor) ? $kayaQRCodeGenerator->data->_shortcode_assistant_image_defaultColor : ''
			),

			array(
				'_meta_type'       => 'color',
				'_meta_slug'       => 'bgcolor',
				'_label'           => __('Background color', 'kaya-qr-code-generator'),
				'_description'     => __('Choose the background color of the QR code. Leave empty to use the default color. Use "#FFFFFF00" for a transparent background.', 'kaya-qr-code-generator'),
				'_value_default'   => isset($kayaQRCodeGenerator->data->_shortcode_assistant_image_defaultBGColor) ? $kayaQRCodeGenerator->data->_shortcode_assistant_image_defaultBGColor : ''
			),

			array(
				'_meta_type'       => 'select',
				'_meta_slug'       => 'align',
				'_label'           => __('Image alignment', 'kaya-qr-code-generator'),
				'_description'     => __('Choose how the QR code image is aligned horizontally.', 'kaya-qr-code-generator'),
				'_options'         => array(
					'alignnone'   => __('None', 'kaya-qr-code-generator'),
					'alignleft'   => __('Left', 'kaya-qr-code-generator'),
					'aligncenter' => __('Center', 'kaya-qr-code-generator'),
					'alignright'  => __('Right', 'kaya-qr-code-generator')
				),
				'_value_default'   => 'alignnone'
			),

			array(
				'_meta_type'       => 'checkbox',
				'_meta_slug'       => 'css_shadow',
				'_label'           => __('Add a shadow to the QR code', 'kaya-qr-code-generator'),
				'_description'     => __('Add a visual shadow around the QR code image.', 'kaya-qr-code-generator'),
				'_value_default'   => 0
			),

			array(
				'_meta_type'       => 'checkbox',
				'_meta_slug'       => 'no_css',
				'_label'           => __('Disable the plugin styles', 'kaya-qr-code-generator'),
				'_description'     => __('Disable the default plugin styles applied to the QR code image.', 'kaya-qr-code-generator'),
				'_value_default'   => 0
			),

			array(
				'_meta_type'       => 'text',
				'_meta_slug'       => 'alt',
				'_label'           => __('Alternative text', 'kaya-qr-code-generator'),
				'_description'     => __('Optional alternative text for the QR code image. Leave empty to use "QR Code".', 'kaya-qr-code-generator'),
				'_class'           => 'widefat',
				'_value_default'   => ''
			),

			// Link settings

			array(
				'_meta_type'       => 'section_head',
				'_meta_slug'       => 'section_url',
				'_label'           => __('Clickable link', 'kaya-qr-code-generator'),
				'_description'     => '',
				'_class'           => '',
				'_value_default'   => ''
			),

			array(
				'_meta_type'       => 'url',
				'_meta_slug'       => 'url',
				'_label'           => __('Destination URL', 'kaya-qr-code-generator'),
				'_description'     => __('Make the QR code image clickable by entering a destination URL.', 'kaya-qr-code-generator'),
				'_class'           => 'widefat',
				'_value_default'   => ''
			),

			array(
				'_meta_type'       => 'checkbox',
				'_meta_slug'       => 'new_window',
				'_label'           => __('Open the link in a new tab', 'kaya-qr-code-generator'),
				'_description'     => __('Open the destination URL in a new browser tab when the QR code image is clicked.', 'kaya-qr-code-generator'),
				'_value_default'   => 0
			),

			array(
				'_meta_type'       => 'checkbox',
				'_meta_slug'       => 'content_url',
				'_label'           => __('Use the QR code content as the link', 'kaya-qr-code-generator'),
				'_description'     => __('Use the QR code content as the clickable link. This option is only available when no destination URL is specified.', 'kaya-qr-code-generator'),
				'_value_default'   => 0
			),

			// Download settings

			array(
				'_meta_type'       => 'section_head',
				'_meta_slug'       => 'section_download',
				'_label'           => __('Download button', 'kaya-qr-code-generator'),
				'_description'     => '',
				'_class'           => '',
				'_value_default'   => ''
			),

			array(
				'_meta_type'       => 'checkbox',
				'_meta_slug'       => 'download_button',
				'_label'           => __('Add a download button', 'kaya-qr-code-generator'),
				'_description'     => __('Display a button that allows visitors to download the QR code image.', 'kaya-qr-code-generator'),
				'_value_default'   => 0
			),

			array(
				'_meta_type'       => 'text',
				'_meta_slug'       => 'download_text',
				'_label'           => __('Button text', 'kaya-qr-code-generator'),
				'_description'     => __('Text displayed on the download button. Leave empty to use "Download QR code".', 'kaya-qr-code-generator'),
				'_class'           => 'widefat',
				'_value_default'   => ''
			),

			array(
				'_meta_type'       => 'select',
				'_meta_slug'       => 'download_align',
				'_label'           => __('Button alignment', 'kaya-qr-code-generator'),
				'_description'     => __('Choose how the download button is aligned horizontally.', 'kaya-qr-code-generator'),
				'_options'         => array(
					'alignnone'   => __('None', 'kaya-qr-code-generator'),
					'alignleft'   => __('Left', 'kaya-qr-code-generator'),
					'aligncenter' => __('Center', 'kaya-qr-code-generator'),
					'alignright'  => __('Right', 'kaya-qr-code-generator')
				),
				'_value_default'   => 'alignnone'
			),

		);

		return $fields;
	}

	/**
	 * return Array of fields default values
	 */
	public static function get_fields_default_value()
	{
		$fields_default = array();
		//	get form fields array
		$fields_Tab = WPKQCG_Forms_QRCode::get_fields();
		//	get default values
		foreach ($fields_Tab as $field)
		{
			$fields_default[$field['_meta_slug']] = $field['_value_default'];
		}

		return $fields_default;
	}

	/**
	 * return Array field by slug
	 *
	 * @return mixed array|boolean
	 */
	private static function get_field_by_slug($p_slug)
	{
		//	get form fields array
		$fields_Tab = WPKQCG_Forms_QRCode::get_fields();
		//	get field by slug
		foreach ($fields_Tab as $field)
		{
			if ($field['_meta_slug'] == $p_slug)
			{
				return $field;
			}
		}

		return false;
	}

	/**
	 * return options Object
	 *
	 * @return stdClass
	 */
	private static function get_form_options()
	{
		$options_Obj = new stdClass();
		//	Options setting
		$options_Tab = array(
			'_form_onchange' => 'wpkqcg_qrcode_sc_gen',
		);
		//	switch from array to Object
		foreach ($options_Tab as $attr => $val)
		{
			$options_Obj->$attr = $val;
		}

		return $options_Obj;
	}

	/**
	 * return Array accepted options
	 *
	 * @return mixed array|boolean
	 */
	private static function get_accepted_options($p_slug)
	{
		$field = WPKQCG_Forms_QRCode::get_field_by_slug($p_slug);

		if (isset($field['_options'])) return $field['_options'];

		return false;
	}

	/**
	 * Display HTML form fields
	 */
	public static function display_form_fields($p_fields_val = false, $p_function_ids = false)
	{
		//	get form fields
		$form_fields = WPKQCG_Forms_QRCode::get_form_fields($p_fields_val, $p_function_ids);
		//	display form fields
		$o = WPKQCG_Forms::display_form($form_fields, false);

		return $o;
	}

	/**
	 * Display HTML form fields with form options
	 */
	public static function display_form_fields_options($p_fields_val = false, $p_function_ids = false)
	{
		//	get form fields
		$form_fields = WPKQCG_Forms_QRCode::get_form_fields($p_fields_val, $p_function_ids);
		//	get form options
		$form_options = WPKQCG_Forms_QRCode::get_form_options();
		//	display form fields
		$o = WPKQCG_Forms::display_form($form_fields, $form_options);

		return $o;
	}

	/**
	 * return Array with fields Object
	 */
	private static function get_form_fields($p_fields_val = false, $p_function_ids = false)
	{
		$fields_Obj = array();
		//	get form fields array
		$fields_Tab = WPKQCG_Forms_QRCode::get_fields();

		foreach ($fields_Tab as $field)
		{
			$form_field = new stdClass();
			//	switch from array to Object
			foreach ($field as $attr => $val)
			{
				$form_field->$attr = $val;
			}
			//	get field value
			if (empty($p_fields_val))
			{
				$field_val = false;
			}
			else
			{
				$field_val = isset($p_fields_val[$form_field->_meta_slug]) ? $p_fields_val[$form_field->_meta_slug] : false;
			}
			//	validate field value
			$form_field->_value = WPKQCG_Forms_QRCode::validate_field($form_field->_meta_slug, $field_val, $form_field->_value_default);
			//	get callable functions to set ids values
			if (!$p_function_ids)
			{
				$function_ids_id	= false;
				$function_ids_name	= false;
			}
			else
			{
				$function_ids_id	= $p_function_ids['_id'];
				$function_ids_name	= $p_function_ids['_name'];
			}
			//	set ids values : field id and name
			$form_field->_id	= WPKQCG_Forms_QRCode::set_field_id($form_field->_meta_slug, $function_ids_id);
			$form_field->_name	= WPKQCG_Forms_QRCode::set_field_name($form_field->_meta_slug, $function_ids_name);
			//	Add object to the list
			$fields_Obj[] = $form_field;
		}

		return $fields_Obj;
	}

	/**
	 * Set one field id
	 */
	private static function set_field_id($p_meta_slug, $p_function_id = false)
	{
		$field_id = '';
		if (!empty($p_function_id) && method_exists($p_function_id[0], $p_function_id[1]))
		{
			//	get id through callable function
			$field_id = call_user_func(array($p_function_id[0], $p_function_id[1]), $p_meta_slug);
		}
		else
		{
			//	generate unique field id
			$field_unique_id = rand(0, 99) . uniqid() . rand(0, 99);
			$field_id = 'wpkqcg_data_' . $p_meta_slug . '_' . $field_unique_id;
		}

		return $field_id;
	}

	/**
	 * Set one field name
	 */
	private static function set_field_name($p_meta_slug, $p_function_name = false)
	{
		$field_name = '';
		if (!empty($p_function_name) && method_exists($p_function_name[0], $p_function_name[1]))
		{
			//	get name through callable function
			$field_name = call_user_func(array($p_function_name[0], $p_function_name[1]), $p_meta_slug);
		}
		else
		{
			//	generate field name
			$field_name = 'wpkqcg[data][' . $p_meta_slug . ']';
		}

		return $field_name;
	}


	/**
	 * Get the QR Code fields definition for Gutenberg.
	 *
	 * @return array
	 */
	public static function get_gutenberg_fields()
	{
		$fields = self::get_fields();

		/*
		* Fields displayed directly inside the block placeholder.
		*/
		$main_field_slugs = array(
			'content',
			'dynamic_content'
		);

		/*
		* Gutenberg attribute types corresponding to the plugin field types.
		*/
		$attribute_types = array(
			'text'     => 'string',
			'url'      => 'string',
			'textarea' => 'string',
			'select'   => 'string',
			'color'    => 'string',
			'checkbox' => 'boolean',
			'number'   => ['number', 'null']
		);

		$gutenberg_fields = array();
		$gutenberg_panels = array();
		$gutenberg_attributes = array();

		$current_panel = null;


		/*
		* Convert one plugin field definition into a Gutenberg field
		* and Gutenberg attribute definition.
		*/
		$process_field = function ($field) use ($attribute_types)
		{
			if (
				empty($field['_meta_slug'])
				|| empty($field['_meta_type'])
				|| !isset($attribute_types[$field['_meta_type']])
			)
			{
				return null;
			}

			$slug = $field['_meta_slug'];
			$type = $field['_meta_type'];
			$attribute_type = $attribute_types[$type];

			$default = isset($field['_value_default'])
				? $field['_value_default']
				: '';


			/*
			* Gutenberg field definition.
			*/
			$gutenberg_field = array(
				'name'        => $slug,
				'type'        => $type,
				'label'       => isset($field['_label'])
					? $field['_label']
					: '',
				'description' => isset($field['_description'])
					? $field['_description']
					: '',
				'default'     => $default
			);


			/*
			* Select options.
			*/
			if (
				$type === 'select'
				&& !empty($field['_options'])
			)
			{
				$gutenberg_field['options'] = array();

				foreach ($field['_options'] as $value => $label)
				{
					$gutenberg_field['options'][] = array(
						'value' => $value,
						'label' => $label
					);
				}
			}


			/*
			* Gutenberg block attribute definition.
			*/
			$attribute = array(
				'type' => $attribute_type
			);


			/*
			* Add the default value when it matches the
			* Gutenberg attribute type.
			*/
			if ($attribute_type === 'string')
			{
				$attribute['default'] = (string) $default;
			}
			elseif ($attribute_type === 'boolean')
			{
				$attribute['default'] = (bool) $default;
			}
			elseif (
				$attribute_type === 'number'
				&& is_numeric($default)
			)
			{
				$attribute['default'] = (float) $default;
			}


			return array(
				'field'     => $gutenberg_field,
				'attribute' => $attribute
			);
		};


		foreach ($fields as $field)
		{
			if (empty($field['_meta_type']))
			{
				continue;
			}


			/*
			* A section_head starts a new Gutenberg PanelBody.
			*/
			if ($field['_meta_type'] === 'section_head')
			{
				$current_panel = array(
					'title'  => isset($field['_label'])
						? $field['_label']
						: '',
					'fields' => array()
				);

				$gutenberg_panels[] = $current_panel;

				/*
				* Keep a reference to the panel we have just created.
				*/
				$current_panel_index = count($gutenberg_panels) - 1;

				continue;
			}


			$processed_field = $process_field($field);

			if ($processed_field === null)
			{
				continue;
			}

			$slug = $field['_meta_slug'];


			/*
			* All supported fields become block attributes.
			*/
			$gutenberg_attributes[$slug] = $processed_field['attribute'];


			/*
			* Main fields are displayed directly in the block.
			*/
			if (in_array($slug, $main_field_slugs, true))
			{
				$gutenberg_fields[] = $processed_field['field'];

				continue;
			}


			/*
			* All other fields are added to the current panel.
			*/
			if (isset($current_panel_index))
			{
				$gutenberg_panels[$current_panel_index]['fields'][] =
					$processed_field['field'];
			}
		}
		return array(
			'fields'       => $gutenberg_fields,
			'panels'       => $gutenberg_panels,
			'attributes'   => $gutenberg_attributes,
			'messages'     => array(
				'unsaved_permalink' => __(
					'The post must be saved for a QR Code preview with the permalink as content.',
					'kaya-qr-code-generator'
				),
				'description' => __(
					'Add a QR code to your content.',
					'kaya-qr-code-generator'
				)
			)
		);
	}

	/**
	 * validate all fields values
	 */
	public static function validate_fields($p_fields_values)
	{
		$fields_valid = array();
		//	get form fields array
		$fields_Tab = WPKQCG_Forms_QRCode::get_fields();

		foreach ($fields_Tab as $field)
		{
			$_meta_type		= $field['_meta_type'];
			$_meta_slug		= $field['_meta_slug'];
			$_value_default	= $field['_value_default'];
			if ($_meta_type !== 'section_head')
			{
				//	validate field value
				$fields_valid[$_meta_slug] = WPKQCG_Forms_QRCode::validate_field($_meta_slug, (isset($p_fields_values[$_meta_slug]) ? $p_fields_values[$_meta_slug] : NULL), $_value_default);
			}
		}

		return $fields_valid;
	}

	/**
	 * validate one field value
	 */
	private static function validate_field($p_field_slug, $p_field_value, $p_field_value_default)
	{
		$field_valid = '';

		//	title settings
		if ($p_field_slug == 'title')
		{
			$field_valid = (!empty($p_field_value) && is_string($p_field_value)) ? $p_field_value : $p_field_value_default;	//	title is string
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'title_align')
		{
			$accepted_options = WPKQCG_Forms_QRCode::get_accepted_options($p_field_slug);
			$field_valid = (!empty($p_field_value) && is_string($p_field_value) && array_key_exists($p_field_value, $accepted_options)) ? $p_field_value : $p_field_value_default;	//	title_align is string and key
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'title_level')
		{
			$accepted_options = WPKQCG_Forms_QRCode::get_accepted_options($p_field_slug);
			$field_valid = (!empty($p_field_value) && is_string($p_field_value) && array_key_exists($p_field_value, $accepted_options)) ? $p_field_value : $p_field_value_default;	//	title_level is string and key
			$field_valid = sanitize_text_field($field_valid);
		}
		//	content settings
		elseif ($p_field_slug == 'content')
		{
			$field_valid = (!empty($p_field_value) && is_string($p_field_value)) ? $p_field_value : $p_field_value_default;	//	content is string
			$field_valid = WPKQCG_Forms_QRCode::sanitize_qrCodeContent($field_valid);
		}
		elseif ($p_field_slug == 'dynamic_content')
		{
			$field_valid = (!empty($p_field_value) && is_numeric($p_field_value)) ? $p_field_value : $p_field_value_default;	//	dynamic_content is numeric
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'querystring')
		{
			$field_valid = (!empty($p_field_value) && is_string($p_field_value)) ? $p_field_value : $p_field_value_default;	//	querystring is string
			$field_valid = ltrim($field_valid, '?');
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'anchor')
		{
			$field_valid = (!empty($p_field_value) && is_string($p_field_value)) ? $p_field_value : $p_field_value_default;	//	anchor is string
			$field_valid = ltrim($field_valid, '#');
			$field_valid = sanitize_text_field($field_valid);
		}
		//	image settings
		elseif ($p_field_slug == 'ecclevel')
		{
			$accepted_options = WPKQCG_Forms_QRCode::get_accepted_options($p_field_slug);
			$field_valid = (!empty($p_field_value) && is_string($p_field_value) && array_key_exists($p_field_value, $accepted_options)) ? $p_field_value : $p_field_value_default;	//	ecclevel is string and key
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'size')
		{
			$field_valid = (!empty($p_field_value) && is_numeric(intval($p_field_value))) ? intval($p_field_value) : $p_field_value_default;	//	size is numeric
			$field_valid = sanitize_key($field_valid);
		}
		elseif ($p_field_slug == 'border')
		{
			$accepted_options = WPKQCG_Forms_QRCode::get_accepted_options($p_field_slug);
			$field_valid = (!empty($p_field_value) && is_string($p_field_value) && array_key_exists($p_field_value, $accepted_options)) ? $p_field_value : $p_field_value_default;	//	border is string and key
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'color')
		{
			$field_valid = (!empty($p_field_value) && is_string($p_field_value)) ? $p_field_value : $p_field_value_default;	//	color is string
			$field_valid = str_replace('"', '', $field_valid);
			$field_valid = str_replace("'", "", $field_valid);
			$field_valid = ltrim($field_valid, '#');
			$field_valid = (ctype_xdigit($field_valid)) ? '#' . $field_valid : $p_field_value_default;
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'bgcolor')
		{
			$field_valid = (!empty($p_field_value) && is_string($p_field_value)) ? $p_field_value : $p_field_value_default;	//	bgcolor is string
			$field_valid = str_replace('"', '', $field_valid);
			$field_valid = str_replace("'", "", $field_valid);
			$field_valid = ltrim($field_valid, '#');
			$field_valid = (ctype_xdigit($field_valid)) ? '#' . $field_valid : $p_field_value_default;
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'align')
		{
			$accepted_options = WPKQCG_Forms_QRCode::get_accepted_options($p_field_slug);
			$field_valid = (!empty($p_field_value) && is_string($p_field_value) && array_key_exists($p_field_value, $accepted_options)) ? $p_field_value : $p_field_value_default;	//	align is string and key
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'css_shadow')
		{
			$field_valid = (!empty($p_field_value) && is_numeric($p_field_value)) ? $p_field_value : $p_field_value_default;	//	css_shadow is numeric
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'no_css')
		{
			$field_valid = (!empty($p_field_value) && is_numeric($p_field_value)) ? $p_field_value : $p_field_value_default;	//	no_css is numeric
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'alt')
		{
			$field_valid = (!empty($p_field_value) && is_string($p_field_value)) ? $p_field_value : $p_field_value_default;	//	alt is string
			$field_valid = sanitize_text_field($field_valid);
		}
		//	link settings
		elseif ($p_field_slug == 'url')
		{
			$field_valid = (!empty($p_field_value) && is_string($p_field_value)) ? $p_field_value : $p_field_value_default;	//	url is string
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'new_window')
		{
			$field_valid = (!empty($p_field_value) && is_numeric($p_field_value)) ? $p_field_value : $p_field_value_default;	//	new_window is numeric
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'content_url')
		{
			$field_valid = (!empty($p_field_value) && is_numeric($p_field_value)) ? $p_field_value : $p_field_value_default;	//	content_url is numeric
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'download_button')
		{
			$field_valid = (!empty($p_field_value) && is_numeric($p_field_value)) ? $p_field_value : $p_field_value_default;	//	download_button is numeric
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'download_text')
		{
			$field_valid = (!empty($p_field_value) && is_string($p_field_value)) ? $p_field_value : $p_field_value_default;	//	download_text is string
			$field_valid = sanitize_text_field($field_valid);
		}
		elseif ($p_field_slug == 'download_align')
		{
			$accepted_options = WPKQCG_Forms_QRCode::get_accepted_options($p_field_slug);
			$field_valid = (!empty($p_field_value) && is_string($p_field_value) && array_key_exists($p_field_value, $accepted_options)) ? $p_field_value : $p_field_value_default;	//	download_align is string and key
			$field_valid = sanitize_text_field($field_valid);
		}

		return $field_valid;
	}

	/**
	 * Sanitizes a string for qrcode content.
	 *
	 * @since 1.4.0
	 */
	public static function sanitize_qrCodeContent($str)
	{
		$filtered = WPKQCG_Forms_QRCode::_sanitize_qrCodeContents($str, false);

		return apply_filters('sanitize_text_field', $filtered, $str);
	}

	/**
	 * Sanitizes a string for qrcode content.
	 *
	 * @since 1.4.0
	 */
	public static function _sanitize_qrCodeContents($str, $keep_newlines = false)
	{
		if (is_object($str) || is_array($str))
		{
			return '';
		}

		$str = (string) $str;

		$filtered = wp_check_invalid_utf8($str);

		if (strpos($filtered, '<') !== false)
		{
			$filtered = wp_pre_kses_less_than($filtered);
			// This will strip extra whitespace for us.
			$filtered = wp_strip_all_tags($filtered, false);

			// Use HTML entities in a special case to make sure no later
			// newline stripping stage could lead to a functional tag.
			$filtered = str_replace("<\n", "&lt;\n", $filtered);
		}

		if (!$keep_newlines)
		{
			$filtered = preg_replace('/[\r\n\t ]+/', ' ', $filtered);
		}
		$filtered = trim($filtered, " \n\t");

		$found = false;
		while (preg_match('/[\x00-\x1F\x7F\xA0]/u', $filtered, $match))
		{
			$filtered = str_replace($match[0], '', $filtered);
			$found    = true;
		}

		if ($found)
		{
			// Strip out the whitespace that may now exist after removing the octets.
			$filtered = trim(preg_replace('/ +/', ' ', $filtered), " \n\t");
		}

		return $filtered;
	}
}
