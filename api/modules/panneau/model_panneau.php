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
    
    /**
     * return list of panneau of a city, with game availlable on it
     * @param int $ville_id
     * @return array 
     */
    public function getJeuPanneau($ville_id) {
        $q = "SELECT *, PanneauVille.id as panneau_ville_id, Jeu.id as jeu_id FROM PanneauVille, Jeu
                   WHERE Jeu.rarete <= PanneauVille.nb_check
                   AND PanneauVille.Ville_id = ".$ville_id;
        
        $datas = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
        $datas = is_array($datas) ? $datas : array();
        $panneaux_id = array();
        $return = array();
        foreach($datas as $d) {
            $return[$d['panneau_ville_id']]['panneau_id'] = $d['Panneau_id'];
            $return[$d['panneau_ville_id']]['lat'] = $d['lat'];
            $return[$d['panneau_ville_id']]['lng'] = $d['lng'];
            $return[$d['panneau_ville_id']]['jeux'][] = array(
                'jeu' => $d['nom'],
                'id' => $d['jeu_id']
            );
        }
        return $return;
    }
    
    public function getPanneauNear($lat, $lng, $panneau_id) {
        
         $q = "SELECT *,
               (((acos(sin((".$lat."* pi() / 180)) * sin((lat * pi() / 180)) +
                       cos((".$lat." * pi() / 180)) * cos((lat * pi() / 180)) * 
                       cos((".$lng."  - lng) * pi() / 180))
                 ) * 180 / pi()
                ) * 60 * 1.1515 * 1.609344 * 1000
               ) as distance
          FROM PanneauVille
          WHERE Panneau_id = ".$panneau_id."
        HAVING distance < 40
        ORDER BY distance ASC
         LIMIT 0, 10";
         
         $tab = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
         return is_array($tab) ? $tab : array();
    }
    
    /**
     * load lot of things for a city
     * @param int $ville_id 
     * @return array 
     */
    public function getPanneauVille($ville_id) {
        $q = "  SELECT 
                    Panneau.nom as panneau_nom,
                    Panneau.img as panneau_img,
                    
                    PanneauVille.Panneau_id as panneau_id,
                    PanneauVille.id as panneau_ville_id,
                    PanneauVille.lat as lat,
                    PanneauVille.lng as lng,
                    PanneauVille.nb_check as panneau_check,
                    Joueur.id as joueur_id,
                    Joueur.nom as joueur_nom,
                    Joueur.avatar as joueur_avatar,

                    Jeu.nom as jeu_nom,
                    Jeu.id as jeu_id,

                    AJouer.score as score_jeu 

                    FROM PanneauVille
                    LEFT JOIN AJouer ON AJouer.PanneauVille_id = PanneauVille.id
                    LEFT JOIN Jeu ON Jeu.id = AJouer.jeu_id
                    LEFT JOIN Panneau ON PanneauVille.Panneau_id = Panneau.id
                    LEFT JOIN Joueur ON AJouer.joueur_id = Joueur.id 
                    WHERE PanneauVille.VIlle_id=".$ville_id."
                    ORDER BY PanneauVille.id";
        $tab = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
        return is_array($tab) ? $tab : array();
    }
    
    
    public function getPanneauVilleDetail($panneau_ville_id) {
        $q = "  SELECT 
                    Panneau.nom as panneau_nom,
                    Panneau.img as panneau_img,
                    
                    PanneauVille.Panneau_id as panneau_id,
                    PanneauVille.id as panneau_ville_id,
                    PanneauVille.lat as lat,
                    PanneauVille.lng as lng,
                    PanneauVille.nb_check as panneau_check,
                    Joueur.id as joueur_id,
                    Joueur.nom as joueur_nom,
                    Joueur.avatar as joueur_avatar,

                    Jeu.nb_scan as nb_scan,
                    Jeu.rarete as nb_point,
                    Jeu.nom as jeu_nom,
                    Jeu.id as jeu_id,

                    AJouer.score as score_jeu 

                    FROM PanneauVille
                    LEFT JOIN AJouer ON AJouer.PanneauVille_id = PanneauVille.id
                    LEFT JOIN Jeu ON Jeu.id = AJouer.jeu_id
                    LEFT JOIN Panneau ON PanneauVille.Panneau_id = Panneau.id
                    LEFT JOIN Joueur ON AJouer.joueur_id = Joueur.id 
                    WHERE PanneauVille.id=".$panneau_ville_id."
                    ORDER BY PanneauVille.id";
        $tab = $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
        //echo $q;
        return is_array($tab) ? $tab : array();
    }
}

?>
