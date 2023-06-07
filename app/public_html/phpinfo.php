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
        <h1 class="mt-5">PHP Info</h1>

		<div id="phpinfoContainer">
			<?php
			// Output the PHP info
			ob_start();
			phpinfo();
			$phpinfo = ob_get_clean();
			echo $phpinfo;
			?>
		</div>
    </div>
</main>
<?php include 'partials/footer.php'; ?>

<!-- Load Bootstrap 5.2.3 JS from a local copy -->
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
