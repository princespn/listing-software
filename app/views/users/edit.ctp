﻿<?php if($session->read('Auth.User.username')!='admin' && $session->read('Auth.User.group_id')!='1' && $session->read('Auth.User.group_id')!='5' && $session->read('Auth.User.group_id')!='2') 
{
	
	$this->requestAction('/users/logout/', array('return'));
}
?>

<?php
echo $javascript->link('test.js');    
?>

<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		
		echo $this->Form->input('username');
		echo $this->Form->input('email');
		$modify_by = $session->read('Auth.User.username');
		echo $this->Form->hidden('modify_by',array('value'=>$modify_by));
		echo $this->Form->input('new_password', array('type' => 'password','class'=>'text_main')); 
		echo $this->Form->input('confirm_password', array('type' => 'password','class'=>'text_main')); 
		echo $this->Form->input('group_id');		
	?>
</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

