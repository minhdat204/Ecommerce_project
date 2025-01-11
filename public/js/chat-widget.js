// Toggle chat visibility
function toggleChat() {
    const chatPopup = document.getElementById('chatPopup');
    chatPopup.style.display = chatPopup.style.display === 'none' ? 'block' : 'none';

    if (chatPopup.style.display === 'block') {
        document.querySelector('.chat-messages').scrollTop = document.querySelector('.chat-messages').scrollHeight;
    }
}
//send click
function sendMessage(event) {
    event.preventDefault();

    const input = document.getElementById('messageInput');
    const message = input.value.trim();

    fetch('/fire/message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ message: message })
    })
    .then(response => response.json())
    .then(data => {
        const chatMessages = document.querySelector('.chat-messages');
        const messageHtml = `
            <div class="message ${data.message.user.loai_nguoidung === 'admin' ? 'admin' : 'customer'}">
                <img src="${data.message.user.avatar}" alt="${data.message.user.hoten}" class="message-avatar">
                <div class="message-content">
                    <div class="message-bubble">
                        ${data.message.noidung}
                    </div>
                    <div class="message-info">
                        ${data.message.user.hoten} • ${data.message.thoigian}
                    </div>
                </div>
            </div>
        `;
        chatMessages.insertAdjacentHTML('beforeend', messageHtml);
        // Auto scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;
        // Clear input
        input.value = '';
    })
    .catch(error => console.error(error));






    // if (message) {
    //     const chatMessages = document.querySelector('.chat-messages');
    //     const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    //     // Add customer message
    //     const customerMessage = `
    //         <div class="message customer">
    //             <img src="https://via.placeholder.com/32" alt="Customer" class="message-avatar">
    //             <div class="message-content">
    //                 <div class="message-bubble">
    //                     ${message}
    //                 </div>
    //                 <div class="message-info">
    //                     Bạn • ${currentTime}
    //                 </div>
    //             </div>
    //         </div>
    //     `;

    //     chatMessages.insertAdjacentHTML('beforeend', customerMessage);

    //     // Auto scroll to bottom
    //     chatMessages.scrollTop = chatMessages.scrollHeight;

    //     // Clear input
    //     input.value = '';

    //     // Simulate admin response after 1 second
    //     setTimeout(() => {
    //         const adminMessage = `
    //             <div class="message admin">
    //                 <img src="https://via.placeholder.com/32" alt="Admin" class="message-avatar">
    //                 <div class="message-content">
    //                     <div class="message-bubble">
    //                         Cảm ơn bạn đã nhắn tin. Chúng tôi sẽ phản hồi sớm nhất có thể!
    //                     </div>
    //                     <div class="message-info">
    //                         Admin • ${currentTime}
    //                     </div>
    //                 </div>
    //             </div>
    //         `;

    //         chatMessages.insertAdjacentHTML('beforeend', adminMessage);
    //         chatMessages.scrollTop = chatMessages.scrollHeight;
    //     }, 1000);
    // }
}
