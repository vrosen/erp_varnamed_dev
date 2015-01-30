<?php
/* 
 * models that serves complex products
 * 
 */

Class Part_model extends CI_Model {
    
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
    /**
     * 
     * Return product id frind by shop and product code
     * @param type $shop_id integer
     * @param type $code string
     * @return type integer or false if not found
     */
    public function getProductId($shop_id, $code)
    {
        $id = false;
        $code = $this->clearTerm($code);
        $sql = "SELECT id FROM products WHERE shop_id = '$shop_id' "
                . " AND (code = '$code' OR code = '$code/') LIMIT 1 ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $p = $query->row();
            if(isset($p->id))$id=$p->id;
        }
        return($id);
    }
    /**
     * Return Product complex type
     * @param type $shop_id integer
     * @param type $code string
     * @return type integer or false if not found
     */
    public function getProductComplexType($shop_id, $code)
    {
        $id = false;
        $code = $this->clearTerm($code);
        $sql = "SELECT complexType FROM products WHERE shop_id = '$shop_id' "
                . " AND (code = '$code' OR code = '$code/') LIMIT 1 ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $p = $query->row();
            if(isset($p->complexType))$id=$p->complexType;
        }
        return($id);
    }
    /**
     * add relation complex product part
     * 
     * @return type boolean
     */
    public function add($shop_id, $base_id, $pCode)
    {
        $r = false;
        //
        $id = $this->getProductId($shop_id, $pCode);
        if($id)
        {
            $sql = "INSERT IGNORE complexPart SET shop_id ='$shop_id', "
                    . " complex_id='$base_id', part_id='$id' ";
            $this->db->query($sql);
            return(true);
            // TO DO last insert id
        }
        //
        return($r);
    }
    /**
     * delete complex par relation
     * @param type $shop_id
     * @param type $base_id
     * @param type $partId
     * @return type boolean
     */
    public function delete($shop_id, $base_id, $partId)
    {
        $r = false;
        //
        
            $sql = "DELETE FROM complexPart WHERE shop_id ='$shop_id' AND "
                    . " complex_id='$base_id' AND  part_id='$partId' ";
            $r = $this->db->query($sql);
            return(true);
            // TO DO last insert id
 
        //
        return($r);
    }
    /**
     * 
     * @param type $shop_id integer
     * @param type $id integer
     * @return type array with parts for complex product with id $id
     */
    public function getParts($shop_id,$id)
    {
        $sql = "SELECT products.* FROM complexPart "
                . " LEFT JOIN products ON products.id = complexPart.part_id "
                . " WHERE complexPart.shop_id='$shop_id' "
                . " AND complexPart.complex_id = '$id' ";
        $query = $this->db->query($sql);
        return($query->result_array());
    }
    /**
     * 
     * @param type $shop_id
     * @param type $code
     * @return type array with parts for complex product
     */
    public function getPartsByCode($shop_id,$code)
    {
        $id = $this->getProductId($shop_id, $code);
       
        return($this->getParts($shop_id, $id));
    }
    /**
     * Get product by code
     * @param type $shop_id
     * @param type $code
     * @return type
     */
    public function getProductByCode($shop_id,$code)
    {
        $id = $this->getProductId($shop_id, $code);
        return($this->getProductById($id));
    }
    /**
     * get product bi Id
     * @param type $id
     * @return type
     */
    function getProductById($id)
    {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('id', $id);
        $res = $this->db->get()->result_array();
        if(!empty($res))
            return($res[0]);
        return(false);
    }
}