<?php

class Stock extends CI_Controller {

    //this is used when editing or adding a customer
    var $supplier_id = false;
    private $start_search = false;
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
        $this->load->model(array(
            'Supplier_model',
            'Stock_model',
            'Order_model',
            'Shop_model',
            'Search_model',
            'Location_model',
            'Product_model',
            'Option_model',
            'Category_model',
            'Digital_Product_model',
            'Group_model',
            'Invoice_model',
            'Reservations_model',
        ));
        ////////////////////////////////////////////////////////////////
        $this->load->helper(array('formatting', 'form'));
        $this->load->library('form_validation');
        $this->load->helper('date');
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
        $this->lang->load('order', $this->language);
        $this->lang->load('dashboard', $this->language);
        $this->lang->load('header', $this->language);
        $this->lang->load('product', $this->language);
        $this->lang->load('supplier', $this->language);
        $this->lang->load('stock', $this->language);
        $this->page_title = lang('products');

        ////////////////////////////////////////////////////////////////
        $this->groups = $this->Group_model->get_all_the_groups();
        $this->products = $this->Product_model->get_all_products();
        $this->categories = $this->Category_model->get_all_categories();
        ////////////////////////////////////////////////////////////////
    }

			function index($sort_by = 'order_number', $sort_order = 'asc', $code = 0, $page = 0, $rows = 15) {

				if (!$this->bitauth->logged_in()) {
					$this->session->set_userdata('redir', current_url());
					redirect($this->config->item('admin_folder') . '/admin/login');
				}
				$data['categories'] = $this->categories;
				$data['groups'] = $this->groups;
				$data['products'] = $this->products;
				$data['all_shops'] = $this->Shop_model->get_shops();

				if ($this->input->post('submit') == 'export') {

					$this->load->model('customer_model');
					$this->load->helper('download_helper');
					$post = $this->input->post(null, false);

					$term = (object) $post;

					$data['orders'] = $this->Order_model->get_orders($term);

					foreach ($data['orders'] as &$o) {

						$o->items = $this->Order_model->get_all_items($o->id);
					}

					force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));
					die;
				}

				$this->load->helper('form');
				$this->load->helper('date');

				$data['page_title'] = lang('recent_orders');
				$data['code'] = $code;
				$term = false;

				$post = $this->input->post(null, false);
				if ($post) {

					$term = json_encode($post);
					$code = $this->Search_model->record_term($term);
					$data['code'] = $code;
					$term = (object) $post;
				} elseif ($code) {
					$term = $this->Search_model->get_term($code);
					$term = json_decode($term);
				}

				$data['term'] 				= $term;
				$shop_id 					= $this->shop_id;
				$data['orders'] 			= $this->Stock_model->get_stock_orders($term, $sort_by, $sort_order, $rows, $page, $shop_id);
				$data['total'] 				= $this->Stock_model->get_stock_orders_count($term);

				$s_n 						= $this->Stock_model->get_shop_suppliers($this->session->userdata('shop'));
				$data['suppliers'] 			= $this->Stock_model->get_shop_suppliers($this->session->userdata('shop'));


				$this->load->library('pagination');

				$config['base_url'] 		= site_url($this->config->item('admin_folder') . '/stock/index/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
				$config['total_rows'] 		= $data['total'];
				$config['per_page'] 		= $rows;
				$config['uri_segment'] 		= 7;
				$config['first_link'] 		= 'First';
				$config['first_tag_open'] 	= '<li>';
				$config['first_tag_close'] 	= '</li>';
				$config['last_link'] 		= 'Last';
				$config['last_tag_open'] 	= '<li>';
				$config['last_tag_close'] 	= '</li>';
				$config['full_tag_open'] 	= '<div class="pagination"><ul>';
				$config['full_tag_close'] 	= '</ul></div>';
				$config['cur_tag_open'] 	= '<li class="active"><a href="#">';
				$config['cur_tag_close'] 	= '</a></li>';

				$config['num_tag_open'] 	= '<li>';
				$config['num_tag_close'] 	= '</li>';

				$config['prev_link'] 		= '&laquo;';
				$config['prev_tag_open'] 	= '<li>';
				$config['prev_tag_close'] 	= '</li>';

				$config['next_link'] 		= '&raquo;';
				$config['next_tag_open'] 	= '<li>';
				$config['next_tag_close'] 	= '</li>';

				$this->pagination->initialize($config);

				$data['sort_by'] 			= $sort_by;
				$data['sort_order'] 		= $sort_order;


				$timeid = 0;
				if ($timeid == 0) {
					$time = time();
				} else {
					$time = $timeid;
				}
				$data['weather'] = _date($time);
				$data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
				$this->load->view($this->config->item('admin_folder') . '/stock_orders', $data);
			}

    public function warehouse_stock() {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['page_title'] = lang('warehouse_stock');
        $data['current_shop'] = $this->session->userdata('shop');

        $product_code = $this->session->userdata('product_code');


        $term = '';

        if (!empty($_POST)) {
            $term = $this->input->post('term');
            $this->session->set_userdata('product_code', $term);
        } else {
            if (!empty($product_code)) {
                $term = $product_code;
            }
        }
		$export					= $this->input->post('export');
		if(!empty($export)){	
			
			$data['week_stock']	=	$this->Stock_model->get_week_stock($this->session->userdata('shop'));
			$this->load->view($this->config->item('admin_folder').'/week_stock_xml', $data);
			
		}

		
		

        $data['orders'] = $this->Stock_model->get_warehouse_stock($term, $this->session->userdata('shop'));


        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/warehouse_stock', $data);
    }

    public function move() {


        $move_stock['shop_id'] = $this->session->userdata('shop');
        $product_code = $this->input->post('product_code');

        if (!empty($product_code)) {
            $product = $this->input->post('product_code');
            $this->session->set_userdata('product_move_code', $this->input->post('product_code'));
        } else {
            $product = $this->session->userdata('product_move_code');
        }

        $move_stock['product_code'] = $product;
        $move_stock['agent_id'] = $this->session->userdata('ba_user_id');
        $move_stock['date'] = date('Y-m-d');
        $move_stock['quantity'] = $this->input->post('quantity');
        $move_stock['order_number_from'] = $this->input->post('order_number_from');
        $move_stock['batch_number_from'] = $this->input->post('batch_number_from');
        $move_stock['warehouse_place_from'] = $this->input->post('warehouse_place_from');
        $move_stock['order_number_to'] = $this->input->post('order_number_to');
        $move_stock['batch_number_to'] = $this->input->post('batch_number_to');
        $move_stock['warehouse_place_to'] = $this->input->post('warehouse_place_to');

        //print_r($move_stock);
        //$this->Stock_model->move_products($move_stock);
        $f = $this->Stock_model->some($move_stock, $this->session->userdata('shop'));
        echo '<pre>';
        print_r($f);
        echo '</pre>';

        //$this->session->set_flashdata('product_number', $this->input->post('product_code'));
        //redirect($this->config->item('admin_folder').'/stock/warehouse_stock','refresh'); 
    }

    //callback
    public function product_check($str) {

        $result = $this->Product_model->check_product($str);
        if (empty($result)) {
            $this->session->set_flashdata('message', 'This product does not exists');
            return false;
        } else {
            return true;
        }
    }

    //callback
    public function order_check($str) {

        $code = $this->input->post('product_code');
        $result = $this->Product_model->check_order($str, $code);
        if (empty($result)) {
            $this->session->set_flashdata('message', 'There is no order with this product');
            return false;
        } else {
            return true;
        }
    }

    public function operation() {
        echo "<pre>";
        print_r($_POST);
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        // next are actually arrays due possible multiple inputs
        $new_code = $this->input->post('new_code');
        $new_quantity = $this->input->post('new_quantity');
        // so far next might be empty
        $magazijnnr = $this->input->post('magazijnnr');
        $new_order_number = $this->input->post('new_order_number');
        $new_arrival_date = $this->input->post('new_arrival_date') ? $this->input->post('new_arrival_date') : date("Y-m-d");
        $new_expiry_date = $this->input->post('new_expiry_date');
        $new_batch_number = $this->input->post('new_batch_number');
        $new_warehouse_place = $this->input->post('new_warehouse_place');
        $reason = $this->input->post('reason');


        $key = count($new_code);

        for ($i = 0; $i < $key; $i++) {

            $product_array[] = array(
                'shop_id' => $this->session->userdata('shop'),
                'code' => $new_code[$i],
                'current_quantity' => $new_quantity[$i],
                'warehouse' => $magazijnnr[$i],
                'stock_order_number' => $new_order_number[$i],
                'reception_date' => $new_arrival_date[$i],
                'expiration_date' => $new_expiry_date[$i],
                'batch_number' => $new_batch_number[$i],
                'warehouse_place' => $new_warehouse_place[$i],
                'ordered_quantity' => 0
            );

            $movements[] = array(
                'shop_id' => $this->session->userdata('shop'),
                'agent_id' => $this->session->userdata('ba_user_id'),
                'date' => date('Y-m-d'),
                'product_code' => $new_code[$i],
                'quantity' => $new_quantity[$i],
                'reason' => $reason[$i],
            );
        }


        if (!empty($_POST['add'])) {

            foreach ($movements as $movement) {

                $add = array('remarks' => 'A');
                $move = array_merge($add, $movement);
                $this->Stock_model->move_products($move);
            }

            foreach ($product_array as $product) {


                $qq = $this->Stock_model->remove_backorders($product, $this->session->userdata('shop'));
                
                    $product['ordered_quantity'] = $product['current_quantity'] - $qq;
                    print_r($product);
                    $this->Stock_model->insert_new_quantities($product, $this->session->userdata('shop'));
                
                echo "</pre>";
                
            }
            // exit; // uncomment for test usues
            redirect($this->config->item('admin_folder') . '/stock/warehouse_stock');
        }

        if (!empty($_POST['remove'])) {

            $batch = $this->input->post('new_batch_number');

            foreach ($batch as $key => $value) {

                if (empty($value)) {

                    $this->session->set_flashdata('error', 'ENTER BATCH NUMBER');
                    redirect($this->config->item('admin_folder') . '/stock/warehouse_stock');
                } else {

                    echo '<pre>';
                    //print_r($movements);
                    print_r($product_array);
                    echo '</pre>';

                    foreach ($movements as $movement) {

                        $ded = array('remarks' => 'D');
                        $move = array_merge($ded, $movement);
                        //$this->Stock_model->move_products($move);
                    }

                    foreach ($product_array as $products) {

                        $q = $this->Stock_model->select_from_stock(array('code' => $products['code'], 'batch_number' => $products['batch_number']), $this->session->userdata('shop'));

                        if ($q->current_quantity > $products['current_quantity']) {
                            $number = $q->current_quantity - $products['current_quantity'];
                        } else {
                            $this->session->set_flashdata('error', 'ARE YOU STUPID? THE NUMBER OF DEDUCTION MUST BE GREATER THAN THE EXISTING QUANTITY FOR THE PRODUCT!');
                            redirect($this->config->item('admin_folder') . '/stock/warehouse_stock');
                        }

                        $this->Stock_model->remove_from_stock(array('number' => $number, 'code' => $products['code'], 'batch_number' => $products['batch_number']), $this->session->userdata('shop'));
                    }
                    redirect($this->config->item('admin_folder') . '/stock/warehouse_stock');
                }
            }
        }

        //$this->session->set_flashdata('product_number', $this->input->post('product_code'));
        //redirect($this->config->item('admin_folder').'/stock/warehouse_stock','refresh');
    }

    public function discarded_list($sort_by = 'stock_order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['page_title'] = lang('discarded');


        $data['code'] = $code;
        $term = false;

        $post = $this->input->post(null, false);
        if ($post) {

            $term = json_encode($post);
            $data['code'] = $code;
            $term = (object) $post;
        } elseif ($code) {
            $term = json_decode($term);
        }

        $data['term'] = $term;

        $shop_id = $this->shop_id;
        $data['backorder_stock'] = $this->Stock_model->get_discarded_stock($term, $sort_by, $sort_order, $rows, $page, $shop_id);
        $data['total'] = $this->Stock_model->get_discarded_stock($term);

        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/stock/index/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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

        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/discarded_list', $data);
    }

    public function send_backorder() {



        $a_1 = $this->input->post('product_code');
        $a_2 = $this->input->post('stock_order_number');
        $a_3 = $this->input->post('ek');
        $a_4 = $this->input->post('backorder_quantity');
        $a_5 = $this->input->post('reception_date');
        $a_6 = $this->input->post('expiration_date');
        $a_7 = $this->input->post('batch_number');
        $a_8 = $this->input->post('warehouse_place');
        $a_9 = $this->input->post('customer_order');
        $a_10 = $this->input->post('remarks');

        $client_details = array();
        foreach ($this->input->post('customer_order') as $customer_order) {

            $client_details[] = $this->Stock_model->get_customer_order(array('order_number' => $customer_order));
        }


        $key = count($this->input->post('product_code'));


        for ($i = 0; $i < $key; $i++) {

            $backorder_arr[] = array(
                'shop_id' => $this->data_shop,
                'product_code' => $a_1[$i],
                'stock_order_number' => $a_2[$i],
                'ek' => $a_3[$i],
                'backorder_quantity' => $a_4[$i],
                'reception_date' => $a_5[$i],
                'expiration_date' => $a_6[$i],
                'batch_number' => $a_7[$i],
                'warehouse_place' => $a_8[$i],
                'customer_order' => $a_9[$i],
                'agent_id' => $this->session->userdata('ba_user_id'),
                'agent_name' => $this->session->userdata('ba_username'),
                'date' => date('Y-m-d'),
                'reason' => $a_8[$i],
                'remarks' => $a_10[$i], //
            );
        }

        $new_array = array();

        for ($i = 0; $i < $key; $i++) {
            $new_array[] = array_merge($backorder_arr[$i], $client_details[$i]);
        }
        echo '<pre>';
        //print_r($new_array);
        echo '</pre>';
        foreach ($new_array as $array) {



            if (!empty($array['customer_order']) and ! empty($array['backorder_quantity'])) {
                $backorder_array[] = array(
                    'shop_id' => $array['shop_id'],
                    'product_code' => $array['product_code'],
                    'product_name' => '',
                    'stock_order_number' => $array['stock_order_number'],
                    'invoice_number' => '',
                    'reception_date' => $array['reception_date'],
                    'expiration_date' => $array['expiration_date'],
                    'batch_number' => $array['batch_number'],
                    'warehouse_place' => $array['warehouse_place'],
                    'customer_id' => $array['customer_id'],
                    'customer_name' => $array['company'] . ' ' . $array['firstname'] . ' ' . $array['lastname'],
                    'customer_order' => $array['customer_order'],
                    'agent_id' => $this->session->userdata('ba_user_id'),
                    'agent_name' => $this->session->userdata('ba_username'),
                    'backorder_quantity' => $array['backorder_quantity'],
                    'reason' => $array['reason'],
                    'remarks' => $array['remarks'],
                    'date' => $array['date'],
                );
            }
            if (empty($array['customer_order']) and ! empty($array['backorder_quantity'])) {
                $backorder_array[] = array(
                    'shop_id' => $array['shop_id'],
                    'product_code' => $array['product_code'],
                    'product_name' => '',
                    'stock_order_number' => $array['stock_order_number'],
                    'invoice_number' => '',
                    'reception_date' => $array['reception_date'],
                    'expiration_date' => $array['expiration_date'],
                    'batch_number' => $array['batch_number'],
                    'warehouse_place' => $array['warehouse_place'],
                    'customer_id' => 0,
                    'customer_name' => 0,
                    'customer_order' => 0,
                    'agent_id' => $this->session->userdata('ba_user_id'),
                    'agent_name' => $this->session->userdata('ba_username'),
                    'backorder_quantity' => $array['backorder_quantity'],
                    'reason' => $array['reason'],
                    'remarks' => $array['remarks'],
                    'date' => $array['date'],
                );
            }
        }
        $this->Stock_model->insert_backorder($backorder_array);
        redirect($this->config->item('admin_folder') . '/stock/discarded_list');
    }

    function delivered($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        if ($this->input->post('submit') == 'export') {

            $this->load->model('customer_model');
            $this->load->helper('download_helper');
            $post = $this->input->post(null, false);
            $term = (object) $post;

            $data['orders'] = $this->Order_model->get_orders($term);

            foreach ($data['orders'] as &$o) {
                $o->items = $this->Order_model->get_all_items($o->id);
            }

            force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));
            die;
        }

        $this->load->helper('form');
        $this->load->helper('date');
        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('delivered_orders');
        $data['code'] = $code;
        $term = false;

        $post = $this->input->post(null, false);
        if ($post) {

            $term = json_encode($post);
            $code = $this->Search_model->record_term($term);
            $data['code'] = $code;
            //reset the term to an object for use
            $term = (object) $post;
        } elseif ($code) {
            $term = $this->Search_model->get_term($code);
            $term = json_decode($term);
        }

        $data['term'] = $term;
        $shop_id = $this->shop_id;
        $data['orders'] = $this->Stock_model->get_stock_orders_delivered($term, $sort_by, $sort_order, $rows, $page, $shop_id);

        $data['total'] = $this->Stock_model->get_stock_orders_delivered($term);

        //$data['items']  = $this->Order_model->get_all_items($id);



        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/stock/index/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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

        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));

        $this->load->view($this->config->item('admin_folder') . '/stock_orders_delivered', $data);
    }

    function cancelled($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        if ($this->input->post('submit') == 'export') {

            $this->load->model('customer_model');
            $this->load->helper('download_helper');
            $post = $this->input->post(null, false);
            $term = (object) $post;

            $data['orders'] = $this->Order_model->get_orders($term);

            foreach ($data['orders'] as &$o) {
                $o->items = $this->Order_model->get_all_items($o->id);
            }

            force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));
            die;
        }

        $this->load->helper('form');
        $this->load->helper('date');
        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('cancelled_orders');
        $data['code'] = $code;
        $term = false;

        $post = $this->input->post(null, false);
        if ($post) {

            $term = json_encode($post);
            $code = $this->Search_model->record_term($term);
            $data['code'] = $code;
            //reset the term to an object for use
            $term = (object) $post;
        } elseif ($code) {
            $term = $this->Search_model->get_term($code);
            $term = json_decode($term);
        }

        $data['term'] = $term;
        $shop_id = $this->shop_id;
        $data['orders'] = $this->Stock_model->get_stock_orders_cancelled($term, $sort_by, $sort_order, $rows, $page, $shop_id);

        $data['total'] = $this->Stock_model->get_stock_orders_cancelled($term);

        //$data['items']  = $this->Order_model->get_all_items($id);



        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/stock/index/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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

        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $data['admins'] = $this->auth->get_admin_list();

        $this->load->view($this->config->item('admin_folder') . '/stock_orders_cancelled', $data);
    }

    function on_hold($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        if ($this->input->post('submit') == 'export') {

            $this->load->model('customer_model');
            $this->load->helper('download_helper');
            $post = $this->input->post(null, false);
            $term = (object) $post;

            $data['orders'] = $this->Order_model->get_orders($term);

            foreach ($data['orders'] as &$o) {
                $o->items = $this->Order_model->get_all_items($o->id);
            }

            force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));
            die;
        }

        $this->load->helper('form');
        $this->load->helper('date');
        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('on_hold_orders');
        $data['code'] = $code;
        $term = false;

        $post = $this->input->post(null, false);
        if ($post) {

            $term = json_encode($post);
            $code = $this->Search_model->record_term($term);
            $data['code'] = $code;
            //reset the term to an object for use
            $term = (object) $post;
        } elseif ($code) {
            $term = $this->Search_model->get_term($code);
            $term = json_decode($term);
        }

        $data['term'] = $term;
        $shop_id = $this->shop_id;
        $data['orders'] = $this->Stock_model->get_stock_orders_on_hold($term, $sort_by, $sort_order, $rows, $page, $shop_id);

        $data['total'] = $this->Stock_model->get_stock_orders_on_hold($term);

        //$data['items']  = $this->Order_model->get_all_items($id);



        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/stock/index/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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

        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $this->auth->check_access('Admin', true);
        $this->current_admin = $this->session->userdata('admin');
        $data['admins'] = $this->auth->get_admin_list();
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/stock_orders_on_hold', $data);
    }

    function closed_orders($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        if ($this->input->post('submit') == 'export') {

            $this->load->model('customer_model');
            $this->load->helper('download_helper');
            $post = $this->input->post(null, false);
            $term = (object) $post;

            $data['orders'] = $this->Order_model->get_orders($term);

            foreach ($data['orders'] as &$o) {
                $o->items = $this->Order_model->get_all_items($o->id);
            }

            force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));
            die;
        }

        $this->load->helper('form');
        $this->load->helper('date');
        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('closed_orders');
        $data['code'] = $code;
        $term = false;

        $post = $this->input->post(null, false);
        if ($post) {

            $term = json_encode($post);
            $code = $this->Search_model->record_term($term);
            $data['code'] = $code;
            //reset the term to an object for use
            $term = (object) $post;
        } elseif ($code) {
            $term = $this->Search_model->get_term($code);
            $term = json_decode($term);
        }

        $data['term'] = $term;
        $shop_id = $this->shop_id;
        $data['orders'] = $this->Stock_model->get_stock_orders_closed($term, $sort_by, $sort_order, $rows, $page, $shop_id);

        $data['total'] = $this->Stock_model->get_stock_orders_closed($term);

        //$data['items']  = $this->Order_model->get_all_items($id);



        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/stock/index/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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

        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));

        $this->load->view($this->config->item('admin_folder') . '/stock_orders_closed', $data);
    }

    function send_notification($order_id = '') {



        // send the message
        $this->load->library('email');

        $config['mailtype'] = 'html';

        $this->email->initialize($config);
        $current_shop = $this->Shop_model->get_shop($this->data_shop);
        $email = strtolower($current_shop->shop_name);

        $this->email->from($this->config->item('email') . $email . '.com', $this->config->item('company_name'));
        $this->email->to($this->input->post('recipient'));

        $this->email->subject($this->input->post('subject'));
        $this->email->message(html_entity_decode($this->input->post('content')));

        $this->email->send();

        $this->session->set_flashdata('message', lang('sent_notification_message'));

        redirect($this->config->item('admin_folder') . '/stock/view/' . $order_id);
    }

    function view($id) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['invoices'] = $this->Invoice_model->get_invoice($id);

        $this->form_validation->set_rules('notes', 'lang:notes');
        $this->form_validation->set_rules('status', 'lang:status', 'required');

        $message = $this->session->flashdata('message');
        if ($this->form_validation->run() == TRUE) {

            $save = array();
            $save['id'] = $id;
            $save['notes'] = $this->input->post('notes');
            $save['status'] = $this->input->post('status');
            $save['changed_by'] = $this->input->post('changer');
            $save['changed_on'] = date('Y-m-d H:i:s');


            $data['message'] = lang('message_order_updated');

            $this->Stock_model->save_order($save);
        }

        $data['page_title'] = lang('view_order');
        $data['order'] = $this->Stock_model->get_order($id);
        $data['supplier'] = $this->Supplier_model->get_supplier($data['order']->supplier_id);
        //print_r($data['supplier']);
        $data['vat'] = $data['supplier']->vat;
        if ($data['order']->status == 1) {
            $data['order_items'] = $this->Stock_model->get_all_items_delivered($id, $data['order']->NR, $data['order']->order_number);
        } else {
            $data['order_items'] = $this->Stock_model->get_all_items($id, $data['order']->NR, $data['order']->order_number, $this->shop_id);
        }

        //print_r($data['order_items']);

        $this->load->model('Messages_model');
        $msg_templates = $this->Messages_model->get_list('order');

        foreach ($msg_templates as $msg) {
            // fix html
            $msg['content'] = str_replace("\n", '', html_entity_decode($msg['content']));

            // {order_number}
            $msg['subject'] = str_replace('{order_number}', $data['order']->order_number, $msg['subject']);
            $msg['content'] = str_replace('{order_number}', $data['order']->order_number, $msg['content']);

            // {url}
            $msg['subject'] = str_replace('{url}', $this->config->item('base_url'), $msg['subject']);
            $msg['content'] = str_replace('{url}', $this->config->item('base_url'), $msg['content']);

            // {site_name}
            $msg['subject'] = str_replace('{site_name}', $this->config->item('company_name'), $msg['subject']);
            $msg['content'] = str_replace('{site_name}', $this->config->item('company_name'), $msg['content']);

            $data['msg_templates'][] = $msg;
        }
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/stock_order', $data);
    }

    public function update_new_order($id = false) {

        force_ssl();
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();

        //$this->load->helper('date');




        if ($id) {

            if (!empty($_POST)) {

                $this->form_validation->set_rules('code', 'lang:code', 'required');


                if ($this->form_validation->run() == FALSE) {

                    $this->form_validation->set_message('required', 'Error Message');
                } else {

                    $order_details['shop_id'] = $this->shop_id;
                    $order_details['id'] = $id;
                    $order_details['order_number'] = $this->input->post('order_number');
                    $order_details['NR'] = $this->input->post('NR');
                    $order_details['supplier_id'] = $this->input->post('supplier_id');
                    $order_details['supplier_name'] = $this->input->post('supplier_name');
                    $order_details['status'] = $this->input->post('status');
                    $order_details['ordered_on'] = $this->input->post('ordered_on');
                    $order_details['arrival_date'] = $this->input->post('arrival_date');
                    $order_details['tax'] = $this->input->post('vat');
                    $order_details['vat'] = $this->input->post('vindex');
                    $order_details['total'] = $this->input->post('gross');
                    $order_details['subtotal'] = $this->input->post('netto');
                    $order_details['shipping_notes'] = $this->input->post('shipping_notes');
                    $entered_by = $this->input->post('entered_by');
                    if (empty($entered_by)) {
                        $order_details['entered_by'] = $this->input->post('entered_by');
                    } else {
                        $order_details['entered_by'] = $this->session->userdata('ba_username');
                    }


                    $this->Stock_model->update_new_order($order_details);

                    //echo '<pre>';
                    //print_r($order_details);
                    //echo '</pre>';


                    $key = count($this->input->post('code'));



                    $a_2 = $this->input->post('code');
                    $a_3 = $this->input->post('quantity');
                    $a_4 = $this->input->post('min_stock');
                    $a_5 = $this->input->post('package_details');
                    $a_6 = $this->input->post('unit_price');
                    $a_7 = $this->input->post('total');
                    $a_8 = $this->input->post('description');

                    for ($i = 0; $i < $key; $i++) {

                        $new_array[] = array(
                            'product_number' => $a_2[$i],
                            'number' => $a_3[$i],
                            'min_stock' => $a_4[$i],
                            'package_details' => $a_5[$i],
                            'unit_price' => $a_6[$i],
                            'total' => $a_7[$i],
                            'description' => $a_8[$i],
                        );
                    }
                    foreach ($new_array as $arr) {



                        $products[] = array(
                            'NR' => $this->input->post('NR'),
                            'order_id' => $id,
                            'order_number' => $this->input->post('order_number'),
                            'ARTIKELCOD' => $arr['product_number'],
                            'AANTALBEST' => $arr['number'],
                            'MINAANTALV' => $arr['min_stock'],
                            'CAANTALPER' => $arr['package_details'],
                            'total' => $arr['total'],
                            'FACTUUROMS' => $arr['description'],
                            'warehouse_price' => $arr['unit_price'],
                        );
                    }
                    //echo '<pre>';
                    //print_r($products);
                    //echo '</pre>';
                    $this->Stock_model->update_new_warehouse_products($products);
                    redirect($this->config->item('admin_folder') . '/stock/view/' . $id);
                }
            }
        } else {

            $this->session->set_flashdata('error', lang('error_not_found'));
            redirect($this->config->item('admin_folder') . '/stock');
        }
    }

    public function update_delivered_order($id = false) {

        force_ssl();
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();

        //$this->load->helper('date');




        if ($id) {

            if (!empty($_POST)) {

                $this->form_validation->set_rules('code', 'lang:code', 'required');


                if ($this->form_validation->run() == FALSE) {

                    $this->form_validation->set_message('required', 'Error Message');
                } else {

                    $order_details['shop_id'] = $this->shop_id;
                    $order_details['id'] = $id;
                    $order_details['order_number'] = $this->input->post('order_number');
                    $order_details['NR'] = $this->input->post('NR');
                    $order_details['supplier_id'] = $this->input->post('supplier_id');
                    $order_details['supplier_name'] = $this->input->post('supplier_name');
                    $order_details['status'] = $this->input->post('status');
                    $order_details['ordered_on'] = $this->input->post('ordered_on');
                    $order_details['arrival_date'] = $this->input->post('arrival_date');
                    $order_details['tax'] = $this->input->post('vat');
                    $order_details['vat'] = $this->input->post('vindex');
                    $order_details['total'] = $this->input->post('gross');
                    $order_details['subtotal'] = $this->input->post('netto');
                    $order_details['shipping_notes'] = $this->input->post('shipping_notes');
                    $entered_by = $this->input->post('entered_by');
                    if (empty($entered_by)) {
                        $order_details['entered_by'] = $this->input->post('entered_by');
                    } else {
                        $order_details['entered_by'] = $this->session->userdata('ba_username');
                    }

                    $this->Stock_model->update_delivered_order($order_details);

                    //echo '<pre>';
                    //print_r($order_details);
                    //echo '</pre>';


                    $key = count($this->input->post('code'));


                    $a_2 = $this->input->post('code');
                    $a_3 = $this->input->post('ordered_quantity');
                    $a_9 = $this->input->post('delivered_quantity');
                    $a_5 = $this->input->post('package_details');
                    $a_6 = $this->input->post('unit_price');
                    $a_4 = $this->input->post('expiration_date');
                    $a_1 = $this->input->post('product_id');


                    for ($i = 0; $i < $key; $i++) {

                        $new_array[] = array(
                            'code' => $a_2[$i],
                            'ordered_quantity' => $a_3[$i],
                            'delivered_quantity' => $a_9[$i],
                            'package_details' => $a_5[$i],
                            'unit_price' => $a_6[$i],
                            'expiration_date' => $a_4[$i],
                            'product_id' => $a_1[$i],
                        );
                    }
                    foreach ($new_array as $arr) {


                        $products[] = array(
                            'NR' => $this->input->post('NR'),
                            'stock_order_id' => $id,
                            'id' => $arr['product_id'],
                            'stock_order_number' => $this->input->post('order_number'),
                            'code' => $arr['code'],
                            'ordered_quantity' => $arr['ordered_quantity'],
                            'delivered_quantity	' => $arr['delivered_quantity'],
                            'package_details' => $arr['package_details'],
                            'expiration_date' => $arr['expiration_date'],
                            'reception_date' => $this->input->post('arrival_date'),
                            'price' => $arr['unit_price'],
                        );
                    }
                    //echo '<pre>';
                    //print_r($products);
                    //echo '</pre>';
                    $this->Stock_model->update_delivered_warehouse_products($products);
                    redirect($this->config->item('admin_folder') . '/stock/view/' . $id);
                }
            }
        } else {

            $this->session->set_flashdata('error', lang('error_not_found'));
            redirect($this->config->item('admin_folder') . '/stock');
        }
    }

    function valid_date($date) {
        $date_format = 'Y-m-d'; /* use dashes - dd/mm/yyyy */

        $date = trim($date);
        /* UK dates and strtotime() don't work with slashes, 
          so just do a quick replace */
        $date = str_replace('/', '-', $date);


        $time = strtotime($date);

        $is_valid = date($date_format, $time) == $date;

        if ($is_valid) {
            return true;
        }


        return false;
    }

    function checkout($id) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['page_title'] = lang('checkout_order');



        $data['shop_index'] = $this->data_shop;
        $data['invoices'] = $this->Invoice_model->get_invoice($id);

        $data['order'] = $this->Stock_model->get_order($id);

        $data['supplier'] = $this->Supplier_model->get_supplier($data['order']->supplier_id);
        $data['vat'] = $data['supplier']->vat;
        $data['order_items'] = $this->Stock_model->get_all_items($id, $data['order']->NR, $data['order']->order_number);

        $order_costs = $this->Stock_model->get_order_costs($id);
        $data['shiping_costs'] = $order_costs['shipping_costs'];
        $data['duties'] = $order_costs['duties'];
        $data['other_costs'] = $order_costs['other_costs'];





        if (!empty($_POST)) {

            $message = $this->session->flashdata('message');




            $this->form_validation->set_rules('number[]', 'lang:number', 'trim|numeric');

            //$this->form_validation->set_rules('batch_number[]','lang:batch_number','trim|numeric');


            if ($this->form_validation->run() == FALSE) {

                $this->session->set_flashdata('error', lang('shipping_costs_error'));
                redirect($this->config->item('admin_folder') . '/stock/checkout/' . $id);
            } else {

                $save['stock_order_id'] = $id;
                $save['shop_id'] = $this->shop_id;
                $save['stock_order_NR'] = $this->input->post('NR');
                $save['order_number'] = $this->input->post('order_number');
                $save['supplier_id'] = $this->input->post('supplier_id');
                $save['supplier_name'] = $this->input->post('supplier_name');
                $save['status'] = $this->input->post('status');
                $save['notes'] = $this->input->post('notes');

                $p_key = count($this->input->post('product_number'));
                $codes = $this->input->post('product_number');
                foreach ($codes as $code) {
                    
                }

                $a_1 = $this->input->post('product_number');
                $a_2 = $this->input->post('number');
                $a_4 = $this->input->post('quantity_recieved');
                $a_5 = $this->input->post('package_details');
                $a_6 = $this->input->post('reseption_date');
                $a_7 = $this->input->post('expiration_date');
                $a_8 = $this->input->post('batch_number');
                $a_9 = $this->input->post('warehouse');
                $a_10 = $this->input->post('warehouse_place');
                $a_11 = $this->input->post('description');


                for ($i = 0; $i < $p_key; $i++) {

                    $product_array[] = array(
                        'product_number' => $a_1[$i],
                        'ordered_quantity' => $a_2[$i],
                        'delivered_quantity' => $a_4[$i],
                        'number_pro_package' => $a_5[$i],
                        'reception_date' => $a_6[$i],
                        'expiration_date' => $a_7[$i],
                        'batch_number' => $a_8[$i],
                        'warehouse' => $a_9[$i],
                        'warehouse_place' => $a_10[$i],
                        'invoice_product_name' => $a_11[$i],
                    );
                }

                $save['product_details'] = serialize($product_array);
                //print_r(serialize($product_array));

                $this->Stock_model->update_stock_order_status(array('stock_order_id' => $id, 'stock_order_NR' => $this->input->post('NR'), 'stock_order_number' => $this->input->post('order_number'), 'status' => $this->input->post('status')));
                $this->Stock_model->checkout_stock($save);

                //echo '<pre>';
                //print_r($save);
                //echo '</pre>';  


                $key = count($this->input->post('product_number'));


                $a_1 = $this->input->post('product_number');
                $a_2 = $this->input->post('number');
                $a_3 = $this->input->post('quantity_recieved');
                $a_4 = $this->input->post('warehouse');
                $a_5 = $this->input->post('warehouse_place');
                $a_6 = $this->input->post('description');
                $a_7 = $this->input->post('batch_number');
                $a_8 = $this->input->post('product_price');

                $a_9 = $this->input->post('reception_date');
                $a_10 = $this->input->post('expiration_date');
                $a_11 = $this->input->post('vpa');


                for ($i = 0; $i < $key; $i++) {

                    $new_array[] = array(
                        'shop_id' => $this->data_shop,
                        'NR' => $this->input->post('NR'),
                        'supplier_id' => $this->input->post('supplier_id'),
                        'stock_order_id' => $id,
                        'stock_order_number' => $this->input->post('order_number'),
                        'batch_number' => $a_7[$i],
                        'code' => $a_1[$i],
                        'ordered_quantity' => $a_2[$i],
                        'delivered_quantity' => $a_3[$i],
                        'price' => $a_8[$i],
                        'warehouse' => $a_4[$i],
                        'warehouse_place' => $a_5[$i],
                        'description' => $a_6[$i],
                        'reception_date' => $a_9[$i],
                        'expiration_date' => $a_10[$i],
                        'package_details' => $a_11[$i],
                    );
                }
                // echo '<pre>';
                // print_r($new_array);
                // echo '</pre>';  


                $this->Stock_model->insert_warehouse_products($new_array);
                //$this->Product_model->update_warehouse_products($product_data);
                redirect($this->config->item('admin_folder') . '/stock', 'refresh');
            }
        }
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/stock_checkout', $data);
    }

    function close_order($id) {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['page_title'] = lang('close_order');

        $data['order'] = $this->Stock_model->get_order($id);
        $data['shop_index'] = $this->data_shop;
        $data['supplier'] = $this->Supplier_model->get_supplier($data['order']->supplier_id);
        $data['vat'] = $data['supplier']->vat;
        $data['order_items'] = $this->Stock_model->get_all_items($id);


        $deliverd_order = $this->Stock_model->get_warehouse_order($id);
        $data['delivered_order'] = unserialize($deliverd_order['product_details']);
        $data['notes'] = $deliverd_order['notes'];

        $data['shiping_costs'] = $deliverd_order['shipping_cost'];
        $data['duties'] = $deliverd_order['duties'];
        $data['other_costs'] = $deliverd_order['other_costs'];


        $g = ($data['shiping_costs'] + $data['duties'] + $data['other_costs']);

        foreach ($data['delivered_order'] as $value) {

            $margin_components = $this->Stock_model->prepare_margin(array('product_code' => $value['product_number'], 'stock_order_id' => $id));
            $margin = ($margin_components['delivered_quantity'] / $g) + $margin_components['price'];
            $margin_data = array('product_code' => $value['product_number'], 'stock_order_id' => $id, 'margin' => $margin);
            $this->Stock_model->update_margin_index($margin_data);
        }

        if ($this->input->post()) {
            if ($this->input->post('close_order') == 1) {
                $data['close_order'] = '1';
                $this->Stock_model->close_order($data['order']->order_number);
                redirect($this->config->item('admin_folder') . '/stock/closed_orders', 'refresh');
            }
        }


        //change the status when closed
        //follow quantity the sum of all quantity in the warehouse
        //follow the margin $this->Stock_model->get_margin($m_data);
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/close_order', $data);
    }

    function set_costs($id = false) {

        $REQEUST_URL = $this->input->post('current_url');

        $this->form_validation->set_rules('shipping_cost', 'lang:shipping_cost', 'trim|numeric');
        $this->form_validation->set_rules('duties', 'lang:duties', 'trim|numeric');
        $this->form_validation->set_rules('other_costs', 'lang:other_costs', 'trim|numeric');


        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error', lang('costs_error'));
            redirect($this->config->item('admin_folder') . '/' . $REQEUST_URL);
        } else {

            $save['shipping_cost'] = $this->input->post('shipping_cost');
            $save['duties'] = $this->input->post('duties');
            $save['other_costs'] = $this->input->post('other_costs');

            $this->Stock_model->update_costs(array(
                'id' => $id,
                'shop_id' => $this->data_shop,
                'shipping_cost' => $this->input->post('shipping_cost'),
                'duties' => $this->input->post('duties'),
                'other_costs' => $this->input->post('other_costs'),
            ));

            redirect($this->config->item('admin_folder') . '/' . $REQEUST_URL);
        }
    }

    public function incoming_stock($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        if ($this->input->post('submit') == 'export') {

            $this->load->model('customer_model');
            $this->load->helper('download_helper');
            $post = $this->input->post(null, false);
            $term = (object) $post;

            $data['orders'] = $this->Order_model->get_orders($term);

            foreach ($data['orders'] as &$o) {
                $o->items = $this->Order_model->get_all_items($o->id);
            }

            force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));
            die;
        }

        $this->load->helper('form');
        $this->load->helper('date');
        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('recent_orders');
        $data['code'] = $code;
        $term = false;

        $post = $this->input->post(null, false);
        if ($post) {

            $term = json_encode($post);
            $code = $this->Search_model->record_term($term);
            $data['code'] = $code;
            //reset the term to an object for use
            $term = (object) $post;
        } elseif ($code) {
            $term = $this->Search_model->get_term($code);
            $term = json_decode($term);
        }

        $data['term'] = $term;
        $shop_id = $this->shop_id;
        $data['orders'] = $this->Order_model->get_orders($term, $sort_by, $sort_order, $rows, $page, $shop_id);
        $data['total'] = $this->Order_model->get_orders_count($term);

        //$data['items']  = $this->Order_model->get_all_items($id);



        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/stock/index/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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

        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));


        $this->load->view($this->config->item('admin_folder') . '/incoming_stock', $data);
    }

    function bulk_delete() {

        $orders = $this->input->post('order');

        if ($orders) {
            foreach ($orders as $order) {
                $this->Stock_model->delete($order);
            }
            $this->session->set_flashdata('message', lang('message_orders_deleted'));
        } else {
            $this->session->set_flashdata('error', lang('error_no_orders_selected'));
        }
        redirect($this->config->item('admin_folder') . '/stock');
    }

    function bulk_delete_delivered() {

        $orders = $this->input->post('order');

        if ($orders) {
            foreach ($orders as $order) {
                $this->Stock_model->delete_delivered($order);
            }
            $this->session->set_flashdata('message', lang('message_orders_deleted'));
        } else {
            $this->session->set_flashdata('error', lang('error_no_orders_selected'));
        }
        redirect($this->config->item('admin_folder') . '/delivered');
    }

    public function concept_orders($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        if ($this->input->post('submit') == 'export') {

            $this->load->model('customer_model');
            $this->load->helper('download_helper');
            $post = $this->input->post(null, false);
            $term = (object) $post;

            $data['orders'] = $this->Order_model->get_orders($term);

            foreach ($data['orders'] as &$o) {
                $o->items = $this->Order_model->get_all_items($o->id);
            }

            force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));
            die;
        }

        $this->load->helper('form');
        $this->load->helper('date');
        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('draft_orders');
        $data['code'] = $code;
        $term = false;

        $post = $this->input->post(null, false);
        if ($post) {

            $term = json_encode($post);
            $code = $this->Search_model->record_term($term);
            $data['code'] = $code;
            //reset the term to an object for use
            $term = (object) $post;
        } elseif ($code) {
            $term = $this->Search_model->get_term($code);
            $term = json_decode($term);
        }

        $data['term'] = $term;
        $data['orders'] = $this->Order_model->get_orders($term, $sort_by, $sort_order, $rows, $page);
        $data['total'] = $this->Order_model->get_orders_count($term);

        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/stock/concept_orders/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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

        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));

        $this->load->view($this->config->item('admin_folder') . '/stock_concept_orders', $data);
    }

    public function reservations($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();




        if ($this->input->post('submit') == 'export') {

            $this->load->model('customer_model');
            $this->load->helper('download_helper');
            $post = $this->input->post(null, false);
            $term = (object) $post;

            $data['orders'] = $this->Order_model->get_orders($term);

            foreach ($data['orders'] as &$o) {
                $o->items = $this->Order_model->get_all_items($o->id);
            }

            force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));
            die;
        }

        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('reservations');
        $data['code'] = $code;
        $term = false;

        $post = $this->input->post(null, false);
        if ($post) {

            $term = json_encode($post);
            $code = $this->Search_model->record_term($term);
            $data['code'] = $code;
            //reset the term to an object for use
            $term = (object) $post;
        } elseif ($code) {
            $term = $this->Search_model->get_term($code);
            $term = json_decode($term);
        }

        $data['term'] = $term;

        $data['reserved_products'] = $this->Stock_model->get_reserved_products($term, $sort_by, $sort_order, $rows, $page, $this->session->userdata('shop'));
        $data['total'] = $this->Stock_model->get_reserved_products_count($term, $this->session->userdata('shop'));

        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/stock/reservations/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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

        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/stock_reservations', $data);
    }

    function reservation($id) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['page_title'] = lang('view_order');

        $data['shopname'] = $this->Shop_model->get_shopname($this->data_shop)->shop_name;



        $this->form_validation->set_rules('notes', 'lang:notes');
        $this->form_validation->set_rules('status', 'lang:status', 'required');


        $message = $this->session->flashdata('message');


        if ($this->form_validation->run() == TRUE) {

            $save = array();
            $save['id'] = $id;
            $save['notes'] = $this->input->post('notes');
            $save['status'] = $this->input->post('status');
            $save['changed_by'] = $this->input->post('changer');
            $save['changed_on'] = date('Y-m-d H:i:s');
            $data['message'] = lang('message_order_updated');
        }

        $data['invoices'] = $this->Invoice_model->get_invoice($id);
        $data['order_items'] = $this->Order_model->get_all_items($id);
        $data['order'] = $this->Order_model->get_order($id);
        $data['invoices'] = $this->Invoice_model->grt_order_invoices($data['order']->order_number);
        $data['saleprice_index'] = strtoupper($data['order']->LANDCODE);
        $c_data = $this->Customer_model->get_country_data_by_index($data['saleprice_index']);
        $data['vat'] = $c_data->tax;
        $data['currency'] = $c_data->currency;
        $data['current_user'] = $this->session->userdata('ba_username');

        $invoice_address = $this->Customer_model->get_invoice_address($data['order']->customer_id);
        //$data['invoice_address'] =  $invoice_address['field_data'];
        $delivery_address = $this->Customer_model->get_delivery_address($data['order']->customer_id);
        // $data['delivery_address'] =  $delivery_address['field_data'];
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/order', $data);
    }

    public function dispatch($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        //new_deliveries = $this->Reservations_model->get_dispatch_new_deliveries();//first table
        //$direct_deliveries = $this->Reservations_model->get_dispatch_new_deliveries();//second table
        //$complete_deliveries = $this->Reservations_model->get_dispatch_complete_deliveries();//third table

        $fixed_deliveries = $this->Reservations_model->get_dispatch_fixed_deliveries(); //four table


        if ($this->input->post('submit') == 'export') {

            $this->load->model('customer_model');
            $this->load->helper('download_helper');
            $post = $this->input->post(null, false);
            $term = (object) $post;

            $data['orders'] = $this->Order_model->get_orders($term);

            foreach ($data['orders'] as &$o) {
                $o->items = $this->Order_model->get_all_items($o->id);
            }

            force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));
            die;
        }

        $this->load->helper('form');
        $this->load->helper('date');
        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('dispatch');
        $data['code'] = $code;
        $term = false;

        $post = $this->input->post(null, false);
        if ($post) {

            $term = json_encode($post);
            $code = $this->Search_model->record_term($term);
            $data['code'] = $code;
            //reset the term to an object for use
            $term = (object) $post;
        } elseif ($code) {
            $term = $this->Search_model->get_term($code);
            $term = json_decode($term);
        }

        $data['term'] = $term;
        $shop_id = $this->shop_id;
        $data['orders'] = $this->Order_model->get_orders($term, $sort_by, $sort_order, $rows, $page, $shop_id);
        $data['total'] = $this->Order_model->get_orders_count($term);

        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/stock/dispatch/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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

        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        //$this->load->view($this->config->item('admin_folder').'/stock_dispatch', $data);
    }

    public function status($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $reservations = $this->Reservations_model->get_shipingstatus();



        /*
          if($this->input->post('submit') == 'export') {

          $this->load->model('customer_model');
          $this->load->helper('download_helper');
          $post	= $this->input->post(null, false);
          $term	= (object)$post;

          $data['orders']	= $this->Order_model->get_orders($term);

          foreach($data['orders'] as &$o){
          $o->items	= $this->Order_model->get_all_items($o->id);
          }

          force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder').'/orders_xml', $data, true));
          die;
          }

          $this->load->helper('form');
          $this->load->helper('date');
          $data['message']	= $this->session->flashdata('message');
          $data['page_title']	= lang('shipping_status');
          $data['code']		= $code;
          $term			= false;

          $post	= $this->input->post(null, false);
          if($post){

          $term		= json_encode($post);
          $code		= $this->Search_model->record_term($term);
          $data['code']	= $code;
          //reset the term to an object for use
          $term	= (object)$post;
          }
          elseif ($code){
          $term	= $this->Search_model->get_term($code);
          $term	= json_decode($term);
          }

          $data['term']	= $term;
          $shop_id = $this->shop_id;
          $data['orders']	= $this->Order_model->get_orders($term, $sort_by, $sort_order, $rows, $page,$shop_id);
          $data['total']	= $this->Order_model->get_orders_count($term);

          $this->load->library('pagination');

          $config['base_url']		= site_url($this->config->item('admin_folder').'/stock/status/'.$sort_by.'/'.$sort_order.'/'.$code.'/');
          $config['total_rows']		= $data['total'];
          $config['per_page']		= $rows;
          $config['uri_segment']		= 7;
          $config['first_link']		= 'First';
          $config['first_tag_open']	= '<li>';
          $config['first_tag_close']	= '</li>';
          $config['last_link']		= 'Last';
          $config['last_tag_open']	= '<li>';
          $config['last_tag_close']	= '</li>';

          $config['full_tag_open']	= '<div class="pagination"><ul>';
          $config['full_tag_close']	= '</ul></div>';
          $config['cur_tag_open']		= '<li class="active"><a href="#">';
          $config['cur_tag_close']	= '</a></li>';

          $config['num_tag_open']		= '<li>';
          $config['num_tag_close']	= '</li>';

          $config['prev_link']		= '&laquo;';
          $config['prev_tag_open']	= '<li>';
          $config['prev_tag_close']	= '</li>';

          $config['next_link']		= '&raquo;';
          $config['next_tag_open']	= '<li>';
          $config['next_tag_close']	= '</li>';

          $this->pagination->initialize($config);

          $data['sort_by']	= $sort_by;
          $data['sort_order']	= $sort_order;

          $this->auth->check_access('Admin', true);
          $this->current_admin	= $this->session->userdata('admin');
          $data['admins']	= $this->auth->get_admin_list();


          $this->load->view($this->config->item('admin_folder').'/stock_status', $data);



         * 
         */
    }

    public function bulk_save() {

        //function for update
        $orders = $this->input->post('order');
        if (!$orders) {

            $this->session->set_flashdata('error', lang('error_bulk_no_products'));
            redirect($this->config->item('admin_folder') . '/stock');
        }
        foreach ($orders as $id => $order) {
            $order['id'] = $id;
            $this->Order_model->save($product);
        }
        $this->session->set_flashdata('message', lang('message_bulk_update'));
        redirect($this->config->item('admin_folder') . '/stock');
    }

    public function edit_shippment($id) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $this->load->helper('form');
        $this->load->helper('date');
        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('shipping_status');




        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/stock_shipping_edit', $data);
    }

    public function backorder_old($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $backorders = $this->Reservations_model->get_backorder_list();
        /*
          if($this->input->post('submit') == 'export') {

          $this->load->model('customer_model');
          $this->load->helper('download_helper');
          $post	= $this->input->post(null, false);
          $term	= (object)$post;

          $data['orders']	= $this->Order_model->get_orders($term);

          foreach($data['orders'] as &$o){
          $o->items	= $this->Order_model->get_all_items($o->id);
          }

          force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder').'/orders_xml', $data, true));
          die;
          }

          $this->load->helper('form');
          $this->load->helper('date');
          $data['message']	= $this->session->flashdata('message');
          $data['page_title']	= lang('backorder');
          $data['code']		= $code;
          $term			= false;

          $post	= $this->input->post(null, false);
          if($post){

          $term		= json_encode($post);
          $code		= $this->Search_model->record_term($term);
          $data['code']	= $code;
          //reset the term to an object for use
          $term	= (object)$post;
          }
          elseif ($code){
          $term	= $this->Search_model->get_term($code);
          $term	= json_decode($term);
          }

          $data['term']	= $term;
          $shop_id = $this->shop_id;
          $data['orders']	= $this->Order_model->get_orders($term, $sort_by, $sort_order, $rows, $page,$shop_id);
          $data['total']	= $this->Order_model->get_orders_count($term);

          $this->load->library('pagination');

          $config['base_url']		= site_url($this->config->item('admin_folder').'/stock/backorder/'.$sort_by.'/'.$sort_order.'/'.$code.'/');
          $config['total_rows']		= $data['total'];
          $config['per_page']		= $rows;
          $config['uri_segment']		= 7;
          $config['first_link']		= 'First';
          $config['first_tag_open']	= '<li>';
          $config['first_tag_close']	= '</li>';
          $config['last_link']		= 'Last';
          $config['last_tag_open']	= '<li>';
          $config['last_tag_close']	= '</li>';

          $config['full_tag_open']	= '<div class="pagination"><ul>';
          $config['full_tag_close']	= '</ul></div>';
          $config['cur_tag_open']		= '<li class="active"><a href="#">';
          $config['cur_tag_close']	= '</a></li>';

          $config['num_tag_open']		= '<li>';
          $config['num_tag_close']	= '</li>';

          $config['prev_link']		= '&laquo;';
          $config['prev_tag_open']	= '<li>';
          $config['prev_tag_close']	= '</li>';

          $config['next_link']		= '&raquo;';
          $config['next_tag_open']	= '<li>';
          $config['next_tag_close']	= '</li>';

          $this->pagination->initialize($config);

          $data['sort_by']	= $sort_by;
          $data['sort_order']	= $sort_order;

          $this->auth->check_access('Admin', true);
          $this->current_admin	= $this->session->userdata('admin');
          $data['admins']	= $this->auth->get_admin_list();


          $this->load->view($this->config->item('admin_folder').'/stock_backorder', $data);
         * 
         */
    }

    public function old_dispatches($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        if ($this->input->post('submit') == 'export') {

            $this->load->model('customer_model');
            $this->load->helper('download_helper');
            $post = $this->input->post(null, false);
            $term = (object) $post;

            $data['orders'] = $this->Order_model->get_orders($term);

            foreach ($data['orders'] as &$o) {
                $o->items = $this->Order_model->get_all_items($o->id);
            }

            force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));
            die;
        }

        $this->load->helper('form');
        $this->load->helper('date');
        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('old_dispatches');
        $data['code'] = $code;
        $term = false;

        $post = $this->input->post(null, false);
        if ($post) {

            $term = json_encode($post);
            $code = $this->Search_model->record_term($term);
            $data['code'] = $code;
            //reset the term to an object for use
            $term = (object) $post;
        } elseif ($code) {
            $term = $this->Search_model->get_term($code);
            $term = json_decode($term);
        }

        $data['term'] = $term;
        $shop_id = $this->shop_id;
        $data['orders'] = $this->Order_model->get_orders($term, $sort_by, $sort_order, $rows, $page, $shop_id);
        $data['total'] = $this->Order_model->get_orders_count($term);

        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/stock/old_dispatches/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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

        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/stock_old_dispatch', $data);
    }

    public function stock_check_out($order_by = "name", $sort_order = "ASC", $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['page_title'] = lang('stock_check_out');
        $data['code'] = $code;
        $term = $this->term;
        $category_id = $this->category_id;

        //category list for the drop menu
        $data['categories'] = $this->categories;
        $post = $this->post;

        if ($post) {
            $term = json_encode($post);
            $code = $this->Search_model->record_term($term);
            $data['code'] = $code;
        } elseif ($code) {
            $term = $this->Search_model->get_term($code);
        }

        //store the search term
        $data['term'] = $term;
        $data['order_by'] = $order_by;

        $data['sort_order'] = $sort_order;

        $data['products'] = $this->Product_model->products(array('term' => $term, 'order_by' => $order_by, 'sort_order' => $sort_order, 'rows' => $rows, 'page' => $page, 'shop_id' => $this->shop_id));

        //total number of products
        $data['total'] = $this->Product_model->products(array('term' => $term, 'order_by' => $order_by, 'sort_order' => $sort_order), true);

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/stock/stock_check_out/' . $order_by . '/' . $sort_order . '/' . $code . '/');
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

        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/stock_check_out', $data);
    }

    public function movements($order_by = "name", $sort_order = "ASC", $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['page_title'] = lang('stock_check_out');
        $data['code'] = $code;
        $term = $this->term;
        $category_id = $this->category_id;

        $data['categories'] = $this->categories;
        $post = $this->post;

        if ($post) {
            $term = json_encode($post);
            $code = $this->Search_model->record_term($term);
            $data['code'] = $code;
        } elseif ($code) {
            $term = $this->Search_model->get_term($code);
        }

        $data['term'] = $term;
        $data['order_by'] = $order_by;
        $data['sort_order'] = $sort_order;

        $data['products'] = $this->Product_model->products(array('term' => $term, 'order_by' => $order_by, 'sort_order' => $sort_order, 'rows' => $rows, 'page' => $page, 'shop_id' => $this->shop_id));

        $data['total'] = $this->Product_model->products(array('term' => $term, 'order_by' => $order_by, 'sort_order' => $sort_order), true);

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/stock/movements/' . $order_by . '/' . $sort_order . '/' . $code . '/');
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
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));


        $this->load->view($this->config->item('admin_folder') . '/stock_movements', $data);
    }

    function start_order($id = false) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        force_ssl();
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['page_title'] = lang('order_in_process');
        $data['shop_id'] = $this->shop_id;

        if ($id) {

            $supplier = $this->Supplier_model->get_supplier($id);
            $data['supplier_products'] = $this->Supplier_model->get_supplier_products($id);

            $data['id'] = $supplier->id;
            $data['group_id'] = $supplier->group_id;
            $data['current_user'] = $this->session->userdata('ba_username');
            $data['supplier'] = $supplier->company;
            $data['vat'] = $supplier->vat;
            $data['order_date'] = date('Y-m-d');
            $timeid = $this->uri->segment(5);
            if ($timeid == 0) {
                $time = time();
            } else {
                $time = $timeid;
            }
            $data['weather'] = _date($time);
            $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));

            $this->load->view($this->config->item('admin_folder') . '/stock_new_order', $data);
        } else {
            $this->session->set_flashdata('error', lang('error_not_found'));
            redirect($this->config->item('admin_folder') . '/suppliers');
        }
    }

    public function preview_order($id = false) {
	
			if (!$this->bitauth->logged_in()) {
				$this->session->set_userdata('redir', current_url());
				redirect($this->config->item('admin_folder') . '/admin/login');
			}
			
			force_ssl();
			$data['categories'] 	= $this->categories;
			$data['groups'] 		= $this->groups;
			$data['products'] 		= $this->products;
			$data['all_shops'] 		= $this->Shop_model->get_shops();


        if (!empty($id)) {

            $data['id'] = $id;
            $data['order_date'] 	= $this->input->post('order_date');
            $supplier 				= $this->Supplier_model->get_the_supplier($id);
            $data['supplier'] 		= $supplier->company;
            $data['vat_index'] 		= $supplier->vat;
            $data['vat'] 			= $this->input->post('vat');
            $data['current_user'] 	= $this->session->userdata('ba_username');


            $data['unit_price'] 	= $this->input->post('unit_price');
            $data['discount'] 		= $this->input->post('discount');
            $data['ordered_quantity'] = $this->input->post('number');

            $key = count($this->input->post('product_number'));

            $a_1 = $this->input->post('number');
            $a_2 = $this->input->post('unit_price');
            $a_3 = $this->input->post('product_number');


            for ($i = 0; $i < $key; $i++) {

                $new_array_1[] = array(
                    'ordered_quantity' => $a_1[$i],
                    'unit_price' => $a_2[$i],
                    'code' => $a_3[$i],
                );
            }

            $nums = $this->input->post('product_number');
            $f = array();
            foreach ($nums as $num) {

                if ($this->data_shop == 3) {
                    $f[] = $this->Product_model->select_order_product(33, $num);
                } else {
                    $f[] = $this->Product_model->select_order_product($this->shop_id, $num);
                }
            }
            //print_r($f);
            $f = json_decode(json_encode($f), true);
            $product_array = array();

            for ($i = 0; $i < $key; $i++) {

                $product_array[] = array_merge($new_array_1[$i], $f[$i]);
            }

            $data['product_array'] = $product_array;


            $timeid = $this->uri->segment(5);
            if ($timeid == 0) {
                $time = time();
            } else {
                $time = $timeid;
            }
            $data['weather'] = _date($time);
            $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
            $this->load->view($this->config->item('admin_folder') . '/stock_new_order_1', $data);
        } else {

            $this->session->set_flashdata('error', lang('error_not_found'));
            redirect($this->config->item('admin_folder') . '/customers');
        }
    }

    public function submit_order($id = false) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        force_ssl();
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['page_title'] = 'Order in process';
        $this->load->helper('string');


        if ($id) {

            $supplier = $this->Supplier_model->get_supplier($id);
            $data['id'] = $id;

            if (!empty($_POST)) {

                $this->form_validation->set_rules('product_number', 'lang:product_number', 'required');
                //$this->form_validation->set_rules('arrival_date', 'lang:arrival_date', 'required');

                if ($this->form_validation->run() == FALSE) {

                    $this->form_validation->set_message('required', 'Error Message');
                } else {

                    $order_details['shop_id'] = $this->shop_id;
                    $last_id = $this->Stock_model->get_last_order_id();
                    $last_number = $this->Stock_model->get_last_order($last_id['id']);
                    $order_details['order_number'] = $last_number['order_number'] + 1;
                    $order_details['NR'] = $last_number['NR'] + 1;
                    $order_details['supplier_id'] = $id;
                    $order_details['supplier_name'] = $this->input->post('supplier_name');
                    $order_details['status'] = '0';
                    $order_details['ordered_on'] = date('Y-m-d');
                    $order_details['arrival_date'] = $this->input->post('arrival_date');
                    $order_details['tax'] = $this->input->post('vat');
                    $order_details['vat'] = $this->input->post('vindex');
                    $order_details['total'] = $this->input->post('gross');
                    $order_details['subtotal'] = $this->input->post('netto');
                    $order_details['shipping_notes'] = $this->input->post('shipping_notes');
                    $order_details['entered_by'] = $this->session->userdata('ba_username');

                    $this->Stock_model->insert_order($order_details);
                    $order_id = $this->db->insert_id();

                    //echo '<pre>';
                    //print_r($order_details);
                    //echo '</pre>';








                    $key = count($this->input->post('number'));


                    $a_1 = $this->input->post('product');
                    $a_2 = $this->input->post('product_number');
                    $a_3 = $this->input->post('number');
                    $a_4 = $this->input->post('min_stock');
                    $a_5 = $this->input->post('vpa');
                    $a_6 = $this->input->post('vk');
                    $a_7 = $this->input->post('total');
                    $a_8 = $this->input->post('description');

                    for ($i = 0; $i < $key; $i++) {

                        $new_array[] = array(
                            'product' => $a_1[$i],
                            'product_number' => $a_2[$i],
                            'number' => $a_3[$i],
                            'min_stock' => $a_4[$i],
                            'vpa' => $a_5[$i],
                            'vk' => $a_6[$i],
                            'total' => $a_7[$i],
                            'description' => $a_8[$i],
                        );
                    }
                    foreach ($new_array as $arr) {



                        $products[] = array(
                            'NR' => $order_details['NR'],
                            'order_id' => $order_id,
                            'order_number' => $order_details['order_number'],
                            'ARTIKELCOD' => $arr['product_number'],
                            'AANTALBEST' => $arr['number'],
                            'MINAANTALV' => $arr['min_stock'],
                            'CAANTALPER' => $arr['vpa'],
                            'total' => $arr['total'],
                            'FACTUUROMS' => $arr['description'],
                            'product_id' => $arr['product'],
                            'warehouse_price' => $arr['vk'],
                            'ARTIKELCOD' => $arr['product_number'],
                        );
                    }
                    //echo '<pre>';
                    //print_r($products);
                    //echo '</pre>';
                    $this->Stock_model->insert_order_products($products);
                    redirect($this->config->item('admin_folder') . '/suppliers/form/' . $id);
                }
            }
        } else {
            $this->session->set_flashdata('error', lang('error_not_found'));
            redirect($this->config->item('admin_folder') . '/customers');
        }
    }

    function open_product($code) {

        $id = $this->Product_model->get_id($code, $this->shop_id);

        if ($id->id) {
            redirect($this->config->item('admin_folder') . '/products/form/' . $id->id);
        } else {

            $second_id = $this->Product_model->get_second_id($code);
            redirect($this->config->item('admin_folder') . '/products/old_product_form/' . $second_id->NR);
            if (empty($second_id->NR)) {
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    //THE CLASS END
}
