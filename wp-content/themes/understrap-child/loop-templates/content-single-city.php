<?php
/**
 * Single post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'full', ['class' => "img-fluid mb-2"] ); ?>

	<div class="entry-content">

		<?php the_content(); ?>

	</div>

	<?php
		$args = array(
			'post_type'      => 'real_estate',
			'post_status'    => 'publish',
			'post_parent'    => $post->ID,
			'posts_per_page' => 10,
			'orderby'        => 'post_title',
			'order'          => 'ASC'
		);

		$real_estates = get_posts($args);

		if( $real_estates ){
			echo '<div class="list-group">';
			foreach( $real_estates as $post ){
				setup_postdata( $post );
				get_template_part( 'loop-templates/content', 'estate' );
			}
			echo '</div>';
		} else {
			?>
				<div class="alert alert-dark" role="alert">
					В этом городе недвижимости не найдено.
				</div>
			<?php
		}
		wp_reset_postdata();
	?>
</article>