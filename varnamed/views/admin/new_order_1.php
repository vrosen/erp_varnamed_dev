<?php include('header.php'); ?>
<?php
if($this->data_shop == 1){	
$order_type_array = array(
    'instant_delivery'  => 'Sofort Lieferung',
    'Fixtermin'           => 'Fixtermin',
    'direct_delivery'   => 'Direct delivery',
    'Komplettlieferung' => 'Komplettlieferung',
    'Miete'              => 'Miete',
    'Rezept'            => 'Rezept',
    'Probe Lieferung'   => 'Probe Lieferung',
    'Mietkauf'       => 'Mietkauf',
);

}
if($this->data_shop == 2){
$order_type_array = array(

    'instant_delivery'  => 'Sofort Lieferung',
    'Fixtermin'           => 'Fixtermin',
    'direct_delivery'   => 'Direct delivery',
    'Komplettlieferung' => 'Komplettlieferung',
    'Miete'              => 'Miete',
    'Rezept'            => 'Rezept',
    'Probe Lieferung'   => 'Probe Lieferung',
    'Mietkauf'       => 'Mietkauf',
);

}
if($this->data_shop == 3){
$order_type_array = array(
    '0'                 => 'Select order type',
    'instant_delivery'  => 'Instant delivery',
    'fixdate'           => 'Fixdate',
    'direct_delivery'   => 'Direct delivery',
    'complete_delivery' => 'Complete delivery',
    'rent'              => 'Rent',
    'recipe'            => 'Recipe',
    'sample_delivery'   => 'Sample delivery',
    'rent_to_own'       => 'Rent to own',
);

}
$date = array(
   'id' => 'date',
    'name' => 'date',
    'type' => 'text',
    'placeholder' => 'Date',
    
);
$delivery_condition_array = array(
    

    '1'         => 'Verzendkosten gratis',
    '2'         => 'Verzendkosten berekenen',
);
$dispatch_method_array = array(
    'Selbstauslieferung'  => 'Selbstauslieferung',
    'Spedition'  => 'Parcel sevice',
    'miscellaneous'  => 'miscellaneous',
);
if($current_shop == 1){
    $warehouse_array = array(

    3            => 'Combiwerk(Delft)',
   2             => 'Transoflex(Frechen)',
);
}
if($current_shop == 2){
    $warehouse_array = array(

    3             => 'Dutchblue(Delft)',
    2             => 'Transoflex(Frechen)',
);
}
if($current_shop == 1){
    $payment_method_array = array(
                
    '0'                         => lang('select_payment_method'),
    '1'     => lang('invoice_upon_delivery'),
    '2'              => lang('direct_debit'),
    '3'           => lang('paid_in_advance'),
    '4'                     => lang('iDEAL'),
    '6'          => lang('American_Express'),
    '7'                => lang('MasterCard'),
    '8'                      => lang('VISA'),
    '9'     => lang('instant_wire_transfer'),
    '10'                   => lang('Giropay'),
    '11'                       => lang('EPS'),
    '12'                    => lang('PAYPAL'),
    '5'      => lang('free_sample_delivery'),
    '13'  => lang('comforties_com_BV_account'),//set the shop variable
    '14'                 => lang('by_cheque'), 
);
}
if($current_shop == 2){
    $payment_method_array = array(
                
    '0'                         => lang('select_payment_method'),
    '1'     => lang('invoice_upon_delivery'),
    '2'              => lang('direct_debit'),
    '3'           => lang('paid_in_advance'),
    '4'                     => lang('iDEAL'),
    '6'          => lang('American_Express'),
    '7'                => lang('MasterCard'),
    '8'                      => lang('VISA'),
    '9'     => lang('instant_wire_transfer'),
    '10'                   => lang('Giropay'),
    '11'                       => lang('EPS'),
    '12'                    => lang('PAYPAL'),
    '5'      => lang('free_sample_delivery'),
    '13'  => lang('dutchblue_com_BV_account'),//set the shop variable
    '14'                 => lang('by_cheque'), 
);
}
$payment_condition_array = array(
                    
    '0'                                         => lang('set_condition'),
    '4'             => lang('immediately_without_deduction'),
    '3'                  => lang('8_days_without_deduction'),
    '1'                 => lang('30_days_without_deduction'),
    '5'                 => lang('42_days_without_deduction'),
);

$currency_array = array(
    
    'EUR'   => 'EUR',
    'USD'   => 'USD'
    
);

		$product_missing = $this->session->flashdata('product_missing');
		if(!empty($product_missing)){
			echo '<h3>'.$product_missing.'</h3>';
	}
		

?>

<style>
input[type=text] {
	width: 100px;
}
.form-control { width: 100% !important; }
</style>



    <?php echo form_open($this->config->item('admin_folder').'/orders/proceed_order/'.$id); ?>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo lang('order_details'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped" style="border: 1px solid #ddd;">
					<tr>
					<td><?php echo lang('order_number');?></td>
						<td><input style="width: 25%" type="text" name="order_number" value="<?php echo $order_number; ?>" placeholder="Order number" required /></td>
					</tr>
                            <tr>
								<td><?php echo lang('customer');?></td>
								<td><?php echo $customer_number; ?>&nbsp;<a href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$id); ?>"><?php echo $company;?></a></td>
								<input type="hidden" name="customer_nr" id="customer_nr" value="<?php echo $customer_nr; ?>">
								<input type="hidden" name="customer_number"  value="<?php echo $customer_number; ?>">
								
                            </tr>
                            <tr>
                            <tr>
									<td><?php echo lang('order_type');?></td>
									<td>
										<select name="order_type" id="order_type" style="width: 25%;">
										<?php 
										if(!empty($order_type)){
										?><option name="default" elected="selected" value="<?php echo $order_type; ?>"><?php echo $order_type_array[$order_type]; ?></option><?php
										}
										?>
												<option name="default" value="instant_delivery">Instant delivery</option>
												<option name="fixdate" value="fixdate">Fixdate</option>
												<option name="direct_delivery" value="direct_delivery">Direct delivery</option>
												<option name="complete_delivery" value="complete_delivery">Complete delivery</option>
												<option name="rent" value="rent">Rent</option>
												<option name="recipe" value="recipe">Recipe</option>
												<option name="sample_delivery" value="sample_delivery">Sample delivery</option>
												<option name="rent_to_own" value="rent_to_own">Rent to own</option>
										</select>
										<input id="row_dim" name="order_date" class="datepicker" value="" type="text" placeholder="Date of Fixtermin" style="margin: 2px 0 2px 30px; border: 0.5px solid #cacaca; padding: 1px 5px;"/>										
									</td>	
								<script>
								$(function() {
									$('#row_dim').hide(); 
									$('#order_type').change(function(){
										if($('#order_type').val() == 'fixdate') {
											$('#row_dim').show(); 
										} else {
											$('#row_dim').hide(); 
										} 
									});
								});
								$(function() {
										if($('#order_type').val() == 'fixdate') {
											$('#row_dim').show(); 
										} 
								});
								</script>
								
                            </tr>
                            </tr>
                            <tr>
								<td><?php echo lang('delivery_condition');?></td>
								<td><?php echo form_dropdown('delivery_condition',$delivery_condition_array,$delivery_condition,'style="width: 25%;"'); ?></td>
                            </tr>
                            <tr>
								<td><?php echo lang('dispatch_method');?></td>
								<td><?php echo form_dropdown('dispatch_method',$dispatch_method_array,$dispatch_method,'style="width: 25%;"'); ?></td>
                            </tr>
                            <tr>
								<td><?php echo lang('warehouse');?></td>
								<td><?php echo form_dropdown('warehouse',$warehouse_array,$warehouse,'style="width: 25%;"'); ?></td>
                            </tr>
                            <tr>
								<td><?php echo lang('weight');?></td>
								<td><?php echo form_input(array('name' => 'weight','type' => 'text', 'id' => 'weight', 'value' => $weight,'style'=>'width: 25%;')); ?></td>
                            </tr>
                            <tr>
								<td><?php echo lang('payment_method');?></td>
								<td><?php echo form_dropdown('payment_method',$payment_method_array,$payment_method,'style="width: 25%;"'); ?></td>
                            </tr>
                            <tr>
								<td><?php echo lang('payment_condition');?></td>
								<td><?php echo form_dropdown('payment_condition',$payment_condition_array,$payment_condition,'style="width: 25%;"'); ?></td>
                            </tr>
                            <tr>
								<td><?php echo lang('none_VAT');?></td>
								<?php 
								if($none_VAT == 1){
									 $none_VAT = array(  'name' => 'none_VAT','id' => 'none_VAT','value' => '1','checked' => TRUE,'style'=> 'margin:10px'); 
								}
								else {
									$none_VAT = array(  'name' => 'none_VAT','id' => 'none_VAT','value' => '0','checked' => FALSE,'style'=> 'margin:10px'); 
								}
								   
								?>
								<td><?php echo form_checkbox($none_VAT); ?></td>
                            </tr>
							<tr>
								<td><strong><?php echo lang('not_remind');?></strong></td>
								<?php 
								if($not_remind == 0){
								$not_remind = array(  'name' => 'not_remind','id' => 'not_remind','value' => '0','checked' => false,'style'=> 'margin:10px'); ?>
								<td><?php echo form_checkbox($not_remind); ?></td> <?php
								}
								else {
								$not_remind = array(  'name' => 'not_remind','id' => 'not_remind','value' => '1','checked' => TRUE,'style'=> 'margin:10px'); ?>
								<td><?php echo form_checkbox($not_remind); ?></td><?php
								}
								?>
							</tr>
							<tr>
								<td><?php echo lang('invoice_per_email');?></td>
								<?php 
								if($invoice_per_email == 1){
									 $invoice_per_email = array(  'name' => 'invoice_per_email','id' => 'invoice_per_email','value' => '1','checked' => TRUE,'style'=> 'margin:10px; '); 
								}
								else {
									$invoice_per_email = array(  'name' => 'invoice_per_email','id' => 'invoice_per_email','value' => '0','checked' => FALSE,'style'=> 'margin:10px;'); 
								}
								?>
								<td><?php echo form_checkbox($invoice_per_email); ?></td>
                            </tr>
                            <tr>
								<td><?php echo lang('email_adresse');?></td>
                              <?php $email_address = array(  'name' => 'email','id' => 'email','type'=> 'text','value' => set_value('email',$email),'style'=>'width: 25%;'); ?>
								<td><?php echo form_input($email_address); ?></td>
                            </tr>
                            <tr>
								<td><?php echo lang('currency');?></td>
								<td><?php echo form_dropdown('currency',$currency_array,$currency,'class="span2"'); ?></td>
                            </tr>
                            <tr>
								<td><?php echo lang('order_entry');?></td>
								<td><?php echo $current_user; ?></td>
                            </tr>
                            <tr>
								<td><?php echo lang('order_date');?></td>
                                <?php $date = array(  'name' => 'order_date','class' => 'datepicker','type'=> 'text','value' => set_value('order_date',$order_date),'style'=>'width: 25%;'); ?>
								<td><?php echo form_input($date); ?></td>
                            </tr>
                    </table>
                    </div>
            </div>


    <?php 
        if(!empty($backorder_products)){
            
            ?>
            <div class="alert alert-block">
            <a class="close" href="#" data-dismiss="alert">×</a>
            <h4 class="alert-heading">Warning!</h4>
            <?php foreach ($backorder_products as $back){
                 echo 'For product '.'<strong>'.$back['code'].'</strong>'.' there are '.'<strong>'.$back['backorder_quantity'].'</strong>'.' products missing. '.'<br>'; 
            }
            ?><input type='hidden' value='<?php echo serialize($backorder_products); ?>' name='backorder_products'><?php
            ?>
            <strong>If you choose to continue, this order will be sent into the backorder's list.</strong>
            </div>
            <?php
        }
    ?>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">Ordered products<?php //echo lang('invoice_details'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table id="myTable" class="table table-hover">
					<button id="addrow" class="glyphicon glyphicon-plus" ></button>
						<thead>
							<tr>
											<!--<th><button type="submit" class="btn btn-small btn-danger"><i class="icon-trash icon-white"></i></button></th>-->
											<th  style="font-size: 12px;">Article no.<?php //echo lang('product_nr');?></th>
											<th style="font-size: 12px;">Number<?php //echo lang('quantity');?></th>
											<th style="font-size: 12px;">Number VPA<?php //echo lang('num_vpe');?></th>
											<th style="font-size: 12px;">VK<?php //echo lang('price').'&nbsp'.$saleprice_index;?></th>
											<th style="font-size: 12px;">Discount %<strong><?php // echo lang('discount');?></strong></th>
											<th style="font-size: 12px;"><?php echo lang('unit_price');?></th>
											<th style="font-size: 12px;"><?php echo lang('total');?></th>
											<th  style="font-size: 12px;">Article VAT.<?php //echo lang('product_nr');?></th>
											<?php if($this->bitauth->is_admin()): ?>
											<th style="font-size: 12px;">WHPrice <?php //echo lang('buying_price');?></th>
											<th style="font-size: 12px;">margin %<?php //echo lang('margin'); ?></th>
											<?php endif; ?>
											<th style="font-size: 12px;"><?php echo lang('available_stock'); ?></th>
											<th style="font-size: 12px;"><?php echo lang('description');?></th>
							</tr>
						</thead>
        <tbody>
		
<?php foreach ($product_array as $product): ?>

				
				<tr>
					<!--<td><input name="product[]" type="checkbox" value="<?php // echo $product['id']; ?>" class="gc_check" /></td>-->
					<input name="product[]" type="hidden" value="<?php echo $product['id']; ?>" >

					<td  style="font-size: 12px; white-space: nowrap; "><input name="product_number[]" type="hidden" value="<?php echo $product['code']; ?>" /><?php echo str_replace('/','',$product['code']); ?></td>
					<td style="font-size: 12px; white-space: nowrap; "><input name="number[]" type="text" value="<?php echo $product['ordered_quantity']; ?>" /></td>
            
					<td style="font-size: 12px; white-space: nowrap;"><input name="vpa[]" type="hidden" value="<?php echo $product['package_details']; ?>" /><?php echo $product['package_details']; ?></td>
            
					<?php  echo '<td style="font-size: 12px; white-space: nowrap;">'.form_input(array('name' => 'vk[]','value'=> $product['saleprice'])).'</td>'; //price  ?>
					
                    <?php 
					//CASE 1 
					if(!$product['discount'] > 0  and $product['unit_price'] > 0 ){
					echo '777';
						$diff = ($product['saleprice'] - $product['unit_price'])/$product['saleprice']*100;
						echo  '<td style="font-size: 12px; white-space: nowrap;">'.form_input(array('name'=>'discount[]','value' => round($diff,2))).'</td>';
						echo  '<td style="font-size: 12px; white-space: nowrap;">'.form_input(array('name'=>'unit_price[]','value' => round($product['unit_price'],2))).'</td>';
						echo  '<td style="font-size: 12px; white-space: nowrap;">'.form_input(array('name' => 'total[]','value'=> round($product['unit_price']*$product['ordered_quantity'],2))).'</td>'; 
						?>
							<td>
								<?php
										$totalprice = round($product['unit_price']*$product['ordered_quantity'],2);
										
										if(!empty($product[$product_vat])){
											
											?><input name="vat_index_item[]" type="hidden" value="<?php echo $product[$product_vat]; ?>"><?php
											?><input name="vat_rate_item[]" type="hidden" value="<?php echo round($totalprice*($product[$product_vat]/100),2); ?>"><?php

											if($product[$product_vat] == str_replace('.00','',$vat_index)){

												$n_vat[] 		= round($totalprice*($product[$product_vat]/100),2);
												$n_index 		= $product[$product_vat];
												?><input name="special_vat[]" type="hidden" value="<?php echo '0'; ?>"><?php
											}

											if($product[$product_vat] != str_replace('.00','',$vat_index)){
												$d_vat[]	= round($totalprice*($product[$product_vat]/100),2);
												$d_vat_1 	= round($totalprice*($product[$product_vat]/100),2);
												$d_index 	= $product[$product_vat];
												$d_code[] 	= array('code'=>$product['code'],'vat_ammount'=>$d_vat_1,'vat_index'=>$d_index);
												?><input name="special_vat[]" type="hidden" value="<?php echo '1'; ?>"><?php
											}

											echo round($totalprice*($product[$product_vat]/100),2);
										}else {
											?><input name="vat_index_item[]" type="hidden" value="<?php echo $vat_index; ?>"><?php
											?><input name="vat_rate_item[]" type="hidden" value="<?php echo round($totalprice*($vat_index/100),2); ?>"><?php
											echo round($totalprice*($vat_index/100),2);
										}
								?>
							</td>
						<?php
						if($this->bitauth->is_admin()){
						echo  '<td style="font-size: 12px; white-space: nowrap;">'.form_input(array('name' => 'warehouse_price[]','type' => 'text','value'=> $product['warehouse_price'])).'</td>'; 
						$diff_price = $product['unit_price']-$product['warehouse_price'];
						echo '<td style="font-size: 12px; white-space: nowrap;">'.form_input(array('name' => 'margin[]','value'=> round((($diff_price/$product['unit_price'])*100),2))).'</td>'; 
						$total_margin[] = round((($diff_price/$product['unit_price'])*100),2);
						}
						else {
						  '<td style="font-size: 12px; white-space: nowrap;">'.form_input(array('name' => 'warehouse_price[]','type' => 'hidden','value'=> $product['warehouse_price'])).'</td>'; 
						$diff_price = $product['unit_price']-$product['warehouse_price'];
						 '<td style="font-size: 12px; white-space: nowrap;">'.form_input(array('name' => 'margin[]','value'=> round((($diff_price/$product['unit_price'])*100),2))).'</td>'; 
						$total_margin[] = round((($diff_price/$product['unit_price'])*100),2);
						}
						
						
						$total_price[] = $product['unit_price']*$product['ordered_quantity'];
						?><td style="font-size: 12px; white-space: nowrap;"><input name="available_stock[]" type="hidden" value="<?php echo $product['current_quantity']; ?>" /><?php echo $product['current_quantity']; ?></td><?php
						?><td style="font-size: 10px;"><input name="description[]" type="hidden" value="<?php echo $product[$name]; ?>" /><?php echo $product[$name]; ?></td><?php
                                                  echo '<td><button id="ibtnDel" class="glyphicon glyphicon-trash"  ></button></td>';
                    }
					//CASE 2
					if($product['discount'] > 0  and !$product['unit_price'] > 0 ){
					echo '777-2';
						echo  '<td>'.form_input(array('name'=>'discount[]','value' => $product['discount'])).'</td>';
						$percent = $product['saleprice']*($product['discount']/100);
						$unit_price = $product['saleprice']-$percent;
						echo  '<td>'.form_input(array('name'=>'unit_price[]','value' => round($unit_price,2))).'</td>';
						echo  '<td>'.form_input(array('name' => 'total[]','value'=> round($unit_price*$product['ordered_quantity'],2))).'</td>'; 
						?>
							<td>
								<?php
										$totalprice = round($unit_price*$product['ordered_quantity'],2);
										
										if(!empty($product[$product_vat])){
											
											?><input name="vat_index_item[]" type="hidden" value="<?php echo $product[$product_vat]; ?>"><?php
											?><input name="vat_rate_item[]" type="hidden" value="<?php echo round($totalprice*($product[$product_vat]/100),2); ?>"><?php

											if($product[$product_vat] == str_replace('.00','',$vat_index)){

												$n_vat[] 		= round($totalprice*($product[$product_vat]/100),2);
												$n_index 		= $product[$product_vat];
												?><input name="special_vat[]" type="hidden" value="<?php echo '0'; ?>"><?php
											}

											if($product[$product_vat] != str_replace('.00','',$vat_index)){
												$d_vat[]	= round($totalprice*($product[$product_vat]/100),2);
												$d_vat_1 	= round($totalprice*($product[$product_vat]/100),2);
												$d_index 	= $product[$product_vat];
												$d_code[] 	= array('code'=>$product['code'],'vat_ammount'=>$d_vat_1,'vat_index'=>$d_index);
												?><input name="special_vat[]" type="hidden" value="<?php echo '1'; ?>"><?php
											}

											echo round($totalprice*($product[$product_vat]/100),2);
										}else {
											?><input name="vat_index_item[]" type="hidden" value="<?php echo $vat_index; ?>"><?php
											?><input name="vat_rate_item[]" type="hidden" value="<?php echo round($totalprice*($vat_index/100),2); ?>"><?php
											echo round($totalprice*($vat_index/100),2);
										}
								?>
							</td>
						<?php						
						if($this->bitauth->is_admin()){
						echo '<td>'.form_input(array('name' => 'warehouse_price[]','type' => 'text','value'=> $product['warehouse_price'])).'</td>'; 
						$diff_price = $unit_price-$product['warehouse_price'];
						echo '<td>'.form_input(array('name' => 'margin[]','value'=> @round((($diff_price/$unit_price)*100),2))).'</td>'; 
						@$total_margin[] = round((($diff_price/$unit_price)*100),2);
						}
						else {
						 '<td>'.form_input(array('name' => 'warehouse_price[]','type' => 'hidden','value'=> $product['warehouse_price'])).'</td>'; 
						$diff_price = $unit_price-$product['warehouse_price'];
						 '<td>'.form_input(array('name' => 'margin[]','value'=> round((($diff_price/$unit_price)*100),2))).'</td>'; 
						$total_margin[] = round((($diff_price/$unit_price)*100),2);
						}
						//$total_price[]  =   ($product['saleprice']-($product['saleprice']/$product['discount']))*$product['ordered_quantity'];
						$total_price[]  =   $unit_price*$product['ordered_quantity'];
						
						?><td><input name="available_stock[]" type="hidden" value="<?php echo $product['current_quantity']; ?>" /><?php echo $product['current_quantity']; ?></td><?php
						?><td style="font-size: 10px;"><input name="description[]" type="hidden" value="<?php echo $product[$name]; ?>" /><?php echo $product[$name]; ?></td><?php
                        echo '<td><button id="ibtnDel" class="glyphicon glyphicon-trash"  ></button></td>';
                    }
					//CASE 3
					if(!$product['discount'] > 0  and !$product['unit_price'] > 0 ){

						echo  '<td>'.form_input(array('name'=>'discount[]','type'=> 'text')).'</td>';
						echo  '<td>'.form_input(array('name'=>'unit_price[]','type'=> 'text')).'</td>';
						echo '<td>'.form_input(array('name' => 'total[]','value'=> round($product['saleprice']*$product['ordered_quantity'],2))).'</td>'; 
						?>
							<td>
								<?php
										$totalprice =  round($product['saleprice']*$product['ordered_quantity'],2);

										if(!empty($product[$product_vat])){

											?><input name="vat_index_item[]" type="hidden" value="<?php echo $product[$product_vat]; ?>"><?php
											?><input name="vat_rate_item[]" type="hidden" value="<?php echo round($totalprice*($product[$product_vat]/100),2); ?>"><?php

											if($product[$product_vat] == str_replace('.00','',$vat_index)){

												$n_vat[] 		= round($totalprice*($product[$product_vat]/100),2);
												$n_index 		= $product[$product_vat];
												?><input name="special_vat[]" type="hidden" value="<?php echo '0'; ?>"><?php
											}

											if($product[$product_vat] != str_replace('.00','',$vat_index)){
											
												$d_vat[]	= round($totalprice*($product[$product_vat]/100),2);
												$d_vat_1 	= round($totalprice*($product[$product_vat]/100),2);
												$d_index 	= $product[$product_vat];
												$d_code[] 	= array('code'=>$product['code'],'vat_ammount'=>$d_vat_1,'vat_index'=>$d_index);
												?><input name="special_vat[]" type="hidden" value="<?php echo '1'; ?>"><?php
											}

											echo round($totalprice*($product[$product_vat]/100),2);
										}else {
											?><input name="vat_index_item[]" type="hidden" value="<?php echo $vat_index; ?>"><?php
											?><input name="vat_rate_item[]" type="hidden" value="<?php echo round($totalprice*($vat_index/100),2); ?>"><?php
											echo round($totalprice*($vat_index/100),2);
										}
								?>
							</td>
						<?php	
						if($this->bitauth->is_admin()){
						echo '<td>'.form_input(array('name' => 'warehouse_price[]','type' => 'text','value'=> $product['warehouse_price'])).'</td>'; 
						
						if($product['saleprice'] > 0){
						$diff_price = $product['saleprice']-$product['warehouse_price'];

						echo '<td>'.form_input(array('name' => 'margin[]','value'=> round((($diff_price/$product['saleprice'])*100),2))).'</td>'; 
						$total_margin[] = round((($diff_price/$product['saleprice'])*100),2);
						}
						else {
						echo '<td>'.form_input(array('name' => 'margin[]','value'=> '')).'</td>';
						$total_margin[] = '';
						}
						}
						else {
						 '<td>'.form_input(array('name' => 'warehouse_price[]','type' => 'hidden','value'=> $product['warehouse_price'])).'</td>'; 

						if($product['saleprice'] > 0){
						$diff_price = $product['saleprice']-$product['warehouse_price'];

						 '<td>'.form_input(array('name' => 'margin[]','value'=> round((($diff_price/$product['saleprice'])*100),2))).'</td>'; 
						$total_margin[] = round((($diff_price/$product['saleprice'])*100),2);
						}
						else {
						 '<td>'.form_input(array('name' => 'margin[]','value'=> '')).'</td>';
						$total_margin[] = '';
						}
						}
						$total_price[] = $product['saleprice']*$product['ordered_quantity'];
						?><td><input name="available_stock[]" type="hidden" value="<?php echo $product['current_quantity']; ?>" /><?php echo $product['current_quantity']; ?></td><?php
						?><td style="font-size: 10px;"><input name="description[]" type="hidden" value="<?php echo $product[$name]; ?>" /><?php echo $product[$name]; ?></td><?php
						echo '<td><button id="ibtnDel" class="glyphicon glyphicon-trash"  ></button></td>';
                    }
					//CASE 4
					if($product['discount'] > 0  and $product['unit_price'] > 0 ){

						echo  '<td>'.form_input(array('name'=>'discount[]','value' => round($product['discount'],2))).'</td>';
						echo  '<td>'.form_input(array('name'=>'unit_price[]','value' => round($product['unit_price'],2))).'</td>';
						echo  '<td>'.form_input(array('name' => 'total[]','value'=> round($product['unit_price']*$product['ordered_quantity'],2))).'</td>'; 
						?>
							<td>
								<?php
										$totalprice =  round($product['unit_price']*$product['ordered_quantity'],2);
										
										if(!empty($product[$product_vat])){
											
											?><input name="vat_index_item[]" type="hidden" value="<?php echo $product[$product_vat]; ?>"><?php
											?><input name="vat_rate_item[]" type="hidden" value="<?php echo round($totalprice*($product[$product_vat]/100),2); ?>"><?php

											if($product[$product_vat] == str_replace('.00','',$vat_index)){

												$n_vat[] 		= round($totalprice*($product[$product_vat]/100),2);
												$n_index 		= $product[$product_vat];
												?><input name="special_vat[]" type="hidden" value="<?php echo '0'; ?>"><?php
											}

											if($product[$product_vat] != str_replace('.00','',$vat_index)){
												$d_vat[]	= round($totalprice*($product[$product_vat]/100),2);
												$d_vat_1 	= round($totalprice*($product[$product_vat]/100),2);
												$d_index 	= $product[$product_vat];
												$d_code[] 	= array('code'=>$product['code'],'vat_ammount'=>$d_vat_1,'vat_index'=>$d_index);
												?><input name="special_vat[]" type="hidden" value="<?php echo '1'; ?>"><?php
											}

											echo round($totalprice*($product[$product_vat]/100),2);
										}else {
											?><input name="vat_index_item[]" type="hidden" value="<?php echo $vat_index; ?>"><?php
											?><input name="vat_rate_item[]" type="hidden" value="<?php echo round($totalprice*($vat_index/100),2); ?>"><?php
											echo round($totalprice*($vat_index/100),2);
										}
								?>
							</td>
						<?php	
						if($this->bitauth->is_admin()){
						echo  '<td>'.form_input(array('name' => 'warehouse_price[]','type' => 'text','value'=> $product['warehouse_price'])).'</td>'; 
						$diff_price = $product['unit_price']-$product['warehouse_price'];
						echo '<td>'.form_input(array('name' => 'margin[]','value'=> round((($diff_price/$product['unit_price'])*100),2))).'</td>'; 
						$total_margin[] = round((($diff_price/$product['unit_price'])*100),2);
						}
						else {
							'<td>'.form_input(array('name' => 'warehouse_price[]','type' => 'hidden','value'=> $product['warehouse_price'])).'</td>'; 
							$diff_price = $product['unit_price']-$product['warehouse_price'];
							'<td>'.form_input(array('name' => 'margin[]','value'=> round((($diff_price/$product['unit_price'])*100),2))).'</td>'; 
							$total_margin[] = round((($diff_price/$product['unit_price'])*100),2);
						}
						$total_price[] = $product['unit_price']*$product['ordered_quantity'];
						?><td><input name="available_stock[]" type="hidden" value="<?php echo $product['current_quantity']; ?>" /><?php echo $product['current_quantity']; ?></td><?php
						?><td style="font-size: 10px;"><input name="description[]" type="hidden" value="<?php echo $product[$name]; ?>" /><?php echo $product[$name]; ?></td><?php
						echo '<td><button id="ibtnDel" class="glyphicon glyphicon-trash"  ></button></td>';
                    }
					//CASE 5 
					if($product['discount'] < 0  and $product['unit_price'] > 0 ){

						echo  '<td>'.form_input(array('name'=>'discount[]','value' => round($product['discount'],2))).'</td>';
						echo  '<td>'.form_input(array('name'=>'unit_price[]','value' => $product['unit_price'])).'</td>';
						echo  '<td>'.form_input(array('name' => 'total[]','value'=> round($product['unit_price']*$product['ordered_quantity'],2))).'</td>'; 
						?>
							<td>
								<?php
										$totalprice =  round($product['unit_price']*$product['ordered_quantity'],2);
										
										if(!empty($product[$product_vat])){
											
											?><input name="vat_index_item[]" type="hidden" value="<?php echo $product[$product_vat]; ?>"><?php
											?><input name="vat_rate_item[]" type="hidden" value="<?php echo round($totalprice*($product[$product_vat]/100),2); ?>"><?php

											if($product[$product_vat] == str_replace('.00','',$vat_index)){

												$n_vat[] 		= round($totalprice*($product[$product_vat]/100),2);
												$n_index 		= $product[$product_vat];
												?><input name="special_vat[]" type="hidden" value="<?php echo '0'; ?>"><?php
											}

											if($product[$product_vat] != str_replace('.00','',$vat_index)){
												$d_vat[]	= round($totalprice*($product[$product_vat]/100),2);
												$d_vat_1 	= round($totalprice*($product[$product_vat]/100),2);
												$d_index 	= $product[$product_vat];
												$d_code[] 	= array('code'=>$product['code'],'vat_ammount'=>$d_vat_1,'vat_index'=>$d_index);
												?><input name="special_vat[]" type="hidden" value="<?php echo '1'; ?>"><?php
											}

											echo round($totalprice*($product[$product_vat]/100),2);
										}else {
											?><input name="vat_index_item[]" type="hidden" value="<?php echo $vat_index; ?>"><?php
											?><input name="vat_rate_item[]" type="hidden" value="<?php echo round($totalprice*($vat_index/100),2); ?>"><?php
											echo round($totalprice*($vat_index/100),2);
										}
								?>
							</td>
						<?php	
						if($this->bitauth->is_admin()){
						echo  '<td>'.form_input(array('name' => 'warehouse_price[]','type' => 'text','value'=> $product['warehouse_price'])).'</td>'; 
						$diff_price = $product['unit_price']-$product['warehouse_price'];
						echo '<td>'.form_input(array('name' => 'margin[]','value'=> round((($diff_price/$product['unit_price'])*100),2))).'</td>'; 
						$total_margin[] = round((($diff_price/$product['unit_price'])*100),2);
						}
						else {
						  '<td>'.form_input(array('name' => 'warehouse_price[]','type' => 'hidden','value'=> $product['warehouse_price'])).'</td>'; 
						$diff_price = $product['unit_price']-$product['warehouse_price'];
						 '<td>'.form_input(array('name' => 'margin[]','value'=> round((($diff_price/$product['unit_price'])*100),2))).'</td>'; 
						$total_margin[] = round((($diff_price/$product['unit_price'])*100),2);
						}
						$total_price[] = $product['unit_price']*$product['ordered_quantity'];
						?><td><input name="available_stock[]" type="hidden" value="<?php echo $product['current_quantity']; ?>" /><?php echo $product['current_quantity']; ?></td><?php
						?><td style="font-size: 10px;"><input name="description[]" type="hidden" value="<?php echo $product[$name]; ?>" /><?php echo $product[$name]; ?></td><?php
						echo '<td><button id="ibtnDel" class="glyphicon glyphicon-trash"  ></button></td>';

                    }
                    ?>
			</tr>	
		<?php endforeach; ?>
					<?php 
					
					
					
						if(!empty($d_code)){
						foreach($d_code as $v){	
							$d_vat_value[] = $v['vat_ammount'];
						}
						
						$second_vat_val = array_sum($d_vat_value);
					}
					
					
						if($current_shop == 1 and array_sum($total_price) >250){
							$extra_charge = '0.00';
						}
						if($current_shop == 2 and array_sum($total_price) >500){
							$extra_charge = '0.00';
						}
						
						
						
						if($extra_charge != '0.00'){
						
							$net_price = array_sum($total_price)+$extra_charge;

						}
						else {

							$net_price = array_sum($total_price);
							
						}
						
					?>
					<?php 
						@$margin    		= array_sum($total_margin); 
						@$count_marge 		= count(array_filter($total_margin));
						@$overall_margin 	= $margin/$count_marge;
					?>

    </tbody>
    <tfoot>


						<tr>
						
							<?php 
								$order_discount_array = array(0=>'Discount',1=>'10% off',2=>'Free');
							?>	
							<td style="font-size: 12px;"><strong>Order discount</strong></td>
							<?php 		
								if(!empty($order_discount)){
									?><td colspan='5'></td><td><strong><?php echo form_dropdown('order_discount',$order_discount_array,$order_discount,'style="width: 50%;"');   ?></strong></td><?php
								}
								else{
									?><td colspan='5'></td><td><strong><?php echo form_dropdown('order_discount',$order_discount_array,'0','style="width: 100%;"');   ?></strong></td><?php
								} 
							?>
						</tr>
						
						<tr>
							<td style="font-size: 12px;"><strong><?php echo lang('dispatch_costs');?></strong></td>
							
								<?php 
									if($current_shop == 1){
										$extra_charges = array('0' => 'Shipping','6.95' => format_currency(6.95),'4.95' => format_currency(4.95),'0.00' => 'Samples  ');
									}
									if($current_shop == 2){
										$extra_charges = array('0' => 'Shipping','6.95' => format_currency(6.95),'4.95' => format_currency(4.95),'0.00' => 'Samples  ');
									}
									?>
									<?php 
									if(!empty($extra_charge)){
										?><td colspan='5'></td><td><strong><?php echo form_dropdown('extra_charges',$extra_charges,$extra_charge,'style="width: 100%;"');   ?></strong></td><?php
									}
									else{
										?><td colspan='5'></td><td><strong><?php echo form_dropdown('extra_charges',$extra_charges,'0','style="width: 100%;"');   ?></strong></td><?php
									} 
								?>
						</tr>

				
						<tr>
							<td style="font-size: 12px;"><strong><?php echo lang('netto');?></strong></td>
							<td colspan='5'></td><td><strong><?php echo format_currency($net_price);   ?></strong></td>
							<?php if($this->bitauth->is_admin()){
							?> <td colspan='2'></td><td><strong><?php echo $overall_margin; ?>%</strong></td>	<?php
							}
							?>
						   
							<input type="hidden" name="overall_margin" value="<?php echo $overall_margin;   ?>">
							<input type="hidden" name="netto" value="<?php echo $net_price;   ?>">
						</tr>
<!--&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&-->


							<?php
								$n_vats 	= array_sum($n_vat);
								$d_vats 	= array_sum($d_vat);
								$ship_vat 	= $extra_charge*$vat_index/100;
								
								
								if(!empty($n_vats)){ ?>
								
								<tr>
								<td style="font-size: 12px;"><strong><?php echo lang('vat').' for '.$country;?></strong></td>
										<?php 
										
										
										?>
										<td colspan='4'><?php echo $n_index; ?>%</td>
										<td colspan='1'></td><td><?php echo format_currency($n_vats); ?></td>
										<input type="hidden" name="vat" value="<?php echo $n_vats; ?>">
										<input type="hidden" name="vat_index" value="<?php echo $n_index; ?>%">
								</tr>
								
							<?php } ?>

							
							<input type="hidden" name="ship_vat_rate" value="<?php echo $ship_vat; ?>">
							<tr>
							<td><strong><?php echo lang('vat'); ?></strong></td>
									<?php ?>
									<td colspan='4'><?php echo str_replace('.00','',$vat_index); ?>%&nbsp;<span style="font-size: 11px; color: blue;"><?php echo 'Standard'.' '.lang('vat').' rate for shipping to '.$country;?></span></td>
									<td colspan='1'></td><td><?php echo format_currency($ship_vat); ?></td>
							</tr>
				

						<?php if(!empty($d_code)){ ?>
							<?php foreach($d_code as $code): ?>
								<?php if($code['vat_ammount'] > 0): ?>
									<tr>
										<td style="font-size: 12px;"><strong><?php echo lang('vat').' for '.$code['code'].' for '.$country;?></strong></td>
										<td colspan='4'><?php echo $d_index; ?>%</td>
										<td colspan='1'></td><td><?php echo format_currency($code['vat_ammount']); ?></td>
									</tr>
								<?php endif; ?>		
							<?php endforeach; ?>
						<?php } ?>
<!--&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&-->
				<tr>
					<td style="font-size: 12px;"><strong><?php echo lang('gross');?></strong></td>
					<td colspan="5"></td>
					<?php 
					if(!empty($order_discount)){
					?>
									<?php
											if(!empty($d_code) and !empty($n_vats)){
												$price = $net_price+$n_vats+$ship_vat+$d_vats;
											}
											if(empty($d_code) and !empty($n_vats)){
												$price = $net_price+$n_vats+$ship_vat;
											}
										if($order_discount == 1){
											$new_price = $price-($price/10);
											?>
											<td><?php echo format_currency($new_price); ?></td>
											<td style="font-size: 15px; color: red"><?php echo 'Old price'.' '.format_currency($price); ?></td>
											<input type="hidden" name="gross" value="<?php echo $new_price; ?>">
											<?php
									}
						if($order_discount == 2){
							$new_price = 0.00;
							?>
								<td><?php echo format_currency($new_price); ?></td>
								<td style="font-size: 15px; color: red"><?php echo 'Old price'.' '.format_currency($price); ?></td>
								<input type="hidden" name="gross" value="<?php echo $new_price; ?>" >
							<?php
						}
					?>	
					<?php
					}else {
					?>
						<td>
							<?php 
								if(!empty($d_code) and !empty($n_vats)){

									echo format_currency($net_price+$n_vats+$ship_vat+$d_vats);
									?><input type="hidden" name="gross" value="<?php echo ($net_price+$n_vats+$ship_vat+$d_vats); ?>"><?php
								}

								if(empty($d_code) and !empty($n_vats)){

									echo format_currency($net_price+$n_vats+$ship_vat);
									?><input type="hidden" name="gross" value="<?php echo ($net_price+$n_vats+$ship_vat); ?>"><?php
								}
							?>
						</td>
					<?php
					}
					?>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<input type="hidden" name="saleprice_index" value="<?php echo $saleprice_index; ?>">
<input type="hidden" name="vat_index" value="<?php echo $vat_index; ?>">
<input type="hidden" name="delivery_addres" value="<?php echo $vat_index; ?>">

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">Customer Information<?php //echo lang('invoice_details'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped">
						<tr><td style="text-align:center; text-transform: uppercase;"><h5><?php echo lang('important_info');?></h5></td>
							<td style="text-align:center; text-transform: uppercase;"><h5><?php echo lang('remarks');?></h5></td></tr>
						<tr>
							<td style="padding:5px;">
								<?php
								if(!empty($notes)){
								$data	= array('name'=>'notes','id'=>'notes','style' => 'width: 99%; margin: 3px; resize: none; overflow: auto;', 'value'=> $notes,'rows' => '2','style'=>'background-color: #E6E6FA;"');
								}
								else {
								$data	= array('name'=>'notes','id'=>'notes','style' => 'width: 99%; margin: 3px; resize: none; overflow: auto;', 'rows' => '2','style'=>'background-color: #E6E6FA;"');
								}
								echo form_textarea($data); ?>
							</td>

							
							<td style="padding:5px;"><?php
								if(!empty($remarks)){
								$data	= array('name'=>'remarks','id'=>'remarks','style' => 'width: 99%; margin: 3px; resize: none; overflow: auto;', 'value'=> $remarks,'rows' => '2','style'=>'background-color: #E6E6FA;"');
								}
								else {
								$data	= array('name'=>'remarks','id'=>'remarks','style' => 'width: 99%; margin: 3px; resize: none; overflow: auto;', 'rows' => '2','style'=>'background-color: #E6E6FA;"');
								}
								
								echo form_textarea($data); ?>
							</td>
						</tr>
						</table>
					</div>
				</div>
				
				<div class="panel panel-default" style="width: 100%; float: left;">
					<div class="panel-heading">Addresses<?php //echo lang('invoice_details'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
						</div>
						<div class="panel-body">
							<table class="table table-striped">
									<tr><td style="text-align:center; text-transform: uppercase;"><h5><?php echo lang('invoice_address');?></h5></td>
										<td style="text-align:center; text-transform: uppercase;"><h5><?php echo lang('delivery_address');?></h5></td></tr>
									<tr>
									<tr><a class="btn btn-info btn-sm" href="<?php echo site_url($this->config->item('admin_folder').'/customers/addresses/'.$customer_nr); ?>">Edit addresses<?php //echo lang('change_address');?></a></tr>
										<td style="padding:5px;">
											<?php if(!empty($invoice_address)): ?>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('company'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['NAAM1']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('firstname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['NAAM2']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('lastname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['NAAM3']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;">Street<?php //echo lang('street'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['STRAAT']; ?>">&nbsp;<input type="text"  style="width: 100px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['HUISNR']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;">Postcode<?php //echo lang('zip'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['POSTCODE']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('city'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['PLAATS']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('country'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['LAND']; ?>"><br><br>
											<?php endif; ?>	
										</td>
										<td style="padding:5px;">
											<?php if(!empty($delivery_address)): ?>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('company'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM1']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('firstname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM2']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('lastname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM3']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;">Street<?php //echo lang('street'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['STRAAT']; ?>">&nbsp;<input type="text"  style="width: 100px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['HUISNR']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;">Postcode<?php //echo lang('zip'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['POSTCODE']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('city'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['PLAATS']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('country'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['LAND']; ?>"><br><br>
											<?php endif; ?>	
										</td>
									</tr>
							</table>
						</div>
				</div>
				

				<div style="padding: 0px 0px 10px 10px">
                <button class="btn btn-info btn-sm" type="submit" name="submit" value="create_order"><?php echo lang('create_order'); ?></button>
                <button class="btn btn-info btn-sm" type="submit" name="submit" value="update"><?php echo lang('update'); ?></button>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a class="btn btn-default btn-sm" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$id); ?>"><?php echo lang('cancel');?></a>
                <a class="btn btn-default btn-sm" href="<?php echo site_url($this->config->item('admin_folder').'/orders/start_order/'.$id); ?>">Back<?php //echo lang('cancel');?></a>
			</div>
			<br><br>
</form>
 <script>
$(function() {
$( ".datepicker" ).datepicker();
});
</script>
    <script>$('#start_top').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
    <script>
        function update(){
                  $('#display')
                        .text(
                                ($('#number[]').val() * $('#unit_price[]').val() - $('#discount[]').val() * $('#number[]').val() * $('#unit_price[]').val() / 100)
                    );  
                }
                $('#number').keyup(update);
                $('#unit_price').change(update);
                $('#discount').change(update);
    </script>
<style>
input.span1{
 height: 12px;

}
#some-element {
  border: 1px solid #ccc;
  display: none;
  font-size: 10px;
  margin-top: 10px;
  padding: 5px;
  text-transform: uppercase;
}

#some-div:hover #some-element {
  display: block;
}
</style>


        <script>
        $(document).ready(function () {
            var counter = 0;

            $("#addrow").on("click", function () {


                var counter = $('#myTable tr').length - 2;

                $("#ibtnDel").on("click", function () {
                    counter = -1
                });


                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><input type="text" class="span1" name="product_number[]' + counter + '" required/></td>';
                cols += '<td><input type="text" class="span1" name="number[]' + counter + '" required/></td><td></td><td></td>';
                cols += '<td><input type="text" class="span1" name="discount[]' + counter + '"/></td>';
                cols += '<td><input type="text" class="span1" name="unit_price[]' + counter + '"/></td><td></td>';
                cols += '<td><input type="text" class="span1" name="warehouse_price[]' + counter + '"/></td><td></td><td></td><td></td>';




                cols += '<td><button id="ibtnDel" class="glyphicon glyphicon-trash" style="display: inline-block; " ></button></td>';
                newRow.append(cols);
                if (counter == 20) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
                $("table.table-hover").append(newRow);
                counter++;
            });

            $("table.table-hover").on("change", 'input[name^="unit_price"]', function (event) {
                calculateRow($(this).closest("tr"));
                calculateGrandTotal();
            });


            $("table.table-hover").on("click", "#ibtnDel", function (event) {
                $(this).closest("tr").remove();
                calculateGrandTotal();
            });


        });



        function calculateRow(row) {
            var number = +row.find('input[name^="unit_price"]').val();

        }

        function calculateGrandTotal() {
            var grandTotal = 0;
            $("table.table-hover").find('input[name^="unit_price"]').each(function () {
                grandTotal += +$(this).val();
            });
            $("#grandtotal").text(grandTotal.toFixed(2));
        }
        </script>
<?php include('footer.php'); ?>