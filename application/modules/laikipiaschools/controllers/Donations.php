<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once "./application/modules/admin/controllers/Admin.php";

class Donations extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("donations_model");
        // $this->load->model("payments_model");
    }

    /*
     *
     *    Default action is to show all the donations
     *
     */
    public function index($donation_id = NULL , $order = NULL, $order_method = NULL)
    {
		$order = 'donation.created_on';
		$order_method = 'DESC';
        $this->form_validation->set_rules('donation_amount', 'Donation Amount', 'required|numeric');
        $this->form_validation->set_rules('partner_id', 'Partner', 'required|numeric');
        $this->form_validation->set_rules('school_id', 'School', 'required|numeric');

        if ($this->form_validation->run()) {
            if ($this->donations_model->create_donation($donation_id)) {
                $this->session->set_flashdata('success', 'Donation ID: ' . $donation_id . ' updated successfully');
                redirect('laikipiaschools/donations');
            } else {
                $this->session->set_flashdata('error', 'Unable to update: ' . $donation_id);
                redirect('laikipiaschools/donations');
            }
        } else {
            $where = 'donation.deleted=0 AND donation.school_id = school.school_id AND donation.partner_id = partner.partner_id';
            $table = 'donation, school, partner';
            $donations_search = $this->session->userdata('donations_search');
            $search_title = $this->session->userdata('donations_search_title');

            if (!empty($donations_search) && $donations_search != null) {
                $where .= $donations_search;
            }

            //pagination
            $segment = 5;
            $this->load->library('pagination');
            $config['base_url'] = site_url() . 'donations/' . $order . '/' . $order_method;
            // $config['total_rows'] = $this->site_model->count_items($table, $where);
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
            $query = $this->donations_model->get_all_donations($table, $where, $config["per_page"], $page, $order, $order_method);

            //change of order method
            if ($order_method == 'DESC') {
                $order_method = 'ASC';
            } else {
                $order_method = 'DESC';
            }

            $data['title'] = 'donations';

            if (!empty($search_title) && $search_title != null) {
                $data['title'] = 'donations filtered by ' . $search_title;
            }
            $v_data['title'] = $data['title'];

            $v_data['order'] = $order;
            $v_data['order_method'] = $order_method;
            // $v_data['transacted_agents'] = $this->donations_model->get_transacted_agents();
            // $v_data['transacted_locations'] = $this->donations_model->get_transacted_locations();
            // $v_data['transacted_customers'] = $this->payments_model->get_transacted_customers();
            $v_data['query'] = $query;
            $v_data['schools'] = $this->donations_model->all_schools();
            $v_data['partners'] = $this->donations_model->all_partners();
            $v_data['page'] = $page;
            $data['content'] = $this->load->view('donations/all_donations', $v_data, true);

            $this->load->view("laikipiaschools/layouts/layout", $data);
        }

    }

    public function edit_donation($donation_id)
    {
		// echo $this->input->post("donation_amount");die();
        $this->form_validation->set_rules('donation_amount', 'Donation Amount', 'required|numeric');
        $this->form_validation->set_rules('partner_id', 'Partner', 'required|numeric');
        $this->form_validation->set_rules('school_id', 'School', 'required|numeric');
		
        if ($this->form_validation->run()) {
            if ($this->donations_model->update_donation($donation_id)) {
                $this->session->set_flashdata('success', 'Donation ID: ' . $donation_id . ' updated successfully');

                redirect('laikipiaschools/donations');
            } else {
                $this->session->set_flashdata('error', 'Unable to update: ' . $donation_id);
                $v_data['query'] = $this->donations_model->get_single_donation($donation_id);
                $v_data['schools'] = $this->donations_model->all_schools();
                $v_data['partners'] = $this->donations_model->all_partners();
                $v_data['title'] = "Edit Donation";
                $data['content'] = $this->load->view('donations/edit_donation', $v_data, true);

                $this->load->view("laikipiaschools/layouts/layout", $data);
            }
        } else {
            $v_data['query'] = $this->donations_model->get_single_donation($donation_id);
            $v_data['schools'] = $this->donations_model->all_schools();
            $v_data['partners'] = $this->donations_model->all_partners();
            $v_data['title'] = "Edit Donation";
            $data['content'] = $this->load->view('donations/edit_donation', $v_data, true);

            $this->load->view("laikipiaschools/layouts/layout", $data);
        }

    }

    public function single_donation($donation_id)
    {
        $v_data['query'] = $this->donations_model->get_single_donation($donation_id);
        $v_data['title'] = "View";
        $query = $this->donations_model->get_single_donation($donation_id);

        $data['content'] = $this->load->view('donations/single_donation', $v_data, true);

        $this->load->view("laikipiaschools/layouts/layout", $data);
    }

    public function delete_donation($donation_id)
    {
		if($this->donations_model->delete_donation($donation_id))
		{
			$this->session->set_flashdata('success', 'Deleted successfully');
			redirect('laikipiaschools/donations');
		}
		else 
		{
			$this->session->set_flashdata('error', 'Unable to delete, Try again!!');
			redirect('laikipiaschools/donations');
		}
    }

}
