<?php
/**
 * @date    : May 2012
 * @project : urbanTraps
 * @package : /modules/scan
 * @author : Badger
 * 
 * 
 * this module doesn't work
 */

include_once(dirname(__FILE__).'/model_scan.php');

class scan extends pageDefault {
    private $_model = null;
    
    /**
     * add scann in BDD
     * url to call http://localhost:8888/urbantraps/api/?p=scan&task=scan&panneau_ville_id=1&joueur_ville_id=2
     */
    protected function _scan() {
        $this->_model = new model_scan();
        
        $this->_model->insert(array(
              'JoueurVille_id'=>$_REQUEST['joueur_ville_id'],
              'PanneauVille_id'=>$_REQUEST['panneau_ville_id'],
              'Date' => date('Y/m/d H:i:s')
        ));
    }


}

?>
