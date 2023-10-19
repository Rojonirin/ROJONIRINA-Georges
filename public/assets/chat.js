// public/js/chat.js
const messageForm = document.getElementById('message-form');
const messageInput = document.getElementById('message-input');
const messageList = document.getElementById('message-list');

messageForm.addEventListener('submit', (event) => {
    event.preventDefault();

    // Récupérez le message saisi par l'utilisateur
    const messageContent = messageInput.value.trim();

    // Envoyez le message au serveur WebSocket (à implémenter)

    // Ajoutez le message à la liste des messages
    if (messageContent) {
        const messageItem = document.createElement('li');
        messageItem.textContent = messageContent;
        messageList.appendChild(messageItem);

        // Effacez le champ de saisie
        messageInput.value = '';
    }
});
