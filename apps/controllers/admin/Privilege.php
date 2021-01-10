<?php
class Privilege extends MY_Controller {
	public function __construct () {
		parent::__construct ();
		$this->form_validation->set_error_delimiters ('<div>', '</div>');
		$this->load->model ('Master_model');
        $this -> data['active_tabs'] = 'privilege';

	}

	public function index () {
		$this->data['list'] = $this->db->get_where('admin', array('id !=' => 1))->result();
        $this -> data['main'] = admin_view('privilege/index');
		$this->load->view(admin_view('default'), $this->data);
	}

    public function add($id = false){
        $this -> data['main'] = admin_view('privilege/add');
        $this -> data['m'] = $this -> Master_model -> getNew('admin');
        if($id){
            $this -> data['m'] = $this -> Master_model -> getRow($id, 'admin');
        }
        $this -> form_validation -> set_rules('frm[email_id]', 'Email Id', 'required');
        if($this -> form_validation -> run()){
            $m = $this -> input -> post('frm');
            $m['id'] = $id;
            if($this->input->post('frm[password]'))
            {
                $m['password'] = base64_encode($this->input->post('frm[password]'));
            }
            $id = $this -> Master_model -> save($m, 'admin');
            $this -> session -> set_flashdata("success", "Users detail saved");
            redirect(admin_url('privilege/add/' . $id));
        }else {
            $this->load->view (admin_view ('default'), $this->data);
        }
    }

    function setting($id)
    {

        /*$this->data['tabs'] = array('Dashboard', 'Sales & Orders', 'Electronics', 'Books', 'Office Product', 'Clothing', 'Bags', 'Campus Store', 'Home Accessories', 'Tech Accessories', 'Catalog', 'Members', 'Media & Settings', 'Store Locatior', 'logs & Others', 'SEO', 'Import & Export', 'User Privilege');*/

        $this->data['tabs'] = array(
             array(
                'pa' => 'Dashboard',
                
            ),
            array(
                'pa' => 'Sales & Orders',
                'ch' => 'Recent Orders,Pendings Orders,Track Orders,Refund Request,Recent Payments,Payment History,Coupons,Add New Coupons',
            ),
            array(
                'pa' => 'Electronics',
                'ch' => 'Manage Products,Add Product,Mobile Handsets,Mobile Brands,Miscellaneous',
            ),
            array(
                'pa' => 'Books',
                'ch' => 'Books,Author,Publisher,Language',
            ),
            array(
                'pa' => 'Office Product',
                'ch' => 'Office Product,Brands,Material,Theme',
            ),
            array(
                'pa' => 'Clothing',
                'ch' => 'T-Shirt Designs,Clothing,Combo List,Add New,Add New Combo',
            ),
            array(
                'pa' => 'Bags',
                'ch' => 'Bags,Add New',
            ),
            array(
                'pa' => 'Campus Store',
                'ch' => 'Campus,Add Campus',
            ),
            array(
                'pa' => 'Home Accessories',
                'ch' => 'Home Accessories,Brand,Material,Theme',
            ),
            array(
                'pa' => 'Tech Accessories',
                'ch' => 'Tech Accessories,Brand,Material',
            ),
            array(
                'pa' => 'Catalog',
                'ch' => 'Manage Categories,Add Category,Events,Offers & Discounts,Stock Management,Return Stock Management',
            ),
            array(
                'pa' => 'Members',
                'ch' => 'Registered Users,Add User,Email Subscription',
            ),
            array(
                'pa' => 'Media & Settings',
                'ch' => 'Gallery,Menus,Quick Links,Media Manager,Upload Media,Global Settings,Static Pages,Wallet Info,Pincode Coverage',
            ),
            array(
                'pa' => 'Store Locator',
                'ch' => 'Cities,Store,Add New Store,Text,Franchisee,Add New Franchhisee',
            ),
            array(
                'pa' => 'Blogs & Others',
                'ch' => 'Blogs,Fanbook',
            ),
            array(
                'pa' => 'SEO',
                'ch' => 'Add SEO,List SEO',
            ),
            array(
                'pa' => 'Import & Export',
                'ch' => 'Import,Export',
            ),
            array(
                'pa' => 'User Privilege',
                'ch' => 'User list,Add User,Change Password,Client Testimonials',
            ),
            array(
                'pa' => 'MLM Features',
                'ch' => 'All Members,New Registered Members,Membership Tree,Benefits,Achievement,Payout History',
            ),
             array(
                'pa' => 'Achievment',
                
            ),
              
            
              

        );
        //$this->data['tabs'] = $this->db->get_where('dashboard_tabs', array('p_id' => 0))->result_array();
        if($id)
        {
            $this->data['main'] = admin_view('privilege/setting');
            $this->data['m'] = $this->Master_model->getRow($id, 'admin');
            if($this->input->post('submit'))
            {
                $frm = $this->input->post('frm');
                $frm['id'] =$this->input->post('id');
                $frm['user_id'] = $id;
                $this->Master_model->save($frm, 'privilege');
                $this->session->set_flashdata('success', "Data saved successfully");
                redirect(admin_url('privilege/setting/'.$id));

            }
            $this->load->view(admin_view('default'), $this->data);
        }else{
            redirect(admin_url('privilege'));
        }
    }

    function delete($id = false)
    {
        if($id)
        {
            $data =$this->db->get_where('privilege', array('user_id' => $id));
            if($data->num_rows() > 0)
            {
                $this->db->delete('privilege', array('user_id' => $id));
            }
            $this->Master_model->delete($id, 'admin');
        }
        redirect(admin_url('privilege'));



    }

    function change_pass() {

        $this->data['page_title'] = 'Change Password';
        $this->data['menu2'] = 'Admins';
        $this->data['menu3'] = 'Change Password';
        $this->data['main'] = admin_view('privilege/change-password');

        echo $u_id = $this->session->userdata('userid');
        $user = $this->db->get_where('admin', array('id' => $u_id))->row();

        $this->form_validation->set_rules('old_pass', 'Old Password', 'required');
        $this->form_validation->set_rules('new_pass', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('con_pass', 'Confirm Password', 'required|matches[new_pass]');
        if (($this->form_validation->run() == true)) {
            $old = $this->input->post('old_pass');
            $new = $this->input->post('new_pass');
            if ($user->password == base64_encode($old)) {
                $this->db->where('id', $u_id);
                $this->db->update('admin', array('password' => base64_encode($new)));
                $this->session->set_flashdata('success', 'Password saved');
            } else {
                $this->session->set_flashdata('error', 'Password is wrong. Try again... ');
            }
        }

        $this->load->view(admin_view('default'), $this->data);
    }

     public function client_testimonial($id = false){
        $config['upload_path']      = 'img/uploads';
        $config['allowed_types']    = 'gif|jpg|png|jpeg|bmp';
        $config['max_size']         = '5000';
        $config['max_width']        = '3000';
        $config['max_height']       = '2000';
        $this->load->library('upload', $config);
        $this -> data['main'] = admin_view('privilege/client_testimonial');
        $this -> data['m'] = $this -> Master_model -> getNew('client_testimonial');
        if($id){
            $this -> data['m'] = $this -> Master_model -> getRow($id, 'client_testimonial');
        }
        $this -> form_validation -> set_rules('frm[name]', 'Name', 'required');
        if($this -> form_validation -> run()){
            $m = $this -> input -> post('frm');
            $m['id'] = $id;
           $uploaded    = $this->upload->do_upload('image');
            if ($id){
                if($this -> input -> post('del_image')){
                    $img_name = $this -> input -> post('hid_image');
                    @unlink('img/products/'.$img_name);
                    $m['image'] = '';
                }
            }
            if($uploaded)
            {
                $image          = $this->upload->data();
                $m['image']   = $image['file_name'];
            }//else{
                //
            $id = $this -> Master_model -> save($m, 'client_testimonial');
            $this -> session -> set_flashdata("success", "Client detail saved");
            redirect(admin_url('privilege/client/' . $id));
        }else {
            $this->load->view (admin_view ('default'), $this->data);
        }
    }
     function client(){
        $this -> data['main'] = admin_view('privilege/client');
        $this -> data['client'] = $this -> db -> get('client_testimonial')->result();
        $this -> load -> view(admin_view('default'), $this -> data);
    }



    function activate($id = false){
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('privilege/client');
        if($id){
            $c['id'] = $id;
            $c['status'] = 1;
             $id = $this -> Master_model -> save($c, 'client_testimonial');
            $this -> session -> set_flashdata("success", "Client saved");
        }
        redirect($redirect);
    }

    function deactivate($id = false){
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('privilege/client');
        if($id){
            $c['id'] = $id;
            $c['status'] = 0;
            $id = $this -> Master_model -> save($c, 'client_testimonial');
            $this -> session -> set_flashdata("success", "Client saved");
        }
        redirect($redirect);
    }
    function deletec($id = false)
    {
        if($id)
        {
            $data =$this->db->get_where('client_testimonial', array('id' => $id));
            if($data->num_rows() > 0)
            {
                $this->db->delete('client_testimonial', array('id' => $id));
            }
            $this->Master_model->delete($id, 'client_testimonial');
            $this -> session -> set_flashdata('success', 'Client deleted successfully');
        }
        redirect(admin_url('privilege/client'));
    }



}
