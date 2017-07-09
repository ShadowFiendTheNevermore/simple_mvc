<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<a href="<?php echo $_SERVER['REQUEST_URI'] ?>" class="navbar-brand">
				<?php echo $_SESSION['user']['login'] ?>
				<span class="glyphicon glyphicon-user"></span>
			</a>
		</div>
		<div class="collapse navbar-collapse pull-right">
			<ul class="nav navbar-nav">
				<li><a href="/logout">Logout</a></li>
			</ul>
		</div>
	</div>
</nav>