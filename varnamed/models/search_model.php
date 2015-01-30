<?php
Class Search_model extends CI_Model{
    
	function __construct(){
		parent::__construct();
	}
	
	/********************************************************************

	********************************************************************/
	
	function record_term($term){
		$code	= md5($term);
		$this->db->where('code', $code);
		$exists	= $this->db->count_all_results('search');
		if ($exists < 1){
			$this->db->insert('search', array('code'=>$code, 'term'=>$term));
		}
		return $code;
	}
	
	function get_term($code){
		$this->db->select('term');
		$result	= $this->db->get_where('search', array('code'=>$code));
		$result	= $result->row();
		return $result->term;
	}
        /*******************************************************************************************************************************************************/   
        public function find_invoices($search=false, $sort_by='', $sort_invoice='DESC', $limit=10, $offset=0,$shop_id){

            if(!empty($shop_id)){

                if(!empty($search)){
                       
                        $term = explode(' ', $search);

                            foreach($term as $t){
                                
                                $not		= '';
                                $operator	= 'OR';
                                
                            if(substr($t,0,1) == '-'){

                                $not		= 'NOT ';
                                $operator	= 'AND';
                                $t              = substr($t,1,strlen($t));
                            }

                                    $like           = '';
                                    $like	.= "( `invoice_number` ".$not."LIKE '%".$t."%' " ;
                                    $like          .= $operator." `company` ".$not."LIKE '%".$t."%'  ";
                                    $like          .= $operator." `firstname` ".$not."LIKE '%".$t."%'  ";
                                    $like          .= $operator." `city` ".$not."LIKE '%".$t."%'  ";
                                    $like          .= $operator." `zip` ".$not."LIKE '%".$t."%'  ";
                                    $like          .= $operator." `country` ".$not."LIKE '%".$t."%'  ";
                                    $like          .= $operator." `order_number` ".$not."LIKE '%".$t."%' )";
                                    $this->db->where($like);
                            }	
                        }		
                    

                        if($limit>0){
                            $this->db->limit($limit, $offset);
                        }
                        if(!empty($sort_by)){
                            $this->db->order_by($sort_by, $sort_invoice);
						}
						


                        $this->db->select('id,invoice_number,order_number,fully_paid,created_on,company,TAAL,zip,city,country');
						$this->db->where('shop_id',$shop_id);
                        return $this->db->get('invoices')->result_array();

                    }
		}
        /*******************************************************************************************************************************************************/        
        public function find_customers($search=false, $sort_by='', $sort='DESC', $limit=10, $offset=0,$shop_id,$data){

            if(!empty($shop_id)){
                
				if(!empty($search)){
                    
                    $term = explode(' ', $search);
                        
                    foreach($term as $t){
					$not		= '';
					$operator	= 'OR';
					if(substr($t,0,1) == '-'){
						$not		= 'NOT ';
						$operator	= 'AND';

						$t		= substr($t,1,strlen($t));
							}
                                        //echo $t;
                                        $like	= '';
										$like	.= "( `customer_number` ".$not."LIKE '%".$t."%' " ;
                                        $like	.= $operator." `company` ".$not."LIKE '%".$t."%'  ";
                                        $like	.= $operator." `firstname` ".$not."LIKE '%".$t."%'  ";
                                        $like	.= $operator." `email_1` ".$not."LIKE '%".$t."%'  ";
                                        $like	.= $operator." `POSTCODE` ".$not."LIKE '%".$t."%'  ";
                                        $like	.= $operator." `industry` ".$not."LIKE '%".$t."%'  ";
                                        $like	.= $operator." `PLAATS` ".$not."LIKE '%".$t."%'  ";
										$like	.= $operator." `lastname` ".$not."LIKE '%".$t."%' )";
										$this->db->where($like);
						}	
                    }
		
		if($limit>0){
			$this->db->limit($limit, $offset);
		}
		if(!empty($sort_by)){
			$this->db->order_by($sort_by, $sort);
		}
                $this->db->select('id,customer_number,company,firstname,lastname,STRAAT,PLAATS,POSTCODE,phone,country,email_1');

				if(!empty($data['term_country'])){
							$this->db->where('LANDCODE',$data['term_country']);
				}
				if(!empty($data['term_industry'])){
							$this->db->where('industry',$data['term_industry']);
				}
				if(!empty($data['term_buitendienst'])){
							$this->db->where('field_service',$data['term_buitendienst']);
				}

				$this->db->where('shop_id',$shop_id);

				return $this->db->get('customers')->result_array();
            }
        }
        /*******************************************************************************************************************************************************/   
		public function find_customers_zip($search=false, $sort_by='', $sort='DESC', $limit=10, $offset=0,$shop_id,$data){

            if(!empty($shop_id)){
                
				if(!empty($search)){
					$this->db->where('POSTCODE',$search);
				}	
                    
		
		if($limit>0){
			$this->db->limit($limit, $offset);
		}
		if(!empty($sort_by)){
			$this->db->order_by($sort_by, $sort);
		}
               // $this->db->select('id,NAAM1,NAAM2,NAAM3,STRAAT,PLAATS,POSTCODE,LAND,email,phone');

				if(!empty($data['term_country'])){
							$this->db->where('LANDCODE',$data['term_country']);
				}

				$this->db->where('shop_id',$shop_id);

				return $this->db->get('adres')->result_array();
            }
        }
        /*******************************************************************************************************************************************************/   
        public function find_products($search=false, $sort_by='', $sort='DESC', $limit=10, $offset=0,$shop_id){

            
            if(!empty($shop_id)){
	
			if(!empty($search)){

				$term = explode(' ', $search);

				foreach($term as $t){
					$not		= '';
					$operator	= 'OR';
					if(substr($t,0,1) == '-'){
						$not		= 'NOT ';
						$operator	= 'AND';
						$t		= substr($t,1,strlen($t));
					}
                                        echo $t;
					$like	 = '';
					$like	.= "( `description` ".$not."LIKE '%".$t."%' " ;
					$like	.= $operator." `code` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `type` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `name` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `name_NL` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `name_BE` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `name_UK` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `brand` ".$not."LIKE '%".$t."%' )";

					$this->db->where($like);
				}	
			}

		$this->db->select('id,code,type,name,enabled,cat_id,grp_id,supplier_id');
		if($limit>0){
			$this->db->limit($limit, $offset);
		}
		if(!empty($sort_by)){
			$this->db->order_by($sort_by, $sort);
		}
		if($this->data_shop == 3 ){
			$this->db->where('shop_id',33);
                        //echo '33';
		}
		else {
			$this->db->where('shop_id',$shop_id);
                        //echo $shop_id;
		}
                //echo 'dgnhn';
                return $this->db->get('products')->result_array();
            }
        }
        /*******************************************************************************************************************************************************/   
		public function find_orders($search=false, $sort_by='', $sort='DESC', $limit=10, $offset=0,$shop_id){

            
            if(!empty($shop_id)){
			
				if(!empty($search)){

					$term = explode(' ', $search);

					foreach($term as $t){
						$not		= '';
						$operator	= 'OR';
						if(substr($t,0,1) == '-'){
							$not		= 'NOT ';
							$operator	= 'AND';

							$t		= substr($t,1,strlen($t));
						}

						$like	= '';
						$like	.= "( `order_number` ".$not."LIKE '%".$t."%' " ;
											$like	.= $operator." `company` ".$not."LIKE '%".$t."%'  ";
											$like	.= $operator." `firstname` ".$not."LIKE '%".$t."%'  ";
											$like	.= $operator." `lastname` ".$not."LIKE '%".$t."%'  ";
						$like	.= $operator." `entered_by` ".$not."LIKE '%".$t."%' )";

						$this->db->where($like);
					}	
				}

					if($limit>0){
						$this->db->limit($limit, $offset);
					}
					if(!empty($sort_by)){
						$this->db->order_by($sort_by, $sort);
					}
					$this->db->select('id,order_number,company,entered_by,status,ordered_on');
					


					$this->db->where('shop_id',$shop_id);
					return $this->db->get('orders')->result_array();
			}
        }
		
		public function find_postcode($search=false, $sort_by='', $sort='DESC', $limit=10, $offset=0,$shop_id){
    
        if(!empty($shop_id)){
			if ($search){
				if(!empty($search)){

				$term = explode(' ', $search);

				foreach($term as $t){
					$not		= '';
					$operator	= 'OR';
					if(substr($t,0,1) == '-'){
						$not		= 'NOT ';
						$operator	= 'AND';

						$t		= substr($t,1,strlen($t));
					}

					$like	= '';
					$like	.= "( `POSTCODE` ".$not."LIKE '%".$t."%' " ;
                                        $like	.= $operator." `company` ".$not."LIKE '%".$t."%'  ";
					$like	.= $operator." `entered_by` ".$not."LIKE '%".$t."%' )";

                                        $this->db->where($like);
				}	
			}
			
		}
		
		if($limit>0){
			$this->db->limit($limit, $offset);
		}
		if(!empty($sort_by)){
			$this->db->order_by($sort_by, $sort);
		}
		$this->db->where('shop_id',$shop_id);
		return $this->db->get('customers')->result_array();

	}
        }


        
                public function find_customers_m($in, $sort_by='', $sort='DESC', $limit=10, $offset=0,$shop_id,$c){

            if(!empty($shop_id)){
                
		
				if($limit>0){
					$this->db->limit($limit, $offset);
				}
				if(!empty($sort_by)){
					$this->db->order_by($sort_by, $sort);
				}
                $this->db->select('id,company,firstname,lastname,STRAAT,PLAATS,POSTCODE,phone,fax_1,country,email_1');

				if(!empty($c)){
							$this->db->where('LANDCODE',$c);
				}
				if(!empty($in)){
							$this->db->where('industry',$in);
				}

				$this->db->where('shop_id',$shop_id);
                $this->db->where('DELRECORD',0);//FALSE
				return $this->db->get('customers')->result_array();
            }
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
}