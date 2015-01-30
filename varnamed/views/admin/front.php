<?php include('header.php'); ?>


<div class="control-group success">
<div class="controls">
        <?php echo form_open($this->config->item('admin_folder').'/dashboard/index', 'class="form-inline" style="float:right"');?>
                <select  id="inputError" name="shop">

                        ?><option value="">Choose shop</option><?php
                    
                    ?>
                    <?php foreach ($all_shops as $shop): ?>
                        <option value="<?php echo $shop->shop_id; ?>" ><?php echo $shop->shop_name; ?></option>
                    <?php endforeach;?>    
                </select>
            <button class="btn" name="submit" value="submit"><?php echo lang('enter')?></button>
        </form>   
        </div>
</div>

<?php include('footer.php'); ?>