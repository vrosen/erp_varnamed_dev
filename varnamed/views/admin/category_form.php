<?php include('header.php'); ?>
<link href='http://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>
<style>
input[type="text"] {
text-align:right;
}
.method {
margin-top: 25px;
margin-bottom:25px;
}
.method td {
height:25px;
}
</style>

	<?php
		$data_nl	= array('name'=>'name_nl', 'value'=>set_value('name_nl', $name_nl), 'class'=>'form-control');
		$data_be	= array('name'=>'name_be', 'value'=>set_value('name_be', $name_be), 'class'=>'form-control');
		$data_de	= array('name'=>'name_de', 'value'=>set_value('name_de', $name_de), 'class'=>'form-control');
		$data_au	= array('name'=>'name_au', 'value'=>set_value('name_au', $name_au), 'class'=>'form-control');
		$data_fr	= array('name'=>'name_fr', 'value'=>set_value('name_fr', $name_fr), 'class'=>'form-control');
		$data_bel	= array('name'=>'name_bel', 'value'=>set_value('name_bel',$name_bel), 'class'=>'form-control');
		$data_lx	= array('name'=>'name_lx', 'value'=>set_value('name_lx', $name_lx), 'class'=>'form-control');
		$data_uk	= array('name'=>'name_uk', 'value'=>set_value('name_uk', $name_uk), 'class'=>'form-control');
		
		$data_textarea	= array('name'=>'description', 'class'=>'redactor', 'value'=>set_value('description', $description));
	?>
	
	
	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo $category_title; ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">

				<?php echo form_open_multipart($this->config->item('admin_folder').'/categories/form/'.$id.'/'.$token); ?>

					<div class="tabbable">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#general_tab" data-toggle="tab"><?php echo lang('general');?></a></li>
							<li><a href="#features_tab" data-toggle="tab"><?php echo lang('features');?></a></li>
						</ul>

						<div class="tab-content">
						<br/>
						<br/>
						<br/>
							<div class="tab-pane active" id="general_tab">
			
								<table class="table table-condensed" style="border: 1px solid #ddd; width:50%;">
										<tr>
											<th style="font-family: 'Raleway', sans-serif; width:30%; padding-left: 10px;"><?php echo lang('name_nl');?></th><td><?php echo form_input($data_nl); ?></td>
										</tr>	
										<tr>	
											<th style="font-family: 'Raleway', sans-serif; padding-left: 10px;"><?php echo lang('name_be');?></th><td><?php echo form_input($data_be); ?></td>
										</tr>	
										<tr>	
											<th style="font-family: 'Raleway', sans-serif; padding-left: 10px;"><?php echo lang('name_bel');?></th><td><?php echo form_input($data_bel); ?></td>
										</tr>
										<tr>	
											<th style="font-family: 'Raleway', sans-serif; padding-left: 10px;"><?php echo lang('name_de');?></th><td><?php echo form_input($data_de); ?></td>
										</tr>	
										<tr>	
											<th style="font-family: 'Raleway', sans-serif; padding-left: 10px;"><?php echo lang('name_au');?></th><td><?php echo form_input($data_au); ?></td>
										</tr>	
										<tr>	
											<th style="font-family: 'Raleway', sans-serif; padding-left: 10px;"><?php echo lang('name_fr');?></th><td><?php echo form_input($data_fr); ?></td>
										</tr>	
										<tr>		
											<th style="font-family: 'Raleway', sans-serif; padding-left: 10px;"><?php echo lang('name_lx');?></th><td><?php echo form_input($data_lx); ?></td>
										</tr>
										<tr>		
											<th style="font-family: 'Raleway', sans-serif; padding-left: 10px;"><?php echo lang('name_uk');?></th><td><?php echo form_input($data_uk); ?></td>
										</tr>
								</table>
								<br/>
								<div class="table table-striped" style="padding: 5px;  width: 50%;  margin-bottom:15px;">
									<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('description');  ?></legend></fieldset>
										<?php echo form_textarea($data_textarea); ?>
								</div>

						</div>

		<div class="tab-pane" id="features_tab">
			
							<table class="table table-condensed" style="border: 1px solid #ddd; width:50%;">
										<tr>
											<th style="font-family: 'Raleway', sans-serif; width:30%; padding-left: 10px;"><?php echo lang('slug');?></th>
											<?php	$data	= array('name'=>'slug', 'value'=>set_value('slug', $slug),'class'=>'form-control');	?>
											<td><?php echo form_input($data); ?></td>
										</tr>											
										<tr>
											<th style="font-family: 'Raleway', sans-serif; width:30%; padding-left: 10px;"><?php echo lang('sequence');?></th>
											<?php	$data	= array('name'=>'sequence', 'value'=>set_value('sequence', $sequence),'class'=>'form-control');	?>
											<td><?php echo form_input($data); ?></td>
										</tr>											
										<tr>
											<th style="font-family: 'Raleway', sans-serif; width:30%; padding-left: 10px;"><?php echo lang('seo_title');?></th>
											<?php	$data	= array('name'=>'seo_title', 'value'=>set_value('seo_title', $seo_title),'class'=>'form-control');	?>
											<td><?php echo form_input($data); ?></td>
										</tr>											
										<tr>
											<th style="font-family: 'Raleway', sans-serif; width:30%; padding-left: 10px;"><?php echo lang('meta');?></th>
											<?php	$data	= array('rows'=>3, 'name'=>'meta', 'value'=>set_value('meta', html_entity_decode($meta)),'class'=>'form-control');	?>
											<td><?php echo form_textarea($data); ?><p class="help-block"><?php echo lang('meta_data_description');?></p></td>
											
										</tr>
							</table>			
			
		</div>

	</div>
</div>
</div>
</div>

<div class="form-actions">
	<button type="submit" class="btn btn-info"><?php echo lang('form_save');?></button>
	<a class="btn btn-info" href="<?php echo site_url($this->config->item('admin_folder').'/categories/'); ?>">Back</a>
</div>
</form>

<script type="text/javascript">
$('form').submit(function() {
	$('.btn').attr('disabled', true).addClass('disabled');
});
</script>
<?php include('footer.php');