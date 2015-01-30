<?php 

    $class_1 = 'class = span3';

        if($current_shop == 1 ){
				$staff_array = array(
					
					"0"  	=> 'Select',
					'94' 	=> 'Metamorfose Vertalingen',
					'115' 	=> 'Testaccount CC',
					'127' 	=> 'Davorka Tosic',
					'128' 	=> 'Davorka Tosic',
					'129' 	=> 'Ramona M�ller',
					'130' 	=> 'Ramona M�ller',
					'131' 	=> 'Sandra Weibke',
					'134' 	=> 'Sven Mettmann',
					'136' => 'Irina Schumann',
					'138' => 'Sophie Gricourt',
					'139' => 'Anne Sophie Carre',
					'140' => 'Jennifer Rault',
					'141' => 'Emilie Delavigne',
					'142' => 'Eva Lavilla',
					'143' => 'Elodie Sebeille',
					'144' => 'Amelie Bloret',
					'145' => 'Sandrine Rault',
					'146' => 'Manuele K�hl',
					'147' => 'Marcel Hoffmann',
					'148' => 'Angelika Lichter',
					'149' => 'Martina Ege',
					'150' => 'Dieter B�hler',
					'151' => 'Peter Reason',
					'152' => 'Florian Macht',
					'155' => 'Marjan Jeuring',
					'156' => 'Maarten Lansink',
					'157' => 'Franck Jaarsma',
					'158' => 'Stefan Hiddink',
					'159' => 'Veruschka Laetemia',
					'160' => 'Francisca Oosterbroek',
					'161' => 'Alexander Stozkijk',
					'164' => 'Max Hijne',
					'165' => 'Gina-Cristin Kisker',
					'167' => 'Emmanuelle Miakakarila',
					'169' => 'Marianne Rijn',
					'172' => 'Frits',
					'173' => 'Karel van Mossevelde',
					'179' => 'Veronica Hoffman',
					'183' => 'Ane Lorens',
					'184' => 'Ann Jansens',
					'185' => 'Axel Mettenleiter',
					'187' => 'Hildo Kat',
					'188' => 'Capucin Lepere',
					'189' => 'Viktor3',
					'192' => 'Brigitte Becker',
					'199' => 'Viktor2',
					'205' => 'Viktor8',
					'207' => 'Kerry Robinson',
					'208' => 'Ernest Lassman',
					'209' => 'Maria Meister',
					'213' => 'Geert Kloppenburg',
					'217' => 'Stephanie Gillet',
					'219' => 'Petra Muller');
    
}
		
		    if($current_shop == 2 ){
					$staff_array = array(
						
					"0"  => 'Select',
					"131"=>'Davorka Tosic',
					"132"=>'Ramona M�ller',
					"133"=>'Sandra Weibke',
					"135"=>'Sven Mettmann',
					"136"=>'Irina Schumann',
					"137"=>'Jennifer Rault',
					"138"=>'Sophie Gricourt',
					"139"=>'Anne Sophie Carre',
					"140"=>'Emilie Delavigne',
					"141"=>'Eva Lavilla',
					"142"=>'Elodie Sebeille',
					"143"=>'Amelie Bloret',
					"144"=>'Sandrine Rault',
					"145"=>'Manuela K�hl',
					"146"=>'Marcel Hoffmann',
					"147"=>'Angelika Lichter',
					"148"=>'Martina Ege',
					"149"=>'Dieter B�hler',
					"150"=>'Peter Reason',
					"151"=>'Florian Macht',
					"152"=>'Rachel Kortstam',
					"154"=>'Marjan Jeuring',
					"155"=>'Maarten Lansink',
					"156"=>'Franck Jaarsma',
					"157"=>'Stefan Hiddink',
					"158"=>'Veruschka Laetemia',
					"159"=>'Francisca Oosterbroek',
					"162"=>'Max Hijne',
					"163"=>'Gina-Cristin Kisker',
					"166"=>'Emmanuelle Miakakarila',
					"170"=>'Marianne Rijn',
					"176"=>'Frits',
					"177"=>'Karel van Mossevelde',
					"182"=>'Veronica Hoffman',
					"184"=>'Ane Lorens',
					"188"=>'Ann Jansens',
					"190"=>'Axel Mettenleiter',
					"192"=>'Hildo Kat',
					"193"=>'Capucin Lepere',
					"195"=>'Brigitte Becker',
					"200"=>'Ernest Lassman',
					"201"=>'Maria Meister',
					"205"=>'Geert Kloppenburg',
					"208"=>'Stephanie Gillet',
					"210"=>'Petra Muller');
						
					}
	if($current_shop == 3 ){

			$staff_array = array(
				
					"0"  => 'Select',
					"176"=>'Frits van Oorschot',
					"177"=>'Karel van Mossevelde',
					"188"=>'Ann Jansens',
					"192"=>'Hildo Kat',
					"200"=>'Ernest Lassman',
					"201"=>'Maria Meister',
					"205"=>'Geert Kloppenburg',
					"170"=>'Marianne Rijn',
					"182"=>'Veronica Hoffman',
					"195"=>'Brigitte Becker',
					"208"=>'Stephanie Gillet',
					"210"=>'Petra Muller'
					);
	}

    $type = array(
        '-1'                => lang('select_type_overview'),
        'country'           => lang('country'),
        'industry'          => lang('industry'),
        'customer'          => lang('customer'),
        'manager'           => lang('manager'),
        'team'              => lang('team'),
        'office_staff'      => lang('office_staff'),
        'field_service'     => lang('field_service'),
        'product'           => lang('product'),
        'supplier'          => lang('supplier'),
        'catagory_manager'  => lang('catagory_manager'),
    );
	
	
	$this_month = date('m');
	$last_month = date('m')-1;
	$two_months_ago = date('m')-2;
	$twelf_months = date('m');
	
    $period = array(
        $this_month        => 'Diese Month',
       $last_month         => 'Letzte Month',
        $two_months_ago    => 'Vor 2 Monate',

    );
	
	$pay_array = array(
		0 => 'Niet betaald',
		1 => 'Betaald',
	);
	
	
?>

<?php include('header.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_customer');?>');
}
</script>
	
    <?php echo form_open($this->config->item('admin_folder').'/overview/profit_per_agent');?>
		
			<?php $js = 'id="agent" onChange="this.form.submit();"'; ?>
	
			<?php echo form_fieldset('Selecteert middel')?>
			
            <?php 
				if(!empty($selected_agent)){
					echo form_dropdown('agent', $staff_array, $selected_agent,$js,$class_1);
				}
				else {
					echo form_dropdown('agent', $staff_array, '-1',$js,$class_1);
				}
			 ?>
			
        </fieldset>
        

        
        <?php echo form_fieldset(lang('settings'))?>
          <input type="radio" name="settings" value="margin_in_per" id='r1'>&nbsp;<?php echo lang('margin_in_%'); ?>&nbsp;&nbsp;
            <input type="radio" name="settings" value="margin_in_eu" id='r2' checked='checked'>&nbsp;<?php echo lang('margin_in_€'); ?>&nbsp;&nbsp;
            <input type="radio" name="settings" value="number_ve" id='r3'>&nbsp;<?php echo lang('number_ve'); ?>&nbsp;&nbsp; 
        </fieldset>
    </form>

    <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/overview/profit_per_agent');?>">Duidelijke selectie<?php //echo lang('clear_selection')?></a>
	<hr>
<?php if(!empty($agent_profit)): ?>
<table class="table table-striped table-condensed">      
	<thead>	  
			<tr>
				<th>Afgelopen twaalf maanden</th>
				<th>Afgelopen twee maanden</th>
				<th>Vorige maand</th>
				<th>Deze maand</th>
			</tr>	
	</thead>
	<tbody>		
		<?php  if(!empty($agent_profit)):   ?>
			<tr>
				<td><?php  if(!empty($agent_profit['12_months'])) echo $this->config->item('currency_symbol').' '.$agent_profit['12_months']; ?></td>	
				<td><?php  if(!empty($agent_profit['2_months'])) echo $this->config->item('currency_symbol').' '.$agent_profit['2_months']; ?></td>	
				<td><?php  if(!empty($agent_profit['1_months'])) echo $this->config->item('currency_symbol').' '.$agent_profit['1_months']; ?></td>	
				<td><?php  if(!empty($agent_profit['current_month'])) echo $this->config->item('currency_symbol').' '.$agent_profit['current_month']; ?></td>	
			</tr>	
				
		<?php endif;  ?>

	</tbody>
</table>
<?php 
//echo '<pre>';
//print_r($agent_profit_details);
//echo '</pre>';
?>

                <div class="accordion" id="accordion2">
                    <div class="accordion-group">  
                        <div class="accordion-heading">  
                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">  
                            <label>Facturen voor 12 maanden</label>
                          </a>  
                        </div>  
                        <div id="collapseOne" class="accordion-body collapse" style="height: 0px; ">  
                          <div class="accordion-inner">  
						<table class="table table-striped table-condensed">
							<thead>
								<tr>
									<th>Aangemaakt</th>
									<th>Factuurnummer</th>
									<th>Ordernummer</th>
									<th>Klant</th>
									<th>Klant ID</th>
									<th>Land ID</th>
									<th>Totalnet</th>
									<th>Betaald</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($agent_profit_details['12_months'] as $invoice_12): ?>
								<tr>
									<td><?php echo $invoice_12['created_on'] ?></td>
									<td><?php echo $invoice_12['invoice_number'] ?></td>
									<td><?php echo $invoice_12['order_number'] ?></td>
									<td><?php echo $invoice_12['company'] ?></td>
									<td><?php echo $invoice_12['customer_id'] ?></td>
									<td><?php echo $invoice_12['country_id'] ?></td>
									<td><?php echo $invoice_12['totalnet'] ?></td>
									<td><?php echo $pay_array[$invoice_12['fully_paid']] ?></td>
								</tr>
							<?php endforeach; ?>	
							</tbody>
						</table>
                          </div>  
                        </div>  
                    </div>
                </div>
                <div class="accordion" id="accordion2">
                    <div class="accordion-group">  
                        <div class="accordion-heading">  
                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">  
                            <label>Facturen voor 2 maanden</label>
                          </a>  
                        </div>  
                        <div id="collapseTwo" class="accordion-body collapse" style="height: 0px; ">  
                          <div class="accordion-inner">  
						<table class="table table-striped table-condensed">
							<thead>
								<tr>
									<th>Aangemaakt</th>
									<th>Factuurnummer</th>
									<th>Ordernummer</th>
									<th>Klant</th>
									<th>Klant ID</th>
									<th>Land ID</th>
									<th>Totalnet</th>
									<th>Betaald</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($agent_profit_details['2_months'] as $invoice_2): ?>
								<tr>
									<td><?php echo $invoice_2['created_on'] ?></td>
									<td><?php echo $invoice_2['invoice_number'] ?></td>
									<td><?php echo $invoice_2['order_number'] ?></td>
									<td><?php echo $invoice_2['company'] ?></td>
									<td><?php echo $invoice_2['customer_id'] ?></td>
									<td><?php echo $invoice_2['country_id'] ?></td>
									<td><?php echo $invoice_2['totalnet'] ?></td>
									<td><?php echo $pay_array[$invoice_2['fully_paid']] ?></td>
								</tr>
							<?php endforeach; ?>	
							</tbody>
						</table>
                          </div>  
                        </div>  
                    </div>
                </div>
				                <div class="accordion" id="accordion2">
                    <div class="accordion-group">  
                        <div class="accordion-heading">  
                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">  
                            <label>Facturen voor 1 maand</label>
                          </a>  
                        </div>  
                        <div id="collapseThree" class="accordion-body collapse" style="height: 0px; ">  
                          <div class="accordion-inner">  
						<table class="table table-striped table-condensed">
							<thead>
								<tr>
									<th>Aangemaakt</th>
									<th>Factuurnummer</th>
									<th>Ordernummer</th>
									<th>Klant</th>
									<th>Klant ID</th>
									<th>Land ID</th>
									<th>Totalnet</th>
									<th>Betaald</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($agent_profit_details['1_months'] as $invoice_1): ?>
								<tr>
									<td><?php echo $invoice_1['created_on'] ?></td>
									<td><?php echo $invoice_1['invoice_number'] ?></td>
									<td><?php echo $invoice_1['order_number'] ?></td>
									<td><?php echo $invoice_1['company'] ?></td>
									<td><?php echo $invoice_1['customer_id'] ?></td>
									<td><?php echo $invoice_1['country_id'] ?></td>
									<td><?php echo $invoice_1['totalnet'] ?></td>
									<td><?php echo $pay_array[$invoice_1['fully_paid']] ?></td>
								</tr>
							<?php endforeach; ?>	
							</tbody>
						</table>
                          </div>  
                        </div>  
                    </div>
                </div>
				                <div class="accordion" id="accordion2">
                    <div class="accordion-group">  
                        <div class="accordion-heading">  
                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">  
                            <label>Factuur van deze maand</label>
                          </a>  
                        </div>  
                        <div id="collapseFour" class="accordion-body collapse" style="height: 0px; ">  
                          <div class="accordion-inner">  
						<table class="table table-striped table-condensed">
							<thead>
								<tr>
									<th>Aangemaakt</th>
									<th>Factuurnummer</th>
									<th>Ordernummer</th>
									<th>Klant</th>
									<th>Klant ID</th>
									<th>Land ID</th>
									<th>Totalnet</th>
									<th>Betaald</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($agent_profit_details['current_month'] as $current_month): ?>
								<tr>
									<td><?php echo $current_month['created_on'] ?></td>
									<td><?php echo $current_month['invoice_number'] ?></td>
									<td><?php echo $current_month['order_number'] ?></td>
									<td><?php echo $current_month['company'] ?></td>
									<td><?php echo $current_month['customer_id'] ?></td>
									<td><?php echo $current_month['country_id'] ?></td>
									<td><?php echo $current_month['totalnet'] ?></td>
									<td><?php echo $pay_array[$current_month['fully_paid']] ?></td>
								</tr>
							<?php endforeach; ?>	
							</tbody>
						</table>
                          </div>  
                        </div>  
                    </div>
                </div>
<?php else: ?>
    <table class="table table-striped table-condensed">      
	<thead>	  
            <tr>
                <th rowspan='2' style='text-align: right;'>Buitendienst</th>
                <th colspan="2" style='text-align: right;'>Durschnitt 12 Monate</th>
		<th colspan="2" style='text-align: right;'>Vor 2 Monate</th>
                <th colspan="2" style='text-align: right;'>Letzte Month</th>
		<th colspan="2" style='text-align: right;'>Diese Month</th>
            </tr>
            <tr>
                <th style='text-align: right;'>Umsatz</th>
                <th style='text-align: right;' class='agevro'>margin €</th>
                <th style='text-align: right;' class='agpercent'>margin %</th>
                <th style='text-align: right;' class='agve'>Number VE</th>
                <th style='text-align: right;'>Umsatz</th>
                <th style='text-align: right;' class='agevro'>margin €</th>
                <th style='text-align: right;' class='agpercent'>margin %</th>
                <th style='text-align: right;' class='agve'>Number VE</th>
                <th style='text-align: right;'>Umsatz</th>
                <th style='text-align: right;' class='agevro'>margin €</th>
                <th style='text-align: right;' class='agpercent'>margin %</th>
                <th style='text-align: right;' class='agve'>Number VE</th>
                <th style='text-align: right;'>Umsatz</th>
                <th style='text-align: right;' class='agevro'>margin €</th>
                <th style='text-align: right;' class='agpercent'>margin %</th>
                <th style='text-align: right;' class='agve'>Number VE</th>
            </tr>
	</thead>
        <tbody>
            <?php
                /* counter setting */
                $s['meannet'] = 0;
                $s['meanprofit'] = 0;
                $s['meanVE'] = 0;
                $s['m_2_totalnet'] = 0;
                $s['m_2_profit'] = 0;
                $s['m_2_VE'] = 0;
                $s['m_1_totalnet'] = 0;
                $s['m_1_profit'] = 0;
                $s['m_1_VE'] = 0;
                $s['totalnet'] = 0;
                $s['profit'] = 0;
                $s['VE'] = 0;
            ?>
            <?php foreach($profit_per_agent as $k => $v): ?>
            <tr>
                <td>
                    <?php 
                        echo 
                        anchor(
                            $this->config->item('admin_folder').'/overview/agent/'.$v['field_service'],
                            $k
                        ); 
                    ?>
                </td>
                <?php if(isset($v['meannet']) && $v['meannet'] != 0.0): ?>
                    <?php $s['meannet'] += $v['meannet'] ?>
                    <td style='text-align: right;'>
                        <?php echo sprintf("%6.2f",$v['meannet']) ?>
                    </td>
                <?php else: ?>
                    <td>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['meanprofit']) && $v['meanprofit'] != 0.0): ?>
                    <?php $s['meanprofit'] += $v['meanprofit'] ?>
                    <td style='text-align: right;' class='agevro'>
                        <?php echo  sprintf("%6.2f",$v['meanprofit']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agevro'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['meannet']) && $v['meannet'] != 0.0): ?>
                    <td style='text-align: right;' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$v['meanprofit'] / $v['meannet']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['meanVE']) && $v['meanVE'] != 0): ?>
                    <?php $s['meanVE'] += $v['meanVE'] ?>
                    <td style='text-align: right;' class='agve'>
                        <?php echo  sprintf("%d",$v['meanVE']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agve'>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                <?php if(isset($v['m_2_totalnet']) && $v['m_2_totalnet'] != 0.0): ?>
                    <?php $s['m_2_totalnet'] += $v['m_2_totalnet'] ?>
                    <td style='text-align: right;'>
                        <?php echo sprintf("%6.2f",$v['m_2_totalnet']) ?>
                    </td>
                <?php else: ?>
                    <td>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['m_2_profit']) && $v['m_2_profit'] != 0.0): ?>
                    <?php $s['m_2_profit'] += $v['m_2_profit'] ?>
                    <td style='text-align: right;'  class='agevro'>
                        <?php echo sprintf("%6.2f",$v['m_2_profit']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro'>&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($v['m_2_totalnet']) && $v['m_2_totalnet'] != 0.0): ?>
                    <td style='text-align: right;' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$v['m_2_profit'] / $v['m_2_totalnet']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['m_2_VE']) && $v['m_2_VE'] != 0): ?>
                    <?php $s['m_2_VE'] += $v['m_2_VE'] ?>
                    <td style='text-align: right;' class='agve'>
                        <?php echo  $v['m_2_VE'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve'>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                <?php if(isset($v['m_1_totalnet']) && $v['m_1_totalnet'] != 0.0): ?>
                    <?php $s['m_1_totalnet'] += $v['m_1_totalnet'] ?>
                    <td style='text-align: right;' >
                        <?php echo  sprintf("%6.2f",$v['m_1_totalnet']) ?>
                    </td>
                <?php else: ?>
                    <td>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['m_1_profit']) && $v['m_1_profit'] != 0.0): ?>
                    <?php $s['m_1_profit'] += $v['m_1_profit'] ?>
                    <td style='text-align: right;'  class='agevro'>
                        <?php echo sprintf("%6.2f",$v['m_1_profit']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['m_1_totalnet']) && $v['m_1_totalnet'] != 0.0): ?>
                    <td style='text-align: right;' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$v['m_1_profit'] / $v['m_1_totalnet']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['m_1_VE']) && $v['m_1_VE'] != 0): ?>
                    <?php $s['m_1_VE'] += $v['m_1_VE'] ?>
                    <td style='text-align: right;' class='agve'>
                        <?php echo  $v['m_1_VE'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve'>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                 <?php if(isset($v['totalnet']) && $v['totalnet'] != 0.0): ?>
                    <?php $s['totalnet'] += $v['totalnet'] ?>
                    <td style='text-align: right;'>
                        <?php echo sprintf("%6.2f",$v['totalnet']) ?>
                    </td>
                <?php else: ?>
                    <td>&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($v['profit']) && $v['profit'] != 0.0): ?>
                    <?php $s['profit'] += $v['profit'] ?>
                    <td style='text-align: right;' class='agevro'>
                        <?php echo sprintf("%6.2f",$v['profit']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['totalnet']) && $v['totalnet'] != 0.0): ?>
                    <td style='text-align: right;' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$v['profit'] / $v['totalnet']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent'>&nbsp;</td>
                <?php endif; ?> 
                <?php if(isset($v['VE']) && $v['VE'] != 0): ?>
                    <?php $s['VE'] += $v['VE'] ?>
                    <td style='text-align: right;' class='agve'>
                        <?php echo  $v['VE'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve'>&nbsp;</td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
            <!-- total row -->
            <tr style="text-weight:bold">
                <td>Total: </td>
                <?php if(isset($s['meannet']) && $s['meannet'] != 0.0): ?>
                    <td style='text-align: right;'>
                        <?php echo sprintf("%6.2f",$s['meannet']) ?>
                    </td>
                <?php else: ?>
                    <td>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['meanprofit']) && $s['meanprofit'] != 0.0): ?>
                    <td style='text-align: right;' class='agevro'>
                        <?php echo  sprintf("%6.2f",$s['meanprofit']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agevro'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['meannet']) && $s['meannet'] != 0.0): ?>
                    <td style='text-align: right;' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$s['meanprofit'] / $s['meannet']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['meanVE']) && $s['meanVE'] != 0): ?>
                    <td style='text-align: right;' class='agve'>
                        <?php echo  sprintf("%d",$s['meanVE']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agve'>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                <?php if(isset($v['m_2_totalnet']) && $s['m_2_totalnet'] != 0.0): ?>
                    <td style='text-align: right;'>
                        <?php echo sprintf("%6.2f",$s['m_2_totalnet']) ?>
                    </td>
                <?php else: ?>
                    <td>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['m_2_profit']) && $s['m_2_profit'] != 0.0): ?>
                    <td style='text-align: right;'  class='agevro'>
                        <?php echo sprintf("%6.2f",$s['m_2_profit']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro'>&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($s['m_2_totalnet']) && $s['m_2_totalnet'] != 0.0): ?>
                    <td style='text-align: right;' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$s['m_2_profit'] / $s['m_2_totalnet']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['m_2_VE']) && $s['m_2_VE'] != 0): ?>
                    <td style='text-align: right;' class='agve'>
                        <?php echo  $s['m_2_VE'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve'>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                <?php if(isset($s['m_1_totalnet']) && $s['m_1_totalnet'] != 0.0): ?>
                    <td style='text-align: right;' >
                        <?php echo  sprintf("%6.2f",$s['m_1_totalnet']) ?>
                    </td>
                <?php else: ?>
                    <td>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['m_1_profit']) && $s['m_1_profit'] != 0.0): ?>
                    <td style='text-align: right;'  class='agevro'>
                        <?php echo sprintf("%6.2f",$s['m_1_profit']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['m_1_totalnet']) && $s['m_1_totalnet'] != 0.0): ?>
                    <td style='text-align: right;' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$s['m_1_profit'] / $s['m_1_totalnet']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['m_1_VE']) && $s['m_1_VE'] != 0): ?>
                    <td style='text-align: right;' class='agve'>
                        <?php echo  $s['m_1_VE'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve'>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                <?php if(isset($s['totalnet']) && $s['totalnet'] != 0.0): ?>
                    <td style='text-align: right;'>
                        <?php echo sprintf("%6.2f",$s['totalnet']) ?>
                    </td>
                <?php else: ?>
                    <td>&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($s['profit']) && $s['profit'] != 0.0): ?>
                    <td style='text-align: right;' class='agevro'>
                        <?php echo sprintf("%6.2f",$s['profit']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['totalnet']) && $s['totalnet'] != 0.0): ?>
                    <td style='text-align: right;' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$s['profit'] / $s['totalnet']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent'>&nbsp;</td>
                <?php endif; ?> 
                <?php if(isset($s['VE']) && $s['VE'] != 0): ?>
                    <td style='text-align: right;' class='agve'>
                        <?php echo  $s['VE'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve'>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
            </tr>
        </tbody>
    </table>
<?php endif; ?>
<?php include('footer.php'); ?>