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
                    <td><input id="start_top" name="arrival_date" value="<?php echo $order->ordered_on; ?>" type="text" placeholder="expexted date of arrival"/></td>
                </tr>

            </tbody>
        </table>



<?php echo form_open($this->config->item('admin_folder').'/stock/checkout/'.$order->id, 'class="form-inline"');?>


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

                <?php if(!empty($order_items)): ?>
                <tbody>
                    <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td>
                            <input type="hidden" name="product_price[]" id="product_price" value="<?php echo $item['warehouse_price']; ?>">
                            <input type="hidden" name="product_number[]" id="product_number" value="<?php echo $item['ARTIKELCOD']; ?>">
                            <?php echo $item['ARTIKELCOD']; ?>
                        </td>
                        
                        <td>
                            <input type="hidden" name="number[]" id="ordered_quantity" value="<?php echo $item['AANTALBEST']; ?>">
                            <?php echo form_decode($item['AANTALBEST']);?>
                        </td>
                        
                        <td></td>
                        
                        <td>
                            <?php echo form_input(array('name'=>'quantity_recieved[]','id'=>'quantity_recieved', 'type'=>'text','class'=>'span1'));?>
                        </td>
                        
                        <td>
                            <input type="hidden" name="vpa[]" id="package_details" value="<?php echo $item['CAANTALPER']; ?>">
                            <?php echo form_decode($item['CAANTALPER']);?>
                        </td>
                        
                        
                        
                        <td><?php echo form_input(array('name'=>'reception_date[]','id'=>'reseption_date','value'=>  date('Y-m-d'),'type'=>'text','class'=>'span2'));?></td>
						<td><input type="text" class="start_exp" name="expiration_date[]" value="<?php echo $item['expiration_date']; ?>" class="span2" /></td>
                        <td><?php echo form_input(array('name'=>'batch_number[]','id'=>'batch_number','type'=>'text','class'=>'span2'));?></td>
                        
                        <td><?php 
                        if($shop_index == '2'){
                            echo form_dropdown('warehouse[]',$warehouse_dutchblue,'0');
                        }
                        if($shop_index == '1'){
                            echo form_dropdown('warehouse[]',$warehouse_comforties,'0');
                        }
                        ?></td>
                        <td>
						<select name="warehouse_place[]" id="warehouse_place[]" required>

							 <option value="" disabled="disabled" selected="selected"><?php echo lang('select_warehouse_place'); ?></option>
							<option value="vast">1 Vast</option>
							<option value="buiten">1 Buiten</option>
						</select>
						</td>
                        
                        <td>
                            <input type="hidden" name="description[]" id="product_name" value="<?php echo $item['FACTUUROMS']; ?>">
                            <div id="some-div"><p>view</p><span id="some-element"><?php echo form_decode($item['FACTUUROMS']); ?></span></div>
                        </td>
                    </tr>
                    
                    <?php endforeach; ?>
    
                    </tbody>

                <?php endif; ?>
        </table>
        <input type="hidden" name="order_number" id="" value="<?php echo $order->order_number; ?>">
        <input type="hidden" name="supplier_name" id="" value="<?php echo $order->supplier_name; ?>">
        <input type="hidden" name="supplier_id" id="" value="<?php echo $order->supplier_id; ?>">
        <input type="hidden" name="NR" id="" value="<?php echo $order->NR; ?>">

	<div class="row" style="margin-top:20px;">
		<div class="span8">
			<h4><?php echo lang('other_remarks');?></h4>
			<textarea name="notes" class="span8"></textarea>
		</div>
		<div class="span4">
			<h4><?php echo lang('status');?></h4>
			<?php

			echo form_dropdown('status', $this->config->item('stock_order_statuses'), $order->status, 'class="span4"');
			?>
		</div>
	</div>


            <div class="form-actions">
                    <input type="submit" class="btn btn-success btn-small" value="<?php echo lang('update_order');?>"/>
            </div>

</form>

<?php echo form_open($this->config->item('admin_folder').'/stock/set_costs/'.$order->id, 'class="form-inline"');?>
        
<hr>
<table class="table table-condensed">
                <tr>
                    
                    <td><strong><?php  echo lang('shipping_cost');?></strong></td>
                    <td><input name="shipping_cost" class="span2" type="text" value="<?php if(!empty($shiping_costs))echo $shiping_costs; ?>" placeholder="shipping costs"/>&nbsp;<?php echo $this->config->item('currency_symbol'); ?></td>
                </tr>
                <tr>
                    <td><strong><?php  echo lang('duties');?></strong></td>
                    <td><input name="duties" class="span2" type="text" value="<?php if(!empty($duties))echo $duties; ?>" placeholder="duties"/>&nbsp;<?php echo $this->config->item('currency_symbol'); ?></td>
                </tr>
                <tr>
                    <td><strong><?php  echo lang('other_costs');?></strong></td>
                    <td><input name="other_costs" class="span2" type="text" value="<?php if(!empty($other_costs))echo $other_costs; ?>" placeholder="other costs"/>&nbsp;<?php echo $this->config->item('currency_symbol'); ?></td>
                </tr>
</table>
<hr>

 <?php $uri = str_replace('/admin/', '', $this->uri->uri_string()); ?>
<input type="hidden" name="current_url" value="<?php echo $uri; ?>">
            <div class="form-actions">
                    <input type="submit" class="btn btn-success btn-small" value="<?php echo lang('set_costs');?>"/>
            </div>
</form>

<script>$('.start_exp').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
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