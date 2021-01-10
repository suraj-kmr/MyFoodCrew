<?php
class Home_accessories extends MY_Controller{

    function __construct(){
        parent::__construct();

        $this -> load -> helper("file");
        $this -> data['active_tabs'] = 'home_accessories';
        $role = $this -> session -> userdata('role');
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
        $this -> load -> model(array('Media_model'));
    }

    function bulksave(){

        $url = admin_url('home_accessories');
        if($this -> input -> post('frmall')) {
            $url = $this -> input -> post('url');
            $pids = $this -> input -> post('pid');
            $ship = $this -> input -> post('ship');
            $qty = $this -> input -> post('qty');
            $off = $this -> input -> post('offer');
            $sequence = $this -> input -> post('sequence');
            foreach($pids as $id => $val){
                $item = array();
                $item['id'] = $id;
                $item['sale_price'] = $val;
                $item['ship_charge'] = $ship[$id];
                $item['qty'] = $qty[$id];
                $item['offer'] = $off[$id];
                $item['sequence'] = $sequence[$id];
                $this -> Product_model -> save($item);
            }
            $this -> session -> set_flashdata("success", "Bulk Details Updated");
        }
        redirect($url);
    }

    function index(){
        $show_per_page = isset($_GET['show_page']) ? $_GET['show_page'] : 10;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1 ) * $show_per_page;
        $this -> data['main'] = admin_view('home-accessories/index');
        $status = isset($_GET['status']) ? $_GET['status'] : 'all';
        $rule = array();
        if($status == 'active'){
            $rule['status'] = 1;
            $data	= $this -> Product_model -> getWherePtype($show_per_page, $offset, $rule, HOMEKITCHEN);
        }elseif($status == 'inactive'){
            $rule['status'] = 0;
            $data	= $this -> Product_model -> getWherePtype($show_per_page, $offset, $rule, HOMEKITCHEN);
        }else{
            $data	= $this -> Product_model -> getWherePtype($show_per_page, $offset,'', HOMEKITCHEN);
        }

        $this -> data['filter_status'] = $status;
        $this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'ptitle' => $q, 'id' => $q, 'sku' => $q
                );
                $data = $this -> Product_model -> getAllSearchedWhere($offset, $show_per_page, $likes, array('product_type'=> HOMEKITCHEN));
                $this -> data['q'] = $q;
            }
        }

        $this -> data['products'] = $data['results'];
        $config['base_url'] 	 = admin_url('home_accessories/index');
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

        $this -> data['categories'] = $data['results'];
        $this->load->view(admin_view('default'), $this -> data);
    }


    function add($id = false){
        $config = array();
        $config['upload_path'] = upload_dir();
        $config['allowed_types'] = 'png|jpg|jpeg|gif';
        $config['remove_spaces'] = TRUE;
        $this->load->library('upload', $config);
        $this -> data['active_tabs'] ='home_accessories';
        $this -> data['main'] = admin_view('home-accessories/add');
        $this -> data['dashboard_title'] = ($id == false) ? "Add Products" : "Edit Products";
        $this -> data['brand'] = $this -> Master_model -> listAll('ai_hbrand');
        $this -> data['material'] = $this -> Master_model -> listAll('hmaterial');

        $this -> data['theme'] = $this -> Master_model -> listAll('htheme');
        $this -> data['categories']		= $this -> Category_model -> get_categories_tierd(0, HOMEKITCHEN);
        $this -> data['gift'] = $this -> Master_model -> listAllWhere('categories', array('parent_id'=>102));
        //print_r($this -> data['categories']);
        $this -> data['images'] = $this -> Media_model -> allimages();
        $this -> data['office'] = $this -> Master_model -> getNew('ai_home');
        $this -> data['p'] = $this -> Product_model -> getNew();
        if($id){
            $this -> data['p'] = $this -> Product_model -> getProduct($id);
            $this -> data['office'] = $this -> Master_model -> getRow1($id, 'ai_home');
            $this -> data['categories']	= $this -> Category_model -> get_categories_tierd(0,HOMEKITCHEN);
        }

        $this -> form_validation -> set_rules('frm[ptitle]', 'Product Title', 'required');
        $this -> form_validation -> set_rules('frm[product_type]', 'Product Type', 'required');
        $this -> form_validation -> set_rules('frm[qty]', 'Product Quantity', 'required');
        $this -> form_validation -> set_rules('frm[price]', 'Product Price', 'required');
        $this -> form_validation -> set_rules('frm[sale_price]', 'Product Sale Price', 'required');
        if($this -> form_validation -> run()){
            $p = $this -> input -> post('frm');
            $p['id'] = $id;
            //$p['gallery'] = $this -> input -> post('img_selected');
            $p['available'] = $this -> input -> post('frm[available]') ? 1 : 0;
            $p['discount'] = $this -> input -> post('frm[discount]') ? 1 : 0;

            $config = array();
            //$config['upload_path'] = upload_dir();
            $config['upload_path'] = 'img/uploads/';
            $config['allowed_types'] = 'png|jpg|jpeg|gif';
            $config['max_size'] = 3000;
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $ftp_server = "images-aldivo.com";
            $ftp_user = "aldivoimages";
            $ftp_password = "Booklele@#123";

            $image = $image1 = $image2 = $image3 = '';

            $conn = ftp_connect($ftp_server) or die ("Cannot connect to host");
            if (@ftp_login($conn, $ftp_user, $ftp_password)) {
                ftp_pasv($conn, true);

                if($_FILES['cover_image']['name'] != ''){
                    $file_name = $_FILES['cover_image']['name'];
                    $file_path = 'public_html/img/uploads/'.$file_name;
                    $uploaded = ftp_put($conn, $file_path, $_FILES['cover_image']['tmp_name'], FTP_BINARY);
                    $image = 'https://images-aldivo.com/img/uploads/'.$file_name;
                }
                else{
                    $image = $this -> input -> post('txt_image1');
                }

                if($_FILES['image1']['name'] !='') {
                    $file_name = $_FILES['image1']['name'];
                    $file_path = 'public_html/img/uploads/'.$file_name;
                    $uploaded = ftp_put($conn, $file_path, $_FILES['image1']['tmp_name'], FTP_BINARY);
                    $image1 = 'https://images-aldivo.com/img/uploads/'.$file_name;
                }
                else{
                    $image1 = $this -> input -> post('txt_image2');
                }
                if($_FILES['image2']['name'] != '') {
                    $file_name = $_FILES['image2']['name'];
                    $file_path = 'public_html/img/uploads/'.$file_name;
                    $uploaded = ftp_put($conn, $file_path, $_FILES['image2']['tmp_name'], FTP_BINARY);
                    $image2 = 'https://images-aldivo.com/img/uploads/'.$file_name;
                }
                else{
                    $image2 = $this -> input -> post('txt_image3');
                }
                if($_FILES['image3']['name']) {
                    $file_name = $_FILES['image3']['name'];
                    $file_path = 'public_html/img/uploads/'.$file_name;
                    $uploaded = ftp_put($conn, $file_path, $_FILES['image3']['tmp_name'], FTP_BINARY);
                    $image3 = 'https://images-aldivo.com/img/uploads/'.$file_name;
                }
                else{
                    $image3 = $this -> input -> post('txt_image4');
                }

                ftp_close($conn);
                if($uploaded){
                    echo "success";
                }
                else{
                    echo "fail";
                }
            } else {
                return "Couldn't connect as $ftp_user\n";
            }

            $p['image'] = $image;
            $p['gallery'] = $image.','.$image1 . ',' . $image2 . ',' . $image3;

            /*$image = $image1 = $image2 = $image3 = '';
            if($_FILES['cover_image']['name'] != ''){
                $uploaded = $this -> upload -> do_upload('cover_image');
                if($uploaded){
                    $image = $this -> upload -> data();
                    $p['image'] = site_url(upload_dir($image['file_name']));
                    $image = site_url(upload_dir($image['file_name']));
                }
            }
            else{
                $image = $this -> input -> post('txt_image1');
            }

            if($_FILES['image1']['name'] !='') {
                $uploaded1 = $this->upload->do_upload('image1');
                if ($uploaded1) {
                    $image1 = $this->upload->data();
                    $image1 = site_url(upload_dir($image1['file_name']));
                }
            }
            else{
                $image1 = $this -> input -> post('txt_image2');
            }
            if($_FILES['image2']['name'] != '') {
                $uploaded2 = $this->upload->do_upload('image2');
                if ($uploaded2) {
                    $image2 = $this->upload->data();
                    $image2 = site_url(upload_dir($image2['file_name']));
                }
            }
            else{
                $image2 = $this -> input -> post('txt_image3');
            }
            if($_FILES['image3']['name']) {
                $uploaded3 = $this->upload->do_upload('image3');
                if ($uploaded3) {
                    $image3 = $this->upload->data();
                    $image3 = site_url(upload_dir($image3['file_name']));
                }
            }
            else{
                $image3 = $this -> input -> post('txt_image4');
            }

            $p['gallery'] = $image.','.$image1 . ',' . $image2 . ',' . $image3;*/
            $slug = $p['slug'];
            if(empty($slug) || $slug=='')
            {
                $slug = $p['ptitle'];
            }
            $p['slug']	= strtolower(url_title($slug));
            if($this -> input -> post('sizes')){
                $p['sizes'] = json_encode($this -> input -> post('sizes'));
            }
            if($this -> input -> post('params')){
                $p['params'] = json_encode($this -> input -> post('params'));
            }
            $id1 = $this -> Product_model -> save($p);
            $office = $this -> input -> post('frm1');
            $office['pid'] = $id1;
            $office['id'] = false;
            if($id){
                $office1 = $this -> Master_model -> getBookId($id, 'ai_home');
                $office['id'] = $office1 -> id;
            }
            $this -> Master_model -> save($office, 'ai_home');
            if($this -> input -> post('cats')){
                $cats = $this -> input -> post('cats');
                $this -> Product_model -> resetCategory($id1, $cats);
            }
            $this -> session -> set_flashdata("success", "Product saved successfully");
            redirect(admin_url('home_accessories/add/'. $id));
        }

        $this -> load -> view(admin_view('default'), $this -> data);
    }

    function brand(){
        $page = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
        $show_per_page = 50;
        $offset = ($page - 1) * $show_per_page;
        $this -> data['main'] = admin_view('home-accessories/brand');
        $data = $this -> Master_model -> getAll($offset, $show_per_page, 'ai_hbrand');
        $this -> data['q'] = '';
        if($this->input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'title' => $q,
                    'id' => $q
                );
                $data = $this -> Master_model -> getAllSearched($offset, $show_per_page, $likes, 'ai_hbrand');
                $this -> data['q'] = $q;
            }
        }
        $config['base_url'] = admin_url('home_accessories/brand');
        $config['num_links'] = 2;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $data['total'];
        $config['per_page'] = $show_per_page;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['next_link'] = 'Next';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open']	 = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['use_page_numbers'] = true;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);
        $this -> data['links'] 	=  $this->pagination->create_links();
        $this -> data['brand'] = $data['results'];
        $this -> load -> view(admin_view('default'), $this->data);
    }

    function brand_add($id=false){
        $this -> data['main'] = admin_view('home-accessories/add_brand');
        $this -> data['brand'] = $this -> Master_model -> getNew('ai_hbrand');
        if($id){
            $this -> data['brand'] = $this -> Master_model -> getRow($id, 'ai_hbrand');
        }
        $this -> form_validation -> set_rules('frm[title]', 'Brand', 'required');
        if($this -> form_validation -> run()){
            $data = $this -> input -> post('frm');
            $data['id'] = $id;
            //print_r($data); exit;
            $this -> Master_model -> save($data, 'ai_hbrand');
            $this->session->set_flashdata('success', "Successfully Saved");
            redirect(admin_url('home_accessories/brand_add/'. $id));
        }
        else {
            $this->load->view(admin_view('default'), $this->data);
        }
    }

    function material(){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $show_per_page = 50;
        $offset = ($page - 1 ) * $show_per_page;
        $this -> data['main'] = admin_view('home-accessories/material');
        $data = $this -> Master_model -> getAll($offset, $show_per_page,'hmaterial');
        $this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'title' => $q, 'id' => $q
                );
                $data = $this -> Master_model -> getAllSearched($offset, $show_per_page, $likes,'hmaterial');
                $this -> data['q'] = $q;
            }
        }
        $config['base_url'] 	 = admin_url('home_accessories/material');
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
        $this -> data['links'] 	=  $this->pagination->create_links();

        $this -> data['material'] = $data['results'];
        $this -> load -> view(admin_view('default'), $this->data);
    }

    function material_add($id = false){
        $this -> data['material'] = $this -> Master_model -> getNew('hmaterial');
        if($id){
            $this -> data['material'] = $this -> Master_model -> getRow($id,'hmaterial');
        }
        $this -> data['main'] = admin_view('home-accessories/add_material');
        $this -> form_validation -> set_rules('frm[title]', 'Material', 'required');
        if($this -> form_validation -> run()) {
            $data = $this->input->post('frm');
            $data['id'] = $id;
            $this->Master_model->save($data, 'hmaterial');
            $this->session->set_flashdata('success', "Successfully Saved");
            redirect(admin_url('home_accessories/material_add/'. $id));
        }
        else {
            $this->load->view(admin_view('default'), $this->data);
        }
    }

    function theme(){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $show_per_page = 50;
        $offset = ($page - 1 ) * $show_per_page;
        $this -> data['main'] = admin_view('home-accessories/theme');
        $data = $this -> Master_model -> getAll($offset, $show_per_page,'htheme');
        $this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'title' => $q, 'id' => $q
                );
                $data = $this -> Master_model -> getAllSearched($offset, $show_per_page, $likes,'htheme');
                $this -> data['q'] = $q;
            }
        }

        $config['base_url'] 	 = admin_url('home_accessories/theme');
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
        $this -> data['links'] 	=  $this->pagination->create_links();

        $this -> data['theme'] = $data['results'];
        $this -> load -> view(admin_view('default'), $this->data);
    }

    function theme_add($id = false){
        $this -> data['theme'] = $this -> Master_model -> getNew('htheme');
        if($id){
            $this -> data['theme'] = $this -> Master_model -> getRow($id, 'htheme');
        }
        $this -> data['main'] = admin_view('home-accessories/add_theme');
        $this -> form_validation -> set_rules('frm[title]', 'Theme', 'required');
        if($this -> form_validation -> run()) {
            $data = $this->input->post('frm');
            $data['id'] = $id;
            $this->Master_model->save($data, 'htheme');
            $this->session->set_flashdata('success', "Successfully Saved");
            redirect(admin_url('home_accessories/theme_add/'. $id));
        }
        else {
            $this->load->view(admin_view('default'), $this->data);
        }
    }

    function activate($id = false){
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('home_accessories');
        if($id){
            $c['id'] = $id;
            $c['status'] = 1;
            $this -> Product_model -> save($c);
            $this -> session -> set_flashdata("success", "Product activated");
        }
        redirect($redirect);
    }

    function deactivate($id = false){
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('home_accessories');
        if($id){
            $c['id'] = $id;
            $c['status'] = 0;
            $this -> Product_model -> save($c);
            $this -> session -> set_flashdata("success", "Product deactivated");
        }
        redirect($redirect);
    }

    function export_selected($id = false){
        $data['status'] = 1;
        if($id){
            $this -> session -> set_flashdata('success', 'Products deleted successfully');
        }else{
            $ids = $this -> input -> post('ids');
            $this->load->dbutil();
            $this->load->helper('file');
            $this->load->helper('download');
            ini_set('memory_limit','1024M');
            $delimiter = ",";
            $newline = "\r\n";
            $filename = "products.csv";
            $this ->db -> where_in('id',$ids);
            $result = $this -> db -> get('products');
            $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
            force_download($filename, $data);
            redirect(admin_url('books'));
            $this -> session -> set_flashdata('success', 'Bulk Products deleted');
        }
        redirect('admin/home_accessories');
    }

    function export_all(){
        $data['status'] = 1;
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        ini_set('memory_limit','1024M');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "products.csv";
        $result = $this -> db -> get_where('products', array('product_type'=>HOMEKITCHEN));
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
        redirect(admin_url('products'));
        $this -> session -> set_flashdata('success', 'Bulk Products deleted');
        redirect('admin/home_accessories');
    }

    public function delete($id = false){
        $data['status'] = 1;
        if($id){
            $this -> Product_model -> delete($id);
            $this -> Master_model -> delete($id,'ai_home');
            $this -> Product_model -> delete_p_cat($id);
            $this -> session -> set_flashdata('success', 'Products deleted successfully');
        }else{
            $ids = $this -> input -> post('ids');
            if(is_array($ids)){
                foreach($ids as $id){
                    $this -> Product_model -> delete($id);
                    $this -> Product_model -> delete_p_cat($id);
                }
            }
            $this -> session -> set_flashdata('success', 'Bulk Products deleted');
        }
        redirect('admin/home_accessories');
    }

    function bdelete($id){
        $this -> Master_model -> delete($id,'ai_hbrand');
        $this -> session -> set_flashdata('success', 'Data Deleted Successfully');
        redirect(admin_url('home_accessories/brand'));
    }

    function mdelete($id){
        $this -> Master_model -> delete($id,'hmaterial');
        $this -> session -> set_flashdata('success', 'Data Deleted Successfully');
        redirect(admin_url('home_accessories/material'));
    }

    function tdelete($id){
        $this -> Master_model -> delete($id,'htheme');
        $this -> session -> set_flashdata('success', 'Data Deleted Successfully');
        redirect(admin_url('home_accessories/theme'));
    }


}