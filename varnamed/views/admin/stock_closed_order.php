<?php include('header.php'); ?>
<?php
$vat_arr = array('0' => '0',$vat => $vat);
?>
        <table class="table table-responsive">
            <tbody>
                <tr>
                    <td><strong><?php echo lang('order_number'); ?></strong></td>
                    <td><strong><?php echo $order->id;?></strong></td>
                </tr>
                <tr>
                    <td><strong><?php  echo lang('supplier');?></strong></td>
                    <td>
                        <a href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/form/'.$order->supplier_id); ?>">
                        <?php echo strtoupper($order->supplier_name); ?>
                           
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><strong><?php  echo lang('order_date');?></strong></td>
                    <td>
                        <?php echo $order->ordered_on; ?>
                    </td>
                </tr>
                <tr>
                <td><strong><?php  echo lang('arrival_date');?></strong></td>
                    <td><input id="start_top" name="arrival_date" value="<?php echo $order->ordered_on; ?>" type="text" placeholder="expexted date of arrival"/></td>
                </tr>
            </tbody>
        </table>






<?php echo form_open($this->config->item('admin_folder').'/stock_orders/restart_order/'.$order->id, 'class="form-inline"');?>

<div class="row">
	<div class="span12">
		<div class="btn-group pull-right">
			<a class="btn" title="<?php echo lang('change_status');?>" onclick="$('#notification_form').slideToggle();"><i class="icon-envelope"></i> <?php echo lang('change_status');?></a>
		</div>
	</div>
</div>
<div id="notification_form" class="row" style="display:none;">
                
		<div class="span4">
			<h3><?php echo lang('status');?></h3>
			<?php
			echo form_dropdown('status', $this->config->item('order_statuses'), $order->status, 'class="span4"');
			?>
		</div>
    &nbsp;    &nbsp;<br>
                <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="<?php echo lang('restart');?>" />
                </div>	
</div>

</form>
&nbsp;




<div class="block">
    <div class="navbar navbar-inner block-header">
        <table class="table table-striped">
                <thead>
                        <tr>
                                <th><?php echo lang('product');?></th>
                                <th><?php echo lang('number_ordered');?></th>
                                <th><?php echo lang('number_recieved');?></th>
                                <th><?php echo lang('VK');?></th>
                                <th><?php echo lang('unit_price');?></th>
                                <th><?php echo lang('total');?></th>
                                <th><?php echo lang('description');?></th>

                        </tr>
                </thead>
                <?php if(!empty($order_items)): ?>
                <tbody>
                    <?php //print_r($order_items); ?>
                    <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td><?php echo form_input(array('name'=>'code[]','value'=>form_decode($item['product_number']), 'class'=>'span1'));?></td>
                        <td><?php echo form_input(array('name'=>'quantity[]','value'=>form_decode($item['number']), 'class'=>'span1'));?></td>
                        <td></td>
                        <td><?php echo form_input(array('name'=>'package_details[]','value'=>form_decode($item['vpa']), 'class'=>'span1'));?></td>
                        <td><?php echo form_input(array('name'=>'unit_price[]','value'=>  format_currency($item['vk']), 'class'=>'span1'));?></td>
                        <td><?php echo form_input(array('name'=>'total[]','value'=> format_currency($item['total']), 'class'=>'span1'));?></td>
                        <td><div id="some-div"><p>view</p><span id="some-element"><?php echo form_decode($item['description']); ?></span></div></td>
                    </tr>
                        <?php 
                        if(!empty($item))
                        $t_pr[] = form_decode($item['vk'])*form_decode($item['number']); 
                        ?>
                    <?php endforeach; ?>
                    <?php $net_sum = array_sum($t_pr); ?>
                    </tbody>
                    
                <tfoot>
                    
                        <tr>
                                <td><strong><?php echo lang('netto');?></strong></td>
                                <td colspan='4'></td><td><?php echo format_currency($net_sum);   ?></td>	
                                <input type="hidden" name="netto" value="<?php echo format_currency($net_sum);   ?>">
                        </tr>
                        <tr>
                                <td><strong><?php echo lang('vat');?></strong></td>
                                <td colspan=""><?php echo form_dropdown('vat',$vat_arr,$vat,'class="span2"'); ?></td>
                                <td colspan='3'></td><td><?php echo format_currency($net_sum/$vat); ?></td>
                                <input type="hidden" name="vat" value="<?php echo $net_sum/$vat; ?>">
                        </tr>

                        <tr>
                                <td><h3><?php echo lang('gross');?></h3></td>
                                <td colspan="4"></td>
                                <td><?php echo format_currency($net_sum+($net_sum/$vat)); ?></td>
                                <input type="hidden" name="gross" value="<?php echo $net_sum+($net_sum/$vat); ?>">
                        </tr>
                </tfoot>
                <?php endif; ?>
        </table>
    </div>
</div>




	<div class="row" style="margin-top:20px;">
		<div class="span8">
			<h3><?php echo lang('other_remarks');?></h3>
			<textarea name="notes" class="span8"><?php echo $order->notes;?></textarea>
		</div>
	</div>



<script>$('#start_top').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
<script type="text/javascript">
// store message content in JS to eliminate the need to do an ajax call with every selection
var messages = <?php
	$messages	= array();
	foreach($msg_templates as $msg)
	{
		$messages[$msg['id']]= array('subject'=>$msg['subject'], 'content'=>$msg['content']);
	}
	echo json_encode($messages);
	?>;
//alert(messages[3].subject);
// store customer name information, so names are indexed by email
var customer_names = <?php 
	echo json_encode(array(
		$order->email=>$order->firstname.' '.$order->lastname,
		$order->ship_email=>$order->ship_firstname.' '.$order->ship_lastname,
		$order->bill_email=>$order->bill_firstname.' '.$order->bill_lastname
	));
?>;
// use our customer names var to update the customer name in the template
function update_name()
{
	if($('#canned_messages').val().length>0)
	{
		set_canned_message($('#canned_messages').val());
	}
}

function set_canned_message(id)
{
	// update the customer name variable before setting content	
	$('#msg_subject').val(messages[id]['subject'].replace(/{customer_name}/g, customer_names[$('#recipient_name').val()]));
}	
</script>
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
<?php include('footer.php');