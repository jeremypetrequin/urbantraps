<?php
/**
 * @date    : April 2012
 * @project : urbanTraps
 * @package : /modules/ville
 * @author : Badger
 */

include_once(dirname(__FILE__).'/model_ville.php');

class ville extends pageDefault {
    private $_model = null;
    
    protected function _get() {
       
    } 
    
    public function __construct() {
     
    }
    
    public function witchCity($lat, $lng) {
        $this->_model = new model_ville();
        
        $specific = array(
            'paris' => 75000,
            'lyon' => 69000,
            'marseille' => 13000
        );
        
        //point dans annecy : 45.90792769384896, 6.121273040771484 
        //on regarde si le emc est dans le périmetre d'une ville déjà en BDD
        $cityInDB = $this->_model->getCityNear($lat, $lng);
        if(count($cityInDB) > 0) {
            return $cityInDB[0];
        } else {
            //sinon, on interroge google pour avoir la ville, on regarde si elle existe déjà en BDD, sinon on la crée automatiquement
            $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lng."&sensor=false";
            echo $url;
            $json = file_get_contents($url);
            $reponse = json_decode($json);
            echo '<pre>';
            print_r($reponse);
            $villeName = '';
            $zipCode = '';
            if(isset($reponse->results) && count($reponse->results) > 0) {
                if(isset($reponse->results[0]->address_components) && count($reponse->results[0]->address_components) > 0) {
                    foreach ($reponse->results[0]->address_components as $ret) {
                        
                        if(in_array('locality', $ret->types)) {
                            $villeName = strtolower($ret->short_name);
                        } else if(in_array('postal_code', $ret->types)) {
                            $zipCode = $ret->short_name;
                        }
                    }
                }
            }
            
            $zipCode = isset($specific[$villeName]) ? $specific[$villeName] : $zipCode;
            
            $cityBD = $this->_model->getCity($villeName, $zipcode);
            if(count($cityBD) == 0) {
                /*
                $this->_model->insert(array(
                    'nom' => $villeName,
                    'code_postal' => $zipCode,
                    'lat' => 0,
                    'lng' => 0,
                    'rayon' => 5,
                    'webservice' => 0
                ));*/
            }
            echo '<pre>';
            print_r($cityBD);
            echo '</pre>';
            echo '<br />';
            echo $villeName;
            echo '<br />';
            echo $zipCode;
            echo '<br />';
        }
    }

}

?>
