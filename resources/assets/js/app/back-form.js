$(function () {
	// Initialize fileinput plugin
	$('#back-form input[type="file"]').fileinput({
		showCaption: true,
		showUpload: false,
		showPreview: true,

		allowedFileTypes: ['image'],
		allowedPreviewTypes: ['image'],
		previewSettings: {
			html: {width: "auto", height: "200px"}
		},
		fileActionSettings: {
			showZoom: false,
			showUpload: false
		}
	});


	// Handle form submit
	$('#back-form').on('submit', function (event) {
		// var formData = new FormData($(this)[0]);
		// console.log(formData);
		event.preventDefault();
	});


	// Set event handlers for form button
	$('#back-form button').on('click', function () {
		var handler = $(this).attr('data-action');
		switch (handler){
			case 'submit':
				var form = $('#back-form');

				var actionUrl = form.attr('action');

				var formData = new FormData(form[0]);
				$.ajax({
					url: actionUrl,
					method: form.attr('method'),
					data: formData,
					cache: false,
					success: function(data){
						form.children('.alert').remove();
						console.log(data);
					},
					error: function(data) {
						console.log(data);
						form.children('.alert').remove();
						var errors = JSON.parse(data.responseText);
						
						errors.forEach(function(error, index){
							addErrorElementToForm(form, error);
						});
					},
					contentType: false,
					processData: false
				});
				return false;
			break;
			case 'check':
				check();
			break;
		}
	});

});


function addErrorElementToForm(form, error){
	var errorElement = '<div class="alert alert-danger">'+
		'<p>'+error+'<p>'+
		'</div>';

	form.prepend(errorElement);
}


function check() {
	
	var inputs = $('#back-form [data-form-keep]').toArray();

	var dataObj = make_assoc_obj(inputs);

	if ($('#reviews .preview-item').length == 0) {
		createNewReviewItem(dataObj);
	} else {
		changePreviewItem(dataObj);
	}
	
}

function createNewReviewItem(data){
	var newReview = document.createElement('div');

	// console.log($('#back-form input[type="file"]').fileinput());
	$(newReview).append('<div class="media-body">'+
		'<span class="label label-info">preview:</span>'+
		'<h4 class="media-heading">'+
			'<span>'+data.name+'</span>'+
			' <span class="small">'+data.email+
		'</h4>'+
		'<p>'+data.message+'</p>'+
		'<p><img src="'+data.picture+'"></p>'+
		'<p>Date: '+moment().format('YYYY-MM-DD HH:mm:ss')+'</p></div>'
	);

	$(newReview).addClass('media review preview-item');

	$('#reviews').append(newReview);
}

function changePreviewItem(data) {
	deletePreviewItem();
	createNewReviewItem(data);
}


function deletePreviewItem() {
	$('.preview-item').remove();
}


function make_assoc_obj(arr) {
	var obj = {};
	arr.forEach(function (el, index, arr) {
		var $objKey = $(arr[index]).attr('data-form-keep');

		obj[$objKey] = arr[index].value;
	});

	return obj;
}




