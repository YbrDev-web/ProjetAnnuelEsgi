// Ouvre le modal de création de tableau
function openModal() {
    const modal = document.getElementById('boardModal');
    if (modal) {
        modal.style.display = 'flex';
    }
}

// Ferme le modal
function closeModal() {
    const modal = document.getElementById('boardModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Ferme le modal si on clique en dehors
window.onclick = function (event) {
    const modal = document.getElementById('boardModal');
    if (event.target === modal) {
        closeModal();
    }
}

// Affiche / cache la sidebar
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        sidebar.classList.toggle('hidden');
    }
}
