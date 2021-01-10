<?php

function admin_url($file = '', $redirect = false){
	$CI =& get_instance();
	$f = $CI -> config -> item('admin_folder');
	$url = site_url($f) . '/';
    $params   = $_SERVER['QUERY_STRING'];
	if($file <> ''){
		$url .= $file;
	}
	if($redirect){
		$cur = urlencode(current_url().'?'.$params);
		$url .= '?redirect_to=' . $cur;
	}
	return $url;
}

    function isLogin(){
        if(isset($_SESSION['login']) && $_SESSION['login']){
            return true;
        }
        else
        {
            return false;
        }
    }

    function user_id(){
        if(isset($_SESSION['login']) && $_SESSION['login']){
            return $_SESSION['login']['user_id'];
        }
    }

function admin_view($view = ''){
	$CI = & get_instance();
	$f = $CI -> config -> item('admin_folder');
	return $f . '/' . $view;
}

function inr_rs($amt){
	return ' <i class="fa fa-inr"></i> ' . number_format($amt, 2);
}

function upload_dir($view = ''){
	$CI = & get_instance();
	$f = $CI -> config -> item('upload_folder');
	return $f . '/' . $view;
}

function theme_option($optname){
	$CI = & get_instance();
	$v = $CI -> Setting_model -> get_option_value($optname);
	return $v;
}

function typeStr($id){
    $str = '';
    switch($id){
        case CLOTHINGS:
            $str = "Clothings";
            break;
        case ELECTRONICS:
            $str = "Electronics and Mobile";
            break;
        case BAGS:
            $str = "Bags";
            break;
        case BOOKS:
            $str = "Books";
            break;
        case COMPUTERS:
            $str = "Computers";
            break;
        case HOMEKITCHEN:
            $str = "Home & Kitchen";
            break;
        case OFFICEPRODUCTS:
            $str = "Office Products";
            break;
        case TOYSGAMES:
            $str = "Toys & Games";
            break;
        case GIFTSCARDS:
            $str = "Games & Toys";
            break;

    }
    return $str;
}
function myurl(){
    $get = $_GET;
    // $str = '';
    // foreach($get as $k => $v){
    //     $str .= $k .'=' . $v . '&';
    // }
    // $str = rtrim($str, '&');
    $url = current_url() ;
    return $url;
}

function sendSMS($to, $msg){
   $msg = urlencode($msg);
   $senderid = "RAEESW";    
   $url = "http://sms.originitsolution.com/http-tokenkeyapi.php?authentic-key=38327261656573776f726c643834321537423623&senderid=$senderid&route=1&number=$to&message=$msg";
   $ch = curl_init();
   curl_setopt($ch,CURLOPT_URL,$url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $output = curl_exec ($ch);
   curl_close ($ch);
}
// function sendSMS($to, $msg){
//     $msg = urlencode($msg);
// 	$url = 'http://sms.originitsolution.com/http-api.php?username=osgmark&password=hello@123&senderid=OSGMKT&route=1&number='.$to.'&message=' .$msg;
//     //echo $url = 'http://sms.originitsolution.com/http-api.php?username=aldivo&password=@#aldiv123&senderid=ALDIVO&route=1&number='.$to.'&message='.$msg;
//     $ch = curl_init();
//     curl_setopt($ch,CURLOPT_URL,$url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     $output = curl_exec ($ch);
//     curl_close ($ch);
// }

function permalink($slug, $id, $product_type = false)
{
    $link = site_url('products/' . $slug . '/' . $id);
    if($product_type == OFFICEPRODUCTS){
        $link = site_url('notebooks-and-diaries/' . $slug . '/' . $id);
    }
    return $link;
}


function get_array($data)
{
    $data = explode(',', $data);
    return($data);
}

