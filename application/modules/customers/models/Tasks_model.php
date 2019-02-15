<?php

class Tasks_model extends CI_Model
{
    /*
     *    Retrieve all sections
     *    @param string $table
     *     @param string $where
     *
     */
    public function get_all_tasks($table, $where, $per_page, $page, $order = 'task.created', $order_method = 'DESC')
    {
        $this->db->select("customers.customer_id, customers.firstName, customers.lastName, customers.username, customers.customer_gender, customers.customer_age, customers.customer_location, customers.customer_access_code, customers.customer_splash_page, customers.customer_autoplay, customers.customer_mpesa, customers.customer_comments, customers.customer_updated_by, customers.customer_updated, task_status.task_status_name, task.*");
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($order, $order_method);
        $query = $this->db->get('', $per_page, $page);

        return $query;
    }

    public function update_status()
    {
        $data = array(
            "task_status_id" => $this->input->post("task_status_id"),
            "modified_by" => $this->session->userdata("personnel_id")
        );

        $this->db->where("task_id", $this->input->post("task_id"));
        if($this->db->update("task", $data))
        {
            return TRUE;
        }

        else
        {
            return FALSE;
        }
    }

    public function update_customer_task()
    {
        $data = array(
            "customer_location" => $this->input->post("customer_location"),
            "customer_gender" => $this->input->post("gender"),
            "customer_age" => $this->input->post("age"),
            "customer_access_code" => $this->input->post("access_code"),
            "customer_splash_page" => $this->input->post("splash_page"),
            "customer_autoplay" => $this->input->post("autoplay"),
            "customer_mpesa" => $this->input->post("mpesa"),
            "customer_comments" => $this->input->post("comments"),
            "customer_updated_by" => $this->session->userdata("personnel_id"),
            "customer_updated" => date("Y-m-d H:i:s")
        );
        $this->db->where("customer_id", $this->input->post("customer_id"));
        if($this->db->update("customers", $data))
        {
            return TRUE;
        }

        else
        {
            return FALSE;
        }
    }

    public function get_completion_status($status_id)
    {
        if($status_id == 1)
        {
            return '<span class="label label-success">Completed</span>';
        }

        else
        {
            return '<span class="label label-danger">Incompleted</span>';
        }
    }
}
