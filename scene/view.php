<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ascii-bin" />

<!-- Include all the global CSS files -->
<link rel="StyleSheet" href="ansi.css" type="text/css" />
<link rel="StyleSheet" href="scene.css" type="text/css" />
<link rel="alternate" href="scheduleRSS.php" title="Scene System Schedule Feed" type="application/rss+xml" />

<title><?php
	require 'ansi.php';
	require 'db.php';

	mysql_connect('localhost',$username,$password);
	@mysql_select_db($database) or die( "Unable to select database");

	$num = ($_REQUEST['id']  ? $_REQUEST['id'] : $num );
	$ownerscenes = ( $_REQUEST['owner'] ? $_REQUEST['owner'] : $ownerscenes );

	function poseview($scene)
	{
		global $rownum, $posecount;
		echo "\n<tr class=\"$rownum\" id=\"".$scene['pose_id']." pose".($scene['ignore']? ' ignore':'')."\">";
		$views = array(	 'order_id'   => $_REQUEST['showid']
						,'poser_name' => '1'
						,'pose_time'  => $_REQUEST['showtime']
						,'pose_penn'  => '1');
		foreach ($views as $view => $value)
		{
			if($value != false && $value != "false")
			echo "\n\t<td class=\"$view pose\">".ansi2html($scene[$view])."</td>";
		}
		echo "\n</tr>";
		$rownum = ($rownum == "even" ? "odd" : "even");
		$posecount++;
	}

	$errorquery = mysql_query("SELECT `scene_id` FROM `scene_config` WHERE scene_id='$num' AND NOT `scene_private`='1'") or die(mysql_error());
	$errortest = mysql_num_rows($errorquery);

	if(!$errortest)
	{
		$error = true;
		echo "SceneSys: Listing";
	}
	else
	{
		$error = false;
		echo "SceneSys: Scene #$num";
	}
?>
</title>
</head>
<!-- Main body starts here -->
<body>
	<table id="sceneheader" align="center" cellspacing="3" cellpadding="3" >
    	<tr>
        	<td><a href="view.php"title="Scene Listing"/>Scene Listing</a></td>
            <td>||</td>
        	<td><a href="schedule.php"title="Scene System Schedule"/>Scene Schedule</a></td>
            <td>||</td>
            <td><a rel="alternate" href="scheduleRSS.php" title="Scene System Schedule Feed" type="application/rss+xml" />Scene Schedule RSS</a></td>
        </tr>
    </table> 
<?php

	if(!$error)
	{
		/* The header */
		// echo '<center><img src="header-city.png" style="opacity:0.9;filter:alpha(opacity=90)"/></center>';

                $location = mysql_fetch_array(mysql_query("SELECT pose_room_name FROM `scene_poses` WHERE `scene_id`='$num' GROUP BY `pose_room_name` ORDER BY count(*) DESC LIMIT 1")) or die(mysql_error());
                $location = $location[0];

		$title = mysql_fetch_assoc(mysql_query("SELECT * FROM `scene_config` WHERE scene_id='$num' AND NOT `scene_private`='1'")) or die(mysql_error());
		echo '<table border="0" cellpadding="1" align="center" id="sceneheader">';
		echo '<tr><td><font size="5">'.( $title["scene_title"] ? "$title[scene_title]" : "No title.")."</font></td></tr>";
		echo '<tr><td>'." (".substr($title["scene_ctime"],0,10)." - ";
	    echo ( $title["scene_etime"] && $title["scene_etime"] !== "0000-00-00 00:00:00" ? 
			   substr($title["scene_etime"],0,10).")":"Now)");
		echo '</td></tr>';
		echo '<tr><td width="400">'.( $title["scene_desc"] ? "$title[scene_desc]" : "No description.")."</td></tr>";
		echo "</table>";

		/* Scene pose views follow below */
		echo "\n<table border=\"0\" cellpadding=\"2\" cellspacing=\"3\" class=\"posetable\" id=\"posetable\" align=\"left\">";
		$rownum = even;
		$posecount = 0;
		$q = mysql_query("SELECT * FROM `scene_poses` WHERE scene_id='$num' AND `ignore`='0' ORDER BY `order_id`") or die(mysql_error());
		if(!$q)
			echo "Something went wrong!";
		while($scene = mysql_fetch_array($q))
		{
			poseview($scene);
		}
		echo "\n</table>\n<!-- footer -->\n";
		echo "<div id=\"scene_info\">";
		/* Footer */
		echo "<br/>&nbsp;<br/>This scene contained $posecount poses.";
		$present = mysql_query("SELECT DISTINCT `poser_id`,`poser_name` FROM `scene_poses` WHERE scene_id='$num' ORDER BY `poser_id`") or die(mysql_error());
		$lastpresent = '';
		$open = false;
		$total = '';
		$first = true;
		while($number = mysql_fetch_array($present) )
		{
			if($number["poser_id"]!=$lastpresent)
			{
				if($open)
					$total .= ')';
				if($first)
				{
					$first = false;
					$total = "$number[poser_name]";
				}
				else 
					$total .= ", $number[poser_name]";
				$open = false;
			}
			else if(!$open)
			{
				$total .= " (Aka: $number[poser_name]";
				$open = true;
			}
			else
				$total .= " &amp; $number[poser_name]";
			$lastpresent = $number["poser_id"];
		}
		$total = preg_replace('/,([^,]+)\./',", \\1",$total.($open?").":"."));
		echo "&nbsp;The players who were present were: ".ansi2html($total)."<br>";
//		echo 'Click this link to go to the wiki-ready version of this log: <a target="_blank" href="view_wiki.php?id='.$num.'">link</a>.';

		$fullformat = "";

                $q = mysql_query("SELECT * FROM `scene_poses` WHERE scene_id='$num' AND `ignore`='0' ORDER BY `order_id`") or die(mysql_error());
                if(!$q)
                     echo "Something went wrong!";
                while($scene = mysql_fetch_array($q))
                {
                        $fullformat .= ":'''[[".$scene['poser_name']."]] has posed:'''&lt;br&gt;".preg_replace("/<(.+?)>/","&lt;\\1&gt;",ansi2html($scene['pose_penn']))."<br> <br>\n\n";
                }
                $fullformat = str_replace("\n\r","%0D%0A",$fullformat);
                $fullformat = str_replace('"','&quot;',$fullformat);

                ?>

		<form action="../wiki/index.php/Special:FormEdit/Roleplaying Log/<?php echo $title['scene_title'] ?>" method="POST">
		<input type="hidden" name="target" value="<?php echo $title['scene_title']?>">
		<input type="hidden" name="form" value="Roleplaying Log">
		<input type="hidden" name="Log Header[pretty]" value="yes">
		<input type="hidden" name="Log Header[Date of Scene]" value="<?php echo substr($title["scene_ctime"],0,10); ?>">
		<input type="hidden" name="Log Header[Location]" value="<?php echo $location; ?>">
		<input type="hidden" name="Log Header[Cast of Characters]" value="<?php echo $total; ?>">
		<input type="hidden" name="Log Header[Synopsis]" value="<?php echo preg_replace('/&/','&amp;',$title['scene_desc']); ?>">
		<input type="hidden" name="Poses[Poses]" value="<?php echo $fullformat; ?>">
		<?php
	        if($title['scene_title']) {
                	echo "<input id='logsubmit' type='submit' value='Submit Log to Wiki'>";
        	}
	        else {
                	echo "<input id='logsubmit' type='submit' value='No Scene Title' disabled>";
        	}
		?>
	</form>
	<?php
	}
	else
	{
		/*  THIS IS THE FULL SCENE LISTING  */
		include 'pagelisting.php';
	}
	echo "</div>";
?>
</body>
</html>
