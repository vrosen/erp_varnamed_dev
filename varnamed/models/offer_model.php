<?php
Class Offer_model extends CI_Model{

	//this is the expiration for a non-remember session
	var $session_expire	= 7200;
	
	
	function __construct(){
			parent::__construct();
	}
	
	/********************************************************************

	********************************************************************/
	
	function get_offers($limit=0, $offset=0, $order_by='id', $direction='DESC'){
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}

		$result	= $this->db->get('offer');
		return $result->result();
	}
        
		
		
		
		
		
		
		
        function get_all_offer_products($limit=0, $offset=0, $order_by='id', $direction='DESC'){
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}

		$result	= $this->db->get('products');
		return $result->result();

	}
        function get_all_offer_orders(){
            
		$result	= $this->db->get('orders');
		return $result->result();

	}
        
        
        
	function count_offer_products(){
		return $this->db->count_all_results('products');
	}
	
	function get_offer($id){
		
		$result	= $this->db->get_where('offers', array('id'=>$id));
		return $result->row();
	}
	
	function get_subscribers()
	{
		$this->db->where('email_subscribe','1');
		$res = $this->db->get('offer');
		return $res->result_array();
	}
	
	function get_address_list($id)
	{
		$addresses = $this->db->where('offer_id', $id)->get('offer_address_bank')->result_array();
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
	
	function get_address($address_id)
	{
		$address= $this->db->where('id', $address_id)->get('offer_address_bank')->row_array();
		if($address)
		{
			$address_info			= unserialize($address['field_data']);
			$address['field_data']	= $address_info;
			$address				= array_merge($address, $address_info);
		}
		return $address;
	}
	
	function save_address($data)
	{
		// prepare fields for db insertion
		$data['field_data'] = serialize($data['field_data']);
		// update or insert
		if(!empty($data['id']))
		{
			$this->db->where('id', $data['id']);
			$this->db->update('offer_address_bank', $data);
			return $data['id'];
		} else {
			$this->db->insert('offer_address_bank', $data);
			return $this->db->insert_id();
		}
	}
	
	function delete_address($id, $offer_id){
		$this->db->where(array('id'=>$id, 'offer_id'=>$offer_id))->delete('offer_address_bank');
		return $id;
	}
	
	function save($offer){
		if ($offer['id']){
			$this->db->where('id', $offer['id']);
			$this->db->update('offer', $offer);
			return $offer['id'];
		}
		else{
			$this->db->insert('offer', $$offer);
			return $this->db->insert_id();
		}
	}
	
	function deactivate($id)
	{
		$offer	= array('id'=>$id, 'active'=>0);
		$this->save_offer($offer);
	}
	
	function delete($id,$shop){

		$this->db->where('id', $id);
		$this->db->where('shop_id', $shop);
		$this->db->delete('offers');
		
	}
	
	function check_email($str, $id=false)
	{
		$this->db->select('email');
		$this->db->from('offer');
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
		$this->session->unset_userdata('offer');
		$this->go_cart->destroy(false);
		//$this->session->sess_destroy();
	}
	
	function login($email, $password, $remember=false){
		$this->db->select('*');
		$this->db->where('email', $email);
		$this->db->where('active', 1);
		$this->db->where('password',  sha1($password));
		$this->db->limit(1);
		$result = $this->db->get('offer');
		$offer	= $result->row_array();
		
		if ($offer)
		{
			
			// Retrieve offer addresses
			$this->db->where(array('offer_id'=>$offer['id'], 'id'=>$offer['default_billing_address']));
			$address = $this->db->get('offer_address_bank')->row_array();
			if($address)
			{
				$fields = unserialize($address['field_data']);
				$offer['bill_address'] = $fields;
				$offer['bill_address']['id'] = $address['id']; // save the addres id for future reference
			}
			
			$this->db->where(array('offer_id'=>$offer['id'], 'id'=>$offer['default_shipping_address']));
			$address = $this->db->get('offer_address_bank')->row_array();
			if($address)
			{
				$fields = unserialize($address['field_data']);
				$offer['ship_address'] = $fields;
				$offer['ship_address']['id'] = $address['id'];
			} else {
				 $offer['ship_to_bill_address'] = 'true';
			}
			
			
			// Set up any group discount 
			if($offer['group_id']!=0) 
			{
				$group = $this->get_group($offer['group_id']);
				if($group) // group might not exist
				{
					if($group->discount_type == "fixed")
					{
						$offer['group_discount_formula'] = "- ". $group->discount; 
					}
					else
					{
						$percent	= (100-(float)$group->discount)/100;
						$offer['group_discount_formula'] = '* ('.$percent.')';
					}
				}
			}
			
			if(!$remember)
			{
				$offer['expire'] = time()+$this->session_expire;
			}
			else
			{
				$offer['expire'] = false;
			}
			
			// put our offer in the cart
			$this->go_cart->save_offer($offer);

		
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function is_logged_in($redirect = false, $default_redirect = 'secure/login/'){
		
		//$redirect allows us to choose where a offer will get redirected to after they login
		//$default_redirect points is to the login page, if you do not want this, you can set it to false and then redirect wherever you wish.
		
		$offer = $this->go_cart->offer();
		if (!isset($offer['id']))
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
			if($offer['expire'] && $offer['expire'] < time())
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
				if($offer['expire'])
				{
					$offer['expire'] = time()+$this->session_expire;
					$this->go_cart->save_offer($offer);
				}

			}

			return true;
		}
	}
	
	function reset_password($email){
		$this->load->library('encrypt');
		$offer = $this->get_offer_by_email($email);
		if ($offer)
		{
			$this->load->helper('string');
			$this->load->library('email');
			
			$new_password		= random_string('alnum', 8);
			$offer['password']	= sha1($new_password);
			$this->save($offer);
			
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
	
	function get_offer_by_email($email){
		$result	= $this->db->get_where('offer', array('email'=>$email));
		return $result->row_array();
	}
	
	
	/// Customer groups functions
	
	function get_groups(){
		return $this->db->get('offer_groups')->result();		
	}
	
	function get_group($id){
		return $this->db->where('id', $id)->get('offer_groups')->row();		
	}
	
	function delete_group($id){
		$this->db->where('id', $id);
		$this->db->delete('offer_groups');
	}
	
	function save_group($data){
            
		if(!empty($data['id'])) {
			$this->db->where('id', $data['id'])->update('offer_groups', $data);
			return $data['id'];
		} else {
			$this->db->insert('offer_groups', $data);
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
                  $this->db->where('offer_id',$id['client_num']);
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
                
                //selecting from table offer
                if($id['gender'] != '-1'){
                  $this->db->where('gender',$id['gender']);
                }
                if($id['function'] != '-1'){
                  $this->db->where('function',$id['function']);
                }

                
                
                $this->db->from('orders');
                // JOINED two tables orders with table offer BY offer id
                $this->db->join('offer', 'orders.offer_id = offer.id');

                // we can join onother table inhere
                //$this->db->join('table3', 'orders.offer_id =  table3.id');

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
            
            function save_offer($data){
                
                if(!empty($data)){
                $this->db->insert('customers', $customer);
                return $this->db->insert_id();
                }

            }
			/*
            	if ($offer['id']){
					$this->db->where('id', $offer['id']);
					$this->db->update('offers', $offer);
					return $offer['id'];
				}
            */
            	function save_the_offer($offer){

					$this->db->insert('offers', $offer);
					return $this->db->insert_id();

			}
            
            
		function get_all_offers($shop,$client_id) {
		
					$this->db->where('shop_id',$shop);
					$this->db->where('client_id',$client_id);
					return $this->db->get('offers')->result();
		}
			
		function get_current_offer($offer_id,$shop) {
		
					$this->db->where('shop_id',$shop);
					$this->db->where('id',$offer_id);
					return $this->db->get('offers')->row();
			}
			
		function update_offer($offer_id,$shop,$data){	
		
			$this->db->where('shop_id',$shop);
			$this->db->where('id',$offer_id);
			$update = array('offer'=>$data);
			$this->db->update('offers',$update);
			
		}	
			
			
			
			
			
			
			
			
			
			
			
			
			
			
            
        }
    