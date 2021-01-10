<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->library('instamojo');
		$this->load->helper('url');
		 // $this -> data['top'] = $this -> Package_model -> top();
   //      $this -> data['late'] = $this -> Package_model -> latest(2);
	}
	public function index()
	{
	    //svar_dump($_POST);
	    if($this->input->post('submit')){
	        $package = $this->input->post('purpose');
	        $amount = $this->input->post('amount');
	        //print_r($amount);die;
	        $name = $this->input->post('name');
	        $email = $this->input->post('email');
	        $contact = $this->input->post('phone');
	        
		$pay = $this->instamojo->pay_request(
			$amount = $amount , 
			$purpose = $package ,
			$buyer_name = $name ,
			$email = $email , 
			$phone = $contact ,
			$send_email = 'TRUE' ,
			$send_sms = 'TRUE' , 
			$repeated = 'FALSE'
		);
		//      		echo "<pre>";
		// var_dump($pay); die;

		$redirect_url = $pay['longurl']   ;
       //var_dump($redirect_url); die;

		redirect($redirect_url,'refresh') ;
	    }

	}

	public function get_all()
	{
		$result = $this->instamojo->all_payment_request();

		print_r($result);
	}


	public function pay_request()
	{
		
		$pay = $this->instamojo->pay_request( 
			$amount = "200" , 
			$purpose = "TEST" , 
			$buyer_name = "rbbqq" ,
			$email = "rajeevbbqq@gmail.com" , 
			$phone = "89xxxx2017" ,
			$send_email = 'TRUE' , 
			$send_sms = 'TRUE' , 
			$repeated = 'FALSE'
		);

		$payment_id = $pay['id'];  
		// <= Payment Id
		// print_r($pay) ; <=  Prints all the data from the request

	}


	public function status()
	{
		$requestId  = '84c04c212ccb4a8ba8c87e35ec4a2511'  ; // $reqid generated using pay_request()
		$status     = $this->instamojo->status($requestId);
		

		print_r($status);
	}


	public function payment_status()
	{   
		//print_r($_POST); die;
	    $this -> data['main'] = 'payment_status';
		$requestId = $_GET['payment_request_id']  ;
		print_r($requestId); die;
	    $da   = $this->instamojo->status($requestId);
	   	
	   	//print_r($this->data); die;
	    $status = $da['status'];
	    $transaction_id =  $da['id']; 
	    $buyer_name =  $da['payments'][0]['buyer_name']; 
	    $amount =  $da['amount']; 
	    // print_r($amount);die;
	    $package_name =  $da['purpose']; 
	    $email =  $da['payments'][0]['buyer_email']; 
	    $contact =  $da['payments'][0]['buyer_email']; 
	    $paymentid = $da['payments'][0]['payment_id']; 
	    $method = $da['payments'][0]['instrument_type'];

	    if($status=='Failed'){
	       $this -> data['msg'] = '<h4 style="text-align:center;">Transaction Failed</h4><br/><b>Transaction Id :</b> '.$transaction_id.'<br/><b>Buyer name :</b> '.$buyer_name.'<br/><b>Amount :</b> '.$amount.'<br>';
	           $to = "suraj@originitsolution.com";
	           //$to = "manoj@originitsolution.com";
                $subject='Transaction Failed ('.$transaction_id.')';
                $message="Name: ".$buyer_name."<br> "."Email ID: ".$email."<br>" ."Contact No: ".$contact."<br>"."package_name: ".$package_name."<br>"."Status: ".$status.' <br> Thank You <br> Just Hike.';
                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-type: text/html; charset=iso-8859-1';
                $headers[] = 'To:  <' . $to. '>';
                $headers[] = 'From:' . $email;
                mail($to,$subject, $message, implode("\r\n", $headers));
                $message1='Your Transaction Failed. Transaction ID.'.$transaction_id;
                
                $headers1[] = 'MIME-Version: 1.0';
                $headers1[] = 'Content-type: text/html; charset=iso-8859-1';
                $headers1[] = 'To:  <' . $email. '>';
                $headers1[] = 'From: noreply@justhiketours.com';
                mail($email,$subject, $message1, implode("\r\n", $headers1));

                redirect('payment/pay_status?payment_id='.$_GET['payment_id'].'&payment_status='.$_GET['payment_status'].'&payment_request_id='.$_GET['payment_request_id']); 
	        
	    }
	    if($status=='Completed'){
	    	
	    	$order_id = $this->session->userdata('orderid');
	    	//print_r($order_id);die;
	    	$dt = array(
	    		'payment_id'=>$paymentid,
	    		'pay_method'=>$method,
	    		'pay_status'=>'Received',
	    		'status'=>'Processing',
	    		'order_status' => "Processing",
	    		'payment_price'=> $amount
	    	);
	    	$this->db->where('id',$order_id);
	        $this->db->update('orders',$dt);
	        $userid = $_SESSION['login']['user_id'];
	        $detail = $this->db->get_where('users',array('id'=>$userid))->row();

	        $to = $detail->phone_no;
			$msg = "Hello, Amount payable received. your order no is ".$order_id.". Thank you.";
			//echo $to;
			//echo $msg;die;
			sendSMS($to, $msg);
	       //echo $this->db->last_query();die;
	         $this -> data['msg'] = '<h4 style="text-align:center;">Transaction Successfully</h4><br/><b>Transaction Id :</b> '.$transaction_id.'<br/><b>Buyer name :</b> '.$buyer_name.'<br/><b>Amount :</b> '.$amount.'<br>';
	           $to = "suraj@originitsolution.com";
	         //   $to = "sunil@originitsolution.com";
                $subject='Transaction Successfully ('.$transaction_id.')';
                $message="Name: ".$buyer_name."<br> "."Email ID: ".$email."<br>" ."Contact No: ".$contact."<br>"."Product_name: ".$package_name."<br>"."Status: ".$status.' <br> Thank You <br> raeesworld.';
                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-type: text/html; charset=iso-8859-1';
                $headers[] = 'To:  <' . $to. '>';
                $headers[] = 'From:' . $email;
                mail($to,$subject, $message, implode("\r\n", $headers));
                $message1='Your Transaction Successfully. Transaction ID.'.$transaction_id;
                
                 $headers1[] = 'MIME-Version: 1.0';
                $headers1[] = 'Content-type: text/html; charset=iso-8859-1';
                $headers1[] = 'To:  <' . $email. '>';
                $headers1[] = 'From: noreply@originitsolution.com';
                mail($email,$subject, $message1, implode("\r\n", $headers1));
                
                $p_info = $this->db->get_where('order_items',array('order_id'=>$order_id))->result();
                $uid = $this->db->get_where('users',array('id'=>user_id()))->row();


                //  echo "<pre>";
                // print_r($uid);die;
                foreach($p_info as $p){
                     $pid = $p->product_id;
                     $p_qty= $p->quantity;
                     $p = $this->db->get_where('products',array('id'=>$pid))->row();
                    
                     if($p->cashback_type ==1){
                        $w_amt=$uid->wallet;
                        $p_amt=$p->discount_amount*$p_qty;
                        $w['wallet'] = $p_amt+$w_amt;
                        $this->db->update('users',$w,array('id'=>$uid->id));
                        

                    }
                    elseif ($p->cashback_type ==2) {
                    	$w_amt=$uid->wallet;
                    	$p_amt=($p->price * $p->discount_amount / 100) * $p_qty;
                    	$w['wallet'] = $p_amt+$w_amt;
                    	$this->db->update('users',$w,array('id'=>$uid->id)); 
                    	
                    }




                }

            redirect('payment/pay_status?payment_id='.$_GET['payment_id'].'&payment_status='.$_GET['payment_status'].'&payment_request_id='.$_GET['payment_request_id']);  

	    }
	    
		 $this -> load -> view('default', $this -> data);
	
	}

	function pay_status()
	{
               $payment_id = $_GET['payment_id'];
                $payment_status=$_GET['payment_status'];
                $payment_request_id=$_GET['payment_request_id'];

		$this -> data['main'] = 'pay_status';
		$requestId = $_GET['payment_request_id']  ;
	    $da   = $this->instamojo->status($requestId);
	   	
	   	//print_r($this->data);
	    $status = $da['status'];
	    $transaction_id =  $da['id']; 
	    $buyer_name =  $da['payments'][0]['buyer_name']; 
	    $amount =  $da['amount']; 
	    // print_r($amount);die;
	    $package_name =  $da['purpose']; 
	    $email =  $da['payments'][0]['buyer_email']; 
	    $contact =  $da['payments'][0]['buyer_email']; 
	    $paymentid = $da['payments'][0]['payment_id']; 
	    $method = $da['payments'][0]['instrument_type'];

	    if($status=='Failed'){
	    	 $this -> data['msg'] = '<h4 style="text-align:center;">Transaction Failed</h4><br/><b>Transaction Id :</b> '.$transaction_id.'<br/><b>Buyer name :</b> '.$buyer_name.'<br/><b>Amount :</b> '.$amount.'<br>';
	    }
	    if($status=='Completed'){

	    	$this -> data['msg'] = '<h4 style="text-align:center;">Transaction Successfully</h4><br/><b>Transaction Id :</b> '.$transaction_id.'<br/><b>Buyer name :</b> '.$buyer_name.'<br/><b>Amount :</b> '.$amount.'<br>';
	    }
	    
      $this -> load -> view('default', $this -> data);

	}



	public function show()
	{
		$data['request_id'] = '84c04c212ccb4a8ba8c87e35ec4a2511' ;
		$this->load->view('instamojo' ,$data);
	}

}

/* End of file example.php */
/* Location: ./application/controllers/example.php */