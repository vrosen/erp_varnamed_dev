<?php

class Suppliers extends CI_Controller {

	//this is used when editing or adding a customer
	var       $supplier_id	= false;	
        private   $start_search = false;
        protected $shop_id;
        public    $data_shop;
        public    $language;
        ////////////////////////////////////////////////////////////////////////////
        private $products;
        private $groups;
        private $categories;

            
                    function __construct(){		

				parent::__construct();

						$this->load->model(array('Supplier_model', 'Location_model', 'Group_model', 'Product_model', 'Category_model','Shop_model','Search_model','Stock_model','Invoice_model'));
						////////////////////////////////////////////////////////////////
						$this->load->helper('formatting_helper');
						$this->load->helper('form');
						$this->load->library('form_validation');
						////////////////////////////////////////////////////////////////
						$this->shop_id      = $this->session->userdata('shop');
						$this->language     = $this->session->userdata('language');
						$this->data_shop    = $this->session->userdata('shop');
						////////////////////////////////////////////////////////////////
						$this->lang->load('supplier',  $this->language);
						$this->lang->load('dashboard',  $this->language);
						////////////////////////////////////////////////////////////////
						$this->groups                   = array(1);
						$this->products                 = array(1);
						$this->categories               = array(1);
						////////////////////////////////////////////////////////////////
			}
	
			function index($field='lastname', $by='ASC', $page=0){

	
					if(!$this->bitauth->logged_in()) {
						$this->session->set_userdata('redir', current_url());
						redirect($this->config->item('admin_folder').'/admin/login');
					}
		
					//menu items
					$data['categories'] 		= $this->categories;
					$data['groups']     		= $this->groups;
					$data['products']   		= $this->products;
					$data['all_shops']  		= $this->Shop_model->get_shops();
            

					$data['suppliers']		= $this->Supplier_model->get_suppliers(50,$page, $field, $by,  $this->session->userdata('shop'));
					
					$this->load->library('pagination');

					$config['base_url']		= base_url().'/'.$this->config->item('admin_folder').'/suppliers/index/'.$field.'/'.$by.'/';
					$config['total_rows']  		= $this->Supplier_model->count_suppliers(50,$page, $field, $by,$this->session->userdata('shop'));
					$config['per_page']		= 30;
					$config['uri_segment']          = 6;
					$config['first_link']		= 'First';
					$config['first_tag_open']	= '<li>';
					$config['first_tag_close']	= '</li>';
					$config['last_link']		= 'Last';
					$config['last_tag_open']	= '<li>';
					$config['last_tag_close']	= '</li>';

					$config['full_tag_open']	= '<div class="pagination"><ul>';
					$config['full_tag_close']	= '</ul></div>';
					$config['cur_tag_open']		= '<li class="active"><a href="#">';
					$config['cur_tag_close']	= '</a></li>';
					
					$config['num_tag_open']		= '<li>';
					$config['num_tag_close']	= '</li>';
					
					$config['prev_link']		= '&laquo;';
					$config['prev_tag_open']	= '<li>';
					$config['prev_tag_close']	= '</li>';

					$config['next_link']		= '&raquo;';
					$config['next_tag_open']	= '<li>';
					$config['next_tag_close']	= '</li>';
					
					$this->pagination->initialize($config);
		
		
					$data['page']	= $page;
					$data['field']	= $field;
					$data['by']		= $by;

					$timeid = $this->uri->segment(5);
                                        
                                        
                                        if($timeid==0){
                                            $time = time();
                                        }	
                                        else {
                                            $time = $timeid;
                                        }
                                        $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
		
					$this->load->view($this->config->item('admin_folder').'/suppliers', $data);
			}

                        function export_xml(){
                                $this->load->helper('download_helper');

                                $data['customers'] = (array)$this->Customer_model->get_customers();


                                force_download_content('customers.xml',	$this->load->view($this->config->item('admin_folder').'/customers_xml', $data, true));

                                //$this->load->view($this->config->item('admin_folder').'/customers_xml', $data);
                        }
                        

                        function form($id = false){
	
						force_ssl();
						
						if(!$this->bitauth->logged_in()) {
							
							$this->session->set_userdata('redir', current_url());
							redirect($this->config->item('admin_folder').'/admin/login');
						}

						$data['categories'] 		= $this->categories;
						$data['groups']     		= $this->groups;
						$data['products']   		= $this->products;
						$data['all_shops']  		= $this->Shop_model->get_shops();
						$data['page_title']     	= lang('supplier_form');
					
						$data['id']			= '';
						$data['group_id']		= '';
						$data['firstname']		= '';
						$data['lastname']		= '';
						$data['email']			= '';
						$data['account_number']         = '';
						$data['account_owner']          = '';
						$data['bank_number']            = '';
						$data['bank_name']              = '';
						$data['supplier_info']          = '';
						$data['cust_tariff']		= '';
						$data['web']			= '';
						$data['phone']			= '';
						$data['fax']			= '';
						$data['company']		= '';
						$data['number']                 = '';
						$data['street']                 = '';
						$data['street_num']             = '';
						$data['post_code']              = '';
						$data['city']                   = '';
						$data['contact_person']         = '';
						$data['email_subscribe']        = '';
						$data['active']			= false;

						$lang 				= $this->config->item('lang');

						if(empty($this->session->userdata('language'))){
							$data['name']           =	'name_NL';
						}else{
							$data['name']       =	'name_'.$lang[$this->session->userdata('language')];
						}

					if ($id){
					
						$this->supplier_id		= $id;
						$supplier			= $this->Supplier_model->get_current_supplier($id,$this->session->userdata('shop'));

						if (!$supplier){
							
							$this->session->set_flashdata('error', lang('error_not_found'));//
							redirect($this->config->item('admin_folder').'/suppliers');
						}
						//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
						/*supplier_products*/
						$supplier_products	= $this->Supplier_model->get_supplier_products($id,$this->session->userdata('shop'));
						
						$clean_products = array();
						foreach($supplier_products as $products){
							if(substr($products->ARTIKELCOD,-2,1) != '-'){
								$clean_products[] = $products;
							}
						}
						$pr = array();
						foreach($clean_products as $artikel){
							if(is_numeric($artikel->ARTIKELCOD)){
								$p = $artikel->ARTIKELCOD.'/';
							}else{
								$p = $artikel->ARTIKELCOD;
							}
							$pr[] = $this->Product_model->get_product_details($p,$this->session->userdata('shop'));
						}
						
						
						//echo '<pre>';
						//print_r(array_filter($pr));
						//echo '</pre>';
						$data['supplier_products']	=	array_filter($pr);
						//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
						/*supplier's contacts*/

						$data['supplier_contacts'] 	= $this->Supplier_model->get_supplier_contacts($id,$this->session->userdata('shop'));
						$data['shop_id']			= $this->session->userdata('shop');

						//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
						
						$data['id']					= $supplier->id;
						$data['group_id']			= $supplier->group_id;
						$data['shop_id']			= $supplier->shop_id;
						$data['firstname']			= $supplier->firstname;
						$data['lastname']			= $supplier->lastname;
						$data['email']				= $supplier->email;
						$data['account_number']		= $supplier->account_number;
						$data['account_owner']		= $supplier->account_owner;
						$data['bank_number']		= $supplier->bank_number;
						$data['bank_name']			= $supplier->bank_name;
						$data['supplier_info']		= $supplier->supplier_info;
						$data['cust_tariff']		= $supplier->cust_tariff;
						$data['web']				= $supplier->web;
						$data['phone']				= $supplier->phone;
						$data['fax']				= $supplier->fax;
						$data['company']			= $supplier->company;
						$data['number']				= $supplier->number;
						$data['street']				= $supplier->street;
						$data['street_num']			= $supplier->street_num;
						$data['post_code']			= $supplier->post_code;
						$data['city']				= $supplier->city;
						$data['plaats']				= $supplier->city;
						$data['contact_person']		= $supplier->contact_person;
						$data['country']			= $supplier->country;
						$data['active']				= $supplier->active;
						$data['email_subscribe']	= $supplier->email_subscribe;
						
					}
					$this->form_validation->set_rules('company', 'lang:company', 'trim|max_length[128]');

					$data['orders'] 				= $this->Supplier_model->get_suppliers_orders($id,$this->session->userdata('shop'));

					if ($this->form_validation->run() == FALSE){								
						$timeid = 0;
						if($timeid==0){
							$time = time();
						}else {
							$time = $timeid;
						}
						$data['weather']			=	_date($time);
						$data['events']				=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
						$this->load->view($this->config->item('admin_folder').'/supplier_form', $data);
					}
					else {

						$save['id']                 = $id;
						$save['shop_id']            = $this->shop_id;
						$save['group_id']           = $this->input->post('group_id');
						$save['firstname']          = $this->input->post('firstname');
						$save['lastname']           = $this->input->post('lastname');
						$save['email']              = $this->input->post('email');
						$save['account_number']     = $this->input->post('account_number');
						$save['account_owner']      = $this->input->post('account_owner');
						$save['bank_number']        = $this->input->post('bank_number');
						$save['bank_name']          = $this->input->post('bank_name');
						$save['supplier_info']      = $this->input->post('supplier_info');
						$save['web']                = $this->input->post('web');
						$save['cust_tariff']        = $this->input->post('cust_tariff');
						$save['phone']              = $this->input->post('phone');
						$save['fax']                = $this->input->post('fax');
						$save['company']            = $this->input->post('company');
						$save['number']             = $this->input->post('number');
						$save['street']             = $this->input->post('street');
						$save['street_num']         = $this->input->post('street_num');
						$save['post_code']          = $this->input->post('post_code');
						$save['city']               = $this->input->post('city');
						$save['contact_person']     = $this->input->post('contact_person');
						$save['country']            = $this->input->post('country');
						$save['active']             = '1';
						$save['email_subscribe']    = '1';

						if ($this->input->post('password') != '' || !$id){
							$save['password']	= $this->input->post('password');
						}
						
						$this->Supplier_model->save($save);
						$this->session->set_flashdata('message', lang('message_saved_supplier'));
						
						if(!empty($id)){
							redirect($this->config->item('admin_folder').'/suppliers/form/'.$id);
						}else{
							redirect($this->config->item('admin_folder').'/suppliers');
						}
						
						
					}
	}
	
	
				function contact_form($id=false){
				
					$post = $this->input->post(null, false);
					
					if(!empty($post['contact_id'])){
						$this->Supplier_model->update_supplier_contact($post,$this->session->userdata('shop'));
					}else{
						$this->Supplier_model->save_supplier_contact($post);
					}
					redirect($this->config->item('admin_folder').'/suppliers/form/'.$post['supplier_id']);
				}
				
				function delete_suppliers_contact($id){
				
					$this->Supplier_model->delete_supplier_contact($id);
					
				
				}
	
	
	
	
	
	
	
				function start_order($id = false){
		
							if(!$this->bitauth->logged_in()){
								$this->session->set_userdata('redir', current_url());
								redirect($this->config->item('admin_folder').'/admin/login');
							}
							
							force_ssl();
							
							$data['categories'] 	= $this->categories;
							$data['groups']     	= $this->groups;
							$data['products']   	= $this->products;
							$data['all_shops']  	= $this->Shop_model->get_shops();
							$data['page_title'] 	= lang('order_in_process');
							$data['shop_id'] 		= $this->shop_id;
               
							$data['currency_array']	=	$this->Supplier_model->get_currencies();
							
							$post_currency = $this->input->post('currency');
							
							if(!empty($post_currency)){
								$this->set_session->userdata('c_currency',$post_currency);
							}
							if(!empty($this->session->userdata('c_currency'))){
								$data['c_currency']	=	$this->session->userdata('c_currency');
								$data['c_details'] = $this->Supplier_model->get_currency($this->session->userdata('c_currency'));
							}else{
								$data['c_currency']	=	'USD';
								$data['c_details'] = $this->Supplier_model->get_currency('USD');
							}
							
							if ($id){
							
									$supplier                               = $this->Supplier_model->get_current_supplier($id,$this->session->userdata('shop'));
									$data['supplier_products']				= $this->Supplier_model->get_supplier_products($id,$this->session->userdata('shop'));
									$data['id']								= $supplier->id;
									$data['group_id']						= $supplier->group_id;
									$data['current_user']                   = $this->session->userdata('ba_username');
									$data['supplier']                       = $supplier->company;
									$data['vat']                            = $supplier->vat;
									$data['order_date']                     = date('Y-m-d');
									
									
									
									
									$timeid = 0;
									if($timeid==0){
										$time = time();
									}	
									else {
										$time = $timeid;
									}
									$data['weather']	=	_date($time);
									$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
									
									$this->load->view($this->config->item('admin_folder').'/stock_new_order', $data);
							} else {
									$this->session->set_flashdata('error', lang('error_not_found'));
									redirect($this->config->item('admin_folder').'/suppliers');
							}
				}
	
	
	    public function preview_order($id = false) {
		
					if(!$this->bitauth->logged_in()){
					$this->session->set_userdata('redir', current_url());
					redirect($this->config->item('admin_folder').'/admin/login');
					}
                    force_ssl();
                    $data['categories'] = $this->categories;
                    $data['groups']     = $this->groups;
                    $data['products']   = $this->products;
                    $data['all_shops']  = $this->Shop_model->get_shops();
                    $data['page_title'] = lang('preview_order');
                
                if(!empty($id)){
                    
                    $data['id']                     = $id;
                    $data['order_date']             = $this->input->post('order_date');
                    $supplier                       = $this->Supplier_model->get_current_supplier($id,$this->session->userdata('shop'));
                    $data['supplier']               = $supplier->company;
                    $data['vat_index']              = $supplier->vat;
                    $data['vat']                    = $this->input->post('vat');
                    $data['current_user']           = $this->session->userdata('ba_username');
                    
                    
                    $data['unit_price']             = $this->input->post('unit_price');
                    $data['discount']               = $this->input->post('discount');
                    $data['ordered_quantity']       = $this->input->post('number');
                
                    $key = count($this->input->post('product_number')); 
                    
                    $a_1 = $this->input->post('number');
                    $a_2 = $this->input->post('unit_price');
                    $a_3 = $this->input->post('product_number');
                    

                    for($i = 0;$i < $key; $i++) { 
                        
                        $new_array_1[] = array(
                            'ordered_quantity'      =>  $a_1[$i],
                            'unit_price'            =>  $a_2[$i],
                            'code'                  =>  $a_3[$i],
                            );     
                    }
                    
                    $nums       = $this->input->post('product_number');
                    $f 			= array();
					
                    foreach ($nums as $num){
                        if($this->data_shop == 3){
                            $f[] = $this->Product_model->select_order_product(33,$num);
                        }
						else {
							$f[] = $this->Product_model->select_order_product($this->session->userdata('shop'),$num);
						}
                    }

                    //print_r($f);
                    $f =  json_decode( json_encode($f), true);
                    $product_array = array();
                    
                    for($i = 0;$i < $key; $i++) { 

                    $product_array[] = array_merge($new_array_1[$i],$f[$i]);
                      
                    }

                    $data['product_array']  = $product_array;
					
                    //$invoice_address = $this->Customer_model->get_invoice_address($id);
                    //$data['invoice_address'] =  $invoice_address['field_data'];
                    //$delivery_address = $this->Customer_model->get_delivery_address($id);
                    //$data['delivery_address'] =  $delivery_address['field_data'];
					
					$timeid = 0;
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
					
                    $this->load->view($this->config->item('admin_folder').'/stock_new_order_1', $data);
                   
                }
                else {

                    $this->session->set_flashdata('error', lang('error_not_found'));
                    redirect($this->config->item('admin_folder').'/suppliers/form/'.$id);
             }
        }
		
		
	
			public function submit_order($id = false) {
			
				if (!$this->bitauth->logged_in()) {
					$this->session->set_userdata('redir', current_url());
					redirect($this->config->item('admin_folder') . '/admin/login');
				}
				
				force_ssl();
				//menu items
				$data['categories'] = $this->categories;
				$data['groups'] = $this->groups;
				$data['products'] = $this->products;
				$data['all_shops'] = $this->Shop_model->get_shops();
				$data['page_title'] = 'Order in process';
				$this->load->helper('string');


				if ($id) {

					$supplier                       = $this->Supplier_model->get_current_supplier($id,$this->session->userdata('shop'));
					
					$data['id'] = $id;

					if (!empty($_POST)) {

						$this->form_validation->set_rules('product_number', 'lang:product_number', 'required');
						//$this->form_validation->set_rules('arrival_date', 'lang:arrival_date', 'required');

						if ($this->form_validation->run() == FALSE) {

							$this->form_validation->set_message('required', 'Error Message');
						} else {

							$order_details['shop_id'] 			= $this->shop_id;
							$last_id 							= $this->Stock_model->get_last_order_id();
							$last_number 						= $this->Stock_model->get_last_order($last_id['id']);
							$order_details['order_number'] 		= $last_number['order_number'] + 1;
							$order_details['NR'] 				= $last_number['NR'] + 1;
							$order_details['supplier_id'] 		= $id;
							$order_details['supplier_name'] 	= $supplier->company;
							$order_details['status'] 			= '0';
							$order_details['entered_on'] 		= date('Y-m-d H:i:s');
							$order_details['ordered_on'] 		= $this->input->post('order_date');
							$order_details['arrival_date'] 		= $this->input->post('arrival_date');
							$order_details['tax'] 				= $this->input->post('vat');
							$order_details['vat'] 				= $this->input->post('vindex');
							$order_details['total'] 			= $this->input->post('gross');
							$order_details['subtotal'] 			= $this->input->post('netto');
							$order_details['shipping_notes']	= $this->input->post('shipping_notes');
							$order_details['notes']				= $this->input->post('important_info');
							$order_details['entered_by'] 		= $this->session->userdata('ba_username');

							$this->Stock_model->insert_order($order_details);
							$order_id = $this->db->insert_id();

							//echo '<pre>';
							//print_r($order_details);
							//echo '</pre>';

							$key = count($this->input->post('number'));


							$a_1 = $this->input->post('product');
							$a_2 = $this->input->post('product_number');
							$a_3 = $this->input->post('number');
							$a_4 = $this->input->post('min_stock');
							$a_5 = $this->input->post('vpa');
							$a_6 = $this->input->post('vk');
							$a_7 = $this->input->post('total');
							$a_8 = $this->input->post('description');

							for ($i = 0; $i < $key; $i++) {

								$new_array[] = array(
									'product' => $a_1[$i],
									'product_number' => $a_2[$i],
									'number' => $a_3[$i],
									'min_stock' => $a_4[$i],
									'vpa' => $a_5[$i],
									'vk' => $a_6[$i],
									'total' => $a_7[$i],
									'description' => $a_8[$i],
								);
							}
							foreach ($new_array as $arr) {



								$products[] = array(
									'NR' => $order_details['NR'],
									'order_id' => $order_id,
									'order_number' => $order_details['order_number'],
									'ARTIKELCOD' => $arr['product_number'],
									'AANTALBEST' => $arr['number'],
									'MINAANTALV' => $arr['min_stock'],
									'CAANTALPER' => $arr['vpa'],
									'total' => $arr['total'],
									'FACTUUROMS' => $arr['description'],
									'product_id' => $arr['product'],
									'warehouse_price' => $arr['vk'],
									'ARTIKELCOD' => $arr['product_number'],
								);
							}
							//echo '<pre>';
							//print_r($products);
							//echo '</pre>';
							$this->Stock_model->insert_order_products($products);
							redirect($this->config->item('admin_folder') . '/suppliers/form/' . $id);
						}
					}
				} else {
					$this->session->set_flashdata('error', lang('error_not_found'));
					redirect($this->config->item('admin_folder') . '/customers');
				}
			}
	
	
    function order($id) {
	
				if (!$this->bitauth->logged_in()) {
					$this->session->set_userdata('redir', current_url());
					redirect($this->config->item('admin_folder') . '/admin/login');
				}
				
				$data['categories'] = $this->categories;
				$data['groups'] = $this->groups;
				$data['products'] = $this->products;
				$data['all_shops'] = $this->Shop_model->get_shops();
				$data['invoices'] = $this->Invoice_model->get_invoice($id);

				$this->form_validation->set_rules('notes', 'lang:notes');
				$this->form_validation->set_rules('status', 'lang:status', 'required');

				$message = $this->session->flashdata('message');
				if ($this->form_validation->run() == TRUE) {

					$save = array();
					$save['id'] = $id;
					$save['notes'] = $this->input->post('notes');
					$save['status'] = $this->input->post('status');
					$save['changed_by'] = $this->input->post('changer');
					$save['changed_on'] = date('Y-m-d H:i:s');


					$data['message'] = lang('message_order_updated');

					$this->Stock_model->save_order($save);
				}


				$data['order'] 		= $this->Stock_model->get_order($id);
				$data['supplier']	= $this->Supplier_model->get_current_supplier($data['order']->supplier_id,$this->session->userdata('shop'));

				$data['vat'] = $data['supplier']->vat;
				if ($data['order']->status == 1) {
					$data['order_items'] = $this->Stock_model->get_all_items_delivered($id, $data['order']->NR, $data['order']->order_number);
				} else {
					$data['order_items'] = $this->Stock_model->get_all_items($id, $data['order']->NR, $data['order']->order_number, $this->shop_id);
				}

				//print_r($data['order_items']);



				$timeid = $this->uri->segment(5);
				if ($timeid == 0) {
					$time = time();
				} else {
					$time = $timeid;
				}
				$data['weather'] = _date($time);
				$data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
				$this->load->view($this->config->item('admin_folder') . '/stock_order', $data);
    }
	
	
	    public function update_new_order($id = false) {

			force_ssl();
 
				if ($id) {

					if (!empty($_POST)) {

						$this->form_validation->set_rules('code', 'lang:code', 'required');


						if ($this->form_validation->run() == FALSE) {

							$this->form_validation->set_message('required', 'Error Message');
							
						} else {

							$order_details['shop_id'] 			= $this->shop_id;
							$order_details['id'] 				= $id;
							$order_details['order_number'] 		= $this->input->post('order_number');
							$order_details['NR'] 				= $this->input->post('NR');
							$order_details['supplier_id'] 		= $this->input->post('supplier_id');
							$order_details['supplier_name'] 	= $this->input->post('supplier_name');
							$order_details['status'] 			= $this->input->post('status');
							$order_details['ordered_on'] 		= $this->input->post('ordered_on');
							$order_details['arrival_date'] 		= $this->input->post('arrival_date');
							$order_details['tax'] 				= $this->input->post('vat');
							$order_details['vat'] 				= $this->input->post('vindex');
							$order_details['total'] 			= $this->input->post('gross');
							$order_details['subtotal'] 			= $this->input->post('netto');
							$order_details['shipping_notes']	= $this->input->post('shipping_notes');
							$entered_by 						= $this->input->post('entered_by');
							if (empty($entered_by)) {
								$order_details['entered_by'] 	= $this->input->post('entered_by');
							} else {
								$order_details['entered_by'] 	= $this->session->userdata('ba_username');
							}


							//$this->Stock_model->update_new_order($order_details);

							echo '<pre>';
							print_r($order_details);
							echo '</pre>';


							$key = count($this->input->post('code'));


							$a_2 = $this->input->post('code');
							$a_3 = $this->input->post('quantity');
							$a_4 = $this->input->post('min_stock');
							$a_5 = $this->input->post('package_details');
							$a_6 = $this->input->post('unit_price');
							$a_7 = $this->input->post('total');
							$a_8 = $this->input->post('description');

							for ($i = 0; $i < $key; $i++) {

								$new_array[] = array(
									'product_number' 	=> $a_2[$i],
									'number' 			=> $a_3[$i],
									'min_stock' 		=> $a_4[$i],
									'package_details'	=> $a_5[$i],
									'unit_price' 		=> $a_6[$i],
									'total' 			=> $a_7[$i],
									'description' 		=> $a_8[$i],
								);
							}
							foreach ($new_array as $arr) {



								$products[] = array(
									'NR' 				=> $this->input->post('NR'),
									'order_id' 			=> $id,
									'order_number' 		=> $this->input->post('order_number'),
									'ARTIKELCOD' 		=> $arr['product_number'],
									'AANTALBEST' 		=> $arr['number'],
									'MINAANTALV' 		=> $arr['min_stock'],
									'CAANTALPER' 		=> $arr['package_details'],
									'total' 			=> $arr['total'],
									'FACTUUROMS' 		=> $arr['description'],
									'supplier_price'	=> $arr['unit_price'],
								);
							}
							echo '<pre>';
							print_r($products);
							echo '</pre>';
							//$this->Stock_model->update_new_warehouse_products($products);
							//redirect($this->config->item('admin_folder') . '/stock/view/' . $id);
						}
					}
				} else {

					$this->session->set_flashdata('error', lang('error_not_found'));
					redirect($this->config->item('admin_folder') . '/stock');
				}
    }
	
	
	function addresses($id = false){
		        if(!$this->bitauth->logged_in()) {
			
			$this->session->set_userdata('redir', current_url());
			redirect($this->config->item('admin_folder').'/admin/login');
		}
                            //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['supplier']		= $this->Supplier_model->get_supplier($id);
                $data['all_shops']  =   $this->Shop_model->get_shops();
		//if the customer does not exist, redirect them to the customer list with an error
		if (!$data['supplier'])
		{
			$this->session->set_flashdata('error', lang('error_not_found'));
			redirect($this->config->item('admin_folder').'/suppliers');
		}
		
		$data['addresses'] = $this->Supplier_model->get_address_list($id);
		
                //print_r($data['addresses']);
		$data['page_title']	= sprintf(lang('addresses_for'), $data['supplier']->company);
		
                
                
                $this->current_admin	= $this->session->userdata('admin');
                $data['admins']	= $this->auth->get_admin_list();
                						$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
		$this->load->view($this->config->item('admin_folder').'/supplier_addresses', $data);

	}
	
	function delete($id = false){
		if ($id){	
			$customer	= $this->Customer_model->get_customer($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$customer){
				$this->session->set_flashdata('error', lang('error_not_found'));
				redirect($this->config->item('admin_folder').'/suppliers');
			}
			else{
				//if the customer is legit, delete them
				$delete	= $this->Customer_model->delete($id);
				
				$this->session->set_flashdata('message', lang('message_customer_deleted'));
				redirect($this->config->item('admin_folder').'/customers');
			}
		}
		else{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('error_not_found'));
			redirect($this->config->item('admin_folder').'/suppliers');
		}
	}
	
	//this is a callback to make sure that customers are not sharing an email address
	function check_email($str){
		$email = $this->Supplier_model->check_email($str, $this->supplier_id);
        	if ($email){
			$this->form_validation->set_message('check_email', lang('error_email_in_use'));
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	function order_list($status = false){
		        if(!$this->bitauth->logged_in()) {
			
			$this->session->set_userdata('redir', current_url());
			redirect($this->config->item('admin_folder').'/admin/login');
		}
                            //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['all_shops']  =   $this->Shop_model->get_shops();
		//we're going to use flash data and redirect() after form submissions to stop people from refreshing and duplicating submissions
		$this->load->model('Order_model');
		
		$data['page_title']	= 'Order List';
		$data['orders']		= $this->Order_model->get_orders($status);
								$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
		$this->load->view($this->config->item('admin_folder').'/order_list', $data);
	}
	
	function get_subscriber_list(){
	
		        if(!$this->bitauth->logged_in()) {
			
			$this->session->set_userdata('redir', current_url());
			redirect($this->config->item('admin_folder').'/admin/login');
		}
                            //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['all_shops']  =   $this->Shop_model->get_shops();
		$subscribers = $this->Customer_model->get_subscribers();
		
		$sub_list = '';
		foreach($subscribers as $subscriber){
			$sub_list .= $subscriber['email'].",\n";
		}
		
		$data['sub_list']	= $sub_list;
								$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
		$this->load->view($this->config->item('admin_folder').'/customer_subscriber_list', $data);
	}	
        function groups(){
		$data['groups']		= $this->Customer_model->get_groups();
		$data['page_title']	= lang('customer_groups');
								$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
		$this->load->view($this->config->item('admin_folder').'/customer_groups', $data);
	}
	
	function edit_group($id=0){
		        if(!$this->bitauth->logged_in()) {
			
			$this->session->set_userdata('redir', current_url());
			redirect($this->config->item('admin_folder').'/admin/login');
		}
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['page_title']		= lang('customer_group_form');
		
		//default values are empty if the customer is new
		$data['id']				= '';
		$data['name']   		= '';
		$data['discount']		= '';
		$data['discount_type'] 	= '';
		
		if($id) {
			$group = $this->Customer_model->get_group($id);
			
			$data['id']			= $group->id;
			$data['name']   		= $group->name;
			$data['discount']		= $group->discount;
			$data['discount_type']          = $group->discount_type;
		}
		
		$this->form_validation->set_rules('name', 'lang:group_name', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('discount', 'lang:discount', 'trim|required|numeric');
		$this->form_validation->set_rules('discount_type', 'lang:discount_type', 'trim|required');

		if ($this->form_validation->run() == FALSE){
								$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
			$this->load->view($this->config->item('admin_folder').'/supplier_group_form', $data);
		}
		else{
			
			if($id){
				$save['id'] = $id;
			}
			
			$save['name'] 			= set_value('name');
			$save['discount'] 		= set_value('discount');
			$save['discount_type']          = set_value('discount_type');
			
			$this->Customer_model->save_group($save);
			$this->session->set_flashdata('message', lang('message_saved_group'));
			
			//go back to the customer group list
			redirect($this->config->item('admin_folder').'/suppliers/groups');
		}
	}
	
	
	function get_group(){
		$id = $this->input->post('id');
		
		if(empty($id)) return;
		
		echo json_encode($this->Customer_model->get_group($id));
	}
	
	
	function delete_group($id){
		
		if(empty($id)){
			return;
		}
		
		$this->Customer_model->delete_group($id);
		
		//go back to the customer list
		redirect($this->config->item('admin_folder').'/suppliers/groups');
	}
	
	function address_list($customer_id){
		        if(!$this->bitauth->logged_in()) {
			
			$this->session->set_userdata('redir', current_url());
			redirect($this->config->item('admin_folder').'/admin/login');
		}
                            //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['all_shops']  =   $this->Shop_model->get_shops();
		$data['address_list'] = $this->Customer_model->get_address_list($customer_id);
								$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
		$this->load->view($this->config->item('admin_folder').'/address_list', $data);
	}
	
	function address_form($supplier_id, $id = false) {
            	        if(!$this->bitauth->logged_in()) {
			
			$this->session->set_userdata('redir', current_url());
			redirect($this->config->item('admin_folder').'/admin/login');
		}
                //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['all_shops']  =   $this->Shop_model->get_shops();
            
		$data['id']			= $id;
		$data['company']		= '';
		$data['firstname']		= '';
		$data['lastname']		= '';
		$data['email']			= '';
		$data['phone']			= '';
		$data['address1']		= '';
		$data['address2']		= '';
		$data['city']			= '';
		$data['country_id']		= '';
		$data['zone_id']		= '';
		$data['zip']			= '';
		
		$data['supplier_id']	= $supplier_id;
		
		$data['page_title']		 = lang('address_form');
		//get the countries list for the dropdown
		$data['countries_menu']	= $this->Location_model->get_countries_menu();
		
		if($id) {
			$address                 = $this->Supplier_model->get_address($id);
			
			//fully escape the address
			form_decode($address);
			
			//merge the array
			$data			= array_merge($data, $address);
			
			$data['zones_menu']	= $this->Location_model->get_zones_menu($data['country_id']);
		}
		else {
			//if there is no set ID, the get the zones of the first country in the countries menu
			$data['zones_menu']	= $this->Location_model->get_zones_menu(array_shift(array_keys($data['countries_menu'])));
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('company', 'lang:company', 'trim|max_length[128]');
		$this->form_validation->set_rules('firstname', 'lang:firstname', 'trim|required|max_length[32]');
		$this->form_validation->set_rules('lastname', 'lang:lastname', 'trim|required|max_length[32]');
		$this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|max_length[128]');
		$this->form_validation->set_rules('phone', 'lang:phone', 'trim|required|max_length[32]');
		$this->form_validation->set_rules('address1', 'lang:address', 'trim|required|max_length[128]');
		$this->form_validation->set_rules('address2', 'lang:address', 'trim|max_length[128]');
		$this->form_validation->set_rules('city', 'lang:city', 'trim|required');
		$this->form_validation->set_rules('country_id', 'lang:country', 'trim|required');
		$this->form_validation->set_rules('zone_id', 'lang:state', 'trim|required');
		$this->form_validation->set_rules('zip', 'lang:postcode', 'trim|required|max_length[32]');
		
		if ($this->form_validation->run() == FALSE) {
								$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
			$this->load->view($this->config->item('admin_folder').'/supplier_address_form', $data);
		}
		else {
			
			$a['supplier_id']		= $supplier_id; // this is needed for new records
			$a['id']                        = (empty($id))?'':$id;
			$a['field_data']['company']	= $this->input->post('company');
			$a['field_data']['firstname']	= $this->input->post('firstname');
			$a['field_data']['lastname']	= $this->input->post('lastname');
			$a['field_data']['email']	= $this->input->post('email');
			$a['field_data']['phone']	= $this->input->post('phone');
			$a['field_data']['address1']	= $this->input->post('address1');
			$a['field_data']['address2']	= $this->input->post('address2');
			$a['field_data']['city']	= $this->input->post('city');
			$a['field_data']['zip']		= $this->input->post('zip');
			
			
			$a['field_data']['zone_id']	= $this->input->post('zone_id');
			$a['field_data']['country_id']	= $this->input->post('country_id');
			
			$country                        = $this->Location_model->get_country($this->input->post('country_id'));
			$zone                           = $this->Location_model->get_zone($this->input->post('zone_id'));
			
			$a['field_data']['zone']	= $zone->code;  // save the state for output formatted addresses
			$a['field_data']['country']	= $country->name; // some shipping libraries require country name
			$a['field_data']['country_code']	= $country->iso_code_2; // some shipping libraries require the code 
			
                       
			$this->Supplier_model->save_address($a);
			$this->session->set_flashdata('message', lang('message_saved_address'));
			
			redirect($this->config->item('admin_folder').'/suppliers/addresses/'.$supplier_id);
		}
	}
	
	
	function delete_address($customer_id = false, $id = false){
		if ($id){	
			$address	= $this->Customer_model->get_address($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$address){
				$this->session->set_flashdata('error', lang('error_address_not_found'));
				
				if($customer_id)
				{
					redirect($this->config->item('admin_folder').'/suppliers/addresses/'.$customer_id);
				}
				else
				{
					redirect($this->config->item('admin_folder').'/suppliers');
				}
				
			}
			else{
				//if the customer is legit, delete them
				$delete	= $this->Customer_model->delete_address($id, $customer_id);				
				$this->session->set_flashdata('message', lang('message_address_deleted'));
				
				if($customer_id){
					redirect($this->config->item('admin_folder').'/suppliers/addresses/'.$customer_id);
				}
				else{
					redirect($this->config->item('admin_folder').'/suppliers');
				}
			}
		}
		else{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('error_address_not_found'));
			
			if($customer_id){
				redirect($this->config->item('admin_folder').'/suppliers/addresses/'.$customer_id);
			}
			else{
				redirect($this->config->item('admin_folder').'/suppliers');
			}
		}
	}
	
        
        public function monthly_mailing($field='lastname', $by='ASC', $page=0){
            	        if(!$this->bitauth->logged_in()) {
			
			$this->session->set_userdata('redir', current_url());
			redirect($this->config->item('admin_folder').'/admin/login');
		}
                            //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['all_shops']  =   $this->Shop_model->get_shops();

                
                $data['country'] = array(
                    '-1'      => lang('select_country'),
                    '13'      => lang('australia'),
                    '21'      => lang('belgium'),
                    '33'      => lang('bulgaria'),
                    '81'      => lang('germany'),
                    '57'      => lang('danmark'),
                    '73'      => lang('france'),
                    '103'     => lang('ireland'),
                    '105'     => lang('italy'),
                    '124'     => lang('luxemburg'),
                    '150'     => lang('holland'),
                    '170'     => lang('poland'),
                    '171'     => lang('portugal'),
                    '175'     => lang('romania'),
                    '204'     => lang('switzerland'),
                    '195'     => lang('spain'),
                    '56'      => lang('cezh_republik'),
                    '97'      => lang('hungary'),
                    '222'     => lang('england'),
                    '223'     => lang('amerika'),
                    '203'     => lang('sweden'),
                    '14'      => lang('austria'),
                    );

                
                $country        = $this->input->post('country');
                $status         = $this->input->post('status');
                $function       = $this->input->post('function');
                $gender         = $this->input->post('gender');
                $order_nr       = $this->input->post('order_num');
                $client_nr      = $this->input->post('client_num');
                $client_name    = $this->input->post('client_name');
                $client_lname    = $this->input->post('client_lname');

                if(!empty($_POST['search'])){

                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('country', 'lang:country', '');
                    $this->form_validation->set_rules('status', 'lang:status', '');
                    $this->form_validation->set_rules('function', 'lang:function', '');
                    $this->form_validation->set_rules('gender', 'lang:gender', '');
                    $this->form_validation->set_rules('order_num', 'lang:order_num', 'trim|numeric');
                    $this->form_validation->set_rules('client_num', 'lang:client_num', 'trim|numeric');
                    
                    if ($this->form_validation->run() == FALSE) {

                        $this->form_validation->set_message('numeric', 'Error Message');

                    }
                    else {
                        
                        $data_form = array(

                                        'country'       =>   $country,//0
                                        'status'        =>   $status,//1
                                        'function'      =>   $function,//2
                                        'gender'        =>   $gender,//3
                                        'order_num'     =>   $order_nr,//4
                                        'client_num'    =>   $client_nr,//5
                                        'client_name'   =>  $client_name,//6
                                        'client_lname'  =>  $client_lname,//7
                            
                        );
                        
                        $report_data['report_details'] = $this->Customer_model->filter($data_form);

                        $report_data['page_title'] = lang('report_page_title');
                        $this->current_admin	= $this->session->userdata('admin');
                        $report_data['admins']	= $this->auth->get_admin_list();
                        $this->load->view($this->config->item('admin_folder').'/suplier_report',$report_data);
                        
                    }
                }

						$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
                $data['page_title']     = lang('month_export'); 
                $this->load->view($this->config->item('admin_folder').'/monthly_mailing', $data);
            }
			
			
			
			
			//-----------------------------------------------------------------------------------------------------------------------------------------------------------------
			/*adding a new supplier function*/
			
				function add_supplier_form(){
							
					if(!$this->bitauth->logged_in()) {
						$this->session->set_userdata('redir', current_url());
						redirect($this->config->item('admin_folder').'/admin/login');
					}

					$data['categories'] = 	$this->categories;
					$data['groups']     = 	$this->groups;
					$data['products']   = 	$this->products;
					$data['all_shops']  =   $this->Shop_model->get_shops();
					
					
					
					
					
					
					
					
					
										
										
										
					$timeid = 0;
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
					$this->load->view($this->config->item('admin_folder').'/add_supplier', $data);
				}
			//-----------------------------------------------------------------------------------------------------------------------------------------------------------------
			
			
			
			
            function add_supplier(){
                	        if(!$this->bitauth->logged_in()) {
			
			$this->session->set_userdata('redir', current_url());
			redirect($this->config->item('admin_folder').'/admin/login');
		}

                        $data['categories'] = $this->categories;
                        $data['groups']     = $this->groups;
                        $data['products']   = $this->products;
                        $data['all_shops']  =   $this->Shop_model->get_shops();
                        force_ssl();
                

                        $this->load->library('form_validation');

                        $this->form_validation->set_rules('email', 'lang:email', 'trim|valid_email|max_length[128]');
                        $this->form_validation->set_rules('company', 'lang:company', 'trim|max_length[128]');
                        $this->form_validation->set_rules('contact_person', 'lang:contact_person', 'trim|max_length[128]');

		
                        if ($this->form_validation->run() == FALSE){
												$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
                                $this->load->view($this->config->item('admin_folder').'/add_supplier', $data);
                        }
                        else {


			$save['email']              = $this->input->post('email');
                        $save['shop_id']            = $this->shop_id;
                        $save['account_number']     = $this->input->post('account_number');
                        $save['account_owner']      = $this->input->post('account_owner');
                        $save['bank_number']        = $this->input->post('bank_number');
                        $save['bank_name']          = $this->input->post('bank_name');
                        $save['supplier_info']      = $this->input->post('supplier_info');
                        $save['web']                = $this->input->post('web');
                        $save['cust_tariff']        = $this->input->post('cust_tariff');
			$save['phone']              = $this->input->post('phone');
                        $save['fax']                = $this->input->post('fax');
			$save['company']            = $this->input->post('company');
                        $save['number']             = $this->input->post('number');
                        $save['contact_person']     = $this->input->post('contact_person');
			$save['active']             = $this->input->post('active');
			$save['email_subscribe']    = $this->input->post('email_subscribe');

                        print_r($save);
                        $this->Supplier_model->save($save);
			$this->session->set_flashdata('message', lang('message_saved_supplier'));
                        redirect($this->config->item('admin_folder').'/suppliers');
                }
            }
        }