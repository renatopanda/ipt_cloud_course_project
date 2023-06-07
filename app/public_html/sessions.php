<?php include '_dotenv.php'; ?>

<?php
session_set_cookie_params(86400); // Set the session cookie's lifetime to 24 hours (in seconds)
session_start();

// Check if the destroy session button is clicked
if (isset($_POST['destroy'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Check if the name is submitted and save it to the session
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $escapedInput = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $_SESSION['name'] = $escapedInput;
}

// Check if the session name is set
if (isset($_SESSION['name'])) {
    $savedName = $_SESSION['name'];
    $welcomeMessage = "Hello <b>$savedName</b>, welcome back!";
} else {
    $welcomeMessage = "Welcome! Please enter your name.";
}

?>

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
        <h1 class="mt-5">Session Example</h1>
        <p class="lead"><?php echo $welcomeMessage; ?></p>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary" name="save">Save to Session</button>
        </form>
        <form method="POST">
            <button type="submit" class="btn btn-danger" name="destroy">Destroy Session</button>
        </form>
    </div>
</main>
<?php include 'partials/footer.php'; ?>
<!-- Load Bootstrap 5.2.3 JS from a local copy -->
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
