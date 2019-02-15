<?php

class Customers_model extends CI_Model
{
    public function count_items($table, $where)
	{
		$this->db->from($table);
		$this->db->where($where);
        $this->db->join("task", "task.customer_id = customers.customer_id", "left");
        $this->db->join("task_status", "task.task_status_id = task_status.task_status_id", "left");
		return $this->db->count_all_results();
    }
    
    /*
     *    Retrieve all sections
     *    @param string $table
     *     @param string $where
     *
     */
    public function get_all_customers($table, $where, $per_page, $page, $order = 'inserted', $order_method = 'DESC')
    {
        $this->db->select("customers.*, task_status.task_status_name, task.personnel_id AS task_assignee");
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($order, $order_method);
        $this->db->join("task", "task.customer_id = customers.customer_id", "left");
        $this->db->join("task_status", "task.task_status_id = task_status.task_status_id", "left");
        $query = $this->db->get('', $per_page, $page);

        return $query;
    }

	public function get_raw_customers()
	{
		$this->db->order_by('username', "ASC");
		$query = $this->db->get("customers");

		return $query;
	}

	public function get_task_statuses()
	{
		$this->db->order_by('task_status_name', "ASC");
		$query = $this->db->get("task_status");

		return $query;
	}

	public function get_distinct_cities()
	{
		$this->db->distinct('city');
		$this->db->select('city');
		$this->db->order_by('city', "ASC");
		$query = $this->db->get("customers");

		return $query;
    }
    
    public function clean_phone($phone_number)
    {
        if ($phone_number[1] == 2 && $phone_number[2] == 5 && $phone_number[3] == 4) {
            $validated_number = $phone_number;
        } else {
            $validated_number = $phone_number[0] == 0 ? "+254" . substr($phone_number, 1, 9) : ($phone_number[0] == 7 ? "+254" . $phone_number : ($phone_number[0] == 2 && $phone_number[1] == 5 && $phone_number[2] == 4 ? "+" . $phone_number : $phone_number));
        }

        return $validated_number;
    }

	public function get_task_assignees()
	{
        $this->db->where("personnel.personnel_status = 1 AND personnel.personnel_id = personnel_section.personnel_id AND personnel_section.section_id = section.section_id AND section.section_name = 'Tasks'");
		$this->db->order_by('personnel_fname', "ASC");
		$query = $this->db->get("personnel, personnel_section, section");

		return $query;
    }
    
    public function assign_customer()
    {
        $data = array(
            "customer_id" => $this->input->post("customer_id"),
            "personnel_id" => $this->input->post("personnel_id"),
            "task_status_id" => 1,
            "created" => date("Y-m-d H:i:s"),
            "created_by" => $this->session->userdata("personnel_id"),
            "modified_by" => $this->session->userdata("personnel_id"),
        );

        if($this->db->insert("task", $data))
        {
            return TRUE;
        }

        else
        {
            return FALSE;
        }
    }
}
