<?php include('header.php'); ?>

 <?php echo form_open($this->config->item('admin_folder') . '/products/quick_view/' . $id); ?>
		<div class="panel panel-default" style="width: 100%; float: left;">
			<div class="panel-heading"><strong><?php echo $code; ?></strong><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
			<div class="panel-body">
				<div class="tabbable">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#genral_tab" data-toggle="tab">General<?php //echo lang('description'); ?></a></li>
						
						<?php if($sales): ?>
							<li><a href="#suplier_tab" data-toggle="tab">Suppliers<?php //echo lang('description'); ?></a></li>
						<?php endif; ?>
						
						<li><a href="#description_tab" data-toggle="tab"><?php echo lang('description'); ?></a></li>
						<li><a href="#downloads_tab" data-toggle="tab">Documents<?php //echo lang('seo'); ?></a></li>
					</ul>

					<div class="tab-content">
						<br/>
						<?php echo form_open($this->config->item('admin_folder') . '/products/quick_view/' . $id); ?>
							<?php
							$js = 'id="shop_nationality" class="form-control" style="margin-bottom: 10px; width: 228px; float: left;" onChange="this.form.submit()"';
							echo form_dropdown('shop_nationality', $all_shops_national, $shop_nationality, $js, 'class="form-control"');
							?>
						</form>
						<br/>
						<div class="tab-pane active" id="genral_tab">
							<br/>
							<table class="table table-striped" style="border: 1px solid #ddd; width: 100%;">
								<tr>
									<th style="width: 10%"><?php echo $photo_small; ?></th>
								</tr>	                        
								<tr>
									<th style="width: 30%"><?php echo lang('code'); ?></th>
									<td>
										<a href="<?php echo site_url($this->config->item('admin_folder').'/products/form/'.$id); ?>"><strong><?php echo $code; ?></strong></a>
									</td>
								</tr>	
								<tr>	
									<th><?php echo lang('name'); ?></th><td><?php echo $name; ?></td>
								</tr>	
								<tr>	
									<th><?php echo lang('price'); ?></th><td><?php echo format_currency($price) . ' for ' . $package_details; ?></td>
								</tr>				
								<tr>	
									<th><?php echo lang('vat'); ?></th><td><?php echo str_replace('.00', '%', $detail->tax); ?></td>
								</tr>
								<tr>	
									<th><?php echo lang('stock'); ?></th><td><?php echo $quantity; ?></td>
								</tr>							
								<tr>	
									<th><?php echo lang('stock_remarks'); ?></th><td><input type="text" name="remarks" value="<?php echo $remarks; ?>" style="width: 50%; background: #D8D8D8 ;"/></td>
								</tr>								
								<tr>	
									<th><?php echo lang('new_shippment_date'); ?></th><td><input type="text" id="new_shippment_date" name="new_shippment_date" value="<?php echo $new_shippment_date; ?>" style="width: 15%; background: #D8D8D8 ;" disabled/></td>
								</tr>
								<tr>	
									<th><?php echo lang('package_details'); ?></th><td><?php echo $package_details; ?></td>
								</tr>
								<tr>	
									<th><?php echo lang('dimension'); ?></th><td><?php echo $dimension; ?></td>
								</tr>	
								<tr>	
									<th><?php echo lang('size_innerbox'); ?></th><td><?php echo $size; ?></td>
								</tr>					
								<tr>	
									<th><?php echo lang('size_outerbox'); ?></th><td><?php echo $size; ?></td>
								</tr>							
								<tr>	
									<th><?php echo lang('weight_innerbox'); ?></th><td><?php echo $weight; ?></td>
								</tr>	
								<tr>	
									<th><?php echo lang('weight_outerbox'); ?></th><td><?php echo $weight; ?></td>
								</tr>					
							</table>
						</div>
						<?php if($sales): ?>
							<div class="tab-pane" id="suplier_tab">
								<br/>
								<table class="table" style="border: 1px solid #ddd; width: 100%;">
									<?php foreach($suppliers as $supplier): ?>
																<tr><td><?php echo lang('company'); ?></td><td><a href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/form/'.$supplier->id); ?>"><strong><?php echo $supplier->company; ?><strong></a></td></tr>
																<tr><td><?php echo lang('firstname'); ?></td><td><?php echo $supplier->firstname; ?></td></tr>
																<tr><td><?php echo lang('lastname'); ?></td><td><?php echo $supplier->lastname; ?></td></tr>
																<tr><td><?php echo lang('address'); ?></td><td><?php echo $supplier->street.' '.$supplier->street_num; ?></td></tr>
																<tr><td><?php echo lang('address'); ?></td><td><?php echo $supplier->post_code.' '.$supplier->city; ?></td></tr>
																<tr><td><?php echo lang('address'); ?></td><td><?php echo $supplier->country; ?></td></tr>
																<tr><td>Contact person<?php echo lang('contact_person'); ?></td><td><?php echo $supplier->contact_person; ?></td></tr>
																<tr><td><?php echo lang('phone'); ?></td><td><?php echo $supplier->phone; ?></td></tr>
																<tr><td><?php echo lang('fax'); ?></td><td><?php echo $supplier->fax; ?></td></tr>
																<tr><td><?php echo lang('email'); ?></td><td><a href="mailto:<?php echo $supplier->email; ?>" target="_top"><?php echo $supplier->email; ?></a></td></tr>
																<tr><td>Website<?php echo lang('site'); ?></td><td><a href="<?php echo 'http://'.$supplier->web; ?>" target="_"><?php echo $supplier->web; ?></a></td></tr>
																<tr><td>Info<?php echo lang('info'); ?></td><td><?php echo $supplier->supplier_info; ?></td></tr>
									<?php endforeach; ?>					
								</table>	
							</div>
						<?php endif; ?>
						<div class="tab-pane" id="description_tab">
							<br/>
							<table class="table" style="border: 1px solid #ddd; width: 100%;">
								<tr>	
									<td style="width: 40%;">
										<?php echo $photo_big; ?>
									</td>
									<td>
										<?php echo $description; ?><p>&nbsp;</p><?php echo $text_1; ?><p>&nbsp;</p><?php echo $text_2; ?><p>&nbsp;</p>
										<div><a href="#" onclick="showhide()" ><?php echo $link_1; ?></a></div>
										<div><a href="#" onclick="showhide_1()" ><?php echo $link_2; ?></a></div>
									</td>
								</tr>							
							</table>	
						</div>
						<div class="tab-pane" id="downloads_tab">
							<br/>
								<table class="table table-striped table-hover" style="border: 1px solid #ddd;">
												<tbody>
													<?php if(!empty($files)): ?>
														<?php foreach ($files as $file): ?>
															<?php if(!is_dir($file)): ?>
															<?php  $match = substr($file, 0, 2); ?>
																<?php if($match == $shop_nationality): ?>
																	<tr>
																		<td><a href="<?php echo $path.'/'.$file; ?>" download=""><?php echo $file; ?></a></td>
																	   <td></td>
																	   <td></td>
																	</tr>
																<?php endif; ?>
															<?php endif; ?>
														<?php endforeach; ?>
													<?php endif; ?>
												</tbody>
													<tfoot>
														<tr>&nbsp;</tr>
													</tfoot>
												<?php //echo $error;?>
									</table>
						</div>
						

							<br/>
							<br/>
						<button type="submit" class="btn btn-info" >Save</button>
					</div>
				</div>
			</div>
		</div>
</form>
<?php if($sales): ?>
<div class="panel panel-default" style="width: 100%; float: left;">
    <div class="panel-heading">Overview Customer per product<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
    </div>
    <div class="panel-body">
        <?php echo form_open($this->config->item('admin_folder') . '/products/quick_view/'.$id); ?>
			<?php
			$js_month = 'id="month" class="form-control" style="margin-bottom: 10px; width: 100px; float: left;" onChange="this.form.submit()"';
			echo form_dropdown('month', $months, $month, $js_month, 'class="form-control"');
			?>				

			<?php
			$js_year = 'id="year" class="form-control" style="margin-bottom: 10px; width: 100px; float: left;" onChange="this.form.submit()"';
			echo form_dropdown('year', $years, $year, $js_year, 'class="form-control"');
			?>
        </form>
        <table class="table table-striped" style="border: 1px solid #ddd; width: 100%;">
            <tr>	
                <th><?php echo lang('customer'); ?></th>
                <th><?php echo lang('name'); ?></th>
                <th><?php echo lang('ordered_quantity'); ?></th>
                <th><?php echo lang('turnover'); ?></th>
                <th><?php echo lang('purchase_price'); ?></th>
                <th><?php echo lang('profit'); ?></th>
                <th><?php echo lang('margin'); ?></th>
            </tr>	
            <?php
                $s['profit'] = 0;
                $s['VE'] = 0;
                $s['total_warehouse_price'] = 0;
                $s['total'] = 0;
                $s['profit'] = 0;
                $s['quantity'] = 0;
                //
                
            ?>
            <?php foreach($res as $v): ?>
                <tr>
                    <td>
                        <a href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$v['real_id']); ?>"><?php echo $v['qid']; ?></a>
                    </td>
                    <td>
                        <a href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$v['real_id']); ?>"><?php echo $v['title']; ?></a>
                    </td>
                        <?php if(isset($v['quantity']) && $v['quantity'] != 0.0): ?>
                            <?php $s['quantity'] += $v['quantity'] ?>
                            <td >
                                <?php echo sprintf("%6.0f",$v['quantity'] ); ?>
                            </td>
                        <?php else: ?>
                            <td>&nbsp;</td>
                        <?php endif; ?>
                        <!-- -->
                        <?php if(isset($v['quantity']) && $v['quantity'] != 0.0): ?>
                            <?php $s['total'] += $v['total']; ?>
                            <td>
                                <?php echo sprintf("%6.2f",$v['total'] ); ?>
                            </td>
                        <?php else: ?>
                            <td>&nbsp;</td>
                        <?php endif; ?>
                         <!-- -->
                        <?php if(isset($v['total_warehouse_price']) && $v['total_warehouse_price'] != 0.0): ?>
                            <?php $s['total_warehouse_price'] += $v['total_warehouse_price']; ?>
                            <td>
                                <?php echo sprintf("%6.2f",$v['total_warehouse_price'] ); ?>
                            </td>
                        <?php else: ?>
                            <td>&nbsp;</td>
                        <?php endif; ?>
                         <!-- -->
                        <?php if(isset($v['profit']) && $v['profit'] != 0.0): ?>
                            <?php $s['profit'] += $v['profit']; ?>
                            <td>
                                <?php echo sprintf("%6.2f",$v['profit'] ); ?>
                            </td>
                        <?php else: ?>
                            <td>&nbsp;</td>
                        <?php endif; ?>
                        <!-- -->
                        <?php if(isset($v['total']) && $v['total'] != 0.0): ?>
                            <td>
                                <?php echo  sprintf("%6.2f",100*$v['profit'] / $v['total']) ?>
                            </td>
                        <?php else: ?>
                            <td>&nbsp;</td>
                        <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td>&nbsp;</td>
                <td>Total:</td>
                <?php if($s['quantity'] != 0.0): ?>            
                    <td >
                        <?php echo sprintf("%6.0f",$s['quantity'] ); ?>
                    </td>
                <?php else: ?>
                    <td>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                <?php if( $s['quantity'] != 0.0): ?>
                    <td>
                        <?php echo sprintf("%6.2f",$s['total'] ); ?>
                    </td>
                <?php else: ?>
                    <td>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                <?php if( $s['total_warehouse_price'] != 0.0): ?>
                    <td>
                        <?php echo sprintf("%6.2f",$s['total_warehouse_price'] ); ?>
                    </td>
                <?php else: ?>
                    <td>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                <?php if($s['profit'] != 0.0): ?>
                    <td>
                            <?php echo sprintf("%6.2f",$s['profit'] ); ?>
                    </td>
                <?php else: ?>
                    <td>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                <?php if($s['total'] != 0.0): ?>
                    <td>
                        <?php echo  sprintf("%6.2f",100*$s['profit'] / $s['total']) ?>
                    </td>
                <?php else: ?>
                            <td>&nbsp;</td>
                <?php endif; ?>
            </tr>
        </table>	
    </div>
</div>
<?php endif; ?>
<!--style="display:none;"-->
<div id="table_1" style="display: none;">
	<?php echo '<img src="http://www.varnamed.com/uploads/images/no_image_full" alt="no_image"/>'; ?>
</div>
<div id="table_2" style="display: none;">
	<?php echo '<img src="http://www.varnamed.com/uploads/images/no_image_full" alt="no_image"/>'; ?>
</div>
<script>
     function showhide()
     {
           var div = document.getElementById("table_1");
    if (div.style.display !== "none") {
        div.style.display = "none";
    }
    else {
        div.style.display = "block";
    }
     }
	      function showhide_1()
     {
           var div = document.getElementById("table_1");
    if (div.style.display !== "none") {
        div.style.display = "none";
    }
    else {
        div.style.display = "block";
    }
     }
</script>
<script>$('#new_shippment_date').datepicker({dateFormat:'yy-mm-dd', altField: '#new_shippment_date', altFormat: 'yy-mm-dd'});</script>
<style type="text/css">

</style>


































































<?php include('footer.php'); ?>