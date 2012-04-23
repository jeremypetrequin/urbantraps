<?php
/**
 * @date    : April 2011
 * @project : BMS
 * @package : /framework
 * @author : Badger
 *
 * class for HTML displaying
 */
class HTML {
    
    /*
     * return image tag if image exist
     */
    public function showImage($url, $alt) {
        if(is_file($url)) {
            return '<img src="'.$url.'" alt="'.$alt.'" />';
        }
    }
    
    public function script($JS) {
        return '<script>'.$JS.'</script>';
    }
}

?>
