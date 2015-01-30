<?php

		    if($current_shop == 1 ){
	
				$staff_array = array(
					
					"0"   => 'Select',
					'94'  => 'Metamorfose Vertalingen',
					'115' => 'Testaccount CC',
					'127' => 'Davorka Tosic',
					'128' => 'Davorka Tosic',
					'129' => 'Ramona Müller',
					'130' => 'Ramona Müller',
					'131' => 'Sandra Weibke',
					'134' => 'Sven Mettmann',
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






      //CLIENT SEARCH SECTION VARS      	

                $attributes = 'class = "btn btn-primary"';
                                                        
		$search_keywords = array(
	
					'name'        	=> 'search_keywords',
                                        'class'         => 'inputxlarge_focused',
					'id'          	=> 'focusedInput_keywords',
					'size'        	=> '10',
					'placeholder' 	=> 'Name, zip code oder City/Town, z.B. Schmidt Hamburg',
            );		
		$search_country = array(
	
					'-1'        	=> 'Select...',
					'1'        	=> 'Australia',
					'2'        	=> 'België',
					'3'        	=> 'Bulgarije',
					'4'        	=> 'Deutschland',
					'5'        	=> 'Dänemark',
					'6'        	=> 'France',
					'7'        	=> 'Ireland',
					'8'        	=> 'Italien',
					'9'        		=> 'Luxemburg',
					'10'        	=> 'Nederland',
					'11'        	=> 'Polen',
					'12'        	=> 'Portugal',
					'13'        	=> 'Roemenië',
					'14'        	=> 'Schweiz',
					'15'        	=> 'Spanien',
					'16'        	=> 'Tschechische Republik',
					'17'        	=> 'Ungarn',
					'18'        	=> 'United Kingdom',
					'19'        	=> 'United States of America',
					'20'        	=> 'Zweden',
					'21'        	=> 'Österreich',
            );
            
            $order_accept = array(
            
					'name'        	=> 'order',
					'id'          	=> 'order',
					'value'       	=> 'accept',
					'checked'     	=> TRUE,
					'style'       	=> 'margin:10px',
					
			);
			
			$order_not_accept = array(
            
					'name'        	=> 'order',
					'id'          	=> 'order',
					'value'       	=> 'notaccept',
					'checked'     	=> TRUE,
					'style'       	=> 'margin:10px',
					
			);
			
			$industry = array(
	
					'-1'        	=> 'Select...',
					'2'        	=> 'Care shop',
					'3'        	=> 'Convalescent home',
					'4'        	=> 'Export',
					'5'        	=> 'Hospital',
					'6'        	=> 'Medical wholesale',
					'7'        	=> 'Nursing home',
					'8'        	=> 'Retailer',
					'9'        	=> 'Pharmaceutical wholesaler',
					'10'        	=> 'Pharmacy',
					'11'        	=> 'Private individual',
					'12'        	=> 'Rest & convalescent home',
					'13'        	=> 'Other / unknown',
            );
            
			$position = array(
	
					'-1'        	=> 'Select...',
					'2'        	=> 'Heimleitung',
					'3'        	=> 'Wirtschaftsleitung',
					'4'        	=> 'Pflegedienstleitung',
					'5'        	=> 'Hauptfirma',
					'6'        	=> 'Inkoop',
					'7'        	=> 'Fysio',
					'8'        	=> 'Ergo',
            );
            
            $postal_code_from = array(
            
					'name'        	=> 'postal_code_from',
					'id'          	=> 'postal_code_from',
					'size'        	=> '10',
					'placeholder' 	=> 'from',
            );
			$postal_code_to = array(
            
					'name'        	=> 'postal_code_to',
					'id'          	=> 'postal_code_to',
					'size'        	=> '10',
					'placeholder' 	=> 'to',
            );
			$excel_export = array(
            
					'name'        	=> 'excel_export',
					'id'          	=> 'excel_export',
					'value'       	=> 'export',
					'checked'     	=> TRUE,
					'style'       	=> 'margin:10px',
					
			);

	//to do -
	//put vars for language session 	
	?>



<?php include('header.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_customer');?>');
}
</script>
<div class="btn-group pull-right">
	<a class="btn btn-small" href="<?php echo site_url($this->config->item('admin_folder').'/customers/export_xml');?>"><?php echo lang('excel_export');?></a>

</div>
<?php echo form_open($this->config->item('admin_folder').'/overview/');?>
			<?php 

			$js = 'id="agent" onChange="this.form.submit();"';
			if(!empty($agent)){
				
				echo form_dropdown('agent', $staff_array,$agent,$js); 
			}
			else {
				echo form_dropdown('agent', $staff_array,0,$js); 
			}
?>
</form>

<table class="table table-striped">
    <thead>
	<tr>
            <th style="white-space:nowrap; font-size: 12px;">Customer Nr.<?php //echo lang('company');?></th>
            <th style="white-space:nowrap; font-size: 12px;"><?php echo lang('company');?></th>
            <th style="white-space:nowrap; font-size: 12px;"><?php echo lang('city');?></th>
            <th style="white-space:nowrap; font-size: 12px;">ZIP<?php //echo lang('zip');?></th>
            <th style="white-space:nowrap; font-size: 12px;"><?php echo lang('country');?></th>
            <th style="white-space:nowrap; font-size: 12px;">Total</th>
				
            <?php for ($i = 12; $i >= 0; $i--):?>
                <?php $m = date("Y/m", strtotime( date( 'Y-m-01' )." -$i months")); ?>
		<th style="white-space:nowrap; font-size: 12px;"><?php echo  $m; ?></th>		
            <?php endfor; ?>
	</tr>
    </thead>	
    <tbody>
        <?php echo (count($invoices) < 1)?'<tr><td style="text-align:center;" colspan="5">'.lang('no_customers').'</td></tr>':''?>
        <?php foreach ($invoices as $k=>$data):?>
            <?php if(!empty($data)): ?>
                <tr>
                <td style="white-space:nowrap; font-size: 12px;"><?php echo  $data['customer_number']; ?></td>
                <td style="white-space:nowrap; font-size: 12px;"><?php echo  $data['company']; ?></td>
                <td style="white-space:nowrap; font-size: 12px;"><?php echo  $data['city']; ?></td>
		<td style="white-space:nowrap; font-size: 12px;"><?php echo  $data['zip']; ?></td>
		<td style="white-space:nowrap; font-size: 12px;"><?php echo  $data['country_id']; ?></td>
		<td style="white-space:nowrap; font-size: 12px;"><?php echo  $data['total']; ?></td>
                <?php for ($i = 12; $i >= 0; $i--):?>
                    <?php $m = date("Y/m", strtotime( date( 'Y-m-01' )." -$i months")); ?>
                    <?php if(array_key_exists($m, $data['tm']) && $data['tm'][$m] != 0.0): ?>
                        <td style="white-space:nowrap; font-size: 12px;"><?php echo  $data['tm'][$m]; ?></td>
                    <?php else: ?>
                        <td style="white-space:nowrap; font-size: 12px;">&nbsp;</td>
                    <?php endif; ?>
                <?php endfor; ?>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include('footer.php'); ?>