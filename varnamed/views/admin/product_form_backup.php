
<?php 

include('header.php');
$GLOBALS['option_value_count']		= 0;
?>
<style type="text/css">
	.sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
	.sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; height: 18px; }
	.sortable li>span { position: absolute; margin-left: -1.3em; margin-top:.4em; }
	
	.option-form {
		display:none;
		margin-top:10px;
		}
	.option-values-form
		{
		background-color:#fff;
		padding:6px 3px 6px 6px;
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
		border-radius: 3px;
		margin-bottom:5px;
		border:1px solid #ddd;
		}
					
	.option-values-form input {
		margin:0px;
		}
	.option-values-form a {
		margin-top:3px;
		}
	.productform { display: inline; width: 40%; margin: 5px; float: right; }
	table tr td {vertical-align: middle;} 	 
</style>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_product_group');?>');
}
</script>
<script type="text/javascript">
//<![CDATA[

$(document).ready(function() {
	$(".sortable").sortable();
	$(".sortable > span").disableSelection();
	//if the image already exists (phpcheck) enable the selector

	<?php if($id) : ?>
	//options related
	var ct	= $('#option_list').children().size();
	// set initial count
	option_count = <?php echo count($product_options); ?>;
	<?php endif; ?>

	photos_sortable();
});

function add_product_image(data)
{
	p	= data.split('.');
	
	var photo = '<?php add_image("'+p[0]+'", "'+p[0]+'.'+p[1]+'", '', '', '', base_url('uploads/images/thumbnails'));?>';
	$('#gc_photos').append(photo);
	$('#gc_photos').sortable('destroy');
	photos_sortable();
}

function remove_image(img)
{
	if(confirm('<?php echo lang('confirm_remove_image');?>'))
	{
		var id	= img.attr('rel')
		$('#gc_photo_'+id).remove();
	}
}

function photos_sortable()
{
	$('#gc_photos').sortable({	
		handle : '.gc_thumbnail',
		items: '.gc_photo',
		axis: 'y',
		scroll: true
	});
}

function remove_option(id)
{
	if(confirm('<?php echo lang('confirm_remove_option');?>'))
	{
		$('#option-'+id).remove();
	}
}

//]]>
</script>


<?php echo form_open($this->config->item('admin_folder').'/products/form/'.$id ); ?>

	<div class="panel panel-default" style="width: 100%; float: left;">
	<!-- Default panel contents -->
		<div class="panel-heading">Product<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
		</div>
		<div class="panel-body">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#product_info" data-toggle="tab"><?php echo lang('details');?></a></li>
                        <?php //if there aren't any files uploaded don't offer the client the tab
                            if (count($file_list) > 0):?>
							<li><a href="#product_downloads" data-toggle="tab"><?php echo lang('digital_content');?></a></li>
							<?php endif;?>
							<li><a href="#product_categories" data-toggle="tab"><?php echo lang('categories');?></a></li>
											<li><a href="#product_groups" data-toggle="tab"><?php echo lang('groups');?></a></li>
							<!-- <li><a href="#product_options" data-toggle="tab"><?php //echo lang('options');?></a></li> -->
							<!-- <li><a href="#product_related" data-toggle="tab"><?php echo lang('related_products');?></a></li> -->
							<li><a href="#product_photos" data-toggle="tab"><?php echo lang('images');?></a></li>
				</ul>
			</div>
		<div class="tab-content">
			<div class="tab-pane active" id="product_info"><br><br>
				<div style="padding: 5px;">
					<div class="col-md-12 table-responsive" >
						<table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
								<fieldset>
									<legend>Basic<?php //echo lang('inventory');?></legend>
								</fieldset>
									<tbody>
										<tr>
											<td>
												<label for="code"><?php echo lang('code');?></label>&nbsp;&nbsp;&nbsp;&nbsp;
													<?php
														$data	= array('name'=>'code', 'value'=>set_value('code', $code));
														echo form_input(str_replace('/','',$data));
													?>
											</td>
										</tr>	
											
										<tr>
											<td>
												<label for="saleprice"><?php echo lang('name');?></label>&nbsp;&nbsp;&nbsp;&nbsp;
												<?php
													$data	= array('name'=>'name', 'value'=>set_value('name', $name));
													echo form_input($data);
												?>
											</td>
										</tr>
										<tr>
											<td>
												<label for="saleprice"><?php echo lang('type');?></label>&nbsp;&nbsp;&nbsp;&nbsp;
												<?php
													$data	= array('name'=>'type', 'value'=>set_value('type', $type));
													echo form_input($data);
												?>
											</td>
										</tr>
									</tbody>
								</table>
								</div>
							</div>
									
							<div style="padding: 5px;">
								<div class="col-md-12 table-responsive" >
									<table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
										<fieldset><legend><?php echo lang('price');?></legend></fieldset>
										<tbody>
											<tr>
												<?php if($this->bitauth->is_admin()): ?>
													<td style=" width: 150px;">
														<label for="price">Warehouse price<?php //echo lang('warehouse_price');?></label>&nbsp;&nbsp;&nbsp;&nbsp;
														<?php
															$data	= array('name'=>'price', 'value'=>set_value('price', $price));
															echo form_input($data);
														?>
													</td>
												<?php endif; ?>
											</tr>
											
											<tr>
												<td>
													<label for="saleprice"><?php echo lang('saleprice');?></label>&nbsp;&nbsp;&nbsp;&nbsp;
													<?php
														$data	= array('name'=>'saleprice', 'value'=>set_value('saleprice', $saleprice));
														echo form_input($data);
													?>
												</td>
											</tr>
											
											<tr>
												<td>
													<label for="saleprice_DE"><?php echo lang('saleprice_DE');?></label>&nbsp;&nbsp;&nbsp;&nbsp;
													<?php
														$data	= array('name'=>'saleprice_DE', 'value'=>set_value('saleprice_DE', $saleprice_DE));
														echo form_input($data);
													?>
												</td>
											</tr>
										
											<tr>
												<td>
													<label for="saleprice_AU"><?php echo lang('saleprice_AU');?></label>&nbsp;&nbsp;&nbsp;&nbsp;
														<?php
															$data	= array('name'=>'saleprice_AU', 'value'=>set_value('saleprice_AU', $saleprice_AU));
															echo form_input($data);?>
												</td>
											</tr>
											
										<tr>	
											<td>
												<label for="saleprice_FR"><?php echo lang('saleprice_FR');?></label>&nbsp;&nbsp;&nbsp;&nbsp;
													<?php
														$data	= array('name'=>'saleprice_FR', 'value'=>set_value('saleprice_FR', $saleprice_FR));
														echo form_input($data);?>
											</td>
										</tr>
										
										<tr>	
											<td>
												<label for="saleprice_BE"><?php echo lang('saleprice_BE');?></label>&nbsp;&nbsp;&nbsp;&nbsp;
													<?php
														$data	= array('name'=>'saleprice_BE', 'value'=>set_value('saleprice_BE', $saleprice_BE));
														echo form_input($data);?>
											</td>
										</tr>	
											
										<tr>	
											<td>
												<label for="saleprice_BE"><?php echo lang('saleprice_BE');?></label>&nbsp;&nbsp;&nbsp;&nbsp;
													<?php
														$data	= array('name'=>'saleprice_BE', 'value'=>set_value('saleprice_BE', $saleprice_BE));
														echo form_input($data);?>
											</td>
										</tr>			
													
									
									<tr>
										<td>
											<label for="weight"><?php echo lang('weight');?> </label>&nbsp;&nbsp;&nbsp;&nbsp;
											<?php
													$data	= array('name'=>'weight', 'value'=>set_value('weight', $weight));
													echo form_input($data);?>
										</td>
									</tr>
								</tbody>
							</table>
							</div>
						</div>

						
				<div style="padding: 5px;">
					<div class="col-md-12 table-responsive" >
						<table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
								<fieldset><legend>Characteristic<?php //echo lang('price');?></legend></fieldset>
								<tbody>
									<tr>
										<td>
											<label for="status"><?php echo lang('status');?> </label>&nbsp;&nbsp;&nbsp;&nbsp;
											<?php 
												$product_status = array(0=>'Inactive',1=>'Active');
												echo form_dropdown('active',$product_status,set_value('active',$active));
											?>
										</td>
									</tr>	
									<tr>
										<td>
											<label for="status"><?php echo lang('shippable');?> </label>&nbsp;&nbsp;&nbsp;&nbsp;
											<?php 
													$options = array(	 '1'	=> lang('shippable')
																		,'0'	=> lang('not_shippable')
																		);
												echo form_dropdown('shippable', $options, set_value('shippable',$shippable));
											?>
										</td>
									</tr>	
									<tr>
										<td>
											<label for="status"><?php echo lang('taxable');?> </label>&nbsp;&nbsp;&nbsp;&nbsp;
											<?php 
												$options = array(	 '1'	=> lang('taxable')
																	,'0'	=> lang('not_taxable')
																	);
												echo form_dropdown('taxable', $options, set_value('taxable',$taxable));
											?>
										</td>
									</tr>	
								</tbody>
							</table>
						</div>
					</div>			



				<div style="padding: 5px;">
					<div class="col-md-12 table-responsive" >
						<table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
							<fieldset><legend><?php echo lang('inventory');?></legend></fieldset>
									<tr>
										<td>
											<label for="track_stock"><?php echo lang('track_stock');?> </label>
												<?php
													$options = array(	 '1'	=> lang('yes')
																		,'0'	=> lang('no')
																		);
													echo form_dropdown('track_stock', $options, set_value('track_stock',$track_stock));
												?>
										</td>
									</tr>
									
									<tr>
										<td>
											<label for="fixed_quantity"><?php echo lang('fixed_quantity');?> </label>
												<?php
													$options = array(	 '0'	=> lang('no')
																		,'1'	=> lang('yes')
																		);
													echo form_dropdown('fixed_quantity', $options, set_value('fixed_quantity',$fixed_quantity));
												?>
										</td>
									</tr>
									
									<tr>
										<td>
											<label for="quantity"><?php echo lang('quantity');?> </label>
												<?php
													$data	= array('name'=>'quantity', 'value'=>set_value('quantity', $quantity));
													echo form_input($data);
												?>
										</td>
									</tr>
								</table>
						</div>
					</div>

					<div style="padding: 5px;">
						<div class="col-md-12 table-responsive" >
							<table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
								<fieldset><legend>Description: </legend></fieldset>
									<?php
										$data	= array('name'=>'description', 'class'=>'redactor', 'value'=>set_value('description', $description));
										echo form_textarea($data);
									?>
							</table>
						</div>
					</div>
					
					<div style="padding: 5px;">
						<div class="col-md-12 table-responsive" >
							<table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
								<fieldset>
									<legend><?php echo lang('header_information');?></legend>
										<tr>
											<td><label for="slug"><?php echo lang('slug');?> </label>
												<?php
													$data	= array('name'=>'slug', 'value'=>set_value('slug', $slug), 'class'=>'productform form-control input-sm', 'style'=>'width:95%;');
													echo form_input($data);
												?>
											</td>
										</tr>
										<tr>
											<td><label for="seo_title"><?php echo lang('seo_title');?> </label>
												<?php
													$data	= array('name'=>'seo_title', 'value'=>set_value('seo_title', $seo_title), 'class'=>'productform form-control input-sm', 'style'=>'width:95%;');
													echo form_input($data);
												?>
											</td>
										</tr>
										<tr>
											<td><label for="meta" style="font-size:11px;"><?php echo lang('meta');?><?php echo lang('meta_example');?></label> 
												<?php
													$data	= array('name'=>'meta', 'value'=>set_value('meta', html_entity_decode($meta)), 'class'=>'productform form-control input-sm', 'style'=>'width:95%; height: 30px; resize:none;');
													echo form_textarea($data);
												?>
											</td>
										</tr>
								</fieldset>
							</table>
						</div>
					</div>
				</div>	

				<!--
					<div class="tab-pane" id="product_downloads">
						<div class="alert alert-info">
							<?php //echo lang('digital_products_desc'); ?>
						</div>
						<fieldset>
							<table class="table table-hover">
								<thead>
									<tr>
										<th><?php //echo lang('filename');?></th>
										<th><?php //echo lang('title');?></th>
										<th style="width:70px;"><?php //echo lang('size');?></th>
										<th style="width:16px;"></th>
									</tr>
								</thead>
								<tbody>
								<?php //echo (count($file_list) < 1)?'<tr><td style="text-align:center;" colspan="6">'.lang('no_files').'</td></tr>':''?>
								<?php //foreach ($file_list as $file):?>
									<tr>
										<td><?php //echo $file->filename ?></td>
										<td><?php //echo $file->title ?></td>
										<td><?php //echo $file->size ?></td>
										<td><?php //echo form_checkbox('downloads[]', $file->id, in_array($file->id, $product_files)); ?></td>
									</tr>
								<?php //endforeach; ?>
								</tbody>
							</table>
						</fieldset>
					</div>
				-->	
			   <br><br>   
				<div class="tab-pane" id="product_categories">
					<div style="padding: 5px;">
						<div class="col-md-12 table-responsive" >
							<table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
								<legend><?php echo lang('category');?></legend>
									<tr>                                
										<td>            
										<select id="category_search" name="category_search" class="productform form-control input-sm" style="float:left;">
											<option value="0">Select category</option>
												<?php 
													foreach ($all_cats as $cat){
														?><option value="<?php echo $cat->name; ?>"><?php echo $cat->name; ?></option><?php
													}
												?>
										</select>
																 
												<script type="text/javascript">
												$('#category_search').bind("keyup change" , function(){
													$('#category_list').html('');
													run_category_query();
												});
																				
																				
												function run_category_query()
												{
													$.post("<?php echo site_url($this->config->item('admin_folder').'/categories/category_autocomplete/');?>", { name: $('#category_search').val(), limit:10},
														function(data) {

															$('#category_list').html('');

															$.each(data, function(index, value){

																if($('#category_'+index).length == 0)
																{
																	$('#category_list').append('<option id="category_item_'+index+'" value="'+index+'">'+value+'</option>');
																}
															});

													}, 'json');
												}
												</script>
											<a href="#" onclick="add_category(); return false;" class="btn btn-default" style="display:block; float: left; margin:5px;" title="Add Category"><?php echo lang('add_category');?></a>
										</td>
									</tr>
									<tr>
										<td>
											<select class="productform form-control input-sm" id="category_list" size="5" style="height: 50px; width:100%; float: left;"></select>
										</td>
									</tr>
							</table>
							<table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
								<tbody id="categories_container">
									<?php							
										foreach($product_categories as $cat)
										{
											echo category($cat->id, $cat->name);
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			
			
                <br>
				<div class="tab-pane" id="product_groups">
					<div style="padding: 5px;">
						<div class="col-md-12 table-responsive" >
							<table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
								<legend>Existing product groups<?php //echo lang('category');?></legend>
								<tbody>
									<?php  
											foreach ($product_group_names as $product_group_name){
												echo    
												'<tr><td>'.$product_group_name->group_name.
												'<a class="btn btn-danger pull-right btn-mini" href='.site_url($this->config->item("admin_folder")."/groups/group_delete/".$id.'/'.$product_group_name->group_id).' onclick="return areyousure();"><i class="icon-trash icon-white"></i> '.lang('remove').'</a>';
												'</td></tr>';
										}
									?>
								</tbody>
							</table>
							<select name="group" id="slectboxid">
								<option value="">Add new group</option>
									<?php 
										foreach ($all_groups as $group){
											?><option value="<?php echo $group->group_name; ?>"><?php echo $group->group_name; ?></option><?php
												}
											?>
							</select>
							<input type="text" name="group" id="textboxid" />
							<script type="text/javascript">
								$(document).ready(function() {
								$('#slectboxid option').click(function(){
									$('#textboxid').val($(this).val());
										});
								});
							</script>
						</div>
                    </div>
                </div>

			
			
			
			
			<!--
			<div class="tab-pane" id="product_options">
				<div class="row">
					<div class="span8">
						<div class="pull-right" style="padding:0px 0px 10px 0px;">
							<select id="option_options" style="margin:0px;">
								<option value=""><?php //echo lang('select_option_type')?></option>
								<option value="checklist"><?php //echo lang('checklist');?></option>
								<option value="radiolist"><?php //echo lang('radiolist');?></option>
								<option value="droplist"><?php //echo lang('droplist');?></option>
								<option value="textfield"><?php //echo lang('textfield');?></option>
								<option value="textarea"><?php //echo lang('textarea');?></option>
							</select>
							<input id="add_option" class="btn" type="button" value="<?php echo lang('add_option');?>" style="margin:0px;"/>
						</div>
					</div>
				</div>
				
				<script type="text/javascript">
				
				$( "#add_option" ).click(function(){
					if($('#option_options').val() != '')
					{
						add_option($('#option_options').val());
						$('#option_options').val('');
					}
				});
				
				function add_option(type)
				{
					//increase option_count by 1
					option_count++;
					
					<?php
					/*
					$value			= array(array('name'=>'', 'value'=>'', 'weight'=>'', 'price'=>'', 'limit'=>''));
					$js_textfield	= (object)array('name'=>'', 'type'=>'textfield', 'required'=>false, 'values'=>$value);
					$js_textarea	= (object)array('name'=>'', 'type'=>'textarea', 'required'=>false, 'values'=>$value);
					$js_radiolist	= (object)array('name'=>'', 'type'=>'radiolist', 'required'=>false, 'values'=>$value);
					$js_checklist	= (object)array('name'=>'', 'type'=>'checklist', 'required'=>false, 'values'=>$value);
					$js_droplist	= (object)array('name'=>'', 'type'=>'droplist', 'required'=>false, 'values'=>$value);
					*/
					?>
					if(type == 'textfield')
					{
						$('#options_container').append('<?php //add_option($js_textfield, "'+option_count+'");?>');
					}
					else if(type == 'textarea')
					{
						$('#options_container').append('<?php //add_option($js_textarea, "'+option_count+'");?>');
					}
					else if(type == 'radiolist')
					{
						$('#options_container').append('<?php //add_option($js_radiolist, "'+option_count+'");?>');
					}
					else if(type == 'checklist')
					{
						$('#options_container').append('<?php //add_option($js_checklist, "'+option_count+'");?>');
					}
					else if(type == 'droplist')
					{
						$('#options_container').append('<?php //add_option($js_droplist, "'+option_count+'");?>');
					}
				}
				
				function add_option_value(option)
				{
					
					option_value_count++;
					<?php
					//$js_po	= (object)array('type'=>'radiolist');
					//$value	= (object)array('name'=>'', 'value'=>'', 'weight'=>'', 'price'=>'');
					?>
					$('#option-items-'+option).append('<?php //add_option_value($js_po, "'+option+'", "'+option_value_count+'", $value);?>');
				}
				
				$(document).ready(function(){
					$('body').on('click', '.option_title', function(){
						$($(this).attr('href')).slideToggle();
						return false;
					});
					
					$('body').on('click', '.delete-option-value', function(){
						if(confirm('<?php //echo lang('confirm_remove_value');?>'))
						{
							$(this).closest('.option-values-form').remove();
						}
					});
					
					
					
					$('#options_container').sortable({
						axis: "y",
						items:'tr',
						handle:'.handle',
						forceHelperSize: true,
						forcePlaceholderSize: true
					});
					
					$('.option-items').sortable({
						axis: "y",
						handle:'.handle',
						forceHelperSize: true,
						forcePlaceholderSize: true
					});
				});
				</script>
				
				<div class="row">
					<div class="span8">
						<table class="table table-striped"  id="options_container">
							<?php
							/*
							$counter	= 0;
							if(!empty($product_options))
							
							{
								foreach($product_options as $po)
								{
									$po	= (object)$po;
									if(empty($po->required)){$po->required = false;}

									add_option($po, $counter);
									$counter++;
								}
							}
							*/
							?>
								
						</table>
					</div>
				</div>
			</div>
			-->
			<!--	
			<div class="tab-pane" id="product_related">
                            <div class="row">
                                <div class="span8">
                                    <label><strong><?php //echo lang('select_a_product');?></strong></label>
				</div>
                            </div>
                            <div class="row">
                            <div class="span2" style="text-align:center">
                                <div class="row">
                                    <div class="span2">
                                    <input class="span2" type="text" id="product_search" />
                                    <script type="text/javascript">
                                            $('#product_search').keyup(function(){
                                                $('#product_list').html('');
                                                    run_product_query();
					});						
				function run_product_query(){
						$.post("<?php //echo site_url($this->config->item('admin_folder').'/products/product_autocomplete/');?>", { name: $('#product_search').val(), limit:10},
                                                    function(data) {
									$('#product_list').html('');
									
											$.each(data, function(index, value){
									
												if($('#related_product_'+index).length == 0)
												{
													$('#product_list').append('<option id="product_item_'+index+'" value="'+index+'">'+value+'</option>');
												}
											});
									
									}, 'json');
								}
								</script>
							</div>
						</div>
						<div class="row">
							<div class="span2">
								<select class="span2" id="product_list" size="5" style="margin:0px;"></select>
							</div>
						</div>
						<div class="row">
							<div class="span2" style="margin-top:8px;">
								<a href="#" onclick="add_related_product();return false;" class="btn" title="Add Related Product"><?php echo lang('add_related_product');?></a>
							</div>
						</div>
					</div>
					<div class="span6">
						<table class="table table-striped" style="margin-top:10px;">
							<tbody id="product_items_container">
							<?php
							/*
							foreach($related_products as $rel)
							{
								echo related_items($rel->id, $rel->name);
							}
							*/
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			-->
			<div class="tab-pane" id="product_photos">
				<div class="row">
					<iframe id="iframe_uploader" src="<?php echo site_url($this->config->item('admin_folder').'/products/product_image_form');?>" class="span8" style="height:75px; border:0px;"></iframe>
				</div>
				<div class="row">
					<div class="span8">
						
						<div id="gc_photos">
							
						<?php
						foreach($images as $photo_id=>$photo_obj)
						{
							if(!empty($photo_obj))
							{
								$photo = (array)$photo_obj;
								add_image($photo_id, $photo['filename'], $photo['alt'], $photo['caption'], isset($photo['primary']));
							}

						}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
	<div class="form-actions" style="margin:10px 10px 10px 20px;">
	<button type="submit" class="btn btn-info"><?php echo lang('form_save');?></button>
	</div>
	</form>
	
</div>



<?php
function add_image($photo_id, $filename, $alt, $caption, $primary=false)
{

	ob_start();
	?>
	<div class="row gc_photo" id="gc_photo_<?php echo $photo_id;?>" style="background-color:#fff; border-bottom:1px solid #ddd; padding-bottom:20px; margin-bottom:20px;">
		<div class="span2">
			<input type="hidden" name="images[<?php echo $photo_id;?>][filename]" value="<?php echo $filename;?>"/>
			<img class="gc_thumbnail" src="<?php echo base_url('uploads/images/thumbnails/'.$filename);?>" style="padding:5px; border:1px solid #ddd"/>
		</div>
		<div class="span6">
			<div class="row">
				<div class="span2">
					<input name="images[<?php echo $photo_id;?>][alt]" value="<?php echo $alt;?>" class="span2" placeholder="<?php echo lang('alt_tag');?>"/>
				</div>
				<div class="span2">
					<input type="radio" name="primary_image" value="<?php echo $photo_id;?>" <?php if($primary) echo 'checked="checked"';?>/> <?php echo lang('primary');?>
				</div>
				<div class="span2">
					<a onclick="return remove_image($(this));" rel="<?php echo $photo_id;?>" class="btn btn-danger" style="float:right; font-size:9px;"><i class="icon-trash icon-white"></i> <?php echo lang('remove');?></a>
				</div>
			</div>
			<div class="row">
				<div class="span6">
					<label><?php echo lang('caption');?></label>
					<textarea name="images[<?php echo $photo_id;?>][caption]" class="span6" rows="3"><?php echo $caption;?></textarea>
				</div>
			</div>
		</div>
	</div>

	<?php
	$stuff = ob_get_contents();

	ob_end_clean();
	
	echo replace_newline($stuff);
}


function add_option($po, $count)
{
	ob_start();
	?>
	<tr id="option-<?php echo $count;?>">
		<td>
			<a class="handle btn btn-mini"><i class="icon-align-justify"></i></a>
			<strong><a class="option_title" href="#option-form-<?php echo $count;?>"><?php echo $po->type;?> <?php echo (!empty($po->name))?' : '.$po->name:'';?></a></strong>
			<button type="button" class="btn btn-mini btn-danger pull-right" onclick="remove_option(<?php echo $count ?>);"><i class="icon-trash icon-white"></i></button>
			<input type="hidden" name="option[<?php echo $count;?>][type]" value="<?php echo $po->type;?>" />
			<div class="option-form" id="option-form-<?php echo $count;?>">
				<div class="row-fluid">
				
					<div class="span10">
						<input type="text" class="span10" placeholder="<?php echo lang('option_name');?>" name="option[<?php echo $count;?>][name]" value="<?php echo $po->name;?>"/>
					</div>
					
					<div class="span2" style="text-align:right;">
						<input class="checkbox" type="checkbox" name="option[<?php echo $count;?>][required]" value="1" <?php echo ($po->required)?'checked="checked"':'';?>/> <?php echo lang('required');?>
					</div>
				</div>
				<?php if($po->type!='textarea' && $po->type!='textfield'):?>
				<div class="row-fluid">
					<div class="span12">
						<a class="btn" onclick="add_option_value(<?php echo $count;?>);"><?php echo lang('add_item');?></a>
					</div>
				</div>
				<?php endif;?>
				<div style="margin-top:10px;">

					<div class="row-fluid">
						<?php if($po->type!='textarea' && $po->type!='textfield'):?>
						<div class="span1">&nbsp;</div>
						<?php endif;?>
						<div class="span3"><strong>&nbsp;&nbsp;<?php echo lang('name');?></strong></div>
						<div class="span2"><strong>&nbsp;<?php echo lang('value');?></strong></div>
						<div class="span2"><strong>&nbsp;<?php echo lang('weight');?></strong></div>
						<div class="span2"><strong>&nbsp;<?php echo lang('price');?></strong></div>
						<div class="span2"><strong>&nbsp;<?php echo ($po->type=='textfield')?lang('limit'):'';?></strong></div>
					</div>
					<div class="option-items" id="option-items-<?php echo $count;?>">
					<?php if($po->values):?>
						<?php
						foreach($po->values as $value)
						{
							$value = (object)$value;
							add_option_value($po, $count, $GLOBALS['option_value_count'], $value);
							$GLOBALS['option_value_count']++;
						}?>
					<?php endif;?>
					</div>
				</div>
			</div>
		</td>
	</tr>
	
	<?php
	$stuff = ob_get_contents();

	ob_end_clean();
	
	echo replace_newline($stuff);
}

function add_option_value($po, $count, $valcount, $value)
{
	ob_start();
	?>
	<div class="option-values-form">
		<div class="row-fluid">
			<?php if($po->type!='textarea' && $po->type!='textfield'):?><div class="span1"><a class="handle btn btn-mini" style="float:left;"><i class="icon-align-justify"></i></a></div><?php endif;?>
			<div class="span3"><input type="text" class="span12" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][name]" value="<?php echo $value->name ?>" /></div>
			<div class="span2"><input type="text" class="span12" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][value]" value="<?php echo $value->value ?>" /></div>
			<div class="span2"><input type="text" class="span12" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][weight]" value="<?php echo $value->weight ?>" /></div>
			<div class="span2"><input type="text" class="span12" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][price]" value="<?php echo $value->price ?>" /></div>
			<div class="span2">
			<?php if($po->type=='textfield'):?><input class="span12" type="text" name="option[<?php echo $count;?>][values][<?php echo $valcount ?>][limit]" value="<?php echo $value->limit ?>" />
			<?php elseif($po->type!='textarea' && $po->type!='textfield'):?>
				<a class="delete-option-value btn btn-danger btn-mini pull-right"><i class="icon-trash icon-white"></i></a>
			<?php endif;?>
			</div>
		</div>
	</div>
	<?php
	$stuff = ob_get_contents();

	ob_end_clean();

	echo replace_newline($stuff);
}
//this makes it easy to use the same code for initial generation of the form as well as javascript additions
function replace_newline($string) {
  return trim((string)str_replace(array("\r", "\r\n", "\n", "\t"), ' ', $string));
}
?>
<script type="text/javascript">
//<![CDATA[
var option_count		= <?php echo $counter?>;
var option_value_count	= <?php echo $GLOBALS['option_value_count'];?>

function add_related_product()
{
	//if the related product is not already a related product, add it
	if($('#related_product_'+$('#product_list').val()).length == 0 && $('#product_list').val() != null)
	{
		<?php $new_item	 = str_replace(array("\n", "\t", "\r"),'',related_items("'+$('#product_list').val()+'", "'+$('#product_item_'+$('#product_list').val()).html()+'"));?>
		var related_product = '<?php echo $new_item;?>';
		$('#product_items_container').append(related_product);
		run_product_query();
	}
	else
	{
		if($('#product_list').val() == null)
		{
			alert('<?php echo lang('alert_select_product');?>');
		}
		else
		{
			alert('<?php echo lang('alert_product_related');?>');
		}
	}
}

function add_category()
{
	//if the related product is not already a related product, add it
	if($('#categories_'+$('#category_list').val()).length == 0 && $('#category_list').val() != null)
	{
		<?php $new_item	 = str_replace(array("\n", "\t", "\r"),'',category("'+$('#category_list').val()+'", "'+$('#category_item_'+$('#category_list').val()).html()+'"));?>
		var category = '<?php echo $new_item;?>';
		$('#categories_container').append(category);
		run_category_query();
	}
}


function remove_related_product(id)
{
	if(confirm('<?php echo lang('confirm_remove_related');?>'))
	{
		$('#related_product_'+id).remove();
		run_product_query();
	}
}

function remove_category(id)
{
	if(confirm('<?php echo lang('confirm_remove_category');?>'))
	{
		$('#category_'+id).remove();
		run_product_query();
	}
}

function photos_sortable()
{
	$('#gc_photos').sortable({	
		handle : '.gc_thumbnail',
		items: '.gc_photo',
		axis: 'y',
		scroll: true
	});
}
//]]>
</script>
<?php
function related_items($id, $name) {
	return '
			<tr id="related_product_'.$id.'">
				<td>
					<input type="hidden" name="related_products[]" value="'.$id.'"/>
					'.$name.'</td>
				<td>
					<a class="btn btn-danger pull-right btn-mini" href="#" onclick="remove_related_product('.$id.'); return false;"><i class="icon-trash icon-white"></i> '.lang('remove').'</a>
				</td>
			</tr>
		';
}

function category($id, $name) {
	return '
			<tr id="category_'.$id.'">
				<td>
					<input type="hidden" name="categories[]" value="'.$id.'"/>
					'.$name.'</td>
				<td>
					<a class="btn btn-danger pull-right btn-mini" href="#" onclick="remove_category('.$id.'); return false;"><i class="icon-trash icon-white"></i> '.lang('remove').'</a>
				</td>
			</tr>
		';
}

include('footer.php'); ?>