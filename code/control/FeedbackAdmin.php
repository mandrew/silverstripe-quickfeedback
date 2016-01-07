<?php
class FeedbackAdmin extends ModelAdmin {
	
	private static $menu_title = "Feedback";
	private static $url_segment = "feedback";

	static $managed_models = array(
		'Feedback'
	);

	/**
	 * Don't show the Import from CSV form
	 */
	public $showImportForm = false;
	
}