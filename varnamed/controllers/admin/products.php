<?php

class Products extends CI_Controller {

    private $use_inventory = false;
    public $shop_id;
    protected $page_title;
    protected $code;
    protected $post;
    protected $categories;
    protected $term;
    protected $category_id;
    protected $categories_dropdown;
    public $data_shop;
    public $language;

    public function __construct() {

        parent::__construct();
        remove_ssl();
        //check admin access
        $this->load->model(array('Option_model', 'Category_model', 'Digital_Product_model', 'Group_model', 'Supplier_model'));
        $this->load->model('Search_model');
        $this->load->model('Stock_model');
        $this->load->model('Product_model');
        $this->load->model('Group_model');
        $this->load->model('Complex_model2');
        $this->load->model('Part_model');
		$this->load->model('Routes_model');
        ////////////////////////////////////////////////////////////////
        $this->load->helper(array('formatting'));
        $this->load->helper(array('form', 'date', 'file','array'));
        $this->load->helper('text');
		$this->load->library('form_validation');
        ////////////////////////////////////////////////////////////////
        $this->post = $this->input->post(null, false);
        $this->categories = $this->Category_model->get_categories_tierd();
        $this->term = false;
        $this->category_id = false;
        $this->categories_dropdown = $this->Category_model->get_categories_tierd();
        ////////////////////////////////////////////////////////////////
        $this->shop_id = $this->session->userdata('shop');
        $this->language = $this->session->userdata('language');
        $this->data_shop = $this->session->userdata('shop');
        ////////////////////////////////////////////////////////////////
        $this->lang->load('product', $this->language);
        $this->lang->load('dashboard', $this->language);
        $this->page_title = lang('products');

        $this->products = $this->Product_model->get_all_products();
    }

				public function index($order_by = "name", $sort_order = "ASC", $code = 0, $page = 0, $rows = 20) {

								if (!$this->bitauth->logged_in()) {

									$this->session->set_userdata('redir', current_url());
									redirect($this->config->item('admin_folder') . '/admin/login');
								}

								$data['can_edit_product'] = $this->bitauth->has_role('can_edit_product');

								$data['code'] 		= $code;
								$term 				= $this->term;
								$category_id 		= $this->category_id;
								$data['groups'] 	= $this->Group_model->get_shop_groups($this->shop_id);
								$data['group'] 		= $this->session->userdata('ba_username');
								$data['categories'] = $this->categories;
								$post 				= $this->post;

								if ($post) {
									$term 			= json_encode($post);
									$code 			= $this->Search_model->record_term($term);
									$data['code'] 	= $code;
								} elseif ($code) {
									$term 			= $this->Search_model->get_term($code);
								}

								$data['shop_name'] 	= $this->Product_model->get_product_shop($this->shop_id);

								$data['term'] 		= $term;
								$data['order_by'] 	= $order_by;
								$data['sort_order'] = $sort_order;

								$data['cat'] = '';
								$data['grp'] = '';
								
								//-----------------------------------------------------------------------------------------------------------------------------------------------------
								
								$post_cat 	= $this->input->post('category');
								$post_grp 	= $this->input->post('group');
								$clear 		= $this->input->post('clear');
								
								
								if (!empty($post_cat)) {
									$this->session->set_userdata('category', $post_cat);
									$this->session->unset_userdata('group');
								}
								if (!empty($post_grp)) {
									$this->session->set_userdata('group', $post_grp);
								}
								
								if (!empty($clear)) {
									$this->session->unset_userdata('category');
									$this->session->unset_userdata('group');
								}
								
								//-----------------------------------------------------------------------------------------------------------------------------------------------------
								/*all categories*/
								$all_categories = $this->Group_model->get_all_cats($this->shop_id);
								
								foreach($all_categories as $category){
									$cats[$category['id']] = $category['name'];
								}
								$data['all_categories'] = $cats;

								//-----------------------------------------------------------------------------------------------------------------------------------------------------
								/*all groups*/
								$all_groups = $this->Group_model->fetch_all_groups($this->session->userdata('category'),$this->session->userdata('shop'));
								

								$grps = array();
								foreach($all_groups as $group){
									$grps[$group['group_id']] = $group['group_name'];
								}
								$data['all_groups'] = $grps;
								//-----------------------------------------------------------------------------------------------------------------------------------------------------
								
								$web_shop 			= $this->input->post('webshop');
								$this->session->set_userdata('current_web_shop',$web_shop);
								$data['web_shop']	=	$this->session->userdata('current_web_shop');
								
								
								if(!empty($this->session->userdata('current_web_shop'))){
									if($data['web_shop'] == 'BEL'){
										$data['saleprice']	=	'saleprice_BE';
									}else{
										$data['saleprice']	=	'saleprice_'.$this->session->userdata('current_web_shop');
									}
								}else{
										$data['saleprice']	=	'saleprice_NL';
								}
								
								
								$data['products'] = $this->Product_model->products(array('term' => $term, 'order_by' => $order_by, 'sort_order' => $sort_order, 'rows' => $rows, 'page' => $page), $this->session->userdata('category'), $this->session->userdata('group'), $this->session->userdata('shop'));

								if(!empty($this->session->userdata('category'))){
									$data['cat'] = $this->session->userdata('category');
								}
								if(!empty($this->session->userdata('group'))){
									$data['grp'] = $this->session->userdata('group');
								}

								$data['total'] 				= $this->Product_model->countProducts(array('term' => $term, 'order_by' => $order_by, 'sort_order' => $sort_order), $this->session->userdata('category'), $this->session->userdata('group'), $this->session->userdata('shop'));
								
								$config['base_url'] 			= site_url($this->config->item('admin_folder') . '/products/index/' . $order_by . '/' . $sort_order . '/' . $code . '/');
								$config['total_rows'] = $data['total'];
								$config['per_page'] = $rows;
								$config['uri_segment'] = 7;
								$config['first_link'] = 'First';
								$config['first_tag_open'] = '<li>';
								$config['first_tag_close'] = '</li>';
								$config['last_link'] = 'Last';
								$config['last_tag_open'] = '<li>';
								$config['last_tag_close'] = '</li>';
								$config['full_tag_open'] = '<div class="pagination"><ul>';
								$config['full_tag_close'] = '</ul></div>';
								$config['cur_tag_open'] = '<li class="active"><a href="#">';
								$config['cur_tag_close'] = '</a></li>';

								$config['num_tag_open'] = '<li>';
								$config['num_tag_close'] = '</li>';

								$config['prev_link'] = '&laquo;';
								$config['prev_tag_open'] = '<li>';
								$config['prev_tag_close'] = '</li>';

								$config['next_link'] = '&raquo;';
								$config['next_tag_open'] = '<li>';
								$config['next_tag_close'] = '</li>';

								$this->pagination->initialize($config);

								$this->pagination->initialize($config);
								
								$data['order_by'] 	= $order_by;
								$data['sort_order'] = $sort_order;
		
								$timeid = 0;
								if ($timeid == 0) {
									$time = time();
								} else {
									$time = $timeid;
								}
								$data['weather'] = _date($time);
								$data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
								$this->load->view($this->config->item('admin_folder') . '/products', $data);
    }

    //basic category search
    public function product_autocomplete() {

        $saleprice = $this->session->userdata('customer_order_country_index') ? 'saleprice_' . $this->session->userdata('customer_order_country_index') : 'saleprice';
        $product_name = $this->session->userdata('customer_order_country_index') ? 'name_' . $this->session->userdata('customer_order_country_index') : 'name';
        $vat = $this->session->userdata('customer_order_country_index') 
               ? 'vat_'.strtoupper($this->session->userdata('customer_order_country_index'))
               : false; 

        $name = trim($this->input->post('name'));
        $limit = $this->input->post('limit');
        $shop = $this->shop_id;
        if (empty($name)) {
            echo json_encode(array());
        } else {


            $results = $this->Product_model->product_autocomplete($name, $limit, $shop);
            $ret = array();
            foreach ($results as $r) {
                $redRow = array();
                $redRow['label'] = $r->$product_name;
                $redRow['value'] = $r->code;
                $redRow['saleprice'] = $r->$saleprice; //VK
                $redRow['package_details'] = $r->package_details; //VOE details
                $redRow['vatIndex'] = $vat;
                if($vat)
                {
                    $redRow['vat'] = $r->$vat;
                }
                else 
                {
                    $redRow['vat'] = 0;
                }
                $ret[] = $redRow;
            }
            echo json_encode($ret);
        }
    }

    public function product_autocomplete_supplier() {


        $name = trim($this->input->post('name'));
        $supplier_id = trim($this->input->post('supplier_id'));

        $limit = $this->input->post('limit');

        if (empty($name)) {
            echo json_encode(array());
        } else {

            $results = $this->Product_model->product_autocomplete_supplier($name, $supplier_id, $this->session->userdata('shop'));
            $ret = array();
            //echo '<pre>';

            foreach ($results as $result) {
                foreach ($result as $r) {
                    $redRow = array();
					if(substr($r['code'],-2,1) != '-'){
						$redRow['label'] = $r['name_UK'];
						$redRow['value'] = str_replace('/','',$r['code']);
						$redRow['supplier_price'] = $r['supplier_price']; //VK
						$redRow['package_details'] = $r['package_details']; //VOE details
					}
                    $ret[] = $redRow;
                }
            }
            echo json_encode($ret);
            //print_r($ret);
            //echo '</pre>';
        }
    }

    public function product_autocomplete_multiple() {

        $name = trim($this->input->post('name'));
        $shop = $this->session->userdata('shop');

        if (empty($name)) {
            echo json_encode(array());
        } else {

            $results = $this->Product_model->product_array($name, $shop);
            $return = array();

            foreach ($results as $r) {

                $return['code'] = $r->code;
                $return['name'] = $r->name;
            }
            echo json_encode($return);
        }
    }
	
	
	public function populate_groups(){
	

				$cat	=	$this->input->post('name');
	
								$all_groups = $this->Product_model->fetch_all_groups($cat,$this->session->userdata('shop'));
								$resp	=	array();
								foreach($all_groups as $group){
									$grps = array();
									$grps['group_id'] 	= $group->group_id;
									$grps['group_name'] = $group->group_name;
									$resp[] = $grps;
								}

								
					echo json_encode($resp);
					exit;
	}

    public function bulk_save() {

        $products = $this->input->post('product');
		//echo '<pre>';
		
        if (!$products) {
           $this->session->set_flashdata('error', lang('error_bulk_no_products'));
           redirect($this->config->item('admin_folder') . '/products');
        }
        foreach ($products as $id => $product) {
            $product['id'] = $id;
			
			foreach($product as $k=>$v){
					$money = array('€','£');
					$r[$k] = str_replace($money,'',$v);
			}
			//print_r($r);
			$this->Product_model->save($r);
        }
        $this->session->set_flashdata('message', lang('message_bulk_update'));
        redirect($this->config->item('admin_folder') . '/products');
		//echo '</pre>';
    }

    public function quick_view($id) {


        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        $category_id = $this->category_id;
        $data['groups'] = $this->Group_model->get_shop_groups($this->shop_id);
        $data['group'] = $this->session->userdata('ba_username');
        $data['products'] = $this->products;
        $data['categories'] = $this->categories;
        $data['description'] = '';
        $data['text_1'] = '';
        $data['text_2'] = '';
        $data['year'] = '';
        $data['month'] = '';
        $data['photo_big'] = '';
        $data['photo_medium'] = '';
        $data['photo_small'] = '';
        $data['new_shippment_date'] = '';

        $data['sales'] = $this->bitauth->has_role('sales');
        $data['marketing'] = $this->bitauth->has_role('customer_service');



        $data['years'] = array(
            '2010' => '2010',
            '2011' => '2011',
            '2012' => '2012',
            '2013' => '2013',
            '2014' => '2014',
        );

        $data['months'] = array(
            'Jan' => 'January',
            'Feb' => 'February',
            'Mar' => 'March',
            'Apr' => 'April',
            'May' => 'May',
            'Jun' => 'June',
            'Jul' => 'July',
            'Aug' => 'August',
            'Sep' => 'September',
            'Oct' => 'October',
            'Nov' => 'November',
            'Dec' => 'December',
            '13' => 'Whole year',
        );


        $post_year = $this->input->post('year');

        if (!empty($post_year)) {
            $this->session->set_userdata('quick_product_posted_year', $post_year);
            $data['year'] = $this->session->userdata('quick_product_posted_year');
        } else {
            $data['year'] = date('Y');
        }

        $post_month = $this->input->post('month');
        if (!empty($post_month)) {
            $this->session->set_userdata('quick_product_posted_month', $post_month);
            $data['month'] = $this->session->userdata('quick_product_posted_month');
        } else {
            $data['month'] = date('M');
        }

        //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        if ($data['month'] != '13') {
            $fromDate = $data['year'] . "-" . $data['month'] . "-01";
            $toDate = date("Y-m-d", strtotime($fromDate . " +1 months"));
            $this->Complex_model2->setShopId($this->session->userdata('shop'));
            $fromDate = date("Y-m-d", strtotime($fromDate));
        } else {
            $fromDate = $data['year'] . "-01-01";
            $toDate = date("Y-m-d", strtotime($fromDate . " +1 years"));
        }

        //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

        $languages_1 = array('0' => 'Select language', 'english' => 'UK', 'german' => 'DE', 'french' => 'FR', 'dutch' => 'NL', 'BG' => 'BG');

        if (!empty($this->session->userdata('language'))) {
            $lang_index = $languages_1[$this->session->userdata('language')];
        } else {
            $lang_index = 'NL';
        }


        $shop_post = $this->input->post('shop_nationality');

        if (!empty($shop_post)) {
            $this->session->set_userdata('shop_nationality', $this->input->post('shop_nationality'));
            $data['shop_nationality'] = $this->session->userdata('shop_nationality');
        } else {
            $data['shop_nationality'] = 'NL';
        }

        $name = 'name_' . $data['shop_nationality'];
        $description = 'description_' . $data['shop_nationality'];
        $text_1 = 'text_1_' . $data['shop_nationality'];
        $text_2 = 'text_2_' . $data['shop_nationality'];
        //$link_1 		= 'link_1'.$lang_index;
        //$link_2 		= 'link_2_'.$lang_index;
        $price = 'saleprice_' . $data['shop_nationality'];

        //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        if ($id) {
            /* set turnover model */
            $this->Complex_model2->setShopId($this->session->userdata('shop'));
            $data['showBy'] = 'customers';
            $product = $this->Product_model->get_product($id);
            $this->Complex_model2->setShowBy('customers');
            $filterModel['products'] = $this->Complex_model2->clearTerm($product->code);
            $this->Complex_model2->setFilter($filterModel);
            /* */
            $data['id'] = $id;
            $data['name'] = $product->$name;
            $data['code'] = str_replace('/','',$product->code);
            $data['price'] = $product->$price;
            $data['package_details'] = $product->package_details;
            $data['quantity'] = $product->quantity;
            $data['dimension'] = $product->dimension;
            $data['weight'] = $product->weight;
            $data['size'] = $product->size;
            $data['remarks'] = $product->remarks;

            $group = $this->Group_model->get_group($product->grp_id, $this->session->userdata('shop'));
            $data['description'] = $group->$description;
            $data['text_1'] = $group->$text_1;
            $data['text_2'] = $group->$text_2;
            $data['link_1'] = $group->link_1;
            $data['link_2'] = $group->link_2;
            $data['link_1_href'] = $group->link_1_href;
            $data['link_2_href'] = $group->link_2_href;
            $data['seo_title'] = $group->seo_title;
            $data['detail'] = $this->Product_model->get_country($data['shop_nationality']);
            $data['all_shops_national'] = $this->Category_model->get_shop_nationalities($this->session->userdata('shop'));
            $data['res'] = $this->Complex_model2->productTurnover($fromDate, $toDate);
            //echo '<pre>';
            //print_r($data['res']);
            //echo '</pre>';
            //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            /* supplier's details */
            $data['suppliers'] = $this->Supplier_model->fetch_supplier(str_replace('/', '', $product->code), $this->session->userdata('shop'));

            //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            /* files */

            $this->load->helper('directory');
            $this->load->helper('file');

            $dir_path = $_SERVER['DOCUMENT_ROOT'] . '/group_files/certificates/' . $product->grp_id;
            if (!file_exists($dir_path)) {
                mkdir($dir_path, 0777, true);
            }

            $data['files'] = directory_map($dir_path);
            $data['path'] = base_url() . 'group_files/certificates/' . $product->grp_id;

            //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            //new shipment date per item
            $new_shippment_date = $this->Stock_model->get_item_new_shippment_date($product->code, $this->session->userdata('shop'));
            $data['new_shippment_date'] = $new_shippment_date->VERWACHT;
            //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            $data['images'] = json_decode($product->images);
            if (!empty($data['images'])) {
                foreach ($data['images'] as $img) {
                    $photo_big[] = '<img src="' . 'http://www.varnamed.com/uploads/images/full/' . $img->filename . '" alt="' . $group->seo_title . '"/>';
                    $photo_medium[] = '<img src="' . 'http://www.varnamed.com/uploads/images/medium/' . $img->filename . '" alt="' . $group->seo_title . '"/>';
                    $photo_small[] = '<img src="' . 'http://www.varnamed.com/uploads/images/small/' . $img->filename . '" alt="' . $group->seo_title . '"/>';
                }
                $data['photo_big'] = $photo_big[0];
                $data['photo_medium'] = $photo_medium[0];
                $data['photo_small'] = $photo_small[0];
            } else {
                $data['photo_big'] = '<img src="http://www.varnamed.com/uploads/images/no_image_full" alt="no_image"/>';
                $data['photo_medium'] = '<img src="http://www.varnamed.com/uploads/images/no_image_full" alt="no_image"/>';
                $data['photo_small'] = '<img src="http://www.varnamed.com/uploads/images/no_image_small" alt="no_image"/>';
            }

            //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            $post_remark = $this->input->post('remarks');

            if (!empty($post_remark)) {

                $this->Product_model->update_product_quick($id, $post_remark, $this->session->userdata('shop'));
                redirect($this->config->item('admin_folder') . '/products/quick_view/' . $id);
            }


            //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
        }

        $timeid = 0;
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));

        $this->load->view($this->config->item('admin_folder') . '/quick_products', $data);
    }

    function form($id = false, $duplicate = false) {

						if (!$this->bitauth->logged_in()) {
							$this->session->set_userdata('redir', current_url());
							redirect($this->config->item('admin_folder') . '/admin/login');
						}
						if (!$this->bitauth->has_role('can_edit_product')) {
							$this->session->set_flashdata('message', "&nbsp;&nbsp;You have no right to edit Products");
							redirect($this->config->item('admin_folder') . '/admin/login');
						}

						$data['can_edit_product'] 	= $this->bitauth->has_role('can_edit_product');

						$category_id 		= $this->category_id;
						$data['groups'] 	= $this->Group_model->get_shop_groups($this->shop_id);
						$data['group'] 		= $this->session->userdata('ba_username');
						$data['products'] 	= $this->products;
						$data['categories'] = $this->categories;

	
						$data['grpp'] 		= '';
						
						$this->product_id 	= $id;

						$data['all_cats'] 	= $this->Category_model->get_current_categories($this->shop_id);
						$data['all_groups'] = $this->Category_model->get_current_groups($this->shop_id);
		
								//-----------------------------------------------------------------------------------------------------------------------------------------------------
								/*all categories*/
								$all_categories = $this->Group_model->get_all_cats($this->shop_id);
								$cats = array();
								foreach($all_categories as $category){
									$cats[$category['id']] = $category['name'];
								}
								$f = array('-1'=>'Select category');
								$data['all_categories'] = $cats+$f;
								//-----------------------------------------------------------------------------------------------------------------------------------------------------

		
		
		
				$data['product_list'] 		= $this->Product_model->get_products();
				$data['file_list']	 		= $this->Digital_Product_model->get_list();
				$data['id'] 				= '';
				$data['code'] 				= '';
				$data['cat_id'] 			= '-1';
				$data['grp_id'] 			= '';
				$data['brand'] 				= '';
				$data['type'] 				= '';
				$data['name'] 				= '';
				$data['slug'] 				= '';
				$data['description'] 		= '';
				$data['excerpt'] 			= '';
				$data['price'] 				= '';
				$data['EK'] 				= '';
				$data['saleprice'] 			= '';
				$data['warehouse_price'] 	= '';
				$data['saleprice_NL'] 		= '';
				$data['saleprice_DE'] 		= '';
				$data['saleprice_AU'] 		= '';
				$data['saleprice_FR'] 		= '';
				$data['saleprice_BE'] 		= '';
				$data['saleprice_UK'] 		= '';
				$data['saleprice_LX'] 		= '';
				$data['name_NL'] 			= '';
				$data['name_DE'] 			= '';
				$data['name_AU'] 			= '';
				$data['name_FR'] 			= '';
				$data['name_BE'] 			= '';
				$data['name_BEL'] 			= '';
				$data['name_UK'] 			= '';
				$data['name_LX'] 			= '';

				$data['vat_NL'] 			= 21;
				$data['vat_DE'] 			= 19;
				$data['vat_AU'] 			= 20;
				$data['vat_FR'] 			= 20;
				$data['vat_BE'] 			= 21;
				$data['vat_UK'] 			= 20;
				$data['vat_LX'] 			= 15;

				$data['complexType'] 		= '';
				$data['weight'] 			= '';
				$data['track_stock'] 		= '';
				$data['seo_title'] 			= '';
				$data['meta'] 				= '';
				$data['shippable'] 			= '';
				$data['taxable'] 			= '';
				$data['differing_dispatch_costs'] = '';
				$data['fixed_quantity'] 	= '';
				$data['quantity'] 			= '';
				$data['active'] 			= '';
				$data['size'] 				= '';
				$data['color'] 				= '';
				$data['package_1'] 			= '';
				$data['package_2'] 			= '';
				$data['available_stock'] 			= '';
				$data['package_3'] 			= '';
				$data['package_details']	= '';
				$data['suppliers'] 			= array();
				$data['related_products'] 	= array();
				$data['product_categories'] = array();
				$data['images'] 			= array();
				$data['product_files'] 		= array();
				$data['average_price']		=	'';
				$data['photos'] 			= array();

			if ($id) {

				$pr_files 							= $this->Digital_Product_model->get_associations_by_product($id);
				foreach ($pr_files as $f) {
					$data['product_files'][] 		= $f->file_id;
				}
				$data['product_options'] 			= $this->Option_model->get_product_options($id);
				$product 							= $this->Product_model->get_product($id);
				if (!$product) {
					$this->session->set_flashdata('error', lang('error_not_found'));
					redirect($this->config->item('admin_folder') . '/products');
				}
				$this->product_name 				= $this->input->post('slug', $product->slug);

				//-----------------------------------------------------------------------------------------------------------------------------------
				/*posted product values of existing product*/
				
				$data['id'] 						= $id;
				$data['code'] 						= $product->code;
				$data['name_NL'] 					= $product->name_NL;
				$data['name_BE'] 					= $product->name_BE;
				$data['name_BEL'] 					= $product->name_BEL;
				$data['name_FR'] 					= $product->name_FR;
				$data['name_DE'] 					= $product->name_DE;
				$data['name_AU'] 					= $product->name_AU;
				$data['name_LX'] 					= $product->name_LX;
				$data['name_UK'] 					= $product->name_UK;
				$data['description'] 				= $product->description;
				$data['complexType'] 				= $product->complexType;
				$data['cat_id'] 					= $product->cat_id;
				$data['grp_id'] 					= $product->grp_id;
				$data['warehouse_price'] 			= $product->warehouse_price;
				$data['EK'] 						= $product->EK;
				$data['saleprice_NL'] 				= $product->saleprice_NL;
				$data['saleprice_DE'] 				= $product->saleprice_DE;
				$data['saleprice_AU'] 				= $product->saleprice_AU;
				$data['saleprice_FR'] 				= $product->saleprice_FR;
				$data['saleprice_BE'] 				= $product->saleprice_BE;
				$data['saleprice_LX'] 				= $product->saleprice_LX;
				$data['saleprice_UK'] 				= $product->saleprice_UK;
				$data['differing_dispatch_costs'] 	= $product->differing_dispatch_costs;
				$data['vat_NL'] 					= $product->vat_NL;
				$data['vat_DE'] 					= $product->vat_DE;
				$data['vat_AU'] 					= $product->vat_AU;
				$data['vat_FR'] 					= $product->vat_FR;
				$data['vat_BE'] 					= $product->vat_BE;
				$data['vat_LX'] 					= $product->vat_LX;
				$data['vat_UK'] 					= $product->vat_UK;
				$data['package_1'] 					= $product->package_1;
				$data['package_2'] 					= $product->package_2;
				$data['package_3'] 					= $product->package_3;
				$data['package_details'] 			= $product->package_details;
				$data['available_stock'] 			= $product->available_stock;
				$data['weight'] 					= $product->weight;
				$data['size'] 						= $product->size;
				$data['color'] 						= $product->color;
				$data['active'] 					= $product->enabled;
				$data['shippable'] 					= $product->shippable;
				$data['taxable'] 					= $product->taxable;
				$data['slug'] 						= $product->slug;
				$data['seo_title'] 					= $product->seo_title;
				$data['meta'] 						= $product->meta;
				
				if ($data['complexType'] == 'complex')
				{
					$data['parts'] = $this->Part_model->getParts($this->session->userdata('shop'), $id);
				}
				
				//------------------------------------------------------------------------------------------------------------------------------------------
				/*average price*/
				$prices 				= 	array($product->saleprice_NL,$product->saleprice_DE,$product->saleprice_AU,$product->saleprice_FR,$product->saleprice_BE,$product->saleprice_UK,$product->saleprice_LX);
				$prices_num				=	count($prices);
				$prices_sum				=	array_sum($prices);
				$data['average_price']	=	$prices_sum/$prices_num;
				
				//------------------------------------------------------------------------------------------------------------------------------------------
				/*all groups for category*/
				$all_groupos = $this->Group_model->fetch_all_groups($product->cat_id,$this->session->userdata('shop'));
				$grps	=	array();
				foreach($all_groupos as $group){
					$grps[$group['group_id']] = $group['group_name'];
				}
				$data['all_groupos'] = $grps;		
				//------------------------------------------------------------------------------------------------------------------------------------------
				/* suppliers */
				
				$supplier 		= $this->Supplier_model->get_supplier(str_replace('/', '', $product->code),$this->session->userdata('shop'));
				$suppliers 		= array();
				$suppliers_name = array();
				
				foreach ($supplier as $sup) {
					$suppliers_name[] = $this->Supplier_model->get_suppliers_name($sup['LEVERANCIE'],$this->session->userdata('shop'));
					$suppliers[] = $this->Supplier_model->get_the_supplier($sup['LEVERANCIE'],$this->session->userdata('shop'));
				}
				$sup_name 	= array_filter($suppliers_name);
				$s_n 		= array();
				foreach($sup_name as $v){
					$s_n[$v['id']]	=	$v['company'];
				}
			
				$data['suppliers'] = $supplier;
				$data['suppliers_name'] = $s_n;
				//------------------------------------------------------------------------------------------------------------------------------------------
				/* groups for category */
				$data['all_groups'] = $this->Category_model->get_current_groups_by_cat($this->shop_id, $product->cat_id);

				$grp = array();
				foreach ($data['all_groups'] as $gr) {
					$grp[$gr->group_id] = array('name' => $gr->group_name);
				}
				$data['group_drops'] = $grp;

				foreach ($data['all_cats'] as $ct) {
					$ctr[$ct->id] = array('name' => $ct->name);
				}
				$data['cat_drops'] = $ctr;
				//------------------------------------------------------------------------------------------------------------------------------------------
				
					//make sure we haven't submitted the form yet before we pull in the images/related products from the database
					if (!$this->input->post('submit')) {

						$data['product_categories'] = $product->categories;
						$data['related_products'] 	= $product->related_products;
						$data['images'] 			= (array) json_decode($product->images);
					}
			}

				if (!is_array($data['related_products'])) {
					$data['related_products'] 	= array();
				}
				if (!is_array($data['product_categories'])) {
					$data['product_categories'] = array();
				}

				if ($duplicate) {
					$data['id'] 				= false;
				}

				if ($this->input->post('submit')) {
					$data['product_options'] 	= $this->input->post('option');
					$data['related_products'] 	= $this->input->post('related_products');
					$data['product_categories'] = $this->input->post('categories');
					$data['product_group'] 		= $this->input->post('group');
					$data['images'] 			= $this->input->post('images');
					$data['product_files'] 		= $this->input->post('downloads');
				}

			//-----------------------------------------------------------------------------------------------------------------------------------
			/*form validations*/

					$this->form_validation->set_rules('code', 'lang:code', 'required');
					//$this->form_validation->set_rules('slug', 'lang:slug_', 'required');

			//-----------------------------------------------------------------------------------------------------------------------------------	
				if ($this->form_validation->run() == FALSE) {
					

					$this->session->set_flashdata('error','The code or the URL Keyword is missing.');
					$data['error']	=	$this->session->flashdata('error');

					$data['categories_dropdown'] = $this->categories_dropdown;

					$timeid = 0;
					if ($timeid == 0) {
						$time = time();
					} else {
						$time = $timeid;
					}
					$data['weather'] 	= _date($time);
					$data['events'] 	= $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
					$this->load->view($this->config->item('admin_folder') . '/product_form', $data);
				} else {
			//-----------------------------------------------------------------------------------------------------------------------------------
			/*slug and route*/
           
            $slug 					= $this->input->post('slug');
			
            if (empty($slug) || $slug == '') {
                $slug 				= $this->input->post('name_NL');
            }
			
            $slug 					= url_title(convert_accented_characters($slug), 'dash', TRUE);

            if ($id) {
                $slug 				= $this->Routes_model->validate_slug($slug, $product->route_id);
				$route['group_id']	= $product->grp_id;
                $route_id 			= $product->route_id;
            } else {
                $slug 				= $this->Routes_model->validate_slug($slug);
                $route['slug'] 		= $slug;
                $route['group_id'] 	= $this->input->post('group');
                $route_id 			= $this->Routes_model->save($route);
            }

			//-----------------------------------------------------------------------------------------------------------------------------------
			/*posted product values*/
			
            $save['id'] 						= $id;
			$save['shop_id'] 					= $this->session->userdata('shop');
			
            $save['code'] 						= $this->input->post('code');
            $save['name_NL'] 					= $this->input->post('name_NL');
            $save['name_DE'] 					= $this->input->post('name_DE');
            $save['name_AU'] 					= $this->input->post('name_AU');
            $save['name_FR'] 					= $this->input->post('name_FR');
            $save['name_BE'] 					= $this->input->post('name_BE');
            $save['name_BEL'] 					= $this->input->post('name_BEL');
            $save['name_UK'] 					= $this->input->post('name_UK');
            $save['name_LX'] 					= $this->input->post('name_LX');
            $save['description'] 				= $this->input->post('description');
            $save['complexType'] 				= $this->input->post('complexType');
            $save['cat_id'] 					= $this->input->post('category');
            $save['grp_id'] 					= $this->input->post('group');
            $save['warehouse_price'] 			= str_replace('€','',$this->input->post('warehouse_price'));
            $save['EK'] 						= $this->input->post('EK');
            $save['saleprice_NL'] 				= str_replace('€','',$this->input->post('saleprice_NL'));
            $save['saleprice_DE'] 				= str_replace('€','',$this->input->post('saleprice_DE'));
            $save['saleprice_AU'] 				= str_replace('€','',$this->input->post('saleprice_AU'));
            $save['saleprice_FR'] 				= str_replace('€','',$this->input->post('saleprice_FR'));
            $save['saleprice_BE'] 				= str_replace('€','',$this->input->post('saleprice_BE'));
            $save['saleprice_LX'] 				= str_replace('€','',$this->input->post('saleprice_LX'));
            $save['saleprice_UK'] 				= str_replace('£','',$this->input->post('saleprice_UK'));
            $save['vat_NL'] 					= str_replace('%','',$this->input->post('vat_NL'));
            $save['vat_DE'] 					= str_replace('%','',$this->input->post('vat_DE'));
            $save['vat_AU'] 					= str_replace('%','',$this->input->post('vat_AU'));
            $save['vat_FR'] 					= str_replace('%','',$this->input->post('vat_FR'));
            $save['vat_BE'] 					= str_replace('%','',$this->input->post('vat_BE'));
            $save['vat_LX'] 					= str_replace('%','',$this->input->post('vat_LX'));
            $save['vat_UK'] 					= str_replace('%','',$this->input->post('vat_UK'));
            $save['differing_dispatch_costs'] 	= str_replace('%','',$this->input->post('differing_dispatch_costs'));
            $save['package_1'] 					= $this->input->post('package_1');
            $save['package_2'] 					= $this->input->post('package_2');
            $save['package_3'] 					= $this->input->post('package_3');
            $save['package_details'] 			= $this->input->post('package_details');
            $save['available_stock'] 			= $this->input->post('available_stock');
            $save['weight'] 					= $this->input->post('weight');
            $save['size'] 						= $this->input->post('size');
            $save['color'] 						= $this->input->post('color');
            $save['enabled'] 					= $this->input->post('active');
            $save['shippable'] 					= $this->input->post('shippable');
            $save['taxable'] 					= $this->input->post('taxable');
            $save['slug'] 						= $slug;
            $save['seo_title'] 					= $this->input->post('seo_title');
            $save['meta'] 						= $this->input->post('meta');
            $post_images 						= $this->input->post('images');

            $save['route_id'] 					= $route_id;


            if ($primary = $this->input->post('primary_image')) {
                if ($post_images) {
                    foreach ($post_images as $key => &$pi) {
                        if ($primary == $key) {
                            $pi['primary'] = true;
                            continue;
                        }
                    }
                }
            }
			
            $save['images'] = json_encode($post_images);
			//-----------------------------------------------------------------------------------------------------------------------------------
			/*related products and options*/
			
            if ($this->input->post('related_products')) {
                $save['related_products'] = json_encode($this->input->post('related_products'));
            } else {
                $save['related_products'] = '';
            }


            $options = array();
            if ($this->input->post('option')) {
                foreach ($this->input->post('option') as $option) {
                    $options[] = $option;
                }
            }
			//-----------------------------------------------------------------------------------------------------------------------------------
			/*product to group relation*/
            $product_id 			= $this->Product_model->save_($save, $options);
			
            $relation['product_id'] = $product_id;
            $relation['shop_id'] 	= $this->session->userdata('shop');
            $relation['group_id'] 	= $this->input->post('group');

            $this->Routes_model->save_product_relation($relation);
			//-----------------------------------------------------------------------------------------------------------------------------------
			/*product route string*/
            $routing['product_id'] 	= $product_id;
            $routing['route_id'] 	= $route_id;
			$routing['route'] 		= 'cart/product/'.$product_id;

            $this->Routes_model->save_product_route($routing);
			//-----------------------------------------------------------------------------------------------------------------------------------
            $this->session->set_flashdata('message', lang('message_saved_product'));

            redirect($this->config->item('admin_folder') . '/products/form/' . $product_id);
        }
    }

    public function old_product_form($NR = false) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        $data['old_product'] = $this->Product_model->get_old_product($NR);
        $data['suppliers'] = $this->Product_model->get_suppliers($data['old_product']->code);

        $shop = array(1 => 'Comforties', 2 => 'Dutchblue', 3 => 'Glovers');
        $data['current_shop'] = $shop[$this->shop_id];
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/old_product_form', $data);
    }

    function product_image_form() {

        $data['file_name'] = false;
        $data['error'] = false;
        $this->load->view($this->config->item('admin_folder') . '/iframe/product_image_uploader', $data);
    }

    function product_image_upload() {
        $data['file_name'] = false;
        $data['error'] = false;

        $config['allowed_types'] = 'gif|jpg|png';
        //$config['max_size']	= $this->config->item('size_limit');
        $config['upload_path'] = 'uploads/images/full';
        $config['encrypt_name'] = true;
        $config['remove_spaces'] = true;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload()) {
            $upload_data = $this->upload->data();

            $this->load->library('image_lib');
            /*

              I find that ImageMagick is more efficient that GD2 but not everyone has it
              if your server has ImageMagick then you can change out the line

              $config['image_library'] = 'gd2';

              with

              $config['library_path']		= '/usr/bin/convert'; //make sure you use the correct path to ImageMagic
              $config['image_library']	= 'ImageMagick';
             */

            //this is the larger image
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/images/full/' . $upload_data['file_name'];
            $config['new_image'] = 'uploads/images/medium/' . $upload_data['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 600;
            $config['height'] = 500;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->image_lib->clear();

            //small image
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/images/medium/' . $upload_data['file_name'];
            $config['new_image'] = 'uploads/images/small/' . $upload_data['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 235;
            $config['height'] = 235;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->image_lib->clear();

            //cropped thumbnail
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/images/small/' . $upload_data['file_name'];
            $config['new_image'] = 'uploads/images/thumbnails/' . $upload_data['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 150;
            $config['height'] = 150;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->image_lib->clear();

            $data['file_name'] = $upload_data['file_name'];
        }

        if ($this->upload->display_errors() != '') {
            $data['error'] = $this->upload->display_errors();
        }
        $this->load->view($this->config->item('admin_folder') . '/iframe/product_image_uploader', $data);
    }

    function delete($id = false) {
        if ($id) {
            $product = $this->Product_model->get_product($id);
            //if the product does not exist, redirect them to the customer list with an error
            if (!$product) {
                $this->session->set_flashdata('error', lang('error_not_found'));
                redirect($this->config->item('admin_folder') . '/products');
            } else {

                // remove the slug
                $this->load->model('Routes_model');
                $this->Routes_model->remove('(' . $product->slug . ')');

                //if the product is legit, delete them
                $this->Product_model->delete_product($id);

                $this->session->set_flashdata('message', lang('message_deleted_product'));
                redirect($this->config->item('admin_folder') . '/products');
            }
        } else {
            //if they do not provide an id send them to the product list page with an error
            $this->session->set_flashdata('error', lang('error_not_found'));
            redirect($this->config->item('admin_folder') . '/products');
        }
    }

    function track_stock(array $product_number) {


        //(select) -> product_number
        //(get_current_quantity) -> product_number
        //(see if the new quantity is more than the current quantity)
        //(if) the current_quantity is < new quantity -> set order quantity of product to the current quantity -> (new_quantity - current_quantity) = backorder_quantity -> send to backorders the backorder_quantity 
        //(if) the current_quantity is > new quantity -> (current_quantity - new quantity)
        //(update the new quantity to the current_quantity)    
        //(update the quantity) -> product_number           
    }

}
