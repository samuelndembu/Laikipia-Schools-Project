<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/Admin.php";

class Customers extends admin 
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model("customers/customers_model");
		$this->load->model("customers/tasks_model");
    }
    
	/*
	*
	*	Default action is to show all the customers
	*
	*/
	public function index($order = 'customers.inserted', $order_method = 'DESC') 
	{
		$where = 'customers.customer_id > 0';
		$table = 'customers';
		$customers_search = $this->session->userdata('customers_search');
		$search_title = $this->session->userdata('customers_search_title');

		if(!empty($customers_search) && $customers_search != NULL)
		{
			$where .= $customers_search;
		}

		//pagination
		$segment = 5;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'customers/all-customers/'.$order.'/'.$order_method;
		$config['total_rows'] = $this->customers_model->count_items($table, $where);
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
		$query = $this->customers_model->get_all_customers($table, $where, $config["per_page"], $page, $order, $order_method);
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
		$data['title'] = 'Customers';

		if(!empty($search_title) && $search_title != NULL)
		{
			$data['title'] = 'Customers filtered by '.$search_title;
		}
		$v_data['title'] = $data['title'];
		
		$v_data['order'] = $order;
		$v_data['order_method'] = $order_method;
		$v_data['query'] = $query;
		$v_data['task_assignees'] = $this->customers_model->get_task_assignees();
		$v_data['task_statuses'] = $this->customers_model->get_task_statuses();
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('all_customers', $v_data, true);
		
		$this->load->view('admin/layout/home', $data);
    }
    
	public function search_customers()
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
                    $daterange = ' AND customers.inserted LIKE \''.$start_date.'%\'';
                }

                else
                {
                    $daterange = ' AND (customers.inserted >= \''.$start_date.'\' AND customers.inserted <= \''.$end_date.'\')';
                }
			}
		}
		
		$search = $customer_phone.$daterange.$task_status;
		// var_dump($search_title); die();
		$this->session->set_userdata('customers_search', $search);
		$this->session->set_userdata('customers_search_title', $search_title);
		
		redirect("customers/all-customers");
	}
	
	public function close_search()
	{
		$this->session->unset_userdata('customers_search');
		$this->session->unset_userdata('customers_search_title');
		
		redirect("customers/all-customers");
    }
    
    public function export_customers()
    {
		$order = 'customers.inserted';
		$order_method = 'DESC';
		$where = 'customers.customer_id > 0';
		$table = 'customers';
		$customers_search = $this->session->userdata('customers_search');
		$search_title = $this->session->userdata('customers_search_title');

		if(!empty($customers_search) && $customers_search != NULL)
		{
			$where .= $customers_search;
		}
		$title = 'Customers';

		if(!empty($search_title) && $search_title != NULL)
		{
			$title = 'Customers filtered by '.$search_title;
		}
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($order, $order_method);
        $this->db->join("task", "task.customer_id = customers.customer_id", "left");
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

    public function assign_customer()
    {
        $this->form_validation->set_rules('customer_id', 'Customer', 'required');
        $this->form_validation->set_rules('personnel_id', 'Personnel', 'required');

        if ($this->form_validation->run()) 
        {
            if($this->customers_model->assign_customer())
            {
                $this->session->set_userdata('success_message', 'Customer assigned successfully');
            }

            else
            {
                $this->session->set_userdata('error_message', 'Unable to assign customer');
            }
        } 
        
        else 
        {
            $validation_errors = validation_errors();
            if (!empty($validation_errors)) {
                $this->session->set_userdata('error_message', $validation_errors);
            }
        }
        redirect("customers/all-customers");
    }
}