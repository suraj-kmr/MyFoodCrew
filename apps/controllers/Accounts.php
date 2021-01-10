<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends AI_Controller{
	function __construct() {
		parent::__construct();
		$this -> load -> model("Order_model");
        $this -> load -> model("Media_model");
		$flag = $this->session->userdata('login');
		if($flag == false){
			$this -> session -> set_flashdata("error", "Your must login to View this page.");
			redirect('login');
		}
	
		$this -> data['user'] = $this -> User_model -> getUserById($flag['user_id']);
        //print_r($this -> data['user']);die;
        $this -> data['carts'] = $this -> session -> userdata('cart');
        
       
	}

	function index() {
		//$this -> load -> model("Order_model");
		$this -> data['title'] = "My Account";
        $this -> data['active'] = "my-account";
		$this -> data['main'] = 'my-accounts';
        $u= $this->session->userdata('login');
        if($u['user_type']=='vender'){
            redirect('accounts/vender');
        }
        $this->data['users_active'] = $this->db->get_where('users',array('id'=>user_id()))->row();
        $this -> data['orders'] = $this -> db -> order_by('id', 'DESC')->limit(5)->get_where('orders', array('user_id' => $this -> user_id())) -> result();
		 //= $this -> Order_model -> myorders($this -> user_id());
        $this -> data['cancelled'] = $this->db->order_by('id','DESC')->limit(5)->get_where('orders',array('user_id'=>$this -> user_id(),'order_status'=>'Canceled'))->result();
        $this -> data['wishlists'] = $this->db->limit(5)->get_where('ai_wishlist',array('user_id'=>$this -> user_id()))->result();
		$this -> load -> view('default', $this -> data);
	}

	function cancelproduct($oid=false,$id=false){
        $dt_user = $this->db->get_where('orders',array('id'=>$oid))->row();
            $user_id = $dt_user->user_id;

            $dt = $this->db->get_where('order_items',array('order_id'=>$oid))->row();
            $order_id = $dt->order_id;
            $product_id = $dt->product_id;
            $st = array(
                'order_id'=>$order_id,
                'product_id'=>$product_id,
                'user_id'=>$user_id,
                'requested_at'=>date('Y-m-d h:i:s'),
                'modified_at'=>date('Y-m-d h:i:s'),
                'status'=>0

            );
            //print_r($st);die;
            $this->db->insert('ai_cancel',$st);
            $this->session->set_flashdata('success','You Sent Cancel Request Successfully.');
            redirect(site_url('accounts/myorders'));
    }
    // function cancelproduct($oid=false,$id=false){
    //     $where = array('id'=>$oid);
    //     $items = $this -> Order_model -> cancelCount($oid);
    //     $pstatus = 'Canceled';
    //     $data1 = array(
    //         'order_status' => $pstatus,
    //         'cancel_by' => 'User'
    //     );
    //     if($items==1){
    //         $this -> Order_model -> update($data1, 'orders', $where);
    //     }
    //     $where = array('id'=>$id);
    //     $data = array();
    //     //$data['cancel_by'] = 'User';
    //     $data['product_status'] = "Canceled";
    //     $this -> Master_model -> update($data, 'order_items', $where);
    //     redirect('accounts/myorders');
    // }

    function returnProduct($oid=false,$id=false){
        $where = array('id'=>$oid);
        $items = $this -> Order_model -> returnCount($oid);
   
        $pstatus = 'Returned';
        $data1 = array(
            'order_status' => $pstatus,
            'cancel_by' => 'User'
        );
        if($items==1){
            $this -> Order_model -> update($data1, 'orders', $where);
        }
        $where = array('id'=>$id);
        $data = array();
        //$data['cancel_by'] = 'User';
        $data['product_status'] = "Returned";
        $this -> Master_model -> update($data, 'order_items', $where);
        redirect('accounts/myorders');
    }
    function returnRequest($id=false){
    	$this -> data['title'] = "Return Products";
		$this -> data['main'] = 'return_products';
		$this -> data['id']=$id;
		if($this->input->post('submit')){
    		$dt_user = $this->db->get_where('orders',array('id'=>$id))->row();
    		$user_id = $dt_user->user_id;
    		$dt = $this->db->get_where('order_items',array('order_id'=>$id))->row();
    		$order_id = $dt->order_id;
    		$product_id = $dt->product_id;
   			$reason = $_POST['reason_for_return'];
   			$st = array(
   				'order_id'=>$order_id,
   				'product_id'=>$product_id,
   				'user_id'=>$user_id,
   				'reason_for_return'=>$reason,
   				'requested_at'=>date('Y-m-d h:i:s'),
   				'modified_at'=>date('Y-m-d h:i:s'),
   				'status'=>0

   			);
   			$this->db->insert('ai_return',$st);
   			$this->session->set_flashdata('success','You Sent Return Request Successfully.');
   			redirect(site_url('accounts/myorders'));
    	}
		//$this -> data['orders'] = $this -> Order_model -> myorders($this -> user_id());
		$this -> load -> view('default', $this -> data);
    	
    }

    function cancelOrder($oid=false){
        $where = array('id'=>$oid);
        //$data1['id'] = $oid;
        $pstatus = 'Canceled';
        $data1 = array(
            'order_status' => $pstatus
        );
        $this -> Order_model -> update($data1, 'orders', $where);
        $items = $this -> Order_model -> cancelCount($oid);
        if($items > 0){
            $where = array('order_id'=>$oid);
            //$data['user_id'] = $this->user_id();
            $data['product_status'] = "Canceled";
            $this -> Master_model -> update($data, 'order_items', $where);
        }
        redirect('accounts');
    }

	function changepassword(){
        
		$this -> data['title'] = "Change Password";
		$this -> data['main'] = "change-password";
        $this -> data['active'] = "change-password";
		$this -> form_validation -> set_rules('oldpass', "Old Password", "required");
		$this -> form_validation -> set_rules('password', "New Password", "required|min_length[6]");
		$this -> form_validation -> set_rules('cnfpassword', "Confirm Password", "required|matches[password]");
		if($this -> form_validation -> run()){

			$oldp = $this -> input -> post('oldpass');
			$newp = $this -> input -> post('password');
			$pass=array('pass',$newp);
			$temp =  $this -> User_model -> getUserById($this -> data['user']->id);

			if($temp -> pass == $oldp){
				$this -> db -> update('users', array('pass'=>$newp), array('id'=>$this -> data['user']->id));


			 /*	$params = array(
					'username'=>$temp -> first_name . ' ' . $temp -> last_name,
					'password'=> $newp,
					'email'=> $temp -> email,
					'date'=>date('Y-m-d H:i:s'),
				);
				//config email.
			$config = array(
					'mailtype' => 'html',
				);
				$subject = configEmail('sub_change_pass', $params);
				$message = configEmail('change_pass', $params);

				$this->load->library('email', $config);
				$this->email->from(getEmail(config_item('admin_email')), getSiteName(config_item('site_name')));
				$this->email->to($this->user['email']);
				$this->email->subject ( $subject);
				$this->email->message ($message);
				$this->email->send();*/
				$this -> session -> set_flashdata("success", "New password updated successfully");
			}else{
				$this -> session -> set_flashdata("error", "Invalid old password.");
			}
			redirect('accounts/changepassword');
		}
		$this -> load -> view('default', $this -> data);
	}

	function myorders(){
		$this -> load -> model("Order_model");
        $this -> data['active'] = "my-orders";
		$this -> data['main'] = 'myorders';
		$this -> data['orders'] = $this -> Order_model -> myorders($this -> user_id());
		$this -> load -> view('default', $this -> data);
	}

    function wishlists(){
        $this -> data['main'] = 'wishlists';
        $this -> data['active'] = "wishlist";
        $this -> data['items'] = $this -> User_model -> myWishlistItems($this -> user_id());
        $this -> load -> view('default', $this -> data);
    }

    function my_designs(){
        redirect('accounts');
    }
    function trackorder(){
        $this -> load -> model('Order_model');
        $this -> data['main'] = "order-tracking";
        $this -> data['title'] = "Order Tracking";
        $this->data['email'] = $this -> input -> post('email_id');
        $track_code= $this -> input -> post('trackcode');
        $this -> data['track'] = $this -> Order_model->orderTrack($track_code);
        $this -> load -> view('default', $this -> data);
    }
    
     function affiliate(){
        $this -> data['main'] = 'affiliate';
       if ($this->session->has_userdata('login')) {
                    $user = $this->session->userdata('login');
                    $u=$this->User_model->getUserById($user['user_id']);
                    //print_r($user);
                     $this -> data['ref_user']=$this -> db -> get_where('users', array('ref_code' => $u->username))->result();
                }
              
              
        $this -> load -> view('default', $this -> data);
    }
     function refer_earn(){
        $this -> data['main'] = 'refer_earn';
       
        $this -> load -> view('default', $this -> data);
    }
     function trans_history(){
        $this -> data['main'] = 'trans_history';
        $this ->data['transactions'] = $this->Order_model->myorders(user_id());
        $this -> load -> view('default', $this -> data);
    }

    function cancelledOrder(){
        $this -> data['main'] = 'cancelled';
        $this -> data['active'] ='cancel-orders';
        $userid = $_SESSION['login']['user_id'];
        $this -> data['cancelled'] = $this->db->get_where('orders',array('user_id'=>$userid,'order_status'=>'Canceled'))->result();
         $this -> load -> view('default', $this -> data);
    }

    function bankdetails(){
        if($this->input->post('frm')){
            $save = $this->input->post('frm');
            $this->db->insert('bank_details',$save);
            $dt_user = $this->db->get_where('orders',array('id'=>$save['order_id']))->row();
            $user_id = $dt_user->user_id;

            $dt = $this->db->get_where('order_items',array('order_id'=>$save['order_id']))->row();
            $order_id = $dt->order_id;
            $product_id = $dt->product_id;
            $st = array(
                'order_id'=>$order_id,
                'product_id'=>$product_id,
                'user_id'=>$user_id,
                'requested_at'=>date('Y-m-d h:i:s'),
                'modified_at'=>date('Y-m-d h:i:s'),
                'status'=>0

            );
            //print_r($st);die;
            $this->db->insert('ai_cancel',$st);
            $this->session->set_flashdata('success','You Sent Cancel Request Successfully.');
            redirect(site_url('accounts/myorders'));
        }
    }
     function vender(){
        $this -> data['main'] = 'vender-accounts';
        $this -> data['today'] =$this-> Product_model -> todayorder(user_id());
        $this -> data['week'] =$this-> Product_model -> weekorder(user_id());
        $this -> data['month'] =$this-> Product_model -> monthorder(user_id());
        $this -> data['can']=$this -> Product_model -> canceled(user_id());
        $this -> data['count']=count( $this -> data['can']);
        $this -> data['can']=$this -> Product_model -> canceled(user_id(),6);
        
        $this -> data['product']=$this -> Product_model -> recentOrder(user_id());
           // print_r( $this -> data['product']);
        $this -> load -> view('default', $this -> data);
    }




     function vender_product(){
        $this -> data['main'] = 'vender-product';
        $show_per_page = isset($_GET['show_page']) ? $_GET['show_page'] : 100;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
       
        $offset = ($page - 1 ) * $show_per_page;
       $rule['user_id'] = user_id();
        $data   = $this -> Product_model -> getWhereRecords($show_per_page, $offset, $rule, 'products');
      // print_r($data);
        $this -> data['products'] = $data['results'];
        $config['base_url']      = site_url('accounts/vender_product');
        $config['num_links']     = 2;
        $config['uri_segment']   = 4;
        $config['total_rows']    = $data['total'];
        $config['per_page']      = $show_per_page;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close']= '</ul>';
        $config['num_tag_open']  = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link']    = 'First';
        $config['first_tag_open']= '<li>';
        $config['first_tag_close']= '</li>';
        $config['last_link']     = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close']= '</li>';
        $config['prev_link']     = 'Prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close']= '</li>';
        $config['next_link']     = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close']= '</li>';
        $config['cur_tag_open']  = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['use_page_numbers'] = true;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);

        $this -> data['paginate']   =  $this->pagination->create_links();

        $this -> data['categories'] = $data['results'];
        $this -> load -> view('default', $this -> data);
    }
    function add_vender_product($id = false){
        $this -> data['main'] ='add-vender-product';
        //print_r($this->input->post('frm'));die;
       // $this -> data['dashboard_title'] = ($id == false) ? "Add Products" : "Edit Products";
        $this -> data['categories']     = $this -> Category_model -> get_categories_tierd();
        $this -> data['category']     = $this -> Category_model -> category_dropdown();
        $this -> data['gift'] = $this -> Master_model -> listAllWhere('categories', array('parent_id'=>102));
       // $this -> data['brands'] = $this -> Mobile_model -> allBrands();
        //$this -> data['m'] = $this -> Mobile_model -> addMobile();
        $this -> data['images'] = $this -> Media_model -> allimages();
        $this -> data['p'] = $this -> Product_model -> getNew();
        //$this -> data['arr_designs'] = $this -> Master_model -> listAll('designs');
        if($id){
            $detail = $this -> db-> get_where('products',array('id'=>$id)) -> row();
            if($detail -> product_type == 1){
                $this -> data['brands'] = $this -> db -> get('cloths_brand') ->result();
            }
            if($detail -> product_type == 2){
                $this -> data['brands'] = $this -> db -> get('grocery_brand') -> result();
            }
            $this -> data['units'] = $this->db->get_where('units',array('pid'=>$id))->result();
            $this -> data['p'] = $this -> Product_model -> getProduct($id);
            $this -> data['categories'] = $this -> Category_model -> get_categories_tierd(0,$this->data['p']->product_type);
        }

        $this -> form_validation -> set_rules('frm[ptitle]', 'Product Title', 'required');
        // $this -> form_validation -> set_rules('frm[product_type]', 'Product Type', 'required');
        if($this -> form_validation -> run()){
            $p = $this -> input -> post('frm');
            $p['id'] = $id;
            $p['gallery'] = $this -> input -> post('img_selected');
            $p['available'] = $this -> input -> post('frm[available]') ? 1 : 0;
            $p['discount'] = $this -> input -> post('frm[discount]') ? 1 : 0;
            $p['cod_available'] = $this -> input -> post('cod_available') ? 1 : 0;

            $config = array();
            //$config['upload_path'] = upload_dir();
            $config['upload_path'] = 'img/uploads/';
            $config['allowed_types'] = 'png|jpg|jpeg|gif';
            $config['max_size'] = 3000;
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);

            if($_FILES['cover_image']['name'] != ''){

                $uploaded = $this -> upload -> do_upload('cover_image');
                if($uploaded){
                    $image = $this -> upload -> data();
                    $p['image'] = site_url(upload_dir($image['file_name']));
                    $image = site_url(upload_dir($image['file_name']));
                }
            }
            else{
                $image = $this -> input -> post('txt_image1');
            }

            if($_FILES['image1']['name'] !='') {
                $uploaded1 = $this->upload->do_upload('image1');
                if ($uploaded1) {
                    $image1 = $this->upload->data();
                    $image1 = site_url(upload_dir($image1['file_name']));
                }
            }
            else{
                $image1 = $this -> input -> post('txt_image2');
            }
            if($_FILES['image2']['name'] != '') {
                $uploaded2 = $this->upload->do_upload('image2');
                if ($uploaded2) {
                    $image2 = $this->upload->data();
                    $image2 = site_url(upload_dir($image2['file_name']));
                }
            }
            else{
                $image2 = $this -> input -> post('txt_image3');
            }
            if($_FILES['image3']['name']) {
                $uploaded3 = $this->upload->do_upload('image3');
                if ($uploaded3) {
                    $image3 = $this->upload->data();
                    $image3 = site_url(upload_dir($image3['file_name']));
                }
            }
            else{
                $image3 = $this -> input -> post('txt_image4');
            }
            if($_FILES['image4']['name']) {
                $uploaded4 = $this->upload->do_upload('image4');
                if ($uploaded4) {
                    $image4 = $this->upload->data();
                    $image4 = site_url(upload_dir($image4['file_name']));
                }
            }
            else{
                $image4 = $this -> input -> post('txt_image5');
            }
            if($_FILES['image5']['name']) {
                $uploaded5 = $this->upload->do_upload('image5');
                if ($uploaded5) {
                    $image5 = $this->upload->data();
                    $image5 = site_url(upload_dir($image5['file_name']));
                }
            }
            else{
                $image5 = $this -> input -> post('txt_image6');
            }

            if($_FILES['image6']['name']) {
                $uploaded6 = $this->upload->do_upload('image6');
                if ($uploaded6) {
                    $image6 = $this->upload->data();
                    $image6 = site_url(upload_dir($image6['file_name']));
                }
            }
            else{
                $image6 = $this -> input -> post('txt_image7');
            }
            

            if($_FILES['image7']['name']) {
                $uploaded7 = $this->upload->do_upload('image7');
                if ($uploaded7) {
                    $image7 = $this->upload->data();
                    $image7 = site_url(upload_dir($image7['file_name']));
                }
            }
            else{
                $image7 = $this -> input -> post('txt_image8');
            }

            if($_FILES['image8']['name']) {
                $uploaded8 = $this->upload->do_upload('image8');
                if ($uploaded8) {
                    $image8 = $this->upload->data();
                    $image8 = site_url(upload_dir($image8['file_name']));
                }
            }
            else{
                $image8 = $this -> input -> post('txt_image9');
            }

            if($_FILES['image9']['name']) {
                $uploaded9 = $this->upload->do_upload('image9');
                if ($uploaded9) {
                    $image9 = $this->upload->data();
                    $image9 = site_url(upload_dir($image9['file_name']));
                }
            }
            else{
                $image9 = $this -> input -> post('txt_image10');
            }

            if($_FILES['image10']['name']) {
                $uploaded10 = $this->upload->do_upload('image10');
                if ($uploaded10) {
                    $image10 = $this->upload->data();
                    $image10 = site_url(upload_dir($image10['file_name']));
                }
            }
            else{
                $image10 = $this -> input -> post('txt_image11');
            }
            $p['image'] = $image;
            $p['gallery'] = $image.','.$image1 . ',' . $image2 . ',' . $image3 . ',' . $image4 . ',' . $image5 . ',' . $image6 . ',' . $image7 . ',' . $image8 . ',' . $image9 . ',' . $image10;
            //print_r($p);die;
            $slug = $p['slug'];
            if(empty($slug) || $slug=='')
            {
                $slug = $p['ptitle'];
            }
            $slug   = strtolower(url_title($slug));
            $p['slug'] = $this -> Product_model -> get_unique_url($slug, $id);
                 $p['user_id'] = user_id();
                 
            // if($this -> input -> post('sizes')){
            //     $p['sizes'] = json_encode($this -> input -> post('sizes'));
            // }
            if($this -> input -> post('params')){
                $p['params'] = json_encode($this -> input -> post('params'));
            }
            if($p['product_type'] == 1){
                $ar = array();
                if($this->input->post('attr'))
                {
                    $attrs = $this -> input -> post("attr");
                    //print_r($attrs);
                    $sizes = $attrs['sizes'];
                    $prices = $attrs['price'];
                    $qty = $attrs['qty']; 
                    foreach($sizes as $in => $vl){
                        $a = new stdClass();
                        $a->sizes = $sizes[$in];
                        $a->price = $prices[$in];
                        $a->qty = $qty[$in];
                        $ar[] = $a;
                    }
                }
                $p['attr'] = json_encode($ar);
            }
            //print_r($_POST);
            $id = $this -> Product_model -> save($p);
            $this->db->where('pid',$id);
            $this->db->delete('units');
           // echo $this->db->last_query();die;
                $total  = count($this -> input -> post('units'));
                $units = $this -> input -> post('units');
                $unit_price = $this -> input -> post('unit_price');
                if($total>0 && $p['product_type'] == 2){
                for($i=0;$i<$total;$i++){
                    if(@isset($units[$i])){
                        $arr = array(
                            'units'=>$units[$i],
                            'unit_price'=>$unit_price[$i],
                            'pid'=>$id
                        );
                        $this->db->insert('units',$arr);
                    }
                }
            }
            if($this -> input -> post('cats')){
                $cats = $this -> input -> post('cats');
                $this -> Product_model -> resetCategory($id, $cats);
            }
            $this -> session -> set_flashdata("success", "Product saved successfully");
            redirect(site_url('accounts/vender_product'));
        }

        $this -> load -> view('default', $this -> data);
    }
    function vender_order(){
        $this -> data['main'] = 'vender-order';
         $this -> data['v_order']=$this -> Product_model->venderOrder(user_id());
         //print_r($this -> data['v_order']);
        $this -> load -> view('default', $this -> data);
    }
    function vender_cancel(){
        $this -> data['main'] = 'vender-cancel';
          $this -> data['can']=$this -> Product_model -> canceled(user_id());
        // print_r( $this -> data['can']);
        $this -> load -> view('default', $this -> data);
    }
    function vender_pin(){
        $this -> data['main'] = 'vender-pin';
        $this -> load -> view('default', $this -> data);
    }
    function add_vender_pin(){
        $this -> data['main'] = 'add-vender-pin';
        $this -> load -> view('default', $this -> data);
    }
    function vender_shipping(){
        $this -> data['main'] = 'vender-shipping';
        $this -> load -> view('default', $this -> data);
    }
    function add_vender_shipping(){
        $this -> data['main'] = 'add-vender-shipping';
        $this -> load -> view('default', $this -> data);
    }
    function vender_payout(){
        $this -> data['main'] = 'vender-payout';
        $this -> data['payout']=$this -> Product_model->venderPayout(user_id());
        //print_r($this -> data['payout']);
        $this -> load -> view('default', $this -> data);
    }
    function vender_profile(){
       $id = user_id();
         $this->data['main'] = 'vender-profile';
         $this->data['active'] = 'edit-profile';
         $this -> data['states'] = $this -> User_model -> state_dropdown();
        $this->data['users_details'] = $this->User_model->getUserById($id);
        $this->load->view('default', $this->data);
    }

     function vender_changepassword(){
         $this -> data['active'] = "change-password";
        $this -> data['main'] = 'vender-changepassword';
       
        $this -> form_validation -> set_rules('oldpass', "Old Password", "required");
        $this -> form_validation -> set_rules('password', "New Password", "required|min_length[6]");
        $this -> form_validation -> set_rules('cnfpassword', "Confirm Password", "required|matches[password]");
        if($this -> form_validation -> run()){

            $oldp = $this -> input -> post('oldpass');
            $newp = $this -> input -> post('password');
            $pass=array('pass',$newp);
            $temp =  $this -> User_model -> getUserById($this -> data['user']->id);

            if($temp -> pass == $oldp){
                $this -> db -> update('users', array('pass'=>$newp), array('id'=>$this -> data['user']->id));


$this -> session -> set_flashdata("success", "New password updated successfully");
            }else{
                $this -> session -> set_flashdata("error", "Invalid old password.");
            }
            redirect('accounts/vender_changepassword');
        }
        $this -> load -> view('default', $this -> data);
    }
    function getclothBrands(){
        $brands = $this->Product_model->field_dropdown('cloths_brand');
        echo form_dropdown("frm[brand_id]",$brands,'',array("class"=>"form-control"));
    }

    function getgroceryBrands(){
        $brands = $this->Product_model->field_dropdown('grocery_brand');
        echo form_dropdown("frm[brand_id]",$brands,'',array("class"=>"form-control"));
    }

    function getmarbleBrands(){
        $brands = $this->Product_model->field_dropdown('marble_brands');
        echo form_dropdown("frm[brand_id]",$brands,'',array("class"=>"form-control"));
    }

    function gethealthBrands(){
        $brands = $this->Product_model->field_dropdown('health_brands');
        echo form_dropdown("frm[brand_id]",$brands,'',array("class"=>"form-control"));
    }
    
    function getelectronicBrands(){
        $brands = $this->Product_model->field_dropdown('electronic_brands');
        echo form_dropdown("frm[brand_id]",$brands,'',array("class"=>"form-control"));
    }
    function ajaximgdel(){
        $imgsrc = $this -> input -> post('imgsrc');
        $str['id']=$this->input->post('pid');
        $m=$this->Product_model->getProduct($str['id']);
        if($m -> gallery <> '') {
            $str['gallery'] = str_replace($imgsrc . ',', '', $m -> gallery);
        }
        $this -> Product_model -> save($str);
        echo true;
    }

    function ajaxLoadCategory($product_type){
        $p = $this -> Category_model -> get_categories_tierd(0, $product_type);
        $this -> list_categories($p, '', array());
    }
}
