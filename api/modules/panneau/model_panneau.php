<?php
/**
 * @date    : April 2012
 * @project : urbanTraps
 * @package : /modules/panneau
 * @author : Badger
 */

class model_panneau extends modelDefault {
    public function __construct() {
        parent::__construct();
        parent::setTable('Panneau');
        parent::setId('id');
    } 
}

?>
