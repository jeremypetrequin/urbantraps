<?php get_header(); ?>

<?php $args = array(
        'depth'        => 0,
        'show_date'    => '',
        'date_format'  => get_option('date_format'),
        'child_of'     => 404,
        'exclude'      => '404',
        'include'      => '',
        'title_li'     => __(''),
        'echo'         => 1,
        'authors'      => '',
        'sort_column'  => 'menu_order, post_title',
        'link_before'  => '',
        'link_after'   => '',
        'walker'       => new SimpleIndentMenuWalker,
        'post_status'  => 'publish' 
); ?>

<div id="navigation">
    <div id="logo">
        Logo
        <!-- <img src="" alt=""/> -->
    </div>
    <div id="menu">
        <div>
            <div id="triangle_select"></div>
            <ul>
                <?php wp_list_pages( $args ); ?> 
            </ul>
        </div>
    </div> <?php //menu ?>
</div> <?php //navigation ?>


<?php get_footer(); ?>

