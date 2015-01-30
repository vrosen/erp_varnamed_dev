<?php include('header.php'); ?>
<?php
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
 <?php //if($can_edit_product): ?>
<link href='http://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>	
<?php
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
                $sort   = 'desc';
                $icon   = ' <i class="icon-chevron-up"></i>';
            }
            else{
                $sort   = 'asc';
                $icon   = ' <i class="icon-chevron-down"></i>';
            }
        }
        else
        {
                $sort   = 'asc';
                $icon   = '';
        }


        $return = site_url($admin_folder.'/products/index/'.$by.'/'.$sort.'/'.$code);

        echo '<a href="'.$return.'">'.lang($lang).$icon.'</a>';

    }
?>
<?php if(!empty($term)): ?>
    <?php
        $term = json_decode($term);
        if(!empty($term->term) || !empty($term->category_id)):
    ?>
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
<script>
$(document).ready(function(){
  $('#example_').dataTable().yadcf([
        {column_number : 0},
	   // {column_number : 1,  filter_type: "range_number_slider", filter_container_id: "external_filter_container"},
	    {column_number : 2, data: ["Yes", "No"], filter_default_label: "Select Yes/No"},
	    {column_number : 3, text_data_delimiter: ",", filter_type: "auto_complete"},
	    {column_number : 4, column_data_type: "html", html_data_type: "text", filter_default_label: "Select tag"}]);
});
$(document).ready(function(){
  $('#example').dataTable().yadcf([
		{column_number : 0, text_data_delimiter: ",", filter_type: "auto_complete"},
		{column_number : 1, text_data_delimiter: ",", filter_type: "auto_complete"},
		{column_number : 2, text_data_delimiter: ",", filter_type: "auto_complete"},
	    {column_number : 3, text_data_delimiter: ",", filter_type: "auto_complete"},
	    {column_number : 4, text_data_delimiter: ",", filter_type: "auto_complete"},
	    {column_number : 5, text_data_delimiter: ",", filter_type: "auto_complete"},
	    {column_number : 6, column_data_type: "html", html_data_type: "text", filter_default_label: "Select tag"}]);
});
</script>






						<?php
							$webshop_array = array(
								'0'		=>   'Select webshop',
								'BEL'   =>   'Belgique',
								'BE'    =>   'België',
								'DE'    =>   'Deutschland',
								'FR'    =>   'France',
								'LX'    =>   'Luxembourg',
								'NL'    =>   'Nederland',
								'UK'    =>   'United Kingdom',
								'AU'    =>   'Österreich',    
							); 
						?>
					<div style="float: left; margin-right: 5px;">
						<?php echo form_open($this->config->item('admin_folder').'/products/');?>
							<?php if(!empty($all_categories)): ?>
								<?php $js = 'id="category" class="form-control" style="margin-bottom: 5px;" onChange="this.form.submit()"'; ?>
								<?php echo form_dropdown('category',$all_categories,$cat,$js); ?>
							<?php endif; ?>
						</form>
					</div>
					<div style="float: left; margin-right: 5px;">
						<?php echo form_open($this->config->item('admin_folder').'/products/');?>
							<?php if(!empty($all_groups)): ?>
								<?php $js = 'id="group" class="form-control" style="margin-bottom: 5px;" onChange="this.form.submit()"'; ?>
								<?php echo form_dropdown('group',$all_groups,$grp,$js); ?>
							<?php endif; ?>
						</form>
					</div>
					<div style="float: left; margin-right: 5px;">
						<?php echo form_open($this->config->item('admin_folder').'/products/');?>
							<?php $js_web = 'id="webshop" class="form-control" style="margin-bottom: 5px;" onChange="this.form.submit()"'; ?>
							<?php echo form_dropdown('webshop',$webshop_array,$web_shop,$js_web); ?>
						</form>
					</div>

                    <span class="btn-group pull-left" style="margin-bottom: 10px;">
                        <?php echo form_open($this->config->item('admin_folder').'/products/');?>
                            <input class="select-shop" type="hidden" name="clear" value="clear"/>
                            <input class=" view-all-products btn btn-xs btn-info button-hover" type="submit" value="View all products">
                        </form>
                    </span>

    <div class="panel panel-default" style="float: left;">
    <p>&nbsp;</p>
    </div>
                    
<?php echo form_open($this->config->item('admin_folder').'/products/bulk_save', array('id'=>'bulk_form')) ;?>


    <div class="panel panel-default table-responsive" style="width: 100%; float: left;">
        <div class="panel-heading"><?php echo lang('products'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
                <div class="panel-body">
                        
                    <span class="btn-group pull-left" style="margin-bottom: 10px;">
                        <button class="update btn btn-xs btn-info button-hover" href="#"><?php echo lang('bulk_save');?></button>
                        <a class="products-add-new-product btn btn-xs btn-default button-hover" style="font-weight:normal;"href="<?php echo site_url($this->config->item('admin_folder').'/products/form');?>"><?php echo lang('add_new_product');?></a>
                    </span>

    <!--<div class="table-responsive">-->
    <table class="table table-hover" id="example" style="border: 1px solid #ddd;">
        <thead>
            <tr>
                <th class="col-lg-1 col-md-1 col-sm-1">
                    <?php 
                        echo sort_url(
                                'code', 
                                'code', 
                                $order_by, 
                                $sort_order, 
                                $code, 
                                $this->config->item( 'admin_folder')
                            );
                    ?>
                </th>
        <th class="col-lg-4 col-md-4 col-sm-4">
                    <?php 
                        echo sort_url(
                                'name', 
                                'name', 
                                $order_by, 
                                $sort_order, 
                                $code, 
                                $this->config->item('admin_folder')
                        );
                    ?>
                </th>
                <th class="col-lg-1 col-md-1 col-sm-1">
                    <?php 
                        echo sort_url(
                                'type', 
                                'type', 
                                $order_by, 
                                $sort_order, 
                                $code, 
                                $this->config->item('admin_folder')
                        );
                    ?>
                </th>

                    <th class="col-lg-1 col-md-1 col-sm-1">
                        <?php 
                            echo 'Package details';
                        ?>
                    </th>
                    
                <?php if($can_edit_product): ?>
                    <th class="col-lg-1 col-md-1 col-sm-1">
                        <?php 
                            echo sort_url(
                                    'EK', 
                                    'EK', 
                                    $order_by, 
                                    $sort_order, 
                                    $code, 
                                    $this->config->item('admin_folder')
                            );
                        ?>
                    </th>
                <?php endif; ?>
                
                <?php if($can_edit_product): ?>
                    <th class="col-lg-1 col-md-1 col-sm-1">
                        <?php 
                            echo sort_url(
                                    'price', 
                                    'price', 
                                    $order_by, 
                                    $sort_order, 
                                    $code, 
                                    $this->config->item('admin_folder')
                            );
                        ?>
                    </th>
                <?php endif; ?>
                <?php 
                    switch ($web_shop) {
							case 1:
								?><th><?php echo sort_url('saleprice_BE', 'saleprice_BE', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th><?php
                            break;
							case 2:
								?><th><?php echo sort_url('saleprice_BE', 'saleprice_BE', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th><?php
                            break;
                            case 3:
                                ?><th><?php echo sort_url('saleprice_DE', 'saleprice_DE', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th><?php
                                break;
                            case 4:
                                ?><th><?php echo sort_url('saleprice_FR', 'saleprice_FR', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th><?php
								break;
                            case 5:
                                ?><th><?php echo sort_url('saleprice_LX', 'saleprice_LX', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th><?php
								break;
                            case 6:
                                ?><th><?php echo sort_url('saleprice_NL', 'saleprice_NL', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th><?php
								break;
                            case 7:
                                ?><th><?php echo sort_url('saleprice_UK', 'saleprice_UK', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th><?php
								break;
                            case 8:
                                ?><th><?php echo sort_url('saleprice_AU', 'saleprice_AU', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th><?php
                                break;
                    }
                ?>                                
                <th class="col-lg-1 col-md-1 col-sm-1">
                    <?php 
                        echo sort_url(
                                'visible', 
                                'enabled',
                                $order_by, 
                                $sort_order, 
                                $code, 
                                $this->config->item('admin_folder')
                        );
                     ?>
                </th>
                <?php if($can_edit_product): ?>
                    <th class="col-lg-1 col-md-1 col-sm-1">Edit</th>
                    <th class="col-lg-1 col-md-1 col-sm-1">Delete</th>
                <?php endif; ?>
            </tr>
            
    </thead>
    <tbody>
        <?php if(!count($products)) :?>
            <tr>
                <td style="height: 34px; text-align:center; padding: 0!important; margin: 0!important;" colspan="7">
                    <?php echo lang('no_products') ?>
                </td>
            </tr>
        <?php endif;?>

        <?php if(!empty($products)): ?>
			<?php foreach ($products as $product):?>                 
				<tr>
					<td style="min-width: 70px;" class="input-focus-wrapper"><?php echo str_replace('/','',$product->code) ?></td>
					<td style="min-width: 70px;" class="input-focus-wrapper"><?php echo str_replace('/','',$product->name) ?></td>
					<td style="min-width: 70px;" class="input-focus-wrapper"><?php echo str_replace('/','',$product->type) ?></td>
					<td style="min-width: 70px;" class="input-focus-wrapper"><?php echo str_replace('/','',$product->package_details) ?></td>
					<td style="min-width: 70px;" class="input-focus-wrapper"><?php echo str_replace('/','',$product->EK) ?></td>
					<td style="min-width: 70px;" class="input-focus-wrapper"><?php echo str_replace('/','',$product->price) ?></td>
					<td style="min-width: 70px;" class="input-focus-wrapper"><?php echo str_replace('/','',$product->saleprice) ?></td>
					
					<td style="text-align: center; min-width: 50px;">
						<a class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="bottom" title='Edit' style="display: inline-block; font-size: 14px;" href="<?php echo  site_url($this->config->item('admin_folder').'/products/form/'.$product->id);?>"><?php //echo lang('form_view')?>
						</a>
					</td>
					<td style="text-align: center; min-width: 50px;">
						<a class="glyphicon glyphicon-trash" onclick="return areyousure();" data-toggle="tooltip" data-placement="bottom" title='Delete' style="display: inline-block; font-size: 14px;" href="<?php echo  site_url($this->config->item('admin_folder').'/products/delete/'.$product->id);?>"><?php //echo lang('form_view')?></a>
					</td>
				</tr>
			<?php endforeach; ?>
        <?php endif;?>

    </tbody>
    </table>
    <!--</div>-->

</form>

</div>

</div>

<div class="panel panel-default" style="float: left;">
    <button type="submit" class="btn btn-info button-hover" onclick="history.go(-1); return false;" >Back<?php //echo lang('form_save');?></button>
</div>

<!--<div class="row custom-pagination">
    <div class="span12" style="border-bottom:1px solid #f5f5f5;">
        <div class="row">-->
            <div class="span4">
                <?php echo $this->pagination->create_links();?>   &nbsp;
            </div>
       <!-- </div>
    </div>
</div>-->






<?php include('footer.php'); ?>

<script>
var $tip1 = $('.glyphicon');
$tip1.tooltip({trigger: 'hover'});
</script>












