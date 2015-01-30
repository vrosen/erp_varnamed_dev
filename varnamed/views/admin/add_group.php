<?php include('header.php'); ?>

<?php if($bitauth->is_admin()): ?>	
        <div style="text-align:right;">
            <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('view_all_users');?></a>
            <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin/add_user'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_admin');?></a>
            <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin/groups'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('view_groups');?></a>
            <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin/add_group'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_group');?></a>
        </div>
<?php endif; ?>
<table class="table  table-responsive">
	<?php
		echo form_open($this->config->item('admin_folder').'/admin/add_group/');
                ?>
		<tr><td><?php echo lang('group_name'); ?></td><td><?php echo form_input('name', set_value('name')); ?></td></tr>
		<tr><td><?php echo lang('description'); ?></td><td><?php echo form_textarea('description', set_value('description')); ?></td></tr>
		<tr><td><?php echo lang('roles'); ?></td><td><?php echo form_multiselect('roles[]', $roles, set_value('roles[]')); ?></td></tr>
		<tr><td><?php echo lang('members'); ?></td><td><?php echo form_multiselect('members[]', $users, set_value('members[]')); ?></td></tr>
                <?php
		if(validation_errors())
		{
			echo '<tr><td colspan="2">'.validation_errors().'</td></tr>';
		}

		                        ?>
                        <br>
                        <tr><td>
                                <br>
                        <button class="btn btn-primary" type="submit"><?php echo lang('update'); ?></button>
                        </td></tr>
                        <?php
		echo form_close();


	?>
    </table>
<?php include('footer.php'); ?>