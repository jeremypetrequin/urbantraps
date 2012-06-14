<?php

include("conf_log.php");
include("db_error.php");

// Affiche un projet en particulier avec son nom et son domaine que l'on peut modifier

// Update ou insertion du projet suivant qu'il y ait son ID en GET
// Affichage du projet si ID en GET
// Redirection sinon

if($_GET['name'] && $_GET['domain']) 
{
	$_GET['id'] ? $id = $_GET['id'] : $id = null;
	dbUpdateProject($connectDBLOG, $id, $_GET['name'], $_GET['domain']);
	header('Location: project.php');
} else {
	if($_GET['project']) { $project = dbSelectOneProject($connectDBLOG, $_GET['project']); }	
}

include("html_beginning.php");
?>
	
<div id="content">
<form action="modifproject.php" method="get">
	<input type="hidden" name="id" value="<?php echo $project['project_id']; ?>" />
	
	<table>
		<tr class="line1">
			<td class="col1">Nom</td>
			<td class="col2"><input type="text" name="name" value="<?php echo $project['project_name']; ?>" /></td>
		</tr>
		<tr class="line2">
			<td class="col1">Domaine <br/><span class="mini">Don't put http://</span></td>
			<td class="col2"><input type="text" name="domain" value="<?php echo $project['project_domain']; ?>" /></td>
		</tr>
	</table>
	
	<input type="submit" value="Enregistrer" />
</form>
</div>

<?php include("html_ending.php"); ?>
