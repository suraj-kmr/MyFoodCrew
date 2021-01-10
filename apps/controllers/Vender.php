<?php

class Vender extends AI_Controller
{

    // function __construct()
    // {
    //     parent::__construct();
    //     $flag = $this->session->userdata('login');
    //     //print_r($flag);
    //     if($flag == false){
    //         $this -> session -> set_flashdata("error", "Your must login to View this page.");
    //         redirect('login');
    //     }
    //     $this -> data['user'] = $this -> User_model -> getUserById($flag['user_id']);
    // }
   
   
    function vender_product(){
        $this -> data['main'] = 'vender-product';
        $this -> load -> view('default', $this -> data);
    }
    function add_vender_product(){
        $this -> data['main'] = 'add-vender-product';
        $this -> load -> view('default', $this -> data);
    }
    function vender_order(){
        $this -> data['main'] = 'vender-order';
        $this -> load -> view('default', $this -> data);
    }
    function vender_cancel(){
        $this -> data['main'] = 'vender-cancel';
        $this -> load -> view('default', $this -> data);
    }
    function vender_pin(){
        $this -> data['main'] = 'vender-pin';
        $this -> load -> view('default', $this -> data);
    }
    function add_vender_pin(){
        $this -> data['main'] = 'add-vender-pin';
        $this -> load -> view('default', $this -> data);
    }
    function vender_shipping(){
        $this -> data['main'] = 'vender-shipping';
        $this -> load -> view('default', $this -> data);
    }
    function add_vender_shipping(){
        $this -> data['main'] = 'add-vender-shipping';
        $this -> load -> view('default', $this -> data);
    }
    function vender_payout(){
        $this -> data['main'] = 'vender-payout';
        $this -> load -> view('default', $this -> data);
    }
    function vender_profile(){
        $this -> data['main'] = 'vender-profile';
        $this -> load -> view('default', $this -> data);
    }
    function vender_changepassword(){
        $this -> data['main'] = 'vender-changepassword';
        $this -> load -> view('default', $this -> data);
    }
    function vender_logout(){
       
    }
}

?>