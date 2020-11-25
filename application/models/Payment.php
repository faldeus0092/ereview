<?php
class Payment extends CI_Model
{

    function getviewpayments($id_assign)
    {
        $q = "SELECT t2.*,t3.id_assign, t3.status,t4.no_rek, t5.nama, t2.price,t3.id_task FROM assignment t3 
			JOIN reviewer t4 ON t4.id_reviewer=t3.id_reviewer
            JOIN users t5 ON t5.id_user=t4.id_user
            JOIN task t2 ON t3.id_task =t2.id_task
            WHERE t3.id_assign=" . $id_assign;
        $res = $this->db->query($q);
        return $res->result_array();
    }

    function getAmount($id_task)
    {
        $q = "SELECT price FROM task 
            WHERE id_task=" . $id_task;
        $res = $this->db->query($q);
        foreach ($res->result_array() as $row) {
            return $row['price'];
        }
    }

    function getPayments($id_assign = -1, $new_name, $amount)
    {
        $thequery = "INSERT INTO pembayaran (amount,bukti, id_assignment, date_updated) 
                VALUES (".$amount.",'".$new_name."',".$id_assign.",now())";
        $this->db->query($thequery);
    }

    function getBukti($id_assignment)
    {
        $thequery = "SELECT bukti FROM pembayaran
        WHERE id_assignment=$id_assignment";
        $res = $this->db->query($thequery);
        return $res->row();
    }

    function getTheAssignmentFile($id_assignment=-1)
	{
		$thequery="SELECT assignment.file_location 
		FROM assignment
		WHERE assignment.id_assignment=$id_assignment AND assignment.status>4";
		$res=$this->db->query($thequery);
		return $res->result_array();
    }
    function editorgetTheAssignmentFile($id_task=-1)
	{
		$thequery="SELECT assignment.file_location 
		FROM assignment
		WHERE assignment.id_task=$id_task AND assignment.status>4";
		$res=$this->db->query($thequery);
		return $res->result_array();
    }
    
    //bayar saldo
    function getSaldo($id_reviewer)
    {
        $q = "SELECT * FROM reviewer
            WHERE id_reviewer=" . $id_reviewer;
        $res = $this->db->query($q);
        foreach ($res->result_array() as $row) {
            return $row['saldo'];
        }
    }
    function getAmountComplete($id_assignment)
    {
        $q = "SELECT * FROM pembayaran
            WHERE id_assignment=" . $id_assignment;
        $res = $this->db->query($q);
        foreach ($res->result_array() as $row) {
            return $row['amount'];
        }
    }
    function confirmPayment($id_reviewer, $amount)
    {
        $thequery = "UPDATE reviewer SET `saldo`=$amount 
         WHERE id_reviewer=" . $id_reviewer;
        $this->db->query($thequery);
    }

    //ambil saldo
    function getBalance($id_user=-1){
        $thequery="SELECT saldo FROM reviewer WHERE id_user=$id_user";
        $res = $this->db->query($thequery);
        return $res->row();
    }

}
