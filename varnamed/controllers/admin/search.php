<?php

class Search extends CI_Controller {	
	

        public $language;
        private $products;
        private $groups;
        private $categories;
        
        
	function __construct(){		
		parent::__construct();
		
		force_ssl();
		//check admin access
		$this->load->model(array('Shop_model','Product_model','Group_model','Category_model','Search_model','Calendar_model'));

                $this->language     = $this->session->userdata('language');
                $this->data_shop    = $this->session->userdata('shop');
                $this->lang->load('shop',  $this->language);
                $this->lang->load('dashboard',  $this->language);
                $this->groups                   = $this->Group_model->get_all_the_groups();
                $this->products                 = $this->Product_model->get_all_products();
                $this->categories               = $this->Category_model->get_all_categories();
	}
	
	function index(){
            

		$term_invoices 		= trim($this->input->post('search_term_invoices'));
		$term_products 		= trim($this->input->post('search_term_products'));
		$term_customers 	= trim($this->input->post('search_term_customers'));
		$term_orders 		= trim($this->input->post('search_term_orders'));
		$term_country 		= trim($this->input->post('search_term_country'));
		$term_industry 		= trim($this->input->post('search_term_industry'));
		$term_buitendienst 	= trim($this->input->post('search_term_buitendienst'));
		$term_zip 			= trim($this->input->post('search_term_zip'));
               
		$custom_data = array('term_country' => $term_country, 'term_industry' => $term_industry, 'term_buitendienst' => $term_buitendienst);
		
		if(!empty($term_invoices)){
						
						
                        $found_invoices         = 	$this->Search_model->find_invoices($term_invoices, 'invoice_number', 'desc', 15, 0,$this->session->userdata('shop'));

						if(!empty($found_invoices)){ 
							$this->session->set_flashdata('found_invoices', $found_invoices); 
						}else {
							$this->session->set_flashdata('no_result', 'No results found for invoices!'); 
						}
		}

		if(!empty($term_products)){
		
                        if(is_numeric($term_products)){
                            $num_new = $term_products.'/';
                        }
                        else {
                            $num_new = $term_products;
                        }
                        
						$catg = $this->Category_model->get_current_categories_($this->session->userdata('shop'));
						
                        if(!empty($catg)) { 
							$this->session->set_flashdata('c_categories', $catg); 
						}

                        $gatg = $this->Category_model->get_current_groups_($this->session->userdata('shop'));
						
                        if(!empty($gatg)) { 
							$this->session->set_flashdata('c_groups', $gatg); 
						}
                        
						$found_products	= $this->Search_model->find_products($num_new, 'id', 'desc', 15, 0,$this->session->userdata('shop'));

						if(!empty($found_products)) {
							
							$num_results = count($found_products);

							if($num_results == 1){
								
								foreach($found_products as $product){
									redirect($this->config->item('admin_folder').'/products/quick_view/'.$product['id']);			
								}
								
							}else {

								foreach($found_products as $product){

									if($term_products == $product['code']){
										redirect($this->config->item('admin_folder').'/products/quick_view/'.$product['id']);
									}else{
										$this->session->set_flashdata('found_products', $found_products); 
									}
								}
							}
						}else {
							$this->session->set_flashdata('no_result', 'No results found for products!'); 
						}
		}
                
		if(!empty($term_customers)){
                       //echo $term_customers;
                        $customer_criteria = mysql_real_escape_string($term_customers);
                        //echo $customer_criteria; 
						$found_customers            = $this->Search_model->find_customers($customer_criteria, 'id', 'desc', 15, 0,$this->session->userdata('shop'),$custom_data);
                        //print_r($found_customers);
                        if(!empty($found_customers)) { 
							$this->session->set_flashdata('found_customers', $found_customers); 
						}else {
							$this->session->set_flashdata('no_result', 'No results found for customers!'); 
						}
		}		
		if(!empty($term_zip)){
                        //echo $term_customers;
						$found_customers_zip            = $this->Search_model->find_customers_zip($term_zip, 'id', 'desc', 15, 0,$this->session->userdata('shop'),$custom_data);
                        //print_r($found_customers);
                        if(!empty($found_customers_zip)) { 
							$this->session->set_flashdata('found_customers_zip', $found_customers_zip); 
						}else {
							$this->session->set_flashdata('no_result', 'No results found for customers!'); 
						}
		}	
		if(!empty($term_industry) and !empty($term_country)){
                        //echo $term_country;
                        //echo $term_industry;
						$found_customers            = $this->Search_model->find_customers_m($term_industry, 'id', 'desc', 15, 0,$this->session->userdata('shop'),$term_country);
                        //print_r($found_customers);
                        if(!empty($found_customers)) { 
							$this->session->set_flashdata('found_customers', $found_customers); 
						}else {
							$this->session->set_flashdata('no_result', 'No results found for customers!'); 
						}
		}
		if(!empty($term_orders)){
                        //echo $term_orders;
						$found_orders               = $this->Search_model->find_orders($term_orders, 'order_number', 'desc', 15, 0,$this->session->userdata('shop'));
                        //print_r($found_orders);
						if(!empty($found_orders)) { 
							$this->session->set_flashdata('found_orders', $found_orders); 
						}else {
							$this->session->set_flashdata('no_result', 'No results found for orders!'); 
						}
		}		
							
					$site = str_replace('admin','',$this->input->post('url'));
					redirect($this->config->item('admin_folder').'/'.$site);
	}
		public function weather(){
	
				$city = $this->input->post('city');
				
					if(!empty($city)){
						
						$homepage = file_get_contents('http://api.openweathermap.org/data/2.5/weather?id='.$this->input->post('city').''); 
					}
					else {
						$homepage = file_get_contents('http://api.openweathermap.org/data/2.5/weather?id=2759794'); 
					}
					$w_data = json_decode($homepage,TRUE);
					$data['w_data'] = json_decode($homepage,TRUE);
					$cur_temp_Kelvin = $w_data['main']['temp'];
					$cur_temp_Celsius = $cur_temp_Kelvin - 273;
							
					$this->session->set_userdata('cur_temp_Celsius', $cur_temp_Celsius);
					
					if($city == '2759794'){
						date_default_timezone_set("Europe/Amsterdam"); 
					}
					if($city == '726050'){
						date_default_timezone_set("Europe/Athens"); 
					}      
			
					$i = $w_data['weather'][0]['icon'];
					
					$pics = array(
								'09d' => base_url('assets/img/w_img/sun+rain.png'),
								'01d' => base_url('assets/img/w_img/Sunny-icon.png'),
								'04d' => base_url('assets/img/w_img/showers.png'),
								'50d' => base_url('assets/img/w_img/mist.png'),
								'02d' => base_url('assets/img/w_img/clouds.png'),
								'13n' => base_url('assets/img/w_img/light_snow.png'),
					);

					$pic_source = '';
							
							switch ($i) {
								case '09d':
									$pic_source= $pics['09d'];
									break;
								case '01d':
									$pic_source= $pics['01d'];
									break;
								case '04d':
									$pic_source = $pics['04d'];
									break;
								case '50d':
									$pic_source = $pics['50d'];
									break;
								case '02d':
									$pic_source = $pics['02d'];
									break;
								case '13n':
									$pic_source = $pics['13n'];
									break;
							}


					$this->session->set_userdata('city', $this->input->post('city'));
					$this->session->set_userdata('pic_source', $pic_source);
					$this->session->set_userdata('w_data', json_decode($homepage,TRUE));
					
					$site = str_replace('admin','',$this->input->post('url'));
					redirect($this->config->item('admin_folder').'/'.$site);
	}


			
			

		
	
				 function edit($id=0){
				        if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
        }
				  if(isset($_POST['add']))
				  {
					  //check for empty inputs
					  if((isset($_POST['date']) && !empty($_POST['date'])) && (isset($_POST['eventTitle']) && !empty($_POST['eventTitle'])) && (isset($_POST['eventContent']) && !empty($_POST['eventContent'])))	
					  {
						  //add new event to the database
						  $this->MCalendar->addEvents();
						  $this->session->set_flashdata('message','Event created!');
						  redirect($this->config->item('admin_folder').'/dashboard','refresh');
					  }
					  else 
					  {
						  //alert message for empty input
						  $data['alert'] = "No empty input please";
					  }
				  }
				
				$data['event']			= $this->Calendar_model->getEventsById($id);
				$data['page_title']   	= lang('edit_event');
				$this->load->view($this->config->item('admin_folder').'/admin_calendar_edit', $data);
			}
	
				function update($id=0){

				if(isset($_POST['add'])){
				
						$update_event['date'] 			= $this->input->post('date');
						$update_event['eventTitle'] 	= $this->input->post('eventTitle');
						$update_event['eventContent'] 	= $this->input->post('eventContent');

						$this->Calendar_model->updateEvent($update_event,$id,$this->data_shop);
						$this->session->set_flashdata('message', 'Event updated!');
						redirect($this->config->item('admin_folder').'/dashboard','refresh');
				}
				$this->session->set_flashdata('message', 'Please fill up the information');
				redirect($this->config->item('admin_folder').'/dashboard/update','refresh');

			}
	
	
				function create(){
				
					$event_data['user']             =   $this->session->userdata('ba_username');
					$event_data['shop_id']          =   $this->data_shop;
					$event_data['user_id']          =   $this->session->userdata('ba_user_id');;
					$event_data['eventDate']        =   $this->input->post('date');
					$event_data['eventTitle']       =   $this->input->post('eventTitle');
					$event_data['eventContent']     =   $this->input->post('eventContent');
					$index 							=   $this->input->post('submit');
				  
				if($index == 'add_event'){

					$this->Calendar_model->addEvents($event_data);
	
					  
				}
					$site = $this->input->post('url');
					redirect($site);
			  }
			  
			  
				function delete($id=0){
				$this->Calendar_model->deleteEvent($id);
				$this->session->set_flashdata('message', 'Event deleted successfully.');
				 redirect($this->config->item('admin_folder').'/dashboard','refresh');
			}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	}