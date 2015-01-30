<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

                <title><?php echo lang('pdf_invoice'); ?> :: <?php echo $shop_name; ?><?php echo (isset($page_title))?' :: '.$page_title:''; ?></title>

                <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
                <link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css');?>" rel="stylesheet" type="text/css" />

                <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js');?>"></script>
                <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui.js');?>"></script>
                <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
                <script type="text/javascript" src="<?php echo base_url('assets/js/redactor.min.js');?>"></script>
                <script type="text/javascript" src="<?php echo base_url('assets/js/file-browser.js');?>"></script>
                <script type="text/javascript" src="index_files/wz_jsgraphics.htm"></script>

                <style type="text/css">
                    <!--
                        span.cls_002{font-family:Times,serif;font-size:28.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
                        div.cls_002{font-family:Times,serif;font-size:28.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
                        span.cls_006{font-family:Times,serif;font-size:8.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
                        div.cls_006{font-family:Times,serif;font-size:8.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
                        span.cls_004{font-family:Times,serif;font-size:8.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
                        div.cls_004{font-family:Times,serif;font-size:8.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
                        span.cls_003{font-family:Times,serif;font-size:7.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
                        div.cls_003{font-family:Times,serif;font-size:7.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
                        span.cls_005{font-family:Times,serif;font-size:17.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
                        div.cls_005{font-family:Times,serif;font-size:17.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
                        span.cls_007{font-family:Times,serif;font-size:9.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
                        div.cls_007{font-family:Times,serif;font-size:9.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
                        span.cls_008{font-family:Times,serif;font-size:9.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
                        div.cls_008{font-family:Times,serif;font-size:9.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
                        span.cls_009{font-family:Times,serif;font-size:7.0px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
                        div.cls_009{font-family:Times,serif;font-size:7.0px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
                    -->
                </style>
    </head>	

    <body>
        
        <div style="position:absolute;left:50%;margin-left:-297px;top:0px;width:595px;height:841px;border-style:outset;overflow:hidden">
            
            <div style="position:absolute;left:235.68px;top:0.00px" class="cls_002"><span class="cls_002"><?php echo $shop_name.'.com'; ?></span></div>

            <div style="position:absolute;left:468.80px;top:50.00px" class="cls_006"><span class="cls_006"><?php echo $shop_name.'.com'.' '.$shop_index; ?></span></div>
            <div style="position:absolute;left:442.80px;top:60.00px" class="cls_004"><span class="cls_004"><?php echo $shop_address['street'].' '.$shop_address['street_number'];?></span></div>
            <div style="position:absolute;left:495.80px;top:70.00px" class="cls_004"><span class="cls_004"><?php echo $shop_address['zip'].' '.$shop_address['city'];?></span></div>
            <div style="position:absolute;left:465.80px;top:80.00px" class="cls_004"><span class="cls_004"><?php echo lang('phone').' '.$shop_address['phone'];?></span></div>
            <div style="position:absolute;left:433.80px;top:90.00px" class="cls_004"><span class="cls_004"><?php  echo lang('email').' : '.$shop_address['email'];?></span></div>
            <div style="position:absolute;left:435.80px;top:100.00px" class="cls_004"><span class="cls_004"><?php echo lang('website').' : '.$shop_address['website']; ?></span></div>


            <div style="position:absolute;left:61.92px;top:141.32px" class="cls_003">
                <span class="cls_003">
                    <?php  echo $shop_name.'.com'.' '.$shop_index.' '.$shop_address['street'].' '.$shop_address['street_number'].' '.$shop_address['zip'].' '.$shop_address['city']; ?> 
                </span></div>
            <div style="position:absolute;left:62.40px;top:180.00px" class="cls_004"><span class="cls_004"><?php echo $customer_address['company']; ?></span></div>
            <div style="position:absolute;left:62.64px;top:190.00px" class="cls_004"><span class="cls_004"><?php echo $customer_address['firstname'].' '.$customer_address['lastname']; ?></span></div>
            <div style="position:absolute;left:61.92px;top:200.00px" class="cls_004"><span class="cls_004"><?php echo $customer_address['address1']; ?></span></div>
            <div style="position:absolute;left:61.92px;top:210.00px" class="cls_004"><span class="cls_004"><?php echo $customer_address['zip'].' '.$customer_address['city']; ?></span></div>
            <div style="position:absolute;left:61.92px;top:220.00px" class="cls_004"><span class="cls_004"><?php echo $customer_address['country']; ?></span></div>
        
            <div style="position:absolute;left:62.88px;top:259.72px" class="cls_005"><span class="cls_005"><?php echo lang('pdf_invoice'); ?></span></div>

            <div style="position:absolute;left:62.16px;top:290.00px" class="cls_006"><span class="cls_006"><?php echo lang('pdf_invoice_nr').'&nbsp;&nbsp;&nbsp;'.$invoice_number; ?></span></div>
            <div style="position:absolute;left:62.16px;top:300.00px" class="cls_006"><span class="cls_006"><?php echo lang('pdf_order_nr').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$order_number; ?></span></div>
            <div style="position:absolute;left:62.16px;top:310.00px" class="cls_006"><span class="cls_006"><?php echo lang('agent').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$agent; ?></span></div>
            <div style="position:absolute;left:62.16px;top:320.00px" class="cls_006"><span class="cls_006"><?php echo lang('date').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$invoice_date; ?></span></div>


            <div style="position:absolute;left:309.36px;top:290.00px" class="cls_006"><span class="cls_006"><?php echo lang('pdf_client_nr').' '.$customer_number; ?></span></div>

            <div style="position:absolute;left:309.84px;top:300.00px" class="cls_006"><span class="cls_006">Ust-IdNr.</span></div>
            <div style="position:absolute;left:310.56px;top:310.00px" class="cls_006"><span class="cls_006">Bestell-Nr.</span></div>


            
            
            <table>
                <thead>
                    <th><?php echo lang('product_nr'); ?></th>
                    <th><?php echo lang('description'); ?></th>
                    <th><?php echo lang('delivery_quantity'); ?></th>
                    <th><?php echo lang('number_per_packing'); ?></th>
                    <th><?php echo lang('unit_price_netto'); ?></th>
                    <th><?php echo lang('total_price_netto'); ?></th>
                </thead>
                <tbody>
            <?php foreach ($ordered_products as $product): ?>
                
            <td><?php echo $product['code'] ?></td>
            

            
            
            
            
                </tbody>
            <?php endforeach; ?>
            </table>


        </div>

    </body>
 </html>






