<?php
class Media extends MY_Controller{
	var $submenu;
	function __construct(){
		parent::__construct();
		$config['upload_path'] = upload_dir();
		$config['allowed_types'] = 'jpeg|jpg|png|gif|pdf|doc|docx|psd|txt|xls|ppt|zip';
		$config['max_size'] = 1000000;
		$config['remove_spaces'] = TRUE;
		$this->load->library('upload', $config);
		$this -> load -> model('Media_model');
		$this -> data['active_tabs'] = 'media';
		$role = $this -> session -> userdata('role');
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
	}
	public function index($page = 1){
        //echo upload_dir();
		$show_per_page = 20;
		$offset = ($page - 1) * $show_per_page;
		$this -> data['main'] = admin_view('media/index');
		$media = $this -> Media_model -> getAll($offset, $show_per_page);
		$this -> data['medias'] = $media['results'];
		$config['base_url'] 	 = admin_url('media/index');
		$config['num_links'] 	 = 2;
		$config['uri_segment']	 = 4;
		$config['total_rows']	 = $media['total'];
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
		$this->pagination->initialize($config);
		$this -> data['paginate'] 	=  $this->pagination->create_links();

		$this -> load -> view(admin_view('default'), $this -> data);
	}

	public function add(){
		$this -> data['main'] = admin_view('media/add');
		$this -> load -> library('upload');
		$err_str = '';
		if($this -> input -> post('submit')){
			$files = $_FILES;
			$count = count($_FILES['filesToUpload']['name']);
			for($i=0; $i<$count; $i++) {
				$_FILES['filesToUpload']['name']= $files['filesToUpload']['name'][$i];
				$_FILES['filesToUpload']['type']= $files['filesToUpload']['type'][$i];
				$_FILES['filesToUpload']['tmp_name']= $files['filesToUpload']['tmp_name'][$i];
				$_FILES['filesToUpload']['error']= $files['filesToUpload']['error'][$i];
				$_FILES['filesToUpload']['size']= $files['filesToUpload']['size'][$i];

				$config = array();
				$config['upload_path'] = upload_dir();
				$config['allowed_types'] = '*';
				$config['max_size'] = '0';
				$config['overwrite']     = FALSE;

				$this -> upload -> initialize($config);
				if($this -> upload -> do_upload('filesToUpload') == False) {
					$err_str .= $this->upload->display_errors();
				}else{
					$save = $this -> upload -> data();
					$save['img_title'] = $this -> input -> post('title');
					$save['id'] = false;
					$this-> Media_model -> save($save);
				}

			}
			$this -> session -> set_flashdata('success', 'Medial file uploaded');
			redirect(admin_url('media/add'));
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}
	public function edit($id = false){
		$this -> data['main'] = admin_view('media/edit');
		$this -> data['media'] = $this -> Media_model -> getRow($id);
		if($this -> input -> post('submit')){
			$s = $this -> input -> post('frm');
			$s['id'] = $id;
			if($this -> Media_model -> save($s)){
				$this -> session -> set_flashdata('success', 'Media file updated successfully');
			}else{
				$this -> session -> set_flashdata('error', 'Unable to update files');
			}
			redirect(admin_url('media'));
		}else{
			$this -> load -> view(admin_view('default'),$this -> data);
		}
	}
	public function delete($id){
		if($id > 0){
            $r = $this -> Media_model -> getRow($id);
            @unlink(upload_dir($r -> file_name));
            $this -> Media_model -> delete($id);
            $this -> session -> set_flashdata('success', 'Media file deleted successfully');
		}
		redirect(admin_url('media'));
	}
}
