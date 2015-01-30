<?php
		$site_name = 'Dutchblue control';
                $admin_panel= 'Admin Panel';
                $clients = 'Clients';
                $stock = 'Stock';
                $invoice = 'Invoice';
                $overview = 'Overview';
                $management = 'Management';
                $callers = 'Callers';
                $users = 'Users';
                $search_tools = 'Search tools';
                $search_tools_explain = 'Enter search cretiria';
                $to_do_list = 'My to do list'; 
                $current_user = 'current user';
                $profile = 'Profile';
                $logout = 'Logout';
                $products = 'Products';
                // STOCK
                $draft_orders = 'Draft orders';
                $new_shippments = 'New shippments';
                $shipping_status = 'Shipping status';
                $backorder_list = 'Backorder list';
                $old_dispatches = 'Old dispatches';
                // INVOICE
                $open_invoices = 'Open invoices';
                $send_invoices = 'Send';
                $reminders = 'Reminders';
                // OVERVIEW
                $overview_per_client = 'Overview per client';
                $debtors = 'Debtors';
                $management = 'Management';
                $sales = 'Sales';
                $downloads = 'Downloads';
                $home = 'Home';
                $shop_content = 'Shop content';
                
		$article_number = array(
	
					'name'        	=> 'article_number',
                                        'class'         => 'input-xlarge focused',
					'id'          	=> 'focusedInput1',
					'size'        	=> '10',
					'maxlength'	=> '15',
                                        'type'          => 'text',
					'placeholder' 	=> 'Article number',
                );
		$article_definition = array(
	
					'name'        	=> 'article_definition',
					'class'         => 'input-xlarge focused',
					'id'          	=> 'focusedInput2',
					'size'        	=> '10',
					'maxlength'	=> '15',
                                        'type'          => 'text',
					'placeholder' 	=> 'Article definition',
                );
		$Customer = array(
	
					'name'        	=> 'customer',
					'class'         => 'input-xlarge focused',
					'id'          	=> 'focusedInput3',
					'size'        	=> '10',
					'maxlength'	=> '15',
                                        'type'          => 'text',
					'placeholder' 	=> 'Customer ',
                );
		$order = array(
	
					'name'        	=> 'order',
                                        'class'         => 'input-xlarg e focused',
					'id'          	=> 'focusedInput4',
					'size'        	=> '10',
					'maxlength'	=> '15',
                                        'type'          => 'text',
					'placeholder' 	=> 'Order number',
                );
		$Invoice = array(
	
					'name'        	=> 'invoice',
                                        'class'         => 'input-xlarge focused',
					'id'          	=> 'focusedInput5',
					'size'        	=> '10',
					'maxlength'	=> '15',
                                        'type'          => 'text',
					'placeholder' 	=> 'Invoice',
                );
		$webshop_origin = array(
					
					'-1'	=> 'Select Webshop',
					'1'		=> 'België',
					'2'		=> 'Belgique',
					'3'		=> 'Deutschland',
					'4'		=> 'France',
					'5'		=> 'Luxembourg',
					'6'		=> 'Nederland',
					'7'		=> 'United Kingdom',
					'8'		=> 'Österreich',            
                );
		$webshop_lang = array(

					'-1'	=> 'Select language',
					'1'		=> 'Deutsch',
					'2'		=> 'English',
					'3'		=> 'Français',
					'4'		=> 'Nederlands',      
                );
                $label_attributes = array(
                                        'class'         => 'control-label',
            );
            $form_attributes = array(
                '                       class'          => 'form-horizontal'
            );

?>


<div class="container">
    <!-- START SEARCH FORM -->
        <div class="container-fluid">
            <div class="row-fluid">

                <!--/span-->
                <div class="span9" id="content">
                      <!-- morris stacked chart -->
                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block">

                            <div class="block-content collapse in">
                                <div class="span12">
                                        <?php echo form_open('eshop/search',$form_attributes); ?>
                                        <?php //echo form_fieldset($search_tools_explain); ?>
                                        <?php echo anchor('eshop/','New window',array('class' => 'badge badge-info pull-left')); ?><br/><br/>
                                        <?php echo anchor('eshop/','Print version',array('class' => 'badge badge-info pull-left')); ?><br/><br/>
                                            
                                        <div class="control-group">
                                            <?php echo form_label('Article number','focusedInput1',$label_attributes); ?>
                                            <div class="controls">
                                                <?php echo form_input($article_number); ?>&nbsp;<?php echo anchor('eshop/','Go'); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <?php echo form_label('Article definition','focusedInput2',$label_attributes); ?>
                                            <div class="controls">
                                                <?php echo form_input($article_definition); ?>&nbsp;<?php echo anchor('eshop/','Go'); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <?php echo form_label('Customer','focusedInput3',$label_attributes); ?>
                                            <div class="controls">
                                                <?php echo form_input($Customer); ?>&nbsp;<?php echo anchor('eshop/','Go'); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <?php echo form_label('Order','focusedInput4',$label_attributes); ?>
                                            <div class="controls">
                                                <?php echo form_input($order); ?>&nbsp;<?php echo anchor('eshop/','Go'); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <?php echo form_label('Invoice','focusedInput5',$label_attributes); ?>
                                            <div class="controls">
                                                <?php echo form_input($Invoice); ?>&nbsp;<?php echo anchor('eshop/','Go'); ?>
                                            </div>
                                        </div>

                                    <?php echo form_close(); ?>
      
                                    <?php echo form_open('eshop/search',$form_attributes); ?>

                                            <div class="control-group success">
                                                <?php echo form_label('Webshop','webshop_origin',$label_attributes); ?>
                                                <div class="controls">
                                                    <?php echo form_dropdown('webshop_origin', $webshop_origin, '-1'); ?>
                                                </div>
                                            </div>
                                            <div class="control-group success">
                                                <?php echo form_label('Language','webshop_lang',$label_attributes); ?>
                                                <div class="controls">
                                                    <?php echo form_dropdown('webshop_lang', $webshop_lang, '-1'); ?>
                                                </div>
                                            </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                        

                    </div>
                </div>
            </div>
        </div>
<!-- END SEARCH FORM -->
</div>

	
	