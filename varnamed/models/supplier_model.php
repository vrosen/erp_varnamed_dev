<?php
Class Supplier_model extends CI_Model
{

	//this is the expiration for a non-remember session
	var $session_expire	= 7200;
	
	
	function __construct(){
			parent::__construct();
	}
	
	/********************************************************************

	********************************************************************/
	
	function get_suppliers($limit=0, $offset=0, $order_by='id', $direction='DESC',$shop_id){
	
			$this->db->order_by($order_by, $direction);
			$this->db->where('shop_id',$shop_id);
			$this->db->where('active',1);
			
			if($limit>0){
				$this->db->limit($limit, $offset);
			}

			$result	= $this->db->get('suppliers');
			return $result->result();
	}
	
	
	function count_suppliers($limit=0, $offset=0, $order_by='id', $direction='DESC',$shop_id){
	
			$this->db->order_by($order_by, $direction);
			$this->db->where('shop_id',$shop_id);
			$this->db->where('active',1);
			
			if($limit>0){
				$this->db->limit($limit, $offset);
			}
			return $this->db->count_all_results('suppliers');
	}
	function fetch_supplier($code,$shop){
		
		$suppliers_ids	= $this->db->get_where('relartikelleverancier', array('ARTIKELCOD'=>$code,'shop_id'=>$shop,'DELRECORD'=>1))->result();
		foreach($suppliers_ids as $v){

			$result[] = $this->db->get_where('suppliers', array('id'=>$v->LEVERANCIE,'shop_id'=>$shop))->row();
			
		}
		return @$result;
	}
	function get_supplier($code,$shop){
		$result	= $this->db->get_where('relartikelleverancier', array('ARTIKELCOD'=>$code,'shop_id'=>$shop));
		return $result->result_array();
	}
	
	function get_suppliers_name($id,$shop){

		$this->db->select('id,company');
		$this->db->where('shop_id',$shop);
		$this->db->where('id',$id);
		return $this->db->get('suppliers')->row_array();
	}
	
	
	function get_the_supplier($id,$shop){

		$result	= $this->db->join('suppliers', 'relartikelleverancier.LEVERANCIE = suppliers.id');
		return $this->db->get_where('relartikelleverancier', array('LEVERANCIE'=>$id,'s_id'=>$shop))->row();
	}
	function get_subscribers()
	{
		$this->db->where('email_subscribe','1');
		$res = $this->db->get('suppliers');
		return $res->result_array();
	}
	
	function get_address_list($id)
	{
		$addresses = $this->db->where('supplier_id', $id)->get('suppliers_address_bank')->result_array();
		// unserialize the field data
		if($addresses)
		{
			foreach($addresses as &$add)
			{
				$add['field_data'] = unserialize($add['field_data']);
			}
		}
		
		return $addresses;
	}
	
	function get_address($address_id){
		$address= $this->db->where('id', $address_id)->get('suppliers_address_bank')->row_array();
		if($address)
		{
			$address_info			= unserialize($address['field_data']);
			$address['field_data']	= $address_info;
			$address				= array_merge($address, $address_info);
		}
		return $address;
	}
	
	public function save_address($data){

		$data['field_data'] = serialize($data['field_data']);
		// update or insert
		if(!empty($data['id'])){
			$this->db->where('id', $data['id']);
			$this->db->update('suppliers_address_bank', $data);
			return $data['id'];
		} else {
			$this->db->insert('suppliers_address_bank', $data);
			return $this->db->insert_id();
		}
	}

	function delete_address($id, $supplier_id){
		$this->db->where(array('id'=>$id, 'supplier_id'=>$supplier_id))->delete('suppliers_address_bank');
		return $id;
	}
	
	function save($supplier){

		// update or insert
		if(!empty($supplier['id'])){
			$this->db->where('id', $supplier['id']);
			$this->db->update('suppliers', $supplier);
			return $supplier['id'];
		} else {
			$this->db->insert('suppliers', $supplier);
			return $this->db->insert_id();
		}
	}
	
	function deactivate($id){
		$supplier	= array('id'=>$id, 'active'=>0);
		$this->save_supplier($supplier);
	}
	
	function delete($id){

		/*
		deleting a supplier will remove all their orders from the system
		this will alter any report numbers that reflect total sales
		deleting a supplier is not recommended, deactivation is preferred
		*/
		
		//this deletes the suppliers record
		$this->db->where('id', $id);
		$this->db->delete('supplier');
		
		// Delete Address records
		$this->db->where('supplier_id', $id);
		$this->db->delete('suppliers_address_bank');
		
		//get all the orders the supplier has made and delete the items from them
		$this->db->select('id');
		$result	= $this->db->get_where('orders', array('supplier_id'=>$id));
		$result	= $result->result();
		foreach ($result as $order)
		{
			$this->db->where('order_id', $order->id);
			$this->db->delete('order_items');
		}
		
		//delete the orders after the items have already been deleted
		$this->db->where('supplier_id', $id);
		$this->db->delete('orders');
	}
	
	function check_email($str, $id=false)
	{
		$this->db->select('email');
		$this->db->from('suppliers');
		$this->db->where('email', $str);
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
	
	
	/*
	these functions handle logging in and out
	*/
	function logout(){
		$this->session->unset_userdata('supplier');
		$this->go_cart->destroy(false);
		//$this->session->sess_destroy();
	}
	
	function login($email, $password, $remember=false){
		$this->db->select('*');
		$this->db->where('email', $email);
		$this->db->where('active', 1);
		$this->db->where('password',  sha1($password));
		$this->db->limit(1);
		$result = $this->db->get('suppliers');
		$supplier	= $result->row_array();
		
		if ($supplier)
		{
			
			// Retrieve supplier addresses
			$this->db->where(array('supplier_id'=>$supplier['id'], 'id'=>$supplier['default_billing_address']));
			$address = $this->db->get('suppliers_address_bank')->row_array();
			if($address)
			{
				$fields = unserialize($address['field_data']);
				$supplier['bill_address'] = $fields;
				$supplier['bill_address']['id'] = $address['id']; // save the addres id for future reference
			}
			
			$this->db->where(array('supplier_id'=>$supplier['id'], 'id'=>$supplier['default_shipping_address']));
			$address = $this->db->get('suppliers_address_bank')->row_array();
			if($address)
			{
				$fields = unserialize($address['field_data']);
				$supplier['ship_address'] = $fields;
				$supplier['ship_address']['id'] = $address['id'];
			} else {
				 $supplier['ship_to_bill_address'] = 'true';
			}
			
			
			// Set up any group discount 
			if($supplier['group_id']!=0) 
			{
				$group = $this->get_group($supplier['group_id']);
				if($group) // group might not exist
				{
					if($group->discount_type == "fixed")
					{
						$supplier['group_discount_formula'] = "- ". $group->discount; 
					}
					else
					{
						$percent	= (100-(float)$group->discount)/100;
						$supplier['group_discount_formula'] = '* ('.$percent.')';
					}
				}
			}
			
			if(!$remember)
			{
				$supplier['expire'] = time()+$this->session_expire;
			}
			else
			{
				$supplier['expire'] = false;
			}
			
			// put our supplier in the cart
			$this->go_cart->save_supplier($supplier);

		
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function is_logged_in($redirect = false, $default_redirect = 'secure/login/'){
		
		//$redirect allows us to choose where a supplier will get redirected to after they login
		//$default_redirect points is to the login page, if you do not want this, you can set it to false and then redirect wherever you wish.
		
		$supplier = $this->go_cart->supplier();
		if (!isset($supplier['id']))
		{
			//this tells gocart where to go once logged in
			if ($redirect)
			{
				$this->session->set_flashdata('redirect', $redirect);
			}
			
			if ($default_redirect)
			{	
				redirect($default_redirect);
			}
			
			return false;
		}
		else
		{
		
			//check if the session is expired if not reset the timer
			if($supplier['expire'] && $supplier['expire'] < time())
			{

				$this->logout();
				if($redirect)
				{
					$this->session->set_flashdata('redirect', $redirect);
				}

				if($default_redirect)
				{
					redirect('secure/login');
				}

				return false;
			}
			else
			{

				//update the session expiration to last more time if they are not remembered
				if($supplier['expire'])
				{
					$supplier['expire'] = time()+$this->session_expire;
					$this->go_cart->save_supplier($supplier);
				}

			}

			return true;
		}
	}
	
	function reset_password($email){
		$this->load->library('encrypt');
		$supplier = $this->get_supplier_by_email($email);
		if ($supplier)
		{
			$this->load->helper('string');
			$this->load->library('email');
			
			$new_password		= random_string('alnum', 8);
			$supplier['password']	= sha1($new_password);
			$this->save($supplier);
			
			$this->email->from($this->config->item('email'), $this->config->item('site_name'));
			$this->email->to($email);
			$this->email->subject($this->config->item('site_name').': Password Reset');
			$this->email->message('Your password has been reset to <strong>'. $new_password .'</strong>.');
			$this->email->send();
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function get_supplier_by_email($email){
		$result	= $this->db->get_where('suppliers', array('email'=>$email));
		return $result->row_array();
	}
	
	
	/// Customer groups functions
	
	function get_groups(){
		return $this->db->get('supplier_groups')->result();		
	}
	
	function get_group($id){
		return $this->db->where('id', $id)->get('supplier_groups')->row();		
	}
	
	function delete_group($id){
		$this->db->where('id', $id);
		$this->db->delete('supplier_groups');
	}
	
	function save_group($data){
            
		if(!empty($data['id'])) {
			$this->db->where('id', $data['id'])->update('supplier_groups', $data);
			return $data['id'];
		} else {
			$this->db->insert('supplier_groups', $data);
			return $this->db->insert_id();
		}
	}
        function filter($id){
                
               /* 
                * $data = array(
                    'bill_country_id'=>$id[0],
                    'status'=>$id[1]

                );
                $query	= $this->db->get_where('orders', $data);
                */
            
            

                $this->db->select('*');
                
                //selecting from table orders
                if($id['country'] != '-1'){
                  $this->db->where('bill_country_id',$id['country']);  
                }
                if($id['status'] != '-1'){
                  $this->db->where('status',$id['status']);
                }
                if(!empty($id['client_num'])){
                  $this->db->where('supplier_id',$id['client_num']);
                }
                if(!empty($id['order_num'])){
                  $this->db->where('order_number',$id['order_num']);
                }
                //to set 
                if(!empty($id['client_name'])){
                  $this->db->where('firstname',$id['client_name']);
                }
                if(!empty($id['client_lname'])){
                  $this->db->where('lastname',$id['client_lname']);
                }
                
                //selecting from table suppliers
                if($id['gender'] != '-1'){
                  $this->db->where('gender',$id['gender']);
                }
                if($id['function'] != '-1'){
                  $this->db->where('function',$id['function']);
                }

                
                
                $this->db->from('orders');
                // JOINED two tables orders with table suppliers BY supplier id
                $this->db->join('suppliers', 'orders.supplier_id = suppliers.id');

                // we can join onother table inhere
                //$this->db->join('table3', 'orders.supplier_id =  table3.id');

                $query = $this->db->get();
                
                if($query->num_rows() > 0 ){
                    foreach ($query->result() as $row){
                     $data_query[] = $row;
                    }
                    return $data_query;;
                }
                else {
                    echo "No data found";
                }
                

            }
            
            function save_supplier($data){
                
                if(!empty($data)){
                $this->db->insert('customers', $customer);
                return $this->db->insert_id();
                }

            }
	function get_suppliers_orders($id,$shop){
                    
                $this->db->limit(5);
                $this->db->order_by('id','DESC');
				$result	= $this->db->get_where('stock_orders', array('supplier_id'=>$id,'shop_id'=>$shop));
				return $result->result_array();
	}

        function get_supplier_products($supplier_id,$shop){
		
            return $this->db->where(array('LEVERANCIE'=>$supplier_id,'DELRECORD'=>0,'shop_id'=>$shop))->get('relartikelleverancier')->result();
        }

		
	function get_current_supplier($id,$shop){
	
		$this->db->where('id',$id);
		$this->db->where('shop_id',$shop);
	
		$result	= $this->db->get_where('suppliers', array('id'=>$id,'shop_id'=>$shop));
		return $result->row();
	}
		
	function get_supplier_contacts($id,$shop){
	
			$this->db->where('shop_id',$shop);
			$this->db->where('supplier_id',$id);
			return $this->db->get('suppliers_contacts')->result();
	}

	function update_supplier_contact($data,$shop){
		
		$update = array('contact_person'=>$data['contact_person'],'phone'=>$data['phone'],'fax'=>$data['fax'],'email'=>$data['email']);

		$this->db->where('shop_id',$shop);
		$this->db->where('id',$data['contact_id']);
		$this->db->update('suppliers_contacts',$update);
	
	}
		
	function save_supplier_contact($data){
		
		$this->db->insert('suppliers_contacts',$data);
		return $this->db->insert_id();
	}
		
	function delete_supplier_contact($id){
			
		$this->db->where('id', $id);
		$this->db->delete('suppliers_contacts');
	}
		
	function get_currencies(){

		$this->db->select('currency_name,currency_index,currency_font');
		
		$currs = $this->db->get('c_currency')->result();
		$cur = array();
		foreach($currs as $c){
			$cur[$c->currency_index] = $c->currency_name;
		}
		return $cur;
		

	}
		
	function get_currency($index){
		
		$this->db->where('currency_index', $index);
		$this->db->select('currency_name,currency_index,currency_font');
		return $this->db->get('c_currency')->row();
	}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
            
}
    