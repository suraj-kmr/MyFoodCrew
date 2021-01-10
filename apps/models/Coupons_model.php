<?php
class Coupons_model extends Master_model{

	function __construct(){
		$this -> table = 'coupons';
	}
	
	function allCoupons(){
        return $this->db->get_where($this->table, array('status'=>1, 'visibility'=>0))->result();
    }

    function isExists($cat_id){
        $c = $this -> db -> get_where($this -> table, array('id' => $cat_id)) -> num_rows();
        if($c == 0){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    function validCoupon($coupon){
        $this->db->where('no_of_use >',0);
        $this->db->where('validity >', date('Y-m-d'));
        return $this->db->get_where($this->table, array('status'=>1, 'coupon_code'=>$coupon))->row_array();
    }

    function couponExist($coupon, $user_id){
        $c= $this->db->get_where('user_coupons',array('coupon_code'=>$coupon, 'user_id'=>$user_id))->num_rows();
        if($c ==0){
            return false;
        }
        else{
            return true;
        }
    }

}
