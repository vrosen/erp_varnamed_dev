<?php

		class Offer extends CI_Controller {		

				//this is used when editing or adding a customer
					var $supplier_id	= false;	
					private $start_search = false;
					public $data_shop;
					public $language;
					////////////////////////////////////////////////////////////////////////////
					private $products;
					private $groups;
					private $categories;
				////////////////////////////////////////////////////////////////////////////
        
				function __construct(){		
					parent::__construct();

							$this->load->model(array('Offer_model','Order_model', 'Location_model','Product_model','Group_model','Category_model','Shop_model','Search_model','Invoice_model'));
							////////////////////////////////////////////////////////////////
							$this->load->helper('formatting_helper');
							////////////////////////////////////////////////////////////////
							$this->language     = $this->session->userdata('language');
							$this->data_shop    = $this->session->userdata('shop');
							////////////////////////////////////////////////////////////////
							$this->lang->load('offer',  $this->language);
							$this->lang->load('dashboard',  $this->language);
							////////////////////////////////////////////////////////////////
							$this->groups                   = $this->Group_model->get_all_the_groups();
							$this->products                 = $this->Product_model->get_all_products();
							$this->categories               = $this->Category_model->get_all_categories();
							////////////////////////////////////////////////////////////////
				}
					function index(){
					
						
						
					}
				
					function all($id){
						
						
							if(!$this->bitauth->logged_in()){
							$this->session->set_userdata('redir', current_url());
							redirect($this->config->item('admin_folder').'/admin/login');
							}
							$this->load->library('parser');
							//menu items
							$data['categories'] = $this->categories;
							$data['groups']     = $this->groups;
							$data['products']   = $this->products;
							$data['all_shops']  = $this->Shop_model->get_shops();


					
							$data['offers']     = $this->Offer_model->get_all_offers($this->session->userdata('shop'),$id);

							
							$data['is_sent']	=	array(0=>'Not sent',1=>'Sent',);
							$data['some']	=	'Test';
							
							
							$timeid = $this->uri->segment(5);
								if($timeid==0){
									$time = time();
								}	
								else {
									$time = $timeid;
								}
								$data['weather']	=	_date($time);
								$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
								
								$this->parser->parse($this->config->item('admin_folder').'/offers', $data);
								//$this->load->view($this->config->item('admin_folder').'/offers', $data);
				}
				


	
				public function view($offer_id){
				
					force_ssl();
					
					if(!$this->bitauth->logged_in()){
						$this->session->set_userdata('redir', current_url());
						redirect($this->config->item('admin_folder').'/admin/login');
					}
					
					$data['categories'] 	= 	$this->categories;
					$data['groups']     	= 	$this->groups;
					$data['products']   	= 	$this->products;
					$data['all_shops']  	= 	$this->Shop_model->get_shops();
					
					//---------------------------------------------------------------------------------------------------------------------------------------
					$offer					=   $this->Offer_model->get_current_offer($offer_id,$this->session->userdata('shop'));						
					$data['offer_id']		=   $offer->id;						
					$data['offers']			=	unserialize($offer->offer);		
					$data['customer_id']	=	$offer->client_id;
					$customer				=	$this->Customer_model->get_customer($offer->client_id);
					$invoice_address 		= 	$this->Invoice_model->get_invoice_customer_address_pieces($customer->NR,$this->session->userdata('shop'));
					$country_id 			= 	strtoupper($invoice_address['LANDCODE']);
					$general_vat 			= 	$this->Customer_model->get_country_vat($country_id);
					$data['general_vat']	= 	$general_vat->tax;
					$offer_products			=	unserialize($offer->offer);		
					//echo '<pre>';
					//print_r($offer_products);
					//echo '</pre>';
					
					
					$data['special_case']	=	'';
					$data['special_vat']	=	'';
					//---------------------------------------------------------------------------------------------------------------------------------------

						foreach($offer_products as $products){
					
							foreach($products as $product){

								$items[] 	= $product;
								$t[] 		= $product['saleprice']*$product['VE'];
								$total 		= $product['saleprice']*$product['VE'];

								if($country_id == 'BEL'){
									$country_id == 'BE';
								}
								if($country_id == 'AT'){
									$country_id == 'AU';
								}

								$vat	=	'vat_'.$country_id;
								$v		= 	$this->Product_model->get_vat($product['ARTIKELCOD'],$this->session->userdata('shop'),$vat);

								$tv[] 	= $product['saleprice']*$product['VE']*$v->$vat/100;
								
								if($v->$vat != $general_vat->tax){
									$dv[] 		= $product['saleprice']*$product['VE']*$v->$vat/100;
									$vat_value	= ($product['saleprice']*$product['VE'])*$v->$vat/100;
									$d_vats[]	= array('vat' => $v->$vat,'code'=>$product['ARTIKELCOD'],'vat_value'=>$vat_value);
								}
							}
						}

					$data['items']				=	$items;
					$data['total_net']			=	format_currency(array_sum($t),2);
					
					if(!empty($dv)){
						$d_sum	= array_sum($tv)-array_sum($dv);
						$data['total_vat']		=	format_currency($d_sum,2);
						
					}else {
						$data['total_vat']		=	format_currency(array_sum($tv),2);
					}
					$data['total_gross']		=	format_currency(array_sum($t)+array_sum($tv),2);

						if(!empty($d_vats)){
							foreach($d_vats as $d_vat){
								$special_case[] = '(For product '.$d_vat['code'].' VAT is '.$d_vat['vat'].'%)';
								$special_vat[] 	= $d_vat['vat_value'];
							}
						}
						if(!empty($special_case)){
							$data['special_case']	=	$special_case;
						}
						if(!empty($special_vat)){
							$data['special_vat']	=	$special_vat;
						}
						
					
					//---------------------------------------------------------------------------------------------------------------------------------------
					$timeid = $this->uri->segment(5);
					if($timeid==0){
						$time = time();
					}	
					else {
						$time = $timeid;
					}
					$data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
					$this->load->view($this->config->item('admin_folder').'/offer', $data);

				}
	
	

	
	function delete($id,$offer_id){
	
		if ($offer_id){	

			$this->Offer_model->delete($offer_id,$this->session->userdata('shop'));
			//$this->session->set_flashdata('error', lang('error_not_found'));
			redirect($this->config->item('admin_folder').'/offer/all/'.$id);
		}
	}
	

	function check_email($str){
		$email = $this->Offer_model->check_email($str, $this->supplier_id);
        	if ($email){
			$this->form_validation->set_message('check_email', lang('error_email_in_use'));
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	

	function get_subscriber_list(){

  
		$subscribers = $this->Customer_model->get_subscribers();
		
		$sub_list = '';
		foreach($subscribers as $subscriber){
			$sub_list .= $subscriber['email'].",\n";
		}
		
		$data['sub_list']	= $sub_list;
								$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
		$this->load->view($this->config->item('admin_folder').'/customer_subscriber_list', $data);
	}	


				public function word($offer_id,$customer_id){
			
						$this->load->helper('date');
						$this->load->library('parser');
						$this->load->library('labels');

						$filename           = $offer_id.'.doc';
						header("Cache-Control: public");
						header("Content-Description: File Transfer");
						header("Content-Disposition: attachment; filename=".$filename);
						header("Content-Type: application/vnd.ms-word.main+xml");
						header("Content-Transfer-Encoding: binary");

			
						$customer						= $this->Customer_model->get_customer($customer_id);
						$invoice_address 				= $this->Order_model->get_invoice_adres($customer->NR,$this->session->userdata('shop'));
						
						$data['c_name'] 				= $invoice_address['NAAM1'];
						$data['c_street'] 				= $invoice_address['STRAAT'];
						$data['c_street_nr'] 			= $invoice_address['HUISNR'];
						$data['c_zip'] 					= $invoice_address['POSTCODE'];
						$data['c_city'] 				= $invoice_address['PLAATS'];
						$data['c_country'] 				= $invoice_address['LAND'];
			
						$company_address 				= $this->Order_model->get_address($invoice_address['LANDCODE'],$this->session->userdata('shop'));
						$c_address 						= unserialize($company_address['address']);

						$data['our_name']				=	$c_address['company_name'].strtolower($invoice_address['LANDCODE']);
						$data['our_street']				=	$c_address['street'];
						$data['our_street_number']		=	$c_address['street_number'];
						$data['our_zip']				=	$c_address['zip'];
						$data['our_city']				=	$c_address['city'];
						$data['our_phone']				=	$c_address['phone'];
						$data['our_email']				=	$c_address['email'];
						$data['our_website']			=	$c_address['website'];
			
						$data['company_bank_info'] 		= $this->Order_model->get_bank($invoice_address['LANDCODE'],$this->session->userdata('shop'));
						$data['bank_details'] 			= unserialize($data['company_bank_info']['account']);
			
						$offer							=   $this->Offer_model->get_current_offer($offer_id,$this->session->userdata('shop'));									
						$data['offer_products']			=	unserialize($offer->offer);		
						
						//print_r($data['offer_products']);
						
						$data['offer_number']			= $offer->id;
						$data['offer_date']				= $offer->date_made;
						$data['shipped_on']				= $offer->sent_date;
						$data['customer_number']		= $customer->customer_number;
						$data['agent_name']				= $offer->agent_name;

						$c_id = $invoice_address['LANDCODE'];
						
						$data['shipping_costs']		=	'0,00';
						
						$c_data                     = $this->Customer_model->get_country_data_by_index($c_id);
						$data['vat_percent']        = $c_data->tax;

						
						if($c_id == 'NL' or $c_id == 'BE'){
						
							$data['offer']				= 'Anbod';
							$data['order_nr'] 			= 'Order nr.';
							$data['client_nr'] 			= 'Klant nr.';
							$data['bestel_nr'] 			= 'Bestel nr.';
							$data['agent'] 				= 'Behandeld door';
							$data['vat'] 				= 'BTW';
							$data['date'] 				= 'Datum';
							$data['product_nr'] 		= 'Art. nr.';
							$data['description'] 		= 'Omschrijving';
							$data['quantity'] 			= 'Geleverd';
							$data['q_per_package'] 		= 'Aantal per verpakking';
							$data['shipping'] 			= 'Verzendkosten';
							$data['nett'] 				= 'Netto';
							$data['price_net'] 			= 'verpakking prijs Netto';
							$data['total_price_net'] 	= 'Totale prijs Netto';
						}
						if($c_id == 'FR' or $c_id == 'LX' or $c_id == 'BEL'){
						
							$data['packing_slip']		= 'Bordereau d`expédition';
							$data['order_nr'] 			= 'Nº d`ordre';
							$data['client_nr'] 			= 'Nº de client';
							$data['bestel_nr'] 			= 'Nº de commande';
							$data['agent'] 				= 'Traité par';
							$data['vat'] 				= 'TVA';
							$data['date'] 				= 'Date';
							$data['product_nr'] 		= 'Article';
							$data['description'] 		= 'Détail';
							$data['quantity'] 			= 'Nombre';
							$data['q_per_package'] 		= 'Nombre par carton';
							$data['shipping'] 			= 'Livraison';
							$data['nett'] 				= 'Net';
							$data['price_net'] 			= 'Conditionnement prix Net';
							$data['total_price_net'] 	= 'Prix ​​total';
						}
						if($c_id == 'DE' or $c_id == 'AU' or $c_id == 'AT'){
						
							$data['offer']				= 'Angebot';
							$data['offer_nr'] 			= 'Angebot nr.';
							$data['client_nr'] 			= 'Kunde-Nr.';
							$data['bestel_nr'] 			= 'Bestell-Nr.';
							$data['agent'] 				= 'Bearbeiter(in)';
							$data['vat'] 				= 'MwSt.';
							$data['date'] 				= 'Datum';
							$data['product_nr'] 		= 'Art-Nr';
							$data['description'] 		= 'Beschreibung';
							$data['quantity'] 			= 'Liefermenge';
							$data['q_per_package'] 		= 'Anzahl pro Verpackung';
							$data['shipping'] 			= 'Versandkosten';
							$data['nett'] 				= 'Netto';
							$data['price_net'] 			= 'Verpackungs-preis Netto';
							$data['total_price_net'] 	= 'Gesamtpreis Netto';
						}
						if($c_id == 'UK'){
						
							$data['packing_slip']		= 'Packing slip';
							$data['order_nr'] 			= 'Order no.';
							$data['client_nr'] 			= 'Client no.';
							$data['bestel_nr'] 			= 'Part no.';
							$data['agent'] 				= 'Processed by';
							$data['vat'] 				= 'VAT';
							$data['date'] 				= 'Date';
							$data['product_nr'] 		= 'Article no.';
							$data['description'] 		= 'Description';
							$data['quantity'] 			= 'Delivered';
							$data['q_per_package'] 		= 'Packaging unit';
							$data['shipping'] 			= 'Dispatch costs';
							$data['nett'] 				= 'Net';
							$data['price_net'] 			= 'Net price per package';
							$data['total_price_net'] 	= 'Total net price';
						}

						//echo '<pre>';
						//print_r($data);
						//echo '</pre>';
						
						
						
						//$this->Offer_model->set_printed($order_id,$this->session->userdata('shop'));
						$this->load->view($this->config->item('admin_folder').'/print_offer', $data);
				}	
			
			
			public function send_mail($id){
			
					$data['offer_id']			=	'OFR'.$id;
					$offer						= $this->Offer_model->get_offer($id);
					$customer					= $this->Customer_model->get_customer($offer->client_id);

					if($this->session->userdata('shop') == 1){
						$company_name 			= 'Comforties.com';
						$company_email 			= 'offer@comforties.com';
						$email_offer 			= 'offer@comforties.com';
						$data['img_path']		=	base_url().'assets/img/invoice_logos/c_logo.png';
					}
					if($this->session->userdata('shop') == 2){
						$company_name 			= 'Dutchblue.com';
						$company_email 			= 'offer@dutchblue.com';
						$email_offer 			= 'offer@dutchblue.com';
						$data['img_path']		=	base_url().'assets/img/invoice_logos/d_logo.png';
					}
					if($this->session->userdata('shop') == 3){
						$company_name 			= 'Glovers.com';
						$company_email 			= 'offer@glovers.com';
					}
					
					$invoice_address 			= $this->Invoice_model->get_invoice_customer_address_pieces($customer->NR,$this->session->userdata('shop'));
					$country_id 				= strtoupper($invoice_address['LANDCODE']);
					$shop_address       		= $this->Invoice_model->get_shop_address( $this->session->userdata('shop'),$country_id);
					$shop_address   			= unserialize($shop_address['address']);
					$shop_bank_account  		= $this->Invoice_model->get_shop_account($this->session->userdata('shop'),$country_id);
					$data['bank_account']       = unserialize($shop_bank_account['account']); 
					
					$data['special_case']		=	'';
					$data['special_vat']		=	'';
					$data['company_name']		=	$shop_address['company_name'].'com';
					$data['street']				=	$shop_address['street'];
					$data['street_number']		=	$shop_address['street_number'];
					$data['zip']				=	$shop_address['zip'];
					$data['city']				=	$shop_address['city'];
					$data['email']				=	$shop_address['email'];
					$data['website']			=	$shop_address['website'];
					
					$offer_id 					= 	'OFR'.$id;
					$data['agent_name']			=	$offer->agent_name;
					$data['offer_date']			=	$offer->date_made;
					$data['customer_company']	=	$customer->company;
					$data['customer_number']	=	$customer->customer_number;
					$general_vat 				= 	$this->Customer_model->get_country_vat($country_id);
					$data['general_vat']		= 	$general_vat->tax;
					
					//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					$offer_products				=	unserialize($offer->offer);		
					
					foreach($offer_products as $products){
					
						foreach($products as $product){
							
							$items[] 	= $product;
							$t[] 		= $product['saleprice']*$product['VE'];
							$total 		= $product['saleprice']*$product['VE'];
								
								if($country_id == 'BEL'){
									$country_id == 'BE';
								}
								if($country_id == 'AT'){
									$country_id == 'AU';
								}

								$vat	=	'vat_'.$country_id;
								$v		= 	$this->Product_model->get_vat($product['ARTIKELCOD'],$this->session->userdata('shop'),$vat);

								
								$tv[] 	= $product['saleprice']*$product['VE']*$v->$vat/100;
								
								if($v->$vat != $general_vat->tax){
									$dv[] 		= $product['saleprice']*$product['VE']*$v->$vat/100;
									$vat_value	= ($product['saleprice']*$product['VE'])*$v->$vat/100;
									$d_vats[]	= array('vat' => $v->$vat,'code'=>$product['ARTIKELCOD'],'vat_value'=>$vat_value);
								}
						}
					}
					//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					$data['items']				=	$items;
					$data['total_net']			=	format_currency(array_sum($t),2);
					
					
					if(!empty($dv)){
						$d_sum	= array_sum($tv)-array_sum($dv);
						$data['total_vat']		=	format_currency($d_sum,2);
						
					}else {
						$data['total_vat']		=	format_currency(array_sum($tv),2);
					}
					$data['total_gross']		=	format_currency(array_sum($t)+array_sum($tv),2);
					
					
					//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


					if($country_id == 'NL' or $country_id == 'BE'){
						$data['dear']				=	'Lieve';
						$data['team']				= 	'het Team';
						$data['explanation_header']	=	'Vind een aanbod gekoppeld, voor de producten, U bent geïnteresseerd van.';
						$data['explanation_footer']	=	'In het geval u nog vragen met betrekking tot het huidige aanbod, aarzel dan niet om ons te contacteren.';
						$data['offer_number']		= 	'Aanbod nr.';	
						$data['client_number']		= 	'Klantnummer';	
						$data['agent']				= 	'Agent';	
						$data['date']				= 	'Datum';	
						$data['product_code']		= 	'Art. nr.';	
						$data['name']				= 	'Omschrijving';	
						$data['quantity']			= 	'Geleverd';	
						$data['price']				= 	'Prijs per verpakking';	
						$data['total']				= 	'Totaalprijs';	
						$data['nett']				= 	'Subtotaal';	
						$data['vat']				= 	'% BTW';	
						$data['gross']				= 	'Totaal';	
						
						if(!empty($d_vats)){
							foreach($d_vats as $d_vat){
								$special_case[] = '(Voor product '.$d_vat['code'].' BTW is '.$d_vat['vat'].'%)';
								$special_vat[] 	= $d_vat['vat_value'];
							}
						}
						$data['special_case']	=	$special_case;
						$data['special_vat']	=	$special_vat;
						
						$offer = 'Aanbod nr'.$id;
					}
					if($country_id == 'FR' or $country_id == 'LX' or $country_id == 'BEL'){
						$data['dear']				=	'Cher';
						$data['team']				= 	"l'équipe";
						$data['explanation_header']	=	'Trouverez ci-joint une offre, pour les produits, vous êtes intéressé de.';
						$data['explanation_footer']	=	"Si vous avez d'autres questions concernant l'offre actuelle, s'il vous plaît n'hésitez pas à nous contacter.";
						$data['offer_number']		= 	'Nº Proposition';	
						$data['client_number']		= 	'Nº de client';	
						$data['agent']				= 	'Traité par';	
						$data['date']				= 	'Date';	
						$data['product_code']		= 	'Article';	
						$data['name']				= 	'Détail';	
						$data['quantity']			= 	'Nombre';	
						$data['price']				= 	'Prix unitaire';	
						$data['total']				= 	'Prix total';	
						$data['nett']				= 	'Prix total';	
						$data['vat']				= 	'% TVA';	
						$data['gross']				= 	'Total';	
						
						if(!empty($d_vats)){
							foreach($d_vats as $d_vat){
								$special_case[] = '(Pour les produits '.$d_vat['code'].' TVA est '.$d_vat['vat'].'%)';
								$special_vat[] 	= $d_vat['vat_value'];
							}
						}
						$data['special_case']	=	$special_case;
						$data['special_vat']	=	$special_vat;
						
						$offer = 'Nº Proposition'.$id;
					}
					if($country_id == 'DE' or $country_id == 'AU' or $country_id == 'AT'){
						$data['dear']				=	'Liebe';
						$data['team']				= 	'Das Team';
						$data['explanation_header']	=	'Im Anhang finden Sie ein Angebot für die Produkte, Sie sind interessiert an.';
						$data['explanation_footer']	=	'Falls Sie weitere Fragen bezüglich der aktuellen Angebot haben, zögern Sie bitte nicht, uns zu kontaktieren.';
						$data['offer_number']		= 	'Angebot-Nr.';	
						$data['client_number']		= 	'Kunden-Nr.';	
						$data['agent']				= 	'Bearbeiter(in)';	
						$data['date']				= 	'Datum';	
						$data['product_code']		= 	'Art-Nr';	
						$data['name']				= 	'Beschreibung';	
						$data['quantity']			= 	'Liefermenge';	
						$data['price']				= 	'Verpackungspreis Netto';	
						$data['total']				= 	'Gesamtpreis Netto';	
						$data['nett']				= 	'Netto';	
						$data['vat']				= 	'% MwSt.';	
						$data['gross']				= 	'Gesamt';

						if(!empty($d_vats)){
							foreach($d_vats as $d_vat){
								$special_case[] = '(Für Produkt '.$d_vat['code'].' MwSt. ist '.$d_vat['vat'].'%)';
								$special_vat[] 	= $d_vat['vat_value'];
							}
						}
						$data['special_case']	=	$special_case;
						$data['special_vat']	=	$special_vat;		
	
						$offer = 'Angebot-Nr'.$id;
					}
					if($country_id == 'UK'){
						$data['dear']				=	'Dear';
						$data['team']				= 	'The Team';
						$data['explanation_header']	=	'find attached an offer, for the products, You are interested of.';
						$data['explanation_footer']	=	'In case you have any more questions regarding the current offer, please do not hesitate to contact us.';
						$data['offer_number']		= 	'Offer Number';	
						$data['client_number']		= 	'Customer Number';	
						$data['agent']				= 	'Agent';	
						$data['date']				= 	'Date';	
						$data['product_code']		= 	'Product code';	
						$data['name']				= 	'Name';	
						$data['quantity']			= 	'Quantity';	
						$data['price']				= 	'Price';	
						$data['total']				= 	'Total';	
						$data['nett']				= 	'Nett';	
						$data['vat']				= 	'% VAT';	
						$data['gross']				= 	'Gross';	
						
						if(!empty($d_vats)){
							foreach($d_vats as $d_vat){
								$special_case[] = '(For product '.$d_vat['code'].' VAT is '.$d_vat['vat'].'%)';
								$special_vat[] 	= $d_vat['vat_value'];
							}
						}
						$data['special_case']	=	$special_case;
						$data['special_vat']	=	$special_vat;
						
						$offer = 'Offer number'.$id;
					}
					
					
					//-------------------------------------------------------------------------------------------------------------------------------------------------------------------
					$data['address'] = $this->Customer_model->get_invoice_address_new($customer->NR);

					
					$row['subject'] = $offer;
					$row['content'] = $this->load->view($this->config->item('admin_folder').'/offer_email', $data, true);

					$this->load->library('email');
		
					$config['mailtype'] = 'html';
					
					$this->email->initialize($config);
					$this->email->from($company_email, $company_name);
					$this->email->to($customer->invoice_email);
					$this->email->bcc($email_offer);
					$this->email->subject($row['subject']);
					$this->email->message($row['content']);
		
					$this->email->send();
					//-------------------------------------------------------------------------------------------------------------------------------------------------------------------
					
					redirect($this->config->item('admin_folder').'/offer/view/'.$id);
					//$this->load->view($this->config->item('admin_folder').'/offer_email', $data);
			
			}
			public function update($id){
				
				//echo '<pre>';
				
				$offer						= $this->Offer_model->get_offer($id);	
				$offer_products				=	unserialize($offer->offer);	
				
				$key 			= count($this->input->post('code'));

				$codes 					= $this->input->post('code');
				$quantities 			= $this->input->post('quantity');
				$no_discount_price 		= $this->input->post('no_discount_price');
				$new_price 				= $this->input->post('new_price');
				$descriptions 			= $this->input->post('description');
				
				for($i=0;$i<$key;$i++){
					$updated_offer_products[] = array(
											'ARTIKELCOD'		=>	$codes[$i],
											'VE'				=>	$quantities[$i],	
											'KORTING'			=>	round(($no_discount_price[$i] - $new_price[$i])/$no_discount_price[$i]*100,2),
											'saleprice'			=>	$new_price[$i],
											'description'		=>	$descriptions[$i],
											'OSTUKSPRIJ'		=>	$no_discount_price[$i],
										);
				}
				print_r($updated_offer_products);
				
				foreach($offer_products as $products){
					foreach($products as $product){
						$selected[] = array(
						
							'id'			=>	$product['id'],		
							'shop_id'		=>	$this->session->userdata('shop'),		
							'active'		=>	$product['active'],		
							'RELATIESNR'	=>	$product['RELATIESNR'],		
							'REGELNR'		=>	$product['REGELNR'],		
							'VE'			=>	$product['VE'],		
							'WAREHOUSE'		=>	$product['WAREHOUSE'],		
							'INVDATUM'		=>	$product['INVDATUM'],		
							'INVLOGINNR'	=>	$product['INVLOGINNR'],		
							'MADE_BY'		=>	$product['MADE_BY'],		
							'WIJZDATUM'		=>	$product['WIJZDATUM'],		
							'WIJZLOGINN'	=>	$product['WIJZLOGINN'],		
							'BRANCHENR'		=>	$product['BRANCHENR'],		
							'ARTIKELNR'		=>	$product['ARTIKELNR'],		
							'NR'			=>	$product['NR'],		
						
						);
					}
				}

				foreach($updated_offer_products as $offer_products){
					foreach($selected as $products){
						$new_array[] = array_merge($products,$offer_products);
					}
				}

				for($i=0;$i<$key;$i++){
					$modified_new_array[] = array($new_array[$key*$i]);
				}
				$modified_new_array_string = serialize($modified_new_array);
				
				
				
				//print_r($modified_new_array);
				//echo '</pre>';
				
				$this->Offer_model->update_offer($id,$this->session->userdata('shop'),$modified_new_array_string);
				redirect($this->config->item('admin_folder').'/offer/view/'.$id);
			}
			
			
			
			
			
			
			
			
			
			
			
			
        }
