<?php
class SetController {
	function __construct($f3) {
		$this->db=new DB\SQL(
			$f3->get('db_dns') . $f3->get('db_name'),
			$f3->get('db_user'),
			$f3->get('db_pass')
		);
		
		$this->users 		= new user($this->db);
		$this->viewProject 	= new viewProject($this->db);
		$this->project 		= new project($this->db);
		$this->projectUser 	= new projectUser($this->db);
		$this->requirement 	= new requirement($this->db);
		$this->todo 		= new todo($this->db);
		$this->setting 		= new setting($this->db);
		
        $f3->set('year', date('Y'));
	}
	
	function afterroute($f3) {
		//echo Template::instance()->render('template.htm');
		echo Template::instance()->render('/layout.htm');
    }
	
	function startsWith($haystack, $needle) {
		// search backwards starting from haystack length characters from the end
		return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}
	
}