<?
	$username="selector";  // We highly suggest the use of a SELECT PERMISSIONS only account.
	$password="db_select"; // This way, there is no security risk. SceneSys doesn't require more at this moment.
	$database="scene";
	$posecount = 0;

	mysql_connect('localhost',$username,$password);
	@mysql_select_db($database) or die( "Unable to select database");
?>
