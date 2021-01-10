<?php

class Menu extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');
        $this->data['active_tabs'] = 'media';
        $role = $this->session->userdata('role');
        if (!$role == 1) {
            redirect(admin_url('users/login'));
        }
    }

    public function index()
    {
        $this->data['main'] = admin_view('menu/menu-group');
        $this->data['menu_group'] = $this->Menu_model->all_groups();
        $this->load->view(admin_view('default'), $this->data);
    }

    public function group($id = false)
    {
        $this->data['main'] = admin_view('menu/group');
        $this->data['menu'] = $this->Menu_model->getNew('menugroup');
        if ($id) {
            $this->data['menu'] = $this->Menu_model->getRow($id, 'menugroup');
        }
        $this->form_validation->set_rules('m[group_name]', 'Group name', 'trim|required|max_length[80]');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view(admin_view('default'), $this->data);
        } else {
            $save = $this->input->post('m');
            $save['id'] = $id;
            $this->Menu_model->groupadd($save);
            $this->session->set_flashdata('success', 'Menu Group updated');
            redirect(admin_url('menu'));
        }
    }

    function delgroup($id)
    {
        $this->Menu_model->deleteGroup($id);
        $this->session->set_flashdata('success', 'Menu Group Deleted Successfully');
        redirect(admin_url('menu'));
    }

    public function addlink($group_id)
    {
        $config = array();
        $config['upload_path'] = upload_dir();
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $this -> load -> library('upload', $config);
        $this->data['main'] = admin_view('menu/add-link');
        $this->data['menu_group'] = $this->Menu_model->all_groups();
        $this->data['parents'] = $this->Menu_model->get_links($group_id);
        $this->data['category_dd'] = $this->Category_model->category_dropdown();
        $this->data['page_dd'] = $this->Post_model->get_page_dd();
        $this->data['post_dd'] = $this->Post_model->get_post_dd();
        $this->data['group_id'] = $group_id;

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('menu_title', 'Menu Title', 'required');
            if ($this->input->post('link_type') == 1) {
                $this->form_validation->set_rules('link_url', 'URL', 'required');
            }
            if ($this->form_validation->run() == FALSE) {
                $this->load->view(admin_view('default'), $this->data);
            } else {
                $menu = array();
                $menu['id'] = false;
                $menu['group_id'] = $this->input->post('group_id');
                $menu['menu_title'] = $this->input->post('menu_title');
                $menu['menu_parent'] = $this->input->post('menu_parent');
                $menu['sequence'] = $this->input->post('sequence');
                $menu['link_type'] = $this->input->post('link_type');
                $menu['menu_url'] = $this->input->post('menu_url');
                if ($this->input->post('link_type') != 1) {
                    $menu['menu_url'] = $this->input->post('link_hid');
                } else {
                    $menu['menu_url'] = $this->input->post('link_url');
                }
                $menu['target'] = $this->input->post('target');
                $menu['target'] = 0;
                if ($this->input->post('target')) {
                    $menu['target'] = 1;
                }
                $menu['use_heading'] = $this->input->post('use_heading') ? 1 : 0;
                $uploaded = $this -> upload -> do_upload('image');
                if($uploaded){
                    $menu['image'] = $this -> upload -> data('file_name');
                }
                $menu['description'] = $this -> input -> post('description');
                $this->Menu_model->save($menu);
                $this->session->set_flashdata('success', 'Menu item added successfully');
                redirect(admin_url('menu'), 'refresh');
            }
        } else {
            $this->load->view(admin_view('default'), $this->data);
        }
    }

    public function editlink($linkid = false)
    {
        $config = array();
        $config['upload_path'] = upload_dir();
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $this -> load -> library('upload', $config);
        $this->data['main'] = admin_view('menu/edit-link');
        $this->data['menu'] = $menu_group = $this->Menu_model->get_menu($linkid);
        $this->data['menu_group'] = $this->Menu_model->all_groups();
        $this->data['parents'] = $this->Menu_model->get_links($menu_group['group_id']);
        $this->data['category_dd'] = $this->Category_model->category_dropdown();
        $this->data['page_dd'] = $this->Post_model->get_page_dd();
        $this->data['post_dd'] = $this->Post_model->get_post_dd();
        $this->data['group_id'] = $menu_group['group_id'];

        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('menu_title', 'Menu Title', 'required');
            if ($this->input->post('link_type') == 1) {
                $this->form_validation->set_rules('link_url', 'URL', 'required');
            }
            if ($this->form_validation->run() == FALSE) {
                $this->load->view(admin_view('default'), $this->data);
            } else {

                $menu['id'] = $linkid;
                $menu['group_id'] = $this->input->post('group_id');
                $menu['menu_title'] = $this->input->post('menu_title');
                $menu['menu_parent'] = $this->input->post('parent_id');
                $menu['sequence'] = $this->input->post('sequence');
                $menu['link_type'] = $this->input->post('link_type');
                $menu['menu_url'] = $this->input->post('link_url');
                $linktype = $this->input->post('link_type');
                if ($linktype == 1) {
                    $menu['menu_url'] = $this->input->post('link_url');
                } elseif ($linktype == 2) {
                    $menu['menu_url'] = $this->input->post('category_dd');
                } elseif ($linktype == 3) {
                    $menu['menu_url'] = $this->input->post('page_dd');
                } elseif ($linktype == 4) {
                    $menu['menu_url'] = $this->input->post('post_dd');
                } else {
                    $menu['menu_url'] = site_url();
                }
                $menu['target'] = $this->input->post('target');
                $menu['target'] = 0;
                if ($this->input->post('target')) {
                    $menu['target'] = 1;
                }
                $menu['use_heading'] = $this->input->post('use_heading') ? 1 : 0;
                $uploaded = $this -> upload -> do_upload('image');
                if($uploaded){
                    $menu['image'] = $this -> upload -> data('file_name');
                }
                $menu['description'] = $this -> input -> post('description');
                $this->Menu_model->save($menu);
                $this->session->set_flashdata('success', 'Menu item added successfully');
                redirect(admin_url('menu'), 'refresh');
            }
        } else {
            $this->load->view(admin_view('default'), $this->data);
        }
    }

    function deletelink($linkid = false)
    {
        if ($linkid) {
            $this->Menu_model->remove_link($linkid);
            $this->session->set_flashdata('success', 'Menu item removed successfully');
        } else {
            $this->session->set_flashdata('error', 'Please select menu link to delete');
        }
        redirect(admin_url('menu'));
    }

    public function get_link($id)
    {
        $m = $this->Menu_model->get_menu($id);
        $table = '<table class="table table-bordered">';
        $table .= '<tr>';
        $table .= '<td> Menu Title </td>';
        $table .= '<td>' . $m['menu_title'] . '</td>';
        $table .= '</tr>';
        $table .= '<tr>';
        $table .= '<td> Menu Link</td>';
        $table .= '<td><a href="' . $m['link_url'] . '" target="_blank">' . $m['link_url'] . '</a></td>';
        $table .= '</tr>';
        $table .= '<tr>';
        $table .= '<td colspan="2"><a href="' . admin_url('menu/editlink/' . $m['id']) . '" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil"></i> Edit</a> <a href="' . admin_url('menu/deletelink/' . $m['id']) . '" class="btn btn-xs btn-danger delete" onclick="return confirm(\'Are you sure to delete??\');"><i class="glyphicon glyphicon-trash"></i> Delete</a></td>';
        $table .= '</tr>';
        $table .= '</table';
        $output_string = $table;
        echo json_encode($output_string);
    }

    public function get_menu($id)
    {
        $group_id = $id;
        $msg = '';
        $sel = '<select name="parent_id" class="form-control">';
        $sel .= '<option value="0">Top Level</option>';
        $sel .= $this->submenu($id, 0, '', '');
        $sel .= '</select>';
        $output_string = $sel;
        echo json_encode($output_string);
    }

    public function submenu($id, $menu_parent = 0, $msg, $sep)
    {
        $m = $this->Menu_model->get_links($id, $menu_parent);
        if (count($m) > 0) {
            foreach ($m as $menu) {
                $msg .= '<option value="' . $menu['id'] . '">' . $sep . $menu['menu_title'] . '</option>';
                if (count($menu['children']) > 0) {
                    $msg = $this->submenu($id, $menu['id'], $msg, $sep . '&raquo;');
                }
            }
        }
        return $msg;
    }
}
