<?php include('header.php'); ?>


   	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">Client Files<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped table-hover" style="border: 1px solid #ddd;">
						<thead>
							<tr>
								<th><?php echo lang('name'); ?></th>
								<th>Date<?php //echo lang('size'); ?></th>
								<th><?php echo lang('size'); ?></th>
								<th><?php echo lang('delete'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($files)): ?>
								<?php foreach ($files as $file): ?>
									<?php if(!is_dir($file)): ?>
										<tr>
											<td><a href="<?php echo $path.'/'.$file; ?>" download=""><?php echo $file; ?></a></td>
										   <td></td>
										   <td></td>
											<td style="text-align: center; width: 50px;">
												<a class="glyphicon glyphicon-trash" style="display: inline-block; font-size: 13px;" onclick="return areyousure();" href="<?php echo base_url($this->config->item('admin_folder').'/customers/delete_file/'.$id.'/'.$file); ?>"><?php //echo lang('form_view')?></a>
											</td>
										</tr>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
							<tfoot>
								<tr>&nbsp;</tr>
							</tfoot>
						<?php //echo $error;?>
					</table>    
				</div>
			</div>

			<div class="panel panel-default" style="width: 100%; float: left;">
				<div class="panel-body">
					<?php echo form_open_multipart($this->config->item('admin_folder').'/customers/do_upload/'.$id); ?>
						<table class="table table-striped" style="border: 1px solid #ddd;">
							<tr>
								<td style="width: 50%;">
									<input type="file" name="userfile" size="20" />
								</td>
								<td>
									<input type="submit" class="btn btn-info" value="upload" />
								</td>
							</tr>
						</table>	
					</form>
				</div>
			</div>
			<button type="submit" class="btn btn-info" onclick="history.go(-1); return false;" >Back<?php //echo lang('form_save');?></button>

			<script type="text/javascript">
			function areyousure()
			{
				return confirm('<?php echo 'Do you want to delete these file?';?>');
			}

			</script>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
<?php include('footer.php'); ?>
