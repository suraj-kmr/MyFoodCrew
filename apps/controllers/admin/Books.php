<?php
class Books extends MY_Controller{

    function __construct(){
        parent::__construct();
        $config = array();
        $config['upload_path'] = upload_dir();
        $config['allowed_types'] = 'png|jpg|jpeg|gif';
        //$config['max_size'] = 3000;
        $config['remove_spaces'] = TRUE;
        $this->load->library('upload', $config);
        $this -> load -> helper("file");
        $this -> data['active_tabs'] = 'books';
        $role = $this -> session -> userdata('role');
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
        $this -> load -> model(array('Book_model', 'Media_model'));
    }

    function bulksave(){

        $url = admin_url('books');
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
        $this -> data['main'] = admin_view('books/index');
        $status = isset($_GET['status']) ? $_GET['status'] : 'all';
        $rule = array();
        if($status == 'active'){
            $rule['status'] = 1;
            $rule['product_type'] = BOOKS;
            $data	= $this -> Product_model -> getWherePtype($show_per_page, $offset, $rule, BOOKS);
        }elseif($status == 'inactive'){
            $rule['status'] = 0;
            $data	= $this -> Product_model -> getWherePtype($show_per_page, $offset, $rule, BOOKS);
        }else{
            $data	= $this -> Product_model -> getWherePtype($show_per_page, $offset,'', BOOKS);
        }

        $this -> data['filter_status'] = $status;
        $this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'ptitle' => $q, 'id' => $q, 'sku' => $q
                );
                $data = $this -> Product_model -> getAllSearchedWhere($offset, $show_per_page, $likes, array('product_type'=>BOOKS));
                $this -> data['q'] = $q;
            }
        }

        $this -> data['products'] = $data['results'];
        $config['base_url'] 	 = admin_url('books/index');
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
        $this -> data['active_tabs'] ='books';
        $this -> data['main'] = admin_view('books/add');
        $this -> data['dashboard_title'] = ($id == false) ? "Add Products" : "Edit Products";
        $this -> data['author'] = $this -> Master_model -> listAll('ai_author');
        $this -> data['publisher'] = $this -> Master_model -> listAll('ai_publisher');

        $this -> data['language'] = $this -> Master_model -> listAll('ai_language');
        $this -> data['categories']		= $this -> Category_model -> get_categories_tierd1();
        $this -> data['gift'] = $this -> Master_model -> listAllWhere('categories', array('parent_id'=>102));
        $this -> data['images'] = $this -> Media_model -> allimages();
        $this -> data['p'] = $this -> Product_model -> getNew();
        $this -> data['arr_designs'] = $this -> Master_model -> listAll('designs');
        $this -> data['book'] = $this -> Book_model -> getNew('ai_book');
        if($id){
            $this -> data['p'] = $this -> Product_model -> getProduct($id);
            $this -> data['book'] = $this -> Master_model -> getRow1($id, 'ai_book');
            $this -> data['categories']	= $this -> Category_model -> get_categories_tierd1(0,$this->data['p']->product_type);
        }

        $this -> form_validation -> set_rules('frm[ptitle]', 'Product Title', 'required');
        $this -> form_validation -> set_rules('frm[product_type]', 'Product Type', 'required');
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

            if($this -> input -> post('sizes')){
                $p['sizes'] = json_encode($this -> input -> post('sizes'));
            }
            if($this -> input -> post('params')){
                $p['params'] = json_encode($this -> input -> post('params'));
            }
            $id1 = $this -> Product_model -> save($p);
            $book = $this -> input -> post('frm1');
            $book['pid'] = $id1;
            $book['id'] = false;
            if($id){
                $books = $this -> Master_model -> getBookId($id, 'ai_book');
                //print_r($books); exit;
                $book['id'] = $books->id;
            }
            $this -> Master_model -> save($book, 'ai_book');

            if($this -> input -> post('cats')){
                $cats = $this -> input -> post('cats');
                $this -> Product_model -> resetCategory($id1, $cats);
            }
            $this -> session -> set_flashdata("success", "Product saved successfully");
            redirect(admin_url('books/add/'. $id));
        }

        $this -> load -> view(admin_view('default'), $this -> data);
    }

    function author(){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $show_per_page = 50;
        $offset = ($page - 1 ) * $show_per_page;
        $this -> data['main'] = admin_view('books/author');
        $data = $this -> Master_model -> getAll($offset, $show_per_page,'ai_author');
        $this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'title' => $q, 'id' => $q
                );
                $data = $this -> Book_model -> getAllSearched($offset, $show_per_page, $likes);
                $this -> data['q'] = $q;
            }
        }

        $config['base_url'] 	 = admin_url('books/author');
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

        $this -> data['books'] = $data['results'];
        $this -> load -> view(admin_view('default'), $this->data);
    }

    function author_add($id = false){
        $this -> data['books'] = $this -> Book_model -> getNew();
        if($id){
            $this -> data['books'] = $this -> Book_model -> getRow($id);
        }
        $this -> data['main'] = admin_view('books/add_author');
        $this -> form_validation -> set_rules('frm[title]', 'Author', 'required');
        if($this -> form_validation -> run()) {

            $data = $this->input->post('frm');
            $data['id'] = $id;
            $this->Master_model->save($data, 'ai_author');
            $this->session->set_flashdata('success', "Successfully Saved");
            redirect(admin_url('books/author_add/'. $id));
        }
        else {
            $this->load->view(admin_view('default'), $this->data);
        }
    }

    function publisher(){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $show_per_page = 50;
        $offset = ($page - 1 ) * $show_per_page;
        $this -> data['main'] = admin_view('books/publisher');
        //$this -> data['publisher'] = $this -> Book_model -> allPublisher();
        $data = $this -> Master_model -> getAll($offset, $show_per_page,'ai_publisher');
        $this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'title' => $q, 'id' => $q
                );
                $data = $this -> Master_model -> getAllSearched($offset, $show_per_page, $likes,'ai_publisher');
                $this -> data['q'] = $q;
            }
        }

        $config['base_url'] 	 = admin_url('books/publisher');
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

        $this -> data['publisher'] = $data['results'];
        $this -> load -> view(admin_view('default'), $this->data);
    }

    function publisher_add($id = false){
        $this -> data['publisher'] = $this -> Master_model -> getNew('ai_publisher');
        if($id){
            $this -> data['publisher'] = $this -> Master_model -> getRow($id,'ai_publisher');
        }
        $this -> data['main'] = admin_view('books/add_publisher');
        $this -> form_validation -> set_rules('frm[title]', 'Publisher', 'required');
        if($this -> form_validation -> run()) {
            $data = $this->input->post('frm');
            $data['id'] = $id;
            $this->Master_model->save($data, 'ai_publisher');
            $this->session->set_flashdata('success', "Successfully Saved");
            redirect(admin_url('books/publisher_add/'. $id));
        }
        else {
            $this->load->view(admin_view('default'), $this->data);
        }
    }

    function isbm(){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $show_per_page = 50;
        $offset = ($page - 1 ) * $show_per_page;
        $this -> data['main'] = admin_view('books/isbm');
        //$this -> data['publisher'] = $this -> Book_model -> allPublisher();
        $data = $this -> Master_model -> getAll($offset, $show_per_page,'ai_isbm');
        $this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'title' => $q, 'id' => $q
                );
                $data = $this -> Master_model -> getAllSearched($offset, $show_per_page, $likes,'ai_isbm');
                $this -> data['q'] = $q;
            }
        }

        $config['base_url'] 	 = admin_url('books/isbm');
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

        $this -> data['isbm'] = $data['results'];
        $this -> load -> view(admin_view('default'), $this->data);
    }

    function isbm_add($id = false){
        $this -> data['isbm'] = $this -> Master_model -> getNew('ai_isbm');
        if($id){
            $this -> data['isbm'] = $this -> Master_model -> getRow($id, 'ai_isbm');
        }
        $this -> data['main'] = admin_view('books/add_isbm');
        $this -> form_validation -> set_rules('frm[title]', 'ISBM', 'required');
        if($this -> form_validation -> run()) {
            $data = $this->input->post('frm');
            $data['id'] = $id;
            $this->Master_model->save($data, 'ai_isbm');
            $this->session->set_flashdata('success', "Successfully Saved");
            redirect(admin_url('books/isbm_add/'. $id));
        }
        else {
            $this->load->view(admin_view('default'), $this->data);
        }
    }

    function language(){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $show_per_page = 50;
        $offset = ($page - 1 ) * $show_per_page;
        $this -> data['main'] = admin_view('books/language');
        //$this -> data['publisher'] = $this -> Book_model -> allPublisher();
        $data = $this -> Master_model -> getAll($offset, $show_per_page,'ai_language');
        $this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'title' => $q, 'id' => $q
                );
                $data = $this -> Master_model -> getAllSearched($offset, $show_per_page, $likes,'ai_language');
                $this -> data['q'] = $q;
            }
        }

        $config['base_url'] 	 = admin_url('books/language');
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

        $this -> data['language'] = $data['results'];
        $this -> load -> view(admin_view('default'), $this->data);
    }

    function language_add($id = false){
        $this -> data['language'] = $this -> Master_model -> getNew('ai_language');
        if($id){
            $this -> data['language'] = $this -> Master_model -> getRow($id, 'ai_language');
        }
        $this -> data['main'] = admin_view('books/add_language');
        $this -> form_validation -> set_rules('frm[title]', 'Language', 'required');
        if($this -> form_validation -> run()) {
            $data = $this->input->post('frm');
            $data['id'] = $id;
            $this->Master_model->save($data, 'ai_language');
            $this->session->set_flashdata('success', "Successfully Saved");
            redirect(admin_url('books/language_add/'. $id));
        }
        else {
            $this->load->view(admin_view('default'), $this->data);
        }
    }

    function activate($id = false){
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('books');
        if($id){
            $c['id'] = $id;
            $c['status'] = 1;
            $this -> Product_model -> save($c);
            $this -> session -> set_flashdata("success", "Product activated");
        }
        redirect($redirect);
    }

    function deactivate($id = false){
        $redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('books');
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
        redirect('admin/books');
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
        $result = $this -> db -> get_where('products', array('product_type'=>2));
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
        redirect(admin_url('products'));
        $this -> session -> set_flashdata('success', 'Bulk Products deleted');
        redirect('admin/books');
    }

    public function delete($id = false){
        $data['status'] = 1;
        if($id){
            $this -> Product_model -> delete($id);
            $this -> Master_model -> delete($id,'ai_book');
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
        redirect('admin/books');
    }

    function adelete($id){
        $this -> Master_model -> delete($id,'ai_author');
        $this -> session -> set_flashdata('success', 'Data Deleted Successfully');
        redirect(admin_url('books'));
    }

    function pdelete($id){
        $this -> Master_model -> delete($id,'ai_publisher');
        $this -> session -> set_flashdata('success', 'Data Deleted Successfully');
        redirect(admin_url('books/publisher'));
    }

    function idelete($id){
        $this -> Master_model -> delete($id,'ai_isbm');
        $this -> session -> set_flashdata('success', 'Data Deleted Successfully');
        redirect(admin_url('books/isbm'));
    }

    function ldelete($id){
        $this -> Master_model -> delete($id,'ai_language');
        $this -> session -> set_flashdata('success', 'Data Deleted Successfully');
        redirect(admin_url('books/language'));
    }
}