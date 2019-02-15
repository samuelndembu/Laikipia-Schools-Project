<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/Admin.php";

class Merchants extends admin 
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model("reports/merchants_model");
	}
    
	/*
	*
	*	Default action is to show all the merchants
	*
	*/
	public function index($order = 'agents.inserted', $order_method = 'DESC') 
	{
		$where = 'agent_id > 0';
		$table = 'agents';
		$merchants_search = $this->session->userdata('merchants_search');
		$search_title = $this->session->userdata('merchants_search_title');

		if(!empty($merchants_search) && $merchants_search != NULL)
		{
			$where .= $merchants_search;
		}

		//pagination
		$segment = 5;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'reports/merchants/'.$order.'/'.$order_method;
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
		$query = $this->merchants_model->get_all_merchants($table, $where, $config["per_page"], $page, $order, $order_method);
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
		$data['title'] = 'Merchants';

		if(!empty($search_title) && $search_title != NULL)
		{
			$data['title'] = 'Merchants filtered by '.$search_title;
		}
		$v_data['title'] = $data['title'];
		
		$v_data['order'] = $order;
		$v_data['order_method'] = $order_method;
		$v_data['transacted_merchants'] = $this->merchants_model->get_registered_merchants();
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('merchants/all_merchants', $v_data, true);
		
		$this->load->view('admin/layout/home', $data);
	}
    
	public function update_merchant_info($per_page, $page)
	{
		$this->merchants_model->update_merchant_info($per_page, $page);
	}
    
	public function test_page()
	{
		$v_data['transacted_merchants'] = $this->merchants_model->get_transacted_merchants();
		$this->load->view("merchants/test.php", $v_data);
	}

	public function search_merchants()
	{
		$agent_id = $this->input->post('agent_id');
		$search_title = '';
		
		if(!empty($agent_id))
		{
			$search_title .= ' Merchant ID <strong>'.$agent_id.'</strong>';
			$agent_id = ' AND agents.agent_id = '.$agent_id;
		}
		
		$search = $agent_id;
		// var_dump($search_title); die();
		$this->session->set_userdata('merchants_search', $search);
		$this->session->set_userdata('merchants_search_title', $search_title);
		
		redirect("reports/merchants");
	}
	
	public function close_search()
	{
		$this->session->unset_userdata('merchants_search');
		$this->session->unset_userdata('merchants_search_title');
		$this->session->set_userdata("success_message", "Search has been closed");
		redirect("reports/merchants");
	}

	public function export_merchants()
	{
		$order = 'agents.inserted';
		$order_method = 'DESC';
		$where = 'agent_id > 0';
		$table = 'agents';
		$merchants_search = $this->session->userdata('merchants_search');
		$search_title = $this->session->userdata('merchants_search_title');

		if(!empty($merchants_search) && $merchants_search != NULL)
		{
			$where .= $merchants_search;
		}
		$title = 'Merchants';

		if(!empty($search_title) && $search_title != NULL)
		{
			$title = 'Merchants filtered by '.$search_title;
		}
		
		if($this->site_model->export_results($table, $where, $order, $order_method, $title))
		{
		}
		
		else
		{
			$this->session->set_userdata('error_message', "Unable to export results");
		}

	}

	public function bulk_actions()
	{
		$this->form_validation->set_rules('action_name', 'Action', 'required');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			$agent_id_array = $_POST['agent_id'];
			$action_name = $this->input->post('action_name');
	
			$total_merchants = count($agent_id_array);

			if($total_merchants > 0)
			{
				foreach($agent_id_array as $key => $value)
				{
					if($action_name == "reset")
					{
						$this->merchants_model->reset_merchant_password($value);
					}
				}
				
				$merchants = "merchants";
				if($total_merchants == 1)
				{
					$merchants = "merchant";
				}
				$this->session->set_userdata('success_message', $action_name." of ".$total_merchants." ".$merchants."  successfull");
			}
			
			else
			{
				$this->session->set_userdata('error_message', "No merchants have been selected");
			}
		}

		else
		{
			$validation_errors = validation_errors();
			if(!empty($validation_errors))
			{
				$this->session->set_userdata("error_message", $validation_errors);
			}
		}

		redirect("reports/merchants");
	}
}
?>