<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<div style="font-family: 'Inter', sans-serif;">
    <button id="chat-toggle" style="
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 50%;
        width: 64px;
        height: 64px;
        font-size: 26px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 9999;
        transition: background-color 0.3s ease;
    " onmouseover="this.style.backgroundColor='#0056b3'" onmouseout="this.style.backgroundColor='#007bff'">
        💬
    </button>

    <div id="chat-container" style="
        position: fixed;
        bottom: 100px;
        right: 20px;
        width: 320px;
        max-height: 450px;
        background: #ffffff;
        border: 1px solid #ccc;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        display: none;
        flex-direction: column;
        z-index: 9999;
        overflow: hidden;
    ">
        <div style="
            padding: 14px 16px;
            background-color: #007bff;
            color: white;
            font-weight: 600;
            font-size: 16px;
        ">
            🤖 Chatbot Assistant
        </div>

        <div id="chat-box" style="
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            height: 280px;
            background-color: #f9f9f9;
            font-size: 14px;
        "></div>

        <form id="chat-form" style="
            display: flex;
            border-top: 1px solid #ddd;
            background-color: white;
        " method="POST" action="{{ route('ChatBotSend') }}">
            @csrf
            <input type="text" name="message" id="message" placeholder="Type a message..." autocomplete="off" style="
                    flex: 1;
                    border: none;
                    padding: 14px;
                    font-size: 14px;
                    outline: none;
                    font-family: 'Inter', sans-serif;
                " />
            <button type="submit" style="
                    background-color: #007bff;
                    color: white;
                    border: none;
                    padding: 0 18px;
                    cursor: pointer;
                    transition: background-color 0.3s ease;
                " onmouseover="this.style.backgroundColor='#0056b3'" onmouseout="this.style.backgroundColor='#007bff'">
                Send
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('chat-toggle');
        const chatContainer = document.getElementById('chat-container');
        const form = document.getElementById('chat-form');
        const chatBox = document.getElementById('chat-box');
        const messageInput = document.getElementById('message');

        toggleBtn.addEventListener('click', () => {
            chatContainer.style.display = chatContainer.style.display === 'flex' ? 'none' : 'flex';
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const message = messageInput.value.trim();
            if (!message) return;

            chatBox.innerHTML += `<div style="text-align:right; color:blue;"><strong>You:</strong> ${message}</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
            messageInput.value = '';

            const csrfToken = document.querySelector('input[name="_token"]').value;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ message })
            })
                .then(async response => {
                    if (!response.ok) {
                        const text = await response.text();
                        throw new Error(text);
                    }
                    return response.json();
                })
                .then(data => {
                    chatBox.innerHTML += `<div style="text-align:left; color:green;"><strong>Bot:</strong> ${data.response}</div>`;
                    chatBox.scrollTop = chatBox.scrollHeight;
                })
                .catch(error => {
                    console.error("Chatbot error:", error);
                    chatBox.innerHTML += `<div style="color:red;">❌ Error: Could not reach the chatbot</div>`;
                });
        });
    });


</script>