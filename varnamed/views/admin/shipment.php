<?php require('header.php'); ?>


<?php 

$speditor = array(
    5   =>  'DPD',
    7   =>  'Post'
);
$condition = array(
    '0'                     => lang('select_delivery_condition'),
    '1'                     => lang('free_shipment'),
    '2'                     => lang('calculate_shipment'),
    );
$status_array = array(
    
    0   =>  lang('new_order'),
    1   =>  lang('warehouse_order'),
    2   =>  lang('ready_order'),
    3   =>  lang('shipped_order'),
);

?>
    <table class="table table-bordered">
        <thead>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap; ">Auftragsnummer</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $order->order_number; ?></td></tr>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap;">Customer</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $order->company; ?></td></tr>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap;">Order type</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $order->order_type; ?></td></tr>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap;">Delivery condition</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $condition[$order->delivery_condition]; ?></td></tr>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap;">Dispatch method</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $order->shipping_method; ?></td></tr>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap;">Spediteur</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $speditor[$shipment->VERZENDDOO]; ?></td></tr>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap;">Number of parcels</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $shipment->COLLI; ?></td></tr>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap;">Order picking costs</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $order->order_picking_costs; ?></td></tr>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap;">Shipping costs Comforties.nl (€)</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $order->shipping; ?></td></tr>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap;">Dispatch costs Customer (€)</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $shipment->VERZENDKOS; ?></td></tr>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap;">Kommissioniert</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $shipment->KONTROLLIE; ?></td></tr>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap;">Kontrolliert</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $shipment->KOMMISSION; ?></td></tr>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap;">Order date</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $order->ordered_on; ?></td></tr>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap;">Versanddatum</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $shipment->VERZENDDAT; ?></td></tr>
            <tr><td style="width: 50px; font-size: 12px; white-space: nowrap;">Status</td><td style="width: 50px; font-size: 12px; white-space: nowrap; "><?php echo $order->status; ?></td></tr>
        </thead>
    </table>












    <table class="table table-condensed">
        <thead>
            <tr>
                            <th style="font-size:12px;"><?php echo lang('order'); ?></th>
                            <th style="font-size:12px;"><?php echo lang('company'); ?></th>
                            <th style="font-size:12px;"><?php echo lang('delivery_date'); ?></th>
                            <th style="font-size:12px;">Verzending</th>
                        <?php 
                            if($this->data_shop == 3){
                            ?><th>Drop Shipment</th><?php
                            }
                        ?>
	    </tr>
	</thead>
        <tbody>
            <?php echo (count($shipment) < 1)?'<tr><td style="text-align:center;" colspan="8">'.lang('no_orders') .'</td></tr>':''?>
                <?php if(!empty($shipment)):?>
                    <?php //foreach($shipments as $shipment): ?>
                        <tr>
                                
                                <td style="font-size:12px;"><?php echo $shipment->ORDERNR; ?></td>
                                <td style="font-size:12px;"><?php echo $shipment->RELATIESNR.' '.$customers[$shipment->RELATIESNR][0]; ?></td>
                                <td style="font-size:12px;"><?php echo date('m/d/y h:i a', strtotime($shipment->VERZENDDAT)); ?></td>
                                <td style="font-size:12px;"><?php echo $shipment->VERZENDNR; ?></td>
                        </tr>
                    <?php //endforeach; ?>
                <?php endif; ?>
        </tbody>
    </table>



<?php include('footer.php'); ?>