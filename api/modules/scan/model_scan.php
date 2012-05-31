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
    
    public function insertScanForUser($ville_id, $panneau_ville_id, $user_id) {
        //on enregistre le scan
        $q = "INSERT INTO `Scann` (`JoueurVille_id`, `PanneauVille_id`, `Date`) VALUES (
            (SELECT id FROM JoueurVille WHERE Ville_id = ".$ville_id." AND Joueur_id=".$user_id."),
            '".$panneau_ville_id."',
            '".date('Y/m/d H:i:s')."');";
        
        $this->db->exec($q);
        
        //on incremente le nombre de scan du joueur
        $q = "UPDATE `DetailScore` SET `nb_scans` = nb_scans+1 WHERE `DetailScore`.`id_joueur` =".$user_id.";";
        $this->db->exec($q);
        
        //on incremente le nombre de scan du panneau
        $q = "UPDATE `PanneauVille` SET `nb_check` = nb_check+1 WHERE `PanneauVille`.`id` =".$panneau_ville_id;
        $this->db->exec($q);
        
    }
}


?>
