<?php
/* 
 * class that show complex turn over report
 * The Report is related to a lot of parameters
 * Parameters are shown as private parameters with
 * classic get, set and add, remove for masive parameters
 * 
 */

Class Complex_model2 extends CI_Model {
    // TO DO finished setter getter methods
    /**
     * so far relation between products and supliers are n:m
     * mean product might to have more than one supplier 
     * Unfortunateely so far in old and new system have no info about 
     * an partikular order who is the suppler this is TO DO fix later
     * so far to produce usefull table temporary tabel relartikelleverancier 
     * ( comming from old system ) is GROUP BY in temporary table
     * Code analyse parameters and whne it is need to create such temp table
     * flag is set to true
     * @var type boolean
     */
    private $tempFlag = false;
    
    /**
     *
     * @var type array industry id => industry name
     * should be table so far it is hacced from html of old system
     */
    private $industry_array = array(
	'82' => 'Abattoir',
	'66' => 'Ambulance service',
	'52' => 'Beauty salon',
	'77' => 'Butcher',
        '42' => 'Care group',
        '43' => 'Care shop',
        '74' => 'Cattle farmer',
        '56' => 'Cleaning',
        '38' => 'Day-care centre',
        '61' => 'Dental laboratory',
        '47' => 'Dental surgeons',
        '50' => 'Dental wholesale',
        '16' => 'Dentist',
        '58' => 'Disabled care',
        '20' => 'Doctor',
        '22' => 'Export',
        '35' => 'Family doctor',
	'75' => 'Fishmonger',
	'37' => 'Food service industry',
	'53' => 'Funeral parlour',
	'71' => 'Garden',
	'36' => 'Hairdresser',
	'3'  => 'Home care',
        '1'  => 'Hospital',
        '45' => 'Laboratory',
        '85' => 'Midwife',
        '59' => 'Nail studio',
        '2'  => 'Nursing home',
        '41' => 'Nursing home',
        '46' => 'Oral hygienist',
        '39' => 'Orthodontist',
	'8'  => 'Other / unknown',
        '40' => 'PMU',
        '79' => 'Painter',
        '34' => 'Pedicure',
        '62' => 'Pelvic therapist',
        '65' => 'Permanent make-up',
        '55' => 'Pet crematorium',
	'4'  => 'Pharmacy',
	'57' => 'Physiotherapy',
        '64' => 'Piercing studio/jeweller',
        '49' => 'Podotherapy',
        '67' => 'Private clinic',
        '32' => 'Private individual',
        '30' => 'Retailer',
        '33' => 'Tattoo shop',
        '54' => 'Veterinarian',
        '44' => 'Veterinary ambulance',
        '51' => 'Wholesale general',
        '5'  => 'Care phop',
        '6'  => 'Pharmaceutical wholesaler',
        '7'  => 'Medical wholesale',
        '18' => 'Rest &amp; convalescent home'
        
    );
    
    
    /**
     * check id some issue need to be join initially it was oblu for 
     * temp table but to made query more light now it is for all cases as 
     * agents, profucts customer 
     * pld use is : This is the function that does the job see upper
     * $this->tempFlag = $this->checkIfTempTableRequired('supplier')
     * @param type $cs string
     * @return type $ret boolan
     */
    
    private function checkIfTempTableRequired($cs)
    {
        /**
         * First check id supplier explicite is shown in table
         */
        if($this->showBy == $cs) 
        {
            return true;
        }
        /**
         * Second if supplier presents if filter 
         */
        foreach($this->filter as $key => $value)
        {
            if($key == $cs)
            {
                return true;
            }
        }
        return false;
    }
    /**
     *  Create temporary product - supplier n:1 RELATION TABLE
     */
    private function createTemp()
    {
        $sql = " CREATE TEMPORARY TABLE IF NOT EXISTS relationTemp ( "
               . " INDEX (shop_id,LEVERANCIE), "    /* index for relation with suppliers */
               . " INDEX (shop_id,ARTIKELCOD) ) ENGINE=MEMORY "   /* index for relation with products */
               . " AS ( SELECT ARTIKELCOD, shop_id, LEVERANCIE " /* select from m:n tables */
               . " FROM  relartikelleverancier GROUP BY shop_id, ARTIKELCOD ) ";
        // get the job done
        $query = $this->db->query($sql);
        
    }
    /**
     * I very rare case am product for same shope has 2 records to hide this
     * we create temporary table
     */
    private function createTempProduct()
    {
        $sql = " CREATE TEMPORARY TABLE IF NOT EXISTS tempProduct ( "
               . " INDEX (shop_id,code)) "    /* index for relation with invoice items */
               . " ENGINE=MEMORY "   /* index for relation with products */
               . " AS ( SELECT shop_id, code, cat_id, grp_id " /* select from m:n tables */
               . " FROM  products GROUP BY shop_id, code ) ";
        // get the job done
        $query = $this->db->query($sql);
        
    }
    /**
     * Private variable set from session and additionnaly with
     * classic seter and geter or add and remove for arrays
     * @var integer
     */
    
    private $shop_id=1;
    /**
     * Set shop_id
      */
    public function setShopId($shop_id=1)
    {
        $this->shop_id = $shop_id;
    }
    /**
     * what to show i.e customers , filed service and etc
     */
    private $showBy = false;
    /**
     * showBy setter
     * @param type $m false or string
     */
    public function setShowBy($m=false)
    {
        $this->showBy = $m;
    }
    /**
     *
     * @var type array $key => $id
     * Save how to filter data 
     */
    private $filter = array();
    /**
     * Add filter element if exist set id
     * @param type $key string
     * @param type $id  string
     */
    public function addFeilter($key, $id)
    {
        $this->filter[$key] = $value;
    }
    /**
     * Classing getter if argument missing clear filter
     * @param type $f array
     */
    public function setFilter($f=array())
    {
        $this->filter = $f;
    }
    /*
     * If true print usefull test info
     */
    private $testMode =  false;
    /*
     * Set test mode
     * @param type boolean
     */
    public function setTestMode($m=false)
    {
        $this->testMode = $m;
    }
    
    public function productTurnover($fromDate, $toDate)
    {
        $this->createTempProduct();
        return($this->turnover($fromDate, $toDate));
    }
    /**
     * Get turnover for period and pre set filter 
     * @param type $fromDate YYYY-mm-dd
     * @param type $toDate   YYYY-mm-dd
     * @param type $affix    string
     * @return type          array with result
     */
    public function turnover($fromDate, $toDate,$affix="")
    {
        $res = array();
        // Specific Columns part of select
        switch($this->showBy)
        {
            case 'agents':
                $sql = "SELECT a.agent_index AS qid, a.agent_name AS title, \n";
                break;
            case 'customers':
                $sql = "SELECT c.customer_number AS qid, i.company AS title, c.id AS real_id,  \n";
                break;
            case 'products':
                $sql  = "SELECT d.code AS title, \n"; 
                break;
            case 'country':
                $sql = "SELECT i.country_id AS qid, i.country AS title, \n";
                break;
            case 'category':
                $sql = "SELECT p.cat_id AS qid, t.name AS title, \n";
                break;
            case 'group':
                $sql = "SELECT p.grp_id AS qid, g.group_name AS title, \n";
                break;
            case 'supplier':
                $sql = "SELECT r.LEVERANCIE AS qid, s.company AS title, \n";
                break;
            case 'industry':
                $sql = "SELECT c.industry AS qid,  \n";
                break;
            default: 
                $sql = "SELECT ";
        }
        $sql .= $this->mainColums();
        // common sql DONE
        $sql .= $this->commonSQL($fromDate, $toDate);
        ////////$sql .= " AND c.company NOT LIKE 'Comforties%' "
        //        . " AND c.company NOT LIKE 'Dutchblue%' ";
        // extra where DONE
        foreach($this->filter as $key => $id)
        {
            switch($key)
            {
                case "agents":
                    $sql .= " AND c.field_service = '$id'";
                    break;
                case 'customers':
                    $sql .= " AND i.customer_number = '$id'";
                    break;
                case 'products':
                    $id1 = $id."/";
                    $sql .= " AND ( d.code = '$id' OR d.code = '$id1' ) ";
                    break;
                case "country":
                    if(!$id)  $sql .= " AND ( i.country_id  IS NULL OR i.country_id='') ";
                    else $sql .= " AND i.country_id = '$id'";
                    break;
                case 'category':
                    if(!$id) $sql .= " AND ( p.cat_id  IS NULL OR p.cat_id='') ";
                    else $sql .= " AND p.cat_id = '$id'";
                    break;
                case 'group':
                     if(!$id) $sql .= " AND ( p.grp_id  IS NULL OR  p.grp_id='') ";
                    else $sql .= " AND  p.grp_id = '$id'";
                    break;
                case 'supplier':
                    if(!$id) $sql .= " AND ( r.LEVERANCIE  IS NULL OR  r.LEVERANCIE='') ";
                    else $sql .= " AND  r.LEVERANCIE = '$id'";
                    break;
            }
        }
        
        // group by & prder by DONE 
        switch($this->showBy)
        {
            case "agents":
                $sql .= " GROUP BY c.field_service ORDER BY a.agent_name ";
                break;
            case 'customers':////////////////////
                $sql .= " GROUP BY i.customer_number ORDER BY i.company ";
                break;
            case 'products':
                $sql .= " GROUP BY d.code ";
                break;
            case "country":
                $sql .= " GROUP BY i.country_id ORDER BY i.country ";
                break;
            case "category":
                $sql .= " GROUP BY t.id ORDER BY t.id "; // to do cat lang field
                break;
            case "group":
                $sql .= " GROUP BY g.group_id ORDER BY g.group_id "; // to do cat lang field
                break;
            case "supplier":
                $sql .= " GROUP BY r.LEVERANCIE ORDER BY r.LEVERANCIE "; // to do cat lang field
                break;
            case 'industry':
                $sql .= "GROUP BY c.industry \n";
                break;
        }
        // get result DONE
        $query = $this->db->query($sql);
        $test = array();
        if ($query->num_rows() > 0)
        {
            
            foreach ($query->result_array() as $row)
            {
                switch($this->showBy)
                {
                    case 'agents':
                        if(!isset($row['qid']) || empty($row['qid']) )
                        {
                            $row['qid'] = '0';
                            $row['title'] = "No name";
                        }
                        else if(!isset($row['title']) || empty($row['title']))
                        {
                            $row['title'] = "Old Agent: ".$row['title'] = "No name";
                        }
                        break;
                    case 'products':
                        $row['qid'] = $row['title'];
                        break;
                    case 'category':
                        if(!isset($row['qid']) || empty($row['qid']) )
                        {
                            $row['qid'] = '0';
                            $row['title'] = "No Category";
                        }
                        else if(!isset($row['title']) || empty($row['title']))
                        {
                            $row['title'] = $row['qid'];
                        }
                        break;
                    case 'group':
                        if(!isset($row['qid']) || empty($row['qid']) )
                        {
                            $row['qid'] = '0';
                            $row['title'] = "No Group";
                        }
                        else if(!isset($row['title']) || empty($row['title']))
                        {
                            $row['title'] = $row['qid'];
                        }
                        break;
                    case 'supplier':
                        if(!isset($row['qid']) || empty($row['qid']) )
                        {
                            $row['qid'] = '0';
                            $row['title'] = "No Supplier";
                        }
                        else if(!isset($row['title']) || empty($row['title']))
                        {
                            $row['title'] = $row['qid'];
                        }
                        break;
                    case 'customers':
                        $test[] = $row['qid'];
                        break;
                    case 'country':
                        if(!isset($row['qid']) || empty($row['qid']) )
                        {
                            $row['qid'] = '0';
                            $row['title'] = "No country";
                        }
                        else if(!isset($row['title']) || empty($row['title']))
                        {
                            $row['title'] = $row['qid'];
                        }
                        break;
                    case 'industry':
                        if(!isset($row['qid']) || empty($row['qid']) )
                        {
                            $row['qid'] = '0';
                            $row['title'] = "No Industry";
                        }
                        else if(isset($this->industry_array[$row['qid']]) )
                        {
                            $row['title'] = $this->industry_array[$row['qid']];
                        }
                        else {
                            $row['title'] = $row['qid'];
                        }
                        break;
                    default: 
                        $row['title'] = 'Sales';
                        $row['qid'] = $row['title'];
                }
                $res[] = $row;
            }
        }
        return($res);
    }
    
    /** ////////////
     * Calculate turb over result in company standart format
     * today
     * this week
     * this month
     * previos month
     * month before that
     * mean for 12 month
     * calls few times $this->turnover
     * @return type array with result
     */          
    public function turnover12()
    {
        // old use $this->checkIfTempTableRequired();
        $this->tempFlag = $this->checkIfTempTableRequired("supplier");
        if($this->tempFlag)
             $this->createTemp();
        if(
                $this->checkIfTempTableRequired("products") || 
                $this->checkIfTempTableRequired("group") || 
                $this->checkIfTempTableRequired("category") ||
                $this->checkIfTempTableRequired("supplier")
        )
            $this->createTempProduct();
        $res = array();
        // to do to day -------------------------------------------------------
        $fromDate = date("Y-m-d");
        $toDate = date("Y-m-d", strtotime($fromDate . " +1 days"));
        $temp = $this->turnover($fromDate, $toDate);

        if(!empty($temp))
        {
            foreach($temp as $k => $v)
            {
                $res[$v['qid']]  = array();
                $res[$v['qid']]['title'] = $v['title'];
                $res[$v['qid']]['profit_d'] = $v['profit'];
                $res[$v['qid']]['total_d'] = $v['total'];
                $res[$v['qid']]['VE_d'] = $v['VE'];
                $res[$v['qid']]['total_warehouse_price_d'] = $v['total_warehouse_price'];
                if(isset($v['real_id']))
                    $res[$v['qid']]['real_id'] = $v['real_id'];
            }
        }
        // this week -----------------------------------------------------------
        $td = time();
        $dw = date( "w", $td);
        if($dw == 1) 
            $startweek = $td;
        else 
            $startweek = (date('w', $td) == 0) ? $td : strtotime('last monday', $td);
        $endweek = strtotime('next monday', $startweek);
        $fromDate = date("Y-m-d",$startweek);
        $toDate = date("Y-m-d",$endweek);
        $temp = $this->turnover($fromDate, $toDate);
        if(!empty($temp))
        {
            foreach($temp as $k => $v)
            {
                if(!isset($res[$v['qid']]))
                {
                    $res[$v['qid']]  = array();
                    $res[$v['qid']]['title'] = $v['title'];
                    if(isset($v['real_id']))
                        $res[$v['qid']]['real_id'] = $v['real_id'];
                }
                $res[$v['qid']]['profit_w'] = $v['profit'];
                $res[$v['qid']]['total_w'] = $v['total'];
                $res[$v['qid']]['VE_w'] = $v['VE'];
                $res[$v['qid']]['total_warehouse_price_w'] = $v['total_warehouse_price'];
            }
        }
        // this month ----------------------------------------------------------
        $fromDate = date("Y-m-01"); 
        $toDate = date("Y-m-d", strtotime($fromDate . " +1 months"));
        $temp = $this->turnover($fromDate, $toDate);
        if(!empty($temp))
        {
            foreach($temp as $k => $v)
            {
                if(!isset($res[$v['qid']]))
                {
                    $res[$v['qid']]  = array();
                    $res[$v['qid']]['title'] = $v['title'];
                    if(isset($v['real_id']))
                        $res[$v['qid']]['real_id'] = $v['real_id'];
                }
                $res[$v['qid']]['profit'] = $v['profit'];
                $res[$v['qid']]['total'] = $v['total'];
                $res[$v['qid']]['VE'] = $v['VE'];
                $res[$v['qid']]['total_warehouse_price'] = $v['total_warehouse_price'];
            }
        }
        // Previous month
        $toDate = $fromDate;
        $fromDate = date("Y-m-d", strtotime($toDate . " -1 months"));
        $temp = $this->turnover($fromDate, $toDate);
        if(!empty($temp))
        {
            foreach($temp as $k => $v)
            {
                if(!isset($res[$v['qid']]))
                {
                    $res[$v['qid']]  = array();
                    $res[$v['qid']]['title'] = $v['title'];
                    if(isset($v['real_id']))
                        $res[$v['qid']]['real_id'] = $v['real_id'];
                }
                $res[$v['qid']]['profit_1'] = $v['profit'];
                $res[$v['qid']]['total_1'] = $v['total'];
                $res[$v['qid']]['VE_1'] = $v['VE'];
                $res[$v['qid']]['total_warehouse_price_1'] = $v['total_warehouse_price'];
            }
        }
        // Month before that
        $toDate = $fromDate;
        $fromDate = date("Y-m-d", strtotime($toDate . " -1 months"));
        $temp = $this->turnover($fromDate, $toDate);
        if(!empty($temp))
        {
            foreach($temp as $k => $v)
            {
                if(!isset($res[$v['qid']]))
                {
                    $res[$v['qid']]  = array();
                    $res[$v['qid']]['title'] = $v['title'];
                    if(isset($v['real_id']))
                        $res[$v['qid']]['real_id'] = $v['real_id'];
                }
                $res[$v['qid']]['profit_2'] = $v['profit'];
                $res[$v['qid']]['total_2'] = $v['total'];
                $res[$v['qid']]['VE_2'] = $v['VE'];
                $res[$v['qid']]['total_warehouse_price_2'] = $v['total_warehouse_price'];
            }
        }
        // 12 month mean
        $todate =  date("Y-m-01");
        $fromDate = date("Y-m-d", strtotime($toDate . " -12 months"));
        $temp = $this->turnover($fromDate, $toDate);
        if(!empty($temp))
        {
            foreach($temp as $k => $v)
            {
                if(!isset($res[$v['qid']]))
                {
                    $res[$v['qid']]  = array();
                    $res[$v['qid']]['title'] = $v['title'];
                    if(isset($v['real_id']))
                        $res[$v['qid']]['real_id'] = $v['real_id'];
                }
                $res[$v['qid']]['profit_12'] = round($v['profit'] / 12,2);
                $res[$v['qid']]['total_12'] = round($v['total'] / 12,2);
                $res[$v['qid']]['VE_12'] = round($v['VE'] / 12,2);
                $res[$v['qid']]['total_warehouse_price_12'] = round($v['total_warehouse_price'] / 12,2);
            }
        }
        return($res);
    }
    // strictly join model -----------------------------------------------------
    /* to use in turnover action overview controller */
    function hasNameSum($fromDate, $toDate,$affix="")
    {
        $res  = array();
        $sql  = "SELECT ";
        $sql .= $this->mainColums($affix)." \n ";
                
        $sql .= $this->commonSQL1($fromDate, $toDate);
        
        // payed only no
        // $sql .= " AND i.fully_paid = 1 ";
        // to conforties
        $sql .= " AND c.company NOT LIKE 'Comforties%' "
                . " AND c.company NOT LIKE 'Dutchblue%' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        foreach ($query->result_array() as $row)
        {
            return($row);
        }
        return(false);
    }
    function hasNameAgent($fromDate, $toDate,$affix="")
    {
        $res  = array();
        $sql  = "SELECT a.agent_index, a.agent_name AS title, \n";  // try to company name from invoice record
        $sql .= $this->mainColums($affix)." \n ";
        $sql .= $this->commonSQL1($fromDate, $toDate);
        $sql .= " AND c.company NOT LIKE 'Comforties%' "
                . " AND c.company NOT LIKE 'Dutchblue%' ";
        $sql .= " GROUP BY a.agent_index ORDER BY a.agent_name";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $res = array();
            if ($query->num_rows() > 0)
            {
                foreach ($query->result_array() as $row)
                {
                    $row['title'] .= " ".$row['agent_index'];
                    $row["link"] = site_url($this->config->item('admin_folder').'/overview/sales/agents/'.$row['agent_index']);
                    $res[] = $row;
                }
                return($res);
            }
        }
        return(false);
    }
    //
    function hasNameAgentCustomer($id,$fromDate, $toDate,$affix="")
    {
        $res  = array();
        $sql  = "SELECT c.customer_number, i.company AS title, \n";
        $sql .= $this->mainColums($affix)." \n ";
        $sql .= $this->commonSQL1($fromDate, $toDate);
        $sql .= " AND c.company NOT LIKE 'Comforties%' "
                . " AND c.company NOT LIKE 'Dutchblue%' ";
        $sql .= " AND c.field_service = $id ";
        $sql .= " GROUP BY c.customer_number ";
        // $sql .= " ORDER BY i.company ";                                 // and order same
        $sql .= " ORDER BY c.customer_number ";  
        $query = $this->db->query($sql);
        $res = array();
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $row['title'] .= " ".$row['customer_number'];
                $row["link"] = site_url($this->config->item('admin_folder').'/overview/sales/mcustomer/'.$row['customer_number']);
                $res[] = $row;
            }
            return($res);
        }
        return(false);
    }
    //
    public function hasNameSumIntersale($fromDate, $toDate,$affix="")
    {
        $res  = array();
        $sql  = "SELECT ";
        $sql .= $this->mainColums($affix)." \n ";
                
        $sql .= $this->commonSQL1($fromDate, $toDate);
        
        $sql .= " AND (  c.company  LIKE 'Comforties%' "
                . " OR c.company  LIKE 'Dutchblue%') ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        foreach ($query->result_array() as $row)
        {
            return($row);
        }
        return(false);
    }
    // intersale by agents
    function hasNameAgentIntersale($fromDate, $toDate,$affix="")
    {
        $res  = array();
        $sql  = "SELECT a.agent_index, a.agent_name AS title, \n";  // try to company name from invoice record
        $sql .= $this->mainColums($affix)." \n ";
        $sql .= $this->commonSQL1($fromDate, $toDate);
        $sql .= " AND (  c.company  LIKE 'Comforties%' "
                . " OR c.company  LIKE 'Dutchblue%') ";
        $sql .= " GROUP BY a.agent_index ORDER BY a.agent_name";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            
                $res = array();
                if ($query->num_rows() > 0)
                {
                    foreach ($query->result_array() as $row)
                    {
                        $row['title'] .= " ".$row['agent_index'];
                        $row["link"] = site_url($this->config->item('admin_folder').'/overview/sales/agentsi/'.$row['agent_index']);
                        $res[] = $row;
                    }
                    return($res);
                }
            
        }
        return(false);
    }
    //
    function hasNameAgentCustomerIntersale($id,$fromDate, $toDate,$affix="")
    {
        $res  = array();
        $sql  = "SELECT c.customer_number, i.company AS title, \n";
        $sql .= $this->mainColums($affix)." \n ";
        $sql .= $this->commonSQL1($fromDate, $toDate);
        $sql .= " AND (  c.company  LIKE 'Comforties%' "
                . " OR c.company  LIKE 'Dutchblue%') ";
        $sql .= " AND c.field_service = $id ";
        $sql .= " GROUP BY c.customer_number ";
        $sql .= " ORDER BY i.company ";                                 // and order same
        $query = $this->db->query($sql);
        $res = array();
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $row['title'] .= " ".$row['customer_number'];
                $row["link"] = site_url($this->config->item('admin_folder').'/overview/sales/mcustomeri/'.$row['customer_number']);
                $res[] = $row;
            }
            return($res);
        }
        return(false);
    }
    //
    
    // sum no name data
    public function noNameSum($fromDate, $toDate, $affix = "")
    {
        $sql  = "SELECT ";
        $sql .= $this->mainColums($affix)." \n ";
        $sql .= $this->noNameSQL($fromDate, $toDate);
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        foreach ($query->result_array() as $row)
        {
            return($row);
        }
        return(false);
    }
    public function noNameCust($fromDate, $toDate)
    {
        $sql  = "SELECT c.customer_number, i.company AS title, \n";  // try to company name from invoice record
        $sql .= $this->mainColums("")." \n ";
        $sql .= $this->noNameSQL($fromDate, $toDate);
        $sql .= " GROUP BY c.customer_number ";
        // $sql .= " ORDER BY i.company ";                                 // and order same
        $sql .= " ORDER BY c.customer_number ";
        $sql .= " ";
        $query = $this->db->query($sql);
        $res = array();
        $test = array();
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $test[] = $row['customer_number'];
                $row['title'] .= " ".$row['customer_number'];
                $row["link"] = site_url($this->config->item('admin_folder').'/overview/sales/mcustomern/'.$row['customer_number']);
                $res[] = $row;
            }
            return($res);
            
        }
        return(false);
    }
    /**
     * Return data for top report 
     * 
     */
    public function topTable($fromDate, $toDate)
    {
        $res = array();
        $r1 = $this->hasNameSumIntersale($fromDate, $toDate);
        if($r1)
        {
            $r1['title']  = 'Management';
            $r1['link']   = site_url($this->config->item('admin_folder').'/overview/sales/management');
            $res[] = $r1;
        }
        //
        $r1 = $this->noNameSum($fromDate, $toDate);
        if($r1)
        {
            $r1['title']  = 'No Name';
            $r1['link']   = site_url($this->config->item('admin_folder').'/overview/sales/noname');
            $res[] = $r1;
        }
        //
        $r1 = $this->hasNameSum($fromDate, $toDate);
        if($r1)
        {
            $r1['title']  = 'Sales';
            $r1['link']   = site_url($this->config->item('admin_folder').'/overview/sales/sales');
            $res[] = $r1;
        }
        return($res);
    }
    // Products if customers
    public function customerProducts($fromDate, $toDate,$id)
    {
        $sql  = "SELECT d.code AS title, \n";  // try to company name from invoice record
        $sql .= $this->mainColums("")." \n ";
        $sql .= $this->commonSQL1($fromDate, $toDate);
        $sql .= " AND i.customer_number=$id ";
        $sql .= " GROUP BY d.code ";
        $sql .= " ORDER BY d.code ";        // and order same
        $query = $this->db->query($sql);
        $res = array();
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                // find product id 
                $psql = "SELECT * FROM products WHERE code='".$row['title']."' OR code ='".$row['title']."/"."' ";
                
                $query = $this->db->query($psql);
                if ($query->num_rows() > 0)
                {
                    $qq = $query->result_array();
                    $product = $qq[0];
                    $row["link"] = site_url($this->config->item('admin_folder').'/products/form/'.$product['id']);
                }
                else 
                {
                    $row["link"] = "#";
                    $row['title'] .=  " not found try search ";
                }
                $res[] = $row;
            }
            return($res);
        }
        return(false);
    }
    public function customerProductsNoName($fromDate, $toDate,$id)
    {
        $sql  = "SELECT d.code AS title, \n";  // try to company name from invoice record
        $sql .= $this->mainColums("")." \n ";
        $sql .= $this->noNameSQL($fromDate, $toDate);
        $sql .= " AND i.customer_number=$id ";
        $sql .= " GROUP BY d.code ";
        $sql .= " ORDER BY d.code ";                                 // and order same
        $query = $this->db->query($sql);
        $res = array();
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                // find product id 
                $psql = "SELECT * FROM products WHERE code='".$row['title']."' OR code ='".$row['title']."/"."' ";
                
                $query = $this->db->query($psql);
                if ($query->num_rows() > 0)
                {
                    $qq = $query->result_array();
                    $product = $qq[0];
                    $row["link"] = site_url($this->config->item('admin_folder').'/products/form/'.$product['id']);
                }
                else 
                {
                    $row["link"] = "#";
                    $row['title'] .=  " not found try search ";
                }
                $res[] = $row;
            }
            return($res);
        }
        return(false);
    }
    // auxilary methods --------------------------------------------------------
    private function commonSQL($fromDate, $toDate)
    {
        $sql = "FROM ";
        // early stage 
        if($this->checkIfTempTableRequired("agents"))
        {
            $sql .= "agents as a "
                . " RIGHT JOIN customers as c "
                . " ON c.shop_id ='".$this->shop_id."' "
                . " AND c.field_service = a.agent_index "
                . " RIGHT JOIN invoices AS i "
                . " ON i.customer_number = c.customer_number "
                . " AND i.shop_id = '".$this->shop_id."' "
                . " AND i.created_on >= '".$fromDate."' "
                . " AND i.created_on <'".$toDate."' ";
        }
        else if(
                    $this->checkIfTempTableRequired("customers") ||
                    $this->checkIfTempTableRequired("industry")
                )
        {
            $sql .= " customers as c "
                . " RIGHT JOIN invoices AS i "
                . " ON i.customer_number = c.customer_number "
                . " AND i.shop_id = '".$this->shop_id."' "
                . " AND i.created_on >= '".$fromDate."' "
                . " AND i.created_on <'".$toDate."' ";
        } 
        else {
            $sql .= " invoices AS i ";
            //attention add datechecking in where clause
        }
        // mandatory select details     
            
        $sql    .= " RIGHT JOIN invoice_items AS d "
                . " ON d.shop_id ='".$this->shop_id."' "
                . " AND d.invoice_number = i.invoice_number ";
        if(
                $this->checkIfTempTableRequired("products") || 
                $this->checkIfTempTableRequired("group") || 
                $this->checkIfTempTableRequired("category") ||
                $this->checkIfTempTableRequired("supplier")
        )
        {
            $sql .= " LEFT JOIN tempProduct AS p "
                 . " ON (d.code = p.code OR CONCAT(d.code,'/') = p.code) "
                 . " AND p.shop_id='".$this->shop_id."' ";
        }
        if($this->checkIfTempTableRequired("group"))         
        {
            $sql .= " LEFT JOIN groups AS g "
                . " ON g.group_id = p.grp_id AND g.shop_id='".$this->shop_id."' ";
        }      
        if($this->checkIfTempTableRequired("category"))         
        {
            $sql .=  "LEFT JOIN categories AS t "
                . " ON t.id = p.cat_id AND t.shop_id='".$this->shop_id."' ";
        }       
        if($this->tempFlag)
        {
            // Left join to temporary table already created
            $sql .= " LEFT JOIN relationTemp AS r ON "
                    . " r.shop_id ='".$this->shop_id."' "
                    . "AND d.code = r.ARTIKELCOD   "
                    . " LEFT JOIN suppliers AS s ON s.id = r.LEVERANCIE "; 
        }
        if($this->checkIfTempTableRequired("agents"))
        {
            $sql    .= " WHERE a.shop_id ='".$this->shop_id."' "
                    . " AND c.customer_number IS NOT NULL "
                    . "AND c.customer_number > 0 AND c.customer_number !=''";
        }
        else if ($this->checkIfTempTableRequired("customers"))
        {
             $sql   .= " WHERE c.shop_id ='".$this->shop_id."' "
                    . " AND c.customer_number IS NOT NULL "
                    . "AND c.customer_number > 0 AND c.customer_number !=''";
        }
        else
        {
            $sql .= " WHERE i.shop_id ='".$this->shop_id."' "
                 . " AND i.created_on >= '".$fromDate."' "
                 .  " AND i.created_on <'".$toDate."' ";
        }
        
        return($sql);
    }
    private function commonSQL1($fromDate, $toDate)
    {
        $sql = "FROM agents as a "
                . " RIGHT JOIN customers as c "
                . " ON c.shop_id ='".$this->shop_id."' "
                . " AND c.field_service = a.agent_index "
                . " RIGHT JOIN invoices AS i "
                . " ON i.customer_number = c.customer_number "
                . " AND i.shop_id = '".$this->shop_id."' "
                . " AND i.created_on >= '".$fromDate."' "
                . " AND i.created_on <'".$toDate."' "
                . " RIGHT JOIN invoice_items AS d "
                . " ON d.shop_id ='".$this->shop_id."' "
                . " AND d.invoice_number = i.invoice_number "
                . " LEFT JOIN products AS p "
                . " ON (d.code = p.code OR CONCAT(d.code,'/') = p.code) AND p.shop_id='".$this->shop_id."' "
                . " LEFT JOIN groups AS g "
                . " ON g.group_id = p.grp_id "
                . " LEFT JOIN categories AS t "
                . " ON t.id = p.cat_id"
                . " WHERE a.shop_id ='".$this->shop_id."' "
                . " AND c.customer_number IS NOT NULL AND c.customer_number > 0 AND c.customer_number !=''";
        return($sql);
    }
    private function noNameSQL($fromDate, $toDate)
    {
        $sql = "FROM customers as c "
                . " RIGHT JOIN invoices AS i "
                . " ON i.customer_number = c.customer_number "
                . " AND i.shop_id = '".$this->shop_id."' "
                . " AND i.created_on >= '".$fromDate."' "
                . " AND i.created_on <'".$toDate."' "
                . " RIGHT JOIN invoice_items AS d "
                . " ON d.shop_id ='".$this->shop_id."' "
                . " AND d.invoice_number = i.invoice_number "
                . " LEFT JOIN products AS p "
                . " ON (d.code = p.code OR CONCAT(d.code,'/') = p.code) AND p.shop_id='".$this->shop_id."' "
                . " LEFT JOIN groups AS g "
                . " ON g.group_id = p.grp_id "
                . " LEFT JOIN categories AS t "
                . " ON t.id = p.cat_id"
                . " WHERE c.field_service = 0  "
                . " AND c.shop_id ='".$this->shop_id."' \n"
                . " AND c.customer_number IS NOT NULL AND c.customer_number > 0 AND c.customer_number !=''\n";
        return($sql);
    }
    private function mainColums($affix="")
    {
        $sql = " SUM(d.profit) AS profit".$affix.", "
                . " SUM(d.total) AS total".$affix.", "
                . " SUM(d.VE) AS VE".$affix.", "
                . " SUM(d.sent_quantity) AS quantity".$affix.", "
                . " COUNT(distinct d.order_number) AS ncontracts".$affix.", "
                // . " COUNT(distinct CASE WHEN (d.sent_quantity IS NOT NULL OR d.sent_quantity != 0  OR d.sent_quantity != '')  THEN d.order_number END ) AS ncontracts".$affix.", "
                . " SUM(total_warehouse_price) AS total_warehouse_price".$affix." ";
        return($sql);
    }
    //  utility to get names overview controller
    public function getCategory($id)
    {
        $this->db->select("name");
        $this->db->where("id",$id);
        $row = $this->db->get('categories')->row();
        if(is_object($row) && $row->name)
            $title = $row->name;
        else {
            $title = $id;
        }
        return($title);
    }
    public function getAgent($id)
    {
        $this->db->select("agent_name");
        $this->db->where("agent_index",$id);
        $this->db->where("shop_id",$this->session->userdata('shop'));
        $row = $this->db->get('agents')->row();
        if(is_object($row) && $row->agent_name)
            $title = $row->agent_name;
        else {
            $title = $id;
        }
        return($title);
    }
    public function getGroup($id)
    {
        $this->db->select("group_name");
        $this->db->where("group_id",$id);
        $this->db->where("shop_id",$this->session->userdata('shop'));
        $row = $this->db->get('groups')->row();
        if(is_object($row) && $row->group_name)
            $title = $row->group_name;
        else {
            $title = $id;
        }
        return($title);
    }
    public function getProduct($id)
    {
        $sql = "SELECT name FROM products WHERE "
                . " ( code='$id' OR code='".$id."/"."' ) AND shop_id='".$this->session->userdata('shop')."' ";
        $query = $this->db->query($sql);
        $row = $query->row();
        if(is_object($row) && $row->name)
            $title = $row->name;
        else {
            $title = $id;
        }
        return($title);
    }
    public function getProductId($id)
    {
        $sql = "SELECT id FROM products WHERE "
                . " ( code='$id' OR code='".$id."/"."' ) AND shop_id='".$this->session->userdata('shop')."' ";
        $query = $this->db->query($sql);
        $row = $query->row();
        if(is_object($row) && $row->id)
            $title = $row->id;
        else {
            $title = false;
        }
        return($title);
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