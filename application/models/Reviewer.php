<?php
class Reviewer extends CI_Model
{
	function getAllReviewer()
	{
		$thequery = "SELECT t1.nama, t1.email, t1.username,t2.sts_reviewer,t2.id_reviewer,t2.kompetensi
					FROM users t1 JOIN reviewer t2 
					ON t1.id_user=t2.id_user ";
		$res = $this->db->query($thequery);
		return $res->result_array();//kembalikan ke fungsi yang manggil
	}

	function getReviewerCompletedAssignment($id_task=-1, $id_user=-1)
	{
		$thequery = "SELECT t1.id_assignment, t1.id_task, t1.status,t2.sts_reviewer,t2.id_reviewer
					FROM assignment t1 JOIN reviewer t2 
					ON t2.id_user=".$id_user." AND t1.id_task=".$id_task." ";
		$res = $this->db->query($thequery);
		return $res->result_array();//kembalikan ke fungsi yang manggil
	}

}
?>