<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AccountCtl extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('Account'));
	}
	
	function index()
	{
		$this->load->view('account/account.php');
	}
	
	function creatingAccount($pesan='')
	{
		$this->load->helper(array('form','url', 'security'));
		$this->load->model('task');
		$this->load->library(array('form_validation'));
		
		$this->form_validation->set_rules('nama', 'Nama', 'trim|min_length[2]|max_length[128]|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'trim|min_length[2]|max_length[128]|xss_clean');
		$this->form_validation->set_rules('katasandi', 'Kata Sandi', 'trim|min_length[2]|max_length[128]|xss_clean');
		$this->form_validation->set_rules('email', 'Surel', 'trim|min_length[2]|max_length[128]|xss_clean');
		
		$res = $this->form_validation->run();
		if ($res==FALSE){
			$msg = validation_errors();
			$this->load->view('create_account', array('msg' => $msg));
			return FALSE;
		}
		
		$id_user = $this->Account->insertNewUser();
		redirect('AccountCtl/login/'. $id_user);
	}
	
	function createAccount($pesan='')
	{
		$this->load->helper('form');
		$this->load->view('create_account', array('msg' => $pesan));
		
	}
	
	function checkingLogin()
	{
		$this->load->helper(array('url', 'security'));
		$this->load->model('task');
		$this->load->library(array('form_validation'));
		
		$this->form_validation->set_rules('username', 'Username', 'trim|min_length[2]|max_length[128]|xss_clean');
		$this->form_validation->set_rules('katasandi', 'Kata Sandi', 'trim|min_length[2]|max_length[128]|xss_clean');
		
		$res = $this->form_validation->run();
		if ($res==FALSE){
			$msg = validation_errors();
			$this->load->view('login', array('msg' => $msg));
			return FALSE;
		}
		
		$users = $this->Account->getIDUser();
		var_dump($users);
		if(sizeof($users) <= 0){
			$this->load->view('login',array('msg'=>'Username/Password Invalid'));
		}else{
			//ke welcome page
			//$peran=$this->account->getPeranUser($id_user);
			$sess_array = array(
				'id_user'	=> $users[0]['id_user'],
				'nama'		=> $users[0]['nama'],
				'username'	=> $users[0]['username'],
				'id_grup'	=> $users[0]['id_grup'],
				'nama_grup'	=> $users[0]['nama_grup'],
				'currentgrup'	=> $users[0]['nama_grup'],
				'password'	=> $users[0]['password'],
				'photo'	=> $users[0]['photo']
			);
			$this->session->set_userdata('logged_in', $sess_array);
			if ($users[0]['id_grup']==1){
				redirect('EditorCtl');
				//ke welcome page editor
			}elseif ($users[0]['id_grup']==2){
				redirect('ReviewerCtl');
				//ke welcomepage reviewer
			}else{
				redirect('MakelarCtl');
				//kewelcomepage makelaar
			}
			
		}
	}
	
	function logout(){
		if ($this->session->userdata('logged_in')){
			redirect ('welcome/login');
		}
		$session_data = $this->session->userdata('logged_in');
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('welcome');
	}
	function signingup($pesan='')
	{
		$this->load->helper(array('url', 'security'));
		$this->load->model(array('task', 'account'));
		$this->load->library(array('form_validation'));
		
		$this->form_validation->set_rules('nama', 'Nama', 'trim|min_length[2]|max_length[128]|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'trim|min_length[2]|max_length[128]|xss_clean');
		$this->form_validation->set_rules('katasandi', 'Kata Sandi', 'trim|min_length[2]|max_length[128]|xss_clean');
		$this->form_validation->set_rules('email', 'Surel', 'trim|min_length[2]|max_length[128]|xss_clean');
		
		$res = $this->form_validation->run();
		if ($res==FALSE){
			$msg = validation_errors();
			$this->load->view('common/header');
			$this->load->view('signup', array('error' => $msg));
			$this->load->view('common/footer');
			//$this->load->view('create_account', array('msg' => $msg));
			return FALSE;
		}
		
				$config['upload_path']          = './photos/';
                $config['allowed_types']        = 'gif|jpg|jpeg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 300;
                $config['max_height']           = 300;

				//$new_name = time().$_FILES["userfiles"]['name'];
				//$config['file_name'] = $new_name;
				$new_name = $this->input->post('username').$_FILES['userfile']['name'];
				$config['file_name'] = $new_name;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {//gagal
                        $error = array('error' => $this->upload->display_errors());
						$this->load->view('common/header');
						$this->load->view('signup',$error);
						$this->load->view('common/footer');
						return;
                }
                
                //upload
                $data =$this->upload->data();
				$id_user = $this->Account->insertNewUser($data['file_name']);
				$this->load->view('common/header');
				$this->load->view('signup_success');
				$this->load->view('common/footer');
				return;
                
	}
	function profile($msg=''){
		
		if (!$this->session->userdata('logged_in')){
			redirect ('welcome/login');
		}
		$session_data = $this->session->userdata('logged_in');
		$this->load->helper(array('form','url'));
		$this->load->model("account");
		$user=$this->account->getUser($session_data['id_user']);
		$roles=$this->account->getRoles($session_data['id_user']); 
		
		$this->load->model(array("task"));
		$balance=$this->task->getReviewerBalance($session_data['id_user']);
		
		$this->load->view($session_data['nama_grup'].'/header',
							array("nama_user"=>$session_data['nama'],
										"current_role"=>$session_data['nama_grup'],
										"balance"=>$balance,
										"roles"=>$roles));
		$this->load->view('profile',array("error"=>"",
										"msg"=>$msg,
										"user"=>$user[0],
										"roles"=>$roles));
		$this->load->view('common/footer');
	}
	
	function changerole()
	{
		if (!$this->session->userdata('logged_in')) {
		redirect('welcome/login');
		}
		$session_data = $this->session->userdata('logged_in');

		$this->load->helper(array('form', 'url'));
		
		$this->load->model("account");
		$roles = $this->account->getRoles($session_data['id_user']);
		$users = $this->account->getUser($session_data['id_user']);
		//var_dump($session_data['id_grup']);
			//	die;
		if (sizeof($roles)==2){
			if($session_data['id_grup'] == 1){
				$reviewer=2;
				$sess_array = array(
					'id_user'	=> $users[0]['id_user'],
					'nama'		=> $users[0]['nama'],
					'username'	=> $users[0]['username'],
					'id_grup'	=> $reviewer,
					'nama_grup'	=> 'reviewer',
					'currentgrup'	=> 'reviewer',
					'password'	=> $users[0]['password'],
					'photo'	=> $users[0]['photo']
				);
				$this->session->set_userdata('logged_in', $sess_array);
				//var_dump($session_data['id_grup']);
				//die;
				redirect('reviewerCtl');
			}
			if($session_data['id_grup'] == 2){
				$editor=1;
				$sess_array = array(
					'id_user'	=> $users[0]['id_user'],
					'nama'		=> $users[0]['nama'],
					'username'	=> $users[0]['username'],
					'id_grup'	=> $editor,
					'nama_grup'	=> 'editor',
					'currentgrup'	=> 'editor',
					'password'	=> $users[0]['password'],
					'photo'	=> $users[0]['photo']
				);
				$this->session->set_userdata('logged_in', $sess_array);
				//var_dump($session_data['id_grup']);
				//die;
				redirect('reviewerCtl');
				redirect('editorCtl');
			}
		}
		else if (sizeof($roles)==1){
			if($session_data['id_grup'] == 1){
				$reviewer=2;
				$sess_array = array(
					'id_user'	=> $users[0]['id_user'],
					'nama'		=> $users[0]['nama'],
					'username'	=> $users[0]['username'],
					'id_grup'	=> $reviewer,
					'nama_grup'	=> 'reviewer',
					'currentgrup'	=> 'reviewer',
					'password'	=> $users[0]['password'],
					'photo'	=> $users[0]['photo']
				);
				$this->session->set_userdata('logged_in', $sess_array);
				//var_dump($session_data['id_grup']);
				//die;
				redirect('reviewerCtl');
			}
			if($session_data['id_grup'] == 2){
				$editor=1;
				$sess_array = array(
					'id_user'	=> $users[0]['id_user'],
					'nama'		=> $users[0]['nama'],
					'username'	=> $users[0]['username'],
					'id_grup'	=> $editor,
					'nama_grup'	=> 'editor',
					'currentgrup'	=> 'editor',
					'password'	=> $users[0]['password'],
					'photo'	=> $users[0]['photo']
				);
				$this->session->set_userdata('logged_in', $sess_array);
				//var_dump($session_data['id_grup']);
				//die;
				redirect('reviewerCtl');
				redirect('editorCtl');
			}
		}
		
	}

	function changePassword($msg=''){
		if (!$this->session->userdata('logged_in')) {
			redirect('welcome/login');
			}
		$session_data = $this->session->userdata('logged_in');

		$this->load->library(array('form_validation'));
		$this->load->helper(array('form', 'url', 'security'));
		
		$this->load->model(array("Account","task"));
		$user = $this->Account->getUser($session_data['id_user']);
		$roles = $this->Account->getRoles($session_data['id_user']);
		$balance=$this->task->getReviewerBalance($session_data['id_user']);
		$this->load->view(''.$session_data['nama_grup'].'/header', array("nama_user"=>$session_data['nama'],
																		"current_role"=>$session_data['nama_grup'],
																		"balance"=>$balance,
																		"roles" => $roles));
		$this->load->view('changepassword', array("error" => "",
												"msg"=>$msg,
												"user" => $user[0]));
		$this->load->view('common/footer');
		$data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
	}

	public function changeProfile()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('Welcome/login');
		}
		$session_data = $this->session->userdata('logged_in');

		$this->load->library(array('form_validation'));
		$this->load->helper(array('url', 'form', 'security'));
		$this->load->model("Account");

		$user = $this->Account->getUser($session_data['id_user']);
		$roles = $this->Account->getRoles($session_data['id_user']);

		$this->load->model(array("task"));
		$balance=$this->task->getReviewerBalance($session_data['id_user']);
		
		$this->load->view($session_data['nama_grup'].'/header',array("nama_user"=>$session_data['nama'],
																	"current_role"=>$session_data['nama_grup'],
																	"balance"=>$balance,
																	"roles" => $roles));
		$this->load->view('editprofile', array("error" => "",
												"user" => $user[0]));
		$this->load->view('common/footer');
	}

	public function changingProfile()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('Welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');



		$this->load->helper(array('form', 'url', 'security'));
		$this->load->library(array('form_validation'));

		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		if ($this->form_validation->run() == false) {
			redirect('AccountCtl/profile');
		} 
		$nama = $this->input->post('nama');
		$username = $this->input->post('username');
		

			// cek jk ada gambar yang akan di upload
		$this->load->helper(array('form', 'url'));
		//$upload_foto = $_FILES['photo']['name'];

		//if ($upload_foto) {
			$config['upload_path']          = './photos/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['max_size']             = 100;
            $config['max_width']            = 300;
            $config['max_height']           = 300;

			//$new_name = time().$_FILES["userfiles"]['name'];
			//$config['file_name'] = $new_name;
			$new_name = $this->input->post('username').$_FILES['userfile']['name'];
			$config['file_name'] = $new_name;
			

			$this->load->library('upload', $config);
			//jika berhasil upload
			if ($this->upload->do_upload('photo')) {
				$new_photo = $this->upload->data('file_name');
				$this->db->set('photo', $new_photo);
				$this->db->set('nama', $nama);
				$this->db->where('username', $username);
				$this->db->update('users');
				//$_SESSION['photo']=$new_photo;
				$this->load->model('account');
				$users = $this->account->getUser($session_data['id_user']);
				$sess_array = array(
					'id_user'	=> $users[0]['id_user'],
					'nama'		=> $nama,
					'username'	=> $users[0]['username'],
					'id_grup'	=> $users[0]['id_grup'],
					'nama_grup'	=> $users[0]['nama_grup'],
					'currentgrup'	=> $users[0]['nama_grup'],
					'password'	=> $users[0]['password'],
					'photo'	=> $new_photo
				);
				$this->session->set_userdata('logged_in', $sess_array);
				redirect('AccountCtl/profile');
			} else { //jika gagal
				//$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
				redirect('AccountCtl/profile');
			}
		//}
		
		
	}


	public function changingPassword()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('Welcome/index');
		}
		$session_data = $this->session->userdata('logged_in');

		//mengambil dari tabel users dimana username sesuai session data
		$data['users'] = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
		
		$this->load->helper(array('form', 'url', 'security'));
		$this->load->library(array('form_validation'));

		$this->form_validation->set_rules('currentpassword', 'Current Password', 'required|trim');
		$this->form_validation->set_rules('newpassword', 'New Password', 'required|trim|min_length[5]');
		
		//jika form validation salah, kembali ke view changepassword
		if ($this->form_validation->run() == false) {
			$this->load->model(array("Account","task"));
			$balance=$this->task->getReviewerBalance($session_data['id_user']); //ambil saldo
			$user = $this->Account->getUser($session_data['id_user']);
			$roles = $this->Account->getRoles($session_data['id_user']);
			$error = validation_errors();
			$this->load->view(''.$session_data['nama_grup'].'/header', array( "nama_user" => $session_data['nama'],
																			"balance"=>$balance,
																			"current_role" => $session_data['nama_grup']));
			$this->load->view('changepassword', array("error" => $error,
													"user" => $user[0],
													"roles" => $roles));
			$this->load->view('common/footer');
		} 

		//$oldpassword = $this->account->insertNewPassword($session_data['id_user'], $newpassword);
		$currentpassword = $this->input->post('currentpassword');
		//echo $session_data['password'],$currentpassword, md5($currentpassword);
		//die;
		$newpassword=$this->input->post('newpassword');

		//jika current password salah
		if (md5($currentpassword)!=$session_data['password']) { 
			//$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password!</div>');
			$msg = '<div class="alert alert-danger" role="alert">Wrong current password!</div>';
			redirect('AccountCtl/changePassword', array("msg"=>$msg));
		} 
		//berhasil
		$this->load->model("Account");
		$this->Account->insertNewPassword($session_data['id_user'], $newpassword);
		//$this->db->set('password', $newpassword);
		//$this->db->where('username', $this->session->userdata('username'));
		//$this->db->update('users');
		$msg = '<div class="alert alert-success" role="alert">Password Changed!</div>';
		redirect("AccountCtl/profile", array("msg"=>$msg));
	}
}