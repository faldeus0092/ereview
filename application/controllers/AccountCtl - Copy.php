<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AccountCtl extends CI_Controller {

	function AccountCtl()
	{
		parent::__construct();
		$this->load->model(array('Account'));
	}
	
	function login($pesan='')
	{
		$this->load->view('login',array('msg'=>$pesan));
	}
	
	function creatingAccount($pesan='')
	{
		$this->load->helper(array('url', 'security'));
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
		
		$id_user = $this->user->insertNewTask();
		redirect('accountctl/login'. $id_user);
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
		
		$id_user = $this->user->getIDUser();
		
		if($id_user==-1){
			//kembali login
		}else{
			//ke welcome page
			$peran=$this->account->getPeranUser($id_user);
			if ($peran==1){
				redirect('editorct1/welcome_page'. $id_user);
				//ke welcome page editor
			}elseif ($peran==2){
				redirect('reviewerct1/welcome_page'. $id_user);
				//ke welcomepage reviewer
			}else{
				redirect('ct1/welcome_page'. $id_user);
				//kewelcomepage makelaar
			}
			
		}
		redirect('accountctl/login'. $id_user);
	}
	
	function index()
	{
		$this->load->view('create_account');
	}
}