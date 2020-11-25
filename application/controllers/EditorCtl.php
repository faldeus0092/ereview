<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditorCtl extends CI_Controller {


	
	function index()
	{
		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] !='editor'){
			redirect('welcome/redirecting');
		}

		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);

		$this->load->view('editor/header', array("nama_user"=>$session_data['nama'],
										"current_role"=>$session_data['nama_grup'],
										"roles"=>$roles));
		$this->load->view('common/topmenu');
		$this->load->view('common/content');
		$this->load->view('common/footer');
	}
	function addTask()
	{
		$this->load->helper(array('form', 'url'));
		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] !='editor'){
			redirect('welcome/redirecting');
		}
		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);

		$this->load->view('editor/header', array("nama_user"=>$session_data['nama'],
										"current_role"=>$session_data['nama_grup'],
										"roles"=>$roles));
		//$this->load->view('common/topmenu');
		$this->load->view('editor/add_task',array("error"=>""));
		$this->load->view('common/footer');
	}

	function addingTask($pesan='')
	{
		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] !='editor'){
			redirect('welcome/redirecting');
		}

		$this->load->helper(array('url', 'security'));
		$this->load->model('task');
		$this->load->library(array('form_validation'));
		
		$this->form_validation->set_rules('judul', 'Title', 'trim|min_length[2]|max_length[128]|xss_clean');
		$this->form_validation->set_rules('katakunci', 'Keywords', 'trim|min_length[2]|max_length[128]|xss_clean');
		$this->form_validation->set_rules('authors', 'Authors', 'trim|min_length[2]|max_length[128]|xss_clean');
		
		$res = $this->form_validation->run();
		if ($res==FALSE){
			$msg = validation_errors();

			$this->load->model("account");
			$roles = $this->account->getRoles($session_data['id_user']);

			$this->load->view('editor/header', array("nama_user"=>$session_data['nama'],
													"current_role"=>$session_data['nama_grup'],
													"roles"=>$roles));
			//$this->load->view('common/topmenu');
			$this->load->view('editor/add_task',$msg);
			$this->load->view('common/footer');
			return FALSE;
		}
		
		$config['upload_path']          = '../../ereview/berkas/';
        $config['allowed_types']        = 'doc|docx|pdf';
        $config['max_size']             = 10000;
        //$config['max_width']            = 300;
        //$config['max_height']           = 300;

		$new_name = time()."_".$_FILES["userfile"]['name'];
		$new_name = str_replace(" ", "_", $new_name);
		$config['file_name'] = $new_name;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {//gagal
					$msg = array('error' => $this->upload->display_errors());

					$this->load->model("account");
					$roles = $this->account->getRoles($session_data['id_user']);

					$this->load->view('editor/header', array("nama_user"=>$session_data['nama'],
															"current_role"=>$session_data['nama_grup'],
															"roles"=>$roles));
					//$this->load->view('common/topmenu');
					$this->load->view('editor/add_task',$msg);
					$this->load->view('common/footer');
					return;
                }
                
                //upload
                $data = array('upload_data' => $this->upload->data());
				//tambah data ke database
				$id_task = $this->task->insertNewTask($session_data['id_user'],$new_name);
				//tampilkan halaman sukses

				$this->load->model("account");
				$roles = $this->account->getRoles($session_data['id_user']);

				$this->load->view('editor/header', array("nama_user"=>$session_data['nama'],
														"current_role"=>$session_data['nama_grup'],
														"roles"=>$roles));
				//$this->load->view('common/topmenu');
				$this->load->view('editor/add_success',array("error"=>""));
				$this->load->view('common/footer');
				return;
                
	}
	function viewTask()
	{
		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] !='editor'){
			redirect('welcome/redirecting');
		}

		$this->load->model(array("task"));
		//ambil my task
		$tasks=$this->task->getMyTask($session_data['id_user']);
		//$assignments=$this->task->getMyTaskWithIDAssignment($session_data['id_user']);
		//ambil id assignment
		//$res=$this->task->getIDAssignment($tasks['id_task']);
		
		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);

		$this->load->view('editor/header', array("nama_user"=>$session_data['nama'],
										"current_role"=>$session_data['nama_grup'],
										"roles"=>$roles));
		$this->load->view('editor/view_task',array("tasks"=>$tasks));
		$this->load->view('common/footer');
	}

	function Payment($id_task=-1){
		if (!$this->session->userdata('logged_in')){
			redirect('welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		if ($session_data['nama_grup'] !='editor'){
			redirect('welcome/redirecting');
		}
		$this->load->helper('form');

		$this->load->model("task");
		$info=$this->task->getIDAssignmentdanReviewer($id_task);

		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);

		$this->load->view('editor/header', array("nama_user"=>$session_data['nama'],
										"current_role"=>$session_data['nama_grup'],
										"roles"=>$roles));
		$this->load->view('editor/payment_confirmation',array("info"=>$info));
		$this->load->view('common/footer');
	}

}