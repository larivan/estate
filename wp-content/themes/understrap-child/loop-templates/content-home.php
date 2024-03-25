<?php
/**
 * Partial template for content in page.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php
	if ( ! is_page_template( 'page-templates/no-title.php' ) ) {
		the_title(
			'<header class="entry-header"><h1 class="entry-title">',
			'</h1></header><!-- .entry-header -->'
		);
	}

	echo get_the_post_thumbnail( $post->ID, 'full' );
	?>

	<div class="entry-content">

		<?php
		the_content();
		?>

	</div><!-- .entry-content -->

	<div class="my-4">
		<h2 class="mb-2">Города</h2>
		<?php
			$args = array(
				'post_type'      => 'city',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => 'post_title',
				'order'          => 'ASC'
			);

			$cities = get_posts($args);

			if( $cities ){
				echo '<div class="list-group">';
				foreach( $cities as $post ){
					setup_postdata( $post );
					get_template_part( 'loop-templates/content', 'city' );
				}
				echo '</div>';
			} else {
				?>
					<div class="alert alert-dark" role="alert">
						Городов не найдено.
					</div>
				<?php
			}
			wp_reset_postdata();
		?>
	</div>

	<div class="my-4">
		<h2 class="mb-2">Недвижимость</h2>
		<?php
			$args = array(
				'post_type'      => 'real_estate',
				'post_status'    => 'publish',
				'posts_per_page' => 10,
				'orderby'        => 'date',
				'order'          => 'DESC'
			);

			$real_estates = get_posts($args);

			if( $real_estates ){
				echo '<div id="estate-list" class="list-group">';
				foreach( $real_estates as $post ){
					setup_postdata( $post );
					get_template_part( 'loop-templates/content', 'estate' );
				}
				echo '</div>';
			} else {
				?>
					<div class="alert alert-dark" role="alert">
						Недвижимости не найдено.
					</div>
				<?php
			}
			wp_reset_postdata();
		?>
	</div>

	<form id="ajax-form" class="my-4">
		<h2 class="mb-2">Добавление новой недвижимости</h2>
		<div class="form-group">
			<label for="exampleInputName">Введите название</label>
			<input type="text" class="form-control" name="name" id="exampleInputName" placeholder="Название объекта недвижимости" required>
		</div>
		<div class="form-group">
			<label for="exampleInputSquare">Введите площадь</label>
			<input type="number" class="form-control" name="square" id="exampleInputSquare" placeholder="Площадь" required>
		</div>
		<div class="form-group">
			<label for="exampleInputPrice">Введите стоимость</label>
			<input type="number" class="form-control" name="price" id="exampleInputPrice" placeholder="Стоимость" required>
		</div>
		<div class="form-group">
			<label for="exampleInputAddress">Введите адрес</label>
			<input type="text" class="form-control" name="address" id="exampleInputAddress" placeholder="Адрес" required>
		</div>
		<div class="form-group">
			<label for="exampleInputLivingSpace">Введите жилую площадь</label>
			<input type="number" class="form-control" name="living_space" id="exampleInputLivingSpace" placeholder="Жилая площадь" required>
		</div>
		<div class="form-group">
			<label for="exampleInputFloor">Введите этаж</label>
			<input type="number" class="form-control" name="floor" id="exampleInputFloor" placeholder="Этаж" required>
		</div>
		<button type="submit" class="btn btn-primary">Отправить</button>
	</form>

	<footer class="entry-footer">

		<?php understrap_edit_post_link(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->

<script>
	jQuery(function($){
		$('#ajax-form').submit(function(e) {
			e.preventDefault();
	
			$form = $(this);
			$button = $form.children('button');
	
			$.ajax({
				url: '<?php echo admin_url( "admin-ajax.php" ) ?>',
				method: 'POST',
				dataType: 'json',
				data: 'action=ajax_form_handler&' + $form.serialize(),
				beforeSend: function( xhr ) {
					$button.text('Подождите...');	
				},
				success: function( data ) {
					$button.text('Отправить');
					$('#estate-list').html(data);
				}
			});
		})
	})
</script>