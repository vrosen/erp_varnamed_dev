

<?php include('header.php');
    $month = array(
        date('m')   => date('M'),
        '1'         => 'January',
        '2'         => 'February',
        '3'         => 'March',
        '4'         => 'April',
        '5'         => 'May',
        '6'         => 'June',
        '7'         => 'July',
        '8'         => 'August',
        '9'         => 'September',
        '10'        => 'Oktober',
        '11'        => 'November',
        '12' => 'December',
    );
                
    $year = array(
        date('Y')   => date('Y'),
        '2006'      => '2006',
        '2007'      => '2007',
        '2008'      => '2008',
        '2009'      => '2009',
        '2010'      => '2010',
        '2011'      => '2011',
        '2012'      => '2012',
        '2013'      => '2013',
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
<!--
<?php //echo form_open($this->config->item('admin_folder').'/customers/export_excel'); ?>
    <table>
        <div class="control-group pull-left" style="width: 50%;">
        <?php //echo form_dropdown('month', $month, '0'); ?>
        <?php //echo form_dropdown('year', $year, '0'); ?>
		
		<button class="btn btn-info btn-xs" type="submit" name="submit" value="export"><?php //echo lang('excel_export')?></button>

        </div>
    </table>
</form>
-->
<?php echo form_open($this->config->item('admin_folder').'/customers/bulk_save', array('id'=>'bulk_form'));?>
							<span class="btn-group pull-right">
									<?php if($can_delete_customers): ?>
										<button class="btn btn-default btn-xs" href="#"><?php echo lang('bulk_save');?></button>
							<?php endif; ?>
									<a class="btn btn-default btn-xs" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form'); ?>"><span style="font-size:14px; line-height:12px;">+</span> <?php echo lang('add_new_customer');?></a>
							</span>
							
							<br/><br/>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo lang('customers'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table id="myTable" class="table table-hover" style="border: 1px solid #ddd;">
					
						<thead>

							<tr>
							<?php  if($this->bitauth->is_admin()):  ?>
									<th><button type="submit" class="glyphicon glyphicon-trash" ></button></th>
							<?php endif; ?>
								<th>
									<?php echo sort_url(
												'company', 
												'company', 
												$order_by, 
												$sort_order, 
												$code, 
												$this->config->item('admin_folder')
											);
									?>
								</th>
								<th><?php echo lang('country'); ?></th>
								<th>Created on<?php //echo lang('firstname'); ?></th>
								<th>
									<?php echo sort_url(
												'email', 
												'email_1', 
												$order_by, 
												$sort_order, 
												$code, 
												$this->config->item('admin_folder')
											);
									?>
								</th>
								<th><?php echo lang('active');?></th>
								<?php if($this->data_shop == 3): ?>
									<th>Goedgekeurd klant<?php //echo lang('active');?></th>
								<?php endif; ?>
							</tr>

						</thead>
						<tbody>
							<?php if(count($customers) < 1): ?>
								<tr>
									<td style="text-align:center;" colspan="7">
										Search for customers
									</td>
								</tr>
							<?php endif; ?>
							<?php foreach ($customers as $customer):?>
						<tr>
							<?php  if($this->bitauth->is_admin()):  ?>
							<td style="width: 2%;"><input name="customer[]" type="checkbox" value="<?php echo $customer->id; ?>" class="gc_check"/></td>
							<?php endif; ?>  
								<td style="width: 27%;">
									<?php if($can_delete_customers): ?>
										<?php echo 
											form_input(
												array(
													'name'=>'customer['.$customer->id.'][company]',
													'value'=>form_decode($customer->company), 
													'style'=>'width: 95%;'
													)
											);
										?>
									<?php else: ?>
										<?php echo $customer->company ?>
									<?php endif; ?>
								</td>
								<td style="width: 5%;">
									<?php echo strtoupper($customer->LANDCODE); ?>
								</td>
								<td><?php
									if($customer->CREATEDDAT !== '0000-00-00 00:00:00' and $customer->CREATEDDAT !== '0000-00-00'){	
										echo $customer->CREATEDDAT; 
									}else {
										echo $customer->creation_date;
									}
								?></td>
										<td>
											<a href="mailto:<?php echo $customer->email_1; ?>" target="_top">
												<?php echo $customer->email_1; ?>
											</a>
										</td>
										<td>
													<?php echo ($customer->active) ? 'Yes' :'No' ?>
										</td>
										<?php if($this->data_shop == 3): ?>
										<td>
													<?php echo ($customer->aproved) ? 'Yes' :'No' ?>
										</td>
										<?php endif; ?>
										
										<td style="text-align: center; width: 50px;">
											<a class="glyphicon glyphicon-edit" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$customer->id); ?>"><?php //echo lang('form_view')?></a>
										</td>
										<td style="text-align: center; width: 50px;">
											<a class="glyphicon glyphicon-envelope" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/addresses/'.$customer->id); ?>"><?php //echo lang('form_view')?></a>
										</td>

								<?php if($can_delete_customers): ?>
										<td style="text-align: center; width: 50px;">
											<a class="glyphicon glyphicon-trash" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/delete/'.$customer->id); ?>"><?php //echo lang('form_view')?></a>
										</td>
								<?php endif; ?>
								

								</tr>
						<?php endforeach; ?>
							</tbody>
					</table>
					</div>
				</div>
			<br/>
				
				<div class="pull-right">
					<?php echo $this->pagination->create_links();?>
				</div>
				
			</form>

<?php include('footer.php'); ?>