<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>VarnaMed<?php echo (isset($page_title))?' :: '.$page_title:''; ?></title>
<link rel="shortcut icon" href="<?php echo base_url('assets/favicon(1).ico'); ?>">
<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php //echo base_url('assets/css/bootstrap-responsive.min.css');?>" rel="stylesheet" type="text/css" />
<link type="text/css" href="<?php echo base_url('assets/css/jquery-ui.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('assets/css/redactor.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('assets/css/file-browser.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('assets/css/agstyle.css');?>" rel="stylesheet" />
<?php
	$c_shop = $this->session->userdata('shop');
    
	if(empty($c_shop)){
      ?><link type="text/css" href="<?php echo base_url('assets/css/master.css');?>" rel="stylesheet" /><?php
    }
    if($c_shop == '1'){
      ?><link type="text/css" href="<?php echo base_url('assets/css/master-pink.css');?>" rel="stylesheet" /><?php
    }
    if($c_shop == '2'){
      ?><link type="text/css" href="<?php echo base_url('assets/css/master-blue.css');?>" rel="stylesheet" /><?php
    }
	if($c_shop == '3'){
      ?><link type="text/css" href="<?php echo base_url('assets/css/master-green.css');?>" rel="stylesheet" /><?php
    }
?>
<link type="text/css" href="<?php echo base_url('assets/css/jquery.datepick.css');?>" rel="stylesheet" />


<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/redactor.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/file-browser.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/coda.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.listen-1.0.3.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.datepick.pack.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/coda.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/aprofit.js');?>"></script>

<?php //if($this->auth->is_logged_in(false, false)):?>
	
<style type="text/css">
	body {
		margin-top:50px;
	}
	
	@media (max-width: 979px){ 
		body {
			margin-top:0px;
		}
	}
	@media (min-width: 980px) {
		.nav-collapse.collapse {
			height: auto !important;
			overflow: visible !important;
		}
	 }
	
	.nav-tabs li a {
		text-transform:uppercase;
		background-color:#f2f2f2;
		border-bottom:1px solid #ddd;
		text-shadow: 0px 1px 0px #fff;
		filter: dropshadow(color=#fff, offx=0, offy=1);
		font-size:12px;
		padding:5px 8px;
	}
	
	.nav-tabs li a:hover {
		border:1px solid #ddd;
		text-shadow: 0px 1px 0px #fff;
		filter: dropshadow(color=#fff, offx=0, offy=1);
	}

</style>
<script type="text/javascript">
$(document).ready(function(){
	$('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('.redactor').redactor({
		focus: true,
		plugins: ['fileBrowser']
	});
});
</script>
<?php //endif;?>
</head>
<body>

<?php if(!empty($c_shop)): ?>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-b ar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<?php $admin_url = site_url($this->config->item('admin_folder')).'/';?>

			<div class="nav-collapse">
				<ul class="nav">

					<?php
					// Restrict access to Admins only
					//if($this->auth->check_access('Admin')) : ?>
                                    <li><?php echo anchor($this->config->item('admin_folder').'/dashboard', $this->session->userdata('ba_username')); ?></li>

                                    
                                        <!-- START PRODUCTS  -->
					<li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('dash_products') ?> <b class="caret"></b></a>
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
                                                          if(!empty($products)){
                                                          echo anchor($this->config->item('admin_folder').'/products', lang('dash_product_list')); 
                                                          }
                                                          ?>
                                                      </li>
                                                       <?php //echo anchor($this->config->item('admin_folder').'/digital_products', lang('dash_digital_products')); ?>
						</ul>
					</li>
					<!-- END PRODUCTS  -->

                                        <!-- START CUSTOMERS  -->    
                                        <li class="dropdown">
                                             <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('dash_customers') ?> <b class="caret"></b></a>
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
                                        
                                        <!-- START ORDERS  -->    
                                        <li class="dropdown">
                                             <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('dash_all_orders') ?> <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/orders', lang('dash_orders')); ?></li>
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/orders/processed_orders', lang('processed_orders')); ?></li>
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/orders/orders_to_ship', lang('orders_for_ship')); ?></li>
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/orders/all_orders', lang('all_orders')); ?></li>
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/orders/new_shippments', lang('new_shippments')); ?></li>
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/orders/old_shippments', lang('old_shippments')); ?></li>
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/orders/backorder', lang('backorder')); ?></li>
						</ul>
                                        </li>
                                        <!-- END ORDERS  --> 
                                        <!-- START PURCHASE  -->    
                                        <li class="dropdown">
                                             <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('dash_stock') ?> <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/suppliers', lang('dash_suppliers')); ?></a></li>
														<li><?php echo anchor($this->config->item('admin_folder').'/offer', lang('dash_offer')); ?></li>
                                                         <li><?php echo anchor($this->config->item('admin_folder').'/stock', lang('dash_stock_orders')); ?></li>
                                                         <li><?php echo anchor($this->config->item('admin_folder').'/stock/delivered', lang('stock_delievered_orders')); ?></li>
                                                         <li><?php echo anchor($this->config->item('admin_folder').'/stock/cancelled', lang('stock_cancelled_orders')); ?></li>
                                                         <li><?php echo anchor($this->config->item('admin_folder').'/stock/on_hold', lang('stock_on_hold_orders')); ?></li>
                                                         <li><?php echo anchor($this->config->item('admin_folder').'/stock/closed_orders', lang('closed_orders')); ?></li>
                                                         <li><?php echo anchor($this->config->item('admin_folder').'/stock/warehouse_stock', lang('stock_operations')); ?></li>
                                                         <li><?php echo anchor($this->config->item('admin_folder').'/stock/reservations', lang('dash_reservations')); ?></li>
                                                         <li><?php echo anchor($this->config->item('admin_folder').'/stock/discarded_list', lang('discarded')); ?></li>
						</ul>
                                        </li>
                                        <!-- END PURCHASE  --> 

                                        
                                        <!-- START INVOICES  -->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('dash_invoices') ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php //if($this->auth->check_access('Admin')) : ?>
							<li><?php echo anchor($this->config->item('admin_folder').'/invoices', lang('dash_open_invoices')); ?></li>
							<li><?php echo anchor($this->config->item('admin_folder').'/invoices/invoices_print', lang('dash_open_invoices_print')); ?></li>
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/invoices/invoice_list', lang('dash_invoice_list')); ?></li>
							<li><?php echo anchor($this->config->item('admin_folder').'/invoices/sent_invoices', lang('dash_sent_invoices')); ?></li>
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/cnotes/', 'Credit note(Gutschrift)'); ?></li>
							<li><?php echo anchor($this->config->item('admin_folder').'/invoices/reminders', lang('dash_reminders')); ?></li>
							<?php //endif; ?>
						</ul>
					</li>
                                        
                                        <!-- END INVOICES  -->
                                        
                                        <!-- START OVERVIEW  -->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('dash_overview') ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php if($this->bitauth->is_admin()) : ?>

                                                     <!--   <li><?php //echo anchor($this->config->item('admin_folder').'/stock/status', lang('dash_ship_status')); ?></li> -->

														<li><?php echo anchor($this->config->item('admin_folder').'/overview', lang('dash_overview_per_client')); ?></li>
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/overview/to_do_list_client', lang('dash_overview_todo_list_pro_client')); ?></li>
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/overview/to_do_list_agent', 'To do per agent'); ?></li>
														<li><?php echo anchor($this->config->item('admin_folder').'/overview/debtors', lang('dash_overview_debtors')); ?></li>
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/overview/web_orders', lang('dash_overview_web_orders')); ?></li>
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/overview/sales', lang('dash_overview_sales')); ?></li>
                                                        <li><?php echo anchor($this->config->item('admin_folder').'/overview/profit_per_agent', lang('agent_profit')); ?></li>

                                                        <li><?php echo anchor($this->config->item('admin_folder').'/overview', lang('dash_overview_callcenter')); ?></li>
							<?php endif; ?>
						</ul>
					</li>
                                        <!-- END OVERVIEW  -->
                                        

                                        
                                        <!-- START MARKETING  
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php //echo lang('dash_marketing') ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php //if($this->auth->check_access('Admin')) : ?>
							<li><a href="<?php //echo $admin_url;?>marketing/"><?php //echo lang('common_marketing_statistics') ?></a></li>
							<?php //endif; ?>
						</ul>
					</li>
                                        END MARKETING  -->
                                <?php         if($this->bitauth->is_admin()): ?>

                                        <!-- START ADMINISTRATIVE  -->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('dash_administrative') ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
														<li><?php echo anchor($this->config->item('admin_folder').'/admin', lang('dash_admin')); ?></li>
														<li><?php echo anchor($this->config->item('admin_folder').'/shops', lang('dash_shops')); ?></li>
														<li><?php echo anchor($this->config->item('admin_folder').'/settings', lang('dash_settings')); ?></li>
														<li><?php echo anchor($this->config->item('admin_folder').'/locations', lang('dash_locations')); ?></li>
														<li><a href="<?php echo $admin_url;?>banners"><?php echo lang('common_banners') ?></a></li>
														<li><a href="<?php echo $admin_url;?>boxes"><?php echo lang('common_boxes') ?></a></li>
														<li><a href="<?php echo $admin_url;?>pages"><?php echo lang('common_pages') ?></a></li>
                                                        <li><a href="<?php echo $admin_url;?>banners"><?php echo lang('common_branches') ?></a></li>
                                                        <li><a href="<?php echo $admin_url;?>banners"><?php echo lang('common_homepage') ?></a></li>
                                                        <li><a href="<?php echo $admin_url;?>banners"><?php echo lang('common_webshop_content') ?></a></li>
                                                        <li><a href="<?php echo $admin_url;?>banners"><?php echo lang('common_product_devision') ?></a></li>
                                                        <li><a href="<?php echo $admin_url;?>banners"><?php echo lang('common_exchange') ?></a></li>
                                                        <li><a href="<?php echo $admin_url;?>banners"><?php echo lang('common_test_classification') ?></a></li>
														<li><?php echo anchor($this->config->item('admin_folder').'/admin/downloads', lang('dash_downloads')); ?></li> 

						</ul>
					</li>
					<?php endif; ?>
                                        <!-- END ADMINISTRATIVE  -->
					<?php //endif; ?>
                                        
				</ul>
				<ul class="nav pull-right">
	<li><?php 
                                                        echo anchor($this->config->item('admin_folder').'/admin/logout', lang('dash_logout'), 'style="float: right;"'); 
                                                        ?></li>
				</ul>

			</div><!-- /.nav-collapse -->
		</div>
	</div><!-- /navbar-inner -->
</div>
<?php endif; ?>

<div class="container">


	<?php $found_invoices =  $this->session->flashdata('found_invoices'); ?>
	<?php $found_products =  $this->session->flashdata('found_products'); ?>
        <?php $found_cats =  $this->session->flashdata('c_categories'); ?>
	<?php $found_customers =  $this->session->flashdata('found_customers'); ?>
	<?php $found_orders =  		$this->session->flashdata('found_orders'); ?>

       <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        <?php if(!empty($found_invoices)):?>
            <div class="alert alert-info">
                <?php 
                if(count($found_invoices) > 1 ){
                    echo count($found_invoices).' '.lang('invoices');
                }
                else {
                    echo count($found_invoices).' '.lang('invoice');
                }
                ?>
            </div>
            <table class="table table-condensed">
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
            </table><hr/>
        <?php endif;?>

        <?php if(!empty($found_products)): ?>
            <div class="alert alert-info">
                <?php 
                if(count($found_products) > 1 ){
                    echo count($found_products).' '.lang('products');
                }
                else {
                    echo count($found_products).' '.lang('product');
                }
                $enabled = array('0'=>'Disabled','1'=>'Enabled');
                //echo '<pre>';
                //print_r($found_cats['11']['name']);
                //echo '</pre>';
                ?>
            </div>
            <table class="table table-condensed">
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
                        <td><?php echo $found_cats[$found_product['grp_id']]['name']; ?></td>
       
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table><hr/>
        <?php endif;?>

            
        <?php if(!empty($found_customers)): ?>
            <div class="alert alert-info">
                <?php 
                if(count($found_customers) > 1 ){
                    echo count($found_customers).' '.lang('customers');
                }
                else {
                    echo count($found_customers).' '.lang('customer');
                }
                ?>
            </div>
            <table class="table table-condensed">
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
                        <th><?php echo lang('fax') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($found_customers as $found_customer):?>
                   

                    <tr>
                        <td style="font-size: 12px; white-space: nowrap;"><a href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$found_customer['id']); ?>"><?php echo $found_customer['company']; ?></a></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['firstname']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['lastname']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['STRAAT']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['PLAATS']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['POSTCODE']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['country']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><a href="mailto:<?php echo $found_customer['email_1']; ?>"><?php echo $found_customer['email_1']; ?></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['phone']; ?>&nbsp;<button class="btn btn-info btn-mini"><?php echo lang('call'); ?></button></td>
                        <td style="font-size: 12px; white-space: nowrap;"><?php echo $found_customer['fax']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table><hr/>
            <?php endif;?>

    <?php if(!empty($found_orders)): ?>
            <div class="alert alert-info">
                <?php 
                if(count($found_orders) > 1 ){
				//lang('search_returned').' '.
                    echo count($found_orders).' '.lang('orders');
                }
                else {
                    echo count($found_orders).' '.lang('order');
                }
                ?>
            </div>
            <table class="table table-condensed">
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
            </table><hr/>
            <?php endif;?>
            

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<div class="container">
	<?php if(!empty($page_title)):?>
	<div class="page-header">
		<h4><?php echo  $page_title; ?></h4>
	</div>
	<?php endif;?>
<BR><BR><BR><BR>
 <?php $languages = array('0'=>'Select language','english'=>'English','german'=>'Deutsch','french'=>'Francais','dutch'=>'Nederlands','bulgarian'=>'Bulgarian'); ?>
    
 <?php $the_shops = array(
						'0'=>'Select shop',
						1 => 'Comforties', 
						2 =>'Dutchblue',
						3 =>'Glovers'
						); 
	?>
 
 
             <div class="form-horizontal">
                <?php $uri = str_replace('/admin/', '', $this->uri->uri_string()); ?>
                    <?php echo form_open($this->config->item('admin_folder').'/search', 'class="form-inline" style="float:right"');?>
                        <fieldset>
                            <div class="control-group warning">
                                <input type="text" class="span3" name="search_term_invoices" placeholder="<?php echo lang('search_term').' for invoices';?>" /><br><br>
                                <input type="text" class="span3" name="search_term_products" placeholder="<?php echo lang('search_term').' for products';?>" /><br><br>
				<input type="text" class="span3" name="search_term_customers" placeholder="<?php echo lang('search_term').' for customers';?>" /><br><br>
				<input type="text" class="span3" name="search_term_orders" placeholder="<?php echo lang('search_term').' for orders';?>" /><br><br>						
                                <button class="btn btn-success" name="submit" value="search"><?php echo lang('search')?></button>
                                <a class="btn btn-danger" href="<?php echo site_url($this->config->item('admin_folder').'/'.$uri);?>">Reset</a>
                                <input type='hidden' name='url' value='<?php echo $uri; ?>'>
                            </div>
                        </fieldset>
                    </form>
            </div>
 
 <?php $uri = str_replace('/admin/', '', $this->uri->uri_string()); ?>
 
 <?php echo form_open($this->config->item('admin_folder').'/languages/lang/');?>
    <?php $js = 'id="language" onChange="this.form.submit();"'; ?>
            <?php 

            if(!empty($this->language)){
                echo form_dropdown('language',$languages,$this->language,$js);
            }
            else {
                echo form_dropdown('language',$languages,'0',$js);
            }

            ?>        
			
    </form>
<?php echo form_open($this->config->item('admin_folder').'/shops/shop/'.$);?>
    <?php 
	$js = 'id="shop" onChange="this.form.submit();"'; 
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
    </form>

    
    
    
    
    
    
    
