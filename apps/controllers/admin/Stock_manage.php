<?php
class Stock_manage extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this -> load -> model('Stock_manage_model');
        $this -> data['active_tabs'] = "catalog";
    }

    function bulksave(){
        $url = admin_url('stock_manage');
        if($this -> input -> post('frmall')) {
            $url = $this -> input -> post('url');
            $pids = $this -> input -> post('quantity');
            $quantity = $this -> input -> post('quantity');
            foreach($pids as $id => $val){
                $item = array();
                $item['id'] = $id;
                $item['quantity'] = $quantity[$id];
                $this -> Stock_manage_model -> save($item);
            }
            $this -> session -> set_flashdata("success", "Bulk Details Updated");
        }
        redirect($url);
    }

    function index(){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $show_per_page = 50;
        $offset = ($page - 1 ) * $show_per_page;
        $this -> data['main'] = admin_view('stock/stock_manage_index');
        $data	= $this -> Stock_manage_model -> getWhereRecords($show_per_page, $offset);
        $this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'rake_code' => $q, 'name' => $q, 'id' => $q
                );
                $data = $this -> Stock_manage_model -> getAllSearched($offset, $show_per_page, $likes);
                $this -> data['q'] = $q;
            }
        }

        $this -> data['stock'] = $data['results'];
        $config['base_url'] 	 = admin_url('stock_manage/stock_manage_index');
        $config['num_links'] 	 = 2;
        $config['uri_segment']	 = 4;
        $config['total_rows']	 = $data['total'];
        $config['per_page'] 	 = $show_per_page;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close']= '</ul>';
        $config['num_tag_open']  = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link'] 	 = 'First';
        $config['first_tag_open']= '<li>';
        $config['first_tag_close']= '</li>';
        $config['last_link'] 	 = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close']= '</li>';
        $config['prev_link'] 	 = 'Prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close']= '</li>';
        $config['next_link'] 	 = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close']= '</li>';
        $config['cur_tag_open']	 = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['use_page_numbers'] = true;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);
        $this -> data['paginate'] 	=  $this->pagination->create_links();
        $this->load->view(admin_view('default'), $this -> data);
    }

    function add($id = false){
        $this -> data['main'] = admin_view('stock/stock_manage_add');
        $this -> data['dashboard_title'] = ($id == false) ? "Add Stock" : "Edit Stock";
        $this -> data['p'] = $this -> Stock_manage_model -> getNew();
        if($id){
            $this -> data['p'] = $this -> Stock_manage_model -> getProduct($id);
        }
        if($id){
            $this -> form_validation -> set_rules('frm[rake_code]', 'Rake Code', 'required');
        }
        else{
            $this -> form_validation -> set_rules('frm[rake_code]', 'Rake Code', 'required|is_unique[stock_manage.rake_code]');
        }
        $this -> form_validation -> set_rules('frm[quantity]', 'Item Quantity', 'required');
        if($this -> form_validation -> run()){
            $p = $this -> input -> post('frm');
            $p['id'] = $id;
            $id = $this -> Stock_manage_model -> save($p);
            $this -> session -> set_flashdata("success", "Stock Item saved successfully");
            redirect(admin_url('stock_manage/add/'. $id));
        }

        $this -> load -> view(admin_view('default'), $this -> data);
    }

    function activate($id = false){
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('stock');
        if($id){
            $c['id'] = $id;
            $c['status'] = 1;
            $this -> Stock_manage_model -> save($c);
            $this -> session -> set_flashdata("success", "Stock Item activated");
        }
        redirect($redirect);
    }

    function deactivate($id = false){
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('products');
        if($id){
            $c['id'] = $id;
            $c['status'] = 0;
            $this -> Stock_manage_model -> save($c);
            $this -> session -> set_flashdata("success", "Stock Item deactivated");
        }
        redirect($redirect);
    }

    public function delete($id = false){
        $data['status'] = 1;
        if($id){
            $this -> Stock_manage_model -> delete($id);
            $this -> session -> set_flashdata('success', 'Stock Item deleted successfully');
        }else{
            $ids = $this -> input -> post('ids');
            if(is_array($ids)){
                foreach($ids as $id){
                    $this -> Stock_manage_model -> delete($id);
                }
            }
            $this -> session -> set_flashdata('success', 'Bulk Stock Item deleted');
        }
        redirect('admin/stock_manage');
    }

    function import_files(){
        $this -> data['main'] = admin_view('stock/stocke_manage_import-file');
        if($this -> input -> post('import_btn')){
            $count = 0;
            if($_FILES['excel_file']['name'] <> ''){
                $fn = $_FILES['excel_file']['tmp_name'];
                $file = fopen($fn, "r");
                while(($tp = fgetcsv($file, 10000, ",")) !== FALSE){
                    $count++;
                    if($count > 1) {
                        $this -> check_nd_update($tp);
                    }
                }
            }
        }
        $this -> load -> view(admin_view('default'), $this -> data);
    }

    function check_nd_update($tp){
        $data = array();
        $data['id'] = false;
        $data['rake_code']=$tp[0];
        if($tp[1]==""){
            $this -> session -> set_flashdata('error', "Rake Code must not be blank");
            redirect(admin_url('stock_manage/import_files'));
        }
        $data['name'] = $tp[1];
        $data['quantity'] = $tp[2];
        /*if($tp[2]==""){
            $this -> session -> set_flashdata('error', "Quantity must not be blank");
            redirect(admin_url('stock_manage/import_files'));
        }*/
        $pid = $this -> Stock_manage_model -> saveStock($data);
        $this -> session -> set_flashdata('success', "Data Imported Successfully");
    }

    function export(){
        $this->Stock_manage_model->ExportCSV();
        redirect(admin_url('stock_manage'));
    }
}