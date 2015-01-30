<?php include('header.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_offer');?>');
}
</script>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">Offers<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped table-hover" style="border: 1px solid #ddd;">
			<thead>
				<tr>			
								<th>Offer Nr.<?php //echo lang('invoice_description'); ?></th>
								<th>Made by<?php //echo lang('invoice_description'); ?></th>
								<th>Date<?php //echo lang('invoice_description'); ?></th>
								<th>Sent<?php //echo lang('invoice_description'); ?></th>
								<th>Edit<?php //echo lang('invoice_description'); ?></th>
								<th>Delete<?php //echo lang('invoice_description'); ?></th>

				</tr>
			</thead>
			<tbody>
						<?php foreach ($offers as $offer):?>
				<tr>
				
								<td style="width: 5%;"><?php echo  'OFR'.$offer->id; ?></td>
								<td><?php echo  $offer->agent_name; ?></td>
								<td><?php echo  $offer->date_made; ?></td>
								<td><?php echo  $is_sent[$offer->is_sent]; ?></td>
								<td style="text-align: center; width: 50px;">
								<a class="glyphicon glyphicon-edit" style="display: inline-block; font-size: 14px;" href="<?php echo site_url($this->config->item('admin_folder').'/offer/view/'.$offer->id);?>"><?php //echo lang('form_view')?></a>
								</td>
								<td style="text-align: center; width: 50px;">
								<a class="glyphicon glyphicon-trash" onclick="return areyousure();" style="display: inline-block; font-size: 14px;" href="<?php echo site_url($this->config->item('admin_folder').'/offer/delete/'.$offer->client_id.'/'.$offer->id);?>"><?php //echo lang('form_view')?></a>
								</td>
				</tr>
				<?php endforeach; ?>


					   
						
						
						
						

			</tbody>
		</table>
		</div></div>

<?php include('footer.php'); ?>