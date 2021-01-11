<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart extends AI_Controller{
	var $category;
	function __construct(){
		parent::__construct();
        $this->load->model('Coupons_model');
		$this -> load -> model('Wallet_model');

    }

	function index(){
		
		$this -> data['main'] = 'cart';
		$this -> data['carts'] = $this -> session -> userdata('cart');
        
		$this -> load -> view('default', $this -> data);
	}
// 3th time chqab
	// Add Cart function
	function add_cart(){
		$pid = $this -> input -> post('pid');
		$price = $this -> input -> post('price');
		$url = $this -> input -> post('url');
		$qty = $this -> input -> post('qty');
		$size = $this -> input -> post('size');
		//print_r($price);die;
		if($this -> session -> has_userdata('cart')){
			$cart = $this -> session -> userdata('cart');
			$new_cart = array();
			$add_new = true;
			foreach($cart as $row){
				if($row['pid'] == $pid && $row['size'] == $size){
					$row['qty'] = $row['qty'] + $qty;
					$add_new = false;
				}
				$new_cart[] = $row;
			}
			if($add_new){
				$row = array(
					'pid' => $pid,
					'price' => $price,
					'qty' => $qty,
					'size' => $size
				);
				$new_cart[] = $row;
			}
			$this -> session -> set_userdata('cart', $new_cart);
		}else{
			$cart = array();
			$cart[] = array(
				'pid' => $pid,
 				'price' => $price,
				'qty' => $qty,
				'size' => $size
			);
			$this -> session -> set_userdata('cart', $cart);
			
		}
        $this -> session -> set_flashdata("success", 'Cart Item update ');
	if(isset($_SESSION['login'])){
        $uid = $_SESSION['login']['user_id'];
        $wishlist =  $this->db->get_where('ai_wishlist',array('user_id'=>$uid,'pid'=>$pid))->num_rows();
        if($wishlist > 0){
        	$this->db->where('user_id',$uid);
        	$this->db->where('pid',$pid);
        	$this->db->delete('ai_wishlist');
        }
	}
       // print_r($wishlist);die;
        if($this -> input -> post('btn_buy')){
            $this -> session -> set_flashdata("success", 'Cart Item is ready for checkout');
            redirect('cart');
        }
        else{
		redirect($url);
	}
	}

	function wallet_deduction()
	{
		if($_POST['status']==1){
		$uid=$this->session->userdata('login');
    	$wlt=$this->db->get_where('users',array('id'=>$uid['user_id']))->row();
		$total_price=$this->cartprice();
		$wallet_price=$wlt->wallet;
        if($wallet_price < $total_price){
        	echo $a = $total_price - $wallet_price;
        }
        elseif($wallet_price > $total_price){
        	echo 0 ;
        }
    }
    else
    {
    	echo $this->cartprice();
     }
	}

	function wallet_uncheck(){
    
    if($_POST['status']==2) {
    	$uid=$this->session->userdata('login');
    	$ee=$this->db->get_where('users',array('id'=>$uid['user_id']))->row();
    	
    	echo $ee->wallet;
    }
    }
    function wallet_remain()
    {
    $uid=$this->session->userdata('login');
    $wlt=$this->db->get_where('users',array('id'=>$uid['user_id']))->row();
    $total_price=$this->cartprice();
	$wallet_price=$wlt->wallet;
	if($total_price>$wallet_price)
	{
		echo 0;
	}else{
		 if($total_price<$wallet_price){
		 	echo  $wallet_price-$this->cartprice();
		 }
		 else{
		 	echo 0;
		 }
		
	}

    


	}
	function clear(){
		$this -> session -> unset_userdata('cart');
		$this -> session -> set_flashdata("success", "Cart empty now");
		redirect(site_url());
	}

    function clearCoupon(){
        $this -> session -> unset_userdata('discount');
        $this -> session -> unset_userdata('coupon_code');
        $this -> session -> set_flashdata("Error", "You have removed Coupon");
        redirect(site_url('cart'));
    }

	function r($rid= false){
		if($this -> session -> has_userdata('cart')){
			$cart = $this -> session -> userdata('cart');
			$new_cart = array();
			if(is_array($cart) && count($cart) > 0){
				foreach($cart as $row){
					if($row['pid'] == $rid) continue;
					$new_cart[] = $row;
				}
			}
			$this -> session -> set_userdata('cart', $new_cart);
		}
		redirect('cart');
	}

	public function update_qty()
	{
		$qtyar = $this -> input -> post('qty');
		$id = $this -> input -> post('id');
		if($id){
			$str = preg_replace('/\D/', '', $id);
			$qtyar = array($str=>$qtyar);

		}
		$cart = $this -> session -> userdata('cart');
		$new_cart = array();
		if(is_array($cart) && count($cart) > 0){
			foreach($cart as $row){
				 if(array_key_exists($row['pid'], $qtyar)){
                    $pid = $row['pid'];
				 	$required_qty = $qtyar[$row['pid']];
					 $r = $this -> Product_model -> getProduct($pid);
					 $available_qty = $r -> qty;
                     if($required_qty > $available_qty){
                         $required_qty = $available_qty;
                     }
                    $row['qty'] = $required_qty;
				}
				$new_cart[] = $row;
			}
		}
		$this -> session -> set_userdata('cart', $new_cart);
		$this -> session -> set_flashdata('success', "Cart updated");
	}

	function update(){
		$qtyar = $this -> input -> post('qty');
		$cart = $this -> session -> userdata('cart');
		$new_cart = array();
		if(is_array($cart) && count($cart) > 0){
			foreach($cart as $row){
				if(array_key_exists($row['pid'], $qtyar)){
                    $pid = $row['pid'];
					$required_qty = $qtyar[$row['pid']];
                    $r = $this -> Product_model -> getProduct($pid);
                    $available_qty = $r -> qty;
                    if($required_qty > $available_qty){
                        $required_qty = $available_qty;
                    }
                    $row['qty'] = $required_qty;
				}
				$new_cart[] = $row;
			}
		}
		$this -> session -> set_userdata('cart', $new_cart);
		$this -> session -> set_flashdata('success', "Cart updated");
		redirect('cart');
	}

	function checkout(){
		$this -> data['carts'] = $this -> session -> userdata('cart');

		$this -> load -> model(array("City_model", "Order_model"));
		$this -> data['main'] = 'checkout';
		$this -> data['addresses'] = $this -> User_model -> getUserAddresses($this -> user_id());
		if(!$this -> isLoggedIn()){
            $url_to = urlencode(site_url('cart'));
			$this -> session -> set_userdata('redirect', $url_to);
			redirect('user/login');
		}
		$tu = $this -> User_model -> getUserById($this -> user_id());
		$this -> data['user'] = $tu;
		$this -> data['arstats'] = $this -> City_model -> getStates();

		if($tu -> default_address <> ''){
			$this -> data['address'] = $this -> User_model -> getAddress($tu -> default_address);
		}else{
			$taddress = array();
			$this -> data['address'] = $taddress;
		}

		$this -> form_validation -> set_rules('frm[ship_name]', 'Name', 'required');
		$this -> form_validation -> set_rules('frm[ship_add1]', 'Address', 'required');
		$this -> form_validation -> set_rules('frm[ship_city]', 'City', 'required');
		$this -> form_validation -> set_rules('frm[ship_mobile]', 'Mobile', 'required');
		if($this -> form_validation -> run()){
			$ship = $this -> input -> post('frm');
			$ship['user_id'] = $this -> user_id();
			$ship['id'] = false;
            $ship['ship_m_code'] = rand(1000, 9999);
			$adid = $this -> User_model -> saveAddress($ship);
			$this -> session -> set_userdata('cur_address', $adid);
			if($this -> input -> post('makeit')){
				$this -> User_model -> makeDefaultAddress($adid, $this -> user_id());
			}
			if(trim($tu -> default_address) == ''){
				$this -> User_model -> makeDefaultAddress($adid, $this -> user_id());
			}
            redirect('cart/checkout');
		}
		$this -> load -> view('default', $this -> data);
	}

    function applyCoupon(){
        $coupon = $this->input->post('coupon');
        if($this -> isLoggedIn()){
            $this->data['user_id'] = $this -> user_id();
            $check = $this->Coupons_model->couponExist($coupon, $this->data['user_id']);
            if($check){
                $this->session->set_flashdata('error',"You have already used this coupon");
                redirect('cart');
            }
            else{
                $this->data['c'] = $this->Coupons_model->validCoupon($coupon);
                if(!$this->data['c']){
                    $this -> session -> set_flashdata('error', "Invalid Coupon Code");
                    redirect('cart');
                }
                else{
                    $this->session->set_userdata($this->data['c']);
                    $this -> session -> set_flashdata('success', "Coupon applied on your cart");
                    redirect('cart');
                }
            }
        }
        else{
            //$coupon = $this->input->post('coupon');
            $this->data['c'] = $this->Coupons_model->validCoupon($coupon);
            //print_r($this->data['c']);
            if(!$this->data['c']){
                $this -> session -> set_flashdata('error', "Invalid Coupon Code");
                redirect('cart');
            }
            else{
                $this->session->set_userdata($this->data['c']);
                $this -> session -> set_flashdata('success', "Coupon applied on your cart");
                redirect('cart');
            }
        }

        //$row['coupon'] = $coupon;
    }

	function selectaddress(){
		if($this -> input -> post('btn_continue')){
			$adid = $this -> input -> post('adid');
			$this -> session -> set_userdata('cur_address', $adid);
			redirect('cart/save_orders');
		}
		redirect('cart/checkout');
	}

	function save_orders(){
		$this -> load -> model("Order_model");
		$ord = array();
		$ord['user_id'] = $this -> user_id();
		$address = $this -> User_model -> getDefaultAddress($this -> user_id());
		if($this -> session -> has_userdata('cur_address')){
			$adid = $this -> session -> userdata('cur_address');
			$address = $this -> User_model -> getAddress($adid);
		}
		//print_r($address->ship_pin);die;

        $sub = $subtotal1=$sum=0;
        $cart = $this->session->userdata('cart');
        //print_r($cart); //exit();
        foreach($cart as $c){
            $tmp = new AI_Product($c['pid']);
            //print_r($tmp);die;
            $ship = $tmp -> data("ship_charge");
            
            /****************Add to order table***************/
            $subtotal = $c['qty'] * $c['price'];
                            if(is_numeric($tmp ->ship_charge))
                            {
                                $subtotal1 = $subtotal + $tmp ->ship_charge ;
                            }
                            else
                            {
                                $subtotal1 = $subtotal + 0;
                            }
                            $sub = $subtotal;
                           
                            //$discount = $this->session->userdata('discount');
                            $coupon_code = $this->session->userdata('coupon_code');
                            //$d_type = $this->session->userdata('d_type');
                            //$type = $this->session->userdata('type');
                            $discount = $tmp->discount;
                            $d_type = $tmp->discount_type;
                             $discount_rate = $tmp->discount_rate;
                                if($d_type==2){
                                   
                                    $sub = $subtotal1 - $subtotal1 * $discount_rate / 100;
                                    
                                }
                                elseif($d_type == 1){
                                    
                                    if(is_numeric($discount_rate) and !empty($discount_rate) and $discount_rate>0){
                                        
                                        $sub = $subtotal1 - ($discount_rate * $c['qty']);
                                        //print_r($subtotal1);die;
                                    }
                                    else
                                    {
                                        $sub = $subtotal1;
                                    }
                                }
                                else{
                                    $sub = $subtotal1;
                                }
							$sum += $sub;
            /*********************************************/
        }


        $sub = $sum;
        $coupon_code = false;
        $discount = $tmp->discount;
		$d_type = $tmp->discount_type;
		$discount_rate = $tmp->discount_rate;
		
		$ord['shipping_id'] = $address -> id;
		$ord['created_on'] = date('Y-m-d h:i:s');
		$ord['modified_on'] = date('Y-m-d h:i:s');
		//$ord['payment_price'] = $this -> cartPrice();
		$data = theme_option('pin_codes');
		$pincodes = explode(',',$data);
		if(in_array($address->ship_pin, $pincodes)){
			$ord['payment_price'] = $sub - $ship;
			$ord['shipping_price'] = 0;
			$ord['total'] = $sub-$ship;
		}
		else{
			$ord['payment_price'] = $sub;
			$ord['shipping_price'] = $ship;		
			$ord['total'] = $sub;			
		}
        
		$ord['sub_total'] = $sub;
        $ord['coupon_total'] = $sub;
        //$ord['coupon_code'] = $coupon_code;
		$ord['status'] = "Pending";
		
		$order_id = $this -> Order_model -> saveOrders($ord);
		$this -> session -> set_userdata('orderid', $order_id);
		$cart = $this -> session -> userdata('cart');
		if(is_array($cart) && count($cart) > 0){
			foreach($cart as $cr){
				$sub=$subtotal1=0;
				$item = new AI_Product($cr['pid']);
				//print_r($item);die;
				$files = array();
				$files['order_id'] = $order_id;
				$files['product_id'] = $item -> ID();
				$files['product_name'] = $item -> title();
				$files['product_sku'] = $item -> sku();

				
				/**********************************************/
							$discount = $item->discount;
                            $d_type = $item->discount_type;
                             $discount_rate = $item->discount_rate;
                                if($d_type==2){
                                   
                                    $sub = $item -> price() - $item -> price() * $discount_rate / 100;
                                    $files['product_price'] = $sub * $cr['qty'];
                                    
                                }
                                elseif($d_type == 1){
                                    
                                    if(is_numeric($discount_rate) and !empty($discount_rate) and $discount_rate>0){
                                        
                                        $sub = $item -> price() - ($discount_rate);
                                        $files['product_price'] = $sub * $cr['qty'];
                                        //print_r($subtotal1);die;
                                    }
                                    else
                                    {
                                        
                                        $files['product_price'] = $item -> price() * $cr['qty'];
                                    }
                                }
                                else{
                                   
                                    $files['product_price'] = $item -> price() * $cr['qty'];
                                }
				/*********************************************/
				if(in_array($address->ship_pin, $pincodes)){
					$files['ship_charge'] = 0;
					$files['subtotal_price'] = $files['product_price']  ;
				}
				else{
					$files['ship_charge'] = $item -> shipCharge();
					$files['subtotal_price'] = $files['product_price'] + $item->shipCharge() ;			
				}
				//$files['ship_charge'] = $item -> shipCharge();
				//$files['subtotal_price'] = ($cr['price']*$c['qty']) + $item->shipCharge() ;
                $files['coupon_discount'] = $this->session->userdata('discount');
				$files['quantity'] = $cr['qty'];
				$files['attributes'] = $cr['size'];
				$files['created_on'] = date('Y-m-d h:i:s');
				$files['modified_on'] = date('Y-m-d h:i:s');
				//print_r($files);die;
				$this -> Order_model -> addFiles($files);
			}
			redirect('cart/revieworders');
		}else{
			redirect(site_url());
		}
	}


	function revieworders(){
        $this -> load -> model('Order_model');
        $this -> load -> model('Ajax_model');

		$this -> data['carts'] = $this -> session -> userdata('cart');
		if(!$this -> session -> has_userdata('cart')){
			redirect(site_url());
		}
		$this -> data['main'] = 'review-orders';
		$this -> data['price'] = $this -> cartPrice();

		$this -> data['orderid'] = $this -> session -> userdata('orderid');
        $this -> data['addresses'] = $this -> User_model -> getUserAddresses($this -> user_id());

        $this -> load -> view('default', $this -> data);
	}

	

	function cartPrice(){
		$orderid = $this -> session -> userdata('orderid');
		$ship_id = $this->db->select('shipping_id')->get_where('orders',array('id'=>$orderid))->row();
		//print_r($ship_id);die;
		
		$sid = $ship_id->shipping_id;
		$addresses = $this->db->get_where('users_address',array('id'=>$sid))->row();
		$ship_pin = $addresses->ship_pin;
	

		$carts = $this -> session -> userdata('cart');
		$sum =$subtotal1= 0;
		$d_type = '';
		$type='';
		$discount = '';
		$coupon_code = '';
		$sub=0;
		
		if(is_array($carts) && count($carts) > 0){
			foreach($carts as $citem){
				$tmp = new AI_Product($citem['pid']);
				
				$subtotal = $citem['qty'] * $citem['price'];
				if(is_numeric($tmp ->ship_charge)){
					$subtotal1 = $subtotal + $tmp ->ship_charge  ;
				}
				else
				{
					$subtotal1 = $subtotal + 0;
				}
				$gst=$this->db->get_where('products',array('id'=>$citem['pid']))->row();
                $gst_amt=$subtotal1 * $gst->gst / 100;
                 //print_r($gst_amt);
				$sub = $subtotal;

				$discount = $tmp->discount;

				$d_type = $tmp->discount_type;
				$discount_rate = $tmp->discount_rate;
					if($d_type==2){
						$sub = ($subtotal1 - $subtotal1 * $discount_rate / 100) + $gst_amt ;
				      //print_r($sub);

					}
					elseif($d_type == 1){
						if(is_numeric($discount_rate)){
							$sub = $subtotal1 - ($discount_rate * $citem['qty']) +$gst_amt ;
						}
						else
						{
							$sub = $subtotal1 + $gst_amt;
						}
					}
					else{
						$sub = $subtotal1 + $gst_amt;
					}
				$sum += $sub;

			}
		}
		$data = theme_option('pin_codes');
		$pincodes = explode(',',$data);
		if(in_array($ship_pin, $pincodes)){
		    $tt = $sum - $tmp ->ship_charge;
			return number_format($tt,2);
		}
		else{
		   
			return number_format($sum,2);						
		}
	}

    private function cartItemCount(){
        $c = 0;
        if($this -> session -> has_userdata('cart')){
            $carts = $this -> session -> userdata('cart');
            $c = count($carts);
        }
        return $c;
    }

	function payments(){
		//print_r($_SESSION);
		$this -> data['availability'] = $this -> input -> post('availability');
		$this -> data['main'] = 'payments';
	     $carts = $this -> session -> userdata('cart');
		$this -> data['carts'] = $carts;
		//$print_r($carts[0]['pid']);
		$this -> data['pay']=$this->db->select('cod_available')->get_where('products',array('id'=>$carts[0]['pid']))->row();
		$this -> data['cartprice'] = $this -> cartPrice();
		//print_r($this -> data['cartprice']);
		$this -> load -> view('default', $this -> data);
		
	}
	

	function payment_process(){
		if(!$this -> session -> has_userdata('cart')){
			redirect(site_url());
		}
		$this -> load -> model("Order_model");
		if($this -> input -> post('btn_confirm')){
			$order_id = $this -> session -> userdata('orderid');
			$o = $this->Master_model->getRow($order_id, 'orders');
			$ord = array();
			$ord['id'] = $order_id;
			$ord['pay_method'] = "COD";
			$ord['pay_status'] = "Pending";
			$ord['coupon_code'] = 0;
			$ord['payment_price'] = $o->payment_price;
			$ord['coupon_total'] = 0;
			$ord['order_status'] = "Processing";
			$orderid = $this -> Order_model -> save($ord);
			$userid = $_SESSION['login']['user_id'];
			$detail = $this->db->get_where('users',array('id'=>$userid))->row();
			$to = $detail->phone_no;
			$msg = "Hello, Your Order has been successfully placed. your order no is ".$orderid." Amount payable Rs".$o->payment_price.". Thank you.";
			//echo $to;
			//echo $msg;die;
			sendSMS($to, $msg);
			$this -> session -> unset_userdata('cart');
			$this->session->set_flashdata('success',"your Order has been successfully Placed.");
		}
		redirect(site_url(''));
	}
	
	function confirm(){
		$this -> load -> model("Order_model");
            $this->data['carts'] = $this -> session -> userdata('cart');
            $carts = $this->data['carts'];
            if(is_array($carts) && count($carts) > 0){
                foreach($carts as $row)
                {
                    $pid = $row['pid'];
                    $qty = $row['qty'];
                    $r = $this -> Product_model -> getProduct($pid);
                    $available_qty = $r -> qty;
                    $data['qty'] = $available_qty - $qty;
                    $data['id'] = $pid;
                    $this -> Master_model -> save($data, 'products');
				}
			}
		    $order_id = $this -> session -> userdata('orderid');
	        $this -> data['cartprice'] = $_SESSION['payamount']['total'];
	        $this -> session -> unset_userdata('cart');
	        // $coupon_code = $this->session->userdata('coupon_code');
	        // $aa = $this->Coupons_model->validCoupon($coupon_code);
	        // $no_of_use = $aa['no_of_use'];
	        // $this->ss['id'] = $aa['id'];
	        // $this->ss['no_of_use'] = $no_of_use - 1;
	        // //$this->Order_model->save($this->ss, 'coupons');
	        // $this -> session -> unset_userdata('discount');
	        // $this -> session -> unset_userdata('coupon_code');
	
		$this -> data['main'] = 'order_confirm';
		$this -> data['order'] = $this -> Order_model -> orderDetails($order_id);
        $user = $this -> Master_model -> getRow($this -> user_id(), 'users');
        $mobile = $user -> phone_no;
        //$msg = "Your order has been confirmed. order number: ACP".$order_id.". Thanks for order www.aldivo.com";
        //sendSMS($mobile, $msg);
        $new_order_id = 'OSG'.$order_id;
        //========Write code to send email for verification =============
        //$m = new AI_Mail();
        //$m -> onConfirmOrder($user->first_name, $user->email_id, $new_order_id) -> sendMail();

		$this -> load -> view('default', $this -> data);
	}
	
	function confirm_package(){
		$this -> load -> model("Order_model");
           
		    $order_id = $this -> session -> userdata('orderid');
		    $o = $this->Master_model->getRow($order_id, 'orders');
	        $this -> data['cartprice'] = $o->total;
	        $this -> session -> unset_userdata('cart');
	        // $coupon_code = $this->session->userdata('coupon_code');
	        // $aa = $this->Coupons_model->validCoupon($coupon_code);
	        // $no_of_use = $aa['no_of_use'];
	        // $this->ss['id'] = $aa['id'];
	        // $this->ss['no_of_use'] = $no_of_use - 1;
	        // //$this->Order_model->save($this->ss, 'coupons');
	        // $this -> session -> unset_userdata('discount');
	        // $this -> session -> unset_userdata('coupon_code');
	
		$this -> data['main'] = 'order_package_confirm';
		$this -> data['order'] = $this -> Order_model -> orderDetails($order_id);
        $user = $this -> Master_model -> getRow($this -> user_id(), 'users');
        $mobile = $user -> phone_no;
        //$msg = "Your order has been confirmed. order number: OSG".$order_id.". Thanks for order www.aldivo.com";
        //sendSMS($mobile, $msg);
         $new_order_id = 'OSG'.$order_id;
        //========Write code to send email for verification =============
        //$m = new AI_Mail();
        //$m -> onConfirmOrder($user->first_name, $user->email_id, $new_order_id) -> sendMail();

		$this -> load -> view('default', $this -> data);
	}
	
	function add_wishlist(){
		$user_id = $this->user_id();
		$pid = $_POST['pid'];
        if(!$this -> isLoggedIn()){
            echo "Please login to add wishlist";
            
        }
        $id = false;
        $user_id = $this->user_id();
        $data=array('id'=>$id, 'pid'=>$pid, 'user_id'=>$user_id);
        $exist = $this -> User_model->checkWishlist($pid, $user_id);
        if($exist > 0) {
            echo "You have already added this product to wishlist.";
        }
        else{
            $this->Master_model->save($data, 'ai_wishlist');
            echo "Your wishlist added.";
        }

	}

    function add_wishlist1(){
        $url = $_GET['url'];
        $pid = $_['id'];
        if(!$this -> isLoggedIn()){
            //echo "<script> alert('Please login to add wishlist'); </script>";
            $url_to = $url;
            $this -> session -> set_userdata('redirect', $url_to);
            redirect('user/login');
        }
        $id = false;
        $user_id = $this->user_id();
        $data=array('id'=>$id, 'pid'=>$pid, 'user_id'=>$user_id);
        $exist = $this -> User_model->checkWishlist($pid, $user_id);
        if($exist > 0) {
            $this -> session -> set_flashdata('error', "You have already added this product to wishlist.");
            redirect($url);
        }
        else{
            $this->Master_model->save($data, 'ai_wishlist');
            $this -> session -> set_flashdata('success', "Your wishlist added.");
            redirect($url);
        }

    }

    function del_address($id){
        if($id){
            $this -> Master_model -> delete($id, 'users_address');
            $this -> session -> set_flashdata('Successfully Deleted address');
            redirect('cart/checkout');
        }
    }
	
	function edit_address($id = false){
		$this -> load -> model('City_model');
        $this -> data['main'] = 'address-edit';
        $this->data['active'] = 'address';
		$this -> data['arstats'] = $this -> City_model -> getStates();
        $this -> data['addresses'] = $this -> User_model -> getAddress($id);
        $dv = $this->db->get_where('users',array('id'=>$this->user_id()))->row();
        $this->data['def_add'] = $dv->default_address;
        $this -> load -> view('default', $this -> data);
    }

    function confirm_ordermeail(){
	     $this -> load -> model("Order_model");
	    // print_r($_SESSION);
		 // $order_id = $this -> session -> userdata('orderid');
		 $order_id = 708;
		 $this -> data['main'] = 'orderconfirmationmail';
		 $this -> data['order'] = $this -> Order_model -> orderDetails($order_id);
		 $this -> load -> view('default', $this -> data);
	}

	/* user ranking and activation*/

	function ranking(){
		$this -> load -> model("Order_model");
		$users_order = $this -> Order_model -> getTotalprice(user_id());
		$total_price = 0;
		foreach($users_order as $order){
			$total_price += $order->payment_price;
		}
		if($total_price >=3000){
			$chkactivation = $this -> User_model -> checkActive(user_id());
			if($chkactivation){
				$this -> User_model -> updateActivation(user_id());
			}
			else{
				echo "activated";
			}
		}
	}

	function cashback(){
		
		$u_info= $this->db->get_where('users',array('id'=>user_id()))->row();
		$carts = $this -> session -> userdata('cart');
		foreach($carts as $c){
		$pdt[]=$this->db->get_where('products',array('id'=>$c['pid']))->row();
		foreach($pdt as $p){
			if($p->casback_type==1){
				 $wallet=  $p->discount_amount*$c['qty'];
				 $w['wallet']=$wallet;
				 $this->db->update('users',$w,array('id'=>$u_info->id));
			}
			else{
				 $wallet= ($p->price * $p->discount_amount/100)*$c['qty'];
				 $w['wallet']=$wallet;
				 $this->db->update('users',$w,array('id'=>$u_info->id));
			}
		}
	    }
     
	}
}
