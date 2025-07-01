document.addEventListener('DOMContentLoaded', () => {
    const body = document.getElementById('body');
    const toggle = document.getElementById('darkModeToggle');

    // Appliquer le mode si déjà activé
    if (localStorage.getItem('dark-mode') === 'enabled') {
        body.classList.add('dark');
    }

    // Toggle au clic
    toggle.addEventListener('click', () => {
        body.classList.toggle('dark');
        if (body.classList.contains('dark')) {
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            localStorage.setItem('dark-mode', 'disabled');
        }
    });
});
