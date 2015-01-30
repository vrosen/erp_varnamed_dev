<?php
/* 
 * class that show complex turn over report
 * The Report is related to a lot of parameters
 * Parameters are shown as private parameters with
 * classic get, set and add, remove for masive parameters
 * 
 */

Class Complex_model extends CI_Model {
    // TO DO finished setter getter methods
    /**
     * Private variable set from session and additionnaly with
     * classic seter and geter or add and remove for arrays
     * @var integer
     */
    private $shop_id=null;
    /**
     * in use in getSum...()
     * @var integer 3,6, 9 or 12;
     */
    /**
     * Get shop_id
     * @return type
     */
    public function getShopId()
    {
        return($this->shop_id);
    }
    /* -------------------------------------------------------------- */
    private $period=12;
    /**
     * Year of report in use in getTurnoverMonth();
     * @var integer
     */
    private $year=null;
    /**
     * Month of report in use in getTurnoverMonth();
     * @var string 01,02 ... 12
     */
    private $month=null;
    /**
     * In use when there are a chain of joib
     * Index field set 1 or 0 joined table
     */
    private $extraJoin = array();
    public function addExtraJoined($index,$field,$table,$joinTable,$joinField)
    {
        $this->extraJoin[$index]=
            array(
                "field"     => $field,
                "table"     => $table,
                "joinTable" => $joinTable,
                "joinField" => $joinField
            );
        
    }
    /**
     * Index filed and join params
     * @var array
     */
    private $indexField = 
            array(
                "field"     => "field_service",
                "table"     => "invoices",
                "joinTable" => "agents",
                "joinField" => "agent_index",
                "extraCond" => "agents.shop_id"
            );
    public function setIndexField($field,$table,$joinTable,$joinField,$extraCond=false)
    {
        $this->indexField = 
            array(
                "field"     => $field,
                "table"     => $table,
                "joinTable" => $joinTable,
                "joinField" => $joinField,
                "extraCond" => $extraCond
            );
        
    }
    /* ---------------------------------------------------------------------- */
    /**
     * Extra where clasus
     * @var array field => value 
     */
    private $extraWhere = array( );
    /**
     *
     * @var sting
     */
    
    public function addExtraWhere($f,$v)
    {
        $this->extraWhere[$f] = $v;
    }
    /* ---------------------------------------------------------------------- */
    private $nameField = "agents.agent_name";
    
    public function setNameField($s)
    {
        $this->nameField = $s;
        //echo "$s ". $this->nameField;
        //exit;
    }
    /* ---------------------------------------------------------------------- */
    /**
     *
     * @var array of extra selected fields
     */
    private $extraSelect = array("invoices.field_service");
    /**
     * for test putpose save firat query
     * @var string
     */
    private $sql1 = "";
    /**
     * when show only for one period
     * @var string 
     * posible values "today", "this week", "this month", "previous month"
     * "some month", "3 months", "6 months", "9 months", "12 months"
     */
    private $periodTerm = "today";
    /*
     * setter
     */
    public function setPeriodTem($t="today")
    {
        $this->periodTerm = $t;
    }
    
    
    
    function __construct() {
        parent::__construct();
        // set vars from session to avoid long argument list
        // when call essential method
        $this->setFromSession();
    }
    /**
     * This function is called at first in all model method
     * Just in case that constructor is before last session update
     */
    private function setFromSession()
    {
        $this->shop_id = $this->session->userdata('shop');
        $this->period = $this->session->userdata('overperiod')
                      ? $this->session->userdata('overperiod')
                      : 12;
        $this->year = $this->session->userdata('overyear')
                    ? $this->session->userdata('overyear')
                    : date('Y');
        $this->month    = $this->session->userdata('overmonth')
                        ? $this->session->userdata('overmonth')
                        : date('m');
    }
    /**
     * Main methods
     */
    /**
     * Return turnover for 3, 6, 9 or 12 month
     * @return array with results`
     */
    public function getTurnover()
    {
        $this->setFromSession();
        $res = array();
        // calculate time limits
        $curr_start = date('Y-m-01');
        $next_month = date("Y-m-d", strtotime($curr_start . " +1 months"));
        $curr_start_1 = date("Y-m-d", strtotime($curr_start . " -1 months"));
        // 
        $curr_start_3 = date("Y-m-d", strtotime($curr_start . " -2 months"));
        $curr_start_12 = date("Y-m-d", strtotime($curr_start . " -".$this->period."months"));
    
        //$qq = date('Y-m-d', strtotime('previous monday')); 
        // temporary hack to march
        // $td = strtotime("2014-03-".date('d'));
        $td = time();
        $dw = date( "w", $td);
        if($dw == 1) 
            $startweek = $td;
        else 
            $startweek = (date('w', $td) == 0) ? $td : strtotime('last monday', $td);
        $endweek = strtotime('next monday', $startweek);
        $startweek = date("Y-m-d",$startweek);
        $endweek = date("Y-m-d",$endweek);
        $td = date("Y-m-d",$td);
        $tm = date("Y-m-d", strtotime($td . " +1 days"));
        // today 
        $rawResToday = $this->getSales($td, $tm,"_day");
        // 
        // this week
        $rawResWeek = $this->getSales($startweek, $endweek,"_week");
        
        //
        // curent month
        $rawRes = $this->getSales($curr_start, $next_month);
        
        //   
        $rawRes_1 = $this->getSales($curr_start_1, $curr_start,"_1");
        
        //
        $rawRes_2 = $this->getSales($curr_start_3, $curr_start_1,"_2");
        //
        $rawRes_12 = $this->getSales($curr_start_12, $curr_start,"_12"); 
        //
        foreach ($rawRes as $r) {
            // if($r['total_warehouse_price_c'] > 0)
                $res[$r['aq']] = $r;
        }
        foreach ($rawRes_1 as $r) {
            //if($r['total_warehouse_price_1'] > 0)
            //{
                if(!isset($res[$r['aq']]))
                    $res[$r['aq']] = $r;
                else {
                    $res[$r['aq']]['profit_1'] = $r['profit_1'];
                    $res[$r['aq']]['total_warehouse_price_1'] = $r['total_warehouse_price_1'];
                    $res[$r['aq']]['total_1'] = $r['total_1'];
                    $res[$r['aq']]['VE_1'] = $r['VE_1'];
                    $res[$r['aq']]['cc_1'] = $r['cc_1'];
                }
                //$res[$r['aq']]['field_service'] = $r['field_service'];
            //}
        }
        foreach ($rawRes_2 as $r) {
           // if($r['total_warehouse_price_2'] > 0)
           // {
                if(!isset($res[$r['aq']]))
                    $res[$r['aq']] = $r;
                else {
                    $res[$r['aq']]['profit_2'] = $r['profit_2'];
                    $res[$r['aq']]['total_warehouse_price_2'] = $r['total_warehouse_price_2'];
                    $res[$r['aq']]['total_2'] = $r['total_2'];
                    $res[$r['aq']]['VE_2'] = $r['VE_2'];
                    $res[$r['aq']]['cc_2'] = $r['cc_2'];
                }
                //$res[$r['aq']]['field_service'] = $r['field_service'];
           // }
        }
        foreach ($rawRes_12 as $r) {
           // if($r['total_warehouse_price_12'] > 0)
           // {
                if(!isset($res[$r['aq']]))
                    $res[$r['aq']] = $r;
                else {
                    $res[$r['aq']]['profit_12'] = $r['profit_12'];
                    $res[$r['aq']]['total_warehouse_price_12'] = $r['total_warehouse_price_12'];
                    $res[$r['aq']]['total_12'] = $r['total_12'];
                    $res[$r['aq']]['VE_12'] = $r['VE_12'];
                    $res[$r['aq']]['cc_12'] = $r['cc_12'];
                }
                //$res[$r['aq']]['field_service'] = $r['field_service'];
          //  }
        }
        foreach ($rawResWeek as $r) {
           // if($r['total_warehouse_price_12'] > 0)
           // {
                if(!isset($res[$r['aq']]))
                    $res[$r['aq']] = $r;
                else {
                    $res[$r['aq']]['profit_week'] = $r['profit_week'];
                    $res[$r['aq']]['total_warehouse_price_week'] = $r['total_warehouse_price_week'];
                    $res[$r['aq']]['total_week'] = $r['total_week'];
                    $res[$r['aq']]['VE_week'] = $r['VE_week'];
                    $res[$r['aq']]['cc_week'] = $r['cc_week'];
                }
                //$res[$r['aq']]['field_service'] = $r['field_service'];
          //  }
        }
        foreach ($rawResToday as $r) {
           // if($r['total_warehouse_price_12'] > 0)
           // {
                if(!isset($res[$r['aq']]))
                    $res[$r['aq']] = $r;
                else {
                    $res[$r['aq']]['profit_day'] = $r['profit_day'];
                    $res[$r['aq']]['total_warehouse_price_day'] = $r['total_warehouse_price_day'];
                    $res[$r['aq']]['total_day'] = $r['total_day'];
                    $res[$r['aq']]['VE_day'] = $r['VE_day'];
                    $res[$r['aq']]['cc_day'] = $r['cc_day'];
                }
                //$res[$r['aq']]['field_service'] = $r['field_service'];
          //  }
        }
        ksort($res);
        return($res);
    }
    /**
     * Return turn over for 1 month
     * @return array with results
     */
    public function getTurnoverMonth()
    {
        $this->setFromSession();
        $res = array();
        // calculate time limits
        $curr_start = !empty($this->year) && !empty($this->month)
                    ? date($this->year."-".($this->month)."-01")
                    : date('Y-m-01');
        // temporary
        // $curr_start =  date('Y-03-01');
        $next_month = date("Y-m-d", strtotime($curr_start . " +1 months"));
        // curent month
        $rawRes = $this->getSales($curr_start, $next_month);
        foreach ($rawRes as $r) {
            // if($r['total_warehouse_price_c'] > 0)
                $res[$r['aq']] = $r;
        }
        ksort($res);
        /*
        echo "<pre>";
        echo $this->db->last_query();
        print_r($res);
        exit;
         * 
         */
        return($res);
    }
    // Auxtilary methods
    /**
     * Only one query easing all
     * @param type $fromDate string start date
     * @param type $toDate string end date
     * @return array result from query
     */
    private function getSales($fromDate, $toDate,$affix="_c")
    {
        $res = array();
        $this->db->select_sum('d.profit','profit'.$affix);
        $this->db->select_sum('d.VE','VE'.$affix);
        $this->db->select_sum('d.total_warehouse_price','total_warehouse_price'.$affix);
        $this->db->select_sum('d.total','total'.$affix);
        $this->db->select('count(*) as cc'.$affix);
        // extra select 
        // specific select
        if(!empty($this->indexField) && !empty($this->indexField['field']))
        {
           if(!empty($this->indexField['table'])){
               $key = $this->indexField['table'].".";
           }
           else {
               $key = "";
           }
           $key .= $this->indexField['field'];
           $this->db->select($key);
           $key2 = $this->nameField;
           $qq = str_replace("_", " ", $this->indexField['field']);
           
           $qq = ucfirst($qq).": ";
           $qa = ' ';
           //
           $this->db->select("IFNULL(CONCAT( $key2,$key ), $key ) AS aq", false);           
        }
        // extra select 
        foreach($this->extraSelect as $s) $this->db->select($s);
        $this->db->from('invoice_items AS d');
        // JOIN
        // madatory one 
        $this->db->join('invoices', 'invoices.invoice_number = d.invoice_number', 'left');
        //
        foreach($this->extraJoin as $v)
        {
            if(
                !empty($v['field']) &&
                !empty($v['table']) &&
                !empty($v['joinTable']) &&
                !empty($v['joinField'])
                
            )
            {
                $qj = $v['joinTable'].".".$v['joinField'];
                $qj .= " = ".$v['table'].".";
                $qj .= $v['field'];
                $this->db->join(
                    $v['joinTable'],
                    $qj,
                    "left"
                        
                );
            }
        }
        
        // specific one 
        if(
                !empty($this->indexField) && 
                !empty($this->indexField['field']) &&
                !empty($this->indexField['table']) &&
                !empty($this->indexField['joinTable']) &&
                !empty($this->indexField['joinField'])
                
        )
        {
            $rel = $this->indexField['joinTable'].".".$this->indexField['joinField'];
            $rel .= " = ".$this->indexField['table'].".";
            $rel .= $this->indexField['field'];
            if($this->indexField['extraCond'])
            {
                $rel .= " AND ".$this->indexField['extraCond']." = ".$this->shop_id;
            }
            $this->db->join(
                    $this->indexField['joinTable'], 
                    $rel,
                    'left'
            );
        }
        // GROUP BY 
        $gbstring = "invoices.shop_id";
        if(isset($key))
            $gbstring .= ", ".$key;
        $this->db->group_by($gbstring);
        // WHERE 
        if(!empty($this->shop_id))
        {
            $this->db->where('invoices.shop_id', $this->shop_id);
            $this->db->where('d.shop_id', $this->shop_id);
        }
        $this->db->where('invoices.created_on >=', $fromDate);
        $this->db->where('invoices.created_on <', $toDate);
        // $this->db->where('invoices.paid_on >=', $fromDate);
        // $this->db->where('invoices.paid_on <', $toDate);
        // $this->db->where('invoices.field_service  IS NOT NULL');
        // $this->db->where('invoices.field_service > ', 0);
        // $this->db->where('invoices.fully_paid > ', 0);
        // where extra
        foreach($this->extraWhere as $k => $v)
        {
            $this->db->where($k,$v);
        }
        // ORDER BY 
        $this->db->order_by('invoices.shop_id');
        if(isset($key))
            $this->db->order_by($key);
        //
        //
        $res = $this->db->get()->result_array();
        // echo "<pre>";
        // echo $this->db->last_query();
        // print_r($res);
        // echo "</pre>";
        // exit;
        return($res);
    }
    /**
     * Get invoices to check turnover problem
     * initiall and mainly per filed services
     */
    public function getIvoices()
    {
       $this->setFromSession();
       // prepare dates
       $currentMonthStart = date("Y-m-01");
       $td = time();
       switch($this->periodTerm)
       {
           default:
            /* today */
            $dw = date( "w", $td);
            if($dw == 1) 
                $start = $td;
            else 
                $start = (date('w', $td) == 0) ? $td : strtotime('last monday', $td);
            $end = strtotime('next monday', $start);
            $start = date("Y-m-d",$start);
            $end = date("Y-m-d",$end);
       }
       $res = array();
       //
       $this->db->select("i.created_on");
       $this->db->select("i.invoice_number");
       $this->db->select("i.customer_number");
       $this->db->select("c.company");
       $this->db->select("i.field_services");
       $this->db->select("a.aganet_name");
       $this->db->select("i.totalnet");
       $this->db->select("i.EURO");
       $this->db->select("i.currency");
       $this->db->from('invoices AS i');
       // join
       $this->db->join('customers AS c', 'c.customer_number = i.customer_number', 'left');
       $this->db->join('agents AS a', 'a.agent_index = i.field_services', 'left');
       // where
       if(!empty($this->shop_id))
        {
            $this->db->where('invoices.shop_id', $this->shop_id);
        }
        $this->db->where('invoices.created_on >=', $start);
        $this->db->where('invoices.created_on <', $end);
        //
        foreach($this->extraWhere as $k => $v)
        {
            $this->db->where($k,$v);
        }
         $res = $this->db->get()->result_array();
         /*
         echo "<pre>";
         echo $this->db->last_query();
         print_r($res);
        echo "</pre>";
        exit;
          * 
          */
        return($res);
    }
}