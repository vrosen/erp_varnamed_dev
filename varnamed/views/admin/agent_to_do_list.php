<?php 



    if($current_shop == 1 ){
	
				$staff_array = array(
					
					"0"  	=> 'Select',
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
		
	if($current_shop == 3 ){

			$staff_array = array(
				
					"0"  => 'Select',
					"176"=>'Frits van Oorschot',
					"177"=>'Karel van Mossevelde',
					"188"=>'Ann Jansens',
					"192"=>'Hildo Kat',
					"200"=>'Ernest Lassman',
					"201"=>'Maria Meister',
					"205"=>'Geert Kloppenburg',
					"170"=>'Marianne Rijn',
					"182"=>'Veronica Hoffman',
					"195"=>'Brigitte Becker',
					"208"=>'Stephanie Gillet',
					"210"=>'Petra Muller'
					);
			}
		
		$stat = array(
		
		"1" => 'In Bearbeitung',
		"2" => 'Abgeschlossen',
		
		);

?>

<?php include('header.php'); ?>


<?php echo form_open($this->config->item('admin_folder').'/overview/to_do_list_agent/');?>
			<?php 
			if(!empty($staff_array_val)){

				echo form_dropdown('agent', $staff_array,$staff_array_val,$js); 
			}
			else {
				$js = 'id="agent" onChange="this.form.submit();"';
				echo form_dropdown('agent', $staff_array,0,$js); 
			}
?>
</form>
		<?php
		$page_links	= $this->pagination->create_links();
		
		if($page_links != ''):?>
		<tr><td colspan="5" style="text-align:center"><?php echo $page_links;?></td></tr>
                
		<?php endif;?>

<table class="table table-condensed table-bordered">
	<thead>
		<tr>
			<th style="font-size: 12px;">Data van uitvoering</th>
			<th style="font-size: 12px;">Datum van indiening</th>
			<th style="font-size: 12px;">Actie</th>
			<th style="font-size: 12px;">Klant</th>
			<th style="font-size: 12px;">Status</th>
		</tr>
	</thead>
	
	<tbody>

		<?php if(!empty($actions)): ?>
		<?php echo (count($actions) < 1)?'<tr><td style="text-align:center;" colspan="5">'.lang('no_customers').'</td></tr>':''?>
                <?php foreach ($actions as $action):?>
		<tr>
                        <td style="font-size: 12px;"><?php echo $action['UITVOEROP']; ?></td>
                        <td style="font-size: 12px;"><?php echo $action['INVOERDATU']; ?></td>
                        <td style="font-size: 12px; width: 300px;"><?php echo $action['ACTIE']; ?></td>
                        <td style="font-size: 12px;"><?php echo @$clients[$action['RELATIESNR']][0]; ?></td>
                        <td style="font-size: 12px;"><?php echo $stat[$action['STATUS']]; ?></td>

		</tr>
<?php endforeach;
		if($page_links != ''):?>
		<tr><td colspan="5" style="text-align:center"><?php echo $page_links;?></td></tr>
		<?php endif;?>
		<?php endif;?>
	</tbody>
</table>

<?php include('footer.php'); ?>