<div class="categories index">
	<h2><?php __('Categories');?></h2>

	<?php if(isset($selected)) : ?>
	<?php echo $this->Html->link(__('Home', true), array('action' => 'index')); ?>
	<?php
	foreach($parents as $category)
	{	
		echo " &gt; " . $this->Html->link($category['Category']['name'], array('action' => 'index', $category['Category']['id']));
	}
	$category = $selected;
	echo " &gt; " . $this->Html->link($category['Category']['name'], array('action' => 'index', $category['Category']['id'])); ?>
	<?php endif; ?>
	<div class="actions" style="clear: both;">
	<ul style="clear: both;">
	<li style="display: absolute;"><?php echo $this->Html->link(__('Add Here', true), array('action' => 'add', @$selected['Category']['id']), array('style' => 'margin: 5px; padding: 5px; border: 1px solid black;')); ?></li>
	</ul>
	</div>

	<?php if(isset($selected)) : ?>	
	<?php $category = $selected; ?>
	<BR><BR>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($category['ParentCategory']['name'], array('controller' => 'categories', 'action' => 'view', $category['ParentCategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $category['Category']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Text'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $category['Category']['text']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo @$html->image($category['Category']['image']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Voice'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $category['Category']['voice']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $category['Category']['order']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
			switch($category['Category']['type'])
			{
				case 0:
					__('Non-sequential');
					break;
				case 1:
					__('Sequential');
					break;
			}
			?>
			&nbsp;
		</dd>
	</dl>	
	<?php endif ?>
	<BR><BR>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('parent_category_id');?></th>
		<th><?php echo $this->Paginator->sort('name');?></th>
		<th><?php echo $this->Paginator->sort('text');?></th>
		<th><?php echo $this->Paginator->sort('type');?></th>
		<th><?php echo $this->Paginator->sort('image');?></th>
		<th><?php echo $this->Paginator->sort('order');?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($categories as $category):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Html->link($category['ParentCategory']['name'], array('controller' => 'categories', 'action' => 'view', $category['ParentCategory']['id'])); ?>
		</td>
		<td><?php echo $category['Category']['name']; ?>&nbsp;</td>
		<td><?php echo $category['Category']['text']; ?>&nbsp;</td>
		<td>
			<?php echo @$html->image($category['Category']['image']); ?>
		&nbsp;</td>
		<td><?php switch($category['Category']['type'])
		{
			case 1:
				__('Sequential');
				break;
			case 0:
				__('Non-sequential');
				break;
				
		}
		?>&nbsp;</td>
		<td><?php echo $category['Category']['order']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View Sub Categories', true), array('action' => 'index', $category['Category']['id'])); ?>
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $category['Category']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $category['Category']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $category['Category']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $category['Category']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Categories', true), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('New Parent Category', true), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>