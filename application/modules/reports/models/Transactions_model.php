<?php

class Transactions_model extends CI_Model 
{	
	/*
	*	Retrieve all sections
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_transactions($table, $where, $per_page, $page, $order = 'created_at', $order_method = 'DESC')
	{
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	public function update_merchant_info($per_page, $page)
	{
		$this->db->select("agents.firstName, agents.lastName, agents.cell, mpesa_customer_register.mpesa_customer_register_id");
		$this->db->where("mpesa_customer_register.merchant_id > 0 AND agents.id = mpesa_customer_register.merchant_id");
		$this->db->order_by("created_at", "DESC");
		$query = $this->db->get("mpesa_customer_register, agents");

		if($query->num_rows() > 0)
		{
			foreach($query->result() as $res)
			{
				$mpesa_customer_register_id = $res->mpesa_customer_register_id;

				$data = array(
					"agent_firstName" => $res->firstName,
					"agent_lastName" => $res->lastName,
					"agent_phoneNumber" => $res->cell,
				);

				$this->db->where("mpesa_customer_register_id", $mpesa_customer_register_id);
				$this->db->update("mpesa_customer_register", $data);
			}
		}
	}

	public function get_transacted_agents()
	{
		$this->db->distinct('agent_phoneNumber');
		$this->db->select('agent_phoneNumber, agent_firstName, agent_lastName');
		$this->db->order_by('agent_phoneNumber', "ASC");
		$this->db->order_by('agent_firstName', "ASC");
		$this->db->order_by('agent_lastName', "ASC");
		$query = $this->db->get("mpesa_customer_register");

		return $query;
	}

	public function get_transacted_locations()
	{
		$this->db->distinct();
		$this->db->select('merchant_location');
		$this->db->order_by('merchant_location', "ASC");
		$query = $this->db->get("mpesa_customer_register");

		return $query;
	}

	public function delete_transaction($mpesa_customer_register_id)
	{
		$this->db->where("mpesa_customer_register_id", $mpesa_customer_register_id);
		if($this->db->delete("mpesa_customer_register"))
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