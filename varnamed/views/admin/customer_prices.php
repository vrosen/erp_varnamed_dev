
<?php include('header.php'); ?>


<?php

    if(!$code){
            $code = '';
    }
    else{
            $code = '/'.$code;
    }
    function sort_url($id,$lang, $by, $sort, $sorder, $code, $admin_folder){
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


            $return = site_url($admin_folder.'/customers/prices/'.$id.'/'.$by.'/'.$sort.'/'.$code);

            echo '<a href="'.$return.'">'.lang($lang).$icon.'</a>';

    }

    if(!empty($term)):
            $term = json_decode($term);
            if(!empty($term->term) || !empty($term->category_id)):?>
                    <div class="alert alert-info">
                            <?php echo sprintf(lang('search_returned'), intval($total));?>
                    </div>
            <?php endif;?>
    <?php endif;?>

<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_product');?>');
}
function sure()
{
	return confirm('Activate this product?');
}
</script>
<style type="text/css">
	.pagination {
		margin:0px;
		margin-top:-3px;
	}
</style>

<!--***************************************************************************************************************************************************-->
			<?php echo form_open($this->config->item('admin_folder').'/customers/prices/'.$id); ?>
			
				<div class="panel panel-default" style="width: 100%; float: left;">
					<div class="panel-heading">Add products to list<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
						</div>
							<div class="panel-body">
								<table id="myTable" class="table table-condensed" style="border: 1px solid #ddd;">
									<button id="addrow" class="glyphicon glyphicon-plus" ></button>
										<thead>
											<tr>
												<td>Product code<?php //echo lang('product_nr'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<td><?php echo lang('quantity'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<td>Package<?php //echo lang('num_vpe'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<td>Price<?php echo lang('VK'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<td><?php echo lang('discount'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<td>New Price<?php echo lang('unit_price'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<td>Name<?php echo lang('unit_price'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<td>Delete<?php echo lang('unit_price'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
											</tr>
										</thead>
										<tbody>
											<tr class='qqrow'>
												<td><input type="text" name="product_number[]" class="span2"  qq12="" required /></td>
												<td><input type="text" name="quantity[]" class="span1" required /></td>
												<td class='span3qq'></td>
												<td class='span1qq'></td>
												<td><?php echo form_input(array('name'=>'discount[]', 'class'=>'span2'));?></td>
												<td><?php echo form_input(array('name' => 'unit_price[]', 'class'=>'span'));?></td>
												<td class='span2qq'></td>
												<td><a id="ibtnDel" class="glyphicon glyphicon-trash" ></a></td>
											</tr>
										</tbody>
									</table>
										<td colspan="5" style="text-align: left;">
											<input class="btn btn-small" type="submit" name="submit" value="Add Product to List"/>
										</td>   
								</form>  
							</div>
						</div>		
 

                    		

<!--***************************************************************************************************************************************************-->
<br><br>
<script type="text/javascript">
function areyousure()
{
	return confirm('Are you sure you want to delete those products?');
}
</script>

<?php echo form_open($this->config->item('admin_folder').'/customers/make_offer/'.$id, array('onsubmit'=>'return submit_form();', 'class="form-inline"')); ?>
	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">Price list<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped table-hover" style="border: 1px solid #ddd;">
        <thead>
                <tr>
                    <th><button type="submit" class="glyphicon glyphicon-list-alt" ></button></th>
                    <th>Active</th>
                    <th style="font-size: 12px; white-space: nowrap">Code<?php //echo lang('quantity');?></th>
                    <th style="font-size: 12px; white-space: nowrap">Discount per Quantity<?php //echo lang('quantity');?></th>
                    <th style="font-size: 12px; white-space: nowrap">Discount %<?php //echo lang('product_nr');?></th>
                    <th style="font-size: 12px; white-space: nowrap">New Price<?php //echo lang('total');?></th>
					 <th style="font-size: 12px; white-space: nowrap">Sale Price <?php echo $index;?></th>
					 <?php if($this->bitauth->is_admin()): ?>
                    <th style="font-size: 12px; white-space: nowrap">Warehouse Price<?php //echo lang('quantity');?></th>
					<?php endif; ?>
                    <th style="font-size: 12px; white-space: nowrap">Date new price <?php //echo lang('name');?></th>
                    <th style="font-size: 12px; white-space: nowrap">Made by <?php //echo lang('name');?></th>
                    <th style="font-size: 12px; white-space: nowrap">Description <?php //echo lang('name');?></th>
                    <th style="font-size: 12px; white-space: nowrap">Activate<?php //echo lang('name');?></th>
                    <th style="font-size: 12px; white-space: nowrap">Delete <?php //echo lang('name');?></th>
                </tr>
        </thead>
        <tbody>
            <?php if(!empty($price_list)): ?>
			
			<?php
			
			$active_arr = array(NULL=> 'NO',1=>'YES'); 
			?>
                <?php foreach($price_list as $price): ?>
				
                    <tr>
                        <td><input name="products[]" type="checkbox" value="<?php echo $price->id; ?>" class="gc_check"/></td>			
                        <td style="font-size: 12px; white-space: nowrap; color: red"><?php echo $active_arr[$price->active]; ?></td>
                        <td style="font-size: 12px; white-space: nowrap"><?php echo $price->ARTIKELCOD; ?></td>
                        <td style="font-size: 12px; white-space: nowrap"><?php echo $price->VE; ?></td>
                        <td style="font-size: 12px; white-space: nowrap"><?php echo round($price->KORTING,2).' %'; ?></td>
                        <td style="font-size: 12px; white-space: nowrap"><?php echo $this->config->item('currency_symbol').' '.money_format('%.2n', $price->saleprice); ?></td>
                        <td style="font-size: 12px; white-space: nowrap"><?php echo $this->config->item('currency_symbol').' '.money_format('%.2n', $price->OSTUKSPRIJ); ?></td>
						<?php if($this->bitauth->is_admin()): ?>
							<td style="font-size: 12px; white-space: nowrap"><?php echo $this->config->item('currency_symbol').' '.money_format('%.2n', $price->WAREHOUSE); ?></td>
						<?php endif; ?>
                        <td style="font-size: 12px; white-space: nowrap"><?php echo $price->INVDATUM; ?></td>
                        <td style="font-size: 12px; white-space: nowrap"><?php echo $price->MADE_BY; ?></td>
                        <td style="font-size: 12px; white-space: nowrap"><?php echo $price->description; ?></td>
						<td style="text-align: center; width: 50px;">
							<a class="glyphicon glyphicon-ok-circle" style="display: inline-block; font-size: 16px;" onclick="return sure();" href="<?php echo site_url($this->config->item('admin_folder').'/customers/activate/'.$price->id.'/'.$id); ?>"><?php //echo lang('form_view')?></a>
						</td>
						<td style="text-align: center; width: 50px;">
							<a class="glyphicon glyphicon-trash" style="display: inline-block; font-size: 16px;" onclick="return areyousure();" href="<?php echo site_url($this->config->item('admin_folder').'/customers/delete_discount_product/'.$price->id.'/'.$id); ?>"><?php //echo lang('form_view')?></a>
						</td>
                    </tr>
                <?php endforeach; ?>
           <?php endif; ?>
        </tbody>
    </table>
<input type="hidden" name="client_id" value="<?php echo $id; ?>">
		</div>
	</div>
</form> 
					<div class="form-actions" style="margin:10px 10px 10px 20px;">
								<a href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$id); ?>" >Back<?php //echo lang('form_save');?></a>
							</div>  

<?php include('footer.php');