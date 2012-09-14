<?php $javascript->link(array('categories'), false); ?>
<div class="categories form">
<?php echo $this->Form->create('Category', array('action' => 'edit', 'type' => 'file'));?>
	<fieldset>
 		<legend><?php __('Edit Category'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('parent_category_id', array('empty' => array(0=>' ')));
		echo $this->Form->input('name');
		echo $this->Form->input('text');
		echo "<table>";
		echo "<tr>";
		echo "<td>";
		echo $this->Form->input('image', array('type' => 'file'));
		echo "</td>";
		echo "<td>";
		echo @$html->image(BASE_DIR . '/' . $this->data['Category']['parent_category_id'] . "/" . $this->data['Category']['image'], array('style' => 'max-width: 300px; max-height: 300px'));
		echo $this->Form->input('delete_current_image', array('type' => 'checkbox'));
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "<table>";
		/*
		echo "<tr>";
		echo "<td>";
		echo $this->Form->input('voice', array('type' => 'file'));
		echo "</td>";
		echo "<td>";
		?>
		<!--
		<audio id="audio_<?php echo $this->data['Category']['id']; ?>" controls>
		  <source src="<?php echo $html->url(BASE_DIR . '/' . $this->data['Category']['parent_category_id'] . '/' . $this->data['Category']['voice']); ?>" type="audio/mpeg" />
		</audio>
		<object id="audio_swf_<?php echo $this->data['Category']['id']; ?>" type="application/x-shockwave-flash" data="<?php echo $html->url(BASE_DIR_SWF); ?>"  width="100%" height="40">
			<param name="movie" value="<?php echo $html->url(BASE_DIR_SWF); ?>" />
			<param name="FlashVars" value="mp3=<?php echo $html->url(BASE_DIR . '/' . $this->data['Category']['parent_category_id'] . '/' . $this->data['Category']['voice']); ?>" />
		</object>
		-->
		<p id="playeraudio_swf_<?php echo $this->data['Category']['id']; ?>"></p>
		<?php
		echo $this->Form->input('delete_current_voice', array('type' => 'checkbox'));
		echo "</td>";
		echo "</tr>";
		*/
		echo "</table>";
		echo "<table>";
		echo "<tr>";
		echo "<td>";
		echo $this->Form->input('voice_question', array('type' => 'file'));
		echo "</td>";
		echo "<td>";
		?>
		<!--
		<audio id="audio_question_<?php echo $this->data['Category']['id']; ?>" controls>
		  <source src="<?php echo $html->url(BASE_DIR . '/' . $this->data['Category']['parent_category_id'] . '/' . $this->data['Category']['voice_question']); ?>" type="audio/mpeg" />
		</audio>
		<object id="audio_swf_q<?php echo $this->data['Category']['id']; ?>" type="application/x-shockwave-flash" data="<?php echo $html->url(BASE_DIR_SWF); ?>" width="100%" height="40">
			<param name="movie" value="<?php echo $html->url(BASE_DIR_SWF); ?>" />
			<param name="FlashVars" value="mp3=<?php echo $html->url(BASE_DIR . '/' . $this->data['Category']['parent_category_id'] . '/' . $this->data['Category']['voice_question']); ?>" />
		</object>
		-->
		<p id="playeraudio_swf_q<?php echo $this->data['Category']['id']; ?>"></p>
		<?php
		echo $this->Form->input('delete_current_voice_question', array('type' => 'checkbox'));
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "<table>";
		echo "<tr>";
		echo "<td>";
		echo $this->Form->input('voice_answer', array('type' => 'file'));
		echo "</td>";
		echo "<td>";
		?>
		<!--
		<audio id="audio_answer_<?php echo $this->data['Category']['id']; ?>" controls="controls">
		  <source src="<?php echo $html->url(BASE_DIR . '/' . $this->data['Category']['parent_category_id'] . '/' . $this->data['Category']['voice_answer']); ?>" type="audio/mpeg" />
		  
		</audio>    
		<object id="audio_swf_a<?php echo $this->data['Category']['id']; ?>" type="application/x-shockwave-flash" data="<?php echo $html->url(BASE_DIR_SWF); ?>"  width="100%" height="40">
			<param name="wmode" value="transparent" />
			<param name="movie" value="<?php echo $html->url(BASE_DIR_SWF); ?>" />
			<param name="FlashVars" value="mp3=<?php echo $html->url(BASE_DIR . '/' . $this->data['Category']['parent_category_id'] . '/' . $this->data['Category']['voice_answer']); ?>" />
		</object>
		-->
		<p id="playeraudio_swf_a<?php echo $this->data['Category']['id']; ?>"></p>		
		
		<script type="text/javascript">
		//$(document).ready(function(){
			<?php if($this->data['Category']['voice'] != "") : ?>
			//var s1 = new SWFObject("<?php echo $html->url(BASE_DIR_SWF2); ?>","ply","328","24","9","#FFFFFF");
			//s1.addParam("flashvars","file=<?php echo $html->url(BASE_DIR . '/' . $this->data['Category']['parent_category_id'] . '/' . $this->data['Category']['voice']); ?>&autostart=false");
			//s1.write("playeraudio_swf_<?php echo $this->data['Category']['id']; ?>");
			<?php endif ?>

			<?php if($this->data['Category']['voice_question'] != "") : ?>
			var s2 = new SWFObject("<?php echo $html->url(BASE_DIR_SWF2); ?>","ply","328","24","9","#FFFFFF");
			s2.addParam("flashvars","file=<?php echo $html->url(BASE_DIR . '/' . $this->data['Category']['parent_category_id'] . '/' . $this->data['Category']['voice_question']); ?>&autostart=false");
			s2.write("playeraudio_swf_q<?php echo $this->data['Category']['id']; ?>");
			<?php endif ?>

			<?php if($this->data['Category']['voice_answer'] != "") : ?>
			var s3 = new SWFObject("<?php echo $html->url(BASE_DIR_SWF2); ?>","ply","328","24","9","#FFFFFF");
			s3.addParam("flashvars","file=<?php echo $html->url(BASE_DIR . '/' . $this->data['Category']['parent_category_id'] . '/' . $this->data['Category']['voice_answer']); ?>&autostart=false");
			s3.write("playeraudio_swf_a<?php echo $this->data['Category']['id']; ?>");
			<?php endif ?>
		//});
		</script>							
		
		<?php
		echo $this->Form->input('delete_current_voice_answer', array('type' => 'checkbox'));
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo $this->Form->input('order');
		echo $this->Form->input('type', array('options' => array(0=>'Non-sequential', 1=>'Sequential')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Category.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Category.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Categories', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Categories', true), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Category', true), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>