<?php

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


?>

		<div style="font-size:12px; font-family:arial, verdana, sans-serif;">
			<?php 
			if($this->data_shop == 3){
			 ?>
			 <h2 style="font-size: 50px;">Glovers.com</h2>
			 <?php
			}
			else {
			?>
			<?php if ($shop_id == 1) :?>
				<?php if ($this->config->item('site_logo_comforties')) :?>
			<div>
				<img src="<?php echo base_url($this->config->item('site_logo_comforties'));?>" />
			</div>
			<?php endif; ?>
			<?php endif; ?>

			<?php if ($shop_id == 2) :?>
				<?php if ($this->config->item('site_logo_dutchblue')) :?>
			<div>
				<img src="<?php echo base_url($this->config->item('site_logo_dutchblue'));?>" />
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<?php
			}
			?>

	
	<table style="border:1px solid #000; width:100%; font-size:13px;" cellpadding="5" cellspacing="0">
		<tr>
			<td style="width:20%; vertical-align:top;" class="packing">
				<h2 style="margin:0px">*<?php //echo $order->order_number;?>*</h2>
				<?php if(!empty($order->is_gift)):?>
					<h1 style="margin:0px; font-size:4em;"><?php echo lang('packing_is_gift');?></h1>
				<?php endif;?>
			</td>
			<td style="width:40%; vertical-align:top;">
				<strong><?php echo lang('bill_to_address');?></strong><br/>
                                
                                <?php echo (!empty($order->company))?$order->company.'<br/>':'';?>
                                
                                <?php if(!empty($invoice_address)): ?>
				<?php echo $invoice_address['NAAM1'].' '.$invoice_address['NAAM2'];?> <br/>
                                <?php echo (!empty($order->contact_person))?$order->contact_person.'<br/>':'';?><br>
				<?php echo $invoice_address['STRAAT'];?><br>
				<?php echo (!empty($invoice_address['HUISNR']))?$invoice_address['HUISNR'].'<br/>':'';?>
				<?php echo $invoice_address['PLAATS'].', '.$invoice_address['POSTCODE']; ?><br/>
				<?php echo $invoice_address['LAND'];?><br/>
                                <?php endif; ?>
								


			</td>
			<td style="width:40%; vertical-align:top;" class="packing">
				<strong><?php echo lang('ship_to_address');?></strong><br/>
				 <?php echo (!empty($order->company))?$order->company.'<br/>':'';?>
                                
                                <?php if(!empty($delivery_address)): ?>
				<?php echo $delivery_address['NAAM1'].' '.$delivery_address['NAAM2'];?> <br/>
                                <?php echo (!empty($order->contact_person))?$order->contact_person.'<br/>':'';?><br>
				<?php echo $delivery_address['STRAAT'];?><br>
				<?php echo (!empty($delivery_address['HUISNR']))?$delivery_address['HUISNR'].'<br/>':'';?>
				<?php echo $delivery_address['PLAATS'].', '.$delivery_address['POSTCODE']; ?><br/>
				<?php echo $delivery_address['LAND'];?><br/>
                                <?php endif; ?>
								


			<br/>
			</td>
		</tr>
		
		<tr>
			<td style="border-top:1px solid #000;"></td>
			<?php if($this->data_shop == 3 ){ ?>
			<td style="border-top:1px solid #000;">
				<strong><?php echo lang('payment_method');?></strong>
					<h4>Met factuur</h4>
			</td>
			<?php }
			else {
			?>
			<td style="border-top:1px solid #000;">
				<strong><?php echo lang('payment_method');?></strong>
				<?php echo $payment_method_array[$order->payment_method]; ?>
			</td>
			
			<?php

			}
			?>

			
			<td style="border-top:1px solid #000;">
				<strong><?php echo lang('shipping_details');?></strong>
				<?php echo $order->shipping_method; ?>
			</td>
		</tr>
		
		<?php if(!empty($order->gift_message)):?>
		<tr>
			<td colspan="3" style="border-top:1px solid #000;">
				<strong><?php echo lang('gift_note');?></strong>
				<?php echo $order->gift_message;?>
			</td>
		</tr>
		<?php endif;?>
		
		<?php if(!empty($order->notes)):?>
			<tr>
				<td colspan="3" style="border-top:1px solid #000;">
					<strong><?php echo lang('shipping_notes');?></strong><br/><?php echo $order->notes;?>
				</td>
			</tr>
		<?php endif;?>
                <?php if(!empty($order->remarks)):?>
			<tr>
				<td colspan="3" style="border-top:1px solid #000;">
					<strong><?php echo lang('shipping_notes');?></strong><br/><?php echo $order->remarks;?>
				</td>
			</tr>
		<?php endif;?>
	</table>
	
	<table border="1" style="width:100%; margin-top:10px; border-color:#000; font-size:13px; border-collapse:collapse;" cellpadding="5" cellspacing="0">
		<thead>
			<tr>
				<th width="5%" class="packing">
					<?php echo lang('qty');?>
				</th>
				<th width="20%" class="packing">
					<?php echo lang('name');?>
				</th>
				<th class="packing" >
					<?php echo lang('description');?>
				</th>
			</tr>
		</thead>
	<?php $items = $order->contents; ?>


     <?php if(!empty($order_items)):?>           
<?php foreach($order_items as $item):

?>
		<tr>
			<td class="packing" style="font-size:20px; font-weight:bold;">
				<?php echo $item->quantity;?>
			</td>
                        
			<td class="packing">
				<?php echo $item->description;?>
				<?php echo (trim($item->code) != '')?'<br/><small>sku: '.$item->code.'</small>':'';?>
			</td>
                        
			<td class="packing">
				<?php
	

				?>
			</td>
		</tr>
<?php	endforeach;?>
                <?php	endif;?>
	</table>
</div>


<br class="break"/>