<?php
class Task extends CI_Model
{
	function insertNewTask_2()
	{
		$thequery = "INSERT INTO task (judul,katakunci) 
					VALUES ('".$this->input->post('judul')."', 
					'".$this->input->post('katakunci')."')";
		$this->db->query($thequery);
		return $this->db->insert_id();
	}

	function insertNewTask($id_user=0,$filename='')
	{
		$this->db->set("judul",$this->input->post('judul'));
		$this->db->set("katakunci",$this->input->post('katakunci'));
		$this->db->set("authors",$this->input->post('authors'));
		$this->db->set("page",$this->input->post('page'));
		$this->db->set("file_location",$filename);
		$this->db->set("id_user",$id_user);
		//$this->db->set("id_editor",$id_editor);

		$this->db->insert("task");
		
		return $this->db->insert_id();
	}
	
	function getTheTask($id_task=-1)
	{
		//select * = semua diambil, di mana id tasknya=//
		$thequery = "SELECT*FROM task WHERE id_task=".$id_task;
		$res=$this->db->query($thequery);
		return $res->result_array();
	}
	
	function getTheAssignment($id_task=-1, $id_reviewer=-1)
	{
		//select * = semua diambil, di mana id tasknya=//
		//$id_task = "SELECT t1.id_task FROM task t1 JOIN users t2 ON t1.id_user=t2.id_user";
		//$id_reviewer = "SELECT t3.id_reviewer FROM reviewer t3 JOIN users t2 ON t3.id_user=t2.id_user";
		//$q1="SELECT t1.id_task, t3.id_reviewer 
		//	FROM task t1, reviewer t3 JOIN users t2 
		//	WHERE t1.id_user=t2.id_user AND t3.id_user=t2.id_user ";
		$thequery = "INSERT INTO assignment (id_task,id_reviewer) 
					VALUES ('".$id_task."','".$id_reviewer."')";
		$this->db->query($thequery);
		//$thequery = "INSERT INTO assignment(id_task) 
		//VALUES ('".$id_task."')";
		//$this->db->insert('assignment',$thequery);
		//$res=$thequery->result_array();
		//$data['query']=$results;
		//return $this->db->insert_id();
	}

	function getMyTask($id_user=-1)
	{
		//$thequery="SELECT t1.*, t2.id_task, t2.status, t3.id_user
		//FROM task t1
		//JOIN editor t3 ON t1.id_editor = t3.id_editor 
		//JOIN assignment t2 ON t2.status = 2 AND t3.id_user = 10";
		//$thequery="SELECT t1.*, t2.status FROM task t1, assignment t2
		//			WHERE t1.id_user=".$id_user." AND t1.sts_task=1";

		$thequery="SELECT task.id_task, task.judul, task.katakunci, task.file_location, task.page, task.status, task.date_created 
		FROM task
		WHERE task.id_user=".$id_user."";
		//$this->db->where("id_user", $id_user);
		//$this->db->where("id_editor", $id_editor);
		//$this->db->where("sts_task", 1);
		//$res=$this->db->get("task");
		$res=$this->db->query($thequery);

		//select * = semua diambil, di mana id tasknya=//
		//$thequery = "SELECT*FROM task WHERE id_task=.$id_task";
		//$this->db->query($thequery);
		return $res->result_array();
	}

	function getTaskPage($id_task=-1)
	{
		$thequery="SELECT task.page 
		FROM task
		WHERE task.id_task=".$id_task."";
		$res=$this->db->query($thequery);
		return $res->row();
	}

	

	function getIDAssignmentdanReviewer($id_task=-1)
	{
		$thequery="SELECT t1.id_assignment, t1.id_reviewer, t2.judul, t2.page, t2.id_task, 
		t2.authors, t3.nama, t3.no_rek, t3.saldo 
		FROM assignment t1 JOIN task t2 ON t1.id_task=$id_task AND t2.id_task=$id_task 
		JOIN reviewer t3 ON t3.id_reviewer=t1.id_reviewer ";
		$res=$this->db->query($thequery);
		return $res->result_array();
	}

	/*function getIDassignment($id_task=-1){
		$thequery="SELECT id_assignment FROM assignment WHERE id_task=44";
		$res=$this->db->query($thequery);
		return $res->row();
	}*/

	function getReviewerAssignment($id_user=-1)
	{
		//select * = semua diambil, di mana id tasknya=//
		//$id_task = "SELECT t1.id_task FROM task t1 JOIN users t2 ON t1.id_user=t2.id_user";
		//$id_reviewer = "SELECT t3.id_reviewer FROM reviewer t3 JOIN users t2 ON t3.id_user=t2.id_user";
		//$q1="SELECT t1.id_task, t3.id_reviewer 
		//	FROM task t1, reviewer t3 JOIN users t2 
		//	WHERE t1.id_user=t2.id_user AND t3.id_user=t2.id_user ";
		//nama editor, judul task, author task, dan id assignment
		//$q1="SELECT t1.id_reviewer FROM reviewer t1 WHERE t1.id_user=".$id_user;
		$thequery="SELECT t1.id_reviewer, t2.id_reviewer, t2.status, t2.id_assignment, t2.tgl_deadline, t3.*  
					FROM reviewer t1 ,assignment t2, task t3 WHERE t3.id_task=t2.id_task  
					AND t2.id_reviewer=(SELECT t1.id_reviewer WHERE t1.id_user=".$id_user.")";
		/*$thequery = "SELECT t1.id_user, t2.id_reviewer, t2.status, t3.*  
					FROM (SELECT*FROM reviewer t0) t1
					INNER JOIN assignment t2 ON t1.id_reviewer=t2.id_reviewer
					INNER JOIN task t3 ON t2.id_task WHERE t1.id_user=".$id_user;*/

		$res=$this->db->query($thequery);
		return $res->result_array();
		//$thequery = "INSERT INTO assignment(id_task) 
		//VALUES ('".$id_task."')";
		//$this->db->insert('assignment',$thequery);
		//$res=$thequery->result_array();
		//$data['query']=$results;
		//return $this->db->insert_id();
	}

	function getviewmakelar($status)
   { 
      $thequery = "SELECT t1.*, t2.id_reviewer, t2.status, t3.judul, t3.katakunci, t3.file_location, t3.id_task, t3.page FROM reviewer t1 
      JOIN assignment t2 ON t1.id_reviewer=t2.id_reviewer 
      JOIN task t3 ON t2.id_task = t3.id_task 
      WHERE t2.status = ". $status;
      $res = $this->db->query($thequery);
      return $res->result_array();
   }

   function getviewmakelar2($status)
   {
		$thequery = "SELECT t1.*, t2.id_reviewer, t2.status, t2.file_location, t2.id_assignment, t4.bukti, t3.judul, t3.katakunci, t3.id_task, t3.page FROM reviewer t1 
		JOIN assignment t2 ON t1.id_reviewer=t2.id_reviewer 
		JOIN task t3 ON t2.id_task = t3.id_task 
		JOIN pembayaran t4 ON t2.id_assignment=t4.id_assignment
		WHERE t2.status = ". $status;
		$res = $this->db->query($thequery);
		return $res->result_array();
   }
   function getReviewerBalance($id_user=-1)
   {
		$thequery = "SELECT saldo FROM reviewer WHERE id_user=$id_user";
		$res = $this->db->query($thequery);
		return $res->result_array();
   }

	/*function getIDassignment($id_task=-1){
		$thequery="SELECT t1.status  
					FROM assignment t1 ,task t2, WHERE t1.id_task=".$id_task."";
		$res=$this->db->query($thequery);
		return $res->result_array();
	}/*
	/*function getRequest($status, $id_user = -1)
   {
      $thequery = "SELECT t1.id_user, t2.id_reviewer, t2.status, t3.*, t4.nama_status FROM reviewer t1 
         	JOIN assignment t2 ON t1.id_reviewer=t2.id_reviewer 
         	JOIN task t3 ON t2.id_task = t3.id_task JOIN progress t4 on t2.status=t4.status WHERE t2.status = $status AND t1.id_user =" . $id_user;
      $res = $this->db->query($thequery);
      return $res->result_array();
   }*/

}
?>