<?php include('header.php'); ?>
<link href='http://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>

<script type="text/javascript">
    function areyousure(){
            return confirm('<?php echo lang('confirm_delete_category');?>');
    }
</script>
<?php 

$error = $this->session->flashdata('error');
if(!empty($error)){
    echo $error;
}

?>

        <?php if($this->bitauth->is_admin()): ?>
            <div style="text-align:right; margin-bottom: 10px;">
                <?php if($can_edit_categories): ?>
                    <a class="btn btn-info btn-xs" href="<?php echo site_url($this->config->item('admin_folder').'/categories/form'); ?>"><span style="font-size:14px; line-height:12px;">+</span>  <?php echo lang('add_new_category');?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">Categories<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
			<div class="panel-body">
				<table class="table table-hover" style="border: 1px solid #ddd;">
                                            <thead>
						<tr style="background: #E6E6FA;">
							<th></th>
							<th style="font-size: 14px; font-weight:bold;"><?php echo lang('name_nl')?></th>
							<th style="font-size: 14px; font-weight:bold;"><?php echo lang('name_be')?></th>
							<th style="font-size: 14px; font-weight:bold;"><?php echo lang('name_de')?></th>
							<th style="font-size: 14px; font-weight:bold;"><?php echo lang('name_au')?></th>
							<th style="font-size: 14px; font-weight:bold;"><?php echo lang('name_fr')?></th>
							<th style="font-size: 14px; font-weight:bold;"><?php echo lang('name_bel')?></th>
							<th style="font-size: 14px; font-weight:bold;"><?php echo lang('name_lx')?></th>
							<th style="font-size: 14px; font-weight:bold;"><?php echo lang('name_uk')?></th>
							<th style="font-size: 14px; font-weight:bold;"><?php echo lang('order')?></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
                                            </thead>
					<tbody>
						<?php echo (count($categories) < 1)?'<tr><td style="text-align:center;" colspan="3">'.lang('no_categories').'</td></tr>':''?>
							<?php	foreach ($categories as $k=>$v):?>
							<tr>
										<td><?php echo  $counter[$k]; ?></td>
										<td><?php echo  $v->name_NL; ?></td>
										<td><?php echo  $v->name_BE; ?></td>
										<td><?php echo  $v->name_DE; ?></td>
										<td><?php echo  $v->name_AU; ?></td>
										<td><?php echo  $v->name_FR; ?></td>
										<td><?php echo  $v->name_BEL; ?></td>
										<td><?php echo  $v->name_LX; ?></td>
										<td><?php echo  $v->name_UK; ?></td>
										<td><?php echo  $v->sequence; ?></td>

										<?php if($can_edit_categories): ?>
												<td>
													<a class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="bottom" title='Edit' style="display: inline-block; font-size: 12px;" href="<?php echo  site_url($this->config->item('admin_folder').'/categories/form/'.$v->id.'/'.md5($v->slug));?>"><?php //echo lang('form_view')?></a>
												</td>
										<?php endif; ?>
												<td>
													<a class="glyphicon glyphicon-indent-left" data-toggle="tooltip" data-placement="bottom" title='Organize' style="display: inline-block; font-size: 12px;" href="<?php echo  site_url($this->config->item('admin_folder').'/categories/organize/'.$v->id.'/'.md5($v->slug));?>"><?php //echo lang('organize')?></a>
												</td>
										<?php if($can_edit_categories): ?>
												<td>
													<a class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="bottom" title='Delete' onclick="return areyousure();" style="display: inline-block; font-size: 12px;" href="<?php echo  site_url($this->config->item('admin_folder').'/categories/delete/'.$v->id.'/'.md5($v->slug));?>"><?php //echo lang('organize')?></a>
												</td>
										<?php endif; ?>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="panel panel-default" style="width: 10%; float: left;">
			<table class="table table-hover" style="border: 1px solid #ddd;">
				<td>Total categories : <?php echo count($categories); ?></td>
			</table>
		</div>
<?php include('footer.php'); ?>


<script>
    var $tip1 = $('.glyphicon');
    $tip1.tooltip({trigger: 'hover'});
</script>


















