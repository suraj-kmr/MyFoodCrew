<?php 
class Admin extends CI_Controller{
	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata('userid'))
        {
           $this -> session -> set_flashdata('errormsg', 'Session out!! Please login agin'); 
		   redirect('users/login', 'refresh');
        }
		if($this->session->userdata('role') != 1){
		   	$this -> session -> set_flashdata('error', 'Sorry, you have no permission.'); 
		   	redirect('dashboard', 'refresh');
		}
		$this -> form_validation->set_error_delimiters('<div class="info">', '</div>');
		$this -> output -> nocache();
	}
	public function index(){
		$data['main'] = 'admin/index';
		$data['admins'] = $this -> Admin_model -> getAll();
		$this -> load -> view('default', $data);
	}
	public function add($id = false){		
		$data = array(
			'main' => 'admin/add',
			'title' => 'Add New User',
			'status' => $this -> Admin_model -> status,
		);
		$data['id'] = $id;
		$data['email_id'] = '';
		$data['password'] = '';	
		$data['username'] = '';
		$data['role'] 	  = '';
		if($id){
			$user = $this -> Admin_model -> get_user($id);
			$data['email_id'] = $user['email_id'];
			$old_password     = $user['password'];
			$data['password'] = '';
			$data['username'] = $user['username'];
			$data['role'] 	  = $user['role'];
		}
		
		$valid = array(
				array(
					'field' => 'email_id',
					'label' => 'Email id',
					'rules' => 'required|valid_email'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required'
				)				
			);
			$this -> form_validation -> set_rules($valid);
			if($this -> form_validation -> run() == FALSE){
				$this -> load -> view('default', $data);
			}else{
				$save['id'] = $id;
				$save['username'] = $this -> input -> post('username');
				$save['email_id'] = $this -> input -> post('email_id');
				$new_pass 		  = $this -> input -> post('password');
				if($new_pass != ''){
					$save['password'] = md5($new_pass);
					if($old_password != $save['password']){					
						$msg = 'Dear Admin';
						$msg .= '<br />Some one has tried to change your password. Please check it immediately if you are not changing';
						$msg .= '<br /><br /> To login here. <a href="'.base_url('users/login').'">Login Now</a>';
						
						$this->load->library('email');
						$this->email->from('no-reply@domain.com', 'Web Admin');
						$this->email->to('info@originitsolution.com, royalthotz@gmail.com');  					
						$this->email->subject('Password Change Alerts');
						$this->email->message($msg);						
						
						$this->email->send();	
					}
				}
				$save['role']     = $this -> input -> post('role');
				
				
				
				$this -> Admin_model -> add($save);
				$this -> session -> set_flashdata('success', 'Admin details saved successfully');
				redirect('admin');
			}		
	}
	
	public function delete($id){
		if($id){
			$this -> Admin_model -> delete($id);
			$this -> session -> set_flashdata('success', 'Admin details deleted successfully');
		}		
		redirect('admin');
	}	
}
?>