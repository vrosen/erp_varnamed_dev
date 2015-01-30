<?php include('header.php'); ?>

<?php

if(!$code){
            $code = '';
    }
    else{
            $code = '/'.$code;
    }
    
    function sort_url($id , $lang, $by, $sort, $sorder, $code, $admin_folder){

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


            $return = site_url($admin_folder.'/groups/view_products/'.$id.'/'.$by.'/'.$sort.'/'.$code);

            echo '<a href="'.$return.'">'.lang($lang).$icon.'</a>';

    }

    if(!empty($term)){
            $term = json_decode($term);
            if(!empty($term->term) || !empty($term->category_id)){
					?><div class="alert alert-info"><?php
						echo sprintf(lang('search_returned'), intval($total));
					?></div><?php
			}
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




<?php echo form_open($this->config->item('admin_folder').'/groups/update_products/'.$id_id, array('id'=>'bulk_form'));?>
	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo $group_name; ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-hover" style="border: 1px solid #ddd;">
						<thead>
							<tr>

								<th><?php echo sort_url($id_id,'code','code', $order_by, $sort_order, $code, $this->config->item( 'admin_folder'));?></th>
								<th><?php echo sort_url($id_id,$name_product, $name_product, $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
								<th><?php echo sort_url($id_id,'saleprice', 'saleprice', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
								<th><?php echo sort_url($id_id,'saleprice_DE', 'saleprice_DE', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
								<th><?php echo sort_url($id_id,'saleprice_AU', 'saleprice_AU', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
								<th><?php echo sort_url($id_id,'saleprice_FR', 'saleprice_FR', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
								<th><?php echo sort_url($id_id,'saleprice_BE', 'saleprice_BE', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
								<th><?php echo sort_url($id_id,'saleprice_UK', 'saleprice_UK', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
								<th><?php echo sort_url($id_id,'saleprice_LX', 'saleprice_LX', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
								<th>Quantity<?php //echo sort_url($id_id,'quantity', 'quantity', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
								<th><?php echo sort_url($id_id,'enabled', 'enabled', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
							</tr>
						</thead>
						<tbody>
								<?php if(!empty($products)): ?>
									<?php foreach ($products as $product):?>
										<?php if($product != 1): ?>
									<tr>
										<td style="width: 5%;">
											<?php echo form_input(array('name'=>'product['.$product['id'].'][code]','value'=>form_decode(str_replace('/','',$product['code'])),'class'=>'form-control' ,'style'=>'width: 97%;')); ?>
										</td>

										<?php if(!empty($shop_index)): ?>
											<td style="width: 40%;"><?php echo form_input(array('name'=>'product['.$product['id'].'][name_'.$shop_index.']','value'=>form_decode($product[$name_product]),'class'=>'form-control','style'=>'width: 99%;'));?></td>
										<?php else: ?>
											<td style="width: 40%;"><?php echo form_input(array('name'=>'product['.$product['id'].'][name_NL]','value'=>form_decode($product['name_NL'])));?></td>
										<?php endif; ?>
										
										<script>						
												jQuery(function(value) {
													$("<?php echo '#price_nl_'.$product['id']; ?>").autoNumeric('init');
													$("<?php echo '#price_nl_'.$product['id']; ?>").autoNumeric('set', value);	
													
													$("<?php echo '#price_de_'.$product['id']; ?>").autoNumeric('init');
													$("<?php echo '#price_de_'.$product['id']; ?>").autoNumeric('set', value);	
													
													$("<?php echo '#price_au_'.$product['id']; ?>").autoNumeric('init');
													$("<?php echo '#price_au_'.$product['id']; ?>").autoNumeric('set', value);	
													
													$("<?php echo '#price_fr_'.$product['id']; ?>").autoNumeric('init');
													$("<?php echo '#price_fr_'.$product['id']; ?>").autoNumeric('set', value);	
													
													$("<?php echo '#price_be_'.$product['id']; ?>").autoNumeric('init');
													$("<?php echo '#price_be_'.$product['id']; ?>").autoNumeric('set', value);
	
													$("<?php echo '#price_uk_'.$product['id']; ?>").autoNumeric('init');
													$("<?php echo '#price_uk_'.$product['id']; ?>").autoNumeric('set', value);	
													
													$("<?php echo '#price_lx_'.$product['id']; ?>").autoNumeric('init');
													$("<?php echo '#price_lx_'.$product['id']; ?>").autoNumeric('set', value);	
												});
										</script>
										<td style="width: 5%;">
											<?php 
												if($product['saleprice_NL']  == '0.00'){
													echo 'N/A';
												}
												else {
													echo form_input(array('name'=>'product['.$product['id'].'][saleprice_NL]','value'=>form_decode($product['saleprice_NL']),'id'=>'price_nl_'.$product['id'] ,'data-a-sign'=>'€', 'data-a-sep'=>".", 'data-a-dec'=> ",", 'class'=>'form-control','style'=>'width: 95%;'));
												}
											?>
										</td>
										<td style="width: 5%;">
											<?php 
												if($product['saleprice_DE']  == '0.00'){
													echo 'N/A';
												}
												else {
													echo form_input(array('name'=>'product['.$product['id'].'][saleprice_DE]','value'=>form_decode($product['saleprice_DE']),'id'=>'price_de_'.$product['id'] ,'data-a-sign'=>'€', 'data-a-sep'=>".", 'data-a-dec'=> ",", 'class'=>'form-control','style'=>'width: 95%;'));
												}
											?>
										</td>	
										<td style="width: 5%;">
											<?php 
												if($product['saleprice_AU']  == '0.00'){
													echo 'N/A';
												}
												else {
													echo form_input(array('name'=>'product['.$product['id'].'][saleprice_AU]','value'=>form_decode($product['saleprice_AU']),'id'=>'price_au_'.$product['id'] ,'data-a-sign'=>'€', 'data-a-sep'=>".", 'data-a-dec'=> ",", 'class'=>'form-control','style'=>'width: 95%;'));
												}
											?>
										</td>
										<td style="width: 5%;">
											<?php 
												if($product['saleprice_FR']  == '0.00'){
													echo 'N/A';
												}
												else {
													echo form_input(array('name'=>'product['.$product['id'].'][saleprice_FR]','value'=>form_decode($product['saleprice_FR']),'id'=>'price_fr_'.$product['id'] ,'data-a-sign'=>'€', 'data-a-sep'=>".", 'data-a-dec'=> ",", 'class'=>'form-control','style'=>'width: 95%;'));
												}
											?>
										</td>
										<td style="width: 5%;">
											<?php 
												if($product['saleprice_BE']  == '0.00'){
													echo 'N/A';
												}
												else {
													echo form_input(array('name'=>'product['.$product['id'].'][saleprice_BE]','value'=>form_decode($product['saleprice_BE']),'id'=>'price_be_'.$product['id'] ,'data-a-sign'=>'€', 'data-a-sep'=>".", 'data-a-dec'=> ",", 'class'=>'form-control','style'=>'width: 95%;'));
												}
											?>
										</td>
										<td style="width: 5%;">
											<?php 
												if($product['saleprice_UK']  == '0.00'){
													echo 'N/A';
												}
												else {
													echo form_input(array('name'=>'product['.$product['id'].'][saleprice_UK]','value'=>form_decode($product['saleprice_UK']),'id'=>'price_uk_'.$product['id'] ,'data-a-sign'=>'£', 'data-a-sep'=>".", 'data-a-dec'=> ",", 'class'=>'form-control','style'=>'width: 95%;'));
												}
											?>
										</td>
										<td style="width: 5%;">
											<?php 
												if($product['saleprice_LX']  == '0.00'){
													echo 'N/A';
												}
												else {
													echo form_input(array('name'=>'product['.$product['id'].'][saleprice_LX]','value'=>form_decode($product['saleprice_LX']),'id'=>'price_lx_'.$product['id'] ,'data-a-sign'=>'€', 'data-a-sep'=>".", 'data-a-dec'=> ",", 'class'=>'form-control','style'=>'width: 95%;'));
												}
											?>
										</td>
										<td style="width: 5%;">
											<?php echo form_input(array('name'=>'product['.$product['id'].'][quantity]', 'value'=>set_value('quantity', $product['quantity']), 'class'=>'form-control','style'=>'width: 70px;'));?>
										</td>
										<td>
											<?php
											$options = array('1'	=> lang('enabled'),'0'	=> lang('disabled'));
											
											echo form_dropdown('product['.$product['id'].'][enabled]', $options, set_value('enabled',$product['enabled']),'class=form-control');
											?>
										</td>
										<td style="text-align: center; width: 50px;">
											<a class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="bottom" title='Edit' style="display: inline-block; font-size: 14px;" href="<?php echo  site_url($this->config->item('admin_folder').'/products/form/'.$product['id']);?>"><?php //echo lang('form_view')?></a>
										</td>
										<td style="text-align: center; width: 50px;">
											<a class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="bottom" title='Delete' style="display: inline-block; font-size: 14px;" href="<?php echo  site_url($this->config->item('admin_folder').'/products/delete/'.$product['id']);?>" onclick="return areyousure();"><?php //echo lang('form_view')?></a>
										</td>

									</tr>
									<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
					</table>
				</div>
		</div>
		<input type="submit" class="btn btn-info" value="Update">
		<a class="btn btn-info" href="<?php echo site_url($this->config->item('admin_folder').'/groups/'); ?>">Back</a>
</form>
<?php //echo $this->pagination->create_links();?>	

<?php include('footer.php'); ?>

<script>
var $tip1 = $('.glyphicon');
$tip1.tooltip({trigger: 'hover'});
</script>





