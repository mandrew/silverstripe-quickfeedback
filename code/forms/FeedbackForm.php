<?php

class FeedbackForm extends Form {

	private static $allowed_actions = array(
		'QuickFeedbackForm'
	);

	/**
	 *	Feedback Form
	 */
	public function QuickFeedbackForm() {
		$form = Form::create(
			$this,
			'QuickFeedbackForm',
			FieldList::create(
				OptionsetField::create('Rating'),
				TextareaField::create('Comment','Comment')
			),
			FieldList::create(
				FormAction::create('doSubmit','Submit')
			),
			RequiredFields::create('Rating')
		);

		return $form;
	}	

	/**
	 *	Submits feedback form
	 */
	public function doSubmit($data, $form) {
		$feedback = Feedback::create();
		$feedback->Name = $data['Rating'];
		$feedback->Comment = $data['Comment'];
		$feedback->URL = $this->URLSegment;
		$comment->write();

		$form->sessionMessage('Thanks for your comment!','good');

		return $this->redirectBack();
	}
}