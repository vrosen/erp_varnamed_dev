<?php

class Orders extends CI_Controller {

    protected $shop_id;
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
        $this->load->model(array('Order_model', 'Group_model', 'Category_model', 'Shop_model'));
        $this->load->model('Customer_model');
        $this->load->model('Product_model');
        $this->load->model('Search_model');
        $this->load->model('Stock_model');
        $this->load->model('location_model');
        $this->load->model('Messages_model');
        $this->load->model('Gift_card_model');
        $this->load->model('Invoice_model');
        $this->load->model('Part_model');
        ////////////////////////////////////////////////////////////////
        $this->load->helper(array('formatting'));
        $this->load->helper(array('form', 'date', 'file'));
        $this->load->helper('form');
        ////////////////////////////////////////////////////////////////
        $this->shop_id = $this->session->userdata('shop');
        $this->language = $this->session->userdata('language');
        $this->data_shop = $this->session->userdata('shop');
        ////////////////////////////////////////////////////////////////
        $this->lang->load('order', $this->language);
        $this->lang->load('dashboard', $this->language);
        $this->lang->load('customer', $this->language);
        $this->lang->load('invoices', $this->language);
        ////////////////////////////////////////////////////////////////
        $this->groups = $this->Group_model->get_all_the_groups();
        $this->products = $this->Product_model->get_all_products();
        $this->categories = $this->Category_model->get_all_categories();
        ////////////////////////////////////////////////////////////////
        $this->load->library('form_validation');
    }

    function index($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 150) {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();


        $data['current_shop'] = $this->data_shop;
        //if they submitted an export form do the export
        if ($this->input->post('submit') == 'export') {

            $this->load->model('customer_model');
            $this->load->helper('download_helper');
            $post = $this->input->post(null, false);
            $term = (object) $post;

            $data['orders'] = $this->Order_model->get_orders($term);

            foreach ($data['orders'] as &$o) {
                $o->items = $this->Order_model->get_items($o->id);
            }

            force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));

            //kill the script from here
            die;
        }

        $this->load->helper('form');
        $this->load->helper('date');
        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('orders');
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
        $shop_id = $this->shop_id;
        $order_status = '1';

        $data['term'] = $term;

        $data['orders_verzending'] = $this->Order_model->get_verzending_orders($this->shop_id);

        foreach ($data['orders_verzending'] as $ver) {

            $verz[$ver['ORDERNR']] = array($ver['VERZENDNR']);
        }
        $data['verzendung'] = $verz;

        $data['orders'] = $this->Order_model->get_new_orders($term, $sort_by, $sort_order, $rows, $page, $shop_id, $order_status);
        $data['back_orders'] = $this->Order_model->get_new_orders_with_backorders($term, $sort_by, $sort_order, $rows, $page, $shop_id, $order_status);
        $data['total'] = $this->Order_model->get_orders_count($term);

        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/orders/index/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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

        $this->load->view($this->config->item('admin_folder') . '/orders', $data);
    }

    function orders_to_ship($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['current_shop'] = $this->data_shop;

        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('orders_for_ship');
        $data['code'] = $code;
        $term = false;
        $data['order_status'] = $this->input->post('status');

        $data['orders_verzending'] = $this->Order_model->get_verzending_orders($this->shop_id);

        foreach ($data['orders_verzending'] as $ver) {

            $verz[$ver['ORDERNR']] = array($ver['VERZENDNR']);
        }
        $data['verzendung'] = $verz;

        $data['orders'] = $this->Order_model->get_orders_to_ship($this->session->userdata('shop'));

        $data['total'] = $this->Order_model->get_orders_count($term);

        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/orders/orders_to_ship/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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
        $this->load->view($this->config->item('admin_folder') . '/orders_to_ship', $data);
    }

    function processed_orders($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }




        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        //if they submitted an export form do the export
        if ($this->input->post('submit') == 'export') {
            $this->load->model('customer_model');
            $this->load->helper('download_helper');
            $post = $this->input->post(null, false);
            $term = (object) $post;

            $data['orders'] = $this->Order_model->get_orders($term);

            foreach ($data['orders'] as &$o) {
                $o->items = $this->Order_model->get_items($o->id);
            }

            force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));

            //kill the script from here
            die;
        }

        $this->load->helper('form');
        $this->load->helper('date');
        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('processed_orders');
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
        $shop_id = $this->shop_id;
        $data['order_status'] = $this->input->post('status');
        $data['term'] = $term;


        $data['orders'] = $this->Order_model->get_processed_orders($term, $sort_by, $sort_order, $rows, $page, $shop_id);
        $data['total'] = $this->Order_model->get_orders_count($term);

        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/orders/processed_orders/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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
        $this->load->view($this->config->item('admin_folder') . '/processed_orders', $data);
    }

    function all_orders($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        //if they submitted an export form do the export
        if ($this->input->post('submit') == 'export') {
            $this->load->model('customer_model');
            $this->load->helper('download_helper');
            $post = $this->input->post(null, false);
            $term = (object) $post;

            $data['orders'] = $this->Order_model->get_orders($term);

            foreach ($data['orders'] as &$o) {
                $o->items = $this->Order_model->get_items($o->id);
            }

            force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));

            //kill the script from here
            die;
        }

        $this->load->helper('form');
        $this->load->helper('date');
        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('all_orders');
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
        $shop_id = $this->shop_id;

        $data['order_status'] = $this->input->post('status');
        $data['term'] = $term;

        $order_status = $this->input->post('status');

        $data['orders'] = $this->Order_model->get_list_orders($term, $sort_by, $sort_order, $rows, $page, $shop_id, $order_status);
        $data['total'] = $this->Order_model->get_orders_count($term);

        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/orders/all_orders/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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
        $this->load->view($this->config->item('admin_folder') . '/all_orders', $data);
    }

    public function backorder($sort_by = 'product_code', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['page_title'] = lang('backorder');


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



        $data['backorders'] = $this->Order_model->get_backorder_list($term, $sort_by, $sort_order, $rows, $page, $shop_id);
        $data['total'] = $this->Order_model->get_backorder_list($term);
        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/orders/backorder/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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
        $this->load->view($this->config->item('admin_folder') . '/backorder_list', $data);
    }

    function transfer_backorder() {
        //only when moving the db from Meindert to us

        $this->Order_model->transfer_backorders();
    }

    function export() {
        $this->load->model('customer_model');
        $this->load->helper('download_helper');
        $post = $this->input->post(null, false);
        $term = (object) $post;

        $data['orders'] = $this->Order_model->get_orders($term);

        foreach ($data['orders'] as &$o) {
            $o->items = $this->Order_model->get_items($o->id);
        }
        force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));
    }

    function check($id) {
        echo $id;
    }

    public function remove($order_id, $product_id) {


        $this->Order_model->remove_item($product_id, $order_id, $this->shop_id);
        redirect($this->config->item('admin_folder') . '/orders/view/' . $order_id);
    }

    public function view($id) {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        if (!empty($this->session->userdata('back'))) {
            $this->session->unset_userdata('back');
        }
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['page_title'] = lang('view_order');

        $data['shopname'] = $this->Shop_model->get_shopname($this->data_shop)->shop_name;
        $data['current_shop'] = $this->shop_id;

        $data['order'] = $this->Order_model->get_order($id);
        $data['order_id'] = $id;

        //$data['invoices']     = $this->Invoice_model->get_invoice($id);
        $data['order_items'] = $this->Order_model->get_all_items($data['order']->NR, $id);
        $data['invoices'] = $this->Invoice_model->grt_order_invoices($data['order']->order_number);
        $data['verzending'] = $this->Order_model->get_verzending($data['order']->order_number, $this->shop_id);

        $data['saleprice_index'] = strtoupper($data['order']->country_id);
        $c_data = $this->Customer_model->get_country_data_by_index($data['saleprice_index']);
        $data['current_user'] = $this->session->userdata('ba_username');

        $client_details_sys = $this->Customer_model->get_client_details_NR($data['order']->customer_id);
        $data['id'] = $client_details_sys['id'];
        $data['NR'] = $client_details_sys['NR'];
        $data['info'] = $client_details_sys['customer_info'];
        if (empty($client_details_sys)) {
            $client_details_web = $this->Customer_model->get_client_details_ID($data['order']->customer_id);
            $data['id'] = $client_details_web['id'];
            $data['NR'] = $client_details_web['NR'];
            $data['info'] = $client_details_web['customer_info'];
        }
        $data['invoice_address'] = $this->Order_model->get_invoice_adres($data['order']->customer_id, $this->session->userdata('shop')); //adres
        $data['delivery_address'] = $this->Order_model->get_delivery_adres($data['order']->customer_id, $this->session->userdata('shop')); //adres


        $data['VAT_N'] = '';
        $data['VAT_D'] = '';
        $data['n_vat'] = array();
        $data['d_vat'] = array();
        $data['shipping_costs'] = $data['order']->shipping;
        $data['vat_shipping_costs'] = '';
        $data['vat_shipping_costs_d'] = '';




        if ($data['order']->dropshipment == 1) {

            if (!empty($data['order']->drop_shipment_address)) {
                $data['drop_shipment_address'] = unserialize($data['order']->drop_shipment_address);
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
        $this->load->view($this->config->item('admin_folder') . '/order', $data);
    }

    public function verzending($id) {


        $data['customers'] = $this->Order_model->get_all_customers($this->shop_id);
        $data['shipment'] = $this->Order_model->get_shipment($id, $this->shop_id);

        $data['order'] = $this->Order_model->get_order_verzending($data['shipment']->ORDERNR, $this->shop_id);

        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));

        $this->load->view($this->config->item('admin_folder') . '/shipment', $data);
    }

    function order_details($id) {

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
        $data['current_shop'] = $this->data_shop;


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

            //create the arrays for update
            $data['message'] = lang('message_order_updated');

            //$this->Order_model->save_order($save);
        }
        $data['order'] = $this->Order_model->get_order($id);
        $data['invoices'] = $this->Invoice_model->get_invoice($id);
        $data['order_items'] = $this->Order_model->get_all_items_for_ship($data['order']->NR, $data['order']->order_number, $this->shop_id);



        $data['invoices'] = $this->Invoice_model->grt_order_invoices($data['order']->order_number);

        $msg_templates = $this->Messages_model->get_list('order');

        $data['saleprice_index'] = strtoupper($data['order']->country_id);
        $c_data = $this->Customer_model->get_country_data_by_index($data['saleprice_index']);
        $data['current_user'] = $this->session->userdata('ba_username');
        /*         * ************************************************************************************************************************** */

        $client_details_sys = $this->Customer_model->get_client_details_NR($data['order']->customer_id);
        $client_details_web = $this->Customer_model->get_client_details_ID($data['order']->customer_id);

        if (!empty($client_details_sys)) {

            $data['id'] = $client_details_sys['id'];
            $data['NR'] = $client_details_sys['NR'];
            $data['info'] = $client_details_sys['customer_info'];

            $data['invoice_address_1'] = unserialize($data['order']->invoice_address);
            $data['invoice_address_2'] = $this->Customer_model->get_invoice_address_new($client_details_sys['NR']);
            $data['delivery_address_1'] = unserialize($data['order']->delivery_address);
            $data['delivery_address_2'] = $this->Customer_model->get_delivery_address_new($client_details_sys['NR']);
        }

        //when from the webshop 
        if (!empty($client_details_web)) {

            $data['id'] = $client_details_web['id'];
            $data['NR'] = $client_details_web['NR'];
            $data['info'] = $client_details_web['customer_info'];

            $data['invoice_address_1'] = unserialize($data['order']->invoice_address);
            $data['invoice_address_2'] = $this->Customer_model->get_invoice_address_new($client_details_web['NR']);
            $data['delivery_address_1'] = unserialize($data['order']->delivery_address);
            $data['delivery_address_2'] = $this->Customer_model->get_delivery_address_new($client_details_web['NR']);
        }

        if (empty($data['invoice_address'])) {
            $data['company'] = $data['order']->company;
            $data['firstname'] = $data['order']->firstname;
            $data['lastname'] = $data['order']->lastname;
            $data['address1'] = $data['order']->address1;
            $data['address2'] = $data['order']->address2;
            $data['zip'] = $data['order']->zip;
            $data['city'] = $data['order']->city;
            $data['country'] = $data['order']->country;
        }


        if ($data['order']->dropshipment == 1) {

            if (!empty($data['order']->drop_shipment_address)) {
                $data['drop_shipment_address'] = unserialize($data['order']->drop_shipment_address);
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
        $this->load->view($this->config->item('admin_folder') . '/order_details', $data);
    }

    public function packing_slip($order_id) {

        //packing_slip

        $this->load->helper('date');
        $this->load->library('parser');
        $this->load->library('labels');

        $filename = $order_id . '.doc';
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=" . $filename);
        header("Content-Type: application/vnd.ms-word.main+xml");
        header("Content-Transfer-Encoding: binary");

        $data['shop_id'] = $this->shop_id;
        $primary_data['order'] = $this->Order_model->get_order_word($order_id);
        $data['order_items'] = $this->Order_model->get_all_items_word($primary_data['order']['NR'], $order_id);



        if ($primary_data['order']['dropshipment'] == 1) {
            if (!empty($primary_data['order']->drop_shipment_address)) {
                $primary_data['delivery_address'] = unserialize($primary_data['order']->drop_shipment_address);
            }
        } else {
            if (!empty($primary_data['order']->delivery_address)) {
                $primary_data['delivery_address'] = unserialize($primary_data['order']->delivery_address);
            }
        }

        $delivery_address = $this->Order_model->get_delivery_adres($primary_data['order']['customer_id'], $this->session->userdata('shop'));

        if (empty($delivery_address['NAAM1']) or empty($delivery_address['HUISNR']) or empty($delivery_address['POSTCODE']) or empty($delivery_address['PLAATS']) or empty($delivery_address['LAND'])) {
            $this->session->set_flashdata('missing_address', 'Delivery address is missing!');
            redirect($this->config->item('admin_folder') . '/orders/orders_to_ship');
        } else {

            $data['c_name'] = $delivery_address['NAAM1'];
            $data['c_street'] = $delivery_address['STRAAT'];
            $data['c_street_nr'] = $delivery_address['HUISNR'];
            $data['c_zip'] = $delivery_address['POSTCODE'];
            $data['c_city'] = $delivery_address['PLAATS'];
            $data['c_country'] = $delivery_address['LAND'];

            $data['order_number'] = $primary_data['order']['order_number'];
            $data['order_date'] = $primary_data['order']['ordered_on'];
            $data['shipped_on'] = $primary_data['order']['shipped_on'];
            $data['customer_number'] = $primary_data['order']['customer_id'];
            $data['agent'] = $primary_data['order']['entered_by'];
            $data['carrier'] = strtoupper($primary_data['order']['carrier']);


            $ccode = strtoupper($delivery_address['LANDCODE']);

            $company_address = $this->Order_model->get_address($delivery_address['LANDCODE'], $this->shop_id);
            $c_address = unserialize($company_address['address']);
            //print_r($c_address);
            $data['our_name'] = $c_address['company_name'] . strtolower($delivery_address['LANDCODE']);
            $data['our_street'] = $c_address['street'];
            $data['our_street_number'] = $c_address['street_number'];
            $data['our_zip'] = $c_address['zip'];
            $data['our_city'] = $c_address['city'];
            $data['our_phone'] = $c_address['phone'];
            $data['our_email'] = $c_address['email'];
            $data['our_website'] = $c_address['website'];



            $data['company_bank_info'] = $this->Order_model->get_bank($delivery_address['LANDCODE'], $this->shop_id);
            $data['bank_details'] = unserialize($data['company_bank_info']['account']);

            $c_id = $delivery_address['LANDCODE'];

            if ($c_id == 'NL' or $c_id == 'BE') {

                $data['packing_slip'] = 'Pakbon';
                $data['order_nr'] = 'Order nr.';
                $data['client_nr'] = 'Klant nr.';
                $data['bestel_nr'] = 'Bestel nr.';
                $data['agent'] = 'Behandeld door';
                $data['vat'] = 'BTW';
                $data['date'] = 'Datum';
                $data['product_nr'] = 'Art. nr.';
                $data['description'] = 'Omschrijving';
                $data['quantity'] = 'Geleverd';
                $data['q_per_package'] = 'Aantal per verpakking';
                $data['weight'] = 'Gewicht';
                $data['sent_with'] = 'Verzonden met';
                $data['send_date'] = 'Verzenddatum';
            }
            if ($c_id == 'FR' or $c_id == 'LX' or $c_id == 'BEL') {

                $data['packing_slip'] = 'Bordereau d`expédition';
                $data['order_nr'] = 'Nº d`ordre';
                $data['client_nr'] = 'Nº de client';
                $data['bestel_nr'] = 'Nº de commande';
                $data['agent'] = 'Traité par';
                $data['vat'] = 'TVA';
                $data['date'] = 'Date';
                $data['product_nr'] = 'Article';
                $data['description'] = 'Détail';
                $data['quantity'] = 'Nombre';
                $data['q_per_package'] = 'Nombre par carton';
                $data['weight'] = 'Poids';
                $data['sent_with'] = 'Envoyé avec';
                $data['send_date'] = 'Date d`expédition';
            }
            if ($c_id == 'DE' or $c_id == 'AU' or $c_id == 'AT') {

                $data['packing_slip'] = 'Packzettel';
                $data['order_nr'] = 'Auftrags-Nr.';
                $data['client_nr'] = 'Kunden-Nr.';
                $data['bestel_nr'] = 'Bestell-Nr.';
                $data['agent'] = 'Bearbeiter(in)';
                $data['vat'] = 'MwSt.';
                $data['date'] = 'Datum';
                $data['product_nr'] = 'Art-Nr';
                $data['description'] = 'Beschreibung';
                $data['quantity'] = 'Liefermenge';
                $data['q_per_package'] = 'Anzahl pro Verpackung';
                $data['weight'] = 'Gewicht';
                $data['sent_with'] = 'Geschickt mit';
                $data['send_date'] = 'Versanddatum';
            }
            if ($c_id == 'UK') {

                $data['packing_slip'] = 'Packing slip';
                $data['order_nr'] = 'Order no.';
                $data['client_nr'] = 'Client no.';
                $data['bestel_nr'] = 'Part no.';
                $data['agent'] = 'Processed by';
                $data['vat'] = 'VAT';
                $data['date'] = 'Date';
                $data['product_nr'] = 'Article no.';
                $data['description'] = 'Description';
                $data['quantity'] = 'Delivered';
                $data['q_per_package'] = 'Packaging unit';
                $data['weight'] = 'Weight';
                $data['sent_with'] = 'Carrier';
                $data['send_date'] = 'Dispatch date';
            }
            //echo '<pre>';
            //print_r($data);
            //echo '</pre>';



            $this->Order_model->set_printed($order_id, $this->session->userdata('shop'));
            $this->load->view($this->config->item('admin_folder') . '/print_slip', $data);
        }
    }

    function print_label($order_id) {

        $order = $this->Order_model->get_order($order_id);

        if ($order->dropshipment == 1) {
            if (!empty($order->drop_shipment_address)) {
                $delivery_address = unserialize($order->drop_shipment_address);
            }
        }

        $delivery_address = $this->Order_model->get_delivery_adres($order->customer_id, $this->session->userdata('shop'));

        if (empty($delivery_address['NAAM1']) or empty($delivery_address['STRAAT']) or empty($delivery_address['POSTCODE']) or empty($delivery_address['PLAATS']) or empty($delivery_address['LAND'])) {
            $this->session->set_flashdata('empty_address', 'Please fill delivery address correctly for order' . ' - ' . $order->order_number);
            redirect($this->config->item('admin_folder') . '/orders/orders_to_ship/');
        } else {

            $file_name = 'dpd_' . date('Ymd') . $order_details->order_number;
            if (!empty($delivery_address)) {

                $dpd_row = '"' . $delivery_address['NAAM1'] . $delivery_address['NAAM2'] . '"' . ';' . '"' . $delivery_address['NAAM3'] . '"' . ';' . '"' . '"' . ';' . '"' . $delivery_address['STRAAT'] . $delivery_address['HUISNR'] . '"' . ';' . '"' . strtoupper($delivery_address['LANDCODE']) . '"' . ';' . '"' . $delivery_address['POSTCODE'] . '"' . ';' . '"' . $delivery_address['PLAATS'] . '"' . ';' . '"' . $order->order_number . '"' . ';' . '"' . strtoupper($delivery_address['LANDCODE']) . '"' . ';' . '"' . $order->parcel_number . '"';
            }

            if ($this->shop_id == 1) {
                $fp = fopen(FCPATH . "dpd/Comforties/" . $file_name . ".txt", "wb");
                fwrite($fp, $dpd_row);
                fclose($fp);
            }
            if ($this->shop_id == 2) {
                $fp = fopen(FCPATH . "dpd/Dutchblue/" . $file_name . ".txt", "wb");
                fwrite($fp, $dpd_row);
                fclose($fp);
            }

            $this->Order_model->set_geprint();
            redirect($this->config->item('admin_folder') . '/orders/orders_to_ship/');
        }
    }

    function edit_status() {

        $order['id'] = $this->input->post('id');
        $order['status'] = $this->input->post('status');

        $this->Order_model->save_order($order);

        echo url_title($order['status']);
    }

    function send_notification($order_id = '') {



        // send the message
        $this->load->library('email');

        $config['mailtype'] = 'html';

        $this->email->initialize($config);

        $this->email->from($this->config->item('email'), $this->config->item('company_name'));
        $this->email->to($this->input->post('recipient'));

        $this->email->subject($this->input->post('subject'));
        $this->email->message(html_entity_decode($this->input->post('content')));

        $this->email->send();

        $this->session->set_flashdata('message', lang('sent_notification_message'));

        redirect($this->config->item('admin_folder') . '/orders/view/' . $order_id);
    }

    function bulk_delete() {

        $orders = $this->input->post('order');

        if ($orders) {
            foreach ($orders as $order) {
                $this->Order_model->delete($order);
            }
            $this->session->set_flashdata('message', lang('message_orders_deleted'));
        } else {
            $this->session->set_flashdata('error', lang('error_no_orders_selected'));
        }
        //redirect as to change the url
        redirect($this->config->item('admin_folder') . '/orders');
    }

    function delete($id = false) {



        $this->Order_model->delete($id);
        redirect($this->config->item('admin_folder') . '/orders');
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
        $data['page_title'] = lang('start_order');
        $data['current_shop'] = $this->data_shop;
        $data['payment_condition'] = 4;
        if ($id) {

            $customer = $this->Customer_model->get_customer($id);

            if (!empty($customer->LANDCODE)) {

                $this->session->set_userdata('customer_order_country_index', strtoupper($customer->LANDCODE));
                $this->session->userdata('customer_order_country_index');

                $data['id'] = $customer->id;
                $data['NR'] = $customer->NR;
                $data['customer_number'] = $customer->customer_number;
                $data['group_id'] = $customer->group_id;
                $data['company'] = $customer->company;
                $data['email'] = $customer->email_1;
                $data['company'] = $customer->company;
                $data['active'] = $customer->active;
                $data['current_user'] = $this->session->userdata('ba_username');
                $data['none_VAT'] = $customer->none_VAT;
                $data['not_remind'] = $customer->not_remind;
                $data['customer_info'] = $customer->customer_info;
                $data['standard_payment_method'] = $customer->standard_payment_method;
                $payment_condition = $customer->payment_condition;

                $data['currency'] = '';
                $data['order_date'] = date('Y-m-d');
                $data['saleprice_index'] = strtoupper($customer->LANDCODE);
                $c_data = $this->Customer_model->get_country_data_by_index($data['saleprice_index']);
                $data['vat_index'] = $c_data->tax;
                $currency = $this->Location_model->get_country_currency_by_index($data['saleprice_index']);
                $data['currency'] = $currency->currency;

//----------------------------------------------------------------------------------------------------------------------------------------------------						
//----------------------------------------------------------------------------------------------------------------------------------------------------		

                $timeid = '';
                if ($timeid == 0) {
                    $time = time();
                } else {
                    $time = $timeid;
                }
                $data['weather'] = _date($time);
                $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));

                $this->load->view($this->config->item('admin_folder') . '/new_order', $data);
            } else {
                $this->session->set_flashdata('no_country', 'Select country');
                redirect($this->config->item('admin_folder') . '/customers/form/' . $id);
            }
        } else {
            $this->session->set_flashdata('error', lang('error_not_found'));
            redirect($this->config->item('admin_folder') . '/customers');
        }
    }

    public function preview_order($id = false) {   // here we go to check backorders HOOOOOOPE
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        if (!empty($this->session->userdata('back'))) {
            $this->session->unset_userdata('back');
        }
        force_ssl();

        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['page_title'] = lang('preview_order');
        $data['current_shop'] = $this->data_shop;


        $data['extra_charge'] = '';
        $data['n_vat'] = array();
        $data['d_vat'] = array();
        $data['order_vat_index'] = '';



        if (!empty($id)) {


            $customer = $this->Customer_model->get_customer($id);

            $adres = $this->Customer_model->get_invoice_address_new($customer->NR);
            $data['country'] = $adres['LAND'];


            $products_numbers1 = $this->input->post('product_number');
            $quantity_numbers1 = $this->input->post('number');
            $discount_numbers1 = $this->input->post('discount');
            $price_numbers1 = $this->input->post('unit_price');

            $n = sizeof($products_numbers1);
            echo "\nsize=$n\n";
            $products_numbers = array();
            for ($k = 0; $k < $n; $k++) {
                $code = $this->Order_model->clearTerm($products_numbers1[$k]);
                $key = array_search($code, $products_numbers);
                if ($key === false) {
                    $products_numbers[] = $code;
                    $quantity_numbers[] = $quantity_numbers1[$k];
                    $discount_numbers[] = $discount_numbers1[$k];
                    $price_numbers[] = $price_numbers1[$k];
                } else {
                    $quantity_numbers[$key] += $quantity_numbers1[$k];
                }
            }
            $n = sizeof($products_numbers);
            $data['id'] = $id;
            $data['company'] = $this->input->post('company');
            $data['customer_number'] = $this->input->post('customer_number');
            $data['customer_order_number'] = $this->input->post('customer_order_number');
            $data['contact_person'] = $this->input->post('contact_person');
            $data['order_type'] = $this->input->post('order_type');
            $data['order_type_date'] = $this->input->post('order_type_date');
            $data['not_remind'] = $this->input->post('not_remind');
            $data['email'] = $this->input->post('email');
            $data['delivery_condition'] = $this->input->post('delivery_condition');
            $data['dispatch_method'] = $this->input->post('dispatch_method');
            $data['warehouse'] = $this->input->post('warehouse');
            $data['weight'] = $this->input->post('weight');
            $data['payment_method'] = $this->input->post('payment_method');
            $data['payment_condition'] = $this->input->post('payment_condition');
            $data['none_VAT'] = $this->input->post('none_VAT');
            $data['not_warn'] = $this->input->post('not_warn');
            $data['invoice_per_email'] = $this->input->post('invoice_per_email');
            $data['email'] = $this->input->post('email');
            $data['currency'] = $this->input->post('order_type');
            $data['current_user'] = $this->session->userdata('ba_username');
            $data['order_date'] = $this->input->post('order_date');
            $data['saleprice_index'] = $this->input->post('saleprice_index');
            $data['vat_index'] = $this->input->post('vat_index');
            $data['unit_price'] = $this->input->post('unit_price');
            $data['discount'] = $this->input->post('discount');

            $v_index = $this->input->post('vat_index');
            $data['order_vat_index'] = '';
            if (!empty($v_index)) {
                $data['order_vat_index'] = str_replace('.00', '', $this->input->post('vat_index'));
            }
            $data['order_number'] = '';
            $data['VAT_N'] = '';
            $data['VAT_D'] = '';






            if ($data['payment_method'] == 0) {

                $this->session->set_flashdata('payment_method_error', lang('select_payment_method'));
                redirect($this->config->item('admin_folder') . '/orders/start_order/' . $id);
            }

            //$key = count($this->input->post('product_number'));
            // $a_1 = $this->input->post('number');    //  $quantity_numbers
            // $a_2 = $this->input->post('discount');  // $discount_numbers
            // $a_3 = $this->input->post('unit_price');  // $price_numbers
            // $a_4 = $this->input->post('product_number'); // $products_numbers

            for ($i = 0; $i < $n; $i++) {

                $q_arr[] = $this->Product_model->check_quantity($products_numbers[$i], $this->shop_id); // !!!!!!!!!!!!!!!
                $new_array_1[] = array(
                    'ordered_quantity' => $quantity_numbers[$i],
                    'discount' => $discount_numbers[$i],
                    'unit_price' => $price_numbers[$i],
                    'code' => $products_numbers[$i],
                );
            }

            // $nums = $this->input->post('product_number'); // $products_numbers

            $index = $this->input->post('saleprice_index');

            foreach ($products_numbers as $num) {
                if (is_numeric($num)) {
                    $num_new = $num . '/';
                } else {
                    $num_new = $num;
                }

                $f[] = $this->Product_model->get_order_product($this->data_shop, $num_new, $index);
            }


            foreach ($f as $check) {
                if (empty($check)) {

                    $this->session->set_flashdata('product_missing', lang('product_does_not_exists'));
                    redirect($this->config->item('admin_folder') . '/orders/start_order/' . $id);
                }
            }

            //echo '<pre>';
            //print_r($f);
            //echo '</pre>';

            $f = json_decode(json_encode($f), true);

            $product_array = array();

            for ($i = 0; $i < $n; $i++) {

                $product_array[] = array_merge($new_array_1[$i], $f[$i], $q_arr[$i]); // !!!!!!!!!!!!!!!!!!
                // $backorder_check__array[] = array_merge($new_array_1[$i], $q_arr[$i]); // not in use
            }
            $final_array = array();

            foreach ($product_array as $array) {

                if ($data['saleprice_index'] == 'DE') {
                    if (array_key_exists('saleprice_DE', $array)) {
                        $final_array[] = changekeyname($array, 'saleprice', 'saleprice_DE');
                    }
                }

                if ($data['saleprice_index'] == 'NL') {
                    if (array_key_exists('saleprice_NL', $array)) {
                        $final_array[] = changekeyname($array, 'saleprice', 'saleprice_NL');
                    }
                }

                if ($data['saleprice_index'] == 'AT' or $data['saleprice_index'] == 'AU') {
                    if (array_key_exists('saleprice_AU', $array)) {
                        $final_array[] = changekeyname($array, 'saleprice', 'saleprice_AU');
                    }
                }

                if ($data['saleprice_index'] == 'FR') {
                    if (array_key_exists('saleprice_FR', $array)) {
                        $final_array[] = changekeyname($array, 'saleprice', 'saleprice_FR');
                    }
                }

                if ($data['saleprice_index'] == 'BE' or $data['saleprice_index'] == 'BEL') {
                    if (array_key_exists('saleprice_BE', $array)) {
                        $final_array[] = changekeyname($array, 'saleprice', 'saleprice_BE');
                    }
                }

                if ($data['saleprice_index'] == 'UK') {
                    if (array_key_exists('saleprice_UK', $array)) {
                        $final_array[] = changekeyname($array, 'saleprice', 'saleprice_UK');
                    }
                }

                if ($data['saleprice_index'] == 'LX') {
                    if (array_key_exists('saleprice_LX', $array)) {
                        $final_array[] = changekeyname($array, 'saleprice', 'saleprice_LX');
                    }
                }
            }

            //echo '<pre>';
            //print_r($final_array);
            //echo '</pre>';

            $data['name'] = 'name_' . $index;
            if ($index == 'BEL') {
                $index = 'BE';
            }
            $data['product_vat'] = 'vat_' . $index;

            $n_p = array();

            foreach ($final_array as $final) {
                $n_p[] = $this->Order_model->check_special_price($final, $this->session->userdata('shop'), $customer->NR);
            }
            if (!empty($n_p)) {
                foreach ($n_p as $k => $v) {
                    if (!empty($v)) {
                        $final_array[$k]['saleprice'] = $v['saleprice'];
                    }
                }
            }

            $data['product_array'] = $final_array; // !!!!!!!!!!



            $data['customer_nr'] = $this->input->post('customer_nr');
            $c_NR = $this->input->post('customer_nr');
            $customer = $this->Customer_model->get_customer_nr($c_NR);

            /*             * ********************************************************************************************************************* */

            $data['invoice_address'] = $this->Order_model->get_invoice_adres($c_NR, $this->session->userdata('shop')); //adres
            $data['delivery_address'] = $this->Order_model->get_delivery_adres($c_NR, $this->session->userdata('shop')); //adres

            /*             * ******************************************************************************************************************* */


            $timeid = $this->uri->segment(5);
            if ($timeid == 0) {
                $time = time();
            } else {
                $time = $timeid;
            }
            $data['weather'] = _date($time);
            $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
            $this->load->view($this->config->item('admin_folder') . '/new_order_1', $data);
        } else {

            $this->session->set_flashdata('error', lang('error_not_found'));
            redirect($this->config->item('admin_folder') . '/customers');
        }
    }

    function workagain($id) {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        force_ssl();
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['page_title'] = lang('work_again');
        $data['current_shop'] = $this->data_shop;

        $data['order'] = $this->Order_model->get_order($id);
        $data['order_items'] = $this->Order_model->get_all_items($data['order']->NR, $data['order']->order_number, $this->session->userdata('shop'));
        $data['order_items'] = json_decode(json_encode($data['order_items']), true);

        $verzending = $this->Order_model->get_order_verzendings($data['order']->NR, $this->session->userdata('shop'));
        $order_items = $this->Order_model->get_all_items_for_back_ship($data['order']->NR, $data['order']->order_number, $this->session->userdata('shop'));
        $back = $this->Order_model->get_backorder_products($data['order']->NR, $data['order']->order_number, $this->session->userdata('shop'));




        $back_items = $this->Order_model->get_order_backorder_products($data['order']->id, $this->session->userdata('shop'));
        $back_codes = $this->Order_model->get_order_backorder_only_products($data['order']->id, $this->session->userdata('shop'));
        $index = strtoupper($data['order']->country_id);

        $key = count($back_codes);
        foreach ($back_codes as $num) {


            $f[] = $this->Product_model->get_backorder_product($this->data_shop, $num->product_code, $data['order']->NR);
        }


        $product_array = array();

        for ($i = 0; $i < $key; $i++) {

            $product_array[] = array_merge($back_items[$i], $f[$i]);
        }


        $data['backorder_products'] = $this->Product_model->check_availability_again($back_items, $this->shop_id);

        $data['back_product_array'] = $product_array;





        $data['verzending'] = $order_items;


        $data['invoices'] = $this->Invoice_model->grt_order_invoices($data['order']->order_number);

        $data['saleprice_index'] = strtoupper($data['order']->country_id);
        $c_data = $this->Customer_model->get_country_data_by_index($data['saleprice_index']);
        $data['current_user'] = $this->session->userdata('ba_username');

        $client_details = $this->Customer_model->get_client_details_NR($data['order']->customer_id);
        $data['info'] = $client_details['customer_info'];

        $invoice_address = $this->Customer_model->get_invoice_address($data['order']->customer_id);
        $data['invoice_address'] = $invoice_address['field_data'];
        $delivery_address = $this->Customer_model->get_delivery_address($data['order']->customer_id);
        $data['delivery_address'] = $delivery_address['field_data'];


        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $data['weather'] = _date($time);
        $data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/workagain', $data);
    }

    function get_last_nr() {

        $last_order_id = $this->Order_model->get_last_id($this->data_shop);
        $last_order_numbers = $this->Order_model->get_last_order_number($last_order_id->id);

        //print_r($last_order_numbers->NR);
    }

    public function proceed_order($id = false) {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //
        force_ssl();
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['current_shop'] = $this->data_shop;
        //
        if ($this->input->post('submit') == 'create_order') {
            if ($id) {
                $customer = $this->Customer_model->get_customer($id);
                $data['id'] = $id;
                // 
                if (!empty($_POST)) {
                    //
                    $this->form_validation->set_rules('product_number', 'lang:product_number', 'required');
                    //
                    if ($this->form_validation->run() == FALSE) {
                        $this->form_validation->set_message('required', 'Error Message');
                    } else {
                        $order_details['shop_id'] = $this->shop_id;
                        ////////////////////////////////////////////////////////
                        $last_order_id = $this->Order_model->get_last_id($this->data_shop);
                        $last_order_numbers = $this->Order_model->get_last_order_number($last_order_id->id);
                        echo "<pre>";
                        print_r($_POST);
                        echo "</pre>";
                        // $last_NR_number  = $this->Order_model->get_last_NR_number($last_order_id->id);
                        ////////////////////////////////////////////////////////
                        $order_details['customer_id'] = $customer->NR;
                        // $order_details['order_number']   = $last_order_numbers->order_number+1;
                        $order_details['order_number'] = $this->input->post('order_number');
                        $order_details['NR'] = is_object($last_order_numbers) ? $last_order_numbers->NR + 1 : 1;
                        $order_details['notes'] = $this->input->post('notes');
                        $order_details['vat_index'] = $this->input->post('vat_index');
                        $order_details['status'] = '0';
                        $order_details['entered_by'] = $this->session->userdata('ba_username');
                        $order_details['customer_number'] = $this->input->post('customer_number');
                        $order_details['remarks'] = $this->input->post('remarks');
                        $order_details['weight'] = $this->input->post('weight');
                        $order_details['shipping'] = $this->input->post('extra_charges');
                        $order_details['total'] = $this->input->post('gross');
                        $order_details['subtotal'] = $this->input->post('netto');
                        $order_details['VAT'] = $this->input->post('vat');
                        $order_details['ship_vat_rate'] = $this->input->post('ship_vat_rate');
                        $order_details['none_vat'] = $this->input->post('none_VAT');
                        $order_details['customer_order_number'] = $this->input->post('customer_order_number');
                        $order_details['contact_person'] = $this->input->post('contact_person');
                        $order_details['company'] = $customer->company;
                        $order_details['firstname'] = $customer->firstname;
                        $order_details['lastname'] = $customer->lastname;
                        $order_details['payment_method'] = $this->input->post('payment_method');
                        $order_details['shipping_method'] = $this->input->post('dispatch_method');
                        $order_details['order_type'] = $this->input->post('order_type');
                        $order_details['order_type_date'] = $this->input->post('order_type_date');
                        $order_details['delivery_condition'] = $this->input->post('delivery_condition');
                        $order_details['ordered_on'] = date('Y-m-d H:m:s');
                        //
                        $marge = $this->input->post('overall_margin');
                        if ($marge > 0) {
                            $order_details['overall_margin'] = $marge;
                        }
                        $c_id = $this->Customer_model->get_country_id($id);
                        $order_details['country_id'] = strtoupper($c_id['TAAL']);
                        $order_details['not_remind'] = $this->input->post('not_remind');
                        $order_details['warehouse'] = $this->input->post('warehouse');
                        $order_details['invoice_per_email'] = $this->input->post('invoice_per_email');
                        $order_details['email'] = $this->input->post('email');
                        $order_details['currency'] = $this->input->post('currency');
                        $data['invoice_address'] = $this->Customer_model->get_invoice_address_new($customer->NR);
                        $order_details['invoice_address'] = serialize($data['invoice_address']);
                        $data['delivery_address'] = $this->Customer_model->get_delivery_address_new($customer->NR);
                        $order_details['delivery_address'] = serialize($data['delivery_address']);
                        $order_details['delivery_address'] = serialize($data['delivery_address']);
                        $backorder_products = $this->input->post('backorder_products');
                        /*
                          if (!empty($backorder_products)) {
                          $order_details['BACKORDER'] = '1';
                          } else {
                          $order_details['BACKORDER'] = '0';
                          }
                         * 
                         */
                        // this will be set to 1 in 
                        //  $this->Order_model->insert_resevations if reqired
                        $order_details['BACKORDER'] = '0';
                        //insert versendung 1,2,3 so on if backorders found
                        $this->Order_model->insert_order($order_details);
                        $order_id = $this->db->insert_id();
                        $order_NR = $order_details['NR'];
                        $index = strtoupper($c_id['TAAL']);
                        if (!empty($backorder_products)) {
                            $backorder_details = unserialize($backorder_products);
                            foreach ($backorder_details as $back) {
                                $backorder_array[] = array(
                                    'order_id' => $order_id,
                                    'shop_id' => $this->data_shop,
                                    'product_code' => $back['code'],
                                    'backorder_quantity' => $back['backorder_quantity'],
                                    // 'order_number'   => $last_order_number->order_number+1,
                                    'order_number' => $this->input->post('order_number'),
                                    'order_date' => date('Y-m-d'),
                                    'customer' => $customer->company . $customer->firstname . $customer->lastname,
                                    'agent_id' => $this->session->userdata('ba_user_id'),
                                    'agent_name' => $this->session->userdata('ba_username'),
                                    'backorder_date' => date('Y-m-d'),
                                );
                            }
                            //$this->Order_model->insert_backorder($backorder_array);
                        }
                        $key = count($this->input->post('product_number'));
                        $a_1 = $this->input->post('product');
                        $a_2 = $this->input->post('product_number');
                        $a_3 = $this->input->post('number');
                        $a_4 = $this->input->post('vpa');
                        $a_5 = $this->input->post('vk');
                        $a_6 = $this->input->post('discount');
                        $a_7 = $this->input->post('unit_price');
                        $a_8 = $this->input->post('total');
                        $a_9 = $this->input->post('warehouse_price');
                        $a_10 = $this->input->post('margin');
                        $a_11 = $this->input->post('available_stock');
                        $a_12 = $this->input->post('description');
                        $a_13 = $this->input->post('vat_rate_item');
                        $a_14 = $this->input->post('vat_index_item');
                        $a_15 = $this->input->post('special_vat');
                        echo "<pre>";
                        for ($i = 0; $i < $key; $i++) {
                            /*
                            $complexType = $this->Part_model->getProductComplexType($this->data_shop, $a_2[$i]);
                            echo $complexType . "\n";
                            // and if so find sub product
                            // and sun array
                            // no change model
                            if ($complexType == 'complex') {
                                // find parts
                                $parts = $this->Part_model->getPartsByCode(
                                        $this->data_shop, $a_2[$i]
                                );
                                $compProduct = $this->Part_model->getProductByCode(
                                        $this->data_shop, $a_2[$i]
                                );
                                print_r($parts);
                                // add parts calculate prices
                                $index = (isset($index) && $index) ? $index : $this->input->post('saleprice_index');
                                $ind = 'saleprice';
                                if(isset($index) && $index) 
                                    $ind .= "_".$index;
                                $sp = 0;
                                if($compProduct);
                                    $sp = $compProduct[$ind];
                                foreach ($parts as $p) {
                                    // unit price
                                    $unit_price = $a_7[$i];
                                    if(!empty($unit_price))
                                    {
                                        if($sp > 0 )
                                        {
                                            $unit_price = $a_7[$i] * $p[$ind] / $sp;
                                        }
                                    }
                                    // sales price
                                    if($sp > 0 )
                                    {
                                       $vk = $a_5[$i] * $p[$ind] / $sp;
                                    }
                                    else 
                                    {
                                        $vk = $p[$ind];
                                    }
                                    $total = $vk * $a_3[$i];
                                    // warehouse_price
                                    $warehouse_price = $p['warehouse_price'];
                                    if($warehouse_price > 0)
                                    {
                                        $margin = $total - $warehouse_price * $a_3[$i];
                                    }
                                    else
                                    {
                                        $margin =  0;
                                    }
                                    // vat percent 
                                    $vPercent = ($a_15[$i] > 0 ) ? $a_15[$i] : $a_14[$i];
                                    $vat_rate_item = round($total * $vPercent / 100,2);
                                    //
                                    $new_array[] = array(
                                        'product' => $p['name'],
                                        'product_number' => $p['code'],
                                        'number' => $a_3[$i],
                                        'vpa' => $p['package_details'],
                                        'vk'    => $vk,
                                        'discount' => $a_6[$i],
                                        'unit_price' => $unit_price,
                                        'total'     => $a_3[$i].$vk,
                                        'warehouse_price' => $warehouse_price,
                                        'margin' => $margin,
                                        'available_stock' => '',
                                        'description' =>  $a_12[$i],
                                        'vat_rate_item' => $vat_rate_item,
                                        'vat_index_item' => $a_14[$i],
                                        'special_vat' => $a_15[$i], // to get from base
                                    );
                                }
                                
                            } else {
                             * 
                             */
                                $new_array[] = array(
                                    'product' => $a_1[$i],
                                    'product_number' => $a_2[$i],
                                    'number' => $a_3[$i],
                                    'vpa' => $a_4[$i],
                                    'vk' => $a_5[$i],
                                    'discount' => $a_6[$i],
                                    'unit_price' => $a_7[$i],
                                    'total' => $a_8[$i],
                                    'warehouse_price' => $a_9[$i],
                                    'margin' => $a_10[$i],
                                    'available_stock' => $a_11[$i],
                                    'description' => $a_12[$i],
                                    'vat_rate_item' => $a_13[$i],
                                    'vat_index_item' => $a_14[$i],
                                    'special_vat' => $a_15[$i],
                                );
                            /*
                            }
                             * 
                             */
                        }
                        foreach ($new_array as $arr) {
                            $product_array[] = array(
                                'order_id' => $order_NR,
                                'order_id_number' => $order_id,
                                'shop_id' => $this->data_shop,
                                'code' => $arr['product_number'],
                                'quantity' => $arr['number'],
                                'saleprice' => $arr['unit_price'],
                                'original_price' => $arr['vk'],
                                'c_index' => $index,
                                'vpa' => $arr['vpa'],
                                'discount' => $arr['discount'],
                                'total' => $arr['total'],
                                'VAT' => $arr['vat_rate_item'],
                                'vat_index' => $arr['vat_index_item'],
                                'special_vat' => $arr['special_vat'],
                                'warehouse_price' => $arr['warehouse_price'],
                                'margin' => $arr['margin'],
                                'available_stock' => $arr['available_stock'],
                                'description' => $arr['description'],
                            );
                        }
                        foreach ($new_array as $arr) {
                            $product_reservation_array[] = array(
                                'shop_id' => $this->data_shop,
                                'order_id' => $order_NR,
                                'product_code' => $arr['product_number'],
                                'quantity' => $arr['number'],
                                'reservation_date' => date('Y-m-d H:i:s'),
                                // added AG 
                                'order_number' => $this->input->post('order_number'), // TODO  $last_order_number->order_number+1,
                            );
                        }
                        foreach ($new_array as $arr) {
                            $backorder_product_array[] = array(
                                'order_id' => $order_NR,
                                'order_id_number' => $order_id,
                                'shop_id' => $this->data_shop,
                                'code' => $arr['product_number'],
                                'quantity' => $arr['number'],
                                'saleprice' => $arr['unit_price'],
                                'original_price' => $arr['vk'],
                                'vpa' => $arr['vpa'],
                                'discount' => $arr['discount'],
                                'total' => $arr['total'],
                                'VAT' => $arr['vat_rate_item'],
                                'vat_index' => $arr['vat_index_item'],
                                'special_vat' => $arr['special_vat'],
                                'warehouse_price' => $arr['warehouse_price'],
                                'margin' => $arr['margin'],
                                'available_stock' => $arr['available_stock'],
                                'description' => $arr['description'],
                                'BACKORDER' => '1',
                            );
                        }
                        if (!empty($backorder_products)) {
                            $this->Order_model->insert_order_products_with_backorder($backorder_product_array);
                            die("no empty1");
                            redirect($this->config->item('admin_folder') . '/customers/form/' . $id);
                        } else {
                            $this->Order_model->insert_order_products($product_array);
                            $this->Order_model->insert_reserved_products($product_reservation_array);
                            // this will subject of test
                            $this->Order_model->insert_resevations($product_reservation_array, $customer);
                            // die("empty2");
                            redirect($this->config->item('admin_folder') . '/customers/form/' . $id);
                        }
                    }
                }
            } else {
                $this->session->set_flashdata('error', lang('error_not_found'));
                redirect($this->config->item('admin_folder') . '/customers');
            }
        } // till hear we will check create
        if ($this->input->post('submit') == 'update') {

            if (!empty($id)) {

                $customer = $this->Customer_model->get_customer($id);
                $adres = $this->Customer_model->get_invoice_address_new($customer->NR);
                $u_data['country'] = $adres['LAND'];

                $u_data['extra_charge'] = '';
                $u_data['n_vat'] = array();
                $u_data['d_vat'] = array();
                $u_data['order_vat_index'] = '';

                //$u_data['vat_net_price']		= '';



                $products_numbers = $this->input->post('product_number');
                $quantity_numbers = $this->input->post('number');
                //$discount_numbers   = $this->input->post('discount');
                $price_numbers = $this->input->post('unit_price');


                foreach ($quantity_numbers as $quantity_number) {
                    if (!is_numeric($quantity_number)) {
                        $this->session->set_flashdata('error', lang('quantity_number_error'));
                        redirect($this->config->item('admin_folder') . '/orders/start_order/' . $id);
                    }
                }

                $u_data['id'] = $id;
                $u_data['company'] = $this->input->post('company');
                $u_data['customer_number'] = $this->input->post('customer_number');
                $u_data['customer_order_number'] = $this->input->post('customer_order_number');
                $u_data['contact_person'] = $this->input->post('contact_person');
                $u_data['order_type'] = $this->input->post('order_type');
                $u_data['order_type_date'] = $this->input->post('order_type_date');
                $u_data['none_VAT'] = $this->input->post('none_VAT');
                $u_data['not_remind'] = $this->input->post('not_remind');
                $u_data['email'] = $this->input->post('email');
                $u_data['delivery_condition'] = $this->input->post('delivery_condition');
                $u_data['dispatch_method'] = $this->input->post('dispatch_method');
                $u_data['warehouse'] = $this->input->post('warehouse');
                $u_data['weight'] = $this->input->post('weight');
                $u_data['payment_method'] = $this->input->post('payment_method');
                $u_data['payment_condition'] = $this->input->post('payment_condition');
                $u_data['none_vat'] = $this->input->post('none_vat');
                $u_data['not_warn'] = $this->input->post('not_warn');
                $u_data['invoice_per_email'] = $this->input->post('invoice_per_email');
                $u_data['email'] = $this->input->post('email');
                $u_data['currency'] = $this->input->post('order_type');
                $u_data['current_user'] = $this->session->userdata('ba_username');
                $u_data['order_date'] = $this->input->post('order_date');
                $u_data['saleprice_index'] = $this->input->post('saleprice_index');
                $u_data['vat_index'] = $this->input->post('vat_index');
                $u_data['notes'] = $this->input->post('notes');
                $u_data['remarks'] = $this->input->post('remarks');
                $u_data['unit_price'] = $this->input->post('unit_price');
                $u_data['discount'] = $this->input->post('discount');
                $u_data['order_discount'] = $this->input->post('order_discount');
                $u_data['quantity'] = $this->input->post('number');
                $u_data['order_number'] = $this->input->post('order_number');



                $marge = $this->input->post('overall_margin');


                if ($marge > 0) {
                    $order_details['margin'] = $marge;
                }

                $key = count($this->input->post('product_number'));

                $a_1 = $this->input->post('number');
                $a_2 = $this->input->post('discount');
                $a_3 = $this->input->post('unit_price');
                $a_4 = $this->input->post('product_number');

                for ($i = 0; $i < $key; $i++) {
                    $q_arr[] = $this->Product_model->check_quantity($a_4[$i], $this->shop_id);

                    $new_array_1[] = array(
                        'ordered_quantity' => $a_1[$i],
                        'discount' => $a_2[$i],
                        'unit_price' => $a_3[$i],
                        'code' => $a_4[$i],
                    );
                }

                $nums = $this->input->post('product_number');

                $f = array();
                $index = $this->input->post('saleprice_index');

                foreach ($nums as $num) {

                    if (is_numeric($num)) {

                        $num_new = $num . '/';
                    } else {
                        $num_new = $num;
                    }

                    $f[] = $this->Product_model->get_order_product($this->shop_id, $num_new, $index);
                }
                foreach ($f as $check) {
                    if (empty($check)) {

                        $this->session->set_flashdata('product_missing', lang('product_does_not_exists'));
                        redirect($this->config->item('admin_folder') . '/orders/preview_order/' . $id);
                    }
                }
                $f = json_decode(json_encode($f), true);
                $product_array = array();

                for ($i = 0; $i < $key; $i++) {

                    $product_array[] = array_merge($new_array_1[$i], $f[$i], $q_arr[$i]);
                }

                $u_data['backorder_products'] = $this->Product_model->check_availability($product_array, $this->shop_id);

                $final_array = array();

                foreach ($product_array as $array) {

                    if ($index == 'DE') {
                        if (array_key_exists('saleprice_DE', $array)) {
                            $final_array[] = changekeyname($array, 'saleprice', 'saleprice_DE');
                        }
                    }

                    if ($index == 'NL') {
                        if (array_key_exists('saleprice_NL', $array)) {
                            $final_array[] = changekeyname($array, 'saleprice', 'saleprice_NL');
                        }
                    }

                    if ($index == 'AT' or $index == 'AU') {
                        if (array_key_exists('saleprice_AU', $array)) {
                            $final_array[] = changekeyname($array, 'saleprice', 'saleprice_AU');
                        }
                    }

                    if ($index == 'FR') {
                        if (array_key_exists('saleprice_FR', $array)) {
                            $final_array[] = changekeyname($array, 'saleprice', 'saleprice_FR');
                        }
                    }

                    if ($index == 'BE' or $index == 'BEL') {
                        if (array_key_exists('saleprice_BE', $array)) {
                            $final_array[] = changekeyname($array, 'saleprice', 'saleprice_BE');
                        }
                    }

                    if ($index == 'UK') {
                        if (array_key_exists('saleprice_UK', $array)) {
                            $final_array[] = changekeyname($array, 'saleprice', 'saleprice_UK');
                        }
                    }

                    if ($index == 'LX') {
                        if (array_key_exists('saleprice_LX', $array)) {
                            $final_array[] = changekeyname($array, 'saleprice', 'saleprice_LX');
                        }
                    }
                }

                $u_data['name'] = 'name_' . $index;
                if ($index == 'BEL') {
                    $index = 'BE';
                }
                $u_data['product_vat'] = 'vat_' . $index;
                $u_data['customer_nr'] = $this->input->post('customer_nr');

                $u_data['product_array'] = $final_array;
                //echo '<pre>';
                //print_r($final_array);
                //echo '</pre>';

                $c_NR = $this->input->post('customer_nr');
                $customer = $this->Customer_model->get_customer_nr($c_NR);
                $u_data['invoice_address'] = $this->Customer_model->get_invoice_address_new($c_NR);
                $u_data['delivery_address'] = $this->Customer_model->get_delivery_address_new($c_NR);

                if (empty($u_data['invoice_address'])) {
                    $u_data['invoice_address'] = $u_data['delivery_address'];
                }
                if (empty($u_data['delivery_address'])) {
                    $u_data['delivery_address'] = $u_data['invoice_address'];
                }

                $u_data['extra_charge'] = $this->input->post('extra_charges');
                $u_data['current_shop'] = $this->data_shop;

                $timeid = $this->uri->segment(5);
                if ($timeid == 0) {
                    $time = time();
                } else {
                    $time = $timeid;
                }
                $u_data['weather'] = _date($time);
                $u_data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
                $this->load->view($this->config->item('admin_folder') . '/new_order_1', $u_data);
            } else {

                $this->session->set_flashdata('error', lang('error_not_found'));
                redirect($this->config->item('admin_folder') . '/customers');
            }
        }
    }

    public function update($id = false) {

        force_ssl();
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['page_title'] = 'Order in process';

        if ($id) {

            $data['id'] = $id;

            if (!empty($_POST)) {

                $this->form_validation->set_rules('product_number', 'lang:product_number', 'required');

                $order_details['id'] = $id;
                $order_details['shop_id'] = $this->shop_id;
                $order_details['nr'] = $this->input->post('order_nr');
                $order_details['order_number'] = $this->input->post('order_number');
                $order_details['customer_id'] = $this->input->post('customer_id');
                $order_details['customer_number'] = $this->input->post('customer_number');
                $order_details['order_type'] = $this->input->post('order_type');
                $order_details['order_type_date'] = $this->input->post('order_type_date');
                $order_details['delivery_condition'] = $this->input->post('delivery_condition');
                $order_details['none_VAT'] = $this->input->post('none_VAT');
                $order_details['not_remind'] = $this->input->post('not_remind');
                $order_details['invoice_per_email'] = $this->input->post('invoice_per_email');
                $order_details['currency'] = $this->input->post('currency');
                $order_details['ordered_on'] = $this->input->post('order_date');
                $order_details['notes'] = $this->input->post('notes');
                $order_details['remarks'] = $this->input->post('remarks');
                $order_details['shipping_method'] = $this->input->post('dispatch_method');
                $order_details['warehouse'] = $this->input->post('warehouse');
                $order_details['payment_method'] = $this->input->post('payment_method');
                $order_details['email'] = $this->input->post('email');
                $order_details['total'] = $this->input->post('gross');
                $order_details['subtotal'] = $this->input->post('netto');
                $order_details['vat'] = $this->input->post('vat');
                $order_details['vat_index'] = $this->input->post('vat_index');
                $order_details['ship_vat_rate'] = $this->input->post('ship_vat_rate');
                $order_details['entered_by'] = $this->input->post('agent');
                $order_details['firstname'] = $this->input->post('firstname');
                $order_details['lastname'] = $this->input->post('lastname');
                $order_details['company'] = $this->input->post('company');
                $order_details['weight'] = $this->input->post('weight');
                $order_details['carrier'] = $this->input->post('carrier');
                $order_details['parcel_number'] = $this->input->post('parcel_number');
                $order_details['order_picking_costs'] = $this->input->post('order_picking_costs');
                $order_details['picking_agent'] = $this->input->post('picking_agent');
                $order_details['monitored_by'] = $this->input->post('monitored_by');
                $order_details['shipped_on'] = $this->input->post('shipped_on');
                $order_details['shipping'] = $this->input->post('shipping');
                $order_details['invoice_agreement_notes'] = $this->input->post('invoice_agreement_notes');

                $marge = $this->input->post('overall_margin');

                if ($marge > 0) {
                    $order_details['margin'] = $marge;
                }

                //echo '<pre>';
                //print_r($order_details);
                //echo '</pre>';

                $this->Order_model->update_order($order_details);

                $index = $this->input->post('saleprice_index');
                if ($index == 'BEL') {
                    $index = 'BE';
                }
                $u_data['name'] = 'name_' . $index;
                $key = count($this->input->post('product_number'));

                // $a_1    = $this->input->post('product_id');
                $a_2 = $this->input->post('product_number');
                $a_3 = $this->input->post('number');
                $a_4 = $this->input->post('vpa');
                $a_5 = $this->input->post('vk');
                $a_6 = $this->input->post('discount');
                $a_7 = $this->input->post('unit_price');
                $a_8 = $this->input->post('total');
                $a_9 = $this->input->post('warehouse_price');
                $a_10 = $this->input->post('margin');
                $a_11 = $this->input->post('available_stock');
                $a_12 = $this->input->post('description');
                $a_13 = $this->input->post('order_nr');
                $a_14 = $this->input->post('vat_rate_item');


//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

                $new_2 = $this->input->post('new_product_number');

                if (!empty($new_2)) {

                    $index = $this->input->post('saleprice_index');
                    $u_data['name'] = 'name_' . $index;
                    $u_data['product_vat'] = 'vat_' . $index;


                    $new_key = count($this->input->post('new_product_number'));

                    $new_1 = $this->input->post('new_number');
                    $new_3 = $this->input->post('new_discount');
                    $new_4 = $this->input->post('new_unit_price');

                    for ($i = 0; $i < $new_key; $i++) {

                        $q_arr[] = $this->Product_model->check_quantity($new_2[$i], $this->shop_id);

                        $new_array_1[] = array(
                            'ordered_quantity' => $new_1[$i],
                            'discount' => $new_3[$i],
                            'unit_price' => $new_4[$i],
                            'code' => $new_2[$i],
                        );
                    }

                    $nums = $this->input->post('new_product_number');

                    foreach ($nums as $num) {
                        if (is_numeric($num)) {
                            $num_new = $num . '/';
                        } else {
                            $num_new = $num;
                        }

                        $f[] = $this->Product_model->get_new_order_product($this->data_shop, $num_new, $index);
                    }

                    foreach ($f as $check) {

                        if (empty($check)) {

                            //$this->session->set_flashdata('error', lang('product_does_not_exists'));
                            //redirect($this->config->item('admin_folder').'/orders/start_order/'.$id);
                        }
                    }

                    $f = json_decode(json_encode($f), true);

                    $new_product_array = array();

                    for ($i = 0; $i < $new_key; $i++) {

                        $new_product_array[] = array_merge($new_array_1[$i], $f[$i], $q_arr[$i]);
                    }

                    $u_data['backorder_products'] = $this->Product_model->check_availability($new_product_array, $this->shop_id);

                    $final_array = array();

                    foreach ($new_product_array as $array) {

                        if ($index == 'DE') {
                            if (array_key_exists('saleprice_DE', $array)) {
                                $final_array[] = changekeyname($array, 'saleprice', 'saleprice_DE');
                            }
                        }

                        if ($index == 'NL') {
                            if (array_key_exists('saleprice_NL', $array)) {
                                $final_array[] = changekeyname($array, 'saleprice', 'saleprice_NL');
                            }
                        }

                        if ($index == 'AT' or $index == 'AU') {
                            if (array_key_exists('saleprice_AU', $array)) {
                                $final_array[] = changekeyname($array, 'saleprice', 'saleprice_AU');
                            }
                        }

                        if ($index == 'FR') {
                            if (array_key_exists('saleprice_FR', $array)) {
                                $final_array[] = changekeyname($array, 'saleprice', 'saleprice_FR');
                            }
                        }

                        if ($index == 'BE' or $index == 'BEL') {
                            if (array_key_exists('saleprice_BE', $array)) {
                                $final_array[] = changekeyname($array, 'saleprice', 'saleprice_BE');
                            }
                        }

                        if ($index == 'UK') {
                            if (array_key_exists('saleprice_UK', $array)) {
                                $final_array[] = changekeyname($array, 'saleprice', 'saleprice_UK');
                            }
                        }

                        if ($index == 'LX') {
                            if (array_key_exists('saleprice_LX', $array)) {
                                $final_array[] = changekeyname($array, 'saleprice', 'saleprice_LX');
                            }
                        }
                    }
                    //echo '<pre>';
                    //print_r($final_array);
                    //echo '</pre>';
                    //foreach($final_array as $new){
                    //	$final_array_1[] = changekeyname($new, 'description', 'name');
                    //}
                    foreach ($final_array as $new_1) {
                        $final_array_2[] = changekeyname($new_1, 'available_stock', 'current_quantity');
                    }
                    foreach ($final_array_2 as $new_2) {
                        $final_array_3[] = changekeyname($new_2, 'vpa', 'package_details');
                    }

                    foreach ($final_array_3 as $farr) {

                        if (!$farr['discount'] > 0 and $farr['unit_price'] > 0) {
                            $diff_price = $farr['unit_price'] - $farr['warehouse_price'];
                            $marge = round((($diff_price / $farr['unit_price']) * 100), 2);
                        }
                        if ($farr['discount'] > 0 and ! $farr['unit_price'] > 0) {
                            $percent = $farr['saleprice'] * ($farr['discount'] / 100);
                            $unit_price = $farr['saleprice'] - $percent;
                            $diff_price = $unit_price - $farr['warehouse_price'];
                            $marge = round((($diff_price / $unit_price) * 100), 2);
                        }
                        if (!$farr['discount'] > 0 and ! $farr['unit_price'] > 0) {
                            $diff_price = $farr['saleprice'] - $farr['warehouse_price'];
                            $marge = round((($diff_price / $farr['saleprice']) * 100), 2);
                        }
                        if ($farr['discount'] > 0 and $farr['unit_price'] > 0) {
                            $diff_price = $farr['unit_price'] - $farr['warehouse_price'];
                            $marge = round((($diff_price / $farr['unit_price']) * 100), 2);
                        }



                        $final_product_array[] = array(
                            'order_id_number' => $id,
                            'order_id' => $this->input->post('order_nr'),
                            'shop_id' => $this->data_shop,
                            'code' => $farr['code'],
                            'discount' => $farr['discount'],
                            'quantity' => $farr['ordered_quantity'],
                            'saleprice' => $farr['unit_price'],
                            'original_price' => $farr['saleprice'],
                            'warehouse_price' => $farr['warehouse_price'],
                            'description' => $farr['name_' . $index],
                            'total' => '',
                            'vat_index' => $farr['vat_' . $index],
                            'vpa' => $farr['vpa'],
                            'available_stock' => $farr['available_stock'],
                            'margin' => $marge,
                            'c_index' => $index,
                        );
                    }
                    //echo '<pre>';
                    //print_r($final_product_array);
                    //echo '</pre>';
                }
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
                for ($i = 0; $i < $key; $i++) {

                    $new_array[] = array(
                        // 'product'           =>  $a_1[$i],
                        'product_number' => $a_2[$i],
                        'number' => $a_3[$i],
                        'vpa' => $a_4[$i],
                        'vk' => $a_5[$i],
                        'discount' => $a_6[$i],
                        'unit_price' => $a_7[$i],
                        'total' => $a_8[$i],
                        'warehouse_price' => $a_9[$i],
                        'margin' => $a_10[$i],
                        'available_stock' => $a_11[$i],
                        'description' => $a_12[$i],
                        'id' => $a_13[$i],
                        'vat_rate_item' => $a_14[$i],
                    );
                }


                foreach ($new_array as $arr) {

                    $product_array[] = array(
                        'order_id_number' => $id,
                        'order_id' => $this->input->post('order_nr'),
                        'shop_id' => $this->data_shop,
                        'code' => $arr['product_number'],
                        'discount' => $arr['discount'],
                        'quantity' => $arr['number'],
                        'saleprice' => $arr['unit_price'],
                        'warehouse_price' => $arr['warehouse_price'],
                        'description' => $arr['description'],
                        'total' => $arr['total'],
                        'VAT' => $arr['vat_rate_item'],
                        'vpa' => $arr['vpa'],
                        'original_price' => $arr['vk'],
                        'available_stock' => $arr['available_stock'],
                        'margin' => $arr['margin'],
                        'c_index' => $index,
                    );
                }

                foreach ($new_array as $arr) {

                    $reserved_product_array[] = array(
                        'order_id' => $this->input->post('order_nr'),
                        'shop_id' => $this->data_shop,
                        'code' => $arr['product_number'],
                        'quantity' => $arr['number'],
                    );
                }

                if (!empty($final_product_array)) {
                    $lnew_product_array = array_merge($product_array, $final_product_array);
                    $this->Order_model->renew_order_items($lnew_product_array);
                    redirect($this->config->item('admin_folder') . '/orders/view/' . $id);
                    //echo '<pre>';
                    //print_r($lnew_product_array);
                    //echo '</pre>';									
                } else {
                    $this->Order_model->update_order_products($product_array);
                    //$this->Order_model->update_reserved_order_products($reserved_product_array);
                    redirect($this->config->item('admin_folder') . '/orders/view/' . $id);
                }
                //echo '<pre>';
                //print_r($product_array);
                //echo '</pre>';
            }
        } else {

            $this->session->set_flashdata('error', lang('error_not_found'));
            redirect($this->config->item('admin_folder') . '/customers');
        }
    }

    public function process_order($order_number = false) {


        $data['order'] = $this->Order_model->get_order_num($order_number);
        $BACK = $data['order']->BACKORDER;

        $this->Order_model->update_status($order_number, $BACK);

        redirect($this->config->item('admin_folder') . '/orders/processed_orders');
    }

    public function order_for_shipp($order_number = false) {
        $this->Order_model->to_ship($order_number);
        redirect($this->config->item('admin_folder') . '/orders/orders_to_ship');
    }

    public function ship_order() {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        $shop = $this->shop_id;

        $orders = $this->input->post('orders');



        foreach ($orders as $order) {

            $order_details = $this->Order_model->get_order($order);

            $order_items = $this->Order_model->get_all_items($order_details->NR, $order_details->id);

            $this->Order_model->insert_sent_order($order_details, $shop);

            $ship_details_data = array(
                'shop_id' => $this->shop_id,
                'NR' => $order_details->NR,
                'order_number' => $order_details->order_number,
                'id' => $order_details->id,
            );
            $update_data = array(
                'picking_agent' => $this->input->post('picking_agent'),
                'monitored_by' => $this->input->post('monitored_by'),
                'label_number' => $this->input->post('label_number')
            );
            //print_r($ship_details_data);
            $this->Order_model->ship_details($ship_details_data, $update_data);

            foreach ($order_items as $item) {

                $new_item = array('code' => $item->code, 'quantity' => $item->quantity, 'vpa' => $item->vpa);

                $result = $this->Order_model->insert_sent_order_ietms($new_item, $shop, $order_details->NR, $order_details->order_number);
                $result = $this->Order_model->insert_sent_order_ietms_2($new_item, $shop, $order_details->NR, $order_details->order_number);

                if ($result[0] == true) {
                    $new_item = array('code' => $item->code, 'quantity' => $result[1], 'vpa' => $item->vpa);
                    $result = $this->Order_model->insert_sent_order_ietms($new_item, $shop, $order_details->NR, $order_details->order_number);
                    $result = $this->Order_model->insert_sent_order_ietms_2($new_item, $shop, $order_details->NR, $order_details->order_number);
                }

                $this->Order_model->close_reservation($item->code, $this->session->userdata('shop'), $order_details->NR);
            }
            $this->submit_invoice($order_details->order_number);
        }
        $this->Order_model->ship($orders);

        redirect($this->config->item('admin_folder') . '/orders/new_shippments');
    }

    public function submit_invoice($order_number = false) {

        $detail = $this->Order_model->get_order_number($order_number);
        $cust = $this->Order_model->get_staff($detail->customer_id, $this->session->userdata('shop'));
        $current_details = $this->Order_model->get_current_order(array('id' => $detail->id, 'order_number' => $order_number));

        $invoice_address = $this->Customer_model->get_invoice_address($detail->customer_id);
        $delivery_address = $this->Customer_model->get_delivery_address($detail->customer_id);

        $last_id = $this->Invoice_model->get_last_id($this->shop_id);
        $last_record = $this->Invoice_model->get_shop_invoices($this->shop_id, $last_id->id);

        $last_record->invoice_number;

        //set the same column names in invoices table
        $order_details['shop_id'] = $this->shop_id;
        $order_details['customer_id'] = $detail->customer_id;

        $order_details['sent'] = '0';
        $order_details['fully_paid'] = '0';
        $order_details['order_number'] = form_decode($order_number);
        $order_details['order_id_number'] = $detail->id;
        $order_details['invoice_number'] = $last_record->invoice_number + 1;
        $order_details['order_dispatch_date'] = $detail->shipped_on;
        $order_details['created_on'] = date('Y-m-d');
        $order_details['created_by'] = $this->session->userdata('ba_username');
        $order_details['customer_number'] = $current_details->customer_number;
        $order_details['totalnet'] = $detail->subtotal;
        $order_details['totalgross'] = $detail->total;
        $order_details['office_staff'] = $cust->office_staff;
        $order_details['field_service'] = $cust->field_service;
        $order_details['dispatch_costs'] = $detail->shipping;
        $order_details['none_VAT'] = $detail->none_vat;
        $order_details['delivery_condition'] = $detail->delivery_condition;
        $order_details['company'] = $detail->company;
        $order_details['firstname'] = $detail->firstname;
        $order_details['lastname'] = $detail->lastname;
        $order_details['country_id'] = $detail->country_id;
        $order_details['VAT'] = $detail->VAT;
        $order_details['notes'] = $detail->invoice_agreements_notes;
        $order_details['payment_info'] = '';
        $order_details['payment_method'] = $detail->payment_method;
        if ($detail->payment_method = 'direct_debi') {
            $order_details['DD'] = '1';
        }
        $order_details['not_remind'] = $detail->not_remind;
        $order_details['per_email'] = $detail->invoice_per_email;
        $order_details['email'] = $detail->email;
        $order_details['currency'] = $detail->currency;

        $items = $this->Order_model->get_all_items($detail->NR, $detail->id);

        //$previus_invoices = $this->Invoice_model->check_invoice($order_number);
        $previus_invoices = '';

        if (empty($previus_invoices)) {

            $this->Invoice_model->insert_invoice($order_details);
            $new_order_id = $this->db->insert_id();

            $last_invoice_number = $this->Invoice_model->get_invoice_number($new_order_id);

            $invoice_items = array();
            foreach ($items as $item) {

                if (!empty($item->saleprice)) {
                    $unit_price = $item->saleprice;
                } else {
                    $unit_price = $item->original_price;
                }

                $invoice_items[] = array(
                    'shop_id' => $this->shop_id,
                    'order_id' => $item->order_id_number,
                    'order_number' => $item->order_id,
                    'invoice_number' => $last_invoice_number['invoice_number'],
                    'code' => $item->code,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'unit_price' => $unit_price,
                    'warehouse_price' => $item->warehouse_price,
                    'total' => $item->total,
                    'VAT' => $item->VAT,
                    'vpa' => $item->vpa,
                );
            }
            echo '<pre>';
            //print_r($invoice_items);
            echo '</pre>';
            $this->Invoice_model->insert_items($invoice_items);
            //redirect($this->config->item('admin_folder').'/invoices/view/'.$new_order_id);
        } else {

            if ($_POST) {

                if ($this->input->post('continue')) {

                    //$this->Invoice_model->insert_invoice($order_details);
                    $new_order_id = $this->db->insert_id();
                    $last_invoice_number = $this->Invoice_model->get_invoice_number($new_order_id);
                    $invoice_items = array();
                    foreach ($items as $item) {

                        $invoice_items[] = array(
                            'shop_id' => $this->data_shop,
                            'order_number' => $item['order_id'],
                            'invoice_number' => $last_invoice_number['invoice_number'],
                            'code' => $item['code'],
                            'description' => $item['description'],
                            'quantity' => $item['quantity'],
                            'unit_price' => $item['saleprice'],
                            'total' => $item['total'],
                            'VAT' => $item['VAT'],
                            'vpa' => $item['vpa'],
                        );
                    }
                    //$this->Invoice_model->insert_items($invoice_items);
                    //redirect($this->config->item('admin_folder').'/invoices/view/'.$new_order_id);
                }
            }

            $all_invoices = $this->Invoice_model->check_invoice($order_number);
            $data['all_invoices'] = $this->Invoice_model->list_existing_invoices($order_number);


            $data['order_id'] = $detail->id;
            $data['page_title'] = lang('order_has_invoice');
            $data['id'] = $order_number;

            //show a list of the maDE INVOICES
            //$this->load->view($this->config->item('admin_folder').'/confirm_invoice', $data);
        }
    }

    function new_shippments($sort_by = 'order_number', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();

        //if they submitted an export form do the export
        if ($this->input->post('submit') == 'export') {
            $this->load->model('customer_model');
            $this->load->helper('download_helper');
            $post = $this->input->post(null, false);
            $term = (object) $post;

            $data['orders'] = $this->Order_model->get_orders($term);

            foreach ($data['orders'] as &$o) {
                $o->items = $this->Order_model->get_items($o->id);
            }

            force_download_content('orders.xml', $this->load->view($this->config->item('admin_folder') . '/orders_xml', $data, true));

            //kill the script from here
            die;
        }

        $this->load->helper('form');
        $this->load->helper('date');

        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('new_shippments');
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
        $shop_id = $this->shop_id;
        $data['order_status'] = $this->input->post('status');
        $data['term'] = $term;


        $data['new_shipments'] = $this->Order_model->get_new_shipments($term, $sort_by, $sort_order, $rows, $page, $shop_id);
        $data['total'] = $this->Order_model->get_new_shipments_count($term);

        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/orders/processed_orders/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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
        $this->load->view($this->config->item('admin_folder') . '/new_shippments', $data);
    }

    function old_shippments($sort_by = 'VERZENDDAT', $sort_order = 'desc', $code = 0, $page = 0, $rows = 15) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        $data['categories'] = $this->categories;
        $data['groups'] = $this->groups;
        $data['products'] = $this->products;
        $data['all_shops'] = $this->Shop_model->get_shops();
        $data['message'] = $this->session->flashdata('message');
        $data['page_title'] = lang('old_shippments');
        $data['code'] = $code;
        $term = false;

        $data['order_status'] = $this->input->post('status');
        $data['customers'] = $this->Order_model->get_all_customers($this->shop_id);
        $data['old_shipments'] = $this->Order_model->get_old_shipments($term, $sort_by, $sort_order, $rows, $page, $this->shop_id);
        $data['total'] = $this->Order_model->get_old_shipments_count($term);

        $this->load->library('pagination');

        $config['base_url'] = site_url($this->config->item('admin_folder') . '/orders/old_shippments/' . $sort_by . '/' . $sort_order . '/' . $code . '/');
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

        $this->load->view($this->config->item('admin_folder') . '/old_shipments', $data);
    }

    function open_order($NR) {

        $id = $this->Order_model->get_id($NR, $this->shop_id);
        redirect($this->config->item('admin_folder') . '/orders/view/' . $id->id);
    }

    function open_order_old($NR) {

        $id = $this->Order_model->get_id($NR, $this->shop_id);
        redirect($this->config->item('admin_folder') . '/orders/order_details/' . $id->id);
    }

    public function submit_invoice_temp($o_id, $order_number) {

        $posted_invoice_number = $this->input->post('invoice_number');

        if (!empty($posted_invoice_number)) {



            $detail = $this->Order_model->get_order_number($order_number);
            $cust = $this->Order_model->get_staff($detail->customer_id, $this->session->userdata('shop'));
            $current_details = $this->Order_model->get_current_order(array('id' => $detail->id, 'order_number' => $order_number));

            $invoice_address = $this->Customer_model->get_invoice_address($detail->customer_id);
            $delivery_address = $this->Customer_model->get_delivery_address($detail->customer_id);

            $last_id = $this->Invoice_model->get_last_id($this->shop_id);


            $order_details['shop_id'] = $this->shop_id;
            $order_details['customer_id'] = $detail->customer_id;

            $order_details['sent'] = '0';
            $order_details['fully_paid'] = '0';
            $order_details['order_number'] = form_decode($order_number);
            $order_details['order_id_number'] = $detail->id;
            $order_details['invoice_number'] = $this->input->post('invoice_number');
            $order_details['order_dispatch_date'] = $detail->shipped_on;
            $order_details['created_on'] = date('Y-m-d');
            $order_details['created_by'] = $this->session->userdata('ba_username');
            $order_details['customer_number'] = $current_details->customer_number;
            $order_details['totalnet'] = $detail->subtotal;
            $order_details['totalgross'] = $detail->total;
            $order_details['office_staff'] = $cust->office_staff;
            $order_details['field_service'] = $cust->field_service;
            $order_details['dispatch_costs'] = $detail->shipping;
            $order_details['none_VAT'] = $detail->none_vat;
            $order_details['delivery_condition'] = $detail->delivery_condition;
            $order_details['company'] = $detail->company;
            $order_details['firstname'] = $detail->firstname;
            $order_details['lastname'] = $detail->lastname;
            $order_details['country_id'] = $detail->country_id;
            $order_details['VAT'] = $detail->VAT;
            $order_details['ship_vat_rate'] = $detail->ship_vat_rate;
            $order_details['vat_index'] = $detail->vat_index;
            $order_details['payment_info'] = '';
            $order_details['payment_method'] = $detail->payment_method;

            if ($detail->payment_method = 'direct_debi') {
                $order_details['DD'] = '1';
            }

            $order_details['not_remind'] = $detail->not_remind;
            $order_details['per_email'] = $detail->invoice_per_email;
            $order_details['email'] = $detail->email;
            $order_details['currency'] = $detail->currency;

            $items = $this->Order_model->get_all_items($detail->NR, $detail->id);

            //echo '<pre>';
            //print_r($order_details);
            //echo '</pre>';


            $this->Invoice_model->insert_invoice($order_details);
            $new_order_id = $this->db->insert_id();

            $invoice_items = array();

            foreach ($items as $item) {

                if ($item->saleprice > 0) {
                    $unit_price = $item->saleprice;
                } else {
                    $unit_price = $item->original_price;
                }

                $invoice_items[] = array(
                    'shop_id' => $this->shop_id,
                    'order_id' => $item->order_id_number,
                    'order_number' => $item->order_id,
                    'invoice_number' => $this->input->post('invoice_number'),
                    'code' => $item->code,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'unit_price' => $unit_price,
                    'warehouse_price' => $item->warehouse_price,
                    'total' => $item->total,
                    'VAT' => $item->vat_index,
                    'vat_ammount' => $item->VAT,
                    'special_vat' => $item->special_vat,
                    'vpa' => $item->vpa,
                );
            }

            //echo '<pre>';
            //print_r($invoice_items);
            //print_r($items);
            //echo '</pre>';

            $this->Invoice_model->insert_items($invoice_items);
            redirect($this->config->item('admin_folder') . '/invoices/view/' . $new_order_id);
        } else {

            $this->session->set_flashdata('no_num', 'No invoice number!');
            redirect($this->config->item('admin_folder') . '/orders/view/' . $o_id);
        }
    }

}
