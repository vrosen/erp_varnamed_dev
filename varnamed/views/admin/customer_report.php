<?php include('header.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_coupon');?>');
}
</script>

<div class="btn-group pull-right">
	<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/marketing/export_xml');?>"><i class="icon-download"></i> <?php echo lang('xml_download_report');?></a>
</div>	


<table class="table">
	<thead>
		<tr>
		  <th><?php echo lang('report_customer_id');?></th>
		  <th><?php echo lang('report_country');?></th>
                  <th><?php echo lang('report_city');?></th>
                  <th><?php echo lang('report_zip');?></th>
                  <th><?php echo lang('report_firstname');?></th>
                  <th><?php echo lang('report_lastname');?></th>
                  <th><?php echo lang('report_order_date');?></th>
                  <th><?php echo lang('report_status');?></th>
                  <th><?php echo lang('gender');?></th>
                  <th><?php echo lang('position');?></th>
                  <th><?php echo lang('order_num');?></th>
		  <th></th>
		</tr>
	</thead>
	<tbody>
<?php echo (count($report_details) < 1)?'<div class="alert" style="text-align:center;"><button class="close" data-dismiss="alert">×</button><strong>'.lang('no_report') .'</strong></div>':''?>
    <?php if(!empty($report_details)): ?>
        <?php foreach ($report_details as $report):?>
		<tr>
                        <td><a href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$report->customer_id); ?>"><?php echo $report->customer_id?></a></td>
			<td><?php echo  $report->bill_country; ?></td>
                        <td><?php echo  $report->bill_city; ?></td>
                        <td><?php echo  $report->bill_zip; ?></td>
                        <td><?php echo  $report->bill_firstname; ?></td>
                        <td><?php echo  $report->bill_lastname; ?></td>
                        <td><?php echo  $report->ordered_on; ?></td>
                        <td><?php echo  $report->status; ?></td>
                        <td><?php if($report->gender == 1){ echo "Male" ;} else { echo "Female";} ?></td>
                        <td><?php echo  $report->function; ?></td>
                        <td><?php echo  $report->order_number; ?></td>
	  </tr>
<?php endforeach; ?>
          <?php endif;?>
	</tbody>
</table>
<?php include('footer.php'); ?>
