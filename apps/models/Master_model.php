<?php
class Master_model extends CI_Model{
    var  $table;

	function __construct(){
		parent::__construct();
	}
	function getNew($table = false){
		if($table){
			$this -> table = $table;
		}
		$f = $this -> db -> list_fields($this -> table);
		$temp = new stdClass();
		$temp -> id = false;
		foreach($f as $fields){
			$temp -> $fields = '';
		}
		return $temp;
	}

	function getRow($id, $table = false){
		if($table){
			$this -> table = $table;
		}
		return $this -> db -> get_where($this -> table, array('id' => $id)) -> first_row();
	}
    function getUseradd($id, $table = false){
        if($table){
            $this -> table = $table;
        }
        return $this -> db -> get_where($this -> table, array('user_id' => $id)) -> first_row();
    }

    function getRow1($pid, $table = false){
        if($table){
            $this -> table = $table;
        }
        return $this -> db -> get_where($this -> table, array('pid' => $pid)) -> first_row();
    }

    function getBookId($pid, $table = false){
        if($table){
            $this -> table = $table;
        }
        return $this -> db -> get_where($this -> table, array('pid' => $pid)) -> first_row();
    }

    function getInvoice($order_id, $table = false){
        if($table){
            $this -> table = $table;
        }
        return $this -> db -> get_where($this -> table, array('order_id' => $order_id)) -> first_row();
    }

	
	function getRowArray($id, $table = false){
        if($table){
            $this -> table = $table;
        }
        return $this -> db -> get_where($this -> table, array('id' => $id)) -> first_row('array');
    }

	function getAll($offset = 0, $limit = 40, $table = false){
		if($table){
			$this -> table = $table;
		}
		$this -> db -> order_by('id', 'DESC');
		$this -> db -> limit($limit, $offset);
		$rest = $this -> db -> get($this -> table);
		$data['results'] = $rest -> result();
		$data['total'] = $this -> db -> get($this -> table) -> num_rows();
		return $data;
	}

	function getAllSearched($offset = 0, $limit = 40, $likes = array(), $table = false){
		if($table){
			$this -> table = $table;
		}
		if(count($likes) > 0){
			foreach($likes as $key => $val){
				$this -> db -> or_like($key, $val);
			}
		}
		$this -> db -> order_by('id', 'DESC');
        $sql = $this -> db -> get_compiled_select($this -> table, false);
		$this -> db -> limit($limit, $offset);
		$rest = $this -> db -> get();
		$data['results'] = $rest -> result();
		$data['total'] = $this -> db -> query($sql) -> num_rows();
		return $data;
	}

    function getAllSearchedWhere($offset = 0, $limit = 40, $likes = array(), $where=array(), $table = false){
        if($table){
            $this -> table = $table;
        }

        if(count($likes) > 0){
            foreach($likes as $key => $val){
                $this -> db -> or_like($key, $val);
            }
        }

        $this -> db -> order_by('id', 'DESC');
        $this -> db -> where($where);
        $sql = $this -> db -> get_compiled_select($this -> table, false);
        $this -> db -> limit($limit, $offset);
        $rest = $this -> db -> get();
        $data['results'] = $rest -> result();
        echo $this -> db -> last_query();
        $data['total'] = $this -> db -> query($sql) -> num_rows();
        return $data;
    }
	
	function getAllActive($offset = 0, $limit = 40, $table = false){
        if($table){
            $this -> table = $table;
        }
        $this -> db -> order_by('id', 'DESC');
        $this -> db -> limit($limit, $offset);
        $this -> db -> where('status', 1);
        $rest = $this -> db -> get($this -> table);
        $data['results'] = $rest -> result();
        $data['total'] = $this -> db -> get($this -> table) -> num_rows();
        return $data;
    }
    
    function getAllSearchedActive($offset = 0, $limit = 40, $likes = array(), $table = false){
		if($table){
			$this -> table = $table;
		}
		if(count($likes) > 0){
			foreach($likes as $key => $val){
				$this -> db -> or_like($key, $val);
			}
		}
		$this -> db -> order_by('id', 'DESC');
		$this -> db -> where('status', 1);
        $sql = $this -> db -> get_compiled_select($this -> table, false);
		$this -> db -> limit($limit, $offset);
		$rest = $this -> db -> get();
		$data['results'] = $rest -> result();
		$data['total'] = $this -> db -> query($sql) -> num_rows();
		return $data;
	}

    function getWhereRecords($limit = 40, $offset = 0, $rules = array(), $table = false){
        $this -> db -> order_by('id', 'DESC');
        if($table){
            $this -> table = $table;
        }
        if(is_array($rules) && count($rules) > 0){
            foreach($rules as $key => $value){
                $this -> db -> or_where($key, $value);
            }
        }
        $sql = $this -> db -> get_compiled_select($this -> table, false);
        $this -> db -> limit($limit, $offset);
        $rest = $this -> db -> get();
        $data['results'] = $rest -> result();
        $data['total'] = $this -> db -> query($sql) -> num_rows();
        return $data;
    }

    function getWherePtype($limit = 40, $offset = 0, $rules = array(), $product_type, $table = false){
        $this -> db -> order_by('id', 'DESC');
       // $this -> db -> where('product_type', $product_type);
        if($table){
            $this -> table = $table;
        }
        if(is_array($rules) && count($rules) > 0){
            foreach($rules as $key => $value){
                $this -> db -> where($key, $value);
            }
        }
        $sql = $this -> db -> get_compiled_select($this -> table, false);
        $this -> db -> limit($limit, $offset);
        $rest = $this -> db -> get();
        //echo $this -> db -> last_query();
        $data['results'] = $rest -> result();
        $data['total'] = $this -> db -> query($sql) -> num_rows();
        return $data;
    }

	function listAll($table = false){
		if($table){
			$this -> table = $table;
		}
		$rest = $this -> db -> get($this -> table);
		return $rest -> result();
	}

    function listAllSequence($table = false){
        if($table){
            $this -> table = $table;
        }
        $this -> db -> order_by('sequence', 'DESC');
        $rest = $this -> db -> get($this -> table);
        return $rest -> result();
    }

    function listAllWhere($table = false, $where){
        if($table){
            $this -> table = $table;
        }
        $this -> db -> where($where);
        $rest = $this -> db -> get($this -> table);
        return $rest -> result();
    }

	function save($data, $table = false){
		if($table){
			$this -> table = $table;
		}
		if($data['id']){
			$this -> db -> update($this -> table, $data, array('id' => $data['id']));
			return $data['id'];
		}else{
			$this -> db -> insert($this -> table, $data);
			return $this -> db -> insert_id();
		}
	}
    
    function saveWhere($data, $where=false, $table = false){
        if($table){
            $this -> table = $table;
        }
        if($where){
            $this -> db -> update($this -> table, $data, $where);
            return $data['id'];
        }else{
            $this -> db -> insert($this -> table, $data);
            return $this -> db -> insert_id();
        }
    }
	
	function update($data, $table = false, $where=array()){
        if($table){
            $this -> table = $table;
        }
        if($where){
            return $this -> db -> update($this -> table, $data, $where);

        }
    }

	function delete($id, $table = false){
		if($table){
			$this -> table = $table;
		}
		$this -> db -> delete($this -> table, array('id' => $id));
	}

    function deletepcat($id, $table = false){
        if($table){
            $this -> table = $table;
        }
        $this -> db -> delete($this -> table, array('pid' => $id));
    }

	function get_unique_url($url, $id = false){
		$this -> db -> select('slug, id');
		$this -> db -> where('slug', $url);
		$rest = $this -> db -> get($this -> table);
		if($rest -> num_rows() == 0){
			return $url;
		}else{
			$cr = $rest -> first_row();
			if($cr -> id == $id){
				return $url;
			}else{
				$url = $url.'1';
				return $this -> get_unique_url($url, $id);
			}
		}
	}

    function homeRelatedProducts($categories){
        $this -> db -> where('products.status', 1);
        $this -> db -> group_start();
        foreach($categories as $cat){
            $this -> db -> or_where('cid',$cat);
        }
        $this -> db -> group_end();
        $this -> db -> limit(12);
        $this -> db -> from('ai_home');
        $this -> db -> join('products', 'products.id=ai_home.pid');
        return $this -> db -> get() -> result();
        //echo $this -> db -> last_query(); exit;
    }

    function techRelatedProducts($categories){
        $this -> db -> where('products.status', 1);
        $this -> db -> group_start();
        foreach($categories as $cat){
            $this -> db -> or_where('cid',$cat);
        }
        $this -> db -> group_end();
        $this -> db -> limit(12);
        $this -> db -> from('ai_tech');
        $this -> db -> join('products', 'products.id=ai_tech.pid');
        return $this -> db -> get() -> result();
    }

    function officeRelatedProducts($categories){
        $this -> db -> where('products.status', 1);
        //$this -> db -> where('ai_office.brand', $brand);
        //$this -> db -> where('ai_office.theme', $theme);
        $this -> db -> group_start();
        foreach($categories as $cat){
            $this -> db -> or_where('cid',$cat);
        }
        $this -> db -> group_end();
        $this -> db -> limit(12);
        $this -> db -> from('products_categories');
        $this -> db -> join('products', 'products.id=products_categories.pid');
        return $this -> db -> get() -> result();
        //echo $this -> db -> last_query();
    }

    function clotheRelatedProducts($categories){
        $this -> db -> where('products.status', 1);
        $this -> db -> where_in('cid', $categories);
        $this -> db -> from('products_categories');
        $this -> db -> join('products', 'products.id=products_categories.pid');
        $this -> db -> limit(12);
        return $this -> db -> get()->result();
    }

    function relatedProductsAll($categories, $type=false){
        $this -> db -> where('products.status', 1);
        if($type != '')
        {
            $this -> db -> where('products.product_type', $type);
        }
        //$this -> db -> where('ai_office.brand', $brand);
        //$this -> db -> where('ai_office.theme', $theme);
        $this -> db -> group_start();
        foreach($categories as $cat){
            $this -> db -> or_where('cid',$cat);
        }
        $this -> db -> group_end();
        $this -> db -> limit(12);
        $this -> db -> from('products_categories');
        $this -> db -> join('products', 'products.id=products_categories.pid');
        return $this -> db -> get() -> result();
        //echo $this -> db -> last_query();
    }
    public function total(){
            $carts = $this -> session -> userdata('cart');
            $a = 0;
                $b = 0;
                $c = 0;
                $d_type = '';
                $type='';
                $discount = '';
                $coupon_code = '';
                $ship_charge= 0;
                $total = 0;
                $total_amount=0;
                   $rs_total = 0;
                   $ps_total =0;
                        //$sub='';
                if(is_array($carts) && count($carts) > 0){
                    foreach($carts as $citem){
                        $tmp = $citem['pid'];
                        $p = $this->db->get_where('products',array('id'=>$tmp))->row();
                        $subtotal = $citem['qty'] * $citem['price'];
                        $ship_charge += $p->ship_charge ;
                        
                        $coupon_code = $this->session->userdata('coupon_code');
                        $d_type = $this->session->userdata('d_type');
                        $type = $this->session->userdata('type');
                        if($p->discount_type == 1)
                            { 
                                $a = $subtotal - ($p->discount_rate * $citem['qty']);
                                $rs_total =$rs_total + $a;
                            } 
                            elseif($p->discount_type == 2)
                            {
                               $disc = (($subtotal * $p->discount_rate)/100) * $citem['qty'];
                                $b = $subtotal - $disc;
                                $ps_total =$ps_total + $b;
                            } 
                            else
                            {
                                $c;
                            }
                            $total_amount = $rs_total +$ps_total;
                        }
                        $total  = $total_amount;
                }
               return $ship_charge.'-'.$total;
        }



}
