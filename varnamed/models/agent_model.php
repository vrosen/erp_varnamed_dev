<?php
/* 
 * Agent data model
 * 
 */

Class Agent_model extends CI_Model {
    // TO DO finished setter getter methods
    /**
     * Private variable set from session and additionnaly with
     * classic seter and geter or add and remove for arrays
     * @var integer
     */
    private $shop_id=false;
    /**
     * Set shop_id
      */
    public function setShopId($shop_id=1)
    {
        $this->shop_id = $shop_id;
    }
    /**
     * 
     * @param type $shop_id integer
     * @return type array
     */
    public function getList($shop_id=false)
    {
        if(!$shop_id) $shop_id =  $this->shop_id;
        if(!$shop_id) $shop_id =  $this->session->userdata('shop');
        $res = array();
        $sql  = "SELECT  B.username , ";
        //
        switch($shop_id)
        {
            case 1:
                $sql .= " B.c_login AS fs,  ";
                break;
            case 2:
                $sql .= " B.d_login AS fs,  ";
                break;
            default:
                $sql .= " B.g_login AS fs,  ";
        }
        $sql .= " a.agent_name ";
        $sql .= " FROM bitauth_users AS B ";
        $sql .= " LEFT JOIN agents AS a ON a.agent_index =";
        switch($shop_id)
        {
            case 1:
                $sql .= " B.c_login ";
                break;
            case 2:
                $sql .= " B.d_login ";
                break;
            default:
                $sql .= " B.g_login ";
        }
        $sql .= " AND shop_id='$shop_id' ";
        $sql .= " WHERE a.agent_name IS NOT NULL AND B.active";
        
        $sql .= " HAVING fs > 0 ";
        $sql .= " ORDER BY a.agent_name ";
        
        $query = $this->db->query($sql);
        
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $res[] = $row;
            }
        }
        return($res);
    }
    //
    public function getFormList($shop_id=false)
    {
        $res = array();
        $list = $this->getList($shop_id);
        foreach($list as $row)
        {
            $res[$row['fs']] = $row['agent_name'];
        }
        return($res);
    }
}