<?php
/**
 * @date    : April 2012
 * @project : urbanTraps
 * @package : /modules/user
 * @author : Badger
 */

include_once(dirname(__FILE__).'/model_user.php');
include_once(ABSPATH.'/api/modules/ville/ville.php');

class user extends pageDefault {
    private $_model = null;
    
    protected function _get() {
        /*$date = Framework::load()->getTool('Date');
        
        $this->_model = new model_user();
        $ret = $this->_model->getItems();
        $ret = is_array($ret) ? $ret : array();
        
        echo json_encode($ret);*/
    } 
    
    protected function _connect() {
        if(isset($_REQUEST['fbk_id'])) {
            $this->_model = new model_user();
            $this->_model->setId('fbk_id');
            //check if exist
            $user = $this->_model->get($_REQUEST['fbk_id']);
            $user = is_array($user) ? $user  : array();
            
            $this->_model->setId('id');
            if(!empty ($_REQUEST['lng']) && !empty ($_REQUEST['lat'])) {
                $ville = new ville();
                $resultVille = $ville->witchCity($_REQUEST['lat'], $_REQUEST['lng']);
            }
            //echo'<pre>';
            //print_r($resultVille);
            //echo '</pre>';
            if(count($user) == 0) { //insert
                $this->_model->insert(array(
                    'nom' => $_REQUEST['nom'],
                    'created' => date("Y/m/d h:i:s"),
                    'fbk_id' => $_REQUEST['fbk_id'],
                    'score' => '0',
                    'data' => '',
                    'avatar' => $_REQUEST['avatar']
                ));
            } else { //update
                $this->_model->insert(array(
                    'id' => $user[0]['id'],
                    'nom' => $_REQUEST['nom'],
                    'created' => $user[0]['created'],
                    'fbk_id' => $_REQUEST['fbk_id'],
                    'score' => $user[0]['score'],
                    'data' => $user[0]['data'],
                    'avatar' => $_REQUEST['avatar']
                ));
            }
            
            //response
            $this->_model->setId('fbk_id');
            $users = $this->_model->get($_REQUEST['fbk_id']);
            $users = is_array($users) ? $users  : array();
            $return = (count($users) > 0) ? $users[0] : array('error' => "probleme lors de l'enregistrement");
            die(json_encode($return));
        } else if(isset($_REQUEST['user_id'])) {
            
        } else {
            
        }
    }
}

?>
