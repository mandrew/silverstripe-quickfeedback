<?php
class FeedbackAdmin extends ModelAdmin {
	/**
	 * @var string
	 */
	private static $menu_title = 'Feedback';

	/**
	 * @var string
	 */
	private static $url_segment = 'feedback';

	/**
	 * @var array
	 */
	static $managed_models = array(
		'Feedback'
	);

	/**
	 * @var bool
	 */
	public $showImportForm = false;
}
