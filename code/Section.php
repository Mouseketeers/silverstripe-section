<?php
class Section extends Page {
	public static $db = array(
		'NumPages' => 'Int',
		'SortOrder' => 'Varchar',
		'ExcludeHiddenPages' => 'Boolean'
	);
	public static $has_one = array(
		'Image' => 'Image'
	);
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
		$fields->addFieldsToTab('Root.Content.Settings', array(
				new LiteralField('SectionSettingHeader', '<br /><h3>'._t('Section.SETTINGSHEADER', 'Section Settings').'</h3>'),
				new DropdownField('SortOrder','Sort order of sub-pages',self::$sort_options),
				new NumericField('NumPages','Max sub-pages to list (set this to 0 to list all pages)'),
				new CheckboxField('ExcludeHiddenPages','Exclude pages hidden in the menu') 
			)
		);
		$fields->addFieldToTab('Root.Content.Main', 
			new FileUploadField(
				'Image',
				_t('Section.IMAGE','Image')
			)
		);
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