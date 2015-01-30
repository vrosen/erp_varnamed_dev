<?php
Class Customer_model extends CI_Model
{

	//this is the expiration for a non-remember session
	var $session_expire	= 7200;
	
	
	function __construct(){
			parent::__construct();
	}
	
	/********************************************************************

	********************************************************************/
	
	function get_customers($data,$offset=0, $order_by='id', $direction='DESC'){

                $this->db->where('shop_id',$data['shop_id']);
		$this->db->order_by($order_by, $direction);
		if($data['limit'] > 0){
                    $this->db->limit($data['limit'], $offset);
		}
		$result	= $this->db->get('customers');
		return $result->result();
	}
	
	function get_customers_overview($data,$offset=0, $order_by='CREATEDDAT', $direction='DESC',$agent){

	
		$this->db->where('shop_id',$data['shop_id']);
		if(!empty($agent)){
		$this->db->where('field_service',$agent);
		}
		$this->db->order_by('CREATEDDAT', 'DESC');
		
		if($data['limit'] > 0){
                    $this->db->limit($data['limit'], $offset);
		}
		
		$result	= $this->db->get('customers');
		return $result->result();
	}
	function count_customers_overview($data, $order_by='CREATEDDAT', $direction='DESC',$agent){
	
		$this->db->where('shop_id',$data['shop_id']);
		if(!empty($agent)){
		$this->db->where('field_service',$agent);
		}
		$this->db->order_by('CREATEDDAT', 'DESC');
		
		return $this->db->count_all_results('customers');
	}
		function get_debtors($data,$offset=0, $order_by='created_on', $direction='ASC'){

			$this->db->where('shop_id',$data['shop_id']);
			$this->db->where('fully_paid',0);
			$this->db->where('totalgross >',0);
			$this->db->order_by($order_by, $direction);
			
			if($data['limit'] > 0){
				$this->db->limit($data['limit'], $offset);
			}
			return $this->db->get('invoices')->result();
		}
	
	
	
	/****************************************************************************************/
		function get_customers_data($shop_id=0){

            if(!empty($shop_id)){

			$curr_month = date('m');
            $curr_YEAR = date('Y');
                
                
            $this->db->where('YEAR(creation_date)',$curr_YEAR);
			
            $this->db->where('MONTH(creation_date)',$curr_month);
			
            $this->db->where('shop_id',$shop_id);
            return $this->db->get('customers')->result_array();
            }
        }
	/****************************************************************************************/
        function get_all_sepa_customers($data){

                $this->db->where('shop_id',$data['shop_id']);
		$result	= $this->db->get('customers');
		return $result->result();
	}
	function count_customers(){
		return $this->db->count_all_results('customers');
	}
	
	function get_customer($id){
		
		$result	= $this->db->get_where('customers', array('id'=>$id));
		return $result->row();
	}
	function get_customer_nr($nr){
		
		$result	= $this->db->get_where('customers', array('NR'=>$nr));
		return $result->row();
	}
	function get_sepa_data($shop_id){
            
		$this->db->where('shop_id',$shop_id);
		$res = $this->db->get('customers');
		return $res->result_array();
	}
    function get_creds(){
            
		//$this->db->where('shop_id',$shop_id);
		$res = $this->db->get('weblogin');
		return $res->result_array();
                
	}

	function get_address_list($id){

		$addresses = $this->db->where('customer_id', $id)->get('customers_address_bank')->result_array();
		// unserialize the field data
		if($addresses){
			foreach($addresses as &$add){
				$add['field_data'] = unserialize($add['field_data']);
			}
		}
                return $addresses;
	}
	
	function get_addresses($NR,$shop_id){

		return $this->db->where(array('RELATIESNR' => $NR, 'shop_id' => $shop_id))->get('adres')->result_array();
	}

	
	
	function get_address($address_id){
		$address= $this->db->where('id', $address_id)->get('adres')->row();
		return $address;
	}

	function save_address($data){

		if(!empty($data['id'])){
			$this->db->where('id', $data['id']);
			$this->db->update('adres', $data);
			return $data['id'];
		} else {
			$this->db->insert('adres', $data);
			return $this->db->insert_id();
		}
	}
	
	function delete_address($id, $customer_id)
	{
		$this->db->where(array('id'=>$id, 'customer_id'=>$customer_id))->delete('customers_address_bank');
		return $id;
	}
	
	function save($customer){
	
				if ($customer['id'])
				{

					$this->db->where('id', $customer['id']);
					$this->db->update('customers', $customer);
					return $customer['id'];
				}
				else
				{
					$this->db->insert('customers', $customer);
					return $this->db->insert_id();
				}
	}
	function update($customer){
	
	if ($customer['id']){
	
			$this->db->where('id', $customer['id']);
			$this->db->update('customers', $customer);
			return $customer['id'];
		}
	}
	function deactivate($id)
	{
		$customer	= array('id'=>$id, 'active'=>0);
		$this->save_customer($customer);
	}
	
	function delete($id)
	{
		/*
		deleting a customer will remove all their orders from the system
		this will alter any report numbers that reflect total sales
		deleting a customer is not recommended, deactivation is preferred
		*/
		
		//this deletes the customers record
		$this->db->where('id', $id);
		$this->db->delete('customers');
		
		// Delete Address records
		$this->db->where('customer_id', $id);
		$this->db->delete('customers_address_bank');
		
		//get all the orders the customer has made and delete the items from them
		$this->db->select('id');
		$result	= $this->db->get_where('orders', array('customer_id'=>$id));
		$result	= $result->result();
		foreach ($result as $order)
		{
			$this->db->where('order_id', $order->id);
			$this->db->delete('order_items');
		}
		
		//delete the orders after the items have already been deleted
		$this->db->where('customer_id', $id);
		$this->db->delete('orders');
	}
	
	function check_email($str, $id=false)
	{
		$this->db->select('email');
		$this->db->from('customers');
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
	function logout()
	{
		$this->session->unset_userdata('customer');
		$this->go_cart->destroy(false);
		//$this->session->sess_destroy();
	}
	
	function login($email, $password, $remember=false)
	{
		$this->db->select('*');
		$this->db->where('email', $email);
		$this->db->where('active', 1);
		$this->db->where('password',  sha1($password));
		$this->db->limit(1);
		$result = $this->db->get('customers');
		$customer	= $result->row_array();
		
		if ($customer)
		{
			
			// Retrieve customer addresses
			$this->db->where(array('customer_id'=>$customer['id'], 'id'=>$customer['default_billing_address']));
			$address = $this->db->get('customers_address_bank')->row_array();
			if($address)
			{
				$fields = unserialize($address['field_data']);
				$customer['bill_address'] = $fields;
				$customer['bill_address']['id'] = $address['id']; // save the addres id for future reference
			}
			
			$this->db->where(array('customer_id'=>$customer['id'], 'id'=>$customer['default_shipping_address']));
			$address = $this->db->get('customers_address_bank')->row_array();
			if($address)
			{
				$fields = unserialize($address['field_data']);
				$customer['ship_address'] = $fields;
				$customer['ship_address']['id'] = $address['id'];
			} else {
				 $customer['ship_to_bill_address'] = 'true';
			}
			
			
			// Set up any group discount 
			if($customer['group_id']!=0) 
			{
				$group = $this->get_group($customer['group_id']);
				if($group) // group might not exist
				{
					if($group->discount_type == "fixed")
					{
						$customer['group_discount_formula'] = "- ". $group->discount; 
					}
					else
					{
						$percent	= (100-(float)$group->discount)/100;
						$customer['group_discount_formula'] = '* ('.$percent.')';
					}
				}
			}
			
			if(!$remember)
			{
				$customer['expire'] = time()+$this->session_expire;
			}
			else
			{
				$customer['expire'] = false;
			}
			
			// put our customer in the cart
			$this->go_cart->save_customer($customer);

		
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function is_logged_in($redirect = false, $default_redirect = 'secure/login/'){
		
		//$redirect allows us to choose where a customer will get redirected to after they login
		//$default_redirect points is to the login page, if you do not want this, you can set it to false and then redirect wherever you wish.
		
		$customer = $this->go_cart->customer();
		if (!isset($customer['id']))
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
			if($customer['expire'] && $customer['expire'] < time())
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
				if($customer['expire'])
				{
					$customer['expire'] = time()+$this->session_expire;
					$this->go_cart->save_customer($customer);
				}

			}

			return true;
		}
	}
	
	function reset_password($email){
		$this->load->library('encrypt');
		$customer = $this->get_customer_by_email($email);
		if ($customer)
		{
			$this->load->helper('string');
			$this->load->library('email');
			
			$new_password		= random_string('alnum', 8);
			$customer['password']	= sha1($new_password);
			$this->save($customer);
			
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
	
	function get_customer_by_email($email){
		$result	= $this->db->get_where('customers', array('email'=>$email));
		return $result->row_array();
	}
	
	
	/// Customer groups functions
	
	function get_groups(){
		return $this->db->get('customer_groups')->result();		
	}
        function get_staff(){
		return $this->db->get('bitauth_users')->result();		
	}
        function get_webshops(){
		return $this->db->get('shops')->result();		
	}
	function get_group($id){
		return $this->db->where('id', $id)->get('customer_groups')->row();		
	}
        function get_webshop($id){
		return $this->db->where('shop_id', $id)->get('shops')->row();		
	}
        function get_agent($id){
		return $this->db->where('user_id', $id)->get('bitauth_users')->row();		
	}
        function get_country($id){
		return $this->db->where('customer_id', $id)->get('customers_address_bank')->row();		
	}
        function get_country_data($id){
		
		return $this->db->where('id', $id)->get('countries')->row();		
	}
        function get_country_data_by_index($id){
		return $this->db->where('iso_code_2', $id)->get('countries')->row();		
	}
	function delete_group($id){
		$this->db->where('id', $id);
		$this->db->delete('customer_groups');
	}
	
	function save_group($data){
            
		if(!empty($data['id'])) {
			$this->db->where('id', $data['id'])->update('customer_groups', $data);
			return $data['id'];
		} else {
			$this->db->insert('customer_groups', $data);
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
                  $this->db->where('customer_id',$id['client_num']);
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

                //selecting from table customers
                if($id['gender'] != '-1'){
                  $this->db->where('gender',$id['gender']);
                }
                if($id['function'] != '-1'){
                  $this->db->where('function',$id['function']);
                }

                $this->db->from('orders');
                // JOINED two tables orders with table customers BY customer id
                $this->db->join('customers', 'orders.customer_id = customers.id');

                // we can join onother table inhere
                //$this->db->join('table3', 'orders.customer_id =  table3.id');

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
            function filter_1($id){
                
                $this->db->select('*');
                
                if($id['country'] != '-1'){
                  $this->db->where('bill_country_id',$id['country']);  
                }
                if(!empty($id['zip_code'])){
                    $this->db->where('bill_zip',$id['zip_code']);
                }
                
                if($id['gender'] != '-1'){
                  $this->db->where('gender',$id['gender']);
                }
                if($id['function'] != '-1'){
                  $this->db->where('function',$id['function']);
                }
                
                
                
                $this->db->from('orders');
                $this->db->join('customers', 'orders.customer_id = customers.id');
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
            function filter_2($id){
                
                
                $this->db->select('*');
                
                
                
                if(!empty($id['client_name'])){
                  $this->db->where('firstname',$id['client_name']);
                }
                if(!empty($id['client_lname'])){
                  $this->db->where('lastname',$id['client_lname']);
                }

                if(!empty($id['email'])){
                    $this->db->where('email',$id['email']);
                }
                
                if($id['gender'] != '-1'){
                  $this->db->where('gender',$id['gender']);
                }
                if($id['function'] != '-1'){
                  $this->db->where('function',$id['function']);
                }
                
                
                
                $this->db->from('orders');
                $this->db->join('customers', 'orders.customer_id = customers.id');
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
            function filter_3($id){

                $this->db->select('*');
                
                if(!empty($id['recieved_samples'])){
                  $this->db->where('firstname',$id['recieved_samples']);
                }
                if(!empty($id['action_code'])){
                  $this->db->where('lastname',$id['action_code']);
                }
                
                $this->db->from('orders');
                $this->db->join('customers', 'orders.customer_id = customers.id');
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
            
            public function customer_search($limit=0, $offset=0, $order_by='id', $direction='DESC',$id){
               
                $this->db->select('*');

                if(!empty($id['keyword'])){
                  $this->db->where('company',$id['keyword']);
                }

                $this->db->order_by($order_by, $direction);
		if($limit>0) {
                $this->db->limit($limit, $offset);
		}
                $this->db->from('orders');
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

            public function customers($data=array(), $return_count=false) {

				if(empty($data )) {
						$this->get_all_customers();
				}
				else {
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

								$this->db->like('firstname', $search->term);
								$this->db->or_like('lastname', $search->term);
								$this->db->or_like('email', $search->term);
								$this->db->or_like('gender', $search->term);
								$this->db->or_like('group_id', $search->term);
								$this->db->or_like('phone', $search->term);
								$this->db->or_like('function', $search->term);
								$this->db->or_like('industry', $search->term);
							}
						}

						if($return_count){
							return $this->db->count_all_results('customers');
						}
						else {
						if($this->data_shop == 3){
							$this->db->where('aproved',1);
						}
						
						$this->db->where('shop_id',$this->data_shop);
						$this->db->where('active',1);
						$this->db->order_by('NR', 'DESC');
						$this->db->limit(20);
						return $this->db->get('customers')->result();
						}
					}
			}

	            public function request_customers($data=array(), $return_count=false) {

		if(empty($data )) {
			$this->get_all_customers();
		}
		else {
                        if(!empty($data['shop_id'])) {
				$this->db->where('shop_id',$data['shop_id']);
			}
			$this->db->where('aproved',0);
			if(!empty($data['rows'])) {
				$this->db->limit($data['rows']);
			}
			//grab the offset
			if(!empty($data['page'])){
				$this->db->offset($data['page']);
			}
			if(!empty($data['order_by'])){
				
				$this->db->order_by($data['order_by'], $data['sort_order']);
			}
			if(!empty($data['term'])){
				$search	= json_decode($data['term']);
				if(!empty($search->term)){

                                        //add search createria
					$this->db->like('firstname', $search->term);
					$this->db->or_like('lastname', $search->term);
                                        $this->db->or_like('email', $search->term);
                                        $this->db->or_like('gender', $search->term);
                                        $this->db->or_like('group_id', $search->term);
                                        $this->db->or_like('phone', $search->term);
                                        $this->db->or_like('function', $search->term);
                                        $this->db->or_like('industry', $search->term);
				}
			}

			if($return_count){
				return $this->db->count_all_results('customers');
			}
			else{
				return $this->db->get('customers')->result();
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	function get_all_customers(){
               

		$this->db->order_by('firstname', 'ASC');
                return $this->db->get('customers')->result();
	}

                public function get_customer_address($id){
            
		$this->db->where('customer_id', $id);
		$result 		= $this->db->get('customers_address_bank');
		$order_details		= $result->row();
		return $order_details;
        }
                 public function get_customer_bank($id){
            
		$this->db->where('id', $id);
		$result 		= $this->db->get('customers');
		$order_details		= $result->row();
		return $order_details;
        }
             public function get_customer_group($id){
            
		$this->db->where('id', $id);
		$result 		= $this->db->get('customer_groups');
		$group_details		= $result->row();
		return $group_details;
        }
        public function insert_DD($id){
            
            $data = array('DD' => '1');
            $this->db->where('customer_id', $id);
            $this->db->update('customers', $data);
            return $data['id'];
        }
        
    function check_invoice_address($data){
            
        if(!empty($data['invoice_address'])){
            
            $this->db->select('id');
            $this->db->where('RELATIESNR', $data['RELATIESNR']);
            $this->db->where('invoice_address', '1');
            $result = $this->db->get('adres')->result_array();
            return $result;
        }
     }
     function update_invoice_address($data){

            $existing_index = array('invoice_address' =>  0);
			$new_index = array('invoice_address' =>  1);
			$this->db->where('id', $data['existing_index'])->update('adres', $existing_index);
			$this->db->where('id', $data['new_index'])->update('adres', $new_index);
     }
     
     
    function check_delivery_address($data){
            
        if(!empty($data['delivery_address'])){
            $this->db->select('id');
            $this->db->where('RELATIESNR', $data['RELATIESNR']);
            $this->db->where('delivery_address', '1');
            $result = $this->db->get('adres')->result_array();
            return $result;
        }
     }
     function update_delivery_address($data){

            $existing_index = array('delivery_address' =>  0);
			$new_index = array('delivery_address' =>  1);
			$this->db->where('id', $data['existing_index'])->update('adres', $existing_index);
			$this->db->where('id', $data['new_index'])->update('adres', $new_index);
     }
	 
	      	function get_invoice_address_new($NR){

				return $this->db->where(array('RELATIESNR' => $NR,'SOORT' => 1,'shop_id'=>$this->data_shop))->get('adres')->row_array();
	}
	 
			function get_delivery_address_new($NR){

				return $this->db->where(array('RELATIESNR' => $NR,'SOORT' => 2,'shop_id'=>$this->data_shop))->get('adres')->row_array();
	}
	 
		function get_all_addresen($NR,$shop){

				return $this->db->where(array('RELATIESNR' => $NR,'shop_id'=>$shop))->get('adres')->result();
	}
	 function get_all_addresses($NR,$shop){

				return $this->db->where(array('RELATIESNR' => $NR,'shop_id'=>$shop))->get('adres')->result_array();
	}
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
     	function get_invoice_address($address_id){

		$address= $this->db->where(array('customer_id' => $address_id,'invoice_address' => 1))->get('customers_address_bank')->row_array();
		if($address){
			$address_info           = unserialize($address['field_data']);
			$address['field_data']	= $address_info;
			$address                = array_merge($address, $address_info);
		}
                if(!empty($address)){
                    return $address;
                }
                else {
                    return false;
                }
		
	}
        function get_delivery_address($address_id){
		$address= $this->db->where(array('customer_id' => $address_id,'delivery_address' => 1))->get('customers_address_bank')->row_array();
		if($address){
			$address_info           = unserialize($address['field_data']);
			$address['field_data']	= $address_info;
			$address                = array_merge($address, $address_info);
		}
                if(!empty($address)){
                    return $address;
                }
                else {
                    return false;
                }
	}
     
     function add_comment($data){

        if(!empty($data)){
            $this->db->insert('comments',$data);
            return $this->db->insert_id();
         }
         else {
             echo 'empty comment';
         }
     }
     function get_comments($data){
         
         return $this->db->where(array('shop_id' => $data['shop_id'], 'customer_id' => $data['customer_id']))->get('comments')->result_array();

     }
          function show_comment($data){

            return $this->db->where(array('customer_id' => $data['customer_id'],'id' => $data['comment_id']))->limit(5)->get('comments')->row_array();
     }
     
          function get_address_details(){
         
            return $this->db->select('customer_id,country_id,company,firstname,lastname,address1,address2,city,zip,country')->get('opdracht_nr')->result_array();

     }
     
        function insert_new_addresses($data){
         
            $this->db->insert_batch('customers_address_bank',$data);
            return $this->db->insert_id();
     }
     
     function get_client_details_NR($nr){
          return $this->db->where(array('NR' => $nr,'shop_id'=>$this->data_shop))->get('customers')->row_array();
     }
	 function get_client_details_by_nr($nr,$shop){
          return $this->db->where(array('NR' => $nr,'shop_id'=>$this->data_shop))->get('customers')->row();
     }
     function get_client_details_ID($id){
          return $this->db->where(array('id' => $id,'shop_id'=>$this->data_shop))->get('customers')->row_array();
     }
     	function get_country_id($id){
		
                 $this->db->select('TAAL');
                 return $this->db->get_where('customers', array('id'=>$id))->row_array();

	}
     
     function get_todo($shop_id,$nr){
	 
		 $this->db->where('RELATIESNR',$nr);
		 $this->db->where('shop_id',$shop_id);
		 return $this->db->get('acties')->result_array();
		 
	 
	 }
		function get_contacts($shop_id,$nr){
	 
		 $this->db->where('RELATIESNR',$nr);
		 $this->db->where('shop_id',$shop_id);
		 $this->db->order_by('DATUM','DESC');
		 $this->db->limit(10);
		 return $this->db->get('kontakt')->result_array();
		}
		function get_contact_persons($shop_id,$nr){
	 
		 $this->db->where('RELATIESNR',$nr);
		 $this->db->where('shop_id',$shop_id);
		 return $this->db->get('personen')->result_array();
		}
		
		
		
		
		
		function get_contact($shop_id,$customer_nr,$kontakt_nr){
	 
		 $this->db->where('RELATIESNR',$customer_nr);
		 $this->db->where('NR',$kontakt_nr);
		 $this->db->where('shop_id',$shop_id);
		 return $this->db->get('kontakt')->row_array();
		 
	 
	 }
	 
	function get_contact_person($shop_id,$customer_nr,$kontakt_nr){
	 
		 $this->db->where('RELATIESNR',$customer_nr);
		 $this->db->where('NR',$kontakt_nr);
		 $this->db->where('shop_id',$shop_id);
		 return $this->db->get('personen')->row_array();
		 
	 
	 }
	 
	 
	 
	 
         function get_todo_detail($shop_id,$customer_nr,$todo_nr){
	 
		 $this->db->where('RELATIESNR',$customer_nr);
		 $this->db->where('NR',$todo_nr);
		 $this->db->where('shop_id',$shop_id);
		 return $this->db->get('acties')->row_array();
	 
	 
	 } 
     
	function change_aproval($id,$shop_id,$ap_index){
            
		
			$a_data = array('aproved' => $ap_index);
			$this->db->where('id', $id);
			$this->db->where('shop_id', $shop_id);
			$this->db->update('customers', $a_data);
			return $id;

        }
		
	function save_todo($action,$shop_id){
		
		
		if ($action['id'])
		{

			$this->db->where('NR', $action['NR']);
			$this->db->where('id', $action['id']);
			$this->db->where('shop_id', $shop_id);
			$this->db->update('acties', $action);
			return $action['NR'];
		}
		else
		{
			$this->db->insert('acties', $action);
			return $this->db->insert_id();
		}
	}
     
    public function get_last_id_todo(){
                
                //$this->db->where('shop_id',$shop_id);
                $this->db->select_max('id');
		$result	= $this->db->get('acties');
		return $result->row();
        }
		    public function get_last_id_contact(){
                
                //$this->db->where('shop_id',$shop_id);
                $this->db->select_max('id');
		$result	= $this->db->get('kontakt');
		return $result->row();
        }
    public function get_last_order_number($id){
                
                $this->db->select('order_number,NR');
                $this->db->where('id',$id);
		$result	= $this->db->get('orders');
		return $result->row();
        }
    public function get_last_NR_number_todo($id){
                
        $this->db->select('NR');
		$this->db->where('id',$id);
		
		$result	= $this->db->get('acties');
		return $result->row();
        }  
    public function get_last_NR_number_contact($id){
                
        $this->db->select('NR');
		$this->db->where('id',$id);
		
		$result	= $this->db->get('kontakt');
		return $result->row();
        }  
     
	function save_contact($contact,$shop_id){
		
		
		if ($contact['id'])
		{
			$this->db->where('NR', $contact['NR']);
			$this->db->where('id', $contact['id']);
			$this->db->where('shop_id', $shop_id);
			$this->db->update('kontakt', $contact);
			return $action['NR'];
		}
		else
		{
			$this->db->insert('kontakt', $contact);
			return $this->db->insert_id();
		}
	}
	
	
	function save_contact_person($contact_person,$shop_id){
		
		
		if ($contact_person['id'])
		{

			$this->db->where('NR', $contact_person['NR']);
			$this->db->where('id', $contact_person['id']);
			$this->db->where('shop_id', $shop_id);
			$this->db->update('personen', $contact_person);
			return $action['NR'];
		}
		else
		{
			$this->db->insert('personen', $contact_person);
			return $this->db->insert_id();
		}
	}
	
	
	
	
	
	function get_client_action($shop_id){

 
				$curr_month = date('m');
				$curr_YEAR = date('Y');
		
				$this->db->where('shop_id',$shop_id);
                $this->db->where('MONTH(UITVOEROP)', $curr_month);
                $this->db->where('YEAR(UITVOEROP)', $curr_YEAR);
				return $this->db->get('acties')->result_array();
        }
	function get_agent_action($search=false,$shop_id){

 
				$curr_month = date('m');
				$curr_YEAR = date('Y');
		
				$this->db->where('shop_id',$shop_id);
				$this->db->where('LOGINNR',$search);
                $this->db->where('MONTH(UITVOEROP)', $curr_month);
                $this->db->where('YEAR(UITVOEROP)', $curr_YEAR);
				return $this->db->get('acties')->result_array();
        }
	 function get_all_agent_clients_array($index,$shop_id){

		$this->db->select('NR,company');
		$this->db->where('shop_id',$shop_id);
		//$this->db->where('field_service',$index);
		$this->db->where('office_staff',$index);
		return $this->db->get('customers')->result_array();
	 }
	function get_all_clients_array($shop_id){

		$this->db->select('NR,company');
		$this->db->where('shop_id',$shop_id);
		return $this->db->get('customers')->result_array();
	 }
	function get_all_clients_array_agent($agent_id,$shop_id){

		$this->db->select('NR,company');
		$this->db->where('shop_id',$shop_id);
		//$this->db->where('field_service',$agent_id);
		return $this->db->get('customers')->result_array();
	 }
	 public function get_last_id($shop_id){
                
		$this->db->where('shop_id',$shop_id);
		$this->db->select_max('id');
		$result	= $this->db->get('customers');
		return $result->row();
    }
        public function get_last_customer_number($shop){
                
                $this->db->select_max('NR');
                $this->db->where('shop_id',$shop);
				$result	= $this->db->get('customers');
				return $result->row();
        }
        
	function get_client_nr($nr,$shop){
		
		$result	= $this->db->get_where('customers', array('customer_number'=>$nr,'shop_id'=>$shop));
		return $result->row();
	}
	 	function erase_adres($id,$shop){
		$this->db->where('id', $id);
		$this->db->where('shop_id', $shop);
		$this->db->delete('adres');
	}
	 
	function to_do_actions($agent_id)
        {
            $td = date("Y-m-d");
            $this->db->from('acties');
            $this->db->where('LOGINNR',$agent_id);
            //$this->db->where('UITVOEROP >= ',$td);
            $this->db->order_by("INVOERDATU", "asc");
            $res = $this->db->get()->result_array();
        /*     
        echo "<pre>";
        echo  $this->db->last_query();
        print_r($res);
        echo "</pre>";
        exit;
         *
         */
           return($res);

	 }
	 
	 
	 
	function delete_contact($id,$shop){

		$this->db->where('id', $id);
		$this->db->where('shop_id', $shop);
		$this->db->delete('kontakt');
	}
	 
	function delete_to_do($id,$shop){

		$this->db->where('id', $id);
		$this->db->where('shop_id', $shop);
		$this->db->delete('acties');
	}
	 
	function delete_contact_person($id,$shop){

		$this->db->where('id', $id);
		$this->db->where('shop_id', $shop);
		$this->db->delete('personen');
	}
	
	function delete_comment($id,$shop){

		$this->db->where('id', $id);
		$this->db->where('shop_id', $shop);
		$this->db->delete('comments');
	}
	
	function get_customer_orders_details($id,$shop){
           
        $this->db->select('order_id,code,description,warehouse_price,quantity,saleprice,total,VAT,vpa');
        $this->db->where('shop_id', $shop);
        $this->db->where('order_id', $id);
		$items = $this->db->get('order_items')->result_array();
		$details = array();
		foreach($items as $item){
			$order = $this->db->get_where('orders', array('NR'=>$item['order_id'],'shop_id'=>$shop))->row_array();
			$details[] = array_merge($item,$order);
		}
		return $details;
	}
	
	
	
	function get_order_items($id,$shop){
        $this->db->select('order_id,code,description,quantity,saleprice,total,VAT,vpa');
        $this->db->where('shop_id', $shop);
        $this->db->where('order_id', $id);
		return $this->db->get('order_items')->result_array();
	}
	 
	 
	 
	 	function get_all_clients_array_agent_new($agent_id,$shop_id){

		$this->db->select('NR,company');
		$this->db->where('shop_id',$shop_id);
		$this->db->where('field_service',$agent_id);
		return $this->db->get('customers')->result_array();
	 }
	 
	function get_country_vat($id){
		return $this->db->select('tax')->where('iso_code_2', $id)->get('countries')->row();		
	}
	 
	 
	 
	 
	 
	 
	 
	 
	 
}
            
    