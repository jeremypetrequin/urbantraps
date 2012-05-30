<?php
/**
 * @date    : April 2012
 * @project : urbanTraps
 * @package : /modules/jeu
 * @author : Badger
 * 
 * 
 */

include_once(dirname(__FILE__).'/model_jeu.php');

class jeu extends pageDefault {
    private $_model = null;
    
    /**
     * url to call http://localhost:8888/urbantraps/api/?p=jeu&task=aJouer&joueur=1&jeu_id=2&score=1029&panneau_ville_id=1
     * 
     * if you want to put your own score, it's the moment!
     */
    protected function _aJouer() {
       $this->_model = new model_jeu();
       
       $this->_model->insert(array(
           'Joueur_id' => $_REQUEST['joueur'],
            'Jeu_id'=>$_REQUEST['jeu_id'],
            'date' => date('Y/m/d H:i:s'),
            'score' =>$_REQUEST['score'],
           'PanneauVille_id' => $_REQUEST['panneau_ville_id']
       ));
       
       $this->_model->setId('id_joueur');
       $this->_model->setTable('DetailScore');
       $joueurDetailScore = $this->_model->get($_REQUEST['joueur']);
       
      /* CREATE TABLE IF NOT EXISTS `DetailScore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_joueur` int(11) NOT NULL,
  `score_jeu_1` int(11) NOT NULL,
  `score_jeu_2` int(11) NOT NULL,
  `score_jeu_3` int(11) NOT NULL,
  `score_jeu_4` int(11) NOT NULL,
  `score_jeu_5` int(11) NOT NULL,
  `nb_badges` int(11) NOT NULL,
  `nb_scans` int(11) NOT NULL,
  `nb_missions` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; */
    } 
    
    protected function _getClassement() {
        $this->_model = new model_jeu();
        
    }
    
   

}

?>
