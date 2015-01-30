
	<?php 
	if ($this->session->flashdata('message')){
		echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
	}
	?>
	
	<?php echo form_open($this->config->item('admin_folder').'/dashboard/create/'); ?>
		<table align="center">
			<tr>
			<td colspan="2">
					<h2><?php echo lang('add_event'); ?></h2>
			</td>
			</tr>
				<td><?php echo form_input(array('name' => 'date','id' => 'start_top','placeholder' => 'date','type' => 'date' )); ?></td>
			</tr>
			<tr>
				<td><?php echo form_input(array('name' => 'eventTitle','placeholder' => 'title','type' => 'text' )); ?></td>
			</tr>
			<tr>
				<td><textarea class="span4" rows="3" name="eventContent" id="eventContent" placeholder="event"></textarea></td>
			</tr>
			<tr>
			<td><input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>" /></td>
			<td><input type="hidden" name="user" id="nick" value="<?php echo $current_user;?>" /></td>
			</tr>
			<tr>
				<td colspan="2">
					<button class="btn btn-success" type="submit" name="submit" value="add_event"><?php echo lang('add_event'); ?></button>
				</td>
			</tr>
		</table>
	</form>
	
	<script>$('#start_top').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
	
	<?php
	//check if there is any alert message set
	if(isset($alert) && !empty($alert))
	{
		//message alert
		echo $alert;
	}
	?>
