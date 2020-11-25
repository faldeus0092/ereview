<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MakelarCtl extends CI_Controller {

	
	function index()
	{
		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] !='makelar'){
			redirect('welcome/redirecting');
		}
		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);
		$this->load->view('makelar/header', array("nama_user"=>$session_data['nama'],
												"current_role"=>$session_data['nama_grup'],
												"roles"=>$roles));
		$this->load->view('common/topmenu');
		$this->load->view('common/content');
		$this->load->view('common/footer');
	}

	function viewNewTask()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('welcome/index');
		}

		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] != 'makelar') {
			redirect('welcome/redirecting');
		}

		$this->load->model(array("task"));
		$status = 1;
		$tasks = $this->task->getviewmakelar($status);

		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);

		$this->load->view('makelar/header', array("nama_user" => $session_data['nama'],
												"current_role" => $session_data['nama_grup'],
												"roles"=>$roles));

		$this->load->view('makelar/viewNewTask', array("tasks" => $tasks));
		// 
		$this->load->view('common/footer');
	}

	function viewOngoingTask()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('welcome/index');
		}

		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] != 'makelar') {
			redirect('welcome/redirecting');
		}

		$this->load->model(array("task"));
		$status = 2;
		$tasks = $this->task->getviewmakelar($status);
		
		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);

		$this->load->view('makelar/header', array("nama_user" => $session_data['nama'],
												"current_role" => $session_data['nama_grup'],
												"roles"=>$roles));

		$this->load->view('makelar/viewOngoingTask', array("tasks" => $tasks));
		// 
		$this->load->view('common/footer');
	}

	function viewCompletedTask()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('welcome/index');
		}

		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] != 'makelar') {
			redirect('welcome/redirecting');
		}

		$this->load->model(array("task"));
		$status = 4;
		$tasks = $this->task->getviewmakelar($status);

		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);

		$this->load->view('makelar/header', array("nama_user" => $session_data['nama'],
													"current_role" => $session_data['nama_grup'],
													"roles"=>$roles));

		$this->load->view('makelar/viewCompletedTask', array("tasks" => $tasks));
		// 
		$this->load->view('common/footer');
	}

	function viewPaidTask()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('welcome/index');
		}

		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] != 'makelar') {
			redirect('welcome/redirecting');
		}

		$this->load->model(array("task"));
		$status = 5;
		$tasks = $this->task->getviewmakelar2($status);

		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);

		$this->load->view('makelar/header', array("nama_user" => $session_data['nama'],
												"current_role" => $session_data['nama_grup'],
												"roles"=>$roles));

		$this->load->view('makelar/viewPaidTask', array("tasks" => $tasks));
		// 
		$this->load->view('common/footer');
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
		redirect('makelarCtl/viewPaidTask');
	}

	function accepted($id_task=-1,$id_reviewer=-1, $id_assignment=-1)
    {
        //if(!isset($id_Task)) redirect('')
        $status=6;
        $this->db->set('status', $status);
        $this->db->where('id_task', $id_task);
        $this->db->update('assignment');
		$this->db->set('status', $status);
        $this->db->where('id_task', $id_task);
		$this->db->update('task');

		$this->load->model(array("Payment"));
		$saldo = $this->Payment->getSaldo($id_reviewer);
		$amounttambah = $this->Payment->getAmountComplete($id_assignment);
		$amount = $saldo + $amounttambah;
		$tasks = $this->Payment->confirmPayment($id_reviewer, $amount, $id_assignment);
		
		redirect('makelarCtl/viewPaidTask');
	}
}