<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once "./application/modules/admin/controllers/Admin.php";

class Schools extends admin
{
    public $upload_path;
    public $upload_location;
    public function __construct()
    {
        parent::__construct();
        $this->upload_path = realpath(APPPATH . '../assets/uploads');

        //get the location to upload images
        $this->upload_location = base_url() . 'assets/uploads';

        $this->load->model("laikipiaschools/schools_model");
        $this->load->library("image_lib");

        $this->load->model("laikipiaschools/schools_model");
        $this->load->model("laikipiaschools/site_model");
        $this->load->model("laikipiaschools/file_model");

        // $this->load->model("laikipiaschools/payments_model");
    }
    public function index($order = 'school.school_name', $order_method = 'ASC')
    {
        $this->form_validation->set_rules("school_name", "School Name", "required");
        $this->form_validation->set_rules("school_write_up", "School Write Up", "required");
        $this->form_validation->set_rules("school_boys_number", "Number of Boys", "required");
        $this->form_validation->set_rules("school_girls_number", "Number of Girls", "required");
        $this->form_validation->set_rules("school_location_name", "Location", "required");
        $this->form_validation->set_rules("school_latitude", "Latitude", "required");
        $this->form_validation->set_rules("school_longitude", "Longitude", "required");
        // $this->form_validation->set_rules("school_status", "Status", "required");

        //  validate
        $form_errors = "";
        if ($this->form_validation->run()) {
            $resize = array(
                "width" => 600,
                "height" => 600,
            )
            ;
            $upload_response = $this->file_model->upload_image($this->upload_path, "school_image", $resize);
            if ($upload_response['check'] == false) {
                $this->session->set_flashdata('error', $upload_response['message']);
            } else {
                if ($this->schools_model->add_school($upload_response['file_name'], $upload_response['thumb_name'])) {
                    $this->session->set_flashdata('success', 'school Added successfully!!');
                    redirect('laikipiaschools/schools');

                } else {
                    $this->session->flashdata("error_message", "Unable to add  school");
                }
            }
        } else {
            // $v_data["all_schools"] = $this->schools_model->get_all_schools();
            // $data = array(
            //     "title" => $this->site_model->display_page_title(),
            //     "content" => $this->load->view("schools/all_schools", $v_data, true),
            // );
            // $this->load->view('site/layouts/layout', $data);

            // $this->load->view("all_schools", $data);

            // $this->load->view('site/layouts/layout', $data);

            $where = 'school_id > 0';
            $table = 'school';
            $school_search = $this->session->userdata('school_search');
            $search_title = $this->session->userdata('school_search_title');

            if (!empty($school_search) && $school_search != null) {
                $where .= $school_search;
            }

            //pagination
            $segment = 5;
            $this->load->library('pagination');
            $config['base_url'] = site_url() . 'laikipiaschools/school/' . $order . '/' . $order_method;
            $config['total_rows'] = $this->site_model->count_items($table, $where);
            $config['uri_segment'] = $segment;
            $config['per_page'] = 3;
            $config['num_links'] = 5;

            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';

            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';

            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';

            $config['next_tag_open'] = '<li>';
            $config['next_link'] = 'Next';
            $config['next_tag_close'] = '</span>';

            $config['prev_tag_open'] = '<li page-item disabled>';
            $config['prev_link'] = 'Prev';
            $config['prev_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="page-link"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $this->pagination->initialize($config);

            $page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
            $v_data["links"] = $this->pagination->create_links();

            $query = $this->schools_model->get_all_schools($table, $where, $config["per_page"], $page, $order, $order_method);

            //change of order method
            if ($order_method == 'DESC') {
                $order_method = 'ASC';
            } else {
                $order_method = 'DESC';
            }

            $data['title'] = 'Lakipia Schools';

            if (!empty($search_title) && $search_title != null) {
                $data['title'] = 'school filtered by ' . $search_title;
            }
            $v_data['title'] = $data['title'];

            $v_data['order'] = $order;
            $v_data['order_method'] = $order_method;
            $v_data['query'] = $query;
            $v_data['page'] = $page;
            $v_data["all_schools"] = $this->schools_model->get_all_schools();

            $data = array(
                "title" => $this->site_model->display_page_title(),
                "content" => $this->load->view("schools/all_schools", $v_data, true),
            );
            // $v_data["all_schools"] = $this->schools_model->get_all_schools();

            $this->load->view("laikipiaschools/layouts/layout", $data);
        }

    }

    public function singleSchool($school_id)
    {
        $school = $this->schools_model->get_single_school($school_id);
        if ($school->num_rows() > 0) {
            //  $age, $gender, $hobby
            $row = $school->row();
            $school_image_name = $row->school_image_name;
            $school_name = $row->school_name;
            $School_write_up = $row->School_write_up;
            $school_boys_number = $row->school_boys_number;
            $school_girls_number = $row->school_girls_number;
            $school_location_name = $row->school_location_name;
            $school_latitude = $row->school_latitude;
            $school_longitude = $row->school_longitude;
            $school_status = $row->school_status;
            $data = array(
                'school_image_name' => $school_image_name,
                'school_name' => $school_name,
                'School_write_up' => $School_write_up,
                'school_boys_number' => $school_boys_number,
                'school_girls_number' => $school_girls_number,
                'school_location_name' => $school_location_name,
                'school_latitude' => $school_latitude,
                'school_longitude' => $school_longitude,
                'school_status' => $school_status,
            );
            $this->load->view('welcome_here', $data);

        } else {
            $this->session->set_flashdata("error_message, could not find your school");
            redirect("laikipiaschools/schools");
        }
        //  pass the date
    }
    public function add_school()
    {
        $this->form_validation->set_rules("school_name", "School Name", "required");
        $this->form_validation->set_rules("School_write_up", "School Write Up", "required");
        $this->form_validation->set_rules("school_boys_number", "Number of Boys", "required");
        $this->form_validation->set_rules("school_girls_number", "Number of Girls", "required");
        $this->form_validation->set_rules("school_location_name", "Location", "required");
        $this->form_validation->set_rules("school_latitude", "Latitude", "required");
        $this->form_validation->set_rules("school_longitude", "Longitude", "required");
        $this->form_validation->set_rules("school_status", "Status", "required");

        //  validate
        $form_errors = "";

        if ($this->form_validation->run()) {
            if ($upload_response['check'] == false) {
                $this->session->set_flashdata('error', $upload_response['message']);
            } else {
                if ($this->schools_model->add_school($upload_response['file_name'], $upload_response['thumb_name'])) {
                    $this->session->set_flashdata('success', 'School Added successfully!!');
                    redirect('laikipiaschools/schools');
                } else {
                    $this->session->flashdata("error_message", "Unable to add  school");
                }

            }
            $school_id = $this->schools_model->add_school();
            if ($school_id > 0) {
                $this->session->flashdata("success_message", "New school ID" . $school_id . "has been added");

                redirect("laikipiaschools/schools");
            } else {
                $this->session->flashdata("error_message", "Unable to add  school");

            }
        } else {
            $data["form_errors"] = validation_errors();
            $this->load->view("laikipiaschools/schools", $data);

        }
    }
    public function edit_school($school_id)
    {
        $this->form_validation->set_rules("school_name", "School Name", "required");
        $this->form_validation->set_rules("school_write_up", "school Write Up", "required");
        $this->form_validation->set_rules("school_boys_number", "Number of Boys", "required");
        $this->form_validation->set_rules("school_girls_number", "Number of Girls", "required");
        $this->form_validation->set_rules("school_location_name", "Location", "required");
        $this->form_validation->set_rules("school_latitude", "Latitude", "required");
        $this->form_validation->set_rules("school_longitude", "Longitude", "required");
        // $this->form_validation->set_rules("school_status", "Status", "required");

        if ($this->form_validation->run()) {
            if ($this->schools_model->update_school($school_id)) {
                $this->session->set_flashdata('success', 'school ID: ' . $school_id . ' updated successfully');

                redirect('laikipiaschools/schools');
            } else {
                $this->session->set_flashdata('error', 'Unable to update: ' . $school_id);

                // $v_data['schools'] = $this->schools_model->all_schools();

                $v_data['title'] = "Edit school";
                $data['content'] = $this->load->view('schools/edit_school', $v_data, true);

                $this->load->view("laikipiaschools/layouts/layout", $data);
            }
        } else {
            $school = $this->schools_model->get_single_school($school_id);

            $row = $school->row();
            $v_data['school_name'] = $row->school_name;
            $v_data['school_write_up'] = $row->school_write_up;
            $v_data['school_boys_number'] = $row->school_boys_number;
            $v_data['school_girls_number'] = $row->school_girls_number;
            $v_data['school_location_name'] = $row->school_location_name;
            $v_data['school_latitude'] = $row->school_latitude;
            $v_data['school_longitude'] = $row->school_longitude;
            $v_data['school_status'] = $row->school_status;

            $v_data['query'] = $this->schools_model->get_single_school($school_id);
            // $v_data['schools'] = $this->schools_model->all_schools();

            $v_data['title'] = "Edit school";
            $data['content'] = $this->load->view('schools/edit_school', $v_data, true);

            $this->load->view("laikipiaschools/layouts/layout", $data);
        }

    }

    public function single_school($school_id)
    {
        $v_data['query'] = $this->schools_model->get_single_school($school_id);
        $v_data['title'] = "View";
        $query = $this->schools_model->get_single_school($school_id);

        $data['content'] = $this->load->view('schools/single_school', $v_data, true);

        $this->load->view("laikipiaschools/layouts/layout", $data);
    }
    public function delete_school($school_id)
    {
        if ($this->schools_model->delete_school($school_id)) {
            $this->session->set_flashdata('success', 'Deleted successfully');
            redirect('laikipiaschools/schools');
        } else {
            $this->session->set_flashdata('error', 'Unable to delete, Try again!!');
            redirect('laikipiaschools/schools');
        }
    }
    public function bulk_actions()
    {
        $this->form_validation->set_rules('action_name', 'Action', 'required');

        //if form conatins invalid data
        if ($this->form_validation->run()) {
            $school_id_array = $_POST['school_id'];
            $action_name = $this->input->post('action_name');

            $total_schools = count($school_id_array);

            if ($total_schools > 0) {
                foreach ($school_id_array as $key => $value) {
                    if ($action_name == "delete") {
                        $this->schools_model->delete_school($value);
                    } else {

                    }
                }

                $schools = "laikipiaschools/schools";
                if ($total_schools == 1) {
                    $schools = "school";
                }
                $this->session->set_userdata('success_message', $action_name . " of " . $total_schools . " " . $schools . "  successfull");
            } else {
                $this->session->set_userdata('error_message', "No schools have been selected");
            }
        } else {
            $validation_errors = validation_errors();
            if (!empty($validation_errors)) {
                $this->session->set_userdata("error_message", $validation_errors);
            }
        }

        redirect("laikipiaschools/schools");
    }
}
