<?php
class Orders extends MY_Controller{
	public function __construct(){
		parent::__construct();
		$this -> load -> model("Order_model");
		$this -> data['active_tabs'] = 'orders';
		$role = $this -> session -> userdata('role');
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
	}
	function index(){
		$this -> data['dashboard_title'] = "Manage Orders";
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $this -> data['invoice'] = $this -> Master_model -> listAll('order_invoice');
		$show_per_page = 40;
		$offset = ($page - 1 ) * $show_per_page;
		$this -> data['main'] = admin_view('orders/index');
        $data	= $this -> Order_model -> getAll($offset, $show_per_page);

		if($this -> input -> get('btnsearch')){
			$q = $this -> input -> get('q');
			if($q <> ''){
				$data = $this -> Order_model -> getAllSearchedByEmail($offset, $show_per_page, $q);
			}
		}
		$f = '';
		if(isset($_GET['f'])){
		    $f = $_GET['f'];
		    switch($_GET['f'])
            {
                case 1:
                    $rule['order_status'] = 'Processing';
                    $data = $this->Order_model->getWhereRecords($show_per_page, $offset, $rule);
                    break;
                case 2:
                    $rule['order_status'] = 'In Transit';
                    $data = $this->Order_model->getWhereRecords($show_per_page, $offset, $rule);
                    break;
                case 3:
                    $rule['order_status'] = 'Canceled';
                    $data = $this->Order_model->getWhereRecords($show_per_page, $offset, $rule);
                    break;
                case 4:
                    $rule['order_status'] = 'Order Confirmed';
                    $data = $this->Order_model->getWhereRecords($show_per_page, $offset, $rule);
                    break;
                case 5:
                    $rule['order_status'] = 'Pending';
                    $data = $this->Order_model->getWhereRecords($show_per_page, $offset, $rule);
                    break;
                case 6:
                    $rule['pay_status'] = 'Pending';
                    $data = $this->Order_model->getWhereRecords($show_per_page, $offset, $rule);
                    break;
                case 7:
                    $rule['pay_status'] = 'Received';
                    $data = $this->Order_model->getWhereRecords($show_per_page, $offset, $rule);
                    break;
                case 8:
                    $rule['pay_status'] = 'Aborted';
                    $data = $this->Order_model->getWhereRecords($show_per_page, $offset, $rule);
                    break;
                case 9:
                    $rule['pay_status'] = 'Failed';
                    $data = $this->Order_model->getWhereRecords($show_per_page, $offset, $rule);
                    break;
                case 10:
                    $rule['pay_method'] = 'COD';
                    $data = $this->Order_model->getWhereRecords($show_per_page, $offset, $rule);
                    break;
                case 11:
                    $rule['pay_method'] = 'Online';
                    $data = $this->Order_model->getWhereRecords($show_per_page, $offset, $rule);
                    break;
                default:
                    $data	= $this -> Order_model -> getAll($offset, $show_per_page);
            }

        }

        $this -> data['filter_status'] = $f;


		$this -> data['orders'] = $data['results'];
		$config['base_url'] 	 = admin_url('orders');
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
		$config['use_page_numbers'] = true;
		$config['page_query_string'] = true;
		$config['query_string_segment'] = 'page';
		$config['reuse_query_string'] = true;
		$this->pagination->initialize($config);
		$this -> data['paginate'] 	=  $this->pagination->create_links();

		$this->load->view(admin_view('default'), $this -> data);
	}

	function track($page = 1){
		$this -> data['dashboard_title'] =  "Track Orders";
		$show_per_page = 40;
		$offset = ($page - 1 ) * $show_per_page;
		$this -> data['main'] = admin_view('orders/track');
		$data	= $this -> Order_model -> orderForTracking($offset, $show_per_page);
		$this -> data['orders'] = $data['results'];
		$config['base_url'] 	 = admin_url('orders/track');
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
	function edit_track($id){
		$this -> data['main'] = admin_view('orders/edit-track');
		$order = $this -> Order_model -> getRow($id);
		$this -> form_validation -> set_rules('tr[courier]', 'Courier', 'required');
		$this -> form_validation -> set_rules('tr[tracking_notes]', 'Notes', 'required');
		if($this -> form_validation -> run()){
			$tr = $this -> input -> post('tr');
			$tr['order_id'] = $id;
			$tr['tracking_code'] = $order -> tracking_code;
			$tr['last_update'] = date('Y-m-d h:i:s');
			$this -> Order_model -> saveTracking($tr);
			$this -> session -> set_flashdata('success', "Tracking details updated");
			redirect(admin_url('orders/edit-track/' . $id));
		}else{
			$this -> data['tracks'] = $this -> Order_model -> orderTrack($order -> tracking_code);
			$this -> data['order_id'] = $id;
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}
	function return_prod($page = 1){
		$this -> data['dashboard_title'] =  "Return Orders";
		$show_per_page = 40;
		$offset = ($page - 1 ) * $show_per_page;
		$this -> data['main'] = admin_view('orders/return');
		$data	= $this -> Order_model -> return1($offset, $show_per_page);
		$this -> data['orders'] = $data['results'];
		$config['base_url'] 	 = admin_url('orders/return_prod');
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
	
	
	function edit_return($id){
		$this -> data['main'] = admin_view('orders/edit-return');
		$order = $this -> Order_model -> getRow($id,'ai_return');
		//print_r($order);die;
		if($this -> input -> post('btn_update')){
			//echo "hello";die;
			$tr = $this -> input -> post('tr');
			$tr['modified_at'] = date('Y-m-d h:i:s');
			//print_r($tr);die;
			$this -> Order_model -> saveReturning($id,$tr);
			$ar = array(
				'product_status'=>'Returned'
			);
			$arr = array(
				'order_status'=>'Returned'
			);
			$this->db->where('order_id',$order->order_id);
			$this->db->update('order_items',$ar);
			$this->db->where('id',$order->order_id);
			$this->db->update('orders',$arr);
			//echo $this->db->last_query();die;
			$this -> session -> set_flashdata('success', "Reurning details updated");
			redirect(admin_url('orders/edit-return/' . $id));
		}else{
			$this -> data['tracks'] = $this -> Order_model -> return_prod($order -> id);
			$this -> data['order_id'] = $order->id;
			$this -> data['reason'] = $order->reason_for_return;
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}
	function cancel($page = 1){
		$this -> data['dashboard_title'] =  "Cancel Orders";
		$show_per_page = 40;
		$offset = ($page - 1 ) * $show_per_page;
		$this -> data['main'] = admin_view('orders/cancel');
		$data	= $this -> Order_model -> cancel($offset, $show_per_page);
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

	function edit_cancel($id){
		$this -> data['main'] = admin_view('orders/edit-cancel');
		$order = $this -> Order_model -> getRow($id,'ai_cancel');
		//print_r($order);die;
		if($this -> input -> post('btn_cancel')){
			//echo "hello";die;
			$tr = $this -> input -> post('tr');
			$tr['modified_at'] = date('Y-m-d h:i:s');
			//print_r($tr);die;
			$this -> Order_model -> saveCancelling($id,$tr);
			$ar = array(
				'product_status'=>'Canceled'
			);
			$arr = array(
				'order_status'=>'Canceled'
			);
			$this->db->where('order_id',$order->order_id);
			$this->db->update('order_items',$ar);
			$this->db->where('id',$order->order_id);
			$this->db->update('orders',$arr);
			//echo $this->db->last_query();die;
			$this -> session -> set_flashdata('success', "Cancelling details updated");
			redirect(admin_url('orders/edit-cancel/' . $id));
		}else{
			$this -> data['tracks'] = $this -> Order_model -> cancel_order($order -> id);
			$this -> data['order_id'] = $order->id;
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}

	function details($order_id){
	    $this -> data['main'] = admin_view('orders/details');
		if($this -> input -> post('btn_details')){
			$ord = $this -> input -> post('order');
			$ord['id'] = $order_id;
            $order_detail = $this->Order_model->orderDetails($order_id);
            if($ord['pay_status'] == "Received"){
				$users_order = $this -> Order_model -> getTotalprice($order_detail->user_id);
				$total_price = 0;
				foreach($users_order as $order){
						$total_price += $order->payment_price;
				}
				if($total_price >=3000){
				$chkactivation = $this -> User_model -> checkActive($order_detail->user_id);
				if($chkactivation){
					$this -> User_model -> updateActivation($order_detail->user_id);
				}
			  }
			}
            $ordd = $order_detail->user;
            $email_id = $ordd->email_id;
            $name = $ordd->first_name;
            $tracking = $ord['tracking_code'];
	    if(isset($ord['delivery_on'])){
		$ord['delivery_on'] = date('Y-m-d', strtotime($ord['delivery_on']));
	    }
	    $this -> Order_model -> save($ord);
            $track_url = $ord['tracking_url'];
            $ob = new AI_User($order_detail->user_id);
            $mobile = $ob->getMobile();
            $msg = "You order has been shipped. Your tracking id: " .$tracking. ". Check your email for details";
			$this -> session -> set_flashdata("success", "Order Details updated");
            if($tracking <> '') {
                sendSMS($mobile, $msg);
                //========Write code to send email for verification =============
                $m = new AI_Mail();
                $m->onUpdateTracking($name, $email_id, $tracking, $track_url)->sendMail();
            }
			redirect(admin_url('orders/details/' . $order_id));
		}

		$this -> data['order'] = $this -> Order_model -> orderDetails($order_id);
		$this -> load -> view(admin_view('default'), $this -> data);
	}

    function print_invoice($order_id){
        $this -> data['order'] = $this -> Order_model -> orderDetailsAfterCancel($order_id);
        $this -> load -> view(admin_view('order-invoice'), $this -> data);
    }

    function create_invoice(){
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('orders');
        $save = $this -> input -> post('frm');
        $save['id'] = false;
        $this -> Master_model -> save($save, 'order_invoice');
        $this -> session -> set_flashdata('success', "Invoice Created");
        //$this -> data['order'] = $this -> Order_model -> orderDetails($order_id);
        redirect($redirect);
    }

	function delete($id = false){
		$redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('orders');
		if($id){
			$this -> Order_model -> delOrder($id);
			$this -> session -> set_flashdata("success", "Order deleted premanently");
		}
		redirect($redirect);
	}

    function add_invoice($id = FALSE) {
        $this->data['main'] = admin_view('orders/edit-invoice');
        $this->data['order'] = $this->Master_model->getNew('order_invoice');
        if ($id) {
            $this -> data['id'] = $id;
            $this->data['order'] = $this->Master_model->getRow($id, 'order_invoice');
        }
        $this->form_validation->set_rules('frm[invoice_no]', 'Invoice No', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view(admin_view('default'), $this->data);
        }
        else {
            $s = $this->input->post('frm');
            $s['id'] = $id;
            $this->Master_model->save($s,'order_invoice');
            $this->session->set_flashdata('success', 'Invoice updated successfully');
            redirect(admin_url('orders/add_invoice/'.$id));
        }
	}
	
	function export(){
        $this->load->helper(array('file', 'download'));
        $this->load->dbutil();
        ini_set('memory_limit', '1024MB');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = 'order.csv';
        if($_POST)
        {
            if($_POST['to'] != '' && $_POST['from'] != '')
            {
                $this->db->where('created_on >=', $_POST['to']);
                $this->db->where('created_on <=', $_POST['from']);
            }
            $result = $this->db->get('orders');
            $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
            force_download($filename, $data);
            $this->session->set_flashdata('success', 'Data exported successfully');
            redirect(admin_url('members/subscriptions'));
        }

    }
    
    function cancelOrderDetails(){
		$this -> data['dashboard_title'] = "Manage Orders";
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
		$show_per_page = 40;
		$offset = ($page - 1 ) * $show_per_page;
		$this -> data['main'] = admin_view('orders/bank_details');
        $data	= $this -> Order_model -> getAll($offset, $show_per_page,'bank_details');
		$this -> data['banks'] = $data['results'];
		$config['base_url'] 	 = admin_url('cancelOrderDetails');
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
		$config['use_page_numbers'] = true;
		$config['page_query_string'] = true;
		$config['query_string_segment'] = 'page';
		$config['reuse_query_string'] = true;
		$this->pagination->initialize($config);
		$this -> data['paginate'] 	=  $this->pagination->create_links();

		$this->load->view(admin_view('default'), $this -> data);
	}

}
