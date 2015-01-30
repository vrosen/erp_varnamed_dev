<?php

class Reports extends CI_Controller {

	//this is used when editing or adding a customer
	var $customer_id	= false;	
        public $data_shop;
        public $language;
        
        
	function __construct()
	{		
		parent::__construct();
		remove_ssl();

		//check admin access
		
		$this->load->model('Order_model');
		$this->load->model('Search_model');
                ////////////////////////////////////////////////////////////////
		$this->load->helper(array('formatting'));
		////////////////////////////////////////////////////////////////
                $this->language     = $this->session->userdata('language');
                $this->data_shop    = $this->session->userdata('shop');
                ////////////////////////////////////////////////////////////////
                $this->lang->load('report',  $this->language);
                $this->lang->load('dashboard',  $this->language);
	}
	
	function index()
	{
		$data['page_title']	= lang('reports');
		$data['years']		= $this->Order_model->get_sales_years();
                $data['admins']	= $this->auth->get_admin_list();
		$this->load->view($this->config->item('admin_folder').'/reports', $data);
	}
	
	function best_sellers()
	{
		$start	= $this->input->post('start');
		$end	= $this->input->post('end');
		$data['best_sellers']	= $this->Order_model->get_best_sellers($start, $end);
		
		$this->load->view($this->config->item('admin_folder').'/reports/best_sellers', $data);	
	}
	
	function sales()
	{
		$year			= $this->input->post('year');
		$data['orders']	= $this->Order_model->get_gross_monthly_sales($year);
		$this->load->view($this->config->item('admin_folder').'/reports/sales', $data);	
	}

}