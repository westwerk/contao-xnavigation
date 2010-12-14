<?php
class xNavigationRunonce extends Frontend
{

	/**
	 * Initialize the object
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->import('Database');
	}

	public function run()
	{
		$this->import('Database');
		if ($this->Database->fieldExists('xNavigation', 'tl_page')) {
			$this->Database->execute("ALTER TABLE tl_page CHANGE xNavigation menu_visibility varchar(32) NOT NULL default ''");
		}
	}
}

/**
 * Instantiate controller
 */
$objxNavigationRunonce = new xNavigationRunonce();
$objxNavigationRunonce->run();

?>