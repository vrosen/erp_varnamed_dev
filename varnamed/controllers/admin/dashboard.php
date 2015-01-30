<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    

    public $data_shop;
    public $language;
    ////////////////////////////////////////////////////////////////////////////
    private $products;
    private $groups;
    private $categories;
    /////////////////////////////////////////////////////////////////////////////
    
	function __construct() {
	
		parent::__construct();
		remove_ssl();
		
				$this->load->model('Order_model');
                $this->load->model('Shop_model');
                $this->load->model('Search_model');
                $this->load->model('Invoice_model');
                $this->load->model('Calendar_model');
				$this->load->model('Dashboard_model');
                //$this->bep_assets->load_asset('master');
				$this->load->model(array('Customer_model','Group_model','Product_model','Category_model'));
                ////////////////////////////////////////////////////////////////
				$this->load->helper(array('date','form'));
                $this->load->library('Bep_assets');
				////////////////////////////////////////////////////////////////
				$this->language                 = $this->session->userdata('language');
                $this->data_shop                = $this->session->userdata('shop');
                $this->lang->load('dashboard',$this->language);
                ////////////////////////////////////////////////////////////////
                $this->groups                   = $this->Group_model->get_all_the_groups();
                $this->products                 = $this->Product_model->get_all_products();
                $this->categories               = $this->Category_model->get_all_categories();
                ////////////////////////////////////////////////////////////////

		}
	

        public function index(){
		
					if(!$this->bitauth->logged_in()){
						$this->session->set_userdata('redir', current_url());
						redirect($this->config->item('admin_folder').'/admin/login');
					}

                    $data['all_shops']                  =  $this->Shop_model->get_shops();
                    $data['payment_module_installed']	= (bool)count($this->Settings_model->get_settings('payment_modules'));
                    $data['shipping_module_installed']	= (bool)count($this->Settings_model->get_settings('shipping_modules'));
	
                    $data['current_user'] 	= $this->session->userdata('ba_username');
                    $data['categories'] 	= $this->categories;

					
					
					if(empty($this->data_shop)){
					$data['to_do_actions']	=	array();
					
					}
						/*
						$customers				=	$this->Customer_model->get_all_clients_array($this->session->userdata('shop')); 
						foreach($customers as $customer){
							$clients[$customer['NR']] = array($customer['company']);
						}
						$data['customers']	=	$clients;
					*/	

					if($this->data_shop == 1){
						$c_id	=	$this->session->userdata('ba_c_login');

						$data['to_do_actions']	=	$this->Customer_model->to_do_actions($c_id);
					}
					if($this->data_shop == 2){
					
						$d_id					=	$this->session->userdata('ba_d_login');
						$data['to_do_actions']	=	$this->Customer_model->to_do_actions($d_id);
					}
					if($this->data_shop == 3){
						$g_id	=	$this->session->userdata('ba_g_login');
						$data['to_do_actions']	=	$this->Customer_model->to_do_actions($g_id);
					}
					
					
					
					
					
                    $data['groups']     	= $this->groups;
                    $data['products']   	= $this->products;

					$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
                    $this->load->view($this->config->item('admin_folder').'/dashboard', $data);
					
                }


}