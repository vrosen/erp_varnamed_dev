<?php include('header.php');?>

<script type="text/javascript">

<?php if( $this->input->post('submit') ):?>
$(window).ready(function(){
	$('#iframe_uploader', window.parent.document).height($('body').height());	
});
<?php endif;?>

<?php if($file_name):?>
	parent.add_product_image('<?php echo $file_name;?>');
<?php endif;?>

</script>

<?php if (!empty($error)): ?>
	<div class="alert alert-error">
		<a class="close" data-dismiss="alert">×</a>
		<?php echo $error; ?>
	</div>
<?php endif; ?>


	
		<?php echo form_open_multipart($this->config->item('admin_folder').'/products/product_image_upload', 'class="form-inline"');?>
			<table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
				<tr>
					<td>
						<?php echo form_upload(array('name'=>'userfile', 'id'=>'userfile', 'class'=>'input-file'));?> 
					</td>	
					<td>	
						<input class="btn btn-info" name="submit" type="submit" value="<?php echo lang('upload');?>" />
					
					</td>
				</tr>
			</table>	
		</form>


<?php include('footer.php');