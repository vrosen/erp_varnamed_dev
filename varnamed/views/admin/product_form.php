
<?php
include('header.php');
$GLOBALS['option_value_count'] = 0;
?>
<link href='http://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>
<script type="text/javascript">
    function areyousure()
    {
        return confirm('<?php echo lang('confirm_delete_product_group'); ?>');
    }

//<![CDATA[

    $(document).ready(function() {
        $(".sortable").sortable();
        $(".sortable > span").disableSelection();
        //if the image already exists (phpcheck) enable the selector

<?php if ($id) : ?>
            //options related
            var ct = $('#option_list').children().size();
            // set initial count
            option_count = <?php echo count($product_options); ?>;
<?php endif; ?>

        photos_sortable();
    });

    function add_product_image(data)
    {
        p = data.split('.');

        var photo = '<?php add_image("'+p[0]+'", "'+p[0]+'.'+p[1]+'", '', '', '', base_url('uploads/images/thumbnails')); ?>';
        $('#gc_photos').append(photo);
        $('#gc_photos').sortable('destroy');
        photos_sortable();
    }

    function remove_image(img)
    {
        if (confirm('<?php echo lang('confirm_remove_image'); ?>'))
        {
            var id = img.attr('rel')
            $('#gc_photo_' + id).remove();
        }
    }

    function photos_sortable()
    {
        $('#gc_photos').sortable({
            handle: '.gc_thumbnail',
            items: '.gc_photo',
            axis: 'y',
            scroll: true
        });
    }

    function remove_option(id)
    {
        if (confirm('<?php echo lang('confirm_remove_option'); ?>'))
        {
            $('#option-' + id).remove();
        }
    }

//]]>
</script>

<?php

	if(!empty($error)){
		echo $error;
	}
?>
<?php echo form_open($this->config->item('admin_folder') . '/products/form/'.$id); ?>

<div class="panel panel-default" style="width: 100%; float: left;">
    <div class="panel-heading">Product <?php echo str_replace('/', '', $code); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
    <div class="panel-body">

        <!--********MENU START******************************************************************************************************************************************************************-->
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active" style="font-family: 'Raleway', sans-serif;"><a href="#general" data-toggle="tab"><?php echo lang('general');  ?></a></li>
                <li style="font-family: 'Raleway', sans-serif;"><a href="#supplier" data-toggle="tab"><?php echo lang('supplier');  ?></a></li>
                <li style="font-family: 'Raleway', sans-serif;"><a href="#prices" data-toggle="tab"><?php echo lang('prices');  ?></a></li>
                <li style="font-family: 'Raleway', sans-serif;"><a href="#stock" data-toggle="tab"><?php echo lang('stock_');  ?></a></li>
                <li style="font-family: 'Raleway', sans-serif;"><a href="#features" data-toggle="tab"><?php echo lang('features');  ?></a></li>
                <li style="font-family: 'Raleway', sans-serif;"><a href="#product_photos" data-toggle="tab"><?php echo lang('pictures');  ?></a></li>
            </ul>
        </div>
        <!--******** MENU END******************************************************************************************************************************************************************-->

        <div class="tab-content">

            <!--******** GENERAL START ******************************************************************************************************************************************************************-->
            <div class="tab-pane active" id="general">
                <br><br>
                <div style="padding: 5px;">
                    <div class="col-md-12 table-responsive" >
                        <table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;float:left;">
                            <tbody>
                                <tr>
                                    <td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 10%;">
                                        <label for="code"><?php echo lang('code'); ?></label>
									</td>	
									<td style="width: 20%;">	
                                        <?php
                                        $data = array('name' => 'code', 'value' => set_value('code', str_replace('/','',$code)), 'class'=>'form-control' ,'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 98%; ');
                                        echo form_input($data);
                                        ?>
                                    </td>
                                </tr>	

                                <tr>
                                    <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                        <?php echo lang('name_nl');  ?>
									</td>	
									<td>		
                                        <?php
                                        $data = array('name' => 'name_NL', 'value' => set_value('name_NL', $name_NL), 'class'=>'form-control' ,'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 98%; ');
                                        echo form_input($data);
                                        ?>
                                    </td>
                                </tr>														
                                <tr>
                                    <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                        <?php echo lang('name_be');  ?>
									</td>	
									<td>		
                                        <?php
                                        $data = array('name' => 'name_BE', 'value' => set_value('name_BE', $name_BE), 'class'=>'form-control' ,'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 98%; ');
                                        echo form_input($data);
                                        ?>
                                    </td>
                                </tr>														
                                <tr>
                                    <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                        <?php echo lang('name_bel');  ?>
									</td>	
									<td>		
                                        <?php
                                        $data = array('name' => 'name_BEL', 'value' => set_value('name_BEL', $name_BEL), 'class'=>'form-control' ,'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 98%; ');
                                        echo form_input($data);
                                        ?>
                                    </td>
                                </tr>														
                                <tr>
                                    <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                        <?php echo lang('name_fr');  ?>
									</td>	
									<td>		
                                        <?php
                                        $data = array('name' => 'name_FR', 'value' => set_value('name_FR', $name_FR), 'class'=>'form-control' ,'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 98%; ');
                                        echo form_input($data);
                                        ?>
                                    </td>
                                </tr>														
                                <tr>
                                    <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                        <?php echo lang('name_de');  ?>
									</td>	
									<td>		
                                        <?php
                                        $data = array('name' => 'name_DE', 'value' => set_value('name_DE', $name_DE), 'class'=>'form-control' ,'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 98%; ');
                                        echo form_input($data);
                                        ?>
                                    </td>
                                </tr>														
                                <tr>
                                    <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                        <?php echo lang('name_at');  ?>
									</td>	
									<td>		
                                        <?php
                                        $data = array('name' => 'name_AU', 'value' => set_value('name_AU', $name_AU), 'class'=>'form-control' ,'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 98%; ');
                                        echo form_input($data);
                                        ?>
                                    </td>
                                </tr>														
                                <tr>
                                    <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                        <?php echo lang('name_lx');  ?>
									</td>	
									<td>		
                                        <?php
                                        $data = array('name' => 'name_LX', 'value' => set_value('name_LX', $name_LX), 'class'=>'form-control' ,'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 98%; ');
                                        echo form_input($data);
                                        ?>
                                    </td>
                                </tr>														
                                <tr>
                                    <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                        <?php echo lang('name_uk');  ?>
									</td>	
									<td>			
                                        <?php
                                        $data = array('name' => 'name_UK', 'value' => set_value('name_UK', $name_UK), 'class'=>'form-control' ,'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 98%; ');
                                        echo form_input($data);
                                        ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
						

							<?php //if($complexType == 'complex'): ?>
								<table class="table table-striped" id="test" style="padding: 5px; width: 40%; margin-bottom:15px; margin-left:15px; float:left; display:none; ">
									<tr>
										<td colspan='3'>
											<label><?php echo lang('components'); ?></label>
										</td>
									</tr>
									<?php if(isset($parts) && !empty($parts)): ?>
									<?php foreach($parts as $p): ?>
									<tr>
										<td><?php echo $p['name'] ?></td>
										<td><?php echo $p['code'] ?></td>
										<td><a class="glyphicon glyphicon-trash fakecl3" delId="<?php echo $p['part_id'] ?>"></a></td>
									</tr>
									<?php endforeach; ?>
									<?php endif; ?>
									<tr>
										<td>
											<label for='addPart'><?php echo lang('add_new_component_code'); ?></label>
										</td>
										<td>
											<input baseId='<?php echo $id ?>' type='text' id='addPart' name='addPart' class="form-control" />
										</td>
										<td>
											<button type="button" id='addPartButton' class="btn btn-info"><?php echo lang('add'); ?></button>
										</td>
									</tr>
								</table>
							<?php //endif; ?>

						<script>
							function check_dd() {
								if(document.getElementById('complexType').value == "stand alone") {
									document.getElementById('test').style.display = 'none';
								} else {
									document.getElementById('test').style.display = 'block';
								}
							}
							
							function check_cc(c) {
							
							var cat = c;
							
						
							$.ajax({
									url: qqurl+"admin/products/populate_groups",
									dataType: "json",
									type: "POST",
									data: {
										name: cat,
									}, 
										success: function (data) {
											
											n = data.length;

												var newOptions =	data;

												var $el = $("#SelectedGroups");
												$el.empty(); // remove old options
												$.each(newOptions, function(key, value) {
												  $el.append($("<option></option>")
													 .attr("value", value.group_id).text(value.group_name));
												});
										}	
									});
								
								
								if(document.getElementById('category').value == "") {
									document.getElementById('gg').style.display = 'none';
								} else {
									document.getElementById('gg').style.display = 'block';
								}
							}
						</script>
						
						
			
						
						<div style="clear:both"></div>                    
                       
                        <table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
                            <fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('description');  ?></legend></fieldset>
                            <?php
                            $data = array('name' => 'description', 'class' => 'redactor', 'value' => set_value('description', $description));
                            echo form_textarea($data);
                            ?>
                        </table>	
					   
					   
					   
					   
					   
					   
						<div class="table table-striped" style="padding: 5px;  width: 50%;  margin-bottom:15px;">
                            <fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('complex');  ?></legend></fieldset>
								<?php
										$j_ch = 'id="complexType" class = "form-control" onChange="check_dd();"';
											
                                        $complexOptions = array(
                                            'stand alone' 			=> lang('stand_alone'),
                                            'complex' 				=> lang('complex'),
                                            'part' 					=> lang('part'),
                                            'part and stand aloone' => lang('part_and_stand_alone'),
                                        );
                                        echo form_dropdown('complexType', $complexOptions, $complexType, $j_ch);
                                        ?>
						</div>			


                        


                        <div class="table table-striped" style="padding: 5px;  width: 50%;  margin-bottom:15px;">
                            <legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('product_category');  ?></legend>
									<?php if(!empty($all_categories)): ?>
										<?php $js = 'id="category" class="form-control" style="margin-bottom: 5px;" onChange="check_cc($(this).val());"'; ?>
										<?php echo form_dropdown('category',$all_categories,$cat_id,$js); ?>
									<?php endif; ?>
                        </div>

                        <br>
					<?php if(empty($grp_id)): ?>
                        <div class="table table-striped" id="gg" style="padding: 5px;  width: 50%;  margin-bottom:15px;  display:none; ">
                            <legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('product_group');  ?></legend>
                            <tbody>
										<select id="SelectedGroups" name="group" class="form-control">
										</select>
                            </tbody>
                        </div>
					
					<?php endif; ?>	
					
                        <div class="table table-striped" id="gg" style="padding: 5px;  width: 50%;  margin-bottom:15px;">
                            <legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('product_group');  ?></legend>
                            <tbody>
						
											<?php if(!empty($grp_id)): ?>
												<?php echo form_dropdown('group',$all_groupos,$grp_id,'class="form-control"'); ?>
											<?php endif; ?>	
							
                            </tbody>
                        </div>
                        
                        <br><br>




                    </div>
                </div>
            </div>	
            <!--********GENERAL END ******************************************************************************************************************************************************************-->
            <br><br> 

            <!--********SUPPLIER START ******************************************************************************************************************************************************************-->	
            <?php $ar_d = array(0 => 'Select', 1 => 'Einkaufsverpackung', 2 => '">####', 3 => '#### 2)', 4 => 'Number'); ?>

            <div class="tab-pane" id="supplier">
                <div style="padding: 5px;">
                    <div class="col-md-12 table-responsive" >
             


                            <?php foreach ($suppliers as $supplier): ?>
								<?php if(!empty($supplier)): ?>
									<?php if($supplier['DELRECORD'] == 1): ?>

									
									 <table class="table table-striped" style="padding: 5px; width: 70%; margin-bottom:15px;">
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 40%">
												<?php echo lang('company'); ?>
											</td>
											<td>
												<input type="text" name="" value="<?php echo @$suppliers_name[$supplier['LEVERANCIE']]; ?>" class="form-control" style="width: 99.5%;" disabled/>
											</td>
										</tr>										
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('minimum_order'); ?>
											</td>
											<td>
												<input type="text" name="" value="<?php echo $supplier['NMINAANTAL']; ?>" class="form-control" style="width: 99.5%;" disabled/>
											</td>
										</tr>										
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('delivery_time'); ?>
											</td>
											<td>
												<input type="text" name="" value="<?php echo $supplier['LEVERTIJD']; ?>" class="form-control" style="width: 99.5%;" disabled/>
											</td>
										</tr>										
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('purchase_price'); ?>
											</td>
											<td>
												<input type="text" name="" value="<?php echo $supplier['INKOOPPRIJ']; ?>" class="form-control" style="width: 99.5%;" disabled/>
											</td>
										</tr>
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('transportation_costs'); ?>
											</td>
											<td>
												<input type="text" name="" value="<?php echo $supplier['TRANSPORTK'].'(% vom Einkaufspreis)'; ?>" class="form-control" style="width: 99.5%;" disabled/>
											</td>
										</tr>
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('packing_size'); ?>
											</td>
											<td>
												<input type="text" name="" value="<?php echo $supplier['VERPAKKING']; ?>" class="form-control" style="width: 99.5%;" disabled/>
											</td>
										</tr>											
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('remarks'); ?>
											</td>
											<td>
												<input type="text" name="" value="<?php echo $supplier['ARTIKELOPM']; ?>" class="form-control" style="width: 99.5%;" disabled/>
											</td>
										</tr>											
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('delete'); ?>
											</td>
											<td>
												<input type="checkbox" value=".T." name="delrecord" class="form-control" />
											</td>
										</tr>	
									</table>
									<?php endif; ?>
								<?php endif; ?>
                            <?php endforeach; ?>
                    </div>	
                </div>	
            </div>
            <!--********SUPPLIER END ******************************************************************************************************************************************************************-->		


            <!--********PRICES START ******************************************************************************************************************************************************************-->					
            <div class="tab-pane" id="prices">
                <div style="padding: 5px;">
                    <div class="col-md-12 table-responsive" >
                        <table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
   
                            <tbody>
                                <?php if ($this->bitauth->is_admin()): ?>

<script type="text/javascript">
jQuery(function($) {
$('#auto_0').autoNumeric('init');
$('#auto_1').autoNumeric('init');
$('#auto_2').autoNumeric('init');
$('#auto_3').autoNumeric('init');
$('#auto_4').autoNumeric('init');
$('#auto_5').autoNumeric('init');
$('#auto_6').autoNumeric('init');
$('#auto_7').autoNumeric('init');
$('#auto_8').autoNumeric('init');
$('#auto_9').autoNumeric('init');
$('#auto_10').autoNumeric('init');
$('#auto_11').autoNumeric('init');
$('#auto_12').autoNumeric('init');
$('#auto_13').autoNumeric('init');
$('#auto_14').autoNumeric('init');
$('#auto_15').autoNumeric('init');
$('#auto_16').autoNumeric('init');
$('#auto_17').autoNumeric('init');
$('#auto_18').autoNumeric('init');
$('#auto_19').autoNumeric('init');


$('.form-control').autoNumeric('set', value);
});
</script>
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
									<?php if($id): ?>
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('average_price');  ?></td>	
											<td>	
											<input type="text" class="form-control" value="<?php echo format_currency($average_price); ?>" style="margin-left: 4px; width: 95%;" disabled/> 
												
											</td>
											<td>
											</td>
											<td>
											</td>
										</tr>
									<?php endif; ?>	
									
                                    <tr>
                                        <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                            <?php echo lang('warehouse_price');  ?>
										</td>	
										<td>
                                            <?php
                                            $data = array('name' => 'warehouse_price', 'value' => set_value('warehouse_price', $warehouse_price), 'class'=>'form-control' ,'id'=>'auto_0','data-a-sign'=>"€",'data-a-sep'=>".",'data-a-dec'=>",",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ' ,'placeholder'=> 'ex. '.$this->config->item('currency_symbol').' 25,00');
                                            echo form_input($data);
                                            ?>
                                        </td>
										<td>
										</td>
										<td>
										</td>
									</tr>	
								<?php endif; ?>

								<?php if($id): ?>
									<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('ek'); ?></td>
										<td>	
											<?php
											$data = array('name' => 'EK', 'value' => set_value('EK', $EK),'class'=>'form-control' ,'id'=>'auto_1','data-a-sign'=>"€",'data-a-sep'=>".",'data-a-dec'=>",",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%;','placeholder'=> 'ex. '.$this->config->item('currency_symbol').' 25,00');
											echo form_input($data);
											?>
										</td>
										<td>
										</td>
										<td>
										</td>
									</tr>
									<?php endif; ?>
									
									
									<tr>
										<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('price_for').' '.lang('nederland'); ?></td>	
										<td>	
											<?php
												$data 		= array('name' => 'saleprice_NL', 'value' => set_value('saleprice_NL', $saleprice_NL),'placeholder'=> 'ex. '.$this->config->item('currency_symbol').' 25,00', 'class'=>'form-control' ,'id'=>'auto_2','data-a-sign'=>"€",'data-a-sep'=>".",'data-a-dec'=>",",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
												
												$data_vat 	= array('name' => 'vat_NL', 'value' => set_value('vat_NL', $vat_NL), 'class'=>'form-control' , 'id'=>'auto_10', 'data-p-sign'=>"s" , 'data-a-sign'=>" %" ,'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
												echo form_input($data); 
											?>
										</td>
						
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
											<?php echo lang('vat_for').' '.lang('nederland'); ?></td>	

										<td>	
											<?php echo form_input($data_vat); ?>
										</td>
									</tr>

                                <tr>

                                       <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
									   <?php echo lang('price_for').' '.lang('germany'); ?></td>

									<td>	
                                        <?php
                                        $data = array('name' => 'saleprice_DE', 'value' => set_value('saleprice_DE', $saleprice_DE), 'placeholder'=> 'ex. '.$this->config->item('currency_symbol').' 25,00', 'class'=>'form-control' ,'id'=>'auto_3','data-a-sign'=>"€",'data-a-sep'=>".",'data-a-dec'=>",",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
                                        $data_vat = array('name' => 'vat_DE', 'value' => set_value('vat_DE', $vat_DE),'class'=>'form-control' , 'id'=>'auto_11', 'data-p-sign'=>"s" , 'data-a-sign'=>" %",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
                                        echo form_input($data); ?>
									</td>	
				
										<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('vat_for').' '.lang('germany'); ?></td>	
					
									<td>	
										<?php echo form_input($data_vat); ?>
                                    </td>
                                </tr>

                                <tr>
                               
                                        <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('price_for').' '.lang('austria'); ?></td>
						
									<td>	
                                        <?php
                                        $data = array('name' => 'saleprice_AU', 'value' => set_value('saleprice_AU', $saleprice_AU), 'placeholder'=> 'ex. '.$this->config->item('currency_symbol').' 25,00','class'=>'form-control' ,'id'=>'auto_4','data-a-sign'=>"€",'data-a-sep'=>".",'data-a-dec'=>",",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
                                        $data_vat = array('name' => 'vat_AU', 'value' => set_value('vat_AU', $vat_AU), 'class'=>'form-control' , 'id'=>'auto_12', 'data-p-sign'=>"s" , 'data-a-sign'=>" %",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
                                        echo form_input($data); ?>
									</td>	
				
										<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('vat_for').' '.lang('austria'); ?></td>	
				
									<td>	
										<?php echo form_input($data_vat); ?>
                                    </td>
                                </tr>

                                <tr>	
                              
                                        <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('price_for').' '.lang('france'); ?></td>
									
									<td>	
                                        <?php
                                        $data = array('name' => 'saleprice_FR', 'value' => set_value('saleprice_FR', $saleprice_FR), 'placeholder'=> 'ex. '.$this->config->item('currency_symbol').' 25,00','class'=>'form-control' ,'id'=>'auto_5','data-a-sign'=>"€",'data-a-sep'=>".",'data-a-dec'=>",",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
                                        $data_vat = array('name' => 'vat_FR', 'value' => set_value('vat_FR', $vat_FR), 'class'=>'form-control' , 'id'=>'auto_13', 'data-p-sign'=>"s" , 'data-a-sign'=>" %",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
                                        echo form_input($data); ?>
									</td>	
						
										<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('vat_for').' '.lang('france'); ?></td>	
							
									<td>	
										<?php echo form_input($data_vat); ?>
                                    </td>
                                </tr>



                                <tr>	
                                 
                                        <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('price_for').' '.lang('belgium'); ?></td>
							
									<td>	
                                        <?php
                                        $data = array('name' => 'saleprice_BE', 'value' => set_value('saleprice_BE', $saleprice_BE), 'placeholder'=> 'ex. '.$this->config->item('currency_symbol').' 25,00','class'=>'form-control' ,'id'=>'auto_6','data-a-sign'=>"€",'data-a-sep'=>".",'data-a-dec'=>",",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
                                        $data_vat = array('name' => 'vat_BE', 'value' => set_value('vat_BE', $vat_BE),  'class'=>'form-control' , 'id'=>'auto_14', 'data-p-sign'=>"s" , 'data-a-sign'=>" %",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
                                        echo form_input($data); ?>
									</td>	
			
										<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('vat_for').' '.lang('belgium'); ?></td>	
					
									<td>	
										<?php echo form_input($data_vat); ?>
                                    </td>
                                </tr>
								
                                <tr>	
                                
                                        <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('price_for').' '.lang('luxembourg'); ?></td>
							
									<td>	
                                        <?php
                                        $data = array('name' => 'saleprice_LX', 'value' => set_value('saleprice_LX', $saleprice_LX), 'placeholder'=> 'ex. '.$this->config->item('currency_symbol').' 25,00','class'=>'form-control' ,'id'=>'auto_7','data-a-sign'=>"€",'data-a-sep'=>".",'data-a-dec'=>",",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
                                        $data_vat = array('name' => 'vat_LX', 'value' => set_value('vat_LX', $vat_LX),  'class'=>'form-control' , 'id'=>'auto_15', 'data-p-sign'=>"s" , 'data-a-sign'=>" %",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
                                        echo form_input($data); ?>
									</td>	
								
										<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('vat_for').' '.lang('luxembourg'); ?></td>	
							
									<td>	
										<?php echo form_input($data_vat); ?>
                                    </td>
                                </tr>
								
                                <tr>	
                                
                                        <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('price_for').' '.lang('uk'); ?></td>
							
									<td>	
                                        <?php
                                        $data = array('name' => 'saleprice_UK', 'value' => set_value('saleprice_UK', $saleprice_UK), 'placeholder'=> 'ex. '.'£'.' 25,00','class'=>'form-control' ,'id'=>'auto_8','data-a-sign'=>"£",'data-a-sep'=>".",'data-a-dec'=>",",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
                                        $data_vat = array('name' => 'vat_UK', 'value' => set_value('vat_UK', $vat_UK),  'class'=>'form-control' , 'id'=>'auto_16', 'data-p-sign'=>"s" , 'data-a-sign'=>" %",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
                                        echo form_input($data); ?>
									</td>	
				
										<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('vat_for').' '.lang('uk'); ?></td>	
						
									<td>	
                                        <?php echo form_input($data_vat); ?>
                                    </td>
                                </tr>
                                <tr>	
                                    <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                        <?php echo lang('differing_dispatch_costs');  ?>
									</td>	
									<td>	
                                        <?php
                                        $data = array('name' => 'differing_dispatch_costs', 'value' => set_value('differing_dispatch_costs', $differing_dispatch_costs), 'class'=>'form-control' ,'placeholder'=> 'ex. '.$this->config->item('currency_symbol').' 25,00','class'=>'form-control' ,'id'=>'auto_9','data-a-sign'=>"€",'data-a-sep'=>".",'data-a-dec'=>",",'style' => 'background-color: ; color: #575D60; margin-left: 4px; width: 95%; ');
                                        echo form_input($data);
                                        ?>
                                    </td>
										<td>
										</td>
										<td>
										</td>
                                </tr>														
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--********PRICES END ******************************************************************************************************************************************************************-->

            <!--********STOCK START ******************************************************************************************************************************************************************-->
							<script>
<!--
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
//-->
							</script>
							
            <div class="tab-pane" id="stock">
                <div style="padding: 5px;">
                    <div class="col-md-12 table-responsive" >
                        <table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
                            <tr>	

                                <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                    <?php echo lang('package_01'); ?>
								</td>
								<td>			
                                    <input type="text" name="package_1" value="<?php echo $package_1; ?>" style='' class="form-control" placeholder="ex. 1" />
                                </td>
								<td><a href="#" style="margin-left: 30%;" data-placement="right" data-toggle="tooltip" data-original-title="<?php echo lang('package_1'); ?>" class="glyphicon glyphicon-info-sign"></a></td>
                            </tr>	
							
                            <tr>	
                                <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                    <?php echo lang('package_02'); ?>
								</td>	
								<td>	
                                    <input type="text" name="package_2" value="<?php echo $package_2; ?>"  style='' class="form-control"  placeholder="ex. 10" />
                                </td>
								<td style="width: 5%;"><a href="#" style="margin-left: 30%;" data-placement="right" data-toggle="tooltip" data-original-title="<?php echo lang('package_2'); ?>" class="glyphicon glyphicon-info-sign"></a></td>
                            </tr>	
							
                            <tr>	
                                <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                    <?php echo lang('package_03'); ?>
								</td>	
								<td>	
                                    <input type="text" name="package_3" value="<?php echo $package_3; ?>" style='' class="form-control"  placeholder="ex. 50" />
                                </td>
								<td><a href="#" style="margin-left: 30%;" data-placement="right" data-toggle="tooltip" data-original-title="<?php echo lang('package_3'); ?>" class="glyphicon glyphicon-info-sign"></a></td>
                            </tr>	
							
                            <tr>	
                                <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                    <?php echo lang('package_details'); ?>
								</td>	
								<td>	
                                    <input type="text" name="package_details" value="<?php echo $package_details; ?>" style='' class="form-control"  placeholder="ex. 1x50" />
                                </td>
								<td><a href="#" style="margin-left: 30%;" data-placement="right" data-toggle="tooltip" data-original-title="<?php echo lang('package_4'); ?>" class="glyphicon glyphicon-info-sign"></a></td>
                            </tr>	
							
							<?php if($id): ?>
								<tr>
									<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('quantity'); ?>
									</td>	
									<td>	
										<?php
										$data = array('name' => 'available_stock', 'value' => set_value('available_stock', $available_stock),'class'=>'form-control');
										echo form_input($data);
										?>
									</td>
								</tr>
							<?php endif; ?>
                            <tr>
                                <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
									<?php echo lang('weight'); ?>
								</td>	
								<td>	
                                    <?php
                                    $data = array('name' => 'weight', 'value' => set_value('weight', $weight),'class'=>'form-control','placeholder'=>'ex. 1kg. (per main box)');
                                    echo form_input($data);
                                    ?>
                                </td>
                            </tr>
							
                            <tr>
                                <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                    <?php echo lang('size_norm');  ?>
								</td>	
								<td>	
                                    <?php
                                    $data = array('name' => 'size', 'value' => set_value('size', $size),'class'=>'form-control','placeholder'=>'ex. XS or S or XXL');
                                    echo form_input($data);
                                    ?>
                                </td>
                            </tr>
							
                            <tr>
                                <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                    <?php echo lang('colour');  ?>
								</td>	
								<td>	
                                    <?php
                                    $data = array('name' => 'color', 'value' => set_value('color', $color),'class'=>'form-control','placeholder'=>'ex. blue');
                                    echo form_input($data);
                                    ?>
                                </td>
                            </tr>

                        </table>
						<script>
								var $tip1 = $('.glyphicon');
								$tip1.tooltip({
								trigger: 'hover',
								placement : 'right'
								});
						</script>


								
                    </div>	
                </div>	
            </div>

            <!--********STOCK END ******************************************************************************************************************************************************************-->



            <!--********Features START ******************************************************************************************************************************************************************-->
            <div class="tab-pane" id="features">
                <div style="padding: 5px;">
                    <div class="col-md-12 table-responsive" >
                        <table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
						
                                <tr>
                                    <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                        <?php echo lang('status'); ?>
									</td>	
									<td>	
                                        <?php
                                        $product_status = array(0 => 'Inactive', 1 => 'Active');
                                        echo form_dropdown('active', $product_status, set_value('active', $active),'class="form-control"'  );
                                        ?>
                                    </td>
                                </tr>	

                                <tr>
                                    <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                        <?php echo lang('shippable'); ?>
									</td>
									<td>				
                                        <?php
                                        $options = array('1' => lang('shippable')
                                            , '0' => lang('not_shippable')
                                        );
                                        echo form_dropdown('shippable', $options, set_value('shippable', $shippable),'class="form-control"' );
                                        ?>
                                    </td>
                                </tr>	

                                <tr>
                                    <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
                                        <?php echo lang('taxable'); ?>
									</td>	
									<td>	
                                        <?php
                                        $options = array('1' => lang('taxable')
														, '0' => lang('not_taxable')
                                        );
                                        echo form_dropdown('taxable', $options, set_value('taxable', $taxable),'class="form-control"' );
                                        ?>
                                    </td>
                                </tr>	

								<tr>
									<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('slug_'); ?> 
									</td>	
									<td>	
										<?php
										$data = array('name' => 'slug', 'value' => set_value('slug', $slug), 'class' => 'form-control','placeholder'=> lang('slug_example'));
										echo form_input($data);
										?>
									</td>
								</tr>

								<tr>
									<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('seo_title'); ?> 
									</td>	
									<td>	
										<?php
										$data = array('name' => 'seo_title', 'value' => set_value('seo_title', $seo_title), 'class' => 'form-control','placeholder'=> lang('seo_example'));
										echo form_input($data);
										?>
									</td>
								</tr>

								<tr>
									<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
										<?php echo lang('meta'); ?>
									</td>
									<td>
										<?php
										$data = array('name' => 'meta', 'value' => set_value('meta', html_entity_decode($meta)), 'class' => 'form-control', 'style' => 'height: 30px; resize:none;','placeholder'=> lang('meta_example'));
										echo form_textarea($data);
										?>
									</td>
								</tr>
								
                        </table>
                    </div>	
                </div>	
            </div>
            <!--******** Features END ******************************************************************************************************************************************************************-->

            <div class="tab-pane" id="product_photos">
                <div style="padding: 5px;">
                    <div class="col-md-12 table-responsive" >
					
								<iframe id="iframe_uploader" src="<?php echo site_url($this->config->item('admin_folder') . '/products/product_image_form'); ?>" class="span8" style="height:100px; width: 50%; border:0px;"></iframe>
				
								<div id="gc_photos">
									<?php
									foreach ($images as $photo_id => $photo_obj) {
										if (!empty($photo_obj)) {
											$photo = (array) $photo_obj;
											add_image($photo_id, $photo['filename'], $photo['alt'], $photo['caption'], isset($photo['primary']));
										}
									}
									?>
								</div>
                    </div>
                </div>
            </div>

            <div class="form-actions" style="margin:10px 10px 10px 20px;">
                <button type="submit" class="btn btn-info"><?php echo lang('form_save'); ?></button>
				<a class="btn btn-info" href="<?php echo site_url($this->config->item('admin_folder').'/products/'); ?>">Back</a>
            </div>
        </div>
    </div>
</form>
</div>



<?php

function add_image($photo_id, $filename, $alt, $caption, $primary = false) {

    ob_start();
    ?>
    <div class="row gc_photo" id="gc_photo_<?php echo $photo_id; ?>" style="background-color:#fff; border-bottom:1px solid #ddd; padding-bottom:20px; margin-bottom:20px;">
	<table class="table table-striped" style="padding: 5px; width: 50%; margin-bottom:15px;">
        <input type="hidden" name="images[<?php echo $photo_id; ?>][filename]" value="<?php echo $filename; ?>"/>
		<tr>	
			<td>
				<img class="gc_thumbnail" src="<?php echo base_url('uploads/images/thumbnails/' . $filename); ?>" style="padding:5px; border:1px solid #ddd"/>
			</td>
		</tr>	
	<tr>	
		<td>
			<input name="images[<?php echo $photo_id; ?>][alt]" value="<?php echo $alt; ?>" class="span2" placeholder="<?php echo lang('alt_tag'); ?>"/>
		</td>
	</tr>	
	<tr>	
		<td>
			<input type="radio" name="primary_image" value="<?php echo $photo_id; ?>" <?php if ($primary) echo 'checked="checked"'; ?>/> <?php echo lang('primary'); ?>
		</td>
	</tr>	
	<tr>
		<td>
			<a onclick="return remove_image($(this));" rel="<?php echo $photo_id; ?>" class="btn btn-info" style="float:right; font-size:9px;"><i class="icon-trash icon-white"></i> <?php echo lang('remove'); ?></a>
		</td>
	</tr>
	<tr>	
		<td>
			<?php echo lang('caption'); ?>		
		</td>	
		<td>
			<textarea name="images[<?php echo $photo_id; ?>][caption]" class="form-control" style="height: 30px; resize:none;"rows="3"><?php echo $caption; ?></textarea>
		</td>	
	</tr>	

		
	</table>
    </div>

    <?php
    $stuff = ob_get_contents();

    ob_end_clean();

    echo replace_newline($stuff);
}

function add_option($po, $count) {
    ob_start();
    ?>
    <tr id="option-<?php echo $count; ?>">
        <td>
            <a class="handle btn btn-mini"><i class="icon-align-justify"></i></a>
            <strong><a class="option_title" href="#option-form-<?php echo $count; ?>"><?php echo $po->type; ?> <?php echo (!empty($po->name)) ? ' : ' . $po->name : ''; ?></a></strong>
            <button type="button" class="btn btn-mini btn-danger pull-right" onclick="remove_option(<?php echo $count ?>);"><i class="icon-trash icon-white"></i></button>
            <input type="hidden" name="option[<?php echo $count; ?>][type]" value="<?php echo $po->type; ?>" />
            <div class="option-form" id="option-form-<?php echo $count; ?>">
                <div class="row-fluid">

                    <div class="span10">
                        <input type="text" class="span10" placeholder="<?php echo lang('option_name'); ?>" name="option[<?php echo $count; ?>][name]" value="<?php echo $po->name; ?>"/>
                    </div>

                    <div class="span2" style="text-align:right;">
                        <input class="checkbox" type="checkbox" name="option[<?php echo $count; ?>][required]" value="1" <?php echo ($po->required) ? 'checked="checked"' : ''; ?>/> <?php echo lang('required'); ?>
                    </div>
                </div>
                <?php if ($po->type != 'textarea' && $po->type != 'textfield'): ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <a class="btn" onclick="add_option_value(<?php echo $count; ?>);"><?php echo lang('add_item'); ?></a>
                        </div>
                    </div>
                <?php endif; ?>
                <div style="margin-top:10px;">

                    <div class="row-fluid">
                        <?php if ($po->type != 'textarea' && $po->type != 'textfield'): ?>
                            <div class="span1">&nbsp;</div>
                        <?php endif; ?>
                        <div class="span3"><strong>&nbsp;&nbsp;<?php echo lang('name'); ?></strong></div>
                        <div class="span2"><strong>&nbsp;<?php echo lang('value'); ?></strong></div>
                        <div class="span2"><strong>&nbsp;<?php echo lang('weight'); ?></strong></div>
                        <div class="span2"><strong>&nbsp;<?php echo lang('price'); ?></strong></div>
                        <div class="span2"><strong>&nbsp;<?php echo ($po->type == 'textfield') ? lang('limit') : ''; ?></strong></div>
                    </div>
                    <div class="option-items" id="option-items-<?php echo $count; ?>">
                        <?php if ($po->values): ?>
                            <?php
                            foreach ($po->values as $value) {
                                $value = (object) $value;
                                add_option_value($po, $count, $GLOBALS['option_value_count'], $value);
                                $GLOBALS['option_value_count'] ++;
                            }
                            ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </td>
    </tr>

    <?php
    $stuff = ob_get_contents();

    ob_end_clean();

    echo replace_newline($stuff);
}

function add_option_value($po, $count, $valcount, $value) {
    ob_start();
    ?>
    <div class="option-values-form">
        <div class="row-fluid">
            <?php if ($po->type != 'textarea' && $po->type != 'textfield'): ?><div class="span1"><a class="handle btn btn-mini" style="float:left;"><i class="icon-align-justify"></i></a></div><?php endif; ?>
            <div class="span3"><input type="text" class="span12" name="option[<?php echo $count; ?>][values][<?php echo $valcount ?>][name]" value="<?php echo $value->name ?>" /></div>
            <div class="span2"><input type="text" class="span12" name="option[<?php echo $count; ?>][values][<?php echo $valcount ?>][value]" value="<?php echo $value->value ?>" /></div>
            <div class="span2"><input type="text" class="span12" name="option[<?php echo $count; ?>][values][<?php echo $valcount ?>][weight]" value="<?php echo $value->weight ?>" /></div>
            <div class="span2"><input type="text" class="span12" name="option[<?php echo $count; ?>][values][<?php echo $valcount ?>][price]" value="<?php echo $value->price ?>" /></div>
            <div class="span2">
                <?php if ($po->type == 'textfield'): ?><input class="span12" type="text" name="option[<?php echo $count; ?>][values][<?php echo $valcount ?>][limit]" value="<?php echo $value->limit ?>" />
                <?php elseif ($po->type != 'textarea' && $po->type != 'textfield'): ?>
                    <a class="delete-option-value btn btn-danger btn-mini pull-right"><i class="icon-trash icon-white"></i></a>
                    <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
    $stuff = ob_get_contents();

    ob_end_clean();

    echo replace_newline($stuff);
}

//this makes it easy to use the same code for initial generation of the form as well as javascript additions
function replace_newline($string) {
    return trim((string) str_replace(array("\r", "\r\n", "\n", "\t"), ' ', $string));
}
?>
<script type="text/javascript">
//<![CDATA[
    var option_count = <?php echo isset($counter) ? $counter : 0 ?>;
    var option_value_count = <?php echo $GLOBALS['option_value_count']; ?>

    function add_related_product()
    {
        //if the related product is not already a related product, add it
        if ($('#related_product_' + $('#product_list').val()).length == 0 && $('#product_list').val() != null)
        {
<?php $new_item = str_replace(array("\n", "\t", "\r"), '', related_items("'+$('#product_list').val()+'", "'+$('#product_item_'+$('#product_list').val()).html()+'")); ?>
            var related_product = '<?php echo $new_item; ?>';
            $('#product_items_container').append(related_product);
            run_product_query();
        }
        else
        {
            if ($('#product_list').val() == null)
            {
                alert('<?php echo lang('alert_select_product'); ?>');
            }
            else
            {
                alert('<?php echo lang('alert_product_related'); ?>');
            }
        }
    }

    function add_category()
    {
        //if the related product is not already a related product, add it
        if ($('#categories_' + $('#category_list').val()).length == 0 && $('#category_list').val() != null)
        {
<?php $new_item = str_replace(array("\n", "\t", "\r"), '', category("'+$('#category_list').val()+'", "'+$('#category_item_'+$('#category_list').val()).html()+'")); ?>
            var category = '<?php echo $new_item; ?>';
            $('#categories_container').append(category);
            run_category_query();
        }
    }


    function remove_related_product(id)
    {
        if (confirm('<?php echo lang('confirm_remove_related'); ?>'))
        {
            $('#related_product_' + id).remove();
            run_product_query();
        }
    }

    function remove_category(id)
    {
        if (confirm('<?php echo lang('confirm_remove_category'); ?>'))
        {
            $('#category_' + id).remove();
            run_product_query();
        }
    }

    function photos_sortable()
    {
        $('#gc_photos').sortable({
            handle: '.gc_thumbnail',
            items: '.gc_photo',
            axis: 'y',
            scroll: true
        });
    }
//]]>
</script>
<?php

function related_items($id, $name) {
    return '
			<tr id="related_product_' . $id . '">
				<td>
					<input type="hidden" name="related_products[]" value="' . $id . '"/>
					' . $name . '</td>
				<td>
					<a class="btn btn-danger pull-right btn-mini" href="#" onclick="remove_related_product(' . $id . '); return false;"><i class="icon-trash icon-white"></i> ' . lang('remove') . '</a>
				</td>
			</tr>
		';
}

function category($id, $name) {
    return '
			<tr id="category_' . $id . '">
				<td>
					<input type="hidden" name="categories[]" value="' . $id . '"/>
					' . $name . '</td>
				<td>
					<a class="btn btn-danger pull-right btn-mini" href="#" onclick="remove_category(' . $id . '); return false;"><i class="icon-trash icon-white"></i> ' . lang('remove') . '</a>
				</td>
			</tr>
		';
}

include('footer.php');
?>