<?php include('header.php'); ?>

<?php if($bitauth->is_admin()): ?>	
        <div style="text-align:right;">
            <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('view_all_users');?></a>
            <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin/add_user'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_admin');?></a>
            <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin/groups'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('view_groups');?></a>
            <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin/add_group'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_group');?></a>
        </div>
<?php endif; ?>
<table class="table table-striped">
	<?php
		$yesno = array('No','Yes');

		echo form_open($this->config->item('admin_folder').'/admin/edit_user/'.$user->user_id);
                
		echo '<table border="0" cellspacing="0" cellpadding="0" id="table">';


		if( ! empty($user))
		{
		?>      <tr><td><?php echo lang('username'); ?></td><td><?php echo form_input('username', set_value('username', $user->username)); ?></td></tr>
			<tr><td><?php echo lang('fullname'); ?></td><td><?php echo form_input('fullname', set_value('fullname', $user->fullname)); ?></td></tr>
			<tr><td><?php echo lang('email'); ?></td><td><?php echo form_input('email', set_value('email', $user->email)); ?></td></tr>
			<tr><td><?php echo lang('activ'); ?></td><td><?php echo form_dropdown('active', $yesno, set_value('active', $user->active)); ?></td></tr>
			<tr><td><?php echo lang('enabled'); ?></td><td><?php echo form_dropdown('enabled', $yesno, set_value('enabled', $user->enabled)); ?></td></tr>
			<tr><td><?php echo lang('pass_bnever_expires'); ?></td><td><?php echo form_dropdown('password_never_expires', $yesno, set_value('password_never_expires', $user->password_never_expires)); ?></td></tr>
			<tr><td><?php echo lang('groups'); ?></td><td><?php echo form_multiselect('groups[]', $groups, set_value('groups[]', $user->groups)); ?></td></tr>
			<tr><td colspan="2"><?php echo lang('like_new_pass'); ?></td></tr>
			<tr><td><?php echo lang('new_pass'); ?></td><td><?php echo form_password('password'); ?></td></tr>
			<tr><td><?php echo lang('confirm_new_pass'); ?></td><td><?php echo form_password('password_conf'); ?></td></tr>
                <?php
			if(validation_errors())
			{
				echo '<tr><td colspan="2">'.validation_errors().'</td></tr>';
			}
                        ?>
                        <br>
                        <tr><td>
                                <br>
                        &nbsp;<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('cancel');?></a>
                        <button class="btn btn-primary" type="submit"><?php echo lang('update'); ?></button>
                        </td></tr>
                        <?php

		} else {
			echo '<tr><td><p>User Not Found</p><p>'.anchor($this->config->item('admin_folder').'/admin', 'Go Back').'</p></td></tr>';
		}

		echo form_close();


	?>
    </table>
<?php include('footer.php'); ?>
