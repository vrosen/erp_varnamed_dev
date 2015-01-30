<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Languages extends CI_Controller {

	function __construct() {
		parent::__construct();
		remove_ssl();
                
	}
	

        public function index(){
            
                $language = $this->input->post('language');
                if(!empty($language)){
                echo $this->session->set_userdata('language',$language);
                }

               // redirect($this->uri->uri_string());
                

}
        public function lang(){
				
				$current_session 	= $this->session->userdata('language');
                $language 			= $this->input->post('language');
                
				if(!empty($language)){
					if(!empty($current_session)){
						$this->session->unset_userdata('language');
					}
					$this->session->set_userdata('language',$language);
                }
                
				$site = str_replace('admin','',$this->input->post('url'));
				redirect($this->config->item('admin_folder').'/'.$site);
				
		}
}