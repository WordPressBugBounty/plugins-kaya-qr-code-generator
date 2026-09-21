<?php

if (!defined('ABSPATH'))
{
    exit;
}

$gutenberg_data = WPKQCG_Forms_QRCode::get_gutenberg_fields();

$fields = array();

if (!empty($gutenberg_data['attributes']))
{
    foreach ($gutenberg_data['attributes'] as $slug => $attribute)
    {
        if (isset($attributes[$slug]))
        {
            $value = $attributes[$slug];
        }
        elseif (isset($attribute['default']))
        {
            $value = $attribute['default'];
        }
        else
        {
            continue;
        }

        /*
		 * Gutenberg uses boolean values for checkbox attributes,
		 * while the QR Code plugin expects 1 or 0.
		 */
        if (
            isset($attribute['type'])
            && $attribute['type'] === 'boolean'
        )
        {
            $value = $value ? 1 : 0;
        }

        $fields[$slug] = $value;
    }
}


/*
 * Process shortcodes contained in the QR Code content
 * when dynamic content is enabled.
 */
if (
    !empty($fields['dynamic_content'])
    && !empty($fields['content'])
)
{
    $fields['content'] = do_shortcode($fields['content']);
}


/*
 * Validate fields using the existing QR Code plugin logic.
 */
$fields_valid = WPKQCG_Forms_QRCode::validate_fields($fields);

?>
<div class="kaya-qrcode-block" data-js-displayed="false">
    <?php echo wpkqcg_doDisplayQRCode($fields_valid); ?>
</div>