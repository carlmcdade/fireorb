<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->view('welcome_message');
	}
	
	function hello()
	{
		print 'hello world';
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */