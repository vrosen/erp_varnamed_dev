<?php

class Settings extends CI_Controller {
    
    
        public $data_shop;
        public $language;	
        ////////////////////////////////////////////////////////////////////////////
        private $products;
        private $groups;
        private $categories;
    ////////////////////////////////////////////////////////////////////////////
    
    
	function __construct()
	{
		parent::__construct();
		remove_ssl();

		//check access
		$this->load->model(array('Settings_model','Group_model','Product_model','Category_model','Shop_model'));
		$this->load->model('Messages_model');
                ////////////////////////////////////////////////////////////////
                $this->language     = $this->session->userdata('language');
                $this->data_shop    = $this->session->userdata('shop');
                ////////////////////////////////////////////////////////////////
                $this->lang->load('settings',  $this->language);
                $this->lang->load('dashboard',  $this->language);
                ////////////////////////////////////////////////////////////////
                $this->groups                   = $this->Group_model->get_all_the_groups();
                $this->products                 = $this->Product_model->get_all_products();
                $this->categories               = $this->Category_model->get_all_categories();
                ////////////////////////////////////////////////////////////////
	}
	
	function index()
	{
                           
                //menu items
                $data['categories'] = $this->categories;
                $data['groups']     = $this->groups;
                $data['products']   = $this->products;
                $data['all_shops']  =   $this->Shop_model->get_shops();
		//we're going to handle the shipping and payment model landing page with this, basically
		
		//Payment Information
		$payment_order		= $this->Settings_model->get_settings('payment_order');
		$enabled_modules	= $this->Settings_model->get_settings('payment_modules');
		
		$data['payment_modules']	= array();
		//create a list of available payment modules
		if ($handle = opendir(APPPATH.'packages/payment/')) {
			while (false !== ($file = readdir($handle)))
			{
				//now we eliminate the periods from the list.
				if (!strstr($file, '.'))
				{
					//also, set whether or not they are installed according to our payment settings
					if(array_key_exists($file, $enabled_modules))
					{
						$data['payment_modules'][$file]	= true;
					}
					else
					{
						$data['payment_modules'][$file]	= false;
					}
				}
			}
			closedir($handle);
		}
		//now time to do it again with shipping
		$shipping_order		= $this->Settings_model->get_settings('shipping_order');
		$enabled_modules	= $this->Settings_model->get_settings('shipping_modules');
		
		$data['shipping_modules']	= array();
		//create a list of available shipping modules
		if ($handle = opendir(APPPATH.'packages/shipping/')) {
			while (false !== ($file = readdir($handle)))
			{
				//now we eliminate anything with periods
				if (!strstr($file, '.'))
				{
					//also, set whether or not they are installed according to our shipping settings
					if(array_key_exists($file, $enabled_modules))
					{
						$data['shipping_modules'][$file]	= true;
					}
					else
					{
						$data['shipping_modules'][$file]	= false;
					}
				}
			}
			closedir($handle);
		}
		
		$data['canned_messages'] = $this->Messages_model->get_list();
		
                $this->current_admin	= $this->session->userdata('admin');
                $data['admins']	= $this->auth->get_admin_list();
                
                
		$data['page_title']	= lang('settings');
		$this->load->view($this->config->item('admin_folder').'/settings', $data);
	}
	
	function canned_message_form($id=false)
	{
		$data['page_title'] = lang('canned_message_form');

		$data['id']			= $id;
		$data['name']		= '';
		$data['subject']	= '';
		$data['content']	= '';
		$data['deletable']	= 1;
		
		if($id)
		{
			$message = $this->Messages_model->get_message($id);
						
			$data['name']		= $message['name'];
			$data['subject']	= $message['subject'];
			$data['content']	= $message['content'];
			$data['deletable']	= $message['deletable'];
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'lang:message_name', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('subject', 'lang:subject', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('content', 'lang:message_content', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['errors'] = validation_errors();
			
			$this->load->view($this->config->item('admin_folder').'/canned_message_form', $data);
		}
		else
		{
			
			$save['id']			= $id;
			$save['name']		= $this->input->post('name');
			$save['subject']	= $this->input->post('subject');
			$save['content']	= $this->input->post('content');
			
			//all created messages are typed to order so admins can send them from the view order page.
			if($data['deletable'])
			{
				$save['type'] = 'order';
			}
			$this->Messages_model->save_message($save);
			
			$this->session->set_flashdata('message', lang('message_saved_message'));
			redirect($this->config->item('admin_folder').'/settings');
		}
	}
	
	function delete_message($id)
	{
		$this->Messages_model->delete_message($id);
		
		$this->session->set_flashdata('message', lang('message_deleted_message'));
		redirect($this->config->item('admin_folder').'/settings');
	}
}