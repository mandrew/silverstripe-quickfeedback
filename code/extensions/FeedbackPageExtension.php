<?php
class FeedbackPageExtension extends DataExtension {
	/**
	 * @var array
	 */
	public static $db = array(
		'DisplayFeedback' => 'Enum("show,hide,inherit","inherit")',
	);

    public function updateSettingsFields(FieldList $fields) {
    	$feedback = new FieldGroup(
			DropdownField::create('DisplayFeedback', '', singleton('Page')->dbObject('DisplayFeedback')->enumValues())
		);

        $fields->addFieldToTab("Root.Settings", $feedback->setTitle('Show feedback form?'));
	}
}