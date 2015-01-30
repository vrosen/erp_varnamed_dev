<?php include('header.php'); ?>
<link href='http://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>
<?php
$no_group = $this->session->flashdata('no_group');
if(!empty($no_group)){
echo $no_group;
}


?>

<!--^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^-->
<?php echo form_open_multipart($this->config->item('admin_folder').'/groups/form/'.$group_id); ?>
	<div class="grupForm-panel-body panel panel-default group-form-panel" style="width: 100%; float: left;">
		<div class="panel-heading">
                        <?php 
                            if(!empty($group_name_Nederland)){
                                    echo $group_name_Nederland;
                            }else { 
                                    echo 'New Group'; 
                            }
                        ?>
                    <span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
                </div>

                <div class="panel-body">
                    <div class="tabbable">

					<ul class="nav nav-tabs">
						<li class="active"><a href="#genral_tab" data-toggle="tab">General<?php //echo lang('description'); ?></a></li>
						<?php if(!empty($group_id)): ?>
							<li><a href="#nederland_tab" data-toggle="tab"><?php echo lang('nederland'); ?></a></li>
							<li><a href="#germany_tab" data-toggle="tab"><?php echo lang('germany'); ?></a></li>						
							<li><a href="#austria_tab" data-toggle="tab"><?php echo lang('austria'); ?></a></li>
							<li><a href="#belguim_dutch_tab" data-toggle="tab"><?php echo lang('belgium_dutch'); ?></a></li>
							<li><a href="#belguim_french_tab" data-toggle="tab"><?php echo lang('belgium_france'); ?></a></li>
							<li><a href="#france_tab" data-toggle="tab"><?php echo lang('france'); ?></a></li>
							<li><a href="#luxembourg_tab" data-toggle="tab"><?php echo lang('luxembourg'); ?></a></li>
							<li><a href="#uk_tab" data-toggle="tab"><?php echo lang('uk'); ?></a></li>
						<?php endif; ?>
					</ul>

                    <div class="tab-content">
						<div class="tab-pane active" id="genral_tab">
						<div class="groupForm-wrapper-froms full-width clearfix">
						<br/><br/>
									<table class="table table-condensed custom-table-condensed general-custom-table" style="border: 1px solid #ddd; width: 100%; float: left;">
											<tr class="custom-style-tr">
												<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
													<?php echo lang('group_name'); ?>
												</td>
												<td class="custom-style-td-value custom-general-style-td-value">
													<input style="width:99%; margin-left: 3px;" type="text" name="group_name" value="<?php echo $group_name; ?>" class="form-control" required/>
												</td>
											</tr>			
											<tr class="custom-style-tr">
												<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
													<?php echo lang('slug_'); ?>
												</td>
												<td class="custom-style-td-value custom-general-style-td-value">
													<input style="width:99%; margin-left: 3px;" type="text" name="slug" placeholder="What to see in the URL when on the group page" value="<?php echo $slug; ?>" class="form-control" required/>
												</td>
											</tr>
											<tr class="custom-style-tr">
												<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
													<?php echo lang('category'); ?>
												</td>
												<td class="custom-style-td-value custom-general-style-td-value">
													<select id="category_search" name="category_search" style="width: 99%; padding-left: 9px !important; margin: 0px; height: 32px; margin-top: 8px; border-radius: 1px;" >
														<option style=" border: 1px solid rgba(44, 33, 61, 0.580392) !important; border-radius: 4px; padding-left: 9px !important; outline: none; margin: 0px; height: 90px;" value="0">Select category</option>
																						<?php 
																							if(!empty($cat_id)){
																									?><option value="<?php echo $cat_id; ?>" selected><?php echo $all_categories[$cat_id]; ?></option><?php
																								foreach ($all_categories as  $key=>$value){
																									?><option value="<?php echo $key; ?>"><?php echo $value; ?></option><?php
																								}
																							}else {
																							if(!empty($cat)){
																								?><option value="<?php echo $cat; ?>" selected><?php echo $all_categories[$cat]; ?></option><?php
																							}
																							foreach ($all_categories as $key=>$value){
																									?><option value="<?php echo $key; ?>"><?php echo $value; ?></option><?php
																								}		
																							}
																						 ?>
													</select>
												</td>
											</tr>
											<tr class="custom-style-tr">
											<td class="custom-style-td-label groupProduct-style-td" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
												<?php echo lang('meta'); ?>
											</td>
												<td class="custom-style-td-value custom-general-style-td-value" style="max-width: 369px!important;">
													<?php
														$data	= array('rows'=>3, 'name'=>'meta', 'value'=>set_value('meta', html_entity_decode($meta)), 'style'=>'width: 99%;  border: 1px solid rgba(44, 33, 61, 0.580392) !important; border-radius: 4px; padding-left: 9px !important; outline: none; margin: 0px; margin-top: 7px;','class'=>'');
														echo form_textarea($data);
													?>
												</td>
											</tr>
											<tr class="custom-style-tr">
												<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
													<?php echo lang('seo_title'); ?>
												</td>
												<td class="custom-style-td-value custom-general-style-td-value" style="min-width: 369px!important;">
													<?php
														$data	= array('name'=>'seo_title', 'value'=>set_value('seo_title', $seo_title), 'style'=>'width: 99%;','class'=>'form-control');
														echo form_input($data);
													?>
												</td>
											</tr>
											<tr class="custom-style-tr">
												<td class="custom-style-td-label groupProduct-style-td" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
													<?php echo lang('image'); ?>
												</td>
												<td class="custom-general-style-td-value">
													<?php echo form_upload(array('name'=>'image','class'=>'general-no-border form-control groupForm-choose-file','style'=>'width: 99%')); ?>
												</td>
											</tr>
									</table>
										<br>
										<button type="submit" class="custom-description-save btn btn-info"><?php echo lang('form_save');?></button>
									</form>
									<br/>
									<br/>
									</div> <!--/ .groupForm-wrapper-froms clearfix" -->
										<?php echo form_open_multipart($this->config->item('admin_folder').'/groups/do_upload/'.$group_id); ?>
										
												<div class="table table-striped choose-file-general groupForm-table-add-file" style="padding: 5px;  width: 99%; float:left;">
													<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('upload_files');  ?></legend></fieldset>
														<tr>
															<td>
																<input type="file" class="groupForm-choose-file"  name="userfile" size="20" />
																<input type="submit" class="custom-button btn btn-info de-custom-submit" value="upload" />
															</td>
														</tr>
												</div>	
												
												<div class="wrapper-files" style="padding: 5px;  width: 100%;  margin-bottom:15px; min-width: 680px;">
												<table class="table table-striped table-hover general-table-files" style="border: 1px solid #ddd;">
													<thead>
														<tr>
															<th><?php echo lang('name'); ?></th>
															<th style="min-width: 25px!important"><?php echo lang('date'); ?></th>
															<th style="min-width: 25px!important"><?php echo lang('size'); ?></th>
															<th style="min-width: 25px!important"><?php echo lang('delete'); ?></th>
														</tr>
													</thead>
													<tbody>
														<?php if(!empty($files)): ?>
															<?php foreach ($files as $file): ?>
																<?php if(!is_dir($file)): ?>
																	<tr>
																		<td class="style-td"><a href="<?php echo $path.'/'.$file; ?>" download=""><?php echo $file; ?></a></td>
																	   <td></td>
																	   <td></td>
																		<td class="delete-icon" style="text-align: center; width: 50px;">
																			<a class="glyphicon glyphicon-trash" style="display: inline-block; font-size: 13px;" onclick="return areyousure();" href="<?php echo base_url($this->config->item('admin_folder').'/groups/delete_file/'.$group_id.'/'.$file); ?>"><?php //echo lang('form_view')?></a>
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
									</form>												
						</div>

						
						<?php if(!empty($group_id)): ?>
						<!-- ------- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane" id="nederland_tab">
						<div class="groupForm-wrapper-froms full-width clearfix">
						<br/><br/>
						

								<div class="groupForm-select table table-striped" style="padding: 5px;  width: 100%;  margin-bottom:15px; float: left;">
									<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('');  ?></legend></fieldset>
										<?php $js_spec_0 = 'id="same_spec" class="form-control" style="width: 220px;" onChange="qwerty_0();"';  ?>
										<?php echo form_dropdown('same_spec',$same_specification_nl,'-1',$js_spec_0); ?>
								</div>
								<script>
									function qwerty_0(){
												$.ajax({
													url: qqurl+"admin/groups/set_same_spec",
													dataType: "json",
													type: "POST",
													data: {
														id: "<?php echo $group_id; ?>",
														same_spec: $("#same_spec").val(),
														spec_from: 'NL',
													}, 
													success: function (data) {
													
														$.each(data, function(key, value){
														//alert(key);
															$('.form-control[name='+key+']').val(value);
															$('.redactor[name='+key+']').val(value);
														});
													location.reload(); 
													}
										   });
									}			
									</script>

								<?php echo form_open($this->config->item('admin_folder').'/groups/form_NL/'.$group_id, array('class' => 'nederland-form1')); ?>

													<table class="table table-condensed custom-table-condensed" style="border: 1px solid #ddd; width: 45%; float: left;">
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('name'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="group_name_Nederland" placeholder="<?php echo lang('group_name_Nederland'); ?>" class="form-control"  value="<?php echo $group_name_Nederland; ?>" />
															</td>
														</tr>	
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('header'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="header_Nederland" placeholder="<?php echo lang('header_Nederland'); ?>" class="form-control"  value="<?php echo $header_Nederland; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('brand'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="nick_Nederland" class="form-control" placeholder="<?php echo lang('nick_name_Nederland'); ?>" value="<?php echo $nick_Nederland; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('price').' '.lang('nederland'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="saleprice_NL" placeholder="<?php echo lang('saleprice_name_Nederland'); ?>" class="form-control" value="<?php echo $saleprice_NL; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('amount_price'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="amount_NL" placeholder="<?php echo lang('amount_price'); ?>" class="form-control" value="<?php echo $amount_NL; ?>" />
															</td>
														</tr>
															<?php if(!empty($links_NL)): ?>
																<?php foreach($links_NL as $link): ?>
																	<?php $num=''; ?>
																	<tr>
																		<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
																			<?php echo lang('link').$num; ?>
																		</td>
																		<td>
																			<input style="width:99%; margin-left: 3px;" type="text" name=""  class="form-control" value="<?php echo $link; ?>" />
																		</td>
																		<td class="delete-icon" style="border: none!important;"><a onclick="return areyousure();" href="<?php echo site_url($this->config->item('admin_folder').'/groups/delete_link/'.$group_id.'/'.$link.'/'.'NL' ); ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
																	</tr>
																	<?php echo $num++; ?>
																<?php endforeach; ?>
															<?php endif; ?>
														</table>
														<br/>
														<div class="table table-striped" style="padding: 5px;  width: 50%;  margin-bottom:5px; float:left;">
															<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('description');  ?></legend></fieldset>
																<tr>
																	<td>
																		<?php
																			$data_description_NL	= array('name'=>'description_NL', 'value'=>$description_NL,'class'=>'redactor','style' => ' min-width: 530px!important; padding: 5px; margin: 5px 5px 3px 2px;', 'rows' => '1');
																			echo form_textarea($data_description_NL);
																		?>
																	</td>
																</tr>
														</div>
													<br/>
													<button type="submit" class="custom-description-save btn btn-info"><?php echo lang('form_save');?></button>					
								</form>
								<br/>
								</div> <!--/ .groupForm-wrapper-froms clearfix" -->
								<?php echo form_open_multipart($this->config->item('admin_folder').'/groups/upload_links/'.$group_id); ?>
										
												<div class="table table-striped groupForm-table-add-file choose-filegroupForm-table-add-file" style="padding: 5px;  width: 99%; margin-right:55%; float:left;">
														<tr>
																<input type="file" class="groupForm-choose-file" name="userfile" size="20" />
																<input type="text" class="form-control input-link" name="link_1" />
																<input type="submit" class="custom-button btn btn-info nl-custom-submit" value="Add new link" />
																<input type="hidden" name="country_link" value="NL">
														</tr>
												</div>	
											<button type="submit" class="groupForm-save-selected-file btn btn-info de-custom-submit"><?php echo lang('form_save');?></button>
									</form>	
							<?php endif; ?>
						</div>	
						<!-- ------- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->						
						<div class="tab-pane" id="germany_tab">
						<div class="groupForm-wrapper-froms full-width clearfix">
						<br/><br/>
						

								<div class="groupForm-select table table-striped" style="padding: 5px;  width: 100%;  margin-bottom:15px; float: left;">
									<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('');  ?></legend></fieldset>
										<?php $js_spec_1 = 'id="same_spec_1" class="form-control" style="width: 220px;" onChange="qwerty_1();"';  ?>
										<?php echo form_dropdown('same_spec_1',$same_specification_de,'-1',$js_spec_1); ?>
								</div>
								<script>


									function qwerty_1(){
												$.ajax({
													url: qqurl+"admin/groups/set_same_spec",
													dataType: "json",
													type: "POST",
													data: {
														id: "<?php echo $group_id; ?>",
														same_spec: $("#same_spec_1").val(),
														spec_from: 'DE',
													}, 
													success: function (data) {
													
														$.each(data, function(key, value){
														//alert(key);
															$('.form-control[name='+key+']').val(value);
															$('.redactor[name='+key+']').val(value);
														});
													location.reload(); 
													}
										   });
									}			
								</script>
						<?php if(!empty($group_id)): ?>
							<?php echo form_open($this->config->item('admin_folder').'/groups/form_DE/'.$group_id, array('class' => 'nederland-form1')); ?>

											<table class="table table-condensed custom-table-condensed" style="border: 1px solid #ddd; width: 45%; float: left;">
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('name'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="group_name_Deutschland" placeholder="<?php echo lang('group_name_Germany'); ?>" class="form-control"  value="<?php echo $group_name_Deutschland; ?>" />
															</td>
														</tr>
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('header'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="header_Deutschland" placeholder="<?php echo lang('header_Deutschland'); ?>" class="form-control"  value="<?php echo $header_Deutschland; ?>" />
															</td>
														</tr>
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('brand'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="nick_Deutschland" class="form-control" placeholder="<?php echo lang('nick_name_Germany'); ?>" value="<?php echo $nick_Deutschland; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('price').' '.lang('germany'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="saleprice_DE" placeholder="<?php echo lang('saleprice_name_Germany'); ?>" class="form-control" value="<?php echo $saleprice_DE; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('amount_price'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="amount_DE" placeholder="<?php echo lang('amount_price'); ?>" class="form-control" value="<?php echo $amount_DE; ?>" />
															</td>
														</tr>
														
														<?php if(!empty($links_DE)): ?>
															<?php foreach($links_DE as $link): ?>
																<tr>
																	<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
																		<?php echo lang('link_1'); ?>
																	</td>
																	<td>
																		<input style="width:99%; margin-left: 3px;" type="text" name=""  class="form-control" value="<?php echo $link; ?>" />
																	</td>
																	<td class="delete-icon" style="border:none!important;"><a onclick="return areyousure();" href="<?php echo site_url($this->config->item('admin_folder').'/groups/delete_link/'.$group_id.'/'.$link.'/'.'DE' ); ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
																</tr>
															<?php endforeach; ?>	
														<?php endif; ?>	
														</table>
														<br/>
														<div class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:5px; float:left;">
															<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('description');  ?></legend></fieldset>
																<tr>
																	<td>
																		<?php
																			$data_description_DE	= array('name'=>'description_DE', 'value'=>$description_DE, 'class'=>'redactor','style' => ' min-width: 530px!important; padding: 5px; margin: 5px 5px 3px 2px;', 'rows' => '1', 'placeholder' => '');
																			echo form_textarea($data_description_DE);
																		?>
																	</td>
																</tr>
														</div>

													<br/>
													<button type="submit" class="custom-description-save btn btn-info"><?php echo lang('form_save');?></button>				
							</form>
								<br/>
								</div> <!--/ .groupForm-wrapper-froms clearfix" -->
								<?php echo form_open_multipart($this->config->item('admin_folder').'/groups/upload_links/'.$group_id); ?>
										
												<div class="table table-striped groupForm-table-add-file" style="padding: 5px;  width: 99%; float:left;">
														<tr>
																<input type="file" class="groupForm-choose-file" name="userfile" size="20" />
																<input type="text" class="form-control input-link" name="link_1" />
																<input type="submit" class="custom-button btn btn-info de-custom-submit" value="Add new link" />
																<input type="hidden" name="country_link" value="DE">
														</tr>
												</div>	
											<button type="submit" class="groupForm-save-selected-file btn btn-info de-custom-submit"><?php echo lang('form_save');?></button>
									</form>	
							<?php endif; ?>
						</div>
						<!-- ------- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane" id="austria_tab">
						<div class="groupForm-wrapper-froms full-width clearfix">
						<br/><br/>
								<div class="groupForm-select table table-striped" style="padding: 5px;  width: 100%;  margin-bottom:15px; float: left;">
									<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('');  ?></legend></fieldset>
										<?php $js_spec_2 = 'id="same_spec_2" class="form-control" style="width: 220px;" onChange="qwerty_2();"';  ?>
										<?php echo form_dropdown('same_spec_2',$same_specification_at,'-1',$js_spec_2); ?>
								</div>
								<script>
									function qwerty_2(){

												$.ajax({
													url: qqurl+"admin/groups/set_same_spec",
													dataType: "json",
													type: "POST",
													data: {
														id: "<?php echo $group_id; ?>",
														same_spec: $("#same_spec_2").val(),
														spec_from: 'AT',
													}, 
													success: function (data) {
													
														$.each(data, function(key, value){
														//alert(key);
															$('.form-control[name='+key+']').val(value);
															$('.redactor[name='+key+']').val(value);
														});

													}
										   });
									}	

								</script>

						<?php if(!empty($group_id)): ?>
							<?php echo form_open($this->config->item('admin_folder').'/groups/form_AU/'.$group_id,array('class' => 'nederland-form1')); ?>

											<table class="table table-condensed custom-table-condensed" style="border: 1px solid #ddd; width: 45%; float: left;">
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('name'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="group_name_Österreich" placeholder="<?php echo lang('group_name_Austria'); ?>" class="form-control"  value="<?php echo $group_name_Österreich; ?>" />
															</td>
														</tr>
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('header'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="header_Österreich" placeholder="<?php echo lang('header_Österreich'); ?>" class="form-control"  value="<?php echo $header_Österreich; ?>" />
															</td>
														</tr>
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('brand'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="nick_Österreich" class="form-control" placeholder="<?php echo lang('nick_name_Austria'); ?>" value="<?php echo $nick_Österreich; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('price').' '.lang('austria'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="saleprice_AU" placeholder="<?php echo lang('saleprice_name_Austria'); ?>" class="form-control" value="<?php echo $saleprice_AU; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('amount_price'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="amount_AU" placeholder="<?php echo lang('amount_price'); ?>" class="form-control" value="<?php echo $amount_AU; ?>" />
															</td>
														</tr>

														<?php if(!empty($links_AT)): ?>
															<?php foreach($links_AT as $link): ?>
																<tr>
																	<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
																		<?php echo lang('link_1'); ?>
																	</td>
																	<td>
																		<input style="width:99%; margin-left: 3px;" type="text" name=""  class="form-control" value="<?php echo $link; ?>" />
																	</td>
																	<td class="delete-icon" style="border:none!important;"><a onclick="return areyousure();" href="<?php echo site_url($this->config->item('admin_folder').'/groups/delete_link/'.$group_id.'/'.$link.'/'.'AT' ); ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
																</tr>
															<?php endforeach; ?>	
														<?php endif; ?>	
														</table>
														<br/>

														<div class="table table-striped" id="zaq" style="padding: 5px;  width: 50%;  margin-bottom:5px; float:left;">
																<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('description');  ?></legend></fieldset>
																
				
																
																<textarea style="min-width: 530px!important; padding: 5px; margin: 5px 5px 3px 2px;" class="form-control redactor" name="description_AU" id="primary_description" cols="4" rows="10"><?php echo $description_AU; ?></textarea>

																
																<a  class="groupProduct-custom-edit btn btn-info" onclick="ff();" style="display: inline-block; font-size: 11px;"  data-toggle="modal" href="#myModal_N" href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/contact_form/');?>">Edit<?php //echo lang('form_view')?></a>
														</div>
													<br/>
													<button type="submit" class="custom-edit custom-description-save btn btn-info"><?php echo lang('form_save');?></button>							
							</form>
								<br/>
								</div> <!--/ .groupForm-wrapper-froms clearfix" -->
								<script>
									function ff(){
										var jj = $('#primary_description').val();
										$('#description_AU').val(jj);
										
									}
									
									
								</script>
								<?php echo form_open_multipart($this->config->item('admin_folder').'/groups/upload_links/'.$group_id); ?>
										
												<div class="table table-striped groupForm-table-add-file" style="padding: 5px; width: 99%; float:left;">
														<tr>
																<input type="file" class="groupForm-choose-file" name="userfile" size="20" />
																<input type="text" class="form-control input-link" name="link_1" />
																<input type="submit" class="custom-button btn btn-info de-custom-submit" value="Add new link" />
																<input type="hidden" name="country_link" value="AT">
														</tr>
												</div>	
											<button type="submit" class=" groupForm-save-selected-file btn btn-info de-custom-submit">Add link file<?php //echo lang('form_save');?></button>
									</form>	
						<?php endif; ?>
						</div>

							<div class="modal fade" id="myModal_N" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
								  <div class="modal-content" id="form-content" >
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									  <h4 class="modal-title">Description</h4>
									</div>
										<form action="<?php echo site_url($this->config->item('admin_folder').'/suppliers/contact_form/');?>" id="edit-form" method="post">
											<div class="modal-body">
												<p>
													<table class="table table-striped">
														<tr>
															<td>
																<textarea name="description_AU" id="description_AU" class="form-control" ><?php echo $description_AU; ?></textarea>
															</td>
														</tr>													
													</table>
												</p>
											</div>
											<div class="modal-footer">
											  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											  <button type="submit" class="btn btn-info" id="myFormSubmit" >Save changes</button>
											</div>
										</form>
								  </div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							  </div><!-- /.modal -->

						<!-- ------- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane" id="belguim_dutch_tab">
						<div class="groupForm-wrapper-froms full-width clearfix">
						<br/><br/>
								<div class="groupForm-select table table-striped" style="padding: 5px;  width: 100%;  margin-bottom:15px; float: left;">
									<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('');  ?></legend></fieldset>
										<?php $js_spec_3 = 'id="same_spec_3" class="form-control" style="width: 220px;" onChange="qwerty_3();"';  ?>
										<?php echo form_dropdown('same_spec_3',$same_specification_be,'-1',$js_spec_3); ?>
								</div>
								<script>
									function qwerty_3(){
												$.ajax({
													url: qqurl+"admin/groups/set_same_spec",
													dataType: "json",
													type: "POST",
													data: {
														id: "<?php echo $group_id; ?>",
														same_spec: $("#same_spec_3").val(),
														spec_from: 'BE',
													}, 
													success: function (data) {
													
														$.each(data, function(key, value){
														//alert(key);
															$('.form-control[name='+key+']').val(value);
															$('.redactor[name='+key+']').val(value);
														});
													location.reload(); 
													}
										   });
									}	
                                                                        
								</script>
						<?php if(!empty($group_id)): ?>
							<?php echo form_open($this->config->item('admin_folder').'/groups/form_BE/'.$group_id, array('class' => 'nederland-form1')); ?>

											<table class="table table-condensed custom-table-condensed" style="border: 1px solid #ddd; width: 45%; float: left;">
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('name'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="group_name_Belgie" placeholder="<?php echo lang('group_name_Belgium_Dutch'); ?>" class="form-control"  value="<?php echo $group_name_Belgie; ?>" />
															</td>
														</tr>
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('header'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="header_Belgie" placeholder="<?php echo lang('header_Belgie'); ?>" class="form-control"  value="<?php echo $header_Belgie; ?>" />
															</td>
														</tr>
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('brand'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="nick_Belgie" class="form-control" placeholder="<?php echo lang('nick_name_Belgium_Dutch'); ?>" value="<?php echo $nick_Belgie; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('price').' '.lang('belgium'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="saleprice_BE" placeholder="<?php echo lang('saleprice_name_Belgium_Dutch'); ?>" class="form-control" value="<?php echo $saleprice_BE; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('amount_price'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="amount_BE" placeholder="<?php echo lang('amount_price'); ?>" class="form-control" value="<?php echo $amount_BE; ?>" />
															</td>
														</tr>
														
														<?php if(!empty($links_BE)): ?>
															<?php foreach($links_BE as $link): ?>
																<tr>
																	<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
																		<?php echo lang('link_1'); ?>
																	</td>
																	<td>
																		<input style="width:99%; margin-left: 3px;" type="text" name=""  class="form-control" value="<?php echo $link; ?>" />
																	</td>
																	<td class="delete-icon" style="border:none!important;"><a onclick="return areyousure();" href="<?php echo site_url($this->config->item('admin_folder').'/groups/delete_link/'.$group_id.'/'.$link.'/'.'BE' ); ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
																</tr>
															<?php endforeach; ?>	
														<?php endif; ?>	
														</table>
														<br/>
														<div class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:5px; float:left;">
															<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('description');  ?></legend></fieldset>
																<tr>
																	<td>
																		<?php
																			$data_description_BE	= array('name'=>'description_BE', 'value'=>$description_BE, 'class'=>'redactor','style' =>  ' min-width: 530px!important; padding: 5px; margin: 5px 5px 3px 2px;', 'rows' => '1', 'placeholder' => 'sdfvtg');
																			echo form_textarea($data_description_BE);
																		?>
																	</td>
																</tr>
														</div>
														
													<br/>
													<button type="submit" class="custom-description-save btn btn-info"><?php echo lang('form_save');?></button>		
							</form>
								<br/>
								</div> <!--/ .groupForm-wrapper-froms clearfix" -->
								<?php echo form_open_multipart($this->config->item('admin_folder').'/groups/upload_links/'.$group_id); ?>
										
												<div class="table table-striped groupForm-table-add-file" style="padding: 5px;  width: 99%; float:left;">
														<tr>
																<input type="file" class="groupForm-choose-file" name="userfile" size="20" />
																<input type="text" class="form-control input-link" name="link_1" name="link_1" />
																<input type="submit" class="custom-button btn btn-info de-custom-submit" value="Add new link" />
																<input type="hidden" name="country_link" value="BE">
														</tr>
												</div>	
											<button type="submit" class="groupForm-save-selected-file btn btn-info de-custom-submit"><?php echo lang('form_save');?></button>
									</form>	
							<?php endif; ?>
						</div>
						<!-- ------- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane" id="belguim_french_tab">
						<div class="groupForm-wrapper-froms full-width clearfix">
						<br/><br/>

								<div class="groupForm-select table table-striped" style="padding: 5px;  width: 100%;  margin-bottom:15px; float: left;">
									<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('');  ?></legend></fieldset>
										<?php $js_spec_4 = 'id="same_spec_4" class="form-control" style="width: 220px;" onChange="qwerty_4();"';  ?>
										<?php echo form_dropdown('same_spec_4',$same_specification_bel,'-1',$js_spec_4); ?>
								</div>
								<script>
									function qwerty_4(){
												$.ajax({
													url: qqurl+"admin/groups/set_same_spec",
													dataType: "json",
													type: "POST",
													data: {
														id: "<?php echo $group_id; ?>",
														same_spec: $("#same_spec_4").val(),
														spec_from: 'BEL',
													}, 
													success: function (data) {
													
														$.each(data, function(key, value){
														//alert(key);
															$('.form-control[name='+key+']').val(value);
															$('.redactor[name='+key+']').val(value);
														});
													location.reload(); 
													}
										   });
									}			
								</script>
						<?php if(!empty($group_id)): ?>
							<?php echo form_open($this->config->item('admin_folder').'/groups/form_BEL/'.$group_id, array('class' => 'nederland-form1')); ?>

											<table class="table table-condensed custom-table-condensed" style="border: 1px solid #ddd; width: 45%; float: left;">
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('name'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="group_name_Belgique" placeholder="<?php echo lang('group_name_Belgium_French'); ?>" class="form-control"  value="<?php echo $group_name_Belgique; ?>" />
															</td>
														</tr>
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('header'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="header_Belgique" placeholder="<?php echo lang('header_Belgique'); ?>" class="form-control"  value="<?php echo $header_Belgique; ?>" />
															</td>
														</tr>
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('brand'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="nick_Belgique" class="form-control" placeholder="<?php echo lang('nick_name_Belgium_French'); ?>" value="<?php echo $nick_Belgique; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('price').' '.lang('belgium'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="saleprice_BEL" placeholder="<?php echo lang('saleprice_name_Belgium_France'); ?>" class="form-control" value="<?php echo $saleprice_BEL; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr"> 
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('amount_price'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="amount_BEL" placeholder="<?php echo lang('amount_price'); ?>" class="form-control" value="<?php echo $amount_BEL; ?>" />
															</td>
														</tr>
														
														<?php if(!empty($links_BEL)): ?>
															<?php foreach($links_BEL as $link): ?>
																<tr>
																	<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
																		<?php echo lang('link_1'); ?>
																	</td>
																	<td>
																		<input style="width:99%; margin-left: 3px;" type="text" name=""  class="form-control" value="<?php echo $link; ?>" />
																	</td>
																	<td class="delete-icon" style="border:none!important;"><a onclick="return areyousure();" href="<?php echo site_url($this->config->item('admin_folder').'/groups/delete_link/'.$group_id.'/'.$link.'/'.'BEL' ); ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
																</tr>
															<?php endforeach; ?>	
														<?php endif; ?>	
														</table>
														<br/>
														<div class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:5px; float:left;">
															<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('description');  ?></legend></fieldset>
																<tr>
																	<td>
																		<?php
																			$data_description_BEL	= array('name'=>'description_BEL', 'value'=>$description_BEL, 'class'=>'redactor','style' => ' min-width: 530px!important; padding: 5px; margin: 5px 5px 3px 2px;', 'rows' => '1', 'placeholder' => 'sdfvtg');
																			echo form_textarea($data_description_BEL);
																		?>
																	</td>
																</tr>
														</div>

													<br/>
													<button type="submit" class="custom-description-save btn btn-info"><?php echo lang('form_save');?></button>						
							</form>
								<br/>
								</div> <!--/ .groupForm-wrapper-froms clearfix" -->
								<?php echo form_open_multipart($this->config->item('admin_folder').'/groups/upload_links/'.$group_id); ?>
										
												<div class="table table-striped groupForm-table-add-file" style="padding: 5px;  width: 99%;  float:left;">
														<tr>
																<input type="file" class="groupForm-choose-file" name="userfile" size="20" />
																<input type="text" class="form-control input-link" name="link_1" />
																<input type="submit" class="custom-button btn btn-info de-custom-submit" value="Add new link" />
																<input type="hidden" name="country_link" value="BEL">
														</tr>
												</div>	
											<button type="submit" class="groupForm-save-selected-file btn btn-info de-custom-submit"><?php echo lang('form_save');?></button>
									</form>	
							<?php endif; ?>
						</div>
						<!-- ------- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane" id="france_tab">
						<div class="groupForm-wrapper-froms full-width clearfix">
						<br/><br/>
								<div class="groupForm-select table table-striped" style="padding: 5px;  width: 100%;  margin-bottom:15px; float: left;">
									<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('');  ?></legend></fieldset>
										<?php $js_spec_5 = 'id="same_spec_5" class="form-control" style="width: 220px;" onChange="qwerty_5();"';  ?>
										<?php echo form_dropdown('same_spec_5',$same_specification_fr,'-1',$js_spec_5); ?>
								</div>
								<script>
									function qwerty_5(){
												$.ajax({
													url: qqurl+"admin/groups/set_same_spec",
													dataType: "json",
													type: "POST",
													data: {
														id: "<?php echo $group_id; ?>",
														same_spec: $("#same_spec_5").val(),
														spec_from: 'FR',
													}, 
													success: function (data) {
													
														$.each(data, function(key, value){
														//alert(key);
															$('.form-control[name='+key+']').val(value);
															$('.redactor[name='+key+']').val(value);
														});
													location.reload(); 
													}
										   });
									}			
								</script>
						<?php if(!empty($group_id)): ?>
							<?php echo form_open($this->config->item('admin_folder').'/groups/form_FR/'.$group_id); ?>							

											<table class="table table-condensed custom-table-condensed" style="border: 1px solid #ddd; width: 45%; float: left;">
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('name'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="group_name_France" placeholder="<?php echo lang('group_name_France'); ?>" class="form-control"  value="<?php echo $group_name_France; ?>" />
															</td>
														</tr>
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('header'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="header_France" placeholder="<?php echo lang('header_France'); ?>" class="form-control"  value="<?php echo $header_France; ?>" />
															</td>
														</tr>
														<tr class="custom-style-tr">
															<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
																<?php echo lang('brand'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="nick_France" class="form-control" placeholder="<?php echo lang('nick_name_France'); ?>" value="<?php echo $nick_France; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
																<?php echo lang('price').' '.lang('france'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="saleprice_FR" placeholder="<?php echo lang('saleprice_name_France'); ?>" class="form-control" value="<?php echo $saleprice_FR; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
																<?php echo lang('amount_price'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="amount_FR" placeholder="<?php echo lang('amount_price'); ?>" class="form-control" value="<?php echo $amount_FR; ?>" />
															</td>
														</tr>
														
														<?php if(!empty($links_FR)): ?>
															<?php foreach($links_FR as $link): ?>
																<tr>
																	<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
																		<?php echo lang('link_1'); ?>
																	</td>
																	<td>
																		<input style="width:99%; margin-left: 3px;" type="text" name=""  class="form-control" value="<?php echo $link; ?>" />
																	</td>
																	<td class="delete-icon" style="border:none!important;"><a onclick="return areyousure();" href="<?php echo site_url($this->config->item('admin_folder').'/groups/delete_link/'.$group_id.'/'.$link.'/'.'FR' ); ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
																</tr>
															<?php endforeach; ?>	
														<?php endif; ?>	
														</table>
														<br/>
														
														<div class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:5px; float:left;">
															<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('description');  ?></legend></fieldset>
																<tr>
																	<td>
																		<?php
																			$data_description_FR	= array('name'=>'description_FR', 'value'=>$description_FR, 'class'=>'redactor','style' => 'min-width: 530px!important; padding: 5px; margin: 5px 5px 3px 2px;', 'rows' => '1', 'placeholder' => 'sdfvtg');
																			echo form_textarea($data_description_FR);
																		?>
																	</td>
																</tr>
														</div>

													<br/>
													<button type="submit" class="custom-description-save btn btn-info"><?php echo lang('form_save');?></button>			

							</form>
								<br/>
								</div> <!--/ .groupForm-wrapper-froms clearfix" -->
								<?php echo form_open_multipart($this->config->item('admin_folder').'/groups/upload_links/'.$group_id); ?>
										
												<div class="table table-striped groupForm-table-add-file" style="padding: 5px;  width: 99%;  float:left;">
														<tr>
																<input type="file" class="groupForm-choose-file" name="userfile" size="20" />
																<input type="text" class="form-control input-link" name="link_1" />
																<input type="submit" class="custom-button btn btn-info de-custom-submit" value="Add new link" />
																<input type="hidden" name="country_link" value="FR">
														</tr>
												</div>	
											<button type="submit" class="groupForm-save-selected-file btn btn-info de-custom-submit"><?php echo lang('form_save');?></button>
									</form>	
							<?php endif; ?>
						</div>
						<!-- ------- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane" id="luxembourg_tab">
						<div class="groupForm-wrapper-froms full-width clearfix">
						<br/><br/>
								<div class="groupForm-select table table-striped" style="padding: 5px;  width: 100%;  margin-bottom:15px; float: left;">
									<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('');  ?></legend></fieldset>
										<?php $js_spec_6 = 'id="same_spec_6" class="form-control" style="width: 220px;" onChange="qwerty_6();"';  ?>
										<?php echo form_dropdown('same_spec_6',$same_specification_lx,'-1',$js_spec_6); ?>
								</div>
								<script>
									function qwerty_6(){
												$.ajax({
													url: qqurl+"admin/groups/set_same_spec",
													dataType: "json",
													type: "POST",
													data: {
														id: "<?php echo $group_id; ?>",
														same_spec: $("#same_spec_6").val(),
														spec_from: 'LX',
													}, 
													success: function (data) {
													
														$.each(data, function(key, value){
														//alert(key);
															$('.form-control[name='+key+']').val(value);
															$('.redactor[name='+key+']').val(value);
														});
													location.reload(); 
													}
										   });
									}			
								</script>
						<?php if(!empty($group_id)): ?>
							<?php echo form_open($this->config->item('admin_folder').'/groups/form_LX/'.$group_id, array('class' => 'nederland-form1')); ?>
											<table class="table table-condensed custom-table-condensed" style="border: 1px solid #ddd; width: 45%; float: left;">
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('name'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="group_name_Luxembourg" placeholder="<?php echo lang('group_name_Luxembourg'); ?>" class="form-control"  value="<?php echo $group_name_Luxembourg; ?>" />
															</td>
														</tr>
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('header'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="header_Luxembourg" placeholder="<?php echo lang('header_Luxembourg'); ?>" class="form-control"  value="<?php echo $header_Luxembourg; ?>" />
															</td>
														</tr>
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('brand'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="nick_Luxembourg" class="form-control" placeholder="<?php echo lang('nick_name_Luxembourg'); ?>" value="<?php echo $nick_Luxembourg; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('price').' '.lang('luxembourg'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="saleprice_LX" placeholder="<?php echo lang('saleprice_name_Luxembourg'); ?>" class="form-control" value="<?php echo $saleprice_LX; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('amount_price'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="amount_LX" placeholder="<?php echo lang('amount_price'); ?>" class="form-control" value="<?php echo $amount_LX; ?>" />
															</td>
														</tr>
														
														<?php if(!empty($links_LX)): ?>
															<?php foreach($links_LX as $link): ?>
																<tr>
																	<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
																		<?php echo lang('link_1'); ?>
																	</td>
																	<td>
																		<input style="width:99%; margin-left: 3px;" type="text" name=""  class="form-control" value="<?php echo $link; ?>" />
																	</td>
																	<td class="delete-icon"  style="border:none!important;"><a onclick="return areyousure();" href="<?php echo site_url($this->config->item('admin_folder').'/groups/delete_link/'.$group_id.'/'.$link.'/'.'LX' ); ?>"><span class="glyphicon glyphicon-trash"></a></td>
																</tr>
															<?php endforeach; ?>	
														<?php endif; ?>	
														</table>
														<br/>
														<div class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:5px; float:left;">
															<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('description');  ?></legend></fieldset>
																<tr>
																	<td>
																		<?php
																			$data_description_LX	= array('name'=>'description_LX', 'value'=>$description_LX, 'class'=>'redactor','style' => ' min-width: 530px!important; padding: 5px; margin: 5px 5px 3px 2px;', 'rows' => '1', 'placeholder' => 'sdfvtg');
																			echo form_textarea($data_description_LX);
																		?>
																	</td>
																</tr>
														</div>
														
													<br/>
													<button type="submit" class="custom-description-save btn btn-info"><?php echo lang('form_save');?></button>					
							</form>
								<br/>
								</div> <!--/ .groupForm-wrapper-froms clearfix" -->
								<?php echo form_open_multipart($this->config->item('admin_folder').'/groups/upload_links/'.$group_id); ?>
										
												<div class="table table-striped groupForm-table-add-file" style="padding: 5px;  width: 99%;  float:left;">
														<tr>
																<input type="file" class="groupForm-choose-file" name="userfile" size="20" />
																<input type="text" class="form-control input-link" name="link_1" />
																<input type="submit" class="custom-button btn btn-info de-custom-submit" value="Add new link" />
																<input type="hidden" name="country_link" value="LX">
														</tr>
												</div>	
											<button type="submit" class="groupForm-save-selected-file btn btn-info de-custom-submit"><?php echo lang('form_save');?></button>
									</form>	
							<?php endif; ?>
						</div>
						<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
						<div class="tab-pane" id="uk_tab">
						<div class="groupForm-wrapper-froms full-width clearfix">
						<br/><br/>

						<?php if(!empty($group_id)): ?>
							<?php echo form_open($this->config->item('admin_folder').'/groups/form_UK/'.$group_id); ?>

										<table class="table table-condensed custom-table-condensed" style="border: 1px solid #ddd; width: 45%; float: left;">
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('name'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="group_name_UK" placeholder="<?php echo lang('group_name_UK'); ?>" class="form-control"  value="<?php echo $group_name_UK; ?>" />
															</td>
														</tr>
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('header'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="header_UK" placeholder="<?php echo lang('header_UK'); ?>" class="form-control"  value="<?php echo $header_UK; ?>" />
															</td>
														</tr>
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('brand'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="nick_UK" class="form-control" placeholder="<?php echo lang('nick_name_UK'); ?>" value="<?php echo $nick_UK; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('price').' '.lang('uk'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="saleprice_UK" placeholder="<?php echo lang('saleprice_name_UK'); ?>" class="form-control" value="<?php echo $saleprice_UK; ?>" />
															</td>
														</tr>
														
														<tr class="custom-style-tr">
															<td class="custom-style-td-label" style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 200px;">
																<?php echo lang('amount_price'); ?>
															</td>
															<td class="custom-style-td-value">
																<input style="width:99%; margin-left: 3px;" type="text" name="amount_UK" placeholder="<?php echo lang('amount_price'); ?>" class="form-control" value="<?php echo $amount_UK; ?>" />
															</td>
														</tr>

														<?php if(!empty($links_UK)): ?>
															<?php foreach($links_UK as $link): ?>
																<tr>
																	<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
																		<?php echo lang('link_1'); ?>
																	</td>
																	<td>
																		<input style="width:99%; margin-left: 3px;" type="text" name=""  class="form-control" value="<?php echo $link; ?>" />
																	</td>
																	<td class="delete-icon" style="border:none!important;"><a onclick="return areyousure();" href="<?php echo site_url($this->config->item('admin_folder').'/groups/delete_link/'.$group_id.'/'.$link.'/'.'UK' ); ?>"><span class="glyphicon glyphicon-trash"></a></td>
																</tr>
															<?php endforeach; ?>	
														<?php endif; ?>	
														</table>
														<br/>
														<div class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:5px; float:left;">
															<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('description');  ?></legend></fieldset>
																<tr>
																	<td>
																		<?php
																			$data_description_UK	= array('name'=>'description_UK', 'value'=>$description_UK, 'class'=>'redactor','style' => 'min-width: 530px!important; padding: 5px; margin: 5px 5px 3px 2px;', 'rows' => '1', 'placeholder' => 'sdfvtg');
																			echo form_textarea($data_description_UK);
																		?>
																	</td>
																</tr>
														</div>
													<br/>
													<button type="submit" class="custom-description-save btn btn-info"><?php echo lang('form_save');?></button>	

							</form>
								<br/>
								</div> <!--/ .groupForm-wrapper-froms clearfix" -->
								<?php echo form_open_multipart($this->config->item('admin_folder').'/groups/upload_links/'.$group_id); ?>
										
												<div class="table table-striped groupForm-table-add-file" style="padding: 5px;  width: 99%; float:left;">
														<tr>
																<input type="file" class="groupForm-choose-file" name="userfile" size="20" />
																<input type="text" class="form-control input-link" name="link_1" />
																<input type="submit" class="custom-button btn btn-info de-custom-submit" value="Add new link" />
																<input type="hidden" name="country_link" value="UK">
														</tr>
												</div>	
											<button type="submit" class="groupForm-save-selected-file btn btn-info de-custom-submit"><?php echo lang('form_save');?></button>
									</form>	
						</div>
				<?php endif; ?>
					</div>	

				</div>				
			</div>				
		</div>				

	


<?php include('footer.php'); ?>

			<script type="text/javascript">
			function areyousure()
			{
				return confirm('<?php echo 'Do you want to delete these file?';?>');
			}

			</script>
			<script type="text/javascript">
			$('form').submit(function() {
				$('.btn').attr('disabled', true).addClass('disabled');
			});
			</script>














