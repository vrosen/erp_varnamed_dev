<?php include('header.php'); ?>

<?php
$order_type_array = array(

    '0'                 => lang('select_order_method'),
    'instant_delivery'  => lang('instant_delivery'),
    'fixdate'           => lang('fixdate'),
    'direct_delivery'   => lang('direct_delivery'),
    'complete_delivery' => lang('complete_delivery'),
    'rent'              => lang('rent'),
    'recipe'            => lang('recipe'),
    'sample_delivery'   => lang('sample_delivery'),
    'rent_to_own'       => lang('rent_to_own'),
);
$condition = array(
    '0'                     => lang('select_delivery_condition'),
    '1'         => lang('free_shipment'),
    '2'    => lang('calculate_shipment'),
    );
$dispatch = array(
    '0'                     => lang('select_dispatch_metthod'),
    'Selbstauslieferung'         => lang('self_delivery'),
    'Spedition'        => lang('parcel_service'),
    'Sonstiges (sehe Vereinbarungen)'         => lang('miscellaneous')
    );

if($current_shop == 1){
   $warehouse = array(
    '0'          => lang('select_warehouse'),
    '3' => lang('commbiwerk'),
    '2' => lang('transoflex')
    ); 
}
if($current_shop == 2){
    $warehouse = array(
    '0'          => lang('select_warehouse'),
    '3' => lang('dutchblue'),
    '2' => lang('transoflex')
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

$currency_array = array(
    
    'EUR'   => 'EUR',
    'USD'   => 'USD'
    
);

//$vat_arr = array('0' => '0',$vat => $vat);

$carrier_array = array(
    '0' => lang('choose_carrier'),
    'dpd' => 'DPD',
    'transoflex' => 'Transoflex',
    'post' => 'Post',
    'dpd-monster' => 'DPD-Monster',
);

$picking_agents = array(
    
        '0' =>  lang('select_agent'),
     '1' =>  'agent_1',
     '2' =>  'agent_2',
     '3' =>  'agent_3',
     '4' =>  'agent_4',
     '5' =>  'agent_5',
     '6' =>  'agent_6',
);
$monitoring_agents = array(
    
        '0' =>  lang('select_agent'),
     '1' =>  'agent_1',
     '2' =>  'agent_2',
     '3' =>  'agent_3',
     '4' =>  'agent_4',
     '5' =>  'agent_5',
     '6' =>  'agent_6',
);
$payment_condition_array = array(
    
    '0' => lang('select_payment_condition'),
    '1' => lang('30_without_deduction'),
    '3' => lang('8_without_deduction'),
    '4' => lang('immediately_without_deduction'),
    '5' => lang('42_without_deduction'),

);





?>


<br>

    
     <?php echo form_open($this->config->item('admin_folder').'/orders/update/'.$order->order_number, 'class="form-inline"'); ?>
 

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo lang('new_shippments'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped" style="border: 1px solid #ddd;">
            <tbody>
                <tr>
                    <td><h6><?php echo lang('order_number'); ?></h6></td>
                    <td><h6><?php echo $order->order_number;?></h6></td>
                    <input name="order_number" value="<?php echo $order->order_number; ?>" type="hidden" /></td>
                </tr>
                <tr>
                    <td><h6><?php echo lang('customer_order_number'); ?></h6></td>
                    <td><?php echo $order->customer_order_number; ?></td>
                    </tr>
                    <tr>
                    <td><h6><?php echo lang('contact_person'); ?></h6></td>
                    <td><?php echo $order->contact_person; ?></td>
                    </tr>
                <tr>
                    <td><h6><?php  echo lang('customer');?></h6></td>
                    <td>
                        <a href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$order->customer_id); ?>">
                        <?php echo $order->company.'&nbsp;&nbsp;&nbsp;'.$order->firstname.'&nbsp;'.$order->lastname; ?>
                        <input name="customer_id" value="<?php echo $order->customer_id; ?>" type="hidden" /></td>
                        <input name="firstname" value="<?php echo $order->firstname; ?>" type="hidden" /></td>
                        <input name="lastname" value="<?php echo $order->lastname; ?>" type="hidden" /></td>
                        <input name="company" value="<?php echo $order->company; ?>" type="hidden" /></td>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><h6><?php echo lang('order_type'); ?></h6></td>
                    <?php 
                        if(empty($order->order_type)){
                            ?><td><?php echo form_dropdown('order_type',$order_type_array,'instant_delivery'); ?>&nbsp;
                            <input id="start_top" name="order_type_date" value="<?php echo $order->order_type_date ?>" type="text" placeholder="date of order"/></td><?php
                        }
                        else {
                            ?><td><?php echo form_dropdown('order_type',$order_type_array,$order->order_type); ?>&nbsp;
                            <input id="start_top" name="order_type_date" value="<?php echo $order->order_type_date ?>" type="text" placeholder="date of order"/></td><?php
                        }    
                     ?>
                </tr>
                <tr>
                    <td><h6><?php echo lang('delivery_condition'); ?></h6></td>
                    <td><?php echo form_dropdown('delivery_condition',$condition,$order->delivery_condition); ?></td>
                </tr>
                
                
                <tr>
                    <?php 
                    if(empty($order->shipping_method)){
                    ?><td><h6><?php echo lang('dispatch_method'); ?></h6></td>
                    <td><?php echo form_dropdown('dispatch_method',$dispatch,'Spedition'); ?></td><?php
                    }
                    else {
                    ?><td><h6><?php echo lang('dispatch_method'); ?></h6></td>
                    <td><?php echo form_dropdown('dispatch_method',$dispatch,$order->shipping_method); ?></td><?php
                    }
                    ?>
                </tr>
                
                <tr>
                    <?php 
                    if(empty($order->shipping_method)){
                        ?><td><h6><?php echo lang('warehouse'); ?></h6></td>
                        <td><?php echo form_dropdown('warehouse',$warehouse,'3'); ?></td><?php
                    }
                    else {
                        ?><td><h6><?php echo lang('warehouse'); ?></h6></td>
                        <td><?php echo form_dropdown('warehouse',$warehouse,$order->warehouse); ?></td><?php
                    }
                    ?>
                </tr>
                <tr>
                    <td><h6><?php echo lang('payment_method'); ?></h6></td>
                    <td><?php echo form_dropdown('payment_method',$payment_method_array,$order->payment_method); ?></td>
                </tr>
                <tr>
                    <td><h6><?php echo lang('payment_condition'); ?></h6></td>
                    <td>                        
                        <?php 
                        if(empty($order->payment_condition)){
                             echo form_dropdown('delivery_condition',$payment_condition_array,'4'); 
                        }
                        else {
                             echo form_dropdown('delivery_condition',$payment_condition_array,$order->payment_condition); 
                        }
                        ?></td>
                </tr>
                <tr>
                <td><h6><?php echo  lang('none_VAT');?></h6></td>
                <?php 
                if($order->none_vat == 0){
                $none_VAT = array(  'name' => 'none_VAT','id' => 'none_VAT','value' => '0','checked' => false,'style'=> 'margin:10px',); ?>
                <td><?php echo form_checkbox($none_VAT); ?></td> <?php  
                }
                else {
                $none_VAT = array(  'name' => 'none_VAT','id' => 'none_VAT','value' => '1','checked' => TRUE,'style'=> 'margin:10px',); ?>
                <td><?php echo form_checkbox($none_VAT); ?></td> <?php
                }
                ?>
                </tr>
                <tr>
                <td><h6><?php echo lang('not_remind');?></h6></td>
                <?php 
                if($order->not_remind == 0){
                $not_warn = array(  'name' => 'not_warn','id' => 'not_warn','value' => '0','checked' => false,'style'=> 'margin:10px',); ?>
                <td><?php echo form_checkbox($not_warn); ?></td> <?php
                }
                else {
                $not_warn = array(  'name' => 'not_warn','id' => 'not_warn','value' => '1','checked' => TRUE,'style'=> 'margin:10px',); ?>
                <td><?php echo form_checkbox($not_warn); ?></td><?php
                }
                ?>
                </tr>
                <tr>
                <td><h6><?php echo lang('invoice_per_email');?></h6></td>
                <?php 
                if($order->invoice_per_email == 0){
                    $invoice_per_email = array(  'name' => 'invoice_per_email','id' => 'invoice_per_email','value'=> '0','checked' => false,'style'=> 'margin:10px',); ?>
                <td><?php echo form_checkbox($invoice_per_email); ?></td><?php
                }
                else {
                $invoice_per_email = array(  'name' => 'invoice_per_email','id' => 'invoice_per_email','value'=> '1','checked' => TRUE,'style'=> 'margin:10px',); ?>
                <td><?php echo form_checkbox($invoice_per_email); ?></td><?php
                }
                ?>

                </tr>
                <tr>
                <td><?php echo lang('email_adresse');?></td>
                <?php $email_address = array(  'name' => 'email','id' => 'email','type'=> 'text','value' => set_value('email',$order->email)); ?>
                <td><?php echo form_input($email_address); ?></td>
                </tr>             
                <tr>
                <td><?php echo lang('currency');?></td>
                <td><?php echo form_dropdown('currency',$currency_array,$order->currency,'class="span2"'); ?></td>
                </tr>    
                <tr>
                <td><?php echo lang('order_entry');?></td>
                <td>
                    <?php 
                        if(empty($order->entered_by) and $order->WEBSHOP ==1){
                            echo lang('allone');
                        }
                        else {
                            echo $order->entered_by;
                        }
                    ?>
                </td>
                </tr>                 
                <tr>
                <td><?php echo lang('order_date');?></td>
                <td><input id="order_date" name="order_date" value="<?php echo set_value('order_date',$order->ordered_on); ?>" type="text" /></td>
                <script>$('#order_date').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
                </tr>                 
                <tr>
                <td><h6><?php echo lang('order_status'); ?></h6></td>

                </tr>

                <?php if(!empty($invoices)):?>
                <tr>
                    <td><h6><?php echo lang('invoices'); ?></h6></td>
                    <td>
                        <?php foreach ($invoices as $invoice): ?>
                            <a href="<?php echo site_url('admin/invoices/view/'.$invoice['id']);?>" ><?php echo $invoice['invoice_number']; ?></a>
                        <?php endforeach;?>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>

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
			<?php 
			if($back['backorder_quantity'] ==0){
			?><strong>Continue.</strong><?php
			}else {
			?><strong>If you choose to continue, this order will be sent into the backorder's list.</strong><?php
			}
			?>
            
            </div>
            <?php
        }
    ?>
	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">Already sent<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped" style="border: 1px solid #ddd;">
						<thead>
							<tr>
											<th><?php echo lang('product_nr');?></th>
											<th><?php echo lang('quantity');?></th>
											<th><?php echo lang('num_vpe');?></th>
											<th><?php echo lang('VK');?></th>
							</tr>
						</thead>
							<tbody>
								<tr>
									<?php if(!empty($verzending)): ?>   							
										<?php foreach ($verzending as $send_item):?>
											<td><input name="number[]" type="text" value="<?php echo $send_item['ARTIKELCOD']; ?>" class="span1"/></td>
											<td><input name="number[]" type="text" value="<?php echo $send_item['VERZONDEN']; ?>" class="span1"/></td>
											<td><input name="number[]" type="text" value="<?php echo $send_item['VERPAKKING']; ?>" class="span1"/></td>
											<td><input name="number[]" type="text" value="<?php echo $send_item['LOCATIE']; ?>" class="span1"/></td>

										<?php endforeach;?>
									<?php endif;?>
								</tr>
							<tbody>
						</thead>
					</table>
				</div>			
			</div>		






			
	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo lang('new_shippments'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped" style="border: 1px solid #ddd;">
						<thead>
							<tr>
											<th><?php echo lang('product_nr');?></th>
											<th><?php echo lang('quantity');?></th>
											<th><?php echo lang('num_vpe');?></th>
											<th><?php echo lang('VK');?></th>
											<th><h6><?php echo lang('discount');?></h6></th>
											<th><?php echo lang('unit_price');?></th>
											<th><?php echo lang('total');?></th>
											<th><?php echo lang('buying_price');?></th>
											<th><?php echo lang('margin'); ?></th>
											<th><?php echo lang('available_stock'); ?></th>
								<th><?php echo lang('description');?></th>
							</tr>
						</thead>

							<tbody>
						
							
						<?php if(!empty($back_product_array)): ?>        
						<?php foreach ($back_product_array as $order_item):?>
							   
								<tr>
									<input type="hidden" name="id[]" value="<?php echo $order_item['id'] ?>">
									<input type="hidden" name="product_id[]" value="<?php //echo $order_item['product_id'] ?>">
									<input type="hidden" name="product_number[]" value="<?php echo $order_item['code'] ?>">
									<td><?php echo $order_item['code'] ?></td>
									
									<td><input name="number[]" type="text" value="<?php echo $order_item['quantity']; ?>" class="span1"/></td>
									
									<td><?php echo $order_item['vpa'] ?></td><input type="hidden" name="vpa[]" value="<?php echo $order_item['vpa'] ?>">
									
									<td><?php echo $order_item['original_price'] ?></td><input type="hidden" name="vk[]" value="<?php echo $order_item['original_price'] ?>">
									
									<td><input name="discount[]" type="text" value="<?php echo $order_item['discount']; ?>" class="span1"/></td>

									<?php echo (empty($order_item['discount']))?    '<td>'.form_input(array('name'=>'unit_price[]','value' => $order_item['original_price'],'class'=>'span1')).'</td>': '<td>'.form_input(array('name'=>'unit_price[]','value' => $order_item['saleprice'] - (($order_item['discount']/100)*$order_item['saleprice']),'class'=>'span1')).'</td>'; ?>
									<?php echo (empty($order_item['discount']))?    '<td>'.format_currency($order_item['original_price']*$order_item['quantity']).'</td>': '<td>'.format_currency(($order_item['saleprice'] - (($order_item['discount']/100)*$order_item['saleprice']))*$order_item['quantity']).'</td>'; ?>

									<td><input name="warehouse_price[]" type="text" value="<?php echo $order_item['warehouse_price']; ?>" class="span1"/></td>

									<?php if(!is_int($order_item['discount'])){
										if($order_item['saleprice'] !== '0.00')
									   echo  '<td>'.@round(($order_item['saleprice']-$order_item['warehouse_price'])/($order_item['saleprice'])*(100),2).'</td>'; 
									}
								   else {
									   if($order_item['saleprice'] !== '0.00')
										 echo  '<td>'.round(($order_item['saleprice'] - (($order_item['discount']/100)*$order_item['saleprice']))-$order_item['warehouse_price']/($order_item['saleprice'])*(100),2).'</td>';   
									   
									   
								   }
								   
									?>
									<td><?php echo $order_item['available_stock'] ?></td><input type="hidden" name="available_stock[]" value="<?php echo $order_item['available_stock'] ?>">
									
									<td><div id="some-div"><p>view</p><span id="some-element"><?php echo $order_item['description']; ?></span></div></td><input type="hidden" name="description[]" value="<?php echo $order_item['description'] ?>">
									<input type="hidden" name="saleprice_index" value="<?php echo $saleprice_index; ?>">
								</tr>
									<?php 

									if($order_item['discount'] != 0 ){
										if($order_item['saleprice'] !== '0.00'){
											$price = $order_item['saleprice'] - (($order_item['discount']/100)*$order_item['saleprice']);
											$total_price[]  =   $price*$order_item['quantity'];
											$total_margin[] =   (($order_item['saleprice']-($order_item['saleprice']/$order_item['discount']))-$order_item['warehouse_price']/($order_item['saleprice'])*(100));
										}
									}
								if($order_item['discount'] != 0 ){
										if($order_item['saleprice'] == '0.00'){
											$price = $order_item['saleprice'] - (($order_item['discount']/100)*$order_item['saleprice']);
											$total_price[]  =   $price*$order_item['quantity'];
											$total_margin[] =   null;
										}
									}
									if($order_item['saleprice'] !== '0.00'){
											@$total_price[]  =   $order_item['saleprice']*$order_item['quantity'];
											@$total_margin[] =   (($order_item['saleprice']-$order_item['warehouse_price'])/($order_item['saleprice'])*(100));
									}
									
									?>

							<?php endforeach;?>
						  
							<?php $net_sum = array_sum($total_price);  ?>
							<?php $margin    = array_sum($total_margin); ?>
								</tbody>

								<tfoot>

												<tr>
													<td><h6><?php echo lang('netto');?></h6></td>
													<td colspan='5'></td><td><?php echo format_currency($order->subtotal);   ?></td>
													<?php 

														if($margin != 0) {
															?><td colspan='1'><td><h6><?php echo round(100-(($net_sum-$margin)/$margin)); ?>%</h6></td>	<?php
														}
														else {
														   ?><td colspan='1'><td><h6><?php echo 0; ?>%</h6></td>	<?php 
														}
													?>
													
													<input type="hidden" name="netto" value="<?php echo $net_sum;   ?>">
										</tr>
												
										<tr>
											<td><h6><?php echo lang('vat');?></h6></td>

														<td colspan=""><?php echo str_replace('.00', '', $order->vat_index).'%';//echo form_dropdown('vat_index',$vat_arr,$order->vat_index,'class="span2"'); ?></td>
														<td colspan='4'></td><td><?php echo format_currency($order->VAT); ?></td>
														<input type="hidden" name="vat" value="<?php echo $order->VAT; ?>">
										</tr>
												
										<tr>
											<td><h6><?php echo lang('gross');?></h6></td>
											<td colspan="5"></td>
											<td><?php echo format_currency($order->total); ?></td>
														<input type="hidden" name="gross" value="<?php echo $order->total; ?>">
										</tr>

										</tfoot>   
                <?php endif;?>
</table>
    </div>
</div>

        <div class="form-actions">
           
            <button class="btn btn-success btn-small" type="submit" name="submit" onclick="return areyousure();" value="update"><?php echo lang('create_order'); ?></button>
             <a class="btn btn-danger btn-small" href="<?php echo site_url($this->config->item('admin_folder').'/orders/view/'.$order->id); ?>"><?php echo lang('cancel');?></a>
        </div>

</form>


<script>
function areyousure()
{
	return confirm('<?php echo lang('work_again_sure');?>');
}
</script>
   <script>$('#start_top').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>

<style>
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