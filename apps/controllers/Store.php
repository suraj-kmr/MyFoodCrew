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
        $this -> data['carts'] = $this -> session -> userdata('cart');
    }
    function index(){
        $this->data['main'] = 'index';
             
        $this->form_validation->set_rules('data[first_name]', 'Please enter First name', 'required');
        $this->form_validation->set_rules('data[email_id]', 'Email id', 'valid_email|is_unique[users.email_id]', array('is_unique' => 'Email id already registered'));
         $this->form_validation->set_rules('data[job_title]', 'Please enter Job Title', 'required');
          $this->form_validation->set_rules('data[company]', 'Please enter company  ', 'required');
        $this->form_validation->set_rules('data[pass]', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('data[phone_no]', 'Mobile no', 'required|min_length[10]');
        
        if ($this->form_validation->run()) {
            $u = $this->input->post('data'); /* the 'data' comes from signup.php of line no. 23 of name="data[last_name]" */
            
            $u['created'] = date('Y-m-d h:i:s'); /*this date function creates the current date */
            $u['status'] = 1;
            $u['act_code'] = substr(md5($u['email_id']), 0, 5);
               $u['user_type'] = "user";
            $this->load->model("User_model");
            $this->User_model->createAccount($u);
            $this->session->set_flashdata("success", "Account Created!! Confirmation sent on your email id.");
            }
        $this->load->view('default', $this->data);
    
    }

    function login()
    {
        if ($this->isLoggedIn()) {
            redirect('accounts');
        }

        $this->data['main'] = 'login';
        $this -> form_validation -> set_rules('data[email_id]', 'Email Id ', 'required');
        $this->form_validation->set_rules('data[password]', 'Password', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post('data');
            $email = $data['email_id'];
            $pass = $data['password'];
            if ($this->User_model->loginCheck($email, $pass)) {
                $u = $this->User_model->getUser($email);
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
                redirect('accounts');
            } else {
                $this->session->set_flashdata("error", "Invalid Email id/Password");
                redirect('user/login');
            }
        } else {
            $this->load->view('default', $this->data);
        }
    }



}
?>