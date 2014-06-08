<?php
	$errorquery = mysql_query("SELECT `scene_id` FROM `scene_config` WHERE scene_id='$num' AND NOT `scene_private`='1'") or die(mysql_error());
	$errortest = mysql_num_rows($errorquery);

	if(!$errortest && $num)
	{
		/* In case we are coming here with an invalid scene number */
		?>
	        <div style="align:center; text-align:center; width:100%; background-color:red; opacity:0.5; border:2px solid black; border-radius:5px;">
        		Sorry, we could not find scene <?php echo $num ?>.
	        </div>
	        <?php
	}

	/* Function for showing the scene listing */
	function sceneview($scene)
	{
		switch( $scene['scene_state'] )
		{
			case 0:
				$state='Active';
				break;
			case 1:
				$state='Paused';
				break;
			case 2:
				$state='Unfinished';
				break;
			case 3:
				$state='Finished';
				break;
		}
		echo '<tr class="'.$scene['scene_id'].'">';
		echo '<td class="sceneid">'.$scene['scene_id'].'</td>';
		echo '<td class="scenestate state_'.$state.'">'.$state.'</td>';
		echo '<td class="sceneowner"><a href="view.php?owner='.$scene['scene_owner'].'">'.str_replace(' ','&nbsp;',mysql_result(mysql_query("SELECT `player_initname` FROM `scene_players` WHERE `player_id`=\"".$scene['scene_owner']."\""),0)).'</a></td>';
		echo '<td class="scenetitle"><a href="view.php?id='.$scene['scene_id'].'">'.($scene['scene_title'] ? $scene['scene_title'] : 'No Title Set').'</a></td>';
		echo '<td class="scenedesc">'.ansi2html( ( $scene['scene_desc'] ? $scene['scene_desc'] : 'No Description Set' )).'</td>';
		echo '</tr>';
	}

	/* The actual Query */
	$q = mysql_query("SELECT * FROM `scene_config` WHERE `scene_private`='0' ". ( $ownerscenes ? 'AND `scene_owner`="'.$ownerscenes.'"' : '' ). " ORDER BY `scene_id` DESC") or die(mysql_error());
	if(!$q)
		echo "Something went wrong!";

	echo "\n<table border=\"0\" cellpadding=\"2\" cellspacing=\"3\" class=\"scenetable\" id=\"scenetable\" align=\"left\">";
	echo '<td class="sceneid">ID</td><td class="scenestate">State</td><td class="sceneowner">Owner</td><td class="scenetitle">Title</td><td class="scenedesc">Description</td>';

	while($scene = mysql_fetch_array($q))
	{
		sceneview($scene);
	}

	echo "</table>"
?>
<br />
<br />
&nbsp;
