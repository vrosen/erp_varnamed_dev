<?php include('header.php'); ?>

<?php
if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}
?>
<br><br><br>
<?php echo form_open($this->config->item('admin_folder').'/dashboard/update');?>

	<table align="left">

		<tr>
                    <td><strong><?php echo lang('date_event'); ?></strong>&nbsp;&nbsp;&nbsp;
			<input type="text" id="date" name="date" size="30" value="<?php echo $event[0]['eventDate'] ;?>" ></td>
                    
                    
		</tr>
		<tr>
			<td><strong><?php echo lang('title_event'); ?></strong>&nbsp;&nbsp;&nbsp;
			<input type="text" id="eventTitle" name="eventTitle" value="<?php echo $event[0]['eventTitle'] ;?>" size="50"></td>
		</tr>
		<tr>
                    <td><strong><?php echo lang('details_event'); ?></strong>&nbsp;&nbsp;&nbsp;
			<textarea class="span8" name="eventContent" id="eventContent"><?php echo $event[0]['eventContent'] ;?></textarea></td>
		</tr>
                    <input type="hidden" name="id" value="<?php echo $event[0]['id'] ;?>" />
		<tr>
                    <td colspan="2"><input class="btn btn-primary" name="add" type="submit" value="<?php echo lang('update');?>"/></td>
		</tr>
	</table>
	</form>
        <div class="row">
	<a class="btn btn-danger" href="<?php echo site_url($this->config->item('admin_folder').'/dashboard/delete/'.$event[0]['id']); ?>"><?php echo lang('delete');?></a>
	</div>
        </div>
<?php include('footer.php'); ?>