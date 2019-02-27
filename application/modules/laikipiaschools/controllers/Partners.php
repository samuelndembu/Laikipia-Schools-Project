<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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
        $this->upload_path = realpath(APPPATH . "../assets/uploads");
        $this->upload_location = base_url() . "assets/uploads";
        $this->load->library("image_lib");
    }
    //public function index
    public function index($order = 'partner.partner_name', $order_method = 'ASC')
    {
        $where = 'partner_id > 0 AND partner.deleted=0';
        $table = 'partner';
        $partners_search = $this->session->userdata('partners_search');
        $search_title = $this->session->userdata('partners_search_title');

        if (!empty($partners_search) && $partners_search != null) {
            $where .= $partners_search;
        }

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
        $v_data['categories'] = $this->site_model->get_all_categories();
        $v_data["partner_types"] = $this->partners_model->get_partner_types();

        $partner_type_search = array();

        foreach ($v_data["partner_types"]->result() as $partner_type) {
            array_push($partner_type_search, array(
                'id' => $partner_type->partner_type_id,
                'name' => $partner_type->partner_type_name,
            ));
        }

        $data['search_options'] = $partner_type_search;
        $data['route'] = 'partners';
        $data['content'] = $this->load->view('partners/all_partners', $v_data, true);
        //$this->load->view('admin/layout/home', $data);
        $this->load->view("laikipiaschools/layouts/layout", $data);
    }

    public function update_partner_info($per_page, $page)
    {
        $this->partners_model->update_partner_info($per_page, $page);
    }
    public function search_partners()
    {
        $partner_type_id = $this->input->post('search_param');
        $search_title = '';

        if (!empty($partner_type_id)) {
            $search_title .= ' Searched: <strong>' . $partner_type_id . '</strong>';
            $partner_type_id = ' AND partner.partner_type_id = ' . $partner_type_id;
        }

        $search = $partner_type_id;
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
        if ($status_id == 1) {
            $new_partner_status = 0;
            $message = 'Deactivated';
        } else {
            $new_partner_status = 1;
            $message = 'Activated';
        }

        $result = $this->partners_model->change_partner_status($partner_id, $new_partner_status);
        if ($result == true) {
            $this->session->set_flashdata('success', "Partner ID: " . $partner_id . " " . $message . " successfully!");
        } else {
            $this->session->set_flashdata('error', "Partner ID: " . $partner_id . " failed to " . $message);
        }

        redirect('administration/partners');

    }

    public function export_partners()
    {
        $order = 'partner.partner_name';
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
        $this->form_validation->set_rules("partner_email", "partner_email");

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

    public function edit($partner_id)
    {
        $this->form_validation->set_rules("partner_type", "Partner Type", "required");
        $this->form_validation->set_rules("partner_name", "Partner Name", "required");
        $this->form_validation->set_rules("partner_email", "Partner Email");

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
                $v_data['categories'] = $this->site_model->get_all_categories();
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
    public function delete_partner($partner_id)
    {
        if ($this->partners_model->delete_partners($partner_id)) {
            $this->session->set_flashdata('success', 'Deleted successfully');
            redirect('administration/partners');
        } else {
            $this->session->set_flashdata('error', 'Unable to delete, Try again!!');
            redirect('administration/partners');
        }
    }

}
