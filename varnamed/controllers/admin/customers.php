<?php
/**
 * used when editing or adding a customer
 */
class Customers extends CI_Controller {

    //this is used when editing or adding a customer
    var         $customer_id	= false;	
    protected   $post;
    protected   $term;
    protected   $code;
    private     $use_inventory = false;
    protected   $page_title;
    protected   $categories;
    protected   $category_id;
    protected   $categories_dropdown;
    public      $data_shop;
    public      $language;
    ////////////////////////////////////////////////////////////////////////////
		private $products;
		private $groups;
    ////////////////////////////////////////////////////////////////////////////


    public function __construct()
    {
            
        parent::__construct();

        remove_ssl();
                $this->load->model('Calendar_model');
        /**
         * Load models that will be in use
         */
	$this->load->model(
                array(
                    'Customer_model',
                    'Invoice_model',
                    'Order_model', 
                    'Location_model',
                    'Search_model',
                    'Option_model', 
                    'Category_model', 
                    'Product_model', 
                    'Group_model',
                    'Shop_model',
                    'Search_model',
                    'Offer_model',
                    'Agent_model'
                    )
        );
        /**
         * Load helpers
         */
	$this->load->helper('formatting_helper');
        $this->load->helper('form');
        $this->load->helper('dir');
        $this->load->library('form_validation');

        ////////////////////////////////////////////////////////////////
        $this->post         =   $this->input->post(null, false);
        $this->term         =   false;
        ////////////////////////////////////////////////////////////////
        $this->data_shop    =   $this->session->userdata('shop');
        $this->language     =   $this->session->userdata('language');
        ////////////////////////////////////////////////////////////////
        $this->lang->load('customer',  $this->language);
        $this->lang->load('offer',  $this->language);
        $this->lang->load('dashboard',  $this->language);
        $this->page_title   =   lang('customers');
        ////////////////////////////////////////////////////////////////
        $this->groups                 = $this->Group_model->get_all_the_groups();
        $this->products               = $this->Product_model->get_all_products();
        $this->categories             = $this->Category_model->get_all_categories();
        ////////////////////////////////////////////////////////////////
    }
    /**
     * Shows list of customer with pagingnation
     * @param type $order_by string
     * @param type $sort_order string
     * @param type $code int
     * @param type $page int
     * @param type $rows ind
     */
    function index($order_by="firstname", $sort_order="ASC", $code=0, $page=0, $rows=30)
    {
        /**
         * Check loged in status
         */
        if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
        }
        /**
         * Check roe rite and pass to view
         */
        $data['can_delete_customers']   = 
                    $this->bitauth->has_role('can_delete_customers');
        /**
         * 
         */
        $data['categories']     = $this->categories;
        $data['groups']         = $this->groups;
        $data['products']       = $this->products;
        $data['all_shops']      =   $this->Shop_model->get_shops();
        $data['code']		= $code;
		$term			= $this->term;
        $post			= $this->post;
        if($post) {
            $term		= json_encode($post);
            $code		= $this->Search_model->record_term($term);
            $data['code']	= $code;
        }
        elseif ($code) {
            $term		= $this->Search_model->get_term($code);
	}
        $data['term']           = $term;
        $data['order_by']       = $order_by;
        $data['sort_order']     = $sort_order;

                $name                   = $this->data_shop;
                $shop                   = $this->data_shop;

                switch ($name) {
                    case 1:
                        $name = 'Comforties';
                        break;
                    case 2:
                        $name = 'Dutchblue';
                        break;
                    case 3:
                        $name = 'Glovers';
                        break;
                }

                if(!empty($name)){  
                    $data['page_title'] = $this->page_title.'&nbsp;for&nbsp;'.$name;
                }
                else {
                    $data['page_title'] = $this->page_title;
                }

                $data['customers']      = $this->Customer_model->customers(array('term'=>$term, 'order_by'=>$order_by, 'sort_order'=>$sort_order, 'rows'=>$rows, 'page'=>$page,'shop_id' => $shop));

                if($this->data_shop == 1){
                    $agent_index   =   $this->session->userdata('ba_c_login');
                }
                if($this->data_shop == 2){
                    $agent_index   =   $this->session->userdata('ba_d_login');
                }

					
                $data['total']          = $this->Customer_model->customers(array('term'=>$term, 'order_by'=>$order_by, 'sort_order'=>$sort_order), true);

                
					$config['base_url']			= site_url($this->config->item('admin_folder').'/customers/index/'.$order_by.'/'.$sort_order.'/'.$code.'/');
					$config['total_rows']		= $data['total'];
					$config['per_page']			= $rows;
					$config['uri_segment']		= 7;
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
		
		
					
					
					$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
					
					
					

					$this->load->view($this->config->item('admin_folder').'/customers', $data);
    }
	
	
	function new_requests($order_by="firstname", $sort_order="ASC", $code=0, $page=0, $rows=15){
           if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
        }
                //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['all_shops']  =   $this->Shop_model->get_shops();
                

			$data['code']		= $code;
			$term			= $this->term;
			$post			= $this->post;
		if($post) {
			$term		= json_encode($post);
			$code		= $this->Search_model->record_term($term);
			$data['code']	= $code;

		}
		elseif ($code) {
			$term		= $this->Search_model->get_term($code);
		}
		//store the search term
		$data['term']                   = $term;
		$data['order_by']               = $order_by;
		$data['sort_order']             = $sort_order;
                
                $name = $this->data_shop;
                $shop = $this->data_shop;

                switch ($name) { 
                    case 1:
                        $name = 'Comforties';
                        break;
                    case 2:
                        $name = 'Dutchblue';
                        break;
                    case 3:
                        $name = 'Glovers';
                        break;
                }

     
                    $data['page_title'] = 'Nieuwe Aanvragen';


                

                $data['customers']  = $this->Customer_model->request_customers(array('term'=>$term, 'order_by'=>$order_by, 'sort_order'=>$sort_order, 'rows'=>$rows, 'page'=>$page,'shop_id' => $shop));

                
                $data['total']      = $this->Customer_model->request_customers(array('term'=>$term, 'order_by'=>$order_by, 'sort_order'=>$sort_order), true);
                
                
				$config['base_url']		= site_url($this->config->item('admin_folder').'/customers/index/'.$order_by.'/'.$sort_order.'/'.$code.'/');
				$config['total_rows']		= $data['total'];
				$config['per_page']		= $rows;
				$config['uri_segment']		= 7;
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
				
				
									$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
				
				
				
				$this->load->view($this->config->item('admin_folder').'/request_customers', $data);
	}
	
	
        public function transfer_addresses(){
		
		

            $address_array = $this->Customer_model->get_address_details();

            foreach ($address_array as $adddress){

                $new_address_array = array(
                    
                    'shop_id' =>  $adddress['shop_id'],
                    'customer_id' => $adddress['NR'],
                    'invoice_address' => 1,
                    'delivery_address' => 1,
                    'entry_name' => '',
                    'field_data' => serialize($adddress),
                );
                $this->Customer_model->insert_new_addresses($new_address_array);
            }
            
            
            echo '<pre>';
           //print_r($new_address_array);
            
            echo '</pre>';
            
        }
		
        public function transfer_creds(){

            $creds = $this->Customer_model->get_creds();
            echo '<pre>';
            print_r($creds);
            echo '</pre>';

        }
        public function bulk_save() {

            
                //function for update
		$customers	= $this->input->post('client');
		
		if(!$customers){

			$this->session->set_flashdata('error',  lang('error_bulk_no_products'));
			redirect($this->config->item('admin_folder').'/customers');
		}
				
		foreach($customers as $id => $customer) {
			$customer['id']	= $id;
			$this->Customer_model->save($customer);
		}
		$this->session->set_flashdata('message', lang('message_bulk_update'));
		redirect($this->config->item('admin_folder').'/customers');
	}

	function export_excel(){

		$this->load->helper('download_helper');

		$data['invoices']   =   $this->Customer_model->get_customers_data($this->data_shop);	
		print_r($data['invoices']);
		if(empty($data['invoices'])){
			$this->session->set_flashdata('error', lang('no_customer_c_month').' '.date('F'));
			redirect($this->config->item('admin_folder').'/customers');
		}
		else {
			$this->load->view($this->config->item('admin_folder').'/customers_xml.php', $data);
		}
	}

		public function approve_customer($id = false){
		
		$this->Customer_model->change_aproval($id,$this->data_shop,$this->input->post('aproved'));
		redirect($this->config->item('admin_folder').'/customers/form/'.$id);
		
		
		}
		
		function todo($customer_nr = false,$todo_nr = false){
		
							if(!$this->bitauth->logged_in()){
								$this->session->set_userdata('redir', current_url());
								redirect($this->config->item('admin_folder').'/admin/login');
							}
							
							force_ssl();
							$data['categories']     = $this->categories;
							$data['groups']         = $this->groups;
							$data['products']       = $this->products;
							$data['all_shops']      = $this->Shop_model->get_shops();
							$data['current_shop']   = $this->data_shop;
							$customer				= $this->Customer_model->get_customer_nr($customer_nr);
							$data['customer_names']	= $customer->company.' '.$customer->firstname.' '.$customer->lastname;
							$data['current_agent']  = $this->session->userdata('ba_username');
							
							
							$data['c_id']			= $this->session->userdata('ba_c_login');
							$data['d_id']			= $this->session->userdata('ba_d_login');
						
						
							$data['contact_id']			= '';
							
							if($todo_nr){


							$customer					= $this->Customer_model->get_customer_nr($customer_nr);
							$data['return_id'] 			= $customer->id;
							$data['customer_names']		= $customer->company.' '.$customer->firstname.' '.$customer->lastname;
							$to_do_details				= $this->Customer_model->get_todo_detail($this->data_shop,$customer_nr,$todo_nr);

							
							$data['contact_id']			= $to_do_details['id'];
							
							
							$data['id']					= $customer_nr;
							$data['nr']					= $todo_nr;
							$data['agent_id'] 			= $to_do_details['LOGINNR'];
							$data['reason'] 			= $to_do_details['SOORT'];
							$data['agent_name'] 		= $to_do_details['EIGENNAAM'];
							$data['entry_date']			= $to_do_details['INVOERDATU'];
							$data['entry_time']			= $to_do_details['INVOERTIJD'];
							$data['execution_date'] 	= $to_do_details['UITVOEROP'];
							$data['execution_time'] 	= $to_do_details['UITVOEROPT'];
							$data['executed_on'] 		= $to_do_details['UITGEVOERD'];
							$data['executed_time'] 		= $to_do_details['UITGEVOER2'];
							$data['executed_by'] 		= $to_do_details['UITVOERDOO'];
							$data['contact_person'] 	= $to_do_details['KONTAKTP'];
							$data['contact_phone'] 		= $to_do_details['KTEL'];
							$data['agent_id_2'] 		= $to_do_details['UITVOERNAA'];
							$data['description'] 		= $to_do_details['ACTIE'];
							$data['status'] 			= $to_do_details['STATUS'];
						}
						else {
							$customer					= $this->Customer_model->get_customer_nr($customer_nr);
							$data['return_id'] 			= $customer->id;
							
							
							$data['id']						= $customer_nr;
							$data['agent_id'] 				= '';
							$data['reason'] 				= '';
							$data['agent_name'] 			= '';
							$data['entry_date']				= date('Y-m-d');
							$data['entry_time']				= date('H:i:s');
							$data['execution_date'] 		= '';
							$data['execution_time'] 		= '';
							$data['executed_on'] 			= '';
							$data['executed_time'] 			= '';
							$data['executed_by'] 			= '';
							$data['contact_person'] 		= '';
							$data['contact_phone'] 			= '';
							$data['agent_id_2'] 			= '';
							$data['description'] 			= '';
							$data['status'] 				= '';
							
						}
		
				if($_POST){

							if(!empty($todo_nr)){
							$t_data['NR']					= $todo_nr;
							$t_data['id']					= $to_do_details['id'];
							}
							else {
							$l_id = $this->Customer_model->get_last_id_todo();
							echo $l_id->id;
							$l_nr = $this->Customer_model->get_last_NR_number_todo($l_id->id);
							echo $l_nr->NR;
							$t_data['NR']					= $l_nr->NR+1;
							}
							$t_data['RELATIESNR']			= $customer_nr;
							$t_data['shop_id']				= $this->data_shop;
							$t_data['LOGINNR'] 				= $this->input->post('agent_id');
							$t_data['SOORT'] 				= $this->input->post('reason');
							$t_data['EIGENNAAM'] 			= $this->input->post('agent_name');
                                                        
                                                        $entry_date                             = $this->input->post('entry_date');
                                                        if(!empty($entry_date)){
                                                            $t_data['INVOERDATU'] 			= $entry_date;
                                                        }
                                                        else {
                                                            $t_data['INVOERDATU'] 			= date('Y-m-d');
                                                        }
                                                        
                                                        $entry_time                             = $this->input->post('entry_time');
                                                        if(!empty($entry_time)){
                                                            $t_data['INVOERTIJD'] 			= $entry_time;
                                                        }
                                                        else {
                                                            $t_data['INVOERTIJD'] 			= date('H-i-s');
                                                        }
							

							$t_data['UITVOEROP'] 			= $this->input->post('execution_date');
							$t_data['UITVOEROPT'] 			= $this->input->post('execution_time');
							
							$t_data['UITGEVOERD'] 			= $this->input->post('executed_on');
							$t_data['UITGEVOER2'] 			= $this->input->post('executed_time');
							
							$t_data['UITVOERDOO'] 			= $this->input->post('executed_by');
							$t_data['KONTAKTP'] 			= $this->input->post('contact_person');
							$t_data['KTEL'] 				= $this->input->post('contact_phone');
							if($this->data_shop == 1){
							$t_data['UITVOERNAA'] 			= $this->session->userdata('ba_c_login');
							}
							if($this->data_shop == 2){
							$t_data['UITVOERNAA'] 			= $this->session->userdata('ba_d_login');
							}
							$t_data['ACTIE'] 				= $this->input->post('description');
							$t_data['STATUS'] 				= $this->input->post('status');
							$t_data['shop_id'] 				= $this->data_shop;
							
							//echo '<pre>';
							//print_r($t_data);
							//echo '</pre>';
							
						$this->Customer_model->save_todo($t_data,$this->data_shop);
						redirect($this->config->item('admin_folder').'/customers/form/'.$customer->id);
		
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
			
			
			$this->load->view($this->config->item('admin_folder').'/action', $data);
		

		}
		
		function delete_to_do($id,$customer_nr){
			
			$customer	=	$this->Customer_model->get_customer_nr($customer_nr);
			$this->Customer_model->delete_to_do($id,$this->session->userdata('shop'));
			
			redirect($this->config->item('admin_folder').'/customers/form/'.$customer->id);
		}
		
		
		function contact($customer_nr = false,$kontakt_nr = false){
	
						if(!$this->bitauth->logged_in()){
							$this->session->set_userdata('redir', current_url());
							redirect($this->config->item('admin_folder').'/admin/login');
						}
						
						force_ssl();
						$data['categories']                             = $this->categories;
						$data['groups']                                 = $this->groups;
						$data['products']                               = $this->products;
						$data['all_shops']                              = $this->Shop_model->get_shops();
						$data['current_shop']                           = $this->data_shop;
						$customer                                       = $this->Customer_model->get_customer_nr($customer_nr);
						$data['customer_names']                         = $customer->company.' '.$customer->firstname.' '.$customer->lastname;


						
							if($this->session->userdata('shop') == 1){
								$data['current_agent_id'] 			= $this->session->userdata('ba_c_login');
							}
							if($this->session->userdata('shop') == 2){
								$data['current_agent_id'] 			= $this->session->userdata('ba_d_login');
							}
							if($this->session->userdata('shop') == 3){
								$data['current_agent_id'] 			= $this->session->userdata('ba_g_login');
							}
						
						$customer										= $this->Customer_model->get_customer_nr($customer_nr);
						$data['return_id']                              = $customer->id;
						
						
						$data['contact_id']							=	'';
						
						if($kontakt_nr){

							$data['allow']					= '1';//allow not to change
							$customer						= $this->Customer_model->get_customer_nr($customer_nr);

							$data['return_id'] 				= $customer->id;
							$data['customer_names']         = $customer->company.' '.$customer->firstname.' '.$customer->lastname;
							$kontakt_detail                 = $this->Customer_model->get_contact($this->data_shop,$customer_nr,$kontakt_nr);

							$data['id']						= $customer_nr;
							$data['nr']						= $kontakt_nr;
							
							$data['contact_id']				= $kontakt_detail['id'];
							
							$data['entry_date'] 			= $kontakt_detail['DATUM'];
							$data['reason'] 				= $kontakt_detail['SOORT'];
							$data['agent_name'] 			= $kontakt_detail['EIGENNAAM'];
							$data['contact_person']			= $kontakt_detail['ANDERENAAM'];
							$data['notes']					= $kontakt_detail['OPMERKINGE'];
							$data['call_center'] 			= $kontakt_detail['CALLCENTER'];
							$data['samples_sent'] 			= $kontakt_detail['OORDEEL_MO'];
							$data['conversation_result']    = $kontakt_detail['BELRESULTA'];
							$data['call_campaign'] 			= $kontakt_detail['BELCAMPAGN'];
							$data['samples'] 				= $kontakt_detail['MONSTERAAN'];
							$a_id 							= $kontakt_detail['agent_id'];
							if($a_id == NULL){
								$a_id = $customer->field_service;
							}
							$data['agent_id'] 				= $a_id;
							
						}
						else {

							$data['allow']					= '2';//allow to change
							$data['id']						= $customer_nr;
							$data['entry_date']				= date('Y-m-d H-i-s');
							$data['reason'] 				= 2;
							$data['agent_name'] 			= $this->session->userdata('ba_username');
							$data['agent_id'] 				= $customer->field_service;
							$data['contact_person']			= '';
							$data['notes']					= '';
							$data['call_center'] 			= '';
							$data['execution_date'] 		= '';
							$data['samples_sent'] 			= 0	;
							$data['conversation_result'] 	= 0;
							$data['call_campaign'] 			= '';
							$data['samples'] 				= '';

							
						}
		
				if($_POST){

							if(!empty($kontakt_nr)){
                                                            $t_data['NR']			= $kontakt_nr;
                                                            $t_data['id']			= $kontakt_detail['id'];
							}
							else {
                                                            $l_id                               = $this->Customer_model->get_last_id_contact();
                                                            $l_nr                               = $this->Customer_model->get_last_NR_number_contact($l_id->id);
                                                            $t_data['NR']			= $l_nr->NR+1;
							}
							$t_data['RELATIESNR']			= $customer_nr;
							$t_data['shop_id']			= $this->data_shop;
                                                        $entry_date                             = $this->input->post('entry_date');
                                                        if(!empty($entry_date)){
                                                            $t_data['DATUM'] 			= $entry_date;
                                                        }
                                                        else {
                                                            $t_data['DATUM'] 			= date('Y-m-d H-i-s');
                                                        }
							
							$t_data['SOORT'] 				= $this->input->post('reason');
							$t_data['EIGENNAAM'] 			= $this->input->post('agent_name');
							if($this->session->userdata('shop') == 1){
								$t_data['agent_id'] 			= $this->session->userdata('ba_c_login');
							}
							if($this->session->userdata('shop') == 2){
								$t_data['agent_id'] 			= $this->session->userdata('ba_d_login');
							}
							if($this->session->userdata('shop') == 3){
								$t_data['agent_id'] 			= $this->session->userdata('ba_g_login');
							}
							$t_data['ANDERENAAM']			= $this->input->post('contact_person');
							$t_data['OPMERKINGE']			= $this->input->post('notes');
							$t_data['CALLCENTER'] 			= $this->input->post('call_center');
							$t_data['OORDEEL_MO'] 			= $this->input->post('samples_sent');
							$t_data['BELRESULTA'] 			= $this->input->post('conversation_result');
							$t_data['BELCAMPAGN'] 			= $this->input->post('call_campaign');
							$t_data['MONSTERAAN'] 			= $this->input->post('samples');
							$t_data['shop_id'] 				= $this->data_shop;
							//echo '<pre>';
							//print_r($t_data);
							//echo '</pre>';
							
					$this->Customer_model->save_contact($t_data,$this->data_shop);
					redirect($this->config->item('admin_folder').'/customers/form/'.$customer->id);
		
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
			
			
			$this->load->view($this->config->item('admin_folder').'/contact', $data);
		

		}	
		
		function delete_contact($id,$customer_nr){
			
			$customer	=	$this->Customer_model->get_customer_nr($customer_nr);
			$this->Customer_model->delete_contact($id,$this->session->userdata('shop'));
			
			redirect($this->config->item('admin_folder').'/customers/form/'.$customer->id);
		}
		
		
		function contact_person($customer_nr = false,$kontakt_person_nr = false){
		
		
						if(!$this->bitauth->logged_in()){
							$this->session->set_userdata('redir', current_url());
							redirect($this->config->item('admin_folder').'/admin/login');
						}

						force_ssl();
						$data['categories']     = $this->categories;
						$data['groups']         = $this->groups;
						$data['products']       = $this->products;
						$data['all_shops']      = $this->Shop_model->get_shops();
						$data['current_shop']   = $this->data_shop;
						$customer				= $this->Customer_model->get_customer_nr($customer_nr);
						$data['customer_names']	= $customer->company.' '.$customer->firstname.' '.$customer->lastname;
						$data['current_agent']  = $this->session->userdata('ba_username');
						
							if($this->session->userdata('shop') == 1){
								$data['current_agent_id'] 			= $this->session->userdata('ba_c_login');
							}
							if($this->session->userdata('shop') == 2){
								$data['current_agent_id'] 			= $this->session->userdata('ba_d_login');
							}
							if($this->session->userdata('shop') == 3){
								$data['current_agent_id'] 			= $this->session->userdata('ba_g_login');
							}
						
						$data['c_id']			= $this->session->userdata('ba_c_login');
						$data['d_id']			= $this->session->userdata('ba_d_login');
						
						$customer					= $this->Customer_model->get_customer_nr($customer_nr);
						$data['return_id'] 			= $customer->id;
						
						$data['contact_person_id']		= '';
						
						
						
						if($kontakt_person_nr){

							$customer					= $this->Customer_model->get_customer_nr($customer_nr);

							$data['return_id'] 			= $customer->id;
							$data['customer_names']		= $customer->company.' '.$customer->firstname.' '.$customer->lastname;
							$kontakt_detail				= $this->Customer_model->get_contact_person($this->data_shop,$customer_nr,$kontakt_person_nr);
							
							$data['contact_person_id']		= $kontakt_detail['id'];

							$data['id']						= $customer_nr;
							$data['nr']						= $kontakt_person_nr;
							$data['allow']					= '1';//allow not to change
							$data['firstname']				= $kontakt_detail['ACHTERNAAM'];
							$data['lastname']				= $kontakt_detail['VOORNAAM'];
							$data['department']				= $kontakt_detail['AFDELING'];
							$data['Titel']					= $kontakt_detail['FUNCTIE'];
							$data['position']				= $kontakt_detail['FUNCTIENR'];
							$data['phone']					= $kontakt_detail['TEL'];
							$data['faxnummer']				= $kontakt_detail['FAX'];
							$data['mobil']					= $kontakt_detail['MOB'];
							$data['email']					= $kontakt_detail['EMAIL'];
							$data['remarks']				= $kontakt_detail['OPMERKING'];
							$data['gender']					= $kontakt_detail['gender'];
							
							$a_id 							= $kontakt_detail['agent_id'];
							if($a_id == NULL){
								$a_id = $customer->field_service;
							}
							$data['agent_id'] 				= $a_id;
						}
						else {
							$data['allow']					= '2';//allow to change
							$data['id']						= $customer_nr;
							$data['firstname']				= '';
							$data['lastname']				= '';
							$data['department']				= '';
							$data['Titel']					= '';
							$data['position']				= '';
							$data['phone']					= '';
							$data['faxnummer']				= '';
							$data['mobil']					= '';
							$data['email']					= '';
							$data['remarks']				= '';
							$data['agent_id'] 				= $customer->field_service;
							$data['gender']					= '';
							
							
							
							
							
						}
						
				if($_POST){

							if(!empty($kontakt_person_nr)){
							$t_data['NR']					= $kontakt_person_nr;
							$t_data['id']					= $kontakt_detail['id'];
							}
							else {
							$l_id = $this->Customer_model->get_last_id_contact();

							$l_nr = $this->Customer_model->get_last_NR_number_contact($l_id->id);

							$t_data['NR']					= $l_nr->NR+1;
							}
							$t_data['RELATIESNR']			= $customer_nr;
							$t_data['shop_id']				= $this->data_shop;
							
							$t_data['ACHTERNAAM'] 			= $this->input->post('firstname');
							$t_data['VOORNAAM'] 			= $this->input->post('lastname');
							$t_data['AFDELING'] 			= $this->input->post('department');
							$t_data['FUNCTIE']				= $this->input->post('Titel');
							$t_data['FUNCTIENR']			= $this->input->post('position');
							$t_data['TEL'] 					= $this->input->post('phone');
							$t_data['FAX'] 					= $this->input->post('faxnummer');
							$t_data['MOB'] 					= $this->input->post('mobil');
							$t_data['EMAIL'] 				= $this->input->post('email');
							$t_data['OPMERKING'] 			= $this->input->post('remarks');
							
							$t_data['shop_id'] 				= $this->data_shop;
							//echo '<pre>';
							//print_r($t_data);
							//echo '</pre>';
							
							$this->Customer_model->save_contact_person($t_data,$this->data_shop);
							redirect($this->config->item('admin_folder').'/customers/form/'.$customer->id);
		
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
					$this->load->view($this->config->item('admin_folder').'/contact_person', $data);
		}
		
		function delete_contact_person($id,$customer_nr){
			
			$customer	=	$this->Customer_model->get_customer_nr($customer_nr);
			$this->Customer_model->delete_contact_person($id,$this->session->userdata('shop'));
			
			redirect($this->config->item('admin_folder').'/customers/form/'.$customer->id);
		}
		
		function delete_comment($customer_id,$comment_id){
			

			$this->Customer_model->delete_comment($comment_id,$this->session->userdata('shop'));
			
			redirect($this->config->item('admin_folder').'/customers/form/'.$customer_id);
		}
		
		
		function all_invoices($NR){
		
				if(!$this->bitauth->logged_in()){
					$this->session->set_userdata('redir', current_url());
					redirect($this->config->item('admin_folder').'/admin/login');
				}
                force_ssl();
                $data['categories']     = $this->categories;
                $data['groups']         = $this->groups;
                $data['products']       = $this->products;
                $data['all_shops']      = $this->Shop_model->get_shops();
                $data['current_shop']   = $this->session->userdata('shop');

                $customer		= $this->Customer_model->get_client_nr($NR,  $this->data_shop);
                $data['id']		= $customer->id;
                $data['customer_number']   =    $NR;

                $data['status']         = $this->input->post('invoice_status');
                
                $data['month']                  = $this->input->post('month');
                $data['year']                   = $this->input->post('year');
                
                
                if($data['status'] == 'all' or empty($data['status'])){
                    $data['invoices']       =   $this->Invoice_model->get_customer_all_invoices($NR,0,$this->data_shop,$data['month'],$data['year']);
                }
                else {
                    $data['invoices']	=   $this->Invoice_model->get_customer_status_invoices($NR,0,$this->data_shop,$data['status'],$data['month'],$data['year']);
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
                
		$this->load->view($this->config->item('admin_folder').'/customer_invoices', $data);
		}
	function go_client($nr){
	
		$customer = $this->Customer_model->get_customer_nr($nr);
		$customer->id;
		redirect($this->config->item('admin_folder').'/customers/form/'.$customer->id);
	}

    function form($id = false)
    {
	if(!$this->bitauth->logged_in())
        {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
	}
        force_ssl();
		
		if(!empty($this->session->userdata('back'))){
			$this->session->unset_userdata('back');
		}

        $data['can_delete_customers']   = 
        $this->bitauth->has_role('can_delete_customers');
        $data['staff_array'] = $this->Agent_model->getFormList($this->session->userdata['shop']);
       
        switch($this->session->userdata['shop'])
        {
            case 1:
                $data['ba_login'] = 
                    $this->session->userdata['ba_c_login']
                    ? $this->session->userdata['ba_c_login']
                    : $this->session->userdata['ba_user_id'];
                break;
            case 2:
                $data['ba_login'] = 
                    $this->session->userdata['ba_d_login']
                    ? $this->session->userdata['ba_d_login']
                    : $this->session->userdata['ba_user_id'];
                break;
            case 3:
                $data['ba_login'] = 
                    $this->session->userdata['ba_g_login']
                    ? $this->session->userdata['ba_g_login']
                    : $this->session->userdata['ba_user_id'];
                break;
            default:
                $data['ba_login'] = $this->session->userdata['ba_user_id'];
        }
        $data['ba_fullname'] = $this->session->userdata['ba_fullname'];
                force_ssl();
                $data['categories']     = $this->categories;
                $data['groups']         = $this->groups;
                $data['products']       = $this->products;
                $data['all_shops']      = $this->Shop_model->get_shops();
                $data['current_shop']   = $this->session->userdata('shop');
                $data['page_title']     = lang('add_new_customer');

                /***************************************************************************************************************
                 * no customer
                 */
                $data['countries_languages']	= $this->Location_model->get_countries_menu_languages();

				$data['id']								= '';
                $data['shop_id']						= '';
                $data['shop_name']						= '';
                $data['company']						= '';
                $data['firstname']						= '';
                $data['lastname']						= '';
                $data['active']                         = '';
                $data['customer_number']                = '';
				$data['phone']                          = '';
                $data['fax_1']                          = '';
				$data['email_1']                        = '';
				$data['invoice_email']                  = '';
                $data['website']                        = '';
                $data['industry']                       = '';
				$data['group_id']						= '';
                $data['main_company']                   = '';
				$data['office_staff']					= '';
                $data['field_service']                  = '';
				$data['invoice_after_delivery']         = '';
				$data['payment_by_direct_debit']        = '';
                $data['was_deleted']					= '';
                $data['stop_delivery']                  = '';
                $data['none_VAT']                       = '';
                $data['ICL_VAT_number']                 = '';
                $data['customer_info']                  = '';
                $data['account_number']                 = '';
                $data['account_owner']                  = '';
                $data['bank_number']                    = '';
                $data['bank_name']                      = '';
                $data['IBAN']                           = '';
                $data['BIC']                            = '';
                $data['sortcode']                       = '';
                $data['sepa_id']                        = '';
                $data['sepa_signature_date']            = '';
                $data['number_residents']               = '';
                $data['monthly_invoice']                = '';
                $data['manager']                        = '';
                $data['no_post']                        = '';
                $data['standard_payment_method']        = '';
                $data['payment_condition']              = 4;
                $data['shop_account']                   = '';
                $data['contribution_nl_account']        = '';
                $data['date_contribution']              = '';
                $data['transfer_nl_account']            = '';
                $data['not_remind']                     = '';                
                $data['country']                        = '';                
                $data['country_id']                     = '';                
                $data['creation_date']                  = '';                
                $data['CREATEDDAT']                  	= '';                
                $data['land']                 			= '';                
                $data['adresen']                 			= array();                
                
				$groups = $this->Customer_model->get_groups();
				foreach($groups as $group){
					$group_list[$group->id] = $group->name;
				}
				$data['group_list'] = $group_list;

				$staffs = $this->Customer_model->get_staff();
				foreach($staffs as $staff){
					$staff_list[$staff->user_id] = $staff->username;
				}
				$data['staff_list'] = $staff_list;
				$webshops = $this->Customer_model->get_webshops();
				foreach($webshops as $webshop){
					$webshop_list[$webshop->shop_id] = $webshop->shop_name;
				}
				$data['webshop_list'] = $webshop_list;

                /***************************************************************************************************************
                 * existing customer
                 */
				if ($id){
				

								$this->customer_id	= $id;
					
								$customer		= $this->Customer_model->get_customer($id);
								$data['page_title']	= strtoupper($customer->firstname.' '.$customer->lastname);
								//echo $customer->NR;
								if($this->data_shop == 1 or $this->data_shop == 2){
									$data['order']		= $this->Order_model->get_customer_orders_nr($customer->NR);
									$data['invoices']	= $this->Order_model->get_customer_open_invoices_nr($customer->NR);
								}
								else {
									$data['order']		= $this->Order_model->get_customer_orders_nr($id);
									$data['invoices']	= $this->Order_model->get_customer_open_invoices_nr($id);
								}
								$order              = $this->Order_model->get_recent_orders($id);
								

								$recent_products = array();
								foreach($data['order'] as $order){

									$recent_products[] = $this->Customer_model->get_customer_orders_details($order->NR,$this->session->userdata('shop'));
								}
								
				
								//echo '<pre>';
								//print_r($recent_products);
								//echo '</pre>';
				
				
				
				
								$data['recent_products'] = $recent_products;
								
								if (!$customer){
									$this->session->set_flashdata('error', lang('error_not_found'));
									redirect($this->config->item('admin_folder').'/customers');
								}
							
								//$data['recent_products']                    = $this->Order_model->get_customer_recent_ordered_products($customer->NR,$this->session->userdata('shop'));
						
						
						
						
						
								$data['todo']						= $this->Customer_model->get_todo($this->data_shop,$customer->NR);
								
								$data['contacts']					= $this->Customer_model->get_contacts($this->data_shop,$customer->NR);
								$data['contact_persons']			= $this->Customer_model->get_contact_persons($this->data_shop,$customer->NR);
								$data['page_title']     			= $customer->company.' '.$customer->firstname;
								//echo '<pre>';
								//print_r($data['contacts']);
								//echo '</pre>';
						
						
								$data['id']								= $customer->id;
								$data['customer_number']				= $customer->customer_number;
								$data['shop_id']            			= $customer->shop_id;
								$data['company']						= $customer->company;
								$data['firstname']						= $customer->firstname;
								$data['lastname']						= $customer->lastname;
								$data['active']                         = $customer->active;
								if($this->data_shop == 3){
								$data['aproved']                        = $customer->aproved;
								}
								$data['phone']                          = $customer->phone;
								$data['fax_1']                          = $customer->fax_1;
								$data['email_1']                        = $customer->email_1;
								$data['invoice_email']                  = $customer->invoice_email;
								$data['website']                        = $customer->website;
								$data['industry']                       = $customer->industry;
								$data['group_id']						= $customer->group_id;
								$data['main_company']                   = $customer->main_company;
								$data['office_staff']					= $customer->office_staff;
								$data['number_residents']				= $customer->number_residents;
								$data['field_service']                  = $customer->field_service;
								$data['invoice_after_delivery']         = $customer->invoice_after_delivery;
								$data['payment_by_direct_debit']        = $customer->payment_by_direct_debit;
								$data['was_deleted']					= $customer->was_deleted;
								$data['stop_delivery']                  = $customer->stop_delivery;
								$data['none_VAT']                       = $customer->none_VAT;
								$data['ICL_VAT_number']                 = $customer->ICL_VAT_number;
								$data['customer_info']                  = $customer->customer_info;
								$data['account_number']                 = $customer->account_number;
								$data['account_owner']                  = $customer->account_owner;
								$data['bank_number']                    = $customer->bank_number;
								$data['bank_name']                      = $customer->bank_name;
								$data['IBAN']                           = $customer->IBAN;
								$data['BIC']                            = $customer->BIC;
								$data['sortcode']                       = $customer->sortcode;
								$data['sepa_id']                        = $customer->sepa_id;
								$data['sepa_signature_date']            = $customer->sepa_signature_date;
								$data['number_residents']               = $customer->number_residents;
								$data['monthly_invoice']                = $customer->monthly_invoice;
								$data['manager']                        = $customer->manager;
								$data['no_post']                        = $customer->no_post;
								$data['standard_payment_method']        = $customer->standard_payment_method;
								$data['payment_condition']              = $customer->payment_condition;
								$data['shop_account']                   = $customer->shop_account;
								$data['contribution_nl_account']        = $customer->contribution_nl_account;
								$data['date_contribution']              = $customer->date_contribution;
								$data['transfer_nl_account']            = $customer->transfer_nl_account;
								$data['not_remind']                     = $customer->not_remind;                
								$data['country']                        = $customer->country;
								$data['manager']                        = $customer->manager;
								$data['password_text']                  = $customer->password_text;  
								$data['creation_date']                  = $customer->creation_date;  
								$data['CREATEDDAT']                  	= $customer->CREATEDDAT;  
								$data['NR']								= $customer->NR;
						
								$data['invoice_address'] 				= $this->Order_model->get_invoice_adres($customer->NR,$this->session->userdata('shop'));//adres
								$data['delivery_address'] 				= $this->Order_model->get_delivery_adres($customer->NR,$this->session->userdata('shop'));//adres
								
								
								$data['land_g']							= $customer->TAAL;
								$data['land']							= strtoupper($customer->LANDCODE);
								

								$data['shop_account']					= $customer->shop_account;
								$data['contribution_nl_account']		= $customer->contribution_nl_account;
								$data['date_contribution']              = $customer->date_contribution;
								$data['transfer_nl_account']            = $customer->transfer_nl_account;

								$data['comments']              	 		= $this->Customer_model->get_comments(array('shop_id' => $this->session->userdata('shop'), 'customer_id' => $customer->id));

								$c 										= $this->Customer_model->get_country($customer->id);

								if($c){
								
									$country = unserialize($c->field_data);
									
								if(!empty($country['country_id'])){
									$data['countries']              = $this->Location_model->get_country($country['country_id']);
								}
								else {
									$data['countries']              = $this->Location_model->get_country($country['LANDCODE']);
								}
									$data['countries_languages']		= $this->Location_model->get_countries_menu_languages();
									
								}
						}

								$this->form_validation->set_rules('company', 'lang:company', 'trim|max_length[128]');

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
								
								$this->load->view($this->config->item('admin_folder').'/customer_form', $data);
							
							}else{

						
								$last_customer_id                  		= $this->Customer_model->get_last_id($this->data_shop);
								$last_customer_numbers             		= $this->Customer_model->get_last_customer_number($this->session->userdata('shop'));
						
								if($id){
								
									$save['id']                             = $id;
									$save['NR']                             = $this->input->post('NR');  
									$save['customer_number']                = $this->input->post('customer_number');  
								
								
								}else{
								

									$save['NR']                             = $last_customer_numbers->NR+1;
									if($this->session->userdata('shop') == 1){
										$save['customer_number']                = '2'.$last_customer_numbers->NR+1;
									}
									if($this->session->userdata('shop') == 2){
										$save['customer_number']                = '60'.$last_customer_numbers->NR+1;
									}
								}
						
						
						
						
                        $save['shop_id']                        = $this->data_shop;
                        $web_shop                               = $this->Customer_model->get_webshop($this->data_shop);
                        $save['company']						= $this->input->post('company');  
                        $save['firstname']						= $this->input->post('firstname');  
                        $save['lastname']						= $this->input->post('lastname');  
                        $save['active']                         = $this->input->post('active');  
                        $save['phone']                          = $this->input->post('phone');  
                        $save['fax_1']                          = $this->input->post('fax');  
                        $save['email_1']                        = $this->input->post('email');  
                        $save['invoice_email']                  = $this->input->post('invoice_email');  
                        $save['website']                        = $this->input->post('website');  
                        $save['industry']                       = $this->input->post('industry');  
                        $save['group_id']						= $this->input->post('group_id');  
                        $save['main_company']                   = $this->input->post('main_company');  
                        $save['office_staff']					= $this->input->post('office_staff');  
                        $save['field_service']                  = $this->input->post('field_service');  
                        $save['invoice_after_delivery']         = $this->input->post('invoice_after_delivery');  
                        $save['payment_by_direct_debit']        = $this->input->post('payment_by_direct_debit');  
                        $save['was_deleted']					= $this->input->post('was_deleted');  
                        $save['stop_delivery']                  = $this->input->post('stop_delivery');  
                        $save['none_VAT']                       = $this->input->post('none_VAT');  
                        $save['ICL_VAT_number']                 = $this->input->post('ICL_VAT_number');  
                        $save['customer_info']                  = $this->input->post('customer_info');  
                        $save['account_number']                 = $this->input->post('account_number');  
                        $save['account_owner']                  = $this->input->post('account_owner');  
                        $save['bank_number']                    = $this->input->post('bank_number');  
                        $save['bank_name']                      = $this->input->post('bank_name');  
                        $save['IBAN']                           = $this->input->post('iban');  
                        $save['BIC']                            = $this->input->post('bic');  
                        $save['sortcode']                       = $this->input->post('sortcode');  
                        $save['sepa_id']                        = $this->input->post('sepa_id');  
                        $save['sepa_signature_date']            = $this->input->post('sepa_signature_date');  
                        $save['number_residents']               = $this->input->post('number_residents');  
                        $save['monthly_invoice']                = $this->input->post('monthly_invoice');  
                        $save['manager']                        = $this->input->post('manager');  
                        $save['no_post']                        = $this->input->post('no_post');  
                        $save['standard_payment_method']        = $this->input->post('standard_payment_method');  
                        $save['payment_condition']              = $this->input->post('payment_condition');  
                        $save['shop_account']                   = $this->input->post('shop_account');  
                        $save['contribution_nl_account']        = $this->input->post('contribution_nl_account');  
                        $save['date_contribution']              = $this->input->post('date_contribution');  
                        $save['transfer_nl_account']            = $this->input->post('transfer_nl_account');  
                        $save['not_remind']                     = $this->input->post('not_remind');                  
                        $save['country']                        = $this->input->post('country');  
                        $save['password']                  		= sha1($this->input->post('password'));
                        $save['password_text']                  = $this->input->post('password');
                        $save['creation_date']                  = date('Y-m-d');  
                        $save['CREATEDDAT']                  	= date('Y-m-d');  
						$save['TAAL']							= $this->input->post('country_id'); 
						$save['LANDCODE']						= $this->input->post('country_id'); 
						$save['country_id']						= $this->input->post('country_id'); 
						

                        if( $this->input->post('standard_payment_method') == 'direct_debit'){
                            $save['DD']	= '1';
                        }

						//echo '<pre>';
						//print_r($save);
						//echo '</pre>';
						$this->Customer_model->save($save);
                        $last_id = $this->db->insert_id();
                        /************************************************************************************************
							make a customer folder
                         */
                        $dir_path = $_SERVER['DOCUMENT_ROOT'].'/varnamed/client_files/'.$id;
						$dir_path = $dir_path ."/". $last_id.'/docs';
                        
                        if(!file_exists($dir_path)){
                            mkdir($dir_path,0777,true);
                        }
                        /**************************************************************************************************/
						$this->session->set_flashdata('message', lang('message_saved_customer'));

						if(!empty($last_id)){
							redirect($this->config->item('admin_folder').'/customers/form/'.$last_id);
						}
						else {
							redirect($this->config->item('admin_folder').'/customers/form/'.$id);
						}
						
		}
    }

        function add_comment($id= FALSE){

            if($id){

              $customer                 = $this->Customer_model->get_customer($id);

              $data['customer_id']      =  $id;
              $data['shop_id']          =  $this->data_shop;
              $data['customer_name']    =  $customer->company.' '.$customer->firstname.' '.$customer->lastname;
              $data['agent_id']         =  $this->session->userdata('ba_user_id');
              $data['agent_name']       =  $this->session->userdata('ba_username');
              $data['date']             =  date('Y-m-d H-i-s');
              $data['comment']          =  $this->input->post('new_comment');

              $arr = explode(' ',trim($data['comment']));
              $title = $arr[0].' '.$arr[1].' '.$arr[2].' '.$arr[3].' '.$arr[4].' '.$arr[5].' '.$arr[6].' '.$arr[7];
              $data['comment_title']    = $title;

              if($_POST){
                $this->Customer_model->add_comment($data);
                redirect($this->config->item('admin_folder').'/customers/form/'.$id);
                }
            }
        }
        function show_comment($id = false,$comment_id = false){
                    if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
        }
            if($id || $comment_id){
                $data['comment']    =   $this->Customer_model->show_comment(array('customer_id' => $id,'comment_id' => $comment_id));
									$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
                $this->load->view($this->config->item('admin_folder').'/comment', $data);
            }
        }
        
        function client_files($id = false){
		
			if(!$this->bitauth->logged_in()){
				$this->session->set_userdata('redir', current_url());
				redirect($this->config->item('admin_folder').'/admin/login');
			}
			$this->load->helper('directory');
			$this->load->helper('file');

			$data['id'] =   $id;
				
			$data['page_title'] = lang('file_manager');
				
			$dir_path = $_SERVER['DOCUMENT_ROOT'].'/client_files/'.$id.'/docs/';
				
			if(!file_exists($dir_path)){
				mkdir($dir_path,0777,true);
			}
				
			$data['files'] = directory_map($dir_path);
			
			$data['path'] = base_url().'client_files/'.$id.'/docs';
				
				
				
				
						$timeid = $this->uri->segment(5);
						if($timeid==0){
							$time = time();
						}	
						else {
							$time = $timeid;
						}
						$data['weather']	=	_date($time);
						$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
				$this->load->view($this->config->item('admin_folder').'/customer_files', $data);
        }
		
		function delete_file($id,$file){
				
			$this->load->helper('directory');
			$this->load->helper('file');
			$this->load->helper('url');
			
			$dir_path = $_SERVER['DOCUMENT_ROOT'].'/client_files/'.$id.'/docs/';
			unlink($dir_path.$file);

			redirect($this->config->item('admin_folder').'/customers/client_files/'.$id);
		}
		
        function do_upload($id=false){
            
            $dir_path = $_SERVER['DOCUMENT_ROOT'].'/client_files/'.$id.'/docs';
            if(!file_exists($dir_path)){
                    mkdir($dir_path,0777,true);
                }
            $config['upload_path'] = FCPATH.'/client_files/'.$id.'/docs'; 

            $config['allowed_types'] = '*';
            

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload()){

            $error = array('error' => $this->upload->display_errors());

            redirect($this->config->item('admin_folder').'/customers/client_files/'.$id);
            //print_r($error);
            }
            else
            {
            $data = array('upload_data' => $this->upload->data());
            redirect($this->config->item('admin_folder').'/customers/client_files/'.$id);

            }
	}   

        
                function addresses($NR = false){
				
					if(!$this->bitauth->logged_in()){
						$this->session->set_userdata('redir', current_url());
						redirect($this->config->item('admin_folder').'/admin/login');
					}
					
                    $data['categories'] 	= $this->categories;
                    $data['groups']     	= $this->groups;
                    $data['products']   	= $this->products;
                    $data['all_shops']  	= $this->Shop_model->get_shops();
                    $data['customer']   	= $this->Customer_model->get_customer_nr($NR);

                    if (!$data['customer']){
                        $this->session->set_flashdata('error', lang('error_not_found'));
                        redirect($this->config->item('admin_folder').'/customers');
                    }
					if(empty($this->session->userdata('back'))){
						$this->session->set_userdata('back',$_SERVER['HTTP_REFERER']);
					}
					
					$customer					= $this->Customer_model->get_customer_nr($NR);
					$data['c_id'] 				= $customer->id;
                    $data['back_location']      = $this->session->userdata('back');
                    $data['customer_id']        = $data['customer']->id;
                    $data['id']                 = $NR;
                    $data['addresses']          = $this->Customer_model->get_addresses($NR,$this->data_shop);
                    $data['page_title']         = sprintf(lang('addresses_for'), $data['customer']->firstname.' '.$data['customer']->lastname);
					
					$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
                    $this->load->view($this->config->item('admin_folder').'/customer_addresses', $data);
            }

			
	function set_address($nr = false){

                if ($nr){
                    
                   
                    $invoice_address    = $this->input->post('invoice_address');
				    $delivery_address   = $this->input->post('delivery_address');

                    $check_invoice_address = $this->Customer_model->check_invoice_address(array('RELATIESNR' => $nr, 'invoice_address'   => $invoice_address));
					$check_delivery_address = $this->Customer_model->check_delivery_address(array('RELATIESNR' => $nr, 'delivery_address'   => $delivery_address));

                    foreach ($check_invoice_address as $i){

                       $this->Customer_model->update_invoice_address(array('RELATIESNR' => $nr, 'existing_index'  => $i['id'],'new_index'   => $invoice_address)); 
                    }
                    foreach ($check_delivery_address as $d){
                       $this->Customer_model->update_delivery_address(array('RELATIESNR' => $nr, 'existing_index'  => $d['id'],'new_index'   => $delivery_address)); 
                    }
					
                    if(!empty($delivery_address) and !empty($invoice_address)){
                        $this->session->set_flashdata('message', lang('invoice_and_delivery_address_changed'));    
                    }
					
                    redirect($this->config->item('admin_folder').'/customers/addresses/'.$nr);
				}
                else {
					$this->session->set_flashdata('error', lang('error_not_found'));
					redirect($this->config->item('admin_folder').'/customers');
				}
				
			}
	
	function delete($id = false){
		if ($id){	
			$customer	= $this->Customer_model->get_customer($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$customer){
				$this->session->set_flashdata('error', lang('error_not_found'));
				redirect($this->config->item('admin_folder').'/customers');
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
			redirect($this->config->item('admin_folder').'/customers');
		}
	}
	
	//this is a callback to make sure that customers are not sharing an email address
	public function check_email($str)
	{
		$email = $this->Customer_model->check_email($str, $this->customer_id);
        	if ($email)
        	{
			$this->form_validation->set_message('check_email', lang('error_email_in_use'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function order_list($status = false){
        if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
        }
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
	
	
	// download email blast list (subscribers)
	function get_subscriber_list(){
	
	        if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
        }

		$subscribers = $this->Customer_model->get_subscribers();
		
		$sub_list = '';
		foreach($subscribers as $subscriber)
		{
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
	
	//  customer groups
	function groups(){
	
	
	
	        if(!$this->bitauth->logged_in()) {
			
			$this->session->set_userdata('redir', current_url());
			redirect($this->config->item('admin_folder').'/admin/login');
		}
		$data['groups']		= $this->Customer_model->get_groups();
		$data['page_title']	= lang('customer_groups');
		$data['all_shops']  =   $this->Shop_model->get_shops();
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
        if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
        }
                                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
            $data['all_shops']  =   $this->Shop_model->get_shops();

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['page_title']		= lang('customer_group_form');

		$data['id']			= '';
		$data['name']   		= '';
		$data['discount']		= '';
		$data['discount_type']          = '';
		
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
			$this->load->view($this->config->item('admin_folder').'/customer_group_form', $data);
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
			redirect($this->config->item('admin_folder').'/customers/groups');
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
		redirect($this->config->item('admin_folder').'/customers/groups');
	}
	
	function address_list($customer_id){

				if(!$this->bitauth->logged_in()){
					$this->session->set_userdata('redir', current_url());
					redirect($this->config->item('admin_folder').'/admin/login');
				}
                //menu items
                $data['categories'] 	= $this->categories;
                $data['groups']     	= $this->groups;
                $data['products']   	= $this->products;
                $data['all_shops']  	= $this->Shop_model->get_shops();
            
				$data['address_list'] 	= $this->Customer_model->get_address_list($customer_id);
							
				
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
	
	function address_form($customer_nr, $id = false) {
				
				if(!$this->bitauth->logged_in()){
					$this->session->set_userdata('redir', current_url());
					redirect($this->config->item('admin_folder').'/admin/login');
				}
                //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['all_shops']  = $this->Shop_model->get_shops();
				$data['page_title'] = lang('address_form');
				
                ////////////////////////////////////////////////////////////////
            
				$data['id']							= $id;
				$data['NAAM1']						= '';
				$data['NAAM2']						= '';
				$data['NAAM3']						= '';
				$data['email']						= '';
				$data['phone']						= '';
				$data['STRAAT']						= '';
				$data['HUISNR']						= '';
				$data['PLAATS']						= '';
				$data['LANDCODE']					= '';
				$data['POSTCODE']					= '';
				$data['type']						= '';
				$data['customer_addresses']			= $this->Customer_model->get_all_addresses($customer_nr,$this->session->userdata('shop'));
				
				$data['customer_nr']	= $customer_nr;
				$data['customer']       = $this->Customer_model->get_customer_nr($customer_nr);

				$data['countries_menu']	= $this->Location_model->get_countries_menu();
		
				if($id) {
	
					$data['address']	= $this->Customer_model->get_address($id);
	
					$data['NAAM1']		= $data['address']->NAAM1;
					$data['NAAM2']		= $data['address']->NAAM2;
					$data['NAAM3']		= $data['address']->NAAM3;
					$data['email']		= $data['address']->email;
					$data['phone']		= $data['address']->phone;
					$data['STRAAT']		= $data['address']->STRAAT;
					$data['HUISNR']		= $data['address']->HUISNR;
					$data['PLAATS']		= $data['address']->PLAATS;
					$data['LANDCODE']	= strtoupper($data['address']->LANDCODE);
					$data['POSTCODE']	= $data['address']->POSTCODE;
					$data['type']		= $data['address']->SOORT;
					$data['zones_menu']	= $this->Location_model->get_zones_menu($data['LANDCODE']);
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
					
					$this->load->view($this->config->item('admin_folder').'/customer_address_form', $data);
				
				if($_POST){
			
				$country_array = array(
					'BEL'	=> 'Belgique',
					'BE'	=> 'België',
					'DE'	=> 'Deutschland',
					'FR'	=> 'France',
					'LX'	=> 'Luxembourg',
					'NL'	=> 'Nederland',
					'UK'	=> 'United Kingdom',
					'AT'	=> 'Österreich',
				);

				if(!empty($id)){
					$a['id'] = $id;
				}

				$a['RELATIESNR']	= $customer_nr;
				$a['shop_id']		= $this->data_shop;
				$a['NAAM1']			= $this->input->post('NAAM1');
				$a['NAAM2']			= $this->input->post('NAAM2');
				$a['NAAM3']			= $this->input->post('NAAM3');
				$a['email']			= $this->input->post('email');
				$a['phone']			= $this->input->post('phone');
				$a['STRAAT']		= $this->input->post('STRAAT');
				$a['HUISNR']		= $this->input->post('HUISNR');
				$a['PLAATS']		= $this->input->post('PLAATS');
				$a['POSTCODE']		= $this->input->post('POSTCODE');
				$a['LANDCODE']		= $this->input->post('LANDCODE');
				$a['SOORT']			= $this->input->post('SOORT');
				$a['LAND']			= $country_array[$this->input->post('LANDCODE')];
				//echo '<pre>';
				//print_r($a);
				//echo '</pre>';
				$this->Customer_model->save_address($a);
				$this->session->set_flashdata('message', lang('message_saved_address'));
				redirect($this->config->item('admin_folder').'/customers/addresses/'.$customer_nr);
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
					redirect($this->config->item('admin_folder').'/customers/addresses/'.$customer_id);
				}
				else
				{
					redirect($this->config->item('admin_folder').'/customers');
				}
				
			}
			else{
				//if the customer is legit, delete them
				$delete	= $this->Customer_model->delete_address($id, $customer_id);				
				$this->session->set_flashdata('message', lang('message_address_deleted'));
				
				if($customer_id){
					redirect($this->config->item('admin_folder').'/customers/addresses/'.$customer_id);
				}
				else{
					redirect($this->config->item('admin_folder').'/customers');
				}
			}
		}
		else{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('error_address_not_found'));
			
			if($customer_id){
				redirect($this->config->item('admin_folder').'/customers/addresses/'.$customer_id);
			}
			else{
				redirect($this->config->item('admin_folder').'/customers');
			}
		}
	}
        
		function erase_adres($c_nr,$id){
		
			$this->Customer_model->erase_adres($id,$this->session->userdata('shop'));
			redirect($this->config->item('admin_folder').'/customers/addresses/'.$c_nr);
		}
		
			public function products($id,$order_by="productnr", $sort_order="ASC", $code=0, $page=0, $rows=15){
				
					force_ssl();
					
					if(!$this->bitauth->logged_in()){
						$this->session->set_userdata('redir', current_url());
						redirect($this->config->item('admin_folder').'/admin/login');
					}

					$data['categories'] 			= $this->categories;
					$data['groups']     			= $this->groups;
					$data['products']   			= $this->products;
					$data['all_shops']  			= $this->Shop_model->get_shops();
					$data['code']					= $code;
					$data['order_by']               = $order_by;
					$data['sort_order']             = $sort_order;
              
					if ($id){

						$this->customer_id			= $id;	
						$customer					= $this->Customer_model->get_customer($id);                        

						if($this->data_shop == 1 or $this->data_shop == 2){
							$data['order']		= $this->Order_model->get_customer_orders_nr($customer->NR);
							$data['invoices']	= $this->Order_model->get_customer_open_invoices_nr($customer->NR);
						}
						else {
							$data['order']		= $this->Order_model->get_customer_orders_nr($id);
							$data['invoices']	= $this->Order_model->get_customer_open_invoices_nr($id);
						}
						$order              	= $this->Order_model->get_recent_orders($id);
							
						$recent_products = array();
							foreach($data['order'] as $order){
								$recent_products[] = $this->Customer_model->get_customer_orders_details($order->NR,$this->session->userdata('shop'));
						}

						$data['recent_products'] 	= $recent_products;
						$data['saleprice_name'] 	= 'Single price '.strtoupper($customer->LANDCODE);

						//echo '<pre>';
						//print_r($recent_products);
						//echo '</pre>';
						
						if (!$customer){
							$this->session->set_flashdata('error', lang('error_not_found'));
							redirect($this->config->item('admin_folder').'/customers');
						}
						//set values to db values
						$data['id']					= $customer->id;
						$data['group_id']			= $customer->group_id;
						$data['firstname']			= $customer->firstname;
						$data['lastname']			= $customer->lastname;
						$data['email']				= $customer->email_1;
						$data['phone']				= $customer->phone;
						$data['company']			= $customer->company;
						$data['active']				= $customer->active;
						$data['email_subscribe']    = $customer->email_subscribe;
					}
				
                //page content end
					$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));

					$this->load->view($this->config->item('admin_folder').'/customer_products', $data);
			}

        public function invoices($id , $order_by="productnr", $sort_order="ASC", $code=0, $page=0, $rows=15){ 
        if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
        }
                            //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
            $data['all_shops']  =   $this->Shop_model->get_shops();
            
                $data['page_title']             = lang('customer_invoices');
                //page content start

                force_ssl();
		$this->load->helper('form');
		$this->load->library('form_validation');
                $data['code']		= $code;


		$data['order_by']               = $order_by;
		$data['sort_order']             = $sort_order;
              
		// get group list
		$groups = $this->Customer_model->get_groups();
		foreach($groups as $group){

                    $group_list[$group->id] = $group->name;

		}
                
		$data['group_list'] = $group_list;

		if ($id){

			$this->customer_id	= $id;
                        $this->load->model('Order_model');
                        $this->load->model('Invoice_model');
                        
                        $data['order']		= $this->Order_model->get_order($id);

                        $data['invoice']        = $this->Invoice_model->get_client_invoice($id);

                        
                        
			$customer		= $this->Customer_model->get_customer($id);                        
                        $order                  = $this->Order_model->get_order_details($id);

			if (!$customer){
				$this->session->set_flashdata('error', lang('error_not_found'));
				redirect($this->config->item('admin_folder').'/customers');
			}
			//set values to db values
			$data['id']				= $customer->id;
			$data['group_id']			= $customer->group_id;
			$data['firstname']			= $customer->firstname;
			$data['lastname']			= $customer->lastname;
			$data['email']				= $customer->email;
			$data['phone']				= $customer->phone;
			$data['company']			= $customer->company;
			$data['active']				= $customer->active;
			$data['email_subscribe']                = $customer->email_subscribe;
		}

                //page content end

					$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
		$this->load->view($this->config->item('admin_folder').'/customer_invoices', $data);
        }
        
        public function payments($id){
             if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
        }
                //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
            $data['all_shops']  =   $this->Shop_model->get_shops();
            
                $data['page_title']             = lang('customer_payments');
                //page content start
					$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
		$this->load->view($this->config->item('admin_folder').'/customer_payments', $data);
        }
        
        
        public function make_offer($id){
		
				if($this->session->userdata('shop') == 1){
					$agent_id				= $this->session->userdata('ba_c_login');
				}
				if($this->session->userdata('shop') == 2){
					$agent_id				= $this->session->userdata('ba_d_login');
				}
				if($this->session->userdata('shop') == 3){
					$agent_id				= $this->session->userdata('ba_g_login');
				}

				$offer['shop_id']		=	$this->session->userdata('shop');
				$offer['client_id']		=	$this->input->post('client_id');
				$offer['agent_name']	=	$this->session->userdata('ba_username');
				$offer['agent_id']		=	$agent_id;
				$offer['date_made']		=	date('Y-m-d H:i:s');
				$offer_arr					=	$this->input->post('products');
				
				$t = array();
				foreach($offer_arr as $p){
					$t[] = $this->Order_model->get_price_list_product($p);
				}
				$offer['offer']			=	serialize($t);

				//echo '<pre>';
				//print_r(serialize($t));
				//echo '</pre>';				
				$this->Offer_model->save_the_offer($offer);
				redirect($this->config->item('admin_folder').'/offer/all/'.$id);

        }
        
        public function prices($id , $order_by="productnr", $sort_order="ASC", $code=0, $page=0, $rows=15){
        
						if(!$this->bitauth->logged_in()){
							$this->session->set_userdata('redir', current_url());
							redirect($this->config->item('admin_folder').'/admin/login');
						}
						
						force_ssl();
						$data['categories']             = $this->categories;
						$data['groups']                 = $this->groups;
						$data['products']               = $this->products;
						$data['all_shops']              = $this->Shop_model->get_shops();
						$data['page_title']             = lang('customer_prices');
						$data['code']                   = $code;


						$data['order_by']               = $order_by;
						$data['sort_order']             = $sort_order;
						
						if($this->session->userdata('shop') == 1){
							$agent_id				= $this->session->userdata('ba_c_login');
						}
						if($this->session->userdata('shop') == 2){
							$agent_id				= $this->session->userdata('ba_d_login');
						}
						if($this->session->userdata('shop') == 3){
							$agent_id				= $this->session->userdata('ba_g_login');
						}
						
						if ($id){

						$customer                               = $this->Customer_model->get_customer($id);                        
						if (!$customer){
							$this->session->set_flashdata('error', lang('error_not_found'));
							redirect($this->config->item('admin_folder').'/customers');
						}
						$data['id']				= $customer->id;

                        $data['price_list']                     = $this->Order_model->get_price_list($customer->NR,  $this->session->userdata('shop'));
                        $index                                  = strtoupper($customer->TAAL);
                        $data['index']                          = $index;
                        $saleprice_index = 'name_'.$index;
						
						
                        if(!empty($_POST)){
                        
                        $a_1 = $this->input->post('product_number');
                        $a_2 = $this->input->post('quantity');
                        $a_3 = $this->input->post('unit_price');
                            
                        $key = count($this->input->post('product_number')); 
                            
                        for($i = 0;$i < $key; $i++) { 
                            
						@$new_array[] = array(

                            'code'                  =>  $a_1[$i],
                            'quantity'              =>  $a_2[$i],
                            'new_price'             =>  $a_3[$i],
                            );			
                        }
                        $nums           = $this->input->post('product_number');

                        foreach ($nums as $num){
                            if(is_numeric($num)){
                                $num_new = $num.'/';
                            }
                            else {
                                $num_new = $num;
                            }
                                $f[] 	=  $this->Product_model->get_offers_product($this->data_shop,$num_new,$index);				
						}
                        $f =  json_decode( json_encode($f), true);
			
						for($i = 0;$i < $key; $i++) { 
										$product_array[] = array_merge($new_array[$i],$f[$i]);
						}
                        foreach ($product_array as $item ){
                            
                            $discount_1 = ($item['saleprice_'.$index] - $item['new_price'])/$item['saleprice_'.$index]*100;
                            $discount = round($discount_1,2);
                            
                            $new_product_details[] = array(
                                
                                'shop_id'       => $this->data_shop,
                                'RELATIESNR'    => $customer->NR,
                                'ARTIKELCOD'    => $item['code'],
                                'VE'            => $item['package_details'],
                                'KORTING'       => $discount,
                                'saleprice'    	=> $item['new_price'],
                                'REGELNR'    	=> $item['quantity'],
                                'description'   => $item[$saleprice_index],
                                'OSTUKSPRIJ'    => $item['saleprice_'.$index],
                                'WAREHOUSE'     => $item['warehouse_price'],
                                'INVDATUM'      => date('Y-m-d H:i:s'),
								'INVLOGINNR'	=> $agent_id,
								'MADE_BY'		=> $this->session->userdata('ba_username'),
                            );
                        }
						
						//echo '<pre>';
							//print_r($new_product_details);
						//echo '</pre>';
						
						
						
                       $this->Order_model->insert_discount_price($new_product_details);
                       redirect($this->config->item('admin_folder').'/customers/prices/'.$id);
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
					$this->load->view($this->config->item('admin_folder').'/customer_prices', $data);
        }
        public function activate($product_id,$customer_id){

				if($product_id){

                    $this->Order_model->activate_discount_products($product_id);
				} else {
                    
					$this->session->set_flashdata('error', lang('error_no_products_selected'));
				}
				
				redirect($this->config->item('admin_folder').'/customers/prices/'.$customer_id);
        }

		
        public function delete_discount_product($product_id,$customer_id){

				if($product_id){

                    $this->Order_model->delete_discount_products($product_id);
					$this->session->set_flashdata('message', 'Products are deleted');
				} else {
                    
					$this->session->set_flashdata('error', lang('error_no_orders_selected'));
				}
				
				redirect($this->config->item('admin_folder').'/customers/prices/'.$customer_id);
        }

        public function newApplication($id){
        if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
        }
                //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['all_shops']  = $this->Shop_model->get_shops();
                $data['page_title'] = lang('new_price_list');
					$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
		$this->load->view($this->config->item('admin_folder').'/customer_new_price_list', $data);
        }
        public function newCollectionContract($id){
        if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
        }
                //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['all_shops']  =   $this->Shop_model->get_shops();
                
                
                $data['page_title']             = lang('customer_new_collection_contract');
                //page content start
					$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
		$this->load->view($this->config->item('admin_folder').'/customer_new_collection_contract', $data);
        }
        public function save_list(){
            
        }
        public function delete_list(){
            
        }

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		



//END OF THE CLASS//
}