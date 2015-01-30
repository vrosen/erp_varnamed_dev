<?php include('header.php');

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


            $return = site_url($admin_folder.'/stock/stock_check_out/'.$by.'/'.$sort.'/'.$code);

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
</script>
<style type="text/css">
	.pagination {
		margin:0px;
		margin-top:-3px;
	}
</style>
<div class="row">
	<div class="span12" style="border-bottom:1px solid #f5f5f5;">
		<div class="row">
			<div class="span4">
				<?php echo $this->pagination->create_links();?>	&nbsp;
			</div>
			<div class="span8">
				<?php echo form_open($this->config->item('admin_folder').'/products/index', 'class="form-inline" style="float:right"');?>
					<fieldset>

						
						<input type="text" class="span2" name="term" placeholder="<?php echo lang('search_term');?>" /> 
						<button class="btn" name="submit" value="search"><?php echo lang('search')?></button>
						<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/products/index');?>">Reset</a>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="btn-group pull-right">
</div>

<?php echo form_open($this->config->item('admin_folder').'/products/bulk_save', array('id'=>'bulk_form'));?>

	<table class="table table-striped">
		<thead>
			<tr>
				<th><?php echo sort_url('product_nr', 'code', $order_by, $sort_order, $code, $this->config->item( 'admin_folder'));?></th>
                                <th><?php echo sort_url('number', 'productnr', $order_by, $sort_order, $code, $this->config->item( 'admin_folder'));?></th>
				<th><?php echo sort_url('checkout', 'name', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
                                <th><?php echo sort_url('reception_date', 'brand', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
                                <th><?php echo sort_url('expiration_date', 'brand', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
                                <th><?php echo sort_url('batch_number', 'brand', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
                                <th><?php echo sort_url('warehouse_place', 'brand', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
                                <th><?php echo sort_url('reason', 'brand', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
                                <th><?php echo sort_url('remarks', 'brand', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
				<th>
					<span class="btn-group pull-right">
						<button class="btn" href="#"><i class="icon-ok"></i> <?php echo lang('bulk_save');?></button>
						<a class="btn" style="font-weight:normal;"href="<?php echo site_url($this->config->item('admin_folder').'/products/form');?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_product');?></a>
					</span>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php echo (count($products) < 1)?'<tr><td style="text-align:center;" colspan="7">'.lang('no_products').'</td></tr>':''?>
	<?php foreach ($products as $product):?>
                            <tr>
				<td><?php echo form_input(array('name'=>'product['.$product->id.'][code]','value'=>form_decode($product->code), 'class'=>'span1'));?></td>
                                <td><?php echo form_input(array('name'=>'product['.$product->id.'][code]','value'=>form_decode($product->productnr), 'class'=>'span1'));?></td>
                                <td><?php echo form_input(array('name'=>'checkout','class'=>'span2'));?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                <?php
                                $options = array(
                                    '-1'    => lang('choose'),
                                    '1'    => lang('inventory'),
                                    '2'     => lang('defect'),
                                    '3'     => lang('expired'),
                                    '4'     => lang('testing_consited'),
                                    '5'     => lang('correction'),
                                    '6'     => lang('reclassification'),
                                    '7'     => lang('shipment'),
                                    '8'     => lang('sample_consumption'),
                                );
                                echo form_dropdown('product['.$product->id.'][enabled]', $options, set_value('enabled',$product->enabled), 'class="span2"');
                                ?>
				</td>
                                <td><?php echo form_input(array('name'=>'remarks','class'=>'span2'));?></td>
				<td>
                                    <span class="btn-group pull-right">
                                        <a class="btn" href="<?php echo  site_url($this->config->item('admin_folder').'/products/form/'.$product->id);?>"><i class="icon-pencil"></i>  <?php echo lang('edit');?></a>
                                        <a class="btn" href="<?php echo  site_url($this->config->item('admin_folder').'/products/form/'.$product->id.'/1');?>"><i class="icon-share-alt"></i> <?php echo lang('copy');?></a>
                                        <a class="btn btn-danger" href="<?php echo  site_url($this->config->item('admin_folder').'/products/delete/'.$product->id);?>" onclick="return areyousure();"><i class="icon-trash icon-white"></i> <?php echo lang('delete');?></a>
                                    </span>
				</td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>

</form>
<?php include('footer.php'); ?>