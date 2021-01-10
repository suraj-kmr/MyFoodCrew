<?php

class City extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model(array('Category_model', 'Setting_model', 'City_model'));
		$role = $this -> session -> userdata('role');
		$this -> data['active_tabs'] = 'Store_locator';
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
	}

	function index($offset = 0){
		$show_per_page = 100;
		$this->data['main'] = admin_view('city/index');
        //$this -> data['main'] = admin_view('category/index');
		$q = $this -> input -> get('q');

		$city_arr 		=	$this -> City_model -> getAll($offset, $show_per_page, $q);
		$this->data['city'] 	= 	$city_arr['results'];
		$config = array();
		$config['base_url'] 	 = base_url($this -> config -> item('admin_folder').'city/index');
		$config['num_links'] 	 = 5;
		$config['uri_segment']	 = 4;
		$config['total_rows']	 = $city_arr['total'];
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
		$config['cur_tag_close'] = '</a></b></li>';
		$config['enable_query_strings'] = true;
		$config['page_query_string'] = true;
		$config['reuse_query_string'] = true;
		$this->pagination->initialize($config);

		$this->data['paginate'] = $this->pagination->create_links();
		//$this->load->view($this -> config -> item('admin_folder').'default', $data);
        $this->load->view(admin_view('default'), $this -> data);
	}

    function add($id = FALSE) {
        $this->data['main'] = admin_view('city/add');
        $this->data['state'] = $this->City_model->getStates();
        $this->data['city'] = $this->City_model->getNew();
        $this->data['id']=$id;
        //$this -> data['topcities'] = $this -> City_model -> cities(0);
        if ($id) {
            //$city = $this->City_model->getRow($id);
            $this->data['city'] = $this->City_model->getRow($id);
        }
        $this->form_validation->set_rules('form[city]', 'City name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view(admin_view('default'), $this->data);
        }
        else {
            $s = $this->input->post('form');
            $s['id'] = $id;
            $this->City_model->save($s);
            $this->session->set_flashdata('success', 'City saved successfully');
            redirect(admin_url('city'));
        }
    }

	public function delete($id){
		$this -> db -> where('id', $id);
		$this -> db -> delete('cities');
		redirect(admin_url('city'));
	}

    function store($offset = 0){
        $show_per_page = 100;
        $this->data['main'] = admin_view('city/store');
        $this->data['state'] = $this->City_model->getStates();
        $this->data['city'] = $this->City_model->getCities();
        //$this -> data['main'] = admin_view('category/index');
        //$q = $this -> input -> get('q');
        $city_arr 		=	$this -> City_model -> getAll($offset, $show_per_page, 'store');
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'store_name' => $q, 'id' => $q, 'address' => $q, 'mobile'=>$q, 'email_id'=>$q
                );
                $city_arr = $this -> City_model -> getAllSearched($offset, $show_per_page, $likes, 'store');
            }

        $this->data['store'] 	= 	$city_arr['results'];
        $config = array();
        $config['base_url'] 	 = base_url(admin_url('city/store'));
        $config['num_links'] 	 = 5;
        $config['uri_segment']	 = 4;
        $config['total_rows']	 = $city_arr['total'];
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
        $config['cur_tag_close'] = '</a></b></li>';
        $config['enable_query_strings'] = true;
        $config['page_query_string'] = true;
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);

        $this->data['paginate'] = $this->pagination->create_links();
        //$this->load->view($this -> config -> item('admin_folder').'default', $data);
        $this->load->view(admin_view('default'), $this -> data);
    }
    function addstore($id = FALSE) {
        $this->data['main'] = admin_view('city/addstore');
        $this->data['state'] = $this->City_model->getStates();
        $this->data['cities'] = $this->City_model->getCities();
        $this->data['store'] = $this->City_model->getNew('store');
        $this->data['id']=$id;
        if ($id) {
            $this->data['store'] = $this->City_model->getRow($id,'store');
        }
        $this->form_validation->set_rules('form[store_name]', 'Store name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view(admin_view('default'), $this->data);
        }
        else {
            $s = $this->input->post('form');
            $s['id'] = $id;
            $this->City_model->save($s);
            $this->session->set_flashdata('success', 'Store saved successfully');
            redirect(admin_url('city/store'));
        }
    }
    public function deletestore($id){
        $this -> db -> where('id', $id);
        $this -> db -> delete('store');
        redirect(admin_url('city/store'));
    }

    function store_text($offset = 0){
        $show_per_page = 100;
        $this->data['main'] = admin_view('city/store-text');
        $city_arr 		=	$this -> City_model -> getAll($offset, $show_per_page, 'store_text');
        $this->data['store_text'] 	= 	$city_arr['results'];
        $config = array();
        $config['base_url'] 	 = base_url(admin_url('city/store_text'));
        $config['num_links'] 	 = 5;
        $config['uri_segment']	 = 4;
        $config['total_rows']	 = $city_arr['total'];
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
        $config['cur_tag_close'] = '</a></b></li>';
        $config['enable_query_strings'] = true;
        $config['page_query_string'] = true;
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);

        $this->data['paginate'] = $this->pagination->create_links();
        //$this->load->view($this -> config -> item('admin_folder').'default', $data);
        $this->load->view(admin_view('default'), $this -> data);
    }
    function addstore_text($id = FALSE) {
        $this->data['main'] = admin_view('city/addstore_text');
        $this->data['store_text'] = $this->City_model->getNew('store_text');
        $this->data['id']=$id;
        if ($id) {
            $this->data['store_text'] = $this->City_model->getRow($id,'store_text');
        }
        $this->form_validation->set_rules('form[description]', 'Text', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view(admin_view('default'), $this->data);
        }
        else {
            $s = $this->input->post('form');
            $s['id'] = $id;
            $this->City_model->save($s);
            $this->session->set_flashdata('success', 'Text saved successfully');
            redirect(admin_url('city/store_text'));
        }
    }
    public function deletestore_text($id){
        $this -> db -> where('id', $id);
        $this -> db -> delete('store');
        redirect(admin_url('city/store'));
    }
}
