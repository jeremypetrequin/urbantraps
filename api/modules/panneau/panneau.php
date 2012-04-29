<?php
/**
 * @date    : April 2012
 * @project : urbanTraps
 * @package : /modules/panneau
 * @author : Badger
 * 
 * http://localhost:8888/urbantraps/api/?p=panneau&task=addPanneau&nom=sens%20interdit&famille=1&img=eodkoekded
 */

include_once(dirname(__FILE__).'/model_panneau.php');

class panneau extends pageDefault {
    private $_model = null;
    
    protected function _addPanneau() {
        $this->_model = new model_panneau();
        
        $this->_model->insert(array(
              'nom'=>$_REQUEST['nom'],
              'picto'=>$_REQUEST['img'],
              'img' => $_REQUEST['img'],
              'FamillePanneau_id' => $_REQUEST['famille']
        ));
    }
    
   

}

?>
