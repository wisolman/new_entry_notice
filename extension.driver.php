<?php

/* This extension creates an entry in one section noting that an author has created an
entry in another section. On the site for which this extension was developed the index (home)
page displays only short remarks. Another page displays longer articles (like blog posts).
When an author publishes a new article a remark is automatically created on the index page.
The new remark includes the title of the new article as a link to the new article. The
properties and the code in the callback functions will have to be modified slightly for 
other implementations.*/


Class extension_new_entry_notice extends Extension {

	private $new_id = 7; //the id of the section for which a new entry is to be noted
	private $tgt_id = 12; //the id of the section where the notice is to be entered
	private $admin_id = 1; //the id of a developer or administrator
	private $publish_field_id = 30; //the id of the publish field in section $new_id
	private $title_field_id = 23; //the id of the title field in section $new_id

	// Simply outputs information to Symphony about the extension
	public function about() {
		$info = array(
			'author' => array(
				'email' => 'sassercw@cox.net',
				'name' => 'Carson Sasser',
				'website' => 'http://carsonsasser.com/'
			),
			'name' => 'New Entry Notice',
			'release-date' => '2010-06-20',
			'version' => '1.0'
		);
		return $info;
	}
	
	public function getSubscribedDelegates() {
		return array(
			array(
			'page' => '/publish/new/',
			'delegate' => 'EntryPostCreate',
			'callback' => 'fromEntryPostCreate'
			),
			array(
			'page' => '/publish/edit/',
			'delegate' => 'EntryPreEdit',
			'callback' => 'fromEntryPreEdit'
			)
		);
	}
	//notice created when a new entry is created with the publish field set to 'yes'
	public function fromEntryPostCreate($object) {
		if ($object['section']->get('id') == $this->new_id && $object['fields']['publish'] == 'yes')
			$this->createNewEntryNotice($object);
	}
	//gets the value of the publish field before editing
	//and compares it to the setting after editing
	//creates notice if setting is changing from 'no' to 'yes'
	public function fromEntryPreEdit($object) {
		if ($object['section']->get('id') != $this->new_id) return;
		$entry_id = $object['entry']->get('id');
		$table = "sym_entries_data_".$this->publish_field_id;
		$result = Symphony::Database()->fetch("SELECT value FROM $table WHERE entry_id = '$entry_id'");
		$published = $result[0]['value'];
		if ($published == 'no' && $object['fields']['publish'] == 'yes')
			$this->createNewEntryNotice($object);
	}
	//creates the notice
	public function createNewEntryNotice($object) {
		$parent = $object['section']->_Parent;
		$entryManager = new EntryManager($parent);
		$notice = $entryManager->create();
		$notice->set('section_id', $this->tgt_id);
		$notice->set('author_id', $this->admin_id);
		$date = DateTimeObj::get('Y-m-d H:i:s');
		$notice->set('creation_date', $date);
		$notice->set('creation_date_gmt', DateTimeObj::getGMT('Y-m-d H:i:s'));
		$title_array = $object['entry']->getData($this->title_field_id);
		$title = $title_array['value'];
		$handle = $title_array['handle'];
		$link = "<a href='article/{$handle}'>{$title}</a>";
		$body = "New article posted: ".$link;
		$fields = array('body'=>$body, 'date'=>$date, 'publish'=>'yes');
		$notice->setDataFromPost($fields, $error);
		$notice->commit();
	}
}

?>
