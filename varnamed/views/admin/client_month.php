<?php include('header.php'); ?>
<?php echo form_open($this->config->item('admin_folder') . '/overview/client/' . $id); ?>
<?php $js = 'id="client" onChange="this.form.submit();"'; ?>
<?php echo form_fieldset('Select Period') ?>
<?php
$mArray = array();
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
<?php echo form_dropdown('month', $mArray, $month, $js, 'class = span3'); ?>
&nbsp; &nbsp;	
<?php echo form_dropdown('year', $yArray, $year, $js, 'class = span3'); ?>
<p><br /></p>
<legend>
    <?php echo $id ?>
    &nbsp;
    &nbsp;
    <?php if(isset($customer['company'])) echo $customer['company'] ; ?>
</legend>
</fieldset>
<hr/>

<table class="table table-striped table-condensed" style="width:1210px">      
    <thead >	  
        <tr style="display:block;">
            <th style="width: 500px;">Artikel</th>
            <th style='text-align: right;  width:100px;'>no. contr.</th>
            <th style='text-align: right;  width:100px;'>no. units</th>
            <th style='text-align: right;  width:100px;'>Order</th>
            <th style='text-align: right;  width:100px;'>purchase</th>
            <th style='text-align: right;  width:100px;'>profit</th>
            <th style='text-align: right;  width:100px;'>margin</th>
            <th style='text-align: right;  width:100px;'>dispatch cost</th>
        </tr>
    </thead>
    <tbody style="display:block; height: 600px; overflow-y: auto; ">
        <?php
        $s['cc'] = 0;
        $s['VE'] = 0;
        $s['total'] = 0;
        $s['total_warehouse_price'] = 0;
        $s['profit'] = 0;
        
        ?>
        <?php foreach ($res as $k => $v): ?>
            <?php
            $s['cc'] += $v['cc'];
            $s['VE'] += $v['VE'];
            $s['total'] += $v['total'];
            $s['total_warehouse_price'] += $v['total_warehouse_price'];
            $s['profit'] += $v['profit'];
            
            ?>
            <tr>
                <td style="width: 500px;">
                    <?php 
                         echo 
                        anchor(
                            $this->config->item('admin_folder').'/overview/product/'.$v['code'],
                            $v['code']
                        ); 
                        if(isset($v['id']) && $v['id'])
                        {
                            echo "<br/>" ;
                            echo 
                            anchor(
                                $this->config->item('admin_folder').'/products/form/'.$v['id'],
                                $v['name']
                            ); 
                        } 
                    ?>
                </td>
                <td style='text-align: right; width:100px;'>
                    <?php echo $v['cc'] ?>
                </td>
                <td style='text-align: right;  width:100px; '>
                    <?php echo $v['VE'] ?>
                </td>
                <td style='text-align: right;  width:100px; '>
                    <?php echo sprintf("%.2f", $v['total']) ?>
                </td>
                <td style='text-align: right;  width:100px; '>
                    <?php echo sprintf("%.2f", $v['total_warehouse_price']) ?>
                </td>
                <td style='text-align: right;  width:100px; '>
                    <?php echo sprintf("%.2f", $v['profit']) ?>
                </td>
                <td style='text-align: right;  width:100px; '>
                    <?php if ($v['total'] != 0.0): ?>
                        <?php echo sprintf("%.2f", $v['profit'] * 100.0 / $v['total']) ?>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
                <td style='text-align: right;  width:100px; '>
                    &nbsp;
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td style="width: 500px;font-weight:bold;">
                Total:
            </td>
            <td style='text-align: right; width:100px;font-weight:bold;'>
                <?php echo $s['cc'] ?>
            </td>
            <td style='text-align: right;  width:100px;font-weight:bold; '>
                <?php echo $s['VE'] ?>
            </td>
            <td style='text-align: right;  width:100px;font-weight:bold; '>
                <?php echo sprintf("%.2f", $s['total']) ?>
            </td>
            <td style='text-align: right;  width:100px;font-weight:bold; '>
                <?php echo sprintf("%.2f", $s['total_warehouse_price']) ?>
            </td>
            <td style='text-align: right;  width:100px;font-weight:bold; '>
                <?php echo sprintf("%.2f", $s['profit']) ?>
            </td>
            <td style='text-align: right;  width:100px;font-weight:bold; '>
                <?php if ($s['total'] != 0.0): ?>
                    <?php echo sprintf("%.2f", $s['profit'] * 100.0 / $s['total']) ?>
                <?php else: ?>
                    &nbsp;
                <?php endif; ?>
            </td>
            <td style='text-align: right;  width:100px;font-weight:bold; '>
                n. a.
            </td>
        </tr>
    </tbody>
</table>
<?php include('footer.php'); ?>
