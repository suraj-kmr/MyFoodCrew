<?php

class Store extends AI_Controller
{
    var $category;
    private $perPage = 24;

    function __construct()
    {
        parent::__construct();
        
        $this->data['seo_title'] = "Food";
        $this->data['seo_description'] = "";
        $this->data['seo_keywords'] = "food";
        $this -> data['login'] = $this -> session -> userdata('login');
    }
    function index(){
        $this->data['main'] = 'index';
        $this->load->view('default', $this->data);
    
    }

    function user_dash(){
        $this->data['main'] = "user-dashboard";
        
        $this->load->view('default',$this->data);
    }
    function consultant_dash(){
        $this->data['main'] = "consultant";
        $this->load->view('default',$this->data);
    }

    function login()
    {
        $this->data['main'] = 'login';

        $this -> form_validation -> set_rules('data[email_id]', 'Email Id ', 'required');
        $this -> form_validation->set_rules('data[pass]', 'Password', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post('data');
            //print_r($data);die;
            $email = $data['email_id'];
            $pass = $data['pass'];
            if ($this->User_model->loginCheck($email, $pass)) {
                $u = $this->User_model->getUser($email);
               
                $s = array(
                    'user_id' => $u->id,
                    'loggedat' => time(),
                );
                $this->session->set_userdata('login', $s);
                
                if($u->user_type==1){
                     redirect('user-dashboard');
                 }elseif($u->user_type==2){
                     redirect('consultant-dashboard');
                }
               
               
            } else {
                $this->session->set_flashdata("error", "Invalid Email id/Password");
                redirect('login');
            }
        } else {
            $this->load->view('default', $this->data);
        }
         
        
    }

    function register(){
        $this->data['main']= 'register';
        $this->form_validation->set_rules('data[first_name]', 'Please enter First name', 'required');
        $this->form_validation->set_rules('data[email_id]', 'Email id', 'valid_email|is_unique[users.email_id]', array('is_unique' => 'Email id already registered'));
        $this->form_validation->set_rules('data[pass]', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('data[phone_no]', 'Mobile no', 'required|numeric|min_length[10]|max_length[10]');
        if ($this->form_validation->run()) {
            $u = $this->input->post('data'); /* the 'data' comes from signup.php of line no. 23 of name="data[last_name]" */
            $u['created'] = date('Y-m-d h:i:s'); /*this date function creates the current date */
            $u['status'] = 1;
            //$u['act_code'] = substr(md5($u['email_id']), 0, 5);
            //$u['user_type'] = "user";
            $this->load->model("User_model");
            $this->User_model->createAccount($u);
            $this->session->set_flashdata("success", "Account Created!! ");           
              redirect('login');
           
        } else {
            $this->load->view('default', $this->data);
        }
        
    }

    function user_profile(){
        $this->data['main'] = 'user-profile';
        if($this -> data['login']){
            $user_id = $this -> data['login'];
            $this->data['user'] = $this->db->get_where('users',array('id'=>$user_id['user_id']))->row();
            //print_r($this->data['main']);
            
        }
        $this->load->view('default',$this->data);
    }

    function changepassword(){
        
        //print_r($_POST); die;
        $this -> data['main'] = "user-profile";
        $this -> form_validation -> set_rules('oldpass', "Old Password", "required");
        $this -> form_validation -> set_rules('password', "New Password", "required|min_length[6]");
        $this -> form_validation -> set_rules('cnfpassword', "Confirm Password", "required|matches[password]");
        if($this -> form_validation -> run()){

            echo $oldp = $this -> input -> post('oldpass');
           echo  $newp = $this -> input -> post('password'); die;

            $pass=array('pass',$newp);
            $temp =  $this -> User_model -> getUserById($this -> data['user']->id);

            if($temp -> pass == $oldp){
                $this -> db -> update('users', array('pass'=>$newp), array('id'=>$this -> data['user']->id));


                $this -> session -> set_flashdata("success", "New password updated successfully");
            }else{
                $this -> session -> set_flashdata("error", "Invalid old password.");
            }
            redirect('accounts/changepassword');
        }
        $this -> load -> view('default', $this -> data);
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
        redirect('user/login');
    }

}
?>