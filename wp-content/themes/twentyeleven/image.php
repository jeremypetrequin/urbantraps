<?php
/**
 * The template for displaying image attachments.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

	

<?php while ( have_posts() ) : the_post(); ?>


        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="entry-title"><?php the_title(); ?></h1>

                    <div class="entry-meta">
                        <?php twentyeleven_posted_on(); ?>

                    </div>
                <div class="entry-content">


                        <?php
                        $attachment_size = apply_filters( 'twentyeleven_attachment_size', 574 );
                        echo wp_get_attachment_image( $post->ID, array( $attachment_size, 1024 ) ); // filterable image width with 1024px limit for image height.
                        ?>

                        <?php if ( ! empty( $post->post_excerpt ) ) : ?>
                        <p class="entry-caption">
                                <?php the_excerpt(); ?>
                        </p>
                        <?php endif; ?>




                        <div class="entry-description">
                                <?php the_content(); ?>
                                <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
                        </div><!-- .entry-description -->

                </div><!-- .entry-content -->

        </article><!-- #post-<?php the_ID(); ?> -->

        <?php comments_template(); ?>

<?php endwhile; // end of the loop. ?>


<?php get_footer(); ?>