<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManageMyTask extends CI_Controller {

	function ManageMyTask()
	{
		parent::__construct();
	}
	
	function addNewTask($pesan='')
	{
		$this->load->helper('form');
		$this->load->editor('editor/AddNewTask', array('msg' => $pesan));
	}
	
	function addingNewTask()
	{
		$this->load->helper(array('url', 'security'));
		$this->load->model('task');
		$this->load->library(array('form_validation'));
		
		$this->form_validation->set_rules('judul', 'Judul', 'trim|min_length[2]|max_length[250]|xss_clean');
		$this->form_validation->set_rules('katakunci', 'Kata Kunci', 'trim|min_length[2]|max_length[50]|xss_clean');
		/*memotong karakter, (|)<-lambang gerbang logika OR
		cari form validation rule, min length, max length, dll
		xss_clean: mencegah SQL injection*/
		
		
		$res = $this->form_validation->run();
		if ($res===FALSE){
			$msg = validation_errors();
			$this->load->view('editor/addNewTask', array('msg' => $msg));
			return FALSE; //return value, defaultnya true
		}
		
		$id_task = $this->task->insertNewTask();
		redirect('managemytask/selectReviewer'. $id_task);
	}
	
	function checkingLogin()
	{
		$this->load->helper(array('url', 'security'));
		$this->load->model('task');
		$this->load->library(array('form_validation'));
		
		$this->form_validation->set_rules('judul', 'Judul', 'trim|min_length[2]|max_length[250]|xss_clean');
		$this->form_validation->set_rules('katakunci', 'Kata Kunci', 'trim|min_length[2]|max_length[50]|xss_clean');
		/*memotong karakter, (|)<-lambang gerbang logika OR
		cari form validation rule, min length, max length, dll
		xss_clean: mencegah SQL injection*/
		
		
		$res = $this->form_validation->run();
		if ($res===FALSE){
			$msg = validation_errors();
			$this->load->view('editor/addNewTask', array('msg' => $msg));
			return FALSE; //return value, defaultnya true
		}
		
		$id_task = $this->task->insertNewTask();
		redirect('managemytask/selectReviewer'. $id_task);
	}
	
	function selectReviewer($id_task=-1) 
	{
		$this->load->model('task', 'reviewer');
		$thetask = $this->task->getTheTask($id_task);
		$reviewers = $this->reviewer->getAllReviewer();
		$this->load->view('editor/SelectPotentialReviewer', 
							array('task' => $thetask [0], 'reviewers' => $reviewers) );
	}
	
	function selectPotentialReviewer($id_task=-1) 
	{
		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] !='editor'){
			redirect('welcome/redirecting');
		}
		//load model
		$this->load->model(array('reviewer'));
		//$this->load->model(array('task', 'reviewer'));
		//$tasks = $this->task->getTheTask($id_task);
		$reviewers = $this->reviewer->getAllReviewer(); 

		//$tasks=$this->task->getMyTask($session_data['id_user']);

		$this->load->view('editor/header', array("nama_user"=>$session_data['nama'],
										"current_role"=>$session_data['nama_grup']));
		$this->load->view('editor/selectpotential', array("reviewers"=>$reviewers, "id_task"=>$id_task));
		//biar bisa menampilkan nama2 reviewer, dengan membawa id_task sebelumnya
		$this->load->view('common/content');
		$this->load->view('common/footer');
		/*$this->load->view('editor/selectpotential', 
				array('task' => $thetask [0], 'reviewers' => $reviewers) );*/
	}

	function requestedTask($id_task=-1, $id_reviewer=-1) 
	{
		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] !='editor'){
			redirect('welcome/redirecting');
		}

		$this->load->model('task');
		$assignments=$this->task->getTheAssignment($id_task, $id_reviewer);
		$status = 1;
		$this->db->set('status', $status);
        $this->db->where('id_task', $id_task);
		$this->db->update('task');
		
		/*$date=now();
		$page=$this->task->getTaskPage($id_task);
		$deadline=strtotime($date . '+ '.$page.'days');
		$this->db->set('tgl_deadline', $date);
        $this->db->where('id_task', $id_task);
		$this->db->update('assignment');*/

		$this->load->view('editor/header', array("nama_user"=>$session_data['nama'],
										"current_role"=>$session_data['nama_grup']));
		$this->load->view('editor/requesting_success');
		$this->load->view('common/content');
		$this->load->view('common/footer');
		
		
	}

	function index()
	{
		$this->load->view('editor/AddNewTask', array('msg' => ''));
	}
}
?>