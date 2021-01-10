<?php
class Pages extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$config['upload_path']		= 'img/';
		$config['allowed_types']	= 'gif|jpg|png|jpeg';
		$config['max_width']		= '4000';
		$config['max_height']		= '4000';
		$this->load->library('upload', $config);
		$this -> data['active_tabs'] = 'media';
		$this -> load -> model('Page_model');
		$role = $this -> session -> userdata('role');
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
	}
    public function index($offset = 0){
        $show_per_page = 40;
        $this -> data['main'] = admin_view('pages/index');
        $arr_result = $this -> Page_model -> getAll($offset, $show_per_page);
	    if($this -> input -> get('btnsearch')){
		    $q = $this -> input -> get('q');
		    if($q <> ''){
			    $likes = array(
				    'title' => $q, 'id' => $q
			    );
			    $arr_result = $this -> Page_model -> getAllSearched($offset, $show_per_page, $likes);
		    }
	    }
        $this -> data['post_list']  = $arr_result['results'];
        $config['base_url'] 	 = admin_url('pages/index');
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
	    $config['use_page_numbers'] = true;
	    $config['use_page_numbers'] = true;
	    $config['page_query_string'] = true;
	    $config['query_string_segment'] = 'page';
	    $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);

        $this -> data['paginate'] 	=  $this->pagination->create_links();

        $this -> load -> view(admin_view('default'), $this -> data);
    }
	public function add($id = false){
		$this -> data['main'] = admin_view('pages/add');
		$this -> data['p'] = $this -> Page_model -> getNew();
		if($id){
			$this -> data['p'] = $this -> Page_model -> getRow($id);
		}
		$this -> form_validation -> set_rules('frm[title]', 'Page Title', 'required');
		if($this -> form_validation -> run()){
			$save = $this -> input -> post('frm');
			if($this -> input -> post('del_img')){
				$del_img = $this -> input -> post('hid_img');
				unlink('img/' . $del_img);
				$save['image'] = '';
			}
			$save['id'] = $id;
			$uploaded	= $this->upload->do_upload('image');
			if($uploaded){
				$image			= $this->upload->data();
				$save['image']	= $image['file_name'];
			}
			$save['created'] 			= date('Y-m-d');
			$slug 						= $save['slug'];
			if(empty($slug) || $slug==''){
				$slug = $save['title'];
			}
			$slug	= strtolower(url_title($slug));
			$save['slug']	= $this -> Page_model -> get_unique_url($slug,$id);
			$id	= $this->Page_model->save($save);
			$this -> session -> set_flashdata('success', 'Page saved successfully');
			redirect(admin_url('pages/add/'.$id));
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}

	function activate($id = false){
		$redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('pages');
		if($id){
			$c['id'] = $id;
			$c['status'] = 1;
			$this -> Page_model -> save($c);
			$this -> session -> set_flashdata("success", "Page published");
		}
		redirect($redirect);
	}

	function deactivate($id = false){
		$redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('pages');
		if($id){
			$c['id'] = $id;
			$c['status'] = 0;
			$this -> Page_model -> save($c);
			$this -> session -> set_flashdata("success", "Product saved to draft");
		}
		redirect($redirect);
	}

	function delete($id = false){
		if($id){
			$this -> Page_model -> delete($id);
			$this -> session -> set_flashdata("success", "Page deleted successfully");
		}
		redirect(admin_url('pages'));
	}

}
