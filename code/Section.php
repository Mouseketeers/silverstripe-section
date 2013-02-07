<?php
class Section extends Page {
	static $icon  = 'section/images/section';
 	static $num_pages_options = array(
		0 => 'All',
		2 => '2',
		3 => '3',
		4 => '4',
		5 => '5',
		6 => '6',
		7 => '7',
		8 => '8',
		9 => '9',
		10 => '10',
		15 => '15',
		20 => '20',
		50 => '50',
		100 => '100'
	);
	public static $db = array(
		'NumPages' => 'Int',
		'SortOrder' => 'Varchar',
		'ExcludeHiddenPages' => 'Boolean',
		'IncludeSubsections' => 'Boolean'
	);
	static $defaults = array(
		'SortOrder' => 'Sort',
		'ExcludeHiddenPages' => '0'
	);
	public static $sort_options = array(
		'Sort' => 'Sort order',
		'Sort DESC' => 'Reverse sort order',
		'Created' => 'By creation date',
		'Created DESC' => 'By reverse creation date',
		'Title' => 'Alfabetically by title'
	);
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldsToTab('Root.Content.Settings', array(
				new LiteralField('SectionSettingHeader', '<br /><h3>'._t('Section.SETTINGSHEADER', 'Section Settings').'</h3>'),
				new DropdownField('SortOrder','Sort order of sub-pages',self::$sort_options),
				new DropdownField('NumPages','Number of sub-pages to list',self::$num_pages_options),
				new CheckboxField('ExcludeHiddenPages','Exclude pages hidden in the menu'),
				new CheckboxField('IncludeSubsections','Include pages in subsections')
			)
		);
		return $fields;
	}
}
class Section_Controller extends Page_Controller {
	public function ContentList() {
		if($this->NumPages) {
			if(!isset($_GET['start']) || !is_numeric($_GET['start']) || (int)$_GET['start'] < 1) $_GET['start'] = 0;
			$limit_start = (int)$_GET['start'];
			$limit = $limit_start.','.$this->NumPages;
		}
		else {
			$limit = '';
		}
		if($this->IncludeEventsInSubsections) {
			$decendent_ids = $this->getDescendantIDList();
			$filter = '"Page"."ID" IN ('.implode(',',$decendent_ids).') ';
		}
		else {
			$filter = 'ParentID = '. $this->ID;			
		}
		if($this->ExcludeHiddenPages) $filter .= ' AND ShowInMenus = 1';
		$data = DataObject::get('Page', $filter, $this->SortOrder,'',$limit);
		
		//hack avoiding DataObejctSet to set pageLength to 10 when it should be unlimited
		if($data && $data->pageLength == 0) {
			$data->pageLength = -1;
		}
		return $data;
	}
	public function IsFirstPage() {
		return ($this->request->getVar('start') == 0);
	}
}