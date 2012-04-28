<?php
/**
 * @date    : April 2012
 * @project : urbanTraps
 * @package : /modules/jeu
 * @author : Badger
 */

class model_jeu extends modelDefault {
    public function __construct() {
        parent::__construct();
        parent::setTable('AJouer');
        parent::setId('id');
    } 
}

?>
