<?php
class Posts extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $config['upload_path']		= upload_dir();
        $config['allowed_types']	= 'gif|jpg|png|jpeg';
        $config['max_width']		= '4000';
        $config['max_height']		= '4000';
        $this->load->library('upload', $config);
        $this -> data['active_tabs'] = 'Posts';
        $this -> load -> model('Master_model');
        $this->load->model('Blogcat_model');
        $this->load->model('Post_model');
    }

    public function index($offset = 0){
        $show_per_page = 40;
        $this -> data['main'] = admin_view('post/index');
        $arr_result = $this -> Post_model -> getAllPosts($offset, $show_per_page);
        $this -> data['post_list']  = $arr_result['results'];
        $config['base_url'] 	 = admin_url('post/index');
        $config['num_links'] 	 = 2;
        $config['uri_segment']	 = 4;
        $config['total_rows']	 = $arr_result['total'];
        $config['per_page'] 	 = $show_per_page;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close']= '</ul>';
        $config['num_tag_open']  = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link'] 	 = 'First';
        $config['first_tag_open']= '<li>';
        $config['first_tag_close']= '</li>';
        $config['last_link'] 	 = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close']= '</li>';
        $config['prev_link'] 	 = 'Prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close']= '</li>';
        $config['next_link'] 	 = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close']= '</li>';
        $config['cur_tag_open']	 = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);

        $this -> data['paginate'] 	=  $this->pagination->create_links();

        $this -> load -> view(admin_view('default'), $this -> data);
    }


    public function add_post($id = false){
        $this -> data['post_type'] = 'post';
        $this -> data['main'] = admin_view('post/add');
        $this -> data['p'] = $this -> Post_model -> getNew();
        $layouts = $this -> config -> item('layouts');
        $this -> data['layouts'] = $layouts['posts'];
        $this -> data['parents'] = $this -> Blogcat_model -> categories();
        if($id){
            $this -> data['p'] = $this -> Post_model -> getRow($id);
        }
        $this -> form_validation -> set_rules('frm[post_title]', 'Title', 'required');
        if($this -> form_validation -> run()){
            $save = $this -> input -> post('frm');
            if($this -> input -> post('del_img')){
                $del_img = $this -> input -> post('hid_img');
                unlink(upload_dir($del_img));
                $save['image'] = '';
            }
            $save['id'] = $id;
            $save['post_type'] = 'post';
            $uploaded	= $this->upload->do_upload('image');
            if($uploaded){
                $image			= $this->upload->data();
                $save['image']	= $image['file_name'];
            }
            $save['created'] 			= date('Y-m-d');
            $slug 						= $save['slug'];
            if(empty($slug) || $slug==''){
                $slug = $save['post_title'];
            }
            $slug	= strtolower(url_title($slug));
            $save['slug']	= $this -> Post_model -> get_unique_url($slug, $id);
            $id	= $this-> Post_model ->save($save);

            //////////////////////////////////////////////////////////////Update Post Table Route ID
            //$save = array();
            //$save['id'] = $id;
            //$save['route_id'] = $route_id;
            //$this -> Post_model -> save($save);

            $this -> session -> set_flashdata('success', 'Post saved successfully');
            redirect(admin_url('posts/add-post/'.$id));
        }else{
            $this -> load -> view(admin_view('default'), $this -> data);
        }
    }

    function activate($id = false){
        //$redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('posts');
		$redirect = admin_url('posts');
        if($id){
            $c['id'] = $id;
            $c['status'] = 1;
            $this -> Post_model -> save($c);
            $this -> session -> set_flashdata("success", "Post published");
        }
        redirect($redirect);
    }

    function deactivate($id = false){
        //$redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('posts');
		$redirect = admin_url('posts');
		$redirect = urldecode($redirect);
        if($id){
            $c['id'] = $id;
            $c['status'] = 0;
            $this -> Post_model -> save($c);
            $this -> session -> set_flashdata("success", "Posts saved to draft");
        }
        redirect($redirect);
    }

    function delete($id = false){
        if($id){
            $p = $this -> Post_model -> getRow($id);
            $this -> Post_model -> delete($id);
            $this -> session -> set_flashdata("success", "Posts deleted successfully");
            if($p -> post_type == 'page'){
                redirect(admin_url('posts/pages'));
            }
        }
        redirect(admin_url('posts'));
    }

}
