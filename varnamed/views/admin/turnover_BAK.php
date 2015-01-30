<?php 

    $class_1 = 'class = span3';
     $type = array(
        'country'           => lang('country'),
        // 'industry'          => lang('industry'),
        'customer'          => lang('customer'),
       // 'manager'           => lang('manager'),
       //  'team'              => lang('team'),
        'office_staff'      => lang('office_staff'),
        'field_service'     => lang('field_service'),
        'product'           => lang('product'),
       // 'supplier'          => lang('supplier'),
      //  'catagory_manager'  => lang('catagory_manager'),
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

	
<?php echo form_open($this->config->item('admin_folder').'/overview/turnover');?>
    <?php $js = 'id="agent" onChange="this.form.submit();"'; ?>
   <?php echo form_fieldset(lang('select_type_overview'))?>
        <?php
            if(!empty($select_type_overview)){
                        echo form_dropdown('type', $type, $select_type_overview,$js,$class_1);
                    }
                    else {
                        echo form_dropdown('type', $type, '-1',$js,$class_1);
                    }
        ?>
    </fieldset>
    <?php echo form_fieldset(lang('settings'))?>
    <table border='0'>
        <tr>
            <td>Darstellung:</td>
            <td>
                &nbsp;&nbsp;
                <input type="radio" name="settings" value="margin_in_per" id='r1'>
                &nbsp;<?php echo lang('margin_in_%'); ?>
                &nbsp;&nbsp;
                <input type="radio" name="settings" value="margin_in_eu" id='r2' checked='checked'>
                &nbsp;<?php echo lang('margin_in_€'); ?>
                &nbsp;&nbsp;
                <input type="radio" name="settings" value="number_ve" id='r3'>
                &nbsp;<?php echo lang('number_ve'); ?>
            </td>
        </tr>
        <tr>
            <td>Period:</td>
            <td>
                <?php $js1 = 'id="period" onChange="this.form.submit();"'; ?>
                <?php 
                    $pa[3]  = 3;
                    $pa[6]  = 6;
                    $pa[9]  = 9;
                    $pa[12] = 12;
                ?>
                <?php 
                    if(!empty($selected_period)){
                        echo form_dropdown('period', $pa, $selected_period,$js1,$class_1);
                    }
                    else {
                        echo form_dropdown('period', $pa, '-1',$js1,$class_1);
                    }
                ?>
            </td>
        </tr>
    </table>
    </fieldset>
    <?php echo form_fieldset("Filter")?>
        <?php 
            foreach($filter as $k => $v)
            {
               echo "&nbsp;&nbsp;";
               echo $v['name'];
               echo "&nbsp;";
               echo form_checkbox("filter[".$k."]",$v['id'],TRUE,$js1,$class_1);
               echo "&nbsp;&nbsp;";
            }
        ?>
    </fieldset>

</form>

    <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/overview/profit_per_agent');?>">Duidelijke selectie<?php //echo lang('clear_selection')?></a>
	<hr>

    <table class="table table-striped table-condensed" style="width:1600px;">      
	<thead>	  
            <tr display:block;>
                <th rowspan='2' style='text-align: right;width: 400px;'>
                    <?php
                    $qq = str_replace("_", " ", $select_type_overview);
                    $qq = ucfirst($qq).": ";
                    echo  $qq;
                    ?>
                
                </th>
                <th colspan="2" style='text-align: right;width: 200px;'>
                    Durschnitt 
                    <?php echo $selected_period ?>
                    Monate
                </th>
		<th colspan="2" style='text-align: right;width: 200px;'>Vor 2 Monate</th>
                <th colspan="2" style='text-align: right;width: 200px;'>Letzte Month</th>
		<th colspan="2" style='text-align: right;width: 200px;'>Diese Month</th>
                <th colspan="2" style='text-align: right;width: 200px;'>Diese Woche</th>
                <th colspan="2" style='text-align: right;width: 200px;'>Нeute</th>
            </tr>
            <tr display:block;>
                <th style='text-align: right;width: 100px;'>Umsatz</th>
                <th style='text-align: right;width: 100px;' class='agevro'>margin €</th>
                <th style='text-align: right;width: 100px;' class='agpercent'>margin %</th>
                <th style='text-align: right;width: 100px;' class='agve'>Number VE</th>
                <th style='text-align: right;width: 100px;'>Umsatz</th>
                <th style='text-align: right;width: 100px;' class='agevro'>margin €</th>
                <th style='text-align: right;width: 100px;' class='agpercent'>margin %</th>
                <th style='text-align: right;width: 100px;' class='agve'>Number VE</th>
                <th style='text-align: right;width: 100px;'>Umsatz</th>
                <th style='text-align: right;width: 100px;' class='agevro'>margin €</th>
                <th style='text-align: right;width: 100px;' class='agpercent'>margin %</th>
                <th style='text-align: right;width: 100px;' class='agve'>Number VE</th>
                <th style='text-align: right;width: 100px;'>Umsatz</th>
                <th style='text-align: right;width: 100px;' class='agevro'>margin €</th>
                <th style='text-align: right;width: 100px;' class='agpercent'>margin %</th>
                <th style='text-align: right;width: 100px;' class='agve'>Number VE</th>
                <th style='text-align: right;width: 100px;'>Umsatz</th>
                <th style='text-align: right;width: 100px;' class='agevro'>margin €</th>
                <th style='text-align: right;width: 100px;' class='agpercent'>margin %</th>
                <th style='text-align: right;width: 100px;' class='agve'>Number VE</th>
                <th style='text-align: right;width: 100px;'>Umsatz</th>
                <th style='text-align: right;width: 100px;' class='agevro'>margin €</th>
                <th style='text-align: right;width: 100px;' class='agpercent'>margin %</th>
                <th style='text-align: right;width: 100px;' class='agve'>Number VE</th>
            </tr>
	</thead>
    </table>
    <table class="table table-striped table-condensed" style="width:1600px;">
        <tbody style="display:block; height: 600px; overflow-y: auto;" >
            <?php
                /* counter setting */
                $s['profit_c'] = 0;
                $s['VE_c'] = 0;
                $s['total_warehouse_price_c'] = 0;
                $s['total_c'] = 0;
                $s['cc_c'] = 0;
                //
                $s['profit_1'] = 0;
                $s['total_warehouse_price_1'] = 0;
                $s['total_1'] = 0;
                $s['VE_1'] = 0;
                $s['cc_1'] = 0;
                //
                $s['profit_2'] = 0;
                $s['total_warehouse_price_2'] = 0;
                $s['total_2'] = 0;
                $s['VE_2'] = 0;
                $s['cc_2'] = 0;
                //
                $s['profit_12'] = 0;
                $s['total_warehouse_price_12'] = 0;
                $s['total_12'] = 0;
                $s['VE_12'] = 0;
                //
                $s['profit_week'] = 0;
                $s['VE_week'] = 0;
                $s['total_warehouse_price_week'] = 0;
                $s['total_week'] = 0;
                $s['cc_week'] = 0;
                //
                $s['profit_day'] = 0;
                $s['VE_day'] = 0;
                $s['total_warehouse_price_day'] = 0;
                $s['total_day'] = 0;
                $s['cc_day'] = 0;
                //
                $qclbase = $this->config->item('admin_folder')."/overview/turnshort/$select_type_overview/";
            ?>
            <?php foreach($profit_per_agent as $k => $v): ?>
            <tr>
                <td style='width: 400px'>
                    <?php 
                        $q = $this->config->item('admin_folder')."/overview/turnover/$select_type_overview/";
                        if(empty($k) ) $k = "Na: ";
                        switch($select_type_overview)
                        {
                            case "customer":
                                $q .= $v['customer_number'];
                                $qclb = $qclbase.$v['customer_number'];
                                break;
                            case "product":
                                $q .= rawurlencode($v['code']);
                                $qclb = $qclbase.rawurlencode($v['code']);
                                break;
                            case "country":
                                $q .= $v['country_id'];
                                $qclb = $qclbase.$v['country_id'];
                                break;
                            case "office_staff":
                                $qclb = $qclbase.$v['office_staff'];
                                $q .= $v['office_staff'];
                                break;
                            
                           
                            case "supplier":
                                if(is_null($v['supplier_id']) or $v['supplier_id'] == '') 
                                {
                                    $q .= "null";
                                    $qclb = $qclbase."null";
                                    $k .= "null";
                                }
                                else {
                                    $q .= $v['supplier_id'];
                                    $qclb = $qclbase.$v['supplier_id']; 
                                }
                                break;
                            default:
                                $q .= $v['field_service'];
                                $qclb = $qclbase.$v['field_service'];
                        }
                        echo 
                        anchor(
                            $q,
                            $k
                        ); 
                    ?>
                </td>
                <?php if(isset($v['total_12']) && $v['total_12'] != 0.0): ?>
                    <?php $s['total_12'] += $v['total_12'] ?>
                    <td style='text-align: right; width: 100px'>
                        <?php echo sprintf("%6.2f",$v['total_12'] / $selected_period); ?>
                    </td>
                <?php else: ?>
                    <td style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['profit_12']) && $v['profit_12'] != 0.0): ?>
                    <?php $s['profit_12'] += $v['profit_12'] ?>
                    <td style='text-align: right; width: 100px' class='agevro'>
                        <?php echo  sprintf("%6.2f",$v['profit_12']  / $selected_period) ?>
                    </td>
                <?php else: ?>
                    <td  class='agevro' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['total_12']) && $v['total_12'] != 0.0): ?>
                    <td style='text-align: right;width: 100px' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$v['profit_12'] / $v['total_12']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['VE_12']) && $v['VE_12'] != 0): ?>
                    <?php $s['VE_12'] += $v['VE_12'] ?>
                    <td style='text-align: right; width: 100px' class='agve'>
                        <?php echo  sprintf("%d",ceil($v['VE_12'] / 12)) ?>
                    </td>
                <?php else: ?>
                    <td  class='agve' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                <?php if(isset($v['total_2']) && $v['total_2'] != 0.0): ?>
                    <?php $s['total_2'] += $v['total_2'] ?>
                    <td style='text-align: right; width: 100px'>
                        <?php echo sprintf("%6.2f",$v['total_2']) ?>
                    </td>
                <?php else: ?>
                    <td style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['profit_2']) && $v['profit_2'] != 0.0): ?>
                    <?php $s['profit_2'] += $v['profit_2'] ?>
                    <td style='text-align: right; width: 100px'  class='agevro'>
                        <?php echo sprintf("%6.2f",$v['profit_2']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($v['total_2']) && $v['total_2'] != 0.0): ?>
                    <td style='text-align: right; width: 100px' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$v['profit_2'] / $v['total_2']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['VE_2']) && $v['VE_2'] != 0): ?>
                    <?php $s['VE_2'] += $v['VE_2'] ?>
                    <td style='text-align: right;width: 100px' class='agve'>
                        <?php echo  $v['VE_2'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                <?php if(isset($v['total_1']) && $v['total_1'] != 0.0): ?>
                    <?php $s['total_1'] += $v['total_1'] ?>
                    <td style='text-align: right;width: 100px' >
                        <?php echo  sprintf("%6.2f",$v['total_1']) ?>
                    </td>
                <?php else: ?>
                    <td style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['profit_1']) && $v['profit_1'] != 0.0): ?>
                    <?php $s['profit_1'] += $v['profit_1'] ?>
                    <td style='text-align: right;width: 100px'  class='agevro'>
                        <?php echo sprintf("%6.2f",$v['profit_1']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['total_1']) && $v['total_1'] != 0.0): ?>
                    <td style='text-align: right;width: 100px' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$v['profit_1'] / $v['total_1']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['VE_1']) && $v['VE_1'] != 0): ?>
                    <?php $s['VE_1'] += $v['VE_1'] ?>
                    <td style='text-align: right;width: 100px' class='agve'>
                        <?php echo  $v['VE_1'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                 <?php if(isset($v['total_c']) && $v['total_c'] != 0.0): ?>
                    <?php $s['total_c'] += $v['total_c'] ?>
                    <td style='text-align: right; width: 100px'>
                         <?php 
                            echo 
                            anchor(
                                $qclb,
                                sprintf("%6.2f",$v['total_c'])
                            );
                        ?>
                    </td>
                <?php else: ?>
                    <td style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($v['profit_c']) && $v['profit_c'] != 0.0): ?>
                    <?php $s['profit_c'] += $v['profit_c'] ?>
                    <td style='text-align: right; width: 100px' class='agevro'>
                        <?php echo sprintf("%6.2f",$v['profit_c']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['total_c']) && $v['total_c'] != 0.0): ?>
                    <td style='text-align: right; width: 100px' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$v['profit_c'] / $v['total_c']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?> 
                <?php if(isset($v['VE_c']) && $v['VE_c'] != 0): ?>
                    <?php $s['VE_c'] += $v['VE_c'] ?>
                    <td style='text-align: right; width: 100px' class='agve'>
                        <?php echo  $v['VE_c'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                 <?php if(isset($v['total_week']) && $v['total_week'] != 0.0): ?>
                    <?php $s['total_week'] += $v['total_week'] ?>
                    <td style='text-align: right; width: 100px'>
                        <?php 
                            echo 
                            anchor(
                                $qclb,
                                sprintf("%6.2f",$v['total_week']) 
                            );
                        ?>
                    </td>
                <?php else: ?>
                    <td style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($v['profit_week']) && $v['profit_week'] != 0.0): ?>
                    <?php $s['profit_week'] += $v['profit_week'] ?>
                    <td style='text-align: right; width: 100px' class='agevro'>
                        <?php echo sprintf("%6.2f",$v['profit_week']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['total_week']) && $v['total_week'] != 0.0): ?>
                    <td style='text-align: right; width: 100px' class='agpercent'>
                        <?php 
                            echo  sprintf("%6.2f",100*$v['profit_week'] / $v['total_week']) 
                        ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?> 
                <?php if(isset($v['VE_week']) && $v['VE_week'] != 0): ?>
                    <?php $s['VE_week'] += $v['VE_week'] ?>
                    <td style='text-align: right; width: 100px' class='agve'>
                        <?php echo  $v['VE_week'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                 <?php if(isset($v['total_day']) && $v['total_day'] != 0.0): ?>
                    <?php $s['total_day'] += $v['total_day'] ?>
                    <td style='text-align: right; width: 100px'>
                        <?php echo sprintf("%6.2f",$v['total_day']) ?>
                    </td>
                <?php else: ?>
                    <td style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($v['profit_day']) && $v['profit_day'] != 0.0): ?>
                    <?php $s['profit_week'] += $v['profit_day'] ?>
                    <td style='text-align: right; width: 100px' class='agevro'>
                        <?php echo sprintf("%6.2f",$v['profit_day']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['total_day']) && $v['total_day'] != 0.0): ?>
                    <td style='text-align: right; width: 100px' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$v['profit_day'] / $v['total_day']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?> 
                <?php if(isset($v['VE_day']) && $v['VE_day'] != 0): ?>
                    <?php $s['VE_day'] += $v['VE_day'] ?>
                    <td style='text-align: right; width: 100px' class='agve'>
                        <?php echo  $v['VE_day'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
            <!-- total row -->
            <tr style="text-weight:bold">
                <td style='text-align: right;  width:400px;'>Total: </td>
                <?php if(isset($s['total_12']) && $s['total_12'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;'>
                        <?php echo sprintf("%6.2f",$s['total_12'] / $selected_period); ?>
                    </td>
                <?php else: ?>
                    <td  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['profit_12']) && $s['profit_12'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;' class='agevro'>
                        <?php echo  sprintf("%6.2f",$s['profit_12']  / $selected_period) ?>
                    </td>
                <?php else: ?>
                    <td  class='agevro'  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['total_12']) && $s['total_12'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$s['profit_12'] / $s['total_12']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent'  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['VE_12']) && $s['VE_12'] != 0): ?>
                    <td style='text-align: right;  width:100px;' class='agve'>
                        <?php echo  sprintf("%d",$s['VE_12'] / 12) ?>
                    </td>
                <?php else: ?>
                    <td  class='agve'  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                <?php if(isset($s['total_2']) && $s['total_2'] != 0.0): ?>
                   <td style='text-align: right;  width:100px;'>
                        <?php echo sprintf("%6.2f",$s['total_2']) ?>
                    </td>
                <?php else: ?>
                    <td  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['profit_2']) && $s['profit_2'] != 0.0): ?>
                     <td style='text-align: right;   width:100px;'  class='agevro'>
                        <?php echo sprintf("%6.2f",$s['profit_2']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro'  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($s['total_2']) && $s['total_2'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$s['profit_2'] / $s['total_2']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent'  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['VE_2']) && $s['VE_2'] != 0): ?>
                    <td style='text-align: right;  width:100px;' class='agve'>
                        <?php echo  $s['VE_2'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve'  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                <?php if(isset($s['total_1']) && $s['total_1'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;' >
                        <?php echo  sprintf("%6.2f",$s['total_1']) ?>
                    </td>
                <?php else: ?>
                    <td  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['profit_1']) && $s['profit_1'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;'  class='agevro'>
                        <?php echo sprintf("%6.2f",$s['profit_1']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro'  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['total_1']) && $s['total_1'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$s['profit_1'] / $s['total_1']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent'  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['VE_1']) && $s['VE_1'] != 0): ?>
                     <td style='text-align: right;  width:100px;' class='agve'>
                        <?php echo  $s['VE_1'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve'  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                 <?php if(isset($s['total_c']) && $s['total_c'] != 0.0): ?>
                     <td style='text-align: right;  width:100px;'>
                        <?php echo sprintf("%6.2f",$s['total_c']) ?>
                    </td>
                <?php else: ?>
                    <td  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($s['profit_c']) && $s['profit_c'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;' class='agevro'>
                        <?php echo sprintf("%6.2f",$s['profit_c']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro' style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['total_c']) && $s['total_c'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$s['profit_c'] / $s['total_c']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent' style="width:100px;">&nbsp;</td>
                <?php endif; ?> 
                <?php if(isset($s['VE_c']) && $s['VE_c'] != 0): ?>
                    <td style='text-align: right;  width:100px;' class='agve'>
                        <?php echo  $s['VE_c'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve' style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                <?php if(isset($s['total_week']) && $s['total_week'] != 0.0): ?>
                    <td style='text-align: right; width: 100px'>
                        <?php echo sprintf("%6.2f",$s['total_week']) ?>
                    </td>
                <?php else: ?>
                    <td style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($s['profit_week']) && $s['profit_week'] != 0.0): ?>
                    <td style='text-align: right; width: 100px' class='agevro'>
                        <?php echo sprintf("%6.2f",$s['profit_week']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['total_week']) && $s['total_week'] != 0.0): ?>
                    <td style='text-align: right; width: 100px' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$s['profit_week'] / $s['total_week']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?> 
                <?php if(isset($s['VE_week']) && $s['VE_week'] != 0): ?>
                    <td style='text-align: right; width: 100px' class='agve'>
                        <?php echo  $s['VE_week'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <!-- -->
                 <?php if(isset($s['total_day']) && $s['total_day'] != 0.0): ?>
                     <td style='text-align: right; width: 100px'>
                        <?php echo sprintf("%6.2f",$s['total_day']) ?>
                    </td>
                <?php else: ?>
                    <td style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($s['profit_day']) && $s['profit_day'] != 0.0): ?>
                    <?php $s['profit_week'] += $s['profit_day'] ?>
                    <td style='text-align: right; width: 100px' class='agevro'>
                        <?php echo sprintf("%6.2f",$s['profit_day']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['total_day']) && $s['total_day'] != 0.0): ?>
                    <td style='text-align: right; width: 100px' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$s['profit_day'] / $s['total_day']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?> 
                <?php if(isset($s['VE_day']) && $s['VE_day'] != 0): ?>
                    <td style='text-align: right; width: 100px' class='agve'>
                        <?php echo  $s['VE_day'] ?>
                    </td>
                <?php else: ?>
                    <td  class='agve' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
            </tr>
        </tbody>
    </table>
<?php include('footer.php'); ?>