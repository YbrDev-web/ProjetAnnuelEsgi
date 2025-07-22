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

function openRoleModal(boardId, userId, currentRole) {
    const modal = document.getElementById('roleModal');
    const form = document.getElementById('roleForm');
    const select = document.getElementById('roleSelect');

    select.value = currentRole;
    form.action = `/boards/${boardId}/members/${userId}`;
    modal.style.display = 'flex';
  }

  function closeRoleModal() {
    document.getElementById('roleModal').style.display = 'none';
  }

  window.onclick = function (event) {
    const modal = document.getElementById('roleModal');
    if (event.target === modal) {
      closeRoleModal();
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const boardWrappers = document.querySelectorAll('.board-card-wrapper');
  
    searchInput.addEventListener('input', () => {
      const searchTerm = searchInput.value.toLowerCase();
  
      boardWrappers.forEach(wrapper => {
        const boardName = wrapper.querySelector('strong').textContent.toLowerCase();
        const boardDesc = wrapper.querySelector('.board-badge')?.textContent.toLowerCase() || '';
  
        if (boardName.includes(searchTerm) || boardDesc.includes(searchTerm)) {
          wrapper.style.display = 'block';
        } else {
          wrapper.style.display = 'none';
        }
      });
    });
  });
  





