<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brands extends MY_Controller{

	public function __construct ()
	{
		parent::__construct();
		$this -> load -> model("Brand_model");
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
		$this->data['main']  = admin_view('brands/index');
		$this -> data['keyword'] = '';
		$this -> data['per_page'] = 40;
		$offset = ($offset - 1) * $this -> data['per_page'];
		$data_arr = $this -> Brand_model -> getAll($offset, $this -> data['per_page'], 'cloths_brand');
		$this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'title' => $q, 'id' => $q, 'about' => $q
                );
                $data_arr = $this -> Brand_model -> getAllSearched($offset, $this -> data['per_page'], $likes, 'cloths_brand');
                $this -> data['q'] = $q;
            }
        }
		$this -> data['data'] = $data_arr['results'];
		$config = array();
		$config['base_url'] = admin_url('brands/index');
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
		//$this -> data['max_sequence']=$this -> Brand_model->max_sequence();
		$this->load->view( admin_view('default'), $this->data);
	}

	public function add_cloth_brands($id = false){
		$config['upload_path']          = upload_dir();
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = '150';
        $config['max_width']            = '';
        $config['max_height']           = '';
		$this -> data['main'] = 'admin/brands/add-cloth-brands';
		$this -> data['m'] = $this -> Brand_model -> addCloth();
		if($id){
			$this -> data['m'] = $this -> Master_model -> getrow($id,'cloths_brand');
		}
		$this -> form_validation -> set_rules("data[title]", "Brand Name", "required");
		if($this -> form_validation -> run()){
			$data = $this -> input -> post('data');
			$data['id'] = $id;
			 $this->load->library('upload', $config);
                if (  $this->upload->do_upload('image'))
                {
                	
					$img = array('upload_data' => $this->upload->data());
                	$data['images'] = $this->upload->data('file_name'); 
                	// $error = array('error' => $this->upload->display_errors());
                 //    $this->session->set_flashdata('error',$error['error']);
                 //     redirect(admin_url('brands/add_marble_brands/'.$id));
                }

			$pid = $this -> Brand_model -> saveClothBrands($data);
			$this -> session -> set_flashdata('success', "Cloths Brands details saved successfully");
			redirect(admin_url('brands/add_cloth_brands/'.$pid));
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}

	public function delete_cloths($id = false){
		$data['status'] = 1;
		if($id){
			$this -> Master_model -> delete($id, 'cloths_brand');
			$this -> session -> set_flashdata('success', 'Cloths Brand deleted successfully');
		}
		redirect('admin/Brands');
	}

	function grocery($offset = 1){
		$this->data['main']  = admin_view('brands/grocery');
		$this -> data['keyword'] = '';
		$this -> data['per_page'] = 40;
		$offset = ($offset - 1) * $this -> data['per_page'];
		$data_arr = $this -> Brand_model -> getAll($offset, $this -> data['per_page'], 'grocery_brand');
		$this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'title' => $q, 'id' => $q, 'about' => $q
                );
                $data_arr = $this -> Brand_model -> getAllSearched($offset, $this -> data['per_page'], $likes, 'grocery_brand');
                $this -> data['q'] = $q;
            }
        }
		$this -> data['data'] = $data_arr['results'];
		$config = array();
		$config['base_url'] = admin_url('brands/grocery');
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
		//$this -> data['max_sequence']=$this -> Brand_model->max_sequence();
		$this->load->view( admin_view('default'), $this->data);
	}

	public function add_grocery_brands($id = false){
		$config['upload_path']          = upload_dir();
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = '150';
        $config['max_width']            = '';
        $config['max_height']           = '';
		$this -> data['main'] = 'admin/brands/add-grocery-brands';
		$this -> data['m'] = $this -> Brand_model -> addgrocery();
		if($id){
			$this -> data['m'] = $this -> Master_model -> getrow($id,'grocery_brand');
		}
		$this -> form_validation -> set_rules("data[title]", "Brand Name", "required");
		if($this -> form_validation -> run()){
			$data = $this -> input -> post('data');
			$data['id'] = $id;
			$this->load->library('upload', $config);
                if (  $this->upload->do_upload('image'))
                {
                	
					$img = array('upload_data' => $this->upload->data());
                	$data['images'] = $this->upload->data('file_name'); 
                	// $error = array('error' => $this->upload->display_errors());
                 //    $this->session->set_flashdata('error',$error['error']);
                 //     redirect(admin_url('brands/add_marble_brands/'.$id));
                }
			$pid = $this -> Brand_model -> saveGroceryBrands($data);
			$this -> session -> set_flashdata('success', "Grocery Brands details saved successfully");
			redirect(admin_url('brands/add_grocery_brands/'.$pid));
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}

	public function delete_grocery($id = false){
		$data['status'] = 1;
		if($id){
			$this -> Master_model -> delete($id, 'grocery_brand');
			$this -> session -> set_flashdata('success', 'Grocery Brand deleted successfully');
		}
		redirect('admin/Brands/grocery');
	}

	function health($offset = 1){
		$this->data['main']  = admin_view('brands/healths');
		$this -> data['keyword'] = '';
		$this -> data['per_page'] = 40;
		$offset = ($offset - 1) * $this -> data['per_page'];
		$data_arr = $this -> Brand_model -> getAll($offset, $this -> data['per_page'], 'health_brands');
		$this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'title' => $q, 'id' => $q, 'about' => $q
                );
                $data_arr = $this -> Brand_model -> getAllSearched($offset, $this -> data['per_page'], $likes, 'health_brands');
                $this -> data['q'] = $q;
            }
        }
		$this -> data['data'] = $data_arr['results'];
		$config = array();
		$config['base_url'] = admin_url('brands/health');
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
		//$this -> data['max_sequence']=$this -> Brand_model->max_sequence();
		$this->load->view( admin_view('default'), $this->data);
	}

	public function add_health_brands($id = false){
		$config['upload_path']          = upload_dir();
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = '150';
        $config['max_width']            = '';
        $config['max_height']           = '';
		$this -> data['main'] = 'admin/brands/add-health-brands';
		$this -> data['m'] = $this -> Brand_model -> addhealth();
		if($id){
			$this -> data['m'] = $this -> Master_model -> getrow($id,'health_brands');
		}
		$this -> form_validation -> set_rules("data[title]", "Brand Name", "required");
		if($this -> form_validation -> run()){
			$data = $this -> input -> post('data');
			$data['id'] = $id;
			$this->load->library('upload', $config);
                if (  $this->upload->do_upload('image'))
                {
                	
					$img = array('upload_data' => $this->upload->data());
                	$data['images'] = $this->upload->data('file_name'); 
                	// $error = array('error' => $this->upload->display_errors());
                 //    $this->session->set_flashdata('error',$error['error']);
                 //     redirect(admin_url('brands/add_marble_brands/'.$id));
                }
			$pid = $this -> Brand_model -> saveHealthBrands($data);
			$this -> session -> set_flashdata('success', "Health Brand details saved successfully");
			redirect(admin_url('brands/add_health_brands/'.$pid));
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}

	public function delete_health($id = false){
		$data['status'] = 1;
		if($id){
			$this -> Master_model -> delete($id, 'health_brands');
			$this -> session -> set_flashdata('success', 'Health Brand deleted successfully');
		}
		redirect('admin/Brands/health');
	}

	function marble($offset = 1){
		$this->data['main']  = admin_view('brands/marbles');
		$this -> data['keyword'] = '';
		$this -> data['per_page'] = 40;
		$offset = ($offset - 1) * $this -> data['per_page'];
		$data_arr = $this -> Brand_model -> getAll($offset, $this -> data['per_page'], 'marble_brands');
		$this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'title' => $q, 'id' => $q, 'about' => $q
                );
                $data_arr = $this -> Brand_model -> getAllSearched($offset, $this -> data['per_page'], $likes, 'marble_brands');
                $this -> data['q'] = $q;
            }
        }
		$this -> data['data'] = $data_arr['results'];
		$config = array();
		$config['base_url'] = admin_url('brands/marble');
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
		//$this -> data['max_sequence']=$this -> Brand_model->max_sequence();
		$this->load->view( admin_view('default'), $this->data);
	}

	public function add_marble_brands($id = false){
		$config['upload_path']          = upload_dir();
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = '150';
        $config['max_width']            = '';
        $config['max_height']           = '';
		$this -> data['main'] = 'admin/brands/add-marble-brands';
		$this -> data['m'] = $this -> Brand_model -> addMarble();
		if($id){
			$this -> data['m'] = $this -> Master_model -> getrow($id,'marble_brands');
		}
		$this -> form_validation -> set_rules("data[title]", "Brand Name", "required");
		if($this -> form_validation -> run()){
			$data = $this -> input -> post('data');
			$data['id'] = $id;
			$this->load->library('upload', $config);
                if (  $this->upload->do_upload('image'))
                {
                	
					$img = array('upload_data' => $this->upload->data());
                	$data['images'] = $this->upload->data('file_name'); 
                	// $error = array('error' => $this->upload->display_errors());
                 //    $this->session->set_flashdata('error',$error['error']);
                 //     redirect(admin_url('brands/add_marble_brands/'.$id));
                }
                
			$pid = $this -> Brand_model -> saveMarbleBrands($data);
			$this -> session -> set_flashdata('success', "Marble Brands details saved successfully");
			redirect(admin_url('brands/add_marble_brands/'.$pid));
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}

	public function delete_marble($id = false){
		$data['status'] = 1;
		if($id){
			$this -> Master_model -> delete($id, 'marble_brands');
			$this -> session -> set_flashdata('success', 'Marble Brand deleted successfully');
		}
		redirect('admin/Brands/marble');
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
    
    
    function electronic($offset = 1){
		$this->data['main']  = admin_view('brands/electronic');
		$this -> data['keyword'] = '';
		$this -> data['per_page'] = 40;
		$offset = ($offset - 1) * $this -> data['per_page'];
		$data_arr = $this -> Brand_model -> getAll($offset, $this -> data['per_page'], 'electronic_brands');
		$this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'title' => $q, 'id' => $q, 'about' => $q
                );
                $data_arr = $this -> Brand_model -> getAllSearched($offset, $this -> data['per_page'], $likes, 'electronic_brands');
                $this -> data['q'] = $q;
            }
        }
		$this -> data['data'] = $data_arr['results'];
		$config = array();
		$config['base_url'] = admin_url('brands/electronic');
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
		//$this -> data['max_sequence']=$this -> Brand_model->max_sequence();
		$this->load->view( admin_view('default'), $this->data);
	}

	public function add_electronic_brands($id = false){
		$config['upload_path']          = upload_dir();
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = '150';
        $config['max_width']            = '';
        $config['max_height']           = '';
		$this -> data['main'] = 'admin/brands/add-electronic-brands';
		$this -> data['m'] = $this -> Brand_model -> addElectronic();
		if($id){
			$this -> data['m'] = $this -> Master_model -> getrow($id,'electronic_brands');
		}
		$this -> form_validation -> set_rules("data[title]", "Brand Name", "required");
		if($this -> form_validation -> run()){
			$data = $this -> input -> post('data');
			$data['id'] = $id;
			$this->load->library('upload', $config);
                if (  $this->upload->do_upload('image'))
                {
                	
					$img = array('upload_data' => $this->upload->data());
                	$data['images'] = $this->upload->data('file_name'); 
                	// $error = array('error' => $this->upload->display_errors());
                 //    $this->session->set_flashdata('error',$error['error']);
                 //     redirect(admin_url('brands/add_marble_brands/'.$id));
                }
                
			$pid = $this -> Brand_model -> saveElectronicBrands($data);
			$this -> session -> set_flashdata('success', "Electronic Brands details saved successfully");
			redirect(admin_url('brands/add-electronic-brands/'.$pid));
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}

	public function delete_electronic($id = false){
		$data['status'] = 1;
		if($id){
			$this -> Master_model -> delete($id, 'electronic_brands');
			$this -> session -> set_flashdata('success', 'Electronic Brand deleted successfully');
		}
		redirect('admin/Brands/electronic');
	}

	
}
