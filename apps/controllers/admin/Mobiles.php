<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobiles extends MY_Controller{

	public function __construct ()
	{
		parent::__construct();
		$this -> load -> model("Mobile_model");
        $this -> load -> helper("file");
		$this -> data['breadcrumb'] = "Mobile Sets";
		$this -> data['active_tabs'] = "electronics";
		$role = $this -> session -> userdata('role');
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
	}
	
	function bulksave(){

        $url = admin_url('stock');
        if($this -> input -> post('frmall')) {
            $url = $this -> input -> post('url');
            $pids = $this -> input -> post('sequence');
            //$ship = $this -> input -> post('ship');
            //print_r($pids); exit();
            $sequence = $this -> input -> post('sequence');
            foreach($pids as $id => $val){
                $item = array();
                $item['id'] = $id;
                $item['sequence'] = $sequence[$id];
                $this -> Master_model -> save($item,'mobile_set');
            }
            $this -> session -> set_flashdata("success", "Bulk Details Updated");
        }
        redirect($url);
    }
	
	function index($offset = 1){
		$this->data['main']  = admin_view('mobile/index');
		$this -> data['keyword'] = '';
		$this -> data['per_page'] = 40;
		$offset = ($offset - 1) * $this -> data['per_page'];
		$data_arr = $this -> Mobile_model -> getAll($offset, $this -> data['per_page'], 'mobile_set');
		$this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'title' => $q, 'id' => $q, 'about' => $q
                );
                $data_arr = $this -> Mobile_model -> getAllSearched($offset, $this -> data['per_page'], $likes, 'mobile_set');
                $this -> data['q'] = $q;
            }
        }
		$this -> data['data'] = $data_arr['results'];

		$config = array();

		$config['base_url'] = admin_url('mobiles/index');
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
		$this -> data['max_sequence']=$this -> Mobile_model->max_sequence();
		$this->load->view( admin_view('default'), $this->data);
	}

	public function add($id = false){
        $config['upload_path']		= 'img/uploads';
        $config['allowed_types']	= 'gif|jpg|png|jpeg|bmp';
        $config['max_size']			= '50000';
        $config['max_width']		= '30000';
        $config['max_height']		= '20000';
        $this->load->library('upload', $config);

		$this -> data['main'] = 'admin/mobile/add';
		$this -> data['m'] = $this -> Mobile_model -> addMobile();
		$this -> data['m'] -> features = json_encode(array());
		$this -> data['brands'] = $this -> Mobile_model -> allBrands();
		if($id){
			$this -> data['m'] = $this -> Mobile_model -> getMobile($id);
		}
		$this -> form_validation -> set_rules("data[brand_id]", "Select Brand", "required");
		$this -> form_validation -> set_rules("data[title]", "Mobile Set", "required");
		if($this -> form_validation -> run()){
			$features = array();
			if($this -> input -> post('features')){
				$features = $this -> input -> post('features');
			}
			$data = $this -> input -> post('data');
			$data['id'] = $id;
            $uploaded	= $this->upload->do_upload('image');
            if($uploaded)
            {
                $image			= $this->upload->data();
                $data['image']	= $image['file_name'];
            }
			$data['features'] = json_encode($features);
			$this -> Mobile_model -> saveMobile($data);
			$this -> session -> set_flashdata('success', "Mobile Set details saved successfully");
			redirect(admin_url('mobiles/add/'.$id));
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}

	public function publish($id = false){
		$data['status'] = 1;
		if($id){
			$data['id'] = $id;
			$this -> Mobile_model -> saveMobile($data);
			$this -> session -> set_flashdata('success', 'Mobile Set publish saved');
		}else{
			$ids = $this -> input -> post('ids');
			if(is_array($ids)){
				foreach($ids as $id){
					$data['id'] = $id;
					$this -> Mobile_model -> saveMobile($data);
				}
			}
			$this -> session -> set_flashdata('success', 'Mobile Set publish updated');
		}
		redirect('admin/mobiles');
	}

	public function unpublish($id = false){
		$data['status'] = 0;
		if($id){
			$data['id'] = $id;
			$this -> Mobile_model -> saveMobile($data);
			$this -> session -> set_flashdata('success', 'Mobile Set unpublish saved');
		}else{
			$ids = $this -> input -> post('ids');
			if(is_array($ids)){
				foreach($ids as $id){
					$data['id'] = $id;
					$this -> Mobile_model -> saveMobile($data);
				}
			}
			$this -> session -> set_flashdata('success', 'Mobile Set unpublish updated');
		}
		redirect('admin/mobiles');
	}

	public function delete($id = false){
		$data['status'] = 1;
		if($id){
			$this -> Mobile_model -> delete($id, 'mobile_set');
			$this -> session -> set_flashdata('success', 'Mobile deleted successfully');
		}else{
			$ids = $this -> input -> post('ids');
			if(is_array($ids)){
				foreach($ids as $id){
					$this -> Mobile_model -> delete($id, 'mobile_set');
				}
			}
			$this -> session -> set_flashdata('success', 'Bulk mobile deleted');
		}
		redirect('admin/mobiles');
	}

	public function delbrand($id = false){
		$data['status'] = 1;
		if($id){
			$this -> Mobile_model -> delBrands($id);
			$this -> session -> set_flashdata('success', 'Brand deleted successfully');
		}else{
			$ids = $this -> input -> post('ids');
			if(is_array($ids)){
				foreach($ids as $id){
					$this -> Mobile_model -> delBrands($id);
				}
			}
			$this -> session -> set_flashdata('success', 'Bulk deleted');
		}
		redirect('admin/mobiles/brands');
	}

	public function brands($offset = 1){
		$this -> data['main'] = admin_view('mobile/brands-index');
		$this -> data['keyword'] = '';
		$this -> data['per_page'] = 40;

		$offset = ($offset - 1) * $this -> data['per_page'];

		$data_arr = $this -> Mobile_model -> getAll($offset, $this -> data['per_page']);
		$this -> data['data'] = $data_arr['results'];

		$config = array();

		$config['base_url'] = admin_url('mobile/brands');
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

		$this -> load -> view(admin_view('default'), $this -> data);
	}

	public function addbrand($id = false){
        $config = array();
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 3000;
        $config['upload_path'] = upload_dir();
        $this->load->library('upload', $config);
        //echo upload_dir();
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
            $uploaded = $this -> upload -> do_upload('image');
            if($uploaded){
                $data['image'] = $this -> upload -> data('file_name');
            }
			$data['id'] = $id;
			$id = $this -> Mobile_model -> save($data);
			$this -> session -> set_flashdata('success', "Mobile Brand details saved successfully");
			redirect(admin_url('mobiles/brands'));
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}

	function import_files(){
		$this -> data['main'] = admin_view('mobile/import-file');
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
		$data['brand_id'] = $this -> Mobile_model -> get_brand_id($tp[0]);
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
        //if($this->Mobile_model->check_dupcat($data['id'],$data['name'])==false)
		if($this -> Mobile_model -> check_duplicate($data['brand_id'], $data['title']) == false){
			$this -> Mobile_model -> saveMobile($data);
            $this -> session -> set_flashdata('success', "Data Imported Successfully");
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

    function get_models($brand_id){
        echo(json_encode($this->Mobile_model->get_models_by_brands($brand_id)));
    }
}
