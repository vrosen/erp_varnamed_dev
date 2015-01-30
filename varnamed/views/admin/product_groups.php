<?php include('header.php');
    if(!$code){
            $code = '';
    }
    else{
            $code = '/'.$code;
    }
    function sort_url($lang, $by, $sort, $sorder, $code, $admin_folder)
    {
        if ($sort == $by)
        {
                    if ($sorder == 'asc'){
                            $sort	= 'desc';
                            $icon	= ' <i class="icon-chevron-up"></i>';
                    }
                    else{
                            $sort	= 'asc';
                            $icon	= ' <i class="icon-chevron-down"></i>';
                    }
        }
        else{
                    $sort	= 'asc';
                    $icon	= '';
        }
        $return = site_url($admin_folder.'/groups/index/'.$by.'/'.$sort.'/'.$code);
        echo '<a href="'.$return.'">'.lang($lang).$icon.'</a>';
    }
?>
<?php if(!empty($term)): ?>
    <?php $term = json_decode($term); ?>
		<?php if(!empty($term->term)):?>
			<div class="alert alert-info">
				<?php echo sprintf(lang('search_returned'), intval($total));?>
			</div>
		<?php endif;?>
	<?php endif;?>
<?php 
//UPDATE `groups` SET group_name_Österreich=group_name
$webshop = array(
    '0'     =>   'Select webshop',
    '1'     =>   'Belgique',
    '2'     =>   'België',
    '3'     =>   'Deutschland',
    '4'     =>   'France',
    '5'     =>   'Luxembourg',
    '6'     =>   'Nederland',
    '7'     =>   'United Kingdom',
    '8'     =>   'Österreich',    
); 


?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_group');?>');
}
</script>

	
	<?php echo form_open($this->config->item('admin_folder').'/groups/');?>
	<table class="productGroup-selects">
	<tr>
		<td class="productGroup-select-categories">
			<?php 
			$js_cat = ' name="category" class="form-control" style="margin-bottom: 10px; width: 228px; float: left;" onChange="this.form.submit();"';
			echo form_dropdown('category',$all_categories,$category,$js);
			?>
		</td>
		<td class="productGroup-select-webshop">
			<?php 	
				$js = 'id="webshop" class="form-control" style="margin-bottom: 10px; width: 228px; float: left;" onChange="this.form.submit()"';	
				echo form_dropdown('webshop',$webshop,$web_shop,$js); 
			?>
		</td>
	</tr>		
	</table>		
	</form>

<?php echo form_open($this->config->item('admin_folder').'/groups/bulk_save', array('group_id'=>'bulk_form'));?>
	<div class="panel panel-default table-responsive" style="width: 100%; float: left;">
		<div class="panel-heading">Groups<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
		</div>
		<div class="panel-body">

	<table class="table table-hover " style="border: 1px solid #ddd;">
        <thead>
            <tr>
                <th class="col-lg-1"></th>
				<th class="col-lg-7" slass="group-name">
                    <?php
                    if(!empty($web_shop)){
                        switch ($web_shop) {
                            case 1:
                                echo sort_url(
                                        'group_name_Belgique', 
                                        'group_name_Belgique', 
                                        $order_by, 
                                        $sort_order, 
                                        $code,
                                        $this->config->item('admin_folder')
                                );
                                break;
                            case 2:
                                echo sort_url(
                                        'group_name_België', 
                                        'group_name_België', 
                                        $order_by, 
                                        $sort_order, 
                                        $code, 
                                        $this->config->item('admin_folder')
                                );
                                break;
                            case 3:
                                echo sort_url(
                                        'group_name_Deutschland', 
                                        'group_name_Deutschland', 
                                        $order_by, 
                                        $sort_order, 
                                        $code, 
                                        $this->config->item('admin_folder')
                                );
                                break;
                            case 4:
                                echo sort_url(
                                        'group_name_France', 
                                        'group_name_France', 
                                        $order_by, $sort_order, 
                                        $code, 
                                        $this->config->item('admin_folder')
                                );
                                break;
                            case 5:
                                echo sort_url(
                                        'group_name_Luxembourg', 
                                        'group_name_Luxembourg', 
                                        $order_by, 
                                        $sort_order, 
                                        $code, 
                                        $this->config->item('admin_folder')
                                );
                                break;
                            case 6:
                                echo sort_url(
                                        'group_name_Nederland', 
                                        'group_name_Nederland', 
                                        $order_by, 
                                        $sort_order, 
                                        $code, 
                                        $this->config->item('admin_folder')
                                );
                                break;
                            case 7:
                                echo sort_url(
                                        'group_name_UK', 
                                        'group_name_UK', 
                                        $order_by, 
                                        $sort_order, 
                                        $code, 
                                        $this->config->item('admin_folder')
                                );
                                break;
                            case 8:
                                echo sort_url(
                                        'group_name_Österreich', 
                                        'group_name_Österreich', 
                                        $order_by, 
                                        $sort_order, 
                                        $code, 
                                        $this->config->item('admin_folder')
                                );
                                break;
                        }
                    }else {
                        echo sort_url(
                                'group_name_Nederland', 
                                'group_name_Nederland', 
                                $order_by, $sort_order, 
                                $code, 
                                $this->config->item('admin_folder')
                        );
                    }
                    ?>
                </th>
                <th class="col-lg-2" class="productGroup-enable-select">
                    <?php echo lang('enabled'); ?>
                </th> 
                <th class="col-lg-1 no-label" style="max-width: 50px!important; min-width: 50px;"></th>
                <th class="col-lg-1 no-label" style="max-width: 50px!important; min-width: 50px;"></th>
			</tr>
		</thead>
		<tbody>
		<?php echo (count($groups) < 1)?'<tr><td style="text-align:center;" colspan="7">'.lang('no_groups').'</td></tr>':''?>
	<?php foreach ($groups as $group):?>
                            <tr>
                                <?php if($can_edit_porduct_groups) : ?>
										<td class="col-lg-1 " style="text-align: center; min-width: 100px;">
											<a class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="bottom" title='Edit' style="display: inline-block; font-size: 12px;" href="<?php echo  site_url($this->config->item('admin_folder').'/groups/form/'.$group->group_id);?>"><?php //echo lang('form_view')?></a>
										</td>
								<?php  endif; ?>		
		<?php

                switch ($web_shop) 
                {
                  case 1:
                        $fival = trim($group->group_name_Belgique);
                        $fi = form_input(
                                array(
                                    'name'=>'group['.$group->group_id.'][group_name]',
                                    'value'=>form_decode(trim($group->group_name_Belgique)), 
                                   'style'=>'width: 99%;')
                                );
                        break;
                    case 2:
                        $fival = trim($group->group_name_Belgique);
                        $fi = form_input(
                                array(
                                    'name'=>'group['.$group->group_id.'][group_name]',
                                    'value'=>form_decode(trim($group->group_name_Belgique)), 
                                   'style'=>'width: 99%;')
						);
                        break;
                    case 3:
                        $fival = trim($group->group_name_Deutschland);
                        $fi = form_input(
                                array(
                                    'name'=>'group['.$group->group_id.'][group_name]',
                                    'value'=>form_decode(trim($group->group_name_Deutschland)), 
                                  'style'=>'width: 99%;')
                                );
                        break;
                    case 4:
                        $fival = trim($group->group_name_France);
                        $fi = form_input(
                                array(
                                    'name'=>'group['.$group->group_id.'][group_name]',
                                    'value'=>form_decode(trim($group->group_name_France)), 
                                     'style'=>'width: 99%;')
                                );
                        break;
                    case 5:
                        $fival = trim($group->group_name_Luxembourg);
                        $fi = form_input(
                                array(
                                    'name'=>'group['.$group->group_id.'][group_name]',
                                    'value'=>form_decode(trim($group->group_name_Luxembourg)), 
                                    'style'=>'width: 99%;')
                                );
                        break;
                    case 6:
                        $fival = trim($group->group_name_UK);
                        $fi = form_input(
                                array(
                                    'name'=>'group['.$group->group_id.'][group_name]',
                                    'value'=>form_decode(trim($group->group_name_UK)), 
                                     'style'=>'width: 99%;')
                                );
                        break;
                    case 7:
                        $fival = trim($group->group_name_UK);
                        $fi = form_input(
                                array(
                                    'name'=>'group['.$group->group_id.'][group_name]',
                                    'value'=>form_decode(trim($group->group_name_UK)), 
                                     'style'=>'width: 99%;')
                                );
                        break;
                    case 8:
                        $fival = trim($group->group_name_Österreich);
                        $fi = form_input(
                                array(
                                    'name'=>'group['.$group->group_id.'][group_name]',
                                    'value'=>form_decode(trim($group->group_name_Österreich)), 
                                    'style'=>'width: 99%;')
                                );
                        break;
                    default: 
                        $fival = trim($group->group_name);
                        $fi = form_input(
                                array(
                                    'name'=>'group['.$group->group_id.'][group_name]',
                                    'value'=>form_decode(trim($group->group_name_Nederland)), 
                                    'style'=>'width: 99%;')
                                );
                }
                ?>
                                <td class="col-lg-8 productGropr-group-name" style="min-width: 500px;"> 
                                    <?php if($can_edit_porduct_groups) : ?>
                                        <?php echo $fi; ?>
                                    <?php else: ?>
                                        <?php echo $fival; ?>
                                    <?php endif; ?>
                                </td>
					<?php if($can_edit_porduct_groups){ 
					?>
										<td class="col-lg-1 productGroup-enable-select">
					<?php
					 	$options = array(
			                  '1'	=> lang('enabled'),
			                  '0'	=> lang('disabled')
			                );

						echo form_dropdown('group['.$group->group_id.'][enabled]', $options, set_value('enabled',$group->enabled), 'style="width: 90%;"');
					?>
				</td>
					
					<?php
					}
					else {
						if($group->enabled == 1){
						 echo '<td>'.lang('enabled').'</td>';
						}
						if($group->enabled == 2){
						  echo '<td>'.lang('disabled').'</td>';
						}
					}
					?>
                                <?php if($can_edit_porduct_groups) : ?>
										<td class="col-lg-1 productGroup-list-icon-wrapper" style="text-align: center;">
											<a class="glyphicon glyphicon-list productGroup-list-icon " data-toggle="tooltip" data-placement="bottom" title='Products' style="display: inline-block; font-size: 12px;" href="<?php echo  site_url($this->config->item('admin_folder').'/groups/view_products/'.$group->group_id);?>"><?php //echo lang('form_view')?></a>
										</td>   
									<?php if($this->bitauth->is_admin()): ?>
										<td class="col-lg-1 productGroup-delete-icon-wrapper" style="text-align: center;">
											<a class="glyphicon glyphicon-trash productGroup-delete-icon" data-toggle="tooltip" data-placement="bottom" title='Delete' style="display: inline-block; font-size: 12px;" href="<?php echo  site_url($this->config->item('admin_folder').'/groups/delete/'.$group->group_id);?>" onclick="return areyousure();"><?php //echo lang('form_view')?></a>
										</td>   
									<?php endif;  ?>
                                <?php endif; ?>
			</tr>
	<?php endforeach; ?>
		</tbody>
				<tfoot>
			</tfoot>
    </table>
	<?php if($can_edit_porduct_groups): ?>
							<div class="form-actions productGroup-form-buttons-wrapper" style="margin:10px 10px 10px 20px;">
								<button type="submit" class="btn btn-info productGroup-save-button button-hover"><?php echo lang('form_save');?></button>
								<button type="submit" class="btn btn-info productGroup-back-button button-hover" onclick="history.go(-1); return false;" >Back<?php //echo lang('form_save');?></button>
						<?php if($can_edit_categories): ?>
							<a class="btn btn-info productGroup-add-new-group button-hover" href="<?php echo site_url($this->config->item('admin_folder').'/groups/form'); ?>">Add New Group</a>
						<?php endif; ?>
							</div>
	<?php endif; ?>

				</div>
		</div>
</form>

<?php include('footer.php'); ?>

<script>
var $tip1 = $('.glyphicon');
$tip1.tooltip({trigger: 'hover'});
</script>



