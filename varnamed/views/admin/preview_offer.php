<?php include('header.php'); ?>
<?php echo form_open($this->config->item('admin_folder').'/customers/set_offer/'.$id); ?>




	<div class="span4">
		<h3><?php echo lang('invoice_address');?></h3>
                <?php
                echo '<strong>'.lang('company').'</strong>'.' : '.$invoice_address['company'].'<br>';
                echo '<strong>'.lang('firstname').'</strong>'.' : '.$invoice_address['firstname'].'<br>';
                echo '<strong>'.lang('lastname').'</strong>'.' : '.$invoice_address['lastname'].'<br>';
                echo '<strong>'.lang('email').'</strong>'.' : '.$invoice_address['email'].'<br>';
                echo '<strong>'.lang('invoice_address').'</strong>'.' : '.$invoice_address['address1'].'<br>';
                echo '<strong>'.lang('city').'</strong>'.' : '.$invoice_address['city'].'<br>';
                echo '<strong>'.lang('zip').'</strong>'.' : '.$invoice_address['zip'].'<br>';
                echo '<strong>'.lang('country').'</strong>'.' : '.$invoice_address['country'].'<br>';
                ?>
	</div>


        <h3><?php echo lang('customer_offer'); ?></h2>

        <table id="myTable" class="table-condensed">
            <thead>
                <tr>
                    <td><?php echo lang('date'); ?></td>
                    <td><?php echo lang('order').' '.$this->config->item('nr');?></td>
                    <td><?php echo lang('customer').' '.$this->config->item('nr'); ?></td>
                    <td><?php echo lang('customer').' '.lang('vat').' '.$this->config->item('nr');; ?></td>
                </tr>
            </thead>
            <tbody>
                <td><?php echo date('Y-m-d'); ?></td>
                <td></td>
                <td><?php echo $id; ?></td>
                <td><?php echo $vat_index; ?></td>
            </tbody>
        </table>

        <hr/>

        <table id="myTable" class="table-condensed">
            <thead>
                <tr>
                    <td><?php echo lang('product').' '.$this->config->item('nr'); ?></td>
                    <td><?php echo lang('name'); ?></td>
                    <td><?php echo lang('quantity'); ?></td>
                    <td><?php echo lang('package_details'); ?></td>
                    <td><?php echo lang('price_nett'); ?></td>
                    <td><?php echo lang('total_nett'); ?></td>
                </tr>
            </thead>
            <tbody>
                <?php //print_r($final_array); ?>
                <?php foreach ($final_array as $final): ?>
                <tr>
                    <td><?php echo $final['code']; ?></td>
                    <input type="hidden" name="code[]" value="<?php echo $final['code']; ?>">
                    
                    <td><?php echo $final['name']; ?></td>
                    <input type="hidden" name="name[]" value="<?php echo $final['name']; ?>">
                    <td><?php echo form_input(array('name'  =>   'number[]','class'=>'span1','value' => set_value('name',$final['quantity'])));?></td>
                    
                    <td><?php echo $final['dimension']; ?></td>
                    <input type="hidden" name="dimension[]" value="<?php echo $final['dimension']; ?>">
                    
                    <td><?php echo form_input(array('name'  =>   'unit_price[]', 'class'=>'span1','value' => set_value('name',  format_currency($final['unit_price']))));?></td>
                    <td><?php echo format_currency($final['quantity']*$final['unit_price']); ?></td>
                    <input type="hidden" name="total[]" value="<?php echo $final['quantity']*$final['unit_price']; ?>">
                    <td><a class="deleteRow"></a></td>
                    <?php $total[] = $final['quantity']*$final['unit_price']; ?>
                    <?php $total_weight[] = $final['weight']; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
            &nbsp;

            <tfoot>
                        <tr>
                            <td><strong><?php echo lang('shipping_costs');?></strong></td>
                            <td colspan='4'></td><td><input type="text" name="shipping_costs" value="<?php echo format_currency(0)?>" class="span1"></td>	
                        </tr>
                        <tr>
                            <td><strong><?php echo lang('subtotal');?></strong></td>
                            <td colspan='4'></td><td><?php echo format_currency($final['quantity']*$final['unit_price']); ?></td>	
                        </tr>
                        <tr>
                        <td><strong><?php echo lang('vat');?></strong></td>
                        <td colspan="4"></td><td><?php echo str_replace('.00', '', $vat_index); ?>%</td>
                        <input type="hidden" name="vat" value="<?php echo $vat_index; ?>">
                        </tr>
                        <tr>
                                <td><strong><?php echo lang('total_price');?></strong></td>
                                <td colspan="4"></td>
                                <td><?php echo format_currency(array_sum($total)); ?></td>
                                <input type="hidden" name="gross" value="<?php //echo $net_price+($net_price/$vat_index); ?>">
                        </tr>
                        <tr>
                            <td><strong><?php echo lang('weight');?></strong></td>
                            <td colspan='4'></td><td><?php echo array_sum($total_weight).' kg'; ?></td>	
                        </tr>
            </tfoot>
        </table>

<!-- TABLE START -->
<br>
       <input class="btn btn-success" type="submit" value="<?php echo lang('set_offer');?>"/>
</form>

<?php include('footer.php'); ?>