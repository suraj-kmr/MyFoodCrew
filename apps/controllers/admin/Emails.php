<?php
class Emails extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this -> load -> model("Email_model");
		$role = $this -> session -> userdata('role');
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
	}
	public function index(){
		$d = array();
		$d['email'] = isset($_GET['email']) ? $_GET['email'] : '';
		$d['subject'] = isset($_GET['subject']) ? $_GET['subject'] : '';
		$d['redirect_to'] = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : site_url($this -> config -> item('admin_folder'). 'dashboard');
		$d['description'] = isset($_GET['description']) ? $_GET['description'] : '';
		$this -> data['data'] = $d;

		$this -> data['main'] = $this -> config -> item('admin_folder'). 'email/compose';
		$this -> form_validation -> set_rules('data[email]', 'Email', 'required|valid_email');
		$this -> form_validation -> set_rules('data[subject]', 'Subject', 'required');
		$this -> form_validation -> set_rules('data[description]', 'Email Body', 'required');
		if($this -> form_validation -> run()){
			$data = $this -> input -> post('data');
			$this -> data['data'] = $data;
			$email = $data['email'];
			$sub = $data['subject'];
			$msg = $data['description'];
			$msg .= '<p>Regards<br />Dialx.in<br /><br />For any assistance please contact- +91-0651-2246 146, or mail us at support@dialx.in</p>';
			$this -> email -> to($email);
			$this -> email -> from('no-reply@dialx.in', 'DialX.in Ad Support');
			$this -> email -> subject($sub);
			$this -> email -> message($msg);
			$this -> email -> send();
			$this -> session -> set_flashdata("success", "Email sent to user");
			redirect($data['redirect_to']);
		}else{
			$this -> load -> view($this -> config -> item('admin_folder'). 'default', $this -> data);
		}
	}

	public function page($limit_from = 1){
		$qty = 20;
		$q = $limit_from * $qty;
		$from = $q - $qty;
		$data = array(
			'main' => 'email/index',
			'email_list' => $this -> Email_model -> getAll($from, $qty),
			'title' => 'Manage Email',
		);
		$this -> load -> model('Paginate');
		$options = array(
			'table' => 'emails',
			'qty' => $qty,
			'base_url' => base_url('emails/page')
		);
		$this -> Paginate -> configure($options);
		$data['paginate'] = $this -> Paginate -> create($limit_from);
		$this -> load -> view('default', $data);
	}
	public function view($id = false){
		$data['main'] = 'email/view';
		$data['email'] = $this -> Email_model -> get_email($id);
		$this -> load -> view('default', $data);
	}
	public function delete($id = false){
		if($id){
			$this -> Email_model -> delete($id);
			$this -> session -> set_flashdata('success', 'Email deleted successfully');
		}
		redirect('emails');
	}
}
?>
