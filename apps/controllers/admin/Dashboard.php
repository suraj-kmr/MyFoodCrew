<?php
class Dashboard extends MY_Controller{
	function __construct(){
		parent::__construct();
		
		$this -> load -> model("Order_model");
	}
	public function index(){

	
		$this -> data['main'] = admin_view('dashboard');
		$this -> data['posts'] = array();
		$this -> data['cats'] = array();
		$this -> data['active_tabs'] = 'dashboard';
	    $this -> data['dashboard_title'] = 'Dashboard';
	    $this -> data['total_prod'] = $this->db->get('products')->num_rows();
	    $this -> data['total_sales'] = $this->Order_model->TotalOrder();
	    $this -> data['month'] = $this->Order_model->monthOrder();
	    $this -> data['total_users'] = $this->db->get('users')->num_rows();
		$this -> load -> view(admin_view('default'), $this -> data);
	}
	public function profile(){
		$data['main'] = 'accounts/change-password';
		$id = $this -> session -> userdata('userid');
		$data['id'] = $id;
		$data['username'] = '';
		$data['email_id'] = '';
		$data['password'] = '';
		if($id){
			$user = $this -> Account_model -> get_user($id);
			$data['email_id'] = $user['email_id'];
			$data['password'] = $user['password'];
			$data['username'] = $user['username'];
		}

		$valid = array(
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required'
				),
				array(
					'field' => 'password2',
					'label' => 'Retype password',
					'rules' => 'required|matches[password]'
				)
			);
		$this -> form_validation -> set_rules($valid);
		if($this -> form_validation -> run() == FALSE){
			$this -> load -> view('default', $data);
		}else{
			$save['id'] = $id;
			$save['email_id'] = $this -> input -> post('email_id');
			$save['password'] = $this -> input -> post('password');

			$this -> Account_model -> change_password($save);
			$this -> session -> set_flashdata('success', 'Login details updated successfully');
			redirect($this -> config -> item('admin_folder').'dashboard');
		}
	}

	function change_password(){
		$this -> data['main'] = admin_view('change-password');
		$this -> form_validation -> set_rules('frm[old]', 'Old password', 'required');
		$this -> form_validation -> set_rules('frm[new]', 'New password', 'required');
		$this -> form_validation -> set_rules('frm[re_type]', 'Re enter password', 'required');
		if($this -> form_validation -> run()){
			$save = $this->input->post('frm');
			$ps = base64_encode($save['old']);
			//print_r($_SESSION);
			$user = $this -> db -> get_where('admin',array('id'=>$_SESSION['userid']))->row();
			$oldpass = $user->password;
			if($ps == $oldpass){
				if($save['new'] == $save['re_type']){

					$ar = array(
						'password'=>base64_encode($save['new'])
					); 
					//print_r($ar);die;
					$this->db->where('id',$_SESSION['userid']);
					$this->db->update('admin',$ar);
					//echo $this->db->last_query();die;
					$this->session->set_flashdata('success','Your password successfully changed.');
					redirect(admin_url('dashboard/change_password'));

				}
				else{
					$this->session->set_flashdata('error','New password and Re-enter password not match!');
					redirect(admin_url('dashboard/change_password'));

				}
				
			}
			else{
				$this->session->set_flashdata('error','Sorry! You are not registerd.');
				redirect(admin_url('dashboard/change_password'));
			}
		}
		$this -> load -> view(admin_view('default'), $this -> data);
	}
}
