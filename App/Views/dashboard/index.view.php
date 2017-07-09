<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to dashboard</title>
	<link rel="stylesheet" href="/resources/assets/bootstrap-lib/dist/css/bootstrap.min.css">
</head>
<body>
	<?php include 'components/navigation.view.php' ?>
	<div class="container-fluid">
		<!-- SIDE BAR -->
		<div class="col-md-3">
			<?php include 'components/sidebar.view.php' ?>
		</div>
		<!-- MAIN -->
		<div class="col-md-9">
			<?php include 'components/main_dash.view.php' ?>
		</div>
	</div>
	<script src="/resources/assets/js/jquery/jquery.min.js"></script>
	<script src="/resources/assets/js/app/dashboard-app.js"></script>
</body>
</html>