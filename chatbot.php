<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpdesk Ticketing System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .chatbox {
            margin-bottom: 20px;
        }
        .chatbox div {
            margin: 10px 0;
            padding: 10px;
            border-radius: 4px;
        }
        .chatbox .user {
            background-color: #e1ffc7;
            text-align: right;
        }
        .chatbox .bot {
            background-color: #f1f0f0;
        }
        form {
            display: flex;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            border: none;
            background-color: #28a745;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Helpdesk Ticketing System</h1>
        <p>Welcome to the helpdesk! How can we help you today?</p>
        <div class="chatbox" id="chatbox">
        </div>
        <form id="chatForm">
            <input type="text" id="prompt" name="prompt" placeholder="Type your message..." required>
            <button type="submit">Send</button>
        </form>
    </div>

    <script>
        document.getElementById('chatForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const prompt = document.getElementById('prompt').value;
            displayMessage(prompt, 'user');
            document.getElementById('prompt').value = '';

            const response = await fetch('http://localhost:5000/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ prompt })
            });
            const data = await response.json();
            displayMessage(data.response, 'bot');
        });

        function displayMessage(message, userType) {
            const chatbox = document.getElementById('chatbox');
            const messageDiv = document.createElement('div');
            messageDiv.className = userType;
            messageDiv.textContent = message;
            chatbox.appendChild(messageDiv);
            chatbox.scrollTop = chatbox.scrollHeight;
        }
    </script>
</body>
</html>
