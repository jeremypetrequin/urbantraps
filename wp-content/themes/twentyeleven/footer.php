
    </div>

	<div id="footer"></div>     
</div>

<footer role="contentinfo" class="max">
    <nav>
        <ul class="nav">
            <!--<?php $id = 16; $page = get_page($id);?>

            <li class="link_1 <?php if($post->ID == 16) echo 'selected' ; ?>"><a href="<?php echo get_permalink(16); ?>" title="<?php echo stripslashes($page->post_title); ?>">
                
                <?php echo stripslashes($page->post_title); ?> / nous
                </a>
            </li>
            <?php $id = 18; $page = get_page($id);?>
            <li  class="link_2 <?php if($post->ID == 18) echo 'selected' ; ?>">
                <a href="<?php echo get_permalink(18); ?>" title="<?php echo stripslashes($page->post_title); ?>"><?php echo stripslashes($page->post_title); ?></a>
            </li>
            <li  class="link_3">
                <a href="<?php echo home_url('/'); ?>" title="Catégorie">Catégorie</a>
            </li>
            
             <?php $user = getUserType(); ?>
                                <?php if($user) { ?>
            <li  class="link_4">
                <a href="" title="">
                    équipe péda / vous
                </a>
               
            </li>
            <?php if($user == 'admin') { ?>
            <li  class="link_5">
                <a href="" title="">
                    sources / entre nous
                </a>
            </li>
            <?php } } ?>-->
    </nav>
        
    </footer>
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
<script src="<?php echo get_template_directory_uri(); ?>/js/gmap/gmap.class.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/script_map.js"></script>


<?php wp_footer(); ?>
<!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
    <script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->
    
</body>
</html>