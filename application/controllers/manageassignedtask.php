<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManageAssignedTask extends CI_Controller {

	function ManageAssignedTask()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->load->view('reviewer/AddNewTask');
	}
}
?>