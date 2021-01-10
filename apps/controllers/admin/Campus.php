<?php
class Campus extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this -> load -> helper("file");
        $this -> data['active_tabs'] = 'campus';
        $role = $this -> session -> userdata('role');
        if(!$role==1){
            redirect(admin_url('users/login'));
        }
        //$this -> load -> model(array('Media_model'));
    }


    function index($offset = 1){
        $this -> data['main'] = admin_view('campus/brands-index');
        $this -> data['keyword'] = '';
        $this -> data['per_page'] = 40;

        $offset = ($offset - 1) * $this -> data['per_page'];

        $data_arr = $this -> Master_model -> getAll($offset, $this -> data['per_page'], 'campus');
        $this -> data['data'] = $data_arr['results'];

        $config = array();

        $config['base_url'] = admin_url('campus/brands');
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $data_arr['total'];
        $config['per_page'] = $this -> data['per_page'];
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

        $this -> data['links'] = $this->pagination->create_links();

        $this -> load -> view(admin_view('default'), $this -> data);
    }

    public function addcampus($id = false){
        $config = array();
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 3000;
        $config['upload_path'] = upload_dir();
        $this->load->library('upload', $config);
        //echo upload_dir();
        $this -> data['main'] = 'admin/campus/add-brand';
        $this -> data['brand'] = $this -> Master_model -> getNew('campus');
        if($id){
            $this -> data['brand'] = $this -> Master_model -> getRow($id, 'campus');
            $this -> form_validation -> set_rules("data[title]", "Campus Name", "required");
        }else{
            $this -> form_validation -> set_rules("data[title]", "Campus Name", "required|is_unique[campus.title]", array(
                'is_unique' => 'This Campus Name is already available'
            ));
        }
        if($this -> form_validation -> run()){
            $data = $this -> input -> post('data');
            $uploaded = $this -> upload -> do_upload('image');
            if($uploaded){
                $data['image'] = $this -> upload -> data('file_name');
            }

            $logo = $this -> upload -> do_upload('logo');
            if($logo){
                $data['logo'] = $this -> upload -> data('file_name');
            }

            $data['id'] = $id;
            $id = $this -> Master_model -> save($data, 'campus');
            $this -> session -> set_flashdata('success', "Campus details saved successfully");
            redirect(admin_url('campus/addcampus/'.$id));
        }else{
            $this -> load -> view(admin_view('default'), $this -> data);
        }
    }

    public function delcampus($id = false){
        $data['status'] = 1;
        if($id){
            $this -> db -> delete('campus', array('id' => $id));
            $this -> session -> set_flashdata('success', 'Brand deleted successfully');
        }else{
            $ids = $this -> input -> post('ids');
            if(is_array($ids)){
                foreach($ids as $id){
                    $this -> db -> delete('campus', array('id' => $id));
                }
            }
            $this -> session -> set_flashdata('success', 'Bulk deleted');
        }
        redirect('admin/campus');
    }

}