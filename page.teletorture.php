<?php 
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }

$debug = false;

if (isset($_POST['save'])) {
	$action = 'save'; 
} else {
	$action = 'edit';
}

$ext = isset($_POST['ext']) ? $_POST['ext'] :  '';
$enabled = isset($_POST['enabled']) ? (!empty($_POST['enabled'])) : true;
$blacklist = isset($_POST['blacklist']) ? (!empty($_POST['blacklist'])) : true;

switch ($action) {
	case 'save':
		$astman->database_put('teletorture','featurecode',$ext);
		$astman->database_put('teletorture','enabled',$enabled);
		$astman->database_put('teletorture','blacklist',$blacklist);
		needreload();
		break;
	case 'edit':
		$ext = $astman->database_get('teletorture','featurecode');
		$enabled = $astman->database_get('teletorture','enabled');
		$blacklist = $astman->database_get('teletorture','blacklist');
		break;
}

if($debug) {
	echo "Feature Code: ".$astman->database_get('teletorture','featurecode')."<br>";
	echo "Enabled: ".$astman->database_get('teletorture','enabled')."<br>";
	echo "Blacklist: ".$astman->database_get('teletorture','blacklist')."<br>";
}

echo "<h2>"._("Configure Telemarketer Torture Module")."</h2>";

$helptext = _("");
echo $helptext;
?>

<form name="editTelemarket" action="<?php  $_SERVER['PHP_SELF'] ?>" method="post"> 
	<table>
		<tr><td colspan="2"><h5><?php echo _("Configuration") ?><hr></h5></td></tr>
		<tr>
			<td><a href="#" class="info"><?php echo _("Feature Code")?>:<span><?php echo _("The feature code/extension users can dial to access this application. This can also be modified on the Feature Codes page.")?></span></a></td>
			<td><input type="text" class="extdisplay" name="ext" value="<?php echo $ext; ?>"/></td>
		</tr>
		<tr>
			<td><a href="#" class="info"><?php echo _("Feature Status")?>:<span><?php echo _("If this code is enabled or not.")?></span></a></td>
			<td><select name="enabled">
			<option value="1" <?php if ($enabled) echo "SELECTED"; ?>><?php echo _("Enabled");?></option>
			<option value="0" <?php if (!$enabled) echo "SELECTED"; ?>><?php echo _("Disabled");?></option>
			</select></td>
		</tr>
		<tr>
			<td><a href="#" class="info"><?php echo _("Blacklist?")?>:<span><?php echo _("Should we add the numbers to the blacklist so they go to ZapaTeller if they call again")?></span></a></td>
			<td><select name="blacklist">
			<option value="1" <?php if ($blacklist) echo "SELECTED"; ?>><?php echo _("Yes");?></option>
			<option value="0" <?php if (!$blacklist) echo "SELECTED"; ?>><?php echo _("No");?></option>
			</select></td>
		</tr>
	
		<tr>
			<td colspan="2"><br><input name="save" type="submit" value="<?php echo _("Submit Changes")?>">
			</td>		
			
		</tr>
	</table>
</form>
