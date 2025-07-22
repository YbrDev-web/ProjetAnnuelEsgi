// Système de gestion des thèmes
class ThemeManager {
    constructor() {
        this.currentTheme = this.getStoredTheme() || 'auto';
        this.init();
    }

    init() {
        // Appliquer le thème initial
        this.applyTheme(this.currentTheme);
        
        // Créer le bouton de basculement
        this.createToggleButton();
        
        // Écouter les changements de préférence système
        this.watchSystemPreference();
    }

    getStoredTheme() {
        return localStorage.getItem('theme');
    }

    setStoredTheme(theme) {
        localStorage.setItem('theme', theme);
    }

    getSystemTheme() {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    applyTheme(theme) {
        // Ajouter classe de transition
        document.documentElement.classList.add('theme-transition');
        
        // Supprimer les attributs de thème existants
        document.documentElement.removeAttribute('data-theme');
        
        if (theme === 'auto') {
            // Laisser le CSS media query gérer le thème
            this.currentTheme = 'auto';
        } else {
            // Appliquer le thème spécifique
            document.documentElement.setAttribute('data-theme', theme);
            this.currentTheme = theme;
        }
        
        // Mettre à jour l'icône
        this.updateToggleIcon();
        
        // Sauvegarder le choix
        this.setStoredTheme(this.currentTheme);
        
        // Retirer la classe de transition après l'animation
        setTimeout(() => {
            document.documentElement.classList.remove('theme-transition');
        }, 300);
    }

    toggleTheme() {
        const themes = ['light', 'dark', 'auto'];
        const currentIndex = themes.indexOf(this.currentTheme);
        const nextIndex = (currentIndex + 1) % themes.length;
        const nextTheme = themes[nextIndex];
        
        this.applyTheme(nextTheme);
        
        // Afficher une notification
        this.showNotification(nextTheme);
    }

    createToggleButton() {
        // Vérifier si le bouton existe déjà
        if (document.getElementById('theme-toggle')) return;
        
        const button = document.createElement('button');
        button.id = 'theme-toggle';
        button.className = 'theme-toggle';
        button.setAttribute('aria-label', 'Changer le thème');
        button.innerHTML = this.getIconForTheme(this.currentTheme);
        
        button.addEventListener('click', () => this.toggleTheme());
        
        document.body.appendChild(button);
    }

    updateToggleIcon() {
        const button = document.getElementById('theme-toggle');
        if (button) {
            button.innerHTML = this.getIconForTheme(this.currentTheme);
        }
    }

    getIconForTheme(theme) {
        const icons = {
            light: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.591a.75.75 0 101.06 1.06l1.591-1.591zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.844a.75.75 0 001.06-1.06l-1.591-1.591a.75.75 0 10-1.06 1.06l1.591 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.591a.75.75 0 001.06 1.06l1.591-1.591zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06L6.166 5.106a.75.75 0 00-1.06 1.06l1.591 1.591z"/>
            </svg>`,
            dark: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z"/>
            </svg>`,
            auto: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0z"/>
                <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z" opacity="0.5"/>
            </svg>`
        };
        
        return icons[theme] || icons.auto;
    }

    showNotification(theme) {
        // Supprimer la notification existante s'il y en a une
        const existingNotif = document.querySelector('.theme-notification');
        if (existingNotif) existingNotif.remove();
        
        const notification = document.createElement('div');
        notification.className = 'theme-notification';
        notification.style.cssText = `
            position: fixed;
            bottom: 80px;
            right: 20px;
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: var(--shadow-lg);
            z-index: 1001;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
        `;
        
        const messages = {
            light: '☀️ Thème clair activé',
            dark: '🌙 Thème sombre activé',
            auto: '🔄 Thème automatique activé'
        };
        
        notification.textContent = messages[theme];
        document.body.appendChild(notification);
        
        // Animation d'entrée
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 10);
        
        // Suppression après 2 secondes
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(10px)';
            setTimeout(() => notification.remove(), 300);
        }, 2000);
    }

    watchSystemPreference() {
        // Écouter les changements de préférence système
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (this.currentTheme === 'auto') {
                // Forcer la mise à jour visuelle
                this.applyTheme('auto');
            }
        });
    }
}

// Initialiser le gestionnaire de thème au chargement
document.addEventListener('DOMContentLoaded', () => {
    window.themeManager = new ThemeManager();
});

// Si le DOM est déjà chargé
if (document.readyState === 'complete' || document.readyState === 'interactive') {
    window.themeManager = new ThemeManager();
}