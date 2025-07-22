<div class="theme-preferences-panel">
    <h4>Préférences d'apparence</h4>
    
    <div class="theme-options">
        <label class="theme-option">
            <input type="radio" name="theme" value="light" {{ $currentTheme === 'light' ? 'checked' : '' }}>
            <div class="theme-preview theme-light">
                <span class="icon">☀️</span>
                <span class="label">Clair</span>
            </div>
        </label>
        
        <label class="theme-option">
            <input type="radio" name="theme" value="dark" {{ $currentTheme === 'dark' ? 'checked' : '' }}>
            <div class="theme-preview theme-dark">
                <span class="icon">🌙</span>
                <span class="label">Sombre</span>
            </div>
        </label>
        
        <label class="theme-option">
            <input type="radio" name="theme" value="auto" {{ $currentTheme === 'auto' ? 'checked' : '' }}>
            <div class="theme-preview theme-auto">
                <span class="icon">🔄</span>
                <span class="label">Automatique</span>
            </div>
        </label>
    </div>
    
    <div class="theme-customization">
        <h5>Options avancées</h5>
        
        <label class="switch">
            <input type="checkbox" id="reduceMotion">
            <span class="slider"></span>
            <span class="label">Réduire les animations</span>
        </label>
        
        <label class="switch">
            <input type="checkbox" id="highContrast">
            <span class="slider"></span>
            <span class="label">Contraste élevé</span>
        </label>
    </div>
</div>

<style>
.theme-preferences-panel {
    background: var(--bg-card);
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
}

.theme-options {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin: 20px 0;
}

.theme-option {
    cursor: pointer;
}

.theme-option input {
    display: none;
}

.theme-preview {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    border: 2px solid var(--border-primary);
    border-radius: 8px;
    transition: all 0.3s;
}

.theme-option input:checked + .theme-preview {
    border-color: var(--accent-primary);
    background: var(--bg-tertiary);
}

.theme-preview .icon {
    font-size: 2em;
    margin-bottom: 10px;
}

.theme-preview .label {
    font-weight: 500;
}

.theme-customization {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid var(--border-primary);
}

.switch {
    display: flex;
    align-items: center;
    margin: 15px 0;
    cursor: pointer;
}

.switch input {
    display: none;
}

.slider {
    position: relative;
    width: 50px;
    height: 25px;
    background: var(--bg-tertiary);
    border-radius: 25px;
    margin-right: 15px;
    transition: 0.3s;
}

.slider::before {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    left: 3px;
    top: 2.5px;
    background: white;
    border-radius: 50%;
    transition: 0.3s;
}

.switch input:checked + .slider {
    background: var(--accent-primary);
}

.switch input:checked + .slider::before {
    transform: translateX(25px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des changements de thème
    document.querySelectorAll('input[name="theme"]').forEach(input => {
        input.addEventListener('change', function() {
            if (window.themeManager) {
                window.themeManager.applyTheme(this.value);
            }
        });
    });
    
    // Réduire les animations
    document.getElementById('reduceMotion').addEventListener('change', function() {
        if (this.checked) {
            document.documentElement.style.setProperty('--transition-duration', '0ms');
            localStorage.setItem('reduceMotion', 'true');
        } else {
            document.documentElement.style.removeProperty('--transition-duration');
            localStorage.removeItem('reduceMotion');
        }
    });
    
    // Contraste élevé
    document.getElementById('highContrast').addEventListener('change', function() {
        if (this.checked) {
            document.documentElement.classList.add('high-contrast');
            localStorage.setItem('highContrast', 'true');
        } else {
            document.documentElement.classList.remove('high-contrast');
            localStorage.removeItem('highContrast');
        }
    });
    
    // Restaurer les préférences
    if (localStorage.getItem('reduceMotion') === 'true') {
        document.getElementById('reduceMotion').checked = true;
        document.documentElement.style.setProperty('--transition-duration', '0ms');
    }
    
    if (localStorage.getItem('highContrast') === 'true') {
        document.getElementById('highContrast').checked = true;
        document.documentElement.classList.add('high-contrast');
    }
});
</script>