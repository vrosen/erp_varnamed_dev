<?php include('header.php'); ?>

<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete');?>');
}
</script>
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


		if( ! empty($users))
		{
                                                    echo '<thead>';
                                echo '<tr>'.
					'<th>'.lang('user_id').'</th>'.
					'<th>'.lang('firstname').'</th>'.
					'<th>'.lang('fullname').'</th>'.
					'<th>'.lang('activ').'</th>'.
				'</tr>';
                                echo '</thead>';
			foreach($users as $_user)
			{
				$actions = '';
				if($bitauth->has_role('admin'))
				{
					$actions = anchor($this->config->item('admin_folder').'/admin/edit_user/'.$_user->user_id, lang('edit_user'),'class="btn btn-primary"');
                                        
                                        
					if( ! $_user->active)
					{
						$actions .= '<br/>'.anchor($this->config->item('admin_folder').'/admin/activate/'.$_user->activation_code, 'Activate User');
					}

				}


                                echo '<tbody>';
				echo '<tr>'.
					'<td>'.$_user->user_id.'</td>'.
					'<td>'.$_user->username.'</td>'.
					'<td>'.$_user->fullname.'</td>'.
					'<td>'.$actions.'</td>'.
				'</tr>';
                                echo '</tbody>';
			}
		}
                    
                ?>

    <table>
<?php include('footer.php'); ?>
