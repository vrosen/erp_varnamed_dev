<?php include('header.php'); ?>

<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	create_sortable();
});

// Return a helper with preserved width of cells
var fixHelper = function(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
};

function create_sortable()
{
	$('#category_contents').sortable({
		scroll: true,
		helper: fixHelper,
		axis: 'y',
		update: function(){
			save_sortable();
		}
	});	
	$('#category_contents').sortable('enable');
}

function save_sortable()
{
	serial=$('#category_contents').sortable('serialize');
			
	$.ajax({
		url:'<?php echo site_url($this->config->item('admin_folder').'/categories/process_organization/'.$category->id.'/'.md5($slug));?>',
		type:'POST',
		data:serial
	});
}
//]]>
</script>
	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo lang('drag_and_drop');?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
				<?php echo form_open($this->config->item('admin_folder').'/categories/organize/'.$id.'/'.md5($slug)); ?>
					<?php
						$js = 'id="shop_nationality" class="form-control" style="margin-bottom: 10px; width: 228px; float: left;" onChange="this.form.submit()"';	
							echo form_dropdown('shop_nationality',$all_shops_national, $shop_nationality,$js,'class="form-control"'); 
					?>
				</form>
						<!--<div class="alert alert-info">
							<?php //echo lang('drag_and_drop');?>
						</div>-->

						<table class="table table-hover" style="border: 1px solid #ddd;">
							<thead>
								<tr style="background: #E6E6FA;">
									<th style="font-size: 14px; font-weight:bold;"><?php echo lang('name');?></th>
									<th style="font-size: 14px; font-weight:bold;"><?php echo lang('price').' '.$price_index;?></th>
								</tr>
							</thead>
							<tbody id="category_contents">
							<?php foreach ($category_groups as $group):?>
                                                          
								<tr id="group-<?php echo $group->group_id;?>">
									<td><?php echo $group->$name;?></td>
									<td><?php echo $group->$price;?></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-info" onclick="history.go(-1); return false;" >Back<?php //echo lang('form_save');?></button>
			</div>
			
			
<?php include('footer.php'); ?>










