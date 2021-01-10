<?php
class Gallery extends MY_Controller{

	public function __construct(){
		parent::__construct();
        $this -> load -> model('Gallery_model');
		$this -> data['active_tabs'] = 'media';

		$config = array();
		$config['upload_path'] = upload_dir();
		$config['allowed_types'] = '*';
		$config['max_size'] = '0';
		$this->load->library('upload', $config);
		$role = $this -> session -> userdata('role');
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
	}
	public function index(){
		$this -> data['main'] = admin_view('gallery/index');
		$this -> data['gallery_list']	= $this -> Gallery_model -> getGalleries();
		$this -> load -> view(admin_view('default'), $this -> data);
	}
	public function create($id = false){
		$this -> data['main'] = admin_view('gallery/add');
		$this -> data['gallery'] = $this -> Gallery_model -> getNew('gallery');

		if($id){
			$this -> data['gallery'] = $this -> Gallery_model -> getRow($id);
		}
		$this -> form_validation -> set_rules('gal[gallery_name]', 'Gallery Name', 'required');

		if($this -> form_validation -> run() == false){
			$this -> load -> view(admin_view('default'), $this -> data);
		}else{
			$save	    = 	$this -> input -> post('gal');
			$save['id'] = $id;
			$save['sequence']		=	$this -> input -> post('sequence');
			$this -> Gallery_model -> save($save);
			$this -> session -> set_flashdata("success", 'Gallery Created Successfully');
			redirect(admin_url('gallery'));
		}
	}
	public function multiple($id = false){
		$this -> data['main'] = admin_view('gallery/multiple-upload');
		$this -> data['id'] = $id;
		$err_str = '';
		if($this -> input -> post('submit')){
			$total = count($_FILES['filesToUpload']['name']);
			$files = $_FILES;
			$save['gallery_id'] = $id;
			$save['title']		= $this -> input -> post('title');
			for($i = 0; $i < $total; $i++){
				$_FILES['filesToUpload']['name']= $files['filesToUpload']['name'][$i];
				$_FILES['filesToUpload']['type']= $files['filesToUpload']['type'][$i];
				$_FILES['filesToUpload']['tmp_name']= $files['filesToUpload']['tmp_name'][$i];
				$_FILES['filesToUpload']['error']= $files['filesToUpload']['error'][$i];
				$_FILES['filesToUpload']['size']= $files['filesToUpload']['size'][$i];

				if($this -> upload -> do_upload('filesToUpload') == False) {
					$err_str .= $this->upload->display_errors();
				}else{
					$imgdata = $this -> upload -> data();
					$save['image'] = $imgdata['file_name'];
					$this-> Gallery_model -> saveImage($save);
				}
			}
			$this -> session -> set_flashdata('success', 'Gallery saved successfully');
			redirect(admin_url('gallery'));
		}
		$this -> load -> view(admin_view('default'), $this -> data);
	}

	public function view($id){
		$this -> data['main'] = admin_view('gallery/view-images');
		$this -> data['id']		= $id;
		$this -> data['image_list']	= $this -> Gallery_model -> getImages($id);
		$gallery = $this -> Gallery_model -> getRow($id);
		$this -> data['gallery_name'] 	= 	$gallery -> gallery_name;
		$this -> load -> view(admin_view('default'), $this -> data);
	}
	public function delete($id = false){
		if($id){
			$this -> Gallery_model -> delete($id);
			$this -> session -> set_flashdata('success', 'Gallery Deleted Successfully');
			redirect(admin_url('gallery'));
		}
	}
	public function delete_image($gallery_id, $id = false){
		if($id){
			$this -> Gallery_model -> delete($id, 'gallery_img');
			$this -> session -> set_flashdata('success', 'Image Deleted Successfully');
		}
		redirect(admin_url('gallery/view/'.$gallery_id));
	}
	public function edit_image($id = false){
		$this -> data['main'] = admin_view('gallery/edit-image');
		$this -> data['id']	= $id;
		$cat_id = false;
		if($id){
			$image = $this -> Gallery_model -> getImage($id);
			$this -> data['image'] 	= $image ;
			$cat_id = $image -> gallery_id;
		}
		if($this -> input -> post('submit')){
			$save = $this -> input -> post('im');
			$save['id']		= $id;
            $save['new_tab'] = $this -> input -> post('new_tab') ? 1 : 0;
			$this -> Gallery_model -> save_image($save);
			$this -> session -> set_flashdata('success', "Gallery Image Saved");
			redirect(admin_url('gallery/view/'.$cat_id));
		}
		$this -> load -> view(admin_view('default'), $this -> data);
	}

    function save_all(){
        $url = $this -> input -> post('url');
        $sequence = $_POST['sequence'];
        foreach($sequence as $id => $val){
            $item = array();
            $item['id'] = $id;
            $item['sequence'] = $val;
            $this -> Master_model -> save($item, 'gallery_img');
            //echo $this -> db -> last_query(); exit;
        }
        $this -> session -> set_flashdata("success", "Bulk Sequence Updated");
        redirect($url);
    }

}
