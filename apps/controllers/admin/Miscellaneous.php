<?php
class Miscellaneous extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this -> load -> model('Miscellaneous_model');

    }

    function bulksave(){
        $url = admin_url('miscellaneous');
        if($this -> input -> post('frmall')) {
            $url = $this -> input -> post('url');
            $pids = $this -> input -> post('quantity');
            $quantity = $this -> input -> post('quantity');
            foreach($pids as $id => $val){
                $item = array();
                $item['id'] = $id;
                $item['quantity'] = $quantity[$id];
                $this -> Stock_model -> save($item);
            }
            $this -> session -> set_flashdata("success", "Bulk Details Updated");
        }
        redirect($url);
    }

    function index(){
        $this -> data['active_tabs'] = "electronics";
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $show_per_page = 50;
        $offset = ($page - 1 ) * $show_per_page;
        $this -> data['main'] = admin_view('miscellaneous/index');
        $data	= $this -> Miscellaneous_model -> getWhereRecords($show_per_page, $offset);
        $this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'design_code' => $q, 'model_code' => $q, 'id' => $q, 'sku' => $q, 'name' => $q
                );
                $data = $this -> Miscellaneous_model -> getAllSearched($offset, $show_per_page, $likes);
                $this -> data['q'] = $q;
            }
        }
        $this -> data['miscellaneous'] = $data['results'];
        $config['base_url'] 	 = admin_url('miscellaneous');
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
        $this -> data['active_tabs'] = "electronics";
        $config['upload_path'] = upload_dir();
        $config['allowed_types'] = 'gif|jpeg|jpg|png';
        $this -> load -> library('upload', $config);
        $this -> data['main'] = admin_view('miscellaneous/add');
        $this -> data['dashboard_title'] = ($id == false) ? "Add Type" : "Edit Type";
        $this -> data['p'] = $this -> Miscellaneous_model -> getNew();
        if($id){
            $this -> data['p'] = $this -> Miscellaneous_model -> getRow($id);
        }
        $this -> form_validation -> set_rules('frm[name]', 'Name', 'required');
        $this -> form_validation -> set_rules('frm[type]', 'Type', 'required');
        if($this -> form_validation -> run()){
            $p = $this -> input -> post('frm');
            $p['id'] = $id;
            if($_FILES <>''){
                if($this -> upload ->do_upload('image')){
                    $p['image'] = $this->upload->data()['file_name'];
                }
                else{
                    //echo $this->upload->display_errors();
                }
            }
            $id = $this -> Miscellaneous_model -> save($p);
            $this -> session -> set_flashdata("success", "Data saved successfully");
            redirect(admin_url('miscellaneous/add/'. $id));
        }

        $this -> load -> view(admin_view('default'), $this -> data);
    }

    public function delete($id = false){
        $data['status'] = 1;
        if($id){
            $this -> Miscellaneous_model -> delete($id);
            $this -> session -> set_flashdata('success', 'Stock Item deleted successfully');
        }else{
            $ids = $this -> input -> post('ids');
            if(is_array($ids)){
                foreach($ids as $id){
                    $this -> Stock_model -> delete($id);
                }
            }
            $this -> session -> set_flashdata('success', 'Bulk Stock Item deleted');
        }
        redirect('admin/miscellaneous');
    }

    function  point(){
        $this -> data['active_tabs'] = "media";
        $page = isset($_GET['page'])?$_GET['page'] : 1;
        $show_per_page = 40;
        $offset = ($page - 1) * $show_per_page;
        $this -> data['main'] = admin_view('miscellaneous/point');
        $data = $this -> Master_model -> getAll($offset, $show_per_page, 'point_info');
        $this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'title' => $q, 'short_info' => $q
                );
                $data = $this -> Miscellaneous_model -> getAllSearched($offset, $show_per_page, $likes, 'point_info');
            }
        }
        $this -> data['point'] = $data['results'];
        $config['base_url'] 	 = admin_url('miscellaneous');
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

    function add_point_info($id = false){
        $this -> data['active_tabs'] = "media";
        $this -> data['main'] = admin_view('miscellaneous/add_point_info');
        $this -> data['dashboard_title'] = ($id == false) ? "Add Point" : "Edit Point";
        $this -> data['p'] = $this -> Master_model -> getNew('point_info');
        if($id){
            $this -> data['p'] = $this -> Master_model -> getRow($id, 'point_info');
        }
        $this -> form_validation -> set_rules('frm[title]', 'Title', 'required');
        $this -> form_validation -> set_rules('frm[short_info]', 'Short Info', 'required');
        if($this -> form_validation -> run()){
            $p = $this -> input -> post('frm');
            $p['id'] = $id;
            $id = $this -> Master_model -> save($p);
            $this -> session -> set_flashdata("success", "Stock Item saved successfully");
            redirect(admin_url('miscellaneous/point'));
        }

        $this -> load -> view(admin_view('default'), $this -> data);
    }

    public function del_point_info($id = false){
        $data['status'] = 1;
        if($id){
            $this -> Miscellaneous_model -> delete($id);
            $this -> session -> set_flashdata('success', 'Stock Item deleted successfully');
        }else{
            $ids = $this -> input -> post('ids');
            if(is_array($ids)){
                foreach($ids as $id){
                    $this -> Stock_model -> delete($id);
                }
            }
            $this -> session -> set_flashdata('success', 'Bulk Stock Item deleted');
        }
        redirect('admin/miscellaneous');
    }
}
