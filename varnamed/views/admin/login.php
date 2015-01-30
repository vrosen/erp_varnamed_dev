<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<title>Varnamed | Login</title>
	
	<link rel="shortcut icon" href="<?php echo base_url('assets/favicon.ico'); ?>">
	<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/master.css');?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/css/login.css');?>" rel="stylesheet" type="text/css" />

</head>
<body>
<?php
	echo '<div id="loginhead"><strong>VarnaMed</strong> | Hi there.</div>';

	echo form_open($this->config->item('admin_folder').'/admin/login');
	//echo form_label('Username','username');
	echo form_input('username','', 'placeholder="Username" style="margin-bottom: 10px"');
	//echo form_label('Password','password');
	echo form_password('password','', 'placeholder="Password" style="margin-bottom: 10px"');

	echo form_submit('login','Login', 'class="btn-info" style="padding: 7px 20px; margin-bottom: 0px; display: inline;"');
		echo form_label(form_checkbox('remember_me', 1).' Remember Me', 'remember_me');
	echo ( ! empty($error) ? $error : '' );
	echo form_close();

	//echo '<div id="bottom">';
	//echo '<span style="float: right;">'.anchor($this->config->item('admin_folder').'/admin/register', 'Register').'</span>';
	//echo '</div>';

?>
</body>
</html>
