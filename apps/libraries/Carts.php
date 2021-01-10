<?php

class Carts{

	function __construct(){
		$CI =& get_instance();
		$CI -> load -> library('session');
	}
	function cartPrice(){
		$CI =& get_instance();
		$carts = $CI -> session -> userdata('cart');

	}
}
