<?php error_reporting(E_ALL); ?>
<?php  //error_reporting(0);  ?>
<?php
/**
 * @TODO : authentification key
 */   
include_once(dirname(__FILE__).'/framework/framework.php');

$class = (isset($_REQUEST['p']) && $_REQUEST['p']!= '' && !strstr($_REQUEST['p'], 'http://')) ? $_REQUEST['p'] : 'user';
if(is_file(dirname(__FILE__).'/modules/'.$class.'/'.$class.'.php')) {
   include(dirname(__FILE__).'/modules/'.$class.'/'.$class.'.php');
   $page = new $class(); 
} else {
    die(json_encode(array('error' => 'Fichier introuvable')));
} 

?>