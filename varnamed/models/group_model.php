<?php
Class Group_model extends CI_Model{
		
	// we will store the group discount formula here
	// and apply it to product prices as they are fetched 
	var $group_discount_formula = false;
	
	function __construct(){
		parent::__construct();
		
		// check for possible group discount 
		$customer = $this->session->userdata('customer');
		if(isset($customer['group_discount_formula'])) 
		{
			$this->group_discount_formula = $customer['group_discount_formula'];
		}
	}

	function product_autocomplete($name, $limit){
		return	$this->db->like('name', $name)->get('products', $limit)->result();
	}
	
	function groups($data=array(), $return_count=false) {

		if(empty($data)) {
			//$this->get_all_products();
		}
		else {
			if(!empty($data['shop_id'])) {
				$this->db->where('shop_id',$data['shop_id']);
			}
			if(!empty($data['rows'])) {
				$this->db->limit($data['rows']);
			}
			if(!empty($data['page'])){
				$this->db->offset($data['page']);
			}
			
			if(!empty($data['order_by'])){
				$this->db->order_by($data['order_by'], $data['sort_order']);
			}

			if(!empty($data['term'])){
				$search	= json_decode($data['term']);
				if(!empty($search->term)){
					$this->db->like('group_name', $search->term);
					$this->db->or_like('group_brand', $search->term);
				}
			}
			if(!empty($data['cat_id'])){
				$this->db->where('cat_id',$data['cat_id']);
			}

			$this->db->where('deleted',1);
			
			if($return_count){
				return $this->db->count_all_results('groups');
			}
			else{
				return $this->db->get('groups')->result();
			}
			
		}
	}
        function get_all_cats($shop_id){
            
                $this->db->where('shop_id', $shop_id);
		$this->db->order_by('name', 'ASC');
		$result	= $this->db->get('categories');
		$return = $result->result_array();
		return $return;
        }

	        function get_all_the_groups(){
		
		$this->db->order_by('group_name', 'ASC');
		$result	= $this->db->get('groups');

		//apply group discount
		$return = $result->result();
		return $return;
	}
        function get_shop_groups($id){
		
                $this->db->where('shop_id', $id);
		$this->db->order_by('group_name', 'ASC');
		$result	= $this->db->get('groups');

		//apply group discount
		$return = $result->result();
		return $return;
	}
        function fetch_all_groups($cat_id,$shop){

			$this->db->where('shop_id', $shop);
			$this->db->where('cat_id', $cat_id);
			$grp = $this->db->get('groups')->result_array();
			return $grp;

	}
        function fetch_all_groups_n($shop){

			$this->db->where('shop_id', $shop);
			$grp = $this->db->get('groups')->result_array();
			return $grp;

	}
        function select_group_id($group){
            
            return $this->db->where('group_name', $group)->get('groups')->result();

        }
/*
        function select_group_id($id){
            
            return $this->db->where('grp_id', $id)->get('products')->result();

        }
 * 
 */
	function get_all_groups(){
		//sort by alphabetically by default
		$this->db->order_by('group_name', 'ASC');
		$result	= $this->db->get('groups');
                
		//apply group discount
		$return = $result->result();
		if($this->group_discount_formula) {
			foreach($return as &$product) {
				eval('$product->price=$product->price'.$this->group_discount_formula.';');
			}
		}
		return $return;
	}
	function get_group($id,$shop_id){

		return $this->db->get_where('groups', array('group_id'=>$id , 'shop_id' => $shop_id))->row();
	}
	function get_groups($category_id = false, $limit = false, $offset = false, $by=false, $sort=false){
		//if we are provided a category_id, then get products according to category
		if ($category_id){
			$this->db->select('category_products.*, LEAST(IFNULL(NULLIF(saleprice, 0), price), price) as sort_price', false)->from('category_products')->join('products', 'category_products.product_id=products.id')->where(array('cat_id'=>$category_id, 'enabled'=>1));
			$this->db->order_by($by, $sort);
			
			$result	= $this->db->limit($limit)->offset($offset)->get()->result();

			$contents	= array();
			$count		= 0;
			foreach ($result as $product){

				$contents[$count]	= $this->get_product($product->product_id);
				$count++;
			}

			return $contents;
		}
		else{
			//sort by alphabetically by default
			$this->db->order_by('name', 'ASC');
			$result	= $this->db->get('products');
			//apply group discount
			$return = $result->result();
			if($this->group_discount_formula) 
			{
				foreach($return as &$product) {
					eval('$product->price=$product->price'.$this->group_discount_formula.';');
				}
			}
			return $return;
		}
	}
	
	function count_all_products(){
		return $this->db->count_all_results('products');
	}
	
	function count_products($id){
		return $this->db->select('product_id')->from('category_products')->join('products', 'category_products.product_id=products.id')->where(array('cat_id'=>$id, 'enabled'=>1))->count_all_results();
	}

	function get_product($id, $related=true){
		$result	= $this->db->get_where('products', array('id'=>$id))->row();
		if(!$result){
			return false;
		}

		$related	= json_decode($result->related_products);
		
		if(!empty($related)){
			//build the where
			$where = false;
			foreach($related as $r){
				if(!$where){
					$this->db->where('id', $r);
				}
				else{
					$this->db->or_where('id', $r);
				}
				$where = true;
			}
		
			$result->related_products	= $this->db->get('products')->result();
		}
		else{
			$result->related_products	= array();
		}
		$result->categories			= $this->get_product_categories($result->id);
	
		// group discount?
		if($this->group_discount_formula) {
			eval('$result->price=$result->price'.$this->group_discount_formula.';');
		}

		return $result;
	}

	function get_product_categories($id){
		return $this->db->where('product_id', $id)->join('categories', 'cat_id = categories.id')->get('category_products')->result();
	}

	function get_slug($id){
		return $this->db->get_where('products', array('id'=>$id))->row()->slug;
	}

	function check_slug($str, $id=false){
		$this->db->select('slug');
		$this->db->from('products');
		$this->db->where('slug', $str);
		if ($id){
			$this->db->where('id !=', $id);
		}
		$count = $this->db->count_all_results();

		if ($count > 0){
			return true;
		}
		else{
			return false;
		}
	}

	function save($group, $options=false, $categories=false) {

            
            if ($group['group_id']){
			$this->db->where('group_id', $group['group_id']);
			$this->db->update('groups', $group);

			$id	= $group['group_id'];
		}
		else {
			$this->db->insert('groups', $group);
			$id	= $this->db->insert_id();
		}

		//loop through the product options and add them to the db
		if($options !== false){
			$obj =& get_instance();
			$obj->load->model('Option_model');

			// wipe the slate
			$obj->Option_model->clear_options($id);

			// save edited values
			$count = 1;
			foreach ($options as $option){

				$values = $option['values'];
				unset($option['values']);
				$option['group_id'] = $id;
				$option['sequence'] = $count;

				$obj->Option_model->save_option($option, $values);
				$count++;
			}
		}
		
		if($categories !== false) {
			if($group['group_id']){
				//get all the categories that the product is in
				$cats	= $this->get_product_categories($id);
				//generate cat_id array
				$ids	= array();
				foreach($cats as $c) {
					$ids[]	= $c->id;
				}

				//eliminate categories that products are no longer in
				foreach($ids as $c){
					if(!in_array($c, $categories)){
						$this->db->delete('category_groups', array('group_id'=>$id,'cat_id'=>$c));
					}
				}
				
				//add products to new categories
				foreach($categories as $c){
					if(!in_array($c, $ids))
					{
						$this->db->insert('category_groups', array('group_id'=>$id,'cat_id'=>$c));
					}
				}
			}
			else{
				//new product add them all
				foreach($categories as $c)
				{
					$this->db->insert('category_groups', array('group_id'=>$id,'cat_id'=>$c));
				}
			}
		}
		
		//return the product id
		return $id;
	}
	
	function delete_group_product($id,$i){


		$this->db->delete('group_products', array('product_id' => $id,'group_id' => $i));
                //$this->db->where('product_id', $i);
		//$this->db->delete('groups');
	}

	function add_product_to_category($product_id, $optionlist_id, $sequence){
		$this->db->insert('product_categories', array('product_id'=>$product_id, 'cat_id'=>$category_id, 'sequence'=>$sequence));
	}

	function search_products($term, $limit=false, $offset=false, $by=false, $sort=false){
		$results		= array();
		
		$this->db->select('*, LEAST(IFNULL(NULLIF(saleprice, 0), price), price) as sort_price', false);
		//this one counts the total number for our pagination
		$this->db->where('enabled', 1);
		$this->db->where('(name LIKE "%'.$term.'%" OR description LIKE "%'.$term.'%" OR excerpt LIKE "%'.$term.'%" OR code LIKE "%'.$term.'%")');
		$results['count']	= $this->db->count_all_results('products');


		$this->db->select('*, LEAST(IFNULL(NULLIF(saleprice, 0), price), price) as sort_price', false);
		//this one gets just the ones we need.
		$this->db->where('enabled', 1);
		$this->db->where('(name LIKE "%'.$term.'%" OR description LIKE "%'.$term.'%" OR excerpt LIKE "%'.$term.'%" OR code LIKE "%'.$term.'%")');
		
		if($by && $sort)
		{
			$this->db->order_by($by, $sort);
		}
		
		$results['products']	= $this->db->get('products', $limit, $offset)->result();
		
		return $results;
	}

	// Build a cart-ready product array
	function get_cart_ready_product($id, $quantity=false)
	{
		$product	= $this->db->get_where('products', array('id'=>$id))->row();
		
		//unset some of the additional fields we don't need to keep
		if(!$product)
		{
			return false;
		}
		
		$product->base_price	= $product->price;
		
		if ($product->saleprice != 0.00)
		{ 
			$product->price	= $product->saleprice;
		}
		
		
		// Some products have n/a quantity, such as downloadables
		//overwrite quantity of the product with quantity requested
		if (!$quantity || $quantity <= 0 || $product->fixed_quantity==1)
		{
			$product->quantity = 1;
		}
		else
		{
			$product->quantity = $quantity;
		}
		
		
		// attach list of associated downloadables
		$product->file_list	= $this->Digital_Product_model->get_associations_by_product($id);
		
		return (array)$product;
	}
        
        public function select_groups($id,$shop){

                return $this->db->where(array('group_id'=>$id,'shop_id'=>$shop))->get('group_products')->result();    

        }
        public function get_current_group($id){
            if(!empty($id)){
                return $this->db->where('group_id', $id)->get('groups')->result();    
            }
            else {
                
            }

        }
        public function select_products($id,$data=array(),$shop){

				$products = array();

				if(!empty($id)){
					foreach($id as $val){

						$products[] = $this->db->where(array('id'=>$val->product_id,'shop_id'=>$shop))->get('products')->row_array();
					}
				}
			
				return $products;
        }
		
		
        public function get_product_group($id){
            if(!empty($id)){
                return $this->db->where('product_id', $id)->get('group_products')->result();    
            }
            else {
                
            }

        }
        
			function save_($data)
				{
					if ($data['group_id'])
					{
						$this->db->where('group_id', $data['group_id']);
						$this->db->update('groups', $data);
						return $data['group_id'];
					}
					else
					{
						$this->db->insert('groups', $data);
						return $this->db->insert_id();
					}
				}
				
			function save_all($data){	
			
			

				
			}
			
			function save_NL($data){
			
					if ($data['group_id']){
					
						$this->db->where('group_id', $data['group_id']);
						$this->db->where('cat_id', $data['cat_id']);
						$this->db->where('shop_id', $data['shop_id']);
						$this->db->update('groups', $data);
						return $data['group_id'];
					}
			}
			
			function save_BE($data){
			
					if ($data['group_id']){
					
						$this->db->where('group_id', $data['group_id']);
						$this->db->where('cat_id', $data['cat_id']);
						$this->db->where('shop_id', $data['shop_id']);
						$this->db->update('groups', $data);
						return $data['group_id'];
					}
			}
        
			function save_BEL($data){
			
					if ($data['group_id']){
					
						$this->db->where('group_id', $data['group_id']);
						$this->db->where('cat_id', $data['cat_id']);
						$this->db->where('shop_id', $data['shop_id']);
						$this->db->update('groups', $data);
						return $data['group_id'];
					}
			}
        
			function save_FR($data){
			
					if ($data['group_id']){
					
						//echo '<pre>';
						//print_r($data);
						//echo '</pre>';
						$this->db->where('group_id', $data['group_id']);
						$this->db->where('cat_id', $data['cat_id']);
						$this->db->where('shop_id', $data['shop_id']);
						$this->db->update('groups', $data);
						return $data['group_id'];
					}
			}
			
			function save_DE($data){
			
					if ($data['group_id']){
					
						$this->db->where('group_id', $data['group_id']);
						$this->db->where('cat_id', $data['cat_id']);
						$this->db->where('shop_id', $data['shop_id']);
						$this->db->update('groups', $data);
						return $data['group_id'];
					}
			}
			
			function save_AU($data){
			
					if ($data['group_id']){
					
						$this->db->where('group_id', $data['group_id']);
						$this->db->where('cat_id', $data['cat_id']);
						$this->db->where('shop_id', $data['shop_id']);
						$this->db->update('groups', $data);
						return $data['group_id'];
					}
			}
			
			function save_LX($data){
			
					if ($data['group_id']){
					
						$this->db->where('group_id', $data['group_id']);
						$this->db->where('cat_id', $data['cat_id']);
						$this->db->where('shop_id', $data['shop_id']);
						$this->db->update('groups', $data);
						return $data['group_id'];
					}
			}
			
			function save_UK($data){
			
					if ($data['group_id']){
					
						$this->db->where('group_id', $data['group_id']);
						$this->db->where('cat_id', $data['cat_id']);
						$this->db->where('shop_id', $data['shop_id']);
						$this->db->update('groups', $data);
						return $data['group_id'];
					}
			}
			
			function delete_group($id,$shop){
			
				$this->db->where('group_id',$id);
				$this->db->where('shop_id',$shop);
				
				$this->db->update('groups',array('deleted'=>0));
				
			}
			
			
			function insert_link($data){
			
			
				echo '<pre>';
					print_r($data);
				echo '</pre>';
			
			
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
        
        

}