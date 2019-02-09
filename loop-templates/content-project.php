<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<div class="col-12 project-header" style="min-height: 35rem; height: 80vh; max-height: 50rem; background-image: url('<?php echo get_the_post_thumbnail_url($post->ID,'full'); ?>;">
		  <div class="project-header-overlay">
				<div class="overlay-center">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<div class="entry-excerpt"><?php echo $post->post_excerpt; ?></div>
        </div>
		  </div>
		</div>

	</header><!-- .entry-header -->

	<div class="entry-content">

	  <div class="container-fluid">
		  <div class="col-12 mt-2">
			<?php //the_content(); ?>
			<div class="entry-gallery"></div>
		  </div>
      </div>

		<?php
			$image_ids = get_posts(
				array(
					'post_type'      => 'attachment',
					//'post_mime_type' => 'image',
					'post_status'    => 'any',
					'posts_per_page' => -1,
					'fields'         => 'ids',
					'post_parent'	 => $post->ID
				) );
			
			$images = array_map( "wp_get_attachment_url", $image_ids );

			preg_match_all('/<img(.*?)src=("|\'|)(.*?)("|\'| )(.*?)>/s', $post->post_content, $images);

			$result_images = [];
			if (count($images > 0)) {
				for ($i = 0; $i < count($images[0]); $i++) {
					preg_match('/src=("|\'|)(.*?)("|\'| )/', $images[0][$i], $tmp_match);
					$tmp_match[0] = str_replace('src="', '', $tmp_match[0]);
					$tmp_match[0] = substr($tmp_match[0], 0, strlen($tmp_match[0]) - 1);
					$result_images[$i] = [
						'original' => $images[0][$i],
						'src' => $tmp_match[0]
					];
				}
			}
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

<script>
	var imageList = <?php echo json_encode($result_images); ?>;
	new EasyGallery({
		targetElement: document.getElementsByClassName('entry-gallery').item(0),
		imageList: imageList,
	});
</script>