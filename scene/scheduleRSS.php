<?php
header("Content-Type: application/rss+xml");
require 'ansi.php';
require 'db.php';

$query = "select `id`, `name`, `time`, `title`, `description` from `scene_schedule` ORDER BY `time` DESC";
$result = mysql_query($query, $dbconnect);

while ($line = mysql_fetch_assoc($result))
{
	$return[] = $line;
}

$now = str_ireplace('UTC','UT',date("D, d M Y H:i:s T"));

$output =
"<?xml version=\"1.0\"?>
<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">
<channel>
\t<title>Scene Schedule</title>
\t<link>http://".$_SERVER['HTTP_HOST']."/scene/scheduleRSS.php</link>
\t<description>The schedule for upcoming scenes</description>
\t<language>en-us</language>
\t<pubDate>$now</pubDate>
\t<lastBuildDate>$now</lastBuildDate>
\t<managingEditor>admin@twilightdays.org (Oathkeeper)</managingEditor>
\t<webMaster>admin@twilightdays.org (Oathkeeper)</webMaster>\n
\t<atom:link href=\"http://".$_SERVER['HTTP_HOST']."/scene/scheduleRSS.php\" rel=\"self\" type=\"application/rss+xml\" />\n";
foreach ($return as $line)
{
	$truetime = explode(" ",$line['time']);
	$shorttime = explode(':',$truetime[1]);
  	$output .= "\t<item>\n".
	"\t\t<title>".htmlentities(preg_replace('/<span>|<\/span>/','',ansi2html($line['title'])))."</title>\n".
	"\t\t<link>http://".$_SERVER['HTTP_HOST']."/scene/schedule.php?id=".$line['id']."</link>\n".
	"\t\t<description>\n".
	"<![CDATA[".
	"<b>Player: </b>".htmlentities(strip_tags(ansi2html($line['name']))).nl2br("\n")."\n".
	"<b>Date: </b>".$truetime[0].nl2br("\n")."\n".
	"<b>Time: </b>".$shorttime[0].':'.$shorttime[1].nl2br("\n")."\n".
	htmlentities(strip_tags(ansi2html($line['description']))).
	"]]>".
	"\n\t\t</description>\n".
	"\t\t<guid>http://".$_SERVER['HTTP_HOST']."/scene/schedule.php?id=".$line['id']."</guid>\n".
	"\t</item>\n";
}
$output .= "</channel>\n</rss>";
echo $output;
?>
