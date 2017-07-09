<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Auth page is here</title>
	<link rel="stylesheet" href="/resources/assets/bootstrap-lib/dist/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<h2 class="text-center">Auth Form</h2>
			<div class="well col-md-12">
				<form action="/auth" method="POST">
					<div class="form-group">
						<input type="text" name="login" class="form-control" placeholder="username">
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" placeholder="password">
					</div>
					<input type="submit" value="authorise" class="btn btn-default">
				</form>
			</div>
		</div>	
	</div>
</body>
</html>