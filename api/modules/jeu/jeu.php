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
include_once(ABSPATH.'/api/modules/user/user.php');


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
       
       if(!is_array($joueurDetailScore) || count($joueurDetailScore) == 0) {
           $this->_model->setId('id');
           $joueurDetailScore = array(
                'id_joueur' => $_REQUEST['joueur'],
               'score_jeu_1' => 0,
               'score_jeu_2' => 0,
               'score_jeu_3' => 0,
               'score_jeu_4' => 0,
               'score_jeu_5' => 0,
               'nb_scans' => 0,
               'nb_badges' => 0,
               'nb_missions' => 0
            );
           
           $user_id_score = $this->_model->insert($joueurDetailScore);
           $joueurDetailScore['id'] = $user_id_score;
            
       } else {
           $joueurDetailScore = $joueurDetailScore[0];
       }
       
       $fieldJeu = 'score_jeu_'.$_REQUEST['jeu_id'];
       
       if($joueurDetailScore[$fieldJeu] < $_REQUEST['score']) {
           
           $this->_model->setId('id');
           $joueurDetailScore[$fieldJeu] = $_REQUEST['score'];
           $this->_model->insert($joueurDetailScore);
       } 
       
       $userController = new user();
       $score = $userController->getScore($_REQUEST['joueur']);
       $this->_model->setId('id');
       $this->_model->setTable('Joueur');
       $this->_model->insert(array(
           'id'=> $_REQUEST['joueur'],
           'score' => $score
       ));
       
       echo json_encode(array('score' =>$userController->getScore($_REQUEST['joueur'])));
       
    } 
    
    protected function _getClassement() {
        $this->_model = new model_jeu();
        
    }
    
   

}

?>
