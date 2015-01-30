<?php

Class stock_model extends CI_Model {

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

    function get_stock_orders($search = false, $sort_by = '', $sort_order = 'ASC', $limit = 0, $offset = 0, $shop_id = 0) {

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
                            $t = substr($t, 1, strlen($t));
                        }

                        $like = '';
                        $like .= "( `order_number` " . $not . "LIKE '%" . $t . "%' ";
                        $like .= $operator . " `warehouse` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `entered_by` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_country` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `forwarder` " . $not . "LIKE '%" . $t . "%' ";
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
            $curr_month = date('m');
            $curr_YEAR = date('Y');
            $this->db->where('DELRECORD', '0');
            $this->db->where('shop_id', $shop_id);
            //$this->db->where('MONTH(ordered_on) ', $curr_month);
            //$this->db->where('YEAR(ordered_on)', $curr_YEAR);

            return $this->db->get('stock_orders')->result();
        }
    }

    function get_stock_orders_delivered($search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0) {

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
                        $like .= $operator . " `warehouse` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `entered_by` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_country` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `forwarder` " . $not . "LIKE '%" . $t . "%' ";
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

            return $this->db->get('stock_orders')->result();
        }
    }

    function get_stock_orders_cancelled($search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0) {

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
                        $like .= $operator . " `warehouse` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `entered_by` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_country` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `forwarder` " . $not . "LIKE '%" . $t . "%' ";
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
            $this->db->where('status', '2');
            $this->db->where('shop_id', $shop_id);

            return $this->db->get('stock_orders')->result();
        }
    }

    function get_stock_orders_on_hold($search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0) {

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
                        $like .= $operator . " `warehouse` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `entered_by` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_country` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `forwarder` " . $not . "LIKE '%" . $t . "%' ";
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
            $this->db->where('status', '3');
            $this->db->where('shop_id', $shop_id);

            return $this->db->get('stock_orders')->result();
        }
    }

    function get_stock_orders_closed($search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0) {

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
                        $like .= $operator . " `warehouse` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `entered_by` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_country` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                        $like .= $operator . " `forwarder` " . $not . "LIKE '%" . $t . "%' ";
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

            return $this->db->get('stock_orders')->result();
        }
    }

    function get_stock_orders_count($search = false) {
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
                    $like .= $operator . " `warehouse` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `entered_by` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `ship_country` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `forwarder` " . $not . "LIKE '%" . $t . "%' ";
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

        return $this->db->count_all_results('stock_orders');
    }

    //get an individual customers orders
    function get_supplier_orders($id, $offset = 0) {
        $this->db->join('stock_order_items', 'stock_orders.id = stock_order_items.order_id');
        $this->db->order_by('ordered_on', 'DESC');
        return $this->db->get_where('stock_orders', array('supplier_id' => $id), 15, $offset)->result();
    }

    function count_supplier_orders($id) {
        $this->db->where(array('customer_id' => $id));
        return $this->db->count_all_results('orders');
    }

    function get_order($id) {


        $this->db->where('id', $id);
        $result = $this->db->get('stock_orders');
        if ($result->num_rows() > 0) {

            $order = $result->row();
            $order->contents = $this->get_items($order->id);
            return $order;
        } else {
            
        }
    }

    function get_reservation_order($id) {


        $this->db->where('order_number', $id);
        $result = $this->db->get('orders');
        if ($result->num_rows() > 0) {

            $order = $result->row();
            $order->contents = $this->get_items($order->id);
            return $order;
        } else {
            
        }
    }

    function get_items($id) {
        
    }

    function get_all_items($id, $nr, $order_number, $shop_id) {


        $this->db->where('order_id', $id);
        $this->db->where('NR', $nr);
        $this->db->where('order_number', $order_number);
        return $this->db->get('stock_order_items')->result_array();
    }

    function get_all_items_delivered($id, $nr, $order_number) {


        $this->db->where('stock_order_id', $id);
        $this->db->where('NR', $nr);
        $this->db->where('stock_order_number', $order_number);
        return $this->db->get('warehouse_order_products')->result_array();
    }

    function delete_delivered($id) {
        $this->db->where('id', $id);
        //$this->db->where('NR', $NR);
        $this->db->where('shop_id', $this->data_shop);
        $this->db->delete('stock_orders');

        //now delete the order items
        $this->db->where('stock_order_id', $id);
        //$this->db->where('NR', $NR);
        $this->db->where('shop_id', $this->data_shop);
        $this->db->delete('warehouse_order_products');
    }

    function delete($id) {
        $this->db->where('id', $id);
        //$this->db->where('NR', $NR);
        $this->db->where('shop_id', $this->data_shop);
        $this->db->delete('stock_orders');

        //now delete the order items
        $this->db->where('order_id', $id);
        //$this->db->where('NR', $NR);
        $this->db->where('shop_id', $this->data_shop);
        $this->db->delete('stock_order_items');
    }

    function save_order($data, $contents = false) {

        date_default_timezone_set('Europe/Sofia');


        if (isset($data['id'])) {

            $data['changed_on'] = date('Y-m-d');
            $data['changed_by'] = $this->session->userdata('ba_username');

            $this->db->where('id', $data['id']);
            $this->db->update('stock_orders', $data);
            $id = $data['id'];
            $order_number = $id;
        } else {
            $this->db->insert('stock_orders', $data);
            $id = $this->db->insert_id();

            //unix time stamp + unique id of the order just submitted.
            $order = array('order_number' => date('U') . $id);

            //update the order with this order id
            $this->db->where('id', $id);
            $this->db->update('stock_orders', $order);

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
                $this->db->insert('stock_order_items', $save);
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
        $result = $this->db->get('stock_orders');
        $order = $result->row();
        return $order;
    }

    public function insert_order($data) {
        if (!empty($data)) {
            $this->db->insert('stock_orders', $data);
            return $this->db->insert_id();
        }
    }

    public function update_new_order($data) {


        if (!empty($data)) {

            $this->db->where('shop_id', $this->data_shop);
            $this->db->where('id', $data['id']);
            $this->db->where('NR', $data['NR']);
            $this->db->where('order_number', $data['order_number']);
            $this->db->update('stock_orders', $data);
            return $data['id'];
        }
    }

    public function update_delivered_order($data) {


        if (!empty($data)) {

            $this->db->where('shop_id', $this->data_shop);
            $this->db->where('id', $data['id']);
            $this->db->where('NR', $data['NR']);
            $this->db->where('order_number', $data['order_number']);
            $this->db->update('stock_orders', $data);
            return $data['id'];
        }
    }

    public function update_new_warehouse_products($products) {

        foreach ($products as $product) {

            $this->db->where('shop_id', $this->data_shop);
            $this->db->where('order_id', $product['order_id']);
            $this->db->where('NR', $product['NR']);
            $this->db->where('ARTIKELCOD', $product['ARTIKELCOD']);
            $this->db->where('order_number', $product['order_number']);
            $this->db->update('stock_order_items', $product);
            return $product['order_id'];
        }
    }

    public function update_delivered_warehouse_products($data) {

        if (!empty($data)) {
            @$this->db->update_batch('warehouse_order_products', $data, 'id');
            return $data['id'];
        }
    }

    public function insert_stock_order_products($data) {



        $this->db->insert_batch('stock_order_items', $data);
        return $this->db->insert_id();
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

    public function update_status($order_number) {

        $data = array('status' => 'Processing');
        // update or insert
        if (!empty($order_number)) {

            $this->db->where('order_number', $order_number);
            $this->db->update('orders', $data);
        }
    }

    function checkout_stock($data) {


        $this->db->insert('warehouse', $data);
        return $this->db->insert_id();
    }

    function update_stock_order_status($data) {

        $new_stat = array('status' => $data['status']);
        // update or insert
        if (!empty($data['stock_order_id'])) {
            $this->db->where('shop_id', $this->data_shop);
            $this->db->where('id', $data['stock_order_id']);
            $this->db->where('NR', $data['stock_order_NR']);
            $this->db->where('order_number', $data['stock_order_number']);
            $this->db->update('stock_orders', $new_stat);
        }
    }

    function get_products_delivered($id) {

        return $this->db->where('id', $id)->get('warehouse')->row();
    }

    function get_last_order_id() {

        $this->db->select_max('id');
        return $this->db->get('stock_orders')->row_array();
    }

    function get_last_order($id) {

        $this->db->select('order_number,NR');
        $this->db->where('id', $id);
        return $this->db->get('stock_orders')->row_array();
    }

    public function insert_order_products($data) {

        $this->db->insert_batch('stock_order_items', $data);
        return $this->db->insert_id();
    }

    public function insert_warehouse_products($data) {

        $this->db->insert_batch('warehouse_order_products', $data);
        return $this->db->insert_id();
    }

    public function update_costs($data) {

        if (!empty($data)) {

            $costs = array(
                'shipping_cost' => $data['shipping_cost'],
                'duties' => $data['duties'],
                'other_costs' => $data['other_costs'],
            );


            $this->db->where('shop_id', $data['shop_id']);
            $this->db->where('id', $data['id']);
            $this->db->update('stock_orders', $costs);
        }
    }

    function get_order_costs($id) {

        return $this->db->where('id', $id)->get('stock_orders')->row_array();
    }

    function get_warehouse_order($id) {


        $this->db->where('stock_order_id', $id);
        $result = $this->db->get('warehouse');
        if ($result->num_rows() > 0) {

            $order = $result->row_array();
            //$order->contents	= $this->get_items($order->id);
            return $order;
        } else {
            
        }
    }

    function update_margin_index($data) {


        $margin = array('ek' => $data['margin'],);

        $this->db->where('stock_order_id', $data['stock_order_id']);
        $this->db->where('product_code', $data['product_code']);
        $this->db->update('warehouse_order_products', $margin);
    }

    function get_margin($data) {

        return $this->db->select('margin,')->where(array('product_code' => $data['product_code'], 'stock_order_number' => $data['stock_order_number']))->get('warehouse_order_products')->row();
    }

    function get_price($data) {
        return $this->db->where(array('order_id' => $data['order_id'], 'çode' => $data['code']))->get('stock_order_items')->row_array();
    }

    function prepare_margin($data) {

        return $this->db->where(array('product_code' => $data['product_code'], 'stock_order_id' => $data['stock_order_id']))->get('warehouse_order_products')->row_array();
    }

    function close_order($order_number) {

        $data = array('status' => 'Closed');
        $this->db->where('order_number', $order_number);
        $this->db->update('stock_orders', $data);
    }

    public function get_warehouse_stock($search = false, $shop_id) {

        if (!empty($search)) {
            $search = $this->clearTerm($search);
            $sql = "SELECT * FROM warehouse_order_products "
                    . " WHERE shop_id = '$shop_id' AND "
                    . " ( code='$search' OR code='$search/' )"
                    . " ORDER BY current_quantity ASC ";
            $query = $this->db->query($sql);
            return $query->result();
            /*
            $this->db->where('shop_id', $shop_id);
            $this->db->where('code', $search);
            $this->db->order_by('current_quantity', 'ACS');
            return $this->db->get('warehouse_order_products')->result();
             * 
             */
        }
    }

    public function get_reserved_stock($search = false, $shop_id) {

        if (!empty($search)) {

            $this->db->select_sum('quantity');
            $this->db->where('shop_id', $shop_id);
            $this->db->where('product_code', $search);
            $this->db->where('DELRECORD', '0');
            return $this->db->get('reservations')->row();
        }
    }

    function move_products($data) {
        if (!empty($data)) {
            $this->db->insert('stock_movement', $data);
            return $this->db->insert_id();
        }
    }

    function move_stock_1($data, $shop_id) {

        if (!empty($data)) {

            //$this->db->select_sum('current_quantity');

            if (!empty($data['order_number_from']) and ! empty($data['batch_number_from'])) {

                $this->db->where(array(
                    'shop_id' => $shop_id,
                    'code' => $data['product_code'],
                    'batch_number' => $data['batch_number_from'],
                    'stock_order_number' => $data['order_number_from'],
                ));
            }

            if (!empty($data['order_number_from']) and empty($data['batch_number_from'])) {

                $this->db->where(array(
                    'shop_id' => $shop_id,
                    'code' => $data['product_code'],
                    'stock_order_number' => $data['order_number_from'],
                ));
            }

            if (empty($data['order_number_from']) and ! empty($data['batch_number_from'])) {


                $this->db->where(array(
                    'shop_id' => $shop_id,
                    'code' => $data['product_code'],
                    'batch_number' => $data['batch_number_from'],
                ));
            }

            if (empty($data['order_number_from']) and empty($data['batch_number_from'])) {

                $this->db->where(array(
                    'shop_id' => $shop_id,
                    'code' => $data['product_code'],
                ));
                $this->db->like('warehouse_place', $data['warehouse_place_from']);
            }
            $result = $this->db->get('warehouse_order_products')->row();

            $new_quantity = $result->current_quantity - $data['quantity'];


            $new_data = array(
                'current_quantity' => $new_quantity,
            );

            print_r($new_data);

            $this->db->where(array(
                'shop_id' => $shop_id,
                'code' => $data['product_code'],
                'batch_number' => $data['batch_number_from'],
            ));

            // $this->db->update('warehouse_order_products', $new_data);
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function move_stock_3($data, $shop_id) {

        if (!empty($data)) {

            $this->db->select_sum('current_quantity');



            if (!empty($data['order_number_to']) and ! empty($data['batch_number_to'])) {

                $this->db->where(array(
                    'shop_id' => $shop_id,
                    'code' => $data['product_code'],
                    'batch_number' => $data['batch_number_to'],
                    'stock_order_number' => $data['order_number_to'],
                ));
            }

            if (!empty($data['order_number_to']) and empty($data['batch_number_to'])) {

                $this->db->where(array(
                    'shop_id' => $shop_id,
                    'code' => $data['product_code'],
                    'stock_order_number' => $data['order_number_to'],
                ));
            }

            if (empty($data['order_number_to']) and ! empty($data['batch_number_to'])) {
                echo $data['product_code'];
                $this->db->where(array(
                    'shop_id' => $shop_id,
                    'code' => $data['product_code'],
                    'batch_number' => $data['batch_number_to'],
                ));
            }

            if (empty($data['order_number_from']) and empty($data['batch_number_from'])) {

                $this->db->where(array(
                    'shop_id' => $shop_id,
                    'code' => $data['product_code'],
                ));
            }


            $result = $this->db->get('warehouse_order_products')->row();

            echo $result->current_quantity;
            $new_quantity = $result->current_quantity + $data['quantity'];

            $new_data = array(
                'current_quantity' => $new_quantity,
            );

            print_r($new_quantity);

            $this->db->where(array(
                'shop_id' => $shop_id,
                'code' => $data['product_code'],
                'batch_number' => $data['batch_number_from'],
            ));


            //$this->db->update('warehouse_order_products', $new_data);
        }
    }

    public function add_stock($data) {

        if (!empty($data)) {

            $this->db->select('current_quantity');

            $this->db->where(array(
                'product_code' => $data['product_code'],
                'stock_order_number' => $data['order_number'],
            ));

            $result = $this->db->get('warehouse_order_products')->row_array();

            $new_quantity_2 = $result['current_quantity'] + $data['count_products'];

            $new_data_2 = array(
                'current_quantity' => $new_quantity_2,
            );

            $this->db->where(array(
                'product_code' => $data['product_code'],
                'stock_order_number' => $data['order_number'],
            ));

            $this->db->update('warehouse_order_products', $new_data_2);
        }
    }

    public function remove_stock($data) {

        if (!empty($data)) {

            $this->db->select('current_quantity');

            $this->db->where(array(
                'product_code' => $data['product_code'],
                'stock_order_number' => $data['order_number'],
            ));

            $result = $this->db->get('warehouse_order_products')->row_array();

            $new_quantity_2 = $result['current_quantity'] - $data['count_products'];

            $new_data_2 = array(
                'current_quantity' => $new_quantity_2,
            );

            $this->db->where(array(
                'product_code' => $data['product_code'],
                'stock_order_number' => $data['order_number'],
            ));

            $this->db->update('warehouse_order_products', $new_data_2);
        }
    }

    public function get_backorder_stock($def, $search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0) {

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
                        $like .= "( `stock_order_number` " . $not . "LIKE '%" . $t . "%' ";
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




                if (!empty($def)) {
                    $this->db->where('shop_id', $shop_id);
                    $this->db->where('product_code', $def);
                    return $this->db->get('warehouse_order_products')->result();
                }
                $this->db->where('shop_id', $shop_id);
                $this->db->order_by('current_quantity', 'ACS');
                $this->db->limit(5);
                return $this->db->get('warehouse_order_products')->result();
            }
        }
    }

    function get_customer_order($data) {

        return $this->db->get_where('orders', array('order_number' => $data['order_number']))->row_array();
    }

    function insert_backorder($data) {
        $this->db->insert_batch('backorder', $data);
        return $this->db->insert_id();
    }

    public function get_discarded_stock($search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0) {

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
                        $like .= "( `stock_order_number` " . $not . "LIKE '%" . $t . "%' ";
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
            $this->db->order_by('current_quantity', 'ACS');
            $this->db->limit(5);
            return $this->db->get('warehouse_order_products')->result();
        }
    }

    public function get_reserved_products($search = false, $sort_by = '', $sort_order = 'DESC', $limit = 0, $offset = 0, $shop_id = 0) {

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
                        $like .= "( `stock_order_number` " . $not . "LIKE '%" . $t . "%' ";
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
            $this->db->where('DELRECORD', 0);
            $this->db->order_by('reservation_date', 'ACS');
            $this->db->limit(25);
            return $this->db->get('reservations')->result();
        }
    }

    function get_reserved_products_count($search = false, $shop) {

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
                    $like .= $operator . " `warehouse` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `entered_by` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `ship_country` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `ship_lastname` " . $not . "LIKE '%" . $t . "%'  ";
                    $like .= $operator . " `forwarder` " . $not . "LIKE '%" . $t . "%' ";
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
        $this->db->where('shop_id', $shop);
        $this->db->where('DELRECORD', 0);
        return $this->db->count_all_results('reservations');
    }

    function get_qurrent_quantity($data) {

        return $this->db->where(array('code' => $data['code']))->get('stock_order_items')->row_array();
    }

    function some($data, $s) {

        if (!empty($data['batch_number_from']))
            $from = $this->db->where(array('shop_id' => $s, 'code' => $data['product_code'], 'batch_number' => $data['batch_number_from']))->get('warehouse_order_products')->result_array();
    }

    public function add_to_stock($data) {

        $this->db->insert('warehouse_order_products', $data);
        return $this->db->insert_id();
    }

    public function remove_from_stock($data, $shop) {

        $this->db->where('shop_id', $shop);
        $this->db->where('code', $data['code']);
        $this->db->where('batch_number', $data['batch_number']);
        $new_quantity = array('current_quantity' => $data['number']);
        $this->db->update('warehouse_order_products', $new_quantity);
    }

    function select_from_stock($data, $shop) {

        $this->db->select('current_quantity');
        $this->db->where('shop_id', $shop);
        $this->db->where('code', $data['code']);
        $this->db->where('batch_number', $data['batch_number']);
        return $this->db->get('warehouse_order_products')->row();
    }

    function get_shop_suppliers($shop) {

        $this->db->select('id,company');
        $this->db->where('shop_id', $shop);
        $s = $this->db->get('suppliers')->result_array();
        foreach ($s as $v) {
            $d[$v['id']] = $v;
        }
        return $d;
    }

    function get_all_back_quantity($products, $shop, $ammount) { // to do select oldest back order

        /*
          $this->db->select('id');
          $this->db->where('shop_id',$shop);
          $this->db->where('BACKORDER',1);
          $this->db->where('quantity <=',$ammount);
          $this->db->where('code',$products['code']);
          $this->db->order_by('id');
          $this->db->limit(1);
          $query = $this->db->get('order_items');
         * 
         */
        $products['code'] = $this->clearTerm($products['code']);
        $sql = "SELECT id FROM backorder WHERE "
                . "(product_code='" . $products['code'] . "' OR product_code ='" . $products['code'] . "/" . "') "
                . " AND shop_id='$shop' AND backorder_quantity > 0"
                . " ORDER BY id LIMIT 1";
        echo "\n$sql\n";
        $query = $this->db->query($sql);
        if ($query->num_rows() < 1) {
            return false;
        }
        $result = $query->row();
        return $result->id;
    }

    function insert_new_quantities($products, $shop) {




        $warehouse_stock['shop_id'] = $products['shop_id'];
        $warehouse_stock['code'] = $products['code'];
        $warehouse_stock['current_quantity'] = $products['current_quantity'];
        $warehouse_stock['warehouse'] = $products['warehouse'];
        $warehouse_stock['stock_order_number'] = $products['stock_order_number'];
        $warehouse_stock['reception_date'] = $products['reception_date'] ? $products['reception_date'] : date("Y-m-d");
        $warehouse_stock['expiration_date'] = $products['expiration_date'];
        $warehouse_stock['batch_number'] = $products['batch_number'];
        $warehouse_stock['warehouse_place'] = $products['warehouse_place'];

        $warehouse_stock['ordered_quantity'] = $products['ordered_quantity'];


        $this->db->insert('warehouse_order_products', $warehouse_stock);
    }

    function remove_backorders($product, $shop) {

        $added_ammount = $product['current_quantity'];
        $product['code'] = $this->clearTerm($product['code']);
        while (true) {
            echo "\namount=" . $added_ammount . "\n";
            // Now return older backorder                    
            $id = $this->get_all_back_quantity($product, $shop, $added_ammount);
            echo "\nid=" . $id . "\n";
            if (!$id) {
                echo("\nNo id $added_ammount \n");
                // TO DO add reservations ??????????????????
                return($added_ammount);
            }
            // Now get this from backorder
            $quantity = $this->db->select('backorder_quantity')->where(array('id' => $id))->get('backorder')->row();
            $order_id = $this->db->select('order_id')->where(array('id' => $id))->get('backorder')->row();
            echo "\nquantity=" . $quantity->backorder_quantity . "\n";
            if ($added_ammount >= $quantity->backorder_quantity) {
                // set backorer in order_items
                // $this->db->where(array('id'=>$id))->update('order_items',array('BACKORDER'=>0));
                $sql = "UPDATE order_items SET BACKORDER = 0 "
                        . " WHERE shop_id ='" . $shop . "' "
                        . " AND ( code='" . $product['code'] . "' "
                        . " OR  code='" . $product['code'] .'/'. "' ) "
                        . " AND order_id = '" . $order_id->order_id . "' ";
                $query1 = $this->db->query($sql);
                // check order and eventially set
                $sql = "SELECT count(*) as numb FROM order_items "
                        . "WHERE order_id='" . $order_id->order_id . "' "
                        . "AND BACKORDER=1 ";
                echo "\n$sql\n";
                $query = $this->db->query($sql);
                $row = $query->row();
                print_r($row);
                if ($row->numb > 0) {
                    echo "\n".$row->numb."\n";
                    $this->db->where(array('shop_id' => $shop, 'BACKORDER' => 0, 'NR' => $order_id->order_id))->update('orders', array('BACKORDER' => 1));
                }
                else 
                {
                    echo "\nremove back order from order\n";
                    $this->db->where(array('shop_id' => $shop, 'BACKORDER' => 1, 'NR' => $order_id->order_id))->update('orders', array('BACKORDER' => 0));
                }
                //  fix backorder
                $newInBack = 0;
                $sql = "UPDATE backorder SET "
                        . " backorder_quantity= '$newInBack'"
                        . " WHERE id='" . $id . "' ";
                $query = $this->db->query($sql);
                // 
                $added_ammount -= $quantity->backorder_quantity;
                if ($added_ammount <= 0) {
                    echo("\nNo amount full item\n");
                    return(0);
                }
                continue;
            } else {   // fix partially backorder
                $newInBack = $quantity->backorder_quantity - $added_ammount;
                $sql = "UPDATE backorder SET "
                        . " backorder_quantity= '$newInBack' "
                        . " WHERE id='" . $id . "' ";
                $query = $this->db->query($sql);
                // $this->db->where(array('id'=>$id))->update('backorder',array('quantity'=> $quantity->quantity - $added_ammount));
                echo("\nNo amount partially item\n");
                return(0);
            }
        }
        exit;
    }

    function insert_resevations($data) {


        foreach ($data as $product) {

            $this->db->select_min('reception_date');
            $this->db->select('code,current_quantity,ordered_quantity');
            $this->db->where('shop_id', $product['shop_id']);
            $this->db->where('code', $product['product_code']);
            $oldest = $this->db->get('warehouse_order_products')->row();




            $this->db->select_sum('quantity');
            $this->db->where('shop_id', $product['shop_id']);
            $this->db->where('DELRECORD', 0);
            $this->db->where('product_code', $product['product_code']);
            $reserved_quantity = $this->db->get('reservations')->row();

            $f_reservation = $reserved_quantity->quantity + $product['quantity'];

            //while(true){

            if ($oldest->current_quantity >= $f_reservation) {

                $reserv = array('ordered_quantity' => $f_reservation);
                $this->db->where('shop_id', $product['shop_id']);
                $this->db->where('code', $product['product_code']);
                $this->db->where('reception_date', $oldest->reception_date);
                $this->db->update('warehouse_order_products', $reserv);
                //return false;
            }

            if ($oldest->current_quantity < $f_reservation) {

                $reserv = array('ordered_quantity' => $oldest->current_quantity);
                $this->db->where('shop_id', $product['shop_id']);
                $this->db->where('code', $product['product_code']);
                $this->db->where('reception_date', $oldest->reception_date);
                $this->db->update('warehouse_order_products', $reserv);
                $f_reservation -= $oldest->current_quantity;
                //return true;
            }
            //}	
        }
    }
    /**
     * Clear '/' from the end of search string
     * @param type $term string
     * @return type string
     */
    private function clearTerm($term='')
    {
        echo "\n $term -> ";
        $term = trim($term);
        if(substr($term,-1)=='/')
                $term = substr($term,0,-1);
        echo "$term\n";
        return($term);
    }
	
	function get_item_new_shippment_date($code,$shop){
	
		$this->db->select_max('VERWACHT');
		$this->db->where('shop_id',$shop);
		$this->db->where('ARTIKELCOD',$code);
		return $this->db->get('stock_order_items')->row();
	}
	
	function get_week_stock($shop){
	
		return $this->db->get_where('warehouse_order_products',array('shop_id'=>$shop,'current_quantity !='=>'0'))->result_array();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
