

/**
* Handle review item click event
* Make ajax request to server
**/
$('.review-item a.btn').on('click', function (event) {
	event.preventDefault();

	var reviewUrl = $(this).attr('href');
	var _self = $(this);

	var reviewItem = _self.parents('.review-item');
	var actionButtons = reviewItem.find('a.btn');

	console.log(actionButtons);

	$.ajax({
			url: reviewUrl,
			type: 'POST',
			success: function (successResponse) {

				var reviewLabel = reviewItem.find('.label');

				if (reviewLabel.hasClass('label-success')) {
					changeReviewItemLabel(reviewLabel, 'label-danger', 'Отклонен');
				} else if (reviewLabel.hasClass('label-danger')) {
					changeReviewItemLabel(reviewLabel, 'label-success', 'Принят');
				} else {
					changeReviewItemLabel(reviewLabel, 'label-info', 'Промодерирован');
				}

			},
			error: function (errorResponse){
				console.log(JSON.parse(errorResponse));
			}
		});

		// Disable action buttons
		actionButtons.addClass('disabled');

});


function changeReviewItemLabel(label, labelClass, labelText) {
	label.removeClass('label-danger label-success label-info');
	label.html(labelText);
	label.addClass(labelClass);
}

