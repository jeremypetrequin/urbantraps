<?php

include("conf_log.php");
include("db_error.php");

$filter = array(
	'project' => "Projets", 
	'status' => "Statut", 
	'type' => "Type", 
	'dev' => "D&eacute;veloppeur");

// Traitement des filtres, pour permettre un affichage plus précis

if(count($_POST)>0)
{   
    $data[] = array() ;
    
    foreach($filter as $f => $name)
    {
		if (!empty($_POST["filter_$f"]) && count($_POST["filter_$f"])>0) 
		{
			foreach ($_POST["filter_$f"] as $v) 
			{
				if (!empty($v))
				{
					$data[$f][$v] = $v ;
				}
		  	}
		}
	}
}

include("html_beginning.php");
?>
		
<div id="content">
<form name="modif" action="index.php" method="post" id="filtres">
<?php
	// On affiche un formulaire permettant de sélectionner différents filtres pour
	// trier les erreurs suivants différents critères
	
	foreach($filter as $f => $name)
	{ ?>
		<div class="filtre"><h3><?php echo $name; ?></h3>
		<select multiple="multiple" name="filter_<?php echo $f; ?>[]">
			<?php
				$list = dbListTable($connectDBLOG, $f);
				
				$i=0;
				while($row = mysql_fetch_assoc($list))
				{
					if(!empty($data[$f][$row[$f."_id"]])) {
						$selected = ' selected="selected"'; $i++; }
					else { $selected = ''; }
					printf('<option value="%s" %s>%s</option>',
						$row[$f."_id"],
						$selected,
						$row[$f."_name"]);
				}
			?>
		</select></div>
	<?php } ?>
	
	<input type="submit" name="btnsort" value="Trier"/>
</form>

<hr class="visualClear"/>

<h3 style="margin-left: 30px">Logs d'erreur</h3>
<table id="legende">
	<tr><td colspan="2" align="center"><b>L&eacute;gende</b></td></tr>
	<tr>
		<td><div class="line11"></div>
		<div class="line12"></div></td>
		<td>A corriger</td>
	</tr>
	<tr>
		<td><div class="line21"></div>
		<div class="line22"></div></td>
		<td>En prog&egrave;s</td>
	</tr>
	<tr>
		<td><div class="line31"></div>
		<div class="line32"></div></td>
		<td>Trait&eacute;e</td>
	</tr>
	<tr>
		<td><div class="line41"></div>
		<div class="line42"></div></td>
		<td>Urgent</td>
	</tr>
</table>

<table>
	<tr class="header">
		
		<th width="35%" class="col2"><b>Erreur</b></th>
                                        <th width="10%" class="col1"><b>Ville</b></th>
                                        <th width="10%" class="col1"><b>User</b></th>
		<th width="20%" class="col1"><b>Derni&egrave;re</b></th>
		<th width="10%" class="col2"><b>Nombre</b></th>
	</tr>

	<?php 
		// Sélectionne toutes les erreurs en fonction des filtres récupérés
		$error = dbSelectAllError($connectDBLOG, $data);
		if($error != null) {
			$i = 0;
			foreach ($error as $row) 
			{ ?>
		
			<tr class="line<?php echo $row['status_id'].$i%2+1; $i++; ?>">
				
				<td align="left" class="col2">
                                    <a href="error.php?e=<?php echo $row['error_id']; ?>"><?php echo utf8_decode($row['error_msg']); ?></a>
					
				</td>
                                                                                <td align="center" class="col1"><?php echo ucfirst($row['ville']); ?></td>
                                                                                <td align="center" class="col1"><?php echo $row['joueur']; ?></td>
				<td align="center" class="col1"><?php echo $row['error_date']; ?></td>
				<td align="center" class="col2"><?php echo $row['error_count']; ?></td>
			</tr>
		
		<?php } 
		} else { ?>
			<tr><td colspan="4" align="center">Aucun r&eacute;sultat</td></tr>
		<?php } ?>
</table>
</div>		

<?php include("html_ending.php"); ?>
