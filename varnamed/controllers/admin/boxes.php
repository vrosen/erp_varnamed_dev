<?php

class Boxes extends CI_Controller{
    	
        public $data_shop;
        public $language;
        
        
	function __construct(){
		parent::__construct();
		remove_ssl();
                
                //check access
		$this->load->model('Box_model');
                $this->load->model('Search_model');
		$this->load->helper('date');
                ////////////////////////////////////////////////////////////////
                $this->language     = $this->session->userdata('language');
                $this->data_shop    = $this->session->userdata('shop');
                ////////////////////////////////////////////////////////////////
                $this->lang->load('boxes',  $this->language);
                $this->lang->load('dashboard',$this->language);
	}
		
	function index(){
	

		$data['boxes']		= $this->Box_model->get_boxes();
                   
		$data['page_title']	= lang('boxes');
								$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
		$this->load->view($this->config->item('admin_folder').'/boxes', $data);
	}
	
	function delete($id){
		$this->Box_model->delete($id);
		$this->session->set_flashdata('message', lang('message_delete_box'));
		redirect($this->config->item('admin_folder').'/boxes');
	}
	
	/********************************************************************
	this function is called by an ajax script, it re-sorts the boxes
	********************************************************************/
	function organize()
	{
		$boxes = $this->input->post('boxes');
		$this->Box_model->organize($boxes);
	}
	
	function form($id = false){
	

		$config['upload_path']		= 'uploads';
		$config['allowed_types']	= 'gif|jpg|png';
		$config['max_size']		= $this->config->item('size_limit');
		$config['max_width']		= '1024';
		$config['max_height']		= '768';
		$config['encrypt_name']		= true;
		$this->load->library('upload', $config);
		
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		//set the default values
		$data	= array(                        'id'            =>  $id,
							'title'         =>  '',
                                                        'description'   =>  '',
                                                        'details'       =>  '',
                                                        'price_details' =>  '',
							'enable_on'     =>  '',
							'disable_on'    =>  '',
							'image'         =>  '',
							'link'          =>  '',
							'new_window'    =>  false,	
						);
		if($id){
			$data			= (array) $this->Box_model->get_box($id);
			$data['enable_on']	= format_mdy($data['enable_on']);
			$data['disable_on']	= format_mdy($data['disable_on']);
			$data['new_window']	= (bool) $data['new_window'];
		}
		$data['page_title']	= lang('box_form');
		
		$this->form_validation->set_rules('title', 'lang:title', 'trim|required|full_decode');
                
                //$this->form_validation->set_rules('description', 'lang:description', 'trim|required|full_decode');
                //$this->form_validation->set_rules('details', 'lang:details', 'trim|required|full_decode');
                //$this->form_validation->set_rules('price_details', 'lang:price_details', 'trim|required|full_decode');
                
		$this->form_validation->set_rules('enable_on', 'lang:enable_on', 'trim');
		$this->form_validation->set_rules('disable_on', 'lang:disable_on', 'trim|callback_date_check');
		$this->form_validation->set_rules('image', 'lang:image', 'trim');
		$this->form_validation->set_rules('link', 'lang:link', 'trim');
		$this->form_validation->set_rules('new_window', 'lang:new_window', 'trim');
		
		if ($this->form_validation->run() == false)
		{
			$data['error'] = validation_errors();
									$timeid = $this->uri->segment(5);
                    if($timeid==0){
                        $time = time();
                    }	
                    else {
                        $time = $timeid;
                    }
                    $data['weather']	=	_date($time);
					$data['events']		=	$this->Calendar_model->getMyEvents($time,$this->session->userdata('ba_user_id'));
			$this->load->view($this->config->item('admin_folder').'/box_form', $data);
		}
		else
		{	
			
			$uploaded	= $this->upload->do_upload('image');
			
			$save['title']                  = $this->input->post('title');
                        
                        $save['description']		= $this->input->post('description');
                        $save['details']		= $this->input->post('details');
                        $save['price_details']		= $this->input->post('price_details');
                        
			$save['enable_on']		= format_ymd($this->input->post('enable_on'));
			$save['disable_on']		= format_ymd($this->input->post('disable_on'));
			$save['link']			= $this->input->post('link');
			$save['new_window']		= $this->input->post('new_window');

			if ($id)
			{
				$save['id']	= $id;
				
				//delete the original file if another is uploaded
				if($uploaded)
				{
					if($data['image'] != '')
					{
						$file = 'uploads/'.$data['image'];
						
						//delete the existing file if needed
						if(file_exists($file))
						{
							unlink($file);
						}
					}
				}
				
			}
			else
			{
				if(!$uploaded)
				{
					$data['error']	= $this->upload->display_errors();
					$this->load->view($this->config->item('admin_folder').'/box_form', $data);
					return; //end script here if there is an error
				}
			}
			
			if($uploaded)
			{
				$image			= $this->upload->data();
				$save['image']	= $image['file_name'];
			}
			
			$this->Box_model->save($save);
			
			$this->session->set_flashdata('message', lang('message_box_saved'));
			
			redirect($this->config->item('admin_folder').'/boxes');
		}	
	}
	
	function date_check()
	{
		
		if ($this->input->post('disable_on') != '')
		{
			if (format_ymd($this->input->post('disable_on')) <= format_ymd($this->input->post('enable_on')))
			{
				$this->form_validation->set_message('date_check', lang('date_error'));
				return FALSE;
			}
		}
		
		return TRUE;
	}
}