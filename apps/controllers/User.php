<?php

class User extends AI_Controller
{

    function __construct()
    {
        parent::__construct();
        $flag = $this->session->userdata('login');
        //print_r($flag);
        if($flag == false){
            $this -> session -> set_flashdata("error", "Your must login to View this page.");
            redirect('login');
        }
        $this -> data['user'] = $this -> User_model -> getUserById($flag['user_id']);
    }

     
    function register()
    {
         if ($this->isLoggedIn()) {
            redirect('accounts');
         }
        $this->data['main'] = 'register';
        $this->form_validation->set_rules('data[first_name]', 'Please enter First name', 'required');
        $this->form_validation->set_rules('data[email_id]', 'Email id', 'valid_email|is_unique[users.email_id]', array('is_unique' => 'Email id already registered'));
        $this->form_validation->set_rules('data[pass]', 'Password', 'required|min_length[6]');
        //$this->form_validation->set_rules('data[phone_no]', 'Mobile no', 'required');
        if ($this->form_validation->run()) {
            $u = $this->input->post('data'); /* the 'data' comes from signup.php of line no. 23 of name="data[last_name]" */
            $u['created'] = date('Y-m-d h:i:s'); /*this date function creates the current date */
            $u['status'] = 1;
            $u['act_code'] = substr(md5($u['email_id']), 0, 5);
		       $u['user_type'] = "user";
            $this->load->model("User_model");
            $this->User_model->createAccount($u);
            $this->session->set_flashdata("success", "Account Created!! Confirmation sent on your email id.");
			
            // ========Write code to send email for verification =============
             $m = new AI_Mail();
             $m->onSignup($u['first_name'], $u['email_id'], $u['act_code'])->sendMail();
              redirect('user/login');

   //       $u = $this->User_model->getUser($u['email_id']);
			// // print_r($u); exit();
   //       $s = array(
   //             'user_id' => $u->id,
   //               'loggedat' => time(),
   //        );
			// //print_r($s);
   //         $login = $s['user_id'];
			//  if($login==''){
			//  redirect('user/login');
			//   }
   //         $this->session->set_userdata('login', $s);
            
   //              $cart = $this->session->userdata('cart');
   //              if ($cart) {
   //                  redirect('cart');
   //               } 
   //                  else {
   //                   redirect('accounts');
   //              }
           
        } else {
            $this->load->view('default', $this->data);
        }
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

    function reset()
    {
        $this->data['main'] = 'forget-password';
        if ($this->input->post('btn_submit')) {
            $email = $this->input->post("email_id");
            $u = $this->User_model->getUser($email);
            if ($u->status == 1) {
                $m = new AI_Mail();
                $m->onResetPassword($u->first_name, $email, $u->pass)->sendMail();
                $this->session->set_flashdata("success", "Password has been sent on your registered email id.");
            } else {
                $this->session->set_flashdata("error", "Sorry!! Your account is either not active or not verified. Try again or contact adminstrator");
            }
            redirect(site_url('user/login'));
        }
        $this->load->view('default', $this->data);
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

    function subscribe()
    {

        $this->form_validation->set_rules('email', 'Email ID', 'required|valid_email|is_unique[email_subscription.email_id]', array('is_unique' => 'Email id already registered'));
        if ($this->form_validation->run()) {
            $data['id'] = false;
            $data['email_id'] = $this->input->post('email');
            $data['created'] = date('Y-m-d h:i:s');
            $this->User_model->save($data, 'email_subscription');
        }
        $this->session->set_flashdata("success", "Successfully Subscribed");
        redirect('store');
    }

    function activate()
    {
        $email = $this->input->get('email');
        $actcode = $this->input->get("actcode");
        if ($email && $actcode) {
            if ($this->User_model->validateEmail($email, $actcode)) {
                $u = $this->User_model->getUser($email);
                $s = array();
                $s['id'] = $u->id;
                $s['act_code'] = '';
                $s['status'] = 1;
                $this->User_model->save($s);
                $m = new AI_Mail();
                $m->onSuccessVerification($u->first_name, $email);
                $m->sendMail();

                $this->session->set_flashdata("success", "Account activated successfully");
            } else {
                $this->session->set_flashdata("error", "Sorry!! Activation code not matching");
            }
        } else {
            $this->session->set_flashdata("error", "Opps!! Something wrong. Try again later");
        }
        redirect(site_url('user/login'));
    }

    function address()
    {
        $add = $this->input->post('frm');
        $this->Master_model->save($add, 'users_address');
        redirect('cart/checkout');
    }

    function user_address()
    {
        $this->load->model('City_model');
        $this->data['main'] = 'address';
         $this->data['active'] = 'address';
        $this->data['arstats'] = $this->City_model->getStates();
        $this->data['addresses'] = $this->User_model->getUserAddresses($this->user_id());
        $this->load->view('default', $this->data);
    }

    function edit_address($id = false)
    {
        $this->load->model('City_model');
        $this->data['main'] = 'address-edit';
        $this->data['active'] = 'address';
        $this->data['arstats'] = $this->City_model->getStates();
        $this->data['addresses'] = $this->User_model->getAddress($id);
        $dv = $this->db->get_where('users',array('id'=>$this->user_id()))->row();
        $this->data['def_add'] = $dv->default_address;
        $this->load->view('default', $this->data);
    }

    function address1()
    {
        $add = $this->input->post('frm');
        // if(isset($this->input->post('url')){
        //     $url = $this->input->post('url');
        // }
        //$add['id'] = false;
        $add['user_id'] = $this->user_id();
        $this->User_model->saveAddress($add);
        if($this->input->post('url')!=""){
            redirect($this->input->post('url'));
        }
        else{
            redirect('user/user_address');
        }
    }

    function address2()
    {
        $add = $this->input->post('frm');
        $add['id'] = false;
        $add['user_id'] = $this->user_id();
        $this->User_model->saveAddress($add);
        redirect('user/user_address');
    }

    function del_address($id)
    {
        if ($id) {
            $this->Master_model->delete($id, 'users_address');
            $this->session->set_flashdata('Successfully Deleted address');
            redirect('user/user_address');
        }
    }

    function profile_edit()
    {
        $id = user_id();
         $this->data['main'] = 'profile-edit';
         $this->data['active'] = 'edit-profile';
         $this -> data['states'] = $this -> User_model -> state_dropdown();
        $this->data['users_details'] = $this->User_model->getUserById($id);
        $this->load->view('default', $this->data);
    }

    function update_profile()
    {
        $config['upload_path']      = 'img/uploads';
        $config['allowed_types']    = 'gif|jpg|png|jpeg|bmp';
        $config['max_size']         = '5000';
        $config['max_width']        = '3000';
        $config['max_height']       = '2000';
        $this->load->library('upload', $config);
       
        $data = $this->input->post('frm');
        // print_r($data); die;
        $uploaded   = $this->upload->do_upload('image');
       // print_r($uploaded); die;
           
                if($this -> input -> post('del_image')){
                    $img_name = $this -> input -> post('hid_image');
                    @unlink('img/products/'.$img_name);
                    $frm['image'] = '';
                }
           
            if($uploaded)
            {
                 $image          = $this->upload->data();
                 $data['image']   = $image['file_name']; 
            }
$this->session->set_flashdata('Successfully Updated');
        $this->Master_model->save($data, 'users');
        redirect('accounts');
    }

    function send_sms()
    {
        $to = $this->input->post('to');
        $mcode = $this->input->post('mcode');
        if (!$mcode == '') {
            $msg = "Your mobile verification code is " . $mcode;
            $success = sendSMS($to, $msg);
            if ($success) {
                echo "yes";
            } else {
                echo "no";
            }
        }
    }

    function verify_mobile(){
        $otp = $this->input->post('otp');
        $u = $this->Master_model->getRow($this -> user_id(), "users");
        $vcode = $u->m_verify_code;

        if ($otp == $vcode) {
            $s = array();
            $s['id'] = $u->id;
            $s['phone_verified'] = 1;
            $suc = $this->User_model->save($s, 'users');
            echo "yes";
        }else{
            echo "no";
        }
    }

    function updateMobile()
    {
        $data = array();
        //$data['id'] = $this->input->post('mobile_id');
        $data['id'] = $this -> user_id();
        $data['phone_no'] = $this->input->post('phone_no');
        $data['m_verify_code'] = rand(1000, 9999);
        $success = $this->User_model->save($data);
        $u = $this -> Master_model -> getRow($this -> user_id(), "users");
        $mobile = $u -> phone_no;
        $otp = $u -> m_verify_code;
        $msg1 = "Your Mobile Verification code is : " . $otp;
        //echo $msg1;
        if ($success) {
            sendSMS($mobile, $msg1);
            echo "yes";
        } else {
            echo "no";
        }
    }

}

