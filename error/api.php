<?php
header("Access-Control-Allow-Origin: *"); 
/**
 * save in database, send by mail, whatever you want!
 * $_GET['msg'] => error message
 * $_GET['line'] => line of error, may be empty
 * $_GET['file'] => url of file, may be empty
 * $_GET['domain'] => domain from
 */

include("conf_log.php");
include("db_error.php");

/**
 * On traite d'abord les données
 * Ensuite le projet est vérifié, et on renvoie son ID s'il existe
 * Puis, l'erreur est vérifié pour voir si elle existe déjà dans la BDD
 * Finalement, si les tests sont passés, on insère l'erreur.
 */

//bidouillage & co

$_GET['error'] 	? $msg = $_GET['error']		: $msg = "unknown";
$_GET['user_id']	? $file = $_GET['user_id']	: $file = "";
$_GET['city_id']	? $line = $_GET['city_id']	: $line = "";

$title = 'urbantraps';
$domain = "urbantraps.fr";

$domain_id = dbSelectDomain($connectDBLOG, $domain, $title);

$msg = $_GET['error'] . 'on '.$_GET['device'].' ('.$_GET['osversion'].') (line '.$_GET['line'].' on file '.$_GET['file'].')';




if($domain_id) {
	if(dbVerifyError($connectDBLOG, $msg, $file, $line, $domain_id)) {
                            
		dbInsertError($connectDBLOG, $msg, $line, $file, $domain_id, $nav);
	}
}

//print_r($_GET);
?>
