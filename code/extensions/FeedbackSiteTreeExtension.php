<?php
class FeedbackSiteTreeExtension extends DataExtension {

    /**
     * @var DataObject
     */
    public static $has_one = array(
        'Page' => 'SiteTree'
    );
}