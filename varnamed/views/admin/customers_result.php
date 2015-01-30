<?php

      //CLIENT SEARCH SECTION VARS      	

                $attributes = 'class = "btn btn-primary"';
                                                        
		$keyword = array(
	
					'name'        	=> 'keyword',
                                        'class'         => 'inputxlarge_focused',
					'id'          	=> 'focusedInput_keyword',
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

	//to do -
	//put vars for language session 	
	?>



<?php include('header.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_customer');?>');
}
</script>

            <!-- START SEARCH TABLE -->
                <div class="span6">
                    <?php echo form_open($this->config->item('admin_folder').'/customers/search_customers'); ?>
                    
                                <div class="controls"><?php echo form_input($keyword); ?></div>
                                <div class="control-group success"><?php echo form_dropdown('country', $search_country, '-1'); ?></div>
                                <div class="controls">With order&nbsp;&nbsp;&nbsp;&nbsp;<?php echo form_radio($order_accept); ?>
                                No order&nbsp;&nbsp;&nbsp;&nbsp;<?php echo form_radio($order_not_accept); ?></div>
                                <div class="controls"><?php echo form_dropdown('industry', $industry, '-1'); ?></div>
                                <div class="controls"><?php echo form_dropdown('position', $position, '-1'); ?></div>
                                <div class="controls"><?php echo form_input($postal_code_from); ?><br/><?php echo form_input($postal_code_to); ?></div>
				<?php //$all_agents = array(); ?>
				<?php //foreach($agents as $agent): ?>
				<?php //$all_agents[] = $agent->agent_name; ?>
				<?php //endforeach; ?>
                                <div class="control-group success">
                                        <div class="controls">Field service/Agents&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo form_dropdown('agents', $all_agents, '-1'); ?></div>
                                </div>
				<?php echo form_submit('search', 'Search', $attributes); ?><br/>
				<?php echo form_close(); ?><br>
		</div>
        <!-- END SEARCH TABLE -->
        
<div class="btn-group pull-right">
	<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/customers/export_xml');?>"><i class="icon-download"></i> <?php echo lang('xml_download');?></a>
	<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/customers/get_subscriber_list');?>"><i class="icon-download"></i> <?php echo lang('subscriber_download');?></a>
	<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_customer');?></a>
</div>

<table class="table table-hover">
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
			
			<th><a href="<?php echo site_url($this->config->item('admin_folder').'/customers/index/lastname/');?>/<?php echo ($field == 'lastname')?$by:'';?>"><?php echo lang('lastname');?>
				<?php if($field == 'lastname'){ echo ($by == 'ASC')?'<i class="icon-chevron-up"></i>':'<i class="icon-chevron-down"></i>';} ?> </a></th>
			
			<th><a href="<?php echo site_url($this->config->item('admin_folder').'/customers/index/firstname/');?>/<?php echo ($field == 'firstname')?$by:'';?>"><?php echo lang('firstname');?>
				<?php if($field == 'firstname'){ echo ($by == 'ASC')?'<i class="icon-chevron-up"></i>':'<i class="icon-chevron-down"></i>';} ?></a></th>
			
			<th><a href="<?php echo site_url($this->config->item('admin_folder').'/customers/index/email/');?>/<?php echo ($field == 'email')?$by:'';?>"><?php echo lang('email');?>
				<?php if($field == 'email'){ echo ($by == 'ASC')?'<i class="icon-chevron-up"></i>':'<i class="icon-chevron-down"></i>';} ?></a></th>
			<th><?php echo lang('active');?></th>
			<th></th>
		</tr>
	</thead>
	
	<tbody>
		<?php
		$page_links	= $this->pagination->create_links();
		
		if($page_links != ''):?>
		<tr><td colspan="5" style="text-align:center"><?php echo $page_links;?></td></tr>
                
		<?php endif;?>
                
		<?php echo (count($report_details) < 1)?'<tr><td style="text-align:center;" colspan="5">'.lang('no_customers').'</td></tr>':''?>
                <?php foreach ($report_details as $customer):?>
		<tr>
			<?php /*<td style="width:16px;"><?php echo  $customer->id; ?></td>*/?>
			<td><?php echo  $customer->lastname; ?></td>
			<td class="gc_cell_left"><?php echo  $customer->firstname; ?></td>
			<td><a href="mailto:<?php echo  $customer->email;?>"><?php echo  $customer->email; ?></a></td>

			<td>
				<div class="btn-group" style="float:right">
					<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$customer->id); ?>"><i class="icon-pencil"></i> <?php echo lang('edit');?></a>
					
					<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/customers/addresses/'.$customer->id); ?>"><i class="icon-envelope"></i> <?php echo lang('addresses');?></a>
					
					<a class="btn btn-danger" href="<?php echo site_url($this->config->item('admin_folder').'/customers/delete/'.$customer->id); ?>" onclick="return areyousure();"><i class="icon-trash icon-white"></i> <?php echo lang('delete');?></a>
				</div>
			</td>
		</tr>
<?php endforeach;
		if($page_links != ''):?>
		<tr><td colspan="5" style="text-align:center"><?php echo $page_links;?></td></tr>
		<?php endif;?>
	</tbody>
</table>

<?php include('footer.php'); ?>