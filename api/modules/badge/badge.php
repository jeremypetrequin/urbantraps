<?php
/**
 * @date    : May 2012
 * @project : urbanTraps
 * @package : /modules/badge
 * @author : Badger
 * 
 */

include_once(dirname(__FILE__).'/model_badge.php');

class badge extends pageDefault {
    private $_model = null;
    
    /**
     * add new badge in BDD
     * url to call http://localhost:8888/urbantraps/api/?p=badge&task=addBadge&nom=captain&icone=foo&hidden=0&condition=lorem ipsum
     */
    protected function _addBadge() {
        $this->_model = new model_badge();
        $this->_model->insert(array(
              'nom'=>$_REQUEST['nom'],
              'icone'=>$_REQUEST['icone'],
              'hidden' => $_REQUEST['hidden'],
              'condition' => $_REQUEST['condition']
        ));
    }
    
    /**
     * a player win a badge
     * url to call http://localhost:8888/urbantraps/api/?p=badge&task=winABadge&badge_id=1&user_id=1
     */
    protected function _winABadge() {
        $this->_model = new model_badge();
        $this->_model->setTable("BadgeGagne");

        $this->_model->insert(array(
            'Badge_id' => $_REQUEST['badge_id'],
            'Joueur_id' => $_REQUEST['user_id'],
            'date' => date('Y/m/d H:i:s')
        ));
    }

}

?>
