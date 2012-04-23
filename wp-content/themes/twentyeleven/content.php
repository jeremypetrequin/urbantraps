<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

if(canSee($post)) {
    

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		
            <div class="img_post">
                <?php
                    
                    
                    
                    $id = $post->ID;
                    
                    
                    //recupération de l'image
                    $post_thumbnail_id = get_post_thumbnail_id((int)$id);
                    if(!empty ($post_thumbnail_id)) {
                        $image_attributes = wp_get_attachment_image_src( $post_thumbnail_id, 'medium' );
                        $width = '';
                        $height = '';
                        
                        if($image_attributes[1] < 265) {
                            $width = ' width="265" ';
                        } 
                        if($image_attributes[2] < 225) {
                            $height = ' height="255" ';
                        }
                        ?> 
                         <a href="<?php echo the_permalink(); ?>" title="Lire l'article <?php the_title(); ?>">
                            <img <?php echo $width.' '.$height; ?> src="<?php echo $image_attributes[0]; ?>" alt="<?php the_title(); ?>" />
                         </a>    
                        <?php
                    }
                ?>
            </div>
            <div class="resume_post">
                <h2 class="entry-title">
                     <a href="<?php echo the_permalink(); ?>" title="Lire l'article <?php the_title(); ?>"><?php the_title(); ?></a>
                </h2>


                <?php if ( 'post' == get_post_type() ) : ?>
                <div class="entry-meta">
                        <?php twentyeleven_posted_on(); ?>
                    
                    <?php
                        /* translators: used between list items, there is a space after the comma */
                        $categories_list = get_the_category_list( __( ', ', 'twentyeleven' ) );
                        if ( $categories_list ):
                ?>
                    <span class="cat-links<?php echo listCatForClass($post->ID); ?>">
                        Catégorie : <?php echo $categories_list; ?>
                    </span>
                
                <?php endif; // End if categories ?>
                    
                    
                </div><!-- .entry-meta -->
                <?php endif; ?>

                <?php /*if ( comments_open() && ! post_password_required() ) : ?>
                <div class="comments-link">
                        <?php comments_popup_link( '<span class="leave-reply">' . __( 'Reply', 'twentyeleven' ) . '</span>', _x( '1', 'comments number', 'twentyeleven' ), _x( '%', 'comments number', 'twentyeleven' ) ); ?>
                </div>
                <?php endif;*/ ?>


                <?php// if ( is_search() ) : // Only display Excerpts for ALL basterd! ?>
                <div class="entry-summary">
                <?php 
                
                echo wordCut($post->post_content, 130, '...'); 
                
                ?>
                </div>
                <?php/* else : ?>
                <div class="entry-content">
                <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
                </div><!-- .entry-content -->
                <?php endif; */?>




                

                <?php //edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
            </div>
            
            <a class="readMore" href="<?php echo the_permalink(); ?>" title="Lire l'article <?php the_title(); ?>"><?php the_title(); ?></a>
	</article>
<?php } ?>