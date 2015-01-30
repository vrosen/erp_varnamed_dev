<?php 
    $class_1 = 'class = span3';
    $showByOptions = array(
        'All Sales'  => 'All Sales' ,
        'customers' => lang('customer'),
        'agents'    => lang('field_service'),
        'products'  => lang('product'),
        'country'   => lang('country')
    );
?>
<?php include('header.php'); ?>
<?php echo form_open($this->config->item('admin_folder').'/overview/turnover');?>
    <?php $js = 'id="showBy" onChange="this.form.submit();"'; ?>
    <?php echo form_fieldset(lang('showBy'))?>
    <?php if(!empty($showBy)): ?>
        <?php echo form_dropdown('showBy', $showByOptions, $showBy,$js,$class_1) ?>
   <?php else: ?>
        <?php echo form_dropdown('showBy', $showByOptions, '-1',$js,$class_1); ?>
     <?php endif; ?>
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
        </table>
    </fieldset>
    <?php echo form_fieldset("Filter")?>
        <?php $js1 = 'id="filter" onChange="this.form.submit();"'; ?>
        <?php 
            foreach($filter as $k => $v)
            {
               echo "&nbsp;&nbsp;";
               echo $v['name'];
               echo "&nbsp;";
               echo form_checkbox("filterModel[".$k."]",$v['id'],TRUE,$js1,$class_1);
               echo "&nbsp;&nbsp;";
            }
        ?>
    </fieldset>
</form>
<hr/>

    <table class="table table-striped table-condensed" style="width:1600px;">      
	<thead>	  
            <tr display:block;>
                <th rowspan='2' style='text-align: right;width: 400px;'>
                    <?php
                    if($showBy)
                        $qq = str_replace("_", " ", $showBy);
                    else 
                        $qq = "All Sales";
                    $qq = ucfirst($qq).": ";
                    echo  $qq;
                    ?>
                
                </th>
                <th colspan="2" style='text-align: right;width: 200px;'>
                    Durschnitt 12 Monate
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
                $s['profit'] = 0;
                $s['VE'] = 0;
                $s['total_warehouse_price'] = 0;
                $s['total'] = 0;
                //
                $s['profit_1'] = 0;
                $s['total_warehouse_price_1'] = 0;
                $s['total_1'] = 0;
                $s['VE_1'] = 0;
                //
                $s['profit_2'] = 0;
                $s['total_warehouse_price_2'] = 0;
                $s['total_2'] = 0;
                $s['VE_2'] = 0;
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
                //
                $s['profit_day'] = 0;
                $s['VE_day'] = 0;
                $s['total_warehouse_price_day'] = 0;
                $s['total_day'] = 0;
                //
            ?>
            <?php foreach($res as $k => $v): ?>
            <tr>
                <td style='width: 400px'>
                    <?php 
                        $q = $this->config->item('admin_folder')."/overview/turnover/$showBy/".$k;
                        echo anchor( $q, $v['title']); 
                    ?>
                </td>
                <?php if(isset($v['total_12']) && $v['total_12'] != 0.0): ?>
                    <?php $s['total_12'] += $v['total_12'] ?>
                    <td style='text-align: right; width: 100px'>
                        <?php echo sprintf("%6.2f",$v['total_12'] ); ?>
                    </td>
                <?php else: ?>
                    <td style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['profit_12']) && $v['profit_12'] != 0.0): ?>
                    <?php $s['profit_12'] += $v['profit_12'] ?>
                    <td style='text-align: right; width: 100px' class='agevro'>
                        <?php echo  sprintf("%6.2f",$v['profit_12']) ?>
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
                 <?php if(isset($v['total']) && $v['total'] != 0.0): ?>
                    <?php $s['total'] += $v['total'] ?>
                    <td style='text-align: right; width: 100px'>
                         <?php 
                            echo sprintf("%6.2f",$v['total']);
                        ?>
                    </td>
                <?php else: ?>
                    <td style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($v['profit']) && $v['profit'] != 0.0): ?>
                    <?php $s['profit'] += $v['profit'] ?>
                    <td style='text-align: right; width: 100px' class='agevro'>
                        <?php echo sprintf("%6.2f",$v['profit']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['total']) && $v['total'] != 0.0): ?>
                    <td style='text-align: right; width: 100px' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$v['profit'] / $v['total']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?> 
                <?php if(isset($v['VE']) && $v['VE'] != 0): ?>
                    <?php $s['VE'] += $v['VE'] ?>
                    <td style='text-align: right; width: 100px' class='agve'>
                        <?php echo  $v['VE'] ?>
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
                        <?php echo sprintf("%6.2f",$s['total_12']); ?>
                    </td>
                <?php else: ?>
                    <td  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['profit_12']) && $s['profit_12'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;' class='agevro'>
                        <?php echo  sprintf("%6.2f",$s['profit_12']) ?>
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
                 <?php if(isset($s['total']) && $s['total'] != 0.0): ?>
                     <td style='text-align: right;  width:100px;'>
                        <?php echo sprintf("%6.2f",$s['total']) ?>
                    </td>
                <?php else: ?>
                    <td  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($s['profit']) && $s['profit'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;' class='agevro'>
                        <?php echo sprintf("%6.2f",$s['profit']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro' style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['total']) && $s['total'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$s['profit'] / $s['total']) ?>
                    </td>
                <?php else: ?>
                    <td  class='agpercent' style="width:100px;">&nbsp;</td>
                <?php endif; ?> 
                <?php if(isset($s['VE']) && $s['VE'] != 0): ?>
                    <td style='text-align: right;  width:100px;' class='agve'>
                        <?php echo  $s['VE'] ?>
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