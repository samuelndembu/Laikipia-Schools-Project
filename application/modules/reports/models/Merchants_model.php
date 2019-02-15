<?php

class Merchants_model extends CI_Model 
{	
	/*
	*	Retrieve all sections
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_merchants($table, $where, $per_page, $page, $order = 'created_at', $order_method = 'DESC')
	{
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	public function get_registered_merchants()
	{
		$this->db->order_by('cell', "ASC");
		$query = $this->db->get("agents");

		return $query;
	}

	public function reset_merchant_password($agent_id)
	{
		$this->db->where("agent_id", $agent_id);
		if($this->db->update("agents", array("agent_password" => md5(123456))))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
?>