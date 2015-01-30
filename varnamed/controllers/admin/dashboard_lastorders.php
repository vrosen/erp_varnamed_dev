<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_lastorders extends CI_Controller {
    

    public $data_shop;
    public $language;
    ////////////////////////////////////////////////////////////////////////////
    private $products;
    private $groups;
    private $categories;
    ////////////////////////////////////////////////////////////////////////////
    
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
				$this->load->helper(array('date','form','array'));
                $this->load->library('Bep_assets');
				////////////////////////////////////////////////////////////////
				$this->language                 = $this->session->userdata('language');
                $this->data_shop                = $this->session->userdata('shop');
                $this->lang->load('dashboard',$this->language);
                $this->lang->load('order',$this->language);
                ////////////////////////////////////////////////////////////////
                $this->groups                   = $this->Group_model->get_all_the_groups();
                $this->products                 = $this->Product_model->get_all_products();
                $this->categories               = $this->Category_model->get_all_categories();
				//$this->orders             		  = $this->Order_model->get_new_orders();
                ////////////////////////////////////////////////////////////////

		}
	

        public function index(){
		    $data_shop                = $this->session->userdata('shop');

                   if($_GET["action"] == "list")
	{
	
	$admin_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','Shipped'=>'Shipped','On_Hold'=>'On Hold','Cancelled'=>'Cancelled','Delivered'=>'Delivered');
	$warehouse_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','Shipped'=>'Shipped','On_Hold'=>'On Hold');
	$sales_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','On_Hold'=>'On Hold');
	$statuses = array('0'=>'Select status','Pending'=>'Pending');

if($data_shop == 1){
   $payment_method_array = array(
    '0'                         => lang('select_payment_method1'),
    '1'     => lang('invoice_upon_delivery'),
    '2'              => lang('direct_debit'),
    '3'           => lang('paid_in_advance'),
    '4'                     => lang('ideal'),
	'5'      => lang('free_sample_delivery'),
    '6'          => lang('american_express'),
    '7'                => lang('mastercard'),
    '8'                      => lang('visa'),
    '9'     => lang('instant_wire_transfer'),
    '10'                   => lang('giropay'),
    '11'                       => lang('eps'),
    '12'                    => lang('paypal'),
    '13'  => lang('comforties_com_BV_account'),//set the shop variable
    '14'                 => lang('by_cheque'), 
); 
}
if($data_shop == 2){
    $payment_method_array = array(
    '0'                         => lang('select_payment_method1'),
    '1'     => lang('invoice_upon_delivery'),
    '2'              => lang('direct_debit'),
    '3'           => lang('paid_in_advance'),
    '4'                     => lang('ideal'),
    '5'      => lang('free_sample_delivery'),
    '6'          => lang('american_express'),
    '7'                => lang('mastercard'),
    '8'                      => lang('visa'),
    '9'     => lang('instant_wire_transfer'),
    '10'                   => lang('giropay'),
    '11'                       => lang('eps'),
    '12'                    => lang('paypal'),
    '13'  => lang('dutchblue_com_BV_account'),//set the shop variable
    '14'                 => lang('by_cheque'), 
);
}
if($data_shop == 3){
    $payment_method_array = array(
    '0'                         => lang('select_payment_method1'),
    '1'     => lang('invoice_upon_delivery'),
    '2'              => lang('direct_debit'),
    '3'           => lang('paid_in_advance'),
    '4'                     => lang('ideal'),
    '5'      => lang('free_sample_delivery'),
    '6'          => lang('american_express'),
    '7'                => lang('mastercard'),
    '8'                      => lang('visa'),
    '9'     => lang('instant_wire_transfer'),
    '10'                   => lang('giropay'),
    '11'                       => lang('eps'),
    '12'                    => lang('paypal'),
    '13'  => lang('dutchblue_com_BV_account'),//set the shop variable
    '14'                 => lang('by_cheque'), 
);
}
						//Get record count
						$result = mysql_query("SELECT COUNT(*) AS RecordCount FROM orders WHERE shop_id LIKE " . $this->data_shop . ";");
						$row = mysql_fetch_array($result);
						$recordCount = $row['RecordCount'];
		
						//Get records from database
						$result = mysql_query("SELECT * FROM orders WHERE shop_id LIKE " . $this->data_shop . " ORDER BY DESC;");
						//$row1 = mysql_fetch_array($result1);
													

							
							//Add all records to an array
							$rows = array();
							while($row = mysql_fetch_array($result))
							{	
								//if(!empty($row[55])){
								//$row['payment_method'] = element($row[55], $payment_method_array);
								//$row[55] = element($row['payment_method'], $payment_method_array);
								//}
								//if($row[55] == 0){
								//$row['payment_method'] = element($row[55], $payment_method_array);
								//$row[55] = element($row['payment_method'], $payment_method_array);
								//}								
								if($this->data_shop == 3){

								}
								
								if($data_shop == 1){
									$backorder_array = array(1=>'BACKORDER',0 => '');
									$backorder_array[$row['BACKORDER']];
									$row['BACKORDER'] = "<span style='color:red;'>" . element($row[67], $backorder_array) . "</span>";
								$dropshipment_array = array(1=>'Yes',0 => 'No');
								$dropshipment_array[$row['dropshipment']];
								$row['dropshipment'] = element($row['dropshipment'], $dropshipment_array);
								}
								if($data_shop == 2){
									$backorder_array = array(1=>'BACKORDER',0 => '');
									$backorder_array[$row['BACKORDER']];
									$row['BACKORDER'] = "<span style='color:red;'>" . element($row[67], $backorder_array) . "</span>";
								$dropshipment_array = array(1=>'Yes',0 => 'No');
								$dropshipment_array[$row['dropshipment']];
								$row['dropshipment'] = element($row['dropshipment'], $dropshipment_array);
								}
								if($this->data_shop == 3){
								
								$dropshipment_array = array(1=>'Heeft drop shipment',0 => 'No');
								$dropshipment_array[$row['dropshipment']];
								$row['payment_method'] = 'Met factuur ';
								$row['dropshipment'] = element($row['dropshipment'], $dropshipment_array);
									
								}


								$row['remarks'] = "<a class='gobaby btn btn-default btn-xs'  href='".site_url($this->config->item('admin_folder').'/orders/view/'.$row['id']). "'>" . lang('form_view') ."</a>";
								
								$rows[] = $row;  //Moving to json conversion for jTable

							}
							 
							//Return result to jTable
							$jTableResult['Result'] = "OK";
							$jTableResult['TotalRecordCount'] = $recordCount;
							$jTableResult['Records'] = $rows;						
							print json_encode($jTableResult);
						}
					          
				}
	}