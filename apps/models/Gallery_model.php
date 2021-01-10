<?php
class Gallery_model extends Master_model{
    public function __construct(){
        parent::__construct();
	    $this -> table = 'gallery';
    }
    public function getGalleries(){
        return $this -> db -> get('gallery') -> result();
    }
    public function getImages($gal_id, $limit = false){
	    if($limit){
		    $this -> db -> limit($limit);
	    }
        $this -> db -> order_by('sequence', 'DESC');
        return $this -> db -> get_where('gallery_img', array('gallery_id' => $gal_id)) -> result();
    }

    public function saveImage($save){
        $this -> db -> insert('gallery_img', $save);
    }
    public function getImage($id){
        return $this -> db -> get_where('gallery_img', "id = $id") -> first_row();
    }
    public function save_image($save){
        $this -> db -> where('id', $save['id']);
        $this -> db -> update('gallery_img', $save);
    }

    function bulksave(){
        $url = admin_url('gallery');
        if($this -> input -> post('frmall')) {
            $url = $this -> input -> post('url');
            $pids = $this -> input -> post('pid');
            $sequence = $this -> input -> post('sequence');
            foreach($pids as $id => $val){
                $item = array();
                $item['id'] = $id;
                $item['sequence'] = $sequence[$id];
                $this -> Gallery_model -> save($item);
            }
            $this -> session -> set_flashdata("success", "Bulk Details Updated");
        }
        redirect($url);
    }

}
