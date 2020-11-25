<?php
class User extends CI_Model
{
	function insertNewUser()
	{
		//membuat record baru di tabel user
		$thequery = "INSERT INTO task (nama,username,password,email) 
		VALUES ('".$this->input->post('nama')."',
		'".$this->input->post('username')."'
		'".$this->input->post('katasandi')."'
		'".$this->input->post('email')."')";
		$this->db->query($thequery);
		return $this->db->insert_id();
		
		//membuat record baru di reviewer/editor
		$peran = $this->input->post('peran');
		if ($peran=='1'){
			$thequery2 = "INSERT INTO editor (id_user, date_updated) 
			VALUES (". $id_user .", now())";
			$this->db->query($thequery2);
			
			$thequery3 = "INSERT INTO member (id_user, id_grup, date_updated) 
			VALUES (". $id_user .", ". $peran.", now())";
			$this->db->query($thequery3);
		}else{
			$thequery2 = "INSERT INTO reviewer (id_reviewer, date_updated) 
			VALUES (". $id_user .", now())";
			$this->db->query($thequery2);
			
			$thequery3 = "INSERT INTO member (id_user, id_grup, date_updated) 
			VALUES (". $id_user .", ". $peran.", now())";
			$this->db->query($thequery3);
		}
		return $id_user;
	}
	function getIDUser()
    {
        $thequery = "SELECT * FROM users WHERE username='". $this->input->post('username')."',"."password='".$this->input->post("sandi")."'";
        $res = $this->db->query($thequery);
        $users = $res->result_array();
        //cek jika users berisi 1 atau lebih kembalikan id user

        //kalau tidak, kembalikan nilai -1
        return -1;
    }
	function getPeranUser($id_user=-1)
    {
        $thequery = "SELECT * FROM member WHERE id_user=" . $id_user;
        $res = $this->db->query($thequery);
        $peran = $res->result_array();
        $peran[0]['id_grup'];
	}
}
?>