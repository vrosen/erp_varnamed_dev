<?php
Class Product_model extends CI_Model{
		
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

	function product_autocomplete($name, $limit,$shop){
		if($shop == 3){
			return	$this->db->like('code', $name)->where('shop_id','33')->get('products', $limit)->result();
		}
		else {
			return	$this->db->like('code', $name)->where('shop_id',$shop)->get('products')->result();
		}
	}

	function product_autocomplete_supplier($name,$supplier_id,$shop){

			$products = $this->db->where(array('LEVERANCIE'=>$supplier_id,'DELRECORD'=>1,'shop_id'=>$shop))->get('relartikelleverancier')->result();

			//echo '<pre>';
			
			foreach($products as $product){
			
				if(is_numeric($product->ARTIKELCOD)){
					$code = $product->ARTIKELCOD.'/';
				}else{
					$code = $product->ARTIKELCOD;
				}
				
				$array_codes[] = $this->db->where('code', $code)->where('shop_id',$shop)->get('products')->result_array();
			}
			return $array_codes;
			
			//print_r($array_codes);
			//echo '</pre>';
	}
	
	function product_array($id,$shop){

			return	$this->db->like('id', $id)->where('shop_id',$shop)->get('products')->result();

	}

	function get_vat($code,$shop,$vat){

		return	$this->db->select($vat)->like('code', $code)->where('shop_id',$shop)->get('products')->row();
	}

	
	
	function products($data=array(),$cat,$grp,$shop, $return_count=false) {
	

			if(!empty($shop)) {
					if($shop == 3 ){
						$this->db->where('shop_id',33);
					}
					else {
						$this->db->where('shop_id',$shop);
				}
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
			

			if(!empty($cat)){
				$this->db->where('cat_id',$cat);
			}

			if(!empty($grp)){
				$this->db->where('grp_id',$grp);
			}
			
			$this->db->where('deleted',1);
			

				return $this->db->get('products')->result();
			

	}

	function countProducts($data,$cat,$grp,$shop) {
	

			if(!empty($shop)) {
					if($shop == 3 ){
						$this->db->where('shop_id',33);
					}
					else {
						$this->db->where('shop_id',$shop);
				}
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
			
			if(!empty($cat)){
				$this->db->where('cat_id',$cat);
			}

			if(!empty($grp)){
				$this->db->where('grp_id',$grp);
			}
			
			$this->db->where('deleted',1);
			
			return $this->db->count_all_results('products');

	}
	
	
	function get_all_products(){
		//sort by alphabetically by default
		$this->db->order_by('name', 'ASC');
		$result	= $this->db->get('products');
                
		//apply group discount
	$return = $result->result();
	/*		if($this->group_discount_formula) {
			foreach($return as &$product) {
				eval('$product->price=$product->price'.$this->group_discount_formula.';');
			}
		} */
		return $return;
	}
	
	function get_products($category_id = false, $limit = false, $offset = false, $by=false, $sort=false){
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
	function get_product_available_stock($data){
            
		return $this->db->where('code', $data['code'])->get('products')->row();
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
		return $this->db->where('product_id', $id)->join('categories', 'category_id = categories.id')->get('category_products')->result();
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

	
		function save_($product){
	
				if ($product['id']){
					$this->db->where('id', $product['id']);
					$this->db->update('products', $product);

					$id	= $product['id'];
				}
				else {
					$this->db->insert('products', $product);
					$id	= $this->db->insert_id();
				}

				if($options !== false){
				
					$obj =& get_instance();
					$obj->load->model('Option_model');

					$obj->Option_model->clear_options($id);

					$count = 1;
					foreach ($options as $option){

					$values = $option['values'];
					unset($option['values']);
					$option['product_id'] = $id;
					$option['sequence'] = $count;

					$obj->Option_model->save_option($option, $values);
					$count++;
				
				}
			}
			return $id;
		}
	
	
	
	
	
	
	function save($product, $options=false, $categories=false,$g_id) {
		
            if ($product['id']){
			$this->db->where('id', $product['id']);
			$this->db->update('products', $product);

			$id	= $product['id'];
		}
		else {
			$this->db->insert('products', $product);
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
				$option['product_id'] = $id;
				$option['sequence'] = $count;

				$obj->Option_model->save_option($option, $values);
				$count++;
			}
		}
                if(!empty($g_id)){
                
                        $gr = array('group_id'=>$g_id);
                        $this->db->where('product_id', $product['id']);
						$this->db->update('group_products', $gr);

                }
                else {
                    $this->db->insert('group_products', array('product_id'=>$id,'group_id'=>$g_id)); 
                }
		
                
		if($categories !== false) {
			if($product['id']){
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
						$this->db->delete('category_products', array('product_id'=>$id,'cat_id'=>$c));
					}
				}
				
				//add products to new categories
				foreach($categories as $c){
					if(!in_array($c, $ids))
					{
						$this->db->insert('category_products', array('product_id'=>$id,'cat_id'=>$c));
					}
				}
			}
			else{
				//new product add them all
				foreach($categories as $c)
				{
					$this->db->insert('category_products', array('product_id'=>$id,'cat_id'=>$c));
				}
			}
		}
		
		//return the product id
		return $id;
	}
	
	function delete_product($id){
		// delete product 
		$this->db->where('id', $id);
		$this->db->delete('products');

		//delete references in the product to category table
		$this->db->where('product_id', $id);
		$this->db->delete('category_products');
		
		// delete coupon reference
		$this->db->where('product_id', $id);
		$this->db->delete('coupons_products');

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
        public function remove_products($group_id,$enabled){

        $results =  $this->db->where('group_id', $group_id)->get('group_products')->result();
        foreach ($results as $result){
            $data = array(
               'enabled' => $enabled,
            );
            
            $this->db->where('id', $result->product_id);
            $this->db->update('products', $data);
        }

        }

		
        public function hide_products($group_id,$shop){

        $results =  $this->db->where(array('group_id'=>$group_id,'shop_id'=>$shop))->get('group_products')->result();
        foreach ($results as $result){
            $data = array(
               'deleted' => 2,
            );
            
            $this->db->where('id', $result->product_id);
            $this->db->update('products', $data);
        }

        }
		
		
		
		
        function get_order_product($shop_id,$id,$index){
                
     
            switch ($index) {
				case 'DE':
					$this->db->select(array('id','package_details','saleprice_DE','name_DE','vat_DE','warehouse_price','available_stock'));
				break;
				case 'NL':
					$this->db->select(array('id','package_details','saleprice_NL','name_NL','vat_NL','warehouse_price','available_stock'));
					break;
				case 'AU':
					$this->db->select(array('id','package_details','saleprice_AU','name_AU','vat_AU','warehouse_price','available_stock'));
					break;
				case 'AT':
					$this->db->select(array('id','package_details','saleprice_AU','name_AU','vat_AU','warehouse_price','available_stock'));
					break;
				case 'FR':
					$this->db->select(array('id','package_details','saleprice_FR','name_FR','vat_FR','warehouse_price','available_stock'));
					break;  
				case 'BE':
					$this->db->select(array('id','package_details','saleprice_BE','name_BE','vat_BE','warehouse_price','available_stock'));
					break;
				case 'UK':
					$this->db->select(array('id','package_details','saleprice_UK','name_UK','vat_UK','warehouse_price','available_stock'));
					break;
				case 'LX':
					$this->db->select(array('id','package_details','saleprice_LX','name_LX','vat_LX','warehouse_price','available_stock'));
					break;
				case 'BEL':
					$this->db->select(array('id','package_details','saleprice_BE','name_BEL','vat_BE','warehouse_price','available_stock'));
					break;
            }

         return $this->db->where(array('shop_id'=> $shop_id))->like('code',(string)$id)->get('products')->row();

	
}
	function get_new_order_product($shop_id,$id,$index){
                
     
            switch ($index) {
				case 'DE':
					$this->db->select(array('id','package_details','saleprice_DE','name_DE','vat_DE','warehouse_price','available_stock'));
				break;
				case 'NL':
					$this->db->select(array('id','package_details','saleprice_NL','name_NL','vat_NL','warehouse_price','available_stock'));
					break;
				case 'AU':
					$this->db->select(array('id','package_details','saleprice_AU','name_AU','vat_AU','warehouse_price','available_stock'));
					break;
				case 'AT':
					$this->db->select(array('id','package_details','saleprice_AU','name_AU','vat_AU','warehouse_price','available_stock'));
					break;
				case 'FR':
					$this->db->select(array('id','package_details','saleprice_FR','name_FR','vat_FR','warehouse_price','available_stock'));
					break;  
				case 'BE':
					$this->db->select(array('id','package_details','saleprice_BE','name_BE','vat_BE','warehouse_price','available_stock'));
					break;
				case 'UK':
					$this->db->select(array('id','package_details','saleprice_UK','name_UK','vat_UK','warehouse_price','available_stock'));
					break;
				case 'LX':
					$this->db->select(array('id','package_details','saleprice_LX','name_LX','vat_LX','warehouse_price','available_stock'));
					break;
				case 'BEL':
					$this->db->select(array('id','package_details','saleprice_BE','name_BEL','vat_BE','warehouse_price','available_stock'));
					break;
            }

         return $this->db->where(array('shop_id'=> $shop_id))->like('code',(string)$id)->get('products')->row();

	
}

        function get_offers_product($shop_id,$id,$index){
                
     
            switch ($index) {
				case 'DE':
					$this->db->select(array('id','package_details','saleprice_DE','name_DE','vat_DE','warehouse_price','available_stock'));
				break;
				case 'NL':
					$this->db->select(array('id','package_details','saleprice_NL','name_NL','vat_NL','warehouse_price','available_stock'));
					break;
				case 'AU':
					$this->db->select(array('id','package_details','saleprice_AU','name_AU','vat_AU','warehouse_price','available_stock'));
					break;
				case 'AT':
					$this->db->select(array('id','package_details','saleprice_AU','name_AU','vat_AU','warehouse_price','available_stock'));
					break;
				case 'FR':
					$this->db->select(array('id','package_details','saleprice_FR','name_FR','vat_FR','warehouse_price','available_stock'));
					break;  
				case 'BE':
					$this->db->select(array('id','package_details','saleprice_BE','name_BE','vat_BE','warehouse_price','available_stock'));
					break;
				case 'UK':
					$this->db->select(array('id','package_details','saleprice_UK','name_UK','vat_UK','warehouse_price','available_stock'));
					break;
				case 'LX':
					$this->db->select(array('id','package_details','saleprice_LX','name_LX','vat_LX','warehouse_price','available_stock'));
					break;
				case 'BEL':
					$this->db->select(array('id','package_details','saleprice_BE','name_BEL','vat_BE','warehouse_price','available_stock'));
					break;
            }

         return $this->db->where(array('shop_id'=> $shop_id))->like('code',(string)$id)->get('products')->row();

	
}
















        function get_offer_product($shop_id,$id){
            
            
            return $this->db->where(array('shop_id'=> $shop_id,'code'=>$id))->get('products')->row();
            
        }
	function get_product_id($number){
		return $this->db->where('code', $number)->get('products')->result();
	}

	function insert($code,$shop_id,$data){


            $new_arr    = array_combine($code,$data['quantity']);
            $new_arr_1  = array_combine($code,$data['discount']);
            $new_arr_2  = array_combine($code,$data['unit_price']);

            
            foreach ($new_arr as $k=> $v){
            $data = array(
               'quantity' => $v,

            );
            $this->db->where('shop_id', $shop_id);
            $this->db->where('code', $k);
            $this->db->update('products', $data);
            }

            foreach ($new_arr_1 as $k_1=> $v_1){
            $data_1 = array(
               'discount' => $v_1,

            );
            $this->db->where('shop_id', $shop_id);
            $this->db->where('code', $k_1);
            $this->db->update('products', $data_1);
            }
            
            
            foreach ($new_arr_2 as $k_2=> $v_2){
            $data_2 = array(
               'price' => $v_2,

            );
            $this->db->where('shop_id', $shop_id);
            $this->db->where('code', $k_2);
            $this->db->update('products', $data_2);
            }

        }
	function insert_stock($code,$shop_id,$data){


            $new_arr = array_combine($code,$data['quantity']);

            $new_arr_2 = array_combine($code,$data['unit_price']);


            
            foreach ($new_arr as $k=> $v){
            $data = array(
               'quantity' => $v,

            );
            $this->db->where('shop_id', $shop_id);
            $this->db->where('code', $k);
            $this->db->update('products', $data);
            }


            
            foreach ($new_arr_2 as $k_2=> $v_2){
            $data_2 = array(
               'price' => $v_2,

            );
            $this->db->where('shop_id', $shop_id);
            $this->db->where('code', $k_2);
            $this->db->update('products', $data_2);
            }

        }
	function get_product_shop($id){

		return $this->db->where('shop_id', $id)->get('shops')->result();
	}
        function update_warehouse_products($data){

                $data   =   array('available_stock' => $data['new_available_stock']);
		// update or insert
		if(!empty($data['stock_order_id'])){
			$this->db->where('id', $data['product_number']);
			$this->db->update('products', $data);
               }
        }
        function select_order_product($shop_id,$id){
           
         //return $this->db->where(array('shop_id'=> $shop_id,'code'=>$id))->get('products')->row();
    return            $pro = $this->db->where(array('shop_id'=> $shop_id))->like('code',$id)->get('products')->row();

}

	function get_product_warehouse_price($number){
            
		return $this->db->select('warehouse_price')->where('code', $number)->get('products')->row_array();
                
	}
        function check_product($str){
            
            return $this->db->select('code')->like('code', $str)->get('products')->row_array();

        }

        function check_order($str,$code){
            
            return $this->db->select('stock_order_number')->where('code',$code)->like('stock_order_number', $str)->get('warehouse_order_products')->row_array();

        }
           //(select) -> product_number
            //(get_current_quantity) -> product_number
            //(see if the new quantity is more than the current quantity)
            //(if) the current_quantity is < new quantity -> set order quantity of product to the current quantity -> (new_quantity - current_quantity) = backorder_quantity -> send to backorders the backorder_quantity 
            //(if) the current_quantity is > new quantity -> (current_quantity - new quantity)
            //(update the new quantity to the current_quantity)    
            //(update the quantity) -> product_number       

        
            function check_availability($data,$shop_id){

			//print_r($data);
            if(!empty($data)){
                
                    foreach ($data as $value){
  
                    $product_data = $this->check_quantity($value['code'],$shop_id);
					//print_r($product_data);
                    $new_arr[] = array('code'=>$value['code'],'ordered_quantity'=>$value['ordered_quantity'],'warehouse_quantity'=>$product_data['current_quantity']);
                }
				
                $data_arr = array();

                foreach ($new_arr as $h){
                    if($h['ordered_quantity'] > $h['warehouse_quantity']){
                        $backorder_q = $h['ordered_quantity']-$h['warehouse_quantity'];
                        $data_arr[] = array('code'  =>  $h['code'],'backorder_quantity' =>  $backorder_q);
                    }
                }
                return $data_arr;
            }
        }


            function update_product_qunatity($data){

                foreach ($data as $v){
                        
                        $this->db->select_sum('current_quantity');
                        $this->db->select('code');
                        $this->db->where('code',$v['code']);
                        $quantity[] = $this->db->get('warehouse_order_products')->row_array();
                        
				}
                foreach ($data as $value){
                    $new_arr[] = array('code'=>$value['code'],'ordered_quantity'=>$value['quantity']);
                }
                $key = count($new_arr);
                for($i=0;$i<$key;$i++){
                   
                    $prepare_quantity[] = array_merge($quantity[$i],$new_arr[$i]);
                    
                }

                foreach ($prepare_quantity as $j){
                    $final[] = array(
                        'code'  => $j['code'],
                        'quantity'  => $j['current_quantity']-$j['ordered_quantity'],
                    );
                }
                                                echo '<pre>';
                   // print_r($final);
                echo '</pre>';
                
                foreach ($final as $q){

                   $new_data   =   array('quantity' => $q['quantity']);
                   $this->db->where('code', $q['code']);
                   $this->db->update('products', $new_data);
                }
            }
			
			
		function deduct($code){

			$this->db->select('current_quantity,code,reception_date');
			$this->db->where('code',$code);
			//$this->db->like('warehouse_place','buiten');
			$this->db->where('shop_id',$this->data_shop);
			$this->db->where('current_quantity >','0');

			return $this->db->get('warehouse_order_products')->result_array();
		}
			
        function check_quantity($code,$shop_id){

			$this->db->select_sum('current_quantity');
			$this->db->where('code',$code);
			$this->db->where('shop_id',$shop_id);
			//$this->db->not_like('warehouse_place','vast');

			return $this->db->get('warehouse_order_products')->row_array();

        }
        
        function get_id($code,$shop_id){

                if($shop_id == 3){
                    $this->db->where('shop_id',33);
                }
                else {
                    $this->db->where('shop_id',$shop_id);
                }
                
		$this->db->like('code',$code);
               
		return $this->db->get('products')->row();

        
        }
        function get_second_id($code){



		$this->db->like('code',$code);
               
		return $this->db->get('artikel')->row();

        
        }
        function get_old_product($NR){
            
		$this->db->where('NR',$NR);
		return $this->db->get('artikel')->row();
        
        }
        
        function get_suppliers($code){
            
            
            $this->db->join('suppliers', 'relartikelleverancier.LEVERANCIE = suppliers.id');  
            $this->db->where('ARTIKELCOD',$code);
            return $this->db->get('relartikelleverancier')->result();
        }
        function get_supplier_prod($nr,$code){
            
            return $this->db->where(array('ARTIKELCOD'=>$code,'LEVERANCIE'=>$nr))->get('relartikelleverancier')->result_array();

        }
		
		
		function get_backorder_product($shop_id,$id,$order_nr){
                
				$this->db->where('shop_id', $shop_id);
				$this->db->where('order_id', $order_nr);
				$this->db->where('code', $id);
				$this->db->where('BACKORDER', 1);
				return $this->db->get('order_items')->row_array();
		}
		
		
		
		            function check_availability_again($data,$shop_id){

			if(!empty($data)){
                
                    foreach ($data as $value){
  
                    $product_data = $this->check_quantity($value['product_code'],$shop_id);
                    $new_arr[] = array('code'=>$value['product_code'],'backorder_quantity'=>$value['backorder_quantity'],'warehouse_quantity'=>$product_data['current_quantity']);
                }
				
                $data_arr = array();

                foreach ($new_arr as $h){
                    if($h['backorder_quantity'] >= $h['warehouse_quantity']){
					//echo $h['backorder_quantity'];
					//echo $h['warehouse_quantity'];
                        $backorder_q = $h['backorder_quantity']-$h['warehouse_quantity'];
                        $data_arr[] = array('code'  =>  $h['code'],'backorder_quantity' =>  $backorder_q);
                    }
                }
				
             return $data_arr;
            }
        }
		
	function get_country($id){
	
		return $this->db->select('name,tax')->get_where('countries',array('iso_code_2'=>$id))->row();
	
	}
	function update_product_quick($id,$remark,$shop){

		if(!empty($id)){

		$data = array('remarks' => $remark);
		
			$this->db->where('shop_id',$shop);
			$this->db->where('id',$id);
			$this->db->update('products',$data);
		
		}

	}
	
	
	function get_product_details($code,$shop){
	
			$this->db->where('shop_id',$shop);
			$this->db->where('code',$code);
			return $this->db->get('products')->row();
	
	}
	
	function update_products($id,$data,$shop){

		$this->db->where('shop_id',$shop);
		$this->db->where('id',$id);
		$this->db->update('products',$data);
		
	}
	function fetch_all_groups($c,$shop){

			$this->db->where('shop_id', $shop);
			$this->db->where('cat_id', $c);
			$grp = $this->db->get('groups')->result();
			return $grp;

	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
		
		
		
		

}
