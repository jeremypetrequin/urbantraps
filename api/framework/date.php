<?php
/**
 * @date    : April 2011
 * @project : BMS
 * @package : /framework
 * @author Badger
 * 
 * framework to display, handdle .. Date
 */
class Date {
    private $_month = array(
          'Jan' => '01',
          'Fev' => '02',
          'Mar' => '03',
          'Apr' => '04', 
          'May' => '05',
          'Jun' => '06',
          'Jui' => '07',
          'Aug' => '08', 
          'Sep' => '09',
          'Oct' => '10',
          'Nov' => '11',
          'Dec' => '12' 
        );
    
    private $_dayFR = array(
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'dimanche'
    );
    
    private $_monthFR = array(
        'janvier',
        'février',
        'mars',
        'avril',
        'mai',
        'juin',
        'juillet',
        'aout',
        'septembre',
        'octobre',
        'novembre',
        'decembre'
    );
    /*
    * converti une date twitter (Wed, 27 Apr 2011 20:01:47 +0000) en date US
    */
    public function dateTwitterToUS($date) {
        list($dayL, $day, $month, $year, $hour, $r) = explode(' ', $date);
        $d = $year.'-'.$this->_month[$month].'-'.$day.' '.$hour;
        return $d;
    }
    
    /*
     * calcule la diff√©rence entre deux date, renvoi en seconde
     * false si diff√©rence n√©gative
     */
    public function differenceDate($dateDeb, $dateFin) {
        $d = strtotime($dateDeb);
        $e = strtotime($dateFin);
        $ret = $e - $d;
        return ($ret < 0 ? false : $ret);
    }
    
    /*
     * prepare date US for displaying
     *  =>$date = date US
     *  => $sec = boolean : displaying or not the seconde
     */
    public function displayDate($date, $sec = false, $min = false, $str = '') {
        if($date=='') return;
        list($d, $h) = explode(' ', $date);
        list($year, $month, $day) = explode('-', $d);
        list($hour, $minute, $seconde) = explode(':', $h);
        $seconde = ($sec)? ' et '.$seconde.'s' : '';
        $minutes = ($min)? '&agrave; '.$hour.'H'.$minute.$seconde : '';
        return $str.$day.'.'.$month.'.'.$year.$minutes;
    }
}

?>
