<?php if($session->read('Auth.User.group_id')!='1' && $session->read('Auth.User.group_id')!='2')
{
$this->requestAction('/users/logout/', array('return'));
}
?>


<div class="imports form">
<?php 
echo $this->Form->create('GermanListing',array('action' => 'import','enctype'=>'multipart/form-data'));?>
	<fieldset>
		<legend><?php __('Import Germany Listing'); ?></legend>
		<?php
		echo $this->Form->input('file', array('label'=>'Import Germany listing','type'=>'file') );
		echo $form->input('user_id', array('type' => 'hidden'));
	
		$created_by = $session->read('Auth.User.username');

		echo $this->Form->hidden('created_by',array('value'=>$created_by));
		?> 
		
	</fieldset>
	<div class='reset'>
<?php 
echo $this->Form->button('Import the listing', array('id'=>'submit','disabled'=>'disabled','type'=>'submit'));
echo "&nbsp;&nbsp;&nbsp;&nbsp;";
echo $this->Form->button('Reset the listing', array('id'=>'reset','type'=>'reset','enable'=>'enable'));

?>
</div>
<?php
echo $this->Form->end();?>


<?php 
if (!empty($anything)){ ?>
<div class="errorSummary">
<ul> 
<?php
$key = $anything['errors'];
foreach ($key as $value){  ?>
 <li style="background-color:#dedede;color:#000;list-style-type:none;"><?php  echo $value; ?></li>
<?php 
}
?>
</ul>
</div>
<?php 
} else {
?>
<div id="progress" style="display: none;"><?php echo $html->image('home2.gif');?></div>
 <?php } ?>


</div> 
