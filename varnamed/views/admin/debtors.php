
<?php include('header.php'); ?>



<div class="btn-group pull-right">
	<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/customers/export_xml');?>"><i class="icon-download"></i> <?php echo lang('xml_download');?></a>
	<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/customers/get_subscriber_list');?>"><i class="icon-download"></i> <?php echo lang('subscriber_download');?></a>
	<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_customer');?></a>
	<hr>
</div>


<div class="row">
<table class="table table-condensed table-bordered">
	<thead>
		<tr>
                    <th><?php echo lang('invoice_nr'); ?></th>
                    <th><?php echo lang('order_nr'); ?></th>
                    <th><?php echo lang('customer'); ?></th>
                    <th><?php echo lang('invoice_dispach_date'); ?></th>
                    <th><?php echo lang('total_debt'); ?></th>
                    <th>betaalde bedrag<?php //echo lang('paid_sum'); ?></th>
                    <th>op datum<?php //echo lang('paid_on'); ?></th>
                    <th>herinnering 1<?php //echo lang('paid_on'); ?></th>
                    <th>herinnering 2<?php //echo lang('paid_on'); ?></th>
                    <th>herinnering 3<?php //echo lang('paid_on'); ?></th>

		</tr>
	</thead>
	
	<tbody>


		<?php echo (count($debtors) < 1)?'<tr><td style="text-align:center;" colspan="5">'.lang('no_customers').'</td></tr>':''?>
                <?php foreach ($debtors as $debtor):?>
		<tr>
                        <td><?php echo $debtor->invoice_number; ?></td>
                        <td><?php echo $debtor->order_number; ?></td>
                        <td><?php echo $debtor->company; ?></td>
                        <td><?php echo $debtor->created_on; ?></td>
                        <td><?php echo $debtor->totalgross; ?></td>
                        <td><?php echo $debtor->paid_sum; ?></td>
                        <td><?php echo $debtor->paid_on; ?></td>
                        <td><?php echo $debtor->day_reminder_1; ?></td>
                        <td><?php echo $debtor->day_reminder_2; ?></td>
                        <td><?php echo $debtor->day_reminder_3; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
		<?php $page_links	= $this->pagination->create_links(); ?>
		<?php if($page_links != ''):?>
		<tr><td><?php echo $page_links;?></td></tr>
		<?php endif;?>
</div>










<?php include('footer.php'); ?>