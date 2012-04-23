<?php
/**
 * @date    : April 2011
 * @project : BMS
 *
 * singleton pour la base de donnée
 * utilise PDO
 */
class BDD {
        /**
        * Instance de la classe PDO
        *
        * @var PDO
        * @access private
        */
        private $PDOInstance = null;

        /**
        * Instance de la classe SPDO
        *
        * @var SPDO
        * @access private
        * @static
        */
        private static $instance = null;


        private $_queries = Array();
        private $_nbQueries = 0;

        
        /**
          * Constructeur
          *
          * @param void
          * @return void
          * @see PDO::__construct()
          * @access private
          */
        public function __construct() {
            
                    $this->PDOInstance = new PDO('mysql:dbname='.DB_NAME.';host='.DB_HOST,DB_USER ,DB_PASSWORD);
        }
	 
        /*public function lastInsertId($name = '') {
            return $this->PDOInstance->lastInsertId($name);
        }*/
        
        /*
         * pour pouvoir appelé n'importe quels méthodes de PDO sans les réécrire
         * Pas avec les arguments
         */
        public function __call($method, $arguments) {
            if(isset($arguments[0])) {
                return $this->PDOInstance->$method($arguments);
            } else {
                return $this->PDOInstance->$method(); 
            }
        }
        
        /**
          * Exécute une requête SQL avec PDO
          *
          * @param string $query La requête SQL
          * @return PDOStatement Retourne l'objet PDOStatement
          */
        public function query($query) {
                $this->_queries[$this->_nbQueries]['query'] = $query;
                $before = microtime();
		
                $q = $this->PDOInstance->query($query);
                
                $this->_queries[$this->_nbQueries]['time'] = microtime() - $before;
                $this->_nbQueries++;
                return $q;
        }
	
        public function exec($query) {
                $this->_queries[$this->_nbQueries]['query'] = $query;
                $before = microtime();
                
                $q = $this->PDOInstance->exec($query);
   
                $this->_queries[$this->_nbQueries]['time'] = microtime() - $before;
                $this->_nbQueries++;
                return $q;
        }
        
        private function _getTotalTime() {
            $time = 0;
            foreach ($this->_queries as $query) {
                $time+= $query['time'];
            }
            return $time;
        }
        /*
         * affiche le debugage SQL
         * toutes les requetes SQL, ainsi que leur temps d'éxécution
         */
        public function traceDebug() {
            if(!Framework::load()->config->DEBUGMODE) return;
            echo '<div id="debugSQL"><h4>SQL</h4><p>'.count($this->_queries).' requètes exécutée(s) en '.$this->_getTotalTime().' seconde(s)</p>';
            echo '<table>';
            $i = 0;
            foreach ($this->_queries as $query) {
                echo '<tr>';
                    echo '<td>'.$i.'</td><td>'.$query['time'].' sec</td><td>'.$query['query'].'</td>';
                echo '</tr>';
                $i++;
            }
            
            echo '</table>';
            echo '</div>';

        }
}

?>