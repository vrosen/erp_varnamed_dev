<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// GoCart Theme
$config['theme']			= 'default';
$config['base_url']			= 'http://www.varnamed.com/varnamed/';

// SSL support
$config['ssl_support']                  = false;

// Business information
$config['company_name']                 = 'Dutchblue.com';
$config['company_logo']                 = '';
$config['address1']			= '';
$config['address2']			= '';
$config['country']			= ''; // use proper country codes only
$config['city']							= ''; 
$config['state']						= '';
$config['zip']							= '';
$config['email']						= 'orders@';

// Store currency
$config['currency']                     = 'EUR';  // USD, EUR, etc
$config['currency_symbol']				= '€';
$config['currency_symbol_uk']				= '£';
$config['currency_symbol_side']			= 'left'; // anything that is not "left" is automatically right
$config['currency_decimal']				= '.';
$config['currency_thousands_separator']	= ',';

$config['office_templates_path']  = '/varnamed/third_party/templates';


$config['MsgId'] = 'D20140110-6922202138';
// Shipping config units
$config['weight_unit']                  = 'KG'; // LB, KG, etc
$config['dimension_unit']               = 'CM'; // FT, CM, etc
$config['nr']                           = '№'; // FT, CM, etc
// site logo path (for packing slip)
$config['site_logo_dutchblue']                    = '/assets/img/dutchbluelogode.png';
$config['site_logo_comforties']                   = '/assets/img/comfortieslogo.png';

//change the name of the admin controller folder 
$config['admin_folder']                 = 'admin';


//file upload size limit
$config['size_limit']                   = intval(ini_get('upload_max_filesize'))*1024;

//are new registrations automatically approved (true/false)
$config['new_customer_status']          = true;

//do we require customers to log in 
$config['require_login']		= false;

//default order status
$config['order_status']			= 'Pending';

// default Status for non-shippable orders (downloads)
$config['nonship_status'] = 'Delivered';

$config['order_statuses']               = array(

	'1'                            => 'Processing',
	'2'				=> 'Shipped',
	'3'				=> 'On Hold',
	'4'				=> 'Cancelled',
	'5'				=> 'Delivered'
);
$config['all_order_statuses']               = array(
        '0'                               => 'Pending',
	'1'                            => 'Processing',
	'2'				=> 'Shipped',
	'3'				=> 'On Hold',
	'4'				=> 'Cancelled',
	'5'				=> 'Delivered'
);
$config['stock_order_statuses']               = array(
    
    0				=> 'Pending',
	1				=> 'Delivered',
	2				=> 'Cancelled',
	3				=> 'On Hold'
);
// enable inventory control ?
$config['inventory_enabled']            = true;

// allow customers to purchase inventory flagged as out of stock?
$config['allow_os_purchase']            = true;

//do we tax according to shipping or billing address (acceptable strings are 'ship' or 'bill')
$config['tax_address']                  = 'ship';

//do we tax the cost of shipping?
$config['tax_shipping']                 = false;

//FOOTER LEGEND
$config['about_company_d']              = 'About Dutchblue';
$config['why_company_d']                = 'Why Dutchblue';
$config['impression_company_d']         = 'Impressions';
$config['agb_company_d']                = 'AGB';
$config['customer_service_company_d']   = 'Customer Service';
$config['orders_company_d']             = 'Orders&Payments';
$config['supply_company_d']             = 'Supplies&Returns';
$config['contact_company_d']            = 'Contacts';
$config['downloads_company_d']          = 'Downloads';
$config['strong_company_d']             = 'Our strong sides';
$config['cheap_company_d']              = 'Good value for less';
$config['reliable_company_d']           = 'Reliable';
$config['c_friendly_company_d']         = 'Customer friendly';
$config['high_quality_company_d']       = 'High quality';
$config['countries_company_d']          = 'Countries';
$config['nl_company_d']                 = 'Netherlands';
$config['benl_company_d']               = 'Belguim-nl';
$config['befr_company_d']               = 'Belguim-fr';
$config['fr_company_d']                 = 'France';
$config['ger_company_d']                = 'Germany';
$config['au_company_d']                 = 'Austria';
$config['lx_company_d']                 = 'Luxembourg';
$config['uk_company_d']                 = 'United Kingdom';



$config['lang']		= array(
    
						'english'=> 'UK',
						'german' 				=> 'DE',
						'french' 		=> 'FR',
						'dutch' 		=> 'NL',
						'bulgarian' => 'BG',
					);





$config['webshops'] 	= array(
							'0'     =>   'Select webshop',
							'1'     =>   'BEL',
							'2'     =>   'BE',
							'3'     =>   'DE',
							'4'     =>   'FR',
							'5'     =>   'LX',
							'6'     =>   'NL',
							'7'     =>   'UK',
							'8'     =>   'AU',    
); 




















