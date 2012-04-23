<?php
/**
 * @date    : April 2012
 * @project : urbanTraps
 * @package : /modules/user
 * @author : Badger
 */

class model_user extends modelDefault {
    public function __construct() {
        parent::__construct();
        parent::setTable('Joueur');
        parent::setId('id');
    }    
}

?>
