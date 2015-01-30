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
if($current_shop == 3){
    $warehouse = array(
    '0'          => lang('select_warehouse'),
    '3' => 'Glovers',
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





<div class="block">
    <div class="navbar navbar-inner block-header">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td><strong><?php echo lang('order_number'); ?></strong></td>
                    <td><strong><?php echo $order->order_number;?></strong></td>
                    <input name="order_number" value="<?php echo $order->order_number; ?>" type="hidden" />
					<input name="order_nr" value="<?php echo $order->NR; ?>" type="hidden" />
					</td>
                </tr>

                <tr>
                    <td><strong><?php  echo lang('customer');?></strong></td>
                    <td>
                        <a href="<?php echo @site_url($this->config->item('admin_folder').'/customers/form/'.$id); ?>">
                        <?php echo $order->company.'&nbsp;&nbsp;&nbsp;'.$order->firstname.'&nbsp;'.$order->lastname; ?>
                        <input name="customer_id" value="<?php echo $order->customer_id; ?>" type="hidden" /></td>
                        <input name="firstname" value="<?php echo $order->firstname; ?>" type="hidden" /></td>
                        <input name="lastname" value="<?php echo $order->lastname; ?>" type="hidden" /></td>
                        <input name="company" value="<?php echo $order->company; ?>" type="hidden" /></td>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><strong><?php echo lang('order_type'); ?></strong></td>
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
                    <td><strong><?php echo lang('delivery_condition'); ?></strong></td>
                    <td><?php echo form_dropdown('delivery_condition',$condition,$order->delivery_condition); ?></td>
                </tr>
                
                
                <tr>
                    <?php 
                    if(empty($order->shipping_method)){
                    ?><td><strong><?php echo lang('dispatch_method'); ?></strong></td>
                    <td><?php echo form_dropdown('dispatch_method',$dispatch,'Spedition'); ?></td><?php
                    }
                    else {
                    ?><td><strong><?php echo lang('dispatch_method'); ?></strong></td>
                    <td><?php echo form_dropdown('dispatch_method',$dispatch,$order->shipping_method); ?></td><?php
                    }
                    ?>
                </tr>
                
                <tr>
                    <?php 
                    if(empty($order->shipping_method)){
                        ?><td><strong><?php echo lang('warehouse'); ?></strong></td>
                        <td><?php echo form_dropdown('warehouse',$warehouse,'3'); ?></td><?php
                    }
                    else {
                        ?><td><strong><?php echo lang('warehouse'); ?></strong></td>
                        <td><?php echo form_dropdown('warehouse',$warehouse,$order->warehouse); ?></td><?php
                    }
                    ?>
                </tr>




                <tr>
                <td><?php echo lang('email_adresse');?></td>
                <?php $email_address = array(  'name' => 'email','id' => 'email','type'=> 'text','value' => set_value('email',$order->email)); ?>
                <td><?php echo form_input($email_address); ?></td>
                </tr>             

              
                <tr>
                <td><?php echo lang('order_date');?></td>
                <td><input id="order_date" name="order_date" value="<?php echo set_value('order_date',$order->ordered_on); ?>" type="text" /></td>
                <script>$('#order_date').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
                </tr>                 
                <tr>
                <td><strong><?php echo lang('order_status'); ?></strong></td>
                <td>
                    <?php 
                    if($order->status == 0){
                        echo lang('new_order');
                    }
                    if($order->status == 1){
                        echo lang('warehouse_order');
                    }
                    if($order->status == 2){
                        echo lang('ready_order');
                    }
                    if($order->status == 3){
                        echo lang('shipped_order');
                    }
                    ?>
                </td>
                </tr>


            </tbody>

        </table>
    </div>
</div>
<div class="block">
    <div class="navbar navbar-inner block-header">
<table class="table table-condensed">
	<thead>
		<tr>
                        <th style="font-size: 12px;"><?php echo lang('product_nr');?></th>
                        <th style="font-size: 12px;"><?php echo lang('quantity');?></th>
                        <th style="font-size: 12px;"><?php echo lang('num_vpe');?></th>
                        <th style="font-size: 12px;"><?php echo lang('batch_number');?></th>
                        <th style="font-size: 12px;"><strong><?php echo lang('warehouse');?></strong></th>
                        <th style="font-size: 12px;"><?php echo lang('expiration_date');?></th>
		</tr>
	</thead>
    <tbody>
       <?php
   
       
      $order_items =  json_decode( json_encode($order_items), true); 
  

       
       ?>
<?php if(!empty($order_items)): ?>   
  
<?php foreach ($order_items as $order_item):?>
       
        <tr>
			<?php 
			if($this->data_shop == 3){
			if($order_item['code'] == '3x 1500 (10x150)' and $order_item['description'] == 'Vinyl'){
			 ?><td><?php echo ''.$order_item['code']; ?></td><?php
			}
			if($order_item['code'] == '1x 1500 (10x150)' and $order_item['description'] == 'Vinyl'){
			
			}
			if($order_item['code'] == '4x 1500 (10x150)' and $order_item['description'] == 'Nitryl'){
			
			}
			if($order_item['code'] == '3x 1500 (10x150)' and $order_item['description'] == 'Nitryl'){
			
			}
			if($order_item['code'] == '1x 1500 (10x150)' and $order_item['description'] == 'Nitryl'){
			
			}
			}
			?>
            <td style="font-size: 12px;"><?php echo str_replace('/', '', $order_item['ARTIKELCOD']); ?></td>
            <td style="font-size: 12px;"><?php echo $order_item['VERZONDEN']; ?></td>
            <td style="font-size: 12px;"><?php echo $order_item['VERPAKKING'] ?></td>
            <td><?php echo $order_item['BATCHNR'] ?>
            <td><?php echo $order_item['LOCATIE'] ?>
            <td><?php echo $order_item['VERVALDATU'] ?>
        </tr>


    <?php endforeach;?>
  

        </tbody>


                <?php endif;?>
</table>
    </div>
</div>


	


	
	
	
	

</div>
        
            
            
  

</form>


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
<script>
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_order');?>');
}
</script>
<?php include('footer.php');