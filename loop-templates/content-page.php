<?php
/**
 * Partial template for content in page.php
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<div class="row">
			<div class="col-12 col-md-6">
				<?php //the_title( '<h1 class="entry-title display-4">', '</h1>' ); ?>
			</div>
			<div class="col-12 col-md-6" style="vertical-align: bottom; position: relative;">
				<?php if (function_exists(the_subtitle)) {the_subtitle('<p class="position-md-absolute text-md-right" style="vertical-align: bottom; bottom: 0;">', '</p>');} ?>
			</div>
		</div>

	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
				'after'  => '</div>',
			)
		);
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
