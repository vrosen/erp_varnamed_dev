<?php


$city_array = array(
  

    '2759794' => 'Amsterdam',
    '726050' => 'Varna',
    
);
$js_w = 'id="shirts" onChange="this.form.submit()"';
?>


<?php echo form_open($this->config->item('admin_folder').'/dashboard/'); ?>


		<div  align="right">
            <?php 
            if(!empty($city)){
                echo form_dropdown('city',$city_array,$city,$js_w);
            }
            else {
                echo form_dropdown('city',$city_array,'0',$js_w);
            }
            ?>
	</div>
    </form>

<div class="img-container">
<div  align="right"><img src="<?php echo $pic_source; ?>" id="myimage"></div>
</div>
<style>
div > img {
background-repeat: no-repeat;
background-position: center center;
background-attachment: fixed;
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;
width:100px;
height:100px;
</style>
<script>
$(document).ready(function(){
     $(".imgcontainer > img").each(function(){
       var thisimg = "url("+$(this).attr('src')+")";
       $(this).css({'background-image': thisimg });
       $(this).attr('src', '');
     });

});
</script>

<table>
        
    
    <div  align="right">
    <?php echo date('H:m:s'); ?><br>
    <?php echo date('Y-m-d'); ?><br>
    <?php echo lang('temperature'); ?>:<?php echo round($cur_temp_Celsius); ?>&deg;<br>
    <?php echo lang('humidity'); ?>:<?php echo $w_data['main']['humidity']; ?>&percnt;<br>
    <?php echo lang('wind_speed'); ?>:<?php echo $w_data['wind']['speed']; ?>km/h<br>
    <?php echo lang('weather'); ?>:<?php echo $w_data['weather'][0]['main']; ?><br>
    <?php echo lang('weather_description'); ?>:<?php echo $w_data['weather'][0]['description']; ?><br>

</div>
    
</table>