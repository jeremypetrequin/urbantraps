<?php
/**
 * Sélectionne l'id du projet en fonction du nom de domaine de l'erreur
 * Retourne false si le projet n'est pas présent dans la BDD
 * 
 * @return integer
 */
function dbSelectDomain($con, $domain, $name) {
    
                    $query = "SELECT * FROM error_project WHERE project_domain = '".$domain."';";
                    
	$result = mysql_query($query, $con);
        
	
                    $result_fetch = mysql_fetch_row($result);
	if(!$result_fetch) {
                        $return = false;
	} else {
                        $return = $result_fetch[0];
	}
	
	return $return;
}

/**
 * Vérifie si l'erreur est déjà présente dans la BDD
 * Si c'est le cas, incrémente le compteur d'erreur
 * 
 * @return boolean
 */
function dbVerifyError($con, $msg, $file, $line, $project_id) {
	$query = "SELECT error_id, error_msg, error_file, project_id
		FROM error
		WHERE error_msg = '$msg'
		AND error_file = '$file'
                                        AND error_line = '$line'
		AND project_id = '$project_id';";
	
	$result = mysql_query($query, $con);

	if(!mysql_num_rows($result))
	{
		$return = true;
	} else {
		$return = false;
		$error = mysql_fetch_assoc($result);
		$query_update = "UPDATE error SET error_count = error_count + 1, error_date = UTC_TIMESTAMP() WHERE error_id = ".$error['error_id'];
		mysql_query($query_update, $con);
	}
	
	return $return;
}

/**
 * Insère l'erreur dans la BDD en fonction des différents paramètres reçus
 *
 * @return boolean
 */
function dbInsertError($con, $msg, $line, $file, $domain_id, $nav) {
	$query = "INSERT INTO error 
		(project_id, error_msg, error_line, error_file, error_date, error_browser)
		VALUES ('".$domain_id
		."', '".$msg
		."', '".$line
		."', '".$file
		."', UTC_TIMESTAMP()"
		.", '".$nav
		."');";

	mysql_query($query, $con);

	return true;
}

/**
 * Sélectionne toutes les erreurs de la BDD, en fonction des filtres
 *
 * @return array
 */
function dbSelectAllError($con, $data = "") {
	$query = "SELECT 
		e.error_id, e.error_file,
		e.error_msg, e.error_line,
		e.error_date, e.error_count,
		p.project_domain, p.project_name,
		e.status_id,
                                        Ville.nom as ville,
                                        Joueur.nom as joueur
	FROM 
        error as e 
        LEFT JOIN Ville on  e.error_line = Ville.id
        LEFT JOIN Joueur on e.error_file = Joueur.id,
error_project as p,
		error_dev as d, error_type as t,
		error_status as s
                    
	WHERE
	e.project_id = p.project_id
	AND e.dev_id = d.dev_id
	AND e.type_id = t.type_id
	AND e.status_id = s.status_id";

	$filter = array('p' => 'project', 
		's' => 'status',
		't' => 'type', 
		'd' => 'dev');

	foreach($filter as $k => $f)
	{
		if(is_array($data[$f]) && count($data[$f])>0)
		{ 
			$query .= ' AND ( ' ;
		  
			$sep = '' ;
	  		foreach ( $data[$f] as $id )
	  		{
	  			$query .= $sep.$k.'.'.$f.'_id = '.$id ;
	  			$sep = ' OR ' ;
	  		}
			$query .= ' ) ' ;
	  	}
  	}
  	
  	$query .= " ORDER BY e.error_date DESC";
  	$result = mysql_query($query, $con);
	$i=0;

  	while($data = mysql_fetch_assoc($result)) {
  		$return[$i] = $data;
  		$i++;
  	}

        //echo $query;
  	return $return;
}

/**
 * Sélectionne une seule erreur par son ID
 *
 * @return array
 */
function dbSelectOneError($con, $error_id) {
	$query = "SELECT *
	FROM error as e, error_project as p,
		error_dev as d, error_type as t,
		error_status as s
	WHERE
	e.error_id = $error_id
	AND e.project_id = p.project_id
	AND e.dev_id = d.dev_id
	AND e.type_id = t.type_id
	AND e.status_id = s.status_id";
	
	return mysql_fetch_assoc(mysql_query($query, $con));
}

/**
 * Sélectionne tout le contenu d'une table
 *
 * @return something
 */
function dbListTable($con, $table) {
	$query = "SELECT * FROM error_$table;";
	return mysql_query($query, $con);
}

/**
 * Liste tous les projets de la BDD
 *
 * @return something
 */
function dbSelectAllProjects($con) {
	$query = "SELECT * FROM error_project";
	return mysql_query($query, $con);
}
 
/**
 * Supprime un projet
 *
 * @return true
 */
function dbDeleteProject($con, $id) {
	$query = "DELETE FROM error_project WHERE project_id = $id";
	mysql_query($query, $con);
	
	return true;
}

/**
 * Sélectionne un projet
 *
 * @return array
 */
function dbSelectOneProject($con, $id) {
	$query = "SELECT * FROM error_project WHERE project_id = $id";
	return mysql_fetch_assoc(mysql_query($query, $con));
}

/**
 * Met à jour ou insère un (nouveau) projet
 *
 * @return true
 */
function dbUpdateProject($con, $id, $name, $domain) {
	if($id != null)
	{
		$query = "UPDATE error_project 
			SET project_name = '$name',
			project_domain = '$domain'
			WHERE project_id = $id";
	} else {
		$query = "INSERT INTO error_project
			(project_name, project_domain)
			VALUES ('".$name
			."', '".$domain
			."')";
	}
	
	mysql_query($query, $con);
	return true;
}

/**
 * Sélectionne les erreurs suivant le critère
 *
 * @return something
 */
function dbStatAllError($con, $f) {
	$query = "SELECT 
		e.".$f."_id, e.error_count, f.".$f."_name
		FROM error as e, error_".$f." as f
	WHERE e.".$f."_id = f.".$f."_id";
	
	return mysql_query($query, $con);
}
