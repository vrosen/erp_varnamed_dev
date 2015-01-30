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
$ordered_samples = array(
		0 => 'Select',
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

	0 	=> 'Select',
	1	=> 'niet bereikt',
	2	=> 'bestelling',
	4	=> 'terugbelafspraak',
	5	=> 'heeft eerder besteld',
	6	=> 'nog voorraad',
	14	=> 'tevreden met huidige leverancier',
	18	=> 'Sperrliste',
	20	=> 'Pas dentiste',
);

$gender_array = array(

		null => 'No gender specified',
		1 => 'Mr.',
		2 => 'Mrs.',



);
$position_array = array(

		0 => 'Select position',
		3 => 'Accountmanager',
		1 => 'Director',
		2 => 'Wholesaler',
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
	return confirm('<?php echo 'Do you want to delete these contact person?';?>');
}

</script>
  <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="block-content collapse in">
                                <div class="span12">
									<?php 
									if(!empty($nr)){
										echo form_open($this->config->item('admin_folder').'/customers/contact_person/'.$id.'/'.$nr,$attributes);
									}
									else {
										echo form_open($this->config->item('admin_folder').'/customers/contact_person/'.$id,$attributes);
									}
																											echo $agent_id.'<br>';
																		echo $current_agent_id.'<br>';
																		echo $allow.'<br>';
									?>
                                      
									  <?php if($allow == 2): ?>
									  <fieldset>
									  <h3>Contact person : <a style="color: whitesmoke;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$return_id);?>"><?php echo $customer_names; ?></a></h3>
										<?php 
										if($current_shop == 1){
										?><input type="hidden" name="agent_id" value="<?php echo $c_id; ?>"><?php
										}
										if($current_shop == 2){
										?><input type="hidden" name="agent_id" value="<?php echo $d_id; ?>"><?php
										}
										?>
										<div class="control-group">
                                          <label class="control-label" for="select01">Gender</label>
											  <div class="controls">
												<?php
													if(!empty($gender)){
														echo form_dropdown('gender',$gender_array,$gender);
													}
													else {
														echo form_dropdown('gender',$gender_array,0);
													}
												?>
                                          </div>
                                        </div>				
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">First Name</label>
                                          <div class="controls">
                                            <input type="text" name="firstname" value="<?php echo $firstname; ?>" class="span4" id="firstname" >
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Last Name</label>
                                          <div class="controls">
                                            <input type="text" name="lastname" value="<?php echo $lastname; ?>" class="span4" id="lastname" >
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">department</label>
                                          <div class="controls">
                                            <input type="text" name="department" value="<?php echo $department; ?>" class="span4" id="department" >
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Titel</label>
                                          <div class="controls">
                                            <input type="text" name="Titel" value="<?php echo $Titel; ?>" class="span4" id="Titel" >
                                          </div>
                                        </div>
										<div class="control-group">
                                          <label class="control-label" for="select01">Position</label>
											  <div class="controls">
												<?php
													if(!empty($position)){
														echo form_dropdown('position',$position_array,$position);
													}
													else {
														echo form_dropdown('position',$position_array,0);
													}
												?>
                                          </div>
                                        </div>		
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Telephone</label>
                                          <div class="controls">
                                            <input type="text" name="phone" value="<?php echo $phone; ?>" class="span4" id="phone" >
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Faxnummer</label>
                                          <div class="controls">
                                            <input type="text" name="faxnummer" value="<?php echo $faxnummer; ?>" class="span4" id="faxnummer" >
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Mobil</label>
                                          <div class="controls">
                                            <input type="text" name="mobil" value="<?php echo $mobil; ?>" class="span4" id="mobil" >
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">E-mail</label>
                                          <div class="controls">
                                            <input type="text" name="email" value="<?php echo $email; ?>" class="span4" id="email" >
                                          </div>
                                        </div>

                                        <div class="control-group">
                                          <label class="control-label" for="textarea2">Remarks</label>
                                          <div class="controls">
                                            <textarea placeholder="Enter text ..." name="remarks" style="color: red;" class="redactor"><?php echo $remarks; ?></textarea>
                                          </div>
                                        </div>
											<button type="submit" class="btn btn-primary btn-small">Save changes</button>
											<a class="btn btn-danger btn-small" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$return_id);?>">Back<?php //echo lang('cancel')?></a>
                                        </div>
									<?php endif; ?>
									
									
								<?php if($allow == 1): ?>
									  <fieldset>
									  <h3>Contact person : <a style="color: whitesmoke;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$return_id);?>"><?php echo $customer_names; ?></a></h3>
										<?php 
										if($current_shop == 1){
										?><input type="hidden" name="agent_id" value="<?php echo $c_id; ?>"><?php
										}
										if($current_shop == 2){
										?><input type="hidden" name="agent_id" value="<?php echo $d_id; ?>"><?php
										}
										?>
										<div class="control-group">
                                          <label class="control-label" for="select01">Gender</label>
											  <div class="controls">
												<?php
													if($agent_id == $current_agent_id){
														echo form_dropdown('gender',$gender_array,$gender);
													}else {
														echo $gender_array[$gender];
													}	
												?>
                                          </div>
                                        </div>				
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">First Name</label>
                                          <div class="controls">
												<?php
													if($agent_id == $current_agent_id){
														 ?><input type="text" name="firstname" value="<?php echo $firstname; ?>" class="span4" id="firstname" ><?php
													}else {
														echo $firstname;
													}	
												?>
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Last Name</label>
                                          <div class="controls">
												<?php
													if($agent_id == $current_agent_id){
														 ?><input type="text" name="lastname" value="<?php echo $lastname; ?>" class="span4" id="firstname" ><?php
													}else {
														echo $lastname;
													}	
												?>
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">department</label>
                                          <div class="controls">
												<?php
													if($agent_id == $current_agent_id){
														 ?><input type="text" name="department" value="<?php echo $department; ?>" class="span4" id="firstname" ><?php
													}else {
														echo $department;
													}	
												?>
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Titel</label>
                                          <div class="controls">
												<?php
													if($agent_id == $current_agent_id){
														 ?><input type="text" name="Titel" value="<?php echo $Titel; ?>" class="span4" id="firstname" ><?php
													}else {
														echo $Titel;
													}	
												?>
                                          </div>
                                        </div>
										<div class="control-group">
                                          <label class="control-label" for="select01">Position</label>
											  <div class="controls">
												<?php
													if($agent_id == $current_agent_id){
														echo form_dropdown('position',$position_array,$position);
													}else {
														echo $position_array[$position];
													}	
												?>
                                          </div>
                                        </div>		
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Telephone</label>
                                          <div class="controls">
												<?php
													if($agent_id == $current_agent_id){
														 ?><input type="text" name="phone" value="<?php echo $phone; ?>" class="span4" id="firstname" ><?php
													}else {
														echo $phone;
													}	
												?>
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Faxnummer</label>
                                          <div class="controls">
												<?php
													if($agent_id == $current_agent_id){
														 ?><input type="text" name="faxnummer" value="<?php echo $faxnummer; ?>" class="span4" id="firstname" ><?php
													}else {
														echo $faxnummer;
													}	
												?>
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Mobil</label>
                                          <div class="controls">
												<?php
													if($agent_id == $current_agent_id){
														 ?><input type="text" name="mobil" value="<?php echo $mobil; ?>" class="span4" id="firstname" ><?php
													}else {
														echo $mobil;
													}	
												?>
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">E-mail</label>
                                          <div class="controls">
												<?php
													if($agent_id == $current_agent_id){
														 ?><input type="text" name="email" value="<?php echo $email; ?>" class="span4" id="firstname" ><?php
													}else {
														echo $email;
													}	
												?>
                                          </div>
                                        </div>

                                        <div class="control-group">
                                          <label class="control-label" for="textarea2">Remarks</label>
                                          <div class="controls">
												<?php
													if($agent_id == $current_agent_id){
														 ?><textarea placeholder="Enter text ..." name="remarks" style="color: red;" class="redactor"><?php echo $remarks; ?></textarea><?php
													}else {
														echo $remarks;
													}	
												?>
                                            
                                          </div>
                                        </div>
										
										<?php if($agent_id == $current_agent_id){ 
											?><button type="submit" class="btn btn-primary btn-small">Save changes</button><?php
										}else {
											?><button type="submit" class="btn btn-primary btn-small disabled">Save changes</button><?php
										}
										?>
										<a class="btn btn-danger btn-small" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$return_id);?>">Back<?php //echo lang('cancel')?></a>
										<?php if(!empty($contact_person_id)): ?>
											<?php if($this->bitauth->is_admin()): ?>
												<a class="btn btn-danger btn-small" onClick="return areyousure();" href="<?php echo site_url($this->config->item('admin_folder').'/customers/delete_contact_person/'.$contact_person_id.'/'.$id);?>"><?php echo lang('delete')?></a>
											<?php endif; ?>
										<?php endif; ?>
                                        </div>
									<?php endif; ?>
									
									
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


<?php include('footer.php'); ?>


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
    text-shadow: 1px 1px 1px #444;
}
.dark-matter input[type="text"], .dark-matter input[type="email"], .dark-matter textarea, .dark-matter select {
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







