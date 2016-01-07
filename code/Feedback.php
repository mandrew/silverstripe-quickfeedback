<?php
class Feedback extends DataObject
{
	static $db = array(
		'Rating' => 'Boolean',
		'Comment' => 'Text',
		'URL' => 'Varchar'
	);

	static $has_one = array(
		'Page' => 'SiteTree'
	);


	static $summary_fields = array(
		'Rating',
		'Comment',
		'URL'
	);

}