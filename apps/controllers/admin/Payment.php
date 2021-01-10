<?php
class Payment extends MY_Controller{
	public function __construct(){
		parent::__construct();
		$this -> load -> model("Order_model");
		$this -> data['active_tabs'] = 'orders';
		$role = $this -> session -> userdata('role');
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
	}
	
	function history($page = 1){
		$this -> data['dashboard_title'] =  "payout history";
		$show_per_page = 40;
		$offset = ($page - 1 ) * $show_per_page;
		$this -> data['main'] = admin_view('payment/history');
		$data	= $this -> Order_model -> history($offset, $show_per_page);
		if($this -> input -> get('btnsearch')){
			$q = $this -> input -> get('q');
			if($q <> ''){
				$likes = array(
					'user_id' => $q
				);
				$data = $this -> Order_model -> getAllSearched($offset, $show_per_page, $likes);
			}
		}

		$this -> data['orders'] = $data['results'];
		$config['base_url'] 	 = admin_url('orders/cancel');
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
		$this->pagination->initialize($config);
		$this -> data['paginate'] 	=  $this->pagination->create_links();

		$this->load->view(admin_view('default'), $this -> data);
	}

	function detail($id){
		$this -> data['main'] = admin_view('payment/detail');
		$this->data['order'] = $this -> Master_model -> getRow($id,'orders');
		
		
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	

	function recent(){
		$this -> data['dashboard_title'] =  "Recent Payments";
		$this -> data['main'] = admin_view('payment/recent');
		$this->data['recent'] = $this -> db -> where(array('pay_status' => 'received')) -> limit(20) -> order_by('modified_on', 'desc') -> get('orders') -> result();
		
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	

}
