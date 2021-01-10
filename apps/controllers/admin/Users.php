<?php
class Users extends CI_Controller {
	public function __construct () {
		parent::__construct ();
		$this->form_validation->set_error_delimiters ('<div>', '</div>');
		$this->load->model ('Admin_model');
		
	}

	public function index () {
		$data['main'] = admin_view ('users/login');
		$this->load->view ('users/login', $data);
	}

	public function login () {
		$data = array(
			'main' => admin_view ('users/login')
		);
		if ($this->input->post ('submit')) {
			$validate = array(
				array(
					'field' => 'username',
					'label' => 'Username/Email ID',
					'rules' => 'required'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required'
				)
			);
			$this->form_validation->set_rules ($validate);
			if ($this->form_validation->run () == FALSE) {
				$this->load->view (admin_view ('users/login'), $data);
			}
			else {

				$username = $this->input->post ('username');
				$password = $this->input->post ('password');
				$p = $this->Admin_model->authenticate ($username, base64_encode($password));
				
				if ($p) {
					$sess = array(
						'userid' => $p -> id,
						'role' => $p -> role
					);

					$this->session->set_userdata($sess);
					//print_r($this->session->userdata()); die;
					redirect ('admin/dashboard');
				}
				else {
					$this->session->set_flashdata ('error', 'Invalid userid/password. Try again');
					redirect (admin_url ('users/login'));
				}
			}
		} else {
			$this->load->view (admin_view ('users/login'), $data);
		}

	}
	public function forget () {
		$data['main'] = admin_view('users/forget');
		if ($this->input->post ('submit')) {
			$validate = array(
				array(
					'field' => 'email_id',
					'label' => 'Email ID',
					'rules' => 'required|valid_email'
				)
			);
			$this->form_validation->set_rules ($validate);
			if ($this->form_validation->run () == FALSE) {
				$this->load->view (admin_view('users/forget'), $data);
			} else {
				$email_id = $this->input->post ('email_id');
				$user = $this->db->get_where('admin', array('email_id' => $email_id))->first_row();
				if ($user) {


					$this->load->library('email');

					$u = 'User';
					if($user->role == 1)
					{
						$u = 'Admin';
					}
					$msg = 'Dear '.$u;
					$msg .= '<br />Here is your login details : ';
					$msg .= '<br />User Name: ' . $user->email_id;
					$msg .= '<br />Password : ' . base64_decode($user->password);
					$msg .= '<br /><br /> To login here. <a href="' . base_url ($this->config->item ('admin_folder') . '/users/login') . '">Login Now</a>';

					$this->email->from ('auto@aldivo.com', 'Web Admin');
					$this->email->to ($user->email_id);
					$this->email->subject ('Recover Password');
					$this->email->message ($msg);

					$this->email->send();
					//echo $this->email->print_debugger();die;
					$this->session->set_flashdata ('success', 'Password has been sent on your email id');
					redirect ($this->config->item ('admin_folder') . '/users/login');



				} else {
					$this->session->set_flashdata ('error', 'Sorry, Invalid Email ID');
					$this->load->view (admin_view('users/forget'), $data);
				}
			}
		} else {
			$this->load->view (admin_view('users/forget'), $data);
		}
	}


	public function logout () {
		$newdata = array(
			'userid' => '',
			'username' => '',
			'role' => ''
		);
		$this->session->unset_userdata ($newdata);
		$this->session->sess_destroy ();
		$this->session->set_flashdata ('error', 'You have successfully logged out');
		redirect (admin_url('users/login'));
	}
}
