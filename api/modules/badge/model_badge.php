<?php
/**
 * @date    : May 2012
 * @project : urbanTraps
 * @package : /modules/badge
 * @author : Badger
 */

class model_badge extends modelDefault {
    
    public function __construct() {
        parent::__construct();
        parent::setTable('Badge');
        parent::setId('id');
    } 
}

?>
