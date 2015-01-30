<?php

		class Groups extends CI_Controller {
	
				private   $use_inventory = false;
				protected $shop_id;
				protected $page_title;
				protected $code;
				protected $post;
				protected $categories;
				protected $term;
				protected $category_id;
				protected $categories_dropdown;
				public    $data_shop;
				public    $language;
				private   $products;
        
				public function __construct() {

							parent::__construct();
							remove_ssl();
				
								$this->load->model(array('Option_model', 'Category_model', 'Digital_Product_model','Product_model','Shop_model'));
								$this->load->model('Routes_model');
								$this->load->model('Search_model');
								$this->load->model('Group_model');
								////////////////////////////////////////////////////////////////
								$this->load->helper('form','formatting','text');
								////////////////////////////////////////////////////////////////
								$this->load->library('form_validation');
								////////////////////////////////////////////////////////////////
										
								$this->post         = $this->input->post(null, false);
								//$this->categories   = $this->Category_model->get_categories_tierd();
								//$this->products     = $this->Product_model->get_all_products();
								//$this->products     = $this->Product_model->get_all_products();
								$this->term         = false;
								$this->category_id  = false;
								$this->categories_dropdown = $this->Category_model->get_categories_tierd();
								////////////////////////////////////////////////////////////////
								$this->shop_id 		= $this->session->userdata('shop');
								$this->language     = $this->session->userdata('language');
								$this->data_shop    = $this->session->userdata('shop');
								////////////////////////////////////////////////////////////////
								$this->lang->load('product',  $this->language);
								$this->lang->load('dashboard',  $this->language);
								$this->page_title   = lang('groups');
								
								$this->categories   = array(1);
								$this->groups     	= array(1);
								$this->products     = array(1);
								
				}

			public function index($order_by="group_name", $sort_order="ASC", $code=0, $page=0, $rows=100) {

							if(!$this->bitauth->logged_in()){
								$this->session->set_userdata('redir', current_url());
								redirect($this->config->item('admin_folder').'/admin/login');
							}

							$data['products']   				= $this->products;
							$data['can_edit_porduct_groups']   	= $this->bitauth->has_role('can_edit_porduct_groups');
							$data['all_shops']  				= $this->Shop_model->get_shops();
							$data['can_edit_categories']    	= $this->bitauth->has_role('can_edit_categories');

							$data['code']                   	= $code;
							$term                           	= $this->term;
							$category_id                    	= $this->category_id;
							$data['categories']             	= $this->categories;
							$data['category']               	= '';
							$data['web_shop']               	= '';
							$data['all_categories']             = array();

							$all_categories 					= $this->Group_model->get_all_cats($this->session->userdata('shop'));

							$cats = array();
							foreach($all_categories as $cat){
								$cats[$cat['id']] = $cat['name'];
							}
							if($cats){
								$data['all_categories']				=	$cats;
							}

							$data['term']                   	= $term;
							$data['order_by']               	= $order_by;
							$data['sort_order']             	= $sort_order;
							$data['web_shop']               	= $this->input->post('webshop');
							$post_web_shop               		= $this->input->post('webshop');

							$post_cat 							= $this->input->post('category');
							$clear_cat 							= $this->input->post('clear');

							if(!empty($post_cat)){
								$this->session->set_userdata('category',$post_cat);
								
							}
							if(!empty($this->session->userdata('category'))){
								$data['category']	= $this->session->userdata('category');
							}
							if(!empty($clear_cat)){
								$this->session->unset_userdata('category');
							}
							if(!empty($post_web_shop)){
								$this->session->set_userdata('post_web_shop',$post_web_shop);
							}
							if(!empty($this->session->userdata('post_web_shop'))){
								$data['post_web_shop']	= $this->session->userdata('post_web_shop');
								$data['group_name']		= 'group_name_'.$this->session->userdata('post_web_shop');
							}else{
								$data['post_web_shop']	= 'Nederland';
								$data['group_name']		= 'group_name_Nederland';
							}

							$data['groups']                 	= $this->Group_model->groups(array(
																									'term'			=> $term, 
																									'order_by'		=> $order_by, 
																									'sort_order'	=> $sort_order, 
																									'rows'			=> $rows, 
																									'page'			=> $page,
																									'shop_id'		=> $this->data_shop,
																									'cat_id'		=> $this->session->userdata('category')
																							));

							$data['total']                  	= $this->Group_model->groups(array('term'=>$term, 'order_by'=>$order_by, 'sort_order'=>$sort_order), true);

							$timeid = 0;
							if($timeid==0){
								$time = time();
							}else {
								$time = $timeid;
							}
							$data['weather']	=	_date($time);
							$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));

							$this->load->view($this->config->item('admin_folder').'/product_groups', $data);
			}


			public function bulk_save() {


				$post	= $this->input->post('group');
				
				//echo '<pre>';
						
				if(!$post){

					$this->session->set_flashdata('error',  lang('error_bulk_no_products'));
					redirect($this->config->item('admin_folder').'/groups');
				}
				foreach($post as $id => $group) {

					$group['group_id']	= $id;
					$group['enabled'];
					//$this->Product_model->remove_products($group['group_id'],$group['enabled']);
					$this->Group_model->save_($group);
				}
				
				$this->session->set_flashdata('message', lang('message_bulk_update_groups'));
				redirect($this->config->item('admin_folder').'/groups');
				
				//print_r($post);
				//echo '</pre>';
			}

			function delete($id = false) {

				
						if ($id) {

								$group	= $this->Group_model->get_group($id,$this->session->userdata('shop'));

								if (!$group) {
									
									$this->session->set_flashdata('error', lang('error_not_found'));
									redirect($this->config->item('admin_folder').'/groups');
								}
								else {
									
									$this->Group_model->delete_group($id,$this->session->userdata('shop'));
									$this->Product_model->hide_products($id,$this->session->userdata('shop'));
									
									$this->session->set_flashdata('deleted_group', 'Group deleted');
									redirect($this->config->item('admin_folder').'/groups');
									}
								}else{
									$this->session->set_flashdata('error', lang('error_not_found'));
									redirect($this->config->item('admin_folder').'/groups');
								}
			}
		
		
            public function view_products($id,$order_by="code", $sort_order="ASC", $code=0, $page=0, $rows=15){
				
					if(!$this->bitauth->logged_in()){
						$this->session->set_userdata('redir', current_url());
						redirect($this->config->item('admin_folder').'/admin/login');
					}
					//menu item
					$data['products']       = $this->products;
					$data['groups']     	= $this->groups;
					$data['categories']     = $this->categories;
					$data['all_shops']  	= $this->Shop_model->get_shops();
					
					$webshops 				= $this->config->item('webshops');
					$data['shop_index'] 	= $webshops[$this->session->userdata('post_web_shop')];
					if(!empty($this->session->userdata('post_web_shop'))){
						$data['name_product']	= 'name_'.$webshops[$this->session->userdata('post_web_shop')];
					}else{
						$data['name_product']	= 'name_NL';
					}
					

					$data['id_id'] = $id;

					$current_group = $this->Group_model->get_current_group($id);
					foreach ($current_group as $group_name){
						$group_name->group_name;
					}

					$data['group_name']  			= $group_name->group_name.'&nbsp;'.'products';

					$data['code']                   = $code;
					$term                           = $this->term;
					$category_id                    = $this->category_id;

					//category list for the drop menu
					$data['categories']             = $this->categories;
					$post                           = $this->post;

					if($post) {
						$term                   = json_encode($post);
						$code                   = $this->Search_model->record_term($term);
						$data['code']           = $code;
					}
					elseif ($code) {
						$term                   = $this->Search_model->get_term($code);
					}

					//store the search term
					$data['term']                   = $term;
					$data['order_by']               = $order_by;
					$data['sort_order']             = $sort_order;
				   
 
					$product_id = $this->Group_model->select_groups($id,$this->session->userdata('shop'));
	
					   if(!empty($product_id)){

								$products = $this->Group_model->select_products($product_id,array('term'=>$term, 'order_by'=>$order_by, 'sort_order'=>$sort_order, 'rows'=>$rows, 'page'=>$page),$this->session->userdata('shop'));    
								$data['products']	=	array_filter($products);
						   
					   }

					$timeid = 0;
					if($timeid==0){
						$time = time();
					}	
					else {
						$time = $timeid;
					}
					
					$data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
					$this->load->view($this->config->item('admin_folder').'/group_products',$data);

			}
			
			
			
			
            public function group_delete($id,$i) {

                    $this->load->model('Group_model');

                    if (!empty($id)) {
                        
			$this->Group_model->delete_group_product($id,$i);
			//$this->session->set_flashdata('message', lang('message_deleted_product'));
			redirect($this->config->item('admin_folder').'/products/form/'.$id);
                        }
                }
				
				
				
		public function set_same_spec(){


			$post	= $this->input->post(null, false);
			
			$group	= $this->Group_model->get_group($post['id'],$this->session->userdata('shop'));
			
			//-------------------------------------------------------------------------------------------------------------------------
			/*Dutch section*/
			if($post['same_spec'] == 'BE' and $post['spec_from'] == 'NL'){
				
				$ret['group_name_Nederland']	=	$group->group_name_Belgie;
				$ret['nick_Nederland']			=	$group->nick_Belgie;
				$ret['saleprice_NL']			=	$group->saleprice_BE;
				$ret['description_NL']			=	$group->description_BE;
				$ret['amount_NL']				=	$group->amount_BE;
				$ret['text_1_NL']				=	$group->text_1_BE;
				$ret['text_2_NL']				=	$group->text_2_BE;

			}	
			if($post['same_spec'] == 'NL' and $post['spec_from'] == 'BE'){
				
				$ret['group_name_Belgie']		=	$group->group_name_Nederland;
				$ret['nick_Belgie']				=	$group->nick_Nederland;
				$ret['saleprice_BE']			=	$group->saleprice_NL;
				$ret['description_BE']			=	$group->description_NL;
				$ret['amount_BE']				=	$group->amount_NL;
				$ret['text_1_BE']				=	$group->text_1_NL;
				$ret['text_2_BE']				=	$group->text_2_NL;

			}
			//-------------------------------------------------------------------------------------------------------------------------
			/*German section*/

			if($post['same_spec'] == 'AT' and $post['spec_from'] == 'DE'){
				
				$ret['group_name_Deutschland']	=	$group->group_name_Österreich;
				$ret['nick_Deutschland']		=	$group->nick_Österreich;
				$ret['saleprice_DE']			=	$group->saleprice_AU;
				$ret['description_DE']			=	$group->description_AU;
				$ret['amount_DE']				=	$group->amount_AU;
				$ret['text_1_DE']				=	$group->text_1_AU;
				$ret['text_2_DE']				=	$group->text_2_AU;

			}			
			if($post['same_spec'] == 'DE' and $post['spec_from'] == 'AT'){
				
				$ret['group_name_Österreich']	=	$group->group_name_Deutschland;
				$ret['nick_Österreich']			=	$group->nick_Deutschland;
				$ret['saleprice_AU']			=	$group->saleprice_DE;
				$pattern = array('/','\/','<p>','<br>');
				$ret['description_AU']			=	str_replace($pattern,'',$group->description_DE);
				$ret['amount_AU']				=	$group->amount_DE;
				$ret['text_1_AU']				=	$group->text_1_DE;
				$ret['text_2_AU']				=	$group->text_2_DE;

			}
			//-------------------------------------------------------------------------------------------------------------------------
			/*French section*/
			
			if($post['same_spec'] == 'BEL' and $post['spec_from'] == 'FR'){
				
				$ret['group_name_France']		=	$group->group_name_Belgique;
				$ret['nick_France']				=	$group->nick_Belgique;
				$ret['saleprice_FR']			=	$group->saleprice_BEL;
				$ret['description_FR']			=	$group->description_BEL;
				$ret['amount_FR']				=	$group->amount_BEL;
				$ret['text_1_FR']				=	$group->text_1_BEL;
				$ret['text_2_FR']				=	$group->text_2_BEL;

			}
			if($post['same_spec'] == 'LX' and $post['spec_from'] == 'FR'){
				
				$ret['group_name_France']		=	$group->group_name_Luxembourg;
				$ret['nick_France']				=	$group->nick_Luxembourg;
				$ret['saleprice_FR']			=	$group->saleprice_LX;
				$ret['description_FR']			=	$group->description_LX;
				$ret['amount_FR']				=	$group->amount_LX;
				$ret['text_1_FR']				=	$group->text_1_LX;
				$ret['text_2_FR']				=	$group->text_2_LX;

			}
			
			if($post['same_spec'] == 'LX' and $post['spec_from'] == 'BEL'){
				
				$ret['group_name_Belgique']		=	$group->group_name_Luxembourg;
				$ret['nick_Belgique']			=	$group->nick_Luxembourg;
				$ret['saleprice_BEL']			=	$group->saleprice_LX;
				$ret['description_BEL']			=	$group->description_LX;
				$ret['amount_BEL']				=	$group->amount_LX;
				$ret['text_1_BEL']				=	$group->text_1_LX;
				$ret['text_2_BEL']				=	$group->text_2_LX;

			}
			if($post['same_spec'] == 'FR' and $post['spec_from'] == 'BEL'){
				
				$ret['group_name_Belgique']		=	$group->group_name_France;
				$ret['nick_Belgique']			=	$group->nick_France;
				$ret['saleprice_BEL']			=	$group->saleprice_FR;
				$ret['description_BEL']			=	$group->description_FR;
				$ret['amount_BEL']				=	$group->amount_FR;
				$ret['text_1_BEL']				=	$group->text_1_FR;
				$ret['text_2_BEL']				=	$group->text_2_FR;

			}
			
			if($post['same_spec'] == 'BEL' and $post['spec_from'] == 'LX'){
				
				$ret['group_name_Luxembourg']	=	$group->group_name_Belgique;
				$ret['nick_Luxembourg']			=	$group->nick_Belgique;
				$ret['saleprice_LX']			=	$group->saleprice_BEL;
				$ret['description_LX']			=	$group->description_BEL;
				$ret['amount_LX']				=	$group->amount_BEL;
				$ret['text_1_LX']				=	$group->text_1_BEL;
				$ret['text_2_LX']				=	$group->text_2_BEL;

			}
			if($post['same_spec'] == 'FR' and $post['spec_from'] == 'LX'){
				
				$ret['group_name_Luxembourg']	=	$group->group_name_France;
				$ret['nick_Luxembourg']			=	$group->nick_France;
				$ret['saleprice_LX']			=	$group->saleprice_FR;
				$ret['description_LX']			=	$group->description_FR;
				$ret['amount_LX']				=	$group->amount_FR;
				$ret['text_1_LX']				=	$group->text_1_FR;
				$ret['text_2_LX']				=	$group->text_2_FR;

			}
			 echo json_encode($ret);
			
			
		}
				
				
	public function form($id = false){
			
				if(!$this->bitauth->logged_in()) {
					$this->session->set_userdata('redir', current_url());
					redirect($this->config->item('admin_folder').'/admin/login');
				}

                //menu item
				$data['products']       	= $this->products;
				$data['groups']     		= $this->groups;
				$data['categories']     	= $this->categories;
                $data['all_shops']          =   $this->Shop_model->get_shops();
                
				$config['upload_path']		= 'uploads/images/full';
				$config['allowed_types']	= 'gif|jpg|png';
				$config['max_size']			= $this->config->item('size_limit');
				$config['max_width']		= '1024';
				$config['max_height']		= '768';
				$config['encrypt_name']		= true;
				
				$this->load->library('upload', $config);
		

				
				$this->group_id             = $id;
                

				$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

					//$data['groups']                 	= $this->Group_model->groups($id);
					$data['page_title']					= lang('group_form');
		

					$data['group_id']					= '';
					$data['shop_id']					= '';
					$data['cat_id']						= '';
					$data['group_brand']				= '';
					$data['group_name']					= '';
					$data['slug']						= '';
				
					//----------------------------------------------------------------------------------------------------------------------------------------------------
					
					$data['same_specification_nl'] = array('-1'	=>	'Select specification','BE'	=>	'Same as Belgium/Dutch');
					$data['same_specification_be'] = array('-1'	=>	'Select specification','NL'	=>	'Same as Netherlands');
					$data['same_specification_de'] = array('-1'	=>	'Select specification','AT'	=>	'Same as Austria');
					$data['same_specification_at'] = array('-1'	=>	'Select specification','DE'	=>	'Same as Germany');
					$data['same_specification_bel'] = array('-1'	=>	'Select specification','LX'	=>	'Same as Luxembourg','FR'	=>	'Same as France');
					$data['same_specification_fr'] = array('-1'	=>	'Select specification','LX'	=>	'Same as Luxembourg','BEL'	=>	'Same as Belgium/French');
					$data['same_specification_lx'] = array('-1'	=>	'Select specification','FR'	=>	'Same as France','BEL'	=>	'Same as Belgium/French');
					
					//----------------------------------------------------------------------------------------------------------------------------------------------------
					$data['cat'] = $this->session->userdata('category');
					/*******************************************************************************/
					
					$data['group_name_Nederland']		= '';
					$data['group_name_Belgique']		= '';
					$data['group_name_Belgie']			= '';
					$data['group_name_Deutschland']		= '';
					$data['group_name_France']			= '';
					$data['group_name_Österreich']		= '';
					$data['group_name_Luxembourg']		= '';
					$data['group_name_UK']				= '';
					
					
					$data['header_Nederland']			= '';
					$data['header_Deutschland']			= '';
					$data['header_Österreich']			= '';
					$data['header_Belgie']				= '';
					$data['header_Belgique']			= '';
					$data['header_France']				= '';
					$data['header_Luxembourg']			= '';
					$data['header_UK']					= '';

					
					$data['nick_Nederland']				= '';
					$data['nick_Belgie']				= '';
					$data['nick_Belgique']				= '';
					$data['nick_France']				= '';
					$data['nick_Deutschland']			= '';
					$data['nick_Österreich']			= '';
					$data['nick_Luxembourg']			= '';
					$data['nick_UK']					= '';
					
					$data['description_NL']				= '';
					$data['description_BE']				= '';
					$data['description_BEL']			= '';
					$data['description_FR']				= '';
					$data['description_DE']				= '';
					$data['description_AU']				= '';
					$data['description_LX']				= '';
					$data['description_UK']				= '';
					
					$data['link_1']						= '';
					$data['link_2']						= '';
					
					$data['text_1_NL']					= '';
					$data['text_1_BE']					= '';
					$data['text_1_BEL']					= '';
					$data['text_1_FR']					= '';
					$data['text_1_DE']					= '';
					$data['text_1_AU']					= '';
					$data['text_1_LX']					= '';
					$data['text_1_UK']					= '';

					$data['text_2_NL']					= '';
					$data['text_2_BE']					= '';
					$data['text_2_BEL']					= '';
					$data['text_2_FR']					= '';
					$data['text_2_DE']					= '';
					$data['text_2_AU']					= '';
					$data['text_2_LX']					= '';
					$data['text_2_UK']					= '';
					
					$data['saleprice_NL']				= '';
					$data['saleprice_BE']				= '';
					$data['saleprice_BEL']				= '';
					$data['saleprice_FR']				= '';
					$data['saleprice_DE']				= '';
					$data['saleprice_AU']				= '';
					$data['saleprice_LX']				= '';
					$data['saleprice_UK']				= '';
					
					$data['amount_NL']					= '';
					$data['amount_BE']					= '';
					$data['amount_BEL']					= '';
					$data['amount_FR']					= '';
					$data['amount_DE']					= '';
					$data['amount_AU']					= '';
					$data['amount_LX']					= '';
					$data['amount_UK']					= '';

					/*******************************************************************************/

					$data['group_comment']				= '';
					$data['seo_title']					= '';
					$data['meta']                  		= '';
					$data['enabled']					= '';
					$data['group_categories']       	= array();
					$data['photos']                 	= array();
					$data['links'] 						= array();

					$data['link_path'] 					= '';

					if ($id){
					
						$group		= $this->Group_model->get_group($id,$this->shop_id);
					
					if (!$group){
						$this->session->set_flashdata('error', lang('error_not_found'));
						redirect($this->config->item('admin_folder').'/groups');
					}

					//---------------------------------------------------------------------------------------------------------------------
					$this->load->helper('directory');
					$this->load->helper('file');

					$dir_path = $_SERVER['DOCUMENT_ROOT'].'/group_files/certificates/'.$id;

					if(!file_exists($dir_path)){
						mkdir($dir_path,0777,true);
					}

					$data['files'] = directory_map($dir_path);
					$data['path'] = base_url().'/group_files/certificates/'.$id;

					//---------------------------------------------------------------------------------------------------------------------					//---------------------------------------------------------------------------------------------------------------------
					$this->load->helper('directory');
					$this->load->helper('file');

					$dir_path 		= $_SERVER['DOCUMENT_ROOT'].'/group_files/link_docs/'.$id;
					
					$dir_path_NL 	= $_SERVER['DOCUMENT_ROOT'].'/group_files/link_docs/'.$id.'/'.'NL';
					$dir_path_DE 	= $_SERVER['DOCUMENT_ROOT'].'/group_files/link_docs/'.$id.'/'.'DE';
					$dir_path_AT 	= $_SERVER['DOCUMENT_ROOT'].'/group_files/link_docs/'.$id.'/'.'AT';
					$dir_path_BE 	= $_SERVER['DOCUMENT_ROOT'].'/group_files/link_docs/'.$id.'/'.'BE';
					$dir_path_BEL 	= $_SERVER['DOCUMENT_ROOT'].'/group_files/link_docs/'.$id.'/'.'BEL';
					$dir_path_FR 	= $_SERVER['DOCUMENT_ROOT'].'/group_files/link_docs/'.$id.'/'.'FR';
					$dir_path_LX 	= $_SERVER['DOCUMENT_ROOT'].'/group_files/link_docs/'.$id.'/'.'LX';
					$dir_path_UK 	= $_SERVER['DOCUMENT_ROOT'].'/group_files/link_docs/'.$id.'/'.'UK';

					if(!file_exists($dir_path)){
						mkdir($dir_path,0777,true);
					}

					$data['links'] 			= directory_map($dir_path);
					
					$data['links_NL'] 		= directory_map($dir_path_NL);
					$data['links_DE'] 		= directory_map($dir_path_DE);
					$data['links_AT'] 		= directory_map($dir_path_AT);
					$data['links_BE'] 		= directory_map($dir_path_BE);
					$data['links_BEL'] 		= directory_map($dir_path_BEL);
					$data['links_FR'] 		= directory_map($dir_path_FR);
					$data['links_LX'] 		= directory_map($dir_path_LX);
					$data['links_UK'] 		= directory_map($dir_path_UK);
					
					
					
					
					
					
					$data['link_path'] 	= base_url().'/group_files/link_docs/'.$id;

					//---------------------------------------------------------------------------------------------------------------------

					$data['group_id']					= $group->group_id;
					$data['shop_id']					= $group->shop_id;
					$data['cat_id']						= $group->cat_id;
					$data['group_brand']				= $group->group_brand;
					$data['group_name']					= $group->group_name;
					/*******************************************************************************/

					$data['group_name_Belgique']		= $group->group_name_Belgique;
					$data['group_name_Belgie']			= $group->group_name_Belgie;
					$data['group_name_Deutschland']		= $group->group_name_Deutschland;
					$data['group_name_France']			= $group->group_name_France;
					$data['group_name_Luxembourg']		= $group->group_name_Luxembourg;
					$data['group_name_Nederland']		= $group->group_name_Nederland;
					$data['group_name_UK']				= $group->group_name_UK;
					$data['group_name_Österreich']		= $group->group_name_Österreich;
					
					$data['header_Nederland']			= $group->nick_Nederland;
					$data['header_Deutschland']			= $group->header_Deutschland;
					$data['header_Österreich']			= $group->header_Österreich;
					$data['header_Belgie']				= $group->header_Belgie;
					$data['header_Belgique']			= $group->header_Belgique;;
					$data['header_France']				= $group->header_France;
					$data['header_Luxembourg']			= $group->header_Luxembourg;
					$data['header_UK']					= $group->header_UK;
					
					
					$data['nick_Nederland']				= $group->nick_Nederland;
					$data['nick_Belgie']				= $group->nick_Belgie;
					$data['nick_Belgique']				= $group->nick_Belgique;
					$data['nick_France']				= $group->nick_France;
					$data['nick_Deutschland']			= $group->nick_Deutschland;
					$data['nick_Österreich']			= $group->nick_Österreich;
					$data['nick_Luxembourg']			= $group->nick_Luxembourg;
					$data['nick_UK']					= $group->nick_UK;
					
					$data['description_NL']				= $group->description_NL;
					$data['description_BE']				= $group->description_BE;
					$data['description_BEL']			= $group->description_BEL;
					$data['description_FR']				= $group->description_FR;
					$data['description_DE']				= $group->description_DE;
					$data['description_AU']				= $group->description_AU;
					$data['description_LX']				= $group->description_LX;
					$data['description_UK']				= $group->description_UK;
					
					$data['link_1']						= $group->link_1;
					$data['link_2']						= $group->link_2;
					
					$data['text_1_NL']					= $group->text_1_NL;
					$data['text_1_BE']					= $group->text_1_BE;
					$data['text_1_BEL']					= $group->text_1_BEL;
					$data['text_1_FR']					= $group->text_1_FR;
					$data['text_1_DE']					= $group->text_1_DE;
					$data['text_1_AU']					= $group->text_1_AU;
					$data['text_1_LX']					= $group->text_1_LX;
					$data['text_1_UK']					= $group->text_1_UK;

					$data['text_2_NL']					= $group->text_2_NL;
					$data['text_2_BE']					= $group->text_2_BE;
					$data['text_2_BEL']					= $group->text_2_BEL;
					$data['text_2_FR']					= $group->text_2_FR;
					$data['text_2_DE']					= $group->text_2_DE;
					$data['text_2_AU']					= $group->text_2_AU;
					$data['text_2_LX']					= $group->text_2_LX;
					$data['text_2_UK']					= $group->text_2_UK;
					
					$data['saleprice_NL']				= $group->saleprice_NL;
					$data['saleprice_BE']				= $group->saleprice_BE;
					$data['saleprice_BEL']				= $group->saleprice_BEL;
					$data['saleprice_FR']				= $group->saleprice_FR;
					$data['saleprice_DE']				= $group->saleprice_DE;
					$data['saleprice_AU']				= $group->saleprice_AU;
					$data['saleprice_LX']				= $group->saleprice_LX;
					$data['saleprice_UK']				= $group->saleprice_UK;
					
					$data['amount_NL']					= $group->amount_NL;
					$data['amount_BE']					= $group->amount_BE;
					$data['amount_BEL']					= $group->amount_BEL;
					$data['amount_FR']					= $group->amount_FR;
					$data['amount_DE']					= $group->amount_DE;
					$data['amount_AU']					= $group->amount_AU;
					$data['amount_LX']					= $group->amount_LX;
					$data['amount_UK']					= $group->amount_UK;

					/*******************************************************************************/

					$data['slug']						= $group->slug;
					$data['group_comment']				= $group->group_comment;
					$data['seo_title']					= $group->seo_title;
					$data['meta']               		= $group->meta;
					$data['enabled']					= $group->enabled;
					$data['image']						= $group->image;
				}
					$all_categories 					= $this->Group_model->get_all_cats($this->session->userdata('shop'));
					
					$cats = array();
					foreach($all_categories as $cat){
						$cats[$cat['id']] = $cat['name'];
					}

					$data['all_categories']				= $cats;
					$data['group_categories']			= $this->input->post('categories');

					$this->form_validation->set_rules('group_name', 'lang:group_name', 'trim|max_length[64]');
					$this->form_validation->set_rules('slug', 'lang:slug', 'trim|required');
					
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
						$this->load->view($this->config->item('admin_folder').'/group_form', $data);
					}
				else
				{
						$uploaded	= $this->upload->do_upload('image');
				
						if ($id){
							if($uploaded){
								if($data['image'] != ''){
									$file = array();
									$file[] = 'uploads/images/full/'.$data['image'];
									$file[] = 'uploads/images/medium/'.$data['image'];
									$file[] = 'uploads/images/small/'.$data['image'];
									$file[] = 'uploads/images/thumbnails/'.$data['image'];
									
									foreach($file as $f){
										if(file_exists($f)){
											unlink($f);
										}
									}
								}
							}
							
					}
					/*else
					{
						if(!$uploaded)
						{
							$error	= $this->upload->display_errors();
							if($error != lang('error_file_upload'))
							{
								$data['error']	.= $this->upload->display_errors();
								$this->load->view($this->config->item('admin_folder').'/group_form', $data);
								return;
							}
						}
					}*/
					
					if($uploaded)
					{
						$image			= $this->upload->data();
						$save['image']	= $image['file_name'];
						
						$this->load->library('image_lib');

						$config['image_library'] = 'gd2';
						$config['source_image'] = 'uploads/images/full/'.$save['image'];
						$config['new_image']	= 'uploads/images/medium/'.$save['image'];
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 600;
						$config['height'] = 500;
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
						$this->image_lib->clear();

						//small image
						$config['image_library'] = 'gd2';
						$config['source_image'] = 'uploads/images/medium/'.$save['image'];
						$config['new_image']	= 'uploads/images/small/'.$save['image'];
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 300;
						$config['height'] = 300;
						$this->image_lib->initialize($config); 
						$this->image_lib->resize();
						$this->image_lib->clear();

						//cropped thumbnail
						$config['image_library'] = 'gd2';
						$config['source_image'] = 'uploads/images/small/'.$save['image'];
						$config['new_image']	= 'uploads/images/thumbnails/'.$save['image'];
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 150;
						$config['height'] = 150;
						$this->image_lib->initialize($config); 	
						$this->image_lib->resize();	
						$this->image_lib->clear();
					}
			
						$this->load->helper('text');

						$related_category 					= $this->input->post('category_search');
						
						$save['group_id']               	= $id;
						$save['shop_id']               		= $this->session->userdata('shop');
						$save['cat_id']               		= $this->input->post('category_search');
						$save['group_brand']            	= $this->config->item('company_name');
						$save['group_name']					= $this->input->post('group_name');
						$save['seo_title']					= $this->input->post('seo_title');
						$save['meta']						= $this->input->post('meta');
						$slug								= $this->input->post('slug');
						$save['slug']						= $slug;
						
						
					if($related_category != 0){
							
						$group_id					= $this->Group_model->save_($save);
						
						$route['group_id']			= $group_id;
						$route['slug']				= $slug;
						$route['route']				= 'cart/group/'.$group_id.'';
						$relation['group_id']		= $group_id;
						$relation['shop_id']		= $this->session->userdata('shop');
						$relation['category_id']	= $this->input->post('category_search');
					
						$this->Routes_model->save_route($route);
						$this->Routes_model->save_relation($relation);
						
						$this->session->set_flashdata('message', lang('message_category_saved'));
						
						if(!empty($id)){
							redirect($this->config->item('admin_folder').'/groups/form/'.$id);
						}else{
							$this->session->unset_userdata('category');
							redirect($this->config->item('admin_folder').'/groups/form'.$group_id);
						}
					}else{

						$this->session->set_flashdata('no_group', 'No group selected');
						redirect($this->config->item('admin_folder').'/groups/form/');
					}
					
		}
	}
	
	function upload_links($id){

						$link_data['shop_id']		= $this->session->userdata('shop');
						$link_data['group_id']		= $id;
						$link_data['link_name']		= '';
						$link_data['link_new_name'] = $this->input->post('link_1');
						$link_data['country_link'] 	= $this->input->post('country_link');
						$link_data['time'] 			= date('Y-m-d H:i:s');
						$link_data['agent'] 		= $this->session->userdata('ba_username');

						//$this->Group_model->insert_link($link_data);
						$c_i 						= $this->input->post('country_link');
						
						$dir_path 					= $_SERVER['DOCUMENT_ROOT'].'/group_files/link_docs/'.$id.'/'.$c_i;

						if(!file_exists($dir_path)){
								mkdir($dir_path,0777,true);
						}

						$config['upload_path'] 		= FCPATH.'/group_files/link_docs/'.$id.'/'.$c_i;
						$config['allowed_types'] 	= '*';
						$config['file_name'] 		= $this->input->post('link_1');


						$this->load->library('upload', $config);

						if ( ! $this->upload->do_upload()){
							$error = array('error' => $this->upload->display_errors());
							redirect($this->config->item('admin_folder').'/groups/form/'.$id);
							//print_r($error);
						}
						else
						{
							$data = array('upload_data' => $this->upload->data());
							redirect($this->config->item('admin_folder').'/groups/form/'.$id);
					}
	}
			
	function do_upload($id=false){
            
						$dir_path = $_SERVER['DOCUMENT_ROOT'].'/group_files/certificates/'.$id;
						if(!file_exists($dir_path)){
								mkdir($dir_path,0777,true);
							}
						$config['upload_path'] = FCPATH.'/group_files/certificates/'.$id;

						$config['allowed_types'] = '*';
						

						$this->load->library('upload', $config);

						if ( ! $this->upload->do_upload()){

						$error = array('error' => $this->upload->display_errors());

						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
						//print_r($error);
						}
						else
						{
						$data = array('upload_data' => $this->upload->data());
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);

            }
	}  
			
		function delete_file($id,$file){
				
			$this->load->helper('directory');
			$this->load->helper('file');
			$this->load->helper('url');
			
			$dir_path = $_SERVER['DOCUMENT_ROOT'].'/group_files/certificates/'.$id.'/';
			unlink($dir_path.$file);

			redirect($this->config->item('admin_folder').'/groups/form/'.$id);
		}
		
		function delete_link($id,$file,$index){
				
			$this->load->helper('directory');
			$this->load->helper('file');
			$this->load->helper('url');

			$dir_path = $_SERVER['DOCUMENT_ROOT'].'/group_files/link_docs/'.$id.'/'.$index.'/';
			unlink($dir_path.$file);

			redirect($this->config->item('admin_folder').'/groups/form/'.$id);
		}
		
		public function form_NL($id){

					if ($id){
					
						$group								= $this->Group_model->get_group($id,$this->session->userdata('shop'));
						
						$save['group_id']					= $group->group_id;
						$save['shop_id']					= $group->shop_id;
						$save['cat_id']						= $group->cat_id;
					
						$save['group_name_Nederland']		= $this->input->post('group_name_Nederland');
						$save['nick_Nederland']				= $this->input->post('nick_Nederland');
						$save['header_Nederland']			= $this->input->post('header_Nederland');
						$save['description_NL']				= $this->input->post('description_NL');
						$save['link_1']						= $this->input->post('link_1');
						$save['link_2']						= $this->input->post('link_2');
						$save['text_1_NL']					= $this->input->post('text_1_NL');
						$save['text_2_NL']					= $this->input->post('text_2_NL');
						$save['saleprice_NL']				= $this->input->post('saleprice_NL');
						$save['amount_NL']					= $this->input->post('amount_NL');
						
						$this->Group_model->save_NL($save);
						
						$this->session->set_flashdata('message', 'Group changes for Netherlands saved!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
						
					} else {
					
						$this->session->set_flashdata('message', 'Add first group from the general options!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
					}
		}
		public function form_BE($id){

					if ($id){
					
						$group								= $this->Group_model->get_group($id,$this->session->userdata('shop'));
						
						$save['group_id']					= $group->group_id;
						$save['shop_id']					= $group->shop_id;
						$save['cat_id']						= $group->cat_id;
					
						$save['group_name_Belgie']			= $this->input->post('group_name_Belgie');
						$save['nick_Belgie']				= $this->input->post('nick_Belgie');
						$save['header_Belgie']				= $this->input->post('header_Belgie');
						$save['description_BE']				= $this->input->post('description_BE');
						$save['link_1']						= $this->input->post('link_1');
						$save['link_2']						= $this->input->post('link_2');
						$save['text_1_BE']					= $this->input->post('text_1_BE');
						$save['text_2_BE']					= $this->input->post('text_2_BE');
						$save['saleprice_BE']				= $this->input->post('saleprice_BE');
						$save['amount_BE']					= $this->input->post('amount_BE');
						
						$this->Group_model->save_BE($save);
						
						$this->session->set_flashdata('message', 'Group changes for Belgium/NL saved!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
						
					} else {
					
						$this->session->set_flashdata('message', 'Add first group from the general options!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
					}
		}

		public function form_BEL($id){

					if ($id){
					
						$group								= $this->Group_model->get_group($id,$this->session->userdata('shop'));
						
						$save['group_id']					= $group->group_id;
						$save['shop_id']					= $group->shop_id;
						$save['cat_id']						= $group->cat_id;
					
						$save['group_name_Belgique']		= $this->input->post('group_name_Belgique');
						$save['nick_Belgique']				= $this->input->post('nick_Belgique');
						$save['header_Belgique']			= $this->input->post('header_Belgique');
						$save['description_BEL']			= $this->input->post('description_BEL');
						$save['link_1']						= $this->input->post('link_1');
						$save['link_2']						= $this->input->post('link_2');
						$save['text_1_BEL']					= $this->input->post('text_1_BEL');
						$save['text_2_BEL']					= $this->input->post('text_2_BEL');
						$save['saleprice_BEL']				= $this->input->post('saleprice_BEL');
						$save['amount_BEL']					= $this->input->post('amount_BEL');
						
						$this->Group_model->save_BEL($save);
																//echo '<pre>';
						//print_r($save);
						//echo '</pre>';
						
						$this->session->set_flashdata('message', 'Group changes for Belgium/FR saved!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
						
					} else {
					
						$this->session->set_flashdata('message', 'Add first group from the general options!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
					}
		}
		
		public function form_FR($id){

					if ($id){
					
						$group								= $this->Group_model->get_group($id,$this->session->userdata('shop'));
						
						$save['group_id']					= $group->group_id;
						$save['shop_id']					= $group->shop_id;
						$save['cat_id']						= $group->cat_id;
					
						$save['group_name_France']			= $this->input->post('group_name_France');
						$save['nick_France']				= $this->input->post('nick_France');
						$save['header_France']				= $this->input->post('header_France');
						$save['description_FR']				= $this->input->post('description_FR');
						$save['link_1']						= $this->input->post('link_1');
						$save['link_2']						= $this->input->post('link_2');
						$save['text_1_FR']					= $this->input->post('text_1_FR');
						$save['text_2_FR']					= $this->input->post('text_2_FR');
						$save['saleprice_FR']				= $this->input->post('saleprice_FR');
						$save['amount_FR']					= $this->input->post('amount_FR');
						
						$this->Group_model->save_FR($save);

						
						$this->session->set_flashdata('message', 'Group changes for France saved!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
						
					} else {
					
						$this->session->set_flashdata('message', 'Add first group from the general options!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
					}
		}
		
		public function form_DE($id){

					if ($id){
					
						$group								= $this->Group_model->get_group($id,$this->session->userdata('shop'));
						
						$save['group_id']					= $group->group_id;
						$save['shop_id']					= $group->shop_id;
						$save['cat_id']						= $group->cat_id;
					
						$save['group_name_Deutschland']		= $this->input->post('group_name_Deutschland');
						$save['nick_Deutschland']			= $this->input->post('nick_Deutschland');
						$save['header_Deutschland']			= $this->input->post('header_Deutschland');
						$save['description_DE']				= $this->input->post('description_DE');
						$save['link_1']						= $this->input->post('link_1');
						$save['link_2']						= $this->input->post('link_2');
						$save['text_1_DE']					= $this->input->post('text_1_DE');
						$save['text_2_DE']					= $this->input->post('text_2_DE');
						$save['saleprice_DE']				= $this->input->post('saleprice_DE');
						$save['amount_DE']					= $this->input->post('amount_DE');
						
										//echo '<pre>';
						//print_r($save);
						//echo '</pre>';
						
						
						$this->Group_model->save_DE($save);
						
						$this->session->set_flashdata('message', 'Group changes for Deutschland saved!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
						
					} else {
					
						$this->session->set_flashdata('message', 'Add first group from the general options!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
					}
		}
		
		public function form_AU($id){

					if ($id){
					
						$group								= $this->Group_model->get_group($id,$this->session->userdata('shop'));
						
						$save['group_id']					= $group->group_id;
						$save['shop_id']					= $group->shop_id;
						$save['cat_id']						= $group->cat_id;
					
						$save['group_name_Österreich']		= $this->input->post('group_name_Österreich');
						$save['nick_Österreich']			= $this->input->post('nick_Österreich');
						$save['header_Österreich']			= $this->input->post('header_Österreich');
						$save['description_AU']				= $this->input->post('description_AU');
						$save['link_1']						= $this->input->post('link_1');
						$save['link_2']						= $this->input->post('link_2');
						$save['text_1_AU']					= $this->input->post('text_1_AU');
						$save['text_2_AU']					= $this->input->post('text_2_AU');
						$save['saleprice_AU']				= $this->input->post('saleprice_AU');
						$save['amount_AU']					= $this->input->post('amount_AU');
						
						//echo '<pre>';
						//print_r($save);
						//echo '</pre>';
						
						$this->Group_model->save_AU($save);
						
						$this->session->set_flashdata('message', 'Group changes for Österreich saved!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
						
					} else {
					
						$this->session->set_flashdata('message', 'Add first group from the general options!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
					}
		}
		
		public function form_LX($id){

					if ($id){
					
						$group								= $this->Group_model->get_group($id,$this->session->userdata('shop'));
						
						$save['group_id']					= $group->group_id;
						$save['shop_id']					= $group->shop_id;
						$save['cat_id']						= $group->cat_id;
					
						$save['group_name_Luxembourg']		= $this->input->post('group_name_Luxembourg');
						$save['nick_Luxembourg']			= $this->input->post('nick_Luxembourg');
						$save['header_Luxembourg']			= $this->input->post('header_Luxembourg');
						$save['description_LX']				= $this->input->post('description_LX');
						$save['link_1']						= $this->input->post('link_1');
						$save['link_2']						= $this->input->post('link_2');
						$save['text_1_LX']					= $this->input->post('text_1_LX');
						$save['text_2_LX']					= $this->input->post('text_2_LX');
						$save['saleprice_LX']				= $this->input->post('saleprice_LX');
						$save['amount_LX']					= $this->input->post('amount_LX');
						
						$this->Group_model->save_LX($save);
						
						$this->session->set_flashdata('message', 'Group changes for Luxembourg saved!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
						
					} else {
					
						$this->session->set_flashdata('message', 'Add first group from the general options!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
					}
		}
		
		public function form_UK($id){

					if ($id){
					
						$group								= $this->Group_model->get_group($id,$this->session->userdata('shop'));
						
						$save['group_id']					= $group->group_id;
						$save['shop_id']					= $group->shop_id;
						$save['cat_id']						= $group->cat_id;
					
						$save['group_name_UK']				= $this->input->post('group_name_UK');
						$save['nick_UK']					= $this->input->post('nick_UK');
						$save['header_UK']					= $this->input->post('header_UK');
						$save['description_UK']				= $this->input->post('description_UK');
						$save['link_1']						= $this->input->post('link_1');
						$save['link_2']						= $this->input->post('link_2');
						$save['text_1_UK']					= $this->input->post('text_1_UK');
						$save['text_2_UK']					= $this->input->post('text_2_UK');
						$save['saleprice_UK']				= $this->input->post('saleprice_UK');
						$save['amount_UK']					= $this->input->post('amount_UK');
						
						$this->Group_model->save_UK($save);
						
						$this->session->set_flashdata('message', 'Group changes for United Kingdom saved!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
						
					} else {
					
						$this->session->set_flashdata('message', 'Add first group from the general options!');
						redirect($this->config->item('admin_folder').'/groups/form/'.$id);
					}
		}
		
		
		
		public function update_products($id){
		
		//echo '<pre>';

		
		$post = $this->input->post(null, false);
		
		foreach($post as $product){
			foreach($product as $key=>$value){
				foreach($value as $k=>$v){
					$money = array('€','£');
					$r[$k] = str_replace($money,'',$v);
				}
				$this->Product_model->update_products($key,$r,$this->session->userdata('shop'));
			}
		}
		redirect($this->config->item('admin_folder').'/groups/view_products/'.$id);
		
		
		//echo '</pre>';			
		
		
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
}
