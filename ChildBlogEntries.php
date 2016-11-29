<?php
/**
 * Shows a widget with viewing blog entries
 * by months or years.
 *
 * @package blog
 */
class ChildBlogEntries extends Widget
{
    public static $db = array(
        'NumberOfItems' => 'Int'
    );
    public static $has_one = array();

    public static $has_many = array();

    public static $many_many = array();

    public static $belongs_many_many = array();

    public static $defaults = array(
        'NumberOfItems' => 7
    );

    public static $title = 'Child Blog Entries';

    public static $cmsTitle = 'Child Blog Entries';

    public static $description = 'Show a list of latest child blog entries.';

    public function getCMSFields()
    {
        return new FieldSet(
            new NumericField("NumberOfItems", "Number of items shown (will always show newest ones first)")
        );
    }

    public function Links()
    {
        $bt = defined('DB::USE_ANSI_SQL') ? "\"" : "`";
        $widgetAreaID = $this->ParentID;
        $parent = DataObject::get_one("SiteTree", "NewsItemsID = ".$widgetAreaID);
        if ($parent) {
            Requirements::themedCSS("widgets_ChildBlogEntries");
            return DataObject::get("BlogEntry", "{$bt}ParentID{$bt} = ".$parent->ID, "{$bt}Created{$bt} DESC", null, $this->NumberOfItems);
        }
    }
}
