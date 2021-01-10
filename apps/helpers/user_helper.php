<?php
class AI_User{
    private $_user_id;
    private $_user;
    public static $_SUPER = 1;
    public static $_ADMIN = 2;
    public static $_AGENT = 3;
    public static $_MEMBER = 4;
    function __construct($user_id){
        $this -> _user_id = $user_id;
        $CI =& get_instance();
        $this -> _user = $CI -> User_model -> getUserById($user_id);
    }

    public static function getUserTypes(){
        $arr = array(
            1 => 'Super Admin',
            2 => 'Admin Staff',
            3 => 'Affiliates',
            4 => 'Member'
        );
        return $arr;
    }

    function ID(){
        return $this -> _user_id;
    }

    function is($type){
        if($this -> getData('user_type') == $type){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public static function typStr($type){
        if($type == self::$_SUPER){
            return 'Super Admin';
        }elseif($type == self::$_ADMIN){
            return 'Admin/Staff';
        }elseif($type == self::$_AGENT){
            return 'Affiliate User';
        }else{
            return 'Member';
        }
    }

    function dashboardUrl(){
        $url = site_url('accounts');
        return $url;
    }

    function getName(){
        return $this -> _user -> first_name . ' ' . $this -> _user -> last_name;
    }

    function getMobile(){
        return $this -> _user -> phone_no;
    }

    function getAddress(){
        return $this -> _user -> address;
    }

    function getCity(){
        return $this -> _user -> city;
    }

    function getEmail(){
        return $this -> _user -> email_id;
    }

    function getData($field){
        if(property_exists($this -> _user, $field)){
            return $this -> _user -> $field;
        }else{
            return false;
        }
    }

    function imgUrl(){
        return base_url(upload_dir($this -> getData('image')));
    }

    function hasData($name){
        if(property_exists($this -> _user, $name)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function __get($name){
        return $this -> _user -> $name;
    }
}
// function fbLikeCount2($id,$access_token){
//     //Request URL
//     $json_url ='https://graph.facebook.com/'.$id.'?fields=fan_count&access_token='.$access_token;
//     $json = file_get_contents($json_url);
//     $json_output = json_decode($json);
//     //Extract the likes count from the JSON object
//     if($json_output->fan_count){
//         return $likes = $json_output->fan_count;
//     }else{
//         return 0;
//     }
// }

function fbLikeCount2($id,$access_token){
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/'.$id.'?fields=fan_count&access_token='.$access_token); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        $result = json_decode($output);
        if($result->fan_count){
            return $likes = $result->fan_count;
        }else{
            return 0;
        }
        curl_close($ch);
    }


function number_format_short( $n, $precision = 1 ) {
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'K';
    } else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } else if ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }
    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ( $precision > 0 ) {
        $dotzero = '.' . str_repeat( '0', $precision );
        $n_format = str_replace( $dotzero, '', $n_format );
    }
    return $n_format . $suffix;
}