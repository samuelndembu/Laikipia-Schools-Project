    <?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once "./application/modules/admin/controllers/Admin.php";

class Partners extends MX_Controller
{
    public $upload_path;
    public $upload_location;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("laikipiaschools/partners_model");
        $this->load->model("laikipiaschools/file_model");
        $this->load->model("laikipiaschools/site_model");
        // $this->load->model("reports/payments_model");

        $this->upload_path = realpath(APPPATH . "../assets/uploads");
        $this->upload_location = base_url() . "assets/uploads";

        $this->load->library("image_lib");
    }

    /*
     *
     *    Default action is to show all the transactions
     *
     */
    //public function index
    public function index($order = 'partner.created_on', $order_method = 'DESC')
    {
        $where = 'partner_id > 0';
        $table = 'partner';
        // $partners_search = $this->session->userdata('partners_search');
        // $search_title = $this->session->userdata('partners_search_title');

        // if (!empty($partners_search) && $partners_search != null) {
        //     $where .= $partners_search;
        // }

        //pagination
        $segment = 5;
        $config['base_url'] = site_url() . 'administration/partners/' . $order . '/' . $order_method;
        $config['total_rows'] = $this->site_model->count_items($table, $where);

        // $config['uri_segment'] = $segment;
        $config['per_page'] = 3;
        $config['num_links'] = 5;

        $config['full_tag_open'] = '<div class="pagging text-center"><nav aria-label="Page navigation example"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close'] = '</span></li>';
        $this->pagination->initialize($config);

        $page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $v_data["links"] = $this->pagination->create_links();
        //var_dump($v_data['links']);die();
        $query = $this->partners_model->get_partners($table, $where, $config["per_page"], $page, $order, $order_method);

        //change of order method
        if ($order_method == 'DESC') {
            $order_method = 'ASC';
        } else {
            $order_method = 'DESC';
        }

        $data['title'] = 'Partners';

        if (!empty($search_title) && $search_title != null) {
            $data['title'] = 'Partners filtered by ' . $search_title;
        }
        $v_data['title'] = $data['title'];

        $v_data['order'] = $order;
        $v_data['order_method'] = $order_method;
        $v_data['query'] = $query;
        $v_data['page'] = $page;
        $v_data["partner_types"] = $this->partners_model->get_partner_types();

        $data['content'] = $this->load->view('partners/all_partners', $v_data, true);
        //$this->load->view('admin/layout/home', $data);
        $this->load->view("laikipiaschools/layouts/layout", $data);
    }

    public function update_partner_info($per_page, $page)
    {
        $this->partners_model->update_partner_info($per_page, $page);
    }

    // public function test_page()
    // {
    //     $v_data['x_partners'] = $this->merchants_m->get_transacted_merchants();
    //     $this->load->view("merchants/test.php", $v_data);
    // }

    public function search_partners()
    {
        $partner_id = $this->input->post('partner_id');
        $search_title = '';

        if (!empty($partner_id)) {
            $search_title .= ' Partner ID <strong>' . $partner_id . '</strong>';
            $partner_id = ' AND partner.partner_id = ' . $partner_id;
        }

        $search = $partner_id;
        // var_dump($search_title); die();
        $this->session->set_userdata('partners_search', $search);
        $this->session->set_userdata('partners_search_title', $search_title);

        redirect("administration/partners");
    }

    public function close_search()
    {
        $this->session->unset_userdata('partners_search');
        $this->session->unset_userdata('partners_search_title');
        $this->session->set_userdata("success_message", "Search has been closed");
        redirect("administration/partners");
    }

    public function deactivate_partner($partner_id, $status_id)
    {
        if($status_id == 1)
        {
            $new_partner_status = 0;
            $message = 'Deactivated';
        }
        else
        {
            $new_partner_status = 1;
            $message = 'Activated';
        }

        $result = $this->partners_model->change_partner_status($partner_id, $new_partner_status);
        if($result == TRUE)
        {
            $this->session->set_flashdata('success', "Partner ID: " . $partner_id . " " . $message . " successfully!");
        }
        else
        {
            $this->session->set_flashdata('error', "Partner ID: " . $partner_id . " failed to " . $message);
        }

        redirect('administration/partners');
        
    }

    public function export_partners()
    {
        $order = 'partner.created_on';
        $order_method = 'DESC';
        $where = 'parner_id > 0';
        $table = 'partner';
        $partnerss_search = $this->session->userdata('partners_search');
        $search_title = $this->session->userdata('partners_search_title');

        if (!empty($partners_search) && $partners_search != null) {
            $where .= $partners_search;
        }
        $title = 'Partners';

        if (!empty($search_title) && $search_title != null) {
            $title = 'Partners filtered by ' . $search_title;
        }

        if ($this->site_model->export_results($table, $where, $order, $order_method, $title)) {
        } else {
            $this->session->set_userdata('error_message', "Unable to export results");
        }

    }

    // public function bulk_actions()
    // {
    //     $this->form_validation->set_rules('action_name', 'Action', 'required');

    //     //if form conatins invalid data
    //     if ($this->form_validation->run())
    //     {
    //         $partner_id_array = $_POST['partner_id'];
    //         $action_name = $this->input->post('action_name');

    //         $total_partners = count($partner_id_array);

    //         if($total_partners > 0)
    //         {
    //             foreach($partner_id_array as $key => $value)
    //             {
    //                 if($action_name == "reset")
    //                 {
    //                     $this->partners_model->reset_merchant_password($value);
    //                 }
    //             }

    //             $merchants = "merchants";
    //             if($total_merchants == 1)
    //             {
    //                 $merchants = "merchant";
    //             }
    //             $this->session->set_userdata('success_message', $action_name." of ".$total_merchants." ".$merchants."  successfull");
    //         }

    //         else
    //         {
    //             $this->session->set_userdata('error_message', "No merchants have been selected");
    //         }
    //     }

    //     else
    //     {
    //         $validation_errors = validation_errors();
    //         if(!empty($validation_errors))
    //         {
    //             $this->session->set_userdata("error_message", $validation_errors);
    //         }
    //     }

    //     redirect("reports/merchants");
    // }

    public function firstview()
    {

        $v_data["query"] = $this->partners_model->get_partners();
        $v_data["partner_types"] = $this->partners_model->get_partner_types();

        $data = array("title" => "Partner",
            "content" => $this->load->view("partners/all_partners", $v_data, true),

        );
        $this->load->view("laikipiaschools/layouts/layout", $data);
    }
    public function read_partner($partner_id)
    {
        $my_partner = $this->partners_model->get_single_partner($partner_id);
        if ($my_partner->num_rows() > 0) {
            $row = $my_partner->row();
            $partner_type_id = $row->partner_type_id;
            $partner_name = $row->partner_name;
            $partner_email = $row->partner_email;
            $partner_logo = $row->partner_logo;
            $partner_thumb = $row->partner_thumb;

            $v_data["partner_type_id"] = $partner_type_id;
            $v_data["partner_name"] = $partner_name;
            $v_data["partner_email"] = $partner_email;
            $v_data["partner_logo"] = $partner_logo;
            $v_data["partner_thumb"] = $partner_thumb;
            $v_data["partner_types"] = $this->partners_model->all_partner_types();

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
        //$this->form_validation->set_rules("partner_logo", "partner_logo", "required");

        if ($this->form_validation->run()) {
            $resize = array(
                "width" => 600,
                "height" => 600,
            );

            $upload_response = $this->file_model->upload_image($this->upload_path, "partner_logo", $resize);

            if ($upload_response["check"] == false) {

                $this->session->set_flashdata("error", $upload_response['message']);
                // $this->session->set_flashdata("error", " unable to add partner");
                redirect('administration/partners');

            } else {
                // var_dump('13');die();
                if ($this->partners_model->add_partners($upload_response['file_name'], $upload_response['thumb_name'])) {
                    $this->session->set_flashdata("success", " added partner");
                    redirect('administration/partners');
                } else {
                    // var_dump('13');die();
                    $this->session->set_flashdata("error_message", "unable to add school");
                }
            }
        } else {

            $v_data["query"] = $this->partners_model->get_partners();
            $v_data["partner_types"] = $this->partners_model->get_partner_types();

            $data = array("title" => "Partner",
                "content" => $this->load->view("partners/all_partners", $v_data, true),

            );

            $this->load->view("laikipiaschools/layouts/layout", $data);
        }
    }
    // $partner_id = $this->partners_model->add_partners();
    // if ($partner_id > 0) {
    //     $this->session->set_flashdata("success_message", "New partner ID" . $partner_name . " has been added");
    // } else {
    //     $this->session->set_flashdata
    //         ("error_message", "unable to add partner");
    // }
    // redirect("laikipiaschools/partners");
    // }

    // redirect("laikipiaschools/partners");

    // $data["form_error"] = validation_errors();
    // // $data["partner_types"] = $this->partners_model->get_partner_types();
    // // $data = array("title" => "Add partner",
    // //     "content" => $this->load->view("partners/add_partner", $data, true));
    // // // $this->load->view("welcome_here", $data);
    // // $this->load->view("laikipiaschools/layouts/layout", $data);

    // //  $this->load->view("partners/add_partner",$data);

    // //update
    public function edit($partner_id)
    {
        $this->form_validation->set_rules("partner_type", "Partner Type", "required");
        $this->form_validation->set_rules("partner_name", "Partner Name", "required");
        $this->form_validation->set_rules("partner_email", "Partner Email", "required");

        if ($this->form_validation->run()) {
            $update_status = $this->partners_model->update_partner($partner_id);
            if ($update_status) {
                redirect("administration/partners");
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
                    "content" => $this->load->view("partners/edit_partners", $v_data, true),
                );
                // var_dump($data);die();
                $this->load->view("laikipiaschools/layouts/layout", $data);

            } else {
                $this->session->set_flashdata("error_message", "couldnt");
                redirect("partners");
            }

        }

    }
    //uploading image
    //delete image
    // public function delete_partner($partner_id)
    // {
    // if($this->partners_model->delete_partners($partner_id)
    // {
    // $this->session->set_flashdata('success', 'Partner Deleted successfully');
    // redirect('administration/partners');
    // }
    // else
    // {
    // $this->session->set_flashdata('error', 'Unable to delete partner, Try again!!');
    // redirect('administration/partners');
    // }
    // }
}