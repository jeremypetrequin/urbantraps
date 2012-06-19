<div id="footer-max" class="max" class="wrapper">
        <div id="footer">
        </div> 
    <div id="footer-bottom"></div>
    </div>
  


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false"></script>
<script> 
    var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-28260908-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
  
    window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.6.2.min.js"><\/script>')
    
</script>

<script src="<?php echo get_template_directory_uri(); ?>/js/framework.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/gmap/overlays/overlay-cluster.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/gmap/gmap.class.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/cycle.js"></script>


<script type="text/html" id="home-tpl" data-lat="45.90857343579082" data-lng="6.125575304031372">
    <div id="content_slider">
        <div id="slider">
            <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/images/slide1.png" /></div>
            <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/images/slide2.png"/></div>
            <div class="slide"><img src="<?php echo get_template_directory_uri(); ?>/images/slide3.png"/></div>
        </div>
        <div id="pager"></div>
    </div>
        
    <div id="actions">
        <div id="scanne" class="action"><p><span class="big_text">SCANNE</span><br/><span class="small_text">DES PANNEAUX</span></p></div>
        <div id="redecouvre" class="action"><p><span class="big_text">REDÉCOUVRE</span> <br /><span class="small_text">TA VILLE</span></p></div>
        <div id="debloque" class="action"><p><span class="big_text">DÉBLOQUE</span><br /><span class="small_text">DES JEUX AVEC LA<br />COMMUNAUTÉ</span></p></div>
        <div class="clear"></div>
     </div>
     <div id="extracts">
        <div id="avis_extract"><div class="extract_title">LES AVIS</div></div>
        <div id="blog_extract"><div class="extract_title">LE BLOG</div></div>
        <div class="clear"></div>
    </div>
</script>

<script type="text/html" id="application-tpl" data-lat="45.89830786235205" data-lng="6.123746037483215">
    <div class="application">
        <h2>Urban Traps est une application iPhone s’utilisant en ville, dont le but est de divertir le citadin et de lui faire redécouvrir sa ville.</h2>
        <p>Le citadin, qu’il soit joueur invétéré ou joueur du dimanche, peut grâce aux panneaux de signalisation routière, accéder à des jeux aussi rapides que décalés. Bien que chaque jeu soit individuel, le citadin doit faire appel à ses voisins de quartiers s’il veut pouvoir débloquer de nouveaux niveaux plus rapidement.</p>
    </div>
</script>

<script type="text/html" id="contact-tpl" data-lat="45.90210447924694" data-lng="6.1182475090026855">
    <div class="contact">
        Nous contacter :<br /><a><strong>contact@urbantraps.fr</strong></a>
    </div>
</script>

<script type="text/html" id="blog-tpl" data-lat="45.90117868116585" data-lng="6.130285263061523">
<?php                        
$user = getUserType();
$params = '';
if(!empty ($_REQUEST['paged'])) {
    $params = '&paged='.$_REQUEST['paged'];//prendre en compte la pagination
}
//echo $user;
if($user === false) {
    query_posts( 'cat=-6,-7'.$params);
} else if($user == 'simple') {
    query_posts( 'cat=-7'.$params);
}
?>
<?php if ( have_posts() ) : ?>



    <?php /* Start the Loop */ ?>
    <?php while ( have_posts() ) : the_post(); ?>

                <?php if(!canSee($post)) continue; ?>

            <?php get_template_part( 'content', get_post_format() ); ?>

    <?php endwhile; ?>

    <?php echo  twentyeleven_content_nav( 'nav-below' ); ?>

<?php else : ?>

    <article id="post-0" class="post no-results not-found">
            <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
            </header><!-- .entry-header -->

            <div class="entry-content">
                    Not found
            </div>
    </article>

<?php endif; ?>
</script>

<script src="<?php echo get_template_directory_uri(); ?>/js/script_map.js"></script>
<?php wp_footer(); ?>
<!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
    <script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->
    
</body>
</html>