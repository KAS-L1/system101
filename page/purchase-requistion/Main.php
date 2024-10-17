<?php
require("../../app/init.php"); // Load your initialization file

$username = $_SESSION['username']; // Get the logged-in user's username
$showChatBox = isset($_GET['user']); // Check if a user is selected for chat
$selectedUser = $showChatBox ? $_GET['user'] : ''; // Get the selected user
?>

<div class="container mt-4 py-5">
    <div class="header">
        <h1>My Account</h1>
        <a href="logout.php" class="logout btn btn-danger">Logout</a>
    </div>
    <div class="account-info">
        <div class="welcome">
            <h2>Welcome, <?php echo ucfirst($username); ?>!</h2>
        </div>
        <div class="user-list">
            <h2>Select a User to Chat With:</h2>
            <ul class="list-group">
                <?php
                // Fetch all users except the current user
                $users = $DB->SELECT_WHERE("users", "username", "username != '$username'");
                foreach ($users as $user) {
                    echo "<li class='list-group-item'><a href='chat.php?user=" . ucfirst($user['username']) . "'>" . ucfirst($user['username']) . "</a></li>";
                }
                ?>
            </ul>
        </div>
    </div>

    <?php if ($showChatBox): ?>
        <div class="chat-box border shadow-sm mt-4" id="chat-box">
            <div class="chat-box-header d-flex justify-content-between align-items-center bg-light p-3">
                <h2><?php echo ucfirst($selectedUser); ?></h2>
                <button class="btn btn-close" onclick="closeChat()"></button>
            </div>
            <div class="chat-box-body" id="chat-box-body" style="height: 300px; overflow-y: auto;">
                <!-- Chat messages will be loaded here -->
            </div>
            <form class="chat-form" id="chat-form">
                <input type="hidden" id="sender" value="<?php echo $username; ?>">
                <input type="hidden" id="receiver" value="<?php echo $selectedUser; ?>">
                <div class="input-group mb-3">
                    <input type="text" id="message" class="form-control" placeholder="Type your message..." required>
                    <button class="btn btn-success" type="submit">Send</button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<script>
    function closeChat() {
        document.getElementById("chat-box").style.display = "none";
    }

    function fetchMessages() {
        var sender = $('#sender').val();
        var receiver = $('#receiver').val();

        $.ajax({
            url: 'fetch_messages.php',
            type: 'POST',
            data: {
                sender: sender,
                receiver: receiver
            },
            success: function(data) {
                $('#chat-box-body').html(data);
                scrollChatToBottom();
            }
        });
    }

    function scrollChatToBottom() {
        var chatBox = $('#chat-box-body');
        chatBox.scrollTop(chatBox.prop("scrollHeight"));
    }

    $(document).ready(function() {
        // Fetch messages every 3 seconds
        fetchMessages();
        setInterval(fetchMessages, 3000);
    });

    $('#chat-form').submit(function(e) {
        e.preventDefault();
        var sender = $('#sender').val();
        var receiver = $('#receiver').val();
        var message = $('#message').val();

        $.ajax({
            url: 'submit_message.php',
            type: 'POST',
            data: {
                sender: sender,
                receiver: receiver,
                message: message
            },
            success: function() {
                $('#message').val('');
                fetchMessages(); // Fetch messages after submitting
            }
        });
    });
</script>