<?php
/**
 * @date    : April 2011
 * @project : BMS
 * @package : /framework
 * @author : Badger
 *
 * Singleton to Load & initialize the framework
 */

include_once(dirname(__FILE__).'/../../wp-config.php');
include_once(dirname(__FILE__).'/pageDefault.php');
include_once(dirname(__FILE__).'/modelDefault.php');
include_once(dirname(__FILE__).'/date.php');
include_once(dirname(__FILE__).'/HTML.php');
include_once(dirname(__FILE__).'/connexion.php');
include_once(dirname(__FILE__).'/tweet.php');
include_once(dirname(__FILE__).'/image.php');
include_once(dirname(__FILE__).'/maths.php');
include_once(dirname(__FILE__).'/string.php');
include_once(dirname(__FILE__).'/array_sorter.php');
class Framework {
    private static $Framework = null;
    //si on veut alimenter le contenu du debugueur avec des données spéciales
    public $debug = Array();
    
    
    public $Date = null;
    public $BDD = null;
    
    public $APIFlickr = null;
    public $tweet = null;
    public $maths = null;
    public $string = null;


    public $image = null;
    /*
     * return an instance of framework
     */
    public static function load(){
        if(is_null(self::$Framework)) {
            self::$Framework = new Framework();
	}	
        return self::$Framework;
    }
    
    public function __construct() {
        
    }
    /*
    * return the part of framework wanted in $class
    *  availlable : 
    *  => Date 
    *  => String
    */
    public function getTool($class) {
        if(is_null($this->$class)) {
            $this->$class = new $class();
        }
        return $this->$class;
    }
    
    /*
     * display the home page 
     * define in configuration.php
     */
    public function getHome(){
       
    } 
    /*
     * return the HTML framework
     */
    public function getHTMLTools(){
        if(is_null($this->HTML)) {
            $this->HTML = new HTML();
        }
        return $this->HTML;
    }
    
    /*
    * return the BDD framework
    */
    public function getBDD() {
        
        if(is_null($this->BDD)) {
            $this->BDD = new BDD();
        }
        return $this->BDD;
    }
    
    /*
     * affiche le debugage SQL
     */
    public function __destruct() {
        if(!Framework::load()->config->DEBUGMODE) return;
        echo '<div id="debug">';
        //affiche le debugueur SQL
        echo Framework::load()->BDD->traceDebug();   
        //affiche le debugueur sp√©cifique
        foreach ($this->debug as $name => $debugContent) {
            echo '<div id="'.$name.'"><h4>'.$name.'</h4><ul>';
            foreach ($debugContent as $debugLine) {
                echo '<li>'.$debugLine.'</li>';
            }
            echo '</ul></div>';

        }
        
        echo '</div>';
    }
}

?>
