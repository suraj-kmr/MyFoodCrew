<?php
class Categories extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this -> data['active_tabs'] = "catalog";
		$role = $this -> session -> userdata('role');
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
	}

	function index(){

        if(isset($_GET['type']) && $_GET['type'] == 'link')
        {
            $tbl = 'quick_link';
            $url = 'quick-links';
            $this -> data['main'] = admin_view('quick-links/index');

        }else{
            $tbl = 'categories';
            $url = 'categories';
            $this -> data['main'] = admin_view('category/index');


        }

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $show_per_page = 20;
        $offset = ($page - 1 ) * $show_per_page;
        $status = isset($_GET['status']) ? $_GET['status'] : 'all';
        $rule = array();
        if($status == 'active'){
            $rule['status'] = 1;
            $data	= $this -> Category_model -> getWhereRecords($show_per_page, $offset, $rule, $tbl);
        }elseif($status == 'inactive'){
            $rule['status'] = 0;
            $data	= $this -> Category_model -> getWhereRecords($show_per_page, $offset, $rule, $tbl);
        }else{
            $data	= $this -> Category_model -> getWhereRecords($show_per_page, $offset,'', $tbl);
        }

        $this -> data['filter_status'] = $status;
        $this -> data['q'] = '';
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'name' => $q, 'id' => $q
                );
                $data = $this -> Master_model -> getAllSearched($offset, $show_per_page, $likes, $tbl);
                $this -> data['q'] = $q;
            }
        }

		$config['base_url'] 	 = admin_url($url);
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
        echo isset($_GET['type']);die;

		$config['upload_path']		= 'img/uploads';
		$config['allowed_types']	= 'gif|jpg|png|jpeg|bmp';
		$config['max_size']			= '5000';
		$config['max_width']		= '3000';
		$config['max_height']		= '2000';
		$this->load->library('upload', $config);

        if(isset($_GET['type']) && $_GET['type'] == 'link')
        {
            $this -> data['active_tabs'] = "media";
            $tbl = 'quick_link';
            $this -> data['main'] 			= admin_view('quick-links/add');

        }else{
            $tbl = 'categories';
            $this -> data['main'] 			= admin_view('category/add');

        }

		$this -> data['categories']		= $this -> Category_model -> category_dropdown();
		$this -> data['cat'] = $this -> Master_model -> getNew($tbl);
		if($id){
			$this -> data['cat'] = $this->Master_model->getRow($id, $tbl);

            $this->form_validation->set_rules('cat[name]', 'Name', 'trim|required|max_length[64]');
		}
        else {
            if(!isset($_GET['type']))
            {
            $this->form_validation->set_rules('cat[name]', 'Name', 'trim|required|max_length[64]|is_unique[categories.name]');
            }
        }
		$this->form_validation->set_rules('cat[slug]', 'Slug', 'trim');
		$this->form_validation->set_rules('cat[description]', 'Description', 'trim');
		$this->form_validation->set_rules('cat[sequence]', 'Sequence', 'trim|integer');
		$this->form_validation->set_rules('cat[parent_id]', 'Parent id', 'trim');
        $this->form_validation->set_rules('cat[parent_id]', 'Parent id', 'trim');
		if($this -> form_validation -> run()){
			//print_r($_FILES);
			$catdata = $this -> input -> post('cat');
			$catdata['id'] = $id;
			$uploaded	= $this->upload->do_upload('image');
			if ($id){
				if($this -> input -> post('del_image')){
					$img_name = $this -> input -> post('hid_image');
					@unlink('img/products/'.$img_name);
					$catdata['image'] = '';
				}
			}
			if($uploaded)
			{
				$image			= $this->upload->data();
				$catdata['image']	= $image['file_name'];
			}//else{
				//echo $this -> upload -> display_errors();
			//}
			$slug = $this->input->post('slug');
			if(empty($slug) || $slug=='')
			{
				$slug = $this->input->post('cat[name]');
			}
			$slug	= strtolower(url_title($slug));
			$catdata['popular_cat'] = isset($catdata['popular_cat']) ? 1 : 0;
			if($catdata['slug'] == '')
            {
                $catdata['slug'] = $this -> Category_model -> get_unique_url($slug, $id);
            }

			if(isset($_GET['type']) && $_GET['type'] == 'link')
            {
                $id = $this->Master_model->save($catdata, 'quick_link');
                $url = 'categories/add/'.$id.'?type=link';
            }else{
                $id	= $this->Category_model->save($catdata);
                $url = 'categories/add/'.$id;
            }
			$this -> session -> set_flashdata('success', 'Data saved successfully.');
			redirect(admin_url($url));
		}
        else{
			$this -> load -> view(admin_view('default'), $this -> data);
		}
	}

	function activate($id = false){
		$redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('categories');
		if($id){
			$c['id'] = $id;
			$c['status'] = 1;
			$this -> Category_model -> save($c);
			$this -> session -> set_flashdata("success", "Category saved");
		}
		redirect($redirect);
	}

	function deactivate($id = false){
		$redirect = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : admin_url('categories');
		if($id){
			$c['id'] = $id;
			$c['status'] = 0;
			$this -> Category_model -> save($c);
			$this -> session -> set_flashdata("success", "Category saved");
		}
		redirect($redirect);
	}

	public function delete($id){
		if($id > 0){
			if($this -> Category_model -> hasChildren($id)){
				$this -> session -> set_flashdata("error", "Subcategory exists, Please delete them first");
				redirect(admin_url('categories'));
				exit();
			}
            if($this -> Category_model -> hasProduct($id)){
                $this -> session -> set_flashdata("error", "Products exists, Please delete them first");
                redirect(admin_url('categories'));
                exit();
            }
			$data = $this->Category_model-> getRow($id);
			if($data -> image != ''){
				$file = array();
				$file[] = 'uploads/images/full/'.$data -> image;
				foreach($file as $f){
					if(file_exists($f)){
						@unlink($f);
					}
				}
			}
			$this->Category_model->delete($id);
            //Delete from Menu
            $this -> db -> where('link_type', 2);
            $this -> db -> where('menu_url', $id);
            $this -> db -> delete('menu');

			$this -> session -> set_flashdata('success', 'Category deleted successfully');
		}
		redirect(admin_url('categories'));
	}

    public function delete_link($id){
        $this->Master_model->delete($id, 'quick_link');
        $this -> session -> set_flashdata('success', 'Quick Link deleted successfully');
        redirect(admin_url('categories?type=link'));
    }

    function getparentcat(){
        $pid = $this -> input -> post('pid');
        $m = $this->Category_model->category_dropdown1($pid);
        if(is_array($m) && count($m) > 0){ ?>

            <?php foreach($m as $id => $name){
                ?>
                <option value="<?= $id; ?>"><?= $name; ?></option>
            <?php
            }
        }
    }

    function events(){
        $this -> data['main'] = admin_view('category/event');
        $this -> data['events'] = $this -> db -> get('ai_event')->result();
        $this -> load -> view(admin_view('default'), $this -> data);
    }

    function add_event($id=false){
        $config['upload_path']		= 'img/uploads';
        $config['allowed_types']	= 'gif|jpg|png|jpeg|bmp';
        $config['max_size']			= '5000';
        $config['max_width']		= '3000';
        $config['max_height']		= '2000';
        $this->load->library('upload', $config);
        $this -> data['main'] = admin_view('category/add-event');
        $this -> data['cat'] = $this -> Master_model -> getNew('ai_event');
        if($id){
            $this -> data['cat'] = $this -> Master_model -> getRow($id, 'ai_event');
        }
        $this -> form_validation -> set_rules('cat[event_name]', 'Event Name', 'required');
        if($this -> form_validation -> run()){
            $data = $this -> input -> post('cat');
            $data['id'] = $id;
            if($_FILES['image']['name']!==''){
                $uploaded = $this -> upload -> do_upload('image');
                if($uploaded){
                    $image = $this -> upload->data();
                    $data['image'] = $image['file_name'];
                }
            }
            $this -> Master_model -> save($data, 'ai_event');
            $this -> session -> set_flashdata('success', 'Event Submited Successfully');
            redirect(admin_url('categories/add_event'));
        }
        else{
            $this -> load -> view(admin_view('default'), $this -> data);
        }
        //$this -> data['events'] = $this -> db -> get('ai_event')->result();

    }

    function delete_event($id){
        $this -> Master_model -> delete($id, 'ai_event');
        $this -> session -> set_flashdata('error', 'Event Deleted');
        redirect('categories/event');
    }
    




 public function inventory($offset = 0){
        $show_per_page = 40;
       $this -> data['main'] = admin_view('category/inventory');
    
      
        $arr_result = $this -> Product_model -> getAll($offset, $show_per_page);
        if($this -> input -> get('btnsearch')){
            $q = $this -> input -> get('q');
            if($q <> ''){
                $likes = array(
                    'ptitle' => $q, 'id' => $q
                );
                $arr_result = $this -> Product_model -> getAllSearched($offset, $show_per_page, $likes);
            }
        }
        $this -> data['post_list']  = $arr_result['results'];
        $config['base_url']      = admin_url('categories/inventory');
        $config['num_links']     = 2;
        $config['uri_segment']   = 4;
        $config['total_rows']    = $arr_result['total'];
        $config['per_page']      = $show_per_page;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close']= '</ul>';
        $config['num_tag_open']  = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link']    = 'First';
        $config['first_tag_open']= '<li>';
        $config['first_tag_close']= '</li>';
        $config['last_link']     = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close']= '</li>';
        $config['prev_link']     = 'Prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close']= '</li>';
        $config['next_link']     = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close']= '</li>';
        $config['cur_tag_open']  = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['use_page_numbers'] = true;
        $config['use_page_numbers'] = true;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);

        $this -> data['paginate']   =  $this->pagination->create_links();

        $this -> load -> view(admin_view('default'), $this -> data);
    }
    
     function import(){
        $this -> data['main'] = admin_view('category/import');
        if($this -> input -> post('import_btn')){
            $count = 0;
            if($_FILES['excel_file']['name'] <> ''){
                $fn = $_FILES['excel_file']['tmp_name'];
                $file = fopen($fn, "r");
               
                while(($tp = fgetcsv($file, 10000, ",")) !== FALSE){
                    $count++;
                    if($count > 1) {
                         print_r($tp);
                        $this -> check_nd_update($tp);
                        // echo "hi".$this->db->last_query();
                    } 
                }
            }
        }
        $this -> load -> view(admin_view('default'), $this -> data);
    }


     function check_nd_update($tp){
        $data = array();
        $id= $tp[0];

        //$data['id'] = false;
        $data['ptitle']=$tp[1];
         $data['qty']=$tp[2                                                                                                                                                                                ];
       // if($tp[1]==""){
            if($tp[1]=="" && $tp[2]==""){
            $this -> session -> set_flashdata('error', "Product Main Category and a child category must not be blank");
            redirect(admin_url('categorie/import'));
        }
         $c = $this->db->get_where('products', array('id' => $id))->num_rows();
         if($c > 0){
            $this -> db -> update('products', $data, array('id'=>$id));
         }
         else{
             $data['id'] = $id;
        $pid =$this -> db -> insert('products', $data);
    }
        //$cid_exists = $this->Category_model ->get_category_exist($pid, $tp[1]);
       

        $this -> session -> set_flashdata('success', "Data Imported Successfully");
       
    }
    function export()
    { 
        $data['status'] = 1;
        $this -> db -> select('id, ptitle,qty ');
       
            
            //print_r($ids); //exit();
            $this->load->dbutil();
            $this->load->helper('file');
            $this->load->helper('download');
            ini_set('memory_limit','1024M');
            $delimiter = ",";
            $newline = "\r\n";
            $filename = "inventory.csv";
            
            $result = $this -> db -> get('products');
            //$query = "SELECT * FROM products order by id DESC";
            //$result = $this->db->query($query);
            $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
            force_download($filename, $data);
            //$this->Stock_manage_model->ExportCSV();
            redirect(admin_url('categories/inventory'));
            
            $this -> session -> set_flashdata('success', 'Bulk Products exported');
       }
        
    
    

}
