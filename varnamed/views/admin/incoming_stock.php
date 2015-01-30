<?php require('header.php'); 
	

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
	$return = site_url($admin_folder.'/stock/index/'.$by.'/'.$sort.'/'.$code);
	echo '<a href="'.$return.'">'.lang($lang).$icon.'</a>';
	}
	
if ($term):?>
    <div class="alert alert-info">
            <?php echo sprintf(lang('search_returned'), intval($total));?>
    </div>
<?php endif;?>

<style type="text/css">
	.pagination {
		margin:0px;
		margin-top:-3px;
	}
</style>




<?php echo form_open($this->config->item('admin_folder').'/stock/123'); ?>
    <table class="table table-striped">
        <thead>
            <tr><td><?php echo lang('product_nr'); ?></td><td><input name="product_number" placeholder="<?php echo lang('etc_product'); ?>" type="text" class="span2"/></td></tr>
            <tr><td><?php echo lang('invoice'); ?></td><td><input name="product_number" placeholder="<?php echo lang('etc_invoice'); ?>" type="text" class="span2"/></td></tr>
            <tr><td><?php echo lang('store_location'); ?></td><td><input name="product_number" placeholder="<?php echo lang('etc_storage'); ?>" type="text" class="span2"/></td></tr>
    </table>
        <input class="btn btn-primary" type="submit" value="<?php echo lang('save');?>"/>
</form>

<?php echo form_open($this->config->item('admin_folder').'/stock/index', 'class="form-inline" style="float:right"');?>
        <button class="btn" name="submit" value="export"><?php echo lang('xml_export')?></button>
</form>
<br>


<table class="table table-striped">
    <thead>
        <tr>

            <th><?php echo sort_url('product_nr', 'product_number', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
            <th><?php echo lang('quantity_number'); ?></th>
            <th><?php echo lang('reserved'); ?></th>
            <th><?php echo lang('warehouse'); ?></th>
            <th><?php echo lang('number_pro_packaging'); ?></th>
            <th><?php echo lang('spare_pro_package'); ?></th>
            <th><?php echo lang('value'); ?></th>
            <th><?php echo lang('reception_date'); ?></th>
            <th><?php echo lang('expiration_date'); ?></th>
            <th><?php echo lang('batch_number'); ?></th>
            <th><?php echo lang('warehouse_place'); ?></th>
            <th><?php echo lang('reason'); ?></th>
            <th><?php echo lang('invoice'); ?></th>
        </tr>
    </thead>
    <tbody>
	<?php echo (count($orders) < 1)?'<tr><td style="text-align:center;" colspan="8">'.lang('no_orders') .'</td></tr>':''?>
        <?php foreach($orders as $order): ?>
	<tr>

		<td><input name="product_number" type="text" class="span1"/></td>
                <td><input name="quantity_number" type="text" class="span1"/></td>
                <td><?php ?></td>
                <?php $class = 'class = "span3"'?>
                <td><?php $warehouse = array('1'=>'Combiwerk(Delft)','2'=>'Transoflex(Frechen)'); ?><?php echo form_dropdown('warehouse',$warehouse,'1',$class); ?></td>
                <td><?php ?></td>
                <td><?php ?></td>
                <td><?php ?></td>
                <td><input name="reception_date" type="text" class="span1"/></td>
                <td><input name="expiration_date" type="text" class="span1"/></td>
                <td><input name="batch_number" type="text" class="span1"/></td>
                <td><input name="warehouse_place" type="text" class="span1"/></td>
                <?php $reason = array('-1'=>'Select reason','1'=>'Order','2'=>'Correction','3'=>'Deleted shipment','4'=>'Return'); ?>
                <td><?php echo form_dropdown('reason',$reason,'-1',$class); ?></td>
                <td><?php ?></td>
	</tr>
    <?php endforeach; ?>
    </tbody>
    
</table>
</form>


<div id="saving_container" style="display:none;">
    <div id="saving" style="background-color:#000; position:fixed; width:100%; height:100%; top:0px; left:0px;z-index:100000"></div>
    <img id="saving_animation" src="<?php echo base_url('assets/img/storing_animation.gif');?>" alt="saving" style="z-index:100001; margin-left:-32px; margin-top:-32px; position:fixed; left:50%; top:50%"/>
    <div id="saving_text" style="text-align:center; width:100%; position:fixed; left:0px; top:50%; margin-top:40px; color:#fff; z-index:100001"><?php echo lang('saving');?></div>
</div>
<?php include('footer.php'); ?>


