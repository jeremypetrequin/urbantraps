<?php
/**
 * @date    : May 2012
 * @project : urbanTraps
 * @package : /modules/badge
 * @author : Badger
 * 
 */

include_once(dirname(__FILE__).'/model_statut.php');

class statut extends pageDefault {
    private $_model = null;
    
    /**
     * add new badge in BDD
     * url to call http://localhost:8888/urbantraps/api/?p=statut&task=addStatut&nom=captain&icone=foo&nb_points=200
     */
    protected function _addStatut() {
        $this->_model = new model_statut();
        $this->_model->insert(array(
              'nom'=>$_REQUEST['nom'],
              'nb_points'=>$_REQUEST['nb_points'],
              'icone' => $_REQUEST['icone']
        ));
    }
}

?>
