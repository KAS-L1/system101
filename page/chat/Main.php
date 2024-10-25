<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messaging App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>

    <div class="container mt-5">
        <h2>Messaging App</h2>

        <div id="messages" class="mb-3"></div>

        <form id="messageForm">
            <input type="hidden" id="receiver_id" value="2"> <!-- Example receiver ID -->
            <div class="form-group">
                <textarea class="form-control" id="message" rows="3" placeholder="Type your message..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Fetch messages on load
            fetchMessages();

            // Send message
            $('#messageForm').on('submit', function(e) {
                e.preventDefault();
                const message = $('#message').val();
                const receiver_id = $('#receiver_id').val();

                $.post('/api/chat/send_message.php', {
                    message: message,
                    receiver_id: receiver_id
                }, function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        $('#message').val(''); // Clear the input
                        fetchMessages(); // Refresh messages
                    } else {
                        alert(res.message);
                    }
                });
            });

            // Function to fetch messages
            function fetchMessages() {
                const receiver_id = $('#receiver_id').val();
                $.get('/api/chat/fetch_messages.php', {
                    receiver_id: receiver_id
                }, function(response) {
                    const messages = JSON.parse(response);
                    let messagesHtml = '';
                    messages.forEach(function(msg) {
                        messagesHtml += `<div class="message"><strong>${msg.sender_id}:</strong> ${msg.message} <small>${msg.created_at}</small></div>`;
                    });
                    $('#messages').html(messagesHtml);
                });
            }
        });
    </script>

</body>

</html>