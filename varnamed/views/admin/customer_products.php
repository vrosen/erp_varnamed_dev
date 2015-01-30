
<?php include('header.php'); ?>

<?php
    $class = 'class = span1';
    $class_1 = 'class = span2';
    $current_month = date('F');
    $current_year = date('Y');
    $period = array(
        
        'current' => $current_month,
        'January'   => 'January',
        'February'  => 'February',
        'March'     => 'March',
        'April'     => 'April',
        'May'       => 'May',
        'June'      => 'June',
        'July'      => 'July',
        'August'    => 'August',
        'September' => 'September',
        'October'   => 'October',
        'November'  => 'November',
        'December'  => 'December',
    );
    $period_y = array(
        
        'current'   => $current_year,
        '2006'      => '2006',
        '2007'      => '2007',
        '2008'      => '2008',
        '2009'      => '2009',
        '2010'      => '2010',
        '2011'      => '2011',
        '2012'      => '2012',
        '2013'      => '2013',
        '2014'      => '2014',
    );
	
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


            $return = site_url($admin_folder.'/customers/products/'.$id.'/'.$by.'/'.$sort.'/'.$code);

            echo '<a href="'.$return.'">'.lang($lang).$icon.'</a>';

    }

?>

<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_product');?>');
}
</script>


	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo $company; ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped table-hover" style="border: 1px solid #ddd;">
						<thead>
								<tr>

									<th style="white-space:nowrap"><?php echo sort_url($id,'product_nr','code', $order_by, $sort_order, $code, $this->config->item('admin_folder'));?></th>
									<th><?php echo lang('quantity');?></th>
									<th><?php echo lang('order_number');?></th>
									<th><?php echo lang('sold_for');?></th>
									<?php if($this->bitauth->is_admin()): ?>
									<th><?php echo lang('bought_for');?></th>
									<?php endif; ?>
									<th><?php echo lang('profit'); ?></th>
									<?php if($this->bitauth->is_admin()): ?>
									<th><?php echo lang('margin'); ?></th>
									<th><?php echo lang('price');?></th>
									<?php endif; ?>
									<th><?php echo $saleprice_name;?></th>
									 <th><?php echo lang('name');?></th>
								</tr>
						</thead>
						<tbody>
						<?php if (!empty($recent_products)): ?>
							<?php foreach($recent_products as $recent_product):?>
								<?php foreach($recent_product as $product):?>

									<tr>
										<td><?php echo $product['code'];?></td>
										<td><?php echo $product['quantity'];?></td>
										<td><?php echo $product['order_number'];?></td>
										<td><?php echo format_currency($product['saleprice']*$product['quantity']); ?></td>
										<?php if($this->bitauth->is_admin()): ?>
										<td><?php echo format_currency(($product['saleprice']*$product['quantity'])-($product['warehouse_price']*$product['quantity'])); ?></td>
										<?php endif; ?>
										<td><?php echo format_currency($product['warehouse_price']*$product['quantity']); ?></td>
										<?php 
										@$x = $product['warehouse_price']*$product['quantity'];
										@$y = $product['saleprice']*$product['quantity'];
										@$percent = $x/$y;
										?>
										<?php if($this->bitauth->is_admin()): ?>
											<td><?php echo $percent_friendly = number_format( $percent * 100, 2 ) . '%';?></td>
											<td><?php echo format_currency($product['warehouse_price']);?></td>
										<?php endif; ?>
										<td><?php echo format_currency($product['saleprice']);?></td>
										<td><?php echo $product['description'];?></td>										
									</tr>
									<?php
									$product_quantity[] = $product['quantity'];
									$product_sold_for[] = $product['saleprice']*$product['quantity'];
									$product_bought_for[] = ($product['saleprice']*$product['quantity'])-($product['warehouse_price']*$product['quantity']);
									$product_profit[] = $product['warehouse_price']*$product['quantity'];

									
									?>
								<?php endforeach;?>
							<?php endforeach;?>
								<?php
									//totals
									$total_quantity = array_sum($product_quantity);
									$total_sold_for = array_sum($product_sold_for);
									$total_bought_for = array_sum($product_bought_for);
									$total_profit = array_sum($product_profit);
									
									
									@$x = $total_bought_for*$total_quantity;
									@$y = $total_sold_for*$total_quantity;
									@$percent = $x/$y;
									$total_margin = number_format( $percent * 100, 2 ).'%';	
								?>
							<?php endif; ?>
						</tbody>
									<tr>
										<td style="font-size: 18px;"><strong>Totals</strong><?php //echo $product['code'];?></td>
										<td style="font-size: 16px;"><?php echo $total_quantity;?></td>
										<td><?php //echo $product['code'];?></td>
										<td><?php echo format_currency($total_sold_for);?></td>
										<td><?php echo format_currency($total_bought_for);?></td>
										<td><?php echo format_currency($total_profit);?></td>
										<td><?php echo $total_margin;?></td>
										<td><?php //echo $product['code'];?></td>
										<td><?php //echo $product['code'];?></td>
										<td><?php //echo $product['code'];?></td>
								</tr>
						<tfoot>
						</tfoot>
					</table>
				</div>
			</div>
	
								<button type="submit" class="btn btn-info" onclick="history.go(-1); return false;" >Back<?php //echo lang('form_save');?></button>


<?php include('footer.php');