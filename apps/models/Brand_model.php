<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand_model extends Master_model {
    function __construct(){
        parent::__construct();
    }

    function addCloth(){
        $arr_fields = $this -> db -> list_fields('cloths_brand');
        $data = new stdClass();
        foreach($arr_fields as $a){
            $data -> $a = '';
        }
        $data -> id = false;
        $data -> status = 1;
        return $data;
    }

    function saveClothBrands($data){
        if($data['id']){
            $this -> db -> update('cloths_brand', $data, array('id' => $data['id']));
            return $data['id'];
        }else{
            $this -> db -> insert('cloths_brand', $data);
            return $this -> db -> insert_id();
        }
    }

    function addGrocery(){
        $arr_fields = $this -> db -> list_fields('grocery_brand');
        $data = new stdClass();
        foreach($arr_fields as $a){
            $data -> $a = '';
        }
        $data -> id = false;
        $data -> status = 1;
        return $data;
    }

    function saveGroceryBrands($data){
        if($data['id']){
            $this -> db -> update('grocery_brand', $data, array('id' => $data['id']));
            return $data['id'];
        }else{
            $this -> db -> insert('grocery_brand', $data);
            return $this -> db -> insert_id();
        }
    }

    function addHealth(){
        $arr_fields = $this -> db -> list_fields('health_brands');
        $data = new stdClass();
        foreach($arr_fields as $a){
            $data -> $a = '';
        }
        $data -> id = false;
        $data -> status = 1;
        return $data;
    }

    function saveHealthBrands($data){
        if($data['id']){
            $this -> db -> update('health_brands', $data, array('id' => $data['id']));
            return $data['id'];
        }else{
            $this -> db -> insert('health_brands', $data);
            return $this -> db -> insert_id();
        }
    }

    function addMarble(){
        $arr_fields = $this -> db -> list_fields('Marble_brands');
        $data = new stdClass();
        foreach($arr_fields as $a){
            $data -> $a = '';
        }
        $data -> id = false;
        $data -> status = 1;
        return $data;
    }

    function saveMarbleBrands($data){
        if($data['id']){
            $this -> db -> update('marble_brands', $data, array('id' => $data['id']));
            return $data['id'];
        }else{
            $this -> db -> insert('marble_brands', $data);
            return $this -> db -> insert_id();
        }
    }
    
    function addElectronic(){
        $arr_fields = $this -> db -> list_fields('electronic_brands');
        $data = new stdClass();
        foreach($arr_fields as $a){
            $data -> $a = '';
        }
        $data -> id = false;
        $data -> status = 1;
        return $data;
    }
    
    function saveElectronicBrands($data){
        if($data['id']){
            $this -> db -> update('electronic_brands', $data, array('id' => $data['id']));
            return $data['id'];
        }else{
            $this -> db -> insert('electronic_brands', $data);
            return $this -> db -> insert_id();
        }
    }

    
}
