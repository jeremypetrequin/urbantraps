<?php
/**
 * @date    : April 2012
 * @project : urbanTraps
 * @package : /modules/jeu
 * @author : Badger
 * 
 * http://localhost:8888/urbantraps/api/?p=jeu&task=aJouer&joueur=1&panneau_jeu_id=2&score=1029
 */

include_once(dirname(__FILE__).'/model_jeu.php');

class jeu extends pageDefault {
    private $_model = null;
    
    protected function _aJouer() {
       $this->_model = new model_jeu();
       
       $this->_model->insert(array(
           'Joueur_id' => 	$_REQUEST['joueur'],
            'PanneauJeu_id'=>$_REQUEST['panneau_jeu_id'],
            'date' => date('Y/m/d H:i:s'),
            'score' =>$_REQUEST['score']
       ));
    } 
    
    
   

}

?>
