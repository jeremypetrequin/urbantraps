<?php
 
/**
 * Class SimpleIndentMenuWalker, genere un menu indente classqiue
 */

class SimpleIndentMenuWalker extends Walker_Page {

	private $cpt;
	
	
	/**
	 * @see Walker::start_lvl()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function start_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class='children level".($depth+1)."'>\n";
	}	
	
	/**
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $page Page data object.
	 * @param int $depth Depth of page. Used for padding.
	 * @param int $current_page Page ID.
	 * @param array $args
	 */
	function start_el(&$output, $page, $depth, $args, $current_page) {
		
                  $idTourismeAffaire = array(106);
                  //
		$thiscpt = $this->cpt;
		$parent = (int)$page->post_parent;
		$count = !empty($thiscpt[$parent])?(int)$thiscpt[$parent]:0; 		
		if(!empty($thiscpt[$parent])){ $thiscpt[$parent]++; } else { $thiscpt[$parent]=1; }		
		if(empty($thiscpt[$depth]))$thiscpt[$depth]=(int)0;		

		if ( $depth )
			$indent = str_repeat("\t", $depth);
		else
			$indent = '';

		extract($args, EXTR_SKIP);
		
		//CSS Classes
		$css_class = array('page_item', 'page-item-'.$page->ID);
		if ( !empty($current_page) ) {
			$_current_page = get_page( $current_page );
			_get_post_ancestors($_current_page);
			if ( isset($_current_page->ancestors) && in_array($page->ID, (array) $_current_page->ancestors) )
				$css_class[] = 'current_page_ancestor';
			if ( $page->ID == $current_page )
				$css_class[] = 'current_page_item';
			elseif ( $_current_page && $page->ID == $_current_page->post_parent )
				$css_class[] = 'current_page_parent';
		} elseif ( $page->ID == get_option('page_for_posts') ) {
			$css_class[] = 'current_page_parent';
		}
		$css_class[] = 'm'.$depth.'_'.$count;
		$css_class = implode(' ', apply_filters('page_css_class', $css_class, $page));
		
		$esctitle = esc_attr( wp_strip_all_tags( apply_filters( 'the_title', $page->post_title, $page->ID ) ) );
		
		$output .= $indent . '<li rel="'.$page->ID.'" class="' . $css_class . '">';

                        if(in_array($page->ID, $idTourismeAffaire)) {
                            $output .= '  <a href="' . get_option("noewp_url_affaire"). '" target="_blanck" title="' . $esctitle . '">' ;
                        } else {
                            $output .= '    <a href="'.URL_BLOG.'/#!/page/' .$page->ID.'" title="' . $esctitle . '">' ; 
                        }
                               $output .= $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) 
                                .$link_after
                                . '</a>';
		
		$thiscpt[$depth]++;
		$this->dept = $depth;
		$this->cpt = $thiscpt;
		
	}
}

?>