<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

 	var $is_login;

  	function __construct(){

		parent::__construct();

	    $this->output->nocache ();

	    date_default_timezone_set ('Asia/Kolkata');

        $this -> form_validation->set_error_delimiters('<div>', '</div>');

		$this -> output -> nocache();

		if (!$this->session->userdata('userid')){

			$this -> session -> set_flashdata('errormsg', 'Session out!! Please login agin');

			redirect(admin_url('users/login'), 'refresh');

		}

	    $this -> data['active_tabs'] = 'dashboard';

	    $this -> data['dashboard_title'] = 'Dashboard';

  	}

}

class AI_Controller extends CI_Controller{

	var $data, $login, $email;

	var $user = false;

    var $city = false;

    var $cart = array();

	function __construct(){

		parent::__construct();

        //$this -> load -> model('Mobile_model');

        //$this -> data['all_brands'] = $this -> Mobile_model -> allBrands();

        //print_r($this->data['brands']);

		$this -> output -> nocache();

		$this -> data['seo_title'] = 'OSG Online Store';

		$this -> data['seo_description'] = '';

		$this -> data['seo_keywords'] = '';

		$this -> data['og_image'] = base_url('assets/img/logo.png');



		$this -> data['cart_items'] = $this -> cart_items();

        $this -> cart = $this -> getCart();

	}



	function isLoggedIn(){

		if($this -> session -> has_userdata('login')){

			return true;

		}else{

			return false;

		}

	}



	function cart_items(){

		$c = 0;

		if($this -> session -> has_userdata('cart')){

			$x = $this -> session -> userdata('cart');

			$c = count($x);

		}

		if($c > 0) {

			return '<span class="badge">'.$c.'</span>';

		}else{

			return NULL;

		}

	}



	function user_id(){

		$login = $this -> session -> userdata('login');

		return $login['user_id'];

	}



    private function getCart(){

        $cart = array(

            'items' => 0,

            'total' => 0

        );

        if($this -> session -> has_userdata('cart')){

            $carts = $this -> session -> userdata('cart');

            $items = 0;

            $price = 0;

            if(is_array($carts) && count($carts) > 0){

                foreach($carts as $car){

                    $price += ($car['price'] * $car['qty']);

                    $items += $car['qty'];

                }

            }

            $cart['items'] = $items;

            $cart['total'] = $price;

        }

        return $cart;

    }



    /*function display_models(){

        $this->data['brands'] = $this -> input -> post('frm[brand_id]');

        $this->data['models'] = $this -> input -> post('frm[models]');

        $this -> data['seo_title'] = 'Search Result for Mobile Covers';

        $this -> data['main'] = 'mobile-search-result';

        $this -> data['paginate'] = false;

        $this->data['mobiles'] = $this-> Mobile_model-> product_by_brands_models($this->data['brands'], $this->data['models']);

        //print_r($this->data['mobiles']);

        $this -> load -> view('default', $this -> data);

    }*/

}

