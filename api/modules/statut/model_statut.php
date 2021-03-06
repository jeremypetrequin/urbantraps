<?php
/**
 * @date    : May 2012
 * @project : urbanTraps
 * @package : /modules/statut
 * @author : Badger
 */

class model_statut extends modelDefault {
    
    public function __construct() {
        parent::__construct();
        parent::setTable('Statut');
        parent::setId('id');
    }
    
    public function getStatutUser($user_id) {
        $q = "SELECT * FROM Statut WHERE nb_points <= (SELECT score FROM Joueur WHERE Joueur.id = ".$user_id." LIMIT 1) ORDER BY nb_points DESC";
        $tab = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
        return is_array($tab) ? $tab : array();
    }
    
     public function getItems() {
        $q = 'SELECT * FROM '.$this->_table.' ORDER BY nb_points';
        return $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
