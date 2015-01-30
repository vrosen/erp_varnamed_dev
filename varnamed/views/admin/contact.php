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
		15 => 'COMPLAINT',

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
$ordered_samples = array(
		0 => 'No samples selected',
		1 => 'tevreden',
		2 => 'niet tevreden',
		3 => 'te dik',
		4 => 'te dun',
		5 => 'te duur',
		6 => 'liever latex',
		7 => 'maat niet goed',
		8 => 'handschoenen stinken',
		9 => 'moeilijk aan te trekken',
		10 => 'pasvorm niet goed',
		11 => 'handen drogen uit',
		12 => 'manchetten te kort',
		13 => 'handschoenen scheuren',
		14 => 'geen goede grip',
		15 => 'instrumenten kleven',
		16 => 'handen gaan zweten',
);


$belresultaatnr = array(

	0 	=> 'No result selected',
	1	=> 'niet bereikt',
	2	=> 'bestelling',
	4	=> 'terugbelafspraak',
	5	=> 'heeft eerder besteld',
	6	=> 'nog voorraad',
	14	=> 'tevreden met huidige leverancier',
	18	=> 'Sperrliste',
	20	=> 'Pas dentiste',
);


$attributes = array('class' => 'dark-matter');

?>
 <script>
$(function() {
$( "#datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
});
</script>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo 'Do you want to delete these contact?';?>');
}

</script>
									<?php 
									if(!empty($nr)){
										echo form_open($this->config->item('admin_folder').'/customers/contact/'.$id.'/'.$nr, $attributes);
									}
									else {
										echo form_open($this->config->item('admin_folder').'/customers/contact/'.$id, $attributes);
									}
									?>
									<?php if($allow == 2): ?>
												<h3>Contact for
													<span><a style="color: whitesmoke;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$return_id);?>"><?php echo $customer_names; ?></a></span>
												</h3>
													<tr>
														<td><label>KontaktArt :</label></td>
															<td>
																<label>
																	<?php
																		echo $agent_id.'<br>';
																		echo $current_agent_id.'<br>';
																		echo $allow.'<br>';
																		echo form_dropdown('reason',$reason_array,$reason);
																	?>
																</label>
															</td>
													</tr>
													<label>Person :</label>
															<input type="text" name="contact_person" value="<?php echo $contact_person; ?>" class="span4" id="typeahead" >
													<label>Anlage :</label>
															<input  class="span3 input datepicker" id="datepicker" name="entry_date" type="text" value="<?php echo $entry_date?>">
													<label>Mitarbeiter :</label>
															<input type="text" name="agent_name"  value="<?php echo $agent_name; ?>" readonly="readonly" />
													<label>Oordeel monsters :</label>
														<?php
															echo form_dropdown('samples_sent',$ordered_samples,$samples_sent);
														?>
													<label>Gespreksresultaat :</label>
														<?php
															echo form_dropdown('conversation_result',$belresultaatnr,$conversation_result);
														?>
													<div class="control-group">
														<label class="control-label" for="textarea2">Remarks</label>
															<div class="controls">
																<?php 
																		?><textarea placeholder="Enter text ..." name="notes"  class="redactor" ><?php echo $notes; ?></textarea><?php
																?>
															</div>
													</div>
													<span>&nbsp;</span>
													<div class="control-group">
														<button type="submit" class="btn btn-primary btn-small">Save changes</button>
														<a class="btn btn-danger btn-small" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$return_id);?>">Back<?php //echo lang('cancel')?></a>
													</div>
										<?php endif; ?>
										
									<?php if($allow == 1): ?>
												<h3>Contact for
													<span><a style="color: whitesmoke;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$return_id);?>"><?php echo $customer_names; ?></a></span>
												</h3>

												<tr>
													<td>
													<label>KontaktArt :</label></td>
														<td>
															<label>
																<?php
																echo $agent_id.'<br>';
																echo $current_agent_id.'<br>';
																echo $allow.'<br>';
																	if($agent_id != $current_agent_id){
																			echo '<h6>'.$reason_array[$reason].'</h6>';
																	}else {
																			echo form_dropdown('reason',$reason_array,$reason);
																	}												
																?>
															</label>
														</td>
												</tr>

														<label>Person :</label>
														<?php if($agent_id != $current_agent_id){ ?>
															<input type="text" name="contact_person" value="<?php echo $contact_person; ?>" readonly="readonly" />
														<?php } else {?>
															<input type="text" name="contact_person" value="<?php echo $contact_person; ?>" class="span4" id="typeahead" >
														<?php }?>


													<label>Anlage :</label>
														<?php 
															if($agent_id != $current_agent_id){ 
															
																	echo '<h6>'.$entry_date.'</h6>';
															}else{
																	?><input  class="span3 input datepicker" id="datepicker" name="entry_date" type="text" value="<?php echo $entry_date?>"><?php
															}
														?>


													<label>Mitarbeiter :</label>
					
													
														<input type="text" name="agent_name"  value="<?php echo $agent_name; ?>" readonly="readonly" />

														


				
													<label>Oordeel monsters :</label>
														<?php
														if($agent_id != $current_agent_id){ 

																	echo '<h6>'.$ordered_samples[$samples_sent].'<h6>';
					
														}else {
														
																	echo form_dropdown('samples_sent',$ordered_samples,$samples_sent);

														}
															?>

			  
				
													<label>Gespreksresultaat :</label>
														<?php
															if($agent_id != $current_agent_id){ 
																	echo '<h6>'.$belresultaatnr[$conversation_result].'</h6>';
															}else {
																	echo form_dropdown('conversation_result',$belresultaatnr,$conversation_result);
															}
															?>

			   
														<div class="control-group">
													  <label class="control-label" for="textarea2">Remarks</label>
													  <div class="controls">
													  <?php 

														if($agent_id != $current_agent_id){  
															echo '<h6>'.$notes.'</h6>';
														}else {
															?><textarea placeholder="Enter text ..." name="notes"  class="redactor" ><?php echo $notes; ?></textarea><?php
														}
														?>
													  </div>
													</div>

														<span>&nbsp;</span>
											
										
														<div class="control-group">
															<?php 
															if($agent_id != $current_agent_id){  
																?><button type="submit" class="btn btn-primary btn-small disabled">Save changes</button><?php
															}else {
																?><button type="submit" class="btn btn-primary btn-small">Save changes</button><?php
															}
															?>
															<a class="btn btn-danger btn-small" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$return_id);?>">Back<?php //echo lang('cancel')?></a>
															<?php if(!empty($contact_id)): ?>
																<?php if($this->bitauth->is_admin()): ?>
																	<a class="btn btn-danger btn-small" onClick="return areyousure();" href="<?php echo site_url($this->config->item('admin_folder').'/customers/delete_contact/'.$contact_id.'/'.$id); ?>"><?php echo lang('delete')?></a>
																<?php endif; ?>
															<?php endif; ?>
														</div>
											<?php endif; ?>

 

</form>
			
<style>
#sidebar_1 {
    margin-left: 90%;
    margin-right: auto;
    max-width: 200px;
	    color: #D3D3D3;
		    text-shadow: 1px 1px 1px #444;
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
	    color: #D3D3D3;
		    text-shadow: 1px 1px 1px #444;
}
.dark-matter h6 {

	    color: #D3D3D3;
}
.dark-matter h1>span {
    display: block;
    font-size: 11px;
	    color: #D3D3D3;
		    text-shadow: 1px 1px 1px #444;
}
.dark-matter label {
    display: block;
    margin: 0px 0px 5px;
	    color: #D3D3D3;
		    text-shadow: 1px 1px 1px #444;
}
.dark-matter label>span {
    float: left;
    width: 20%;
    text-align: right;
    padding-right: 10px;
    margin-top: 10px;
    font-weight: bold;
	    color: #D3D3D3;
		
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
    width: 100%;
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