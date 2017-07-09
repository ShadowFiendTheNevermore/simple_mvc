<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register form</title>
	<link rel="stylesheet" href="/resources/assets/bootstrap-lib/dist/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<h2 class="text-center">Регистрация</h2>
			<?php if (isset($errors)): ?>
				<div class="col-md-12 alert alert-danger">
				
					<?php foreach ($errors as $error): ?>
						<p><?php echo $error ?></p>
					<?php endforeach ?>
				
				</div>
			<?php endif ?>
			<div class="well col-md-12">
				<form action="/register" method="POST">
					<div class="form-group">
						<input type="text" name="login" class="form-control" placeholder="login">
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" placeholder="password">
					</div>
					<input type="submit" value="Зарегистрироваться" class="btn btn-default">
				</form>
			</div>
		</div>	
	</div>
</body>
</html>

