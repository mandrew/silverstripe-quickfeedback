<?php
class Feedback extends DataObject
{
	/**
	 * @var array
	 */
	public static $db = array(
		'Rating' => 'Boolean',
		'Comment' => 'Text',
		'URL' => 'Text',
		'IP' => 'Text'
	);

	/**
	 * @var array
	 */
	public static $summary_fields = array(
		'Rating',
		'Comment',
		'URL'
	);
	
	public function canView($member = null) {
        return Permission::check('CMS_ACCESS_FeedbackAdmin');
    }
    public function canEdit($member = null) {
        return Permission::check('CMS_ACCESS_FeedbackAdmin');
    }
    public function canDelete($member = null) {
        return Permission::check('CMS_ACCESS_FeedbackAdmin');
    }
    public function canCreate($member = null) {
        return Permission::check('CMS_ACCESS_FeedbackAdmin');
    }
	
}
