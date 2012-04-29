<?php
/**
 * @date    : April 2012
 * @project : urbanTraps
 * @package : /modules/panneau
 * @author : Badger
 * 
 * http://www1.securiteroutiere.gouv.fr/signaux/famille.asp?sFamille=2&sSFamille=3
 * 
 * 
 */

include_once(dirname(__FILE__).'/model_panneau.php');

class panneau extends pageDefault {
    private $_model = null;
    
    /**
     * add type of panneau in BDD
     * url to call http://localhost:8888/urbantraps/api/?p=panneau&task=addPanneau&nom=sens%20interdit&famille=1&img=foo
     */
    protected function _addPanneau() {
        $this->_model = new model_panneau();
        
        $this->_model->insert(array(
              'nom'=>$_REQUEST['nom'],
              'picto'=>$_REQUEST['img'],
              'img' => $_REQUEST['img'],
              'FamillePanneau_id' => $_REQUEST['famille']
        ));
    }
    
    /**
     * print all panneau in a city, with game availlable on it
     * url to call http://localhost:8888/urbantraps/api/?p=panneau&task=getJeuPanneau&city=1
     */
    protected function _getJeuPanneau() {
        $this->_model = new model_panneau();
        echo '<pre>';
        print_r($this->_model->getJeuPanneau($_REQUEST['city']));
        echo '</pre>';
    }
    
    /**
     *
     * work in progress
     */
    protected  function _getPanneauVille() {
        $this->_model = new model_panneau();
        if(!isset($_REQUEST['ville_id']) && empty ($_REQUEST['ville_id'])) return;
        $data = $this->_model->getPanneauVille($_REQUEST['ville_id']);
    }

    /**
     * add panneau in a city
     * http://localhost:8888/urbantraps/api/?p=panneau&task=addPanneauVille&panneau_id=1&ville_id=1&lat=6.309&lng=40.309
     */
    protected  function _addPanneauVille() {
        $this->_model = new model_panneau();
        $this->_model->setTable("PanneauVille");
        $this->_model->setId("id");
        
        $this->_model->insert(array(
            'Panneau_id' => $_REQUEST['panneau_id'],
            'Ville_id' => $_REQUEST['ville_id'],
            'lat' => $_REQUEST['lat'],
            'lng' => $_REQUEST['lng'],
            'nb_check' => 0
        ));
    }
    
   

}

?>
