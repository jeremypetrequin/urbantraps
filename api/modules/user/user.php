<?php
/**
 * @date    : April 2012
 * @project : urbanTraps
 * @package : /modules/user
 * @author : Badger
 */

include_once(dirname(__FILE__).'/model_user.php');

class user extends pageDefault {
    private $_model = null;
    
    protected function _get() {
        $date = Framework::load()->getTool('Date');
        
        $this->_model = new model_user();
        $ret = $this->_model->getItems();
        $ret = is_array($ret) ? $ret : array();
        
        echo json_encode($ret);
        
    } 
}

?>
