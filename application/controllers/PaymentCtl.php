<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PaymentCtl extends CI_Controller
{
    function payPayment($id_assignment=-1, $id_reviewer=-1, $id_task=-1, $amount=-1)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('welcome/index');
        }
        $session_data = $this->session->userdata('logged_in');

        if ($session_data['nama_grup'] != 'editor') {
            redirect('welcome/redirecting');
        }
        $this->load->helper(array('form', 'url', 'security'));
        $this->load->model('task');
        $this->load->library(array('form_validation'));

        $config['upload_path']          = '../../ereview/berkas/bukti/';
        $config['allowed_types']        = 'jpg|png|pdf|jpeg';
        $config['max_size']             = 2048;
        //		$config['max_width']            = 150;
        //		$config['max_height']           = 200;

        $new_name = time()."_".$_FILES["userfile"]['name'];
		$new_name = str_replace(" ", "_", $new_name);;
        $config['file_name'] = $new_name;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {   //gagal upload
            $msg = array('error' => $this->upload->display_errors());
			$this->load->view('editor/header', array("nama_user"=>$session_data['nama'],
					            "current_role"=>$session_data['nama_grup']));
					//$this->load->view('common/topmenu');
			$this->load->view('editor/add_task',$msg);
			$this->load->view('common/footer');
			return;
        }
        //upload
        $data = array('upload_data' => $this->upload->data());

        $this->load->model(array('payment'));
        //set menjadi waiting for confirmation
        $status = 5;
        $this->db->set('status', $status);
        $this->db->where('id_task', $id_task);
		$this->db->update('assignment');

		$this->db->set('status', $status);
        $this->db->where('id_task', $id_task);
        $this->db->update('task');
        
        //masukkan ke tabel payment
        $tasks = $this->payment->getPayments($id_assignment, $new_name, $amount);
        $this->load->view('editor/header', array("nama_user" => $session_data['nama'],
                                                "current_role" => $session_data['nama_grup']));
        $this->load->view('editor/payment_success', array("tasks" => $tasks));
        //$this->load->view('common/content');
        $this->load->view('common/footer');
    }

    function withdrawFunds(){
        if (!$this->session->userdata('logged_in')) {
            redirect('welcome/index');
        }
        $session_data = $this->session->userdata('logged_in');

        if ($session_data['nama_grup'] != 'reviewer') {
            redirect('welcome/redirecting');
        }
       
        $this->load->helper(array('form', 'url', 'security'));
		$this->load->library(array('form_validation'));

		//$this->form_validation->set_rules('withdraw', 'Withdraw Amount', 'required|trim');
		$this->load->model('task');
        $withdraw = $this->input->post('withdraw');
        $balance=$this->task->getReviewerBalance($session_data['id_user']); //ambil saldo
        //jika kebanyakan ambil
        if ($withdraw>$balance[0]['saldo']){
		    $balance=$this->task->getReviewerBalance($session_data['id_user']);
		    $this->load->model("account");
		    $roles = $this->account->getRoles($session_data['id_user']);
            $msg = '<div class="alert alert-danger" role="alert">Balance not Enough!</div>';
            $this->load->view('reviewer/header', array("nama_user"=>$session_data['nama'],
											"current_role"=>$session_data['nama_grup'],
											"balance"=>$balance,
											"roles"=>$roles,
											"msg"=>$msg));
            $this->load->view('reviewer/view_balance',array("balance"=>$balance, 
                                                            "id_user"=>$session_data['id_user'],
                                                            "msg"=>$msg));
            $this->load->view('common/footer');
			return FALSE;
        }
        $change=$balance[0]['saldo']-$withdraw;
        //var_dump($change);
        //die;
		// cek jk ada gambar yang akan di upload
		/*$this->load->helper(array('form', 'url'));
		$upload_foto = $_FILES['photo']['name'];

			if ($upload_foto) {
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '2048';
				$config['upload_path'] = './photos/';

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('photo')) {

					$old_photo = $data['username']['photo'];
					if ($old_photo != 'default.jpg') {
						unlink(FCPATH . 'photos/' . $old_photo);
					}
					$new_photo = $this->upload->data('file_name');
					$this->db->set('photo', $new_photo);
				} else {
					//$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
					redirect('AccountCtl/profile');
				}
            }*/
        
		$this->db->set('saldo', $change);
		$this->db->where('id_user', $session_data['id_user']);
		$this->db->update('reviewer');

		//$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akun telah berhasil diperbaharui </div>');
		redirect('reviewerCtl/viewBalance');
    }
}
