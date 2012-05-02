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
    
    /**
     * @param int $user_id
     * @return array 
     */
    public function getBadgeUser($user_id) {
        $q = "SELECT * FROM BadgeGagne 
            LEFT JOIN Badge ON BadgeGagne.Badge_id = Badge.id
            WHERE Joueur_id = ".$user_id;
        $tab = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
        return is_array($tab) ? $tab : array();
    }
    
    /**
     * @param int $user_id
     * @return array 
     */
    public function getMissionJoueur($user_id) {
        $q = "SELECT * FROM MissionJoueur 
            LEFT JOIN Mission ON MissionJoueur.Mission_id = Mission.id
            WHERE Joueur_id = ".$user_id;
        $tab = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
        return is_array($tab) ? $tab : array();
    }
    
    /**
     * doesn't used
     * @param int $user_id
     * @return array 
     */
    public function getScannJoueur($user_id) {
        $q = "SELECT * FROM Scann WHERE JoueurVille_id IN (SELECT  id FROM JoueurVille WHERE Joueur_id = ".$user_id.")";
        $tab = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
        return is_array($tab) ? $tab : array();
    }
    
    /**
     * @param int $user_id
     * @return array 
     */
    public function getAJouerJoueur($user_id) {
        $q = "SELECT 
            Ville.nom as ville,
            Jeu.nom as jeu,
            PanneauVille.lat as latitude,
            PanneauVille.lng as longitude,
            AJouer.date as date,
            Panneau.nom as panneau,
            Score as score
            FROM AJouer 
            LEFT JOIN PanneauVille ON AJouer.PanneauVille_id = PanneauVille.id
            LEFT JOIN Ville ON PanneauVille.Ville_id = Ville.id
            LEFT JOIN Panneau ON PanneauVille.Panneau_id = Panneau.id
            LEFT JOIN Jeu ON AJouer.Jeu_id = Jeu.id
            WHERE AJouer.Joueur_id = ".$user_id;
        
        $tab = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
        return is_array($tab) ? $tab : array();
    
    }
}

?>
