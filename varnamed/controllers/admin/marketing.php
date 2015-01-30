<?php

class Marketing extends CI_Controller {

	//this is used when editing or adding a customer
	var $customer_id	= false;	
        protected $post;
        protected $term;
        protected $code;
	private   $use_inventory = false;
        protected $page_title;
        protected $categories;
        protected $category_id;
        protected $categories_dropdown;
        public   $data_shop;
        public   $language;
        
        

        public function __construct(){		
		parent::__construct();

                remove_ssl();
                
                //check access
		$this->load->model(array('Customer_model', 'Location_model','Search_model','Option_model', 'Category_model'));
                ////////////////////////////////////////////////////////////////
		$this->load->helper('formatting_helper');
                $this->load->helper('form');
                ////////////////////////////////////////////////////////////////
                $this->post         =   $this->input->post(null, false);
                $this->term         =   false;
                $this->language     = $this->session->userdata('language');
                $this->data_shop    = $this->session->userdata('shop');
                ////////////////////////////////////////////////////////////////
		$this->lang->load('marketing',  $this->language);
                $this->lang->load('dashboard',  $this->language);
                $this->page_title   = lang('customers');
	}

        function index(){
            
            $this->general_search();

	}
        public function general_search($field='lastname', $by='ASC', $page=0){
            
            
                $this->auth->check_access('Admin', true);		
		$this->current_admin	= $this->session->userdata('admin');
                //$data['admins']		= $this->auth->get_admin_list();
                
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

                    $country                = $this->input->post('country');
                    $status                 = $this->input->post('status');
                    $function               = $this->input->post('function');
                    $gender                 = $this->input->post('gender');
                    $order_nr               = $this->input->post('order_num');
                    $client_nr              = $this->input->post('client_num');
                    $client_name            = $this->input->post('client_name');
                    $client_lname           = $this->input->post('client_lname');
                    
                    $street_name            = $this->input->post('client_lname');
                    $street_number          = $this->input->post('client_lname');
                    $zip_code               = $this->input->post('zip_code');
                    $email                  = $this->input->post('email');
                    $has_order              = $this->input->post('client_lname');//bool
                    $products_bought        = $this->input->post('client_lname');//product list
                    //include a seaparerter functiuon
                    //chech the products both for a period and exlude them from the array of the other products and then display the result of the left
                    $products_never_bought  = $this->input->post('client_lname');//date input for a period
                    
                    $total_order_ammount    = $this->input->post('client_lname');//checkbox
                    $total_ve_orders        = $this->input->post('client_lname');//???????
                    $shopping_frequency     = $this->input->post('client_lname');//separate function  
                    $last_order             = $this->input->post('client_lname');//months dropdown
                    $last_order_products    = $this->input->post('client_lname');//products dropdown from where to choose a specific product, a way of adding more than one
                    
                    $recieved_samples       = $this->input->post('recieved_samples');//checkbox bool result
                    $action_code            = $this->input->post('action_code');//input
                    
                    $turnover_per_year      = $this->input->post('turnover_per_year');//date dropdown, year dropdown
                    $turnover_per_month     = $this->input->post('turnover_per_month');//date dropdown, month dropdown, validation for chosen year       

/*******************************************************************************************************/
//Client details search
                if(!empty($_POST['client_information'])){

                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('country', 'lang:country', '');
                    $this->form_validation->set_rules('status', 'lang:status', '');
                    $this->form_validation->set_rules('function', 'lang:function', '');
                    $this->form_validation->set_rules('gender', 'lang:gender', '');
                    $this->form_validation->set_rules('order_num', 'lang:order_num', 'trim|numeric');
                    $this->form_validation->set_rules('client_num', 'lang:client_num', 'trim|numeric');
                    $this->form_validation->set_rules('client_name', 'lang:client_name', 'trim');
                    $this->form_validation->set_rules('client_lname', 'lang:client_lname', 'trim');

                    if ($this->form_validation->run() == FALSE) {
                    $this->form_validation->set_message('numeric', 'Error Message');
                    }
                    else {
                    $data_form = array(

                                'country'       =>      $country,//0
                                'status'        =>      $status,//1
                                'function'      =>      $function,//2
                                'gender'        =>      $gender,//3
                                'order_num'     =>      $order_nr,//4
                                'client_num'    =>      $client_nr,//5
                                'client_name'   =>      $client_name,//6
                                'client_lname'  =>      $client_lname,//7
                    );
                    $report_data['report_details'] = $this->Customer_model->filter($data_form);

                    $report_data['page_title'] = lang('report_page_title');
                    $this->current_admin	= $this->session->userdata('admin');
                    $report_data['admins']	= $this->auth->get_admin_list();
                    $this->load->view($this->config->item('admin_folder').'/customer_report',$report_data);
                    }
                }
/*******************************************************************************************************/
//Contact information
                if(!empty($_POST['contact_information'])){

                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('country', 'lang:country', '');
                    $this->form_validation->set_rules('gender', 'lang:gender', '');
                    $this->form_validation->set_rules('zip_code', 'lang:zip_code', 'trim|numeric');
                    $this->form_validation->set_rules('function', 'lang:function', '');

                    if ($this->form_validation->run() == FALSE) {
                    $this->form_validation->set_message('numeric', 'Error Message');
                    }
                    else {
                    $data_form_1 =  array(
                                'country'       =>      $country,
                                'gender'        =>      $gender,
                                'zip_code'      =>      $zip_code,
                                'function'      =>      $function,
                    );
                    //print_r($data_form_1);
                    $report_data['report_details'] = $this->Customer_model->filter_1($data_form_1);

                    $report_data['page_title']  = lang('report_page_title');
                    $this->current_admin	= $this->session->userdata('admin');
                    $report_data['admins']	= $this->auth->get_admin_list();
                    $this->load->view($this->config->item('admin_folder').'/customer_report',$report_data);
                    }
                }
/*******************************************************************************************************/
//Contact info-email
                if(!empty($_POST['contact_info'])){
                    
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('email', 'lang:email', 'email');
                    $this->form_validation->set_rules('function', 'lang:function', '');
                    $this->form_validation->set_rules('gender', 'lang:gender', '');
                    $this->form_validation->set_rules('order_num', 'lang:order_num', 'trim|numeric');
                    $this->form_validation->set_rules('client_num', 'lang:client_num', 'trim|numeric');
                    
                    if ($this->form_validation->run() == FALSE) {
                    $this->form_validation->set_message('numeric', 'Error Message');
                    }
                    else {
                    $data_form_2 = array(

                                'email'             =>      $email,//0
                                'function'          =>      $function,//2
                                'gender'            =>      $gender,//3
                                'client_name'       =>      $client_name,//6
                                'client_lname'      =>      $client_lname,//7
                        );
                    
                    //print_r($data_form_2);
                    $report_data['report_details']  = $this->Customer_model->filter_2($data_form_2);
                    
                    $report_data['page_title']      = lang('report_page_title');
                    $this->current_admin            = $this->session->userdata('admin');
                    $report_data['admins']          = $this->auth->get_admin_list();
                    $this->load->view($this->config->item('admin_folder').'/customer_report',$report_data);
                    
                    }
                }
/*******************************************************************************************************/
//Past order behavior
                if(!empty($_POST['order_behavior'])){

                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('recieved_samples', 'lang:recieved_samples', '');
                    $this->form_validation->set_rules('action_code', 'lang:action_code', '');
                    if ($this->form_validation->run() == FALSE) {

                    $this->form_validation->set_message('numeric', 'Error Message');
                    }
                    else {
                    $data_form_3 = array(

                                'recieved_samples'   =>      $recieved_samples,//0
                                'action_code'        =>      $action_code,//1
                        );
                        print_r($data_form_3);
                    //$report_data['report_details'] = $this->Customer_model->filter_3($data_form_3);

                    $report_data['page_title']  = lang('report_page_title');
                    $this->current_admin	= $this->session->userdata('admin');
                    $report_data['admins']	= $this->auth->get_admin_list();
                    $this->load->view($this->config->item('admin_folder').'/customer_report',$report_data);

                    }
                }
/*******************************************************************************************************/
//Marketing actions
                if(!empty($_POST['marketing_actions'])){

                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('turnover_per_year', 'lang:turnover_per_year', '');
                    $this->form_validation->set_rules('turnover_per_month', 'lang:turnover_per_month', '');

                    if ($this->form_validation->run() == FALSE) {
                    $this->form_validation->set_message('numeric', 'Error Message');
                    }
                    else {
                    $data_form_4 = array(
                                'turnover_per_year'         =>      $turnover_per_year,//0
                                'turnover_per_month'        =>      $turnover_per_month,//1
                        );
                        print_r($data_form_4);
                    //$report_data['report_details'] = $this->Customer_model->filter_4($data_form_4);

                    $report_data['page_title']  = lang('report_page_title');
                    $this->current_admin	= $this->session->userdata('admin');
                    $report_data['admins']	= $this->auth->get_admin_list();
                    $this->load->view($this->config->item('admin_folder').'/customer_report',$report_data);
                    }
                }
                
                
                
                $this->current_admin	= $this->session->userdata('admin');
                $data['admins']	= $this->auth->get_admin_list();
                $data['page_title']     = lang('general_search');
                $this->load->view($this->config->item('admin_folder').'/general_filter', $data);
            }
            public function export_xml(){
                
		$this->load->helper('download_helper');
		
		$data['customers'] = (array)$this->Customer_model->get_customers();
		

		force_download_content('customers.xml',	$this->load->view($this->config->item('admin_folder').'/customers_xml', $data, true));
		
		//$this->load->view($this->config->item('admin_folder').'/customers_xml', $data);
	}
            
            
            
            
            
            
            
            
            
            
            
}