<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * Extends controller so some common data set is group in ana private method
 */
class  MY_Controller  extends  CI_Controller  
{
    /**
     * this is sens to view and common data are set in setData method
     * @var array
     */
    protected $data = array();
    /**
     * Other common variables
     * @var type 
     */
    
    protected $data_shop;
    protected $language;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array("Calendar_model",
            "Group_model","Product_model","Category_model", "Shop_model"));
        //
        $this->setData();
    }
    
    /**
     * Set common data related to calendar model amd etc
     * in $this->data, which is sent to view
     */
    protected function setData()
    {
        $time = time();
        $this->data['weather'] = _date($time);
        $this->data['events'] = $this->Calendar_model->getMyEvents($time, $this->session->userdata('ba_user_id'));
        // menu items
        ////////////////////////////////////////////////////////////////
        $this->data['categories'] = $this->Category_model->get_all_categories();
        $this->data['groups'] = $this->Group_model->get_all_the_groups();
        $this->data['products'] = $this->Product_model->get_all_products();
        //
        ////////////////////////////////////////////////////////////////
        $this->language = $this->session->userdata('language');
        $this->data_shop = $this->session->userdata('shop');
        $this->data['current_shop'] = $this->data_shop;
        $this->data['all_shops'] = $this->Shop_model->get_shops();
        
    }
//...
}

