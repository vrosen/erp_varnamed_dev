<?php include('header.php'); ?>
<?php
$warehouse_dutchblue = array(
    '0'             => lang('select_warehouse'),
    'transoflex'    => 'Transoflex(Frechen)',
    'dutchblue'     => 'Dutchblue(Delft)',
);
$warehouse_comforties = array(
    '0'             => lang('select_warehouse'),
    'transoflex'    => 'Transoflex(Frechen)',
    'combiwerk'     => 'Combiwerk(Delft)',
);
$warehouse_place = array(
    '0'             => lang('select_warehouse_place'),
    'vast'          => '1 Vast',
    'buiten'        => '1 Buiten',
);
$vat_arr = array('0' => '0',$vat => $vat);
?>
        <table class="table table-responsive">
            <tbody>
                <tr>
                    <td><strong><?php echo lang('order_number'); ?></strong></td>
                    <td><strong><?php echo $order->order_number;?></strong></td>
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
                    <td><?php echo $order->ordered_on; ?></td>
                </tr>

            </tbody>
        </table>

<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('cinfirm_close_order');?>');
}
</script>

<?php echo form_open($this->config->item('admin_folder').'/stock/close_order/'.$order->id,  'class="form-inline"');?>
<?php
                echo '<pre>';
                //print_r($delivered_order);    
                echo '</pre>';
?>
        <table class="table table-condensed">
                <thead>
                        <tr>
                                <th><?php echo lang('product_number');?></th>
                                <th><?php echo lang('number_ordered');?></th>
                                <th><?php echo lang('number_allready_recieved');?></th>
                                <th><?php echo lang('number_recieved');?></th>
                                <th><?php echo lang('number_pro_package');?></th>
                                <th><?php echo lang('reception_date');?></th>
                                <th><?php echo lang('expiration_date');?></th>
                                <th><?php echo lang('batch_number');?></th>
                                <th><?php echo lang('warehouse');?></th>
                                <th><?php echo lang('warehouse_place');?></th>
                                <th><?php echo lang('product_name_in_invoice');?></th>
                        </tr>
                </thead>

                <?php if(!empty($delivered_order)): ?>
                <tbody>
                    <?php foreach ($delivered_order as $item): ?>
                    <tr>
                        <td><?php echo $item['product_number']; ?></td>
                        <td><?php echo $item['ordered_quantity']; ?></td>
                        <td></td>
                        <td><?php echo $item['delivered_quantity']; ?></td>
                        <td><?php echo $item['number_pro_package']; ?></td>
                        <td><?php echo $item['reception_date']; ?></td>
                        <td><?php echo $item['expiration_date'];?></td>
                        <td><?php echo $item['batch_number'];?></td>
                        <td><?php echo $item['warehouse'];?></td>
                        <td>
                            <div id="some-div"><p>view</p><span id="some-element"><?php echo form_decode($item['invoice_product_name']); ?></span></div>
                        </td>
                    </tr>
                    
                    <?php endforeach; ?>
    
                    </tbody>

                <?php endif; ?>
        </table>
        <input type="hidden" name="order_number" id="" value="<?php echo $order->order_number; ?>">
        <input type="hidden" name="supplier_name" id="" value="<?php echo $order->supplier_name; ?>">
        <input type="hidden" name="supplier_id" id="" value="<?php echo $order->supplier_id; ?>">

	<div class="row" style="margin-top:20px;">
		<div class="span8">
			<h3><?php echo lang('other_remarks');?></h3>
			<?php echo $notes ; ?>
		</div>
            
            <script type="text/javascript">
function validate(){
if (document.getElementById('close').checked){
    document.getElementById('inner').innerHTML = '<div class="form-actions"><input type="submit" class="btn btn-danger" value="<?php echo lang('close_order');?>" id="close_button" onclick="return areyousure()"/></div>';
}else{
alert("<?php echo lang('hide_close_order'); ?>")
location.reload();
}
}
    </script>
      <div id="inner"></div>      
            <div class="span4">
			<h3><?php echo lang('close_order');?></h3>
                        <input type="checkbox" name="close_order" id="close" onclick="validate()" value="1">
		</div>
	</div>
<?php
if(!empty($close_order)){
    echo $close_order;
}
?>


</form>

<?php echo form_open($this->config->item('admin_folder').'/stock/set_costs/'.$order->id, 'class="form-inline"');?>
        
<hr>
<table class="table table-condensed">
                <tr>
                    
                    <td><strong><?php  echo lang('shipping_cost');?></strong></td>
                    <td><input name="shipping_cost" class="span1" type="text" value="<?php echo $shiping_costs; ?>" placeholder="shipping costs"/>&nbsp;<?php echo $this->config->item('currency_symbol'); ?></td>
                </tr>
                <tr>
                    <td><strong><?php  echo lang('duties');?></strong></td>
                    <td><input name="duties" class="span1" type="text" value="<?php echo $duties; ?>" placeholder="duties"/>&nbsp;<?php echo $this->config->item('currency_symbol'); ?></td>
                </tr>
                <tr>
                    <td><strong><?php  echo lang('other_costs');?></strong></td>
                    <td><input name="other_costs" class="span1" type="text" value="<?php echo $other_costs; ?>" placeholder="other costs"/>&nbsp;<?php echo $this->config->item('currency_symbol'); ?></td>
                </tr>
</table>
 <?php $uri = str_replace('/admin/', '', $this->uri->uri_string()); ?>
<input type="hidden" name="current_url" value="<?php echo $uri; ?>">
<hr>
            <div class="form-actions">
                    <input type="submit" class="btn btn-small" value="<?php echo lang('set_costs');?>"/>
            </div>


</form>


<script>$('#start_top').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
<style>
hr {
  -moz-border-bottom-colors: none;
  -moz-border-image: none;
  -moz-border-left-colors: none;
  -moz-border-right-colors: none;
  -moz-border-top-colors: none;
  border-color: red -moz-use-text-color #FFFFFF;
  border-style: solid none;
  border-width: 3px 0;
  margin: 18px 0;
}
</style>
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