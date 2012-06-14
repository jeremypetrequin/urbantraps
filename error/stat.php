<?php
include("conf_log.php");
include("db_error.php");

function graphStatAllError($con, $filter, $title) 
{
	$error_query = dbStatAllError($con, $filter);
	$error = array();
	
	// Récupération des données dans la BDD
	while($row = mysql_fetch_assoc($error_query)) { 
		$error[$row[$filter.'_id']]['count'] += $row['error_count'];
		$error[$row[$filter.'_id']]['name'] = $row[$filter.'_name'];
	}
	
	// Affichage des données sous forme de camembert (jqplot.PieRenderer)
	echo '<h3>R&eacute;partition des erreurs par '.$title.'</h3>
	<div id="all_'.$filter.'" style="width: 500px; height: 400px;" class="jqplot-target"></div>
	

	<script>
	$(document).ready(function(){
		var data = [';
			foreach($error as $v)
			{
				echo "['".$v['name']."', ".$v['count']."], ";
			}
		echo '];
	
		var graph = jQuery.jqplot ("all_'.$filter.'", [data], 
		{ 
			seriesDefaults: {
				renderer: jQuery.jqplot.PieRenderer, 
				rendererOptions: {
					showDataLabels: true
				}
			}, 
			legend: { show:true, location: "e" }
		});
	});
	</script>';
	
	return true;
}

include("html_beginning.php");
?>

<div id="stat">
	<div class="graph"><?php graphStatAllError($connectDBLOG, "project", "projet"); ?></div>
	<div class="graph"><?php graphStatAllError($connectDBLOG, "status", "statut"); ?></div>
	<div class="graph"><?php graphStatAllError($connectDBLOG, "type", "type"); ?></div>
	
	<?php // Ajout des plug-ins jqPlot nécessaires ?>
	<script type="text/javascript" src="js/jqplot.pieRenderer.min.js"></script>

</div>
<?php include("html_ending.php"); ?>
