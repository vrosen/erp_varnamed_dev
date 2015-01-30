<?php
Class invoice_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_gross_monthly_sales($year){

		$this->db->select('SUM(coupon_discount) as coupon_discounts');
		$this->db->select('SUM(gift_card_discount) as gift_card_discounts');
		$this->db->select('SUM(subtotal) as product_totals');
		$this->db->select('SUM(shipping) as shipping');
		$this->db->select('SUM(tax) as tax');
		$this->db->select('SUM(total) as total');
		$this->db->select('YEAR(created_on) as year');
		$this->db->select('MONTH(created_on) as month');
		$this->db->group_by(array('MONTH(created_on)'));
		$this->db->invoice_by("created_on", "desc");
		$this->db->where('YEAR(created_on)', $year);
		
		return $this->db->get('invoices')->result();
	}
	
	function get_sales_years()
	{
		$this->db->invoice_by("created_on", "desc");
		$this->db->select('YEAR(created_on) as year');
		$this->db->group_by('YEAR(created_on)');
		$records	= $this->db->get('invoices')->result();
		$years		= array();
		foreach($records as $r)
		{
			$years[]	= $r->year;
		}
		return $years;
	}
	
	function get_invoices($search=false, $sort_by='', $sort_invoice='DESC', $limit=0, $offset=0,$shop_id=0){
            if(!empty($shop_id)){
			
			if(!empty($search->term)){
				//support multiple words
				$term = explode(' ', $search->term);

				foreach($term as $t){
					$not		= '';
					$operator	= 'OR';
					if(substr($t,0,1) == '-'){
						$not		= 'NOT ';
						$operator	= 'AND';
						//trim the - sign off
						$t		= substr($t,1,strlen($t));
					}

					$like	= '';
					$like	.= "( `invoice_number` ".$not."LIKE '%".$t."%' " ;
					$like	.= $operator." `company` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `firstname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `lastname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `address1` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `address2` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `city` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `country` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `customer_number` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `order_number` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `email` ".$not."LIKE '%".$t."%' )";

					$this->db->where($like);
				}	
			}

		if($limit>0){
			$this->db->limit($limit, $offset);
		}
		if(!empty($sort_by)){
			$this->db->order_by($sort_by, $sort_invoice);
		}
                $curr_month = date('m');
                $curr_YEAR  = date('Y');
				
				$this->db->where('shop_id',$shop_id);
                $this->db->where('fully_paid','0');
                $this->db->where('sent','1');
                $this->db->where('totalgross !=','0.00');
                $this->db->where('MONTH(created_on)', $curr_month);
                $this->db->where('YEAR(created_on)', $curr_YEAR);
				return $this->db->get('invoices')->result();
	}
        }
		
	function get_invoices_for_agent($search=false, $sort_by='', $sort_invoice='DESC', $limit=0, $offset=0,$shop_id=0,$c_id){
     
			
			if(!empty($search->term)){
				//support multiple words
				$term = explode(' ', $search->term);

				foreach($term as $t){
					$not		= '';
					$operator	= 'OR';
					if(substr($t,0,1) == '-'){
						$not		= 'NOT ';
						$operator	= 'AND';
						//trim the - sign off
						$t		= substr($t,1,strlen($t));
					}

					$like	= '';
					$like	.= "( `invoice_number` ".$not."LIKE '%".$t."%' " ;
					$like	.= $operator." `company` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `firstname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `lastname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `address1` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `address2` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `city` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `country` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `customer_number` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `order_number` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `email` ".$not."LIKE '%".$t."%' )";

					$this->db->where($like);
				}	
			}

		if($limit>0){
			$this->db->limit($limit, $offset);
		}
		if(!empty($sort_by)){
			$this->db->order_by($sort_by, $sort_invoice);
		}
                $curr_month = date('m');
                $curr_YEAR  = date('Y');
				
				$this->db->where('shop_id',$shop_id);
				$this->db->where('customer_id',$c_id);
                $this->db->where('fully_paid','0');
                $this->db->where('sent','1');
                //$this->db->where('totalgross !=','0.00');
                //$this->db->where('MONTH(created_on)', $curr_month);
                //$this->db->where('YEAR(created_on)', $curr_YEAR);
				return $this->db->get('invoices')->result();

        }
	
	function get_invoices_count_for_agent($search=false,$shop_id,$c_id){			
			
			if(!empty($search->term)){
				//support multiple words
				$term = explode(' ', $search->term);

				foreach($term as $t){
					$not		= '';
					$operator	= 'OR';
					if(substr($t,0,1) == '-'){
						$not		= 'NOT ';
						$operator	= 'AND';
						//trim the - sign off
						$t		= substr($t,1,strlen($t));
					}

					$like	= '';
					$like	.= "( `invoice_number` ".$not."LIKE '%".$t."%' " ;
					$like	.= $operator." `company` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `firstname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `lastname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `address1` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `address2` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `city` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `country` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `customer_number` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `order_number` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `email` ".$not."LIKE '%".$t."%' )";

					$this->db->where($like);
				}	
			}


                $curr_month = date('m');
                $curr_YEAR  = date('Y');
				
				$this->db->where('shop_id',$shop_id);
				$this->db->where('customer_id',$c_id);
                $this->db->where('fully_paid','0');
                $this->db->where('sent','1');
                //$this->db->where('totalgross !=','0.00');
               // $this->db->where('MONTH(created_on)', $curr_month);
              //  $this->db->where('YEAR(created_on)', $curr_YEAR);

				return $this->db->count_all_results('invoices');
	}
		
	function get_invoices_for_print($search=false, $sort_by='', $sort_invoice='DESC', $limit=0, $offset=0,$shop_id=0){
            if(!empty($shop_id)){
		if ($search){
			if(!empty($search->term)){
				//support multiple words
				$term = explode(' ', $search->term);

				foreach($term as $t){
					$not		= '';
					$operator	= 'OR';
					if(substr($t,0,1) == '-'){
						$not		= 'NOT ';
						$operator	= 'AND';
						//trim the - sign off
						$t		= substr($t,1,strlen($t));
					}

					$like	= '';
					$like	.= "( `invoice_number` ".$not."LIKE '%".$t."%' " ;
					$like	.= $operator." `company` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `firstname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `lastname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `address1` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `address2` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `city` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `country` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `customer_number` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `order_number` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `email` ".$not."LIKE '%".$t."%' )";

					$this->db->where($like);
				}	
			}
			if(!empty($search->start_date)){
				$this->db->where('created_on >=',$search->start_date);
			}
			if(!empty($search->end_date)){
				//increase by 1 day to make this include the final day
				//I tried <= but it did not function. Any ideas why?
				$search->end_date = date('Y-m-d', strtotime($search->end_date)+86400);
				$this->db->where('created_on <',$search->end_date);
			}
			
		}
		
		if($limit>0){
			$this->db->limit($limit, $offset);
		}
		if(!empty($sort_by)){
			$this->db->order_by($sort_by, $sort_invoice);
		}
                $curr_month = date('m');
                $curr_YEAR  = date('Y');
				
				$this->db->where('shop_id',$shop_id);
                $this->db->where('fully_paid','0');
                $this->db->where('per_email','0');
                $this->db->where('printed',NULL);
                $this->db->or_where('printed',0);
                $this->db->where('sent','0');
                $this->db->where('totalgross !=','0.00');
                $this->db->where('MONTH(created_on)', $curr_month);
                $this->db->where('YEAR(created_on)', $curr_YEAR);
		return $this->db->get('invoices')->result();
	}
        }
		
    function overview_invoices($shop_id,$agent){ 
	

                                $last_date = date("Y-m-t"); // use this in case to include current month
                                // $last_date = date("Y-m-t", strtotime(date("Y-m-d")." -1 months"));
                                $first_date = date("Y-m-d",strtotime( date( 'Y-m-01' )." -12 months"));

                                
                                if(!empty($agent)){
                                    $this->db->select_sum('totalnet');
                                    $this->db->select('customer_number,company,country_id,city,zip,YEAR(created_on) as y, MONTH(created_on) as m');
                                    $this->db->group_by('shop_id, customer_number,y, m, field_service');
                                    $this->db->where('shop_id',$shop_id);
				    $this->db->where('field_service',$agent);
                                    $this->db->where('totalgross !=','0.00');
                                    $this->db->where('created_on <=',$last_date);
                                    $this->db->where('created_on >=',$first_date);
                                    $this->db->where('customer_number  IS NOT NULL');
                                    $this->db->where('fully_paid','1');
                                    $this->db->order_by('shop_id');
                                    $this->db->order_by("customer_number");
                                    $this->db->order_by("y DESC");
                                    $this->db->order_by("m DESC");
                                }
                                else {
                                    $this->db->select_sum('totalnet');
                                    $this->db->select('customer_number,company,country_id,city,zip,YEAR(created_on) as y, MONTH(created_on) as m');
                                    $this->db->group_by('shop_id, customer_number,y, m');
                                    $this->db->where('shop_id',$shop_id);
                                    $this->db->where('totalgross !=','0.00');
                                    $this->db->where('created_on <=',$last_date);
                                    $this->db->where('created_on >=',$first_date);
                                    $this->db->where('customer_number  IS NOT NULL');
                                    $this->db->where('fully_paid','1');
                                    $this->db->order_by('shop_id');
                                    $this->db->order_by("customer_number");
                                    $this->db->order_by("y DESC");
                                    $this->db->order_by("m DESC");
                                }
                                $rawRes = $this->db->get('invoices')->result_array();
                                $res = array();
                                $cn = false;
                                $cna = false;
                                foreach($rawRes as $r)
                                {
                                    if($cn != $r['customer_number'])
                                    {
                                        // add previus to result
                                        $res[] = $cna;
                                        $cna = array();
                                        $cna['customer_number'] = $r['customer_number'];
                                        $cna['company'] = $r['company'];
                                        $cna['country_id'] = $r['country_id'];
                                        $cna['city'] = $r['city'];
                                        $cna['zip'] = $r['zip']; 
                                        $cna['tm'] = array();
                                        $cna['total'] = 0.0;
                                        $cn = $r['customer_number'];
                                    }
                                    $key = $r['y']."/".sprintf("%02d",$r['m']);
                                    $cna['tm'][$key] =  $r['totalnet'];  
                                    $cna['total'] += $r['totalnet'];
                                }
                                if($cna) $res[] = $cna;
                                usort($res, function($a, $b)
                                {
                                    if ($a['total'] == $b['total'])
                                    {
                                        return 0;
                                    }
                                    else if ($a['total'] > $b['total'])
                                    {
                                        return -1;
                                    }
                                    else {        
                                        return 1;
                                    }
                                });
                                // echo $this->db->last_query();
                                // echo "<pre>";
                                // print_r($res);
                                // exit;
			return $res;	
	}
		
		
		function get_all_invoices($search = false, $sort_by='', $sort_invoice='DESC', $limit=0, $offset=0,$shop_id=0){
        
				if(!empty($shop_id)){
		

					$this->db->where('shop_id',$shop_id);
					
					
					$start_date = 	$search['year'].'-'.sprintf('%02d',$search['month']).'-01';
					$next_month = date("Y-m-d", strtotime($start_date . ' +1 months'));

					$this->db->where('invoices.created_on >=', $start_date);
					$this->db->where('invoices.created_on <', $next_month);
					
					if(!empty($search['start_day']) and !empty($search['end_day'])){
						$this->db->where('invoices.created_on >=', $search['start_day']);
						$this->db->where('invoices.created_on <', $search['end_day']);
					}
					
					if(!empty($search['invoice_status'])){
						if($search['invoice_status'] == 1){
							$this->db->where('fully_paid','0');
						}
						if($search['invoice_status'] == 2){
							$this->db->where('fully_paid','1');
						}
					}
					if(!empty($search['sent'])){
						if($search['sent'] == 1){
							$this->db->where('sent','0');
						}
						if($search['sent'] == 2){
							$this->db->where('sent','1');
						}
					}
					
					if(!empty($search['country'])){
						$this->db->where('country_id',$search['country']);
					}
					
					if($limit>0){
						$this->db->limit($limit, $offset);
					}
					if(!empty($sort_by)){
					//	$this->db->order_by($sort_by, $sort_invoice);
					}
					if(!empty($search['payment_method'])){
						$this->db->where('payment_method',$search['payment_method']);
					}



					return $this->db->get('invoices')->result_array();

				}
			}
			function get_all_invoices_count($search = false,$shop_id=0){
        
				if(!empty($shop_id)){
		
					$curr_month = date('m');
					$curr_YEAR = date('Y');

					if(!empty($search['year'])){
						$this->db->where('YEAR(created_on)',$search['year']);
					}else {
						$this->db->where('YEAR(created_on)', $curr_YEAR);
						
					}
					
					if(!empty($search['month'])){
						$this->db->where('MONTH(created_on)',$search['month']);
					}else {
						$this->db->where('MONTH(created_on)', $curr_month);
					}

					if(!empty($search['invoice_status'])){
						if($search['invoice_status'] == 1){
							$this->db->where('fully_paid','0');
						}
						if($search['invoice_status'] == 2){
							$this->db->where('fully_paid','1');
						}
					}
					if(!empty($search['sent'])){
						if($search['sent'] == 1){
							$this->db->where('sent','0');
						}
						if($search['sent'] == 2){
							$this->db->where('sent','1');
						}
					}
					if(!empty($search['country'])){
						$this->db->where('country_id',$search['country']);
					}
					if(!empty($search['payment_method'])){
						$this->db->where('payment_method',$search['payment_method']);
					}
			

					$this->db->where('shop_id',$shop_id);
					
					$this->db->where('totalgross !=','0.00');
					
					
					return $this->db->count_all_results('invoices');
				}
			}
	
        	function get_sent_invoices($search=false, $sort_by='', $sort_invoice='DESC', $limit=0, $offset=0,$shop_id=0){
            if(!empty($shop_id)){
		if ($search){
			if(!empty($search->term)){
				//support multiple words
				$term = explode(' ', $search->term);

				foreach($term as $t){
					$not		= '';
					$operator	= 'OR';
					if(substr($t,0,1) == '-'){
						$not		= 'NOT ';
						$operator	= 'AND';
						//trim the - sign off
						$t		= substr($t,1,strlen($t));
					}

					$like	= '';
					$like	.= "( `invoice_number` ".$not."LIKE '%".$t."%' " ;
					$like	.= $operator." `order_number` ".$not."LIKE '%".$t."%' )";

					$this->db->where($like);
				}	
			}
			if(!empty($search->start_date)){
				$this->db->where('created_on >=',$search->start_date);
			}
			if(!empty($search->end_date)){
				//increase by 1 day to make this include the final day
				//I tried <= but it did not function. Any ideas why?
				$search->end_date = date('Y-m-d', strtotime($search->end_date)+86400);
				$this->db->where('created_on <',$search->end_date);
			}
			
		}
		
		if($limit>0){
			$this->db->limit($limit, $offset);
		}
		if(!empty($sort_by)){
			$this->db->order_by($sort_by, $sort_invoice);
		}
                $curr_month = date('m');
                $curr_YEAR = date('Y');
		$this->db->where('shop_id',$shop_id);
                $this->db->where('sent','1');
                $this->db->where('totalgross !=','0.00');
                $this->db->where('MONTH(created_on)', $curr_month);
                $this->db->where('YEAR(created_on)', $curr_YEAR);
		return $this->db->get('invoices')->result();
	}
        }
            function get_invoice_data($search=false,$shop_id=0){

            if(!empty($shop_id)){

		if ($search){
                    
			if(!empty($search['year'])){
				$this->db->where('YEAR(created_on)',$search['year']);
			}
			if(!empty($search['month'])){
				$this->db->where('MONTH(created_on)',$search['month']);
			}
			
		}

				$this->db->where('shop_id',$shop_id);
				return $this->db->get('invoices')->result_array();
			}
        }
	function get_invoices_count($search=false){			
		if ($search)
		{
			if(!empty($search->term))
			{
				//support multiple words
				$term = explode(' ', $search->term);

				foreach($term as $t)
				{
					$not		= '';
					$operator	= 'OR';
					if(substr($t,0,1) == '-')
					{
						$not		= 'NOT ';
						$operator	= 'AND';
						//trim the - sign off
						$t		= substr($t,1,strlen($t));
					}

					$like	= '';
					$like	.= "( `invoice_number` ".$not."LIKE '%".$t."%' " ;
					$like	.= $operator." `company` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `firstname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `lastname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `address1` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `address2` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `city` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `country` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `customer_number` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `order_number` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `email` ".$not."LIKE '%".$t."%' )";

					$this->db->where($like);
				}	
			}
			if(!empty($search->start_date))
			{
				$this->db->where('created_on >=',$search->start_date);
			}
			if(!empty($search->end_date))
			{
				$this->db->where('created_on <',$search->end_date);
			}
			
		}
		$this->db->where('status','open');
		return $this->db->count_all_results('invoices');
	}

		function get_all_invoices_count_($search=false){			
		
		if ($search)
		{
			if(!empty($search->term))
			{
				//support multiple words
				$term = explode(' ', $search->term);

				foreach($term as $t)
				{
					$not		= '';
					$operator	= 'OR';
					if(substr($t,0,1) == '-')
					{
						$not		= 'NOT ';
						$operator	= 'AND';
						//trim the - sign off
						$t		= substr($t,1,strlen($t));
					}

					$like	= '';
					$like	.= "( `invoice_number` ".$not."LIKE '%".$t."%' " ;
					$like	.= $operator." `bill_firstname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `bill_lastname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `ship_firstname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `ship_lastname` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `status` ".$not."LIKE '%".$t."%' ";
					$like	.= $operator." `notes` ".$not."LIKE '%".$t."%' )";

					$this->db->where($like);
				}	
			}
			if(!empty($search->start_date))
			{
				$this->db->where('created_on >=',$search->start_date);
			}
			if(!empty($search->end_date))
			{
				$this->db->where('created_on <',$search->end_date);
			}
			
		}
		
		return $this->db->count_all_results('invoices');
	}
	
	//get an individual customers invoices
	function get_customer_invoices($id, $offset=0,$shop_id)
	{
		//$this->db->join('invoice_items', 'invoices.id = invoice_items.invoice_id');
		$this->db->order_by('created_on', 'DESC');
		return $this->db->get_where('invoices', array('customer_id'=>$id,'shop_id'=>$shop_id), 15, $offset)->result();
	}
	
	function count_customer_invoices($id)
	{
		$this->db->where(array('customer_id'=>$id));
		return $this->db->count_all_results('invoices');
	}
	
	function get_invoice($id)
	{

		$this->db->where('id', $id);
		$result 		= $this->db->get('invoices');


                if($result->num_rows() > 0){
                $invoice		= $result->row();
		$invoice->contents	= $this->get_items($invoice->id);
                    return $invoice;
                }
		else {

                }
                
	}
		function get_invoice_normal($id)
	{

		$this->db->where('id', $id);
		$result 		= $this->db->get('invoices');
		if($result->num_rows() > 0){
		$invoice		= $result->row_array();
	return $invoice;
                }
		else {

                }
                
	}
	
	function get_items($id){

		$this->db->where('invoice_number', $id);
		return $this->db->get('invoice_items')->result_array();

	}
	
	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('invoices');
		
		//now delete the invoice items
		$this->db->where('invoice_id', $id);
		$this->db->delete('invoice_items');
	}
	
	function save_invoice($data, $contents = false)
	{
		if (isset($data['id']))
		{
			$this->db->where('id', $data['id']);
			$this->db->update('invoices', $data);
			$id = $data['id'];
			
			// we don't need the actual invoice number for an update
			$invoice_number = $id;
		}
		else
		{
			$this->db->insert('invoices', $data);
			$id = $this->db->insert_id();
			
			//create a unique invoice number
			//unix time stamp + unique id of the invoice just submitted.
			$invoice	= array('invoice_number'=> date('U').$id);
			
			//update the invoice with this invoice id
			$this->db->where('id', $id);
			$this->db->update('invoices', $invoice);
						
			//return the invoice id we generated
			$invoice_number = $invoice['invoice_number'];
		}
		
		//if there are items being submitted with this invoice add them now
		if($contents)
		{
			// clear existing invoice items
			$this->db->where('invoice_id', $id)->delete('invoice_items');
			// update invoice items
			foreach($contents as $item)
			{
				$save				= array();
				$save['contents']	= $item;
				
				$item				= unserialize($item);
				$save['product_id'] = $item['id'];
				$save['quantity'] 	= $item['quantity'];
				$save['invoice_id']	= $id;
				$this->db->insert('invoice_items', $save);
			}
		}
		
		return $invoice_number;

	}
	
	function get_best_sellers($start, $end)
	{
		if(!empty($start))
		{
			$this->db->where('created_on >=', $start);
		}
		if(!empty($end))
		{
			$this->db->where('created_on <',  $end);
		}
		
		// just fetch a list of invoice id's
		$invoices	= $this->db->select('id')->get('invoices')->result();
		
		$items = array();
		foreach($invoices as $invoice)
		{
			// get a list of product id's and quantities for each
			$invoice_items	= $this->db->select('product_id, quantity')->where('invoice_id', $invoice->id)->get('invoice_items')->result_array();
			
			foreach($invoice_items as $i)
			{
				
				if(isset($items[$i['product_id']]))
				{
					$items[$i['product_id']]	+= $i['quantity'];
				}
				else
				{
					$items[$i['product_id']]	= $i['quantity'];
				}
				
			}
		}
		arsort($items);
		
		// don't need this anymore
		unset($invoices);
		
		$return	= array();
		foreach($items as $key=>$quantity)
		{
			$product				= $this->db->where('id', $key)->get('products')->row();
			if($product)
			{
				$product->quantity_sold	= $quantity;
			}
			else
			{
				$product = (object) array('sku'=>'Deleted', 'name'=>'Deleted', 'quantity_sold'=>$quantity);
			}
			
			$return[] = $product;
		}
		
		return $return;
	}
        	function get_credit_note($id){
            
		$this->db->where('invoice_number', $id);
		$result 		= $this->db->get('credit_note');
		
		$credit_note		= $result->row();
		return $credit_note;
	}
	function get_credit_notes($id){
            
		$this->db->where('invoice_number', $id);
		$result 		= $this->db->get('invoices');
		
		$invoice		= $result->row();
		$invoice->contents	= $this->get_credit_items($invoice->invoice_number);
		
		return $invoice;
	}
	
        function fetch_invoice_id($id){
            

		$this->db->where('invoice_number', $id);
		$result 		= $this->db->get('invoices');
		$invoice_nr		= $result->row();
		return $invoice_nr;
        }
        function grt_order_invoices($id){
            

		$this->db->where('order_number', $id);
		$result 		= $this->db->get('invoices');
		$invoice_nr		= $result->result_array();
		return $invoice_nr;
        }
        
	function get_credit_items($id){

		$this->db->select('invoice_id, contents');
		$this->db->where('invoice_id', $id);
		$result	= $this->db->get('invoice_items');
		
		$items	= $result->result_array();
		
		$return	= array();
		$count	= 0;
		foreach($items as $item){

			$item_content	= unserialize($item['contents']);

			unset($item['contents']);
			$return[$count]	= $item;
			
			//merge the unserialized contents with the item array
			$return[$count]	= array_merge($return[$count], $item_content);
			
			$count++;
		}
		return $return;
	}
	
	function delete_credit_note_product(){

		$this->db->where(array('id'=>$id,'code'=>$code))->delete('invoice_items');
	}
        function check_note($id){
            
        $this->db->where('invoice_number', $id);
        $result         = $this->db->get('credit_note');
        $credit_note    = $result->row();
		return $credit_note;
        }
		
        function save_credit_note($data){

		$query = $this->db->get_where('credit_note',array('shop_id'=>$this->session->userdata('shop'),'invoice_number' => $data['invoice_number']));
		
		if ($query->num_rows() > 0){
		
					$new_data = $query->row_array();
		
					$max_cn = $this->db->select_max('credit_note_number')->get('credit_note')->row();
					
					if(strpbrk($max_cn->credit_note_number,'-')){
						
						$replacement_value = substr($max_cn->credit_note_number,-1)+1;
						$cn_new= substr_replace($max_cn->credit_note_number ,$replacement_value,-1);
					} else {
						$cn  = str_replace('CN','',$max_cn->credit_note_number);
						$cn_new = 'CN'.$cn.'-'.+1;
					}
					
					
					
					$credit_note['shop_id']             = $data['shop_id'];
					$credit_note['status']             	= $data['status'];
					$credit_note['credit_note_number']  = $cn_new;
					$credit_note['invoice_id']      	= $data['invoice_id'];
					$credit_note['invoice_number']      = $data['invoice_number'];
					$credit_note['order_number']        = $data['order_number'];
					$credit_note['customer_number']     = $data['customer_number'];
					$credit_note['company']             = $data['company'];
					$credit_note['delivery_condition']  = $data['delivery_condition'];
					$credit_note['payment_condition']   = $data['payment_condition'];
					$credit_note['per_email']          	= $data['per_email'];
					$credit_note['email']            	= $data['email'];
					$credit_note['invoice_created_on']  = $data['created_on'];
					$credit_note['order_dispatch_date'] = $data['order_dispatch_date'];
					$credit_note['created_on']          = $data['created_on'];
					$credit_note['VAT']          		= $data['VAT'];
					$credit_note['shipping']          	= $data['shipping'];
					$credit_note['ammount']             = $data['ammount'];
					$credit_note['made_by']             = $data['made_by'];
					$credit_note['made_by_id']      	= $data['made_by_id'];

					echo '<pre>';
					print_r($credit_note);
					echo '</pre>';
					$this->db->insert('credit_note', $credit_note);
					return $this->db->insert_id();
			} else {
					$this->db->insert('credit_note', $data);
					return $this->db->insert_id();
			}        
		}
		function save_credit_note_items($data){
		
			$this->db->insert_batch('credit_note_items', $data);
			return $this->db->insert_id();
		}
		
		function update_credit_note($data){
			
			$this->db->where('id',$data['id']);
			$this->db->update('credit_note',$data);
		}
		function update_credit_note_items($data){
			
			$this->db->where(array('credit_note_id' => $data['credit_note_id'], 'code' => $data['code']));
			$this->db->update('credit_note_items',$data);
		}
    	function get_invoice_details($id){
            
		return $this->db->where('invoice_number', $id)->get('invoices')->row_array();

	}
	
		function get_cnote_details($id){
				
			return $this->db->where('id', $id)->get('credit_note')->row_array();

		}
        public function get_client_invoice($id){
            

		$this->db->where('customer_id', $id);
		$result 		= $this->db->get('invoices');
		$invoice_details		= $result->row();
		return $invoice_details;
        }
        public function get_last_id($shop_id){
                
                $this->db->where('shop_id',$shop_id);
                $this->db->select_max('id');
		$result	= $this->db->get('invoices');
		return $result->row();
        }
        public function get_shop_invoices($shop_id,$last_id){
                
                $this->db->where('shop_id',$shop_id);
                $this->db->where('id',$last_id);
		$result	= $this->db->get('invoices');
		return $result->row();
        }   
        public function update_order($order_number){
            
            $data = array('status' => '');
            $this->db->where('order_number',$order_number);
            $this->db->update('invoices', $data);
        }
        public function check_invoice($id){
            

		$this->db->where('order_number', $id);
		$result 		= $this->db->get('invoices');
		$invoice_details		= $result->row();
		return $invoice_details;
        }
        public function list_existing_invoices($id){
            

		$this->db->where('order_number', $id);
		$result 		= $this->db->get('invoices');
		$invoice_details		= $result->result();
		return $invoice_details;
        }
        
        public function insert_invoice($data){

        $this->db->insert('invoices', $data);
        return $this->db->insert_id();
    }
        public function insert_DD($id){
            
            $data = array('DD' => '1');
            $this->db->where('customer_id', $id);
            $this->db->update('invoices', $data);
            return $data['id'];
        }
        public function get_sepa_invoices($data){

                $this->db->where('shop_id',$data['shop_id']);
                $this->db->where('status','open');
                $this->db->where('DD','1');
		$result	= $this->db->get('invoices');
		return $result->result();
        } 
        
        function count_invoices($data){
                
                $this->db->where('shop_id',$data['shop_id']);
                $this->db->where('status','open');
                $this->db->where('DD','1');
		return $this->db->count_all_results('invoices');
	}
        public function get_transaction_sum($data){

      		$this->db->select('SUM(totalgross) as totalgross');
                $this->db->where('shop_id',$data['shop_id']);
                $this->db->where('status','open');
                $this->db->where('DD','1');
		$result	= $this->db->get('invoices');
		return $result->row();
        } 
        
      	function get_comapny_name($id){

		$this->db->where('shop_id', $id);
		$result 		= $this->db->get('shops');
		$details		= $result->row();		
		return $details;
	}
        public function insert_items($data){

        $this->db->insert_batch('invoice_items', $data);
        return $this->db->insert_id();
        }
        public function get_invoice_address($id){
                
                $this->db->select('invoice_address');
		$this->db->where('id', $id);
		$result 		= $this->db->get('invoices');
		$order			= $result->row_array();		
		return $order;
	}
        public function check_send_type($id,$invoice_number){
        
            $this->db->select('per_email');
            $this->db->where('id', $id);
            $this->db->where('invoice_number', $invoice_number);
            return $this->db->get('invoices')->row_array();
            
        }   
        public function set_send_type($id,$invoice_number,$index){

            $data = array('per_email' => $index);
            $this->db->where('id', $id);
            $this->db->where('invoice_number', $invoice_number);
            $this->db->update('invoices', $data);
            
        }
        public function check_paid_status($id,$invoice_number){
        
            $this->db->select('fully_paid,paid_on');
            $this->db->where('id', $id);
            $this->db->where('invoice_number', $invoice_number);
            return $this->db->get('invoices')->row_array();
            
        }  
        public function set_fully_paid($id,$invoice_number,$index){
       
            $data = array('fully_paid' => $index,'paid_on' => '');
            $this->db->where('id', $id);
            $this->db->where('invoice_number', $invoice_number);
            $this->db->update('invoices', $data);
            
        }
        public function set_fully_paid_date($id,$invoice_number,$index,$date){
       
            $data = array('fully_paid' => $index,'paid_on' => $date);
            $this->db->where('id', $id);
            $this->db->where('invoice_number', $invoice_number);
            $this->db->update('invoices', $data);
            
        }
        function get_shop_name($id){
            return $this->db->select('shop_name')->where('shop_id',$id)->get('shops')->row_array();
        }
        function get_shop_address($id,$index){
            return $this->db->where(array('shop_id' => $id, 'country_index' => $index))->get('invoice_company_address')->row_array();
        }
        function get_shop_account($id,$index){
            
            return $this->db->select('account')->where(array('shop_id' => $id, 'country_index' => $index))->get('invoice_bank_account')->row_array();
        }
        function get_invoice_number($id){
            return $this->db->select('invoice_number')->where(array('id' => $id))->get('invoices')->row_array();
        }
      
        public function get_invoice_customer_address($id){
                
		$this->db->select('invoice_address');
		$this->db->where('customer_id', $id);
		$result 		= $this->db->get('orders');
		$order			= $result->row_array();		
		return $order;
	}
        public function get_invoice_customer_address_komatia($id){
                
        $this->db->select('company,firstname,lastname,address1,address2,zip,city,country');
		$this->db->where('customer_id', $id);
		$result 		= $this->db->get('orders');
		$order			= $result->row_array();		
		return $order;
	}
	function get_customer_db_id($customer_nr){
	
		$this->db->select('id');
		$this->db->where('shop_id',$this->data_shop);
		$this->db->where('NR',$customer_nr);
		return $this->db->get('customers')->row();
	
	}
	
	function get_order_details($order_number,$shop_id){
	
	return $this->db->where(array('order_number'=> $order_number,'shop_id'=>$shop_id))->get('orders')->row();
	
	}
	
	function get_invoice_items($invoice_number,$shop_id){
	
	return $this->db->where(array('invoice_number'=> $invoice_number,'shop_id'=>$shop_id))->get('invoice_items')->result_array();
	
	}
	
		function get_cnote_items($credit_note_id,$shop_id){
	
			return $this->db->where(array('credit_note_id'=> $credit_note_id,'shop_id'=>$shop_id))->get('credit_note_items')->result_array();
		
		}
		
        function get_customer_all_invoices($number, $offset=0,$shop_id,$M,$Y){

		$this->db->order_by('created_on', 'DESC');
                
                if(empty($M)){
                  $M = date('m');
                }
                if(empty($Y)){
                  $M = date('Y');
                }
                $this->db->where('shop_id', $shop_id);
                $this->db->where('customer_number', $number);
                $this->db->where('MONTH(created_on)', $M);
                $this->db->where('YEAR(created_on)', $Y);
		return $this->db->get('invoices')->result();
	}
	
        function get_customer_status_invoices($number, $offset=0,$shop_id,$status,$M,$Y){

                if(empty($M)){
                  $M = date('m');
                }
                if(empty($Y)){
                  $M = date('Y');
                }
                
                if($status == 2){
                    $this->db->order_by('created_on', 'DESC');
                    return $this->db->get_where('invoices', array('customer_number'=>$number,'shop_id'=>$shop_id,'fully_paid'=>0,'MONTH(created_on)'=>$M,'YEAR(created_on)' => $Y), 15, $offset)->result();
                }
                else {
                    $this->db->order_by('created_on', 'DESC');
                    return $this->db->get_where('invoices', array('customer_number'=>$number,'shop_id'=>$shop_id,'fully_paid'=>$status,'MONTH(created_on)'=>$M,'YEAR(created_on)' => $Y), 15, $offset)->result();
                }
	}
	        function remove_item($row_id){


			$this->db->where('id', $row_id);
			$this->db->delete('invoice_items');
        }
		        function printed_invoice($row_id){


			$this->db->where('id', $row_id);
			$d = array('printed',1);
			$this->db->update('invoices',$d);
        }
		function update_invoice($data){
		
			foreach($data as $value){
			
				if($value['id']){

					$this->db->where('id', $value['id']);
					$this->db->update('invoice_items',$value);

				}
				else {

					$this->db->where('shop_id', $value['shop_id']);
					//$this->db->where('order_id', $value['order_id']);
					$this->db->where('order_number', $value['order_number']);
					$this->db->where('invoice_number', $value['invoice_number']);
					$this->db->insert('invoice_items',$value);

				}
			}
		}
	
		public function change_invoice($id,$invoice_number,$data,$shop_id){

            $this->db->where('id', $id);
            $this->db->where('shop_id', $shop_id);
            $this->db->where('invoice_number', $invoice_number);
            $this->db->update('invoices', $data);
            
        }
	
		function get_invoice_credit_note($credit_note_number,$shop){
            
			return $this->db->get_where('credit_note',array('credit_note_number' => $credit_note_number,'shop_id'=>$shop))->row();
		}		
		function get_invoice_credit_note_items($id){
            
			return $this->db->get_where('credit_note_items',array('credit_note_id' => $id))->result_array();
		}
		
	function get_invoice_credit_notes($data){
            
		$this->db->where('invoice_id', $data['id']);
		$this->db->where('invoice_number', $data['invoice_number']);
		$this->db->where('shop_id', $this->session->userdata('shop'));
		return $this->db->get('credit_note')->result_array();

	}
	
	
	
	public function get_invoice_customer_address_pieces($id,$shop){
                

		$this->db->where('shop_id', $shop);
		$this->db->where('RELATIESNR', $id);
		$result 		= $this->db->get('adres');
		$order			= $result->row_array();		
		return $order;
	}
	
	function update_adres($nr,$shop,$update){
		
		$this->db->where('shop_id', $shop);
		$this->db->where('RELATIESNR', $nr);
		$this->db->update('adres',$update);
	
	}
	
	public function get_invoice_customer_address_pieces_1($number,$shop){
                
        $this->db->select('company,firstname,lastname,STRAAT,HUISNR,POSTCODE,PLAATS,country,LANDCODE');
		$this->db->where('shop_id', $shop);
		$this->db->where('customer_number', $number);
		$result 		= $this->db->get('customers');
		$order			= $result->row_array();		
		return $order;
	}
	
	function set_printed($id,$shop){	
		
		$this->db->where('shop_id',$shop);
		$this->db->where('invoice_number',$id);
		$this->db->update('invoices',array('printed'=>1));

	}	
	
	function get_customer_nr($cnr,$shop){
	
		$this->db->select('NR');
		$this->db->where('shop_id',$shop);
		$this->db->where('customer_number',$cnr);
		return $this->db->get('customers')->row();
	
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}