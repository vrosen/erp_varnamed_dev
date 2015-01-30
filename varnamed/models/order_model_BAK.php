<?php

Class Order_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_gross_monthly_sales($year) {
        $this->db->select('SUM(coupon_discount) as coupon_discounts');
        $this->db->select('SUM(gift_card_discount) as gift_card_discounts');
        $this->db->select('SUM(subtotal) as product_totals');
        $this->db->select('SUM(shipping) as shipping');
        $this->db->select('SUM(tax) as tax');
        $this->db->select('SUM(total) as total');
        $this->db->select('YEAR(ordered_on) as year');
        $this->db->select('MONTH(ordered_on) as month');
        $this->db->group_by(array('MONTH(ordered_on)'));
        $this->db->order_by("ordered_on", "desc");
        $this->db->where('YEAR(ordered_on)', $year);

        return $this->db->get('orders')->result();
    }

    function get_all_customers($shop_id) {

        $this->db->select('NR,company');
        $this->db->where('shop_id', $shop_id);
        $cust = $this->db->get('customers')->result_array();
        foreach ($cust as $c) {
            @$cstm[$c['NR']] = array($c['company']);
        }
        return $cstm;
    }

    function get_sales_years() {
        $this->db->order_by("ordered_on", "desc");
        $this->db->select('YEAR(ordered_on) as year');
        $this->db->group_by('YEAR(ordered_on)');
        $records = $this->db->get('orders')->result();
        $years = array();
        foreach ($records as $r) {
            $years[] = $r->year;
        }
        return $years;
    }

    function get_web_orders($shop_id, $period) {

        if (!empty($shop_id)) {
            if (empty($period)) {

                $this->db->where('WEBSHOP', 1);
                $this->db->where('MONTH(ordered_on)', date('m'));
                $this->db->where('YEAR(ordered_on)', date('Y'));
                $this->db->where('WEBSHOP', 1);
                $this->db->where('shop_id', $shop_id);
                return $this->db->get('orders')->result();
            } else {
                $this->db->where('WEBSHOP', 1);
                $this->db->where('MONTH(ordered_on)', $period);
                $this->db->where('YEAR(ordered_on)', date('Y'));
                $this->db->where('WEBSHOP', 1);
                $this->db->where('shop_id', $shop_id);
                return $this->db->get('orders')->result();
            }
        }
    }

    function count_web_orders($shop_id) {

        if (!empty($shop_id)) {

            $this->db->where('WEBSHOP', 1);
            $this->db->where('shop_id', $shop_id);
            return $this->db->count_all_results('orders');
        }
    }

    function get_all_recent_orders($search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0, $status = 0) {
        if (!empty($shop_id)) {
            if ($search) {
                if (!empty($search->term)) {
                    //support multiple words
                    $term = explode(' ', $search->term);

                    foreach ($term as $t) {
                        $not = '';
                        $operator = 'OR';
                        if (substr($t, 0, 1) == '-') {
                            $not = 'NOT ';
                            $operator = 'AND';
                            //trim the - sign off
                            $t = substr($t, 1, strlen($t));
                        }

                        $like = '';
                        $like .= "( `order_number` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `bill_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `bill_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `status` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `notes` " . $not . "LIKE '%" . $t . "%' )";

                        $this->db->where($like);
                    }
                }
                if (!empty($search->start_date)) {
                    $this->db->where('ordered_on >=', $search->start_date);
                }
                if (!empty($search->end_date)) {
                    //increase by 1 day to make this include the final day
                    //I tried <= but it did not function. Any ideas why?
                    $search->end_date = date('Y-m-d', strtotime($search->end_date) + 86400);
                    $this->db->where('ordered_on <', $search->end_date);
                }
            }

            if ($limit > 0) {
                $this->db->limit($limit, $offset);
            }
            if (!empty($sort_by)) {
                $this->db->order_by($sort_by, $sort_order);
            }
            $this->db->where('status', $status);
            $this->db->where('shop_id', $shop_id);
            return $this->db->get('orders')->result();
        }
    }

    function get_new_orders($search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0, $status = 0) {

        if (!empty($shop_id)) {
            if ($search) {
                if (!empty($search->term)) {
                    //support multiple words
                    $term = explode(' ', $search->term);

                    foreach ($term as $t) {
                        $not = '';
                        $operator = 'OR';
                        if (substr($t, 0, 1) == '-') {
                            $not = 'NOT ';
                            $operator = 'AND';
                            //trim the - sign off
                            $t = substr($t, 1, strlen($t));
                        }

                        $like = '';
                        $like .= "( `order_number` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `bill_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `bill_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `status` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `notes` " . $not . "LIKE '%" . $t . "%' )";

                        $this->db->where($like);
                    }
                }
                if (!empty($search->start_date)) {
                    $this->db->where('ordered_on >=', $search->start_date);
                }
                if (!empty($search->end_date)) {
                    //increase by 1 day to make this include the final day
                    //I tried <= but it did not function. Any ideas why?
                    $search->end_date = date('Y-m-d', strtotime($search->end_date) + 86400);
                    $this->db->where('ordered_on <', $search->end_date);
                }
            }//shop_id =1 and order_number=

            if (!empty($sort_by)) {
                $this->db->order_by($sort_by, $sort_order);
            }
            //$this->db->where('status',$status);
            $this->db->or_where('status', '0');
            $this->db->where('shop_id', $shop_id);
            return $this->db->get('orders')->result();
        }
    }

    function get_processed_orders($search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0) {
        if (!empty($shop_id)) {
            if ($search) {
                if (!empty($search->term)) {
                    //support multiple words
                    $term = explode(' ', $search->term);

                    foreach ($term as $t) {
                        $not = '';
                        $operator = 'OR';
                        if (substr($t, 0, 1) == '-') {
                            $not = 'NOT ';
                            $operator = 'AND';
                            //trim the - sign off
                            $t = substr($t, 1, strlen($t));
                        }

                        $like = '';
                        $like .= "( `order_number` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `bill_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `bill_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `status` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `notes` " . $not . "LIKE '%" . $t . "%' )";

                        $this->db->where($like);
                    }
                }
                if (!empty($search->start_date)) {
                    $this->db->where('ordered_on >=', $search->start_date);
                }
                if (!empty($search->end_date)) {
                    //increase by 1 day to make this include the final day
                    //I tried <= but it did not function. Any ideas why?
                    $search->end_date = date('Y-m-d', strtotime($search->end_date) + 86400);
                    $this->db->where('ordered_on <', $search->end_date);
                }
            }

            if ($limit > 0) {
                $this->db->limit($limit, $offset);
            }
            if (!empty($sort_by)) {
                $this->db->order_by($sort_by, $sort_order);
            }
            $this->db->where('status', '1');
            $this->db->where('shop_id', $shop_id);

            return $this->db->get('orders')->result();
        }
    }

    function get_new_orders_with_backorders($search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0, $status = 0) {

        if (!empty($shop_id)) {
            if ($search) {
                if (!empty($search->term)) {
                    //support multiple words
                    $term = explode(' ', $search->term);

                    foreach ($term as $t) {
                        $not = '';
                        $operator = 'OR';
                        if (substr($t, 0, 1) == '-') {
                            $not = 'NOT ';
                            $operator = 'AND';
                            //trim the - sign off
                            $t = substr($t, 1, strlen($t));
                        }

                        $like = '';
                        $like .= "( `order_number` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `bill_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `bill_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `status` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `notes` " . $not . "LIKE '%" . $t . "%' )";

                        $this->db->where($like);
                    }
                }
                if (!empty($search->start_date)) {
                    $this->db->where('ordered_on >=', $search->start_date);
                }
                if (!empty($search->end_date)) {

                    $search->end_date = date('Y-m-d', strtotime($search->end_date) + 86400);
                    $this->db->where('ordered_on <', $search->end_date);
                }
            }

            if (!empty($sort_by)) {
                $this->db->order_by($sort_by, $sort_order);
            }
            $m = date('m');
            $curr_YEAR = date('Y');
            $this->db->where('status', '3');
            $this->db->where('BACKORDER', '1');
            $this->db->where('MONTH(ordered_on)', $m);
            $this->db->where('YEAR(ordered_on)', $curr_YEAR);
            $this->db->where('shop_id', $shop_id);
            $this->db->limit(20);
            return $this->db->get('orders')->result();
        }
    }

    function get_orders_to_ship($shop_id) {

        $this->db->where('status', '2');
        $this->db->where('shop_id', $shop_id);
        return $this->db->get('orders')->result();
    }

    function get_list_orders($search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0, $status = 0) {
        if (!empty($shop_id)) {
            if ($search) {
                if (!empty($search->term)) {
                    //support multiple words
                    $term = explode(' ', $search->term);

                    foreach ($term as $t) {
                        $not = '';
                        $operator = 'OR';
                        if (substr($t, 0, 1) == '-') {
                            $not = 'NOT ';
                            $operator = 'AND';
                            //trim the - sign off
                            $t = substr($t, 1, strlen($t));
                        }

                        $like = '';
                        $like .= "( `order_number` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `bill_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `bill_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `status` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `notes` " . $not . "LIKE '%" . $t . "%' )";

                        $this->db->where($like);
                    }
                }
                if (!empty($search->start_date)) {
                    $this->db->where('ordered_on >=', $search->start_date);
                }
                if (!empty($search->end_date)) {
                    //increase by 1 day to make this include the final day
                    //I tried <= but it did not function. Any ideas why?
                    $search->end_date = date('Y-m-d', strtotime($search->end_date) + 86400);
                    $this->db->where('ordered_on <', $search->end_date);
                }
            }

            if ($limit > 0) {
                $this->db->limit($limit, $offset);
            }
            if (!empty($sort_by)) {
                $this->db->order_by($sort_by, $sort_order);
            }
            if (!empty($status)) {
                $this->db->where('status', $status);
                $this->db->where('shop_id', $shop_id);
                return $this->db->get('orders')->result();
            }
        }
    }

    function get_orders_count($search = false) {
        if ($search) {
            if (!empty($search->term)) {
                //support multiple words
                $term = explode(' ', $search->term);

                foreach ($term as $t) {
                    $not = '';
                    $operator = 'OR';
                    if (substr($t, 0, 1) == '-') {
                        $not = 'NOT ';
                        $operator = 'AND';
                        //trim the - sign off
                        $t = substr($t, 1, strlen($t));
                    }

                    $like = '';
                    $like .= "( `order_number` " . $not . "LIKE '%" . $t . "%' ";
                    $like .= $operator . " `bill_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `bill_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `ship_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `status` " . $not . "LIKE '%" . $t . "%' ";
                    $like .= $operator . " `notes` " . $not . "LIKE '%" . $t . "%' )";

                    $this->db->where($like);
                }
            }
            if (!empty($search->start_date)) {
                $this->db->where('ordered_on >=', $search->start_date);
            }
            if (!empty($search->end_date)) {
                $this->db->where('ordered_on <', $search->end_date);
            }
        }

        return $this->db->count_all_results('orders');
    }

    //get an individual customers orders
    function get_customer_orders($id, $offset = 0) {

        $this->db->join('order_items', 'orders.id = order_items.order_id');
        $this->db->order_by('ordered_on', 'DESC');
        return $this->db->get_where('orders', array('customer_id' => $id), 15, $offset)->result();
    }

    function get_customer_order($id, $offset = 0) {


        $this->db->order_by('order_number', 'DESC');
        return $this->db->get_where('orders', array('customer_id' => $id), 15, $offset)->result();
    }

    function count_customer_orders($id) {
        $this->db->where(array('customer_id' => $id));
        return $this->db->count_all_results('orders');
    }

    function get_order($id) {


        $this->db->where('id', $id);
        $result = $this->db->get('orders');
        if ($result->num_rows() > 0) {

            $order = $result->row();
            $order->contents = $this->get_items($order->id);
            return $order;
        } else {
            
        }
    }

    function get_order_word($id) {


        $this->db->where('id', $id);
        return $result = $this->db->get('orders')->row_array();
    }

    function get_order_num($number) {


        $this->db->where('order_number', $number);
        $result = $this->db->get('orders');
        if ($result->num_rows() > 0) {

            $order = $result->row();

            return $order;
        } else {
            
        }
    }

    function get_items($id) {

        $this->db->select('order_id,code,description,quantity,saleprice,total,VAT,vpa');
        $this->db->where('order_id', $id);
        return $this->db->get('order_items')->result_array();
    }

    function get_all_items($NR, $id) {


        $this->db->where('order_id_number', $id);
        $this->db->where('shop_id', $this->data_shop);
        $this->db->where('BACKORDER', '0');
        $result = $this->db->get('order_items');

        if ($result->num_rows() > 0) {

            $this->db->order_by('id', 'ACS');
            $this->db->where('order_id', $NR);
            $this->db->where('order_id_number', $id);
            $this->db->where('shop_id', $this->data_shop);
            $result1 = $this->db->get('order_items')->result();
            return $result1;
        } else {

            $this->db->order_by('id', 'ACS');
            $this->db->where('order_id', $NR);
            $this->db->where('shop_id', $this->data_shop);
            $result2 = $this->db->get('order_items')->result();
            return $result2;
        }
    }

    function get_all_items_word($NR, $id) {


        $this->db->where('order_id_number', $id);
        $this->db->where('shop_id', $this->data_shop);
        $result = $this->db->get('order_items');
        if ($result->num_rows() > 0) {

            $this->db->order_by('id', 'ACS');
            $this->db->where('order_id', $NR);
            $this->db->where('order_id_number', $id);
            $this->db->where('shop_id', $this->data_shop);
            $result1 = $this->db->get('order_items')->result_array();
            return $result1;
        } else {

            $this->db->order_by('id', 'ACS');
            $this->db->where('order_id', $NR);
            $this->db->where('shop_id', $this->data_shop);
            $result2 = $this->db->get('order_items')->result_array();
            return $result2;
        }
    }

    function get_all_items_for_ship($NR, $order_number, $shop_id) {



        $this->db->where('OPDRACHTNR', $NR);
        $this->db->where('ORDERNR', $order_number);
        $this->db->where('shop_id', $shop_id);
        $result = $this->db->get('verzendregel')->result();
        return $result;
    }

    function get_invoice_items($id) {

        //$this->db->order_by('id','ACS');
        //$this->db->select('contents');
        $this->db->where('invoice_number', $id);
        $this->db->where('order_id', $NR);
        $this->db->where('shop_id', $this->data_shop);
        $result = $this->db->get('invoice_items')->result_array();
        return $result;
    }

    function delete($id) {

        $this->db->where('NR', $id);
        $this->db->delete('orders');
        //now delete the order items
        $this->db->where('order_id', $id);
        $this->db->delete('order_items');
    }

    function save_order($data, $contents = false) {

        date_default_timezone_set('Europe/Sofia');


        if (isset($data['id'])) {

            $data['changed_on'] = date('Y-m-d-h-i-s');
            $data['changed_by'] = $this->session->userdata('ba_username');

            $this->db->where('id', $data['id']);
            $this->db->update('orders', $data);
            $id = $data['id'];
            $order_number = $id;
        } else {
            $this->db->insert('orders', $data);
            $id = $this->db->insert_id();

            //unix time stamp + unique id of the order just submitted.
            $order = array('order_number' => date('U') . $id);

            //update the order with this order id
            $this->db->where('id', $id);
            $this->db->update('orders', $order);

            //return the order id we generated
            $order_number = $order['order_number'];
        }

        //if there are items being submitted with this order add them now
        if ($contents) {
            // clear existing order items
            $this->db->where('order_id', $id)->delete('order_items');
            // update order items
            foreach ($contents as $item) {
                $save = array();
                $save['contents'] = $item;

                $item = unserialize($item);
                $save['product_id'] = $item['id'];
                $save['quantity'] = $item['quantity'];
                $save['order_id'] = $id;
                $this->db->insert('order_items', $save);
            }
        }

        return $order_number;
    }

    function get_best_sellers($start, $end) {
        if (!empty($start)) {
            $this->db->where('ordered_on >=', $start);
        }
        if (!empty($end)) {
            $this->db->where('ordered_on <', $end);
        }

        // just fetch a list of order id's
        $orders = $this->db->select('id')->get('orders')->result();

        $items = array();
        foreach ($orders as $order) {
            // get a list of product id's and quantities for each
            $order_items = $this->db->select('product_id, quantity')->where('order_id', $order->id)->get('order_items')->result_array();

            foreach ($order_items as $i) {

                if (isset($items[$i['product_id']])) {
                    $items[$i['product_id']] += $i['quantity'];
                } else {
                    $items[$i['product_id']] = $i['quantity'];
                }
            }
        }
        arsort($items);

        // don't need this anymore
        unset($orders);

        $return = array();
        foreach ($items as $key => $quantity) {
            $product = $this->db->where('id', $key)->get('products')->row();
            if ($product) {
                $product->quantity_sold = $quantity;
            } else {
                $product = (object) array('sku' => 'Deleted', 'name' => 'Deleted', 'quantity_sold' => $quantity);
            }

            $return[] = $product;
        }

        return $return;
    }

    public function get_all_orders() {

        $result = $this->db->get('orders');

        $order = $result->row();
        $order->contents = $this->get_items($order->id);

        return $order;
    }

    public function get_order_details($id) {

        $this->db->where('id', $id);
        $result = $this->db->get('orders');
        $order = $result->row();
        return $order;
    }

    public function get_order_detail($id) {

        $this->db->where('order_number', $id);
        $result = $this->db->get('orders');
        $order = $result->row();
        return $order;
    }

    public function get_order_costs($id) {

        $this->db->select('shipping');
        $this->db->where('order_number', $id);
        $result = $this->db->get('orders');
        $order = $result->row_array();
        return $order;
    }

    public function get_order_vat($id) {

        $this->db->select('vat_index');
        $this->db->where('order_number', $id);
        $result = $this->db->get('orders');
        $order = $result->row_array();
        return $order;
    }

    public function get_recent_orders($id) {

        $this->db->where('id', $id);
        $this->db->where('status', 'Pending');
        $result = $this->db->get('orders');
        $order = $result->row();
        return $order;
    }

    public function insert_order($data) {

        if (!empty($data['id'])) {
            echo $data['id'];
            $this->db->where('id', $data['id']);
            $this->db->update('orders', $data);
            return $data['id'];
        } else {
            $this->db->insert('orders', $data);
            return $this->db->insert_id();
        }
    }

    public function insert_backorder($data) {


        $this->db->insert_batch('backorder', $data);
        return $this->db->insert_id();
    }

    public function update_order($data) {

        if (!empty($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->where('NR', $data['nr']);
            $this->db->update('orders', $data);
            return $data['id'];
        }
    }

    public function insert_order_products($data) {

        $this->db->insert_batch('order_items', $data);
        return $this->db->insert_id();
    }

    public function insert_reserved_products($data) {

        $this->db->insert_batch('reservations', $data);
        return $this->db->insert_id();
    }

    public function insert_order_products_with_backorder($data) {

        $this->db->insert_batch('order_items', $data);
        return $this->db->insert_id();
    }

    public function update_order_products($data) {

        if (!empty($data)) {

            foreach ($data as $item) {

                $this->db->where('order_id', $item['order_id']);
                $this->db->where('code', $item['code']);
                $this->db->where('shop_id', $item['shop_id']);
                $this->db->where('order_id_number', $item['order_id_number']);
                $this->db->update('order_items', $item);
            }
            //return $data['id'];
        }
    }

    public function update_reserved_order_products($data) {

        if (!empty($data)) {

            foreach ($data as $item) {

                $this->db->where('order_id', $item['order_id']);
                $this->db->where('product_code', $item['code']);
                $this->db->where('shop_id', $item['shop_id']);
                $this->db->update('reservations', $item);
            }
            //return $data['id'];
        }
    }

    public function renew_order_items($data) {

        if (!empty($data)) {
            foreach ($data as $item) {
                $this->db->where('order_id', $item['order_id']);
                $this->db->where('code', $item['code']);
                $this->db->where('shop_id', $item['shop_id']);
                $this->db->where('order_id_number', $item['order_id_number']);
                $query = $this->db->get('order_items');

                if ($query->num_rows() > 0) {

                    $this->db->where('order_id', $item['order_id']);
                    $this->db->where('code', $item['code']);
                    $this->db->where('shop_id', $item['shop_id']);
                    $this->db->where('order_id_number', $item['order_id_number']);
                    //echo '<pre>';
                    //print_r($item);
                    // echo '</pre>';
                    $this->db->update('order_items', $item);
                } else {
                    //echo '<pre>';
                    //print_r($item);
                    // echo '</pre>';
                    $this->db->insert('order_items', $item);
                }
            }
        }
    }

    public function get_order_number($id) {

        $this->db->where('order_number', $id);
        $result = $this->db->get('orders');
        $order_details = $result->row();
        return $order_details;
    }

    public function test() {

        $this->db->query('INSERT INTO order_items ( order_id, product_id, quantity ) VALUES
                                
                                ( Value1, Value2 ), ( Value1, Value2 )');
    }

    public function update_status($order_number, $back) {

        date_default_timezone_set('Europe/Sofia');
        //    if($back == 1){
        //        $data   =   array('status' => '1','processed_on'=>date('Y-m-d'),'BACKORDER' => '0');
        //  }
        //   else {
        $data = array('status' => '1', 'processed_on' => date('Y-m-d'));
        // }
        // update or insert
        if (!empty($order_number)) {

            $this->db->where('order_number', $order_number);
            $this->db->update('orders', $data);
        }
    }

    public function to_ship($order_number) {

        date_default_timezone_set('Europe/Sofia');
        $data = array('status' => '2', 'shipped_on' => date('Y-m-d'), 'shipped' => '1');
        // update or insert
        if (!empty($order_number)) {

            $this->db->where('order_number', $order_number);
            $this->db->update('orders', $data);
        }
    }

    public function ship($order_numbers) {

        date_default_timezone_set('Europe/Sofia');
        $data = array('status' => '3', 'shipped_on' => date('Y-m-d'), 'shipped' => '1');
        // update or insert
        if (!empty($order_numbers)) {

            foreach ($order_numbers as $order_number) {
                $this->db->where('id', $order_number);
                $this->db->update('orders', $data);
            }
        }
    }

    function get_current_order($data) {

        $this->db->where('id', $data['id']);
        $this->db->where('order_number', $data['order_number']);
        $result = $this->db->get('orders');
        return $result->row();
    }

    public function get_last_id($shop_id) {

        $this->db->where('shop_id', $shop_id);
        $this->db->select_max('id');
        $result = $this->db->get('orders');
        return $result->row();
    }

    public function get_last_order_number($id) {

        $this->db->select('order_number,NR');
        $this->db->where('id', $id);
        $result = $this->db->get('orders');
        return $result->row();
    }

    public function get_last_NR_number($id) {

        $this->db->select('NR');
        $this->db->where('id', $id);
        $result = $this->db->get('orders');
        return $result->row();
    }

    public function get_backorder_list($search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0) {

        if (!empty($shop_id)) {

            if ($search) {
                if (!empty($search->term)) {
                    //support multiple words
                    $term = explode(' ', $search->term);

                    foreach ($term as $t) {
                        $not = '';
                        $operator = 'OR';
                        if (substr($t, 0, 1) == '-') {
                            $not = 'NOT ';
                            $operator = 'AND';
                            //trim the - sign off
                            $t = substr($t, 1, strlen($t));
                        }

                        $like = '';
                        $like .= "( `order_number` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `batch_number` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `supplier_id` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `shop_id` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `product_code` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `reception_date` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `expiration_date` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `warehouse` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `warehouse_place` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `description` " . $not . "LIKE '%" . $t . "%' )";

                        $this->db->where($like);
                    }
                }
            }
            $this->db->where('shop_id', $shop_id);
            $this->db->limit(5);
            return $this->db->get('backorder')->result();
        }
    }

    function get_backorder_orders($shop_id) {

        return $this->db->select('order_number')->where(array('shop_id' => $shop_id, 'BACKORDER' => '1'))->get('orders')->result_array();
    }

    function transfer_backorders() {



        $this->db->select('NR', 'order_number', 'customer_id', 'shipped_on', 'order_type', 'WEBSHOP', 'enetered_by');
        "SELECT 
                                    opdracht.nr, 
                                    opdracht.ordernr, 
                                    opdracht.relatiesnr, 
                                    opdracht.verzenddatum, 
                                    opdracht.opdrachtsoort, 
                                    opdracht.webshop, 
                                    opdracht.eigennaam, 
                                    relaties.code as relatiecode, 
                                    relaties.naam1, 
                                    relaties.naam2, 
                                    relaties.management, 
                                    '0' AS verzendnr 
                            FROM opdracht, relaties 
                            WHERE opdracht.definitief 
                            AND opdracht.backorder 
                            AND !allesverzonden 
                            AND opdracht.soort='opdracht' 
                            AND !opdracht.delrecord 
                            AND opdracht.relatiesnr = relaties.nr";
    }

    function get_customer_orders_nr($customer_nr, $offset = 0) {

        //$this->db->join('order_items', 'orders.id = order_items.order_id');
        $this->db->order_by('ordered_on', 'DESC');
        return $this->db->get_where('orders', array('customer_id' => $customer_nr), 5, $offset)->result();
    }

    function get_customer_open_invoices_nr($customer_nr, $offset = 0) {

        //$this->db->join('order_items', 'orders.id = order_items.order_id');
        $this->db->order_by('created_on', 'DESC');
        return $this->db->get_where('invoices', array('customer_id' => $customer_nr, 'fully_paid' => 0), 5, $offset)->result();
    }

    function set_geprint() {
        
    }

    function get_id($NR, $shop_id) {

        return $this->db->select('id')->where(array('NR' => $NR, 'shop_id' => $shop_id))->get('orders')->row();
    }

    function ship_details($data, $update) {


        $this->db->where(array(
            'shop_id' => $data['shop_id'],
            'NR' => $data['NR'],
            'order_number' => $data['order_number'],
            'id' => $data['id'],
        ));

        $this->db->update('orders', $update);
    }

    function insert_sent_order($data, $shop) {

        $insert_order = array(
            'shop_id' => $shop,
            'OPDRACHTNR' => $data->NR,
            'VERZENDNR' => 1,
            'VERZENDDAT' => $data->processed_on,
            'VERZENDKOS' => $data->shipping,
            'ORDERNR' => $data->order_number,
            'GEWICHT' => $data->weight,
            'ISVERZONDE' => 1,
            'RELATIESNR' => $data->customer_id,
            'VERZENDWIJ' => $data->shipping_method,
            'KONTROLLIE' => $data->picking_agent,
            'KOMMISSION' => $data->monitored_by,
            'PICKKOSTEN' => $data->order_picking_costs,
            'MAGAZIJNNR' => $data->warehouse,
            'GEPRINT' => 1,
            'dropshipment' => $data->dropshipment,
        );

        $this->db->insert('verzending', $insert_order);
    }

    function insert_shipped_products($data) {

        echo '<pre>';
        //print_r($data);
        echo '</pre>';
        //$this->db->insert('verzendregel',$data);
        return $this->db->insert_id();
    }

    function insert_sent_order_ietms($product, $shop, $NR, $order_number) {

        $code = str_replace('/', '', $product['code']);
        $warehouse_batch = $this->db->select('batch_number,code,MAX(reception_date),expiration_date,warehouse_place,current_quantity')->where(array('code' => $code, 'shop_id' => $shop, 'current_quantity >' => 0, 'warehouse_place !=' => 'vast', 'warehouse_place !=' => '1vast'))->order_by('expiration_date')->get('warehouse_order_products')->row();



        if ($warehouse_batch->current_quantity > $product['quantity']) {

            $result_one = $warehouse_batch->current_quantity - $product['quantity'];
            $res = array('current_quantity' => $result_one);

            $code = str_replace('/', '', $product['code']);

            $this->db->where('shop_id', $shop);
            $this->db->where('code', $code);
            $this->db->where('batch_number', $warehouse_batch->batch_number);
            $this->db->update('warehouse_order_products', $res);

            $products = array(
                'shop_id' => $shop,
                'OPDRACHTNR' => $NR,
                'VERZONDEN' => $product['quantity'],
                'ORDERNR' => $order_number,
                'ARTIKELCOD	' => $product['code'],
                'LOCATIE' => $warehouse_batch->warehouse_place,
                'BATCHNR' => $warehouse_batch->batch_number,
                'VERPAKKING' => $product['vpa'],
                'VERVALDATU' => $warehouse_batch->expiration_date
            );
            $this->db->insert('verzendregel', $products);
            return array(false);
        }

        if ($warehouse_batch->current_quantity < $product['quantity']) {

            $result_next = $product['quantity'] - $warehouse_batch->current_quantity;
            $res = array('current_quantity' => 0);

            $code = str_replace('/', '', $product['code']);

            $this->db->where('shop_id', $shop);
            $this->db->where('code', $code);
            $this->db->where('batch_number', $warehouse_batch->batch_number);
            $this->db->update('warehouse_order_products', $res);

            $products = array(
                'shop_id' => $shop,
                'OPDRACHTNR' => $NR,
                'VERZONDEN' => $warehouse_batch->current_quantity,
                'ORDERNR' => $order_number,
                'ARTIKELCOD	' => str_replace('/', '', $product['code']),
                'LOCATIE' => $warehouse_batch->warehouse_place,
                'BATCHNR' => $warehouse_batch->batch_number,
                'VERPAKKING' => $product['vpa'],
                'VERVALDATU' => $warehouse_batch->expiration_date
            );
            $this->db->insert('verzendregel', $products);
            return array(true, $result_next);
        }

        if ($warehouse_batch->current_quantity = $product['quantity']) {

            $result_next = $product['quantity'] - $warehouse_batch->current_quantity;
            $res = array('current_quantity' => 0);

            $code = str_replace('/', '', $product['code']);

            $this->db->where('shop_id', $shop);
            $this->db->where('code', $code);
            $this->db->where('batch_number', $warehouse_batch->batch_number);
            $this->db->update('warehouse_order_products', $res);

            $products = array(
                'shop_id' => $shop,
                'OPDRACHTNR' => $NR,
                'VERZONDEN' => $product['quantity'],
                'ORDERNR' => $order_number,
                'ARTIKELCOD	' => str_replace('/', '', $product['code']),
                'LOCATIE' => $warehouse_batch->warehouse_place,
                'BATCHNR' => $warehouse_batch->batch_number,
                'VERPAKKING' => $product['vpa'],
                'VERVALDATU' => $warehouse_batch->expiration_date
            );
            $this->db->insert('verzendregel', $products);
            return array(false);
        }
    }

    function insert_sent_order_ietms_2($product, $shop, $NR, $order_number) {

        $code = str_replace('/', '', $product['code']);
        $warehouse_batch = $this->db->select('batch_number,code,MAX(reception_date),expiration_date,warehouse_place,ordered_quantity')->where(array('code' => $code, 'shop_id' => $shop, 'ordered_quantity >' => 0, 'warehouse_place !=' => 'vast', 'warehouse_place !=' => '1vast'))->order_by('expiration_date')->get('warehouse_order_products')->row();



        if ($warehouse_batch->ordered_quantity > $product['quantity']) {

            $result_one = $warehouse_batch->ordered_quantity - $product['quantity'];
            $res = array('ordered_quantity' => $result_one);

            $code = str_replace('/', '', $product['code']);

            $this->db->where('shop_id', $shop);
            $this->db->where('code', $code);
            $this->db->where('batch_number', $warehouse_batch->batch_number);
            $this->db->update('warehouse_order_products', $res);

            return array(false);
        }

        if ($warehouse_batch->ordered_quantity < $product['quantity']) {

            $result_next = $product['quantity'] - $warehouse_batch->ordered_quantity;
            $res = array('ordered_quantity' => 0);

            $code = str_replace('/', '', $product['code']);

            $this->db->where('shop_id', $shop);
            $this->db->where('code', $code);
            $this->db->where('batch_number', $warehouse_batch->batch_number);
            $this->db->update('warehouse_order_products', $res);

            return array(true, $result_next);
        }

        if ($warehouse_batch->ordered_quantity = $product['quantity']) {

            $result_next = $product['quantity'] - $warehouse_batch->ordered_quantity;
            $res = array('ordered_quantity' => 0);

            $code = str_replace('/', '', $product['code']);

            $this->db->where('shop_id', $shop);
            $this->db->where('code', $code);
            $this->db->where('batch_number', $warehouse_batch->batch_number);
            $this->db->update('warehouse_order_products', $res);

            return array(false);
        }
    }

    function get_new_shipments($search = false, $sort_by = 'shipped_on', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0) {

        if (!empty($shop_id)) {
            if ($search) {
                if (!empty($search->term)) {
                    //support multiple words
                    $term = explode(' ', $search->term);

                    foreach ($term as $t) {
                        $not = '';
                        $operator = 'OR';
                        if (substr($t, 0, 1) == '-') {
                            $not = 'NOT ';
                            $operator = 'AND';
                            //trim the - sign off
                            $t = substr($t, 1, strlen($t));
                        }

                        $like = '';
                        $like .= "( `order_number` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `bill_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `bill_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `status` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `notes` " . $not . "LIKE '%" . $t . "%' )";

                        $this->db->where($like);
                    }
                }
                if (!empty($search->start_date)) {
                    $this->db->where('ordered_on >=', $search->start_date);
                }
                if (!empty($search->end_date)) {
                    //increase by 1 day to make this include the final day
                    //I tried <= but it did not function. Any ideas why?
                    $search->end_date = date('Y-m-d', strtotime($search->end_date) + 86400);
                    $this->db->where('ordered_on <', $search->end_date);
                }
            }

            if ($limit > 0) {
                $this->db->limit($limit, $offset);
            }
            $this->db->order_by('shipped_on', 'DESC');
            $this->db->where('status', '3');
            $this->db->where('shop_id', $shop_id);
            return $this->db->get('orders')->result();
        }
    }

    function get_old_shipments($search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0) {

        if (!empty($shop_id)) {
            if ($search) {
                if (!empty($search->term)) {
                    //support multiple words
                    $term = explode(' ', $search->term);

                    foreach ($term as $t) {
                        $not = '';
                        $operator = 'OR';
                        if (substr($t, 0, 1) == '-') {
                            $not = 'NOT ';
                            $operator = 'AND';
                            //trim the - sign off
                            $t = substr($t, 1, strlen($t));
                        }

                        $like = '';
                        $like .= "( `order_number` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `bill_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `bill_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `status` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `notes` " . $not . "LIKE '%" . $t . "%' )";

                        $this->db->where($like);
                    }
                }
                if (!empty($search->start_date)) {
                    $this->db->where('ordered_on >=', $search->start_date);
                }
                if (!empty($search->end_date)) {
                    //increase by 1 day to make this include the final day
                    //I tried <= but it did not function. Any ideas why?
                    $search->end_date = date('Y-m-d', strtotime($search->end_date) + 86400);
                    $this->db->where('ordered_on <', $search->end_date);
                }
            }

            if ($limit > 0) {
                $this->db->limit($limit, $offset);
            }
            if (!empty($sort_by)) {
                $this->db->order_by($sort_by, $sort_order);
            }
            $cur_month = date('m');
            $this->db->where('MONTH(VERZENDDAT)', $cur_month);
            $this->db->where('shop_id', $shop_id);
            return $this->db->get('verzending')->result();
        }
    }

    function get_new_shipments_count($search = false) {

        if ($search) {
            if (!empty($search->term)) {
                //support multiple words
                $term = explode(' ', $search->term);

                foreach ($term as $t) {
                    $not = '';
                    $operator = 'OR';
                    if (substr($t, 0, 1) == '-') {
                        $not = 'NOT ';
                        $operator = 'AND';
                        //trim the - sign off
                        $t = substr($t, 1, strlen($t));
                    }

                    $like = '';
                    $like .= "( `order_number` " . $not . "LIKE '%" . $t . "%' ";
                    $like .= $operator . " `bill_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `bill_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `ship_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `status` " . $not . "LIKE '%" . $t . "%' ";
                    $like .= $operator . " `notes` " . $not . "LIKE '%" . $t . "%' )";

                    $this->db->where($like);
                }
            }
            if (!empty($search->start_date)) {
                $this->db->where('ordered_on >=', $search->start_date);
            }
            if (!empty($search->end_date)) {
                $this->db->where('ordered_on <', $search->end_date);
            }
        }
        return $this->db->count_all_results('verzending');
    }

    function get_old_shipments_count($search = false) {

        if ($search) {
            if (!empty($search->term)) {
                //support multiple words
                $term = explode(' ', $search->term);

                foreach ($term as $t) {
                    $not = '';
                    $operator = 'OR';
                    if (substr($t, 0, 1) == '-') {
                        $not = 'NOT ';
                        $operator = 'AND';
                        //trim the - sign off
                        $t = substr($t, 1, strlen($t));
                    }

                    $like = '';
                    $like .= "( `order_number` " . $not . "LIKE '%" . $t . "%' ";
                    $like .= $operator . " `bill_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `bill_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `ship_firstname` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `status` " . $not . "LIKE '%" . $t . "%' ";
                    $like .= $operator . " `notes` " . $not . "LIKE '%" . $t . "%' )";

                    $this->db->where($like);
                }
            }
            if (!empty($search->start_date)) {
                $this->db->where('ordered_on >=', $search->start_date);
            }
            if (!empty($search->end_date)) {
                $this->db->where('ordered_on <', $search->end_date);
            }
        }
        return $this->db->count_all_results('verzending');
    }

    function remove_item($product_id, $order_id, $shop_id) {

        $this->db->where('id', $product_id);
        $this->db->where('order_id_number', $order_id);
        $this->db->delete('order_items');
    }

    function get_address($country_index, $shop_id) {

        $c = strtoupper($country_index);
        $this->db->where('shop_id', $shop_id);
        $this->db->where('country_index', $c);
        return $this->db->get('invoice_company_address')->row_array();
    }

    function get_bank($country_index, $shop_id) {
        $c = strtoupper($country_index);
        $this->db->where('shop_id', $shop_id);
        $this->db->where('country_index', $c);
        return $this->db->get('invoice_bank_account')->row_array();
    }

    function get_verzending_orders($shop_id) {
        return $this->db->select('VERZENDNR,ORDERNR')->where('shop_id', $shop_id)->get('verzending')->result_array();
    }

    function get_verzending($order_number, $shop_id) {
        return $this->db->where(array('shop_id' => $shop_id, 'ORDERNR' => $order_number))->get('verzending')->result_array();
    }

    function get_shipment($id, $shop_id) {
        return $this->db->where(array('shop_id' => $shop_id, 'id' => $id))->get('verzending')->row();
    }

    public function get_order_verzending($id, $shop_id) {

        return $this->db->where(array('order_number' => $id, 'shop_id' => $shop_id))->get('orders')->row();
    }

    function get_customer_recent_ordered_products($NR) {
        /*
          $this->db->select('NR,status,order_number,ordered_on');
          $this->db->where('shop_id',$shop);
          $this->db->where('customer_id',$NR);
          $orders = $this->db->get('orders')->result_array();

          foreach($orders as $order){

          $this->db->where('order_id',$order['NR']);
          $this->db->where('shop_id',$shop);
          $items = $this->db->get('order_items')->result_array();
          $r = array('items'=> $items);
          $g = array_merge($order,$r);
          }
          return $g;
         */
    }

    function get_price_list($nr, $shop) {

        $this->db->where('RELATIESNR', $nr);
        $this->db->where('shop_id', $shop);
        $this->db->order_by('INVDATUM', 'DESC');
        return $this->db->get('prijslijst')->result();
    }

    public function insert_discount_price($data) {

        $this->db->insert_batch('prijslijst', $data);
        return $this->db->insert_id();
    }

    function delete_discount_products($id) {

        $this->db->where('id', $id);
        $this->db->delete('prijslijst');
    }

    function activate_discount_products($id) {

        $this->db->where('id', $id);
        $d = array('active' => 1);
        $this->db->update('prijslijst', $d);
    }

    function get_price_list_product($id) {

        $this->db->where('id', $id);
        return $this->db->get('prijslijst')->result_array();
    }

    function check_special_price($data, $shop_id, $customer_id) {

        $this->db->select('saleprice');
        $this->db->where(array('shop_id' => $shop_id, 'RELATIESNR' => $customer_id, 'ARTIKELCOD' => $data['code']));
        return $this->db->get('prijslijst')->row_array();
    }

    public function get_invoice_adres($NR, $shop) {


        $this->db->where('shop_id', $shop);
        $this->db->where('SOORT', 1);
        $this->db->where('RELATIESNR', $NR);
        return $this->db->get('adres')->row_array();
    }

    public function get_delivery_adres($NR, $shop) {

        $this->db->where('shop_id', $shop);
        $this->db->where('SOORT', 2);
        $this->db->where('RELATIESNR', $NR);
        return $this->db->get('adres')->row_array();
    }

    function get_staff($nr, $shop) {

        $this->db->select('office_staff,field_service');
        $this->db->where('shop_id', $shop);
        $this->db->where('NR', $nr);
        $result = $this->db->get('customers');
        $c_details = $result->row();
        return $c_details;
    }

    public function get_order_verzendings($id, $shop_id) {

        return $this->db->where(array('shop_id' => $shop_id, 'OPDRACHTNR' => $id))->get('verzending')->row();
    }

    function get_all_items_for_back_ship($NR, $order_number, $shop_id) {


        $this->db->where('OPDRACHTNR', $NR);
        $this->db->where('ORDERNR', $order_number);
        $this->db->where('shop_id', $shop_id);
        $this->db->where('VERZONDEN >', 0);
        $result = $this->db->get('verzendregel')->result_array();
        return $result;
    }

    function get_backorder_products($NR, $id) {


        $this->db->where('order_id_number', $id);
        $this->db->where('shop_id', $this->data_shop);
        $this->db->where('BACKORDER', '1');
        $result = $this->db->get('order_items');

        if ($result->num_rows() > 0) {

            $this->db->order_by('id', 'ACS');
            $this->db->where('order_id', $NR);
            $this->db->where('shop_id', $this->data_shop);
            $result1 = $this->db->get('order_items')->result_array();
            return $result1;
        } else {

            $this->db->order_by('id', 'ACS');
            $this->db->where('order_id', $NR);
            $this->db->where('shop_id', $this->data_shop);
            $result2 = $this->db->get('order_items')->result_array();
            return $result2;
        }
    }

    function get_order_backorder_products($order_id, $shop) {

        $this->db->where('order_id', $order_id);
        $this->db->where('shop_id', $shop);
        $result = $this->db->get('backorder')->result_array();
        return $result;
    }

    function get_order_backorder_only_products($order_id, $shop) {

        $this->db->select('product_code');
        $this->db->where('order_id', $order_id);
        $this->db->where('shop_id', $shop);
        $result = $this->db->get('backorder')->result();
        return $result;
    }

    function set_printed($id, $shop) {

        $this->db->where('shop_id', $shop);
        $this->db->where('id', $id);
        $this->db->update('orders', array('printed' => 1));
    }

    function insert_resevations($data, $customer) {
        echo "<pre>";
        foreach ($data as $product) {
            $product['product_code'] = $this->clearTerm($product['product_code']);
            $productForReservation = $product['quantity'];
            while (true) {
                // TO DO fix / problem in product_code
                $this->db->trans_begin();
                $sql = "SELECT MIN('id'), id, reception_date,"
                        . " code,current_quantity,ordered_quantity  "
                        . " FROM warehouse_order_products "
                        . " WHERE shop_id = '" . $product['shop_id'] . "' "
                        . " AND (code='" . $product['product_code'] . "' "
                        . " OR code='".$product['product_code'] . "/' ) "
                        . " AND updated=0 "
                        . " AND  current_quantity > ordered_quantity "
                        . " FOR UPDATE ";
 echo "\n$sql\n";
                $query = $this->db->query($sql);
                $oldest = $query->row();

                print_r($oldest);
                if ($query->num_rows() < 1 || empty($oldest->id)) {
                    echo "\ncp1\n";
                    // set backorder = 1 in order_item
                    $sql = "UPDATE order_items SET BACKORDER = 1 "
                            . " WHERE shop_id = '" . $product['shop_id'] . "' "
                            . " AND (code='" . $product['product_code'] . "' "
                            . " OR code='".$product['product_code'] . "/' ) "
                            . " AND order_id = '" . $product['order_id'] . "' ";
                    $query1 = $this->db->query($sql);
                    // TO DO update orders table BACKORDER + 1
                    $this->db->where(array('shop_id' => $product['shop_id'], 'BACKORDER' => 0, 'NR' => $product['order_id']))->update('orders', array('BACKORDER' => 1));
                    // save in backorder
                    $sql = "INSERT backorder SET order_id='" . $product['order_id'] . "', "
                            . " shop_id ='" . $product['shop_id'] . "', "
                            . " product_code='" . $product['product_code'] . "', "
                            . " backorder_quantity='" . $productForReservation . "', "
                            . " current_stock=0, "
                            . " order_number ='" . $product['order_number'] . "', "
                            . " order_date ='" . $product['reservation_date'] . "', "
                            . " backorder_date ='" . $product['reservation_date'] . "', "
                            . " customer ='" . addslashes($customer->company) . "', "
                            . " agent_id ='" . $customer->field_service . "', "    // TO Do may be from registered user?
                            . " agent_name ='" . $this->session->userdata('ba_username') . "' ";
                    $query2 = $this->db->query($sql);
                    //
                    // end transaction
                    // if error echo for test purpose exit;
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        echo "<pre>Should not goes here</pre>";
                        exit;
                        continue;
                    } else {
                        $this->db->trans_commit();
                        break; // GO to next product
                    }
                    // 
                } else {
                    echo "\ncp2\n";
                    if ($oldest->current_quantity - $oldest->ordered_quantity >= $productForReservation) {
                        // change warehouse_order_products  ordered_quantity
                        // no back orders
                        $sql = "UPDATE warehouse_order_products SET "
                                . " ordered_quantity=ordered_quantity+'" . $productForReservation . "' "
                                . " WHERE id='" . $oldest->id . "' ";
 echo "\n 1-> $sql\n";
                        $query2 = $this->db->query($sql);
                        // set order_item backorder = 0
                        $sql = "UPDATE order_items SET BACKORDER = 0 "
                                . " WHERE shop_id = '" . $product['shop_id'] . "' "
                                . " AND (code='" . $product['product_code'] . "' "
                                . " OR code='".$product['product_code'] . "/' ) "
                                . " AND order_id = '" . $product['order_id'] . "' ";
 echo "\n$sql\n";
                        $query1 = $this->db->query($sql);
                        //
                        $productForReservation = 0;
                        //
                        // end transaction
                        if ($this->db->trans_status() === FALSE) {
                            $this->db->trans_rollback();
                            echo "<pre>Should not goes here</pre>";
                            exit;
                            continue;
                        } else {
                            $this->db->trans_commit();
                            break; // GO to next product
                        }
                        // go to next broduct - break
                    } else { // if($oldest->current_quantity - $oldest->ordered_quantity < $productForReservation)
                        // change warehouse_order_products
echo "\nqq\n";
                        $update_products = array('ordered_quantity' => $oldest->current_quantity);
                        $this->db->where('id', $oldest->id);
                        $this->db->update('warehouse_order_products', $update_products);
                        //
                        // set order_item backorder = 1
                        $sql = "UPDATE order_items SET BACKORDER = 1 "
                                . " WHERE shop_id = '" . $product['shop_id'] . "' "
                                . " AND (code='" . $product['product_code'] . "' "
                                . " OR code='".$product['product_code'] . "/' ) "
                                . " AND order_id = '" . $product['order_id'] . "' ";
                        $query1 = $this->db->query($sql);
                        // order itself
                        $this->db->where(array('shop_id' => $product['shop_id'], 'NR' => $product['order_id']))->update('orders', array('BACKORDER' => 1));
                        // // save rest in backorder NOT NEEXDED ?!
                        /*
                        $rest = $productForReservation - $oldest->current_quantity + $oldest->ordered_quantity;
                        $sql = "INSERT backorder SET order_id = '" . $product['order_id'] . "', "
                                . " shop_id ='" . $product['shop_id'] . "', "
                                . " product_code='" . $product['product_code'] . "', "
                                . " backorder_quantity='0', "
                                . " current_stock=0, "
                                . " order_number ='" . $product['order_number'] . "', "
                                . " order_date ='" . $product['reservation_date'] . "', "
                                . " backorder_date ='" . $product['reservation_date'] . "', "
                                . " customer ='" . addslashes($customer->company) . "', "
                                . " agent_id ='" . $customer->field_service . "', "    // TO Do may be from registered user?
                                . " agent_name ='" . $this->session->userdata('ba_username') . "' ";
                        $query2 = $this->db->query($sql);
                         * 
                         */
                        // continue
                        if ($this->db->trans_status() === FALSE) {
                            $this->db->trans_rollback();
                            echo "<pre>Should not goes here 2</pre>";
                            exit;
                            continue;
                        } else {
                            $this->db->trans_commit();
                            $productForReservation -= $oldest->current_quantity - $oldest->ordered_quantity;
                            continue; // to next wherehows record
                        }
                    }
                }
            }
            // 
            $this->checkItemsForBack($product['shop_id'],$product['order_id']);
        }
        
        echo "</pre>";
    }

    function close_reservation($item, $shop, $order_nr) {

        $new_data = array('DELRECORD' => 1);

        $this->db->where('shop_id', $shop);
        $this->db->where('product_code', $item);
        $this->db->where('order_id', $order_nr);
        $this->db->update('reservations', $new_data);
    }
    /**
     * Check order items for BACKORDER flag and set BACKORDER flag in order
     * @param type $shop_id string
     * @param type $order_id string
     */
    public function checkItemsForBack($shop_id,$order_id)
    {
        $sql = "SELECT count(*) as numb FROM order_items "
                        . "WHERE order_id='" . $order_id. "' "
                        . "AND BACKORDER=1 AND shop_id='$shop_id'";
        $query = $this->db->query($sql);
        $row = $query->row();
        if ($row->numb > 0) {
                    
            $this->db->where(array('shop_id' => $shop_id, 'BACKORDER' => 0, 'NR' => $order_id))->update('orders', array('BACKORDER' => 1));
        }
        else 
        {
            $this->db->where(array('shop_id' => $shop_id, 'BACKORDER' => 1, 'NR' => $order_id))->update('orders', array('BACKORDER' => 0));
        }
    }
    /**
     * Clear '/' from the end of search string
     * @param type $term string
     * @return type string
     */
    public function clearTerm($term='')
    {
        $term = trim($term);
        if(substr($term,-1)=='/')
                $term = substr($term,0,-1);
        return($term);
    }

}
