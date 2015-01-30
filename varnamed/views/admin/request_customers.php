

<?php include('header.php');
    $month = array(
            date('m')   => date('M'),
                            '1' => 'January',
                            '2' => 'February',
                            '3' => 'March',
                            '4' => 'April',
                            '5' => 'May',
                            '6' => 'June',
                            '7' => 'July',
                            '8' => 'August',
                            '9' => 'September',
                            '10' => 'Oktober',
                            '11' => 'November',
                            '12' => 'December',
                );
                
                $year = array(

                    date('Y') => date('Y'),
                    '2006' => '2006',
                    '2007' => '2007',
                    '2008' => '2008',
                    '2009' => '2009',
                    '2010' => '2010',
                    '2011' => '2011',
                    '2012' => '2012',
                    '2013' => '2013',
                    
                );
				
    if(!$code){
            $code = '';
    }
    else{
            $code = '/'.$code;
    }
    function sort_url($lang, $by, $sort, $sorder, $code, $admin_folder){
            if ($sort == $by){
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


            $return = site_url($admin_folder.'/customers/index/'.$by.'/'.$sort.'/'.$code);

            echo '<a href="'.$return.'">'.lang($lang).$icon.'</a>';

    }

?>

<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_product');?>');
}
</script>
<style type="text/css">
	.pagination {
		margin:0px;
		margin-top:-3px;
	}
</style>

<?php echo form_open($this->config->item('admin_folder').'/customers/export_excel'); ?>
    <table>
        <div class="control-group success">
        <?php echo form_dropdown('month', $month, '0'); ?>
        </div>
        <div class="control-group success">
        <?php echo form_dropdown('year', $year, '0'); ?>
        </div>
         <button class="btn btn-warning btn-small" type="submit" name="submit" value="export"><?php echo lang('excel_export')?></button>
    </table>
</form>
<div class="btn-group pull-right">
    
</div>
<?php echo form_open($this->config->item('admin_folder').'/customers/bulk_save', array('id'=>'bulk_form'));?>
<br>
	<table class="table table-striped">
		<thead>
			<tr>
								<th><?php echo sort_url('company', 'company', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
                                <th><?php echo sort_url('email', 'email_1', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
                                <th><?php echo lang('active');?></th>
								<?php if($this->data_shop == 3): ?>
								<th>Goedgekeurd klant<?php //echo lang('active');?></th>
								<?php endif; ?>
								
			</tr>
                        <span class="btn-group pull-right">
						<?php if($this->bitauth->is_admin()): ?>
                            <button class="btn btn-small" href="#"><i class="icon-ok"></i> <?php echo lang('bulk_save');?></button>
							<?php endif; ?>
                            <a class="btn btn-small" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_customer');?></a>
                        </span>
		</thead>
		<tbody>
		<?php echo (count($customers) < 1)?'<tr><td style="text-align:center;" colspan="7">'.lang('no_customers').'</td></tr>':''?>
	<?php foreach ($customers as $customer):?>
                     
			<tr>
                            
                            <td><?php echo form_input(array('name'=>'customer['.$customer->id.'][company]','value'=>form_decode($customer->company), 'class'=>'span3'));?></td>
                            <td><a href="mailto:<?php echo $customer->email_1; ?>" target="_top"><?php echo $customer->email; ?></a></td>
				<td>
				<?php if($customer->active == 1)
				{
					echo 'Yes';
				}
				else
				{
					echo 'No';
				}
				?>
				</td>
												<?php if($this->data_shop == 3): ?>
												<td>
				<?php if($customer->aproved == 1)
				{
					echo 'Yes';
				}
				else
				{
					echo 'No';
				}
				?>
				</td>
								<?php endif; ?>
			<td>
				<div class="btn-group" style="float:right">
					<a class="btn btn-small" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$customer->id); ?>"><i class="icon-eye-open"></i> <?php echo lang('view');?></a>
					
					<a class="btn btn-small" href="<?php echo site_url($this->config->item('admin_folder').'/customers/addresses/'.$customer->id); ?>"><i class="icon-envelope"></i> <?php echo lang('addresses');?></a>
					<?php if($this->bitauth->is_admin()): ?>
					<a class="btn btn-danger btn-small" href="<?php echo site_url($this->config->item('admin_folder').'/customers/delete/'.$customer->id); ?>" onclick="return areyousure();"><i class="icon-trash icon-white"></i> <?php echo lang('delete');?></a>
					<?php endif; ?>
				</div>
			</td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>

</form>
<div class="row">
	<div class="span12" style="border-bottom:1px solid #f5f5f5;">
		<div class="row">
			<div class="span4">
				<?php echo $this->pagination->create_links();?>	&nbsp;
			</div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>