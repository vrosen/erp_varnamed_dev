<?php

class Categories extends CI_Controller {	
	
    public $data_shop;
    public $language;
    /////////////////
    private $groups;
    private $products;        
    
    function __construct()
    {		
	parent::__construct();
		
	remove_ssl();
	
        $this->load->model(array('Category_model','Group_model','Product_model','Shop_model','Search_model'));
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('formatting');
		$this->load->model('Routes_model');
									$this->load->helper('text');
        ////////////////////////////////////////////////////////////////
        $this->language     = $this->session->userdata('language');
        $this->data_shop    = $this->session->userdata('shop');
        ////////////////////////////////////////////////////////////////
        $this->lang->load('category',$this->language);
        $this->lang->load('dashboard',$this->language);
        ////////////////////////////////////////////////////////////////
        //$this->groups       = $this->Group_model->get_all_the_groups();
        //$this->products     = $this->Product_model->get_all_products();
										$this->categories   = array(1);
								$this->groups     	= array(1);
								$this->products     = array(1);
		
		
    }
	
			function index() {
				
				if(!$this->bitauth->logged_in()){
					$this->session->set_userdata('redir', current_url());
					redirect($this->config->item('admin_folder').'/admin/login');
				}
				$data['can_edit_categories']	= $this->bitauth->has_role('can_edit_categories');
				$data['groups']     			= $this->groups;
				$data['products']   			= $this->products;
				$data['all_shops']  			= $this->Shop_model->get_shops();

				$data['categories']				= $this->Category_model->get_current_categories($this->session->userdata('shop'));

				for($i=1;$i<20;$i++){
					$count[] = $i;
				}
				$data['counter']				= $count;
				
				$timeid = 0;
				if($timeid==0){
					$time = time();
				}	
				else {
					$time = $timeid;
				}
				$data['weather']	=	_date($time);
				$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
				
				$this->load->view($this->config->item('admin_folder').'/categories', $data);
			}

	function category_autocomplete(){
            
		$name	= trim($this->input->post('name'));
		$limit	= $this->input->post('limit');
		
		if(empty($name)){
			echo json_encode(array());
		}
		else{
			$results	= $this->Category_model->category_autocomplete($name, $limit);
			
			$return		= array();
			foreach($results as $r){
				$return[$r->id]	= $r->name;
			}
			echo json_encode($return);
		}
	}
	
		function organize($id = false,$token=false){

				if(!$this->bitauth->logged_in()){
					$this->session->set_userdata('redir', current_url());
					redirect($this->config->item('admin_folder').'/admin/login');
				}
			
			$data['categories']     	= $this->categories;
			$data['groups']     		= $this->groups;
			$data['products']   		= $this->products;
			$data['all_shops']  		= $this->Shop_model->get_shops();
			$data['shop_nationality']	= '';
			$data['price']				= 'saleprice_NL';
			$data['id']					= $id;
			
				if (!$id){
					$this->session->set_flashdata('error', lang('error_must_select'));
					redirect($this->config->item('admin_folder').'/categories');
				}
					
			$data['category']		= $this->Category_model->get_category($id,$this->session->userdata('shop'));

			$data['slug']	= $data['category']->slug;
				if (!$data['category']){
					$this->session->set_flashdata('error', lang('error_not_found'));
					redirect($this->config->item('admin_folder').'/categories');
				}
						
			$data['category_groups']	= $this->Category_model->get_category_groups_admin($id,$this->session->userdata('shop'));
			//print_r($data['category_groups']);
                        
                        
			$languages 		= array('0'=>'Select language','english'=>'UK','german'=>'Deutschland','french'=>'France','dutch'=>'Nederland','BG'=>'Bulgarian'); 
			$languages_1 	= array('0'=>'Select language','english'=>'UK','german'=>'DE','french'=>'FR','dutch'=>'NL','BG'=>'BG'); 
			$languages_2 	= array('0'=>'Select language','english'=>'UK','german'=>'Deutschland','french'=>'France','dutch'=>'Nederland','BG'=>'BG'); 
			
			if(!empty($this->session->userdata('language'))){
				$lang_index 					= $languages[$this->session->userdata('language')];
				$lang_index_group 					= $languages_2[$this->session->userdata('language')];
			}else{
				$lang_index 					= 'NL';
				$lang_index_group 				= 'Nederland';
			}
			
			$data['all_shops_national'] 	= $this->Category_model->get_shop_nationalities($this->session->userdata('shop'));
			
			$shop_post = $this->input->post('shop_nationality');
			
			if(!empty($shop_post)){
				$this->session->set_userdata('shop_nationality',$this->input->post('shop_nationality'));
				$data['shop_nationality']	=	$this->session->userdata('shop_nationality');
				$price_index				=	$this->session->userdata('shop_nationality');
				$data['price'] 				=	'saleprice_'.$price_index;
				$data['price_index'] 		=	$this->session->userdata('shop_nationality'); 	
			}else{
				$data['price'] 				=	'saleprice_NL';
				$data['price_index'] 		=	$this->session->userdata('shop_nationality'); 	
			}

			
			
			
			
			$data['name']	=	'group_name_'.$lang_index_group;
			
			//$data['price']	=	'group_name_'.$lang_index;
			
			$timeid = 0;
			if($timeid==0){
				$time = time();
			}else {
				$time = $timeid;
			}
			$data['weather']	=	_date($time);
			$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
			
			$this->load->view($this->config->item('admin_folder').'/organize_category', $data);
		}
	
			function process_organization($id,$token){

					$groups	= $this->input->post('group');
					$this->Category_model->organize_contents($id, $groups,$this->session->userdata('shop'));
			}
	
				function form($id = false,$token=false){

										if(!$this->bitauth->logged_in()){
											$this->session->set_userdata('redir', current_url());
											redirect($this->config->item('admin_folder').'/admin/login');
										}
										
										$data['groups']     = $this->groups;
										$data['products']   = $this->products;
										$data['categories']   = $this->categories;
										$data['all_shops']  =   $this->Shop_model->get_shops();

										$this->category_id              = $id;

									
										//default values are empty if the customer is new
										$data['id']				= '';
										$data['shop_id']		= $this->data_shop;
										$data['name_nl']		= '';
										$data['name_be']		= '';
										$data['name_bel']		= '';
										$data['name_fr']		= '';
										$data['name_de']		= '';
										$data['name_au']		= '';
										$data['name_lx']		= '';
										$data['name_uk']		= '';
										$data['slug']			= '';
										$data['description']    = '';
										$data['excerpt']		= '';
										$data['sequence']		= '';
										$data['image']			= '';
										$data['seo_title']		= '';
										$data['meta']			= '';
										$data['parent_id']		= 0;
										$data['error']			= '';
										$data['token']			= '';
										$data['category_title']	= lang('add_category');
								
								if ($id){
								
										$category				= $this->Category_model->get_category($id, $this->session->userdata('shop'));

										if (!$category){
													$this->session->set_flashdata('error', lang('error_not_found'));
													redirect($this->config->item('admin_folder').'/categories');
											}
									
							
										$data['id']				= $category->id;
										$data['shop_id']		= $this->data_shop;
										$data['name_nl']		= $category->name_NL;
										$data['name_be']		= $category->name_BE;
										$data['name_bel']		= $category->name_BEL;
										$data['name_fr']		= $category->name_FR;
										$data['name_de']		= $category->name_DE;
										$data['name_au']		= $category->name_AU;
										$data['name_lx']		= $category->name_LX;
										$data['name_uk']		= $category->name_UK;
										$data['slug']			= $category->slug;
										$data['description']    = $category->description;
										$data['excerpt']		= $category->excerpt;
										$data['sequence']		= $category->sequence;
										$data['parent_id']		= $category->parent_id;
										$data['image']			= $category->image;
										$data['seo_title']		= $category->seo_title;
										$data['meta']			= $category->meta;
										$data['token']			= $token;
										$data['category_title']	= lang('edit_category');

								}
								
								$this->form_validation->set_rules('description', 'lang:description', 'trim');
								
								if ($this->form_validation->run() == FALSE){
								
									$timeid = 0;
									if($timeid==0){
										$time = time();
									}	
									else {
										$time = $timeid;
									}
									$data['weather']	=	_date($time);
									$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
									$this->load->view($this->config->item('admin_folder').'/category_form', $data);
								}
								else {

									

									$slug = $this->input->post('slug');

									if(empty($slug) || $slug=='')
									{
										$slug = $this->input->post('name');
									}
									
									$slug	= url_title(convert_accented_characters($slug), 'dash', TRUE);
									
									
									if($id)
									{
										$slug	= $this->Routes_model->validate_slug($slug, $category->route_id);
										$route_id	= $category->route_id;
									}
									else
									{
										$slug	= $this->Routes_model->validate_slug($slug);
										
										$route['slug']	= $slug;	
										$route_id	= $this->Routes_model->save($route);
									}

									$save['id']				= $id;
									$save['shop_id']		= $this->session->userdata('shop');
									$save['name']			= $this->input->post('name_nl');
									$save['name_NL']		= $this->input->post('name_nl');
									$save['name_BE']		= $this->input->post('name_be');
									$save['name_BEL']		= $this->input->post('name_bel');
									$save['name_FR']		= $this->input->post('name_fr');
									$save['name_DE']		= $this->input->post('name_de');
									$save['name_AU']		= $this->input->post('name_au');
									$save['name_LX']		= $this->input->post('name_lx');
									$save['name_UK']		= $this->input->post('name_uk');

									$save['description']    = $this->input->post('description');
									$save['excerpt']		= $this->input->post('excerpt');
									$save['parent_id']		= intval($this->input->post('parent_id'));
									$save['sequence']		= intval($this->input->post('sequence'));
									$save['seo_title']		= $this->input->post('seo_title');
									$save['meta']			= $this->input->post('meta');

									$save['route_id']		= intval($route_id);
									$save['slug']			= $slug;
									
									$category_id			= $this->Category_model->save($save,$this->session->userdata('shop'));

									//echo '<pre>';
									//print_r($save);
									//echo '<pre>';
									
									$route['id']	= $route_id;
									$route['slug']	= $slug;
									$route['route']	= 'cart/category/'.$category_id.'';
									
									$this->Routes_model->save($route);
									
									$this->session->set_flashdata('message', lang('message_category_saved'));
									if(!empty($id)){
										redirect($this->config->item('admin_folder').'/categories/form/'.$id.'/'.$token);
									}else{
										redirect($this->config->item('admin_folder').'/categories/');
									}
									
								}
					}

	function delete($id,$slug=false)
	{
		
		$category	= $this->Category_model->get_category($id,$this->session->userdata('shop'));
		//if the category does not exist, redirect them to the customer list with an error
		if ($category)
		{
			$this->load->model('Routes_model');
			
			$this->Routes_model->delete($category->route_id);
			$this->Category_model->delete($id);
			
			$this->session->set_flashdata('message', lang('message_delete_category'));
			redirect($this->config->item('admin_folder').'/categories');
		}
		else
		{
			$this->session->set_flashdata('error', lang('error_not_found'));
		}
	}
}