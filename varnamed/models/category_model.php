<?php
Class Category_model extends CI_Model
{

	function get_categories($parent = false){
		if ($parent !== false){
			$this->db->where('parent_id', $parent);
		}
                
                //$this->db->where('shop_id', 1);
		$this->db->select('id,shop_id');
		$this->db->order_by('categories.sequence', 'ASC');
		
		//this will alphabetize them if there is no sequence
		$this->db->order_by('id', 'ASC');
                //$this->db->order_by('name', 'ASC');
                
                $result	= $this->db->get('categories');
		
		$categories	= array();
		foreach($result->result() as $cat){
                    
			$categories[]	= $this->get_category($cat->id,$cat->shop_id);
		}
		
		return $categories;
	}
        function get_all_categories(){
		
		$this->db->order_by('name', 'ASC');
		$result	= $this->db->get('categories');

		//apply group discount
		$return = $result->result();
		return $return;
	}
	//this is for building a menu
	function get_categories_tierd($parent=0){

		$categories	= array();
		$result	= $this->get_categories($parent);
		foreach ($result as $category){

			$categories[$category->id]['category']	= $category;
			$categories[$category->id]['children']	= $this->get_categories_tierd($category->id,$category->shop_id);

		}
		return $categories;
	}
	
	function category_autocomplete($name, $limit)
	{
		return	$this->db->like('name', $name)->get('categories', $limit)->result();
	}
	
	function get_category($id,$shop_id){

		return $this->db->get_where('categories', array('id'=>$id , 'shop_id' => $shop_id))->row();
	}
	
	function get_category_products_admin($id)
	{
		$this->db->order_by('sequence', 'ASC');
		$result	= $this->db->get_where('category_products', array('category_id'=>$id));
		$result	= $result->result();
		
		$contents	= array();
		foreach ($result as $product)
		{
			$result2	= $this->db->get_where('products', array('id'=>$product->product_id));
			$result2	= $result2->row();
			
			$contents[]	= $result2;	
		}
		
		return $contents;
	}
		function get_category_groups_admin($id, $shop){
		
		$this->db->order_by('sequence', 'ASC');
                
		$this->db->where('shop_id', $shop);
		$result	= $this->db->get_where('category_groups', array('category_id'=>$id));
		$result	= $result->result();
		
		$contents	= array();
		foreach ($result as $group)
		{
                   
			$contents[]	= $this->db->get_where('groups', array('group_id'=>$group->group_id))->row();
		}
		
		return $contents;
               
	}
	function get_category_products($id, $limit, $offset)
	{
		$this->db->order_by('sequence', 'ASC');
		$result	= $this->db->get_where('category_products', array('category_id'=>$id), $limit, $offset);
		$result	= $result->result();
		
		$contents	= array();
		$count		= 1;
		foreach ($result as $product)
		{
			$result2	= $this->db->get_where('products', array('id'=>$product->product_id));
			$result2	= $result2->row();
			
			$contents[$count]	= $result2;
			$count++;
		}
		
		return $contents;
	}
	
	function organize_contents($id, $groups,$shop)
	{

		//first clear out the contents of the category
		$this->db->where('category_id', $id);
		$this->db->where('shop_id', $shop);
		$this->db->delete('category_groups');
		
		//now loop through the products we have and add them in
		$sequence = 0;
		foreach ($groups as $group)
		{
			$this->db->insert('category_groups', array('category_id'=>$id, 'shop_id'=>$shop,'group_id'=>$group, 'sequence'=>$sequence));
			$sequence++;
		}
	}
	
	function save($category,$shop)
	{
		if ($category['id'])
		{
			$this->db->where('id', $category['id']);
			$this->db->where('shop_id', $shop);
			$this->db->update('categories', $category);
			
			return $category['id'];
		}
		else
		{
			$this->db->insert('categories', $category);
			return $this->db->insert_id();
		}
	}
	
	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('categories');
		
		//delete references to this category in the product to category table
		$this->db->where('category_id', $id);
		$this->db->delete('category_products');
	}
        function get_current_categories($shop_id){
		
        $this->db->where('shop_id', $shop_id);
		$this->db->order_by('sequence', 'ASC');
		$result	= $this->db->get('categories');
		$return = $result->result();
		return $return;
	}
		function get_current_groups($shop_id){
		
        $this->db->where('shop_id', $shop_id);
		$this->db->order_by('group_name', 'ASC');
		$result	= $this->db->get('groups');
		$return = $result->result();
		return $return;
	}
		function get_current_groups_by_cat($shop_id,$cat){
		
        $this->db->where('shop_id', $shop_id);
        $this->db->where('cat_id', $cat);
		$this->db->order_by('group_name', 'ASC');
		$result	= $this->db->get('groups');
		$return = $result->result();
		return $return;
	}
        function get_current_categories_($shop_id){
		
                $this->db->select('id,name');
                $this->db->where('shop_id', $shop_id);
				$this->db->order_by('name', 'ASC');
				$result	= $this->db->get('categories');
                $return = $result->result_array();
                foreach ($return as $v){
                   $n[$v['id']] = array('name'=>$v['name']);
                }
				return $n;
	}
        function get_current_groups_($shop_id){
		
                $this->db->select('group_id,group_name');
                $this->db->where('shop_id', $shop_id);
				$this->db->order_by('group_name', 'ASC');
				$result	= $this->db->get('groups');
                $return = $result->result_array();
                foreach ($return as $v){
                   $n[$v['group_id']] = array('name'=>$v['group_name']);
                }
				return $n;
	}
        
	function get_shop_nationalities($shop){
	
		$this->db->where('shop_id',$shop);
		$shops = $this->db->get('webshops_nationalilty')->result();
		
		foreach($shops as $shop){
			$sh[$shop->country_index] = $shop->country;
		}
		return $sh;
	}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
        
        
}