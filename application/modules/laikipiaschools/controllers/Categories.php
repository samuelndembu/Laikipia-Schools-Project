<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Categories extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("laikipiaschools/categories_model");
        $this->load->model("laikipiaschools/file_model");
        $this->load->model("laikipiaschools/site_model");

    }

    //public function index
    public function index($order = 'category.category_name', $order_method = 'ASC')
    {
        $where = 'category_id > 0 AND deleted=0';
        $table = 'category';
        $category_search = $this->session->userdata('categories_search');
        
        $search_title = $this->session->userdata('categories_search_title');

        if (!empty($category_search) && $category_search != null) {
            $where .= $category_search;
        }

        // var_dump($where);die();

        //pagination
        $segment = 5;
        $config['base_url'] = site_url() . 'administration/categories/' . $order . '/' . $order_method;
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
        $query = $this->categories_model->get_categories($table, $where, $config["per_page"], $page, $order, $order_method);

        //change of order method
        if ($order_method == 'DESC') {
            $order_method = 'ASC';
        } else {
            $order_method = 'DESC';
        }

        $data['title'] = 'Categories';

        if (!empty($search_title) && $search_title != null) {
            $data['title'] = 'Categories filtered by ' . $search_title;
        }
        $v_data['title'] = $data['title'];
        $v_data['order'] = $order;
        $v_data['order_method'] = $order_method;
        $v_data['query'] = $query;
        $v_data['page'] = $page;
        $all_categories = $this->site_model->get_all_categories();
        $v_data['categories'] = $all_categories;

        $cat_parent = array();

        $categories_result = $all_categories->result();

        foreach ($categories_result as $value) 
        {
            if($value->category_parent == 0)
            {
                array_push($cat_parent, array(
                    'id' => $value->category_id, 
                    'name' => $value->category_name
                    ) );
            }
        }
      
        // $v_data["parent"] = $this->categories_model->get_parents();

        $data['content'] = $this->load->view('categories/all_categories', $v_data, true);
        $data['search_options'] = $cat_parent;
        $data['route'] = 'categories';
        //$this->load->view('admin/layout/home', $data);
        $this->load->view("laikipiaschools/layouts/layout", $data);
    }

    public function update_category_info($per_page, $page)
    {
        $this->categories_model->update_category_info($per_page, $page);
    }

    public function search_categories()
    {
        $category_parent = $this->input->post('search_param');
        
        // $all_categories = ($this->site_model->get_all_categories())->result();

        // foreach ($all_categories as $key => $category) 
        // {
        //     if($category_parent_name == $category->category_name)
        //     {
        //         $category_parent = $category->category_id;
        //         break;
        //     }
        // }

        $search_title = '';

        if (!empty($category_parent)) {
            $search_title .= ' Searched: <strong>' . $category_parent . '</strong>';
            $category_parent = ' AND category.category_parent = "' . $category_parent . '"';
        }

        $search = $category_parent;
        // var_dump($search_title); die();
        $this->session->set_userdata('categories_search', $search);
        $this->session->set_userdata('categories_search_title', $search_title);

        // var_dump($search);die();

        redirect("administration/categories");
    }

    public function close_search()
    {
        $this->session->unset_userdata('categories_search');
        $this->session->unset_userdata('categories_search_title');
        $this->session->set_userdata("success_message", "Search has been closed");
        redirect("administration/categories");
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

    public function read_category($category_id)
    {
        $my_category = $this->categories_model->get_single_category($category_id);
        if ($my_category->num_rows() > 0) {
            $row = $my_category->row();
            $category_parent = $row->category_parent;
            $category_name = $row->category_name;

            $v_data["category_parent"] = $category_parent;
            $v_data["Category_name"] = $category_name;

            $data = array("title" => "category",
                "content" => $this->load->view("categories/new_category", $v_data, true));
            // $this->load->view("welcome_here", $data);
            $this->load->view("laikipiaschools/layouts/layout", $data);
        } else {
            $this->session->set_flashdata("error_message", "could not find category");
            redirect("categories");

        }
    }
    public function deactivate_category($category_id, $status_id)
    {
        if ($status_id == 1) {
            $new_category_status = 0;
            $message = 'Deactivated';
        } else {
            $new_category_status = 1;
            $message = 'Activated';
        }

        $result = $this->categories_model->change_category_status($category_id, $new_category_status);
        if ($result == true) {
            $this->session->set_flashdata('success', "Category ID: " . $category_id . " " . $message . " successfully!");
        } else {
            $this->session->set_flashdata('error', "Category ID: " . $category_id . " failed to " . $message);
        }

        redirect('administration/categories');

    }

    public function create_category()
    {
        // $this->form_validation->set_rules("parent", "parent", "required");
        $this->form_validation->set_rules("category_name", "category_name", "required|is_unique[category.category_name]");

        if ($this->form_validation->run()) {
            $category_id = $this->categories_model->add_category();
            if ($category_id > 0) {
                $this->session->set_flashdata("success_message", "New category ID" . $category_id . " has been added");
            } else {
                $this->session->set_flashdata
                    ("error", "unable to add category");
            }
            redirect("administration/categories");
        }
        else{
             $this->session->set_flashdata
                    ("error", validation_errors());
        
             redirect("administration/categories");
        }

        redirect("administration/categories");

       
    }
    
    public function edit($category_id)
     {
    $this->form_validation->set_rules("category_name", "Name", "required|is_unique[category.category_name]");

        if ($this->form_validation->run()) {
            $update_status = $this->categories_model->update_category($category_id);
            if ($update_status) {
                redirect("administration/categories");
            }
        } else {
            $my_category = $this->categories_model->get_single_category($category_id);
            if ($my_category->num_rows() > 0) {
                $row = $my_category->row();
                $category_parent = $row->category_parent;
                $category_name = $row->category_name;
                $v_data["category_id"] = $category_id;
                $v_data["category_name"] = $category_name;
                $v_data['categories'] = $this->site_model->get_all_categories();
                $v_data["category_parent"] = $category_parent;
                //var_dump("category_parent");die();
               
                $data = array("title" => "Update category",
                    "content" => $this->load->view("categories/edit_category", $v_data, true),
                );
                // var_dump($data);die();
                $this->load->view("laikipiaschools/layouts/layout", $data);

            } else {
                $this->session->set_flashdata("error_message", "couldnt");
                redirect("categories");
            }

        }
    }

    //uploading image
    //delete image
   
    public function delete_category($category_id)
    {
        if ($this->categories_model->delete_categories($category_id)) {
            $this->session->set_flashdata('success', 'Deleted successfully');
            redirect('administration/categories');
        } else {
            $this->session->set_flashdata('error', 'Unable to delete, Try again!!');
            redirect('administration/categories');
        }
    }   

    
    
}
