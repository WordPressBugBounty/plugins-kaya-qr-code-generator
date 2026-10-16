/**
 * Run the generator on front.
 *
 * @since 1.5.0
 */
var wp_kqrcg_js_displayed = false;

// Sécurité pour éviter les déclenchements multiples trop rapprochés
var wp_kqrcg_timeout = null;
function wp_kqrcg_trigger_display()
{
    if (wp_kqrcg_timeout) clearTimeout(wp_kqrcg_timeout);
    wp_kqrcg_timeout = setTimeout(function ()
    {
        wpkqcg_qrcode_display();
    }, 50); // Petit délai de 50ms pour laisser le DOM se stabiliser
}

// 1. Essai au chargement initial du DOM
try
{
    window.addEventListener("DOMContentLoaded", (event) =>
    {
        wp_kqrcg_trigger_display();
        wp_kqrcg_js_displayed = true;
    });
}
catch (err)
{
    jQuery(document).ready(function ()
    {
        if (!wp_kqrcg_js_displayed)
        {
            wp_kqrcg_trigger_display();
        }
    });
}

// 2. Gestion des requêtes AJAX classiques (jQuery)
jQuery(document).ready(function ($)
{
    $(document).ajaxSuccess(function ()
    {
        wp_kqrcg_trigger_display();
    });
});

// 3. Solution générale : MutationObserver pour le contenu asynchrone (Ninja Forms, Fetch, etc.)
if (window.MutationObserver)
{
    var wp_kqrcg_observer = new MutationObserver(function (mutations, observer)
    {
        // On cherche un QR Code qui n'a PAS l'attribut data-rendered="true"
        var unrenderedQrCode = document.querySelector('.wpkqcg_qrcode:not([data-rendered="true"])');

        if (unrenderedQrCode)
        {
            wp_kqrcg_trigger_display();
            wp_kqrcg_js_displayed = true;
        }
    });

    // Lance la surveillance de toute la page
    wp_kqrcg_observer.observe(document.body, {
        childList: true,
        subtree: true
    });
}
