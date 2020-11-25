<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReviewerCtl extends CI_Controller {

	
	function index()
	{
		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] !='reviewer'){
			redirect('welcome/redirecting');
		}
		$this->load->model(array("task"));
		$balance=$this->task->getReviewerBalance($session_data['id_user']);
		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);
		
		$this->load->view('reviewer/header', array("nama_user"=>$session_data['nama'],
											"current_role"=>$session_data['nama_grup'],
											"balance"=>$balance,
											"roles"=>$roles));
		$this->load->view('common/topmenu');
		$this->load->view('common/content');
		$this->load->view('common/footer');
	}

	function viewAssignment()
	{
		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] !='reviewer'){
			redirect('welcome/redirecting');
		}

		$this->load->model(array("task"));
		$assignments=$this->task->getReviewerAssignment($session_data['id_user']);
		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);
		$balance=$this->task->getReviewerBalance($session_data['id_user']);
		
		$this->load->view('reviewer/header', array("nama_user"=>$session_data['nama'],
											"current_role"=>$session_data['nama_grup'],
											"balance"=>$balance,
											"roles"=>$roles));
		$this->load->view('reviewer/view_assignment',array("assignments"=>$assignments));
		$this->load->view('common/footer');
	}

	
	function accepted($id_task=-1)
    {
		//set deadline
		$this->load->model("task");
		
		$date = date('Y-m-d', now());
		$page=$this->task->getTaskPage($id_task);
		$deadline = date('Y-m-d', strtotime($date.'+' .$page->page.' days'));

		$this->db->set('tgl_deadline', $deadline);
        $this->db->where('id_task', $id_task);
		$this->db->update('assignment');
		
        $status = 2;
        $this->db->set('status', $status);
        $this->db->where('id_task', $id_task);
		$this->db->update('assignment');

		$this->db->set('status', $status);
        $this->db->where('id_task', $id_task);
		$this->db->update('task');

		

        redirect('reviewerCtl/viewAssignment');
    }

    function rejected($id_task=-1)
    {
        //if(!isset($id_Task)) redirect('')
        $status=3;
        $this->db->set('status', $status);
        $this->db->where('id_task', $id_task);
        $this->db->update('assignment');
		$this->db->set('status', $status);
        $this->db->where('id_task', $id_task);
		$this->db->update('task');
		redirect('reviewerCtl/viewAssignment');
	}
	
	public function completeReviewTask($id_task)
	{
		//Untuk memberikan tugas yg sudah complete kepada Editor
		//Dan mengubah status Task menjadi (4) yaitu Waiting Payment
		if (!$this->session->userdata('logged_in')) {
		redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');
		
		if ($session_data['nama_grup'] != 'reviewer') {
		redirect('welcome/redirecting');
		}
		$this->load->helper('form');
		$this->load->model(array("reviewer"));
		//ambil task yang punya saya
		
		//$assignments = $this->reviewer->getReviewerCompletedAssignment($id_task,$session_data['id_user']);
		
		$this->load->model(array("task"));
		$balance=$this->task->getReviewerBalance($session_data['id_user']);
		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);

		$this->load->view('reviewer/header', array("nama_user"=>$session_data['nama'],
											"current_role"=>$session_data['nama_grup'],
											"balance"=>$balance,
											"roles"=>$roles));
		$namareviewer = $session_data['nama'];
		$this->load->view('reviewer/complete_task', array( 
													"namareviewer" => $namareviewer,
													"id_task"=>$id_task));
		// 
		$this->load->view('common/footer');
 	}

 	function completingReviewTask($id_task=-1)
	{
		//Untuk membrikan tugas yg sudah complete kepada Editor
		//Dan mengubah status Task menjadi (4) yaitu Waiting Payment
		if (!$this->session->userdata('logged_in')) {
		redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');
		
		if ($session_data['nama_grup'] != 'reviewer') {
		redirect('welcome/redirecting');
		}

		$this->load->helper(array('form', 'url', 'security'));
		$this->load->model('task');
		$this->load->library(array('form_validation'));

		$config['upload_path']          = '../../ereview/berkas/completed';
        $config['allowed_types']        = 'doc|docx|pdf';
        $config['max_size']             = 10000;
        //$config['max_width']            = 300;
        //$config['max_height']           = 300;

		$new_name = time()."_".$_FILES["userfile"]['name'];
		$new_name = str_replace(" ", "_", $new_name);
		$config['file_name'] = $new_name;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('userfile')) {   //gagal upload
			$namareviewer = $session_data['nama'];
			$error = array('error' => $this->upload->display_errors());
	
			$this->load->model(array("task"));
			$balance=$this->task->getReviewerBalance($session_data['id_user']);
			$this->load->model("account");
			$roles = $this->account->getRoles($session_data['id_user']);

			$this->load->view('reviewer/header', array("nama_user"=>$session_data['nama'],
											"current_role"=>$session_data['nama_grup'],
											"balance"=>$balance,
											"roles"=>$roles));
			//$this->load->view('common/topmenu');
			$this->load->view('reviewer/complete_task', array("namareviewer" => $namareviewer,
															"id_task"=>$id_task),
																 $error);
			$this->load->view('common/footer');
			return;
		}
		
		$this->load->model(array("task"));
		//jalankan fungsi untuk mengubah status menjadi completed
		//$complete = $this->reviewer->getReviewerCompletedAssignment($id_task,$session_data['id_user']);
		
		$status=4;
		$date = date('Y-m-d', now());
		$this->db->set('status', $status);
		$this->db->set('file_location', $new_name);
		$this->db->set('date_updated', $date);
        $this->db->where('id_task', $id_task);
        $this->db->update('assignment');
		$this->db->set('status', $status);
        $this->db->where('id_task', $id_task);
		$this->db->update('task');
		//kembali ke view assignment
		
		$assignments=$this->task->getReviewerAssignment($session_data['id_user']);

		$this->load->model(array("task"));
		$balance=$this->task->getReviewerBalance($session_data['id_user']);
		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);

		$this->load->view('reviewer/header', array("nama_user"=>$session_data['nama'],
											"current_role"=>$session_data['nama_grup'],
											"balance"=>$balance,
											"roles"=>$roles));
		$this->load->view('reviewer/view_assignment', array("assignments" => $assignments));
		$this->load->view('common/footer');


	}

	function viewBalance($msg='')
	{
		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] !='reviewer'){
			redirect('welcome/redirecting');
		}
		
		$this->load->model('task');
		$this->load->library(array('form_validation'));
		$this->load->helper(array('url', 'form', 'security'));
		$balance=$this->task->getReviewerBalance($session_data['id_user']);
		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);

		$this->load->view('reviewer/header', array("nama_user"=>$session_data['nama'],
											"current_role"=>$session_data['nama_grup'],
											"balance"=>$balance,
											"msg"=>$msg,
											"roles"=>$roles));
		$this->load->view('reviewer/view_balance',array("balance"=>$balance, "id_user"=>$session_data['id_user'])); 
		$this->load->view('common/footer');
	}
}