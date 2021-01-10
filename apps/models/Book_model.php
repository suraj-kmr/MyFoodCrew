<?php
class Book_model extends Master_model{

    function __construct(){
        parent::__construct();
        $this -> table = 'ai_author';
    }

    function allAuthor(){
        return $this -> db -> get('ai_author') -> result();
    }

    function allPublisher(){
        return $this -> db -> get('ai_publisher') -> result();
    }

    function titlebyId($pid, $table){
        return $this -> db -> get_where($table, array('id'=>$pid))->row()->title;
    }

    function bookbyPid($pid){
        return $this -> db -> get_where('ai_book', array('pid'=>$pid))->row();
    }

    function relatedProducts($author, $publisher){
        $this -> db -> where('status', 1);
        $this -> db -> where('author', $author);
        $this -> db -> where('product_type', 2);
        $this -> db -> where('publisher', $publisher);
        $this -> db -> limit(12);
        $this -> db -> from('ai_book');
        $this -> db -> join('products', 'products.id=ai_book.pid');
        return $this -> db -> get() -> result();
    }


}