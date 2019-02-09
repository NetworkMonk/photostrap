<?php
/**
 * Template Name: Project Page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="full-width-page-wrapper">

	<div class="container" id="content">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'loop-templates/content', 'page' ); ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
						?>

					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- #content -->

</div><!-- #full-width-page-wrapper -->

<div class="row no-gutters my-3">
	<div class="container">
		<!-- Display all published projects -->
		<?php $projects = get_posts(array('post_type' => 'project')); ?>
		<?php $count = 0; ?>
		<?php foreach($projects as $project): ?>
			<div class="project-item fade-on-scroll" style="background-image: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id($project->ID)) ?>');">
				<div class="project-description">
					<p class="project-title"><?php echo $project->post_title; ?></p>
					<!--<p class="project-excerpt"><?php echo $project->post_excerpt; ?></p>-->
					<a role="button" class="project-open btn btn-outline-light" href="<?php echo get_permalink($project->ID); ?>">View</a>
				</div>
			</div>
		<?php $count++; ?>
		<?php endforeach; ?>
	</div>
</div>

<?php get_footer(); ?>
