<?php
class Franchisee extends MY_Controller {

	function __construct() {
		parent::__construct();
        $this->load->model('Franchisee_model');
		$this -> data['active_tabs'] = "Store_locator";
		$role = $this -> session -> userdata('role');
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
	}

	function index($page = 1){
		$this -> data['dashboard_title'] = "Manage Franchisee";
		$show_per_page = 40;
		$offset = ($page - 1 ) * $show_per_page;
		$this -> data['main'] = admin_view('franchisee/index');
		$data	= $this -> Franchisee_model -> getAll($offset, $show_per_page);

		if($this -> input -> get('btnsearch')){
			$q = $this -> input -> get('q');
			if($q <> ''){
				$likes = array(
					'name' => $q, 'id' => $q
				);
				$data = $this -> Franchisee_model -> getAllSearched($offset, $show_per_page, $likes);
			}
		}

		$config['base_url'] 	 = admin_url('franchisee');
		$config['num_links'] 	 = 2;
		$config['uri_segment']	 = 4;
		$config['total_rows']	 = $data['total'];
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
		$config['page_query_string'] = true;
		$config['query_string_segment'] = 'page';
		$config['reuse_query_string'] = true;
		$this->pagination->initialize($config);
		$this -> data['paginate'] 	=  $this->pagination->create_links();

		$this -> data['franchisee'] = $data['results'];
		$this->load->view(admin_view('default'), $this -> data);
	}


	function add($id = false){
        $this->load->model('City_model');
        $this->data['id'] = $id;
        $this->data['state'] = $this->City_model->getStates();
		$this -> data['main'] 			= admin_view('franchisee/add');
		$this -> data['categories']		= $this -> Franchisee_model -> category_dropdown();
		$this -> data['fr'] = $this -> Franchisee_model -> getNew();
		if($id){
			$this -> data['fr'] = $this->Franchisee_model->getRow($id);
		}
		$this->form_validation->set_rules('data[name]', 'Name', 'required');
        /*$this->form_validation->set_rules('cat[description]', 'Description', 'trim');
        $this->form_validation->set_rules('cat[sequence]', 'Sequence', 'trim|integer');
        $this->form_validation->set_rules('cat[parent_id]', 'Parent id', 'trim');
        $this->form_validation->set_rules('cat[parent_id]', 'Parent id', 'trim');*/
		if($this -> form_validation -> run()){
			//print_r($_FILES);
			$data = $this -> input -> post('data');
			$data['id'] = $id;
			$id	= $this->Master_model->save($data,'franchisee');
			$this -> session -> set_flashdata('success', 'Request saved successfully.');
			redirect(admin_url('franchisee/add/'.$id));
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}

	public function delete($id){
		if($id > 0){
            $this -> db -> where('id', $id);
            $this -> db -> delete('franchisee');
            redirect(admin_url('franchisee'));
			$this -> session -> set_flashdata('success', 'Franchisee deleted successfully');
		}
		redirect(admin_url('franchisee'));
	}

}
