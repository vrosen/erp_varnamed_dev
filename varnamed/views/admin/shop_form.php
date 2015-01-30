<?php include('header.php'); ?>

<script type="text/javascript">
$(function(){
$("#datepicker1").datepicker({dateFormat: 'mm-dd-yy', altField: '#datepicker1_alt', altFormat: 'yy-mm-dd'});
$("#datepicker2").datepicker({dateFormat: 'mm-dd-yy', altField: '#datepicker2_alt', altFormat: 'yy-mm-dd'});
});
</script>

<?php echo form_open($this->config->item('admin_folder').'/shop/form/'.$shop_id); ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><?php echo lang('shop_id');?></th>
                    <th><?php echo lang('active');?></th>
                    <th><?php echo lang('shop_name');?></th>
                    <th><?php echo lang('shop_creation_date');?></th>
                    <th><?php echo lang('admins');?></th>
                    <th><?php echo lang('shop_products');?></th>
                    <th><?php echo lang('shop_groups');?></th>
                    <th><?php echo lang('shop_categories');?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php $data	= array('name'=>'shop_id', 'value'=>set_value('shop_id', $shop_id), 'class'=>'span1'); echo form_input($data); ?></td>
                    <td>
                            <select id="shop_activ" name="shop_activ" class="span2">
                                <?php if($activ == 0): ?>
                                <option value="<?php if($activ == 0) echo 1 ?>"><?php echo lang('shop_activ'); ?></option>
                                <option value="<?php echo 0 ?>"><?php echo lang('disable'); ?></option>
                                <?php endif; ?>
                                <?php if($activ == 1): ?>
                                <option value="<?php if($activ == 1) echo 0 ?>"><?php echo lang('shop_not_activ'); ?></option>
                                <option value="<?php echo 1 ?>"><?php echo lang('enable '); ?></option>
                                <?php endif; ?>
                           </select>
                    </td>
                    <td><?php $data	= array('name'=>'shop_name', 'value'=>set_value('shop_name', $shop_name), 'class'=>'span2'); echo form_input($data); ?></td>
                    <td><?php $data	= array('name'=>'shop_creation_date', 'value'=>set_value('shop_creation_date', $shop_creation_date), 'class'=>'span2'); echo form_input($data); ?></td>
                    <td>
                        <select id="shop_admins" name="shop_admins">
                                <option value=""><?php echo lang('view_admins'); ?></option>
                        <?php 
                            foreach($shop_admins as $shop_admin){
                                echo '<option value="'.$shop_admin->firstname.'">'.$shop_admin->firstname.'</option>';    
                            }
                        ?>
                       </select>
                    </td>
                    <td>
                        <select id="shop_products" name="shop_products">
                            <option value=""><?php echo lang('view_products'); ?></option>
                        <?php 
                            foreach($shop_products as $shop_product){
                                echo '<option value="'.$shop_product->name.'">'.$shop_product->name.'</option>';    
                            }
                        ?>
                       </select>
                    </td>
                    <td>
                        <select id="shop_groups" name="shop_groups">
                            <option value=""><?php echo lang('view_groups'); ?></option>
                        <?php 
                            foreach($shop_groups as $shop_group){
                                echo '<option value="'.$shop_group->group_name.'">'.$shop_group->group_name.'</option>';    
                            }
                        ?>
                       </select>
                    </td>
                    <td>
                        <select id="shop_categories" name="shop_categories">
                            <option value=""><?php echo lang('view_categories'); ?></option>
                        <?php 
                            foreach($shop_categories as $shop_category){
                                echo '<option value="'.$shop_category->name.'">'.$shop_category->name.'</option>';    
                            }
                        ?>
                       </select>
                    </td>
                </tr>
            </tbody>
        </table>
            <button type="submit" class="btn btn-primary"><?php echo lang('form_save');?></button>
        </form>






<?php include('footer.php'); ?>
