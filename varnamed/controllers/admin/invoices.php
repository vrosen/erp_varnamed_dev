<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoices extends CI_Controller {

        public $data_shop;
        public $language;
        protected $shop_id;
        ////////////////////////////////////////////////////////////////////////////
        private $products;
        private $groups;
        private $categories;
        ////////////////////////////////////////////////////////////////////////////
        
          function __construct(){		
		parent::__construct();

				remove_ssl();
				$this->load->model(array('Invoice_model','Group_model','Product_model','Category_model','Shop_model'));
				$this->load->model('Search_model');
				$this->load->model('location_model');
                $this->load->model('Gift_card_model');
                $this->load->model('Messages_model');
                $this->load->model('Order_model');
                ////////////////////////////////////////////////////////////////
				$this->load->helper(array('formatting'));
                $this->load->helper(array('form', 'date','array'));
				$this->load->library('form_validation');
                ////////////////////////////////////////////////////////////////
                $this->language     = $this->session->userdata('language');
                $this->data_shop    = $this->session->userdata('shop');
                $this->shop_id      = $this->session->userdata('shop');
                ////////////////////////////////////////////////////////////////
                $this->lang->load('invoices',  $this->language);
                $this->lang->load('dashboard',  $this->language);
                $this->lang->load('order',  $this->language);
                $this->lang->load('product',  $this->language);
                ////////////////////////////////////////////////////////////////
                $this->groups                   = $this->Group_model->get_all_the_groups();
                $this->products                 = $this->Product_model->get_all_products();
                $this->categories               = $this->Category_model->get_all_categories();
                ////////////////////////////////////////////////////////////////
	}
	
	function index($sort_by='invoice_number',$sort_invoice='desc', $code=0, $page=0, $rows=15) {
		
					if(!$this->bitauth->logged_in()){
					$this->session->set_userdata('redir', current_url());
					redirect($this->config->item('admin_folder').'/admin/login');
					}
                //menu items
                $data['categories'] 	= $this->categories;
                $data['groups']     	= $this->groups;
                $data['products']   	= $this->products;
                $data['current_shop']   = $this->data_shop;
                $data['all_shops']  	= $this->Shop_model->get_shops();
                $data['page_title'] 	= lang('invoices');

				$data['code']			= $code;
				$data['sort_by']		= $sort_by;
				$data['sort_invoice']	= $sort_invoice;
				$term					= false;
				$post                   = $this->input->post(null, false);
				if($post){
					$term			= json_encode($post);
					$data['code']	= $code;
					$term	= (object)$post;
				}
				elseif ($code){
					$term	= json_decode($term);
				} 
				
				$data['term']           		= $term;
				
				if($this->session->userdata('shop') == 1){
					$agent_customers = $this->Customer_model->get_all_clients_array_agent_new($this->session->userdata('ba_c_login'),$this->session->userdata('shop'));
				}
				if($this->session->userdata('shop') == 2){
					$agent_customers = $this->Customer_model->get_all_clients_array_agent_new($this->session->userdata('ba_d_login'),$this->session->userdata('shop'));
				}
				if($this->session->userdata('shop') == 3){
					$agent_customers = $this->Customer_model->get_all_clients_array_agent_new($this->session->userdata('ba_g_login'),$this->session->userdata('shop'));
				}
				


				
				if($this->bitauth->is_admin()){
					$data['invoices']               = $this->Invoice_model->get_invoices($term, $sort_by, $sort_invoice, $rows, $page,  $this->data_shop);
					$invoices = $data['invoices'];
				}else {

				foreach($agent_customers as $customer){
					$invoices[]             = $this->Invoice_model->get_invoices_for_agent($term, $sort_by, $sort_invoice, $rows, $page,  $this->data_shop,$customer['NR']);
				}
				$data['invoices']	=	$invoices;
				
				}

						
				$this->load->library('pagination');
				
				$config['base_url']		= site_url($this->config->item('admin_folder').'/invoices/index/'.$sort_by.'/'.$sort_invoice.'/'.$code.'/');
				$config['total_rows']		= count($invoices);
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
				$this->load->view($this->config->item('admin_folder').'/open_invoices', $data);
	}
	
	function invoices_print($sort_by='invoice_number',$sort_invoice='desc', $code=0, $page=0, $rows=15) {
			        if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
			}
	
                //menu items
                $data['categories'] 	= $this->categories;
                $data['groups']     	= $this->groups;
                $data['products']   	= $this->products;
				$data['current_shop']   = $this->data_shop;
                $data['all_shops']  	= $this->Shop_model->get_shops();
                $data['page_title'] 	= lang('invoices');

				$data['code']			= $code;
				$data['sort_by']		= $sort_by;
				$data['sort_invoice']	= $sort_invoice;
				$term					= false;
				$post                   = $this->input->post(null, false);
				if($post){
					$term			= json_encode($post);
					$data['code']	= $code;
					$term	= (object)$post;
				}
				elseif ($code){
					$term	= json_decode($term);
				} 
				
				
				
				
				$data['term']           = $term;
				$data['invoices']               = $this->Invoice_model->get_invoices_for_print($term, $sort_by, $sort_invoice, $rows, $page,  $this->data_shop);

				$data['total']                  = $this->Invoice_model->get_invoices_count($term);
						
				$this->load->library('pagination');
				
				$config['base_url']		= site_url($this->config->item('admin_folder').'/invoices/index/'.$sort_by.'/'.$sort_invoice.'/'.$code.'/');
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
				$this->load->view($this->config->item('admin_folder').'/open_invoices_print', $data);
	}

	public function view($id){
	
					if(!$this->bitauth->logged_in()){
							$this->session->set_userdata('redir', current_url());
							redirect($this->config->item('admin_folder').'/admin/login');
					}
                    $data['categories'] = $this->categories;
                    $data['groups']     = $this->groups;
                    $data['products']   = $this->products;
                    $data['all_shops']  = $this->Shop_model->get_shops();
                    $data['page_title'] = lang('view_invoice');
                
                if($id){
                    
                    $data['id']                 		= $id;
                    $data['invoice']            		= $this->Invoice_model->get_invoice($id);

                    $email                      		= $this->Order_model->get_order_detail($data['invoice']->order_number);
                    
                    if(!empty($email->email)){
                        $data['email']              	= $email->email;
                    }
                    else {
                       $data['email']              		= $data['invoice']->email;
                    }
                    if(!empty($email->ordered_on)){
                       $data['order_date']         		= $email->ordered_on; 
                    }
                    else {
                        $data['order_date']         	= $data['invoice']->order_dispatch_date;
                    }
					

					$data['invoice_address'] 	= $this->Order_model->get_invoice_adres($data['invoice']->customer_id,$this->session->userdata('shop'));//adres
					$data['delivery_address'] 	= $this->Order_model->get_delivery_adres($data['invoice']->customer_id,$this->session->userdata('shop'));//adres

					
					
                    $data['order_details']      		= $this->Order_model->get_order_costs($data['invoice']->order_number);
                    $order_vat_index					= $this->Order_model->get_order_vat($data['invoice']->order_number);
                    $data['ordered_products']   		= $this->Invoice_model->get_items($data['invoice']->invoice_number);
                    $data['customer_id'] 				= $data['invoice']->customer_id;
					$data['c_id']						= $this->Invoice_model->get_customer_db_id($data['customer_id']);
                    $filename          					= $data['invoice']->invoice_number;
                    $customer_id       		 			= $data['invoice']->customer_id;
                    $data['credit_notes']				= $this->Invoice_model->get_invoice_credit_notes(array('id'=>$id,'invoice_number'=>$data['invoice']->invoice_number));
					
					$customer_details 			= 	$this->Customer_model->get_client_details_by_nr($customer_id,$this->session->userdata('shop'));
					$customer_land_code 		= 	strtoupper($customer_details->LANDCODE);
					$customer_vat_index 		=	$this->Customer_model->get_country_data_by_index($customer_land_code);
					$data['customer_vat_index']	=	$customer_vat_index->tax;
					
					$data['VAT_N'] = '';
					$data['VAT_D'] = '';
					$data['n_vat'] = array();
					$data['d_vat'] = array();
					$data['shipping_costs'] 		= $data['invoice']->dispatch_costs;
					$data['vat_shipping_costs'] 	= '';
					$data['vat_shipping_costs_d'] 	= '';
					$data['order_vat_index'] 		= $order_vat_index['vat_index'];


                    $pdfFilePath        = FCPATH.'/client_files/'.$customer_id.'/docs/'.$filename.'.pdf';

                    if (file_exists($pdfFilePath)) {

                        $data['invoices_pdf'] = scandir(FCPATH.'/client_files/'.$customer_id.'/docs/');    

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
                    $this->load->view($this->config->item('admin_folder').'/invoice', $data);
                }
                else {
                    $this->session->set_flashdata('message', lang('sent_notification_message'));
                    redirect($this->config->item('admin_folder').'/invoices');
                }		
            }
        public function update($id){
		
			        if(!$this->bitauth->logged_in()){
						$this->session->set_userdata('redir', current_url());
						redirect($this->config->item('admin_folder').'/admin/login');
					}

                    //menu items
                    $data['categories'] = $this->categories;
                    $data['groups']     = $this->groups;
                    $data['products']   = $this->products;
                    $data['all_shops']  = $this->Shop_model->get_shops();
                    $data['page_title'] = lang('view_invoice');
                
                if($id){


                    

				if($_POST){
				
				
					$update_data['company']				=	$this->input->post('company');
					$update_data['firstname']			=	$this->input->post('firstname');
					$update_data['lastname']			=	$this->input->post('lastname');
					$update_data['delivery_condition']	=	$this->input->post('delivery_condition');
					$update_data['payment_condition']	=	$this->input->post('payment_condition');
					$update_data['email']				=	$this->input->post('email');
					$update_data['totalgross']			=	$this->input->post('totalgross');
					$update_data['totalnet']			=	$this->input->post('totalnet');
					$update_data['dispatch_costs']		=	$this->input->post('dispatch_costs');
					$update_data['VAT']					=	$this->input->post('VAT');
					$update_data['payment_info']		=	$this->input->post('payment_info');
					$update_data['notes']				=	$this->input->post('invoice_note');
					$update_data['ship_vat_rate']				=	$this->input->post('ship_vat_rate');
					
				
					$this->Invoice_model->change_invoice($id,$this->input->post('invoice_number'),$update_data,$this->session->userdata('shop')); 

					echo '<pre>';
					print_r($update_data);
					echo '</pre>';
					
					$s_e = $this->input->post('invoice_per_email');
					if(!empty($s_e)){
						$this->Invoice_model->set_send_type($id,$this->input->post('invoice_number'), 1);
					} else {
						$this->Invoice_model->set_send_type($id,$this->input->post('invoice_number'), 0);
					}
					
					$fully_paid 			= $this->input->post('invoice_paid');
					$invoice_date 			= $this->input->post('invoice_date');
					if(!empty($fully_paid)){
							$this->Invoice_model->set_fully_paid_date($id,$this->input->post('invoice_number'),1,$invoice_date); 
                        }
                        else {
							$this->Invoice_model->set_fully_paid($id,$this->input->post('invoice_number'),0); 
                    }
				
				
                /***************************************************************************************************************************************/    

				
				$key = count($this->input->post('code')); 

				$a_1    = $this->input->post('product_id');
				$a_2    = $this->input->post('code');
				$a_3    = $this->input->post('quantity');
				$a_4    = $this->input->post('vpa');
				$a_5    = $this->input->post('unit_price');
				$a_6    = $this->input->post('total');
				$a_7    = $this->input->post('description');
				$a_8    = $this->input->post('vat_ammount');
				
				for($i = 0; $i < $key; $i++) { 
				
				if(!empty($a_1[$i])){
					$a_id      					=  $a_1[$i];
				
					$new_array_1[] = array(
							'id'      			=>  $a_id,
							'shop_id'			=>	$this->session->userdata('shop'),
							//'order_id'			=>	$this->input->post('order_id'),
							'order_number'		=>	$this->input->post('order_number'),
							'invoice_number'	=>	$this->input->post('invoice_number'),
							'code'      		=>  $a_2[$i],
							'description'       =>  $a_7[$i],
							'quantity'      	=>  $a_3[$i],
							'unit_price'        =>  $a_5[$i],
							'total'        		=>  $a_6[$i],
							'vpa'            	=>  $a_4[$i],
							'vat_ammount'       =>  $a_8[$i],
						);		
					}
					else {
					
					$new_array_1[] = array(

							'shop_id'			=>	$this->session->userdata('shop'),
							//'order_id'			=>	$this->input->post('order_id'),
							'order_number'		=>	$this->input->post('order_number'),
							'invoice_number'	=>	$this->input->post('invoice_number'),
							'code'      		=>  $a_2[$i],
							'description'       =>  $a_7[$i],
							'quantity'      	=>  $a_3[$i],
							'unit_price'        =>  $a_5[$i],
							'total'        		=>  $a_5[$i]*$a_3[$i],
							'vpa'            	=>  $a_4[$i],
							'vat_ammount'       =>  $a_8[$i],
						);

					}
					
				}
			}	

				$this->Invoice_model->update_invoice($new_array_1);
				//echo '<pre>';
				//print_r($new_array_1);
				//echo '</pre>';
				

				/***************************************************************************************************************************************/  	
                redirect($this->config->item('admin_folder').'/invoices/view/'.$id);
                }
                else {
                    $this->session->set_flashdata('message', lang('sent_notification_message'));
					redirect($this->config->item('admin_folder').'/invoices');
                }		
            }
        
		public function remove($row_id,$id){
	

			$this->Invoice_model->remove_item($row_id);
			redirect($this->config->item('admin_folder').'/invoices/view/'.$id);
		}
		
		public function packing_slip($invoice_id){
		        
				if(!$this->bitauth->logged_in()){
				$this->session->set_userdata('redir', current_url());
				redirect($this->config->item('admin_folder').'/admin/login');
			
			}
	
                            //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['all_shops']  =   $this->Shop_model->get_shops();
                
                
		$this->load->helper('date');
		$data['invoice']		= $this->Invoice_model->get_invoice($invoice_id);
								$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
		$this->load->view($this->config->item('admin_folder').'/packing_slip.php', $data);
	}
	
	public function edit_status(){

    	$invoice['id']		= $this->input->post('id');
    	$invoice['status']	= $this->input->post('status');
    	
    	$this->Invoice_model->save_invoice($invoice);
    	
    	echo url_title($invoice['status']);
        
        }   

        public function send_notification($invoice_id=''){
            
            
            
			// send the message
   		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);

		$this->email->from($this->config->item('email'), $this->config->item('company_name'));
		$this->email->to($this->input->post('recipient'));
		
		$this->email->subject($this->input->post('subject'));
		$this->email->message(html_entity_decode($this->input->post('content')));
		
		$this->email->send();
		
		$this->session->set_flashdata('message', lang('sent_notification_message'));
		redirect($this->config->item('admin_folder').'/invoices/view/'.$invoice_id);
	}

	public function bulk_delete() {
	
    	
            $invoices	= $this->input->post('invoice');
    	
		if($invoices){
			foreach($invoices as $invoice){
	   			$this->Invoice_model->delete($invoice);
	   		}
			$this->session->set_flashdata('message', lang('message_invoices_deleted'));
		}
		else{
			$this->session->set_flashdata('error', lang('error_no_invoices_selected'));
		}
   		//redirect as to change the url
		redirect($this->config->item('admin_folder').'/invoices');	
        }
	public function set_printed() {
	
    	
            $invoices	= $this->input->post('invoice');
    	
		if($invoices){
			foreach($invoices as $invoice){
	   			$this->Invoice_model->printed_invoice($invoice);
	   		}
			$this->session->set_flashdata('message', 'Invoice printed');
		}
		else{
			$this->session->set_flashdata('error', lang('error_no_invoices_selected'));
		}
   		//redirect as to change the url
		redirect($this->config->item('admin_folder').'/invoices_print');	
        }
        public function invoice_list($sort_by='invoice_number',$sort_invoice='desc', $code=0, $page=0, $rows=100){

				if(!$this->bitauth->logged_in()){
				$this->session->set_userdata('redir', current_url());
				redirect($this->config->item('admin_folder').'/admin/login');
				}

                //menu items
                $data['categories']     = $this->categories;
                $data['groups']         = $this->groups;
                $data['products']       = $this->products;
                $data['all_shops']      = $this->Shop_model->get_shops();
                $data['page_title']		= lang('invoice_list');
				$data['message']		= $this->session->flashdata('message');
				$data['current_shop']   = $this->data_shop;
				$data['code']			= $code;

				$post_year				= $this->input->post('year');
				$post_month				= $this->input->post('month');
				$post_start_day			= $this->input->post('start_date');
				$post_end_day			= $this->input->post('end_date');
				$unset_days				= $this->input->post('unset_days');
				$post_status			= $this->input->post('invoice_status');
				$post_sent				= $this->input->post('sent');
				$post_country			= $this->input->post('country');
				$payment_method			= $this->input->post('payment_method');
				$export					= $this->input->post('export');


				if(!empty($_POST)){

					if(!empty($post_year)){
						$this->session->set_userdata('year', $post_year);
					}
					
					if(!empty($post_start_day) and !empty($post_end_day)){
						$this->session->set_userdata('start_day', $post_start_day);
						$this->session->set_userdata('end_day', $post_end_day);
					}
					if(!empty($unset_days)){
						$this->session->unset_userdata('start_day');
						$this->session->unset_userdata('end_day');
					}
					if(!empty($post_month)){
						$this->session->set_userdata('month', $post_month);
							if($post_month == '-1'){
								$this->session->unset_userdata('month');
							}
					}

					if(!empty($post_status)){
						$this->session->set_userdata('invoice_status', $post_status);
							if($post_status == 3){
								$this->session->unset_userdata('invoice_status');
							}
					}
					if(!empty($post_sent)){
						$this->session->set_userdata('sent', $post_sent);
							if($post_sent == '-1'){
								$this->session->unset_userdata('sent');
							}
					}
					if(!empty($post_country)){
						$this->session->set_userdata('country', $post_country);
							if($post_country == '-1'){
								$this->session->unset_userdata('country');
							}
					}
					if(!empty($payment_method)){
						$this->session->set_userdata('payment_method', $payment_method);
							if($payment_method == '-1'){
								$this->session->unset_userdata('payment_method');
							}
					}
					if(!empty($export)){
							$this->session->set_flashdata('export', $export);
					}
					redirect($this->config->item('admin_folder').'/invoices/invoice_list');
				}

				
				$data['year'] 					= $this->session->userdata('year');
				$data['start_day'] 				= $this->session->userdata('start_day');
				$data['end_day'] 				= $this->session->userdata('end_day');
				$data['month'] 					= $this->session->userdata('month');
				$data['invoice_status'] 		= $this->session->userdata('invoice_status');
				$data['sent'] 					= $this->session->userdata('sent');
				$data['country'] 				= $this->session->userdata('country');
				$data['payment_method'] 		= $this->session->userdata('payment_method');

				
				$term = array(				
					'year' 						=> $this->session->userdata('year'),
					'start_day' 				=> $this->session->userdata('start_day'),
					'end_day' 					=> $this->session->userdata('end_day'),
					'month' 					=> $this->session->userdata('month'),
					'invoice_status' 			=> $this->session->userdata('invoice_status'),
					'sent' 						=> $this->session->userdata('sent'),
					'country' 					=> $this->session->userdata('country'),
					'payment_method' 			=> $this->session->userdata('payment_method'),
				);
				


				$data['invoices']			= $this->Invoice_model->get_all_invoices($term,$sort_by, $sort_invoice, $rows, $page,$this->shop_id);
				$data['total']          	= $this->Invoice_model->get_all_invoices_count($term,$this->shop_id);
                
				$ex = $this->session->flashdata('export');
				if($ex){
					$this->load->view($this->config->item('admin_folder').'/invoices_xml', $data);
				}
				
				$this->load->library('pagination');
				
				$config['base_url']			= site_url($this->config->item('admin_folder').'/invoices/invoice_list/'.$sort_by.'/'.$sort_invoice.'/'.$code.'/');
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
	
				$data['sort_by']	= $sort_by;
				$data['sort_invoice']	= $sort_invoice;

                $today = date("m.d.y");
                $data['recieved_field'] = array(

                    'id'    =>  '',
                    'name'  =>  '',
                    'size'  =>  '',
                    'value' =>  $today,
                    );
					
					$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));

					$this->load->view($this->config->item('admin_folder').'/invoice_list', $data);
        
            }
        public function export(){

				$this->load->helper('download_helper');

                $period = array(
                    
                    'month' => $this->input->post('month'), 
                    'year'  => $this->input->post('year'), 
                );

				$data['invoices']   =   $this->Invoice_model->get_invoice_data($period,  $this->data_shop);	
                echo '<pre>';
                //print_r($data['invoices']);
                echo '</pre>';
                $this->load->view($this->config->item('admin_folder').'/invoices_xml', $data);
	}

    public function sent_invoices($sort_by='invoice_number',$sort_invoice='desc', $code=0, $page=0, $rows=1000){
		        if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
			}

                //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['all_shops']  =   $this->Shop_model->get_shops();
                
                
		//if they submitted an export form do the export
		if($this->input->post('submit') == 'export') {

			$this->load->model('customer_model');
			$this->load->helper('download_helper');
			$post	= $this->input->post(null, false);
			$term	= (object)$post;
			$data['invoices']	= $this->Invoice_model->get_invoices($term);		
			foreach($data['invoices'] as &$o) {
				$o->items	= $this->Invoice_model->get_items($o->id);
			}
			force_download_content('invoices.xml', $this->load->view($this->config->item('admin_folder').'/invoices_xml', $data, true));
			die;
		}
		$data['current_shop']   = $this->session->userdata('shop');
		$this->load->helper('form');
		$this->load->helper('date');
		$data['message']	= $this->session->flashdata('message');
                
		$data['code']		= $code;
		$term				= false;
		
		$post	= $this->input->post(null, false);
		if($post){
			//if the term is in post, save it to the db and give me a reference
			$term			= json_encode($post);
			$code			= $this->Search_model->record_term($term);
			$data['code']	= $code;
			//reset the term to an object for use
			$term	= (object)$post;
		}
		elseif ($code){
			$term	= $this->Search_model->get_term($code);
			$term	= json_decode($term);
		} 

 		$data['term']	= $term;
 		$data['invoices']	= $this->Invoice_model->get_sent_invoices($term, $sort_by, $sort_invoice, $rows, $page,  $this->shop_id);
		$data['total']          = $this->Invoice_model->get_invoices_count($term);
		
		$this->load->library('pagination');
		
		$config['base_url']		= site_url($this->config->item('admin_folder').'/invoices/index/'.$sort_by.'/'.$sort_invoice.'/'.$code.'/');
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
	
		$data['sort_by']	= $sort_by;
		$data['sort_invoice']	= $sort_invoice;
                $today = date("m.d.y");
                $data['recieved_field'] = array(

                    'id'    =>  '',
                    'name'  =>  '',
                    'size'  =>  '',
                    'value' =>  $today,
                    );
                

                
                $data['page_title']	= lang('sent_invoices');
                						$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
                $this->load->view($this->config->item('admin_folder').'/sent_invoices', $data);
        
            }
    public function reminders($sort_by='invoice_number',$sort_invoice='desc', $code=0, $page=0, $rows=15){
		        if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
			}
       //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['all_shops']  =   $this->Shop_model->get_shops();
                
		//if they submitted an export form do the export
		if($this->input->post('submit') == 'export') {
                    
			$this->load->model('customer_model');
			$this->load->helper('download_helper');
			$post	= $this->input->post(null, false);
			$term	= (object)$post;

			$data['invoices']	= $this->Invoice_model->get_invoices($term);		

			foreach($data['invoices'] as &$o) {
				$o->items	= $this->Invoice_model->get_items($o->id);
			}

			force_download_content('invoices.xml', $this->load->view($this->config->item('admin_folder').'/invoices_xml', $data, true));
			
			//kill the script from here
			die;
		}
		
		$this->load->helper('form');
		$this->load->helper('date');
		$data['message']	= $this->session->flashdata('message');
		$data['page_title']	= lang('invoices');
                
		$data['code']		= $code;
		$term				= false;
		
		$post	= $this->input->post(null, false);
		if($post){
			//if the term is in post, save it to the db and give me a reference
			$term			= json_encode($post);
			$code			= $this->Search_model->record_term($term);
			$data['code']	= $code;
			//reset the term to an object for use
			$term	= (object)$post;
		}
		elseif ($code){
			$term	= $this->Search_model->get_term($code);
			$term	= json_decode($term);
		} 

 		$data['term']	= $term;
 		$data['invoices']	= $this->Invoice_model->get_invoices($term, $sort_by, $sort_invoice, $rows, $page,  $this->shop_id);
		$data['total']	= $this->Invoice_model->get_invoices_count($term);
		
		$this->load->library('pagination');
		
		$config['base_url']		= site_url($this->config->item('admin_folder').'/invoices/index/'.$sort_by.'/'.$sort_invoice.'/'.$code.'/');
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
	
		$data['sort_by']	= $sort_by;
		$data['sort_invoice']	= $sort_invoice;
                $today = date("m.d.y");
                $data['recieved_field'] = array(

                    'id'    =>  '',
                    'name'  =>  '',
                    'size'  =>  '',
                    'value' =>  $today,
                    );



                $data['page_title']	= lang('site_reminders');
                						$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
                $this->load->view($this->config->item('admin_folder').'/reminders', $data);
        
            }


            public function credit_note($id){
			

                if(!empty($_POST)){
                
				    $invoice_credit_note        		= $this->Invoice_model->get_invoice_normal($id);

					$shop_id							= $this->session->userdata('shop');
					$credit_note['shop_id']             = $shop_id;
					$credit_note['status']             	= '0';
					$credit_note['credit_note_number']  = 'CN'.$this->input->post('invoice_number');
					$credit_note['invoice_id']      	= $id;
					$credit_note['invoice_number']      = $this->input->post('invoice_number');
					$credit_note['order_number']        = $this->input->post('order_number');
					$credit_note['customer_number']     = $this->input->post('customer_number');
					$credit_note['created_on']          = date('Y-m-d H:i:s');
					$credit_note['ammount']             = $this->input->post('credit_note_ammount');
					$credit_note['made_by']             = $this->session->userdata('ba_username');
					$credit_note['company']             = $invoice_credit_note['company'];
					$credit_note['delivery_condition']  = $invoice_credit_note['delivery_condition'];
					$credit_note['payment_condition']   = $invoice_credit_note['payment_condition'];
					$credit_note['per_email']          	= $invoice_credit_note['per_email'];
					$credit_note['email']            	= $invoice_credit_note['email'];
					$credit_note['invoice_created_on']  = $invoice_credit_note['created_on'];
					$credit_note['order_dispatch_date'] = $invoice_credit_note['order_dispatch_date'];
					$credit_note['total_net'] 			= $this->input->post('totalnet');
					$credit_note['shipping'] 			= $this->input->post('dispatch_costs');
					$credit_note['VAT'] 				= $this->input->post('VAT');
					$credit_note['total_gross'] 		= $this->input->post('totalgross');

					
					if($shop_id == 1){
						$credit_note['made_by_id']      = $this->session->userdata('ba_c_login');
					}
					if($shop_id == 2){
						$credit_note['made_by_id']      = $this->session->userdata('ba_d_login');
					}
					if($shop_id == 3){
						$credit_note['made_by_id']      = $this->session->userdata('ba_g_login');
					}
	
					$key 				= count($this->input->post('code'));
					
					$product_id 		= $this->input->post('product_id');
					$code 				= $this->input->post('code');
					$quantity 			= $this->input->post('quantity');
					$unit_price 		= $this->input->post('unit_price');
					$vpa 				= $this->input->post('vpa');
					$product_total 		= $this->input->post('product_total');
					$description 		= $this->input->post('description');
					
					$credit_note_id 	= $this->Invoice_model->save_credit_note($credit_note);
					
					for($i = 0; $i < $key; $i++){

						$credit_note_products[] = array(
						
							'credit_note_id' 		=> 	$credit_note_id,
							'shop_id' 				=> 	$this->session->userdata('shop'),
							'invoice_number'		=>	$this->input->post('invoice_number'),
							'invoice_id'			=>	$id,
							'product_id' 			=>	$product_id[$i],
							'code' 					=>	$code[$i],
							'quantity' 				=> 	$quantity[$i],
							'unit_price' 			=> 	$unit_price[$i],
							'vpa' 					=> 	$vpa[$i],
							'product_total' 		=> 	$product_total[$i],
							'description' 			=> 	$description[$i],
						);
					}
	
					$this->Invoice_model->save_credit_note_items($credit_note_products);
					redirect($this->config->item('admin_folder').'/invoices/view/'.$id);
                }
				else {
				
					$this->session->set_flashdata('message','The sum for the credit note must not be empty!!!');
					redirect($this->config->item('admin_folder').'/invoices/view/'.$id);
				
				}
			}

        public function view_credit_note($id,$credit_note_number){
				
					if(!empty($this->session->userdata('back'))){
						$this->session->unset_userdata('back');
					}

					$data['categories'] = $this->categories;
					$data['groups']     = $this->groups;
					$data['products']   = $this->products;
					$data['all_shops']  = $this->Shop_model->get_shops();
					$data['page_title'] = lang('credit_note');
					$data['message']	= $this->session->flashdata('message');
                /*************************************************************************************/
					$data['credit_note']				= $this->Invoice_model->get_invoice_credit_note($credit_note_number,$this->session->userdata('shop'));
					$data['ordered_products']			= $this->Invoice_model->get_invoice_credit_note_items($id);
					$data['id']							= $id;

					$customer_num 	= $data['credit_note']->customer_number;
					$customer_id = $this->Invoice_model->get_customer_nr($customer_num,$this->session->userdata('shop'));
					$data['customer_id'] = $customer_id->NR;
					$data['c_id'] 			= $this->Customer_model->get_client_details_by_nr($customer_id->NR,$this->session->userdata('shop'));

					
					$filename    	= 'CN'.$customer_id->NR;
					//print_r($customer_id);
					$pdfFilePath        = FCPATH.'/client_files/'.$customer_id->NR.'/docs/'.$filename.'.pdf';
					//print_r($pdfFilePath);
                    if (file_exists($pdfFilePath)) {

                        $data['invoices_pdf'] = scandir(FCPATH.'/client_files/'.$customer_id->NR.'/docs/');    

                    }

					
					$timeid = '0';
					if($timeid==0){
						$time = time();
					}	
					else {
						$time = $timeid;
					}
					$data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
					$this->load->view($this->config->item('admin_folder').'/credit_note', $data);
		}
		
		public function update_credit_note($id){
		
		
					
					$data['credit_note']				= $this->Invoice_model->get_invoice_credit_note($id);
					
					$shop_id							= $this->session->userdata('shop');
					$credit_note['shop_id']             = $shop_id;
					$credit_note['status']             	= '0';
					$credit_note['credit_note_number']  = $data['credit_note']->credit_note_number;
					$credit_note['invoice_id']      	= $data['credit_note']->invoice_id;
					$credit_note['invoice_number']      = $data['credit_note']->invoice_number;
					$credit_note['order_number']        = $data['credit_note']->order_number;
					$credit_note['customer_number']     = $data['credit_note']->customer_number;
					$credit_note['created_on']          = $data['credit_note']->created_on;
					$credit_note['ammount']             = $data['credit_note']->ammount;
					$credit_note['made_by']             = $this->session->userdata('ba_username');
					$credit_note['company']             = $data['credit_note']->company;
					$credit_note['delivery_condition']  = $this->input->post('delivery_condition');
					$credit_note['payment_condition']   = $this->input->post('payment_condition');
					$credit_note['per_email']          	= $this->input->post('per_email');
					$credit_note['email']            	= $this->input->post('email');
					$credit_note['invoice_created_on']  = $data['credit_note']->invoice_created_on;
					$credit_note['order_dispatch_date'] = $data['credit_note']->order_dispatch_date;
					$credit_note['shipping'] 			= $this->input->post('shipping');
					$credit_note['VAT'] 				= $this->input->post('VAT');
					$credit_note['id'] 					= $id;
					if($shop_id == 1){
						$credit_note['made_by_id']      = $this->session->userdata('ba_c_login');
					}
					if($shop_id == 2){
						$credit_note['made_by_id']      = $this->session->userdata('ba_d_login');
					}
					if($shop_id == 3){
						$credit_note['made_by_id']      = $this->session->userdata('ba_g_login');
					}
					
					$key 				= count($this->input->post('code'));
					
					$product_id 		= $this->input->post('product_id');
					$code 				= $this->input->post('code');
					$quantity 			= $this->input->post('quantity');
					$unit_price 		= $this->input->post('unit_price');
					$vpa 				= $this->input->post('vpa');
					$product_total 		= $this->input->post('product_total');
					$description 		= $this->input->post('description');
					
					for($i = 0; $i < $key; $i++){

						$credit_note_products[] = array(

							'credit_note_id' 	=> 	$id,
							'shop_id' 			=> 	$this->session->userdata('shop'),
							'invoice_number'	=>	$data['credit_note']->invoice_number,
							'invoice_id'		=>	$data['credit_note']->invoice_id,
							'product_id' 		=>	$product_id[$i],
							'code' 				=>	$code[$i],
							'quantity' 			=> 	$quantity[$i],
							'unit_price' 		=> 	$unit_price[$i],
							'vpa' 				=> 	$vpa[$i],
							'product_total' 	=> 	$product_total[$i],
							'description' 		=> 	$description[$i],
							
						);

						$total_n[] = $unit_price[$i]*$quantity[$i];

					}

					$total_net = array_sum($total_n);
					
					$credit_note['total_net'] 			= $total_net;
					$credit_note['total_gross'] 		= $total_net+$this->input->post('shipping')+$this->input->post('VAT');
					
					
					$this->Invoice_model->update_credit_note($credit_note);

					foreach($credit_note_products as $update){
						$this->Invoice_model->update_credit_note_items($update);
					}

					redirect($this->config->item('admin_folder').'/invoices/view_credit_note/'.$id);
		
		}
		

		public function delete_credit_note_product($id,$code){
		
			$this->Invoice_model->delete_credit_note_product($id,$code);
			redirect($this->config->item('admin_folder').'/invoices/view_credit_note/'.$id);

		}
		
        public function send_credit_note(){
            
            
                $this->load->model('Messages_model');
                $msg_templates = $this->Messages_model->get_list('invoice');
		
				// replace template variables
                foreach($msg_templates as $msg){
				// fix html
				$msg['content'] = str_replace("\n", '', html_entity_decode($msg['content']));
					
				// {invoice_number}
				$msg['subject'] = str_replace('{invoice_number}', $data['invoice']->invoice_number, $msg['subject']);
				$msg['content'] = str_replace('{invoice_number}', $data['invoice']->invoice_number, $msg['content']);
				// {url}
				$msg['subject'] = str_replace('{url}', $this->config->item('base_url'), $msg['subject']);
				$msg['content'] = str_replace('{url}', $this->config->item('base_url'), $msg['content']);
			
				// {site_name}
				$msg['subject'] = str_replace('{site_name}', $this->config->item('company_name'), $msg['subject']);
				$msg['content'] = str_replace('{site_name}', $this->config->item('company_name'), $msg['content']);
			
				$data['msg_templates'][]	= $msg;
    	}
            
		foreach($data['invoice']->contents as $invoicekey=>$product){
			if(isset($product['is_gc']) && (bool)$product['is_gc'])
			{
				if($this->Gift_card_model->is_active($product['code']))
				{
					$data['order']->contents[$invoicekey]['gc_status'] = '[ '.lang('giftcard_is_active').' ]';
				} else {
					$data['order']->contents[$invoicekey]['gc_status'] = ' [ <a href="'. base_url() . $this->config->item('admin_folder').'/giftcards/activate/'. $product['code'].'">'.lang('activate').'</a> ]';
				}
			}
		}
	}
        public function update_adres($nr,$id){
        
			$update['NAAM1']	=	$this->input->post('NAAM1');
			$update['NAAM2']	=	$this->input->post('NAAM2');
			$update['NAAM3']	=	$this->input->post('NAAM3');
			$update['STRAAT']	=	$this->input->post('STRAAT');
			$update['POSTCODE']	=	$this->input->post('POSTCODE');
			$update['PLAATS']	=	$this->input->post('PLAATS');
			$update['LAND']		=	$this->input->post('LAND');
			$update['LANDCODE']	=	$this->input->post('LANDCODE');
		
			$this->db->update_adres($nr,$this->session->userdata('shop'),$update);
			redirect($this->config->item('admin_folder').'/invoices/view/'.$id);
		
		}
		
        public function update_c_adres($nr,$id){
        
		
		
		
		}

        public function pdf($id){
		
				
                
				$this->load->helper(array('form', 'date'));
                $this->load->library('form_validation');
                $this->load->model('Gift_card_model');
                $this->load->model('Product_model');	
                $data['all_shops']  =   $this->Shop_model->get_shops();

                $invoice            = $this->Invoice_model->get_invoice_details($id);
				$order            	= $this->Invoice_model->get_order_details($invoice['order_number'],$this->data_shop);

				$invoice_address 					= $this->Invoice_model->get_invoice_customer_address_pieces($invoice['customer_id'],$this->session->userdata('shop'));
				
				if(empty($invoice_address['NAAM1']) or empty($invoice_address['STRAAT']) or empty($invoice_address['POSTCODE']) or empty($invoice_address['PLAATS']) or empty($invoice_address['LAND'])){
					$this->session->set_flashdata('empty_address','Please fill invoice address correctly');
					$red = str_replace('http://www.varnamed.com/varnamed/','',$_SERVER['HTTP_REFERER']);
					redirect($red);
				}else {

					$c_id 								= strtoupper($invoice_address['LANDCODE']);
					

					$shop_name          = $this->Invoice_model->get_shop_name( $invoice['shop_id']);
					$shop_address       = $this->Invoice_model->get_shop_address( $invoice['shop_id'],$c_id);
					$shop_bank_account  = $this->Invoice_model->get_shop_account( $invoice['shop_id'],$c_id);
					$ordered_products   = $this->Invoice_model->get_invoice_items($invoice['invoice_number'],$this->data_shop);

					$customer_id        = $invoice['customer_id'];
					
					$dir_path = $_SERVER['DOCUMENT_ROOT'].'/client_files/'.$customer_id.'/docs/';
					if(!file_exists($dir_path)){
						mkdir($dir_path,0777,true);
					}
					
					$filename           = $id;
					$pdfFilePath        = $_SERVER['DOCUMENT_ROOT'].'/client_files/'.$customer_id.'/docs/'.$filename.'.pdf';


					$data['shop_name']      	= $shop_name['shop_name'];
					$data['shop_address']       = unserialize($shop_address['address']);
					$data['shop_index']         = $shop_address['company_index'];
					$data['customer_address']   = $invoice_address;
					$data['invoice_number']     = $id;
					$data['order_number']       = $invoice['order_number'];
					$data['customer_number']    = $invoice['customer_number'];
					$data['created_by']         = $invoice['created_by']; 
					$data['invoice_date']       = $invoice['created_on']; 
					$data['cfactuurnr']      	= $invoice['CFACTUURNR']; 

					

					$data['ust_idnr']           	= 'Ust-IdNr.';
					$data['bestell_nr']         	= 'Bestell-Nr.';
					$data['ordered_products']   	= $ordered_products;

					//--------------------------------------------------------------------------------------------------------------------------------------------
					$n_vats = array();
					$d_vats = array();
					foreach($ordered_products as $pr){
						if($pr['special_vat'] == 1){
							$d_vats[] = $pr['vat_ammount'];		
						}
						if($pr['special_vat'] != 1){
							$n_vats[] = $pr['vat_ammount'];
						}
					}
					$data['n_vats']	=	array_sum($n_vats);
					$data['d_vats']	=	array_sum($d_vats);

					
					//echo '<pre>';
					//print_r($ordered_products);
					//echo '</pre>';

					//$data['shipping_costs_value']   = $order->shipping;
					$data['shipping_costs_value']   = $invoice['dispatch_costs'];
					$data['totalnet']           	= $invoice['totalnet'];
					$data['ship_vat_rate']          = $invoice['ship_vat_rate'];

					$data['vat_value']              = $invoice['VAT'];
					
					
					$data['totalgross']         	= $invoice['totalgross'];
					//--------------------------------------------------------------------------------------------------------------------------------------------
					$data['send_date']          	= $invoice['created_on'];
					$data['terms_of_payment']   	= $invoice['notes'];
					$data['bank_account']       	= unserialize($shop_bank_account['account']); 
					$c_data                     	= $this->Customer_model->get_country_data_by_index($c_id);
					$data['vat_index']          	= $c_data->tax;

					$data['country_id']		= 	$order->country_id;	
					
					$data['cur_country']	=	$c_id; 
					
					if($c_id == 'AT'){
						$c_id = 'AU';
					}
					
					if($c_id == 'BE'){
					
						$data['important_sentence']	=	'U kunt betalen met een SEPA overschrijving.';
					
					}
					if($c_id == 'BEL' or $c_id == 'LX'){
					
						$data['important_sentence']	=	'Vous pouvez payer par virement SEPA.';
					
					}
					
					if($c_id == 'NL' or $c_id == 'BE'){
					
						$data['invoice']			=	'Factuur';
						$data['invoice_nr']			=	'Factuur nr.';
						$data['order_nr']			=	'Order nr.';
						$data['agent']				=	'Agent';
						$data['date']				=	'Datum';
						$data['client_nr']			=	'Klant nr.';
						$data['ust_idnr']			=	'ust_idnr';
						$data['bestell_nr']			=	'Bestel nr.';
						$data['product_nr']			=	'Art. nr.';
						$data['description']		=	'Omschrijving';
						$data['delivery_quantity']	=	'Geleverd';
						$data['number_per_packing']	=	'Aantal per verpakking';
						$data['unit_price_netto']	=	'Prijs per verpakking';
						$data['total_price_netto']	=	'Totaalprijs';
						$data['shipping_costs']		=	'Verzendkosten';
						$data['vat']				=	'BTW';
						$data['total_price_net']	=	'Subtotaal';
						$data['total_price']		=	'Totaal';
						$data['sent_date']			=	'Verzenddatum';
						$data['terms_of_payment']	=	'Betalingsvoorwaarden';
						$data['explain']			=	'Gelieve te specificeren bij betaling';
						$data['re']					=	'';
						$data['cfactuur']       	= 	'Bestel nr.'; 
						$data['comforties_explain_nl'] = 'Comforties.nl is een handelsnaam van Comforties.com BV';
						$data['comforties_explain_be'] = 'Comforties.be is een handelsnaam van Comforties.com BV';
						$payment_condition_array = array(
    
							NULL => '30 dagen zonder aftrek',
							'0' => '30 dagen zonder aftrek',
							'1' => '30 dagen zonder aftrek',
							'3' => '8 dagen zonder aftrek',
							'4' => 'Onmiddellijk zonder aftrek',
							'5' => '42 dagen zonder aftrek',
						);
						$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
					}
					
					if($c_id == 'FR' or $c_id == 'LX' or $c_id == 'BEL'){
					
					$data['invoice']			=	'Facture';
					$data['invoice_nr']			=	'Nº de facture';
					$data['order_nr']			=	'Nº d`ordre';
					$data['agent']				=	'Traité par';
					$data['date']				=	'Date';
					$data['client_nr']			=	'Nº de client';
					$data['ust_idnr']			=	'';
					$data['bestell_nr']			=	'';
					$data['product_nr']			=	'Article';
					$data['description']		=	'Détail';
					$data['delivery_quantity']	=	'Nombre';
					$data['number_per_packing']	=	'Nombre par carton';
					$data['unit_price_netto']	=	'Prix unitaire';
					$data['total_price_netto']	=	'Prix total';
					$data['shipping_costs']		=	'Frais dd livraison';
					$data['vat']				=	'TVA';
					$data['total_price_net']	=	'Sous-total';
					$data['total_price']		=	'Total';
					$data['sent_date']			=	'Date d`expédition';
					$data['terms_of_payment']	=	'Modalités de paiement';
					$data['explain']			=	'S`il vous plaît indiquer avec votre payement: ';
					$data['re']					=	'';
					$data['phone']       		= 	'Tel.'; 
					$data['cfactuur']       	= 	'Nº de commande'; 
					
					$data['comforties_explain_fr'] = 'Comforties.fr est une marque déposée de Comforties.com BV.';
					$data['comforties_explain_lx'] = 'Comforties.com est une marque déposée de Comforties.com BV.';
					$data['comforties_explain_bel'] = 'Comforties.be est une marque déposée de Comforties.com BV.';
					
					$payment_condition_array = array(
    
							NULL => '30 jours sans déduction',
							'0' => '30 jours sans déduction',
							'1' => '30 jours sans déduction',
							'3' => '8 jours sans déduction',
							'4' => 'immédiatement, sans déduction',
							'5' => '42 jours sans déduction',
					);
					$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
					}
					
					if($c_id == 'DE' or $c_id == 'AU'){
					
						$data['invoice']			=	'Rechnung';
						$data['invoice_nr']			=	'Rechnungs-Nr.';
						$data['order_nr']			=	'Auftrags-Nr.';
						$data['agent']				=	'Bearbeiter(in)';
						$data['date']				=	'Datum';
						$data['client_nr']			=	'Kunden-Nr.';
						$data['ust_idnr']			=	'Ust-IdNr.';
						$data['bestell_nr']			=	'Bestell-Nr.';
						$data['product_nr']			=	'Art-Nr';
						$data['description']		=	'Beschreibung';
						$data['delivery_quantity']	=	'Liefermenge';
						$data['number_per_packing']	=	'Anzahl pro Verpackung';
						$data['unit_price_netto']	=	'Verpackungspreis Netto';
						$data['total_price_netto']	=	'Gesamtpreis Netto';
						$data['shipping_costs']		=	'Versandkosten';
						$data['vat']				=	'MwSt.';
						$data['total_price_net']	=	'Netto';
						$data['total_price']		=	'Gesamt';
						$data['sent_date']			=	'Versanddatum';
						$data['terms_of_payment']	=	'Zahlungsbedingungen';
						$data['explain']			=	'Bitte bei Zahlungen angeben:';
						$data['re']					=	'';
						$data['cfactuur']       	= 	'Bestell-Nr.'; 
						
						$data['comforties_explain_de'] = 'Comforties.de ist ein Handelsname der Comforties.com BV';
						$data['comforties_explain_at'] = 'Comforties.at ist ein Handelsname der Comforties.com BV';
						
						$payment_condition_array = array(
    
							NULL => '30 Tagen ohne Abzug',
							'0' => '30 Tagen ohne Abzug',
							'1' => '30 Tagen ohne Abzug',
							'3' => '8 Tagen ohne Abzug',
							'4' => 'Immédiatement, sans déduction',
							'5' => '42 Tagen ohne Abzug',
						);
						$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
					}
					
					if($c_id == 'UK'){
					
					$data['invoice']			=	'Invoice';
					$data['invoice_nr']			=	'Invoice no.';
					$data['order_nr']			=	'Order no.';
					$data['agent']				=	'Processed by';
					$data['date']				=	'Date';
					$data['client_nr']			=	'Client no.';
					$data['ust_idnr']			=	'';
					$data['bestell_nr']			=	'Part no.';
					$data['product_nr']			=	'Article no.';
					$data['description']		=	'Description';
					$data['delivery_quantity']	=	'Delivered';
					$data['number_per_packing']	=	'Packaging unit';
					$data['unit_price_netto']	=	'Price per package';
					$data['total_price_netto']	=	'Total price';
					$data['shipping_costs']		=	'Shipping costs';
					$data['vat']				=	'VAT';
					$data['total_price_net']	=	'Subtotal';
					$data['total_price']		=	'Total';
					$data['sent_date']			=	'Dispatch date';
					$data['terms_of_payment']	=	'Payment condition';
					$data['explain']			=	'Please indicate with your payment';
					$data['re']					=	'';
					$data['cfactuur']       	= 	'Client reference no.'; 
					
					$data['comforties_explain_uk'] = 'Comforties.com is a trade name of Comforties.com BV';
						$payment_condition_array = array(
    
							NULL => '30 days without deduction',
							'0' => '30 days without deduction',
							'1' => '30 days without deduction',
							'3' => '8 days without deduction',
							'4' => 'Immediately without deduction',
							'5' => '42 days without deduction',
						);
						$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
					}

					//$this->load->view($this->config->item('admin_folder').'/pdf_invoice', $data);
					//echo $_SERVER['DOCUMENT_ROOT'].'/client_files/'.$customer_id.'/docs/'.'<br>';
					//echo FCPATH.'/client_files/'.$customer_id.'/docs/';
					
					ini_set('memory_limit','32M');
					$html = $this->load->view($this->config->item('admin_folder').'/pdf_invoice', $data,true);

					$this->load->library('pdf');
					$pdf = $this->pdf->load();
					//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
					$pdf->WriteHTML($html);
					$pdf->Output($pdfFilePath, 'F');

					//redirect('/client_files/'.$customer_id.'/docs/'.$filename.'.pdf');
					redirect('http://www.varnamed.com/varnamed/client_files/'.$customer_id.'/docs/'.$filename.'.pdf');
					
			}	
        }
        
		public function new_pdf($id){

                $this->load->helper(array('form', 'date'));
                $this->load->library('form_validation');
                $this->load->model('Gift_card_model');
                $this->load->model('Product_model');	
                
				$data['all_shops']  =   $this->Shop_model->get_shops();
                $invoice            =   $this->Invoice_model->get_invoice_details($id);
				$order            	= 	$this->Invoice_model->get_order_details($invoice['order_number'],$this->data_shop);
                $customer_id        =   $invoice['customer_id'];  
                

                
                $pdf_couunt_1 = scandir($_SERVER['DOCUMENT_ROOT'].'/client_files/'.$customer_id.'/docs/');

                foreach ($pdf_couunt_1 as $c){
                    if(!is_dir($c)){
                        $n_a[] = $c;
                    }
                }
                $total_pdfs = count($n_a);
                
                for($i=0;$i < $total_pdfs;$i++){
                   $filename = $id.'-'.+$i;
                   
                }

                $pdfFilePath        = $_SERVER['DOCUMENT_ROOT'].'/client_files/'.$customer_id.'/docs/'.$filename.'.pdf';

                

				/*************************************************************************************************************************************************************************************/
				$invoice_address 					= $this->Invoice_model->get_invoice_customer_address_pieces($invoice['customer_id'],$this->session->userdata('shop'));//adres
				
				$c_id 								= strtoupper($invoice_address['LANDCODE']);
				

				/*************************************************************************************************************************************************************************************/
                

                $shop_name          = $this->Invoice_model->get_shop_name( $invoice['shop_id']);
                $shop_address       = $this->Invoice_model->get_shop_address( $invoice['shop_id'],strtoupper($c_id));
                $shop_bank_account  = $this->Invoice_model->get_shop_account( $invoice['shop_id'],strtoupper($c_id));
                $ordered_products   = $this->Invoice_model->get_invoice_items($invoice['invoice_number'],$this->data_shop);
                


                //1 shop_name
                $data['shop_name']          = $shop_name['shop_name'];
                //2 address of the shop
                $data['shop_address']       = unserialize($shop_address['address']);
                $data['shop_index']         = $shop_address['company_index'];
                //3 customer address
                $data['customer_address']   = $invoice_address;
                //4 invoice number
                $data['invoice_number']     = $id;
                //5 order number
                $data['order_number']       = $invoice['order_number'];
                //6 customer number
                $data['customer_number']    = $invoice['customer_number'];
                //7 agent
                $data['created_by']              = $invoice['created_by']; 
                //8 date of the invoice
                $data['invoice_date']       = $invoice['created_on']; 
                //9 
                $data['ust_idnr']           = 'Ust-IdNr.';
                //10
                $data['bestell_nr']         = 'Bestell-Nr.';
                //11 products ordered
                $data['ordered_products']   = $ordered_products;

				//--------------------------------------------------------------------------------------------------------------------------------------------
					$n_vats = array();
					$d_vats = array();
					foreach($ordered_products as $pr){
						if($pr['special_vat'] == 1){
							$d_vats[] = $pr['vat_ammount'];		
						}
						if($pr['special_vat'] != 1){
							$n_vats[] = $pr['vat_ammount'];
						}
					}
					$data['n_vats']	=	array_sum($n_vats);
					$data['d_vats']	=	array_sum($d_vats);

					

					//$data['shipping_costs_value']   = $order->shipping;
					$data['shipping_costs_value']   = $invoice['dispatch_costs'];
					$data['totalnet']           	= $invoice['totalnet'];
					$data['ship_vat_rate']          = $invoice['ship_vat_rate'];

					$data['vat_value']              = $invoice['VAT'];
					
					
					$data['totalgross']         	= $invoice['totalgross'];
					
				//--------------------------------------------------------------------------------------------------------------------------------------------

                //16 sending date of the invoice
                $data['send_date']          = $invoice['order_dispatch_date'];
                //17 terms of payment
                $data['terms_of_payment']   = $invoice['notes'];
                //18 bank account
                $data['bank_account']       = unserialize($shop_bank_account['account']); 
				$data['cfactuurnr']      	 = $invoice['CFACTUURNR']; 

                //$c_arr                      = $this->Customer_model->get_country($invoice['customer_id']);
                //$country_details            = unserialize($c_arr->field_data);
                $c_data                     = $this->Customer_model->get_country_data_by_index($c_id);
                $data['vat_index']          = $c_data->tax;
                /*************************************************************************************************************/	
				$data['cur_country']	=	$c_id;
				
				if($c_id == 'AT'){
					$c_id = 'AU';
				}

					if($c_id == 'BE'){
					
						$data['important_sentence']	=	'U kunt betalen met een SEPA overschrijving.';
					
					}
					if($c_id == 'BEL' or $c_id == 'LX'){
					
						$data['important_sentence']	=	'Vous pouvez payer par virement SEPA.';
					
					}
					
				if($c_id == 'NL' or $c_id == 'BE'){
				
						$data['invoice']			=	'Factuur';
						$data['invoice_nr']			=	'Factuur nr.';
						$data['order_nr']			=	'Order nr.';
						$data['agent']				=	'Agent';
						$data['date']				=	'Datum';
						$data['client_nr']			=	'Klant nr.';
						$data['ust_idnr']			=	'ust_idnr';
						$data['bestell_nr']			=	'Bestell nr.';
						$data['product_nr']			=	'Art. nr.';
						$data['description']		=	'Omschrijving';
						$data['delivery_quantity']	=	'Geleverd';
						$data['number_per_packing']	=	'Aantal per verpakking';
						$data['unit_price_netto']	=	'Prijs per verpakking';
						$data['total_price_netto']	=	'Totaalprijs';
						$data['shipping_costs']		=	'Verzendkosten';
						$data['vat']				=	'BTW';
						$data['total_price_net']	=	'Subtotaal';
						$data['total_price']		=	'Totaal';
						$data['sent_date']			=	'Verzenddatum';
						$data['terms_of_payment']	=	'Betalingsvoorwaarden';
						$data['explain']			=	'Gelieve te specificeren bij betaling';
						$data['re']					=	'';
						$data['cfactuur']       	= 	'Bestel nr.'; 

						$data['comforties_explain_nl'] = 'Comforties.nl is een handelsnaam van Comforties.com BV';
						$data['comforties_explain_be'] = 'Comforties.be is een handelsnaam van Comforties.com BV';
					
					$payment_condition_array = array(
    
							NULL => '30 dagen zonder aftrek',
							'0' => '30 dagen zonder aftrek',
							'1' => '30 dagen zonder aftrek',
							'3' => '8 dagen zonder aftrek',
							'4' => 'Onmiddellijk zonder aftrek',
							'5' => '42 dagen zonder aftrek',
						);
						$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
				}
				
				if($c_id == 'FR' or $c_id == 'LX' or $c_id == 'BEL'){
				
					$data['invoice']			=	'Facture';
					$data['invoice_nr']			=	'Nº de facture';
					$data['order_nr']			=	'Nº d`ordre';
					$data['agent']				=	'Traité par';
					$data['date']				=	'Date';
					$data['client_nr']			=	'Nº de client';
					$data['ust_idnr']			=	'';
					$data['bestell_nr']			=	'';
					$data['product_nr']			=	'Article';
					$data['description']		=	'Détail';
					$data['delivery_quantity']	=	'Nombre';
					$data['number_per_packing']	=	'Nombre par carton';
					$data['unit_price_netto']	=	'Prix unitaire';
					$data['total_price_netto']	=	'Prix total';
					$data['shipping_costs']		=	'Frais dd livraison';
					$data['vat']				=	'TVA';
					$data['total_price_net']	=	'Sous-total';
					$data['total_price']		=	'Total';
					$data['sent_date']			=	'Date d`expédition';
					$data['terms_of_payment']	=	'Modalités de paiement';
					$data['explain']			=	'S`il vous plaît indiquer avec votre payement:';
					$data['re']					=	'';
					$data['phone']       		= 	'Tel.'; 
					$data['cfactuur']       	= 	'Nº de commande'; 
					
					$data['comforties_explain_fr'] = 'Comforties.fr est une marque déposée de Comforties.com BV.';
					$data['comforties_explain_lx'] = 'Comforties.com est une marque déposée de Comforties.com BV.';
					$data['comforties_explain_bel'] = 'Comforties.be est une marque déposée de Comforties.com BV.';
					
					$payment_condition_array = array(
    
							NULL => '30 jours sans déduction',
							'0' => '30 jours sans déduction',
							'1' => '30 jours sans déduction',
							'3' => '8 jours sans déduction',
							'4' => 'immédiatement, sans déduction',
							'5' => '42 jours sans déduction',
					);
					$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
				}
				
				if($c_id == 'DE' or $c_id == 'AU'){
				
					$data['invoice']			=	'Rechnung';
					$data['invoice_nr']			=	'Rechnungs-Nr.';
					$data['order_nr']			=	'Auftrags-Nr.';
					$data['agent']				=	'Bearbeiter(in)';
					$data['date']				=	'Datum';
					$data['client_nr']			=	'Kunden-Nr.';
					$data['ust_idnr']			=	'Ust-IdNr.';
					$data['bestell_nr']			=	'Bestell-Nr.';
					$data['product_nr']			=	'Art-Nr';
					$data['description']		=	'Beschreibung';
					$data['delivery_quantity']	=	'Liefermenge';
					$data['number_per_packing']	=	'Anzahl pro Verpackung';
					$data['unit_price_netto']	=	'Verpackungspreis Netto';
					$data['total_price_netto']	=	'Gesamtpreis Netto';
					$data['shipping_costs']		=	'Versandkosten';
					$data['vat']				=	'MwSt.';
					$data['total_price_net']	=	'Netto';
					$data['total_price']		=	'Gesamt';
					$data['sent_date']			=	'Versanddatum';
					$data['terms_of_payment']	=	'Zahlungsbedingungen';
					$data['explain']			=	'Bitte bei Zahlungen angeben:';
					$data['re']					=	'';
					$data['cfactuur']       	= 	'Bestell-Nr.'; 
					
					$data['comforties_explain_de'] = 'Comforties.de ist ein Handelsname der Comforties.com BV';
					$data['comforties_explain_at'] = 'Comforties.at ist ein Handelsname der Comforties.com BV';
					
						$payment_condition_array = array(
    
							NULL => '30 Tagen ohne Abzug',
							'0' => '30 Tagen ohne Abzug',
							'1' => '30 Tagen ohne Abzug',
							'3' => '8 Tagen ohne Abzug',
							'4' => 'Immédiatement, sans déduction',
							'5' => '42 Tagen ohne Abzug',
						);
						$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
				}
				
				if($c_id == 'UK'){
				
					$data['invoice']			=	'Invoice';
					$data['invoice_nr']			=	'Invoice no.';
					$data['order_nr']			=	'Order no.';
					$data['agent']				=	'Processed by';
					$data['date']				=	'Date';
					$data['client_nr']			=	'Client no.';
					$data['ust_idnr']			=	'';
					$data['bestell_nr']			=	'Client no.';
					$data['product_nr']			=	'Article no';
					$data['description']		=	'Description';
					$data['delivery_quantity']	=	'Delivered';
					$data['number_per_packing']	=	'Packaging unit';
					$data['unit_price_netto']	=	'Price per package';
					$data['total_price_netto']	=	'Total price';
					$data['shipping_costs']		=	'Shipping costs';
					$data['vat']				=	'VAT';
					$data['total_price_net']	=	'Subtotal';
					$data['total_price']		=	'Total';
					$data['sent_date']			=	'Dispatch date';
					$data['terms_of_payment']	=	'Payment condition';
					$data['explain']			=	'Please indicate with your payment';
					$data['re']					=	'';
					
					$data['comforties_explain_uk'] = 'Comforties.com is a trade name of Comforties.com BV';
					
					
						$data['cfactuur']       	= 	'Client reference no.'; 
						
						$payment_condition_array = array(
    
							NULL => '30 days without deduction',
							'0' => '30 days without deduction',
							'1' => '30 days without deduction',
							'3' => '8 days without deduction',
							'4' => 'Immediately without deduction',
							'5' => '42 days without deduction',
						);
						$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
				}


				/*************************************************************************************************************/


                
				ini_set('memory_limit','32M');
                $html = $this->load->view($this->config->item('admin_folder').'/pdf_invoice', $data,true);

                $this->load->library('pdf');
                $pdf = $this->pdf->load();
                //$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
                $pdf->WriteHTML($html);
                $pdf->Output($pdfFilePath, 'F');

                //redirect('/client_files/'.$customer_id.'/docs/'.$filename.'.pdf','refresh');
				redirect('http://www.varnamed.com/varnamed/client_files/'.$customer_id.'/docs/'.$filename.'.pdf','refresh');
                
                
        }
        
        public function download_word($id){
				
				$data['current_shop'] = $this->data_shop;
			
				$filename           = $id;

				header("Cache-Control: public");
				header("Content-Description: File Transfer");
				header("Content-Disposition: attachment; filename=".$filename);
				header("Content-Type: application/vnd.ms-word.main+xml");
				header("Content-Transfer-Encoding: binary");
				
				
				
                $this->load->helper(array('form', 'date'));
                $this->load->library('form_validation');
                $this->load->model('Gift_card_model');
                $this->load->model('Product_model');	

                $invoice            = $this->Invoice_model->get_invoice_details($id);
                $order            	= $this->Invoice_model->get_order_details($invoice['order_number'],$this->data_shop);

				//print_r($invoice);
				
				$shop_name          = $this->Invoice_model->get_shop_name( $invoice['shop_id']);
                $shop_details       = $this->Invoice_model->get_shop_address( $invoice['shop_id'],$order->country_id);
				$shop_bank_account  = $this->Invoice_model->get_shop_account( $invoice['shop_id'],$order->country_id);
                $ordered_products   = $this->Invoice_model->get_invoice_items($invoice['invoice_number'],$this->data_shop);

				$invoice_address 	= $this->Order_model->get_invoice_adres($invoice['customer_id'],$this->session->userdata('shop'));//adres
				if(empty($invoice_address)){
				
				$this->session->set_flashdata('miss','Invoice address is missing');
				redirect($this->config->item('admin_folder').'/invoices/invoices_print/');
				
				}else {
				
				//echo '<pre>';
				//print_r($order->invoice_address);
				//echo '</pre>';
				
                //1 shop_name
                $data['shop_name']      	= $shop_name['shop_name'];
                //2 address of the shop
                $data['shop_address']       = unserialize($shop_details['address']);
                $data['shop_index']         = $shop_details['company_index'];
                //3 customer address
                //$data['customer_address']   = unserialize($order->invoice_address);
                $data['customer_address']   = $invoice_address; 
                //4 invoice number
                $data['invoice_number']     = $id;
                //5 order number
                $data['order_number']       = $invoice['order_number'];
                //6 customer number
                $data['customer_number']    = $invoice['customer_id'];
                //7 agent
                $data['agent']              = $invoice['created_by']; 
                //8 date of the invoice
                $data['invoice_date']       = $invoice['created_on']; 
                //9 
                $data['ust_idnr']           = 'Ust-IdNr.';
                //10
                $data['bestell_nr']         = 'Bestell-Nr.';
                //11 products ordered
                $data['ordered_products']   = $ordered_products;
                //12 total net
                $data['totalnet']           = $invoice['totalnet'];
                //13 shipping costs
                $data['shipping_costs']     = $order->shipping;
                //14 vat
                $data['vat']                = $invoice['VAT'];
                //15 total gross
                $data['totalgross']         = $invoice['totalgross'];
                //16 sending date of the invoice
                $data['send_date']          = $invoice['created_on'];
                //17 terms of payment
                $data['terms_of_payment']   = $invoice['notes'];
                //18 bank account
                $data['bank_account']		= unserialize($shop_bank_account['account']); 




                $c_data                     = $this->Customer_model->get_country_data_by_index($order->country_id);
                $data['vat_index']          = $c_data->tax;
                
                
                
                $this->Invoice_model->set_printed($id,$this->session->userdata('shop'));
                $this->load->library('parser');
                $content = $this->parser->parse($this->config->item('admin_folder').'/print', $data);
				
				}
        }

        public function printout($id){
            




                $this->load->helper(array('form', 'date'));
                $this->load->library('form_validation');
                $this->load->model('Gift_card_model');
                $this->load->model('Product_model');	

                $invoice            = $this->Invoice_model->get_invoice_details($id);
                $invoice_address    = unserialize($invoice['invoice_address']);
                $shop_name          = $this->Invoice_model->get_shop_name( $invoice['shop_id']);
                $shop_address       = $this->Invoice_model->get_shop_address( $invoice['shop_id'],$invoice_address['country_code']);
                $shop_bank_account  = $this->Invoice_model->get_shop_account( $invoice['shop_id'],$invoice_address['country_code']);
                $ordered_products   = $this->Order_model->get_invoice_items($invoice['id']);
                $order_details      = $this->Order_model->get_order_costs($invoice['order_number']);

                //1 shop_name
                $data['shop_name']          = $shop_name['shop_name'];
                //2 address of the shop
                $data['shop_address']       = unserialize($shop_address['address']);
                $data['shop_index']         = $shop_address['company_index'];
                //3 customer address
                $data['customer_address']   = $invoice_address;
                //4 invoice number
                $data['invoice_number']     = $id;
                //5 order number
                $data['order_number']       = $invoice['order_number'];
                //6 customer number
                $data['customer_number']    = $invoice['customer_id'];
                //7 agent
                $data['agent']              = $invoice['created_by']; 
                //8 date of the invoice
                $data['invoice_date']       = $invoice['created_on']; 
                //9 
                $data['ust_idnr']           = 'Ust-IdNr.';
                //10
                $data['bestell_nr']         = 'Bestell-Nr.';
                //11 products ordered
                $data['ordered_products']   = unserialize($ordered_products['contents']);
                //12 total net
                $data['totalnet']           = $invoice['totalnet'];
                //13 shipping costs
                $data['shipping_costs']     = $order_details['shipping'];
                //14 vat
                $data['vat']                = $invoice['VAT'];
                //15 total gross
                $data['totalgross']         = $invoice['totalgross'];
                //16 sending date of the invoice
                $data['send_date']          = $invoice['invoice_dispatch_date'];
                //17 terms of payment
                $data['terms_of_payment']   = $invoice['notes'];
                //18 bank account
                $bank_account               = unserialize($shop_bank_account['account']); 
                $data['Ust_ID']             = $bank_account['Ust-ID'];
                $data['Handelskammer']      = $bank_account['Handelskammer'];
                $data['bank_name']          = $bank_account['bank_name'];
                $data['Konto_Nr']           = $bank_account['Konto-Nr'];
                $data['IBAN']               = $bank_account['IBAN'];
                $data['BIC']                = $bank_account['BIC'];
                $data['BLZ']                = $bank_account['BLZ'];

                $c_arr                      = $this->Customer_model->get_country($invoice['customer_id']);
                $country_details            = unserialize($c_arr->field_data);
                $c_data                     = $this->Customer_model->get_country_data($country_details['country_id']);
                $data['vat_index']          = $c_data->tax;
                
                
                
                
                $this->load->library('parser');
                $content = $this->parser->parse($this->config->item('admin_folder').'/print', $data);
                
                
                
                if($ph = printer_open("Samsung SCX-4x24 Series PCL6")){

                //$content = $this->load->view($this->config->item('admin_folder').'/print', $data);
                $content = $this->parser->parse($this->config->item('admin_folder').'/print', $data);
                
                printer_set_option($ph, PRINTER_MODE, "RAW");
                printer_write($ph, $content);
                printer_close($ph);
                redirect($this->config->item('admin_folder').'/invoices/view/'.$invoice['id']);
                }
                else "Couldn't connect..."; 

                
                
            }
			
			function send_invoice_by_email(){
			
			
			
			}
			
			
			public function tr_prices(){
			echo 'dv';
				//$this->Invoice_model->tr_invoices();
			
			}
                
         public function credit_note_pdf($id,$c_n){
		
				
                
				$this->load->helper(array('form', 'date'));
                $this->load->library('form_validation');
                $this->load->model('Gift_card_model');
                $this->load->model('Product_model');	
                $data['all_shops']  =   $this->Shop_model->get_shops();

                $cnote            = $this->Invoice_model->get_cnote_details($id);
                $invoice            = $this->Invoice_model->get_invoice_details($cnote['invoice_number']);
				$order            	= $this->Invoice_model->get_order_details($invoice['order_number'],$this->data_shop);

				$invoice_address 					= $this->Invoice_model->get_invoice_customer_address_pieces($invoice['customer_id'],$this->session->userdata('shop'));

				if(empty($invoice_address['NAAM1']) or empty($invoice_address['STRAAT']) or empty($invoice_address['POSTCODE']) or empty($invoice_address['PLAATS']) or empty($invoice_address['LAND'])){
					$this->session->set_flashdata('empty_address','Please fill invoice address correctly');
					$red = str_replace('http://www.varnamed.com/varnamed/','',$_SERVER['HTTP_REFERER']);
					redirect($red);
				}else {

					$c_id 								= strtoupper($invoice_address['LANDCODE']);
					

					$shop_name          = $this->Invoice_model->get_shop_name( $invoice['shop_id']);
					$shop_address       = $this->Invoice_model->get_shop_address( $invoice['shop_id'],$c_id);
					$shop_bank_account  = $this->Invoice_model->get_shop_account( $invoice['shop_id'],$c_id);
					$ordered_products   = $this->Invoice_model->get_cnote_items($id,$this->data_shop);

					$customer_id        = $invoice['customer_id'];
					
					$dir_path = $_SERVER['DOCUMENT_ROOT'].'/client_files/'.$customer_id.'/docs/';
					if(!file_exists($dir_path)){
						mkdir($dir_path,0777,true);
					}
					
					$filename           = 'CN'.$customer_id;
					$pdfFilePath        = $_SERVER['DOCUMENT_ROOT'].'/client_files/'.$customer_id.'/docs/'.$filename.'.pdf';


					$data['shop_name']      	= $shop_name['shop_name'];
					$data['shop_address']       = unserialize($shop_address['address']);
					$data['shop_index']         = $shop_address['company_index'];
					$data['customer_address']   = $invoice_address;
					$data['invoice_number']     = $id;
					$data['order_number']       = $cnote['order_number'];
					$data['customer_number']    = $cnote['customer_number'];
					$data['created_by']         = $cnote['made_by']; 
					$data['invoice_date']       = $cnote['created_on']; 
					$data['cfactuurnr']      	 = $invoice['CFACTUURNR']; 

					

					$data['ust_idnr']           = 'Ust-IdNr.';
					//10
					$data['bestell_nr']         = 'Bestell-Nr.';
					//11 products ordered
					$data['ordered_products']   = $ordered_products;
					//12 total net
					$data['totalnet']           = $cnote['total_net'];
					//13 shipping costs
					$data['shipping_costs_value']     = $order->shipping;
					//14 vat
					$data['vat_value']                = $invoice['VAT'];
					//15 total gross
					$data['totalgross']         = $cnote['total_gross'];
					//16 sending date of the invoice
					$data['send_date']          = $cnote['created_on'];
					//17 terms of payment
					$data['terms_of_payment']   = $invoice['notes'];
					//18 bank account
					$data['bank_account']       = unserialize($shop_bank_account['account']); 

					

					$c_data                     = $this->Customer_model->get_country_data_by_index($c_id);
					$data['vat_index']          = $c_data->tax;

					$data['country_id']		= 	$order->country_id;	
					
					$data['cur_country']	=	$c_id; 
					
					if($c_id == 'AT'){
						$c_id = 'AU';
					}
					
					if($c_id == 'BE'){
					
						$data['important_sentence']	=	'U kunt betalen met een SEPA overschrijving.';
					
					}
					if($c_id == 'BEL' or $c_id == 'LX'){
					
						$data['important_sentence']	=	'Vous pouvez payer par virement SEPA.';
					
					}
					
					if($c_id == 'NL' or $c_id == 'BE'){
					
						$data['invoice']			=	'Credit Nota';
						$data['invoice_nr']			=	'Creditnota nr.';
						$data['order_nr']			=	'Ordernummer';
						$data['agent']				=	'Behandeld door';
						$data['date']				=	'Datum';
						$data['client_nr']			=	'Klantnummer';
						$data['ust_idnr']			=	'BTW-nr klant';
						$data['bestell_nr']			=	'Bestelnummer';
						$data['product_nr']			=	'Art. nr.';
						$data['description']		=	'Omschrijving';
						$data['delivery_quantity']	=	'Geleverd';
						$data['number_per_packing']	=	'Aantal per verpakking';
						$data['unit_price_netto']	=	'Prijs per verpakking';
						$data['total_price_netto']	=	'Totaalprijs';
						$data['shipping_costs']		=	'Verzendkosten';
						$data['vat']				=	'BTW';
						$data['total_price_net']	=	'Subtotaal';
						$data['total_price']		=	'Totaal';
						$data['sent_date']			=	'Verzenddatum';
						$data['terms_of_payment']	=	'Betalingsvoorwaarden';
						$data['explain']			=	'Gelieve te specificeren bij betaling';
						$data['re']					=	'';
						$data['cfactuur']       	= 	'Bestel nr.'; 
						$data['comforties_explain_nl'] = 'Comforties.nl is een handelsnaam van Comforties.com BV';
						$data['comforties_explain_be'] = 'Comforties.be is een handelsnaam van Comforties.com BV';
						$payment_condition_array = array(
    
							NULL => '30 dagen zonder aftrek',
							'0' => '30 dagen zonder aftrek',
							'1' => '30 dagen zonder aftrek',
							'3' => '8 dagen zonder aftrek',
							'4' => 'Onmiddellijk zonder aftrek',
							'5' => '42 dagen zonder aftrek',
						);
						$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
					}
					
					if($c_id == 'FR' or $c_id == 'LX' or $c_id == 'BEL'){
					
					$data['invoice']			=	'Note de crédit';
					$data['invoice_nr']			=	'Nº de note de crédit';
					$data['order_nr']			=	'Nº d`ordre';
					$data['agent']				=	'Traité par';
					$data['date']				=	'Date';
					$data['client_nr']			=	'Nº de client';
					$data['ust_idnr']			=	'';
					$data['bestell_nr']			=	'';
					$data['product_nr']			=	'Article';
					$data['description']		=	'Détail';
					$data['delivery_quantity']	=	'Nombre';
					$data['number_per_packing']	=	'Nombre par carton';
					$data['unit_price_netto']	=	'Prix unitaire';
					$data['total_price_netto']	=	'Prix total';
					$data['shipping_costs']		=	'Frais dd livraison';
					$data['vat']				=	'TVA';
					$data['total_price_net']	=	'Sous-total';
					$data['total_price']		=	'Total';
					$data['sent_date']			=	'Date d`expédition';
					$data['terms_of_payment']	=	'Modalités de paiement';
					$data['explain']			=	'S`il vous plaît indiquer avec votre payement: ';
					$data['re']					=	'';
					$data['phone']       		= 	'Tel.'; 
					$data['cfactuur']       	= 	'Nº de commande'; 
					
					$data['comforties_explain_fr'] = 'Comforties.fr est une marque déposée de Comforties.com BV.';
					$data['comforties_explain_lx'] = 'Comforties.com est une marque déposée de Comforties.com BV.';
					$data['comforties_explain_bel'] = 'Comforties.be est une marque déposée de Comforties.com BV.';
					
					$payment_condition_array = array(
    
							NULL => '30 jours sans déduction',
							'0' => '30 jours sans déduction',
							'1' => '30 jours sans déduction',
							'3' => '8 jours sans déduction',
							'4' => 'immédiatement, sans déduction',
							'5' => '42 jours sans déduction',
					);
					$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
					}
					
					if($c_id == 'DE' or $c_id == 'AU'){
					
						$data['invoice']			=	'Gutschrift';
						$data['invoice_nr']			=	'Gutschrift-Nr.';
						$data['order_nr']			=	'Auftrags-Nr.';
						$data['agent']				=	'Bearbeiter(in)';
						$data['date']				=	'Datum';
						$data['client_nr']			=	'Kunden-Nr.';
						$data['ust_idnr']			=	'Ust-IdNr.';
						$data['bestell_nr']			=	'Bestell-Nr.';
						$data['product_nr']			=	'Art-Nr';
						$data['description']		=	'Beschreibung';
						$data['delivery_quantity']	=	'Liefermenge';
						$data['number_per_packing']	=	'Anzahl pro Verpackung';
						$data['unit_price_netto']	=	'Verpackungspreis Netto';
						$data['total_price_netto']	=	'Gesamtpreis Netto';
						$data['shipping_costs']		=	'Versandkosten';
						$data['vat']				=	'MwSt.';
						$data['total_price_net']	=	'Netto';
						$data['total_price']		=	'Gesamt';
						$data['sent_date']			=	'Versanddatum';
						$data['terms_of_payment']	=	'Zahlungsbedingungen';
						$data['explain']			=	'Bitte bei Zahlungen angeben:';
						$data['re']					=	'';
						$data['cfactuur']       	= 	'Bestell-Nr.'; 
						
						$data['comforties_explain_de'] = 'Comforties.de ist ein Handelsname der Comforties.com BV';
						$data['comforties_explain_at'] = 'Comforties.at ist ein Handelsname der Comforties.com BV';
						
						$payment_condition_array = array(
    
							NULL => '30 Tagen ohne Abzug',
							'0' => '30 Tagen ohne Abzug',
							'1' => '30 Tagen ohne Abzug',
							'3' => '8 Tagen ohne Abzug',
							'4' => 'Immédiatement, sans déduction',
							'5' => '42 Tagen ohne Abzug',
						);
						$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
					}
					
					if($c_id == 'UK'){
					
					$data['invoice']			=	'Credit note';
					$data['invoice_nr']			=	'Credit note no.';
					$data['order_nr']			=	'Order no.';
					$data['agent']				=	'Processed by';
					$data['date']				=	'Date';
					$data['client_nr']			=	'Client no.';
					$data['ust_idnr']			=	'';
					$data['bestell_nr']			=	'Client no.';
					$data['product_nr']			=	'Article no';
					$data['description']		=	'Description';
					$data['delivery_quantity']	=	'Delivered';
					$data['number_per_packing']	=	'Packaging unit';
					$data['unit_price_netto']	=	'Price per package';
					$data['total_price_netto']	=	'Total price';
					$data['shipping_costs']		=	'Shipping costs';
					$data['vat']				=	'VAT';
					$data['total_price_net']	=	'Subtotal';
					$data['total_price']		=	'Total';
					$data['sent_date']			=	'Dispatch date';
					$data['terms_of_payment']	=	'Payment condition';
					$data['explain']			=	'Please indicate with your payment';
					$data['re']					=	'';
					$data['cfactuur']       	= 	'Client reference no.'; 
					
					$data['comforties_explain_uk'] = 'Comforties.com is a trade name of Comforties.com BV';
						$payment_condition_array = array(
    
							NULL => '30 days without deduction',
							'0' => '30 days without deduction',
							'1' => '30 days without deduction',
							'3' => '8 days without deduction',
							'4' => 'Immediately without deduction',
							'5' => '42 days without deduction',
						);
						$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
					}

					$this->load->view($this->config->item('admin_folder').'/pdf_cnote', $data);
					
					ini_set('memory_limit','32M');
					$html = $this->load->view($this->config->item('admin_folder').'/pdf_cnote', $data,true);

					$this->load->library('pdf');
					$pdf = $this->pdf->load();
					//$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
					$pdf->WriteHTML($html);
					$pdf->Output($pdfFilePath, 'F');

					redirect('/client_files/'.$customer_id.'/docs/'.$filename.'.pdf');
					
			}	
        }
        
		public function new_credit_note_pdf($id,$c_n){

                $this->load->helper(array('form', 'date'));
                $this->load->library('form_validation');
                $this->load->model('Gift_card_model');
                $this->load->model('Product_model');	
                
				$data['all_shops']  =   $this->Shop_model->get_shops();
                $invoice            =   $this->Invoice_model->get_invoice_details($id);
				$order            	= 	$this->Invoice_model->get_order_details($invoice['order_number'],$this->data_shop);
                $customer_id        =   $invoice['customer_id'];  
                

                
                $pdf_couunt_1 = scandir(FCPATH.'/client_files/'.$customer_id.'/docs/');

                foreach ($pdf_couunt_1 as $c){
                    if(!is_dir($c)){
                        $n_a[] = $c;
                    }
                }
                $total_pdfs = count($n_a);
                
                for($i=0;$i < $total_pdfs;$i++){
                   $filename = $id.'-'.+$i;
                   
                }

                $pdfFilePath        = FCPATH.'/client_files/'.$customer_id.'/docs/'.$filename.'.pdf';

                

				/*************************************************************************************************************************************************************************************/
				$invoice_address 					= $this->Invoice_model->get_invoice_customer_address_pieces($invoice['customer_id'],$this->session->userdata('shop'));//adres
				
				$c_id 								= strtoupper($invoice_address['LANDCODE']);
				

				/*************************************************************************************************************************************************************************************/
                

                $shop_name          = $this->Invoice_model->get_shop_name( $invoice['shop_id']);
                $shop_address       = $this->Invoice_model->get_shop_address( $invoice['shop_id'],strtoupper($c_id));
                $shop_bank_account  = $this->Invoice_model->get_shop_account( $invoice['shop_id'],strtoupper($c_id));
                $ordered_products   = $this->Invoice_model->get_invoice_items($invoice['invoice_number'],$this->data_shop);
                


                //1 shop_name
                $data['shop_name']          = $shop_name['shop_name'];
                //2 address of the shop
                $data['shop_address']       = unserialize($shop_address['address']);
                $data['shop_index']         = $shop_address['company_index'];
                //3 customer address
                $data['customer_address']   = $invoice_address;
                //4 invoice number
                $data['invoice_number']     = $id;
                //5 order number
                $data['order_number']       = $invoice['order_number'];
                //6 customer number
                $data['customer_number']    = $invoice['customer_number'];
                //7 agent
                $data['created_by']              = $invoice['created_by']; 
                //8 date of the invoice
                $data['invoice_date']       = $invoice['created_on']; 
                //9 
                $data['ust_idnr']           = 'Ust-IdNr.';
                //10
                $data['bestell_nr']         = 'Bestell-Nr.';
                //11 products ordered
                $data['ordered_products']   = $ordered_products;
                //12 total net
                $data['totalnet']           = $invoice['totalnet'];
                //13 shipping costs
                $data['shipping_costs_value']     = $order->shipping;
                //14 vat
                $data['vat_value']                = $invoice['VAT'];
                //15 total gross
                $data['totalgross']         = $invoice['totalgross'];
                //16 sending date of the invoice
                $data['send_date']          = $invoice['order_dispatch_date'];
                //17 terms of payment
                $data['terms_of_payment']   = $invoice['notes'];
                //18 bank account
                $data['bank_account']       = unserialize($shop_bank_account['account']); 
				$data['cfactuurnr']      	 = $invoice['CFACTUURNR']; 

                //$c_arr                      = $this->Customer_model->get_country($invoice['customer_id']);
                //$country_details            = unserialize($c_arr->field_data);
                $c_data                     = $this->Customer_model->get_country_data_by_index($c_id);
                $data['vat_index']          = $c_data->tax;
                /*************************************************************************************************************/	
				$data['cur_country']	=	$c_id;
				
				if($c_id == 'AT'){
					$c_id = 'AU';
				}

					if($c_id == 'BE'){
					
						$data['important_sentence']	=	'U kunt betalen met een SEPA overschrijving.';
					
					}
					if($c_id == 'BEL' or $c_id == 'LX'){
					
						$data['important_sentence']	=	'Vous pouvez payer par virement SEPA.';
					
					}
					
				if($c_id == 'NL' or $c_id == 'BE'){
				
						$data['invoice']			=	'Factuur';
						$data['invoice_nr']			=	'Factuur nr.';
						$data['order_nr']			=	'Order nr.';
						$data['agent']				=	'Agent';
						$data['date']				=	'Datum';
						$data['client_nr']			=	'Klant nr.';
						$data['ust_idnr']			=	'ust_idnr';
						$data['bestell_nr']			=	'Bestell nr.';
						$data['product_nr']			=	'Art. nr.';
						$data['description']		=	'Omschrijving';
						$data['delivery_quantity']	=	'Geleverd';
						$data['number_per_packing']	=	'Aantal per verpakking';
						$data['unit_price_netto']	=	'Prijs per verpakking';
						$data['total_price_netto']	=	'Totaalprijs';
						$data['shipping_costs']		=	'Verzendkosten';
						$data['vat']				=	'BTW';
						$data['total_price_net']	=	'Subtotaal';
						$data['total_price']		=	'Totaal';
						$data['sent_date']			=	'Verzenddatum';
						$data['terms_of_payment']	=	'Betalingsvoorwaarden';
						$data['explain']			=	'Gelieve te specificeren bij betaling';
						$data['re']					=	'';
						$data['cfactuur']       	= 	'Bestel nr.'; 

						$data['comforties_explain_nl'] = 'Comforties.nl is een handelsnaam van Comforties.com BV';
						$data['comforties_explain_be'] = 'Comforties.be is een handelsnaam van Comforties.com BV';
					
					$payment_condition_array = array(
    
							NULL => '30 dagen zonder aftrek',
							'0' => '30 dagen zonder aftrek',
							'1' => '30 dagen zonder aftrek',
							'3' => '8 dagen zonder aftrek',
							'4' => 'Onmiddellijk zonder aftrek',
							'5' => '42 dagen zonder aftrek',
						);
						$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
				}
				
				if($c_id == 'FR' or $c_id == 'LX' or $c_id == 'BEL'){
				
					$data['invoice']			=	'Facture';
					$data['invoice_nr']			=	'Nº de facture';
					$data['order_nr']			=	'Nº d`ordre';
					$data['agent']				=	'Traité par';
					$data['date']				=	'Date';
					$data['client_nr']			=	'Nº de client';
					$data['ust_idnr']			=	'';
					$data['bestell_nr']			=	'';
					$data['product_nr']			=	'Article';
					$data['description']		=	'Détail';
					$data['delivery_quantity']	=	'Nombre';
					$data['number_per_packing']	=	'Nombre par carton';
					$data['unit_price_netto']	=	'Prix unitaire';
					$data['total_price_netto']	=	'Prix total';
					$data['shipping_costs']		=	'Frais dd livraison';
					$data['vat']				=	'TVA';
					$data['total_price_net']	=	'Sous-total';
					$data['total_price']		=	'Total';
					$data['sent_date']			=	'Date d`expédition';
					$data['terms_of_payment']	=	'Modalités de paiement';
					$data['explain']			=	'S`il vous plaît indiquer avec votre payement:';
					$data['re']					=	'';
					$data['phone']       		= 	'Tel.'; 
					$data['cfactuur']       	= 	'Nº de commande'; 
					
					$data['comforties_explain_fr'] = 'Comforties.fr est une marque déposée de Comforties.com BV.';
					$data['comforties_explain_lx'] = 'Comforties.com est une marque déposée de Comforties.com BV.';
					$data['comforties_explain_bel'] = 'Comforties.be est une marque déposée de Comforties.com BV.';
					
					$payment_condition_array = array(
    
							NULL => '30 jours sans déduction',
							'0' => '30 jours sans déduction',
							'1' => '30 jours sans déduction',
							'3' => '8 jours sans déduction',
							'4' => 'immédiatement, sans déduction',
							'5' => '42 jours sans déduction',
					);
					$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
				}
				
				if($c_id == 'DE' or $c_id == 'AU'){
				
					$data['invoice']			=	'Rechnung';
					$data['invoice_nr']			=	'Rechnungs-Nr.';
					$data['order_nr']			=	'Auftrags-Nr.';
					$data['agent']				=	'Bearbeiter(in)';
					$data['date']				=	'Datum';
					$data['client_nr']			=	'Kunden-Nr.';
					$data['ust_idnr']			=	'Ust-IdNr.';
					$data['bestell_nr']			=	'Bestell-Nr.';
					$data['product_nr']			=	'Art-Nr';
					$data['description']		=	'Beschreibung';
					$data['delivery_quantity']	=	'Liefermenge';
					$data['number_per_packing']	=	'Anzahl pro Verpackung';
					$data['unit_price_netto']	=	'Verpackungspreis Netto';
					$data['total_price_netto']	=	'Gesamtpreis Netto';
					$data['shipping_costs']		=	'Versandkosten';
					$data['vat']				=	'MwSt.';
					$data['total_price_net']	=	'Netto';
					$data['total_price']		=	'Gesamt';
					$data['sent_date']			=	'Versanddatum';
					$data['terms_of_payment']	=	'Zahlungsbedingungen';
					$data['explain']			=	'Bitte bei Zahlungen angeben:';
					$data['re']					=	'';
					$data['cfactuur']       	= 	'Bestell-Nr.'; 
					
					$data['comforties_explain_de'] = 'Comforties.de ist ein Handelsname der Comforties.com BV';
					$data['comforties_explain_at'] = 'Comforties.at ist ein Handelsname der Comforties.com BV';
					
						$payment_condition_array = array(
    
							NULL => '30 Tagen ohne Abzug',
							'0' => '30 Tagen ohne Abzug',
							'1' => '30 Tagen ohne Abzug',
							'3' => '8 Tagen ohne Abzug',
							'4' => 'Immédiatement, sans déduction',
							'5' => '42 Tagen ohne Abzug',
						);
						$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
				}
				
				if($c_id == 'UK'){
				
					$data['invoice']			=	'Invoice';
					$data['invoice_nr']			=	'Invoice no.';
					$data['order_nr']			=	'Order no.';
					$data['agent']				=	'Processed by';
					$data['date']				=	'Date';
					$data['client_nr']			=	'Client no.';
					$data['ust_idnr']			=	'';
					$data['bestell_nr']			=	'Client no.';
					$data['product_nr']			=	'Article no';
					$data['description']		=	'Description';
					$data['delivery_quantity']	=	'Delivered';
					$data['number_per_packing']	=	'Packaging unit';
					$data['unit_price_netto']	=	'Price per package';
					$data['total_price_netto']	=	'Total price';
					$data['shipping_costs']		=	'Shipping costs';
					$data['vat']				=	'VAT';
					$data['total_price_net']	=	'Subtotal';
					$data['total_price']		=	'Total';
					$data['sent_date']			=	'Dispatch date';
					$data['terms_of_payment']	=	'Payment condition';
					$data['explain']			=	'Please indicate with your payment';
					$data['re']					=	'';
					
					$data['comforties_explain_uk'] = 'Comforties.com is a trade name of Comforties.com BV';
					
					
						$data['cfactuur']       	= 	'Client reference no.'; 
						
						$payment_condition_array = array(
    
							NULL => '30 days without deduction',
							'0' => '30 days without deduction',
							'1' => '30 days without deduction',
							'3' => '8 days without deduction',
							'4' => 'Immediately without deduction',
							'5' => '42 days without deduction',
						);
						$data['payment_condition']  	= $payment_condition_array[$invoice['payment_condition']]; 
				}


				/*************************************************************************************************************/


                
				ini_set('memory_limit','32M');
                $html = $this->load->view($this->config->item('admin_folder').'/pdf_cnote', $data,true);

                $this->load->library('pdf');
                $pdf = $this->pdf->load();
                //$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
                $pdf->WriteHTML($html);
                $pdf->Output($pdfFilePath, 'F');

                redirect('/client_files/'.$customer_id.'/docs/'.$filename.'.pdf','refresh');
                
                
        }
                
                
                
                
                

}
