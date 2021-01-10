<?php
class AI_Product{
	var $id;
	private $data;
	function __construct($id){
		$this -> id = $id;
		$CI =& get_instance();
		$this -> data = $CI -> Product_model -> getProduct($id);
        //print_r($this -> data);
		if(!is_object($this -> data)){
			// continue;
		}
	}


	function ID(){
		return $this -> id;
	}

	function permalink(){

		$link = site_url('products/' . $this -> data -> slug . '/' . $this -> ID());
        if($this -> data -> product_type == OFFICEPRODUCTS){
            $link = site_url('notebooks-and-diaries/' . $this -> data -> slug . '/' . $this -> ID());
        }
		return $link;
	}

	function title(){
		return $this -> data -> ptitle;
	}

	function image($size = 'sm', $options = array()){
		$str = '<img src="' . $this -> data -> image . '" alt="' . $this -> title(). '" title = "' . $this -> title() . '" ' . $this -> __arr_to_str($options) . ' />';
		return $str;
	}

	function images(){
		$gal_str = $this -> data -> gallery;
		$gal_arr = explode(',', $gal_str);
		return $gal_arr;
	}

	function sizes(){
		return $this -> data -> sizes;
	}

	private function __arr_to_str($arr){
		$str = '';
		foreach($arr as $key => $value){
			$str .= $key . '="' . $value . '" ';
		}
		return $str;
	}

	function formatPrice(){
		$price = $this -> data -> sale_price;
		return  '<i class="fa fa-inr"></i> ' . $price;
	}

    function __get($key){
        if(property_exists($this -> data, $key)){
            return $this -> data -> $key;
        }else{
            return FALSE;
        }
    }

    function __set($key, $val){
        $this -> data -> $key = $val;
    }

	function price(){
		return $this -> data -> price;
	}

	function salePrice(){
		if($this-> data -> discount_type == 1){
			return ($this -> data -> price - $this -> data -> discount_rate);
		}
		elseif($this-> data -> discount_type == 2){
			return ($this -> data -> price - ($this -> data -> price * $this -> data -> discount_rate)/100);
		}
		else
		{
			return $this -> data -> price;
		}
	}
	
	function shipCharge(){
        return $this -> data -> ship_charge;
    }

	function sku(){
		return $this -> data -> sku;
	}

	function discount(){
        return $this -> data -> discount_type;
    }

    function discountRate(){
        return $this -> data -> discount_rate;
    }

	function categories(){
		return $this -> data -> cats;
	}

    function data($key){
        if(property_exists($this -> data, $key)){
            return $this -> data -> $key;
        }else{
            return false;
        }
    }
}

class AI_Category{
	var $id;
	var $data;
	function __construct($id){
		$this -> id = $id;
		$CI =& get_instance();
		$this -> data = $CI -> Master_model -> getRow($id,'categories');
	}

	function ID(){
		return $this -> id;
	}

	function permalink(){
	    //print_r($this->id);die;
		$link = site_url($this -> data -> slug . '/' . $this -> ID());
		//$link = site_url('collections/' . $this -> data -> slug . '/' . $this -> ID());
		return $link;
	}

	function title(){
		return $this -> data -> name;
	}

	function image($size = 'sm', $options = array()){
		$str = '<img src="' . $this -> data -> image . '" alt="' . $this -> title(). '" title = "' . $this -> title() . '" ' . $this -> __arr_to_str($options) . ' />';
		return $str;
	}

	private function __arr_to_str($arr){
		$str = '';
		foreach($arr as $key => $value){
			$str .= $key . '="' . $value . '" ';
		}
		return $str;
	}
}
