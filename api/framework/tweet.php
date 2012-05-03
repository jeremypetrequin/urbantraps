<?php
/**
 * Description of tweet
 *
 * @author Badger
 * @date 23 mai 2011
 * @project AFFLUX
 */
class tweet {
    
    /*
     * parse le contenu d'un tweet pour faire tout les liens dessus : 
     * => http url
     * => @  citation
     * => #  hastag
     */
    public function doLink($str) {
        $str = preg_replace('#http://[a-z0-9._/-]+#i', '<font color="#2AA1C7"><a target="_blank" href="$0">$0</a></font>', $str);
        $str = preg_replace('#@([a-z0-9_]+)#i', '<font color="#2AA1C7">@<a target="_blank" href="http://twitter.com/$1">$1</a></font>', $str);
        $str = preg_replace('# \#([a-z0-9_-]+)#i', ' <font color="#2AA1C7">#<a target="_blank" href="http://search.twitter.com/search?q=%23$1">$1</a></font>', $str);
        return $str;
    }
    
}

?>
