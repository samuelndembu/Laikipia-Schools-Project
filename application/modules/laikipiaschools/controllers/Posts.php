<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class posts extends MX_Controller
{
    public $upload_path;
    public $upload_location;
    public function __construct()
    {
        parent::__construct();
        $this->upload_path = realpath(APPPATH . '../assets/uploads');

        //get the location to upload images
        $this->upload_location = base_url() . 'assets/uploads';

        $this->load->model("laikipiaschools/posts_model");
        $this->load->library("image_lib");

        $this->load->model("laikipiaschools/posts_model");
        $this->load->model("laikipiaschools/site_model");
        $this->load->model("laikipiaschools/file_model");

        // $this->load->model("administration/payments_model");
    }
    public function index($order = 'post_id', $order_method = 'ASC', $start = null)
    {
        $this->form_validation->set_rules("post_title", "Post Title", "required");
        $this->form_validation->set_rules("post_description", "Post Description", "required");
        // $this->form_validation->set_rules("post_image_name", "Post Image", "required");
        // $this->form_validation->set_rules("post_views", "Views", "required");
        // $this->form_validation->set_rules("post_status", "Status", "required");

        //  validate
        $form_errors = "";
        if ($this->form_validation->run()) {
            $resize = array(
                "width" => 600,
                "height" => 600,
            );

            $upload_response = $this->file_model->upload_image($this->upload_path, "post_image_name", $resize);

            if ($upload_response['check'] == false) {
                $this->session->set_flashdata('error', $upload_response['message']);
            } else {
                if ($this->posts_model->add_post($upload_response['file_name'], $upload_response['thumb_name'])) {
                    $this->session->set_flashdata('success', 'Post Added successfully');
                    redirect('administration/posts');

                } else {
                    $this->session->flashdata("error_message", "Unable to add  post!!! Try again");
                }
            }
        } else {

            $where = 'post_id > 0 AND post.deleted = 0';
            $table = 'post';
            $post_search = $this->session->userdata('post_search');
            $search_title = $this->session->userdata('post_search_title');

            if (!empty($post_search) && $post_search != null) {
                $where .= $post_search;
            }

            //pagination
            $segment = 5;
            $this->load->library('pagination');
            $config['base_url'] = site_url() . 'administration/posts/' . $order . '/' . $order_method;
            $config['total_rows'] = $this->site_model->count_items($table, $where . ' AND deleted != 1');
            // $config["total_rows"] = $this->friends_model->countAll();
            $config['uri_segment'] = $segment;
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
            $v_data['categories'] = $this->site_model->get_all_categories();
            $query = $this->posts_model->get_all_posts($table, $where, $start, $config["per_page"],

                $page, $order, $order_method);
            //change of order method
            if ($order_method == 'DESC') {
                $order_method = 'ASC';
            } else {
                $order_method = 'DESC';
            }

            $data['title'] = 'Lakipia posts';

            if (!empty($search_title) && $search_title != null) {
                $data['title'] = 'post filtered by ' . $search_title;
            }
            $v_data['title'] = $data['title'];

            $v_data['order'] = $order;
            $v_data['order_method'] = $order_method;
            $v_data['query'] = $query;
            $v_data['page'] = $page;
            $v_data["posts"] = $this->posts_model->get_all_posts($table, $where, $start, $config["per_page"], $page, $order, $order_method);
            $v_data["all_posts"] = $this->posts_model->get_all_posts($table, $where, $start, $config["per_page"], $page, $order, $order_method);

            $posts_search = array();
            foreach ($v_data["posts"]->result() as $post) {
                array_push($posts_search, array(
                    'id' => $post->post_id,
                    'name' => $post->post_title,
                ));
            }
            $v_data['search_options'] = $posts_search;
            $v_data['route'] = 'posts';

            $data = array(
                "title" => $this->site_model->display_page_title(),
                "content" => $this->load->view("posts/all_posts", $v_data, true),
            );
            //

            $this->load->view("laikipiaschools/layouts/layout", $data);
        }

    }
    public function deactivate_post($post_id, $status_id)
    {
        if ($status_id == 1) {
            $new_post_status = 0;
            $message = 'Deactivated';
        } else {
            $new_post_status = 1;
            $message = 'Activated';
        }

        $result = $this->posts_model->change_post_status($post_id, $new_post_status);
        if ($result == true) {
            $this->session->set_flashdata('success', "post ID: " . $post_id . " " . $message . " successfully!");
        } else {
            $this->session->set_flashdata('error', "post ID: " . $post_id . " failed to " . $message);
        }

        redirect('administration/posts');
    }
    public function export_post()
    {
        $this->load->model("excel_export_model");
        $data["post_data"] = $this->excel_export_model->fetch_data();
        $this->load->view("Administration/posts", $data
        );
    }

    public function export_posts()
    {
        $order = 'post.post_id';
        $order_method = 'DESC';
        $where = 'post_id > 0';
        $table = 'post';
        $posts_search = $this->session->userdata('post_search');
        $search_title = $this->session->userdata('post_search_title');

        if (!empty($posts_search) && $posts_search != null) {
            $where .= $posts_search;
        }
        $title = 'posts';

        if (!empty($search_title) && $search_title != null) {
            $title = 'posts filtered by ' . $search_title;
        }

        if ($this->site_model->export_results($table, $where, $order, $order_method, $title)) {
        } else {
            $this->session->set_userdata('error_message', "Unable to export results");
        }

    }

    public function singlepost($post_id)
    {
        $post = $this->posts_model->get_single_post($post_id);
        if ($post->num_rows() > 0) {
            $row = $post->row();
            $post_title = $row->post_title;
            $post_description = $row->post_description;
            $post_image_name = $row->post_image_name;
            $post_views = $row->post_views;
            $post_status = $row->post_status;
            $data = array(
                'post_image_name' => $post_title,
                'post_description' => $post_description,
                'post_image_name' => $post_image_name,
                'post_views' => $post_views,
                'post_status' => $post_status,
            );
            $v_data["all_posts"] = $this->posts_model->get_single_post();

            $data = array(
                "title" => $this->site_model->display_page_title(),
                "content" => $this->load->view("posts/all_posts", $v_data, true),
            );
            $this->load->view("administration/layouts/layout", $data);

        } else {
            $this->session->set_flashdata("error_message, could not find your post");
            redirect("administration/posts");
        }
        //  pass the date
    }
    public function edit_post($post_id)
    {
        $this->form_validation->set_rules("post_title", "Post Title", "required");
        $this->form_validation->set_rules("post_description", "Post Description", "required");
        $this->form_validation->set_rules("post_image_name", "Post Image", "required");
        // $this->form_validation->set_rules("post_views", "Views", "required");
        $this->form_validation->set_rules("post_status", "Status", "required");

        if ($this->form_validation->run()) {
            if ($this->posts_model->update_post($post_id)) {
                $this->session->set_flashdata('success', 'post ID: ' . $post_id . ' updated successfully');

                redirect('administration/posts');

            } else {
                $post = $this->posts_model->get_single_post($post_id);

                $row = $post->row();
                $v_data['post_title'] = $row->post_title;
                $v_data['post_description'] = $row->post_description;
                $v_data['post_image_name'] = $row->post_image_name;
                $v_data['post_views'] = $row->post_views;
                $v_data['post_status'] = $row->post_status;
                $v_data['post_image_name'] = $row->post_image_name;
                $v_data['post_image_name'] = $row->post_thumb_name;

                // $v_data['query'] = $this->posts_model->get_single_post($post_id);
                // $v_data['posts'] = $this->posts_model->all_posts();

                $data = array(
                    "title" => $this->site_model->display_page_title(),
                    "content" => $this->load->view("posts/all_posts", $v_data, true),
                );

                $this->load->view("administration/layouts/layout", $data);
            }

        }
    }
    // public function search_posts()
    // {
    //     $post_name = $this->input->post('post_name');
    //     $post_girls_number = $this->input->post('post_girls_number');
    //     $post_boys_number = $this->input->post('post_boys_number');
    //     $post_location_name = $this->input->post('post_location_name');
    //     $post_status = $this->input->post('post_status');
    //     // $location_radius = $this->input->post('location_radius');

    //     if (!empty($post_name)) {
    //         $search_title .= ' post: <strong>' . $post_name . '</strong>';
    //         $post_name = ' AND post.post_name = \'+' . $post_name . '\'';
    //     }

    //     if (!empty($post_girls_number)) {
    //         $search_title .= ' Number of Girls <strong>' . $post_girls_number . '</strong>';
    //         $post_girls_number = ' AND post.post_girls_number = \'' . $post_girls_number . '\'';
    //     }
    //     if (!empty($post_boys_number)) {
    //         $search_title .= ' Number of boys <strong>' . $post_boys_number . '</strong>';
    //         $post_boys_number = ' AND post.post_boys_number = \'' . $post_boys_number . '\'';
    //     }
    //     if (!empty($post_location_name)) {
    //         $search_title .= ' Number of Girls <strong>' . $post_location_name . '</strong>';
    //         $post_location_name = ' AND post.post_location_name = \'' . $post_location_name . '\'';
    //     }
    //     if (!empty($post_status)) {
    //         $search_title .= ' Number of Girls <strong>' . $post_status . '</strong>';
    //         $post_status = ' AND post.post_status = \'' . $post_status . '\'';
    //     }

    //     $search = $post_name . $post_girls_number . $post_boys_number . $post_location_name . $post_status;

    //     $this->session->set_userdata('posts_search', $search);
    //     $this->session->set_userdata('posts_search_title', $search_title);

    //     redirect("administration/posts");
    // }

    // public function close_search()
    // {
    //     $this->session->unset_userdata('posts_search');
    //     $this->session->unset_userdata('posts_search_title');

    //     redirect("administration/posts");
    // }

    public function single_post($post_id)
    {
        $v_data['query'] = $this->posts_model->get_single_post($post_id);
        $v_data['title'] = "View";
        $query = $this->posts_model->get_single_post($post_id);

        $data['content'] = $this->load->view('posts/single_post', $v_data, true);

        $this->load->view("administration/layouts/layout", $data);
    }
    public function search_posts()
    {
        $post_id = $this->input->post('search_param');
        $search_title = '';

        if (!empty($post_id)) {
            $search_title .= ' post ID <strong>' . $post_id . '</strong>';
            $post_id = ' AND post.post_id = ' . $post_id;
        }

        $search = $post_id;
        $this->session->set_userdata('posts_search', $search);
        $this->session->set_userdata('posts_search_title', $search_title);
        redirect("administration/posts");
    }
    public function delete_post($post_id)
    {
        if ($this->posts_model->delete_post($post_id)) {
            $this->session->set_flashdata('success', 'Deleted successfully');
            redirect('administration/posts');
        } else {
            $this->session->set_flashdata('error', 'Unable to delete, Try again!!');
            redirect('administration/posts');
        }
    }
}