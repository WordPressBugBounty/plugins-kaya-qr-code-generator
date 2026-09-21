document.addEventListener('DOMContentLoaded', function ()
{
    const tabs = document.querySelectorAll('.ks-wp-dashboard-page-tab');
    const panels = document.querySelectorAll('.ks-wp-dashboard-page-tab-panel');

    if (!tabs.length || !panels.length)
    {
        return;
    }

    function activateTab(tabName)
    {
        tabs.forEach(function (tab)
        {
            const isActive = tab.getAttribute('data-tab') === tabName;

            tab.classList.toggle('is-active', isActive);
            tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });

        panels.forEach(function (panel)
        {
            const isActive = panel.id === 'wpkqcg-panel-' + tabName;

            panel.classList.toggle('is-active', isActive);
            panel.hidden = !isActive;
        });
    }

    const initialTab = window.location.hash
        ? window.location.hash.replace('#', '')
        : 'overview';

    const validTab = ['overview', 'generator', 'settings'].includes(initialTab)
        ? initialTab
        : 'overview';

    activateTab(validTab);

    tabs.forEach(function (tab)
    {
        tab.addEventListener('click', function ()
        {
            const tabName = tab.getAttribute('data-tab');

            activateTab(tabName);

            if (window.history && window.history.replaceState)
            {
                window.history.replaceState(null, '', '#' + tabName);
            }
            else
            {
                window.location.hash = tabName;
            }
        });
    });
});
