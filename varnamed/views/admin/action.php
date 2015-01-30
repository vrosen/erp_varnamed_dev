<?php include('header.php'); ?>


<?php

    if($current_shop == 1 ){
$staff_array = array(
    
"0"  	=> 'Select',
"777"  	=> 'admin',
'94' 	=> 'Metamorfose Vertalingen',
'115' 	=> 'Testaccount CC',
'127' 	=> 'Davorka Tosic',
'128' 	=> 'Davorka Tosic',
'129' 	=> 'Ramona Müller',
'130' 	=> 'Ramona Müller',
'131' 	=> 'Sandra Weibke',
'134' 	=> 'Sven Mettmann',
'136' => 'Irina Schumann',
'138' => 'Sophie Gricourt',
'139' => 'Anne Sophie Carre',
'140' => 'Jennifer Rault',
'141' => 'Emilie Delavigne',
'142' => 'Eva Lavilla',
'143' => 'Elodie Sebeille',
'144' => 'Amelie Bloret',
'145' => 'Sandrine Rault',
'146' => 'Manuele Köhl',
'147' => 'Marcel Hoffmann',
'148' => 'Angelika Lichter',
'149' => 'Martina Ege',
'150' => 'Dieter Bühler',
'151' => 'Peter Reason',
'152' => 'Florian Macht',
'155' => 'Marjan Jeuring',
'156' => 'Maarten Lansink',
'157' => 'Franck Jaarsma',
'158' => 'Stefan Hiddink',
'159' => 'Veruschka Laetemia',
'160' => 'Francisca Oosterbroek',
'161' => 'Alexander Stozkijk',
'164' => 'Max Hijne',
'165' => 'Gina-Cristin Kisker',
'167' => 'Emmanuelle Miakakarila',
'169' => 'Marianne Rijn',
'172' => 'Frits',
'173' => 'Karel van Mossevelde',
'179' => 'Veronica Hoffman',
'183' => 'Ane Lorens',
'184' => 'Ann Jansens',
'185' => 'Axel Mettenleiter',
'187' => 'Hildo Kat',
'188' => 'Capucin Lepere',
'189' => 'Viktor3',
'192' => 'Brigitte Becker',
'199' => 'Viktor2',
'205' => 'Viktor8',
'207' => 'Kerry Robinson',
'208' => 'Ernest Lassman',
'209' => 'Maria Meister',
'213' => 'Geert Kloppenburg',
'217' => 'Stephanie Gillet',
'219' => 'Petra Muller');
    
}
		
		    if($current_shop == 2 ){
$staff_array = array(
    
"0"  => 'Select',
"778"  => 'admin',
"131"=>'Davorka Tosic',
"132"=>'Ramona Müller',
"133"=>'Sandra Weibke',
"135"=>'Sven Mettmann',
"136"=>'Irina Schumann',
"137"=>'Jennifer Rault',
"138"=>'Sophie Gricourt',
"139"=>'Anne Sophie Carre',
"140"=>'Emilie Delavigne',
"141"=>'Eva Lavilla',
"142"=>'Elodie Sebeille',
"143"=>'Amelie Bloret',
"144"=>'Sandrine Rault',
"145"=>'Manuela Köhl',
"146"=>'Marcel Hoffmann',
"147"=>'Angelika Lichter',
"148"=>'Martina Ege',
"149"=>'Dieter Bühler',
"150"=>'Peter Reason',
"151"=>'Florian Macht',
"152"=>'Rachel Kortstam',
"154"=>'Marjan Jeuring',
"155"=>'Maarten Lansink',
"156"=>'Franck Jaarsma',
"157"=>'Stefan Hiddink',
"158"=>'Veruschka Laetemia',
"159"=>'Francisca Oosterbroek',
"162"=>'Max Hijne',
"163"=>'Gina-Cristin Kisker',
"166"=>'Emmanuelle Miakakarila',
"170"=>'Marianne Rijn',
"176"=>'Frits',
"177"=>'Karel van Mossevelde',
"182"=>'Veronica Hoffman',
"184"=>'Ane Lorens',
"188"=>'Ann Jansens',
"190"=>'Axel Mettenleiter',
"192"=>'Hildo Kat',
"193"=>'Capucin Lepere',
"195"=>'Brigitte Becker',
"200"=>'Ernest Lassman',
"201"=>'Maria Meister',
"205"=>'Geert Kloppenburg',
"208"=>'Stephanie Gillet',
"210"=>'Petra Muller');
    
}
$status_array = array(

		0 => 'Set status',
		1 => lang('in_progress'),
		2 => lang('closed'),
);

$reason_array = array(

		2 => lang('quote_machen'),
		3 => lang('besuchen'),
		4 => lang('presentation'),
		5 => lang('telephone_conversation'),
		6 => lang('request'),
		7 => lang('order'),
		8 => lang('sample'),
		9 => lang('catalogue'),
		10 => lang('no_need'),
		11 => lang('register'),
		12 => lang('visit_report'),
		13 => lang('aanmaning'),
		14 => lang('retour'),

);

$exution_by_array = array(

	0 => lang('choose_departament'),
	1 => lang('customer_service'),
	2 => lang('sales'),
	3 => lang('management'),
	4 => lang('warehouse'),
	5 => lang('call_centre'),
	6 => lang('sales_manager'),
	7 => lang('purchase'),
	8 => lang('bookkeeping'),
	9 => lang('marketing'),
	10 => lang('product_specialist'),
);
$attributes = array('class' => 'dark-matter');

?>
 <script>
$(function() {
	$( ".datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
});

</script>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo 'Do you want to delete these to do?';?>');
}

</script>




									<?php 
									if(!empty($nr)){
										echo form_open($this->config->item('admin_folder').'/customers/todo/'.$id.'/'.$nr,$attributes);
									}
									else {
										echo form_open($this->config->item('admin_folder').'/customers/todo/'.$id,$attributes);
									}
									?>

                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="block-content collapse in">
                                <div class="span12">

                                      <fieldset>
                                        <h3>To do for : <a style="color: whitesmoke;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$return_id);?>"><?php echo $customer_names; ?></a></h3>
										<?php 
										if($current_shop == 1){
										?><input type="hidden" name="agent_id" value="<?php echo $c_id; ?>"><?php
										}
										if($current_shop == 2){
										?><input type="hidden" name="agent_id" value="<?php echo $d_id; ?>"><?php
										}
										?>
										
										
										<div class="control-group">
                                          <label class="control-label" for="select01">Status</label>
											  <div class="controls">
												<?php
													if(!empty($status)){
														echo form_dropdown('status',$status_array,$status); 
													}
													else {
													echo form_dropdown('status',$status_array,0); 
													}		
												?>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <label class="control-label" for="select01">KontaktArt</label>
											  <div class="controls">
												<?php
													if(!empty($reason)){
														echo form_dropdown('reason',$reason_array,$reason);
													}
													else {
														echo form_dropdown('reason',$reason_array,2);
													}
												?>
                                          </div>
                                        </div>				
										
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Contact persons</label>
                                          <div class="controls">
                                            <input type="text" name="contact_person" value="<?php echo $contact_person; ?>" class="span4" id="typeahead" >

                                          </div>
                                        </div>
										
                                       <div class="control-group">
                                          <label class="control-label" for="typeahead">Tel</label>
                                          <div class="controls">
                                            <input type="text" name="contact_phone" value="<?php echo $contact_phone; ?>" class="span4" id="typeahead" >
                                          </div>
										</div>
										
										<div class="control-group">
                                          <label class="control-label" for="typeahead">Entered by </label>
                                          <div class="controls">
										  <?php     
											if(!empty($agent_name)){
												?><input type="text" name="agent_name" value="<?php echo $agent_name; ?>" class="span4" id="typeahead" ><?php
											}
										  else {
												?><input type="text" name="agent_name" value="<?php echo $current_agent; ?>" class="span4" id="typeahead" ><?php
											}
										  ?>
                                            
                                          </div>
                                        </div>
					
										<div class="control-group">
                                          <label class="control-label" for="select01">Execute by</label>
											  <div class="controls">
												<?php echo form_dropdown('executed_by',$exution_by_array,$executed_by); ?>
                                          </div>
                                        </div>	
										
										<div class="control-group">
                                          <label class="control-label" for="typeahead">Name</label>
                                          <div class="controls">
											<?php 
											if(!empty($agent_id_2)){
											?><input type="text" name="agent_id_2" value="<?php echo $staff_array[$agent_id_2]; ?>" class="span4" id="typeahead" ><?php
											}
											else {
											if($current_shop == 1){
											?><input type="text" name="agent_id_2" value="<?php echo $staff_array[$c_id]; ?>" class="span4" id="typeahead" ><?php
											}
											if($current_shop == 2){
											?><input type="text" name="agent_id_2" value="<?php echo $staff_array[$d_id]; ?>" class="span4" id="typeahead" ><?php
											}
											}
											?>
                                          </div>
                                        </div>
										
										<div class="control-group">
										<label class="control-label" for="date01">Anlage</label>
											<input type="text" style="width: 20%;" name="entry_date" value="<?php echo $entry_date; ?>" disabled />
											<input type="text" style="width: 20%;" name="entry_time" value="<?php echo $entry_time; ?>" disabled />											
											<input type="hidden" name="entry_date" value="<?php echo $entry_date; ?>">
											<input type="hidden" name="entry_time" value="<?php echo $entry_time; ?>">
										</div>

										<div class="control-group">
                                          <label class="control-label" for="date01">Execution Date</label>
                                            <input id="date01" class="span3 input datepicker" name="execution_date" type="text" value="<?php echo $execution_date?>">
											<span>Time</span>&nbsp;<input class="span3"  type="time" name="execution_time"  value="<?php echo $execution_time; ?>">

                                        </div>
										<div class="control-group">
                                          <label class="control-label" for="date01">Executed on Date</label>
                                          <div class="controls">
                                            <input id="date01" class="span3 input datepicker" type="text" name="executed_on" value="<?php echo $executed_on ?>">Time&nbsp;<input class="span3" id="sample2 input" type="time" name="executed_time"  value="<?php echo $executed_time; ?>">
                                          </div>
                                        </div>									    
										
                                        <div class="control-group">
                                          <label class="control-label" for="textarea2">Umschreibung</label>
                                          <div class="controls">
                                            <textarea placeholder="Enter text ..." name="description" style="color: red;" class="redactor"><?php echo $description; ?></textarea>
                                          </div>
                                        </div>
										
                                     
                                          <button type="submit" class="btn btn-primary btn-small">Save changes</button>
										 <?php if(!empty($contact_id)){
											?><a class="btn btn-danger btn-small" onClick="return areyousure()" href="<?php echo site_url($this->config->item('admin_folder').'/customers/delete_to_do/'.$contact_id.'/'.$id); ?>"><?php echo lang('delete')?></a><?php
										}else {
											?><a class="btn btn-danger btn-small disabled" href="<?php echo site_url($this->config->item('admin_folder').'/customers/delete_to_do/'.$contact_id.'/'.$id); ?>"><?php echo lang('delete')?></a><?php
										}
										?>
										<a class="btn btn-danger btn-small" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$return_id);?>">Back<?php //echo lang('cancel')?></a>
                                        </div>
                           
                                    </form>

                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
					
					
 <!--
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Text input </label>
                                          <div class="controls">
                                            <input type="text" class="span6" id="typeahead"  data-provide="typeahead" data-items="4" data-source='["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Dakota","North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"]'>
                                            <p class="help-block">Start typing to activate auto complete!</p>
                                          </div>
                                        </div>

-->







<style>
#sidebar_1 {
    margin-left: 90%;
    margin-right: auto;
    max-width: 200px;
}

.dark-matter {
    margin-left: 2%;
    margin-right: auto;
    max-width: 700px;
    background: #555;
    padding: 20px 30px 20px 30px;
    font: 12px "Helvetica Neue", Helvetica, Arial, sans-serif;
    border: none;

}
.dark-matter h1 {
    padding: 0px 0px 10px 40px;
    display: block;
    border-bottom: 1px solid #444;
    margin: -10px -30px 30px -30px;
}
.dark-matter h6 {
    padding: 0px 0px 10px 40px;
    display: block;
    border-bottom: 1px solid #444;
    margin: -10px -30px 30px -30px;
	  color: #D3D3D3;
}
.dark-matter h3 {
    padding: 0px 0px 10px 40px;
    display: block;
    border-bottom: 1px solid #444;
    margin: -10px -30px 30px -30px;
	   color: #D3D3D3;
}
.dark-matter h1>span {
    display: block;
    font-size: 11px;
	    color: #D3D3D3;
}
.dark-matter label {
    display: block;
    margin: 0px 0px 5px;
	    color: #D3D3D3;
}
.dark-matter label>span {
    float: left;
    width: 20%;
    text-align: right;
    padding-right: 10px;
    margin-top: 10px;
    font-weight: bold;
}
.dark-matter input[type="text"], .dark-matter input[type="email"], .dark-matter select {
    border: none;
    color: #525252;
    height: 25px;
    line-height:15px;
    margin-bottom: 16px;
    margin-right: 6px;
    margin-top: 2px;
    outline: 0 none;
    padding: 5px 0px 5px 5px;
    width: 70%;
    border-radius: 2px;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    background: #DFDFDF;
}
.dark-matter select {
    background: #DFDFDF url('down-arrow.png') no-repeat right;
    background: #DFDFDF url('down-arrow.png') no-repeat right;
    appearance:none;
    -webkit-appearance:none;
    -moz-appearance: none;
    text-indent: 0.01px;
    text-overflow: '';
    width: 70%;
    height: 35px;
    color: #525252;
    line-height: 25px;
}
.dark-matter textarea{
    height:100px;
    padding: 5px 0px 0px 5px;
    width: 70%;
}
.dark-matter .button {
    background: #FFCC02;
    border: none;
    padding: 10px 25px 10px 25px;
    color: #585858;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    text-shadow: 1px 1px 1px #FFE477;
    font-weight: bold;
    box-shadow: 1px 1px 1px #3D3D3D;
    -webkit-box-shadow:1px 1px 1px #3D3D3D;
    -moz-box-shadow:1px 1px 1px #3D3D3D;
}

.dark-matter .button:hover {
    color: #333;
    background-color: #EBEBEB;
}
</style>







<?php include('footer.php'); ?>