<?php require('header.php'); ?>

<?php echo form_open($this->config->item('admin_folder').'/orders/submit_invoice/'.$id); ?>
    <table class="table table-responsives  ">
        <thead>
                <tr>
                    <th><?php echo lang('invoice_number'); ?></th>
                    <th><?php echo lang('order_number'); ?></th>
                    <th><?php echo lang('date_made'); ?></th>
                    <th><?php echo lang('total'); ?></th>
                    <th><?php echo lang('customer'); ?></th>
                    <th><?php echo lang('agent'); ?></th>
                    <th><?php echo lang('status'); ?></th>
                </tr>
            </thead>

        <tbody>
            <?php foreach($all_invoices as $invoice): ?>

                <tr>
                        <td><?php echo $invoice->invoice_number; ?></td>
                        <td><?php echo $invoice->order_number; ?></td>
                        <td><?php echo $invoice->created_on; ?></td>
                        <td><?php echo format_currency($invoice->totalgross); ?></td>
                        <td><?php echo $invoice->company.'&nbsp;'.$invoice->firstname.'&nbsp;'.$invoice->lastname; ?></td>
                        <td><?php echo $invoice->created_by; ?></td>
                        <td><?php echo $invoice->status; ?></td>
                <?php 
                    if($invoice->part_payments_made = '1'){
                        ?><td><?php echo lang('part_payments_made'); ?></td><?php 
                    }
                    
                ?>
                        <td>
                            <a class="btn btn-primary" style="white-space:nowrap;"href="<?php echo site_url($this->config->item('admin_folder').'/invoices/view/'.$invoice->invoice_number ,array( 'class="form-inline"'));?>"><?php echo lang('form_view')?></a>
                        </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<input type="hidden" name="continue" value="go">
<td><a class="btn btn-danger" style="white-space:nowrap;"href="<?php echo site_url($this->config->item('admin_folder').'/orders/view/'.$order_id,false);?>"><?php echo lang('cancel')?></a></td>
<div class="form-actions"><button type="submit" class="btn btn-primary"><?php echo lang('make_invoice');?></button></div
</form>


<?php require('footer.php'); ?>