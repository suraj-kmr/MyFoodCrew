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
        $this->load->view('index.html');
    }
   /*function index()
    {
        $this->load->model("Gallery_model");
        $this->data['image'] = $this->Gallery_model->getImages(28);
        $this->data['packages'] = $this->db->get_where('package')->result();
        $this->data['cat'] = $this->Category_model->categories();
        $this -> db -> order_by('id', 'DESC');
        $this -> db -> limit(4);
        $this->data['recent'] = $this->db->get('products')->result();
         $this->data['client'] = $this->db->get('client_testimonial')->result();
        $this->data['main'] = 'index';
        $this->load->view('default', $this->data);
    }*/

    function categories()
      {

        $this->data['main'] = 'categories';
        $this->data['categories'] = $this->db->get_where('categories',array('popular_cat'=>1))->result();
        $this->load->view('default', $this->data);
    }
    function category($id)
      {
        $this->data['main'] = 'category';
        $this->data['cat'] = $this->Category_model->categories();
        $this->data['childs'] = $this->Category_model->getSubCat($id);
        $this->data['subcat'] = $this->Product_model->get_products($id);
        $this->data['parent'] = $this -> db -> get_where('categories', array('id' => $id)) -> first_row();
         //print_r($this->data['parent']);die;
        $this -> db -> order_by('id', 'DESC');
        $this -> db -> limit(5);
        $this->data['recent'] = $this->db->get('products')->result();
        // print_r( $this->data['recent']);die;
        $this->load->view('default', $this->data);
    }
      function cart()
    {
        $this->load->model("Gallery_model");
        $this->data['brands'] = $this->Mobile_model->allBrands();
        $this->data['main'] = 'cart';
        $this->load->view('default', $this->data);
    }
  function product_details($slug, $id)
    {
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
         $this->data['main'] = 'details';
        $this->load->view('default', $this->data);
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
    
   function checkout()
    {
      if(isLogin()){
        $this->data['main'] = 'checkout';
        $this->load->model("Gallery_model");
        $str = $this -> Master_model -> total(); 
        $tot = explode('-',$str);
        $this->data['prod'] = $tot;
       // $this->data['brands'] = $this->Mobile_model->allBrands();
         $this->data['user'] = $this->db->get_where('users',array('id'=>user_id()))->row();
         $this->data['users_add'] = $this->db->get_where('users_address',array('user_id'=>user_id()))->row();

        $this -> form_validation -> set_rules('form[ship_name]', 'Ship name', 'required');
        if($this -> form_validation -> run()){
          $this->session->set_userdata('pay_amount',$tot[1]);
          $m = $this -> input -> post('form');
          $user_add = $this->db->get_where('users_address',array('user_id'=>user_id()))->num_rows();
          if($user_add > 0){
            $this->db->where('user_id',user_id());
            $id = $this -> db->update('users_address',$m);
          }
          else
          {
            $m['user_id'] = user_id();
            $id = $this -> db->insert('users_address',$m);
          }
          //echo $this->db->last_query();die;
          //$this -> session -> set_flashdata("success", "User address detail saved");
         redirect(site_url('revieworder'));
        }
        $this->load->view('default', $this->data);
      }else
      {
        redirect(site_url('login'));
      }
    }
    
     function contact()
    {
        $this->data['main'] = 'contact';
     
        $from_email =$this->input->post('email'); 

         $to_email ="preety@originitsolution.com"; 
         $name=$this->input->post('fullname');  
         $phone=$this->input->post('mobile'); 
         $message=$this->input->post('message'); 
           $service=$this->input->post('service'); 

         
         //Load email library 
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
   
         //Send mail 
         if($this->email->send()) {
            $this->session->set_flashdata("default","Email sent successfully."); 
              redirect(site_url('contact'));
         }
         else {
              $this->session->set_flashdata("default","Error in sending Email."); 
               redirect(site_url('contact'));
         }
      }
        
       //$this->email->print_debugger();
              $this -> load->view("default", $this -> data);
        
      } 
    
    function review_order()
    {
      //$this->load->model('Role_model');
      if(isLogin()){
       // print_r($this->cartPrice());
        $this->data['main'] = 'revieworders';
        $this -> data['carts'] = $this -> session -> userdata('cart');
        $this->load->view('default', $this->data);
      }
      else{
        redirect(site_url('login'));
      }
        
    }

    function featured_product()
    {
        $this->data['main'] = 'featured_product';
        $this->data['products'] = $this->db->get_where('products',array('featured'=>1))->result();
        //print_r($this->data['products']);
        $this->load->view('default', $this->data);
    }
     function login()
    {
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
                  redirect('accounts');
                }
            } else {
                $this->session->set_flashdata("error", "Invalid User Name /Password");
                redirect(site_url('login'));
            }
        } else {
            $this->load->view('default', $this->data);
        }
    }
     function register()
    {
         if ($this->isLoggedIn()) {
            redirect('accounts');
         }
          $this -> data['states'] = $this -> User_model -> state_dropdown();
        $this->data['main'] = 'register';
          $this->form_validation->set_rules('data[ref_code]', ' Refferal Code', 'required');
        $this->form_validation->set_rules('data[username]', 'Username', 'required|is_unique[users.username]');


         $this->form_validation->set_rules('data[phone_no]', ' Mobile Number', 'required|exact_length[10]|is_unique[users.phone_no]');
         $this->form_validation->set_rules('data[phone_no]', ' Mobile Number', 'required|exact_length[10]|is_unique[users.phone_no]');
          $this->form_validation->set_rules('data[adhar_no]', ' Adhar Number', 'required|exact_length[12]|is_unique[users.adhar_no]');
           $this->form_validation->set_rules('data[pin_code]', ' Pin Code', 'required');
           $this->form_validation->set_rules('data[state]', ' State', 'required');
             $this->form_validation->set_rules('data[city]', ' City', 'required');
        //$this->form_validation->set_rules('data[phone_no]', 'Mobile no', 'required');
        if ($this->form_validation->run()) {
            $u = $this->input->post('data'); /* the 'data' comes from signup.php of line no. 23 of name="data[last_name]" */

            $u['created'] = date('Y-m-d h:i:s'); /*this date function creates the current date */
            $u['status'] = 1;
           // $u['act_code'] = substr(md5($u['email_id']), 0, 5);
               $u['user_type'] = "user";

            $u['pass'] = mt_rand(100000, 999999);
            //print_r( $u['pass']);die;
            $this->load->model("User_model");
            $this->User_model->createAccount($u);
            
            $to = $u['phone_no'];
            //$msg = "hello";
            $msg = "Hi ".$u['username'].", Your login password is ".$u['pass'].".".site_url('login')."  Thank you.";
            //print_r($msg);die;
            //sendSMS($to, $msg);
            $this->session->set_flashdata("success", "Account Created Successfully!! Your password sent on your mobile. ");

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

   
        } else {
            $this->load->view('default', $this->data);
        }
    }
      function logout()
    {
        $u = array(
            'lastvisitdate' => date('Y-m-d h:i:s'),
            'id' => $this->user_id()
        );
        $this->User_model->save($u);
        $this->session->sess_destroy();
        $this->session->set_flashdata("success", "Successfully logged out");
        redirect('login');
    }

      function chkAvailable() {
        $un = $this -> input -> post("un");
        $r = $this -> User_model -> chkref($un);
        echo $r;
      }
       function get_name_mobile() {
        $un = $this -> input -> post("un");
        $r = $this -> User_model -> get_name_mobile($un);
        echo $r;
      }

      public function page ($slug) {
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
      
      function user_role($id=false)
      {
       
       	  $data =  $this -> Role_model -> user_role($id); 
       	  echo  $data ;
       	 
       	 
      }
      
     function bonus_point($id)
     {


       $this->Role_model->get_top_user($id); 
      
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
            //print_r($msg);die;
            //sendSMS($to, $msg);
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
          $msg = "Hi ".$users->username.", Your Password is ".$users->pass.". Thank you.";
           //sendSMS($to, $msg);
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

      
}
