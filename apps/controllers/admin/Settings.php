<?php

class Settings extends MY_Controller
{
    var $global;

    function __construct()
    {
        parent::__construct();
        $this->data['active_tabs'] = 'media';
        $role = $this->session->userdata('role');
        if (!$role == 1) {
            redirect(admin_url('users/login'));
        }
    }

    public function index()
    {
        $this->data['main'] = admin_view('setting/theme-options');
        $this->data['options'] = $this->Setting_model->all_options();
        if ($this->input->post('submit')) {
            $fields = $this->input->post('fields');
            $arr_fields = explode(',', $fields);
            if (is_array($arr_fields) AND count($arr_fields) > 0) {
                foreach ($arr_fields as $fname) {
                    $fname = trim($fname);
                    $s['option_name'] = $fname;
                    $s['option_value'] = $this->input->post($fname);
                    $this->Setting_model->save_option($s);
                }
                $this->session->set_flashdata('success', 'Settings updated successfully');
            }
            redirect(admin_url('settings'));
        } else {
            $this->load->view(admin_view('default'), $this->data);
        }

    }

    function seo_url($offset = 0)
    {
        $this->data['offset'] = $offset;
        $show_per_page = 40;
        $this->data['main'] = admin_view('setting/url-index');
        $data = $this->Setting_model->seo_urls($offset, $show_per_page);
        $this->data['urls'] = $data['data'];

        $config['base_url'] = admin_url('settings/seo-url');
        $config['num_links'] = 4;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $data['total'];
        $config['per_page'] = $show_per_page;
        $config['full_tag_open'] = '<ul class="pagination pmagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $this->data['paginate'] = $this->pagination->create_links();
        $this->load->view(admin_view('default'), $this->data);
    }

    function edit_url($id = false)
    {
        $this->data['main'] = admin_view('setting/add-url');
        $this->data['url'] = array(
            'id' => $id,
            'url' => '',
            'seo_title' => '',
            'seo_description' => '',
            'seo_keywords' => '',
            'h1_heading' => '',
            'small_desc' => ''
        );
        if ($id) {
            $this->data['url'] = $this->Setting_model->url($id);
        }
        $this->form_validation->set_rules('url', 'URL', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view(admin_view('default'), $this->data);
        } else {
            $save['id'] = $id;
            $url = $this->input->post('url');
            $save['url'] = rtrim($url, '/');
            $save['seo_title'] = $this->input->post('seo_title');
            $save['seo_description'] = $this->input->post('seo_description');
            $save['seo_keywords'] = $this->input->post('seo_keywords');
            $save['h1_heading'] = $this->input->post('h1_heading');
            $save['small_desc'] = $this->input->post('small_desc');

            $id = $this->Setting_model->save_url($save);
            $this->session->set_flashdata('success', 'SEO URL and details saved successfully');
            redirect(admin_url('settings/seo-url'));
        }
    }

    function delete_url($id = false)
    {
        if ($id) {
            $this->Setting_model->url_delete($id);
            $this->session->set_flashdata('success', 'SEO URL and details deleted successfully');
        }
        redirect(admin_url('settings/seo-url'));
    }

    function restore()
    {
        $this->db->truncate('options');
        $this->session->set_flashdata('success', 'Global Setting reset to Default');
        redirect(admin_url('settings'));
    }

    function sql()
    {
        $this->data['main'] = admin_view('setting/sql');
        if ($this->input->post('sql')) {
            $sql = $this->input->post('sql');
            $this->db->query($sql);
            $this->session->set_flashdata("success", "SQL Executed");
            redirect(admin_url('settings/sql'));
        }
        $this->load->view(admin_view('default'), $this->data);
    }

    function addpin($id = false)
    {
        $this->data['main'] = admin_view('setting/addpin');

        if ($id) {
            $this->form_validation->set_rules('pincode', 'Pincode', 'required|exact_length[6]');
        } else {
            $this->form_validation->set_rules('pincode', 'Pincode', 'required|exact_length[6]|is_unique[pincodes.pincode]', array(
                'is_unique' => 'Pincode already exists'
            ));
        }
        if ($this->form_validation->run()) {
            //print_r($_POST);
            $pin = array();
            $pin['id'] = $id;
            $pin['pincode'] = $this->input->post('pincode');
            $cats = $this->input->post('cats');
            $pin['categories'] = json_encode($cats);
            $pin['status'] = $this->input->post('status');
            $this->Master_model->save($pin, 'pincodes');
            $this->session->set_flashdata("success", "Pincode coverage detail saved");
            redirect(admin_url('settings/pincodes'));
        }
        $this->data['pin'] = $this->Master_model->getNew('pincodes');
        if ($id) {
            $this->data['pin'] = $this->Master_model->getRow($id, 'pincodes');
        }
        $this->data['cats'] = $this->Category_model->get_categories_tierd();
        $this->load->view(admin_view('default'), $this->data);
    }

    function pincodes($page = 1)
    {
        $this->data['main'] = admin_view('setting/pincodes');
        $per_page = 40;
        $offset = --$page * $per_page;
        $data = $this->Master_model->getAll($offset, $per_page, 'pincodes');

        $this->data['codes'] = $data['results'];
        $this->data['offset'] = $offset;
        $config['base_url'] = admin_url('settings/pincodes');
        $config['num_links'] = 4;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $data['total'];
        $config['per_page'] = $per_page;
        $config['full_tag_open'] = '<ul class="pagination pmagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $this->data['paginate'] = $this->pagination->create_links();
        $this->load->view(admin_view('default'), $this->data);
    }

    function apin($id = false)
    {
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('settings/pincodes');
        if ($id) {
            $c['id'] = $id;
            $c['status'] = 1;
            $this->Master_model->save($c, 'pincodes');
            $this->session->set_flashdata("success", "Pincode activated");
        }
        redirect($redirect);
    }

    function dpin($id = false)
    {
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('settings/pincodes');
        if ($id) {
            $c['id'] = $id;
            $c['status'] = 0;
            $this->Master_model->save($c, 'pincodes');
            $this->session->set_flashdata("success", "Pincode deactivated");
        }
        redirect($redirect);
    }

    function delpin($id = false)
    {
        if ($id) {
            $this->Master_model->delete($id, 'pincodes');
            $this->session->set_flashdata("success", "Pincode removed successfully");
        }
        redirect(admin_url('settings/pincodes'));
    }

    function seo_urls($offset = 0)
    {
        $this->data['active_tabs'] = 'seo';
        $this->data['offset'] = $offset;
        $show_per_page = 40;
        $this->data['main'] = admin_view('setting/seo-index');
        $data = $this->Setting_model->seo_urls($offset, $show_per_page);
        $this->data['url'] = $data['data'];

        $config['base_url'] = admin_url('settings/seo-index');
        $config['num_links'] = 4;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $data['total'];
        $config['per_page'] = $show_per_page;
        $config['full_tag_open'] = '<ul class="pagination pmagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $this->data['paginate'] = $this->pagination->create_links();
        $this->load->view(admin_view('default'), $this->data);
    }

    function seo($id = false)
    {
        $this->data['active_tabs'] = 'seo';
        $this->data['main'] = admin_view('setting/seo-url');
        //$this -> load -> view(admin_url('default'), $this -> data);
        $this->data['url'] = $this->Master_model->getNew('seo_url');
        if ($id) {
            $this->data['url'] = $this->Master_model->getRow($id, 'seo_url');
        }
        $this->form_validation->set_rules('frm[url]', 'URL', 'required');
        if ($this->form_validation->run() == TRUE) {
            if (isset($_POST['submit'])) {
                $s = $this->input->post('frm');
                $s['id'] = $id;
                $this->Master_model->save($s, 'seo_url');
                $this->session->set_flashdata('success', 'Seo Details saved Successfully');
                redirect(admin_url('settings/seo'));
            }
        } else {
            $this->load->view(admin_view('default'), $this->data);
        }

    }

    function import()
    {
        $this->data['active_menu'] = "imp_exp";
        $this->data['main'] = admin_view('setting/import');
        if ($this->input->post('qty_import')) {
            $count = 0;
            if ($_FILES['excel_file']['name'] <> '') {
                //echo "Rohit"; exit;
                $fn = $_FILES['excel_file']['tmp_name'];
                $file = fopen($fn, "r");
                while (($tp = fgetcsv($file, 10000, ",")) !== FALSE) {
                    $count++;
                    if ($count > 1) {
                        $this->check_nd_updates($tp);
                    }
                }
            }
        }
        if ($this->input->post('price_import')) {
            $count = 0;
            if ($_FILES['excel_filea']['name'] <> '') {
                $fn = $_FILES['excel_filea']['tmp_name'];
                $file = fopen($fn, "r");
                while (($tp = fgetcsv($file, 10000, ",")) !== FALSE) {
                    $count++;
                    if ($count > 1) {
                        $this->check_nd_updates1($tp);
                    }
                }
            }
        }
        $this->load->view(admin_view('default'), $this->data);
    }

    function check_nd_updates($tp)
    {
        $data = array();
            $data['id'] = $tp[0];
        if($data['id']==''){
            $this -> session -> set_flashdata('error', "ID is Blank for ".$tp[2]);
            redirect(admin_url('settings/import'));
        }
        $data['sku'] = $tp[1];
        $data['qty'] = $tp[2];
        $data['sequence'] = $tp[3];
        $this -> Product_model -> save($data);
        $this -> session -> set_flashdata('success', "Succefully imported Quantity");
        //redirect(admin_url('settings/import'));
    }

    function check_nd_updates1($tp)
    {
        $data = array();
        $data['id'] = $tp[0];
        if($data['id']==''){
            $this -> session -> set_flashdata('error', "ID is Blank for ".$tp[2]);
            redirect(admin_url('settings/import'));
        }
        $data['sku'] = $tp[1];
        $data['price'] = $tp[2];
        $data['sale_price'] = $tp[3];
        $data['ship_charge'] = $tp[4];
        $this -> Product_model -> save($data);
        $this -> session -> set_flashdata('success', "Succefully imported Prices");
        //redirect(admin_url('settings/import'));
    }

    function export_quantity(){
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $this->data['active_menu'] = "imp_exp";
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "qty.csv";
        $this -> db -> select('id as ID, sku as SKU, qty as Quantity,sequence as Sequence');
        $this -> db -> order_by('id','DESC');
        $this -> db -> where('product_type',ELECTRONICS);
        $this -> db -> from('products');
        $result = $this -> db -> get();
        $count = $result->num_rows();
        if($count ==0){
            $this -> session -> set_flashdata('error', 'No Data Found');
            redirect('settings/import');
        }
        else{
            $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
            force_download($filename, $data);
            $this -> session -> set_flashdata('success', 'Quantity Exported');
            redirect(admin_url('settings/import'));
        }
    }

    function export_price(){
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $this->data['active_menu'] = "imp_exp";
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "price.csv";
        $this -> db -> select('id as ID, sku as SKU, price as MRP,sale_price as Sale Price, ship_charge as Shipping');
        $this -> db -> order_by('id','DESC');
        $this -> db -> where('product_type',ELECTRONICS);
        $this -> db -> from('products');
        $result = $this -> db -> get();
        $count = $result->num_rows();
        if($count ==0){
            $this -> session -> set_flashdata('error', 'No Data Found');
            redirect('settings/import');
        }
        else{
            $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
            force_download($filename, $data);
            $this -> session -> set_flashdata('success', 'Price Exported');
            redirect(admin_url('settings/import'));
        }
    }



      function referral()
    {
        $this->data['main'] = admin_view('setting/referral');
       
        $this->load->view(admin_view('default'), $this->data);
    }


}
