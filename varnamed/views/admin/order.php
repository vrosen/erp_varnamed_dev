<?php include('header.php'); ?>

<?php
$order_type_array = array(
    '0' => lang('select_order_method'),
    'instant_delivery' => lang('instant_delivery'),
    'fixdate' => lang('fixdate'),
    'direct_delivery' => lang('direct_delivery'),
    'complete_delivery' => lang('complete_delivery'),
    'rent' => lang('rent'),
    'recipe' => lang('recipe'),
    'sample_delivery' => lang('sample_delivery'),
    'rent_to_own' => lang('rent_to_own'),
);
$condition = array(
    '0' => lang('select_delivery_condition'),
    '1' => lang('free_shipment'),
    '2' => lang('calculate_shipment'),
);
$dispatch = array(
    '0' => lang('select_dispatch_metthod'),
    'Selbstauslieferung' => lang('self_delivery'),
    'Spedition' => lang('parcel_service'),
    'Sonstiges (sehe Vereinbarungen)' => lang('miscellaneous')
);

if ($current_shop == 1) {
    $warehouse = array(
        '0' => lang('select_warehouse'),
        '3' => lang('commbiwerk'),
        '2' => lang('transoflex')
    );
}
if ($current_shop == 2) {
    $warehouse = array(
        '0' => lang('select_warehouse'),
        '3' => lang('dutchblue'),
        '2' => lang('transoflex')
    );
}
if ($current_shop == 3) {
    $warehouse = array(
        '0' => lang('select_warehouse'),
        '3' => 'Glovers',
        '2' => lang('transoflex')
    );
}
if ($current_shop == 1) {
    $payment_method_array = array(
        '0' => lang('select_payment_method'),
        '1' => lang('invoice_upon_delivery'),
        '2' => lang('direct_debit'),
        '3' => lang('paid_in_advance'),
        '4' => lang('iDEAL'),
        '6' => lang('American_Express'),
        '7' => lang('MasterCard'),
        '8' => lang('VISA'),
        '9' => lang('instant_wire_transfer'),
        '10' => lang('Giropay'),
        '11' => lang('EPS'),
        '12' => lang('PAYPAL'),
        '5' => lang('free_sample_delivery'),
        '13' => lang('comforties_com_BV_account'), //set the shop variable
        '14' => lang('by_cheque'),
    );
}
if ($current_shop == 2) {
    $payment_method_array = array(
        '0' => lang('select_payment_method'),
        '1' => lang('invoice_upon_delivery'),
        '2' => lang('direct_debit'),
        '3' => lang('paid_in_advance'),
        '4' => lang('iDEAL'),
        '6' => lang('American_Express'),
        '7' => lang('MasterCard'),
        '8' => lang('VISA'),
        '9' => lang('instant_wire_transfer'),
        '10' => lang('Giropay'),
        '11' => lang('EPS'),
        '12' => lang('PAYPAL'),
        '5' => lang('free_sample_delivery'),
        '13' => lang('dutchblue_com_BV_account'), //set the shop variable
        '14' => lang('by_cheque'),
    );
}

$currency_array = array(
    'EUR' => 'EUR',
    'USD' => 'USD'
);

//$vat_arr = array('0' => '0',$vat => $vat);

$carrier_array = array(
    'dpd' => 'DPD',
    'transoflex' => 'Transoflex',
    'post' => 'Post',
    'dpd-monster' => 'DPD-Monster',
);

$picking_agents = array(
    '0' => lang('select_agent'),
    '1' => 'agent_1',
    '2' => 'agent_2',
    '3' => 'agent_3',
    '4' => 'agent_4',
    '5' => 'agent_5',
    '6' => 'agent_6',
);
$monitoring_agents = array(
    '0' => lang('select_agent'),
    '1' => 'agent_1',
    '2' => 'agent_2',
    '3' => 'agent_3',
    '4' => 'agent_4',
    '5' => 'agent_5',
    '6' => 'agent_6',
);
$payment_condition_array = array(
    '0' => lang('select_payment_condition'),
    '1' => lang('30_without_deduction'),
    '3' => lang('8_without_deduction'),
    '4' => lang('immediately_without_deduction'),
    '5' => lang('42_without_deduction'),
);

$no_num = $this->session->flashdata('no_num');
if (!empty($no_num)) {
    echo $no_num;
}
?>
<?php echo form_open($this->config->item('admin_folder') . '/orders/submit_invoice_temp/' . $order->id . '/' . $order->order_number, 'class="form-inline"'); ?>
<tr style="font-size: 12px; ">
    <td><input type="text" placeholder="invoice number" name="invoice_number"  /></td>
</tr>
<input type="submit" class="btn btn-primary btn-small" value="<?php echo lang('create_invoice'); ?>"/>
</form>

<?php
if (!$order->BACKORDER == 1) {
    echo form_open($this->config->item('admin_folder') . '/orders/update/' . $order->id, 'class="form-inline"');
} else {
    echo form_open($this->config->item('admin_folder') . '/orders/update/' . $order->id, 'class="form-inline"');
}
?> 



<div class="panel panel-default" style="width: 100%; float: left;">
    <div class="panel-heading"><?php echo lang('new_shippments'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
    </div>
    <div class="panel-body">
        <table class="table table-striped" style="border: 1px solid #ddd;">
            <thead>
            </thead>
            <tbody>
            <td>
<?php echo $order->customer_number; ?>&nbsp;
<?php
//echo $NR;
if (!empty($id)) {
    ?><a href="<?php echo @site_url($this->config->item('admin_folder') . '/customers/form/' . $id); ?>"><?php echo $order->company . '&nbsp;&nbsp;&nbsp;' . $order->firstname . '&nbsp;' . $order->lastname; ?></a><?php
} else {
    ?><a href="<?php echo @site_url($this->config->item('admin_folder') . '/customers/form/' . $NR); ?>"><?php echo $order->company . '&nbsp;&nbsp;&nbsp;' . $order->firstname . '&nbsp;' . $order->lastname; ?></a><?php
}
?>

            </td>

            <tr style="font-size: 12px; ">
                <td><strong><?php echo lang('order_number'); ?></strong></td>
                <td><strong><?php echo $order->order_number; ?></strong></td>
            <input name="order_number" value="<?php echo $order->order_number; ?>" type="hidden" />
            <input name="order_nr" value="<?php echo $order->NR; ?>" type="hidden" />

            </tr>
            <tr style="font-size: 12px; ">
                <td><strong><?php echo lang('customer_order_number'); ?></strong></td>
                <td><?php echo $order->customer_order_number; ?></td>
            </tr>
            <tr  style="font-size: 12px; ">
                <td><strong><?php echo lang('contact_person'); ?></strong></td>
                <td><?php echo $order->contact_person; ?></td>
            </tr>
            <tr  style="font-size: 12px; ">


            <input name="customer_id" value="<?php echo $order->customer_id; ?>" type="hidden" />
            <input name="customer_number" value="<?php echo $order->customer_number; ?>" type="hidden" />
            <input name="firstname" value="<?php echo $order->firstname; ?>" type="hidden" />
            <input name="lastname" value="<?php echo $order->lastname; ?>" type="hidden" />
            <input name="company" value="<?php echo $order->company; ?>" type="hidden" />
            </tr>
            <tr   style="font-size: 12px; ">
                <td><strong><?php echo lang('order_type'); ?></strong></td>
<?php
if (empty($order->order_type)) {
    ?><td><?php echo form_dropdown('order_type', $order_type_array, 'instant_delivery'); ?>&nbsp;
                        <input id="start_top" name="order_type_date" value="<?php echo $order->order_type_date ?>" type="text" placeholder="date of order"/></td><?php
} else {
    ?><td><?php echo form_dropdown('order_type', $order_type_array, $order->order_type); ?>&nbsp;
                        <input id="start_top" name="order_type_date" value="<?php echo $order->order_type_date ?>" type="text" placeholder="date of order"/></td><?php
}
?>
            </tr>
            <tr   style="font-size: 12px; ">
                <td><strong><?php echo lang('delivery_condition'); ?></strong></td>
                <td><?php echo form_dropdown('delivery_condition', $condition, $order->delivery_condition); ?></td>
            </tr>


            <tr   style="font-size: 12px; ">
                <?php
                if (empty($order->shipping_method)) {
                    ?><td><strong><?php echo lang('dispatch_method'); ?></strong></td>
                    <td><?php echo form_dropdown('dispatch_method', $dispatch, 'Spedition'); ?></td><?php
                } else {
                    ?>
                    <td><strong><?php echo lang('dispatch_method'); ?></strong></td>
                    <td><?php echo form_dropdown('dispatch_method', $dispatch, $order->shipping_method); ?></td><?php
                }
                ?>
            </tr>
            <tr   style="font-size: 12px; ">
<?php
if (empty($order->warehouse)) {
    ?><td><strong><?php echo lang('warehouse'); ?></strong></td>
                    <td><?php echo form_dropdown('warehouse', $warehouse, '3'); ?></td><?php
} else {
    ?><td><strong><?php echo lang('warehouse'); ?></strong></td>
                    <td><?php echo form_dropdown('warehouse', $warehouse, $order->warehouse); ?></td><?php
                }
                ?>
            </tr>
            <tr   style="font-size: 12px; ">
                <td><strong><?php echo lang('payment_method'); ?></strong></td>
<?php if (!empty($order->payment_method)): ?>
                    <td><?php echo form_dropdown('payment_method', $payment_method_array, $order->payment_method); ?></td>
                <?php endif; ?>
            </tr>
            <tr   style="font-size: 12px; ">
                <td><strong><?php echo lang('payment_condition'); ?></strong></td>
                <td>                        
                <?php
                if (empty($order->payment_condition)) {
                    echo form_dropdown('delivery_condition', $payment_condition_array, '4');
                } else {
                    echo form_dropdown('delivery_condition', $payment_condition_array, $order->payment_condition);
                }
                ?></td>
            </tr>
            <tr   style="font-size: 12px; ">
                <td><strong><?php echo lang('none_VAT'); ?></strong></td>
<?php
if ($order->none_vat == 0) {
    $none_VAT = array('name' => 'none_VAT', 'id' => 'none_VAT', 'value' => '0', 'checked' => false, 'style' => 'margin:10px',);
    ?>
                    <td><?php echo form_checkbox($none_VAT); ?></td> <?php
                } else {
                    $none_VAT = array('name' => 'none_VAT', 'id' => 'none_VAT', 'value' => '1', 'checked' => TRUE, 'style' => 'margin:10px',);
                    ?>
                    <td><?php echo form_checkbox($none_VAT); ?></td> <?php
                }
                ?>
            </tr>
            <tr   style="font-size: 12px; ">
                <td><strong><?php echo lang('not_remind'); ?></strong></td>
                    <?php
                    if ($order->not_remind == 0) {
                        $not_warn = array('name' => 'not_warn', 'id' => 'not_warn', 'value' => '0', 'checked' => false, 'style' => 'margin:10px',);
                        ?>
                    <td><?php echo form_checkbox($not_warn); ?></td> <?php
                } else {
                    $not_warn = array('name' => 'not_warn', 'id' => 'not_warn', 'value' => '1', 'checked' => TRUE, 'style' => 'margin:10px',);
                    ?>
                    <td><?php echo form_checkbox($not_warn); ?></td><?php
                }
                ?>
            </tr>
            <tr   style="font-size: 12px; ">
                <td><strong><?php echo lang('invoice_per_email'); ?></strong></td>
                <?php
                if ($order->invoice_per_email == 0) {
                    $invoice_per_email = array('name' => 'invoice_per_email', 'id' => 'invoice_per_email', 'value' => '0', 'checked' => false, 'style' => 'margin:10px',);
                    ?>
                    <td><?php echo form_checkbox($invoice_per_email); ?></td><?php
            } else {
                $invoice_per_email = array('name' => 'invoice_per_email', 'id' => 'invoice_per_email', 'value' => '1', 'checked' => TRUE, 'style' => 'margin:10px',);
                    ?>
                    <td><?php echo form_checkbox($invoice_per_email); ?></td><?php
            }
                ?>
            </tr>
            <tr   style="font-size: 12px; ">
                <td><?php echo lang('email_adresse'); ?></td>
                <?php $email_address = array('name' => 'email', 'id' => 'email', 'type' => 'text', 'value' => set_value('email', $order->email)); ?>
                <td><?php echo form_input($email_address); ?></td>
            </tr>             
            <tr   style="font-size: 12px; ">
                <td><?php echo lang('currency'); ?></td>
                <td><?php echo form_dropdown('currency', $currency_array, $order->currency, 'class="span2"'); ?></td>
            </tr>    
            <tr   style="font-size: 12px; ">
                <td><?php echo lang('order_entry'); ?></td>
                <td>
                <?php
                if (empty($order->entered_by) and $order->WEBSHOP == 1) {
                    echo lang('allone');
                } else {
                    echo $order->entered_by;
                }
                ?>
                    <input type='hidden' name='agent' value='<?php echo $order->entered_by; ?>'>
                </td>
            </tr>                 
            <tr   style="font-size: 12px; ">
                <td><?php echo lang('order_date'); ?></td>
                <td><input id="order_date" name="order_date" value="<?php echo set_value('order_date', $order->ordered_on); ?>" type="text" /></td>
            <script>$('#order_date').datepicker({dateFormat: 'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
            </tr>                 
            <tr   style="font-size: 12px; ">
                <td><strong><?php echo lang('order_status'); ?></strong></td>
                <td>
                    <?php
                    if ($order->status == 0) {
                        echo lang('new_order');
                    }
                    if ($order->status == 1) {
                        echo lang('warehouse_order');
                    }
                    if ($order->status == 2) {
                        echo lang('ready_order');
                    }
                    if ($order->status == 3) {
                        echo lang('shipped_order');
                    }
                    ?>
                </td>
            </tr>
            <tr   style="font-size: 12px; ">
                <td><strong><?php echo lang('carrier'); ?></strong></td>
                <td><?php echo form_dropdown('carrier', $carrier_array, $order->carrier, 'class="span3"'); ?></td>
            </tr>

                    <?php
                    if ($order->status == '1') {
                        ?>
                <tr   style="font-size: 12px; ">
                    <td><strong><?php echo lang('order_picking_costs'); ?></strong></td>
                    <td><input type="text" name="order_picking_costs" value="<?php echo $order->order_picking_costs; ?>" class="span2"></td>
                </tr>
                <tr   style="font-size: 12px; ">
                    <td><strong><?php echo lang('shipping_costs') . ' ' . $shopname . '.com' . ' (' . $this->config->item('currency_symbol') . ')'; ?></strong></td>
                    <td><?php echo format_currency($order->shipping); ?></td>
                </tr>
                <tr   style="font-size: 12px; ">
                    <td><strong><?php echo lang('dispatch_costs') . ' ' . lang('customer') . ' (' . $this->config->item('currency_symbol') . ')'; ?></strong></td>
                    <td><input type="text" name="dispatch_costs" value="<?php echo $order->shipping; ?>" class="span2"></td>
                </tr>


                <tr   style="font-size: 12px; "> 
                    <td><strong><?php echo lang('shipping_date'); ?></strong></td>
                <?php echo '<td>' . form_input(array('name' => 'shipped_on', 'value' => date('Y-m-d'), 'id' => 'shipped_on', 'type' => 'text')) . '</td>'; ?>
                <script>$('#shipped_on').datepicker({dateFormat: 'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
                </tr>   
    <?php
}
?>
<?php
if ($order->status == 3) {
    ?>
                <tr   style="font-size: 12px; ">
                    <td><strong><?php echo lang('order_picking_costs'); ?></strong></td>
                    <td><input type="text" name="order_picking_costs" value="<?php echo $order->order_picking_costs; ?>" class="span2"></td>
                </tr>
                <tr   style="font-size: 12px; ">
                    <td><strong><?php echo lang('shipping_costs') . ' ' . $shopname . '.com' . ' (' . $this->config->item('currency_symbol') . ')'; ?></strong></td>
                    <td><?php echo format_currency($order->shipping); ?></td>
                </tr>
                <tr   style="font-size: 12px; ">
                    <td><strong><?php echo lang('dispatch_costs') . ' ' . lang('customer') . ' (' . $this->config->item('currency_symbol') . ')'; ?></strong></td>
                    <td><input type="text" name="dispatch_costs" value="<?php echo $order->shipping; ?>" class="span2"></td>
                </tr>
                <tr   style="font-size: 12px; "><td><?php echo lang('monitored_by'); ?></td><td><?php echo $order->monitored_by; ?></td></tr>
                <tr   style="font-size: 12px; "><td><?php echo lang('picking_agent'); ?></td><td><?php echo $order->picking_agent; ?></td></tr>
                <tr   style="font-size: 12px; "><td><?php echo lang('label_number'); ?></td><td><?php echo $order->label_number; ?></td></tr>

                <tr   style="font-size: 12px; ">
                    <td><strong><?php echo lang('shipping_date'); ?></strong></td>
                <?php echo '<td>' . form_input(array('name' => 'shipped_on', 'value' => $order->shipped_on, 'id' => 'shipped_on', 'type' => 'text')) . '</td>'; ?>
                <script>$('#shipped_on').datepicker({dateFormat: 'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
                </tr>   
    <?php
}
if (!empty($invoices)):
    ?>
                <tr   style="font-size: 12px; ">
                    <td><strong><?php echo lang('invoices'); ?></strong></td>
                    <td>
    <?php foreach ($invoices as $invoice): ?>
                            <a href="<?php echo site_url('admin/invoices/view/' . $invoice['id']); ?>" ><?php echo $invoice['invoice_number']; ?></a>
    <?php endforeach; ?>
                    </td>
                </tr>
<?php endif; ?>
<?php if (!empty($verzending)): ?>
                <tr   style="font-size: 12px; ">
                    <td><strong>Verzending</strong></td>
                    <td>
    <?php foreach ($verzending as $ship): ?>
                            <a href="<?php echo site_url('admin/orders/verzending/' . $ship['id']); ?>" ><?php echo $ship['id']; ?></a>
                <?php endforeach; ?>
                    </td>
                </tr>
<?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<!------------------------------------------------------------------------------------------------------------------------------------->
<div class="panel panel-default" style="width: 100%; float: left;">
    <div class="panel-heading"><?php echo lang('new_shippments'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
    </div>
    <div class="panel-body">
        <table id="myTable" class="table table-bordered" style="border: 1px solid #ddd;">
            <button type="submit" id="addrow12" class="glyphicon glyphicon-plus" ></button>
            <thead>
                <tr>
                    <th style="font-size: 12px; white-space: nowrap"><?php echo lang('product_nr'); ?></th>
                    <th style="font-size: 12px; white-space: nowrap"><?php echo lang('quantity'); ?></th>
                    <th style="font-size: 12px; white-space: nowrap"><?php echo lang('num_vpe'); ?></th>
                    <th style="font-size: 12px; white-space: nowrap"><?php echo lang('VK'); ?></th>
                    <th style="font-size: 12px; white-space: nowrap"><strong><?php echo lang('discount'); ?></strong></th>
                    <th style="font-size: 12px; white-space: nowrap"><?php echo lang('unit_price'); ?></th>
                    <th style="font-size: 12px; white-space: nowrap"><?php echo lang('total'); ?></th>
                    <th  style="font-size: 12px;">Article VAT.<?php //echo lang('product_nr'); ?></th>
<?php if ($this->bitauth->is_admin()): ?>
                        <th style="font-size: 12px; white-space: nowrap">Warehouse_price<?php //echo lang('warehouse_price'); ?></th>
                        <th style="font-size: 12px; white-space: nowrap"><?php echo lang('margin'); ?></th>
<?php endif; ?>
                    <th style="font-size: 12px; white-space: nowrap"><?php echo lang('available_stock'); ?></th>
                    <th style="font-size: 12px; white-space: nowrap"><?php echo lang('description'); ?></th>
                </tr>
            </thead>
            <tbody>
<?php $order_items = json_decode(json_encode($order_items), true); ?>
<?php if (!empty($order_items)): ?>   

    <?php foreach ($order_items as $order_item): ?>

                        <tr>
                    <input type="hidden" name="id[]" value="<?php echo $order_item['id'] ?>">
                    <input type="hidden" name="product_id[]" value="<?php //echo  $order_item['product_id']  ?>">
                            <?php
                            if ($order_item['BACKORDER'] == 1) {
                                ?><td style="font-size: 12px; color: red; "><?php echo str_replace('/', '', $order_item['code']); ?> - backorder</td><?php
                            } else {
                                ?><td style="font-size: 12px;"><?php echo str_replace('/', '', $order_item['code']); ?></td><?php
                }
                ?>
                    <input type="hidden" name="product_number[]" value="<?php echo $order_item['code'] ?>">
        <?php
        if ($this->data_shop == 3) {
            if ($order_item['code'] == '3x 1500 (10x150)' and $order_item['description'] == 'Vinyl') {
                ?><td><?php echo '' . $order_item['code']; ?></td><?php
            }
            if ($order_item['code'] == '1x 1500 (10x150)' and $order_item['description'] == 'Vinyl') {
                
            }
            if ($order_item['code'] == '4x 1500 (10x150)' and $order_item['description'] == 'Nitryl') {
                
            }
            if ($order_item['code'] == '3x 1500 (10x150)' and $order_item['description'] == 'Nitryl') {
                
            }
            if ($order_item['code'] == '1x 1500 (10x150)' and $order_item['description'] == 'Nitryl') {
                
            }
        }
        ?>
                    <td style="font-size: 11px;"><input name="number[]" type="text" value="<?php echo $order_item['quantity']; ?>" style="font-size: 11px; width: 97%;" /></td>
                    <td style="font-size: 11px;"><?php echo $order_item['vpa'] ?></td><input type="hidden" name="vpa[]" value="<?php echo $order_item['vpa'] ?>">
                    <td style="font-size: 11px;"><?php echo $order_item['original_price'] ?></td><input type="hidden" name="vk[]" value="<?php echo $order_item['original_price'] ?>">
                    <td style="font-size: 11px;"><input name="discount[]" type="text" value="<?php echo $order_item['discount']; ?>" style="width: 97%;"/></td>
                    <td style="font-size: 11px;"><input name="unit_price[]" type="text" value="<?php echo $order_item['saleprice']; ?>" style="width: 97%;"/></td>

                    <?php
                    if ($order_item['saleprice'] != '0.00') {
                        ?><td style="font-size: 11px;"><?php echo $order_item['saleprice'] * $order_item['quantity'] ?></td><?php
                        $subtotal[] = $order_item['saleprice'] * $order_item['quantity'];
                        $st = $order_item['saleprice'] * $order_item['quantity'];

                        if ($order_item['vat_index'] == $order->vat_index) {

                            $VAT_N = $order->vat_index;
                            $n_vat[] = round($st * $order_item['vat_index'] / 100, 2);
                        }
                        if ($order_item['vat_index'] != $order->vat_index) {

                            $VAT_D = $order_item['vat_index'];
                            $d_vat[] = round($st * $order_item['vat_index'] / 100, 2);
                        }
                        ?><td style="font-size: 11px;"><?php echo round($st * $order_item['vat_index'] / 100, 2); ?></td><?php ?><input name="vat_rate_item[]" type="hidden" value="<?php echo $st * $order_item['vat_index'] / 100; ?>" class="span1"/><?php ?><input name="vat_index_item[]" type="hidden" value="<?php echo $order_item['vat_index']; ?>" class="span1" /><?php
                    } else {
                        ?><td style="font-size: 11px;"><?php echo $order_item['original_price'] * $order_item['quantity'] ?></td><?php
                        $subtotal[] = $order_item['original_price'] * $order_item['quantity'];
                        $st = $order_item['original_price'] * $order_item['quantity'];


                        if ($order_item['vat_index'] == $order->vat_index) {

                            $VAT_N = $order->vat_index;
                            $n_vat[] = round($st * $order_item['vat_index'] / 100, 2);
                        }

                        if ($order_item['vat_index'] != $order->vat_index) {
                            $VAT_D = $order_item['vat_index'];
                            $d_vat[] = round($st * $order_item['vat_index'] / 100, 2);
                        }
                        ?><td style="font-size: 11px;"><?php echo round($st * $order_item['vat_index'] / 100, 2); ?></td><?php
                        ?><input name="vat_rate_item[]" type="hidden" value="<?php echo $st * $order_item['vat_index'] / 100; ?>" class="span1"/><?php
                    }
                    ?>

                    <?php if ($this->bitauth->is_admin()): ?>
                        <td style="font-size: 11px;"><input name="warehouse_price[]" type="text" value="<?php echo $order_item['warehouse_price']; ?>" style="width: 97%;"/></td>
                        <td style="font-size: 11px;">
                        <?php
                        if (!empty($order_item['margin'])) {
                            ?>
                                <input name="margin[]" type="hidden" value="<?php echo $order_item['margin']; ?>"/>
                            <?php echo $order_item['margin'] . '%'; ?>
                            <?php
                        } else {
                            ?>
                            <?php
                            $diff_price = $order_item['saleprice'] - $order_item['warehouse_price'];
                            echo @$total_margin[] = round((($diff_price / $order_item['saleprice']) * 100), 2) . '%';
                            ?>
                                <input name="margin[]" type="hidden" value="<?php echo @round((($diff_price / $order_item['saleprice']) * 100), 2); ?>"/>
                            <?php
                        }
                        ?>

                        </td>
                    <?php endif; ?>
                    <td style="font-size: 11px;"><?php echo $order_item['available_stock'] ?></td><input type="hidden" name="available_stock[]" value="<?php echo $order_item['available_stock'] ?>">
                    <td style="font-size: 11px;"><input type="text" name="description[]" value="<?php echo $order_item['description'] ?>" style="width: 97%;"/>
                        <input type="hidden" name="saleprice_index" value="<?php echo $saleprice_index; ?>">
                    <td><a class="glyphicon glyphicon-trash" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder') . '/orders/remove/' . $order_id . '/' . $order_item['id']); ?>" onclick="return areyousure_remove();"></a></td>

                    </tr>
                <?php endforeach; ?>
    <?php
    if (!empty($shipping_costs)) {
        $s_total = array_sum($subtotal) + $order->shipping;
    } else {
        $s_total = array_sum($subtotal);
    }

    $vat_net_price = $s_total * ($order->vat_index / 100);

    if (isset($total_price)) {
        $net_sum = array_sum($total_price);
    }
    if (isset($total_margin)) {
        $net_sum_m = array_sum($total_margin);
    }
    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td style="font-size: 12px; white-space: nowrap"><strong><?php echo lang('dispatch_costs'); ?></strong></td>
                <?php $extra_charges = array('0' => lang('select_dispatch_costs'), '6.95' => format_currency(6.95), '4.95' => format_currency(4.9), '0' => 'Samples'); ?>
                <?php if (!empty($order->shipping)) {
                    ?><td colspan='5'></td><td><strong><?php echo form_dropdown('shipping', $extra_charges, $order->shipping); ?></strong></td><?php
                } else {
                    ?><td colspan='5'></td><td><strong><?php echo form_dropdown('shipping', $extra_charges, '0'); ?></strong></td><?php }
                ?>
                    </tr>

                    <tr>
                        <td style="font-size: 11px;"><strong><?php echo lang('netto'); ?></strong></td>
                        <td colspan='5' style="font-size: 12px;"></td>
                        <td><?php echo format_currency($s_total); ?></td>

                        <td colspan='2' style="font-size: 12px;"><td><strong><?php
                if ($this->bitauth->is_admin()) {
                    if (!empty($order->overall_margin)) {
                        echo round($order->overall_margin, 2);
                        ?><input type="hidden" name="overall_margin" value="<?php echo $order->overall_margin; ?>" /><?php
                    } else {
                        if (!empty($net_sum_m)) {
                            echo $net_sum_m;
                            ?><input type="hidden" name="overall_margin" value="<?php echo $net_sum_m; ?>" /><?php
                        }
                    }
                }
                ?>%</strong></td>	
                <input type="hidden" name="netto" value="<?php echo $s_total; ?>" />
                <input type="hidden" name="overall_margin" value="<?php echo $s_total; ?>" />
                <input type="hidden" name="vat_index" value="<?php echo $order->vat_index; ?>" />

                </tr>
                <!-- <td colspan='4' style="font-size: 12px;"></td><td><?php //echo format_currency($order->vat_index*$order->shipping/100);  ?></td> -->
                <!--&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&-->
                        <?php
                                $n_vats = array_sum($n_vat);
                                $d_vats = array_sum($d_vat);

                                $vat_shipping_costs = $shipping_costs * $VAT_N / 100;
                                $vat_shipping_costs_d = $shipping_costs * $VAT_N / 100;

                                if (!empty($VAT_N) and ! empty($VAT_D)) {
                                    ?>
                    <tr>
                        <td style="font-size: 11px;"><strong><?php echo lang('vat'); ?></strong></td>
                        <td colspan="" style="font-size: 11px;"><?php echo $VAT_N . '%'; ?></td>
                        <td colspan='4' style="font-size: 12px;">
                            <span style="color: blue;"><?php echo 'VAT for the ordered products, different from nutrition'; ?></span>
                        </td>
                        <td><?php echo format_currency($n_vats, 2); ?></td>
                    </tr>
                    <tr>
                        <td style="font-size: 11px;"><strong><?php echo lang('vat'); ?></strong></td>
                        <td colspan="" style="font-size: 11px;" ><?php echo $VAT_N . '%'; ?></td>
                        <td colspan='4' style="font-size: 12px;">
                            <span style="color: blue;"><?php echo 'VAT for the shipping costs for the ordered products, different from nutrition'; ?></span>
                        </td>
                        <td><?php echo format_currency($vat_shipping_costs, 2); ?></td>
                    </tr>
        <?php
        foreach ($order_items as $order_item) {
            if ($order_item['special_vat'] == 1) {
                $st = $order_item['original_price'] * $order_item['quantity'];
                $d_vat = round($st * $order_item['vat_index'] / 100, 2);
                ?>
                            <tr>
                                <td style="font-size: 11px;"><strong><?php echo lang('vat'); ?></strong></td>
                                <td colspan="" style="font-size: 11px;"><?php echo $VAT_D . '%'; ?></td>
                                <td colspan='4' style="font-size: 12px;">
                                    <span style="color: blue;"><?php echo 'VAT for product' . ' ' . $order_item['code']; ?></span>
                                </td>
                                <td><?php echo format_currency($d_vat, 2); ?></td>
                            <input type="hidden" name="VAT" value="<?php echo $n_vats; ?>" />
                            </tr>
                            <?php
                        }
                    }
                    ?><input type="hidden" name="vat" value="<?php echo $n_vats + $vat_shipping_costs + $d_vats; ?>" /><?php
                }
                if (!empty($VAT_N) and empty($VAT_D)) {
                    ?>
                    <tr>
                        <td style="font-size: 11px;"><strong><?php echo lang('vat'); ?></strong></td>
                        <td colspan="" style="font-size: 11px;" class="fakeclvat" ><?php echo $VAT_N . '%'; ?></td>
                        <td colspan='4' style="font-size: 12px;"></td><td><?php echo format_currency($n_vats + $vat_shipping_costs, 2); ?></td>
                    <input type="hidden" name="VAT" value="<?php echo $n_vats; ?>" />
                    </tr>
        <?php
    }
    ?>
                <!--&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&-->
                <tr>
                    <td style="font-size: 11px;"><strong><?php echo lang('gross'); ?></strong></td>
                    <td colspan="5"></td>
                <?php
                if (!empty($VAT_N) and ! empty($VAT_D)) {
                    ?>
                        <td><strong><?php echo format_currency($s_total + $n_vats + $vat_shipping_costs + $d_vats); ?></strong></td>
                    <input type="hidden" name="gross" value="<?php echo $s_total + $n_vats + $vat_shipping_costs + $d_vats; ?>">
        <?php
    }
    ?>
    <?php
    if (!empty($VAT_N) and empty($VAT_D)) {
        ?>
                    <td><strong><?php echo format_currency($s_total + $n_vats + $vat_shipping_costs); ?></strong></td>
                    <input type="hidden" name="gross" value="<?php echo $s_total + $n_vats + $vat_shipping_costs; ?>">
                    <?php
                }
                ?>
                </tr>

                </tfoot>   
            <?php endif; ?>
        </table>
    </div>
</div>

<div class="panel panel-default" style="width: 100%; float: left;">
    <div class="panel-heading">INFO<?php //echo lang('invoice_details');  ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <tr>
                <td style="text-align:center; text-transform: uppercase;"><h5><?php echo lang('customer_info'); ?></h5></td>
                <td style="text-align:center; text-transform: uppercase;"><h5><?php echo lang('invoice_agreements'); ?></h5></td>
                <td style="text-align:center; text-transform: uppercase;"><h5><?php echo lang('other_remarks'); ?></h5></td>
            </tr>
            <tr>
                <td style="padding:5px;">
                    <textarea name="notes" style="width:400px;"><?php if (!empty($order->notes)) echo $order->notes; ?></textarea>
                </td>
                <td style="padding:5px;">
                    <textarea name="invoice_agreement_notes" style="width:400px;"><?php if (!empty($order->invoice_agreement_notes)) echo $order->invoice_agreement_notes; ?></textarea>
                </td>
                <td style="padding:5px;">
                    <textarea name="remarks" style="width:400px;"><?php if (!empty($order->remarks)) echo $order->remarks; ?></textarea>
                </td>
            </tr>	
        </table>
    </div>
</div>

<div class="panel panel-default" style="width: 100%; float: left;">
    <div class="panel-heading">Addresses<?php //echo lang('invoice_details');  ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <tr>
                <td style="text-align:center; text-transform: uppercase;"><h5><?php echo lang('invoice_address'); ?></h5></td>
                <td style="text-align:center; text-transform: uppercase;"><h5><?php echo lang('delivery_address'); ?></h5></td>
            </tr>
            <tr>
                <td style="padding:5px;">
<?php if (!empty($invoice_address)): ?>
                        <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('company'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['NAAM1']; ?>"><br>
                        <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('firstname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['NAAM2']; ?>"><br>
                        <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('lastname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['NAAM3']; ?>"><br>
                        <label style="font-family: 'Inconsolata'; font-size: 18px;">Street<?php //echo lang('street');  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['STRAAT']; ?>">&nbsp;<input type="text"  style="width: 100px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['HUISNR']; ?>"><br>
                        <label style="font-family: 'Inconsolata'; font-size: 18px;">Postcode<?php //echo lang('zip');  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['POSTCODE']; ?>"><br>
                        <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('city'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['PLAATS']; ?>"><br>
                        <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('country'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['LAND']; ?>"><br><br>
<?php endif; ?>	
                </td>
                <td style="padding:5px;">
<?php if (!empty($delivery_address)): ?>
                        <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('company'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM1']; ?>"><br>
                        <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('firstname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM2']; ?>"><br>
                        <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('lastname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM3']; ?>"><br>
                        <label style="font-family: 'Inconsolata'; font-size: 18px;">Street<?php //echo lang('street');  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['STRAAT']; ?>">&nbsp;<input type="text"  style="width: 100px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['HUISNR']; ?>"><br>
                        <label style="font-family: 'Inconsolata'; font-size: 18px;">Postcode<?php //echo lang('zip');  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['POSTCODE']; ?>"><br>
                        <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('city'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['PLAATS']; ?>"><br>
                        <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('country'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['LAND']; ?>"><br><br>
<?php endif; ?>	
                </td>
<?php if ($this->data_shop == 3): ?>
    <?php if (!empty($drop_shipment_address)): ?>
                        <td style="padding:5px;">
                            <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('company'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM1']; ?>"><br>
                            <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('firstname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM2']; ?>"><br>
                            <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('lastname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM3']; ?>"><br>
                            <label style="font-family: 'Inconsolata'; font-size: 18px;">Street<?php //echo lang('street');  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['STRAAT']; ?>">&nbsp;<input type="text"  style="width: 100px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['HUISNR']; ?>"><br>
                            <label style="font-family: 'Inconsolata'; font-size: 18px;">Postcode<?php //echo lang('zip');  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['POSTCODE']; ?>"><br>
                            <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('city'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['PLAATS']; ?>"><br>
                            <label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('country'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['LAND']; ?>"><br><br>
                        </td>
    <?php endif; ?>
                    <?php endif; ?>
            </tr>
            <tr>
                <td style="padding:5px;">
                    <a class="btn btn-info btn-sm" href="<?php echo site_url($this->config->item('admin_folder') . '/customers/addresses/' . $order->customer_id); ?>">Edit addresses<?php //echo lang('change_address'); ?></a>
                </td>
            </tr>
        </table>
    </div>
</div>

                    <?php if (!$order->BACKORDER == 1) { ?>   
    <div style="padding: 0px 0px 10px 10px">
        <button class="btn btn-info btn-sm" type="submit" name="submit" value="update"><?php echo lang('update'); ?></button>&nbsp;&nbsp;|&nbsp;&nbsp;
        <a class="btn btn-default btn-sm" href="<?php echo site_url('admin/orders/delete/' . $order->NR); ?>" onclick="return areyousure();" /><?php echo lang('delete'); ?></a>
    <a class="btn btn-default btn-sm" href="<?php echo site_url($this->config->item('admin_folder') . '/orders'); ?>">Back<?php //echo lang('cancel'); ?></a>
    </div>
<?php } else {
    ?>
    <div style="padding: 0px 0px 10px 10px">
        <button class="btn btn-info btn-sm" type="submit" name="submit" value="update"><?php echo lang('work_again'); ?></button>&nbsp;&nbsp;|&nbsp;&nbsp;
        <a class="btn btn-default btn-sm" href="<?php echo site_url('admin/orders/delete/' . $order->NR); ?>" onclick="return areyousure();" /><?php echo lang('delete'); ?></a>
    <a class="btn btn-default btn-sm" href="<?php echo site_url($this->config->item('admin_folder') . '/orders/'); ?>">Back<?php //echo lang('cancel');?></a>
    </div>

    <?php
}
?>

</form>


                <?php if (!$order->BACKORDER == 1): ?>   
                    <?php echo form_open($this->config->item('admin_folder') . '/orders/process_order/' . $order->order_number, 'class="form-inline"'); ?>
                    <?php if ($order->status == '0'): ?>
        <div style="padding: 0px 0px 10px 10px">
            <button class="btn btn-info btn-sm" type="submit" name="submit" value="update"><?php echo lang('send_to_warehouse'); ?></button>&nbsp;&nbsp;
        </div>
    <?php endif; ?>
    </form>	
<?php endif; ?>

<?php if (!$order->BACKORDER == 1): ?>   
    <?php if ($order->status == '1'): ?>
        <div style="padding: 0px 0px 10px 10px">
            <a class="btn btn-default btn-sm" href="<?php echo site_url('admin/orders/order_for_shipp/' . $order->order_number); ?>"><?php echo lang('SEND_TO_SHIP'); ?></a>
        </div>
    <?php endif; ?>
<?php endif; ?>


</div>
</div>
</div>

<script>$('#start_top').datepicker({dateFormat: 'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>

<style>
    #some-element {
        border: 1px solid #ccc;
        display: none;
        font-size: 10px;
        margin-top: 10px;
        padding: 5px;
        text-transform: uppercase;
    }

    #some-div:hover #some-element {
        display: block;
    }
</style>
<script>
    function areyousure()
    {
        return confirm('<?php echo lang('confirm_delete_order'); ?>');
    }
    function areyousure_remove()
    {
        return confirm('<?php echo 'Remove Product?'; ?>');
    }
</script>




<script>
    $(document).ready(function() {
        var counter = 0;

        $("#addrow").on("click", function() {


            var counter = $('#myTable tr').length - 2;

            $("#ibtnDel").on("click", function() {
                counter = -1
            });


            var newRow = $("<tr>");
            var cols = "";

            cols += '<td><input type="text" class="span2" name="new_product_number[]' + counter + '" required/></td>';
            cols += '<td><input type="text" class="span1" name="new_number[]' + counter + '" required/></td><td></td><td></td>';
            cols += '<td><input type="text" class="span1" name="new_discount[]' + counter + '"/></td>';
            cols += '<td><input type="text" class="span1" name="new_unit_price[]' + counter + '"/></td><td></td>';
            cols += '<td><input type="text" class="span1" name="new_warehouse_price[]' + counter + '"/></td><td></td><td></td><td></td>';




            cols += '<td><button id="ibtnDel" class="glyphicon glyphicon-trash" style="display: inline-block; font-size: 16px;" ></button></td>';
            newRow.append(cols);
            if (counter == 20)
                $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
            $("table.table-bordered").append(newRow);
            counter++;
        });

        $("table.table-bordered").on("change", 'input[name^="unit_price"]', function(event) {
            calculateRow($(this).closest("tr"));
            calculateGrandTotal();
        });


        $("table.table-bordered").on("click", "#ibtnDel", function(event) {
            $(this).closest("tr").remove();
            calculateGrandTotal();
        });


    });



    function calculateRow(row) {
        var number = +row.find('input[name^="unit_price"]').val();

    }

    function calculateGrandTotal() {
        var grandTotal = 0;
        $("table.table-bordered").find('input[name^="unit_price"]').each(function() {
            grandTotal += +$(this).val();
        });
        $("#grandtotal").text(grandTotal.toFixed(2));
    }
</script>





















<?php
include('footer.php');
