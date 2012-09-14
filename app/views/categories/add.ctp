<?php $javascript->link(array('categories'), false); ?>

<div class="categories form">
<?php echo $this->Form->create('Category', array('action' => 'add', 'type' => 'file'));?>

	<fieldset>
 		<legend><?php __('Add Category'); ?></legend>
	<?php
		echo $this->Form->input('parent_category_id', array('empty' => array(0=>' '), 'default' => $id));
		echo $this->Form->input('name');
		echo $this->Form->input('text');
		echo $this->Form->input('image', array('type' => 'file'));
//		echo $this->Form->input('voice', array('type' => 'file'));
		echo $this->Form->input('voice_question', array('type' => 'file'));
		echo $this->Form->input('voice_answer', array('type' => 'file'));
		echo $this->Form->input('order');
		echo $this->Form->input('type', array('options' => array(0=>'Non-sequential', 1=>'Sequential')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Categories', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Categories', true), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Category', true), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>