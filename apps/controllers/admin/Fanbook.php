<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fanbook extends MY_Controller{

	public function __construct ()
	{
		parent::__construct();
		$this -> load -> model("Fanbook_model");
		$this -> data['breadcrumb'] = "Fanbook";
		//$this -> data['active_tabs'] = "catalog";
		$config['upload_path'] = 'img/fanbook';
		$config['allowed_types'] = 'jpeg|jpg|png|gif';
		$config['max_size'] = 1000000;
		$config['remove_spaces'] = TRUE;
		$this->load->library('upload', $config);
                $this -> data['active_tabs'] = 'Posts';
		$this -> load -> model('Fanbook_model');
		$role = $this -> session -> userdata('role');
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
	}
	function index($offset = 1){
		$this->data['main']  = admin_view('fanbook/index');
		$this -> data['keyword'] = '';
		$this -> data['per_page'] = 40;
		$offset = ($offset - 1) * $this -> data['per_page'];
		$data_arr = $this -> Fanbook_model -> getAll($offset, $this -> data['per_page'], 'fanbook');
		$this -> data['data'] = $data_arr['results'];

		$config = array();

		$config['base_url'] = admin_url('fanbook/index');
		$config['num_links'] = 5;
		$config['uri_segment'] = 4;
		$config['total_rows'] = $data_arr['total'];
		$config['per_page'] = $this -> data['per_page'];
		$config['full_tag_open'] = '<ul class="pagination pagination-sm">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></b></li>';
		$config['use_page_numbers'] = true;

		$this->pagination->initialize($config);

		$this -> data['links'] = $this->pagination->create_links();

		$this->load->view( admin_view('default'), $this->data);
	}

	public function add($id = false){
		$this -> data['main'] = 'admin/fanbook/add';
		$this -> data['m'] = $this -> Fanbook_model -> addFanbook();
		
				
		if($id){
			$this -> data['m'] = $this -> Fanbook_model -> getFanbook($id);
		}
		//$this -> form_validation -> set_rules("data[brand_id]", "Select Brand", "required");
		$this -> form_validation -> set_rules("data[title]", "Fanbook Set", "required");
		if($this -> form_validation -> run()){
		//Check whether user upload picture
            if(!empty($_FILES['picture']['name'])){
                $config['upload_path'] = upload_dir();
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['picture']['name'];
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('picture')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    echo $this -> upload -> display_errors();
                }
            }
			
			$data = $this -> input -> post('data');
			$data['id'] = $id;
			$data['user_id'] = 1;
			$data['image'] = $picture;
			$data['created'] = date("Y-m-d h:i:sa");
			//$data['features'] = json_encode($features);
			$this -> Fanbook_model -> saveFanbook($data);
			$this -> session -> set_flashdata('success', "Fanbook details saved successfully");
			redirect(admin_url('fanbook/add/'.$id));
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
				
	}

	public function publish($id = false){
		$data['status'] = 1;
		if($id){
			$data['id'] = $id;
			$this -> Fanbook_model -> saveFanbook($data);
			$this -> session -> set_flashdata('success', 'Fanbook Set publish saved');
		}else{
			$ids = $this -> input -> post('ids');
			if(is_array($ids)){
				foreach($ids as $id){
					$data['id'] = $id;
					$this -> Fanbook_model -> saveFanbook($data);
				}
			}
			$this -> session -> set_flashdata('success', 'Fanbook Set publish updated');
		}
		redirect('admin/fanbook');
	}

	public function unpublish($id = false){
		$data['status'] = 0;
		if($id){
			$data['id'] = $id;
			$this -> Fanbook_model -> saveFanbook($data);
			$this -> session -> set_flashdata('success', 'Fanbook Set unpublish saved');
		}else{
			$ids = $this -> input -> post('ids');
			if(is_array($ids)){
				foreach($ids as $id){
					$data['id'] = $id;
					$this -> Fanbook_model -> saveFanbook($data);
				}
			}
			$this -> session -> set_flashdata('success', 'Fanbook Set unpublish updated');
		}
		redirect('admin/fanbook');
	}

	public function delete($id = false){
		$data['status'] = 1;
		if($id){
			$this -> Fanbook_model -> delete($id);
			$this -> session -> set_flashdata('success', 'Fanbook deleted successfully');
		}else{
			$ids = $this -> input -> post('ids');
			if(is_array($ids)){
				foreach($ids as $id){
					$this -> Fanbook_model -> delete($id);
				}
			}
			$this -> session -> set_flashdata('success', 'Bulk Fanbook deleted');
		}
		redirect('admin/fanbook');
	}

	public function addbrand($id = false){
		$this -> data['main'] = 'admin/mobile/add-brand';
		$this -> data['brand'] = $this -> Mobile_model -> getNew();
		if($id){
			$this -> data['brand'] = $this -> Mobile_model -> getRow($id);
			$this -> form_validation -> set_rules("data[brand]", "Brand Name", "required");
		}else{
			$this -> form_validation -> set_rules("data[brand]", "Brand Name", "required|is_unique[mobile_brand.brand]", array(
				'is_unique' => 'This brand is already available'
			));
		}
		if($this -> form_validation -> run()){
			$data = $this -> input -> post('data');
			$data['id'] = $id;
			$id = $this -> Mobile_model -> save($data);
			$this -> session -> set_flashdata('success', "Mobile Brand details saved successfully");
			redirect(admin_url('mobiles/brands'));
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}

	function import_files(){
		$this -> data['main'] = admin_view('fanbook/import-file');
		if($this -> input -> post('import_btn')){
			$count = 0;
			if($_FILES['excel_file']['name'] <> ''){
				$fn = $_FILES['excel_file']['tmp_name'];
				$file = fopen($fn, "r");
				while(($tp = fgetcsv($file, 10000, ",")) !== FALSE){
					$count++;
					if($count > 1) {
						$this -> check_nd_update($tp);
					}
				}
			}
		}
		$this -> load -> view(admin_view('default'), $this -> data);
	}

	function check_nd_update($tp){
		$data = array();
		$data['id'] = false;
		$data['brand_id'] = $this -> mobile_m -> get_brand_id($tp[0]);
		$data['title'] = $tp[1];
		$data['status'] = 1;

		$features = array();
		if($tp[2] == 'Y'){
			$features[] = '3D';
		}
		if($tp[3] == 'Y'){
			$features[] = '2D';
		}
		if($tp[4] == 'Y'){
			$features[] = 'Transparent 2D';
		}
		$data['features'] = json_encode($features);
		if($this -> Mobile_m -> check_duplicate($data['brand_id'], $data['title']) == false){
			$this -> Mobile_m -> saveMobile($data);
		}
	}

	public function covers($offset = 1){
		$this -> data['meta_title'] = "Mobile";
		$this -> data['sub_title'] = "Covers";
		$this -> data['main'] = 'admin/mobile/covers-index';
		$this -> data['keyword'] = '';
		$this -> data['per_page'] = 40;

		$offset = ($offset - 1) * $this -> data['per_page'];
		$this -> master_m -> table = "mobile_covers";
		$data_arr = $this -> master_m -> all($offset, $this -> data['per_page']);
		$this -> data['data'] = $data_arr -> data;

		$config = array();

		$config['base_url'] = base_url('admin/mobile/covers');
		$config['num_links'] = 5;
		$config['uri_segment'] = 4;
		$config['total_rows'] = $data_arr -> total;
		$config['per_page'] = $this -> data['per_page'];
		$config['full_tag_open'] = '<ul class="pagination pagination-sm">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></b></li>';
		$config['use_page_numbers'] = true;

		$this->pagination->initialize($config);
		$this -> data['links'] = $this->pagination->create_links();

		$this -> load -> view(admin_view('default'), $this -> data);
	}

	function addcover($id = false){
		$this -> data['meta_title'] = "Mobile";
		$this -> data['sub_title'] = "Add Covers";
		$this -> data['breadcrumb'] = "Add Mobile Covers";
		$this -> data['main'] = 'admin/mobile/add-product';

		$data = $this -> mobile_m -> newCover();
		$data -> id = $id;
		$this -> data['data'] = $data;
		$this -> data['albrands'] = $this -> mobile_m -> allBrands();
		if($id){
			$this -> data['data'] = $this -> mobile_m -> getCover($id);
		}

		$this -> form_validation -> set_rules('data[pname]', 'Product name', 'required');
		if($this -> form_validation -> run()){
			$p = $this -> input -> post('data');
			$p['id'] = $id;
			$p['created'] = date('Y-m-d h:i:s');
			$id = $this -> mobile_m -> saveCover($p);
			$this -> session -> set_flashdata("success", "Mobile cover saved successfully");
			redirect('admin/mobile/addcover/' . $id);
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}
}
