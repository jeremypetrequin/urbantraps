<?php get_header(); ?>

<?php $args = array(
        'depth'        => 0,
        'show_date'    => '',
        'date_format'  => get_option('date_format'),
        'child_of'     => 404,
        'exclude'      => '404',
        'include'      => '',
        'title_li'     => __('Pages'),
        'echo'         => 1,
        'authors'      => '',
        'sort_column'  => 'menu_order, post_title',
        'link_before'  => '',
        'link_after'   => '',
        'walker'       => new SimpleIndentMenuWalker,
        'post_status'  => 'publish' 
); ?>
<?php wp_list_pages( $args ); ?> 




<?php get_footer(); ?>

