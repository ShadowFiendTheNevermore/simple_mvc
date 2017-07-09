<form action="/" enctype="multipart/form-data" method="POST" id="back-form">
	<div class="form-group">
		<div class="row">
			<div class="col-xs-6">
				<label>Name:</label>
				<input class="form-control" type="text" name="name"  placeholder="Имя:" data-form-keep="name">
			</div>
			<div class="col-xs-6">
				<label>Email</label>
				<input class="form-control" type="email" name="email" placeholder="Email:" data-form-keep="email">
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="message">Message:</label>
		<textarea class="form-control" name="message" cols="30" rows="10" data-form-keep="message"></textarea>
	</div>
	<div class="form-group">
		<input name="review-file" type="file" data-preview-file-type="text" data-form-keep="file">
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-xs-12 col-md-3">
				<button class="btn btn-default btn-block" data-action="submit">Отправить</button>
			</div>
			<div class="col-xs-12 col-md-3">
				<button class="btn btn-default btn-block" data-action="check">Предварительный просмотр</button>
			</div>
		</div>
	</div>
</form>
