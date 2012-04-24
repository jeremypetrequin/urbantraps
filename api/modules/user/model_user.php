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
    
    public function getInCity($userID, $villeID) {
        $q = 'SELECT * FROM JoueurVille WHERE Ville_id ='.$villeID.' AND Joueur_id='.$userID;
        
        $tab = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
        return is_array($tab) ? $tab : array();
    }
}

?>
