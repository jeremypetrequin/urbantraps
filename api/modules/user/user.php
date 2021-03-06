<?php
/**
 * @date    : April 2012
 * @project : urbanTraps
 * @package : /modules/user
 * @author : Badger
 */


include_once(dirname(__FILE__).'/model_user.php');
include_once(ABSPATH.'/api/modules/ville/ville.php');
include_once(ABSPATH.'/api/modules/badge/badge.php');
include_once(ABSPATH.'/api/modules/statut/statut.php');

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
            $joueurs = $this->_model->get($user_id);
            $badges = $this->_model->getBadgeUser($user_id);
            $ajouer = $this->_model->getAJouerJoueur($user_id);
            $mission = $this->_model->getMissionJoueur($user_id);
            
            //handle data
            
            $joueur = $joueurs[0];
            $joueur['date'] = $joueur['created'];
            $json0 = $this->_handleTableauTimeline(array($joueur), utf8_decode("Bienvenue!"),"", array(), 'inscription');
            
            $json1 = $this->_handleTableauTimeline($ajouer, utf8_decode("Tu as joué à \"%game%\""), utf8_decode("panneau %panneau%, %ville%"), array(
                'panneau' =>'panneau',
                'game' =>'jeu',
                'ville' =>'ville',
                'pts' =>'score'
            ), 'jouer');
            
            $json2 = $this->_handleTableauTimeline($mission, utf8_decode("%mission%"), utf8_decode("Ta mission : \"%desc%\". Tu as gagné %pts%pts, merci qui?"),array(
                'mission' =>'nom',
                'pts' => 'nb_pts',
                'desc' => 'desc'
            ), 'mission');
            
            $json3 = $this->_handleTableauTimeline($badges, utf8_decode("Tu as gagné le badge \"%badge%\""), "", array('badge'=>'nom'), 'badge');
            
            
            //merge all array
            $json = array_merge(array_merge(array_merge($json1, $json0), $json2), $json3);
            
            //sort the big array by date
            $sorter = new array_sorter($json, 'date', false);
            $json = $sorter->sortit();
            
            
            //encode the array for json
            $json = $this->_utf8_encoding_array($json);
          //  echo '<pre>';
            //print_r($json);
            //output the json
            die(json_encode($json));
        }
    }

    /**
     * encode all value in a array in utf8 (/!\ non recursive!, just first level)
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
    
    public function getScore($user_id) {
        $score = 0;
        $modelScore = new modelDefault();
        $modelScore->setId('id_joueur');
        $modelScore->setTable("DetailScore");
        $scoreDetail = $modelScore->get($user_id);

        if(!is_array($scoreDetail) || count($scoreDetail) == 0) {
            $modelScore->setId('id');
            $scoreDetail = array(
                    'id_joueur' => $user_id,
                    'score_jeu_1' => 0,
                    'score_jeu_2' => 0,
                    'score_jeu_3' => 0,
                    'score_jeu_4' => 0,
                    'score_jeu_5' => 0,
                    'nb_scans' => 0,
                    'nb_badges' => 0,
                    'nb_missions' => 0
                );

            $user_id_score = $modelScore->insert($scoreDetail);
            $scoreDetail['id'] = $user_id_score;

        } else {
            $scoreDetail = $scoreDetail[0];
        }
            
        $score +=$scoreDetail['score_jeu_1'];
        $score +=$scoreDetail['score_jeu_2'];
        $score +=$scoreDetail['score_jeu_3'];
        $score +=$scoreDetail['score_jeu_4'];
        $score +=$scoreDetail['score_jeu_5'];

        $score +=$scoreDetail['nb_badges'] * 20;
        $score +=$scoreDetail['nb_scans'] * 5;
        $score +=$scoreDetail['nb_missions'] * 100;
                    
        return $score;
    }
    /**
     * connect user
     */
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
                    $users = $this->_model->getUser($_REQUEST['fbk_id']);
                    $users = is_array($users) ? $users  : array();
                    $return = (count($users) > 0) ? $users[0] : array('error' => "probleme lors de l'enregistrement");
                    
                    $return['score'] = $this->getScore($id);
                    
                    
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
                    
                    $this->_model->setId('id');
                    $this->_model->setTable('Jeu');
                    $jeux = $this->_model->getItems();
                    
                    $return['jeux'] = array();
                    $i = 0;
                    foreach ($jeux as $jeu) {
                        $return['jeux'][$i] = array(
                            'nb_point' =>$jeu['rarete'], 
                            'nb_scan' =>$jeu['nb_scan'],
                            'nom' => $jeu['nom'], 
                            'id' =>$jeu['id']
                        );
                        $i++;
                    }
                     
                   /* echo '<pre>';
                    print_r($return);
                    echo '</pre>';*/
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
