<?php
//error_reporting(E_ALL);
include_once('../../config/symbini.php');
include_once($serverRoot.'/classes/EOLManager.php');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
  
$submitAction = array_key_exists('submitaction',$_REQUEST)?$_REQUEST['submitaction']:'';
$statusStr = array_key_exists('status',$_REQUEST)?$_REQUEST['status']:'';

$editable = false;
if($isAdmin){
	$editable = true;
}

$eolManager = new EOLManager();
 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
	<title><?php echo $defaultTitle." EOL Manager: "; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset;?>"/>
	<link type="text/css" href="../../css/main.css" rel="stylesheet" />
	<script language=javascript>

	</script>
</head>
<body>
<?php
$displayLeftMenu = (isset($taxa_admin_eoladminMenu)?$taxa_admin_eoladminMenu:"true");
include($serverRoot.'/header.php');
if(isset($taxa_admin_eoladminCrumbs)){
	echo "<div class='navpath'>";
	echo "<a href='../index.php'>Home</a> &gt; ";
	echo $taxa_admin_eoladminCrumbs;
	echo " <b>Encyclopedia of Life Manager</b>";
	echo "</div>";
}
?>
	<!-- This is inner text! -->
	<div id="innertext">
		<h1>Encyclopedia of Life Linkage Manager</h1>
		<?php
		if($statusStr){
			?>
			<hr/>
			<div style="color:red;margin:15px;">
				<?php echo $statusStr; ?>
			</div>
			<hr/>
			<?php 
		}
		if($submitAction){
			?>
			<hr/>
			<div style="margin:15px;">
				<?php
				if($submitAction == 'Map Taxa'){
					$eolManager->mapTaxa();
				}
				?>
			</div>
			<hr/>
			<?php 
		}
		?>
		<div style="margin:15px;">
			<?php 
			if($editable){
				?>
				<fieldset style="padding:15px;">
					<legend><b>Taxa Mapping</b></legend>
					Number of taxa not mapped to EOL: 
					<b><?php echo $eolManager->getEmptyIdentifierCount(); ?></b> 
					<div style="margin:10px;">
						<form name="taxamappingform" action="eolmapper.php" method="post">
							<input type="submit" name="submitaction" value="Map Taxa" />
						</form>
					</div>
				</fieldset>
				<?php 
			}
			elseif(!$symbUid){
				?>
				Please <a href="../../profile/index.php?refurl=../taxa/admin/eolmapper.php">login</a> 
				to acess the EOL Mapper Module
				<?php 
			}
			else{
				?>
				You need Super Administrator permissions to use the EOL Mapper Module
				<?php 
			}
			?>
		</div>
	</div>
	<?php 
	include($serverRoot.'/footer.php');
	?>
</body>
</html>
