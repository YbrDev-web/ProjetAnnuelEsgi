document.addEventListener('DOMContentLoaded', () => {
    let draggedCard = null;
  
    document.querySelectorAll('.card').forEach(card => {
      card.addEventListener('dragstart', () => {
        draggedCard = card;
        card.classList.add('dragging');
      });
  
      card.addEventListener('dragend', () => {
        card.classList.remove('dragging');
        draggedCard = null;
      });
    });
  
    document.querySelectorAll('.list').forEach(list => {
      list.addEventListener('dragover', e => {
        e.preventDefault();
        list.classList.add('drag-over');
      });
  
      list.addEventListener('dragleave', () => {
        list.classList.remove('drag-over');
      });
  
      list.addEventListener('drop', () => {
        list.classList.remove('drag-over');
  
        if (!draggedCard) return;
  
        const isTerminal = list.dataset.terminal === "1";
        const listName = list.querySelector('h3')?.innerText.toLowerCase();
  
        if (isTerminal) {
          alert("❌ Impossible de déplacer vers une colonne terminale.");
          return;
        }
  
        if (listName.includes("annulé") || listName.includes("fait")) {
          const confirmMove = confirm(`⚠️ Voulez-vous vraiment déplacer cette tâche vers « ${listName} » ?`);
          if (!confirmMove) return;
        }
  
        // Déplace dans le DOM
        list.appendChild(draggedCard);
  
        // 🔁 Sauvegarde côté serveur (AJAX)
        const cardId = draggedCard.dataset.cardId;
        const listId = list.dataset.listId;
  
        fetch(`/cards/${cardId}/move`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ list_id: listId })
        }).then(res => res.json()).then(data => {
          console.log("✅ Tâche déplacée :", data);
        }).catch(err => {
          alert("Erreur serveur");
          console.error(err);
        });
      });
    });
  });
  