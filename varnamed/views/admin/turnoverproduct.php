<?php 

    $class_1 = 'class = span3';
    for ($i = 1; $i < 13; $i++) {
        $m = sprintf("%02d", $i);
        $monthName = date("F", mktime(0, 0, 0, $m, 10));
        $mArray[$m] = $monthName;
    }

    $yArray = array();
    for ($i = 0, $y = date('Y'); $i < 10; $i++, $y--) {
        $yArray[$y] = $y;
    }
?>
<?php include('header.php'); ?>

	
<?php echo form_open(current_url());?>
    <?php $js = 'id="agent" onChange="this.form.submit();"'; ?>
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
            <td>Select Month / Year:</td>
            <td>
                <?php $js1 = 'id="period" onChange="this.form.submit();"'; ?>
                <?php 
                    if(!empty($month)){
                        echo form_dropdown('month', $mArray, $month,$js1,$class_1);
                    }
                    else {
                        echo form_dropdown('month', $mArray, -1,$js1,$class_1);
                    }
                ?>
                &nbsp;&nbsp;&nbsp;
                <?php 
                    if(!empty($year)){
                        echo form_dropdown('year', $yArray, $year,$js1,$class_1);
                    }
                    else {
                        echo form_dropdown('year', $yArray, -1,$js1,$class_1);
                    }
                ?>
            </td>
        </tr>
    </table>
    </fieldset>
</form
<P><BR/></P>
<?php if(isset($bc) && is_array($bc)): ?>
    <?php $bcs = "" ?>
    <?php foreach($bc as $b): ?>
        <?php
        ///////////////////////////////////////////////////
            if($bcs) $bcs .= "&#8594;";
            $bcs .= $b;
        ?>
    <?php endforeach; ?>
    <?php echo $bcs; ?>
     <P><BR/></P>
<?php endif; ?>
<hr/>
<table class="table table-striped table-condensed" style="width:900px;">      
    <thead>	  
        <tr style='display:block;'>
            <th  style='text-align: left;width: 400px;'>
                <?php echo ucfirst($showBy) ?>
            </th>
            <th style='text-align: right;width: 100px;'>no. contr.</th>
            <th style='text-align: right;width: 100px;'>no. unit.</th>
            <th style='text-align: right;width: 100px;'>Order</th>
            <th style='text-align: right;width: 100px;'>purchase</th>
            <th style='text-align: right;width: 100px;' class='agevro'>margin €</th>
            <th style='text-align: right;width: 100px;' class='agpercent'>margin %</th>
            <th style='text-align: right;width: 100px;' class='agve'>Number VE</th>
        </tr>
    </thead>
</table>
<table class="table table-striped table-condensed" style="width:1800px;">
    <tbody style="display:block; height: 600px; overflow-y: auto;" >
        <?php
            /* counter setting */
            $s['profit'] = 0;
            $s['VE'] = 0;
            $s['total_warehouse_price'] = 0;
            $s['ncontracts'] = 0;
            $s['quantity'] = 0;
            $s['total'] = 0;
        ?>
        <?php if(!empty($res)): ?>
        <?php foreach($res as $k => $v): ?>
            <tr>
                <td style='width: 400px'>
                    <?php 
                        $a  = "<a href='";
                        $a .= site_url($this->config->item('admin_folder').'/overview/products/'.$showBy."/".$v['qid']."/w");
                        $a .= "'>";
                        $a .= $v['title'];
                        $a .= "</a>";
                        echo $a;
                    ?>
                </td>
                <!-- -->
                <?php
                    if($v['total_warehouse_price'])
                        $s['total_warehouse_price'] += $v['total_warehouse_price'];
                    if($v['ncontracts'])
                        $s['ncontracts'] += $v['ncontracts'];
                    if($v['quantity'])
                        $s['quantity'] += $v['quantity'];
                ?>
                <td style='text-align: right; width: 100px'>
                    <?php echo $v['ncontracts']; ?>
                </td>
                <td style='text-align: right; width: 100px'>
                    <?php echo $v['quantity']; ?>
                </td>
                 <?php if(isset($v['total']) && $v['total'] != 0.0): ?>
                    <?php 
                        $s['total'] += $v['total'];  
                    ?>
                    <td style='text-align: right; width: 100px'>
                        <?php echo sprintf("%6.2f",$v['total']) ?>
                    </td>
                <?php else: ?>
                    <td style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <td style='text-align: right; width: 100px'>
                    <?php echo sprintf("%6.2f",$v['total_warehouse_price']) ?>
                </td>
                 <?php if(isset($v['profit']) && $v['profit'] != 0.0): ?>
                    <?php $s['profit'] += $v['profit'] ?>
                    <td style='text-align: right; width: 100px' class='agevro'>
                        <?php echo sprintf("%6.2f",$v['profit']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro' style='text-align: right;  width:100px;'>&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($v['total_warehouse_price']) && $v['total_warehouse_price'] != 0.0): ?>
                    <td style='text-align: right; width: 100px' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$v['profit'] / $v['total_warehouse_price']) ?>
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
            </tr>
        <?php endforeach; ?>
        <?php endif; ?>
            <!-- total row -->
            <tr style="text-weight:bold">
                <td style='text-align: right;  width:400px;'>Total: </td>
                <!-- -->
                <?php if(isset($s['ncontracts']) && $s['ncontracts'] != 0.0): ?>
                     <td style='text-align: right;  width:100px;'>
                        <?php echo $s['ncontracts'] ?>
                    </td>
                <?php else: ?>
                    <td  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($s['quantity']) && $s['quantity'] != 0.0): ?>
                     <td style='text-align: right;  width:100px;'>
                        <?php echo $s['quantity'] ?>
                    </td>
                <?php else: ?>
                    <td  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($s['total']) && $s['total'] != 0.0): ?>
                     <td style='text-align: right;  width:100px;'>
                        <?php echo sprintf("%6.2f",$s['total']) ?>
                    </td>
                <?php else: ?>
                    <td  style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['total_warehouse_price']) && $s['total_warehouse_price'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;' class='agevro'>
                        <?php echo sprintf("%6.2f",$s['total_warehouse_price']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro' style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                 <?php if(isset($s['profit']) && $s['profit'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;' class='agevro'>
                        <?php echo sprintf("%6.2f",$s['profit']) ?>
                    </td>
                <?php else: ?>
                    <td class='agevro' style="width:100px;">&nbsp;</td>
                <?php endif; ?>
                <?php if(isset($s['total_warehouse_price']) && $s['total_warehouse_price'] != 0.0): ?>
                    <td style='text-align: right;  width:100px;' class='agpercent'>
                        <?php echo  sprintf("%6.2f",100*$s['profit'] / $s['total_warehouse_price']) ?>
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
            </tr>
    </tbody>
</table>
<?php include('footer.php'); ?>