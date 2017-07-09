<div class="page-header">
	<h1>Модерация отзывов</h1>
</div>
<div class="col-md-12">
	<div class="row">
		<?php if (count($reviews)): ?>		
			<?php foreach ($reviews as $review): ?>
				<div class="col-md-12 review-item well">
					<div class="media">
						<div class="media-body">
							<h4 class="media-heading">
								<?php echo $review['name'] ?>
								<span class="small"><?php echo $review['email'] ?></span>
								<span class="small">#: <?php echo $review['id'] ?></span>
								<?php if ($review['status'] == 'moderate'): ?>
									<span class="pull-right label label-default">Модерируется</span>
								<?php elseif($review['status'] == 'accepted'): ?>
									<span class="pull-right label label-success">Принят</span>
								<?php elseif($review['status'] == 'declined'): ?>
									<span class="pull-right label label-danger">Отклонен</span>
								<?php endif ?>
							</h4>
							<p><?php echo $review['body'] ?></p>
							<p>Дата: <?php echo $review['created_at'] ?></p>
						</div>
					</div>
					<div class="form-group">
						<?php if ($review['status'] == 'moderate'): ?>
							<a href="/reviews/update/<?php echo $review['id'] ?>/accepted" class="btn btn-success">
								Принять
							</a>
							<a href="/reviews/update/<?php echo $review['id'] ?>/declined" class="btn btn-danger">
								Отклонить
							</a>
						<?php elseif ($review['status'] == 'accepted'): ?>
							<a href="/reviews/update/<?php echo $review['id'] ?>/declined" class="btn btn-danger">Отклонить</a>
						<?php elseif ($review['status'] == 'declined'): ?>
							<a href="/reviews/update/<?php echo $review['id'] ?>/accepted" class="btn btn-success">Принять</a>
						<?php endif ?>
					</div>
				</div>
			<?php endforeach ?>	
		<?php else: ?>
			<p class="text-center">Нет отзывов</p>
		<?php endif ?>
	</div>
</div>
