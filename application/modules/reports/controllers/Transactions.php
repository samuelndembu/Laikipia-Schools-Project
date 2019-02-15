<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/Admin.php";

class Transactions extends admin 
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model("reports/transactions_model");
		$this->load->model("reports/payments_model");
	}
    
	/*
	*
	*	Default action is to show all the transactions
	*
	*/
	public function index($order = 'mpesa_customer_register.created_at', $order_method = 'DESC') 
	{
		$where = 'mpesa_customer_register_id > 0';
		$table = 'mpesa_customer_register';
		$transactions_search = $this->session->userdata('transactions_search');
		$search_title = $this->session->userdata('transactions_search_title');

		if(!empty($transactions_search) && $transactions_search != NULL)
		{
			$where .= $transactions_search;
		}

		//pagination
		$segment = 5;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'reports/transactions/'.$order.'/'.$order_method;
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
		$query = $this->transactions_model->get_all_transactions($table, $where, $config["per_page"], $page, $order, $order_method);
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
		$data['title'] = 'Transactions';

		if(!empty($search_title) && $search_title != NULL)
		{
			$data['title'] = 'Transactions filtered by '.$search_title;
		}
		$v_data['title'] = $data['title'];
		
		$v_data['order'] = $order;
		$v_data['order_method'] = $order_method;
		$v_data['transacted_agents'] = $this->transactions_model->get_transacted_agents();
		$v_data['transacted_locations'] = $this->transactions_model->get_transacted_locations();
		$v_data['transacted_customers'] = $this->payments_model->get_transacted_customers();
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('transactions/all_transactions', $v_data, true);
		
		$this->load->view('admin/layout/home', $data);
	}
    
	public function update_merchant_info($per_page, $page)
	{
		$this->transactions_model->update_merchant_info($per_page, $page);
	}
    
	public function test_page()
	{
		$v_data['transacted_agents'] = $this->transactions_model->get_transacted_agents();
		$this->load->view("transactions/test.php", $v_data);
	}

	public function search_transactions()
	{
		$customer_phone = $this->input->post('customer_phone');
		$merchant_phone = $this->input->post('merchant_phone');
		$daterange = $this->input->post('daterange');
		$transaction_location = $this->input->post('transaction_location');
		$search_title = '';
		
		if(!empty($customer_phone))
		{
			$search_title .= ' Customer <strong>'.$customer_phone.'</strong>';
			$customer_phone = ' AND mpesa_customer_register.phone_number = \'+'.$customer_phone.'\'';
		}
		
		if(!empty($merchant_phone))
		{
			$search_title .= ' Merchant <strong>'.$merchant_phone.'</strong>';
			$merchant_phone = ' AND mpesa_customer_register.agent_phoneNumber = \''.$merchant_phone.'\'';
		}
		
		if(!empty($daterange))
		{
			$date_array = explode("-", $daterange);
			if(count($date_array) == 2)
			{
				$start_date = date("Y-m-d", strtotime($date_array[0]));
				$end_date = date("Y-m-d", strtotime($date_array[1]));

				$search_title .= ' Date <strong>'.$daterange.'</strong>';
				$daterange = ' AND (mpesa_customer_register.created_at >= \''.$start_date.'\' AND mpesa_customer_register.created_at <= \''.$end_date.'\')';
			}
		}
		
		if(!empty($transaction_location))
		{
			$search_title .= ' Location <strong>'.$transaction_location.'</strong>';
			$transaction_location = ' AND mpesa_customer_register.merchant_location LIKE \'%'.$transaction_location.'%\'';
		}
		
		$search = $merchant_phone.$daterange.$transaction_location.$customer_phone;
		// var_dump($search_title); die();
		$this->session->set_userdata('transactions_search', $search);
		$this->session->set_userdata('transactions_search_title', $search_title);
		
		redirect("reports/transactions");
	}
	
	public function close_search()
	{
		$this->session->unset_userdata('transactions_search');
		$this->session->unset_userdata('transactions_search_title');
		
		redirect("reports/transactions");
	}

	public function export_transactions()
	{
		$order = 'mpesa_customer_register.created_at';
		$order_method = 'DESC';
		$where = 'mpesa_customer_register_id > 0';
		$table = 'mpesa_customer_register';
		$transactions_search = $this->session->userdata('transactions_search');
		$search_title = $this->session->userdata('transactions_search_title');

		if(!empty($transactions_search) && $transactions_search != NULL)
		{
			$where .= $transactions_search;
		}
		$title = 'Transactions';

		if(!empty($search_title) && $search_title != NULL)
		{
			$title = 'Transactions filtered by '.$search_title;
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
			$mpesa_customer_register_id_array = $_POST['mpesa_customer_register_id'];
			$action_name = $this->input->post('action_name');
	
			$total_transactions = count($mpesa_customer_register_id_array);

			if($total_transactions > 0)
			{
				foreach($mpesa_customer_register_id_array as $key => $value)
				{
					if($action_name == "delete")
					{
						$this->transactions_model->delete_transaction($value);
					}
					else
					{
						
					}
				}
				
				$transactions = "transactions";
				if($total_transactions == 1)
				{
					$transactions = "transaction";
				}
				$this->session->set_userdata('success_message', $action_name." of ".$total_transactions." ".$transactions."  successfull");
			}
			
			else
			{
				$this->session->set_userdata('error_message', "No transactions have been selected");
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

		redirect("reports/transactions");
	}
}
?>