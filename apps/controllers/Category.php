<?php
class Category extends AI_Controller{
	var $category;
	function __construct(){
		parent::__construct();
        $this -> data['categories_arr'] = $this -> Category_model -> get_categories_tierd();
		$this -> data['top_cat'] = $this -> Category_model -> categories(0);
		$this -> data['latest_posts'] = $this -> Ads_model -> latest_ads(10);
		$this -> data['states'] = $this -> City_model -> all_states();
		$this -> load -> model('Breadcrumb_model');
	}

	function index(){
		$this -> data['main'] = 'all-catgories';
        $this -> data['arr_category'] = $this -> Category_model -> get_categories_tierd();
        $this -> data['seo_title'] = 'All categories at Aldivo';
        $this -> load -> view('default', $this -> data);
	}

	function details($slug, $id, $offset = 0){
		$this -> data['__cat_prefix'] = '';
		$this -> data['state_id'] = false;
		$this -> data['city_id'] = false;
        $this -> data['surl'] = 'category/'.$slug;
		$show_per_page = 24;
		$this -> data['main'] = 'category';
		$ct = $this -> category = $this -> Category_model -> get_category($id);

        $this -> data['arr_subcat']         = $this -> Category_model -> categories($ct['id']);
        $this -> data['og_image']           =   base_url('uploads/images/full/'.$ct['image']);
		$this -> data['category'] 			= 	$ct;
		$this -> data['seo_title'] 			= 	str_replace('{$state_city}', $this -> data['__city'], $ct['seo_title']);
		$this -> data['seo_description']	=	str_replace('{$state_city}', $this -> data['__city'], $ct['seo_description']);
		$this -> data['seo_keywords']		=	str_replace('{$state_city}', $this -> data['__city'], $ct['seo_keywords']);
        if($ct['seo_title'] == ''){
            $this -> data['seo_title'] = $ct['name'];
        }
		$this -> data['featured_ads'] 		= $this -> Ads_model -> latest_ads(10, $ct['id'], 1);
		$this -> data['paid_ads']           = $this -> Ads_model -> getPaidAds($ct['id']);
		$ads_arr			 				= $this -> Category_model -> get_category_ads($ct['id'], $offset, $show_per_page);
		$this -> data['ads']				= 	$ads_arr['ads'];
		$this -> data['breadcrumb'] 		=	$this -> Breadcrumb_model -> categoryBreadcrumb($ct['id']);

		$this -> data['featured_cat']       =   $this -> Category_model -> get_featured_categories($ct['id']);
		if(count($this -> data['featured_cat']) == 0){
			//$this -> data['featured_cat'] = $this -> Category_model -> get_featured_categories($ct['parent_id']);
		}

		$this -> data['ads_count'] = $this -> Ads_model -> adsCount($ct['id']);

		$config['base_url'] 	 = site_url($slug . '/cat-' . $id);
		$config['num_links'] 	 = 2;
		$config['uri_segment']	 = 3;
		$config['total_rows']	 = $ads_arr['total'];
		$config['per_page'] 	 = $show_per_page;
		$config['full_tag_open'] = '<ul class="pagination pagination-sm">';
		$config['full_tag_close']= '</ul>';
		$config['num_tag_open']  = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] 	 = 'First';
		$config['first_tag_open']= '<li>';
		$config['first_tag_close']= '</li>';
		$config['last_link'] 	 = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close']= '</li>';
		$config['prev_link'] 	 = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close']= '</li>';
		$config['next_link'] 	 = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close']= '</li>';
		$config['cur_tag_open']	 = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$this->pagination->initialize($config);
		$this -> data['paginate'] 	=  $this->pagination->create_links();
		$this -> load -> view('default', $this -> data);
	}
	function states_details($city_state, $slug, $id, $offset = 0){
        $surl = $city_state . '/'. $slug . '/cat-'.$id;

		$this -> data['__cat_prefix'] = $city_state . '/';

		//Auto detect state
		$state = $this -> City_model -> detectState($city_state);
		if($state == false){
			$city = $this -> City_model -> detectCity($city_state);
			$city_id = $city['id'];
			$state_id = $city['state_id'];
		}else{
			$state_id = $state['id'];
			$city_id = false;
		}
		$this -> data['city_id'] = $city_id;
		$this -> data['state_id'] = $state_id;

		$show_per_page = 24;
		$this -> data['main'] = 'category';
		$ct = $this -> category = $this -> Category_model -> get_category($id);
		$this -> data['paid_ads']           = $this -> Ads_model -> getPaidAds($ct['id']);
        $this -> data['arr_subcat']         = $this -> Category_model -> categories($ct['id']);
        $this -> data['og_image']           =   base_url('uploads/images/full/'.$ct['image']);
		$this -> data['category'] 			= 	$ct;
		$this -> data['seo_title'] 			= 	str_replace('{$state_city}', $this -> data['__city'], $ct['seo_title']);
		$this -> data['seo_description']	=	str_replace('{$state_city}', $this -> data['__city'], $ct['seo_description']);
		$this -> data['seo_keywords']		=	str_replace('{$state_city}', $this -> data['__city'], $ct['seo_keywords']);
        if($ct['seo_title'] == ''){
            $this -> data['seo_title'] = $ct['name'];
        }
		$ads_arr			 				=   $this -> Category_model -> get_category_ads($ct['id'], $offset, $show_per_page, $state_id, $city_id);
		$this -> data['ads']				= 	$ads_arr['ads'];
		$this -> data['breadcrumb'] 		=	$this -> Breadcrumb_model -> categoryBreadcrumb($ct['id']);

		$this -> data['featured_cat']       =   $this -> Category_model -> get_featured_categories($ct['id']);

		$this -> data['ads_count'] = $ads_count = $this -> Ads_model -> adsCount($ct['id'], $state_id, $city_id);

		$config['base_url'] 	 = site_url($surl);
		$config['num_links'] 	 = 3;
		$config['uri_segment']	 = 4;
		$config['total_rows']	 = $ads_count;
		$config['per_page'] 	 = $show_per_page;
		$config['full_tag_open'] = '<ul class="pagination pagination-sm">';
		$config['full_tag_close']= '</ul>';
		$config['num_tag_open']  = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] 	 = 'First';
		$config['first_tag_open']= '<li>';
		$config['first_tag_close']= '</li>';
		$config['last_link'] 	 = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close']= '</li>';
		$config['prev_link'] 	 = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close']= '</li>';
		$config['next_link'] 	 = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close']= '</li>';
		$config['cur_tag_open']	 = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';

		$this -> pagination -> initialize($config);
		$this -> data['paginate'] 	=  $this->pagination->create_links();
		$this -> load -> view('default', $this -> data);
	}
}
