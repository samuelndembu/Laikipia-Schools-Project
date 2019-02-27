<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Auth_model extends CI_Model
{
    public function validate_user()
    {
        $where = array(
            "user_email" => $this->input->post("user_email"),
            "user_password" => md5($this->input->post("user_password")),
        );
        $this->db->where($where);
        $query = $this->db->get("user_table");

        if ($query->num_rows() == 1) {
            $row = $query->row();
            $user = array(
                "first_name" => $row->user_first_name,
                "last_name" => $row->user_last_name,
                "phone_number" => $row->user_phone_number,
                "user_email" => $row->user_email,
                "id" => $row->user_id,
                "login_status" => true,
            );
            $this->session->set_userdata($user);
            return true;
        } else {
            $this->session->set_flashdata("error", "Email or password is incorrect");
            return false;
        }
    }
    public function get_active_branch()
	{
		$this->db->where('branch_status = 1');
		$this->db->from('branch');
		$query = $this->db->get();
		
		$result = $query->row();

		return $result;
	}
	
	/*
	*	Update personnel's last login date
	*
	*/
	private function update_personnel_login($personnel_id)
	{
		$data['last_login'] = date('Y-m-d H:i:s');
		$this->db->where('personnel_id', $personnel_id);
		if($this->db->update('personnel', $data))
		{
			$session_log_insert = array(
				"personnel_id" => $personnel_id, 
				"session_name_id" => 1
			);
			$table = "ci_sessions";
			if($this->db->insert($table, $session_log_insert))
			{
				return TRUE;
			}
			
			else
			{
				return FALSE;
			}
		}
		
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Reset a personnel's password
	*
	*/
	public function reset_password($personnel_id)
	{
		$new_password = substr(md5(date('Y-m-d H:i:s')), 0, 6);
		
		$data['personnel_password'] = md5($new_password);
		$this->db->where('personnel_id', $personnel_id);
		$this->db->update('personnel', $data); 
		
		return $new_password;
	}
	
	/*
	*	Check if a has logged in
	*
	*/
	public function check_login()
	{
		if($this->session->userdata('login_status'))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}

	public function check_merchant_login()
	{
		if($this->session->userdata('merchant_login_status'))
		{
			// $merchant_last_name = $this->session->userdata("firstName");
			// if(empty($merchant_last_name) || $merchant_last_name == NULL)
			// {
			// 	return FALSE;
			// }
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
}
