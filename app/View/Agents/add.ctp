<div class="agents form">
<?php echo $this->Form->create('Agent'); ?>
	<fieldset>
		<legend><?php echo __('Add Agent'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('default_contact_id', array('options' => $contacts));
		echo 'or';
		echo $this->Form->input('new_default_contact');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Agents'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Contacts'), array('controller' => 'contacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contact'), array('controller' => 'contacts', 'action' => 'add')); ?> </li>
	</ul>
</div>
