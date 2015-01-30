
<?php include('header.php'); ?>

<?php 	if(empty($c_shop)): ?>
    <h1>Choose a Webshop!</h1>
<?php else: ?>
    <div class="panel panel-default" style="width: 100%; float: left;">
	<!-- Default panel contents -->
		<div class="panel-heading">Latest Orders<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
		</div>
		<div class="panel-body">
			<div id="dashboardtable">
				<!-- go to dashboardtable.js -->
			</div>
		</div>
    </div>
<?php endif; ?>
<?php
    //check if there is any alert message set
    if(isset($alert) && !empty($alert))
    {
        //message alert
	echo $alert;
    }
?>

		<div class="panel panel-default" style="width: 100%; float: left;">
			<div class="panel-heading">
				To do list<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-hover" style="border: 1px solid #ddd;">
					<thead>
						<tr>
							<th>To do on</th>
							<th>Task</th>
							<th>View</th>
						</tr>
					</thead>
					<tbody>
					<?php echo (count($to_do_actions) < 1)?'<tr><td style="text-align:center;" colspan="8">'.lang('no_orders') .'</td></tr>':''?>
					<?php if(!empty($to_do_actions)): ?>
				<?php foreach($to_do_actions as $to_do_action): ?>
				<?php if($to_do_action['UITVOEROP'] !== '0000-00-00'): ?>
					<tr>
						<td style="width: 20%"><?php echo $to_do_action['UITVOEROP'].' '.$to_do_action['UITVOEROPT']; ?></td>
						<td><?php echo $to_do_action['ACTIE']; ?></td>
						<td style="text-align: center; width: 50px;">
							<a class="glyphicon glyphicon-edit" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/todo/'.$to_do_action['RELATIESNR'].'/'.$to_do_action['NR']);?>"><?php //echo lang('form_view')?></a>
						</td>
					</tr>
				 <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include('footer.php');?>
