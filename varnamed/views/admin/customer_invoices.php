
<?php include('header.php'); ?>

<br><br><br>
	<?php
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
    <h4><?php //echo lang('customer').' '.$company; ?></h4>
    </div>



<?php 

    $class              = 'class = span2';
    $class_1            = 'class = span2';
    $current_month      = date('F');
    $current_year       = date('Y');
    
    $period_month = array(
        

        '01'   => 'January',
        '02'  => 'February',
        '03'     => 'March',
        '04'     => 'April',
        '05'       => 'May',
        '06'      => 'June',
        '07'      => 'July',
        '08'    => 'August',
        '09' => 'September',
        '10'   => 'October',
        '11'  => 'November',
        '12'  => 'December',
    );
    
    $period_y = array(
        

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
    $status_array = array(
        
       
       
            1       =>  'Closed',
         2       =>  'Open',
        'all'   =>  'Select all'
        
        );
    
    
?>

    <?php echo form_open($this->config->item('admin_folder').'/customers/all_invoices/'.$customer_number);?>
    
    <?php 
        $js_status  = 'id="invoice_status" onChange="this.form.submit();"';
        $js_month   = 'id="month" onChange="this.form.submit();"';
        $js_year    = 'id="year" onChange="this.form.submit();"';
    ?>

    <?php
        if(!empty($month)){
            echo form_dropdown('month', $period_month, $month,$js_month);
        }
        else {
            echo form_dropdown('month', $period_month, date('m'),$js_month);
        }
    ?>&nbsp;
    <?php 
        if(!empty($year)){
            echo form_dropdown('year', $period_y, $year,$js_year); 
        }
        else {
            echo form_dropdown('year', $period_y, date('Y'),$js_year); 
        }
    ?>&nbsp;
    <?php 
        
        if(!empty($status)){
            echo form_dropdown('invoice_status', $status_array, $status,$js_status);
        }
        else {
            echo form_dropdown('invoice_status', $status_array,'all',$js_status);
        }
    ?>
</form>





<table class="table table-striped">

    <thead>
            <tr>
                <th><?php echo lang('invoice_number');?></th>
                <th><?php echo lang('invoice_dispatch');?></th>
                <th><?php echo lang('total');?></th>
                <th><?php echo lang('paid');?></th>
                <th><?php echo lang('paid_on');?></th>
                <th><?php echo lang('ammount_due');?></th>
            </tr>
    </thead>
    <tbody>
	                <?php
					//echo '<pre>';
					//print_r($invoices);
					//echo '</pre>';
					?>
	<?php if(!empty($invoices)): ?>				
        <?php foreach($invoices as $invoice):?>
            <tr>

                <td><?php echo $invoice->invoice_number; ?></td>
                <td><?php echo $invoice->created_on; ?></td>
                <td><?php echo format_currency($invoice->totalgross); ?></td>
                <td><?php echo format_currency($invoice->paid_sum); ?></td>
                <td><?php echo format_currency($invoice->paid_on); ?></td>
                <td><?php echo $ammount_due = format_currency($invoice->totalgross - $invoice->paid_sum) ?></td>
		</tr>
		<?php endforeach;?>
                <th><?php echo lang('total');?></th>
                <td colspan="5">0.00</td>
	</tbody>
        <?php endif; ?>
    </table>
&nbsp;
    <div class="btn-group" style="float:left">
        <a class="btn btn-primary" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$id); ?>"><i class="icon-step-backward"></i> <?php echo lang('back');?></a>
    </div>
    <div class="btn-group" style="float:left">
        <!-- <a class="btn btn-warning" href="<?php //echo site_url($this->config->item('admin_folder').'/customers/export_xml/'.$id); ?>"><i class="icon-print"></i> <?php echo lang('excel');?></a> -->
    </div>


<?php include('footer.php');