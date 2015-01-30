<?php include('header.php'); ?>
<?php
if ($this->data_shop == 1) {
    $order_type_array = array(
        'Sofort Lieferung' => 'Sofort Lieferung',
        'Fixtermin' => 'Fixtermin',
        'direct_delivery' => 'Direct delivery',
        'Komplettlieferung' => 'Komplettlieferung',
        'Miete' => 'Miete',
        'Rezept' => 'Rezept',
        'Probe Lieferung' => 'Probe Lieferung',
        'Mietkauf' => 'Mietkauf',
    );
}
if ($this->data_shop == 2) {
    $order_type_array = array(
        'Sofort Lieferung' => 'Sofort Lieferung',
        'Fixtermin' => 'Fixtermin',
        'direct_delivery' => 'Direct delivery',
        'Komplettlieferung' => 'Komplettlieferung',
        'Miete' => 'Miete',
        'Rezept' => 'Rezept',
        'Probe Lieferung' => 'Probe Lieferung',
        'Mietkauf' => 'Mietkauf',
    );
}
if ($this->data_shop == 3) {
    $order_type_array = array(
        '0' => 'Select order type',
        'instant_delivery' => 'Instant delivery',
        'fixdate' => 'Fixdate',
        'direct_delivery' => 'Direct delivery',
        'complete_delivery' => 'Complete delivery',
        'rent' => 'Rent',
        'recipe' => 'Recipe',
        'sample_delivery' => 'Sample delivery',
        'rent_to_own' => 'Rent to own',
    );
}



$date = array(
    'id' => 'date',
    'name' => 'date',
    'type' => 'text',
    'placeholder' => 'Date',
);
$delivery_condition_array = array(
    '1' => 'Verzendkosten gratis',
    '2' => 'Verzendkosten berekenen',
);
if ($this->data_shop == 1) {
    $dispatch_method_array = array(
        'Selbstauslieferung' => 'Selbstauslieferung',
        'Spedition' => 'Parcel sevice',
        'miscellaneous' => 'miscellaneous',
    );
}
if ($this->data_shop == 2) {
    $dispatch_method_array = array(
        'Selbstauslieferung' => 'Selbstauslieferung',
        'Spedition' => 'Parcel sevice',
        'miscellaneous' => 'miscellaneous',
    );
}
if ($this->data_shop == 3) {
    $dispatch_method_array = array(
        'Selbstauslieferung' => 'Selbstauslieferung',
        'Spedition' => 'Parcel sevice',
        'miscellaneous' => 'miscellaneous',
    );
}
if ($current_shop == 1) {
    $warehouse_array = array(
        3 => 'Combiwerk(Delft)',
        2 => 'Transoflex(Frechen)',
    );
}
if ($current_shop == 2) {
    $warehouse_array = array(
        3 => 'Dutchblue(Delft)',
        2 => 'Transoflex(Frechen)',
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

$payment_condition_array = array(
    '0' => lang('set_condition'),
    '4' => lang('immediately_without_deduction'),
    '3' => lang('8_days_without_deduction'),
    '1' => lang('30_days_without_deduction'),
    '5' => lang('42_days_without_deduction'),
);

$currency_array = array(
    'EUR' => 'EUR',
    'USD' => 'USD'
);
?>
<?php
if ($this->session->flashdata('payment_method_error')) {
    ?><div class="alert alert-block">
    <?php echo '<strong>' . $this->session->flashdata('payment_method_error') . '</strong>'; ?>
    </div><?php
}


$product_missing = $this->session->flashdata('product_missing');
if (!empty($product_missing)) {
    echo '<h3>' . $product_missing . '</h3>';
}
?>








<?php $ATRIBUTES = array('id' => 'form'); ?>
<?php echo form_open($this->config->item('admin_folder') . '/orders/preview_order/' . $id, $ATRIBUTES); ?>

<div class="panel panel-default" style="width: 100%; float: left;">
    <!-- Default panel contents -->
    <div class="panel-heading">New Order<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
    </div>
    <div class="panel-body">
        <div id="dashboardtable">
            <table class="table table-hover">
                <tr>
                    <td><?php echo lang('customer'); ?></td>
                    <td><?php echo $customer_number; ?>&nbsp;<a href="<?php echo site_url($this->config->item('admin_folder') . '/customers/form/' . $id); ?>"><?php echo $company; ?></a></td>
                <input type="hidden" name="company" value="<?php echo $company; ?>">
                <input type="hidden" name="customer_nr" value="<?php echo $NR; ?>">
                <input type="hidden" name="customer_number" value="<?php echo $customer_number; ?>">
                </tr>
                <tr>
                    <td><?php echo lang('order_type'); ?></td>
                    <td>
                        <select name="order_type" id="order_type" style="width: 25%;">
                            <option name="default" value="instant_delivery">Instant delivery</option>
                            <option name="fixdate" value="fixdate">Fixdate</option>
                            <option name="direct_delivery" value="direct_delivery">Direct delivery</option>
                            <option name="complete_delivery" value="complete_delivery">Complete delivery</option>
                            <option name="rent" value="rent">Rent</option>
                            <option name="recipe" value="recipe">Recipe</option>
                            <option name="sample_delivery" value="sample_delivery">Sample delivery</option>
                            <option name="rent_to_own" value="rent_to_own">Rent to own</option>
                        </select>
                        <input id="row_dim" name="order_date" class="datepicker" value="" type="text" placeholder="Date of Fixtermin" style="margin: 2px 0 2px 30px; border: 0.5px solid #cacaca; padding: 1px 5px;"/>										
                    </td>	
                <script>
                    $(function() {
                        $('#row_dim').hide();
                        $('#order_type').change(function() {
                            if ($('#order_type').val() == 'fixdate') {
                                $('#row_dim').show();
                            } else {
                                $('#row_dim').hide();
                            }
                        });
                    });
                    $(function() {
                        if ($('#order_type').val() == 'fixdate') {
                            $('#row_dim').show();
                        }
                    });
                </script>

                </tr>
                <tr>
                    <td><?php echo lang('customer_order_number'); ?></td>
                    <td><input name="customer_order_number"  value="" type="text" placeholder="customer order number" style="width: 25%;"/></td>
                </tr>
                <tr>
                    <td><?php echo lang('contact_person'); ?></td>
                    <td><input name="contact_person"  value="" type="text" placeholder="contact person" style="width: 25%;"/></td>
                </tr>
                <tr>
                    <td><?php echo lang('delivery_condition'); ?></td>
                    <td>
<?php
if ($current_shop == 1) {
    echo form_dropdown('delivery_condition', $delivery_condition_array, '2', 'style="width: 25%;"');
}
if ($current_shop == 2) {
    echo form_dropdown('delivery_condition', $delivery_condition_array, '2', 'style="width: 25%;"');
}
if ($current_shop == 3) {
    echo form_dropdown('delivery_condition', $delivery_condition_array, '2', 'style="width: 25%;"');
}
?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('dispatch_method'); ?></td>
                    <td><?php echo form_dropdown('dispatch_method', $dispatch_method_array, 'Spedition', 'style="width: 25%;"'); ?></td>
                </tr>
                <tr>
                    <td><?php echo lang('warehouse'); ?></td>
                    <td><?php
if ($this->data_shop == 1) {
    echo form_dropdown('warehouse', $warehouse_array, 1, 'style="width: 25%;"');
}
if ($this->data_shop == 2) {
    echo form_dropdown('warehouse', $warehouse_array, 3, 'style="width: 25%;"');
}
if ($this->data_shop == 3) {
    echo form_dropdown('warehouse', $warehouse_array, '', 'style="width: 25%;"');
}
?></td>
                </tr>
                <tr>
                    <td><?php echo lang('payment_method'); ?></td>

                    <td>
<?php
$standart_payment_method = 1;
echo form_dropdown('payment_method', $payment_method_array, $standart_payment_method, 'style="width: 25%;"');
?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('payment_condition'); ?></td>
                    <td><?php echo form_dropdown('payment_condition', $payment_condition_array, $payment_condition, 'style="width: 25%;"'); ?></td>
                </tr>
                <tr>
                    <td><?php echo lang('none_VAT'); ?></td>
                        <?php
                        if ($none_VAT == 1) {
                            $none_VAT = array('name' => 'none_VAT', 'id' => 'none_VAT', 'value' => '1', 'checked' => TRUE, 'style' => 'margin:10px',);
                        } else {
                            $none_VAT = array('name' => 'none_VAT', 'id' => 'none_VAT', 'value' => '0', 'checked' => FALSE, 'style' => 'margin:10px',);
                        }
                        ?>
                    <td><?php echo form_checkbox($none_VAT); ?></td>
                </tr>


                <tr>
                    <td><strong><?php echo lang('not_remind'); ?></strong></td>
                        <?php
                        if ($not_remind == 0) {
                            $not_warn = array('name' => 'not_remind', 'id' => 'not_remind', 'value' => '0', 'checked' => false, 'style' => 'margin:10px',);
                            ?>
                        <td><?php echo form_checkbox($not_warn); ?></td> <?php
                    }
                    if ($not_remind == 1) {
                        $not_warn = array('name' => 'not_remind', 'id' => 'not_remind', 'value' => '1', 'checked' => true, 'style' => 'margin:10px',);
                        ?>
                        <td><?php echo form_checkbox($not_warn); ?></td> <?php
                    }
                        ?>
                </tr>
                <tr>
                    <td><?php echo lang('invoice_per_email'); ?></td>
                    <?php
                    if ($none_VAT == 1) {
                        $invoice_per_email = array('name' => 'invoice_per_email', 'id' => 'invoice_per_email', 'value' => '1', 'checked' => TRUE, 'style' => 'margin:10px',);
                    } else {
                        $invoice_per_email = array('name' => 'invoice_per_email', 'id' => 'invoice_per_email', 'value' => '0', 'checked' => FALSE, 'style' => 'margin:10px',);
                    }
                    ?>
                    <td><?php echo form_checkbox($invoice_per_email); ?></td>
                </tr>

                <tr>
                    <td><?php echo lang('email_adresse'); ?></td>
                    <?php $email_address = array('name' => 'email', 'id' => 'email', 'type' => 'text', 'value' => set_value('email', $email), 'style' => 'width: 25%;'); ?>
                    <td><?php echo form_input($email_address); ?></td>
                </tr>
                <tr>
                    <td><?php echo lang('currency'); ?></td>
                    <td><?php echo form_dropdown('currency', $currency_array, $currency, 'class="span2"'); ?></td>
                </tr>
                <tr>
                    <td><?php echo lang('order_entry'); ?></td>
                    <td><?php echo $current_user; ?></td>
                </tr>
                <tr>
                    <td><?php echo lang('order_date'); ?></td>
                    <?php $date = array('name' => 'order_date', 'class' => 'datepicker', 'type' => 'text', 'value' => set_value('order_date', $order_date), 'style' => 'width: 25%;'); ?>
                    <td><?php echo form_input($date); ?></td>
                </tr>
            </table>
        </div>


        <br/>
    </div>
</div>


<div class="panel panel-default" style="width: 100%; float: left;">
    <div class="panel-heading"><?php echo lang('important_customer_info'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
    </div>
    <div class="panel-body">
        <div id="dashboardtable">
            <table class="table">
                <tr>
                <textarea name="notes" class="redactor" ><?php if (!empty($customer_info)) echo $customer_info; ?></textarea>
                </tr>
            </table>
        </div>
    </div>
</div>



<div class="panel panel-default" style="width: 100%; float: left;">
    <div class="panel-heading"><?php echo lang('invoice_details'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
    </div>
    <div class="panel-body">
        <table id="myTable" class="table table-condensed" style="border: 1px solid #ddd;">
            <button id="addrow1" class="glyphicon glyphicon-plus" ></button>
            <thead>
                <tr>
                    <td><?php echo lang('product_nr'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?php echo lang('quantity'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?php echo lang('num_vpe'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?php echo lang('VK'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?php echo lang('discount'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?php echo lang('unit_price'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                </tr>
            </thead>
            <tbody>
                <tr class='qqrow'>
                    <td><input type="text" name="product_number[]" class="span2"  qq12="" required /></td>
                    <td><input type="text" name="number[]" class="span1" required /></td>
                    <td class='span3qq'></td>
                    <td class='span1qq'></td>
                    <td><?php echo form_input(array('name' => 'discount[]', 'class' => 'span2')); ?></td>
                    <td><?php echo form_input(array('name' => 'unit_price[]', 'class' => 'span')); ?></td>
                    <td class='span2qq'></td>
                    <td><a  class="glyphicon glyphicon-trash fakecl1" ></a></td>
                </tr>
            </tbody>

        </table>

        <input type="hidden" name="saleprice_index" value="<?php echo $saleprice_index; ?>">
        <input type="hidden" name="vat_index" value="<?php echo $vat_index; ?>">







        <script>
            $(function() {
                $(".datepicker").datepicker();
            });
        </script>


    </div></div>





<button type="submit" class="btn btn-info"><?php echo lang('next') ?></button>
<a class="btn btn-default" href="<?php echo site_url($this->config->item('admin_folder') . '/customers/form/' . $id); ?>"><?php echo lang('cancel'); ?></a>
</form>




</div>





<script>
    $('#start_top').datepicker({dateFormat: 'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>

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





















<?php include('footer.php'); ?>