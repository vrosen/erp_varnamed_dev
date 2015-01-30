<?php include('header.php'); ?>

<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete');?>');
}
</script>
<?php if($bitauth->is_admin()): ?>	
        <div style="text-align:right;">
            <a class="btn btn-default btn-sm" href="<?php echo site_url($this->config->item('admin_folder').'/admin'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('view_all_users');?></a>
            <a class="btn btn-default btn-sm" href="<?php echo site_url($this->config->item('admin_folder').'/admin/add_user'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_admin');?></a>
            <a class="btn btn-default btn-sm" href="<?php echo site_url($this->config->item('admin_folder').'/admin/groups'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('view_groups');?></a>
            <a class="btn btn-default btn-sm" href="<?php echo site_url($this->config->item('admin_folder').'/admin/add_group'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_group');?></a>
            
        </div>
<?php endif; ?>
<table class="table table-hover">
	<?php

                echo '<thead>';
                
		echo '<tr><th width="1">ID</th><th>Name</th><th>Description</th><th>Actions</th></tr>';
                echo '</thead>';
		foreach($groups as $_group)
		{
			$actions = '';
			if($bitauth->has_role('admin'))
			{
				$actions = anchor($this->config->item('admin_folder').'/admin/edit_group/'.$_group->group_id."/w", lang('edit_group'),'class="btn btn-info btn-sm"');

			}

			echo '<tr>'.
				'<td>'.$_group->group_id.'</td>'.
				'<td>'.$_group->name.'</td>'.
				'<td>'.$_group->description.'</td>'.
				'<td>'.$actions.'</td>'.
			'</tr>';
		}
	?>
</table>
<?php include('footer.php'); ?>