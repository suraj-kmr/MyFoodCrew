<?php
class Office_model extends Master_model{

	function __construct(){
		parent::__construct();
		$this -> table = 'ai_office';
	}

	function officeId($pid){
    $this -> db -> where('pid',$pid);
    return $this -> db -> get_where($this->table)->row();
}

    function brand($id){
        $this -> db -> where('id',$id);
        return $this -> db -> get_where('ai_obrand')->row();
    }

    function material($id){
        $this -> db -> where('id',$id);
        return $this -> db -> get_where('ai_omaterial')->row();
    }

    function theme($id){
        $this -> db -> where('id',$id);
        return $this -> db -> get_where('ai_otheme')->row();
    }

    function homeId($pid){
        $this -> db -> where('pid',$pid);
        return $this -> db -> get_where('ai_home')->row();
    }

    function hbrand($id){
        $this -> db -> where('id',$id);
        return $this -> db -> get_where('ai_hbrand')->row();
    }

    function hmaterial($id){
        $this -> db -> where('id',$id);
        return $this -> db -> get_where('hmaterial')->row();
    }

    function htheme($id){
        $this -> db -> where('id',$id);
        return $this -> db -> get_where('htheme')->row();
    }

    function techId($pid){
        $this -> db -> where('pid',$pid);
        return $this -> db -> get_where('ai_tech')->row();
    }

    function tbrand($id){
        $this -> db -> where('id',$id);
        return $this -> db -> get_where('tech_brand')->row();
    }

    function tmaterial($id){
        $this -> db -> where('id',$id);
        return $this -> db -> get_where('tech_material')->row();
    }

}
