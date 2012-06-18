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
<div id="content">
	<div id="slider">
	</div>
	<div id="actions">
		<div id="scanne" class="action"><p><span class="big_text">SCANNE</scan><br/><span class="small_text">DES PANNEAUX</scan></p></div>
		<div id="redecouvre" class="action"><p><span class="big_text">REDÉCOUVRE</scan> <br /><span class="small_text">TA VILLE</scan></p></div>
		<div id="debloque" class="action"><p><span class="big_text">DÉBLOQUE</scan><br /><span class="small_text">DES JEUX AVEC LA<br />COMMUNAUTÉ</scan></p></div>
		<div class="clear"></div>
	</div>
	<div id="extracts">
		<div id="avis_extract"><div class="extract_title">LES AVIS</div></div>
		<div id="blog_extract"><div class="extract_title">LE BLOG</div></div>
		<div class="clear"></div>
	</div>
</div>

<?php get_footer(); ?>

