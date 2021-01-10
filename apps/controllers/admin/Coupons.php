<?php
class Coupons extends MY_Controller {

	function __construct() {
		parent::__construct();
        $this->load->model('Coupons_model');
		$this -> data['active_tabs'] = "orders";
		$role = $this -> session -> userdata('role');
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
	}

	function index($page = 1){
		$this -> data['dashboard_title'] = "Manage Coupons";
		$this -> data['active_tabs'] = "catalog";
		$show_per_page = 40;
		$offset = ($page - 1 ) * $show_per_page;
		$this -> data['main'] = admin_view('coupons/index');
		$data	= $this -> Coupons_model -> getAll($offset, $show_per_page);

		if($this -> input -> get('btnsearch')){
			$q = $this -> input -> get('q');
			if($q <> ''){
				$likes = array(
					'title' => $q, 'id' => $q, 'coupon_code' => $q, 'validity' =>$q
				);
				$data = $this -> Coupons_model -> getAllSearched($offset, $show_per_page, $likes);
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

		$this -> data['coupons'] = $data['results'];
		$this->load->view(admin_view('default'), $this -> data);
	}


	function add($id = false){
        $length = 8;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $this -> data['active_tabs'] = "catalog";
        $this->data['coupon'] = $randomString;

        $this->data['id'] = $id;
		$this -> data['main'] 			= admin_view('coupons/add');
		$this -> data['fr'] = $this -> Coupons_model -> getNew();
		if($id){
			$this -> data['fr'] = $this->Coupons_model->getRow($id);
		}
		$this->form_validation->set_rules('data[title]', 'Name', 'required');
        //$this->form_validation->set_rules('data[coupon_code]', 'Coupon Code', 'required|is_unique[coupons.coupon_code]');
		if($this -> form_validation -> run()){
			$data = $this -> input -> post('data');
			$data['id'] = $id;
            if(!$id){
                $data['created'] = date('Y-m-d h:i:s');
            }
			$id	= $this->Coupons_model->save($data);
			$this -> session -> set_flashdata('success', 'Request saved successfully.');
			redirect(admin_url('coupons/add/'.$id));
		}else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}

    function activate($id = false){
        if($id){
            $c['id'] = $id;
            $c['status'] = 1;
            $this -> Coupons_model -> save($c);
            $this -> session -> set_flashdata("success", "Successfully activated");
        }
        redirect(admin_url('coupons'));
    }

    function deactivate($id = false){
        if($id){
            $c['id'] = $id;
            $c['status'] = 0;
            $this -> Coupons_model -> save($c);
            $this -> session -> set_flashdata("success", "Successfully deactivated");
        }
        redirect(admin_url('coupons'));
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        echo $randomString;
    }

	public function delete($id){
		if($id > 0){
            $this -> db -> where('id', $id);
            $this -> db -> delete('coupons');
            redirect(admin_url('coupons'));
			$this -> session -> set_flashdata('success', 'Coupons deleted successfully');
		}
		redirect(admin_url('coupons'));
	}

}
