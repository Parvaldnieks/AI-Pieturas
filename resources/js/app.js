import './bootstrap';

import Alpine from 'alpinejs';
import syncTracker from './syncTracker';

window.Alpine = Alpine;
Alpine.data('syncTracker', syncTracker);

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    const themeButtons = document.querySelectorAll('.theme-toggle');

    const darkTheme = localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);

    if (darkTheme) document.documentElement.classList.add('dark');

    function updateIcons() {
        themeButtons.forEach(btn => {
            const darkIcon = btn.querySelector('.theme-toggle-dark-icon');
            const lightIcon = btn.querySelector('.theme-toggle-light-icon');
            const isDark = document.documentElement.classList.contains('dark');

            darkIcon.classList.toggle('hidden', isDark);
            lightIcon.classList.toggle('hidden', !isDark);
        });
    }

    updateIcons();

    themeButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem(
                'theme',
                document.documentElement.classList.contains('dark') ? 'dark' : 'light'
            );
            updateIcons();
        });
    });
});
