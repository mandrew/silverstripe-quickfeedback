<?php

class QuickFeedbackExtension extends DataExtension {
	/**
	 * Minimum time between submissions, in minutes.
	 *
	 * @var int
	 */
	public static $rate_limit = 3;

	/**
	 * @var array
	 */
	private static $allowed_actions = array(
		'QuickFeedbackForm'
	);

	/**
	 * @return Form
	 */
	public function QuickFeedbackForm() {
		$form = Form::create(
			$this->owner,
			'QuickFeedbackForm',
			FieldList::create(
				LiteralField::create('RatingTitle', _t('QuickFeedback.Title', '<h4>Was this article helpful?</h4>')),
				ButtonGroupField::create('Rating', '', array(
					'1' => _t('QuickFeedback.Yes', 'Yes'),
					'0' => _t('QuickFeedback.No', 'No'),
				)),
				TextareaField::create('Comment', _t('QuickFeedback.Comment', 'Comment'))
			),
			FieldList::create(
				FormAction::create('doSubmit', _t('QuickFeedback.Submit', 'Submit'))
			)
		);

		return $form;
	}

	/**
	 * @param array $data
	 * @param Form $form
	 *
	 * @return mixed
	 */
	public function doSubmit($data, $form) {
		$controller = Controller::curr();

		if (!$controller) {
			goto error;
		}

		$request = $controller->getRequest();

		if (!$request) {
			goto error;
		}

		$limit = (int) Config::inst()->get('QuickFeedbackExtension', 'rate_limit');

		$existing = Feedback::get()
			->filter('IP', $request->getIP())
			->sort('Created desc')
			->first();

		if ($existing) {
			$created = $existing->dbObject('Created');

			if (!$created) {
				goto error;
			}

			$seconds = abs(time() - strtotime($created->getValue()));
			$minutes = round($seconds / 60);

			if ($minutes <= $limit) {
				goto rate;
			}
		}

		$feedback = Feedback::create();
		$feedback->Rating = $data['Rating'];
		$feedback->Comment = $data['Comment'];
		$feedback->URL = $this->owner->URLSegment;
		$feedback->IP = $request->getIP();
		$feedback->write();

		$form->sessionMessage(_t('QuickFeedback.ThanksMessage', 'Thanks for your comment!'),'good');
		return $this->owner->redirect(Director::baseURL() . $this->owner->URLSegment . '?success=1');

		error:
			$form->sessionMessage(_t('QuickFeedback.ErrorMessage', 'An error occurred!'),'error');
			return $this->owner->redirect(Director::baseURL() . $this->owner->URLSegment . '?error=1');

		rate:
			$form->sessionMessage(_t('QuickFeedback.RateMessage', 'Please wait a while before submitting!'),'error');
			return $this->owner->redirect(Director::baseURL() . $this->owner->URLSegment . '?rate=1');
	}
}
