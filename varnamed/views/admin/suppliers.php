<?php

      //CLIENT SEARCH SECTION VARS      	

                $attributes = 'class = "btn btn-primary"';
                                                        
		$search_keywords = array(
	
					'name'        	=> 'search_keywords',
                                        'class'         => 'inputxlarge_focused',
					'id'          	=> 'focusedInput_keywords',
					'size'        	=> '10',
					'placeholder' 	=> 'Name, zip code oder City/Town, z.B. Schmidt Hamburg',
            );		
		$search_country = array(
	
					'-1'        	=> 'Select...',
					'1'        	=> 'Australia',
					'2'        	=> 'België',
					'3'        	=> 'Bulgarije',
					'4'        	=> 'Deutschland',
					'5'        	=> 'Dänemark',
					'6'        	=> 'France',
					'7'        	=> 'Ireland',
					'8'        	=> 'Italien',
					'9'        	=> 'Luxemburg',
					'10'        	=> 'Nederland',
					'11'        	=> 'Polen',
					'12'        	=> 'Portugal',
					'13'        	=> 'Roemenië',
					'14'        	=> 'Schweiz',
					'15'        	=> 'Spanien',
					'16'        	=> 'Tschechische Republik',
					'17'        	=> 'Ungarn',
					'18'        	=> 'United Kingdom',
					'19'        	=> 'United States of America',
					'20'        	=> 'Zweden',
					'21'        	=> 'Österreich',
            );
            
            $order_accept = array(
            
					'name'        	=> 'order',
					'id'          	=> 'order',
					'value'       	=> 'accept',
					'checked'     	=> TRUE,
					'style'       	=> 'margin:10px',
					
			);
			
			$order_not_accept = array(
            
					'name'        	=> 'order',
					'id'          	=> 'order',
					'value'       	=> 'notaccept',
					'checked'     	=> TRUE,
					'style'       	=> 'margin:10px',
					
			);
			
			$industry = array(
	
					'-1'        	=> 'Select...',
					'2'        	=> 'Care shop',
					'3'        	=> 'Convalescent home',
					'4'        	=> 'Export',
					'5'        	=> 'Hospital',
					'6'        	=> 'Medical wholesale',
					'7'        	=> 'Nursing home',
					'8'        	=> 'Retailer',
					'9'        	=> 'Pharmaceutical wholesaler',
					'10'        	=> 'Pharmacy',
					'11'        	=> 'Private individual',
					'12'        	=> 'Rest & convalescent home',
					'13'        	=> 'Other / unknown',
            );
            
			$position = array(
	
					'-1'        	=> 'Select...',
					'2'        	=> 'Heimleitung',
					'3'        	=> 'Wirtschaftsleitung',
					'4'        	=> 'Pflegedienstleitung',
					'5'        	=> 'Hauptfirma',
					'6'        	=> 'Inkoop',
					'7'        	=> 'Fysio',
					'8'        	=> 'Ergo',
            );
            
            $postal_code_from = array(
            
					'name'        	=> 'postal_code_from',
					'id'          	=> 'postal_code_from',
					'size'        	=> '10',
					'placeholder' 	=> 'from',
            );
			$postal_code_to = array(
            
					'name'        	=> 'postal_code_to',
					'id'          	=> 'postal_code_to',
					'size'        	=> '10',
					'placeholder' 	=> 'to',
            );
			$excel_export = array(
            
					'name'        	=> 'excel_export',
					'id'          	=> 'excel_export',
					'value'       	=> 'export',
					'checked'     	=> TRUE,
					'style'       	=> 'margin:10px',
					
			);

	//to do -
	//put vars for language session 	
	?>



<?php include('header.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_supplier');?>');
}
</script>

    <a class="btn btn-info" href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/add_supplier_form');?>">Add New Supplier<?php //echo lang('add_supplier');?></a>
	
	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">Latest Orders<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped table-hover" style="border: 1px solid #ddd;">
						<thead>
							<tr>
								<?php
								if($by=='ASC')
								{
									$by='DESC';
								}
								else
								{
									$by='ASC';
								}
								?>
									<th><a href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/index/company/');?>/<?php echo ($field == 'company')?$by:'';?>"><?php echo lang('company');?>
									<?php if($field == 'company'){ echo ($by == 'ASC')?'<i class="icon-chevron-up"></i>':'<i class="icon-chevron-down"></i>';} ?> </a></th>

									<th><a href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/index/email/');?>/<?php echo ($field == 'email')?$by:'';?>"><?php echo lang('email');?>
									<?php if($field == 'email'){ echo ($by == 'ASC')?'<i class="icon-chevron-up"></i>':'<i class="icon-chevron-down"></i>';} ?></a></th>
											
									<th><a href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/index/web/');?>/<?php echo ($field == 'web')?$by:'';?>"><?php echo lang('web');?>
									<?php if($field == 'web'){ echo ($by == 'ASC')?'<i class="icon-chevron-up"></i>':'<i class="icon-chevron-down"></i>';} ?></a></th>
									<th>View</th>
									<th>Addresses</th>
							</tr>
						</thead>
						<tbody>
							<?php echo (count($suppliers) < 1)?'<tr><td style="text-align:center;" colspan="5">'.lang('no_suppliers').'</td></tr>':''?>
									<?php foreach ($suppliers as $supplier):?>
										<tr>
											<td><?php echo  $supplier->company; ?></td>
											<td><a href="mailto:<?php echo  $supplier->email;?>"><?php echo  $supplier->email; ?></a></td>
											<td><a href="http://<?php echo  $supplier->web;?>/" target="_blank"><?php echo  $supplier->web; ?></a></td>
											<td style="text-align: center; width: 50px;">
												<a class="glyphicon glyphicon-edit" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/form/'.$supplier->id); ?>"><?php //echo lang('form_view')?></a>
											</td>
											<?php if($this->bitauth->is_admin()): ?>
											<td style="text-align: center; width: 50px;">
												<a class="glyphicon glyphicon-trash" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/delete/'.$supplier->id); ?>"><?php //echo lang('form_view')?></a>
											</td>										
											<?php endif; ?>
										</tr>
									<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>

		<div class="row" style="margin-left: 3px;">
                    <?php if(count($suppliers) > 1): ?>
			<div class="span4">
				<?php echo $this->pagination->create_links();?>	
			</div>
                    <?php  endif; ?>
		</div>


<?php include('footer.php'); ?>