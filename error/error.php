<?php
include("conf_log.php");
include("db_error.php");

// On sélectionne une erreur précise
// Si aucun paramètre dans le GET, renvoit à l'index.

if($_GET['e']) { $error = dbSelectOneError($connectDBLOG, $_GET['e']); }
else { header("Location: index.php"); }

include("html_beginning.php");
?>

<div id="content">		
<table>
	<tr class="status line2">
		<td class="col1">Status</td>
		<td class="col2"><?php echo $error['status_name']; ?></td>
	</tr>
	<tr class="line1">
		<td class="col1">Type</td>
		<td class="col2"><?php echo $error['type_name']; ?></td>
	</tr>
	<tr class="line2">
		<td class="col1">Error(s)</td>
		<td class="col2"><?php echo $error['error_msg']; ?></td>
	</tr>
	<tr class="line1">
		<td class="col1">Browser(s)</td>
		<td class="col2"><?php echo $error['error_browser']; ?></td>
	</tr>
	<tr class="line2">
		<td class="col1">OS(s)</td>
		<td class="col2"><?php echo $error['error_browser']; ?></td>
	</tr>
	<tr class="line1">
		<td class="col1">Project</td>
		<td class="col2"><a href="http://<?php echo $error['project_domain']; ?>"><?php echo $error['project_name']; ?></a></td>
	</tr>
	<tr class="line2">
		<td class="col1">File</td>
		<td class="col2"><?php echo $error['status_name']; ?></td>
	</tr>
	<tr class="line1">
		<td class="col1">Similar Error(s)</td>
		<td class="col2"><?php echo $error['error_count']; ?></td>
	</tr>
	<tr class="line2">
		<td class="col1">Developer</td>
		<td class="col2"><?php echo $error['dev_name']; ?></td>
	</tr>
</table>
</div>		

<?php include("html_ending.php"); ?>
