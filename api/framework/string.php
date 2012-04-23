<?php
/**
 * Description of tweet
 *
 * @author Badger
 * @date 23 mai 2011
 * @project AFFLUX
 */
class string {
    
    /*
    * @description function to prepare text for echo in a javascript var
    * @param1 : string
    */
    public function javascriptify($str) {
        $str = stripslashes(utf8_encode(trim($str)));
        return str_replace('"', '&quot', $str);
    }
    
    public function slugify($str) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        // trim
        $text = trim($text, '-');
        // transliterate
        if (function_exists('iconv')) $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text); 
        // lowercase
        $text = strtolower($text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text)) return 'n-a'; 
        return $text;
    } 
    
    
    /**
    *
    * renvoie une chaine racourci 
    * @param string $sText: chaine ‚àö‚Ä† racourcir
    * @param float $iMaxLength : longueur du racourci
    * @param string $sMessage : message qu'on met ‚àö‚Ä† la fin du racourci, exemple 'lire la suite', '[...]' etc...    
    * @return string return la chaine d'origine si celle ci est moin longue que la taille donn‚àö¬©e
    */
    
    public function wordCut($sText, $iMaxLength, $sMessage) {
        $sText = strip_tags($sText);
        if (strlen($sText) > $iMaxLength) {
            $sString = wordwrap($sText, ($iMaxLength-strlen($sMessage)), '[cut]', 1);
            $asExplodedString = explode('[cut]', $sString);
            $sCutText = $asExplodedString[0];
            return "".$sCutText.$sMessage."";
        } else {
            return "".$sText."";
        }
    }
    
}

?>
