<?php

class Payments_model extends CI_Model 
{	
	/*
	*	Retrieve all sections
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_payments($table, $where, $per_page, $page, $order = 'mpesalipatransaction_id', $order_method = 'DESC')
	{
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	public function get_result_codes()
	{
		$this->db->distinct('resultCode');
		$this->db->select('resultCode');
		$this->db->order_by('resultCode', "ASC");
		$query = $this->db->get("mpesalipatransaction");

		return $query;
	}

	public function get_transaction_codes()
	{
		$this->db->distinct('mpesaReceiptNumber');
		$this->db->select('mpesaReceiptNumber');
		$this->db->order_by('mpesaReceiptNumber', "ASC");
		$query = $this->db->get("mpesalipatransaction");

		return $query;
	}

	public function get_transacted_customers()
	{
		$this->db->distinct('msisdn');
		$this->db->select('msisdn');
		$this->db->order_by('msisdn', "ASC");
		$query = $this->db->get("mpesalipatransaction");

		return $query;
	}

	public function delete_payment($mpesalipatransaction_id)
	{
		$this->db->where("mpesalipatransaction_id", $mpesalipatransaction_id);
		if($this->db->delete("mpesalipatransaction"))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function update_payment_info2()
	{
		//Get all completed payments
		$this->db->where("resultCode", "0");
		$query = $this->db->get("mpesalipatransaction");
		$customers = "";
		
		if($query->num_rows() > 0)
		{
			$customers = "(";
			$count = 0;
			foreach($query->result() as $row)
			{
				$count++;
				$msisdn = "+".$row->msisdn;

				if($count == $query->num_rows())
				{
					$customers .= $msisdn;
				}
				else
				{
					$customers .= $msisdn.", ";
				}
			}
			$customers .= ")";
		}

		// echo $customers; die();

		if(!empty($customers))
		{
			$this->db->where("phone_number NOT IN ".$customers);
			$query = $this->db->get("mpesa_customer_register");

			echo $query->num_rows();
		}
	}

	public function update_payment_info()
	{
		//Get all completed payments
		$this->load->model("merchants/merchants_model");
		$this->db->where("merchant_id != 0");
		$query = $this->db->get("mpesa_customer_register");
		$result = array(
			array(
				"Transaction Id",
				"Merchant Id",
				"Customer Name",
				"Transaction Location",
				"Customer Phone Number",
				"Transaction Date",
				"Transaction Last Modified",
				"Merchant First Name",
				"Merchant Last Name",
				"Merchant Phone Number"
			)
		);
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$phone_number = $row->phone_number;

				// $number = ltrim($phone_number, '+');
				// $this->db->where(array("resultCode" => "0", "msisdn" => $number));
				// $query = $this->db->get("mpesalipatransaction");
				
				// if($query->num_rows() == 0)

				if($this->merchants_model->check_transaction($phone_number) == FALSE)
				{
					// echo $phone_number."<br/>";
					$mpesa_customer_register_id = $row->mpesa_customer_register_id;
					$merchant_id = $row->merchant_id;
					$full_name = $row->full_name;
					$merchant_location = $row->merchant_location;
					$phone_number = $row->phone_number;
					$created_at = $row->created_at;
					$last_modified = $row->last_modified;
					$agent_firstName = $row->agent_firstName;
					$agent_lastName = $row->agent_lastName;
					$agent_phoneNumber = $row->agent_phoneNumber;

					$customer = array(
						$mpesa_customer_register_id,
						$merchant_id,
						$full_name,
						$merchant_location,
						$phone_number,
						$created_at,
						$last_modified,
						$agent_firstName,
						$agent_lastName,
						$agent_phoneNumber
					);
					
					// $data = json_decode(json_encode($row), TRUE);
					array_push($result, $customer);
				}
			}
		}
		$title = date("Y-m-d H:i:s")." Unverified Customers";
		$this->site_model->exports_data($result, $title);
	}
}
?>