<?php include('header.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_coupon');?>');
}
</script>

	<a class="btn" style="float:right;" href="<?php echo site_url($this->config->item('admin_folder').'/shops/form'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_shop');?></a>


<table class="table">
	<thead>
		<tr>
		  <th><?php echo lang('code');?></th>
		  <th><?php echo lang('shop_name');?></th>
                  <th><?php echo lang('shop_creation_date');?></th>
		  <th></th>
		</tr>
	</thead>
	<tbody>
	<?php echo (count($shops) < 1)?'<tr><td style="text-align:center;" colspan="3">'.lang('no_shops').'</td></tr>':''?>
<?php foreach ($shops as $shop):?>
		<tr>
			<td><?php echo  $shop->shop_id; ?></td>
			<td>
			  <?php echo  $shop->shop_name; ?>
			</td>
                        <td><?php echo $shop->shop_creation_date; ?></td>
			<td>
				<div class="btn-group" style="float:right;">
					<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/shops/form/'.$shop->shop_id); ?>"><i class="icon-pencil"></i> <?php echo lang('edit');?></a>
					<a class="btn btn-danger" href="<?php echo site_url($this->config->item('admin_folder').'/shops/delete/'.$shop->shop_id); ?>" onclick="return areyousure();"><i class="icon-trash icon-white"></i> <?php echo lang('delete');?></a>
				</div>
			</td>
	  </tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php include('footer.php'); ?>
