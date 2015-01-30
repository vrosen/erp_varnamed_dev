<?php include('header.php'); ?>

<?php
$gender_male = array(
        'name'        => 'gender',
        'id'          => 'gender',
        'value'       => '1',
        'checked'     => TRUE,
        'style'       => 'margin:10px',
);
$gender_female = array(
        'name'        => 'gender',
        'id'          => 'gender',
        'value'       => '0',
        'checked'     => TRUE,
        'style'       => 'margin:10px',
);



if($current_shop == 3 )
{
    $Binnendienst = array(
	"0"  => 'Select',
        $ba_login => $ba_fullname,
	"170"=>'Marianne Rijn',
	"182"=>'Veronica Hoffman',
	"188"=>'Ann Jansens',
	"195"=>'Brigitte Becker',
	"208"=>'Stephanie Gillet',
	"210"=>'Petra Muller'	
    );
    $Buitendienst = array(
        "0"  => 'Select',
        $ba_login => $ba_fullname,
        "176"=>'Frits van Oorschot',
        "177"=>'Karel van Mossevelde',
        "188"=>'Ann Jansens',
        "192"=>'Hildo Kat',
	"200"=>'Ernest Lassman',
	"201"=>'Maria Meister',
	"205"=>'Geert Kloppenburg',
    );
}

$why = array(
		0	=>			'Select reason',
		2	=>			'Quote machen',
		3	=>			'Besuchen',
		4	=>			'Presentation',
		5	=>			'Telephone conversation',
		6	=>			'Request',
		7	=>			'Order',
		8	=>			'Sample',
		9	=>			'Catalogue',
		10	=>			'No need',
		11	=>			'Register',
		12	=>			'Visit report',
		13	=>			'Aanmaning',
		14	=>			'Retour',
);

if($current_shop == 3){
    $group_array= array(
        '1' => lang('hauptfirma'),
        '2' => 'Heeft dropship klant',
    );
}
else {
    $group_array= array(
        '1' => lang('customer'),
	'2' => lang('hauptfirma'),
	'3' => lang('supplier'),
	'4' => lang('other'),
    );
}

if($current_shop == 1 )
{
    $industry_array = array(
        '0'  => lang('choose_industry'),
	'82' => 'Abattoir',
	'66' => 'Ambulance service',
	'52' => 'Beauty salon',
	'77' => 'Butcher',
        '42' => 'Care group',
        '43' => 'Care shop',
        '74' => 'Cattle farmer',
        '56' => 'Cleaning',
        '38' => 'Day-care centre',
        '61' => 'Dental laboratory',
        '47' => 'Dental surgeons',
        '50' => 'Dental wholesale',
        '16' => 'Dentist',
        '58' => 'Disabled care',
        '20' => 'Doctor',
        '22' => 'Export',
        '35' => 'Family doctor',
	'75' => 'Fishmonger',
	'37' => 'Food service industry',
	'53' => 'Funeral parlour',
	'71' => 'Garden',
	'36' => 'Hairdresser',
	'3'  => 'Home care',
        '1'  => 'Hospital',
        '45' => 'Laboratory',
        '85' => 'Midwife',
        '59' => 'Nail studio',
        '2'  => 'Nursing home',
        '41' => 'Nursing home',
        '46' => 'Oral hygienist',
        '39' => 'Orthodontist',
	'8'  => 'Other / unknown',
        '40' => 'PMU',
        '79' => 'Painter',
        '34' => 'Pedicure',
        '62' => 'Pelvic therapist',
        '65' => 'Permanent make-up',
        '55' => 'Pet crematorium',
	'4'  => 'Pharmacy',
	'57' => 'Physiotherapy',
        '64' => 'Piercing studio/jeweller',
        '49' => 'Podotherapy',
        '67' => 'Private clinic',
        '32' => 'Private individual',
        '30' => 'Retailer',
        '33' => 'Tattoo shop',
        '54' => 'Veterinarian',
        '44' => 'Veterinary ambulance',
        '51' => 'Wholesale general',
    );
}
if($current_shop == 2 ){
    $industry_array = array(
        '0'     => lang('choose_industry'),
        '5'     => lang('care_shop'),
        '38'    => lang('convalescent_home'),
        '22'    => lang('export'),
        '1'     => lang('hospital'),
        '7'     => lang('medical_wholesale'),
        '39'    => lang('nursing_home'),
        '8'     => lang('other'),
        '6'     => lang('pharmaceutical_wholesaler'),
        '4'     => lang('pharmacy'),
        '32'    => lang('private_individual'),
        '18'    => lang('rest_convalescent_home'),
        '30'    => lang('retailer'),
    );	
}
if($current_shop == 3 ){
    $industry_array = array(
        '0'                         => lang('choose_industry'),
        '1'                 => 'Apotheek',
        '2'                 => 'Dental',
        '3'                 => 'Pedicure',
        '4'                 => 'Schoonheid',
        '5'                 => 'Schoonmaak',
        '6'                 => 'Medische winkel',
        '7'                 => 'Horeca',
        '8'                 => 'Kapper',
    );		
}
    
if($current_shop == 1 ){
    $standard_payment_method_array = array(
        '0'     => lang('select_payment_method'),
        '1'     => lang('invoice_upon_delivery'),
        '2'     => lang('direct_debit'),
        '3'     => lang('paid_in_advance'),
        '4'     => lang('iDEAL'),
        '6'     => lang('American_Express'),
        '7'     => lang('MasterCard'),
        '8'     => lang('VISA'),
        '9'     => lang('instant_wire_transfer'),
        '10'    => lang('Giropay'),
        '11'    => lang('EPS'),
        '12'    => lang('PAYPAL'),
        '5'     => lang('free_sample_delivery'),
        '13'    => lang('comforties_com_BV_account'),//set the shop variable
        '14'    => lang('by_cheque'), 
     ); 
}
if($current_shop == 2 ){
    $standard_payment_method_array = array(
        '0'     => lang('select_payment_method'),
        '1'     => lang('invoice_upon_delivery'),
        '2'     => lang('direct_debit'),
        '3'     => lang('paid_in_advance'),
        '4'     => lang('iDEAL'),
        '6'     => lang('American_Express'),
        '7'     => lang('MasterCard'),
        '8'     => lang('VISA'),
        '9'     => lang('instant_wire_transfer'),
        '10'    => lang('Giropay'),
        '11'    => lang('EPS'),
        '12'    => lang('PAYPAL'),
        '5'     => lang('free_sample_delivery'),
        '13'    => lang('dutchblue_com_BV_account'),//set the shop variable
        '14'    => lang('by_cheque'), 
    );
}
if($current_shop == 3 ){
    $standard_payment_method_array = array(
        '0' 	=> lang('select_payment_method'),
        '1'     => lang('advanced_payment'),
        '2'     => lang('direct_debit'),
    );
}
$payment_condition_array = array(
    '0'     => lang('set_condition'),
    '4'     => lang('immediately_without_deduction'),
    '3'     => lang('8_days_without_deduction'),
    '1'     => lang('30_days_without_deduction'),
    '5'     => lang('42_days_without_deduction'),
);
$gender_array = array(
    '0'  =>  'Select gender',
    '1'  =>  'Female',
    '2'  =>  'Male',
);
$country_array = array(
    '0'		=>  'Select country',
    'BEL'	=> 'Belgique / français',
    'BE'	=> 'België / nederlands',
    'DE'	=> 'Deutschland / deutsch',
    'FR'	=> 'France / français',
    'LX'	=> 'Luxembourg / français',
    'NL'	=> 'Nederland / nederlands',
    'UK'	=> 'United Kingdom / english',
    'AU'	=> 'Österreich / deutsch',
);

	$no_country = $this->session->flashdata('no_country');
		if(!empty($no_country)){
			echo '<h3>'.$no_country.'</h3>';
	}
	
	
	
	
	
	
	
?>
		<script>
		function areyousure()
		{
			return confirm('<?php echo 'Confirm delete comment'; //echo lang('confirm_delete_banner');?>');
		}
		</script>
		
		<div class="panel panel-default" style="float: left; " id="customer_info">
			<div class="panel-heading">Recent orders<span id="stbar" class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
				<div class="panel-body" id="customer_table" style="float: left;">
					<table class="table table-striped table-hover" style="border: 1px solid #ddd;">
						<thead>
							<tr>
								<th><?php echo lang('date');?></th>
								<th><?php echo lang('order_num');?></th>
								<th><?php echo lang('status');?></th>
								<th><?php echo lang('entered_by');?></th>
								<th><?php echo lang('total');?></th>
							</tr>
						</thead>
						<tbody>
						<?php if (!empty($order)):?>
							<?php foreach($order as $content):?>
									<tr>
										<td><?php echo $content->ordered_on; ?></td>
										<td><a href="<?php echo site_url($this->config->item('admin_folder').'/orders/view/'.$content->id);?>"><?php echo $content->order_number; ?></a></td>
										<td>
											<?php 
												if($content->status == 0){
													 echo lang('new'); 
												}
												if($content->status == 1){
													echo lang('in_warehouse'); 
												}
												if($content->status == 2){
													echo lang('shipped'); 
												}
												if($content->status == 3){
													echo lang('old'); 
												}
											?>
										</td>
										<td>
											<?php 
											if(!empty($content->entered_by)){
												echo $content->entered_by;
											}else {
											if($content->WEBSHOP == 1){
												echo 'WEBSHOP';
												}
											}
											?>
										</td>
										<td><?php echo format_currency($content->total); ?></td>
										<?php if($content->BACKORDER == '1'): ?>
										<td><span class="label label-important"><?php echo lang('backorder'); ?></span></td>
										<?php endif;?>
									</tr>
								<?php endforeach;?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>	
		</div>		
					
		<div class="panel panel-default" style="float: left; " id="customer_info">
			<div class="panel-heading">Recent products<span id="stbar" class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
				<div class="panel-body" id="customer_table" style="float: left;">
					<table class="table table-striped table-hover" style="border: 1px solid #ddd;">
						<thead>
							<tr>
								<th>Ordered on</th>
								<th>Product</th>
								<th>Quantity</th>
								<th>Description</th>
								<th>Order number</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($recent_products)): ?>
								<?php
									foreach($recent_products as $products){
										foreach($products as $product){
											?>
											<tr>
											<td><?php echo $product['ordered_on']; ?></td>
											<td><?php echo $product['code']; ?></td>
											<td><?php echo $product['quantity']; ?></td>
											<td><?php echo $product['description']; ?></td>
											<td><a href="<?php echo site_url($this->config->item('admin_folder').'/orders/view/'.$product['id']);?>"><?php echo $product['order_number']; ?></a></td>
											</tr>
											<?php
										
									}
								}
							endif; ?>
						</tbody>
					</table>
			</div>
		</div>
		
		<div class="panel panel-default" style="float: left; " id="customer_info">
			<div class="panel-heading">Recent invoices<span id="stbar" class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
				<div class="panel-body" id="customer_table" style="float: left;">
					<table class="table table-striped table-hover" style="border: 1px solid #ddd;">
						<thead>
							<tr>
												<th><?php echo lang('date');?></th>
												<th><?php echo lang('invoice');?></th>
												<th><?php echo lang('status');?></th>
												<th><?php echo lang('entered_by');?></th>
												<th><?php echo lang('total');?></th>
											</tr>
									</thead>
									<tbody>
									<?php if (!empty($invoices)):?>
										<?php foreach($invoices as $invoice):?>
											<tr>
													
												<td><?php echo $invoice->created_on; ?></td>
												<td><a href="<?php echo site_url($this->config->item('admin_folder').'/invoices/view/'.$invoice->id);?>"><?php echo $invoice->invoice_number; ?></a></td>
												<td>
													Not paid!!!
												</td>
												<td><?php echo $invoice->created_by; ?></td>
												<td><?php echo format_currency($invoice->totalgross); ?></td>
												<td></td>
											</tr>
												
										
										<?php endforeach;?>
									<?php endif; ?>
									</tbody>
								</table>
					</div>
		</div>


<?php if(!empty($id)): ?>
   
				
		<div class="panel panel-default" style="float: left; " id="customer_info">
			<div class="panel-heading">Comments<span id="stbar" class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
				<div class="panel-body" id="customer_table" style="float: left;">
					 <?php echo form_open($this->config->item('admin_folder').'/customers/add_comment/'.$id); ?>
					 <div style="margin-bottom: 1%;">
							<table class="table">
								<tr>

										<?php
										$data = array(
											'name'=>'new_comment',
											'style' => 'width: 99%; padding: 5px; margin: 5px 5px 3px 2px;', 
											'rows' => '1',
											'placeholder' => 'Add Comment',
											'class' => 'redactor',
											
										);
										echo form_textarea($data); 
										?>

										<button type="submit" class="btn btn-default btn-sm" ><?php echo lang('add_comment');?></button>
								
								</tr>
							</table>
							</div>
					</form>
					<div class="CSSTableGenerator" >
						<table>
							<tr>
								<td>
									<?php echo lang('date'); ?>
								</td>
								<td >
									<?php echo lang('agent'); ?>
								</td>
								<td>
									<?php echo lang('comment'); ?>
								</td>
								<td style="width: 3%;">Delete</td>
							</tr>
							<?php if(!empty($comments)): ?>
								<?php foreach($comments as $comment): ?>
									<tr>
										<td><?php echo $comment['date']; ?></td>
										<td><?php echo $comment['agent_name']; ?></td>
										<td><a href="javascript: void(0)" 
											   accesskey="" onclick="window.open('<?php echo site_url($this->config->item('admin_folder').'/customers/show_comment/'.$id.'/'.$comment['id']);?>', 
									   'windowname1','width=400, height=200');"><?php echo $comment['comment_title']; ?></a>
											</td>
						<td style="text-align: center; width: 50px;">
								<a class="glyphicon glyphicon-trash" onclick="return areyousure();" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/delete_comment/'.$id.'/'.$comment['id']);?>"><?php //echo lang('form_view')?></a>
								</td>
										</tr>
									<?php endforeach;?>
								<?php endif;?>
							</table>
						</div>
					</div>
				</div>
<?php endif; ?>







<style>

.CSSTableGenerator {
	margin:0px;padding:0px;
	width:100%;
	border:1px solid #ffffff;
	
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
	
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
	
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
	
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}
.CSSTableGenerator table{
    border-collapse: collapse;
        border-spacing: 0;
	width:100%;
	height:100%;
	margin:0px;padding:0px;
}

.CSSTableGenerator tr:last-child td:last-child {
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
}
.CSSTableGenerator table tr:first-child td:first-child {
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}
.CSSTableGenerator table tr:first-child td:last-child {
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
}.CSSTableGenerator tr:last-child td:first-child{
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
}
.CSSTableGenerator td{
	vertical-align:middle;
	
	background-color:#cccccc;

	border:1px solid #ffffff;
	border-width:0px 1px 1px 0px;
	text-align:left;
	padding:4px;
	font-size:10px;
	font-family:Helvetica;
	font-weight:normal;

}.CSSTableGenerator tr:last-child td{
	border-width:0px 1px 0px 0px;
}.CSSTableGenerator tr td:last-child{
	border-width:0px 0px 1px 0px;
}.CSSTableGenerator tr:last-child td:last-child{
	border-width:0px 0px 0px 0px;
}
.CSSTableGenerator tr:first-child td{
		background:-o-linear-gradient(bottom, #5f3789 5%, #5f3789 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #5f3789), color-stop(1, #5f3789) );
	background:-moz-linear-gradient( center top, #5f3789 5%, #5f3789 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#5f3789", endColorstr="#5f3789");	background: -o-linear-gradient(top,#5f3789,5f3789);

	background-color:#5f3789;
	border:0px solid #ffffff;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:12px;
	font-family:Helvetica;
	font-weight:bold;
	color:#ffffff;
}
.CSSTableGenerator tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #5f3789 5%, #5f3789 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #5f3789), color-stop(1, #5f3789) );
	background:-moz-linear-gradient( center top, #5f3789 5%, #5f3789 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#5f3789", endColorstr="#5f3789");	background: -o-linear-gradient(top,#5f3789,5f3789);

	background-color:#5f3789;
}
.CSSTableGenerator tr:first-child td:first-child{
	border-width:0px 0px 1px 0px;
}
.CSSTableGenerator tr:first-child td:last-child{
	border-width:0px 0px 1px 1px;
}
h6 {margin: 0px 0px 0px 4px;}
</style>

	<div class="panel panel-default" style="float: left; " id="customer_info">
	<!-- Default panel contents -->
		<div class="panel-heading">Customer Information<span id="stbar" class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
		</div>
		<div class="panel-body" id="customer_table" style="float: left;">

			<?php if(!empty($id)): ?>
				<?php if($current_shop !== 3): ?>

									<a class="btn btn-default btn-xs" style="margin-right: 3px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/products/'.$id);?>"><?php echo lang('product_overview_per_client'); ?></a>
									<a class="btn btn-default btn-xs" style="margin-right: 3px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/all_invoices/'.$customer_number);?>">View all invoices<?php //echo lang('product_overview_per_client'); ?></a>
									<a class="btn btn-default btn-xs" style="margin-right: 3px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/prices/'.$id);?>"><?php echo lang('price_list'); ?></a>
									<a class="btn btn-default btn-xs" style="margin-right: 3px;" href="<?php echo site_url($this->config->item('admin_folder').'/offer/all/'.$id);?>">View offers<?php //echo lang('new_offer'); ?></a>
									<a class="btn btn-default btn-xs" style="margin-right: 3px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/payments/'.$id);?>"><?php echo lang('late_payments'); ?></a>
									<a class="btn btn-default btn-xs" style="margin-right: 3px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/newCollectionContract/'.$id);?>"><?php echo lang('new_collection_contract'); ?></a>				
									<a class="btn btn-info btn-xs" style="margin-right: 3px;" href="<?php echo site_url($this->config->item('admin_folder').'/orders/start_order/'.$id);?>"> <?php echo lang('new_order'); ?></a>
									
								<br/><br/>

				<?php endif; ?>
			<?php endif; ?>



			<?php if($current_shop == 3): ?>
				<?php 
					echo 
					form_open(
						$this->config->item('admin_folder').'/customers/approve_customer/'.$id
					); 
				?>
						<table>
							<tr>
								<td>
								<?php $aproved_array  = array('0'	=> 'No','1'=> 'Yes');?> 
								<strong>Opdrachtgever is goedgekeurd</strong>
								<?php echo 
									form_dropdown(
											'aproved',
											$aproved_array,
											$aproved,
											'class="span2"'
									);
								?>
								</td>
							</tr>
						</table>
						<input 
							class="btn btn-primary btn-small" 
							type="submit" 
							value="verandering"
						/>

				</form>
			<?php endif; ?>
<hr/>


<?php echo form_open($this->config->item('admin_folder').'/customers/form/'.$id); ?>

		<table class="table">
				<tr>

						<?php
							$data	= array('name'=>'customer_info', 'value'=>set_value('customer_info', $customer_info), 'class'=>'redactor','style' => ' width: 99%; padding: 5px; margin: 5px 5px 3px 2px;', 'rows' => '1', 'placeholder' => lang('important_info'));
							echo form_textarea($data); 
						?>

				</tr>
		</table>



    <table class="table">

	        <tr>
            <td>Manage customers files</td>
			<td>
							<a class="btn btn-xs btn-info" style="float:left;" href="<?php 
								  echo 
								  site_url(
								  $this->config->item('admin_folder').'/customers/client_files/'.$id
								  );
								  ?>"
						>
							<?php echo lang('view_files')?>
						</a>
			</td>
	
	
        <tr>
            <td><label><?php echo lang('delivery_stop');?></label></td>
            <td><input type="checkbox" name="stop_delivery" value="1" <?php echo set_checkbox('mycheck', '1'); ?> /><br></td>
        </tr>
        <tr>
            <td><label><?php echo lang('was_deleted');?></label></td>
            <td><input type="checkbox" name="was_deleted" value="1" <?php echo set_checkbox('mycheck', '1'); ?> /></td>
        </tr>
        <tr>
			<?php 
			if(!empty($id)){
				?>
					<td><h6><?php echo lang('customer_number');?></h6></td>
					<td><?php echo $customer_number; ?></td>
				<?php
			}

			if(!empty($id)){
				?><input type="hidden" name="id" value="<?php  echo $id; ?>" ><?php
			}
			?>
			<?php 
			if(!empty($NR)){
				?><input type="hidden" name="NR" value="<?php  echo $NR; ?>" ><?php
			}
			?>
			<?php 
			if(!empty($customer_number)){
				?><input type="hidden" name="customer_number" value="<?php  echo $customer_number; ?>" ><?php
			}
			?>
        </tr>
        <tr>
            <td><h6><?php echo lang('company_name');?></h6></td>
            <td><?php $data	= array('name'=>'company', 'value'=>set_value('company', $company), 'style'=>'width: 40%; background: whitesmoke; '); echo form_input($data); ?></td>
        </tr>
	<?php if($current_shop == 3): ?>
        <tr>
            <td><h6><?php echo lang('gender');?></h6></td>
            <td>
                <label for="Mrs">Mrs.</label>
                <?php echo form_radio($gender_female);?>
                <label for="Mr">Mr.</label>
		<?php echo form_radio($gender_male);?>
            </td>
        </tr>
	<?php endif; ?>
	<tr>
            <td><h6><?php echo lang('firstname');?></h6></td>
            <td><?php $data	= array('name'=>'firstname', 'value'=>set_value('firstname', $firstname), 'style'=>'width: 40%; background: whitesmoke;'); echo form_input($data); ?></td>
        </tr>
        <tr>
            <td><h6><?php echo lang('lastname');?></h6></td>
            <td><?php $data	= array('name'=>'lastname', 'value'=>set_value('lastname', $lastname), 'style'=>'width: 40%; background: whitesmoke;'); echo form_input($data); ?></td>
        </tr>
        <tr>
            <td><h6><?php echo lang('phone');?></h6></td>
            <td><?php $data	= array('name'=>'phone', 'value'=>set_value('phone', $phone), 'style'=>'width: 40%; background: whitesmoke;'); echo form_input($data); ?></td>
        </tr>
        <tr>
            <td><h6><?php echo lang('fax');?></h6></td>
            <td><?php $data	= array('name'=>'fax', 'value'=>set_value('fax', $fax_1), 'style'=>'width: 40%; background: whitesmoke;'); echo form_input($data); ?></td>
        </tr>
        <tr>
            <td><h6><?php echo lang('email');?></h6></td>
            <td><?php $data	= array('name'=>'email', 'value'=>set_value('email', $email_1), 'style'=>'width: 40%; background: whitesmoke;'); echo form_input($data); ?></td>
        </tr>
        <tr>
            <td><h6>Invoice e-mail<?php //echo lang('email');?></h6></td>
            <td><?php $data	= array('name'=>'invoice_email', 'value'=>set_value('invoice_email', $invoice_email), 'style'=>'width: 40%; background: whitesmoke;'); echo form_input($data); ?></td>
        </tr>
        <tr>
            <td><h6><?php echo lang('website');?></h6></td>
            <td><?php $data	= array('name'=>'website', 'value'=>set_value('website', $website), 'style'=>'width: 40%; background: whitesmoke;'); echo form_input($data); ?></td>
        </tr>       
        <tr>
            <td><h6><?php echo lang('industry');?></h6></td>
            <td><?php echo form_dropdown('industry',$industry_array,$industry); ?></td>
        </tr>   
        <tr>
            <td>
                <h6>
                <?php 
                    if($current_shop == 3 ){ 
                        echo 'Dropship klant' ;
                    }
                    else {
                        echo lang('group'); 
                    } 
                ?>
                </h6>
            </td>
            <td><?php echo form_dropdown('group',$group_array,$group_id); ?></td>
        </tr>
        <tr>
            <td><h6><?php echo lang('main_company');?></h6></td>
            <td><?php $data	= array('name'=>'main_company', 'value'=>set_value('main_company', $phone), 'style'=>'width: 40%; background: whitesmoke;'); echo form_input($data); ?></td>
        </tr>
        <tr>
            <td><h6><?php echo lang('number_residents');?></h6></td>
            <td> <?php $data	= array('name'=>'number_residents', 'value'=>set_value('number_residents', $number_residents), 'style'=>'width: 40%; background: whitesmoke;'); echo form_input($data); ?></td>
        </tr>        
        <tr>
            <td><h6><?php echo lang('manager');?></h6></td>
            <td>
                <?php if($manager == 0): ?>
                    <?php echo form_checkbox('manager', 'accept', true); ?>
                    &nbsp;
                    <?php echo lang('salesmanager');?>
                    <?php echo form_checkbox('manager', 'accept', false); ?>
                    &nbsp;
                    <?php echo lang('Ronald_and_Ralf');?>
                <?php else: ?>
                    <?php echo form_checkbox('manager', 'accept', false); ?>
                    &nbsp;
                    <?php echo lang('salesmanager');?>
                    <?php echo form_checkbox('manager', 'accept', true); ?>
                    &nbsp;
                    <?php echo lang('Ronald_and_Ralf');?>
                <?php endif; ?>                    
            </td>         
        </tr>
        <tr>
            <td><h6><?php echo lang('office_staff');?></h6></td>
            <td>
                <?php if($id && $can_delete_customers): ?>
                    <!-- show select -->
                    <?php if($current_shop == 3): ?>
                        <?php echo form_dropdown('office_staff',$Binnendienst,$office_staff) ?>
                    <?php else: ?>
			<?php echo form_dropdown('office_staff',$staff_array,$office_staff); ?>
                    <?php endif; ?>
                <?php elseif($id && !$can_delete_customers): ?>
                    <!-- show hidden and not editable name -->
                    <?php echo form_hidden('office_staff', $office_staff) ?>
                    <?php 
                        /* calculate staff name */
                        if($current_shop == 3)
                        {
                            $stuff_name =
                                isset($Binnendienst[$office_staff])
                                ? $Binnendienst[$office_staff]
                                : $ba_fullname
                            ;
                        }
                        else 
                        {
                            $stuff_name =
                                isset($staff_array[$office_staff])
                                ? $staff_array[$office_staff]
                                : $ba_fullname
                            ;
                        }
                    ?>
                    <?php echo $stuff_name ?>
                <?php else: ?>
                    <!-- show hidden and not editable name current user -->
                    <?php echo form_hidden('office_staff', $ba_login) ?>
                    <?php echo $ba_fullname ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td><h6><?php echo lang('field_service');?></h6></td>
            <td>
                <?php if($id && $can_delete_customers): ?>
                    <!-- show select -->
                    <?php if($current_shop == 3): ?>
                        <?php echo form_dropdown('field_service',$Buitendienst,$field_service) ?>
                    <?php else: ?>
			<?php echo form_dropdown('field_service',$staff_array,$field_service); ?>
                    <?php endif; ?>
                <?php elseif($id && !$can_delete_customers): ?>
                    <!-- show hidden and not editable name -->
                    <?php echo form_hidden('field_service', $field_service) ?>
                    <?php 
                        /* claculate staff name */
                        if($current_shop == 3)
                        {
                            $stuff_name =
                                isset($Binnendienst[$field_service])
                                ? $Binnendienst[$field_service]
                                : $ba_fullname
                            ;
                        }
                        else 
                        {
                            $stuff_name =
                                isset($staff_array[$field_service])
                                ? $staff_array[$field_service]
                                : $ba_fullname
                            ;
                        }
                    ?>
                    <?php echo $stuff_name ?>
                <?php else: ?>
                    <!-- show hidden and not editable name current user -->
                    <?php echo form_hidden('field_service', $ba_login) ?>
                    <?php echo $ba_fullname ?>
                <?php endif; ?>
            </td>
        </tr>
                 <hr/>
                <tr>
                     <td><h6><?php echo lang('email_username');?></h6></td>
                     <td>
					 <?php 

							?><input type="text" name="email__" value="<?php echo $email_1; ?>" style="width: 40%; background: whitesmoke;"/><?php
						
					  ?>
					  </td>
                 </tr>
                <tr>
                     <td><h6><?php echo lang('password');?></h6></td>
					 					<td> <?php 
						if(!empty($password_text)){
						?><input type="text" name="password" value="<?php echo $password_text; ?>" style="width: 40%" /><?php
						}
						else {
							?><input type="text" name="password" value="" style="width: 40%; background: whitesmoke;" /><?php
						}
					  ?></td>

                 </tr>                 
                <tr>
                     <td><h6><?php echo lang('country_language');?></h6></td>
					<td>
						<?php 
						if(!empty($land)){

							echo form_dropdown('country_id',$country_array,$land); 
						}else {
						?>
							<select name="country_id"  required >
								<option value="">Select country</option>
								<option value="BEL">Belgique / français</option>
								<option value="BE">België / nederlands</option>
								<option value="DE">Deutschland / deutsch</option>
								<option value="FR">France / français</option>
								<option value="LX">Luxembourg / français</option>
								<option value="NL">Nederland / nederlands</option>
								<option value="UK">United Kingdom / english</option>
								<option value="AU">Österreich / deutsch</option>
							</select>						
						<?php
						}
						

						
						?>
					</td>	
                 </tr>                 
                <tr>
                     <td><h6><?php echo lang('invoice_after_delivery');?></h6></td>
                     <td><?php $data = array('name'=>'invoice_after_delivery', 'value' => lang('invoice_after_delivery'),  'checked' => TRUE,); echo form_checkbox($data); ?></td>
                 </tr>                 
                <tr>
                     <td><h6><?php echo lang('payment_by_direct_debit');?></h6></td>
                     <td><?php $data = array('name'=>'payment_by_direct_debit', 'value' => lang('payment_by_direct_debit'),  'checked' => TRUE,); echo form_checkbox($data); ?></td>
                 </tr>



                <tr>
                     <td><h6><?php echo lang('account_number');?></h6></td>
                     <td><?php $data = array('name'=>'account_number', 'value'=>set_value('account_number', $account_number), 'style'=>'width:40%; background: whitesmoke;'); echo form_input($data); ?></td>
                 </tr>     
			 
                <tr>
                     <td><h6><?php echo lang('account_owner');?></h6></td>
                     <td><?php $data = array('name'=>'account_owner', 'value'=>set_value('account_owner', $account_owner), 'style'=>'width:40%; background: whitesmoke;'); echo form_input($data); ?></td>
                 </tr>                 
                <tr>
                     <td><h6><?php echo lang('bank_number');?></h6></td>
                     <td><?php $data = array('name'=>'bank_number', 'value'=>set_value('bank_number', $bank_number), 'style'=>'width:40%; background: whitesmoke;'); echo form_input($data); ?></td>
                 </tr>                 
                <tr>
                     <td><h6><?php echo lang('bank_name');?></h6></td>
                     <td><?php $data	= array('name'=>'bank_name', 'value'=>set_value('bank_name', $bank_name), 'style'=>'width:40%; background: whitesmoke;'); echo form_input($data); ?></td>
                 </tr>                 
                <tr>
                     <td><h6><?php echo lang('IBAN');?></h6></td>
                     <td><?php $data = array('name'=>'iban', 'value'=>set_value('iban', $IBAN), 'style'=>'width:40%; background: whitesmoke;'); echo form_input($data); ?></td>
                 </tr>                 
                <tr>
                     <td><h6><?php echo lang('BIC');?></h6></td>
                     <td><?php $data = array('name'=>'bic', 'value'=>set_value('bic', $BIC), 'style'=>'width:40%; background: whitesmoke;'); echo form_input($data); ?></td>
                 </tr>                 
                <tr>
                     <td><h6><?php echo lang('sortcode');?></h6></td>
                     <td><?php $data	= array('name'=>'sortcode', 'value'=>set_value('sortcode', $sortcode), 'style'=>'width:40%; background: whitesmoke;'); echo form_input($data); ?></td>
                 </tr>                        
                <tr>
                     <td><h6><?php echo lang('sepa_id');?></h6></td>
                     <td><?php $data	= array('name'=>'sepa_id', 'value'=>set_value('sepa_id', $sepa_id), 'style'=>'width:40%; background: whitesmoke;'); echo form_input($data); ?></td>
                 </tr>                        
                <tr>
                     <td><h6><?php echo lang('sepa_sig_date');?></h6></td>
                     <td><?php $data	= array('name'=>'sepa_sig_date', 'value'=>set_value('sepa_signature_date', $sepa_signature_date), 'style'=>'width:40%; background: whitesmoke;'); echo form_input($data); ?></td>
                 </tr>    
                <tr>
                     <td>
                         <h6>
                            <?php 
                                if($current_shop == 1){
                                    echo 'Comforties.nl'.' '.lang('account');
                                }
                                if($current_shop == 2){
                                    echo 'dutchblue.com'.' '.lang('account');
                                }
                                if($current_shop == 3){
                                    echo 'Glovers'.' '.lang('account');
                                }
                            ?>
                         </h6>
                     </td>
                     <td>
                         <?php 
                         if($shop_account == 0){
                             echo form_checkbox('shop_account', 'accept', false);
                         }
                         else {
                              echo form_checkbox('shop_account', 'accept', true);
                         }
                            
                        ?>
                     </td>
                 </tr>    
                <tr>
                    <td>
                         <h6>
                            <?php 
                                if($current_shop == 1){
                                    echo 'Contribution Comforties.nl'.' '.lang('account');
                                }
                                if($current_shop == 2){
                                    echo 'Contribution dutchblue.com'.' '.lang('account');
                                }
                                if($current_shop == 3){
                                    echo 'Inleg glovers account';
                                }
                            ?>
                         </h6>
                     </td>
                     <td><?php $data	= array('name'=>'contribution_nl_account', 'value'=> format_currency($contribution_nl_account), 'style'=>'width:40%; background: whitesmoke;'); echo form_input($data); ?>
                     <?php echo lang('date_contribution'); ?><?php $data	= array('name'=>'date_contribution', 'value'=>$date_contribution , 'style'=>'background: whitesmoke;'); echo form_input($data); ?></td>
                 </tr>                        
                 <tr>
                    <td>
                         <h6>
                            <?php 
                                if($current_shop == 1){
                                    echo 'Transfer  Comforties.nl'.' '.lang('account');
                                }
                                if($current_shop == 2){
                                    echo 'Transfer  dutchblue.com'.' '.lang('account');
                                }
                                if($current_shop == 3){
                                    echo 'Afboekingen glovers account';
                                }
                            ?>
                         </h6>
                     </td>
                     <td><?php $data	= array('name'=>'transfer_nl_account', 'value'=>$transfer_nl_account, 'style'=>'width:40%; background: whitesmoke;'); echo form_input($data); ?></td>
                 </tr>
                 <tr>
                     <td><h6><?php echo lang('standard_payment_method');?></h6></td>
                     <td><?php
                        if(empty($standard_payment_method)){
                            echo form_dropdown('standard_payment_method',$standard_payment_method_array,'1'); 
                        }
                        else {
                            echo form_dropdown('standard_payment_method',$standard_payment_method_array,$standard_payment_method);   
                        }
                     ?></td>
                 </tr>
                 <tr>
                     <td><h6><?php echo lang('payment_condition');?></h6></td>
                     <td><?php echo form_dropdown('payment_condition',$payment_condition_array,$payment_condition); ?></td>
                 </tr>
                <tr>
                     <td><h6><?php echo lang('not_remind');?></h6></td>
                     
                     <td><?php 
                     if(empty($not_remind)){
                         echo form_checkbox('not_remind', 'accept', false);
                     }
                     else {
                         echo form_checkbox('not_remind', 'accept', true);
                     }
                     ?></td>
                 </tr>
                <tr>
                     <td><h6><?php echo lang('monthly_invoice');?></h6></td>
                     <td><?php 
                     if(empty($monthly_invoice)){
                         echo form_checkbox('monthly_invoice', 'accept', false);
                     }
                     else {
                         echo form_checkbox('monthly_invoice', 'accept', true);
                     }
                     ?></td>
                 </tr>
				<?php  if($current_shop !== 3): ?>
                <tr>
                     <td><h6><?php echo lang('none_VAT');?></h6></td>
                    <td><?php 
					
                     if(empty($none_VAT)){
                         echo form_checkbox('none_VAT', 'accept', false);
                     }
                     else {
                         echo form_checkbox('none_VAT', 'accept', true);
                     }
                     ?></td>
                 </tr>
				<?php endif; ?>				 
                <tr>
                     <td><h6><?php echo lang('ICL_VAT');?></h6></td>
                     <td><?php $data = array('name'=>'ICL_VAT_number', 'value'=>$ICL_VAT_number, 'style'=>'width:40%; background: whitesmoke;'); echo form_input($data); ?></td>
                 </tr>
                 <tr>
                     <td><h6><?php echo lang('no_mailings');?></h6></td>
                    <td><?php 
                     if(empty($no_post)){
                         echo form_checkbox('no_post', 'accept', false);
                     }
                     else {
                         echo form_checkbox('no_post', 'accept', true);
                     }
                     ?></td>
                 </tr>
				<tr>
                     <td><h6><?php echo lang('no_mailings');?></h6></td>
                    <td><?php 
                     if(empty($no_post)){
                         echo form_checkbox('no_post', 'accept', false);
                     }
                     else {
                         echo form_checkbox('no_post', 'accept', true);
                     }
                     ?></td>
                 </tr>
                 <tr>
                     <td><h6><?php echo lang('active');?></h6></td>
                     <td><?php $data	= array('name'=>'active', 'value'=>1, 'checked'=>$active); echo form_checkbox($data); ?></td>
                 </tr>
				 <?php  if($current_shop !== 3): ?>
                 <tr>
                     <td><h6><?php echo lang('group');?></h6></td>
                     <td><?php echo form_dropdown('group_id', $group_list, set_value('group_id',$group_id)); ?></td>
                 </tr>
				 <?php endif; ?>	

	</table>		


		

                <?php 
                if(empty($company)){
                    ?><br/><input class="btn btn-info" type="submit" value="<?php echo lang('save');?>"/><?php
                }
                else {
                    ?><br/><input class="btn btn-info" type="submit" value="<?php echo lang('bulk_save');?>"/><?php
                }
                ?>
</form>

		</div>
			
	</div>
				
		<div class="panel panel-default" style="float: left; " id="customer_info">
			<div class="panel-heading">Addresses<span id="stbar" class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
				<div class="panel-body" id="customer_table" style="float: left;">
							<table class="table table-striped">
									<tr>
										<td style="text-align:center; text-transform: uppercase;"><h5><?php echo lang('invoice_address');?></h5></td>
										<td style="text-align:center; text-transform: uppercase;"><h5><?php echo lang('delivery_address');?></h5></td>
									</tr>
									<tr>
										<td style="padding:5px;">
											<?php if(!empty($invoice_address)): ?>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('company'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['NAAM1']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('firstname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['NAAM2']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('lastname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['NAAM3']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;">Street<?php //echo lang('street'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['STRAAT']; ?>">&nbsp;<input type="text"  style="width: 100px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['HUISNR']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;">Postcode<?php //echo lang('zip'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['POSTCODE']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('city'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['PLAATS']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('country'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['LAND']; ?>"><br><br>
											<?php endif; ?>	
										</td>
										<td style="padding:5px;">
											<?php if(!empty($delivery_address)): ?>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('company'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM1']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('firstname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM2']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('lastname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM3']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;">Street<?php //echo lang('street'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['STRAAT']; ?>">&nbsp;<input type="text"  style="width: 100px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['HUISNR']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;">Postcode<?php //echo lang('zip'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['POSTCODE']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('city'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['PLAATS']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('country'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['LAND']; ?>"><br><br>
											<?php endif; ?>	
										</td>
										<?php if($this->data_shop == 3): ?>
											<?php if(!empty($drop_shipment_address)): ?>
												<td style="padding:5px;">
														<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('company'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM1']; ?>"><br>
														<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('firstname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM2']; ?>"><br>
														<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('lastname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM3']; ?>"><br>
														<label style="font-family: 'Inconsolata'; font-size: 18px;">Street<?php //echo lang('street'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['STRAAT']; ?>">&nbsp;<input type="text"  style="width: 100px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['HUISNR']; ?>"><br>
														<label style="font-family: 'Inconsolata'; font-size: 18px;">Postcode<?php //echo lang('zip'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['POSTCODE']; ?>"><br>
														<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('city'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['PLAATS']; ?>"><br>
														<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('country'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['LAND']; ?>"><br><br>
												</td>
										<?php endif; ?>
											<?php endif; ?>
									</tr>
									<tr>
										<td style="padding:5px;">
										<?php if(isset($NR)): ?>
											<a class="btn btn-info btn-sm" href="<?php echo site_url($this->config->item('admin_folder').'/customers/addresses/'.$NR); ?>">Edit addresses<?php //echo lang('change_address');?></a>
										<?php endif; ?>	
										</td>
									</tr>
							</table>
						</div>
				</div>	
				


		
	<div id="rightsidebar">

		<!--span id="rightsidebarhide" class="expand pull-left" style="margin-bottom: 2px;" >Hide the Add Panel<span class="expand glyphicon glyphicon-arrow-down pull-left" style="color: #c9c9c9; margin: 2px;"></span></span>
		<span id="rightsidebarshow" class="expand pull-left" style="margin-bottom: 2px; white-space: normal !important;" >Show the Add Panel<span class="expand glyphicon glyphicon-arrow-up pull-left" style="color: #c9c9c9; margin: 2px;"></span></span-->
		
		<div id="heyti1" class="panel panel-default" style="width: 100%; float: left;">
		    <!-- Default panel contents -->
		    <div class="panel-heading">Overviews<span id="heyti" class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
		    <div class="panel-body">	
		  
				<ul class="leftblock_content" style="font-size: 12px;">
		<li>
		<?php if(!empty($NR)): ?>
                    <a class="btn btn-default btn-xs" style="width:100%; margin-bottom:10px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/todo/'.$NR); ?>">
                        Add ToDo
                    </a>
		<?php endif; ?>			
                </li>
		<?php if(!empty($todo)): ?>
                    <?php foreach($todo as $action): ?>
			<li>
                            <a href="<?php echo site_url($this->config->item('admin_folder').'/customers/todo/'.$NR.'/'.$action['NR']); ?>">
                                <?php echo $action['UITVOEROP'].' '.$action['UITVOEROPT'].' , '.$why[$action['SOORT']].' , '.$action['EIGENNAAM']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
		<?php endif; ?>
		<br>
		<!------------------------------------------------------------->
		<li>
		<?php if(!empty($NR)): ?>
                    <a class="btn btn-default btn-xs" style="width:100%; margin-bottom:10px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/contact/'.$NR); ?>">
                            Add Contact
                    </a>
		<?php endif; ?>				
                </li>
		<?php if(!empty($contacts)): ?>
                    <?php foreach($contacts as $contact): ?>
                        <li>
                        <?php if($contact['SOORT'] != 0): ?>
                            <a href="<?php echo site_url($this->config->item('admin_folder').'/customers/contact/'.$NR.'/'.$contact['NR']); ?>">
                                <?php echo $contact['DATUM'].' , '.$why[$contact['SOORT']].' , '.$contact['EIGENNAAM'].' , '.$contact['ANDERENAAM']; ?>
                            </a>
                         <?php else : ?>   
                            <a href="<?php echo site_url($this->config->item('admin_folder').'/customers/contact/'.$NR.'/'.$contact['NR']); ?>">
                                <?php echo $contact['DATUM'].' , '.$why[0].' , '.$contact['EIGENNAAM'].' , '.$contact['ANDERENAAM']; ?>
                            </a>
                        <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
		<?php endif; ?>
		
		<!----------------------------------------------------- -->
                <li>
				<?php if(!empty($NR)): ?>
                    <a class="btn btn-default btn-xs" style="width:100%; margin:10px 0px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/contact_person/'.$NR); ?>">
                            Add Contact Person
                    </a>
				<?php endif; ?>		
                </li>
		<?php if(!empty($contact_persons)): ?>
		<?php foreach($contact_persons as $contact_person): ?>
		<li>
		<?php if(!empty($NR)): ?>
                    <a href="<?php echo site_url($this->config->item('admin_folder').'/customers/contact_person/'.$NR.'/'.$contact_person['NR']); ?>">
                        <?php echo $contact_person['ACHTERNAAM'].' , '.$contact_person['VOORNAAM']; ?>
                    </a>
		<?php endif; ?>			
		</li>
		<?php endforeach; ?>
		<?php endif; ?>
            </ul>
		  
		    </div>
		</div>
	</div>
		  


   <!-- <script type="text/javascript" src="/twitter-bootstrap/twitter-bootstrap-v2/docs/assets/js/jquery.js"></script>  
    <script type="text/javascript" src="/twitter-bootstrap/twitter-bootstrap-v2/docs/assets/js/bootstrap-collapse.js"></script> -->



<?php include('footer.php'); ?>


<style>
#rightsidebar li {
color: #333;
margin: 5px 0px;
list-style: none;
}

#view { padding-right: 0px !important;}

#customer_info {
	width: 80%;
}

#rightsidebar {
	position: absolute;
	overflow:auto;

}

@media (min-width:1200px) {
	
	
	#rightsidebar {
	top: 60px;
	right: 0px;
	bottom: auto;
	opacity:1;
	position: absolute;
	background-color: #fff;
	margin-bottom: 0px;
	border: 3px solid #c9c9c9; 
	border-width: 3px 0 3px 3px;
	width: 15.5%;
	
}

#heyti1 {
	width: 100%;
	display: block;
}

#customer_info {
	width: 80%;
}
}

@media (max-width:1199px) {

#rightsidebar {
	top: auto;
	z-index: 1000;
	bottom: 0px;
	right: 0px;
	/*background-color: #6F5499;*/
	margin-bottom: 0px;
	border: 3px solid #c9c9c9;
	padding:0px;
	max-height:600px;
	overflow: auto;
	position: fixed;
}

#heyti1 { margin-bottom:0px;}

#rightsidebar:hover {
	opacity: 1;
}

#rightsidebar:hover span {
	color: #cacaca;
}

#rightsidebar .panel-body {
	display:none;
}


#customer_info {
	width: 100%;
}

#heyti1 {
	width: 100%;
}

}

</style>

 <script type="text/javascript">
$(function() {
$( "#accordion" ).accordion({ heightStyle: "content", event: "click" });

});
</script>















