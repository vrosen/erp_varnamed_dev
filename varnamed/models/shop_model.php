<?php

class Shop_model extends CI_Model 
{
	function __construct(){
		parent::__construct();
	}
	


	/***************************************************************************************************************/
	function save($shop){ 
            
		if(!$shop['id']) {
			return $this->add_shop($shop);
		} 
		else {
			$this->update_shop($shop['id'], $shop);
			return $shop['id'];
		}
	}
        
	function get_shops() {

		$res = $this->db->get('shops');
		return $res->result();
	}
	
	// get shop details, by id
	function get_shop($id){
		$this->db->where('shop_id', $id);
		$res = $this->db->get('shops');
		return $res->row();
	}
        function get_shopname($id){
            $this->db->select('shop_name');
		$this->db->where('shop_id', $id);
		$res = $this->db->get('shops');
		return $res->row();
	}
        function get_products($shop_id) {
		$this->db->where('shop_id', $shop_id);
		$res = $this->db->get('products');
		return $res->result();
	}
	function get_groups($shop_id) {
		$this->db->where('shop_id', $shop_id);
		$res = $this->db->get('groups');
		return $res->result();
	}
        function get_admins($shop_id) {
		$this->db->where('shop_id', $shop_id);
		$res = $this->db->get('admin');
		return $res->result();
	}
        function get_categories($shop_id) {
		$this->db->where('shop_id', $shop_id);
		$res = $this->db->get('categories');
		return $res->result();
	}
	
	function get_shop_by_code($code){
		$this->db->where('code', $code);
		$res = $this->db->get('shops');
		$return = $res->row_array();
		if(!$return) return false;
		$return['product_list'] = $this->get_product_ids($return['id']);
		return $return;
	}
        
        function add_shop($data) {
		$this->db->insert('shops', $data);
		return $this->db->insert_id();
	}

	function update_shop($id, $data){
		$this->db->where('id', $id);
		$this->db->update('shops', $data);
	}
	
	function delete_shop($id){
		$this->db->where('id', $id);
		$this->db->delete('shops');

		//$this->remove_product($id);
                //$this->remove_group($id);
                //$this->remove_category($id);
	}
    /***************************************************************************************************************/
	// get the next sequence number for a shop products list 
	function get_next_sequence($shop_id)
	{
		$this->db->select_max('sequence');
		$this->db->where('shop_id',$shop_id);
		$res = $this->db->get('shops_products');
		$res = $res->row();
		return $res->sequence + 1;
	}
	
	function check_code($str, $id=false)
	{
		$this->db->select('code');
		$this->db->from('shops');
		$this->db->where('code', $str);
		if ($id)
		{
			$this->db->where('id !=', $id);
		}
		$count = $this->db->count_all_results();
		
		if ($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}



        	// increment shop uses
	function touch_shop($code)
	{
		$this->db->where('code', $code);
		$this->db->set('num_uses','num_uses+1', false);
		$this->db->update('shops');
	}
        
        
        
        
        
	function get_product_ids($shop_id)
	{
		$this->db->select('id');
		$this->db->where('shop_id', $shop_id);
		$res = $this->db->get('products');
		$res = $res->result_array();
		$list = array();
		foreach($res as $item) {
			array_push($list, $item["id"]);	
		}
		return $list;
	}
	
	// set sequence number of product in shop, for re-sorting
	function set_product_sequence($shop_id, $prod_id, $seq)
	{
		$this->db->where(array('shop_id'=>$shop_id, 'product_id'=>$prod_id));
		$this->db->update('shops_products', array('sequence'=>$seq));
	}
	
	
}	