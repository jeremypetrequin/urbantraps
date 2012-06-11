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
        $tab = is_array($tab) ? $tab : array();
        $return = array();
        for($i = 0; $i<count($tab); $i++) {
            $return[$i] = $tab[$i];
            $return[$i]['date'] = $tab[$i]['start'];
        }
        return $return;
    }
    
    /**
     * get an user
     * @param int $id
     * @return array 
     */
    public function getUser($id) {
        $this->setTable('Joueur'); 
        $q = 'SELECT * FROM '.$this->_table.' WHERE '.$this->_id.'='.$id;
        $tab = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
        $tab = is_array($tab) ? $tab : array();
        
        if(count($tab) > 0) {
            $q = "SELECT score, id FROM Joueur ORDER BY score DESC";
            $sc = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
            $sc = is_array($sc) ? $sc : array();
            $tab[0]['total'] = count($sc);
            $tab[0]['classement'] = $tab[0]['total'];
            
            for($i = 0; $i < $tab[0]['total']; $i ++) {
                if($sc[$i]['score'] <= $tab[0]['score']) {
                    $tab[0]['classement'] = $i +1;
                    break;
                }
            }
        }
        
        $modelBadge = new model_badge();
        $badges = $modelBadge->getItems();
        $badges = is_array($badges) ? $badges : array();
        $tab[0]['totalBadge'] = count($badges);
        
        $modelBadge->setTable('BadgeGagne');
        $modelBadge->setId('Joueur_id');
        $badgeUser = $modelBadge->get($tab[0]['id']);
        $badgeUser = is_array($badgeUser) ? $badgeUser : array();
        $tab[0]['badgeJoueur'] = count($badgeUser);
        
        $statutModel = new model_statut();
        $statuts = $statutModel->getStatutUser($tab[0]['id']);
        $statuts = is_array($statuts) ? $statuts : array();
        $tab[0]['statuts_joueurs'] = count($statuts) > 0 ? $statuts : array();
        $tab[0]['statuts'] = $statutModel->getItems();
        
        return $tab;
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
            Jeu.id as jeu_id,
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
