<?php get_header(); ?>

<?php
$args = array(
    'depth' => 0,
    'show_date' => '',
    'date_format' => get_option('date_format'),
    'child_of' => 404,
    'exclude' => '404',
    'include' => '',
    'title_li' => __(''),
    'echo' => 1,
    'authors' => '',
    'sort_column' => 'menu_order, post_title',
    'link_before' => '',
    'link_after' => '',
    'walker' => new SimpleIndentMenuWalker,
    'post_status' => 'publish'
);
?>
<div id="legende">
    <ul>
        <li id="france_li"><a id="france_button">La France</a></li>
        <li id="image_li"><img src="<?php echo get_template_directory_uri(); ?>/images/invasion_legende.png" /></li>
        <li id="city_li"><a id="city_button">Ma ville</a></li>
    </ul>
</div>

<div id="content" class="wrapper">

 
 </div>

<?php get_footer(); ?>

