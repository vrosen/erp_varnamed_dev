<?php

      //CLIENT SEARCH SECTION VARS      	

            $attributes = 'class = "btn btn-primary"';
            
            $industry = array (

                        '-1'  => 'Choose a sector...',    
                        '1'   => 'All industry',
                        '2'   => 'Abattoir',
                        '3'   => 'Ambulance service',
                        '4'   => 'Beauty salon',
                        '5'   => 'Butcher',
                        '6'   => 'Care group',
                        '7'   => 'Care shop',
                        '8'   => 'Cattle farmer',
                        '9'   => 'Cleaning',
                        '10'  => 'Day-care centre',     
                        '11'  => 'Dental laboratory',
                        '12'  => 'Dental surgeons',
                        '13'  => 'Dental wholesale',
                        '14'  => 'Dentist',
                        '15'  => 'Disabled care',
                        '16'  => 'Doctor',
                        '17'  => 'Export',
                        '18'  => 'Family doctor',
                        '19'  => 'Fishmonger',
                        '20'  => 'Food service industry',
                        '21'  => 'Funeral parlour',
                        '22'  => 'Garden',
                        '23'  => 'Hairdresser',
                        '24'  => 'Home care',
                        '25'  => 'Hospital',
                        '26'  => 'Laboratory',
                        '27'  => 'Midwife',
                        '28'  => 'Nail studio',
                        '29'  => 'Nursing home',
                        '30'  => 'Nursing home',
                        '31'  => 'Oral hygienist',
                        '32'  => 'Orthodontist',
                        '33'  => 'Other / unknown',
                        '34'  => 'PMU',
                        '35'  => 'Painter',
                        '36'  => 'Pedicure',
                        '37'  => 'Pelvic therapist',
                        '38'  => 'Permanent make-up',
                        '39'  => 'Pet crematorium',
                        '40'  => 'Pharmacy',
                        '41'  => 'Physiotherapy',
                        '42'  => 'Piercing studio/jeweller',
                        '43'  => 'Podotherapy',
                        '44'  => 'Private clinic',
                        '45'  => 'Private individual',
                        '46'  => 'Retailer',
                        '47'  => 'Tattoo shop',
                        '48'  => 'Veterinarian',
                        '49'  => 'Veterinary ambulance',
                        '50'  => 'Wholesale general',
            );
            
            $gender = array (
                
                        '-1'  => 'Select gender',
                        '1'   => 'male',
                        '2'   => 'female',
            );

            $last_order_date = array (
                
                        '-1'   => 'Last order date', 
                        '2005' => '2005',
                        '2006' => '2006',
                        '2007' => '2007',
                        '2008' => '2008',
                        '2009' => '2009',
                        '2010' => '2010',
                        '2011' => '2011',
                        '2012' => '2012',
                        '2013' => '2013',
                        '2014' => '2014',
                
            );

            $status = array (
                '-1'            => 'Select status',
                'Pending'       => 'Pending',
                'Processing'    => 'Processing',
                'Shipped'       => 'Shipped',
                'On hold'       => 'On hold',
                'Cancelled'     => 'Cancelled',
                'Delivered'     => 'Delivered',
            );

            $function       = array (
                '-1'                                => 'Select position',
               'administrator'                      =>  lang('administrator'),
               'admissions_director'                =>  lang('admissions_director'),                
               'analyst'                            =>  lang('analyst'),                           
               'anesthesiologist'                   =>  lang('anesthesiologist'),                   
               'assistant'                          =>  lang('assistant'),                         
               'bereavement_coordinator'            =>  lang('bereavement_coordinator'),                        
               'biomedical_technician'              =>  lang('biomedical_technician'),                 
               'certified_medical_assistant'        =>  lang('certified_medical_assistant'),        
               'certified_nurse_assistant'          =>  lang('certified_nurse_assistant'),         
               'certified_nursing_assistant'        =>  lang('certified_nursing_assistant'),       
               'certified_pharmacy_technician'      =>  lang('certified_pharmacy_technician'),     
               'charge_nurse'                       =>  lang('charge_nurse'),                       
               'clinical_research_associate'        =>  lang('clinical_research_associate'),      
               'clinical_research_coordinator'      =>  lang('clinical_research_coordinator'),     
               'clinical_specialist'                =>  lang('clinical_specialist'),              
               'consultant'                         =>  lang('consultant'),                        
               'coordinator'                        =>  lang('coordinator'),                      
               'counselor'                          =>  lang('counselor'),                           
               'customer_service_representative'    =>  lang('customer_service_representative'),    
               'dental_hygienist'                   =>  lang('dental_hygienist'),                  
               'dentist'                            =>  lang('dentist'),                          
               'dietitian'                          =>  lang('dietitian'),                         
               'director_of_nursing'                =>  lang('director_of_nursing'),               
               'director_of_operations'             =>  lang('director_of_operations'),            
               'director_of_rehabilitation'         =>  lang('director_of_rehabilitation'),        
               'doctor'                             =>  lang('doctor'),                            
               'emergency_medical_technician'       =>  lang('emergency_medical_technician'),      
               'health_educator'                    =>  lang('health_educator'),                  
               'healthcare_administrator'           =>  lang('healthcare_administrator'),        
               'healthcare_management'              =>  lang('healthcare_management'),              
               'healthcare_or_medical'              =>  lang('healthcare_or_medical'),             
               'home_health_aid'                    =>  lang('home_health_aid'),                    
               'hospice_administrator'              =>  lang('hospice_administrator'),             
               'licensed_practical_nurse'           =>  lang('licensed_practical_nurse'),          
               'massage_therapist'                  =>  lang('massage_therapist'),                 
               'medical_administrative'             =>  lang('medical_administrative'),             
               'medical_assistant'                  =>  lang('medical_assistant'),                 
               'medical_assistant_or_phlebotomist'  =>  lang('medical_assistant_or_phlebotomist'), 
               'medical_assistant_or_receptionist'  =>  lang('medical_assistant_or_receptionist'), 
               'medical_biller'                     =>  lang('medical_biller'),                    
               'medical_billing_specialist'         =>  lang('medical_billing_specialist'),       
               'medical_office_assistant'           =>  lang('medical_office_assistant'),     
               'medical_office_manager'             =>  lang('medical_office_manager'),          
               'medical_office_specialist'          =>  lang('medical_office_specialist'),          
               'medical_receptionist'               =>  lang('medical_receptionist'),            
               'medical_records_clerk'              =>  lang('medical_records_clerk'),            
               'medical_sales'                      =>  lang('medical_sales'),                   
               'medical_secretary'                  =>  lang('medical_secretary'),              
               'medical_technician'                 =>  lang('medical_technician'),             
               'medical_technologist'               =>  lang('medical_technologist'),             
               'microbiologist'                     =>  lang('microbiologist'),              
               'nurse'                              =>  lang('nurse'),                        
               'nurse_practitioner'                 =>  lang('nurse_practitioner'),             
               'nursing_home_administrator'         =>  lang('nursing_home_administrator'),       
               'nutritionist'                       =>  lang('nutritionist'),                      
               'occupational_therapist'             =>  lang('occupational_therapist'),        
               'office_assistant'                   =>  lang('office_assistant'),               
               'office_manager'                     =>  lang('office_manager'),              
               'orderly_attendant'                  =>  lang('orderly_attendant'),                
               'paramedic'                          =>  lang('paramedic'),                        
               'patient_care_associate'             =>  lang('patient_care_associate'),         
               'patient_services_technician'        =>  lang('patient_services_technician'),   
               'patient_services_representative'    =>  lang('patient_services_representative'),   
               'pharmaceutical_sales'               =>  lang('pharmaceutical_sales'),                  
               'pharmaceutical_sales_rep'           =>  lang('pharmaceutical_sales_rep'),             
               'pharmaceutical_sales_representative'=>  lang('pharmaceutical_sales_representative'), 
               'pharmacist'                         =>  lang('pharmacist'),                          
               'pharmacy_technician'                =>  lang('pharmacy_technician'),           
               'phlebotomist'                       =>  lang('phlebotomist'),                    
               'physical_therapist'                 =>  lang('physical_therapist'),            
               'physician'                          =>  lang('physician'),                      
               'physicians_assistant'               =>  lang('physicians_assistant'),           
               'program_director'                   =>  lang('program_director'),             
               'psychiatric_aid'                    =>  lang('psychiatric_aid'),            
               'quality_coordinator'                =>  lang('quality_coordinator'),              
               'registered_nurse'                   =>  lang('registered_nurse'),                
               'receptionist'                       =>  lang('receptionist'),                 
               'recruiter'                          =>  lang('recruiter'),              
               'regional_sales_manager'             =>  lang('regional_sales_manager'),           
               'registered_medical_assistant'       =>  lang('registered_medical_assistant'),     
               'registered_nurse_rn'                =>  lang('registered_nurse_rn'),             
               'registered_nurse_rn_case_manager'   =>  lang('registered_nurse_rn_case_manager'),  
               'research_assistant'                 =>  lang('research_assistant'),             
               'respiration_inhalation_therapist'   =>  lang('respiration_inhalation_therapist'),  
               'sales_associate'                    =>  lang('sales_associate'),                  
               'sales_manager'                      =>  lang('sales_manager'),                   
               'social_services'                    =>  lang('social_services'),                  
               'therapist'                          =>  lang('therapist'),                       
               'transcription'                      =>  lang('transcription'),                     
               'ultrasonographer'                   =>  lang('ultrasonographer'),  
                );
            
            
    $order_nr           = array('id' => 'order_num','name'  => 'order_num','placeholder' => 'order number',);
    $client_nr          = array('id' => 'client_num','name'  => 'client_num','placeholder' => 'client number',);
    $client_name        = array('id' => 'client_name','name' => 'client_name','placeholder' => 'client first name',);        
    $client_lname       = array('id' => 'client_lname','name' => 'client_lname','placeholder' => 'client last name',);              
    $zip_code           = array('id' => 'zip_code','name' => 'zip_code','placeholder' => 'zip code',);
    $email              = array('id' => 'email','name' => 'email','placeholder' => 'email',);
    $action_code        = array('id' => 'action_code','name' => 'action_code','placeholder' => 'action code',);
    
    
    $turnover_per_year = array('-1' => 'Select year','2012','2013','2014');
    $turnover_per_month = array(
                            '-1'        =>      'Select month',
                            'January'	=>      lang('January'),
                            'February'	=>	lang('February'),
                            'March'	=>	lang('March'),
                            'April'	=>	lang('April'),
                            'May'	=>	lang('May'),
                            'June'	=>	lang('June'),
                            'July'	=>	lang('July'),
                            'August'	=>	lang('August'),
                            'September'	=>	lang('September'),
                            'October'	=>	lang('October'),
                            'November'	=>	lang('November'),
                            'December'	=>	lang('December'),
                        );
    $recieved_samples = array(
                             '-1'                       =>      'Select package',
                            'get_to_know_you_package'   =>   lang('get_to_know_you_package'), 
                            'disposable_sample_set'     =>   lang('disposable_sample_set'), 
                            'samples_thickies'          =>   lang('samples_thickies'),
                            );
    
    
?>
<?php include('header.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_customer');?>');
}
</script>
<table class="table table-striped">

		<?php
		$page_links	= $this->pagination->create_links();

		if($page_links != ''):?>
		<tr><td colspan="5" style="text-align:center"><?php echo $page_links;?></td></tr>
		<?php endif;?>

<!-- START SEARCH TABLE -->
<?php echo form_fieldset('Client information'); ?>
                <div class="span6">
                    <?php echo form_open($this->config->item('admin_folder').'/marketing/general_search/'); ?>

                                <div class="control-group success"><?php //echo form_dropdown('country', $search_country, '-1'); ?></div>
                                <div class="controls"><?php echo form_dropdown('country', $country, '-1'); ?></div> 
                                <div class="controls"><?php echo form_dropdown('function', $function, '-1'); ?></div> 
                                <div class="controls"><?php echo form_dropdown('status', $status, '-1'); ?></div> 
                                <div class="controls"><?php echo form_dropdown('gender', $gender, '-1'); ?></div> 
                                <div class="controls"><?php echo form_input($order_nr); ?></div>
                                <div class="controls"><?php echo form_input($client_nr); ?></div>
                                <div class="controls"><?php echo form_input($client_name); ?></div>
                                <div class="controls"><?php echo form_input($client_lname); ?></div>
                                
                    <?php echo form_submit('client_information', 'Search', $attributes); ?><br/>
                    <?php echo form_close(); ?><br>
		</div>
sdcjdfbvdfv
sdcjdfbvdfv
<!-- END SEARCH TABLE -->

<!-- START SEARCH TABLE -->
<?php echo form_fieldset('Contact information'); ?>
                <div class="span6">
                    <?php echo form_open($this->config->item('admin_folder').'/marketing/general_search/'); ?>

                                <div class="control-group success"><?php //echo form_dropdown('country', $search_country, '-1'); ?></div>
                                <div class="controls"><?php echo form_dropdown('country', $country, '-1'); ?></div> 
                                <div class="controls"><?php echo form_dropdown('function', $function, '-1'); ?></div>   
                                <div class="controls"><?php echo form_dropdown('gender', $gender, '-1'); ?></div> 
                                <div class="controls"><?php echo form_input($zip_code); ?></div>

                    <?php echo form_submit('contact_information', 'Search', $attributes); ?><br/>
                    <?php echo form_close(); ?><br>
		</div>
</fieldset>
<!-- END SEARCH TABLE -->

<!-- START SEARCH TABLE -->
<?php echo form_fieldset('Contact info-email'); ?>
                <div class="span6">
                    <?php echo form_open($this->config->item('admin_folder').'/marketing/general_search/'); ?>

                                <div class="control-group success"><?php //echo form_dropdown('country', $search_country, '-1'); ?></div>
                                <div class="controls"><?php echo form_dropdown('function', $function, '-1'); ?></div>  
                                <div class="controls"><?php echo form_dropdown('gender', $gender, '-1'); ?></div> 
                                <div class="controls"><?php echo form_input($email); ?></div>
                                <div class="controls"><?php echo form_input($client_name); ?></div>
                                <div class="controls"><?php echo form_input($client_lname); ?></div>
                    <?php echo form_submit('contact_info', 'Search', $attributes); ?><br/>
                    <?php echo form_close(); ?><br>
		</div>

</fieldset>
<!-- END SEARCH TABLE -->
            
<!-- START SEARCH TABLE -->
<?php echo form_fieldset('Past order behavior'); ?>
                <div class="span6">
                    <?php echo form_open($this->config->item('admin_folder').'/marketing/general_search/'); ?>

                                <div class="control-group success"><?php //echo form_dropdown('country', $search_country, '-1'); ?></div>
                                <div class="controls"><?php echo form_dropdown('recieved_samples', $recieved_samples, '-1'); ?></div> 
                                <div class="controls"><?php echo form_input($action_code); ?></div>

                    <?php echo form_submit('order_behavior', 'Search', $attributes); ?><br/>
                    <?php echo form_close(); ?><br>
		</div>
</fieldset>
<!-- END SEARCH TABLE -->

<!-- START SEARCH TABLE -->
<?php echo form_fieldset('Marketing actions'); ?>
                <div class="span6">
                    <?php echo form_open($this->config->item('admin_folder').'/marketing/general_search/'); ?>

                                <div class="control-group success"><?php //echo form_dropdown('country', $search_country, '-1'); ?></div>
                                <div class="controls"><?php echo form_dropdown('turnover_per_year', $turnover_per_year, '-1'); ?></div> 
                                <div class="controls"><?php echo form_dropdown('turnover_per_month', $turnover_per_month, '-1'); ?></div>
                    <?php echo form_submit('marketing_actions', 'Search', $attributes); ?><br/>
                    <?php echo form_close(); ?><br>
		</div>
</fieldset>
<!-- END SEARCH TABLE -->

            
            
            
            
</table>
<?php include('footer.php'); ?>