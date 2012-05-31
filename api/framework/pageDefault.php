<?php
/**
 * @date    : April 2011
 * @project : BMS
 * @package : /framework
 * @author : Badger
 * 
 * class what need extend each page' class
 */
class pageDefault {

    private $_task;
    private $_scripts = Array();
    private $_css = Array();
    private $_title = 'Urban traps';
    private $_meta = Array();
    public $classes = Array();
    protected $min = false;
    /*
     * selon le get task
     * on envoi la fonction qui y correspond dans l'enfant
     */
    public function __construct() {
        $this->_meta['decription'] = 'Urban traps';
        $this->_meta['location'] = '';
        $this->min = Framework::load()->config->MINIMIZE;
        $this->_task = (isset($_REQUEST['task']) && $_REQUEST['task'] != '') ? $_REQUEST['task'] : 'get';
        
        $this->classes[] = $this->_task;
        $fct = '_'.$this->_task;
        if(method_exists($this, $fct)) {
            $this->$fct();  
        } else {
          //  echo 'methode not exist';
        }
    }
    
    public function setTitle($content, $concat = true) {
        $this->_title = $concat ? $this->_title.' '.$content : $content;
    }
    public function setMeta($type, $content, $concat = true) {
        $this->_meta[$type] = $concat ? (isset($this->_meta[$type]) ? $this->_meta[$type] : '').' '.$content : $content;
    }
    public function getMeta($type = 'description') {
       return $this->_meta[$type];
    }
    
    public function getTitle() {
        return $this->_title;
    }
    public function addClass($cl) {
        $this->classes[] = $cl;
    }
    
    public function getCSS() {
        $uribase = Framework::load()->config->URL_BASE;
        $uribasejs = str_replace('/', '', $uribase);
        $sr = '';
        $str = array();
    	$first = true;
        foreach ($this->_css as $src) {
            if($this->min) { 
                $str[] = $src['src']; //for dev => no minimize script
                continue; //for dev => no minimize script
            }
            if(!$first) $sr.=',';
            if(strpos($src, '/') != 0) $src = '/'.$src;
            $sr .=$uribasejs.$src;
            $first = false;
        }
        if(count($str) != 0) {
            foreach ($str as $s) {
                if($s != '' && !empty($s)) echo '<link rel="stylesheet" media="screen" href="'.$s.'" />';
            }
        }
        if($sr != '' && !empty($sr)) echo '<link rel="stylesheet" media="screen" href="min/?f='.$sr.'" />';
    }
    
    public function addCSS($handle, $src) {
        $this->_css[$handle] = $src;
    }
    
    public function getBodyClass() {
        $first = true;
        foreach ($this->classes as $class) {
            echo (!$first ? ' ' : '');
            echo $class;
            $first = false;
        }
    }
    
    //gerer minification ou pas!! avec "http://"
    public function addScript($handle, $src, $bottom) {
        $this->_scripts[$handle]['src'] = $src;
        $this->_scripts[$handle]['where'] = ($bottom) ? 'bottom' : 'top';
    }
    public function getScriptBottom() {
        $this->getScripts('bottom');
    }
    
    public function getScriptTop() {
        $this->getScripts('top');
    }
    
    private function getScripts($where) {
    	$uribase = Framework::load()->config->URL_BASE;
        $uribasejs = str_replace('/', '', $uribase);
		
    	$sr = '';
        $str = array();
    	$first = true;
        foreach ($this->_scripts as $src) {
            if($src['where'] == $where)	{
                if($this->min) { 
                    $str[] = $src['src']; //for dev => no minimize script
                    continue; //for dev => no minimize script
                }
                if(strpos($src['src'], 'http://') ===0) {
                    $str[] = $src['src'];
                } else {
                    if(!$first) $sr.=',';
                    if(strpos($src['src'], '/') != 0) $src['src'] = '/'.$src['src'];
                    $sr .=$uribasejs.$src['src'];
                    $first = false;
                }
            }
        }

        if(count($str) != 0) {
            foreach ($str as $s) {
                if($s != '' && !empty($s)) echo '<script src="'.$s.'"></script>';
            }
        }
        if($sr != '' && !empty($sr)) echo '<script src="min/?f='.$sr.'"></script>';
        
    }
    
    
}

?>
