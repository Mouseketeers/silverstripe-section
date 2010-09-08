<?php
class Section extends Page {
	public static $db = array(
		'NumPages' => 'Int',
		'SortOrder' => 'Varchar',
		'ExcludeHiddenPages' => 'Boolean'
	);
	public static $has_one = array();
	static $defaults = array(
		'Pagination' => '0',
		'SortOrder' => 'Sort',
		'ExcludeHiddenPages' => '0'
	);
	static $icon  = 'section/images/section';
	public static $sort_options = array(
		'Sort' => 'Menu sort order',
		'Title' => 'Alfabetically by title'
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Content.Main',new DropdownField('SortOrder','Sort order of sub-pages',self::$sort_options),'Content');
		$fields->addFieldToTab('Root.Content.Main',new NumericField('NumPages','Max pages to list (set to 0 to list all pages)'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new CheckboxField('ExcludeHiddenPages','Exclude pages hidden in the menu'),'Content');
		return $fields;
	}

}
class Section_Controller extends Page_Controller {
	public function ContentList() {
		$limit = '';
		if($this->NumPages) {
			if(!isset($_GET['start']) || !is_numeric($_GET['start']) || (int)$_GET['start'] < 1) $_GET['start'] = 0;
			$limit_start = (int)$_GET['start'];
			$limit = $limit_start.','.$this->NumPages;
		}
		$filter = 'ParentID = '. $this->ID;
		if($this->ExcludeHiddenPages) $filter .= ' AND ShowInMenus = 1';
		$data = DataObject::get('Page', $filter, $this->SortOrder,'',$limit);
		return $data;
	}
}
?>