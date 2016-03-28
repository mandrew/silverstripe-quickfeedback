<?php

class QuickFeedbackExtension extends DataExtension {
	/**
	 * Minimum time between submissions, in minutes.
	 *
	 * @var int
	 */
	public static $rate_limit = 3;

	/**
	 * Embed the redirect target.
	 *
	 * @var bool
	 */
	public static $redirect_field = false;

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

		// if DisplayFeedback returns 'hide' then hide form
		$page = $this->owner;

		if ($page->DisplayFeedback == 'hide') {
			return false;
		}

		$previous = null;

		while ($page->hasMethod("Parent") && $parent = $page->Parent()) {
			if ($previous && $previous->ID == $parent->ID) {
				break;
			}

			$previous = $parent;

			if ($page->DisplayFeedback == 'show') {
				break;
			}

			if ($parent->DisplayFeedback == 'hide') {
				return false;
			}
		}

		$fields = FieldList::create(
			LiteralField::create('RatingTitle', _t('QuickFeedback.Title', '<h4>Was this article helpful?</h4>')),
			ButtonGroupField::create('Rating', '', array(
				'1' => _t('QuickFeedback.Yes', 'Yes'),
				'0' => _t('QuickFeedback.No', 'No'),
			)),
			TextareaField::create('Comment', _t('QuickFeedback.Comment', "<strong>Sorry about that.</strong> How can we make it better?"))
		);

		if ((bool) Config::inst()->get('QuickFeedbackExtension', 'redirect_field')) {
			$fields->push(
				HiddenField::create('Redirect', null, $_SERVER['REQUEST_URI'])
			);
		}

		$form = Form::create(
			$this->owner,
			'QuickFeedbackForm',
			$fields,
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

		$redirect = Director::baseURL() . $this->owner->URLSegment;

		if ((bool) Config::inst()->get('QuickFeedbackExtension', 'redirect_field') && isset($data['Redirect']) && Director::is_site_url($data['Redirect'])) {
			$redirect = Director::absoluteURL($data['Redirect'], true);
		}

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
		$feedback->IP = $request->getIP();

		if (!empty($this->owner->ID)) {
			$feedback->PageID = $this->owner->ID;
		}

		if (!empty($this->owner->URLSegment)) {
			$feedback->URL = $this->owner->RelativeLink();
		}

		if ((bool) Config::inst()->get('QuickFeedbackExtension', 'redirect_field') && isset($data['Redirect'])) {
			$feedback->URL = $data['Redirect'];
		}

		$feedback->write();

		$form->sessionMessage(_t('QuickFeedback.ThanksMessage', 'Thanks for your comment!'),'good');
		return $this->owner->redirect($redirect . '?success=1#Form_QuickFeedbackForm');

		error:
			$form->sessionMessage(_t('QuickFeedback.ErrorMessage', 'An error occurred!'),'error');
			return $this->owner->redirect($redirect . '?error=1#Form_QuickFeedbackForm');

		rate:
			$form->sessionMessage(_t('QuickFeedback.RateMessage', 'Please wait a while before submitting!'),'error');
			return $this->owner->redirect($redirect . '?rate=1#Form_QuickFeedbackForm');
	}
}
