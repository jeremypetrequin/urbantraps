<?php

include("conf_log.php");
include("db_error.php");

// Affiche la liste des projets qui ont le script d'implanté.

// Traitement de la suppression d'un projet
if($_GET['delete'] == 1 && !empty($_GET['project'])) dbDeleteProject($connectDBLOG, $_GET['project']);

include("html_beginning.php");
?>
		
<div id="content">
<table>
	<tr class="header">
		<th>Nom</th>
		<th>URL</th>
		<th>Op&eacute;rations</th>
	</tr>
	
	<?php
	$projects = dbSelectAllProjects($connectDBLOG);
	$i=0;
	while($row = mysql_fetch_assoc($projects))
	{ ?>
	
	<tr class="line<?php echo $i%2+1; $i++; ?>">
		<td><?php echo $row['project_name']; ?></td>
		<td><a href="http://<?php echo $row['project_domain']; ?>">
			<?php echo $row['project_domain']; ?></a></td>
		<td><a href="modifproject.php?project=<?php echo $row['project_id']; ?>">Update</a>
			<a href="javascript:confirmation('project.php?delete=1&project=<?php echo $row['project_id']; ?>', 
			'Confirm suppression of <?php echo $row['project_name']; ?> ?');">Supprimer</a></td>
	</tr>
	
	<?php } ?>
</table>
</div>

<?php include("html_ending.php"); ?>
