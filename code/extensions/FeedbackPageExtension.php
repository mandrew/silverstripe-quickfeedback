<?php
class FeedbackPageExtension extends DataExtension {
	/**
	 * @var array
	 */
	public static $db = array(
		'HideFeedbackForm' => 'Boolean'
	);

    public function updateSettingsFields(FieldList $fields) {
    	$feedback = new FieldGroup(
			CheckboxField::create('HideFeedbackForm', 'Hide form')
		);
        $fields->addFieldToTab("Root.Settings", $feedback->setTitle('Feedback'));
	}
	
	// public static function HideForm($this->) {
	// 	return $this->owner->HideFeedbackForm;
	// }
}