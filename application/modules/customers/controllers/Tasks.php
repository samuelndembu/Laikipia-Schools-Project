<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/Admin.php";

class Tasks extends admin 
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model("customers/tasks_model");
		$this->load->model("customers/customers_model");
    }
    
	/*
	*
	*	Default action is to show all the tasks
	*
	*/
	public function index($order = 'task.created', $order_method = 'ASC') 
	{
        $personnel_id = $this->session->userdata("personnel_id");

        if($personnel_id > 0)
        {
            $where = 'task.customer_id = customers.customer_id AND task.task_status_id = task_status.task_status_id AND task.personnel_id = '.$personnel_id;
        }

        else
        {
            $where = 'task.customer_id = customers.customer_id AND task.task_status_id = task_status.task_status_id';
        }
        $table = 'task, customers, task_status';
        $tasks_search = $this->session->userdata('tasks_search');
		$search_title = $this->session->userdata('tasks_search_title');
        // var_dump($tasks_search); die();
		if(!empty($tasks_search) && $tasks_search != NULL)
		{
			$where .= $tasks_search;
		}
        // echo $where; die();
		//pagination
		$segment = 5;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'customers/tasks/'.$order.'/'.$order_method;
		$config['total_rows'] = $this->site_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->tasks_model->get_all_tasks($table, $where, $config["per_page"], $page, $order, $order_method);
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
		$data['title'] = 'My Tasks';

		if(!empty($search_title) && $search_title != NULL)
		{
			$data['title'] = 'My tasks filtered by '.$search_title;
		}
		$v_data['title'] = $data['title'];
		
		$v_data['order'] = $order;
		$v_data['order_method'] = $order_method;
		$v_data['query'] = $query;
		$v_data['task_assignees'] = $this->customers_model->get_task_assignees();
		$v_data['task_statuses'] = $this->customers_model->get_task_statuses();
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('all_tasks', $v_data, true);
		
		$this->load->view('admin/layout/home', $data);
    }
    
	public function search_tasks()
	{
		$customer_phone = $this->input->post('customer_phone');
		$task_status = $this->input->post('task_status');
		$daterange = $this->input->post('daterange');
		$search_title = '';
		
		if(!empty($customer_phone))
		{
            $customer_phone = $this->customers_model->clean_phone($customer_phone);
			$search_title .= ' Customer Phone <strong>'.$customer_phone.'</strong>';
			$customer_phone = ' AND customers.username = \''.$customer_phone.'\'';
		}
		
		if(!empty($task_status))
		{
            $status_array = explode("|", $task_status);
            $task_status_id = $status_array[0];
            $task_status_name = $status_array[1];
			$search_title .= ' Task Status <strong>'.$task_status_name.'</strong>';
			$task_status = ' AND task.task_status_id = \''.$task_status_id.'\'';
		}
		
		if(!empty($daterange))
		{
			$date_array = explode("-", $daterange);
			if(count($date_array) == 2)
			{
				$start_date = date("Y-m-d", strtotime($date_array[0]));
				$end_date = date("Y-m-d", strtotime($date_array[1]));

                $search_title .= ' Date <strong>'.$daterange.'</strong>';
                
                if($start_date == $end_date)
                {
                    $daterange = ' AND task.created LIKE \''.$start_date.'%\'';
                }

                else
                {
                    $daterange = ' AND (task.created >= \''.$start_date.'\' AND task.created <= \''.$end_date.'\')';
                }
			}
		}
		
		$search = $customer_phone.$daterange.$task_status;
		// var_dump($search); die();
		$this->session->set_userdata('tasks_search', $search);
        $this->session->set_userdata('tasks_search_title', $search_title);
        $sch = $this->session->userdata('tasks_search');
		// var_dump($sch); die();
		redirect("customers/tasks");
	}
	
	public function close_tasks_search()
	{
		$this->session->unset_userdata('tasks_search');
		$this->session->unset_userdata('tasks_search_title');
		
		redirect("customers/tasks");
    }
    
    public function export_tasks()
    {
		$order = 'tasks.inserted';
		$order_method = 'DESC';
		$where = 'tasks.task_id > 0';
		$table = 'tasks';
		$tasks_search = $this->session->userdata('tasks_search');
		$search_title = $this->session->userdata('tasks_search_title');

		if(!empty($tasks_search) && $tasks_search != NULL)
		{
			$where .= $tasks_search;
		}
		$title = 'Tasks';

		if(!empty($search_title) && $search_title != NULL)
		{
			$title = 'Tasks filtered by '.$search_title;
		}
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($order, $order_method);
        $this->db->join("task", "task.task_id = tasks.task_id", "left");
        $this->db->join("task_status", "task.task_status_id = task_status.task_status_id", "left");
        $query = $this->db->get();
		
		if($this->site_model->exports_data($query->result(), $title))
		{
		}
		
		else
		{
			$this->session->set_userdata('error_message', "Unable to export results");
		}
    }

    public function update_status()
    {
        $this->form_validation->set_rules('task_id', 'Task', 'required');
        $this->form_validation->set_rules('task_status_id', 'Status', 'required');

        if ($this->form_validation->run()) 
        {
            if($this->tasks_model->update_status())
            {
                $this->session->set_userdata('success_message', 'Task updated successfully');
            }

            else
            {
                $this->session->set_userdata('error_message', 'Unable to update task');
            }
        } 
        
        else 
        {
            $validation_errors = validation_errors();
            if (!empty($validation_errors)) {
                $this->session->set_userdata('error_message', $validation_errors);
            }
        }
        redirect("customers/tasks");
    }

    public function update_customer_task()
    {
        $this->form_validation->set_rules('customer_id', 'Customer', 'required');
        $this->form_validation->set_rules('task_id', 'Task', 'required');
        $this->form_validation->set_rules('customer_location', 'Location', '');
        $this->form_validation->set_rules('access_code', 'Access Code', '');
        $this->form_validation->set_rules('splash_page', 'Splash Page', '');
        $this->form_validation->set_rules('autoplay', 'Autoplay', '');
        $this->form_validation->set_rules('mpesa', 'M-Pesa Training', '');
        $this->form_validation->set_rules('comments', 'Comments', '');

        if ($this->form_validation->run()) 
        {
            if($this->tasks_model->update_customer_task())
            {
                if($this->tasks_model->update_status())
                {
                    $this->session->set_userdata('success_message', 'Customer updated successfully');
                }

                else
                {
                    $this->session->set_userdata('error_message', 'Unable to update task status');
                }
            }

            else
            {
                $this->session->set_userdata('error_message', 'Unable to update customer');
            }
        } 
        
        else 
        {
            $validation_errors = validation_errors();
            if (!empty($validation_errors)) {
                $this->session->set_userdata('error_message', $validation_errors);
            }
        }
        redirect("customers/tasks");
    }
}