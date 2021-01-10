<?php

class Store extends AI_Controller
{
    var $category;
    private $perPage = 24;

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Category_model', 'Search_model', 'Product_model'));
        $this->load->helper(array('cookie', 'url'));
        $seo_title = theme_option('seo_title');
        $this->data['seo_title'] = $seo_title;
        $this->data['seo_description'] = "";
        $this->data['seo_keywords'] = "OSG";
        $this -> data['carts'] = $this -> session -> userdata('cart');
    }

   
    function index(){
       if ($this -> agent -> is_mobile()) {
          $this->data['main'] = 'index_mobile';
       }
       else{
        $this->data['main'] = 'index';
          }
        $this->data['cat'] = $this->Category_model->categories();
        $this->data['recent'] = $this->db->get_where('products',array('status'=>1))->result();
        $this->data['f_products'] = $this->db->limit(24)->get_where('products',array('featured'=>1))->result();
        //echo $this->db->last_query();

         $this->data['p_cat'] = $this->db->get_where('categories',array('mobile_cat'=>1))->result();
        //print_r($this->data['p_cat'] );
        $this->data['cbrands'] = $this->db->get_where('cloths_brand',array('top_brand'=>1))->result();
        $this->data['gbrands'] = $this->db->get_where('grocery_brand',array('top_brand'=>1))->result();
        $this->data['mbrands'] = $this->db->get_where('marble_brands',array('top_brand'=>1))->result();
        $this->data['hbrands'] = $this->db->get_where('health_brands',array('top_brand'=>1))->result();
        $this->data['home_banner'] = $this->db->get_where('gallery_img',array('gallery_id'=>28))->result();
      $this->data['top_banner'] = $this->db->get_where('gallery_img',array('gallery_id'=>29))->result();
	$this->data['middle_banner'] = $this->db->get_where('gallery_img',array('gallery_id'=>31))->result();
        $this->data['bottom_banner'] = $this->db->get_where('gallery_img',array('gallery_id'=>30))->result();
        $this->load->view('default', $this->data);
    }

    function categories(){

        $this->data['main'] = 'categories';
        $this->data['categories'] = $this->db->get_where('categories',array('popular_cat'=>1))->result();
        $this->load->view('default', $this->data);
    }

    function category($slug=false,$id=false){
        $this->data['main'] = 'category';
        $this->data['cat'] = $this->Category_model->categories();
        $this->data['childs'] = $this->Category_model->getSubCat($id);
        $this->data['subcat'] = $this->Product_model->get_products($id);
        $this->data['parent'] = $this -> db -> get_where('categories', array('id' => $id)) -> first_row();
        $this -> db -> order_by('id', 'DESC');
        $this -> db -> limit(5);
        $this->data['recent'] = $this->db->get('products')->result();
        $this->load->view('default', $this->data);
    }
    
    function featured_product()
    {
        $this->data['main'] = 'featured_product';
        $this->data['products'] = $this->db->get_where('products',array('featured'=>1))->result();
        $this->load->view('default', $this->data);
    }

    function product_details($slug, $id){
        $seo = $this -> Product_model -> getRow($id);
        if(is_object($seo)){
            $this -> data['seo_title'] = $seo -> meta_title;
            $this -> data['seo_description'] = $seo -> meta_description;
            $this -> data['seo_keywords'] = $seo -> meta_keywords;
        }
        $this->data['units'] = $this->db->get_where('units',array('pid'=>$id))->result();
        $p = $this->Product_model->getProduct($id);
        
        if(!is_object($p)){
            redirect('store');
        }
        if ($p->status == 0) {
            $this->session->set_flashdata("error", "Product unavailable");
            redirect(site_url());
        }
        $this->data['p'] = $p;
        $this -> db -> order_by('id', 'DESC');
        $this -> db -> limit(5);
        $this->data['recent'] = $this->db->get('products')->result();
        $this->data['similar'] = $this->db->get_where('products',array('product_type'=>$p->product_type))->result();
        $this->data['main'] = 'details';
        $this->load->view('default', $this->data);
    }

    function page ($slug) {
        $page = $this -> db->get_where('pages',array('slug'=>$slug))->row();
        $this->data['pages'] = $page;
        $this -> data['main'] = 'page';
        if($page) {
            $this->data['seo_title'] = $page->meta_title;
            $this -> data['seo_description'] = $page -> meta_description;
            $this -> data['seo_keywords'] = $page -> meta_keywords;
        }
        $this-> load -> view ('default', $this -> data);
    }

    function unit_prod(){
        $this->data['unit_qty'] = $_POST['unit'];
        $this->data['price'] = $_POST['price'];
        $this->data['url'] = $_POST['url'];
        $id = $_POST['id'];
        $this->data['units'] = $this->db->get_where('units',array('pid'=>$id))->result();
        $this->data['p'] = $this->db->get_where('products',array('id'=>$id))->row();
        $this->load->view('prod_detail',$this->data);
    }

    function contact(){
        $this->data['main'] = 'contact';
        $from_email =$this->input->post('email'); 
        $to_email ="sppoort@raeesworld.com"; 
        $name=$this->input->post('fullname');  
        $phone=$this->input->post('mobile'); 
        $message=$this->input->post('message'); 
        $service=$this->input->post('service'); 
        $config = Array(
          'protocol' => 'sendmail',
          'mailtype' => 'html', 
          'charset' => 'utf-8',
          'wordwrap' => TRUE
        );
        $this->load->library('email',$config); 
          if($this->input->post('submit')){
             $this->email->from($from_email, $name); 
             $this->email->to($to_email);
             $this->email->subject("test mail"); 
             $this->email->message('<b>Name - </b>'.$name.'<br> <b>Phone - </b>'.$phone.'<br><b>Email - </b>'.$from_email.'<br><b>Service - </b>'.$service.'<br><b>Message - </b>'.$message); 
            if($this->email->send()) {
                $this->session->set_flashdata("success","Email sent successfully."); 
                redirect(site_url('contact'));
             }
             else 
             {
                $this->session->set_flashdata("error","Error in sending Email."); 
                redirect(site_url('contact'));
             }
        }
       $this -> load->view("default", $this -> data);
    }

    function login(){
        if ($this->isLoggedIn()) {
            redirect('accounts');
        }
        $this->data['main'] = 'login';
        $this -> form_validation -> set_rules('data[username]', 'Username', 'required');
        $this->form_validation->set_rules('data[password]', 'Password', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post('data');
            $username = $data['username'];
            $pass = $data['password'];
            if ($this->User_model->loginCheck($username, $pass)) {
                $u = $this->User_model->getUser($username);
                
                $s = array(
                    'user_id' => $u->id,
                    'loggedat' => time(),
                    'user_type' => $u->user_type,
                );
                $this->session->set_userdata('login', $s);
                if ($this->session->has_userdata('redirect')) {
                    $url_to = $this->session->userdata('redirect');
                    $this->session->unset_userdata('redirect');
                    redirect(urldecode($url_to));
                }
                if(isset($_POST['redirect']))
                {
                  redirect('cart');
                }
                else
                {
                     $user=$this->session->userdata('login');
                     //echo $user;
                     if($user['user_type']=="vender"){
                        redirect(site_url('accounts/vender')); 
                     }
                     else{
                  redirect('accounts');
              }
                }
            } 
            else {
                $this->session->set_flashdata("error", "Invalid User Name /Password");
                redirect(site_url('login'));
            }
        } 
        else{
            $this->load->view('default', $this->data);
        }
    }

     function register(){
         if ($this->isLoggedIn()) {
            redirect('accounts');
         }
        $this -> data['states'] = $this -> User_model -> state_dropdown();
        $this->data['main'] = 'register';
        $this->form_validation->set_rules('data[first_name]','First Name','required');
        $this->form_validation->set_rules('data[phone_no]', ' Mobile Number', 'required|exact_length[10]|is_unique[users.phone_no]');
        $this->form_validation->set_rules('data[email_id]', ' Email ID', 'required|is_unique[users.email_id]');
      
        $this->form_validation->set_rules('data[pass]', ' Password', 'required');
        if ($this->form_validation->run()) {
            $u = $this->input->post('data');
            $email = $u['email_id'];
            $dt = explode('@',$email);
            $u['username'] = strtolower($dt[0]);
            $u['first_name'] = strtolower($u['first_name']);
            $u['last_name'] = strtolower($u['last_name']);
            $u['email_id'] = strtolower($u['email_id']);
            $u['created'] = date('Y-m-d h:i:s'); 
            $u['status'] = 1;
            $u['user_type'] = "user";
            $this->load->model("User_model");
            //print_r($u);die;
            $id = $this->User_model->createAccount($u);
            //print_r($id);
             $to = $u['phone_no'];
          //echo $to;
          $msg = "Hello, Your username is ".$u['username']." and your Password is ".$u['pass'].". Thank you.";
           sendSMS($to, $msg);
            $this->session->set_flashdata("success", "Account Created Successfully. ");
            // ========Write code to send email for verification =============
            // $m = new AI_Mail();
            // $m->onSignup($u['first_name'], $u['email_id'], $u['act_code'])->sendMail();
            if(isset($_POST['redirect'])){
                redirect('store/login?red=cart');
            }
            else
            {
                redirect('store/login');
            }
        } 
        else{
            $this->load->view('default', $this->data);
        }
    }




     function vender_register()
    {
       
          $this -> data['category']= $this -> Category_model -> category_dropdown();
        $this -> data['states'] = $this -> User_model -> state_dropdown();
        $this->data['main'] = 'vender-register';
       
           if ($this->isLoggedIn()) {
            redirect('accounts');
         }
        $this -> data['states'] = $this -> User_model -> state_dropdown();
     
        $this->form_validation->set_rules('data[first_name]','First Name','required');
        $this->form_validation->set_rules('data[phone_no]', ' Mobile Number', 'required|exact_length[10]|is_unique[users.phone_no]');
        $this->form_validation->set_rules('data[email_id]', ' Email ID', 'required|is_unique[users.email_id]');
      
        $this->form_validation->set_rules('data[pass]', ' Password', 'required');
        if ($this->form_validation->run()) {
            $u = $this->input->post('data');
            $email = $u['email_id'];
            $dt = explode('@',$email);
            $u['username'] = strtolower($dt[0]);
            $u['first_name'] = strtolower($u['first_name']);
            $u['last_name'] = strtolower($u['last_name']);
            $u['email_id'] = strtolower($u['email_id']);
            $u['created'] = date('Y-m-d h:i:s'); 
            $u['status'] = 1;
            $u['user_type'] = "vender";
            $this->load->model("User_model");
            //print_r($u);die;
            $id = $this->User_model->createAccount($u);
            //print_r($id);
             $to = $u['phone_no'];
          //echo $to;
          $msg = "Hello, Your username is ".$u['username']." and your Password is ".$u['pass'].". Thank you.";
           sendSMS($to, $msg);
            $this->session->set_flashdata("success", "Account Created Successfully. ");
            // ========Write code to send email for verification =============
            // $m = new AI_Mail();
            // $m->onSignup($u['first_name'], $u['email_id'], $u['act_code'])->sendMail();
            if(isset($_POST['redirect'])){
                redirect('store/login?red=cart');
            }
            else
            {
                redirect('store/login');
            }
        } 
        else{
            $this->load->view('default', $this->data);
        }
    }

    function logout(){
        $lastdate = array(
            'lastvisitdate'=>date('Y-m-d h:i:s')
        );
        $this->db->where('id',$this->user_id());
        $this->db->update('users',$lastdate);
        //echo $this->db->last_query();die;
        $u = array(
            'lastvisitdate' => date('Y-m-d h:i:s'),
            'id' => $this->user_id()
        );
        $this->User_model->save($u);
        $this->session->sess_destroy();
        $this->session->set_flashdata("success", "Successfully logged out");
        redirect('login');
    }

    function search(){
        $this->data['main'] = 'search-all';
        $this->data['paginate'] = false;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $show_per_page = 32;
        $offset = ($page - 1) * $show_per_page;
        //$data = $this->Product_model->getAll($show_per_page, $offset);
        $q = $this->input->get('q');
        if ($q !== "") {
            if ($q <> '') {
                $likes = array(
                    'ptitle' => $q
                );
                $data = $this->Product_model->getAllSearched($offset, $show_per_page, $likes);
            }
        }
        $this->data['products'] = $data['results'];
        $config['base_url'] = site_url('store/search');
        $config['num_links'] = 2;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $data['total'];
        $config['per_page'] = $show_per_page;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm custom-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link'] = '<i class="fa fa-chevron-left"></i> First Page';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last Page <i class="fa fa-chevron-right"></i>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa-chevron-left"></i> <span>Previous Page</span>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '<span>Next Page</span> <i class="fa fa-chevron-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['use_page_numbers'] = true;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);
        $this->data['paginate'] = $this->pagination->create_links();
        $this->load->view('default', $this->data);
    }

    function forgot_password(){
      $this->data['main'] = 'forgot-password';
      $this->form_validation->set_rules('form[mobile]', 'Mobile no.', 'required');
      if ($this->form_validation->run()) {
          $m = $this->input->post('form'); 
          $chkmob = $this->User_model->chkMob($m['mobile']);
          if($chkmob)
          {
            $users = $this->User_model->getUserdata($m['mobile']);
            $otp = mt_rand(1000, 9999);
            $saveotp = $this->User_model->save_otp($otp,$m['mobile']);
            $to = $m['mobile'];
            $msg = "Hi , Your OTP is ".$otp.".";
           // print_r($msg);die;
            sendSMS($to, $msg);
            $this->session->set_flashdata("success", "Please enter OTP sent to your registered or given mobile no");
            redirect(site_url('verification'));
          }
          else
          {
            $this->session->set_flashdata("error", "Sorry ! You are not Registered.");
            redirect(site_url('login'));
          }
        }
        
      $this-> load -> view ('default', $this -> data);
     }

     function verify(){
      $this->data['main'] = 'verify';
      $this->form_validation->set_rules('form[otp]', 'OTP', 'required');
     
      if ($this->form_validation->run()) {
        $o = $this->input->post('form');
        $users = $this->db->get_where('users',array('otp'=>$o['otp']))->row();
        if($users->otp == $o['otp']){
          $to = $users->phone_no;
          //echo $to;
          $msg = "Hello, Your username is ".$users->username." and your Password is ".$users->pass.". Thank you.";
          //print_r($msg);die;
           sendSMS($to, $msg);
           $this->session->set_flashdata("success", "Your password is sent on registered mobile");
          redirect(site_url('login'));
        }
        else
        {
          $this->session->set_flashdata("error", "OTP is not correct.");
          redirect(site_url('verification'));
        }

      }
      $this -> load -> view('default' , $this->data);
     }

     function enquiry_now(){
        if(isset($_POST)){
            $url = $_POST['url'];
            $this->load->library('email');
            $this->email->from($_POST['email'], $_POST['name']);
            $this->email->to('suraj@originitsolution.com');
            $this->email->subject($_POST['sub']);
            $this->email->message($_POST['desc']);
            
            $mail = $this->email->send();
            if($mail == true){
                $this->session->set_flashdata('success','Query successfully sent!');
                redirect($url);
            }
            else{
                $this->session->set_flashdata('error','Something went wrong.');
                redirect($url);
            }
        }

     }

     function cloth_price(){
        $this->data['size'] = $_POST['size'];
        $this->data['url'] = $_POST['url'];
        $id = $_POST['id'];
        $this->data['p'] = $this->db->get_where('products',array('id'=>$id))->row();
        $this->load->view('cloth_details',$this->data);
    }
 // function allproduct($id)
 //    {
 //        $this->data['main'] = 'allproduct';
 //        $this->data['products'] = $this->db->get_where('products',array('category'=>$id))->result();
 //        $this->load->view('default', $this->data);
 //    }

}
?>