<?php
class Ajax extends AI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this -> load -> model('Mobile_model');
    }

    function checkdelivery()
    {
        $pid = $this->input->post('pid');
        $pin = $this->input->post('pc');

        $pin = intval($pin);
        if ($pin <= 99999) {
            echo '<b class="text-danger">Enter valid pincode</b>';
            return;
        }

        $p = new AI_Product($pid);
        $cats = $this->Setting_model->getPin($pin);
        $cats_arr = array();
        if (is_object($cats) && $cats->categories <> null) {
            $cats_arr = json_decode($cats->categories);
        }
        if (!is_array($cats_arr)) {
            $cats_arr = array();
        }

        $flag = false;
        $cats = $p->categories();
        if (is_array($cats) && count($cats) > 0) {
            foreach ($cats as $cid) {
                if (in_array($cid, $cats_arr)) {
                    $flag = true;
                    break;
                }
            }
        }

            $this->load->model("Ajax_model");
            $flag1 = $this->Ajax_model->check($pin);
			
			if($p->cod_available == 1)
            {
                $flag1 = false;
            }
			
        echo '<b class="text-success" style="color:#1c185f">Prepaid Delivery Eligible</b><i class="fa fa-check" aria-hidden="true" style="color: green"></i>';
            if ($flag1 == true) {
                echo '<br/><b class="text-success" style="color: #1c185f">Cash on Delivery Eligible </b> <i class="fa fa-check" aria-hidden="true" style="color: green"></i>
';
            } else {
                echo '<br/><b class="text-danger" style="color: #1c185f">Cash on Delivery Eligible </b> <i class="fa fa-times" aria-hidden="true" style="color: #ff0000"></i>
';
            }
    }

    function addwishlist($id = false){
        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : site_url();
        if(!$this -> isLoggedIn()){
            $this -> session -> set_userdata('redirect', $redirect);
            $this -> session -> set_flashdata("error", "Please login to add in Wishlist");
            redirect('user/login');
        }
        if($id){
            $data = array();
            $data['pid'] = $id;
            $data['user_id'] = $this -> user_id();
            $data['created'] = date('Y-m-d H:i:s');
            if($this -> User_model -> addWishlistItem($data)){
                $this -> session -> set_flashdata("success", "Item added to your Wishlist");
            }else{
                $this -> session -> set_flashdata("error", "Iteam already in your Wishlist");
            }
        }
        redirect($redirect);
    }

    function delWishlist($id = false){
        //echo $id;
        $redirect = urlencode(site_url('accounts/wishlists'));
        if(!$this -> isLoggedIn()){
            $this -> session -> set_userdata('redirect', $redirect);
            $this -> session -> set_flashdata("error", "Please login to add in Wishlist");
            redirect('user/login');
        }
        if($id){
            $item = $this -> User_model -> itemWishlist($id);
            if($item -> user_id == $this -> user_id()){
                $this -> Master_model -> delete($id, 'ai_wishlist');
                $this -> session -> set_flashdata("success", "Item removed from Wishlist");
            }else{
                $this -> session -> set_flashdata("error", "Opps!! Error. Try again");
            }
        }
        redirect(site_url('accounts/wishlists'));
    }

    function mobile_models(){
        $brand_id = $this -> input -> post('brand_id');
        $m = $this -> Mobile_model -> get_models($brand_id);
        if(is_array($m) && count($m) > 0){ ?>
        <option value="">Select Model</option>
            <?php foreach($m as $id => $title){
                ?>
                <option value="<?= $id; ?>"><?= $title; ?></option>
            <?php
            }
        }
    }

    function sendsms(){
        $data['id'] = $this -> user_id();
        $data['m_verify_code'] = rand(1000, 9999);
        $success = $this->User_model->save($data);
        $u = $this -> Master_model -> getRow($this -> user_id(), "users");
        $mobile = $u -> phone_no;
        $otp = $u -> m_verify_code;
        $msg = "Your Mobile Verification code is : " . $otp;
        //print_r($msg);
        sendSMS($mobile, $msg);
    }

    function search_state(){
        $pincode = $_POST['pincode'];
        $this -> db -> where('pincode', $pincode);
        $res = $this -> db -> get('state_pincode')->row();
        //print_r($res);
        if(is_object($res) && count($res) > 0){
            echo $res -> state;
        }
        else{ echo "Others"; }
    }

    function load_category(){
        $catid = $_POST['cat_id'];
        $data = $this->db->get_where('categories',array('parent_id'=>$catid))->result();
        foreach ($data as $d) {
           echo '<option value="'.$d->id.'">'.$d->name.'</option>';
        }
        //print_r($data);
    }
}

  /*function check_pincode()
  {
      $this -> load-> view('pincode');

      $this -> load -> model("Ajax_model");
      $flag = $this -> Ajax_model -> check(5, 834008);
      if($flag == true){
          echo 'found';
      } else{
          echo 'not found';
      }
  }

}*/

