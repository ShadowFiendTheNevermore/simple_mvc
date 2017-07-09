<?php foreach($reviews_allowed as $review):?>
	<div class="review media">
		<div class="media-body">
			<h4 class="media-heading">
				<?php echo $review['name'] ?>
				<span class="small"><?php echo $review['email'] ?></span>	
			</h4>
			<p><?php echo $review['body'] ?></p>
			<p>Дата: <?php echo $review['created_at'] ?></p>
		</div>
	</div>
<?php endforeach;?>
<?php if (!count($reviews_allowed)): ?>
	<p class="text-center">Нет отзывов</p>
<?php endif ?>