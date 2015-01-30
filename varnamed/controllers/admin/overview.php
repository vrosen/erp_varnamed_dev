<?php
class Overview extends MY_Controller {

    //this is used when editing or adding a customer
    var $customer_id = false;

    function __construct() {
        parent::__construct();

        $this->load->model(array('Customer_model', "Calendar_model", 'Location_model', 'Order_model', 'Search_model', 'Sales_model', 'Invoice_model'));
        $this->load->model("Complex_model");
        $this->load->model("Complex_model2");
        ////////////////////////////////////////////////////////////////
        $this->load->helper('formatting_helper');

        $this->lang->load('overview', $this->language);
        $this->lang->load('dashboard', $this->language);
        $this->lang->load('order', $this->language);

        ////////////////////////////////////////////////////////////////
    }

    function index($field = 'CREATEDDAT', $by = 'DESC', $page = 0) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        //menu items


        $this->data['page_title'] = lang('customers');


        $agent = $this->input->post('agent');
        $this->data['agent'] = $agent;

        $this->data['invoices'] = $this->Invoice_model->overview_invoices($this->data_shop, $agent);
        $this->load->library('pagination');
        $config['base_url'] = base_url() . '/' . $this->config->item('admin_folder') . '/overview/index/' . $field . '/' . $by . '/';
        $config['total_rows'] = $this->Customer_model->count_customers_overview(array('shop_id' => $this->data_shop), $field, $by, $agent);

        $config['per_page'] = 50;
        $config['uri_segment'] = 6;
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


        $this->data['page'] = $page;
        $this->data['field'] = $field;
        $this->data['by'] = $by;
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $this->data['weather'] = _date($time);
        $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/client', $this->data);
    }

    function export_xml() {
        $this->load->helper('download_helper');

        $this->data['customers'] = (array) $this->Customer_model->get_customers();


        force_download_content('customers.xml', $this->load->view($this->config->item('admin_folder') . '/customers_xml', $this->data, true));

        //$this->load->view($this->config->item('admin_folder').'/customers_xml', $this->data);
    }

    function form($id = false) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        //menu items


        force_ssl();
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->data['page_title'] = lang('customer_form');

        //default values are empty if the customer is new
        $this->data['id'] = '';
        $this->data['group_id'] = '';
        $this->data['firstname'] = '';
        $this->data['lastname'] = '';
        $this->data['email'] = '';
        $this->data['phone'] = '';
        $this->data['company'] = '';
        $this->data['email_subscribe'] = '';
        $this->data['active'] = false;

        // get group list
        $groups = $this->Customer_model->get_groups();
        foreach ($groups as $group) {
            $group_list[$group->id] = $group->name;
        }
        $this->data['group_list'] = $group_list;



        if ($id) {
            $this->customer_id = $id;
            $customer = $this->Customer_model->get_customer($id);
            //if the customer does not exist, redirect them to the customer list with an error
            if (!$customer) {
                $this->session->set_flashdata('error', lang('error_not_found'));
                redirect($this->config->item('admin_folder') . '/customers');
            }

            //set values to db values
            $this->data['id'] = $customer->id;
            $this->data['group_id'] = $customer->group_id;
            $this->data['firstname'] = $customer->firstname;
            $this->data['lastname'] = $customer->lastname;
            $this->data['email'] = $customer->email;
            $this->data['phone'] = $customer->phone;
            $this->data['company'] = $customer->company;
            $this->data['active'] = $customer->active;
            $this->data['email_subscribe'] = $customer->email_subscribe;
        }

        $this->form_validation->set_rules('firstname', 'lang:firstname', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('lastname', 'lang:lastname', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|max_length[128]|callback_check_email');
        $this->form_validation->set_rules('phone', 'lang:phone', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('company', 'lang:company', 'trim|max_length[128]');
        $this->form_validation->set_rules('active', 'lang:active');
        $this->form_validation->set_rules('group_id', 'group_id', 'numeric');
        $this->form_validation->set_rules('email_subscribe', 'email_subscribe', 'numeric|max_length[1]');

        //if this is a new account require a password, or if they have entered either a password or a password confirmation
        if ($this->input->post('password') != '' || $this->input->post('confirm') != '' || !$id) {
            $this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]|sha1');
            $this->form_validation->set_rules('confirm', 'lang:confirm_password', 'required|matches[password]');
        }


        if ($this->form_validation->run() == FALSE) {
            $timeid = $this->uri->segment(5);
            if ($timeid == 0) {
                $time = time();
            } else {
                $time = $timeid;
            }
            $this->data['weather'] = _date($time);
            $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
            $this->load->view($this->config->item('admin_folder') . '/customer_form', $this->data);
        } else {
            $save['id'] = $id;
            $save['group_id'] = $this->input->post('group_id');
            $save['firstname'] = $this->input->post('firstname');
            $save['lastname'] = $this->input->post('lastname');
            $save['email'] = $this->input->post('email');
            $save['phone'] = $this->input->post('phone');
            $save['company'] = $this->input->post('company');
            $save['active'] = $this->input->post('active');
            $save['email_subscribe'] = $this->input->post('email_subscribe');


            if ($this->input->post('password') != '' || !$id) {
                $save['password'] = $this->input->post('password');
            }

            $this->Customer_model->save($save);

            $this->session->set_flashdata('message', lang('message_saved_customer'));

            //go back to the customer list
            redirect($this->config->item('admin_folder') . '/customers');
        }
    }

    function addresses($id = false) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items


        $this->data['customer'] = $this->Customer_model->get_customer($id);

        //if the customer does not exist, redirect them to the customer list with an error
        if (!$this->data['customer']) {
            $this->session->set_flashdata('error', lang('error_not_found'));
            redirect($this->config->item('admin_folder') . '/customers');
        }

        $this->data['addresses'] = $this->Customer_model->get_address_list($id);

        $this->current_admin = $this->session->userdata('admin');
        $this->data['admins'] = $this->auth->get_admin_list();


        $this->data['page_title'] = sprintf(lang('addresses_for'), $this->data['customer']->firstname . ' ' . $this->data['customer']->lastname);
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $this->data['weather'] = _date($time);
        $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/customer_addresses', $this->data);
    }

    function delete($id = false) {
        if ($id) {
            $customer = $this->Customer_model->get_customer($id);
            //if the customer does not exist, redirect them to the customer list with an error
            if (!$customer) {
                $this->session->set_flashdata('error', lang('error_not_found'));
                redirect($this->config->item('admin_folder') . '/customers');
            } else {
                //if the customer is legit, delete them
                $delete = $this->Customer_model->delete($id);

                $this->session->set_flashdata('message', lang('message_customer_deleted'));
                redirect($this->config->item('admin_folder') . '/customers');
            }
        } else {
            //if they do not provide an id send them to the customer list page with an error
            $this->session->set_flashdata('error', lang('error_not_found'));
            redirect($this->config->item('admin_folder') . '/customers');
        }
    }

    //this is a callback to make sure that customers are not sharing an email address
    function check_email($str) {
        $email = $this->Customer_model->check_email($str, $this->customer_id);
        if ($email) {
            $this->form_validation->set_message('check_email', lang('error_email_in_use'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function order_list($status = false) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        //menu items
        //we're going to use flash data and redirect() after form submissions to stop people from refreshing and duplicating submissions
        $this->load->model('Order_model');

        $this->current_admin = $this->session->userdata('admin');
        $this->data['admins'] = $this->auth->get_admin_list();


        $this->data['page_title'] = 'Order List';
        $this->data['orders'] = $this->Order_model->get_orders($status);
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $this->data['weather'] = _date($time);
        $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/order_list', $this->data);
    }

    // download email blast list (subscribers)
    function get_subscriber_list() {

        $subscribers = $this->Customer_model->get_subscribers();

        $sub_list = '';
        foreach ($subscribers as $subscriber) {
            $sub_list .= $subscriber['email'] . ",\n";
        }

        $this->current_admin = $this->session->userdata('admin');
        $this->data['admins'] = $this->auth->get_admin_list();

        $this->data['sub_list'] = $sub_list;
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $this->data['weather'] = _date($time);
        $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/customer_subscriber_list', $this->data);
    }

    //  customer groups
    function groups() {

        $this->data['groups'] = $this->Customer_model->get_groups();

        $this->current_admin = $this->session->userdata('admin');
        $this->data['admins'] = $this->auth->get_admin_list();

        $this->data['page_title'] = lang('customer_groups');
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $this->data['weather'] = _date($time);
        $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/customer_groups', $this->data);
    }

    function edit_group($id = 0) {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->data['page_title'] = lang('customer_group_form');

        //default values are empty if the customer is new        /*
          foreach($this->data['invoices'] as $m => $inv)
          {
          $t = 0.0;
          foreach($inv as $i1)
          {
          $t += $i1['totalgross'];
          }
          $this->data['invoices'][$m]['total'] =  $t;
          }
        

        $this->data['id'] = '';
        $this->data['name'] = '';
        $this->data['discount'] = '';
        $this->data['discount_type'] = '';

        if ($id) {
            $group = $this->Customer_model->get_group($id);

            $this->data['id'] = $group->id;
            $this->data['name'] = $group->name;
            $this->data['discount'] = $group->discount;
            $this->data['discount_type'] = $group->discount_type;
        }

        $this->form_validation->set_rules('name', 'lang:group_name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('discount', 'lang:discount', 'trim|required|numeric');
        $this->form_validation->set_rules('discount_type', 'lang:discount_type', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $timeid = $this->uri->segment(5);
            if ($timeid == 0) {
                $time = time();
            } else {
                $time = $timeid;
            }
            $this->data['weather'] = _date($time);
            $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
            $this->load->view($this->config->item('admin_folder') . '/customer_group_form', $this->data);
        } else {

            if ($id) {
                $save['id'] = $id;
            }

            $save['name'] = set_value('name');
            $save['discount'] = set_value('discount');
            $save['discount_type'] = set_value('discount_type');

            $this->Customer_model->save_group($save);
            $this->session->set_flashdata('message', lang('message_saved_group'));

            //go back to the customer group list
            redirect($this->config->item('admin_folder') . '/customers/groups');
        }
    }

    function get_group() {
        $id = $this->input->post('id');

        if (empty($id))
            return;

        echo json_encode($this->Customer_model->get_group($id));
    }

    function delete_group($id) {

        if (empty($id)) {
            return;
        }

        $this->Customer_model->delete_group($id);

        //go back to the customer list
        redirect($this->config->item('admin_folder') . '/customers/groups');
    }

    function address_list($customer_id) {

        $this->data['address_list'] = $this->Customer_model->get_address_list($customer_id);

        $this->current_admin = $this->session->userdata('admin');
        $this->data['admins'] = $this->auth->get_admin_list();
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $this->data['weather'] = _date($time);
        $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/address_list', $this->data);
    }

    function address_form($customer_id, $id = false) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        $this->data['id'] = $id;
        $this->data['company'] = '';
        $this->data['firstname'] = '';
        $this->data['lastname'] = '';
        $this->data['email'] = '';
        $this->data['phone'] = '';
        $this->data['address1'] = '';
        $this->data['address2'] = '';
        $this->data['city'] = '';
        $this->data['country_id'] = '';
        $this->data['zone_id'] = '';
        $this->data['zip'] = '';

        $this->data['customer_id'] = $customer_id;

        $this->data['page_title'] = lang('address_form');
        //get the countries list for the dropdown
        $this->data['countries_menu'] = $this->Location_model->get_countries_menu();

        if ($id) {
            $address = $this->Customer_model->get_address($id);

            //fully escape the address
            form_decode($address);

            //merge the array
            $this->data = array_merge($this->data, $address);

            $this->data['zones_menu'] = $this->Location_model->get_zones_menu($this->data['country_id']);
        } else {
            //if there is no set ID, the get the zones of the first country in the countries menu
            $this->data['zones_menu'] = $this->Location_model->get_zones_menu(array_shift(array_keys($this->data['countries_menu'])));
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('company', 'lang:company', 'trim|max_length[128]');
        $this->form_validation->set_rules('firstname', 'lang:firstname', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('lastname', 'lang:lastname', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('phone', 'lang:phone', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('address1', 'lang:address', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('address2', 'lang:address', 'trim|max_length[128]');
        $this->form_validation->set_rules('city', 'lang:city', 'trim|required');
        $this->form_validation->set_rules('country_id', 'lang:country', 'trim|required');
        $this->form_validation->set_rules('zone_id', 'lang:state', 'trim|required');
        $this->form_validation->set_rules('zip', 'lang:postcode', 'trim|required|max_length[32]');

        if ($this->form_validation->run() == FALSE) {
            $timeid = $this->uri->segment(5);
            if ($timeid == 0) {
                $time = time();
            } else {
                $time = $timeid;
            }
            $this->data['weather'] = _date($time);
            $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
            $this->load->view($this->config->item('admin_folder') . '/customer_address_form', $this->data);
        } else {

            $a['customer_id'] = $customer_id; // this is needed for new records
            $a['id'] = (empty($id)) ? '' : $id;
            $a['field_data']['company'] = $this->input->post('company');
            $a['field_data']['firstname'] = $this->input->post('firstname');
            $a['field_data']['lastname'] = $this->input->post('lastname');
            $a['field_data']['email'] = $this->input->post('email');
            $a['field_data']['phone'] = $this->input->post('phone');
            $a['field_data']['address1'] = $this->input->post('address1');
            $a['field_data']['address2'] = $this->input->post('address2');
            $a['field_data']['city'] = $this->input->post('city');
            $a['field_data']['zip'] = $this->input->post('zip');


            $a['field_data']['zone_id'] = $this->input->post('zone_id');
            $a['field_data']['country_id'] = $this->input->post('country_id');

            $country = $this->Location_model->get_country($this->input->post('country_id'));
            $zone = $this->Location_model->get_zone($this->input->post('zone_id'));

            $a['field_data']['zone'] = $zone->code;  // save the state for output formatted addresses
            $a['field_data']['country'] = $country->name; // some shipping libraries require country name
            $a['field_data']['country_code'] = $country->iso_code_2; // some shipping libraries require the code 

            $this->Customer_model->save_address($a);
            $this->session->set_flashdata('message', lang('message_saved_address'));

            redirect($this->config->item('admin_folder') . '/customers/addresses/' . $customer_id);
        }
    }

    function delete_address($customer_id = false, $id = false) {
        if ($id) {
            $address = $this->Customer_model->get_address($id);
            //if the customer does not exist, redirect them to the customer list with an error
            if (!$address) {
                $this->session->set_flashdata('error', lang('error_address_not_found'));

                if ($customer_id) {
                    redirect($this->config->item('admin_folder') . '/customers/addresses/' . $customer_id);
                } else {
                    redirect($this->config->item('admin_folder') . '/customers');
                }
            } else {
                //if the customer is legit, delete them
                $delete = $this->Customer_model->delete_address($id, $customer_id);
                $this->session->set_flashdata('message', lang('message_address_deleted'));

                if ($customer_id) {
                    redirect($this->config->item('admin_folder') . '/customers/addresses/' . $customer_id);
                } else {
                    redirect($this->config->item('admin_folder') . '/customers');
                }
            }
        } else {
            //if they do not provide an id send them to the customer list page with an error
            $this->session->set_flashdata('error', lang('error_address_not_found'));

            if ($customer_id) {
                redirect($this->config->item('admin_folder') . '/customers/addresses/' . $customer_id);
            } else {
                redirect($this->config->item('admin_folder') . '/customers');
            }
        }
    }

    function to_do_list_client($field = 'lastname', $by = 'ASC', $page = 0) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        $this->data['page_title'] = 'Te doen per klant';
        $this->data['actions'] = $this->Customer_model->get_client_action($this->data_shop);
        $this->data['client'] = $this->Customer_model->get_all_clients_array($this->data_shop);

        if (!empty($this->data['client'])) {
            foreach ($this->data['client'] as $v) {
                @$new_arr[$v['NR']] = array($v['company']);
            }

            $this->data['clients'] = $new_arr;
        }
        //echo '<pre>';
        //print_r($new_arr);
        //echo '</pre>';

        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $this->data['weather'] = _date($time);
        $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/client_to_do_list', $this->data);
    }

    function to_do_list_agent() {

        if (!$this->bitauth->logged_in()) {

            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        //menu items



        $this->data['page_title'] = 'Te doen per middel';

        $this->data['c_id'] = $this->session->userdata('ba_c_login');
        $this->data['d_id'] = $this->session->userdata('ba_d_login');

        $this->data['staff_array_val'] = $this->input->post('agent');
        $agent_index = $this->input->post('agent');
        $this->data['actions'] = $this->Customer_model->get_agent_action($agent_index, $this->data_shop);
        if (!empty($agent_index)) {
            $this->data['client'] = $this->Customer_model->get_all_agent_clients_array($agent_index, $this->data_shop);
        } else {
            $this->data['client'] = $this->Customer_model->get_all_agent_clients_array($this->data['staff_array_val'], $this->data_shop);
        }
        if (!empty($this->data['client'])) {
            foreach ($this->data['client'] as $v) {
                @$new_arr[$v['NR']] = array($v['company']);
            }

            $this->data['clients'] = $new_arr;
        }
        //echo '<pre>';
        //print_r($new_arr);
        //echo '</pre>';
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $this->data['weather'] = _date($time);
        $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));

        $this->load->view($this->config->item('admin_folder') . '/agent_to_do_list', $this->data);
    }

    function debtors($field = 'lastname', $by = 'ASC', $page = 0) {
        if (!$this->bitauth->logged_in()) {

            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        $this->data['page_title'] = lang('debtors');

        $this->data['debtors'] = $this->Customer_model->get_debtors(array('shop_id' => $this->data_shop, 'limit' => 50), $page, $field, $by);

        $this->load->library('pagination');

        $config['base_url'] = base_url() . '/' . $this->config->item('admin_folder') . '/overview/debtors/' . $field . '/' . $by . '/';
        $config['total_rows'] = $this->Customer_model->count_customers();
        $config['per_page'] = 50;
        $config['uri_segment'] = 6;
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


        $this->data['page'] = $page;
        $this->data['field'] = $field;
        $this->data['by'] = $by;


        $this->current_admin = $this->session->userdata('admin');
        $this->data['admins'] = $this->auth->get_admin_list();


        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $this->data['weather'] = _date($time);
        $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/debtors', $this->data);
    }

    public function web_orders($field = 'lastname', $by = 'ASC', $page = 0) {

        if (!$this->bitauth->logged_in()) {

            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        $this->data['page_title'] = lang('web_orders');



        $this->load->library('pagination');

        $this->data['period'] = $this->input->post('period');

        $this->data['web_orders'] = $this->Order_model->get_web_orders($this->data_shop, $this->data['period']);

        $config['base_url'] = base_url() . '/' . $this->config->item('admin_folder') . '/overview/to_do_list/' . $field . '/' . $by . '/';
        $config['total_rows'] = $this->Order_model->count_web_orders($this->data_shop);
        $config['per_page'] = 50;
        $config['uri_segment'] = 6;
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


        $this->data['page'] = $page;
        $this->data['field'] = $field;
        $this->data['by'] = $by;
        $timeid = $this->uri->segment(5);
        if ($timeid == 0) {
            $time = time();
        } else {
            $time = $timeid;
        }
        $this->data['weather'] = _date($time);
        $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        $this->load->view($this->config->item('admin_folder') . '/web_orders', $this->data);
    }

    public function profit_per_agent($addfilter = false, $id = false) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        if ($this->bitauth->has_role('can_overview')) {

            $this->data['page_title'] = lang('sales');

            $period = $this->input->post('period') ? $this->input->post('period') : ($this->session->userdata('overperiod') ? $this->session->userdata('overperiod') : 12);

            $this->session->set_userdata('overperiod', $period);
            $options = array(
                'agent' => $this->input->post('agent'),
                'period' => $period
            );
            $agent_request = $this->input->post('agent');
            if (!empty($_POST) && !empty($agent_request)) {
                $this->data['agent_profit'] = $this->Sales_model->get_agent_profit($this->data_shop, $options);
                $this->data['agent_profit_details'] = $this->Sales_model->get_agent_profit_details($this->data_shop, $options);
            } else if ($this->data_shop) {
                // all agents here
                // temporary
                $this->session->set_userdata('overyear', '2014');
                $this->session->set_userdata('overmonth', '03');
                //$this->Complex_model->setIndexField('customer_id','invoices','customers','id');
                //$this->Complex_model->setNameField('customers.company');
                //$this->Complex_model->addExtraWhere("invoices.field_service",172);
                $this->data['profit_per_agent'] = $this->Complex_model->getTurnover();
            }
            $this->data['selected_agent'] = $this->input->post('agent');
            $this->data['selected_period'] = $period;
            $timeid = $this->uri->segment(5);
            if ($timeid == 0) {
                $time = time();
            } else {
                $time = $timeid;
            }
            $this->data['weather'] = _date($time);
            $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
            $this->load->view($this->config->item('admin_folder') . '/agent_profit', $this->data);
        }
    }

    //
    public function agent($id) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        $this->data['page_title'] = lang('sales');

        if ($this->bitauth->has_role('can_overview')) {
            if ($this->input->post('year')) {
                $year = $this->input->post('year');
            } elseif ($this->session->userdata('overyear')) {
                $year = $this->session->userdata('overyear');
            } else {
                $year = date('Y');
            }
            //
            if ($this->input->post('month')) {
                $month = $this->input->post('month');
            } elseif ($this->session->userdata('overmonth')) {
                $month = $this->session->userdata('overmonth');
            } else {
                $month = date('m');
            }
            // set session 
            $this->session->set_userdata('overyear', $year);
            $this->session->set_userdata('overmonth', $month);
            // $temporary 
            // $month = '03';
            //
            $this->data['year'] = $year;
            $this->data['month'] = $month;
            $this->data['id'] = $id;
            $a = $this->Sales_model->get_agent_data($id);
            if ($a)
                $this->data['agent'] = $a[0];
            else {
                $this->data['agent'] = array();
            }
            $this->data['res'] = $this->Sales_model->get_agent_sales($id, $year, $month, $this->session->userdata('shop'));
            $this->load->view($this->config->item('admin_folder') . '/agent_month', $this->data);
        }
    }

    //
    //
    public function client($id) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        if ($this->bitauth->has_role('can_overview')) {
            if ($this->input->post('year')) {
                $year = $this->input->post('year');
                echo "cp1\n";
            } elseif ($this->session->userdata('overyear')) {
                $year = $this->session->userdata('overyear');
                echo "cp2\n";
            } else {
                $year = date('Y');
                echo "cp3";
            }
            //
            if ($this->input->post('month')) {
                $month = $this->input->post('month');
                echo "mp1\n";
            } elseif ($this->session->userdata('overmonth')) {
                $month = $this->session->userdata('overmonth');
                echo "mp2\n";
            } else {
                $month = date('m');
                echo "pp3";
            }
            // set session 
            $this->session->set_userdata('overyear', $year);
            $this->session->set_userdata('overmonth', $month);

            // temporary 
            // $month = '03';
            //
            $this->data['year'] = $year;
            $this->data['month'] = $month;
            $this->data['id'] = $id;
            $a = $this->Sales_model->get_client_data($id);
            if ($a)
                $this->data['customer'] = $a[0];
            else {
                $this->data['customer'] = array();
            }
            $this->data['res'] = $this->Sales_model->get_client_sales($id, $year, $month, $this->session->userdata('shop'));
            //echo "<pre>";
            //print_r($this->data);
            //exit;
            $this->load->view($this->config->item('admin_folder') . '/client_month', $this->data);
        }
    }

    public function product($id) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        $this->data['page_title'] = lang('sales');

        if ($this->bitauth->has_role('can_overview')) {
            if ($this->input->post('year')) {
                $year = $this->input->post('year');
                echo "cp1\n";
            } elseif ($this->session->userdata('overyear')) {
                $year = $this->session->userdata('overyear');
                echo "cp2\n";
            } else {
                $year = date('Y');
                echo "cp3";
            }
            //
            if ($this->input->post('month')) {
                $month = $this->input->post('month');
                echo "mp1\n";
            } elseif ($this->session->userdata('overmonth')) {
                $month = $this->session->userdata('overmonth');
                echo "mp2\n";
            } else {
                $month = date('m');
                echo "pp3";
            }
            // set session 
            $this->session->set_userdata('overyear', $year);
            $this->session->set_userdata('overmonth', $month);
            // temporary 
            // $month = '03';
            //
            $this->data['year'] = $year;
            $this->data['month'] = $month;
            $this->data['id'] = $id;
            $a = $this->Sales_model->get_product_data($id);
            if ($a)
                $this->data['product'] = $a[0];
            else {
                $this->data['product'] = array();
            }
            // echo "<pre>";
            // print_r( $this->data['product']);
            // exit;
            $this->data['res'] = $this->Sales_model->get_product_sales($id, $year, $month, $this->session->userdata('shop'));
            //echo "<pre>";
            //print_r($this->data);
            //exit;
            $this->load->view($this->config->item('admin_folder') . '/product_month', $this->data);
        }
    }

    /*
     * Show turnover by categories group product --------------------
     */

    public function products($addfilter = false, $id = false) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        if ($this->bitauth->has_role('can_overview')) {

            if ($addfilter == 'products') {
                // get proct id
                if (!$id)
                    redirect($this->config->item('admin_folder') . '/overview/product');
                $pid = $this->Complex_model2->getProductId($id);
                if (!$pid) {
                    redirect($this->config->item('admin_folder') . '/overview/product');
                } else
                    redirect($this->config->item('admin_folder') . '/products/form/' . $pid);
            }
            // Prepare model and view ------------------------------------------
            // Set shop
            $this->Complex_model2->setShopId($this->session->userdata('shop'));
            //
            $filter = $this->filterPrepare3($addfilter, $id);
            $this->data['bc'] = $filter; // add to view
            switch ($addfilter) {
                case "category":
                    $showBy = "group";
                    break;
                case "group":
                    $showBy = "products";
                    break;
                default:
                    $showBy = "category";
            }
            $this->data['showBy'] = $showBy;
            $this->Complex_model2->setShowBy($showBy);
            //
            if ($this->input->post('year')) {
                $year = $this->input->post('year');
            } elseif ($this->session->userdata('overyear')) {
                $year = $this->session->userdata('overyear');
            } else {
                $year = date('Y');
            }
            //
            if ($this->input->post('month')) {
                $month = $this->input->post('month');
            } elseif ($this->session->userdata('overmonth')) {
                $month = $this->session->userdata('overmonth');
            } else {
                $month = date('m');
            }
            // set session 
            $this->session->set_userdata('overyear', $year);
            $this->session->set_userdata('overmonth', $month);
            //
            $fromDate = $year . "-" . $month . "-01";
            $toDate = date("Y-m-d", strtotime($fromDate . " +1 months"));
            //
            $this->data['year'] = $year;
            $this->data['month'] = $month;
            // Get data from model ---------------------------------------------
            $this->data['res'] = $this->Complex_model2->productTurnover($fromDate, $toDate);
            // echo "<pre>";
            // print_r($this->data['res']);
            // echo "</pre>";
            //exit;
            // Prepare other data 
            $this->data['page_title'] = lang('sales');

            $time = time();
            $this->data['weather'] = _date($time);
            $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
            //
            $this->load->view($this->config->item('admin_folder') . '/turnoverproduct', $this->data);
        }
    }

    /*
     * So far just test of new models that
     * get filed service from customer ///////////////////////
     */

    public function turnover($addfilter = false, $id = false) {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        if ($this->bitauth->has_role('can_overview')) {

            // Prepare model and view ------------------------------------------
            // Set shop
            $this->Complex_model2->setShopId($this->session->userdata('shop'));
            // Set filter inside in model
            $filter = $this->filterPrepare2($addfilter, $id);
            $this->data['filter'] = $filter; // add to view
            // show by
            $showBy = $this->input->post('showBy') ? $this->input->post('showBy') : (
                    $this->session->userdata('showBy') ? $this->session->userdata('showBy') : ""
                    );
            $this->data['showBy'] = $showBy;
            $this->Complex_model2->setShowBy($showBy);
            $this->session->set_userdata('showBy', $showBy);
            // Get data from model ---------------------------------------------
            $this->data['res'] = $this->Complex_model2->turnover12();
            // Prepare other data 
            $this->data['page_title'] = lang('sales');


            // $this->setData();
            $this->load->view($this->config->item('admin_folder') . '/turnover2', $this->data);
        }
    }

    private function filterPrepare2($addfilter = false, $id = false) {
        $filter = array();
        $filterModel = array();
        // filter from POST
        if ($_POST && $this->input->post("filterModel")) {
            $filterModel = $this->input->post("filterModel");
        } else if (!$_POST && $this->session->userdata('filterModel')) {
            $filterModel = $this->session->userdata('filterModel');
        }
        if ($addfilter && $id !== false) {
            $filterModel[$addfilter] = $id;
        }
        // save model filter to session
        $this->session->set_userdata('filterModel', $filterModel);
        // and model -----------------------------
        // prepare view filter
        foreach ($filterModel as $k => $v) {
            if (!is_array($v)) {
                switch ($k) {
                    case "category":
                        if ($v) {
                            $a['id'] = $v;
                            $a['name'] = $this->Complex_model2->getCategory($a['id']);
                        } else {
                            $a['id'] = 0;
                            $a['name'] = "No Category";
                        }
                        break;
                    case "group":
                        if ($v) {
                            $a['id'] = $v;
                            $a['name'] = $this->Complex_model2->getGroup($a['id']);
                        } else {
                            $a['id'] = 0;
                            $a['name'] = "No Group";
                        }
                        break;
                    case "products":
                        if ($v) {
                            $a['id'] = $v;
                            $a['name'] = $this->Complex_model2->getProduct($a['id']);
                        } else {
                            $a['id'] = 0;
                            $a['name'] = "No Product";
                        }
                        break;
                    case "agents":
                        $a['id'] = $v;
                        if (!$v)
                            $a['name'] = "No Name";
                        else {
                            $a['name'] = $this->Complex_model2->getAgent($a['id']);
                        }
                        break;
                    case "country":
                        $a['id'] = $v;
                        if (!$v)
                            $a['name'] = "No Country";
                        else
                            $a['name'] = $v;
                        break;
                    default:
                        $a['name'] = $v;
                        $a['id'] = $v;
                }
                $filter[$k] = $a;
            }
        }
        return($filter);
    }

    /**
     * filter for overview product 
     * @param type $addfilter string type of filtering
     * @param type $id of item to filter
     * @return type
     */
    private function filterPrepare3($addfilter = false, $id = false) {
        $filter = array();
        $filterModelProduct = array();
        // filter from POST
        if ($this->session->userdata('filterModelProduct')) {
            $filterModel = $this->session->userdata('filterModelProduct');
        }
        if (!$addfilter) {
            // drop filter 
            $filterModel = array();
        }
        if ($addfilter && $id !== false) {
            $filterModel[$addfilter] = $id;
            if ($addfilter == 'category')
                unset($filterModel['group']);
        }
        // save model filter to session
        $this->session->set_userdata('filterModelProduct', $filterModel);
        // and model -----------------------------
        $this->Complex_model2->setFilter($filterModel);
        // prepare view filter actually links
        // for category
        if (isset($filterModel['category'])) {
            // get category name
            $title = $this->Complex_model2->getCategory($filterModel['category']);
            // produce link to top
            $link = "<a href='";
            $link .= site_url($this->config->item('admin_folder') . '/overview/products');
            $link .= "'>Top(Category List)</a>";
            $filter[] = $link;
            // produce link
            $link = "<a href='";
            $link .= site_url($this->config->item('admin_folder') . '/overview/products/category/' . $filterModel['category'] . "/w");
            $link .= "'>$title</a>";
            $filter[] = $link;
            // add to array
        }
        // same for groups
        if (isset($filterModel['group'])) {
            $title = $this->Complex_model2->getGroup($filterModel['group']);
            $filter[] = $title;
        }
        // same for products nothing redirect on top level
        return($filter);
    }

    public function fix() {
        ////////////////////////////////////////////
        $shop_id = $this->session->userdata('shop');
        $sql = "SELECT invoices.invoice_number, invoices.created_on, invoices.totalnet AS totanet ,
        invoices.order_number, orders.id, orders.NR, SUM( `d`.`total` ) AS total, COUNT(`d`.`total`) AS ni,
        invoices.customer_number
        FROM (
        `invoices`
        )
        LEFT JOIN `invoice_items` AS d ON `invoices`.`invoice_number` = `d`.`invoice_number`
        LEFT JOIN orders ON orders.order_number = invoices.order_number
        AND orders.shop_id = $shop_id
        WHERE `invoices`.`shop_id` = '$shop_id'
        AND `invoices`.`created_on` >= '2014-06-01'
        AND `invoices`.`created_on` < '2014-07-01'
        GROUP BY `invoices`.`invoice_number`
        HAVING total IS NULL ";
        echo "<pre>";
        echo $shop_id . "\n";
        echo $sql . "\n";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            print_r($row);
            if ($row['ni'] == 0) {
                $sql1 = "SELECT * FROM order_items WHERE shop_id = $shop_id AND order_id='" . $row['NR'] . "'";
                $query1 = $this->db->query($sql1);

                foreach ($query1->result_array() as $row1) {
                    print_r($row1);
                    $unit_price = $row1['saleprice'] ? $row1['saleprice'] : $row1['original_price'];
                    $warehouse_price = $row1['warehouse_price'] ? $row1['warehouse_price'] : 0;
                    $sql2 = "INSERT IGNORE INTO invoice_items SET "
                            . "shop_id=$shop_id, "
                            . "invoice_number='" . $row['invoice_number'] . "', "
                            . "code='" . $row1['code'] . "', "
                            . "description='" . $row1['description'] . "', "
                            . "VE='" . $unit_price . "', "
                            . "quantity='" . $row1['quantity'] . "' ,"
                            . "unit_price = '" . $unit_price . "', "
                            . "total='" . ($unit_price * $row1['quantity']) . "', "
                            . "warehouse_price='" . $warehouse_price . "', "
                            . "total_warehouse_price='" . ($warehouse_price * $row1['quantity']) . "', "
                            . "profit='" . ($unit_price * $row1['quantity'] - $warehouse_price * $row1['quantity']) . "', "
                            . "margin='" . $row1['margin'] . "' ,"
                            . "VAT='" . $row1['VAT'] . "' ,"
                            . "vpa='" . $row1['vpa'] . "'";
                    echo "$sql2\n";
                    $query2 = $this->db->query($sql2);
                }
            }
        }
        exit;
    }

    //
    //
    public function fix2() {
        $shop_id = $this->session->userdata('shop');
        $sql = "SELECT invoices.invoice_number, invoices.created_on, invoices.totalnet AS totanet ,
        invoices.order_number, orders.id, orders.NR, SUM( `d`.`total` ) AS total, COUNT(`d`.`total`) AS ni,
        invoices.customer_number
        FROM (
        `invoices`
        )
        LEFT JOIN `invoice_items` AS d ON `invoices`.`invoice_number` = `d`.`invoice_number`
        LEFT JOIN orders ON orders.order_number = invoices.order_number
        WHERE `invoices`.`shop_id` = '$shop_id'
        AND `invoices`.`created_on` >= '2014-06-01'
        AND `invoices`.`created_on` < '2014-07-01'
        GROUP BY `invoices`.`invoice_number`
        HAVING total !=  invoices.totalnet";
        echo "<pre>";
        echo $shop_id . "\n";
        echo $sql . "\n";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            print_r($row);
            $sql1 = "UPDATE invoices SET totalnet='" . $row['total'] . "' "
                    . "WHERE shop_id=$shop_id AND invoice_number='" . $row['invoice_number'] . "' ";
            echo $sql1 . "\n";
            $query1 = $this->db->query($sql1);
        }
        exit;
    }

    //
    public function fix3() { /////////////////////////////////////////
        $shop_id = $this->session->userdata('shop');
        $sql = "SELECT invoices.invoice_number, invoices.created_on, invoices.totalnet AS totanet ,
        invoices.order_number, orders.id, orders.NR, orders.country_id,
        invoices.customer_number
        FROM (
        `invoices`
        )
        LEFT JOIN `invoice_items` AS d ON `invoices`.`invoice_number` = `d`.`invoice_number`
        LEFT JOIN orders ON orders.order_number = invoices.order_number
        AND orders.shop_id = $shop_id
        WHERE `invoices`.`shop_id` = '$shop_id'
        AND `invoices`.`created_on` >= '2014-06-16'
        AND `invoices`.`created_on` < '2014-07-01'";
        echo "<pre>";
        echo $shop_id . "\n";
        echo $sql . "\n";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            print_r($row);

            $sql1 = "UPDATE invoices SET country_id='" . $row['country_id'] . "' "
                    . "WHERE shop_id=$shop_id AND invoice_number='" . $row['invoice_number'] . "' ";
            echo $sql1 . "\n";
            $query1 = $this->db->query($sql1);
        }
        exit;
    }

    // strict join ///////////////////////////////////
    public function sales($filter = false, $id = false) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        if ($this->bitauth->has_role('can_overview')) {
            $this->data['page_title'] = lang('sales');

            //
            if ($this->input->post('year')) {
                $year = $this->input->post('year');
            } elseif ($this->session->userdata('overyear')) {
                $year = $this->session->userdata('overyear');
            } else {
                $year = date('Y');
            }
            //
            if ($this->input->post('month')) {
                $month = $this->input->post('month');
            } elseif ($this->session->userdata('overmonth')) {
                $month = $this->session->userdata('overmonth');
            } else {
                $month = date('m');
            }
            // set session 
            $this->session->set_userdata('overyear', $year);
            $this->session->set_userdata('overmonth', $month);
            //
            $fromDate = $year . "-" . $month . "-01";
            $toDate = date("Y-m-d", strtotime($fromDate . " +1 months"));
            //
            $this->data['year'] = $year;
            $this->data['month'] = $month;
            //
            $this->Complex_model2->setShopId($this->session->userdata('shop'));
            //
            $this->data['filter'] = $filter;
            switch ($filter) {
                case "management":
                    $b = array();
                    $b[] = anchor($this->config->item('admin_folder') . '/overview/sales', 'Top Report');
                    $b[] = "Intersale";
                    $this->data['bc'] = $b;
                    $this->data['res'] = $this->Complex_model2->hasNameAgentIntersale($fromDate, $toDate);
                    break;
                case "agentsi":
                    $b = array();
                    $b[] = anchor($this->config->item('admin_folder') . '/overview/sales', 'Top Report');
                    $b[] = anchor($this->config->item('admin_folder') . '/overview/sales/mamagement', 'Management');
                    $dq = $this->Sales_model->get_agent_data($id);
                    // 
                    $b[] = $dq[0]['agent_name'];
                    $this->data['bc'] = $b;
                    $this->data['res'] = $this->Complex_model2->hasNameAgentCustomerIntersale($id, $fromDate, $toDate);
                    break;
                case "mcustomeri":
                    $b = array();
                    $b[] = anchor($this->config->item('admin_folder') . '/overview/sales', 'Top Report');
                    $b[] = anchor($this->config->item('admin_folder') . '/overview/sales/mamagement', 'Management');
                    //
                    $dq = $this->Sales_model->get_client_data($id);
                    $cd = $dq[0];
                    $ad = $this->Sales_model->get_agent_data($cd['field_service']);
                    $agentData = $ad[0];
                    $b[] = anchor($this->config->item('admin_folder') . '/overview/sales/agentsi/' . $agentData['agent_index'], $agentData['agent_name']);
                    // final link
                    $b[] = anchor($this->config->item('admin_folder') . '/customers/form/' . $cd['id'], $id . ":" . $cd['company']);
                    // get data
                    $this->data['res'] = $this->Complex_model2->customerProducts($fromDate, $toDate, $id);
                    $this->data['bc'] = $b;
                    //
                    break;
                case "noname":
                    $b = array();
                    $b[] = anchor($this->config->item('admin_folder') . '/overview/sales', 'Top Report');
                    $b[] = "No Name";
                    $this->data['bc'] = $b;
                    $this->data['res'] = $this->Complex_model2->noNameCust($fromDate, $toDate);
                    break;
                case "sales":
                    $b = array();
                    $b[] = anchor($this->config->item('admin_folder') . '/overview/sales', 'Top Report');
                    $b[] = "Sales";
                    $this->data['bc'] = $b;
                    $this->data['res'] = $this->Complex_model2->hasNameAgent($fromDate, $toDate);
                    break;
                case "agents":
                    $b = array();
                    $b[] = anchor($this->config->item('admin_folder') . '/overview/sales', 'Top Report');
                    $b[] = anchor($this->config->item('admin_folder') . '/overview/sales/sales', 'Sales');
                    $dq = $this->Sales_model->get_agent_data($id);
                    // 
                    $b[] = $dq[0]['agent_name'];
                    $this->data['bc'] = $b;
                    $this->data['res'] = $this->Complex_model2->hasNameAgentCustomer($id, $fromDate, $toDate);
                    break;
                case "mcustomer":
                    $b = array();
                    $b[] = anchor($this->config->item('admin_folder') . '/overview/sales', 'Top Report');
                    //
                    $dq = $this->Sales_model->get_client_data($id);
                    $cd = $dq[0];
                    if (empty($cd['field_service'])) {
                        // empty
                        $b[] = anchor($this->config->item('admin_folder') . '/overview/sales/noname', 'No Name');
                    } else {
                        $ad = $this->Sales_model->get_agent_data($cd['field_service']);
                        if (empty($ad)) {
                            // empty
                            $b[] = anchor($this->config->item('admin_folder') . '/overview/sales/noname', 'No Name');
                        } else {
                            // no empty
                            $agentData = $ad[0];
                            $b[] = anchor($this->config->item('admin_folder') . '/overview/sales/sales', 'Sales');
                            $b[] = anchor($this->config->item('admin_folder') . '/overview/sales/agents/' . $agentData['agent_index'], $agentData['agent_name']);
                        }
                    }
                    // final link
                    $b[] = anchor($this->config->item('admin_folder') . '/customers/form/' . $cd['id'], $id . ":" . $cd['company']);
                    // get data
                    $this->data['res'] = $this->Complex_model2->customerProducts($fromDate, $toDate, $id);
                    $this->data['bc'] = $b;
                    //
                    break;
                case "mcustomern":
                    $b = array();
                    $b[] = anchor($this->config->item('admin_folder') . '/overview/sales', 'Top Report');
                    //
                    $dq = $this->Sales_model->get_client_data($id);
                    $cd = $dq[0];
                    if (empty($cd['field_service'])) {
                        // empty
                        $b[] = anchor($this->config->item('admin_folder') . '/overview/sales/noname', 'No Name');
                    } else {
                        $ad = $this->Sales_model->get_agent_data($cd['field_service']);
                        if (empty($ad)) {
                            // empty
                            $b[] = anchor($this->config->item('admin_folder') . '/overview/sales/noname', 'No Name');
                        } else {
                            // no empty
                            $agentData = $ad[0];
                            $b[] = anchor($this->config->item('admin_folder') . '/overview/sales/sales', 'Sales');
                            $b[] = anchor($this->config->item('admin_folder') . '/overview/sales/agents/' . $agentData['agent_index'], $agentData['agent_name']);
                        }
                    }
                    // final link
                    $b[] = anchor($this->config->item('admin_folder') . '/customers/form/' . $cd['id'], $id . ":" . $cd['company']);
                    // get data
                    $this->data['res'] = $this->Complex_model2->customerProductsNoName($fromDate, $toDate, $id);
                    $this->data['bc'] = $b;
                    //
                    break;
                default:
                    $this->data['res'] = $this->Complex_model2->topTable($fromDate, $toDate);
                    $this->data['bc'] = array("Top Report");
            }

            $this->load->view($this->config->item('admin_folder') . '/top_report', $this->data);
        }
    }

    // -------------------------
//THE CLASS ENDS HERE
}
