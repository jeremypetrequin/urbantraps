<?php
/*
Template Name: Api
*/
?>

<?php
    $mypages = get_pages(array( 'child_of' => '404', 'sort_column' => 'post_date', 'sort_order' => 'asc' ));
    $json = array();
    
    foreach ($mypages as $page) {
        $ret['title'] = $page->post_title;
        $ret['id'] = $page->ID;
        $ret['content'] = $page->post_content;
        $ret['perso_fields']= get_fields($page->ID);
        
        $json[] = $ret;
    }
    
    
    die(json_encode($json));
?>
