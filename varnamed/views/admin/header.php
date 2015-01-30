<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript">
    var  qqurl = "<?php echo base_url(); ?>";
</script>

<title>VarnaMed | ERP // dev2.0.1<?php echo (isset($page_title))?' :: '.$page_title:''; ?></title>
<link rel="shortcut icon" href="<?php echo base_url('assets/favicon.ico'); ?>">
<link type="text/css" href="<?php echo base_url('assets/css/jquery-ui.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/main.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php //echo base_url('assets/css/bootstrap-responsive.min.css');?>" rel="stylesheet" type="text/css" />
<link type="text/css" href="<?php echo base_url('assets/css/redactor.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('assets/css/file-browser.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('assets/css/colorbox.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('assets/css/agstyle.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('assets/js/jtable/themes/metro/purple/jtable.css');?>" rel="stylesheet" />

<!--link type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('assets/css/jquery.datatables.yadcf.css');?>" rel="stylesheet" /-->


<?php
	$c_shop = $this->session->userdata('shop');
    
	if(empty($c_shop)){
      ?><link type="text/css" href="<?php echo base_url('assets/css/master.css');?>" rel="stylesheet" /><?php
    }
    if($c_shop == '1'){ //Comforties
      ?><link type="text/css" href="<?php echo base_url('assets/css/master-pink.css');?>" rel="stylesheet" /><?php
    }
    if($c_shop == '2'){ //Dutchblue
      ?><link type="text/css" href="<?php echo base_url('assets/css/master-blue.css');?>" rel="stylesheet" /><?php
    }
	if($c_shop == '3'){	//Glovers
      ?><link type="text/css" href="<?php echo base_url('assets/css/master-green.css');?>" rel="stylesheet" /><?php
    }
?>
<!--link type="text/css" href="<?php //echo base_url('assets/css/jquery.datepick.css');?>" rel="stylesheet" /-->

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/redactor.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/file-browser.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/coda.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jtable/jquery.jtable.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.colorbox-min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/aprofit.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/custom.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-typeahead.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jq-ac-script.js');?>"></script>
<!-- <script type="text/javascript" src="<?php //echo base_url('assets/js/jq-ac-script_supplier.js');?>"></script> -->
<script type="text/javascript" src="<?php echo base_url('assets/js/jq-ac-complex.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/parser_rules/advanced.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/dist/wysihtml5-0.3.0.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/autoNumeric.js');?>"></script>
<!--script type="text/javascript" src="<?php //echo base_url('assets/js/jquery.datepick.pack.js');?>"></script>
<script type="text/javascript" src="<?php //echo base_url('assets/js/packery.pkgd.js');?>"></script>
<script type="text/javascript" src="<?php //echo base_url('assets/js/draggabilly.js');?>"></script-->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.dataTables.yadcf.js');?>"></script>
<?php //if($this->auth->is_logged_in(false, false)):?>

<?php //endif;?>
</head>

<body>
<div class="page-wrap">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo $this->config->base_url(); echo 'admin/dashboard';?>"><span class="glyphicon glyphicon-home"></span></a>
				</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
		


		<!-- START PRODUCTS  -->
		<?php if(!empty($c_shop)): ?>
			<li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th-large"></span>
                            <?php echo lang('dash_products') ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <!-- categories  -->
				<li>
				<?php 
                                    if(!empty($categories)){
                                        echo anchor($this->config->item('admin_folder').'/categories', lang('dash_categories')); 
                                    }
				?>
				</li>
				<!-- groups  -->
				<li>
                                    <?php 
                                    if(!empty($groups)){
                                    echo anchor($this->config->item('admin_folder').'/groups', lang('dash_groups')); 
                                    }
                                    ?>
				</li>
                                <!-- products  -->
				<li>
                                    <?php 
                                    
                                        echo anchor($this->config->item('admin_folder').'/products', lang('dash_product_list')); 
                                    
                                    ?>
				</li>                                


			</ul>
		</li>
		<!-- END PRODUCTS  -->
                <!-- START CUSTOMERS  -->    
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span> 
                        <?php echo lang('dash_customers') ?> 
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><?php echo anchor($this->config->item('admin_folder').'/customers', lang('dash_customers')); ?></li>
                        <?php 
                        if($c_shop == 3){
                            ?><li><?php echo anchor($this->config->item('admin_folder').'/customers/new_requests', lang('new_requests')); ?></li><?php
                        }
                        ?>
                    </ul>
                </li>
                <!-- END CUSTOMERS  --> 
                <?php $can_edit_shipping = $this->bitauth->has_role('can_edit_shipping') ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-shopping-cart"></span> <?php echo lang('dash_all_orders') ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo anchor($this->config->item('admin_folder').'/orders', lang('dash_orders')); ?></li>
                        <li><?php echo anchor($this->config->item('admin_folder').'/orders/processed_orders', lang('processed_orders')); ?></li>
                        <li><?php echo anchor($this->config->item('admin_folder').'/orders/orders_to_ship', lang('orders_for_ship')); ?></li>
                        <li><?php echo anchor($this->config->item('admin_folder').'/orders/all_orders', lang('all_orders')); ?></li>
                        <?php if($can_edit_shipping): ?>
                            <li><?php echo anchor($this->config->item('admin_folder').'/orders/new_shippments', lang('new_shippments')); ?></li>
                            <li><?php echo anchor($this->config->item('admin_folder').'/orders/old_shippments', lang('old_shippments')); ?></li>
                        <?php endif; ?>
                        <li><?php echo anchor($this->config->item('admin_folder').'/orders/backorder', lang('backorder')); ?></li>
                    </ul>
                </li>
                <!-- END ORDERS  -->
                <!-- START PURCHASE  -->    
		<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span>
                    <?php echo lang('dash_stock') ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php if($can_edit_shipping): ?> 
                            <li><?php echo anchor($this->config->item('admin_folder').'/suppliers', lang('dash_suppliers')); ?></a></li>
                           <!-- <li><?php //echo anchor($this->config->item('admin_folder').'/offer', lang('dash_offer')); ?></li> -->
                            <li><?php echo anchor($this->config->item('admin_folder').'/stock', lang('dash_stock_orders')); ?></li>
                            <li><?php echo anchor($this->config->item('admin_folder').'/stock/delivered', lang('stock_delievered_orders')); ?></li>
                            <li><?php echo anchor($this->config->item('admin_folder').'/stock/cancelled', lang('stock_cancelled_orders')); ?></li>
                            <li><?php echo anchor($this->config->item('admin_folder').'/stock/on_hold', lang('stock_on_hold_orders')); ?></li>
                            <li><?php echo anchor($this->config->item('admin_folder').'/stock/closed_orders', lang('closed_orders')); ?></li>
                            <li><?php echo anchor($this->config->item('admin_folder').'/stock/warehouse_stock', lang('stock_operations')); ?></li>
                        <?php endif; ?>                             
			<li><?php echo anchor($this->config->item('admin_folder').'/stock/reservations', lang('dash_reservations')); ?></li>
			<li><?php echo anchor($this->config->item('admin_folder').'/stock/discarded_list', lang('discarded')); ?></li>
                    </ul>
		</li>
                <!-- END PURCHASE  --> 
		<!-- START INVOICES  -->
                <?php  
                $can_send_invoice = $this->bitauth->has_role('can_send_invoice');
                $can_remaind = $this->bitauth->has_role('can_remaind');
                ?>
		<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-paperclip"></span>
                    <?php echo lang('dash_invoices') ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo anchor($this->config->item('admin_folder').'/invoices', lang('dash_open_invoices')); ?></li>
                        <?php if($can_send_invoice): ?>
                        <?php //echo anchor($this->config->item('admin_folder').'/invoices/sent_invoices', lang('dash_sent_invoices')); ?>
						<li><?php echo anchor($this->config->item('admin_folder').'/invoices/invoice_list', lang('dash_invoice_list')); ?></li>
						<li><?php echo anchor($this->config->item('admin_folder').'/invoices/invoices_print', lang('dash_open_invoices_print')); ?></li>
                        <?php endif; ?>
                        <?php if($can_remaind): ?>
                        <li><?php echo anchor($this->config->item('admin_folder').'/invoices/reminders', lang('dash_reminders')); ?></li>
                        <?php endif; ?>
                    </ul>
		</li>
		<!-- END INVOICES  -->
		<!-- START OVERVIEW  -->
                <?php $can_overview = $this->bitauth->has_role('can_overview'); ?>
				   <?php if($can_overview) : ?>
		<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-sort"></span>
                    <?php echo lang('dash_overview') ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                     
                            <li><?php echo anchor($this->config->item('admin_folder').'/overview', lang('dash_overview_per_client')); ?></li>
             
                        <li><?php echo anchor($this->config->item('admin_folder').'/overview/to_do_list_client', lang('dash_overview_todo_list_pro_client')); ?></li>
               
                            <li><?php echo anchor($this->config->item('admin_folder').'/overview/to_do_list_agent', 'To do per agent'); ?></li>
                            <li><?php echo anchor($this->config->item('admin_folder').'/overview/debtors', lang('dash_overview_debtors')); ?></li>
                            <li><?php echo anchor($this->config->item('admin_folder').'/overview/web_orders', lang('dash_overview_web_orders')); ?></li>
			    <li><?php echo anchor($this->config->item('admin_folder').'/overview/sales', 'Management'); ?></li>
                            <li><?php echo anchor($this->config->item('admin_folder').'/overview/turnover', "Turnover"); ?></li>
                            <li><?php echo anchor($this->config->item('admin_folder').'/overview/products', "Productus"); ?></li>
                            <li><?php echo anchor($this->config->item('admin_folder').'/overview', lang('dash_overview_callcenter')); ?></li>
			
                    </ul>
		</li>
		<?php endif; ?>
		<!-- END OVERVIEW  -->
		<?php if($this->bitauth->is_admin()): ?>
		<!-- START ADMINISTRATIVE  -->
		<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-wrench"></span>
						<?php echo lang('dash_administrative') ?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
															<li><?php echo anchor($this->config->item('admin_folder').'/admin', lang('dash_admin')); ?></li>
															<li><?php echo anchor($this->config->item('admin_folder').'/shops', lang('dash_shops')); ?></li>
															<li><?php echo anchor($this->config->item('admin_folder').'/settings', lang('dash_settings')); ?></li>
															<li><?php echo anchor($this->config->item('admin_folder').'/locations', lang('dash_locations')); ?></li>
															<li><?php echo anchor($this->config->item('admin_folder').'/banners', lang('common_banners')); ?></li>
															<li><?php echo anchor($this->config->item('admin_folder').'/boxes', lang('common_boxes')); ?></li>
															<li><?php echo anchor($this->config->item('admin_folder').'/locations', lang('common_pages')); ?></li>
															<li><?php echo anchor($this->config->item('admin_folder').'/locations', lang('common_branches')); ?></li>
															<li><?php echo anchor($this->config->item('admin_folder').'/locations', lang('common_homepage')); ?></li>
															<li><?php echo anchor($this->config->item('admin_folder').'/locations', lang('common_webshop_content')); ?></li>
															<li><?php echo anchor($this->config->item('admin_folder').'/locations', lang('common_product_devision')); ?></li>
															<li><?php echo anchor($this->config->item('admin_folder').'/locations', lang('common_exchange')); ?></li>
															<li><?php echo anchor($this->config->item('admin_folder').'/locations', lang('common_test_classification')); ?></li>

							</ul>
						</li>
						<?php endif; ?>
											<!-- END ADMINISTRATIVE  -->
						
											
					</ul>
<?php endif; ?>
					<ul class="nav navbar-nav navbar-right">
						
						<li class="dropdown"><?php echo anchor($this->config->item('admin_folder').'/dashboard', '<span class="glyphicon glyphicon-off" style="margin-right: 5px;"></span>'.$this->session->userdata('ba_username').'<b class="caret"></b>', 'class="dropdown-toggle" data-toggle="dropdown"'); ?>
							<ul class="dropdown-menu">
						<li><?php echo anchor($this->config->item('admin_folder').'/admin/logout', lang('dash_logout')); ?></li>
						</ul>
						</li>
						
						<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-random" style="margin-right: 5px;"></span>
						
						<?php  if($c_shop == '1'){
								  ?>Comforties<?php
								}
								if($c_shop == '2'){
								  ?>Dutchblue<?php
								}
								if($c_shop == '3'){
								  ?>Glovers<?php
								} 
								if($c_shop == '0'){
								  ?>Chose a Shop<?php
								}
							?>
						
						<b class="caret"></b></a> <?php //echo anchor($this->config->item('admin_folder').'/dashboard', '<span class="glyphicon glyphicon-wrench" style="margin-right: 5px;"></span>'.$this->session->userdata('ba_username').'<b class="caret"></b>', 'class="dropdown-toggle" data-toggle="dropdown"'); ?>
					
						<div class="dropdown-menu" style="padding: 10px 10px 0 10px;">

						<?php $languages = array('0'=>'Select language','english'=>'English','german'=>'Deutsch','french'=>'Francais','dutch'=>'Nederlands','bulgarian'=>'Bulgarian'); ?>
							
						 <?php $the_shops = array(
												'0'=>'Select shop',
												1 => 'Comforties', 
												2 =>'Dutchblue',
												3 =>'Glovers'
												); 
							?>
						 
						 

								  
						 <?php $uri = str_replace('/admin/', '', $this->uri->uri_string()); ?>
						 
						 <?php echo form_open($this->config->item('admin_folder').'/languages/lang/');?>
							<div class="form-group">
								<?php 
									$js = 'id="language" class="form-control" style="width: 220px;" onChange="this.form.submit();"'; 
									$c_lang = $this->session->userdata('language');
								?>
									<?php 

											if(!empty($c_lang)){
												echo form_dropdown('language',$languages,$c_lang,$js);
											}
											else {
												echo form_dropdown('language',$languages,'0',$js);
											}

									?>      
								</div>
								<input type='hidden' name='url' value='<?php echo $uri; ?>'>
							</form>
							
							<?php echo form_open($this->config->item('admin_folder').'/shops/shop/');?>
								<div class="form-group">
								<?php 
									$js = 'id="shop" class="form-control" style="width: 220px;" onChange="this.form.submit();"'; 
									$c_shop = $this->session->userdata('shop');
								?>
										<?php 
											if(!empty($c_shop)){
												echo form_dropdown('shop',$the_shops,$c_shop,$js);
											}
											else {
												echo form_dropdown('shop',$the_shops,'0',$js);
											}
										?>      
								</div>
								<input type='hidden' name='url' value='<?php echo $uri; ?>'>
							</form>
						</div>
						</li>
					</ul>
		</div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

	<div id="sidebar">

		<span id="sidebarhide" class="expand pull-right" style="margin-bottom: 2px;" >Hide<span class="expand glyphicon glyphicon-resize-horizontal pull-right" style="color: #c9c9c9; margin: 2px;"></span></span>
		<span id="sidebarshow" class="expand pull-right" style="margin-bottom: 2px; display: none;" >Show<span class="expand glyphicon glyphicon-resize-horizontal pull-right" style="color: #c9c9c9; margin: 2px;"></span></span>
<?php if(!empty($c_shop)): ?>
		<div class="panel panel-default" style="width: 250px; float: left;">
		  <!-- Default panel contents -->
		  <div class="panel-heading">Find<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
		  <div class="panel-body">	
										<?php $uri = str_replace('/admin/', '', $this->uri->uri_string()); ?>

												<?php echo form_open($this->config->item('admin_folder').'/search', 'role="form" ');?>
														<div class="form-group">
														
															<input type="text" class="form-control" style="width: 228px; float: left; margin-right: 4px; " name="search_term_invoices" placeholder="Search for invoices<?php //echo lang('search_term');?>" /><br>
															<input type="text" class="form-control" style="width: 228px; float: left; margin-right: 4px; margin-top: 10px;" name="search_term_products" placeholder="Search for products<?php //echo lang('search_term');?>" />
															<input type="text" class="form-control" style="width: 228px; float: left; margin-right: 4px; margin-top: 10px;" name="search_term_customers" placeholder="Search for customers<?php //echo lang('search_term');?>" /> 
															<input type="text" class="form-control" style="width: 228px; float: left; margin-right: 4px; margin-top: 10px;" name="search_term_orders" placeholder="Search for orders<?php //echo lang('search_term');?>" />
															<input type="text" class="form-control" style="width: 228px; float: left; margin-right: 4px; margin-top: 10px;" name="search_term_zip" placeholder="Search by postcode<?php //echo lang('search_term');?>" />
															<input type='hidden' name='url' value='<?php echo $uri; ?>'>
					
																<select type="text" class="form-control" style="width: 228px; float: left; margin-right: 4px; margin-top: 10px;" name="search_term_country" >
																		<option value="0"><?php echo lang('select_country'); ?></option>
																		<option value="AU">Australia</option>
																		<option value="BE">België</option>
																		<option value="BG">Bulgarije</option>
																		<option value="DE">Deutschland</option>
																		<option value="DK">Dänemark</option>
																		<option value="FR">France</option>
																		<option value="IR">Ireland</option>
																		<option value="IT">Italien</option>
																		<option value="LU">Luxemburg</option>
																		<option value="NL">Nederland</option>
																		<option value="PL">Polen</option>
																		<option value="PT">Portugal</option>
																		<option value="RO">Roemenië</option>
																		<option value="CH">Schweiz</option>
																		<option value="ES">Spanien</option>
																		<option value="CZ">Tschechische Republik</option>
																		<option value="HU">Ungarn</option>
																		<option value="UK">United Kingdom</option>
																		<option value="US">United States of America</option>
																		<option value="SE">Zweden</option>
																		<option value="AT">Österreich</option>
																</select>
												
													
																<select type="text" class="form-control" style="width: 228px; float: left; margin-right: 4px; margin-top: 10px;" name="search_term_industry" >
																		<option value="0">Select industry<?php //echo lang('select_sector'); ?></option>
																		<option value="82">Abattoir</option>
																		<option value="66">Ambulance service</option>
																		<option value="52">Beauty salon</option>
																		<option value="77">Butcher</option>
																		<option value="42">Care group</option>
																		<option value="43">Care shop</option>
																		<option value="74">Cattle farmer</option>
																		<option value="56">Cleaning</option>
																		<option value="38">Day-care centre</option>
																		<option value="61">Dental laboratory</option>
																		<option value="47">Dental surgeons</option>
																		<option value="50">Dental wholesale</option>
																		<option value="16">Dentist</option>
																		<option value="58">Disabled care</option>
																		<option value="20">Doctor</option>
																		<option value="22">Export</option>
																		<option value="35">Family doctor</option>
																		<option value="75">Fishmonger</option>
																		<option value="37">Food service industry</option>
																		<option value="53">Funeral parlour</option>
																		<option value="71">Garden</option>
																		<option value="36">Hairdresser</option>
																		<option value="3">Home care</option>
																		<option value="1">Hospital</option>
																		<option value="45">Laboratory</option>
																		<option value="85">Midwife</option>
																		<option value="59">Nail studio</option>
																		<option value="2">Nursing home</option>
																		<option value="41">Nursing home</option>
																		<option value="46">Oral hygienist</option>
																		<option value="39">Orthodontist</option>
																		<option value="8">Other / unknown</option>
																		<option value="40">PMU</option>
																		<option value="79">Painter</option>
																		<option value="34">Pedicure</option>
																		<option value="62">Pelvic therapist</option>
																		<option value="65">Permanent make-up</option>
																		<option value="55">Pet crematorium</option>
																		<option value="4">Pharmacy</option>
																		<option value="57">Physiotherapy</option>
																		<option value="64">Piercing studio/jeweller</option>
																		<option value="49">Podotherapy</option>
																		<option value="67">Private clinic</option>
																		<option value="32">Private individual</option>
																		<option value="30">Retailer</option>
																		<option value="33">Tattoo shop</option>
																		<option value="54">Veterinarian</option>
																		<option value="44">Veterinary ambulance</option>
																		<option value="51">Wholesale general</option>
																</select>
												
														<?php if($this->bitauth->has_role('can_overview')) : ?>    
													
																<select type="text" class="form-control" style="width: 228px; float: left; margin-right: 4px; margin-top: 10px;" name="search_term_buitendienst" >
																	<option value="0">Select Buitendienst<?php //echo lang('select_country'); ?></option>
																	<option value="173">Karel van Mossevelde</option>
																	<option value="179">Veronica Hoffman</option>
																	<option value="184">Ann Jansens</option>
																	<option value="187">Hildo Kat</option>
																	<option value="208">Ernest Lassman</option>
																	<option value="209">Maria Meister</option>
																	<option value="213">Geert Kloppenburg</option>
																	<option value="217">Stephanie Gillet</option>
																	<option value="219">Petra Muller</option>
																	<option value="223">Eduard</option>
																	<option value="224">Mathilde Weiss</option>
																</select>
														<?php endif; ?>  
																<button class="btn btn-default" style="width: 144px; margin-top: 10px;"  name="submit" value="search"><span class="glyphicon glyphicon-search"></span></button>
																<a class="btn btn-info" style="width: 80px; margin-top: 10px;" href="<?php echo site_url($uri);?>"><span class="glyphicon glyphicon-refresh"></span></a>
														  
														</div>
												</form>		
			</div>
		</div>
	<?php endif; ?>	

			<?php $found_invoices 	=  $this->session->flashdata('found_invoices'); ?>
			<?php $found_products 	=  $this->session->flashdata('found_products'); ?>
			<?php $found_customers 	=  $this->session->flashdata('found_customers'); ?>
			<?php $found_customers_zip 	=  $this->session->flashdata('found_customers_zip'); ?>
			<?php $found_orders 	=  $this->session->flashdata('found_orders'); ?>
			<?php $no_result 		=  $this->session->flashdata('no_result'); ?>
			<?php $found_cats 		=  $this->session->flashdata('c_categories'); ?>
			<?php $found_groups 	=  $this->session->flashdata('c_groups'); ?>
			<?php 
						if(count($found_products) > 1 ){
							echo count($found_products).' '.lang('products');
						}
						else {
							echo count($found_products).' '.lang('product');
						}
						$enabled = array('0'=>'Disabled','1'=>'Enabled');
			?>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		<div class="panel panel-default" style="width: 250px; float: left;">
		  <!-- Default panel contents -->
		  <div class="panel-heading">
		  <?php if(!empty($weather['current_month_text'])) echo $weather['current_month_text']; ?>
		  <span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
		</div>
		  <div class="panel-body">
			<div id="calmain">

			<table cellspacing="0">
				<thead>
				<tr>
					<th>Sun</th>
					<th>Mon</th>
					<th>Tue</th>
					<th>Wed</th>
					<th>Thu</th>
					<th>Fri</th>
					<th>Sat</th>
				</tr>
				</thead>
				<tr>
					<?php
					
					
					$day = $weather['day'];
					$current_year = $weather['current_year'];
					$current_month = $weather['current_month'];
					

					
					
					for($i=0; $i< $weather['total_rows']; $i++)
					{
						for($j=0; $j<7;$j++)
						{
							$day++;					
							
							if($day>0 && $day<=$weather['total_days_of_current_month'])
							{
								//YYYY-MM-DD date format
								$date_form = "$current_year/$current_month/$day";
								echo '<td';
								//check if the date is today
								if($date_form == $weather['today'])
								{
									echo ' id="today"';
								}
								
								//check if any event stored for the date
								if(array_key_exists($day,$events))
								{
									//adding the date_has_event class to the <td> and close it
									echo ' class="date_has_event"> '.$day;
									
									//adding the eventTitle and eventContent wrapped inside <span> & <li> to <ul>
									echo '<div class="events"><ul>';
									
									foreach ($events as $key=>$event){
										if ($key == $day){
										foreach ($event as $single){					
										
									echo  '<li>';
									echo anchor("admin/search/edit/$single->id",'<span class="title">'.$single->eventTitle.'(by '.$single->user.')</span><span class="desc">'.$single->eventContent.'</span>');
									echo '</li>'; 
																} // end of for each $event
														}
														} // end of foreach $events

									echo '</ul></div>';
								} // end of if(array_key_exists...)
								else 
								{
									//if there is not event on that date then just close the <td> tag
									echo '> '.$day;
								}
								echo "</td>";
							}
							else 
							{
								//showing empty cells in the first and last row
								echo '<td class="padding">&nbsp;</td>';
							}
						}
						echo "</tr><tr>";
					}
					
					?>
				</tr>
			
				<tfoot>		
					<th>
					<?php //echo anchor(current_url()."/".$weather['previous_year'],'&laquo;&laquo;', array('title'=>$weather['previous_year_text']));?>
					</th>
					<th>
					<?php //echo anchor('admin/dashboard/index/'.$this->session->userdata('ba_user_id')."/".$weather['previous_month'],'&laquo;', array('title'=>$weather['previous_month_text']));?>
					</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<th>
					<?php //echo anchor('admin/dashboard/index/'.$this->session->userdata('ba_user_id')."/".$weather['next_month'],'&raquo;', array('title'=>$weather['next_month_text']));?>
					</th>
					<th>
					<?php //echo anchor('admin/dashboard/index/'.$this->session->userdata('ba_user_id')."/".$weather['next_year'],'&raquo;&raquo;', array('title'=>$weather['next_year_text']));?>
					
					</th>		
				</tfoot>
			</table>
			</div>
			</div>
			</div>
			
			<?php


		$city_array = array(
		  

			'2759794' => 'Amsterdam',
			'726050' => 'Varna',
			
		);
		$js_w = 'id="shirts" class="form-control" style="margin-bottom: 5px;" onChange="this.form.submit()"';
		?>



			<?php 
			if ($this->session->flashdata('message')){
				echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
			}
			?>

		<div class="panel panel-default" style="width: 250px; float: left;">
		  <!-- Default panel contents -->
		  <div class="panel-heading">Add Event<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
		  <div class="panel-body">	
			<?php echo form_open($this->config->item('admin_folder').'/search/create/'); ?>
				<table class="table-responsive" style="width:100%;">
					<tr>
						<td><div><?php echo form_input(array('name' => 'date','id' => 'start_top','placeholder' => 'Date','type' => 'date','class' => 'form-control','style' => 'margin-bottom: 5px;' )); ?></div></td>
					</tr>
					<tr>
						<td><?php echo form_input(array('name' => 'eventTitle','placeholder' => 'Title','type' => 'text','class' => 'form-control','style' => 'margin-bottom: 5px;' )); ?></td>
					</tr>
					<tr>
						<td><textarea class="span4 form-control" rows="3" name="eventContent" style="margin-bottom: 5px; resize:none;" id="eventContent" placeholder="Event"></textarea></td>
					</tr>
					<tr>
					<td><input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('ba_user_id'); ?>" /></td>
					<td><input type="hidden" name="user" id="nick" value="<?php echo $this->session->userdata('ba_username'); ?>" /></td>
					<input type='hidden' name='url' value='<?php echo $uri; ?>'>
					</tr>
					<tr>
						<td colspan="2">
							<button class="btn btn-info pull-right" type="submit" name="submit" value="add_event"><?php echo lang('add_event'); ?></button>
						</td>
					</tr>
				</table>
			</form>
			<script>$('#start_top').datepicker({dateFormat:'yy-mm-dd'});</script>
			</div>
		</div>

		<div class="panel panel-default" style="width: 250px; float: left;">
		  <!-- Default panel contents -->
		  <div class="panel-heading">Calculator<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
		  <div class="panel-body">	
			<FORM NAME="Calc">
				<table class="table-responsive" style="width:100%;">
					<TR>
					<TD>
					<INPUT TYPE="text"   NAME="Input" Size="14">
					<br>
					</TD>
					</TR>
					<TR>
					<TD>
					<INPUT TYPE="button" NAME="one"   VALUE="  1  " OnClick="Calc.Input.value += '1'">
					<INPUT TYPE="button" NAME="two"   VALUE="  2  " OnCLick="Calc.Input.value += '2'">
					<INPUT TYPE="button" NAME="three" VALUE="  3  " OnClick="Calc.Input.value += '3'">
					<INPUT TYPE="button" NAME="plus"  VALUE="  +  " OnClick="Calc.Input.value += ' + '">
					<br>
					<INPUT TYPE="button" NAME="four"  VALUE="  4  " OnClick="Calc.Input.value += '4'">
					<INPUT TYPE="button" NAME="five"  VALUE="  5  " OnCLick="Calc.Input.value += '5'">
					<INPUT TYPE="button" NAME="six"   VALUE="  6  " OnClick="Calc.Input.value += '6'">
					<INPUT TYPE="button" NAME="minus" VALUE="  -  " OnClick="Calc.Input.value += ' - '">
					<br>
					<INPUT TYPE="button" NAME="seven" VALUE="  7  " OnClick="Calc.Input.value += '7'">
					<INPUT TYPE="button" NAME="eight" VALUE="  8  " OnCLick="Calc.Input.value += '8'">
					<INPUT TYPE="button" NAME="nine"  VALUE="  9  " OnClick="Calc.Input.value += '9'">
					<INPUT TYPE="button" NAME="times" VALUE="  x  " OnClick="Calc.Input.value += ' * '">
					<br>
					<INPUT TYPE="button" NAME="clear" VALUE="  c  " OnClick="Calc.Input.value = ''">
					<INPUT TYPE="button" NAME="zero"  VALUE="  0  " OnClick="Calc.Input.value += '0'">
					<INPUT TYPE="button" NAME="DoIt"  VALUE="  =  " OnClick="Calc.Input.value = eval(Calc.Input.value)">
					<INPUT TYPE="button" NAME="div"   VALUE="  /  " OnClick="Calc.Input.value += ' / '">
					<br>
					</TD>
					</TR>
				</table>
			</FORM>
			</div>
		</div>
		
		
		<div class="panel panel-default" style="width: 250px; float: left;">
		  <!-- Default panel contents -->
		  <div class="panel-heading">Today<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
		  <div class="panel-body">
				<table class="table-responsive" style="width:100%; color:#333;">
					<tr>
						<td><div class="img-container"><img style="width:79px; height:79px;" src="<?php echo $this->session->userdata('pic_source');
							//echo base_url('assets/img/w_img/sun+rain.png');	
							?>" id="myimage">
							</div></td>
					   				   
						<td>
						
							<?php echo form_open($this->config->item('admin_folder').'/search/weather'); ?>
								<?php 
								$city = $this->session->userdata('city');
								$w_data = $this->session->userdata('w_data');
								$cur_temp_Celsius = $this->session->userdata('cur_temp_Celsius');
								
									if(!empty($city)){
										echo form_dropdown('city',$city_array,$city,$js_w);
									}
									else {
										echo form_dropdown('city',$city_array,'0',$js_w);
									}
								?>
								<input type='hidden' name='url' value='<?php echo $uri; ?>'>
					</form>
						<strong><?php echo date('H:m:s'); ?>, 
						<?php echo date('Y-m-d'); ?></strong><br>
						<?php echo lang('temperature'); ?>: <?php echo round($cur_temp_Celsius); ?>&deg;<br>
						<?php echo lang('humidity'); ?>: <?php echo $w_data['main']['humidity']; ?>&percnt;<br>
						<?php echo lang('wind_speed'); ?>: <?php echo $w_data['wind']['speed']; ?>km/h<br>
						Sky<?php //echo lang('weather'); ?>: <?php echo $w_data['weather'][0]['main']; ?>
						<?php //echo lang('weather_description'); ?><?php //echo $w_data['weather'][0]['description']; ?>
						</td>
					</tr>
				</table>
			</div>
			
		</div>

		<span id="sidebarhide1" class="expand pull-right" style="margin-bottom: 2px;" >Hide<span class="expand glyphicon glyphicon-resize-horizontal pull-right" style="color: #c9c9c9; margin: 2px;"></span></span>
		<span id="sidebarshow1" class="expand pull-right" style="margin-bottom: 2px; display: none;" >Show<span class="expand glyphicon glyphicon-resize-horizontal pull-right" style="color: #c9c9c9; margin: 2px;"></span></span>


	</div> <!-- sidebar end -->
 <!--/div-->
	<div id="view" class="container packery draggable" style="width: 100%; padding: 0px 10px 0px 270px;">
			<?php 
			if (!empty($no_result)){
				echo "<div class='status_box'>".$no_result."</div>";
			}
			?>
	<?php if(!empty($found_invoices)):?>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">
			<?php 
                if(count($found_invoices) > 1 ){
                    echo count($found_invoices).' '.lang('invoices');
                }
                else {
                    echo count($found_invoices).' '.lang('invoice');
                }
			?>
			<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
		</div>
			<div class="panel-body">
				<table class="table table-striped" style="border: 1px solid #ddd;">
					<thead>
						<tr>
							<th><?php echo lang('invoice_number') ?></th>
							<th><?php echo lang('order_number') ?></th>
							<th><?php echo lang('company') ?></th>
							<th>City<?php //echo lang('city') ?></th>
							<th>Postcode<?php //echo lang('zip') ?></th>
							<th>Country<?php //echo lang('country') ?></th>
							<th><?php echo lang('status') ?></th>
							<th><?php echo lang('date') ?></th>
						</tr>
					</thead>
                <tbody>
					<?php $invoice_status = array('0' => 'Open','1'=>'Closed'); ?>            
					<?php foreach ($found_invoices as $found_invoice):?>
								<tr>
									<td><a href="<?php echo site_url($this->config->item('admin_folder').'/invoices/view/'.$found_invoice['id']); ?>"><?php echo $found_invoice['invoice_number']; ?></a></td>
									<td><?php echo $found_invoice['order_number']; ?></td>
									<td><?php echo $found_invoice['company']; ?></td>
									<td><?php echo $found_invoice['city']; ?></td>
									<td><?php echo $found_invoice['zip']; ?></td>
									<td><?php echo $found_invoice['country']; ?></td>
									<td><?php echo $invoice_status[$found_invoice['fully_paid']]; ?></td>
									<td><?php echo $found_invoice['created_on']; ?></td>
								</tr>
					<?php endforeach; ?>
                </tbody>
            </table>
			</div>
				</div>
				<hr/>
        <?php endif;?>
	
	
        <?php if(!empty($found_products)): ?>
		<div class="panel panel-default" style="width: 100%; float: left;">
			<div class="panel-heading">
				<?php 
					if(count($found_products) > 1 ){
						echo count($found_products).' '.lang('products');
					}
					else {
						echo count($found_products).' '.lang('product');
					}
				?>
				<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
			<div class="panel-body">
				<table class="table table-striped" style="border: 1px solid #ddd;">
                <thead>
                    <tr>
                        <th><?php echo lang('product') ?></th>
                        <th>Type<?php //echo lang('brand') ?></th>
                        <th><?php echo lang('name') ?></th>
                        <th>Enabled<?php //echo lang('name') ?></th>
                        <th>Category<?php //echo lang('name') ?></th>
                        <th>Group<?php //echo lang('name') ?></th>
                 
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($found_products as $found_product):?>
                    <tr>
                        <td><a href="<?php echo site_url($this->config->item('admin_folder').'/products/form/'.$found_product['id']); ?>"><?php echo str_replace('/', '', $found_product['code']); ?></a></td>
                        <td><?php echo $found_product['type']; ?></td>
                        <td><?php echo $found_product['name']; ?></td>
                        <td><?php echo $enabled[$found_product['enabled']]; ?></td>
                        <td><?php echo $found_cats[$found_product['cat_id']]['name']; ?></td>
                        <td><?php echo $found_groups[$found_product['grp_id']]['name']; ?></td>
						<td><a class="btn btn-info btn-xs" style="width: 100%; margin-top: 2px; margin-bottom: 5px;"  href="<?php echo site_url($this->config->item('admin_folder').'/products/quick_view/'.$found_product['id']);?>"><?php echo lang('quick_view'); ?></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table></div></div><hr/>
        <?php endif;?>

	
	
	        <?php if(!empty($found_customers)): ?>
			<div class="panel panel-default" style="width: 100%; float: left;">
				<div class="panel-heading">
					<?php 
						if(count($found_customers) > 1 ){
							echo count($found_customers).' '.lang('customers');
						}
						else {
							echo count($found_customers).' '.lang('customer');
						}
					?>
					<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
				</div>
				<div class="panel-body">
				<table class="table table-striped" style="border: 1px solid #ddd;">
                <thead>
                    <tr>
                        <th><?php echo lang('company') ?></th>
                        <th>Customer number<?php //echo lang('customer_number') ?></th>
                        <th><?php echo lang('firstname') ?></th>
                        <th><?php echo lang('lastname') ?></th>
                        <th>Street<?php //echo lang('street') ?></th>
                        <th>City<?php //echo lang('city') ?></th>
                        <th>ZIP<?php //echo lang('city') ?></th>
                        <th>Country<?php //echo lang('country') ?></th>
                        <th><?php echo lang('email') ?></th>
                        <th><?php echo lang('phone') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($found_customers as $found_customer):?>
                   

                    <tr>
                        <td style="font-size: 12px; white-space: nowrap;"><a href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$found_customer['id']); ?>"><?php echo $found_customer['company']; ?></a></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['customer_number']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['firstname']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['lastname']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['STRAAT']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['PLAATS']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['POSTCODE']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['country']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><a href="mailto:<?php echo $found_customer['email_1']; ?>"><?php echo $found_customer['email_1']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['phone']; ?>&nbsp;<button type="submit" class="glyphicon glyphicon-phone" ></button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table></div></div><hr/>
            <?php endif;?>
	
		<?php if(!empty($found_customers_zip)): ?>
			<div class="panel panel-default" style="width: 100%; float: left;">
				<div class="panel-heading">
					<?php 
						if(count($found_customers_zip) > 1 ){
							echo count($found_customers_zip).' '.lang('customers');
						}
						else {
							echo count($found_customers_zip).' '.lang('customer');
						}
					?>
					<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
				</div>
				<div class="panel-body">
				<table class="table table-striped" style="border: 1px solid #ddd;">
                <thead>
                    <tr>
                        <th><?php echo lang('company') ?></th>
                        <th><?php echo lang('firstname') ?></th>
                        <th><?php echo lang('lastname') ?></th>
                        <th>Street<?php //echo lang('street') ?></th>
                        <th>City<?php //echo lang('city') ?></th>
                        <th>ZIP<?php //echo lang('city') ?></th>
                        <th>Country<?php //echo lang('country') ?></th>
                        <th><?php echo lang('email') ?></th>
                        <th><?php echo lang('phone') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($found_customers_zip as $found_customer):?>

                    <tr>
                        <td style="font-size: 12px; white-space: nowrap;"><a href="<?php echo site_url($this->config->item('admin_folder').'/customers/go_client/'.$found_customer['RELATIESNR']); ?>"><?php echo $found_customer['NAAM1']; ?></a></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['NAAM2']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['NAAM3']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['STRAAT']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['PLAATS']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['POSTCODE']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['LAND']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><a href="mailto:<?php echo $found_customer['email']; ?>"><?php echo $found_customer['email']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['phone']; ?>&nbsp;<button type="submit" class="glyphicon glyphicon-phone" ></button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table></div></div><hr/>
            <?php endif;?>
			
	    <?php if(!empty($found_orders)): ?>
			<div class="panel panel-default" style="width: 100%; float: left;">
				<div class="panel-heading">
					<?php 
						if(count($found_orders) > 1 ){
							echo count($found_orders).' '.lang('orders');
						}
						else {
							echo count($found_orders).' '.lang('order');
						}
					?>
					<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
				</div>
				<div class="panel-body">
				<table class="table table-striped" style="border: 1px solid #ddd;">
                <thead>
                    <tr>
                        <th><?php echo lang('order_number') ?></th>
                        <th><?php echo lang('company') ?></th>
                        <th><?php echo lang('agent') ?></th>
                        <th><?php echo lang('status') ?></th>
                        <th><?php echo lang('date') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($found_orders as $found_order):?>
                    <tr>
                        <td><a href="<?php echo site_url($this->config->item('admin_folder').'/orders/view/'.$found_order['id']); ?>"><?php echo $found_order['order_number']; ?></a></td>
                        <td><?php echo $found_order['company']; ?></td>
                        <td><?php echo $found_order['entered_by']; ?></td>
                        <td><?php echo $found_order['status']; ?></td>
                        <td><?php echo $found_order['ordered_on']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table></div></div><hr/>
            <?php endif;?>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		<?php include('search_results.php'); ?>

		<?php //if(!empty($page_title)):?>
		<!--div class="page-header">
			<h4><?php //echo  $page_title; ?></h4>
		</div-->
		<?php //endif;?>
    
    
    
