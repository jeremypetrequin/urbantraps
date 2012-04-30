<?php
/**
 * @author Badger
 * classe à étendre pour tous les models
 * automatise les actions de bases
 * =>select
 * =>getone
 * =>delete
 * =>update/insert
 * /!\ ne gere pas les liaisons
 * on doit lui fournir le nom de la table, avec setTable
 */

class modelDefault {
    private  $_table;
    private  $_id;
    
    public function __construct() {
        $this->db = Framework::load()->getBDD();
    }
    
    public function setTable($table) {
        $this->_table = $table;
    }
    public function setId($id) {
        $this->_id = $id;
    }
    
    public function getItems() {
        $q = 'SELECT * FROM '.$this->_table;
	return $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function get($id) {
        $q = 'SELECT * FROM '.$this->_table.' WHERE '.$this->_id.'='.$id;
	return $this->db->query($q)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function delete($id) {
        $q = 'DELETE FROM `'.$this->_table.'` WHERE `'.$this->_table.'`.`'.$this->_id.'` = '.$id;
	$this->db->exec($q);
    }
    
    public function insert($tab) {
        if(isset($tab[$this->_id])) {
           $q = "UPDATE `".$this->_table."` SET "; 
           $first = true;
           foreach ($tab as $col => $val) {
               if($col == '' || $col == 'action' || $col == $this->_id) continue;
               if(!$first) $q.=', ';
               $q .= $col ." = '".addslashes($val)."'";
               $first = false;
           }         
           $q .= " WHERE  `".$this->_table."`.`".$this->_id."` =".$tab[$this->_id].";"; 
        } else {
            $q = 'INSERT INTO `'.$this->_table.'` ';
            $first = true;
            $colonnes  = '(';
            $insert = '(';
            foreach ($tab as $col => $val) {
                if($col == '' || $col == 'action') continue;
                if(!$first) $colonnes.=', ';
                $colonnes .= $col;
                
                if(!$first) $insert.=', ';
                
                $insert .= "'".addslashes($val)."'";
                $first = false;
            }
            
            $colonnes  .= ')';
            $insert .= ');';
            $q .= $colonnes;
            $q .= ' VALUES ';
            $q .= $insert;
        }
        //echo $q;
        $this->db->exec($q);
        return $this->db->lastInsertId();
    }
}

?>
