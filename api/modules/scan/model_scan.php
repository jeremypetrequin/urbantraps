<?php
/**
 * @date    : May 2012
 * @project : urbanTraps
 * @package : /modules/scan
 * @author : Badger
 */

class model_scan extends modelDefault {
    
    public function __construct() {
        parent::__construct();
        parent::setTable('Scann');
        parent::setId('id');
    } 
}

?>
