<?php
class Account extends CI_Model
{
	function insertNewUser($photo)
	{
		//membuat record baru di tabel user
		$thequery = "INSERT INTO users (nama,username,password,email,photo)VALUES (
		'".$this->input->post('nama')."',
		'".$this->input->post('username')."',
		MD5(
			'".$this->input->post('katasandi')."'
			),
		'".$this->input->post('email')."',
		'".$photo."'
		)";
		$this->db->query($thequery);
		$id_user = $this->db->insert_id();
		
		//return $this->db->insert_id();
		$roles = $this->input->post('roles');
		foreach($roles as $item){
			$peran = $item;
			if ($peran=='1'){//editor
				$thequery2 = "INSERT INTO editor (nama, id_user, date_updated) 
				VALUES ('".$this->input->post('nama')."',". $id_user .", now())";
				$this->db->query($thequery2);
				
				$thequery3 = "INSERT INTO member (id_user, id_grup, date_updated) 
				VALUES (". $id_user .", ". $peran.", now())";
				$this->db->query($thequery3);
			}else if ($peran=='2'){//reviewer
				$thequery2 = "INSERT INTO reviewer (nama, id_user, date_updated, no_rek, kompetensi) 
				VALUES ('".$this->input->post('nama')."',". $id_user .", now(),'".$this->input->post('no_rek')."','".$this->input->post('kompetensi')."')";
				$this->db->query($thequery2);
				
				$thequery3 = "INSERT INTO member (id_user, id_grup, date_updated) 
				VALUES (". $id_user .", ". $peran.", now())";
				$this->db->query($thequery3);
			}else{
				$thequery2 = "INSERT INTO makelar (nama, id_user, date_updated) 
				VALUES ('".$this->input->post('nama')."',". $id_user .", now())";
				$this->db->query($thequery2);
				
				$thequery3 = "INSERT INTO member (id_user, id_grup, date_updated) 
				VALUES (". $id_user .", ".$peran.", now())";
				$this->db->query($thequery3);
			}
		}

		//membuat record baru di reviewer/editor
		
		return $id_user;
	}
	/*function insertNewUserss()
	{
		//membuat record baru di tabel user
		$thequery = "INSERT INTO users (nama,username,password,email)VALUES (
		'".$this->input->post('nama')."',
		'".$this->input->post('username')."',
		'".$this->input->post('password')."',
		'".$this->input->post('email')."'
		)";
		$this->db->query($thequery);
		$id_user = $this->db->insert_id();
		
		//return $this->db->insert_id();
		$roles = $this->input->post('roles');
		foreach($roles as $item){
			
		}

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
	}*/
	function getIDUser()
    {
        /*$thequery = "SELECT * FROM users WHERE username='". $this->input->post('username')."',"."password='".$this->input->post("sandi")."'";
        $res = $this->db->query($thequery);
        $users = $res->result_array();
        //cek jika users berisi 1 atau lebih kembalikan id user

        //kalau tidak, kembalikan nilai -1
		return -1;*/
		$thequery = 
		"SELECT t1.*, t3.id_grup, t3.nama_grup FROM ( SELECT * FROM users t0 
		WHERE t0.username='". $this->input->post('username') ."'
		AND t0.password=MD5('". $this->input->post('katasandi') ."')
		AND t0.sts_user=1) t1
		INNER JOIN member t2 ON t1.id_user=t2.id_user AND t2.sts_member=1
		INNER JOIN grup t3 ON t2.id_grup=t3.id_grup AND t3.sts_grup=1";
		$res = $this->db->query($thequery);
		$users = $res->result_array();

		if (count($users)>0) {
			return $users;
		}
		return [];
    }
	function getPeranUser($id_user=-1)
    {
        $thequery = "SELECT * FROM member WHERE id_user=" . $id_user;
        $res = $this->db->query($thequery);
        $peran = $res->result_array();
        return $peran[0]['id_grup'];
	}
	function getRoles($id_user=-1)
    {
        $thequery = "SELECT t1.*, t2.nama_grup FROM (SELECT t0.* FROM member t0
									 WHERE t0.sts_member=1 AND t0.id_user=" . $id_user.")t1
					INNER JOIN grup t2 ON t1.id_grup=t2.id_grup AND t2.sts_grup=1";
        $res = $this->db->query($thequery);
        return $res->result_array();

	}
	function getUser($id_user=-1)
    {
        /*$thequery = "SELECT * FROM users WHERE username='". $this->input->post('username')."',"."password='".$this->input->post("sandi")."'";
        $res = $this->db->query($thequery);
        $users = $res->result_array();
        //cek jika users berisi 1 atau lebih kembalikan id user

        //kalau tidak, kembalikan nilai -1
		return -1;*/
		$thequery = "SELECT t1.*, t3.id_grup, t3.nama_grup FROM ( SELECT * FROM users t0 
					WHERE t0.id_user=". $id_user ."
						AND t0.sts_user=1) t1
					INNER JOIN member t2 ON t1.id_user=t2.id_user AND t2.sts_member=1
					INNER JOIN grup t3 ON t2.id_grup=t3.id_grup AND t3.sts_grup=1";
		$res = $this->db->query($thequery);
		return $res->result_array();
	}

	function changePassword($newpassword=-1, $id_user=-1){
		$thequery="UPDATE users SET 'password' = MD5($newpassword) WHERE users.id_user = ".$id_user."";
	}

	function insertNewPassword($id_user=-1, $newpassword=NULL){
		$thequery="UPDATE users SET `password` = MD5('".$newpassword."') WHERE users.id_user = ".$id_user."";
		$this->db->query($thequery);
	}

	function getUserPassword($id_user=-1){
		$thequery = "SELECT `password` FROM users WHERE id_user=" . $id_user;
        $res = $this->db->query($thequery);
        return $res->row();
	}
}
?>