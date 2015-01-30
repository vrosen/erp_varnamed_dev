<?php include('header.php'); ?>

<table class="table table-responsive">
            <thead>
            <tr>
                <th><?php echo lang('direct_debit'); ?></th>
                <th><?php echo lang('subscriber_list'); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>    
                <td><a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/admin/export_sepa_xml');?>"><i class="icon-download"></i> <?php echo lang('xml_download');?></a></td>
                <td><a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/customers/get_subscriber_list');?>"><i class="icon-download"></i> <?php echo lang('subscriber_download');?></a></td>
            <a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/customers/export_xml');?>"><i class="icon-download"></i> <?php echo lang('xml_download');?></a>
            </tr>
            </tbody>
</table>

            <div class="container-fluid">
                <div class="accordion" id="accordion2">
                    <div class="accordion-group">  
                        <div class="accordion-heading">  
                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">  
                            <label><?php echo lang('sepa_explain');?></label>
                          </a>  
                        </div>  
                        <div id="collapseOne" class="accordion-body collapse" style="height: 0px; ">  
                          <div class="accordion-inner">  
                           <h4><?php echo lang('sepa_explain');?></h4><?php  ?>
                          </div>  
                        </div>  
                    </div>
                </div>
            </div>






















<?php include('footer.php'); ?>