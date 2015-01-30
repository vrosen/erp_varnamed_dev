<?php

class Admin extends MY_Controller {

    public $data_shop;
    public $language;
    

    function __construct() {
        parent::__construct();
        remove_ssl();

        //check admin access
        $this->load->model('Order_model');
        $this->load->model('Shop_model');
        $this->load->model('Search_model');
        $this->load->model(array('Customer_model', 'Group_model', 'Product_model', 'Category_model', 'Invoice_model'));
        ////////////////////////////////////////////////////////////////
        $this->load->helper('date');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('bitauth');
        $this->load->library('form_validation');
        $this->load->helper('formatting_helper');


        ////////////////////////////////////////////////////////////////
        $this->language = $this->session->userdata('language');
        
        $this->lang->load('dashboard', $this->language);
        $this->lang->load('admin', $this->language);
        $this->lang->load('downloads', $this->language);
        
    }

    public function index() {


        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        } else {

            if ($this->bitauth->is_admin()) {

                
                $this->data['bitauth'] = $this->bitauth;
                $this->data['users'] = $this->bitauth->get_users();
                $this->data['page_title'] = lang('admin_section');
                $timeid = $this->uri->segment(5);
                
                
                $this->load->view($this->config->item('admin_folder') . '/admins', $this->data);
            } else {
                redirect($this->config->item('admin_folder') . '/dashboard');
            }
        }
    }

    public function convert() {
        $this->load->dbforge();
        $this->dbforge->modify_column($this->bitauth->_table['groups'], array(
            'roles' => array(
                'name' => 'roles',
                'type' => 'text'
            )
        ));

        $query = $this->db->select('group_id, roles')->get($this->bitauth->_table['groups']);
        if ($query && $query->num_rows()) {
            foreach ($query->result() as $row) {
                $this->db->where('group_id', $row->group_id)->set('roles', $this->bitauth->convert($row->roles))->update($this->bitauth->_table['groups']);
            }
        }

        echo 'Update complete.';
    }

    public function login() {
        $this->data = array();
        $this->data['error'] = $this->session->flashdata('message');

        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('remember_me', 'Remember Me', '');

            if ($this->form_validation->run() == TRUE) {
                // Login
                if ($this->bitauth->login($this->input->post('username'), $this->input->post('password'), $this->input->post('remember_me'))) {
                    // Redirect
                    if ($redir = $this->session->userdata('redir')) {
                        $this->session->unset_userdata('redir');
                    }

                    redirect($this->config->item('admin_folder') . '/dashboard');
                } else {
                    $this->data['error'] = $this->bitauth->get_error();
                }
            } else {
                $this->data['error'] = validation_errors();
            }
        }

        $this->load->view($this->config->item('admin_folder') . '/login', $this->data);
    }

    public function register() {
        if ($this->input->post()) {

            $this->form_validation->set_rules('username', 'Username', 'trim|required|bitauth_unique_username');
            $this->form_validation->set_rules('fullname', 'Fullname', '');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|bitauth_valid_password');
            $this->form_validation->set_rules('password_conf', 'Password Confirmation', 'required|matches[password]');

            if ($this->form_validation->run() == TRUE) {

                unset($_POST['submit'], $_POST['password_conf']);
                $this->bitauth->add_user($this->input->post());

                redirect($this->config->item('admin_folder') . '/admin/login');
            }
        }

        $this->load->view($this->config->item('admin_folder') . '/register', array('title' => 'Register'));
    }

    public function add_user() {

        if (!$this->bitauth->logged_in()) {

            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        if (!$this->bitauth->has_role('admin')) {

            $this->load->view($this->config->item('admin_folder') . '/bitauth/no_access');
            return;
        }

        if ($this->input->post()) {

            $this->form_validation->set_rules('username', 'Username', 'trim|required|bitauth_unique_username');
            $this->form_validation->set_rules('fullname', 'Fullname', '');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|bitauth_valid_password');
            $this->form_validation->set_rules('password_conf', 'Password Confirmation', 'required|matches[password]');

            if ($this->form_validation->run() == TRUE) {
                unset($_POST['submit'], $_POST['password_conf']);
                $this->bitauth->add_user($this->input->post());
                redirect($this->config->item('admin_folder') . '/admin');
            }
        }
        
        $this->load->view($this->config->item('admin_folder') . '/add_user', array('page_title' => lang('add_new_admin'), 'title' => 'Add User', 'bitauth' => $this->bitauth));
    }

    public function edit_user($user_id) {
        //  echo $user_id;


        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        if (!$this->bitauth->has_role('admin')) {
            $this->load->view($this->config->item('admin_folder') . '/bitauth/no_access');
            return;
        }

        if ($this->input->post()) {
            if ($this->input->post('username')) {
                $this->form_validation->set_rules('username', 'Username', 'trim');
            }
            if ($this->input->post('fullname')) {
                $this->form_validation->set_rules('fullname', 'Fullname', '');
            }
            if ($this->input->post('email')) {
                $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
            }
            if ($this->input->post('active')) {
                $this->form_validation->set_rules('active', 'Active', '');
            }
            if ($this->input->post('enabled')) {
                $this->form_validation->set_rules('enabled', 'Enabled', '');
            }
            if ($this->input->post('password_never_expires')) {
                $this->form_validation->set_rules('password_never_expires', 'Password Never Expires', '');
            }
            if ($this->input->post('groups')) {
                $this->form_validation->set_rules('groups[]', 'Groups', '');
            }


            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', 'Password', 'bitauth_valid_password');
                $this->form_validation->set_rules('password_conf', 'Password Confirmation', 'required|matches[password]');
            }

            if ($this->form_validation->run() == TRUE) {
                unset($_POST['submit'], $_POST['password_conf']);
                $this->bitauth->update_user($user_id, $this->input->post());
                redirect($this->config->item('admin_folder') . '/admin');
            }
        }

        $groups = array();
        foreach ($this->bitauth->get_groups() as $_group) {
            $groups[$_group->group_id] = $_group->name;
        }

        

        $this->load->view($this->config->item('admin_folder') . '/edit_user', array('page_title' => lang('edit_user'), 'bitauth' => $this->bitauth, 'groups' => $groups, 'user' => $this->bitauth->get_user_by_id($user_id)));
    }

    public function groups() {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }
        
        $this->load->view($this->config->item('admin_folder') . '/groups', array('page_title' => lang('all_groups'), 'bitauth' => $this->bitauth, 'groups' => $this->bitauth->get_groups()));
    }

    public function add_group() {

        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        if (!$this->bitauth->has_role('admin')) {
            $this->load->view($this->config->item('admin_folder') . '/bitauth/no_access');
            return;
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Group Name', 'trim|required|bitauth_unique_group');
            $this->form_validation->set_rules('description', 'Description', '');
            $this->form_validation->set_rules('members[]', 'Members', '');
            $this->form_validation->set_rules('roles[]', 'Roles', '');

            if ($this->form_validation->run() == TRUE) {
                unset($_POST['submit']);
                $this->bitauth->add_group($this->input->post());
                redirect($this->config->item('admin_folder') . '/admin/groups');
            }
        }

        $users = array();
        foreach ($this->bitauth->get_users() as $_user) {
            $users[$_user->user_id] = $_user->fullname;
        }
        
        
        $this->load->view($this->config->item('admin_folder') . '/add_group', array('page_title' => lang('add_group'), 'bitauth' => $this->bitauth, 'roles' => $this->bitauth->get_roles(), 'users' => $users));
    }

    public function edit_group($group_id) {
        if (!$this->bitauth->logged_in()) {
            $this->session->set_userdata('redir', current_url());
            redirect($this->config->item('admin_folder') . '/admin/login');
        }

        /* if ( ! $this->bitauth->has_role('admin'))
          {
          $this->load->view($this->config->item('admin_folder').'/bitauth/no_access');
          return;
          } */

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Group Name', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', '');
            $this->form_validation->set_rules('members[]', 'Members', '');
            $this->form_validation->set_rules('roles[]', 'Roles', '');

            if ($this->form_validation->run() == TRUE) {
                unset($_POST['submit']);
                $this->bitauth->update_group($group_id, $this->input->post());
                redirect($this->config->item('admin_folder') . '/admin/groups');
            }
        }

        $users = array();
        foreach ($this->bitauth->get_users() as $_user) {
            $users[$_user->user_id] = $_user->fullname;
        }

        $group = $this->bitauth->get_group_by_id($group_id);

        $role_list = array();
        $roles = $this->bitauth->get_roles();
        foreach ($roles as $_slug => $_desc) {
            if ($this->bitauth->has_role($_slug, $group->roles)) {
                $role_list[] = $_slug;
            }
        }
        
        $this->load->view($this->config->item('admin_folder') . '/edit_group', array('page_title' => lang('edit_group'), 'id' => $group_id, 'bitauth' => $this->bitauth, 'roles' => $roles, 'group' => $group, 'group_roles' => $role_list, 'users' => $users));
    }

    public function downloads() {

        $this->data['page_title'] = lang('downloads');
        


        $this->load->view($this->config->item('admin_folder') . '/downloads', $this->data);
    }

    public function export_sepa_xml() {


        $this->load->helper('download_helper');

        $this->data['all_details'] = $this->Invoice_model->get_sepa_invoices(array('shop_id' => $this->data_shop));

        $this->data['MsgId'] = $this->config->item('MsgId');
        $this->data['CreDtTm'] = date('Y-m-d') . 'T' . date('h-i-s');
        $this->data['numoftaxes'] = $this->Invoice_model->count_invoices(array('shop_id' => $this->data_shop));
        $transaction_sum = $this->Invoice_model->get_transaction_sum(array('shop_id' => $this->data_shop));
        $this->data['cntrsum'] = $transaction_sum->totalgross;
        $shop_name = $this->Invoice_model->get_comapny_name($this->data_shop);
        $this->data['Nm'] = $shop_name->shop_name;
        $this->data['PmtMtd'] = 'DD'; //set in config
        $this->data['BtchBookg'] = 'true'; //set in config
        $this->data['CD'] = 'SEPA'; //set in config
        $this->data['Cd_DBT'] = 'CORE'; //set in config
        $this->data['SeqTp'] = 'FRST'; //set in config
        $this->data['IBAN_DBT'] = 'NL47INGB0004324404'; //set in config
        $this->data['BIC_DBT'] = 'INGBNL2A'; //set in config
        $this->data['MndtId'] = 'DE0001234'; //set in config.Our SEPA code
        $this->data['DtOfSgntr'] = '2009-11-01'; //set in config.Our SEPA code date od signature
        $this->data['AmdmntInd'] = 'false'; //set in config.
        $this->data['Id_CDT'] = 'NL23ZZZ272857100000'; //set in config.Our ID code
        $this->data['Cd_CDT'] = 'OTHR'; //This element describes the underlying reason for the payment transaction. The debtor uses this element to provide information to the creditor concerning the nature of the payment transaction.
        $this->data['CdOrPrtry_Cd'] = 'SCOR'; //The system assigns the hard-coded value of SCOR.
        $this->data['Issr'] = 'CUR'; //Issuer.This system specifies the supplier name, which is the tag name of element creditor.


        $this->data['PmtInfId'] = ''; //function result
        $this->data['ReqdColltnDt'] = ''; //function result.The date of the creation of the file + six days.
        $this->data['EndToEndId'] = ''; //function result.The system generates a unique key for each payment, comprised of the bank account, supplier, payment date, and the check control number



        $this->data['BIC_CDT'] = '';
        $this->data['Nm_CDT'] = '';
        $this->data['IBAN_CDT'] = '';
        $this->data['Ref'] = '';
        
        //force_download_content('customers.xml',	$this->load->view($this->config->item('admin_folder').'/customers_xml', $this->data, true));
        $this->load->view($this->config->item('admin_folder') . '/customers_xml_sepa', $this->data);
    }

    public function activate($activation_code) {

        if ($this->bitauth->activate($activation_code)) {
            $this->load->view($this->config->item('admin_folder') . '/bitauth/activation_successful');
            return;
        }

        $this->load->view($this->config->item('admin_folder') . '/bitauth/activation_failed');
    }

    public function logout() {
        $this->bitauth->logout();
        //redirect('admin');
        redirect($this->config->item('admin_folder') . '/admin');
    }

}
