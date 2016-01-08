// Standard jQuery header
(function($) {
	$(document).ready(function() {
		$("#Form_QuickFeedbackForm").find(":submit").css({display: "none"}); // hide submit button
		$("#Form_QuickFeedbackForm").find(".textarea").css({display: "none"}); // hide submit button

		$("#Form_QuickFeedbackForm_Rating button").click(function(){
			$("#Form_QuickFeedbackForm_Rating input").val($(this).val());
			var id = $(this).attr('id');

			// if yes (1)
			if (id == "FieldRating-1") {
				$("#Form_QuickFeedbackForm").find(":submit").click();
			} else {
				$("#Form_QuickFeedbackForm").find(".textarea").css({display: "block"}); // show textarea
				$("#Form_QuickFeedbackForm").find(":submit").css({display: "block"}); // show submit button
			}

			return;
		});
	// Standard jQuery footer
	})
})(jQuery);