<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

$categories_list = get_the_category_list( __( ', ', 'twentyeleven' ) );
if(!canSee($post)) {
    wp_die('Vous ne pouvez pas voir cet article');
}

?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h2 class="entry-title"><?php the_title(); ?></h2>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php twentyeleven_posted_on(); ?>
                        <?php
                            /* translators: used between list items, there is a space after the comma */
                            
                            if ( $categories_list ):
                    ?>
                    <div class="clear"></div>
                        <span class="cat-links<?php echo listCatForClass($post->ID); ?>">
                            Catégorie : <?php echo $categories_list; ?>
                        </span>

                    <?php endif; // End if categories ?>
		</div>
		<?php endif; ?>


	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div>

</article>
