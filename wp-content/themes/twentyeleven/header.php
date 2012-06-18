<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html class="ie6 no-js" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html class="ie7 no-js" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="no-js ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title>
<?php
    /*
     * Print the <title> tag based on what is being viewed.
     */
    global $page, $paged;

    wp_title( '|', true, 'right' );

    // Add the blog name.
    bloginfo( 'name' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
            echo " | $site_description";

    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
            echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

?>
</title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link href='http://fonts.googleapis.com/css?family=Tinos:400,400italic,700' rel='stylesheet' type='text/css'>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.js"></script>

<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
        
         wp_deregister_script( 'jquery' );
         

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
    <link href="<?php echo get_template_directory_uri(); ?>/images/favico.png" type="image/png" rel="icon">
    <link href="<?php echo get_template_directory_uri(); ?>/images/favico.png" type="image/x-icon" rel="shortcut icon">
    
    <script>
        window.CONF = {
           url_api : '<?php echo get_permalink(414); ?>'
            
        };
    </script>
</head>

<body <?php body_class(); ?>>
<div id="gmap">
    </div>
    <!-- <div id="formulaire_connexion" class="max">
        <?php echo login_with_ajax(); ?>
    </div> -->
<div id="wrapper" class="hfeed">
	<!--<header role="banner">
                <div id="banner">
                    <div id="connect_form">
                        
                        
                        
                        <a id="toggleConnec">Connexion</a>
                        
                    </div>
                    <?php if(is_home()) echo '<h1>'; ?>
                        <a id="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                    <?php if(is_home()) echo '</h1>'; ?>
                </div>

			

			

			<nav id="menu" role="navigation">
                            <ul class="nav">
                                <?php $id = 16; $page = get_page($id);?>
                                
                                <li class="link_1 <?php if($post->ID == 16) echo 'selected' ; ?>"><a href="<?php echo get_permalink(16); ?>" title="<?php echo stripslashes($page->post_title); ?>">
                                  <?php //  <span>nous</span> ?>
                                    <?php echo stripslashes($page->post_title); ?></a>
                                    <span class="triangle_top"></span>
                                </li>
                                <?php $id = 18; $page = get_page($id);?>
                                <li  class="link_2 <?php if($post->ID == 18) echo 'selected' ; ?>">
                                    <a href="<?php echo get_permalink(18); ?>" title="<?php echo stripslashes($page->post_title); ?>"><?php echo stripslashes($page->post_title); ?></a>
                                    <span class="triangle_top"></span>
                                </li>
                                <li  class="link_3">
                                    <a href="<?php echo home_url('/'); ?>" title="Catégories">Catégories</a>
                                    <span class="triangle_top"></span>
                                    <ul class="children">
                                        <?php
                                        $args = array(
                                            'show_option_all'    => "",
                                            'orderby'            => 'name',
                                            'order'              => 'ASC',
                                            'show_last_update'   => 0,
                                            'style'              => 'list',
                                            'show_count'         => 0,
                                            'hide_empty'         => 1,
                                            'use_desc_for_title' => 1,
                                            'child_of'           => 8,
                                            'dept'               => 1,
                                            'exclude'            => "6,7",
                                            'title_li'           => ''
                                            
                                            );
                                        
                                        ?>
                                        <?php echo wp_list_categories($args) ?>
                                    </ul>
                                </li>
                                <?php $user = getUserType(); ?>
                                <?php if($user) { ?>
                                <li  class="link_4">
                                    <a href="<?php $category_id  = 6; echo get_category_link( $category_id );?>" title="Equipe péda">
                                       <?php // <span>vous</span> ?>
                                        équipe péda
                                    </a>
                                    <span class="triangle_top"></span>
                                    <ul class="children">
                                        <?php
                                        $args = array(
                                            'show_option_all'    => "",
                                            'orderby'            => 'name',
                                            'order'              => 'ASC',
                                            'show_last_update'   => 0,
                                            'style'              => 'list',
                                            'show_count'         => 0,
                                            'hide_empty'         => 1,
                                            'use_desc_for_title' => 1,
                                            'child_of'           => 6,
                                            'dept'               => 1,
                                            'title_li'           => ''
                                            
                                            );
                                        
                                        ?>
                                        <?php echo wp_list_categories($args) ?>
                                    </ul>
                                </li>
                                <?php if($user == 'admin') { ?>
                                <li  class="link_5">
                                    <a href="<?php $category_id  = 7; echo get_category_link( $category_id );?>" title="Entre nous, source">
                                       <?php // <span>Entre nous</span> ?>
                                        sources
                                    </a>
                                    <span class="triangle_top"></span>
                                    <ul class="children">
                                        <?php
                                        $args = array(
                                            'show_option_all'    => "",
                                            'orderby'            => 'name',
                                            'order'              => 'ASC',
                                            'show_last_update'   => 0,
                                            'style'              => 'list',
                                            'show_count'         => 0,
                                            'hide_empty'         => 1,
                                            'use_desc_for_title' => 1,
                                            'child_of'           => 7,
                                            'dept'               => 1,
                                            'title_li'           => ''
                                            );
                                        ?>
                                        <?php echo wp_list_categories($args) ?>
                                    </ul>
                                </li>
                                
                                <?php 
                                    } 
                                }
                                ?>
                            </ul>
                        </nav>
                        
	</header> -->


	<div id="main">
		<div id="navigation">
		    <div id="header">
		    	<div id="ville"><img src=<?php bloginfo('template_url') ?>/images/logo.png title="" alt="" /></div>
		    	<div id="menu">
		    		<ul>
		    			<li id="home"><a href="#!/">home</a></li>
		    			<li class="sep_menu"></li>
		    			<li id="application"><a href="#!/application" title="application"><span class="big_text">L'APPLICATION</scan><br /><span class="small_text">URBAN TRAPS</scan></a></li>
		    			<li class="sep_menu"></li>
		    			<li id="invasion"><a href="#!/invasion" title="invasion"><span class="big_text">L'INVASION</scan><br /><span class="small_text">DANS TA VILLE</scan></a></li>
		    			<li class="sep_menu"></li>
		    			<li id="blog"><a href="#!/blog" title="blog"><span class="big_text">LE BLOG</scan><br /><span class="small_text">NOUS SUIVRE</scan></a></li> 
		    			<li class="sep_menu"></li>
		    			<li id="contact"><a href="#!/contact" title="contact"><span class="big_text">CONTACT</scan><br /><span class="small_text">URBAN TRAPERS</scan></a></li>
		    			<li class="sep_menu"></li>
		    			<li id="telecharger"><a href=""><span class="big_text">TÉLÉCHARGER</scan></a></li>
		    			<li class="clear"></li>
		    		</ul>
		    	</div>
		    </div>
		</div> <?php /*navigation*/ ?>
            