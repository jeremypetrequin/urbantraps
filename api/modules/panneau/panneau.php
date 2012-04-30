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
     * url to call http://localhost:8888/urbantraps/api/?p=panneau&task=getJeuPanneau&ville_id=1
     */
    protected function _getJeuPanneau() {
        if(!isset($this->_model)) $this->_model = new model_panneau();
        return $this->_model->getJeuPanneau($_REQUEST['ville_id']);
    }
    
    /**
     *
     * work in progress
     * url to call http://localhost:8888/urbantraps/api/?p=panneau&task=getPanneauVille&ville_id=1
     */
    protected  function _getPanneauVille() {
        if(!isset($_REQUEST['ville_id']) && empty ($_REQUEST['ville_id'])) return;
        
        $this->_model = new model_panneau();
        $data = $this->_model->getPanneauVille($_REQUEST['ville_id']);
        //$jeuByPanneau =  $this->_getJeuPanneau();
        
        $json1 = array();
        //build the json for the response, fucking array!
        foreach ($data as $d) {
            $json1[$d['panneau_ville_id']]['panneau_nom'] = $d['panneau_nom'];
            $json1[$d['panneau_ville_id']]['panneau_img'] = $d['panneau_img'];
            $json1[$d['panneau_ville_id']]['panneau_id'] = $d['panneau_id'];
            $json1[$d['panneau_ville_id']]['lat'] = $d['lat'];
            $json1[$d['panneau_ville_id']]['lng'] = $d['lng'];
            $json1[$d['panneau_ville_id']]['panneau_check'] = $d['panneau_check'];
            $json1[$d['panneau_ville_id']]['jeux'][$d['jeu_id']]['jeu_nom'] = $d['jeu_nom'];
            if(!is_array($json1[$d['panneau_ville_id']]['jeux'][$d['jeu_id']]['leader']) || $d['score_jeu'] > $json1[$d['panneau_ville_id']]['jeux'][$d['jeu_id']]['leader']['score_jeu']) {
                $json1[$d['panneau_ville_id']]['jeux'][$d['jeu_id']]['leader'] = array(
                  "joueur_id" => $d['joueur_id'],  
                  "joueur_nom" => $d['joueur_nom'],  
                  "score_jeu" => $d['score_jeu'],  
                  "joueur_avatar" => $d['joueur_avatar']  
                );
            }
        }
        
        /*
        echo '<pre>';
        print_r($json1);
        echo '</pre>';
        */
        echo json_encode($json1);
        
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
