<?php
class Menu_model extends Master_model{
	function __construct(){
		parent::__construct();
		$this -> table = 'menu';
	}
	public function all_groups(){
		$data = array();
		$rest = $this -> db -> get('menugroup');
		if($rest -> num_rows() > 0){
			foreach($rest -> result_array() as $row){
				$row['links'] = $this -> get_links($row['id']);
				$data[] = $row;
			}
		}
		$rest -> free_result();
		return $data;
	}

    public function hasChild($id){
        return $this -> db -> get_where($this -> table, array('menu_parent'=>$id))->result();
    }
	public function get_links($group_id, $parent = 0){
		$data = array();
		$this -> db -> order_by('sequence', 'ASC');
		$this -> db -> where('group_id', $group_id);
		$this -> db -> where('menu_parent', $parent);
		$rest = $this -> db -> get('menu');
		if($rest -> num_rows() > 0){
			foreach($rest -> result_array() as $row){
				$tmenu = $this -> get_menu($row['id']);
				$row['href'] = $tmenu['link_url'];
				$data[$row['id']] = $row;
				$data[$row['id']]['children'] = $this -> get_links($group_id, $row['id']);
			}
		}
		$rest -> free_result();
		return $data;
	}

	public function get_group($id){
		return $this -> db -> get_where('menugroup', "id = $id") -> first_row('array');
	}
	public function allMenu(){
        return $this->db->get('menu')->result();
    }

    function allMenuGroup($group_id){
        $this -> db -> order_by('sequence', 'ASC');
        return $this->db->get_where('menu', array('group_id'=>$group_id))->result();
    }

	function deleteGroup($id){
		$this -> db -> where('group_id', $id);
		$this -> db -> delete('menu');
		$this -> db -> flush_cache();
		$this -> db -> where('id', $id);
		$this -> db -> delete('menugroup');
	}

    function deleteGroupMenu($id){
        $this -> db -> where('group_id', $id);
        $this -> db -> delete('menu');
        $this -> db -> flush_cache();
        $this -> db -> where('id', $id);
        $this -> db -> delete('menugroup');
    }
	public function get_menu($id){
		$data = $this -> db -> get_where('menu', "id = '$id'") -> first_row('array');
		$slug = $data['menu_url'];
		if($data['link_type'] == 1){ //URL
			$slug = $data['menu_url'];
		}else if($data['link_type'] == 2){ //Category
            if($this -> Category_model -> isExists($data['menu_url'])){
                $cat = new AI_Category($data['menu_url']);
                //print_r($cat);die;
                $slug = $cat -> permalink();
                
            }else{
                $slug = '#';
            }

		}else{ //Pages or Post
			$c = $this -> db -> get_where('post', array('id' => $data['menu_url'])) -> first_row('array');
			$slug = site_url('page/'. $c['slug']);
		}

		$data['link_url'] = $slug;
		return $data;
	}
	public function groupadd($save){
		if($save['id']){
			$this -> db -> where('id', $save['id']);
			$this -> db -> update('menugroup', $save);
			return $save['id'];

		}else{
			$this -> db -> insert('menugroup', $save);
			return $this -> db -> insert_id();
		}
	}

	function remove_link($id){
		$this -> db -> where('id', $id);
		$this -> db -> delete('menu');
	}
	function remove_link_url($link_type, $link_url){
		$this -> db -> where('link_type', $link_type);
		$this -> db -> where('menu_url', $link_url);
		$this -> db -> delete('menu');
		return true;
	}
	function simpleMenu($menu_id, $args = array(), $parent_id = 0, $level = 1){
		$ul_class 	= isset($args['ul_class']) ? $args['ul_class'] : 'menu';
		$sep 		= isset($args['sep']) ? $args['sep'] : false;
		$this -> db -> where('group_id', $menu_id);
		$this -> db -> where('menu_parent', $parent_id);
		$this -> db -> order_by('sequence', 'ASC');
		$rest = $this -> db -> get('menu');
		$data = $rest -> result_array();
		$msg = '';
		if(count($data) > 0){
		         $l = count($data);
	                if($l > 10 && $parent_id > 0){
	                   $noc = ceil($l / 12);
	                   //$ul_class .= ' column' . $noc;
	                }
			//$msg .= '<div class="wrapper"><ul class="'.$ul_class.'">'."\r\n";
			$msg .= '<ul class="'.$ul_class.'">';            
                        //$msg .= '<li><a class="home_icon" href="http://www.aldivo.com"><i class="fa fa-home"></i> </a></li>'."\r\n";
						$msg .= '<li><a class="home_icon" href="http://www.aldivo.com" ><img src="'.base_url('assets/img/aldivo_fo_mobile_category_page.png').'" class="img-responsive logo-img" style="margin-left: 0;"/></a></li>'."\r\n";
						
			foreach($data as $d){
				$m = $this -> get_menu($d['id']);
				$url = $m['link_url'];
                if($m['use_heading'] == 1){
                    $msg .= '<li><h6>'.$d['menu_title'].'</h6>';
                }else{
                    $msg .= '<li><a href="'.$url.'">'.$d['menu_title'].'</a>';
                }
				$args['ul_class'] = 'submenu-simple';
                if($level > 2){
                    $args['ul_class'] = 'submenu-simple';
                }
				//$msg .= $this -> simpleMenu($menu_id, $args, $m['id'], ++$level);
                $msg .= '</li>' . "\r\n";
			}
			
			$msg .= '</ul>'."\r\n";
		}
        $msg .= '';
		return $msg;
	}
    function megaMenu($menu_id, $args = array(), $parent_id = 0, $level = 1){
        $ul_class 	= isset($args['ul_class']) ? $args['ul_class'] : 'menu';
        $sep 		= isset($args['sep']) ? $args['sep'] : false;
        $this -> db -> where('group_id', $menu_id);
        $this -> db -> where('menu_parent', $parent_id);
        $this -> db -> order_by('sequence', 'ASC');
        $rest = $this -> db -> get('menu');
        $data = $rest -> result_array();
        $msg = '';
        if(count($data) > 0){
            $msg .= '<ul class="'.$ul_class.'">
            <li> <a class="bars_icon" href="#">
            <i style="color:#000;" class="fa fa-bars"></i></a></li>
            <li>
            <a class="home_icon" href="#">
            <i class="fa fa-home"></i> </a></li>'."\r\n";
            foreach($data as $d){
                $m = $this -> get_menu($d['id']);
                $url = $m['link_url'];
                if($m['use_heading'] == 1){
                    $msg .= '<li><h6>'.$d['menu_title'].'</h6>';
                }else{
                    $msg .= '<li><a href="'.$url.'">'.$d['menu_title'].'</a>';
                }
                if($m['menu_parent'] == 0){
                    $level = 1;
                }
                $args['ul_class'] = 'menu-' . $level;
                $msg .= $this -> megaMenu($menu_id, $args, $m['id'], ++$level);
                $msg .= '</li>' . "\r\n";
            }
            $msg .= '</ul>'."\r\n";
        }
        return $msg;
    }
	
	function dropDownMenu($menu_id, $args = array(), $parent_id = 0, $level = 1){
	        $ul_class 	= isset($args['ul_class']) ? $args['ul_class'] : 'menu';
	        $sep 		= isset($args['sep']) ? $args['sep'] : false;
	        $this -> db -> where('group_id', $menu_id);
	        $this -> db -> where('menu_parent', $parent_id);
	        $this -> db -> order_by('sequence', 'ASC');
	        $rest = $this -> db -> get('menu');
	        $data = $rest -> result_array();
	        $msg = '';
	        if(count($data) > 0){
	            $msg .= '<ul class="'.$ul_class.'">'."\r\n";
	            foreach($data as $d){
	                $m = $this -> get_menu($d['id']);
	                //print_r($m);
	                $url = $m['link_url'];
	                if($m['use_heading'] == 1){
	                    if(!$m['menu_parent']==0) {
	                        $msg .= '<li class="menu-drop-down2"><img class="menu_image_dropdown" src="' . site_url(upload_dir($m['image'])) . '" /><h6>' . $d['menu_title'] . '</h6>';
	                    }
	                    else{
	                        $msg .= '<li><h6>' . $d['menu_title'] . '</h6>';
	                    }
	                }else{
	                    if(!$m['menu_parent'] ==0) {
	                        $msg .= '<li class="menu-drop-down2"><img class="menu_image_dropdown" src="' . site_url(upload_dir($m['image'])) . '" /><br/><a href="' . $url . '">' . $d['menu_title'] . '</a>';
	                    }
	                    else{
	                        $msg .= '<li><a href="' . $url . '">' . $d['menu_title'] . '</a>';
	                    }
	                }
	                if($m['menu_parent'] == 0){
	                    $level = 1;
	                }
	                $args['ul_class'] = 'menu-' . $level;
	                $msg .= $this -> dropDownMenu($menu_id, $args, $m['id'], ++$level);
	                $msg .= '</li>' . "\r\n";
	            }
	            $msg .= '</ul>'."\r\n";
	        }
	        return $msg;
    }
	
	function megaMenu1($menu_id, $args = array(), $parent_id = 0, $level = 1){
        $ul_class 	= isset($args['ul_class']) ? $args['ul_class'] : 'menu';
        $sep 		= isset($args['sep']) ? $args['sep'] : false;
        $this -> db -> where('group_id', $menu_id);
        $this -> db -> where('menu_parent', $parent_id);
        $this -> db -> order_by('sequence', 'ASC');
        $rest = $this -> db -> get('menu');
        $data = $rest -> result_array();
        $msg = '';
        if(count($data) > 0){
            $msg .= '<ul class="menu-drop-down1 '.$ul_class.'">'."\r\n";

            foreach($data as $d){
                $m = $this -> get_menu($d['id']);
                $url = $m['link_url'];
                if($m['use_heading'] == 1){
                    if(!$m['menu_parent']==0) {
                        //$msg .= '<ul class="menu-drop-down1 '.$ul_class.'">'."\r\n";
                        $msg .= '<li class="menu-drop-down2"><img class="menu_image_dropdown" src="' . site_url(upload_dir($m['image'])) . '" /><h6>' . $d['menu_title'] . '</h6>';
                    }
                    else{
                        $msg .= '<li><h6>' . $d['menu_title'] . '</h6>';
                    }
                }else{
                    if(!$m['menu_parent'] ==0) {
                        $msg .= '<li class="menu-drop-down2"><a href="' . $url . '"><img class="menu_image_dropdown" src="' . site_url(upload_dir($m['image'])) . '" /><br/>' . $d['menu_title'] . '</a>';
                    }
                    else{
                        $msg .= '<li><a href="' . $url . '">' . $d['menu_title'] . '</a>';
                    }
                }
                if($m['menu_parent'] == 0){
                    $level = 1;
                }
                $args['ul_class'] = 'menu-' . $level;
                $msg .= $this -> megaMenu1($menu_id, $args, $m['id'], ++$level);
                $msg .= '</li>' . "\r\n";
            }
            $msg .= '</ul>'."\r\n";
        }
        return $msg;
    }
    
    
}

