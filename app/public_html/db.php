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
        <h1 class="mt-5">Message Board</h1>
    <?php
    
    // Create a new PDO instance
    $pdo = new PDO("pgsql:host=$db_host;port=$db_port;dbname=$db_name", $db_user, $db_pass);
    
    
    // Check if the truncate form was submitted
    if (isset($_POST['truncate'])) {
        try {
        // Truncate the table
        $pdo->exec('TRUNCATE TABLE messages');
        } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
        }
    }

    // Handle form submission to insert a new message
    if (isset($_POST['submit'])) {
      $message = $_POST['message'];
      $escapedInput = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
      
      // Insert the message into the database
      $stmt = $pdo->prepare("INSERT INTO messages (message) VALUES (?)");
      $stmt->execute([$escapedInput]);
      
      echo '<div class="alert alert-success">Message added successfully!</div>';
    }

    // Retrieve messages from the database
    $stmt = $pdo->query("SELECT pg_sleep(0.1)"); // with a small delay :-)
    $stmt = $pdo->query("SELECT * FROM messages ORDER BY id DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>
    
    <!-- Display messages -->
    <?php if (count($messages) > 0): ?>
    <table class="table table-dark table-striped">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Message</th>
            <th scope="col">Created At</th>
        </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php foreach ($messages as $message): ?>
            <tr>
            <th scope="row"><?php echo $message['id']; ?></th>
            <td><?php echo $message['message']; ?></td>
            <td><?php echo date('Y-m-d H:i:s', strtotime($message['created_at'])); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>No messages found.</p>
    <?php endif; ?>

    
    <hr>
    
<!-- Display form to insert a new message -->
    <form method="POST">
      <div class="form-group">
        <label for="message">New Message:</label>
        <input type="text" class="form-control" id="message" name="message" required>
      </div>
      <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>

<!-- Display form to truncate table -->
    <form method="POST">
        <button type="submit" class="btn btn-danger" name="truncate" onclick="return confirm('Are you sure you want to truncate the table? This action cannot be undone.');">Truncate Table</button>
    </form>

    </div>
</main>
<?php include 'partials/footer.php'; ?>

<!-- Load Bootstrap 5.2.3 JS from a local copy -->
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
