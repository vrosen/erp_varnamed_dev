<?php

Class Sales_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_settings($code) {
        $this->db->where('code', $code);
        $result = $this->db->get('settings');

        $return = array();
        foreach ($result->result() as $results) {
            $return[$results->setting_key] = $results->setting;
        }
        return $return;
    }

    /*
      settings should be an array
      array('setting_key'=>'setting')
      $code is the item that is calling it
      ex. any shipping settings have the code "shipping"
     */

    function save_settings($code, $values) {

        //get the settings first, this way, we can know if we need to update or insert settings
        //we're going to create an array of keys for the requested code
        $settings = $this->get_settings($code);


        //loop through the settings and add each one as a new row
        foreach ($values as $key => $value) {
            //if the key currently exists, update the setting
            if (array_key_exists($key, $settings)) {
                $update = array('setting' => $value);
                $this->db->where('code', $code);
                $this->db->where('setting_key', $key);
                $this->db->update('settings', $update);
            }
            //if the key does not exist, add it
            else {
                $insert = array('code' => $code, 'setting_key' => $key, 'setting' => $value);
                $this->db->insert('settings', $insert);
            }
        }
    }

    //delete any settings having to do with this particular code
    function delete_settings($code) {
        $this->db->where('code', $code);
        $this->db->delete('settings');
    }

    //this deletes a specific setting
    function delete_setting($code, $setting_key) {
        $this->db->where('code', $code);
        $this->db->where('setting_key', $setting_key);
        $this->db->delete('settings');
    }

    function get_turnover($shop_id, $data) {

        $curr_month = date('m');
        $curr_YEAR = date('Y');
        // temporary
        // $curr_month = '03';

        if ($data['type'] == 'office_staff') {

            $this->db->select('customer_number');
            $this->db->select('invoice_number');
            $this->db->select('office_staff');
            $this->db->select('field_service');
            $this->db->select_sum('totalnet');
            $this->db->group_by('customer_number');
            $this->db->order_by('customer_number');
            $this->db->where('shop_id', $shop_id);
            //$this->db->where('field_service =',0);
            $this->db->where('totalgross >', 0);
            $this->db->where('MONTH(created_on)', $curr_month);
            $this->db->where('YEAR(created_on)', $curr_YEAR);
            $clients_sums = $this->db->get('invoices')->result_array();

            foreach ($clients_sums as $check) {

                if (empty($check['field_service'])) {
                    echo '<pre>';
                    print_r($check);
                    echo '</pre>';
                    //$this->db->select('field_service');
                    //$this->db->where('shop_id',$shop_id);
                    //$this->db->where('customer_number',$check['customer_number']);
                    //$agents_2[] = $this->db->get('customers')->row_array();
                }
            }
            //print_r($agents_2);



            foreach ($clients_sums as $one) {

                $arr[] = array('field_service' => $one['field_service'], 'totalnet' => $one['totalnet']);
            }



            echo '<pre>';
            //print_r($clients_sums);
            echo '</pre>';

            $sum = array_reduce($arr, function($result, $item) {
                if (!isset($result[$item['field_service']]))
                    $result[$item['field_service']] = 0;
                $result[$item['field_service']] += $item['totalnet'];
                return $result;
            }, array());





            echo '<pre>';
            print_r($sum);
            echo '</pre>';
        }
    }

    function get_agent_profit($shop_id, $data) {


        $curr_YEAR = date('Y');
        $cur_m = date('m');

        $cur_m_12 = date('m') - 12;
        $cur_m_2 = date('m') - 2;
        $cur_m_1 = date('m') - 1;


        $sum_12_month = $this->db->select_sum('totalnet')->where(array('shop_id' => $shop_id, 'totalnet >' => 0, 'field_service' => $data['agent'], 'MONTH(created_on) >=' => .0 . $cur_m_12, 'MONTH(created_on) <=' => $cur_m))->get('invoices')->row_array();
        $sum_2_month = $this->db->select_sum('totalnet')->where(array('shop_id' => $shop_id, 'totalnet >' => 0, 'field_service' => $data['agent'], 'MONTH(created_on) >=' => .0 . $cur_m_2, 'MONTH(created_on) <=' => $cur_m))->get('invoices')->row_array();
        $sum_1_month = $this->db->select_sum('totalnet')->where(array('shop_id' => $shop_id, 'totalnet >' => 0, 'field_service' => $data['agent'], 'MONTH(created_on) >=' => .0 . $cur_m_1, 'MONTH(created_on) <=' => $cur_m))->get('invoices')->row_array();
        $sum_current_month = $this->db->select_sum('totalnet')->where(array('shop_id' => $shop_id, 'totalnet >' => 0, 'field_service' => $data['agent'], 'MONTH(created_on)' => $cur_m))->get('invoices')->row_array();

        return $profit_result = array('12_months' => $sum_12_month['totalnet'], '2_months' => $sum_2_month['totalnet'], '1_months' => $sum_1_month['totalnet'], 'current_month' => $sum_current_month['totalnet']);
    }
   
    function get_turnover_per_agent($shop_id,$period=12) {
        $curr_start = date('Y-m-01');
        // $curr_start = date('Y-03-01'); // test only 
        $curr_start_1 = date("Y-m-d", strtotime($curr_start . " -1 months"));
        $curr_start_3 = date("Y-m-d", strtotime($curr_start . " -3 months"));
        $curr_start_12 = date("Y-m-d", strtotime($curr_start . " -".$period."months"));
        // echo $curr_start_3;
        // exit;
        // current month -------------------------------------------------------
        $this->db->select_sum('invoices.totalnet');
        $this->db->select('invoices.field_service');
        $this->db->select("IF((agents.agent_name IS NULL), CONCAT('Field Service ' , invoices.field_service ), agents.agent_name ) AS aq", false);
        $this->db->from('invoices');
        $this->db->join('agents', 'agents.agent_index = invoices.field_service', 'left');
        $this->db->group_by('invoices.shop_id, invoices.field_service');
        $this->db->where('invoices.shop_id', $shop_id);
        $this->db->where('invoices.created_on >=', $curr_start);
        $this->db->where('invoices.field_service  IS NOT NULL');
        $this->db->where('invoices.field_service > ', 0);
        $this->db->where('invoices.fully_paid > ', 0);
        $this->db->order_by('invoices.shop_id');
        $this->db->order_by('agents.shop_id');
        $this->db->order_by('invoices.field_service');
        $rawResCurr = $this->db->get()->result_array();
        // current month details
        $this->db->select_sum('d.profit');
        $this->db->select_sum('d.VE');
        $this->db->select('invoices.field_service');
        $this->db->select("IF((agents.agent_name IS NULL), CONCAT('Field Service ' , invoices.field_service ), agents.agent_name ) AS aq", false);
        $this->db->from('invoices');
        $this->db->join('agents', 'agents.agent_index = invoices.field_service', 'left');
        $this->db->join('invoice_items AS d', 'd.invoice_number = invoices.invoice_number', 'left');
        $this->db->group_by('invoices.shop_id, invoices.field_service');
        $this->db->where('invoices.shop_id', $shop_id);
        $this->db->where('d.shop_id', $shop_id);
        $this->db->where('invoices.created_on >=', $curr_start);
        $this->db->where('invoices.field_service  IS NOT NULL');
        $this->db->where('invoices.field_service > ', 0);
        $this->db->where('invoices.fully_paid > ', 0);
        $this->db->order_by('invoices.shop_id');
        $this->db->order_by('agents.shop_id');
        $this->db->order_by('invoices.field_service');
        $rawResCurrDet = $this->db->get()->result_array();
        // end of current mount
        // previous month 
        $this->db->select_sum('invoices.totalnet ','m_1_totalnet');
        $this->db->select('invoices.field_service');
        $this->db->select("IF((agents.agent_name IS NULL), CONCAT('Field Service ' , invoices.field_service ), agents.agent_name ) AS aq", false);
        $this->db->from('invoices');
        $this->db->join('agents', 'agents.agent_index = invoices.field_service', 'left');
        $this->db->group_by('invoices.shop_id, invoices.field_service');
        $this->db->where('invoices.shop_id', $shop_id);
        $this->db->where('invoices.created_on >=', $curr_start_1);
        $this->db->where('invoices.created_on <', $curr_start);
        $this->db->where('invoices.field_service  IS NOT NULL');
        $this->db->where('invoices.field_service > ', 0);
        $this->db->where('invoices.fully_paid > ', 0);
        $this->db->order_by('invoices.shop_id');
        $this->db->order_by('agents.shop_id');
        $this->db->order_by('invoices.field_service');
        $rawResCurr_1 = $this->db->get()->result_array();
        // previous month details
        $this->db->select_sum('d.profit','m_1_profit');
        $this->db->select_sum('d.VE','m_1_VE');
        $this->db->select('invoices.field_service');
        $this->db->select("IF((agents.agent_name IS NULL), CONCAT('Field Service ' , invoices.field_service ), agents.agent_name ) AS aq", false);
        $this->db->from('invoices');
        $this->db->join('agents', 'agents.agent_index = invoices.field_service', 'left');
        $this->db->join('invoice_items AS d', 'd.invoice_number = invoices.invoice_number', 'left');
        $this->db->group_by('invoices.shop_id, invoices.field_service');
        $this->db->where('invoices.shop_id', $shop_id);
        $this->db->where('d.shop_id', $shop_id);
        $this->db->where('invoices.created_on >=', $curr_start_1);
        $this->db->where('invoices.created_on <', $curr_start);
        $this->db->where('invoices.field_service  IS NOT NULL');
        $this->db->where('invoices.field_service > ', 0);
        $this->db->where('invoices.fully_paid > ', 0);
        $this->db->order_by('invoices.shop_id');
        $this->db->order_by('agents.shop_id');
        $this->db->order_by('invoices.field_service');
        $rawResCurrDet_1 = $this->db->get()->result_array();
        // 2 months before previos
        $this->db->select_sum('invoices.totalnet', 'm_2_totalnet');
        $this->db->select('invoices.field_service');
        $this->db->select("IF((agents.agent_name IS NULL), CONCAT('Field Service ' , invoices.field_service ), agents.agent_name ) AS aq", false);
        $this->db->from('invoices');
        $this->db->join('agents', 'agents.agent_index = invoices.field_service', 'left');
        $this->db->group_by('invoices.shop_id, invoices.field_service');
        $this->db->where('invoices.shop_id', $shop_id);
        $this->db->where('invoices.created_on >=', $curr_start_3);
        $this->db->where('invoices.created_on <', $curr_start_1);
        $this->db->where('invoices.field_service  IS NOT NULL');
        $this->db->where('invoices.field_service > ', 0);
        $this->db->where('invoices.fully_paid > ', 0);
        $this->db->order_by('invoices.shop_id');
        $this->db->order_by('agents.shop_id');
        $this->db->order_by('invoices.field_service');
        $rawResCurr_2 = $this->db->get()->result_array();
        // 2 months before previos details 
        $this->db->select_sum('d.profit','m_2_profit');
        $this->db->select_sum('d.VE','m_2_VE');
        $this->db->select('invoices.field_service');
        $this->db->select("IF((agents.agent_name IS NULL), CONCAT('Field Service ' , invoices.field_service ), agents.agent_name ) AS aq", false);
        $this->db->from('invoices');
        $this->db->join('agents', 'agents.agent_index = invoices.field_service', 'left');
        $this->db->join('invoice_items AS d', 'd.invoice_number = invoices.invoice_number', 'left');
        $this->db->group_by('invoices.shop_id, invoices.field_service');
        $this->db->where('invoices.shop_id', $shop_id);
        $this->db->where('d.shop_id', $shop_id);
        $this->db->where('invoices.created_on >=', $curr_start_3);
        $this->db->where('invoices.created_on <', $curr_start_1);
        $this->db->where('invoices.field_service  IS NOT NULL');
        $this->db->where('invoices.field_service > ', 0);
        $this->db->where('invoices.fully_paid > ', 0);
        $this->db->order_by('invoices.shop_id');
        $this->db->order_by('agents.shop_id');
        $this->db->order_by('invoices.field_service');
        $rawResCurrDet_2 = $this->db->get()->result_array();
        // mean for last full 12 months
        $this->db->select_sum('invoices.totalnet / 12 ', 'meannet');
        $this->db->select('invoices.field_service');
        $this->db->select("IF((agents.agent_name IS NULL), CONCAT('Field Service ' , invoices.field_service ), agents.agent_name ) AS aq", false);
        $this->db->from('invoices');
        $this->db->join('agents', 'agents.agent_index = invoices.field_service', 'left');
        $this->db->group_by('invoices.shop_id, invoices.field_service');
        $this->db->where('invoices.shop_id', $shop_id);
        $this->db->where('invoices.created_on >=', $curr_start_12);
        $this->db->where('invoices.created_on <', $curr_start);
        $this->db->where('invoices.field_service  IS NOT NULL');
        $this->db->where('invoices.field_service > ', 0);
        $this->db->where('invoices.fully_paid > ', 0);
        $this->db->order_by('invoices.shop_id');
        $this->db->order_by('agents.shop_id');
        $this->db->order_by('invoices.field_service');
        $rawResCurr_12 = $this->db->get()->result_array();
        // mean for last full 12 months details
        $this->db->select_sum('d.profit / 12 ', 'meanprofit');
        $this->db->select_sum('d.VE / 12 ', 'meanVE');
        $this->db->select('invoices.field_service');
        $this->db->select("IF((agents.agent_name IS NULL), CONCAT('Field Service ' , invoices.field_service ), agents.agent_name ) AS aq", false);
        $this->db->from('invoices');
        $this->db->join('agents', 'agents.agent_index = invoices.field_service', 'left');
        $this->db->join('invoice_items AS d', 'd.invoice_number = invoices.invoice_number', 'left');
        $this->db->group_by('invoices.shop_id, invoices.field_service');
        $this->db->where('invoices.shop_id', $shop_id);
        $this->db->where('d.shop_id', $shop_id);
        $this->db->where('invoices.created_on >=', $curr_start_12);
        $this->db->where('invoices.created_on <', $curr_start);
        $this->db->where('invoices.field_service  IS NOT NULL');
        $this->db->where('invoices.field_service > ', 0);
        $this->db->where('invoices.fully_paid > ', 0);
        $this->db->order_by('invoices.shop_id');
        $this->db->order_by('agents.shop_id');
        $this->db->order_by('invoices.field_service');
        $rawResCurrDet_12 = $this->db->get()->result_array();
        // echo $this->db->last_query();
        // adding in one array
        $res = array();
        foreach ($rawResCurr as $r) {
            $res[$r['aq']] = $r;
        }
        //
        foreach ($rawResCurrDet as $r) {
            if(!isset($r['aq']))
                $res[$r['aq']] = $r;
            else {
                $res[$r['aq']]['profit'] = $r['profit'];
                $res[$r['aq']]['VE'] = $r['VE'];
            }
            $res[$r['aq']]['field_service'] = $r['field_service'];
        }
        //
        foreach ($rawResCurr_1 as $r) {
            if(!isset($r['aq']))
                $res[$r['aq']] = $r;
            else {
                $res[$r['aq']]['m_1_totalnet'] = $r['m_1_totalnet'];
            }
            $res[$r['aq']]['field_service'] = $r['field_service'];
        }
        foreach ($rawResCurrDet_1 as $r) {
            if(!isset($r['aq']))
                $res[$r['aq']] = $r;
            else {
                $res[$r['aq']]['m_1_profit'] = $r['m_1_profit'];
                 $res[$r['aq']]['m_1_VE'] = $r['m_1_VE'];
            }
            $res[$r['aq']]['field_service'] = $r['field_service'];
        }
        //
        foreach ($rawResCurr_2 as $r) {
            if(!isset($r['aq']))
                $res[$r['aq']] = $r;
            else {
                $res[$r['aq']]['m_2_totalnet'] = $r['m_2_totalnet'];
            }
            $res[$r['aq']]['field_service'] = $r['field_service'];
        }
        foreach ($rawResCurrDet_2 as $r) {
            if(!isset($r['aq']))
                $res[$r['aq']] = $r;
            else {
                $res[$r['aq']]['m_2_profit'] = $r['m_2_profit'];
                $res[$r['aq']]['m_2_VE'] = $r['m_2_VE'];
            }
            $res[$r['aq']]['field_service'] = $r['field_service'];
        }
        //
        foreach ($rawResCurr_12 as $r) {
            if(!isset($r['aq']))
                $res[$r['aq']] = $r;
            else {
                $res[$r['aq']]['meannet'] = round($r['meannet'],2);
            }
            $res[$r['aq']]['field_service'] = $r['field_service'];
        }
        foreach ($rawResCurrDet_12 as $r) {
            if(!isset($r['aq']))
                $res[$r['aq']] = $r;
            else {
                $res[$r['aq']]['meanprofit'] = round($r['meanprofit'],2);
                $res[$r['aq']]['meanVE'] = round($r['meanVE'],2);
            }
            $res[$r['aq']]['field_service'] = $r['field_service'];
        }
        ksort($res);
        // echo "<pre>";
        // print_r($res);
        // exit;
        return($res);
    }
    
    function get_agent_profit_details($shop_id, $data) {


        $curr_YEAR = date('Y');
        $cur_m = date('m');

        $cur_m_12 = date('m') - 12;
        $cur_m_2 = date('m') - 2;
        $cur_m_1 = date('m') - 1;


        $sum_12_month = $this->db->where(array('shop_id' => $shop_id, 'totalnet >' => 0, 'field_service' => $data['agent'], 'MONTH(created_on) >=' => .0 . $cur_m_12, 'MONTH(created_on) <=' => $cur_m))->get('invoices')->result_array();
        $sum_2_month = $this->db->where(array('shop_id' => $shop_id, 'totalnet >' => 0, 'field_service' => $data['agent'], 'MONTH(created_on) >=' => .0 . $cur_m_2, 'MONTH(created_on) <=' => $cur_m))->get('invoices')->result_array();
        $sum_1_month = $this->db->where(array('shop_id' => $shop_id, 'totalnet >' => 0, 'field_service' => $data['agent'], 'MONTH(created_on) >=' => .0 . $cur_m_1, 'MONTH(created_on) <=' => $cur_m))->get('invoices')->result_array();
        $sum_current_month = $this->db->where(array('shop_id' => $shop_id, 'totalnet >' => 0, 'field_service' => $data['agent'], 'MONTH(created_on)' => $cur_m))->get('invoices')->result_array();

        return $profit_result = array('12_months' => $sum_12_month, '2_months' => $sum_2_month, '1_months' => $sum_1_month, 'current_month' => $sum_current_month);
    }

    function get_current_turnover($shop, $data) {

        echo $shop;
        print_r($data);
    }
    
    function get_agent_data($id)
    {
        $this->db->select('*');
        $this->db->from('agents');
        $this->db->where('agent_index', $id);
        $this->db->where('shop_id', $this->session->userdata('shop'));
        return($this->db->get()->result_array());
    }
    
    function get_agent_sales($id,$year,$month,$shop_id)
    {
        // calculate first and last date
        $first = "$year-$month-01";
        $last = date("Y-m-d", strtotime($first . " +1 months"));   
        // echo "$first $last";
        //
        $this->db->select_sum('i.paid_sum');
        $this->db->select_sum('i.totalnet');
        $this->db->select_sum('i.BTW');
        $this->db->select_sum('i.totalgross');
        $this->db->select_sum('i.dispatch_costs');
        $this->db->select('count(*) as cc');
        $this->db->select('i.customer_id , customers.customer_number , customers.company');
        $this->db->from('invoices AS i');
        $this->db->join('customers', 'customers.id = i.customer_id', 'left');
        $this->db->group_by('i.shop_id, i.customer_id');
        $this->db->where('i.shop_id', $shop_id);
        //
        $this->db->where('i.created_on >=', $first);
        $this->db->where('i.created_on <', $last);
        $this->db->where('i.field_service',$id);
        $res = $this->db->get()->result_array();
        //
        $this->db->select_sum('d.profit');
        $this->db->select_sum('d.VE');
        $this->db->select_sum('d.total_warehouse_price');
        $this->db->select('invoices.customer_id');
        $this->db->from('invoices');
        $this->db->join('invoice_items AS d', 'd.invoice_number = invoices.invoice_number', 'left');
        $this->db->group_by('invoices.shop_id, invoices.customer_id');
        $this->db->where('invoices.shop_id', $shop_id);
        $this->db->where('d.shop_id', $shop_id);
        $this->db->where('invoices.created_on >=', $first);
        $this->db->where('invoices.created_on <', $last);
        $this->db->where('invoices.field_service',$id);
        $det = $this->db->get()->result_array();
        // 
        $c = array();
        foreach($res as $r)
        {
            $c[$r['customer_id']] = $r;
        }
        //
        foreach($det as $r)
        {
            $c[$r['customer_id']]['profit'] = $r['profit'];
            $c[$r['customer_id']]['VE'] = $r['VE'];
            $c[$r['customer_id']]['total_warehouse_price'] = $r['total_warehouse_price'];
        }
        // echo "<pre>";
        // print_r($c);
        // exit;
        return ($c);
    }
    function get_client_sales($id,$year,$month,$shop_id)
    {
        // calculate first and last date
        $first = "$year-$month-01";
        $last = date("Y-m-d", strtotime($first . " +1 months"));   
        // echo "$first $last";
        //
        
        $this->db->select_sum('d.profit');
        $this->db->select_sum('d.VE');
        $this->db->select_sum('d.total_warehouse_price');
        $this->db->select_sum('d.total');
        $this->db->select('count(*) as cc');
        $this->db->select('d.code');
        $this->db->select('p.id');
        // $this->db->select('p.code');
        $this->db->select('p.name');
        $this->db->from('invoice_items AS d');
        $this->db->join('products AS p', 'p.code = d.code', 'left');
        $this->db->join('invoices', 'invoices.invoice_number = d.invoice_number', 'left');
        $this->db->group_by('d.shop_id, d.code');
        $this->db->where('d.shop_id', $shop_id);
        $this->db->where('invoices.created_on >=', $first);
        $this->db->where('invoices.created_on <', $last);
        $this->db->where('invoices.customer_id',$id);
        $det = $this->db->get()->result_array();
        // 
        
        //echo "<pre>";
        //print_r($det);
       // exit;
        return ($det);
    }
    //
    function get_client_data($id)
    {
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('customer_number', $id);
        $this->db->where('shop_id', $this->session->userdata('shop'));
        return($this->db->get()->result_array());
    }
    function get_product_data($id)
    {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('code', $id);
        return($this->db->get()->result_array());
    }
    function get_country_data($id)
    {
        $this->db->select('*');
        $this->db->from('countries');
        $this->db->where('iso_code_2', $id);
        return($this->db->get()->result_array());
    }
    function get_supplier_data($id)
    {
        $this->db->select('*');
        $this->db->from('suppliers');
        $this->db->where('id', $id);
        return($this->db->get()->result_array());
    }
    
    function get_product_sales($id,$year,$month,$shop_id)
    {
        // calculate first and last date
        $first = "$year-$month-01";
        $last = date("Y-m-d", strtotime($first . " +1 months"));   
        // echo "$first $last";
        //
        
        $this->db->select_sum('d.profit');
        $this->db->select_sum('d.VE');
        $this->db->select_sum('d.total_warehouse_price');
        $this->db->select_sum('d.total');
        $this->db->select('count(*) as cc');
        $this->db->select('customers.id');
        $this->db->select('customers.company');
        $this->db->from('invoice_items AS d');
        $this->db->join('products AS p', 'p.code = d.code', 'left');
        $this->db->join('invoices', 'invoices.invoice_number = d.invoice_number', 'left');
        $this->db->join('customers', 'customers.id = invoices.customer_id', 'left');
        //
        $this->db->group_by('d.shop_id, invoices.customer_id');
        $this->db->where('d.code', $id);
        $this->db->where('d.shop_id', $shop_id);
        $this->db->where('invoices.created_on >=', $first);
        $this->db->where('invoices.created_on <', $last);
        //
        $det = $this->db->get()->result_array();
        // 
        return ($det);
    }
}
