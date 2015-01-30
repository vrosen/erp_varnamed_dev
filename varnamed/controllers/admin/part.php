<?php
/**
 * Special controller to server complex products 
 * that contain multiple parts 
 */
class Part extends MY_Controller {

    //this is used when editing or adding a customer
    var $customer_id = false;

    function __construct() {
        parent::__construct();
        $this->load->model("Part_model");

        ////////////////////////////////////////////////////////////////
    }
    /**
     * Add complex part product relation
     */
    public function add()
    {
        // 
        $res = $this->Part_model->add(
                    $this->data_shop, 
                    $this->input->post('complex'),
                    $this->input->post('part')
        );
        if($res) echo "OK";
        else echo "Sorry";
        exit;
    }
    
    public function delete()
    {
        // 
        $res = $this->Part_model->delete(
                    $this->data_shop, 
                    $this->input->post('complex'),
                    $this->input->post('part')
        );
        if($res) echo "OK";
        else echo "Sorry";
        exit;
    }
    // -------------------------
//THE CLASS ENDS HERE
}
