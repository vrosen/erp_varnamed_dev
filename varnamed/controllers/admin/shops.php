<?php

class Shops extends CI_Controller {	
	
	var $shop_id;
        public $language;
        private $products;
        private $groups;
        private $categories;
        
        
	function __construct(){		
		parent::__construct();
		
		force_ssl();
		//check admin access
		$this->load->model(array('Shop_model','Product_model','Group_model','Category_model','Search_model'));
                ////////////////////////////////////////////////////////////////
                $this->language     = $this->session->userdata('language');
		////////////////////////////////////////////////////////////////
                $this->lang->load('shop',  $this->language);
                $this->lang->load('dashboard',  $this->language);
                $this->groups                   = $this->Group_model->get_all_the_groups();
                $this->products                 = $this->Product_model->get_all_products();
                $this->categories               = $this->Category_model->get_all_categories();
	}
	
	function index(){
	        if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
			}
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['all_shops']  =   $this->Shop_model->get_shops();
		$data['page_title']	= lang('shops');

                $data['shops']	= $this->Shop_model->get_shops();
						$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));

		$this->load->view($this->config->item('admin_folder').'/shops', $data);
	}
        public function shop(){
		
	        if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
			}
			
				$current_session = 	$this->session->userdata('shop');
                $shop = $this->input->post('shop');
                if(!empty($shop)){
					if(!empty($current_session)){
						$this->session->unset_userdata('shop');
					}
				$this->session->set_userdata('shop',$shop);
                }
				
				
				$site = str_replace('admin','',$this->input->post('url'));
				redirect($this->config->item('admin_folder').'/'.$site);
                
}
	
	function form($id = false){
	        if(!$this->bitauth->logged_in()){
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder').'/admin/login');
			}
            $data['all_shops']  =   $this->Shop_model->get_shops();
                            $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
		$this->load->helper(array('form', 'date'));
		$this->load->library('form_validation');
		
                $this->auth->check_access('Admin', true);
                $data['admins']         = $this->auth->get_admin_list();
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$this->shop_id	= $id;
		
		$data['page_title']		= lang('shop_form');
		$data['shop_products']          = $this->Shop_model->get_products($id);
                $data['shop_groups']            = $this->Shop_model->get_groups($id);
                $data['shop_categories']        = $this->Shop_model->get_categories($id);
                $data['shop_admins']            = $this->Shop_model->get_admins($id);
                
                
		//default values are empty if the product is new
		$data['shop_id']					= '';
		$data['shop_name']					= '';
		$data['shop_creation_date']				= '';

                
		$added = array();
		
		if ($id){	
			$shop		= $this->Shop_model->get_shop($id);

			//if the product does not exist, redirect them to the product list with an error
			if (!$shop)
			{
				$this->session->set_flashdata('message', lang('error_not_found'));
				redirect($this->config->item('admin_folder').'/shops');
			}
			
			//set values to db values
			$data['shop_id']				= $shop->shop_id;
			$data['shop_name']				= $shop->shop_name;
			$data['shop_creation_date']			= $shop->shop_creation_date;
                        $data['activ']                                  = $shop->active;
			
			$added = $this->Shop_model->get_product_ids($id);
		}
		
		$this->form_validation->set_rules('shop_name', 'lang:shop_name', 'trim|required|');
		
                

		
 
		
	
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
                    
                    
			$this->load->view($this->config->item('admin_folder').'/shop_form', $data);
		}
		else{
			$save['shop_id']					= $id;
			$save['shop_name']					= $this->input->post('shop_name');
			$save['shop_creation_date']				= $this->input->post('shop_creation_date');

		
			$promo_id = $this->Shop_model->save($save);
			$this->session->set_flashdata('message', lang('message_saved_coupon'));
			
			//go back to the product list
			redirect($this->config->item('admin_folder').'/shops');
		}
	}

	//this is a callback to make sure that 2 coupons don't have the same code
	function check_code($str)
	{
		$code = $this->Coupon_model->check_code($str, $this->coupon_id);
        if ($code)
       	{
			$this->form_validation->set_message('check_code', lang('error_already_used'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$coupon	= $this->Coupon_model->get_coupon($id);
			//if the promo does not exist, redirect them to the customer list with an error
			if (!$coupon)
			{
				$this->session->set_flashdata('error', lang('error_not_found'));
				redirect($this->config->item('admin_folder').'/coupons');
			}
			else
			{
				$this->Coupon_model->delete_coupon($id);
				
				$this->session->set_flashdata('message', lang('message_coupon_deleted'));
				redirect($this->config->item('admin_folder').'/coupons');
			}
		}
		else
		{
			//if they do not provide an id send them to the promo list page with an error
			$this->session->set_flashdata('message', lang('error_not_found'));
			redirect($this->config->item('admin_folder').'/coupons');
		}
	}
}