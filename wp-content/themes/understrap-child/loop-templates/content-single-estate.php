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

	<?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>

	<div class="entry-content">

		<?php if( 
			get_field('re_square') ||
			get_field('re_price') ||
			get_field('re_address') ||
			get_field('re_living_space') ||
			get_field('re_floor')
			): ?>
			<ul>
				<?php if( get_field('re_square')): ?>
					<li><strong>Площадь:</strong> <?php the_field('re_square'); ?> м<sup>2</sup></li>
				<?php endif; ?>
				<?php if( get_field('re_price')): ?>
					<li><strong>Стоимость:</strong> <?php the_field('re_price'); ?> ₽</li>
				<?php endif; ?>
				<?php if( get_field('re_address')): ?>
					<li><strong>Адрес:</strong> <?php the_field('re_address'); ?></li>
				<?php endif; ?>
				<?php if( get_field('re_living_space')): ?>
					<li><strong>Жилая площадь:</strong> <?php the_field('re_living_space'); ?> м<sup>2</sup></li>
				<?php endif; ?>
				<?php if( get_field('re_floor')): ?>
					<li><strong>Этаж:</strong> <?php the_field('re_floor'); ?></li>
				<?php endif; ?>
			</ul>
		<?php endif; ?>

		<?php the_content(); ?>

	</div>
</article>