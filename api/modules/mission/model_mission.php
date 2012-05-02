<?php
/**
 * @date    : May 2012
 * @project : urbanTraps
 * @package : /modules/mission
 * @author : Badger
 */

class model_mission extends modelDefault {
    
    public function __construct() {
        parent::__construct();
        parent::setTable('MissionJoueur');
        parent::setId('id');
    } 
}

?>
