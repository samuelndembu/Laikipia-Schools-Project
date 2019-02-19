<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once "./application/modules/admin/controllers/Admin.php";

class Partners extends admin
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("laikipiaschools/partners_model");
        // $this->load->model("reports/payments_model");
    }

    /*
     *
     *    Default action is to show all the transactions
     *
     */
    public function index()
    {

        $v_data["query"] = $this->partners_model->get_partners();
        $v_data["partner_types"] = $this->partners_model->get_partner_types();

        $data = array("title" => "Partner",
            "content" => $this->load->view("partners/all_partners", $v_data, true),

        );
        $this->load->view("laikipiaschools/layouts/layout", $data);
    }
    public function addpartner($partner_id)
    {
        $my_partner = $this->partners_model->get_single_partner($partner_id);
        if ($my_partner->num_rows() > 0) {
            $row = $my_partner->row();
            $partner_type = $row->partner_type;
            $partner_name = $row->partner_name;
            $partner_email = $row->partner_email;
            $partner_logo = $row->partner_logo;

            $v_data["partner_type"] = $partner_type;
            $v_data["partner_name"] = $partner_name;
            $v_data["partner_email"] = $partner_email;
            $v_data["partner_logo"] = $partner_logo;

            $data = array("title" => "partner",
                "content" => $this->load->view("partners/new_partner", $v_data, true));
            // $this->load->view("welcome_here", $data);
            $this->load->view("laikipiaschools/layouts/layout", $data);
        } else {
            $this->session->set_flashdata("error_message", "could not find partner");
            redirect("partners");

        }
    }
    
    public function create_partner()
    {
        $this->form_validation->set_rules("partner_type", "partner_type", "required");
        $this->form_validation->set_rules("partner_name", "partner_name", "required");
        $this->form_validation->set_rules("partner_email", "partner_email", "required");
        $this->form_validation->set_rules("partner_logo", "partner_logo", "required");

        if ($this->form_validation->run()) {
            $partner_id = $this->partners_model->add_partners();
            if ($partner_id > 0) {
                $this->session->set_flashdata("success_message", "New partner ID" . $partner_name . " has been added");
            } else {
                $this->session->set_flashdata
                    ("error_message", "unable to add partner");
            }
            redirect("laikipiaschools/partners");
        }

        redirect("laikipiaschools/partners");

        $data["form_error"] = validation_errors();
        // $data["partner_types"] = $this->partners_model->get_partner_types();
        // $data = array("title" => "Add partner",
        //     "content" => $this->load->view("partners/add_partner", $data, true));
        // // $this->load->view("welcome_here", $data);
        // $this->load->view("laikipiaschools/layouts/layout", $data);

        //  $this->load->view("partners/add_partner",$data);

        $v_data["query"] = $this->partners_model->get_partners();
        $v_data["partner_types"] = $this->partners_model->get_partner_types();

        $data = array("title" => "Partner",
            "content" => $this->load->view("partners/all_partners", $v_data, true),

        );
        $this->load->view("laikipiaschools/layouts/layout", $data);
    }

    //update
    public function edit($partner_id)
    {
        $this->form_validation->set_rules("partner_type", "Partner Type", "required");
        $this->form_validation->set_rules("partner_name", "Partner Name", "required");
        $this->form_validation->set_rules("partner_email", "Partner Email", "required");
       

        if ($this->form_validation->run()) {
            $update_status = $this->partners_model->update_partner($partner_id);
            if ($update_status) {
                redirect("laikipiaschools/partners");
            }
        } else {
            //name from form is the unique identifier
            $my_partner = $this->partners_model->get_single_partner($partner_id);
            if ($my_partner->num_rows() > 0) {
                $row = $my_partner->row();
                $partner_type_id = $row->partner_type_id;
                $partner_name = $row->partner_name;
                $partner_email = $row->partner_email;
                $partner_logo = $row->partner_logo;

                $v_data["partner_type_id"] = $partner_type_id;
                $v_data["partner_name"] = $partner_name;
                $v_data["partner_email"] = $partner_email;
                $v_data["partner_logo"] = $partner_logo;
                // $v_data["partners"] = $my_partner;
                $v_data["partner_types"] = $this->partners_model->all_partner_types();

                $data = array("title" => "Update partner",
                    "content" => $this->load->view("partners/edit_partners", $v_data, true)
                );
                // var_dump($data);die();
                $this->load->view("laikipiaschools/layouts/layout", $data);

            } else {
                $this->session->set_flashdata("error_message", "couldnt");
                redirect("partners");
            }

        }

    }
    public function delete_partner($partner_id)
    {
		if($this->partners_model->delete_partners($partner_id))
		{
			$this->session->set_flashdata('success', 'Partner Deleted successfully');
			redirect('laikipiaschools/partners');
		}
		else 
		{
			$this->session->set_flashdata('error', 'Unable to delete partner, Try again!!');
			redirect('laikipiaschools/partners');
		}
    }
}
