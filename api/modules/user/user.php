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

    } 
    
    /**
     * return json with detail of a user activity
     * url to call http://localhost:8888/urbantraps/api/?p=user&task=activity&user_id=2
     */
    protected  function _activity() {
        if(isset($_REQUEST['user_id'])) {
            $this->_model = new model_user();
            $user_id = $_REQUEST['user_id'];
            
            //get data
            $badges = $this->_model->getBadgeUser($user_id);
            $ajouer = $this->_model->getAJouerJoueur($user_id);
            $mission = $this->_model->getMissionJoueur($user_id);
            
            //handle data
            $json1 = $this->_handleTableauTimeline($ajouer, "Tu as jouer à %game%", "sur un panneau %panneau% à %ville%, et tu as marqué %pts%pts", array(
                'panneau' =>'panneau',
                'game' =>'jeu',
                'ville' =>'ville',
                'pts' =>'score'
            ), 'jouer');
            
            $json2 = $this->_handleTableauTimeline($mission, "Tu as réussi la mission %mission%", "et tu as gagné %pts%pts",array(
                'mission' =>'nom',
                'pts' => 'nb_pts'
            ), 'mission');
            
            $json3 = $this->_handleTableauTimeline($badges, "Tu as gagné le badge %badge%", "", array('badge'=>'nom'), 'badge');
            
            
            //merge all array
            $json = array_merge(array_merge($json1, $json2), $json3);
            
            //sort the big array by date
            $sorter = new array_sorter($json, 'date', false);
            $json = $sorter->sortit();
            
            
            //encode the array for json
            $json = $this->_utf8_encoding_array($json);
            //echo '<pre>';
            //print_r($json);
            //output the json
            die(json_encode($json));
            
        }
    }

    /**
     * encode all value in a array in utf8 (/!\ non recursive!, juste first level)
     * @param array $array 
     * @return array
     */
    private function _utf8_encoding_array($array) {
        $return = array(); 
        foreach ($array as $key => $value) {
            foreach ($value as $k => $v) {
                $return[$key][$k] = utf8_encode($v);
            }
        }

        return $return;
    }
    
    /**
     * used for manage language in timeline
     * @param array $tab
     * @param string $trad_pattern1
     * @param string $trad_pattern2
     * @param array key=>value $trad_field
     * @param string $type
     * @return array 
     */
    private function _handleTableauTimeline($tab, $trad_pattern1, $trad_pattern2, $trad_field, $type) {
        $return = array();
        
        foreach ($tab as $item) {
            $item['type'] = $type;
            $trad1 = $trad_pattern1;
            $trad2 = $trad_pattern2;
            foreach ($trad_field as $pattern=>$f) {
                 $trad1 = str_replace('%'.$pattern.'%', $item[$f], $trad1); 
                 $trad2 = str_replace('%'.$pattern.'%', $item[$f], $trad2); 
            }
            $item['trad1'] = $trad1;
            $item['trad2'] = $trad2;
            
            $return[] = $item;
        }
        
        return $return;
    }
    
    protected function _connect() {
        
        if(isset($_REQUEST['fbk_id'])) {
            $this->_model = new model_user();
            
            if(!empty ($_REQUEST['lng']) && !empty ($_REQUEST['lat'])) {
                $ville = new ville();
                $resultVille = $ville->witchCity($_REQUEST['lat'], $_REQUEST['lng']);
                
                if(is_array($resultVille)) {
                    
                    $this->_model->setId('fbk_id');
                    //check if exist
                    $user = $this->_model->get($_REQUEST['fbk_id']);
                    $user = is_array($user) ? $user  : array();
                    $this->_model->setId('id');

                    
                    if(count($user) == 0) { //insert
                        $id = $this->_model->insert(array(
                            'nom' => $_REQUEST['nom'],
                            'created' => date("Y/m/d H:i:s"),
                            'fbk_id' => $_REQUEST['fbk_id'],
                            'score' => '0',
                            'data' => '',
                            'avatar' => $_REQUEST['avatar']
                        ));
                    } else { //update
                        $id = $user[0]['id'];
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
                    
                    $inCity = $this->_model->getInCity($id, $resultVille['id']);

                    if(count($inCity) == 0) {
                        $insertInCity = array(
                            'Ville_id' =>$resultVille['id'],
                            'Joueur_id' =>$id,
                            'lastconnect' =>date("Y/m/d H:i:s")
                        );
                    } else {
                        $insertInCity = $inCity[0];
                        $insertInCity['lastconnect'] = date("Y/m/d H:i:s");
                    } 
                    
                    $this->_model->setTable('JoueurVille');
                    $this->_model->setId('id');
                    $this->_model->insert($insertInCity);
                    $resultVille['ville_id'] = $resultVille['id'];
                    unset ($resultVille['id']);
                    $resultVille['ville_nom'] = $resultVille['nom'];
                    unset ($resultVille['nom']);
                    
                    $return = array_merge($resultVille, $return);
                    die(json_encode($return));
                } else {
                    die(json_encode(array('error' => 'Pas trouvé la ville')));
                }
            }
            
            
        } else if(isset($_REQUEST['user_id'])) {
            
        } else {
            
        }
    }
}

?>
