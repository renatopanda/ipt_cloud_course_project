<?php include '_dotenv.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>CNV - Project A</title>
    <!-- Load Bootstrap 5.2.3 CSS from a local copy -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/site.css">
</head>
<body class="d-flex flex-column">
<?php include 'partials/navbar.php'; ?>

<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
        <h1 class="mt-5">WebSockets Example</h1>

        <div class="container py-4">

        <div class="alert alert-warning alert-dismissible fade show" role="alert" id="statusDiv">
        Connecting to the WebSockets server...
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        
        <div class="alert alert-info" id="notificationDiv"></div>

        <form id="messageForm">
            <div class="mb-3 d-flex">
                <input type="text" id="messageInput" class="form-control me-2" placeholder="Enter a message">
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>

    <script>
        const messageForm = document.getElementById('messageForm');
        const messageInput = document.getElementById('messageInput');
        const statusDiv = document.getElementById('statusDiv');
        const notificationDiv = document.getElementById('notificationDiv');

        // Event listener for form submission
        messageForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const message = messageInput.value;
            sendMessage(message);
            messageInput.value = '';
        });
        const ws_uri = "<?php echo 'ws://'.$ws_host.':'.$ws_port; ?>"

        // Create a WebSocket connection
        const socket = new WebSocket(ws_uri);

        // WebSocket event handlers
        socket.onopen = function(event) {
            console.log('WebSocket connection established');
            // Display an error message to the user
            statusDiv.classList.remove('alert-warning');
            statusDiv.classList.add('alert-success');
            statusDiv.innerHTML = 'WebSocket connection established.' + statusDiv.querySelector('.btn-close').outerHTML;
        };

        socket.onmessage = function(event) {
            const notification = JSON.parse(event.data);
            // Handle the received notification
            console.log('Received notification:', notification);
            // Update the page content with the notification data
            const notificationDiv = document.getElementById('notificationDiv');
            const notificationMessage = document.createElement('div');

            // Create a formatted message string with timestamp and sender ID
            const messageString = `${notification.message} <small>(on ${notification.timestamp}, by Sender ID: ${notification.sender_id})</small><br>`;
            notificationMessage.innerHTML = messageString;

            // Add a class to differentiate sender and recipient messages
            if (notification.sender_id === socket.id) {
                notificationMessage.classList.add('sender-message');
            } else {
                notificationMessage.classList.add('recipient-message');
            }

            notificationDiv.appendChild(notificationMessage);
        };

        socket.onclose = function(event) {
                    console.log('WebSocket connection closed');
                    // Display an error message to the user
                    statusDiv.classList.remove('alert-warning');
                    statusDiv.classList.add('alert-danger');
                    statusDiv.innerHTML = 'WebSocket connection closed. Please try again later.' + statusDiv.querySelector('.btn-close').outerHTML;
                };

        // Send a message to the server
        function sendMessage(message) {
            if (socket.readyState === WebSocket.OPEN) {
                socket.send(JSON.stringify({ message: message }));
            } else {
                // Display an error message to the user
                const notificationDiv = document.getElementById('notificationDiv');
                notificationDiv.innerHTML = 'WebSocket connection is not available.';
            }
        }
    </script>
    </div>
</main>
<?php include 'partials/footer.php'; ?>

<!-- Load Bootstrap 5.2.3 JS from a local copy -->
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
