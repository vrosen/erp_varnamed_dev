<?php include('header.php'); ?>
<?php
    $username   =   array(
        
        'type'        => 'text',
        'name'        => 'username',
        'class'       => 'input-xlarge focused',
        'id'          => 'focusedInput',
        'value'       => set_value('username'),
    );
    $fullname   =   array(
        
        'type'        => 'text',
        'name'        => 'fullname',
        'class'       => 'input-xlarge focused',
        'id'          => 'focusedInput',
        'value'       => set_value('fullname'),
    );
    $email   =   array(
        
        'type'        => 'email',
        'name'        => 'email',
        'class'       => 'input-xlarge focused',
        'id'          => 'focusedInput',
        'value'       => set_value('email'),
    );
    $password   =   array(
        
        'type'        => 'password',
        'name'        => 'password',
        'class'       => 'input-xlarge focused',
        'id'          => 'focusedInput',
    );
    $password_conf   =   array(
        
        'type'        => 'password',
        'name'        => 'password_conf',
        'class'       => 'input-xlarge focused',
        'id'          => 'focusedInput',
    );
?>
<?php if($bitauth->is_admin()): ?>	
        <div style="text-align:right;">
            <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('view_all_users');?></a>
            <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin/add_user'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_admin');?></a>
            <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin/groups'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('view_groups');?></a>
            <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin/add_group'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_group');?></a>
        </div>
<?php endif; ?>
	<?php echo form_open($this->config->item('admin_folder').'/admin/add_user/'); ?>
    
            <div class="control-group">
                <label class="control-label" for="focusedInput"><?php echo lang('name'); ?></label>
                    <div class="controls">
                    <?php echo form_input($username); ?>
                    </div>
                <label class="control-label" for="focusedInput"><?php echo lang('fullname'); ?></label>
                    <div class="controls">
                    <?php echo form_input($fullname); ?>
                    </div>
                <label class="control-label" for="focusedInput"><?php echo lang('email'); ?></label>
                    <div class="controls">
                    <?php echo form_input($email); ?>
                    </div>
                <label class="control-label" for="focusedInput"><?php echo lang('password'); ?></label>
                    <div class="controls">
                    <?php echo form_input($password); ?>
                    </div>
                <label class="control-label" for="focusedInput"><?php echo lang('confirm_password'); ?></label>
                    <div class="controls">
                    <?php echo form_input($password_conf); ?>
                    </div>
            </div>
    
    
    
            <?php
		if(validation_errors()){
                    
                    echo '<tr><td colspan="2">'.validation_errors().'</td></tr>';
		}
            ?>
                    <button class="btn btn-primary" type="submit"><?php echo lang('save_user'); ?></button>
            <?php
		echo form_close();
            ?>

<?php include('footer.php'); ?>

