<?php
/**
 * @date    : May 2012
 * @project : urbanTraps
 * @package : /modules/mission
 * @author : Badger
 * 
 * 
 * this module doesn't work
 */

include_once(dirname(__FILE__).'/model_mission.php');

class mission extends pageDefault {
    private $_model = null;
    
    /**
     * when user receive a mission
     * url to call http://localhost:8888/urbantraps/api/?p=mission&task=hasMission&mission_id=1&joueur_id=2
     */
    protected function _hasMission() {
        $this->_model = new model_mission();
        
        $this->_model->insert(array(
              'Joueur_id'=>$_REQUEST['joueur_id'],
              'Mission_id'=>$_REQUEST['mission_id'],
              'start' => date('Y/m/d H:i:s')
        ));
    }

    /*
     * create a mission in BDD
     * url to call http://localhost:8888/urbantraps/api/?p=mission&task=addMission&nom=Mission 1&desc=lorem ipsum dolor sit amet&duree=30&nb_pts=200 
     */
    protected  function _addMission() {
        $this->_model = new model_mission();
        $this->_model->setTable('Mission');
        $this->_model->setId('id');
        
        $this->_model->insert(array(
          'nom' => $_REQUEST['nom'],
          'desc' => $_REQUEST['desc'],
          'duree' => $_REQUEST['duree'],
           'nb_pts' => $_REQUEST['nb_pts']
        ));
    }
}

?>
