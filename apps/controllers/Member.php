<?php

class Store extends AI_Controller
{
    var $category;
    private $perPage = 24;
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Category_model', 'Search_model', 'Mobile_model', 'Product_model', 'Office_model', 'Book_model'));
        $this->load->helper(array('cookie', 'url'));
        $seo_title = theme_option('seo_title');
        $this->data['seo_title'] = $seo_title;
        $this->data['seo_description'] = "Get Your Mobile Covers in your printed design";
        $this->data['seo_keywords'] = "Aldivo";
    }

    function index()
    {
        $this->data['main'] = 'member_tree';
        $this->load->view('default', $this->data);
    }

    function campus_store($slug, $id){
        $s = $this->Master_model->getRow($id, 'campus');
        if(count($s) > 0)
        {
            $this->data['seo_title'] = $s->seo_title;
            $this->data['seo_description'] = $s->seo_description;
            $this->data['seo_keywords'] = $s->seo_keywords;
        }

        $this->data['c'] = $s;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $show_per_page = 24;
        $offset = ($page - 1 ) * $show_per_page;

        $this->db->select('id');
        $data = $this->db->get_where('products', array('campus_id' => $id));
        
        $this ->data['products'] = $data -> result();
        //echo $this->db->last_query();die;

        $total = $data -> num_rows();
        //echo count($total);
        //$this ->data['products'] = $this-> Search_model -> category($id);

        $this->data['main'] = 'campus-prod';

        $config = array();
        $config['base_url'] = site_url($slug.'/'.$s->id);
        $config['num_links'] = 1;
        //$config['uri_segment'] = 2;
        $config['total_rows'] = $total;
        $config['per_page'] = $show_per_page;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm custom-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link'] = '<i class="fa fa-chevron-left"></i> First Page';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last Page <i class="fa fa-chevron-right"></i>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa-chevron-left"></i> <span>Previous Page</span>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '<span>Next Page</span> <i class="fa fa-chevron-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></b></li>';
        $config['use_page_numbers'] = true;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);

        $this->data['paginate'] = $this->pagination->create_links();
        $this->load->view('default', $this->data);
    }

    function categories($slug, $id)
    {
        $cat = $this->Category_model->getRow($id);
        if(count($cat) > 0){
            $this->data['seo_title'] = $cat->seo_title;
            $this->data['seo_description'] = $cat->seo_description;
            $this->data['seo_keywords'] = $cat->seo_keywords;
        }
        $this->data['category'] = $cat;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $show_per_page = 24;
        $offset = ($page - 1 ) * $show_per_page;
        if($cat->product_type==OFFICEPRODUCTS){
            $product_type=OFFICEPRODUCTS;
        }
        elseif($cat->product_type==COMPUTERS){
            $product_type=COMPUTERS;
        }
        elseif($cat->product_type==HOMEKITCHEN){
            $product_type=HOMEKITCHEN;
        }
        elseif($cat->product_type==CLOTHINGS){
            $product_type=CLOTHINGS;
        }
        elseif($cat->product_type==BOOKS){
            $product_type=BOOKS;
        }
        elseif($cat->product_type==ELECTRONICS){
            $product_type=ELECTRONICS;
        }
        elseif($cat->product_type==BAGS){
            $product_type=BAGS;
        }
        else{
            $product_type=GIFTSCARDS;
        }
        $sql = "SELECT id AS pid, sequence FROM products WHERE status = 1 AND product_type = $product_type AND id IN(SELECT pid FROM products_categories WHERE cid = $id) LIMIT $offset, $show_per_page";
        $this ->data['products'] = $this -> db -> query($sql) -> result();
            //echo $this->db->last_query();die;
        $tot = "SELECT id AS pid, sequence FROM products WHERE status = 1 AND product_type = $product_type AND id IN(SELECT pid FROM products_categories WHERE cid = $id)";
        $total = $this -> db -> query($tot) -> num_rows();
        //echo count($total);
        //$this ->data['products'] = $this-> Search_model -> category($id);
        if($cat->product_type==OFFICEPRODUCTS){
            $this->data['main'] = 'office-category';
        }
        elseif($cat->product_type==COMPUTERS){
            $this->data['main'] = 'tech-category';
        }
        elseif($cat->product_type==HOMEKITCHEN){
            $this->data['main'] = 'home-category';
        }
        elseif($cat->product_type==CLOTHINGS){
            $this->data['main'] = 'product-categories';
            $results = $this-> Search_model -> search_clothe($id, $show_per_page, $offset);
            $this->data['products'] = $results['results'];
            $total = $results['total'];
        }
        elseif($cat->product_type==BOOKS){
            $this->data['main'] = 'book-categories';
        }
        elseif($cat->product_type==ELECTRONICS){
            $this->data['main'] = 'mobile-category';
        }
        elseif($cat->product_type==BAGS){
            $this->data['main'] = 'bags';
        }
        else{
            $this->data['main'] = 'gift-category';
        }
        $config = array();
        $config['base_url'] = site_url($slug.'/'.$cat->id);
        $config['num_links'] = 1;
        //$config['uri_segment'] = 2;
        $config['total_rows'] = $total;
        $config['per_page'] = $show_per_page;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm custom-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link'] = '<i class="fa fa-chevron-left"></i> First Page';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last Page <i class="fa fa-chevron-right"></i>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa-chevron-left"></i> <span>Previous Page</span>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '<span>Next Page</span> <i class="fa fa-chevron-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></b></li>';
        $config['use_page_numbers'] = true;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);

        $this->data['paginate'] = $this->pagination->create_links();
        $this->load->view('default', $this->data);
    }

    /*function categories($slug, $id)
    {
        $column = '';
        $cat = $this->Category_model->getRow($id);
        if(count($cat) > 0){
            $this->data['seo_title'] = $cat->seo_title;
            $this->data['seo_description'] = $cat->seo_description;
            $this->data['seo_keywords'] = $cat->seo_keywords;
        }
        $this->data['category'] = $cat;

        if(!empty($_GET['page'])){
            $id = $_GET['id'];
            $cat = $this->Category_model->getRow($id);
            if($cat->product_type==OFFICEPRODUCTS){
                $this->data['main'] = 'office-category';
                $column = 3;
            }
            elseif($cat->product_type==COMPUTERS){
                $this->data['main'] = 'tech-category';
                $column = 3;
            }
            elseif($cat->product_type==HOMEKITCHEN){
                $this->data['main'] = 'home-category';
                $column = 3;
            }
            elseif($cat->product_type==CLOTHINGS){
                $this->data['main'] = 'product-categories';
                $column = 4;
            }
            elseif($cat->product_type==BOOKS){
                $this->data['main'] = 'book-categories';
                $column = 4;
            }
            elseif($cat->product_type==ELECTRONICS){
                $this->data['main'] = 'mobile-category';
                $column = 3;
            }
            else{
                $this->data['main'] = 'gift-category';
                $column = 3;
            }

            $start = ($this->input->get("page") - 1 ) * $this->perPage;
            $sql = "SELECT id AS pid, sequence FROM products WHERE status = 1 AND id IN(SELECT pid FROM products_categories WHERE cid = $id) LIMIT $start, $this->perPage";

            $this ->data['products'] = $this -> db -> query($sql) -> result();
            //echo $this -> db -> last_query(); echo "<br/>";
            if(is_array($this ->data['products']) && count($this -> data['products']) > 0){
                $i=0;
                foreach($this -> data['products'] as $row){ $i++;
                    $p = array();
                    $p['pid'] = $row -> pid;
                    ?>
                    <div class="col-sm-6 col-md-<?= $column; ?>">
                        <?php echo $this -> load -> view('single-product', $p, true); ?>
                    </div>
                    <?php
                    if($cat->product_type==CLOTHINGS || $cat->product_type==BOOKS){
                        if($i==3){
                            ?>
                            <div class="clearfix"></div>
                            <?php $i=0;
                        }
                    }
                    else{
                        if($i==4){
                            ?>
                            <div class="clearfix"></div>
                            <?php $i=0;
                        }
                    }

                }
            }
            else{
                echo '1';
            }
        }else{
            $sql = "SELECT * FROM(SELECT id AS pid, sequence FROM products WHERE status = 1 AND id IN(SELECT pid FROM products_categories WHERE cid = $id) ORDER BY RAND() LIMIT $this->perPage) u ORDER BY sequence";
            $this ->data['products'] = $this -> db -> query($sql) -> result();
            //echo $this -> db -> last_query();
            if($cat->product_type==OFFICEPRODUCTS){
                $this->data['main'] = 'office-category';
            }
            elseif($cat->product_type==COMPUTERS){
                $this->data['main'] = 'tech-category';
            }
            elseif($cat->product_type==HOMEKITCHEN){
                $this->data['main'] = 'home-category';
            }
            elseif($cat->product_type==CLOTHINGS){
                $this->data['main'] = 'product-categories';

            }
            elseif($cat->product_type==BOOKS){
                $this->data['main'] = 'book-categories';
            }
            elseif($cat->product_type==ELECTRONICS){
                $this->data['main'] = 'mobile-category';
            }
            else{
                $this->data['main'] = 'gift-category';
            }
            $this->load->view('default', $this -> data);
        }
    }*/

    function product_details($slug, $id)
    {
        $seo = $this -> Product_model -> getRow($id);
        if(count($seo) > 0){
            $this -> data['seo_title'] = $seo -> meta_title;
            $this -> data['seo_description'] = $seo -> meta_description;
            $this -> data['seo_keywords'] = $seo -> meta_keywords;
        }

        $this->data['history'] = '';
        if ($this->input->cookie("aldivo")) {
            $d = get_cookie("aldivo");
            $d = json_decode($d);
            $this->data['history'] = $d;
            if (!in_array($id, $d)) {
                $d[] = $id;
                $str = json_encode($d);
                set_cookie("aldivo", $str, time() + 3600);
            }
        } else {
            $arr = array();
            $arr[] = $id;
            $str = json_encode($arr);
            set_cookie("aldivo", $str, time() + 3600);
        }

        $p = $this->Product_model->getProduct($id);
        if(count($p) == 0){
            redirect('store');
        }
        if ($p->status == 0) {
            $this->session->set_flashdata("error", "Product unavailable");
            redirect(site_url());
        }
        $this->data['p'] = $p;
        $ptype = $p->product_type;
        if ($ptype == '3') {
            $this->data['main'] = 'product-details';
        }
        elseif($ptype==OFFICEPRODUCTS){
            $this -> data['main'] = 'office-product-details.php';
        }
        elseif($ptype==HOMEKITCHEN){
            $this -> data['main'] = 'home-product-details.php';
        }
        elseif($ptype==COMPUTERS){
            $this -> data['main'] = 'tech-product-details.php';
        }
        elseif($ptype==BOOKS){
            $this -> data['main'] = 'book-details.php';
        }
        elseif($ptype==BAGS){
            $this -> data['main'] = 'bag-details.php';
        }else {
            $this->data['main'] = 'mobile-details';
        }
        $this->load->view('default', $this->data);
    }


    function fanbook($offset = 1)
    {
        $seo = $this -> db -> get_where('seo_url',array('url'=>'http://localhost/aldivo/fanbooks-reviews'))->row();
        if(is_object($seo)){
            $this->data['seo_title'] = $seo -> seo_title;
            $this->data['seo_description'] = $seo -> seo_description;
            $this->data['seo_keywords'] = $seo -> seo_keywords;
        }
        $fb = $this->input->post('fb_search');
        $this->load->model("Fanbook_model");
        $this->data['main'] = 'fanbook';
        $this->data['per_page'] = 20;
        $offset = ($offset - 1) * $this->data['per_page'];
        $data_arr = $this->Fanbook_model->getAllActive($offset, $this->data['per_page'], 'fanbook');
        if ($fb) {
            $sq = array(
                'title' => $fb,
                'short_info' => $fb
            );
            $data_arr = $this->Fanbook_model->getAllSearchedActive($offset, $this->data['per_page'], $sq, 'fanbook');
        }
        $this->data['fanlist'] = $data_arr['results'];
        $config = array();
        $config['base_url'] = site_url('store/fanbook');
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $data_arr['total'];
        $config['per_page'] = $this->data['per_page'];
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
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
        $config['cur_tag_close'] = '</a></b></li>';
        $config['use_page_numbers'] = true;

        $this->pagination->initialize($config);

        $this->data['paginate'] = $this->pagination->create_links();
        $this->load->view("default", $this->data);
    }

    /*public function category($brand_id)
    {
        $this->data['main'] = 'mobile-category';
        $this->data['brand'] = $this->Mobile_model->brand($brand_id);
        $b = $this -> Master_model -> getRow($brand_id,'mobile_brand');
        $this->data['seo_title'] = $b -> seo_title;
        $this->data['seo_description'] = $b -> seo_description;
        $this->data['seo_keywords'] = $b -> seo_keywords;
        $this->data['models'] = $this->Mobile_model->allMobile($brand_id);
        $this->load->view("default", $this->data);
    }*/
    public function category($brand)
    {
        $this->data['main'] = 'mobile-category';
        $this->data['brand'] = $brand;
        $brand_id = $this -> Mobile_model -> get_brands_id($brand);
        $this->data['brand'] = $this->Mobile_model->brand($brand_id);
        $b = $this -> Master_model -> getRow($brand_id,'mobile_brand');
        $this->data['seo_title'] = $b -> seo_title;
        $this->data['seo_description'] = $b -> seo_description;
        $this->data['seo_keywords'] = $b -> seo_keywords;
        $this->data['models'] = $this->Mobile_model->allMobile($brand_id);
        $this->load->view("default", $this->data);
    }

    public function allBrand()
    {
        $this->data['seo_title'] = "Mobile Covers & Cases |  Buy Printed Mobile Covers | ALDIVO.com";
        $this->data['seo_description'] = "Mobile Covers - Printed Mobile Back Covers Online . Designer Mobile Covers for all Smartphones are available. Best Price, Fast Delivery.";
        $this -> data['seo_keywords'] = "Mobile Phone Covers, Mobile Phone Cases, Mobile Covers, Make Your own Mobile Covers, Buy Phone Covers Online, Printed Phone Covers , Customized mobile cover";
        $this->data['main'] = 'brand';
        $this->data['brand'] = $this->Mobile_model->allBrands();
        //$this->data['models'] = $this -> Mobile_model -> allMobile($brand_id);
        $this->load->view("default", $this->data);
    }

    public function campus()
    {
        $this->data['seo_title'] = "";
        $this->data['seo_description'] = "";
        $this -> data['seo_keywords'] = "";
        $this->data['main'] = 'campus';
        $this->data['brand'] = $this->Master_model->listAll('campus');
        //$this->data['models'] = $this -> Mobile_model -> allMobile($brand_id);
        $this->load->view("default", $this->data);
    }

    function get_models($brand_id)
    {
        echo(json_encode($this->Mobile_model->get_models_by_brands($brand_id)));
    }

    function franchisee()
    {
        $seo = $this -> db -> get_where('seo_url',array('url'=>'http://localhost/aldivo/fanbooks-reviews'))->row();
        if(is_object($seo)){
            $this->data['seo_title'] = $seo -> seo_title;
            $this->data['seo_description'] = $seo -> seo_description;
            $this->data['seo_keywords'] = $seo -> seo_keywords;
        }
        $this->load->model('City_model');
        $this->data['main'] = 'franchisee';
        $this->data['state'] = $this->City_model->getStates();
        $this->load->view('default', $this->data);
    }

    function add_franchisee($id = false)
    {
        $seo = $this -> db -> get_where('seo_url',array('url'=>'http://localhost/aldivo/fanbooks-reviews'))->row();
        if(is_object($seo)){
            $this->data['seo_title'] = $seo -> seo_title;
            $this->data['seo_description'] = $seo -> seo_description;
            $this->data['seo_keywords'] = $seo -> seo_keywords;
        }
        $this->data['franchisee'] = $this->Master_model->getNew('franchisee');
        $this->data['id'] = $id;
        if ($id) {
            $this->data['franchisee'] = $this->Master_model->getRow($id, 'franchisee');
        }
        $s = $this->input->post('data');
        $s['id'] = $id;
        $this->Master_model->save($s);
        $this->session->set_flashdata('success', 'Request Submitted successfully');
        redirect(site_url('store/franchisee/' . $id));
    }

    function coupon()
    {
        $seo = $this -> db -> get_where('seo_url',array('url'=>'http://localhost/aldivo/fanbooks-reviews'))->row();
        if(is_object($seo)){
            $this->data['seo_title'] = $seo -> seo_title;
            $this->data['seo_description'] = $seo -> seo_description;
            $this->data['seo_keywords'] = $seo -> seo_keywords;
        }
        $this->load->model('Coupons_model');
        $this->data['main'] = 'coupon';
        $this->data['coupon'] = $this->Coupons_model->allCoupons();
        //echo $this -> db -> last_query();
        $this->load->view('default', $this->data);
    }

    public function officeProduct()
    {
        $this->data['seo_title'] = "Buy Office Product online: Aldivo";
        $this->data['seo_description'] = "Any type of office product is available";
        $this->data['main'] = 'office-product';
        $this->data['category'] = $this->Category_model->allCat(OFFICEPRODUCTS);
        $this->load->view("default", $this->data);
    }

    public function giftProduct()
    {
        $this->data['seo_title'] = "Buy Gifts Items online @ aldivo.com";
        $this->data['seo_description'] = "Buy gifts online for your mom, dad, brother, sister , wife, husband, girlfriend, boyfriend, him,
her for occasions like festival , birthday, wedding anniversary, Send Online Gifts to India";
        $this -> data['seo_keywords'] = "buy gifts, online gifts, send online gifts,
online gifts india, Gift Ideas, Send gifts to india, gifts to india,
Gift for men, Gift for friends, gift for wedding, Gift for women,
Gift for wife, Gift for husband, gifts for brother, gifts for sister";
        $this->data['main'] = 'gift-product';

        $this -> data['category'] = $this -> Master_model -> listAllSequence('ai_event');
        if(isset($_GET['event_a'])){
            if($_GET['event_a']){
                $event = ucwords(str_replace("-", " ", $_GET['event_a']));
                $id = $this -> Category_model -> getIdByEvent($event);
                $this -> db -> where('product_type!='.ELECTRONICS);
                $this -> db -> where('event', $id);
                $this -> db -> order_by('sequence', 'DESC');
                $this -> data['products'] = $this -> db -> get('products')->result();
            }
        }

        if(isset($_GET['mobile_search'])){
            if(isset($_GET['event'])){
                if($_GET['event']!==''){
                    $event = ucwords(str_replace("-", " ", $_GET['event']));
                    $id = $this -> Category_model -> getIdByEvent($event);
                    $this -> db -> where('event', $id);
                    //$this -> db -> where('event',$_GET['event']);
                }
            }
            if(isset($_GET['brand_id'])){
                if($_GET['brand_id']!==''){
                    $this -> db -> where('brand_id', $_GET['brand_id']);
                }
                if($_GET['models']!==''){
                    $this -> db -> where('models', $_GET['models']);
                }
            }
            $this -> db -> order_by('sequence', 'DESC');
            $this -> data['products'] = $this -> db -> get('products')->result();
            $this -> data['searched'] = 1;
        }
        if(isset($_GET['event_search'])){
            $event = ucwords(str_replace("-", " ", $_GET['event']));
            $id = $this -> Category_model -> getIdByEvent($event);
            $this -> db -> where('product_type!='.ELECTRONICS);
            $this -> db -> where('event', $id);
            $this -> db -> order_by('sequence', 'DESC');
            $this -> data['products'] = $this -> db -> get('products')->result();
            $this -> data['searched'] = 2;
            //echo $this -> db -> last_query();
        }

        $this->load->view("default", $this->data);
    }

    public function offerproduct()
    {
        $this->data['seo_title'] = "Buy Offers Item online @ aldivo.com";
        $this->data['seo_description'] = "";
        $this -> data['seo_keywords'] = "";
        $this->data['main'] = 'offer-product';
        $this->data['category'] = '';

        $this->db->select('id');
        $p = $this->db->get_where('products', array('offer' => 1))->result();
        $c = '';
        if(is_array($p) && count($p) > 0)
        {
            foreach($p as $r)
            {
               $c .= $r->id.', ';
            }
            $c = trim($c, ', ');
        }

        if($c != '')
        {
            $sql = 'SELECT DISTINCT(cid) FROM products_categories WHERE pid IN (' .$c.') AND cid != 0';
            $this -> data['category'] = $this->db->query($sql)->result_array();
        }

        if(isset($_GET['offer_a']))
        {
            $cid = $_GET['offer_a'];
            $sql = 'select id from products_categories inner join products on products_categories.pid = products.id where cid = '.$cid.' and offer = 1';
            $this -> data['products'] = $this->db->query($sql)->result();
        }

        if(isset($_GET['mobile_search'])){
            if(isset($_GET['brand_id'])){
                if($_GET['brand_id']!==''){
                    $this -> db -> where('brand_id', $_GET['brand_id']);
                }
                if($_GET['models']!==''){
                    $this -> db -> where('models', $_GET['models']);
                }
            }
            $this -> db -> order_by('sequence', 'DESC');
            $this->db->where('offer', 1);
            $this -> data['products'] = $this -> db -> get('products')->result();
            $this -> data['searched'] = 1;
        }

        $this->load->view("default", $this->data);
    }

    public function giftredirect(){
        $event = $_GET['event'];
        $brand_id = $_GET['brand_id'];
        $models = $_GET['models'];
        $event_name = $this -> db -> get_where('ai_event', array('id'=>$event))->row()->event_name;
        $event1 = strtolower(str_replace(" ", "-", $event_name));
        $url = site_url('gifts/'.$event1.'?brand_id='.$brand_id.'&models='.$models);
        redirect($url);
    }

    public function giftPlist($event_name=false)
    {
        $this->data['seo_title'] = "Buy Gifts Items online @ aldivo.com";
        $this->data['seo_description'] = "Buy gifts online for your mom, dad, brother, sister , wife, husband, girlfriend, boyfriend, him,
her for occasions like festival , birthday, wedding anniversary, Send Online Gifts to India";
        $this -> data['seo_keywords'] = "buy gifts, online gifts, send online gifts,
online gifts india, Gift Ideas, Send gifts to india, gifts to india,
Gift for men, Gift for friends, gift for wedding, Gift for women,
Gift for wife, Gift for husband, gifts for brother, gifts for sister";

        $this->data['main'] = 'gift-category';
        $this -> data['category'] = $this -> Master_model -> listAll('ai_event');

        if($event_name){
            $event = ucwords(str_replace("-", " ", $event_name));
            $id = $this -> Category_model -> getIdByEvent($event);
            $this -> db -> where('event', $id);
        }
        $this -> db -> where('product_type!='.ELECTRONICS);

        /*if(isset($_GET)){
            foreach($_GET as $key => $val){
                if($val!=''){
                    $this -> db -> or_where($key, $val);
                }
            }
        }
        if(!isset($_GET['brand_id']) || $_GET['brand_id']==''){
            $this -> db -> where('product_type!=',ELECTRONICS);
        }*/
        $this -> db -> order_by('sequence', 'random');
        $this -> db -> limit(200);
        $this -> data['products'] = $this -> db -> get('products')->result();
        //echo $this -> db -> last_query();
        $this->load->view("default", $this->data);
    }

    public function home_accessories()
    {
        $this->data['seo_title'] = "Buy Home Accessories online: Aldivo";
        $this->data['seo_description'] = "Any type of Home Accessories is available";
        $this->data['main'] = 'home-product';
        $this->data['category'] = $this->Category_model->allCat(HOMEKITCHEN);

        $this->load->view("default", $this->data);
    }

    public function bags_n_travel()
    {
        $this->data['seo_title'] = "Buy Bags online: Aldivo";
        $this->data['seo_description'] = "Any type of Bags is available";
        $this->data['main'] = 'tech-product';
        $this->data['page_title'] = 'BAGS & TRAVEL';
        $this->data['page_image'] = 'bags';
        $this->data['image_alt'] = 'BAGS & TRAVEL';
        $this->data['category'] = $this->Category_model->allCat(BAGS);
        $this->load->view("default", $this->data);
    }

    public function tech_accessories()
    {
        $this->data['seo_title'] = "Buy Tech Accessories online: Aldivo";
        $this->data['seo_description'] = "Any type of Tech Accessories is available";
        $this->data['main'] = 'tech-product';
        $this->data['page_title'] = 'Tech Accessories';
        $this->data['page_image'] = 'tech_accessories';
        $this->data['image_alt'] = 'Tech Accessories';
        $this->data['category'] = $this->Category_model->allCat(COMPUTERS);
        $this->load->view("default", $this->data);
    }

    public function clothing()
    {
        $cat = $this -> Category_model -> getRow(82);
        if(count($cat) > 0){
            $this->data['seo_title'] = $cat->seo_title;
            $this->data['seo_description'] = $cat->seo_description;
            $this -> data['seo_keywords'] = $cat->seo_keywords;
        }
        /*$data = $this->db->get_where('seo_url', array('url' => current_url()));
        if($data->num_rows() > 0)
        {
            $seo = $data->first_row();
            $this->data['seo_title'] = $seo->seo_title;
            $this->data['seo_description'] = $seo->seo_description;
            $this -> data['seo_keywords'] = $seo->seo_keywords;
        }*/
        $this->data['main'] = 'clothings';
        //$this->data['category'] = $this->Category_model->categories(82, CLOTHINGS);
        $this->data['category'] = $this->Category_model->allCat(CLOTHINGS);
        //echo $this->db->last_query();die;
        //print_r($this -> data['category']);
        $this->load->view("default", $this->data);
    }

    public function mens_collection()
    {
        $cat = $this -> Category_model -> getRow(83);
        if(count($cat) > 0){
            $this->data['seo_title'] = $cat->seo_title;
            $this->data['seo_description'] = $cat->seo_description;
            $this -> data['seo_keywords'] = $cat->seo_keywords;
        }
        $this->data['main'] = 'mens-collection';
        $this->data['category'] = $this->Category_model->categories(83, CLOTHINGS);
        //print_r($this -> data['category']);
        $this->load->view("default", $this->data);
    }

    public function womens_collection()
    {
        $cat = $this -> Category_model -> getRow(85);
        if(count($cat) > 0){
            $this->data['seo_title'] = $cat->seo_title;
            $this->data['seo_description'] = $cat->seo_description;
            $this -> data['seo_keywords'] = $cat->seo_keywords;
        }
        $this->data['main'] = 'womens-collection';
        $this->data['category'] = $this->Category_model->categories(85, CLOTHINGS);
        //print_r($this -> data['category']);
        $this->load->view("default", $this->data);
    }

    public function kids_collection()
    {
        $cat = $this -> Category_model -> getRow(87);
        if(count($cat) > 0){
            $this->data['seo_title'] = $cat->seo_title;
            $this->data['seo_description'] = $cat->seo_description;
            $this -> data['seo_keywords'] = $cat->seo_keywords;
        }
        $this->data['main'] = 'kids-collection';
        $this->data['category'] = $this->Category_model->categories(87, CLOTHINGS);
        //print_r($this -> data['category']);
        $this->load->view("default", $this->data);
    }

    public function books()
    {
        $cat = $this -> Category_model -> getRow(59);
        if(count($cat) > 0){
            $this->data['seo_title'] = $cat->seo_title;
            $this->data['seo_description'] = $cat->seo_description;
            $this -> data['seo_keywords'] = $cat->seo_keywords;
        }
        $this->data['main'] = 'books-collection';
        $this->data['category'] = $this->Category_model->categories(59, BOOKS);
        //print_r($this -> data['category']);
        $this->load->view("default", $this->data);
    }

    function search(){
        $this->data['main'] = 'search-all';
        $this->data['paginate'] = false;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $show_per_page = 32;
        $offset = ($page - 1) * $show_per_page;
        //$data = $this->Product_model->getAll($show_per_page, $offset);
        $q = $this->input->get('q');
        if ($q !== "") {
            if ($q <> '') {
                $likes = array(
                    'ptitle' => $q
                );
                $data = $this->Product_model->getAllSearched($offset, $show_per_page, $likes);
            }
        }
        $this->data['products'] = $data['results'];
        $config['base_url'] = site_url('store/search');
        $config['num_links'] = 2;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $data['total'];
        $config['per_page'] = $show_per_page;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm custom-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link'] = '<i class="fa fa-chevron-left"></i> First Page';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last Page <i class="fa fa-chevron-right"></i>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa-chevron-left"></i> <span>Previous Page</span>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '<span>Next Page</span> <i class="fa fa-chevron-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['use_page_numbers'] = true;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);
        $this->data['paginate'] = $this->pagination->create_links();
        $this->load->view('default', $this->data);
    }
}
