<?php

class QuickFeedbackExtension extends DataExtension {

	private static $allowed_actions = array(
		'QuickFeedbackForm'
	);

	/**
	 *	Feedback Form
	 */
	public function QuickFeedbackForm() {
		$form = Form::create(
			$this->owner,
			'QuickFeedbackForm',
			FieldList::create(
				LiteralField::create("RatingTitle", "<h4>Was this article helpful?</h4>"),
				ButtonGroupField::create('Rating', '', array(
					"1" => "Yes",
					"0" => "No",
				)),
				TextareaField::create('Comment','Comment')
			),
			FieldList::create(
				FormAction::create('doSubmit','Submit')
			)
		);

		return $form;
	}	

	/**
	 *	Submits feedback form
	 */
	public function doSubmit($data, $form) {
		$feedback = Feedback::create();
		$feedback->Rating = $data['Rating'];
		$feedback->Comment = $data['Comment'];
		$feedback->URL = $this->owner->URLSegment;
		$feedback->write();

		$form->sessionMessage('Thanks for your comment!','good');

		return $this->owner->redirect( Director::baseURL() . $this->owner->URLSegment . "/?success=1");
	}

}