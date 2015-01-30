<?php 
    $class = 'class = span2';
    $period = array(
        'all'                           => 'All',
        'today'                         => 'Today',
        'yesterday'                     => 'Yesterday',
        'day_before_yesterday'          => 'Day before yesterday',
        'this_week'                     => 'This week',
        'last_week'                     => 'Last week',
        'current'                       => 'Current',
        );
		
				$stat = array(
		
		"1" => 'In Bearbeitung',
		"2" => 'Abgeschlossen',
		
		);
?>

<?php include('header.php'); ?>



<?php echo form_dropdown('month', $period, 'current',$class); ?>&nbsp;

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
<?php endforeach; ?>
		<?php endif;?>
	</tbody>
</table>

<?php include('footer.php'); ?>