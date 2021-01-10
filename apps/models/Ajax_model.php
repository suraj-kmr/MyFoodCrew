<?php
class Ajax_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function check($pcode)
    {
        $sql = "SELECT pincodes FROM pincode_cod WHERE id = 1";
        $rest = $this->db->query($sql)->result_array();
        $pin = $rest[0];
        $codes = $pin['pincodes'];
        $arr = explode("\n", $codes);
        $arr1 = explode("\r\n", $codes);
        if(in_array($pcode, $arr) || in_array($pcode, $arr1)){
            return true;
        }else{
            return false;
        }
    }

    /*function check($id, $pcode)
    {
        //$sql = "SELECT pincodes FROM products WHERE id = '$id'";
        $sql = "SELECT pincodes FROM pincode_cod WHERE id = 1";
        $rest = $this->db->query($sql)->result_array();
        $pin = $rest[0];
        $codes = $pin['pincodes'];
        $arr = explode("\r\n", $codes);
        if(in_array($pcode, $arr)){
            return true;
        }else{
            return false;
        }
    }*/
}