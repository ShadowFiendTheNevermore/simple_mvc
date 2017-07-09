<nav class="navbar navbar-default">
	<div class="container">
		<?php if (isset($_SESSION['user'])): ?>
			<div class="navbar-header">
				<a href="/" class="navbar-brand">
					<?php echo $_SESSION['user']['login'] ?>
					<span class="glyphicon glyphicon-user"></span>
				</a>
			</div>
		<?php endif ?>
		<div class="collapse navbar-collapse pull-right">
			<ul class="nav navbar-nav">
				<?php if (isset($_SESSION['user']) && $_SESSION['user']): ?>
					<li><a href="/logout">Logout</a></li>
					<?php if ($_SESSION['user']['type'] == 'admin'): ?>
						<li><a href="/admin-dashboard">dashboard</a></li>
					<?php endif ?>
				<?php else: ?>
					<li><a href="/login"> Login</a></li>
					<li><a href="/register">Sign Up</a></li>
				<?php endif ?>
			</ul>
		</div>
	</div>
</nav>