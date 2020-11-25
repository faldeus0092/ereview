<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApplicationCtl extends CI_Controller {

	
	function download($id_task=0)
	{

		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		//mendapatkan model task
		
		$this->load->helper('download');
		$this->load->model(array("task"));
		$task=$this->task->getTheTask($id_task);
		//memastikan dia punya task
		if (sizeof($task)<=0){
			echo "failed";
			return;
		}
		//mengambil file
		force_download('../../ereview/berkas/'.$task[0]['file_location'], NULL);
		return;
	}

	function buktiDownload($id_assignment=-1)
	{
		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		//mendapatkan model task
		
		$this->load->helper('download');
		$this->load->model(array("payment"));
		$bukti=$this->payment->getBukti($id_assignment);
		//echo $bukti->bukti;
		//die;
		//memastikan dia punya task
		if (($bukti->bukti)<=0){
			echo "failed";
			return;
		}
		//mengambil file
		force_download('../../ereview/berkas/bukti/'.$bukti->bukti ,NULL);
		return;
	}

	function assignmentDownload($id_assignment=-1)
	{
		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		//mendapatkan model task
		
		$this->load->helper('download');
		$this->load->model(array("payment"));
		$bukti=$this->payment->getTheAssignmentFile($id_assignment);

		//memastikan dia punya task
		if (sizeof($bukti)<=0){
			echo "failed";
			return;
		}
		//mengambil file
		force_download('../../ereview/berkas/completed/'.$bukti[0]['file_location'] ,NULL);
		return;
	}

	function editorassignmentDownload($id_task=-1)
	{
		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		//mendapatkan model task
		
		$this->load->helper('download');
		$this->load->model(array("payment"));
		$bukti=$this->payment->editorgetTheAssignmentFile($id_task);

		//memastikan dia punya task
		if (sizeof($bukti)<=0){
			echo "failed";
			return;
		}
		//mengambil file
		force_download('../../ereview/berkas/completed/'.$bukti[0]['file_location'] ,NULL);
		return;
	}
}