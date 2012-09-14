<script type="text/javascript">
$(document).ready(function(){

<?php if(isset($selected) && $selected['Category']['type'] != 1 && (!isset($_GET['s']) || $_GET['s'] == "0")) : ?>
	$("#divSelection").hide();
	$("#decisionYes").click(function(e){
		$("#divDecision").hide();
		$("#divSelection").show('slow');
		e.preventDefault();
	});
<?php else : ?>
	$("#divDecision").hide();
<?php endif; ?>
});
</script>

<div style="margin: auto; text-align: center;">
<?php
if(!isset($selected)) echo $html->image(BASE_DIR . '/' . 'profile.jpg', array('style' => 'width: ' . IMAGE_MAIN_WIDTH. 'px; height: ' . IMAGE_MAIN_HEIGHT. 'px'));
?>

<?php

/*
<p id="player"><a href="http://www.macromedia.com/go/getflashplayer">Get Flash Player</a></p> 
<script type="text/javascript"> 
var s1 = new SWFObject("http://localhost/smarter/player.swf","ply","328","20","9","#FFFFFF");
s1.addParam("allowfullscreen","true");
s1.addParam("allowscriptaccess","always");
//s1.addParam("flashvars","file=http://202.160.1.55:8000/;&type=sound&duration=-1&autostart=false");
s1.addParam("flashvars","file=http://localhost/smarter/files/iwanttoeat.mp3&autostart=false");
s1.write("player");
</script> 
//*/
?>
	<?php if(isset($selected)) : ?>
		<h3>
			<?php 
			if ($selected['ParentCategory']['name'] == "")
				echo @$html->link("Home", array('action' => 'main', "?&s=2")); 
			else
			{
				echo "[";
				echo @$html->link("Home", array('action' => 'main', "?&s=2")); 
				echo "] ";
				echo @$html->link($selected['ParentCategory']['name'], array('action' => 'main', $selected['ParentCategory']['id'] . "?s=2")); 
			}
			?>
			&gt;
			<?php echo @$html->link($selected['Category']['name'], array('action' => 'main', $selected['Category']['id'] . "?s=2")); ?>
		</h3>

		<?php if($selected['Category']['type'] == 1) : ?>
		
			<table style="width: 650px; text-align: center; margin: auto;">
				<tr>
					<th style="text-align: center" width="300px">Now</th>
					<th style="text-align: center" width="300px">Next</th>
				</tr>
				<tr>
					<td style="text-align: center" width="300px">
						<?php echo @$html->link($selected['Category']['name'], array('action' => 'main', $selected['Category']['id'])); ?>
						<BR>

						<?php
							list($width, $height, $type, $attr) = @getimagesize( DIR. '/' . $selected['Category']['parent_category_id'] . "/" . $selected['Category']['image']);
							$IMAGE_MAIN_WIDTH = IMAGE_MAIN_WIDTH;
							$IMAGE_MAIN_HEIGHT = IMAGE_MAIN_HEIGHT;
							if($width > $height)
								$IMAGE_MAIN_HEIGHT = IMAGE_MAIN_WIDTH / $width * $height;
							else if($width < $height)
								$IMAGE_MAIN_WIDTH = IMAGE_MAIN_HEIGHT / $height * $width;
							#echo "w: $width h: $height a: " . ($width/$height) . "<BR>";
							#echo "W: $IMAGE_MAIN_WIDTH H: $IMAGE_MAIN_HEIGHT a: " . ($IMAGE_MAIN_WIDTH/$IMAGE_MAIN_HEIGHT) . "<HR>";
						?>
						<?php echo @$html->link($html->image(BASE_DIR . '/' . $selected['Category']['parent_category_id'] . "/" . $selected['Category']['image'], array('style' => 'width: ' . $IMAGE_MAIN_WIDTH. 'px; height: ' . $IMAGE_MAIN_HEIGHT. 'px')), 
							array('action' => 'main', $selected['Category']['id']), 
							array('escape' => false, 'id' => 'img_' . $selected['Category']['id'])
							); ?>
						<audio id="audio_<?php echo $selected['Category']['id']; ?>" controls  style="display: none">
						  <source src="<?php echo $html->url(BASE_DIR . '/' . $selected['Category']['parent_category_id'] . '/' . $selected['Category']['voice_answer']); ?>" type="audio/mpeg" />
						</audio>    
						<object id="audio_swf_<?php echo $selected['Category']['id']; ?>" type="application/x-shockwave-flash" data="<?php echo $html->url(BASE_DIR_SWF); ?>" width="0" height="0">
							<param name="wmode" value="transparent" />
							<param name="movie" value="<?php echo $html->url(BASE_DIR_SWF); ?>" />
							<param name="FlashVars" value="mp3=<?php echo $html->url(BASE_DIR . '/' . $selected['Category']['parent_category_id'] . '/' . $selected['Category']['voice_answer']); ?>" />
						</object>
						<p id="playeraudio_swf_<?php echo $selected['Category']['id']; ?>"></p> 
						<script type="text/javascript">
							$(document).ready(function(){
								$("#img_<?php echo $selected['Category']['id']; ?>").click(function(e){
									//$("#audio_<?php echo $selected['Category']['id']; ?>")[0].play();
									//document.getElementById("audio_swf_<?php echo $selected['Category']['id']; ?>").SetVariable("player:jsPlay", "");
									var s1 = new SWFObject("<?php echo $html->url(BASE_DIR_SWF2); ?>","ply","0","0","9","#FFFFFF");
									s1.addParam("allowfullscreen","true");
									s1.addParam("allowscriptaccess","always");
									s1.addParam("flashvars","file=<?php echo $html->url(BASE_DIR . '/' . $selected['Category']['parent_category_id'] . '/' . $selected['Category']['voice_answer']); ?>&autostart=true");
									s1.write("playeraudio_swf_<?php echo $selected['Category']['id']; ?>");
									e.preventDefault();
								});
								//$("#audio_<?php echo $selected['Category']['id']; ?>")[0].play();
								//document.getElementById("audio_swf_<?php echo $selected['Category']['id']; ?>").SetVariable("player:jsPlay", "");
								
								var s1 = new SWFObject("<?php echo $html->url(BASE_DIR_SWF2); ?>","ply","0","0","9","#FFFFFF");
								s1.addParam("allowfullscreen","true");
								s1.addParam("allowscriptaccess","always");
								s1.addParam("flashvars","file=<?php echo $html->url(BASE_DIR . '/' . $selected['Category']['parent_category_id'] . '/' . $selected['Category']['voice_answer']); ?>&autostart=true");
								s1.write("playeraudio_swf_<?php echo $selected['Category']['id']; ?>");
								
							});
						</script>							
						<p>
						<?php echo ($selected['Category']['text']); ?>
						</p>
					</td>
					<td style="text-align: center" width="300px">
						<?php echo @$html->link($next['Category']['name'], array('action' => 'main', $next['Category']['id'])); ?>
						<BR>
						<?php
							list($width, $height, $type, $attr) = @getimagesize( DIR. '/' . $next['Category']['parent_category_id'] . "/" . $next['Category']['image']);
							$IMAGE_MAIN_WIDTH = IMAGE_MAIN_WIDTH;
							$IMAGE_MAIN_HEIGHT = IMAGE_MAIN_HEIGHT;
							if($width > $height)
								$IMAGE_MAIN_HEIGHT = IMAGE_MAIN_WIDTH / $width * $height;
							else if($width < $height)
								$IMAGE_MAIN_WIDTH = IMAGE_MAIN_HEIGHT / $height * $width;
							#echo "w: $width h: $height a: " . ($width/$height) . "<BR>";
							#echo "W: $IMAGE_MAIN_WIDTH H: $IMAGE_MAIN_HEIGHT a: " . ($IMAGE_MAIN_WIDTH/$IMAGE_MAIN_HEIGHT) . "<HR>";
						?>						
						<?php echo @$html->link($html->image(BASE_DIR . '/' . $next['Category']['parent_category_id'] . "/" . $next['Category']['image'], array('style' => 'max-width: ' . $IMAGE_MAIN_WIDTH. 'px; max-height: ' . $IMAGE_MAIN_HEIGHT. 'px')), 
							array('action' => 'main', $next['Category']['id']), 
							array('escape' => false)
							); ?>
						<p>
						<?php echo ($next['Category']['text']); ?>
						</p>
					</td>
				</tr>
			</table>
		<?php else : ?>
			<div style="margin: auto; text-align: center;">
			<?php echo @$html->link($selected['Category']['name'], array('action' => 'main', $selected['Category']['id'])); ?>
			<BR>
			<?php
				list($width, $height, $type, $attr) = @getimagesize( DIR. '/' . $selected['Category']['parent_category_id'] . "/" . $selected['Category']['image']);
				$IMAGE_MAIN_WIDTH = IMAGE_MAIN_WIDTH;
				$IMAGE_MAIN_HEIGHT = IMAGE_MAIN_HEIGHT;
				if($width > $height)
					$IMAGE_MAIN_HEIGHT = IMAGE_MAIN_WIDTH / $width * $height;
				else if($width < $height)
					$IMAGE_MAIN_WIDTH = IMAGE_MAIN_HEIGHT / $height * $width;
				#echo "w: $width h: $height a: " . ($width/$height) . "<BR>";
				#echo "W: $IMAGE_MAIN_WIDTH H: $IMAGE_MAIN_HEIGHT a: " . ($IMAGE_MAIN_WIDTH/$IMAGE_MAIN_HEIGHT) . "<HR>";
			?>			
			<?php echo @$html->link($html->image(BASE_DIR . '/' . $selected['Category']['parent_category_id'] . "/" . $selected['Category']['image'], array('style' => 'max-width: ' . $IMAGE_MAIN_WIDTH. 'px; max-height: ' . $IMAGE_MAIN_HEIGHT. 'px')), 
				array('action' => 'main', $selected['Category']['id']), 
				array('escape' => false, 'id' => 'img_' . $selected['Category']['id'])
				); ?>
			<p>
			<?php echo ($selected['Category']['text']); ?>
			</p>
			
			<audio id="audio_<?php echo $selected['Category']['id']; ?>" controls  style="display: none">
			  <source src="<?php echo $html->url(BASE_DIR . '/' . $selected['Category']['parent_category_id'] . '/' . $selected['Category']['voice_answer']); ?>" type="audio/mpeg" />
			</audio>    
			<audio id="audio_q<?php echo $selected['Category']['id']; ?>" controls  style="display: none">
			  <source src="<?php echo $html->url(BASE_DIR . '/' . $selected['Category']['parent_category_id'] . '/' . $selected['Category']['voice_question']); ?>" type="audio/mpeg" />
			</audio>    
			<audio id="audio_no" controls  style="display: none">
			  <source src="<?php echo $html->url(BASE_DIR . '/audio_no.mp3'); ?>" type="audio/mpeg" />
			</audio>    
			<audio id="audio_yes" controls  style="display: none">
			  <source src="<?php echo $html->url(BASE_DIR . '/audio_yes.mp3'); ?>" type="audio/mpeg" />
			</audio>    
			<div>
			<object id="audio_swf_<?php echo $selected['Category']['id']; ?>" type="application/x-shockwave-flash" data="<?php echo $html->url(BASE_DIR_SWF); ?>" width="0" height="0">
				<param name="wmode" value="transparent" />
				<param name="movie" value="<?php echo $html->url(BASE_DIR_SWF); ?>" />
				<param name="FlashVars" value="mp3=<?php echo $html->url(BASE_DIR . '/' . $selected['Category']['parent_category_id'] . '/' . $selected['Category']['voice_answer']); ?>" />
			</object>
			<object id="audio_swf_q<?php echo $selected['Category']['id']; ?>" type="application/x-shockwave-flash" data="<?php echo $html->url(BASE_DIR_SWF); ?>" width="0" height="0">
				<param name="wmode" value="transparent" />
				<param name="movie" value="<?php echo $html->url(BASE_DIR_SWF); ?>" />
				<param name="FlashVars" value="mp3=<?php echo $html->url(BASE_DIR . '/' . $selected['Category']['parent_category_id'] . '/' . $selected['Category']['voice_question']); ?>" />
			</object>

			<object id="audio_swf_no" type="application/x-shockwave-flash" data="<?php echo $html->url(BASE_DIR_SWF); ?>" width="0" height="0">
				<param name="wmode" value="transparent" />
				<param name="movie" value="<?php echo $html->url(BASE_DIR_SWF); ?>" />
				<param name="FlashVars" value="mp3=<?php echo $html->url(BASE_DIR . "/audio_no.mp3"); ?>" />
			</object>
			<object id="audio_swf_yes" type="application/x-shockwave-flash" data="<?php echo $html->url(BASE_DIR_SWF); ?>" width="0" height="0">
				<param name="wmode" value="transparent" />
				<param name="movie" value="<?php echo $html->url(BASE_DIR_SWF); ?>" />
				<param name="FlashVars" value="mp3=<?php echo $html->url(BASE_DIR . "/audio_yes.mp3"); ?>" />
			</object>
			<p id="playeraudio_swf_<?php echo $selected['Category']['id']; ?>"></p>
			<p id="playeraudio_swf_q<?php echo $selected['Category']['id']; ?>"></p>
			<p id="playeraudio_swf_yes"></p>
			<p id="playeraudio_swf_no"></p>
			
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
					$("#img_<?php echo $selected['Category']['id']; ?>").click(function(e){
						//$("#audio_<?php echo $selected['Category']['id']; ?>")[0].play();
						//document.getElementById("audio_swf_<?php echo $selected['Category']['id']; ?>").SetVariable("player:jsPlay", "");
						var s1 = new SWFObject("<?php echo $html->url(BASE_DIR_SWF2); ?>","ply","0","0","9","#FFFFFF");
						s1.addParam("allowfullscreen","true");
						s1.addParam("allowscriptaccess","always");
						s1.addParam("flashvars","file=<?php echo $html->url(BASE_DIR . '/' . $selected['Category']['parent_category_id'] . '/' . $selected['Category']['voice_answer']); ?>&autostart=true");
						s1.write("playeraudio_swf_<?php echo $selected['Category']['id']; ?>");
						e.preventDefault();
					});
					$("#decisionYes").click(function(e){						
						//$("#audio_yes")[0].play();
						//document.getElementById("audio_swf_yes").SetVariable("player:jsPlay", "");
						var s1 = new SWFObject("<?php echo $html->url(BASE_DIR_SWF2); ?>","ply","0","0","9","#FFFFFF");
						s1.addParam("allowfullscreen","true");
						s1.addParam("allowscriptaccess","always");
						s1.addParam("flashvars","file=<?php echo $html->url(BASE_DIR . '/audio_yes.mp3'); ?>&autostart=true");
						//s1.addParam("flashvars","file=<?php echo $html->url(BASE_DIR . '/' . $selected['Category']['parent_category_id'] . '/' . $selected['Category']['voice_answer']); ?>&autostart=true");
						s1.write("playeraudio_swf_yes");
						e.preventDefault();
					});
					<?php if(!isset($_GET['s']) || $_GET['s'] == "0") : ?>
						//$("#audio_q<?php echo $selected['Category']['id']; ?>")[0].play();
						//document.getElementById("audio_swf_q<?php echo $selected['Category']['id']; ?>").SetVariable("player:jsPlay", "");
						var s1 = new SWFObject("<?php echo $html->url(BASE_DIR_SWF2); ?>","ply","0","0","9","#FFFFFF");
						s1.addParam("allowfullscreen","true");
						s1.addParam("allowscriptaccess","always");
						s1.addParam("flashvars","file=<?php echo $html->url(BASE_DIR . '/' . $selected['Category']['parent_category_id'] . '/' . $selected['Category']['voice_question']); ?>&autostart=true");
						s1.write("playeraudio_swf_q<?php echo $selected['Category']['id']; ?>");
						e.preventDefault();
					<?php elseif($_GET['s'] == "2") : ?>
						
					<?php else : ?>
						//$("#audio_no")[0].play();
						//document.getElementById("audio_swf_no").SetVariable("player:jsPlay", "");
						$("#audio_swf_no").ready(function(){
							//document.getElementById("audio_swf_no").SetVariable("player:jsPlay", "");

							var s1 = new SWFObject("<?php echo $html->url(BASE_DIR_SWF2); ///?>","ply","0","0","9","#FFFFFF");
							s1.addParam("allowfullscreen","true");
							s1.addParam("allowscriptaccess","always");
							s1.addParam("flashvars","file=<?php echo $html->url(BASE_DIR . '/audio_no.mp3'); ?>&autostart=true");
							s1.write("playeraudio_swf_no");							
						});
					<?php endif;?>
				});
			</script>
			
			</div>		
		<?php endif; ?>
	<?php else : ?>
		<?php if(isset($_GET['s']) && $_GET['s'] == "1") : ?>
			<audio id="audio_no" controls  style="display: none">
				<source src="<?php echo $html->url(BASE_DIR . '/audio_no.mp3'); ?>" type="audio/mpeg" />
			</audio>    
			<object id="audio_swf_no" type="application/x-shockwave-flash" data="<?php echo $html->url(BASE_DIR_SWF); ?>" width="0" height="0">
				<param name="wmode" value="transparent" />
				<param name="movie" value="<?php echo $html->url(BASE_DIR_SWF); ?>" />
				<param name="FlashVars" value="mp3=<?php echo $html->url(BASE_DIR . "/audio_no.mp3"); ?>" />
			</object>			
			<p id="playeraudio_swf_no"></p> 			
			<script type="text/javascript">
				$(document).ready(function(){
					//$("#audio_no")[0].play();
					//document.getElementById("audio_swf_no").SetVariable("player:jsPlay", "");					
					var s1 = new SWFObject("<?php echo $html->url(BASE_DIR_SWF2); ?>","ply","0","0","9","#FFFFFF");
					s1.addParam("allowfullscreen","true");
					s1.addParam("allowscriptaccess","always");
					s1.addParam("flashvars","file=<?php echo $html->url(BASE_DIR . '/audio_no.mp3'); ?>&autostart=true");
					s1.write("playeraudio_swf_no");
					
				});


			</script>
		<?php endif;?>
	<?php endif; // selected - 0 ?>

	<table cellpadding="0" cellspacing="0" style="width:400px; margin: auto; text-align: center;" id="divDecision">
		<tr>
			<td style="text-align: center"><?php echo @$html->link("☑", array('action' => 'main', $selected['Category']['id']), array('style'=>'font-size: 152px; color: #000; text-decoration: none;', 'id'=>'decisionYes')); ?></td>
			<td style="text-align: center"><?php echo @$html->link("☒", array('action' => 'main', $selected['Category']['parent_category_id'] . "&s=1"), array('style'=>'font-size: 152px; color: #000; text-decoration: none;', 'id'=>'decisionNo')); ?></td>
		</tr>
	</table>
	<br><br>
	<table cellpadding="0" cellspacing="0" style="width:400px; margin: auto; text-align: center;" id="divSelection">
	<?php
	$i = 0;
	foreach ($categories as $category):
		$class = null;
		if ($i % ITEMS_PER_ROW == 0) {
			?> 	<tr<?php echo $class;?> height="<?php echo IMAGE_HEIGHT; ?>px"> <?php
		}
		$i++;
	?>
		<td style="text-align: center"style="border: 1px solid green;">
			<?php if($category['Category']['type'] == 1) echo $category['Category']['order'] . ". "; ?>
			<?php echo @$html->link($category['Category']['name'], array('action' => 'main', $category['Category']['id'])); ?>
			<BR>
			<?php
				list($width, $height, $type, $attr) = @getimagesize( DIR. '/' . $category['Category']['parent_category_id'] . "/" . $category['Category']['image']);
				$IMAGE_WIDTH = IMAGE_WIDTH;
				$IMAGE_HEIGHT = IMAGE_HEIGHT;
				if($width > $height)
				 	$IMAGE_HEIGHT = IMAGE_WIDTH / $width * $height;
				else if($width < $height)
				 	$IMAGE_WIDTH = IMAGE_HEIGHT / $height * $width;
			?>
			<?php echo @$html->link($html->image(BASE_DIR . '/' . $category['Category']['parent_category_id'] . "/" . $category['Category']['image'], array('style' => 'max-width: ' . $IMAGE_WIDTH. 'px; max-height: ' . $IMAGE_HEIGHT. 'px')), 
				array('action' => 'main', $category['Category']['id']), 
				array('escape' => false)
				); ?>
		</td>
		<?php
		if ($i % ITEMS_PER_ROW == 0 ) {
			?> 	</tr> <?php
		}
		?>
<?php endforeach; ?>
	</table>

</div>

