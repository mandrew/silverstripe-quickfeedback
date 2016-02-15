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
}
