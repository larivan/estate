<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_filter( 'excerpt_length', function( $length ) {
    return 20;
}, 10 );

// Регистрация новой таксономии Тип недвижимости
add_action( 'init', 'create_taxonomy' );
function create_taxonomy(){
	register_taxonomy( 'type_of_estate', [ 'real_estate' ], [
		'label'                 => '',
		'labels'                => [
			'name'              => 'Тип',
			'singular_name'     => 'Тип',
			'search_items'      => 'Поиск типа недвижимости',
			'all_items'         => 'Все типы',
			'view_item '        => 'Просмотреть тип',
			'parent_item'       => 'Родительский тип',
			'parent_item_colon' => 'Родительский тип:',
			'edit_item'         => 'Редактировать тип',
			'update_item'       => 'Обновить тип',
			'add_new_item'      => 'Добавить новый тип',
			'new_item_name'     => 'Название нового типа',
			'menu_name'         => 'Тип',
			'back_to_items'     => 'Перейти к типам недвижимости',
		],
		'description'           => '',
		'public'                => true,
		'show_tagcloud'         => false,
		'hierarchical'          => true,
		'rewrite'               => true,
		'capabilities'          => array(),
		'show_admin_column'     => false,
		'show_in_rest'          => true,
	] );
}


add_action( 'init', 'register_post_types' );

function register_post_types(){
	// Регистрация нового типа поста Недвижимость
	register_post_type( 'real_estate', [
		'label'  => null,
		'labels' => [
			'name'               => 'Недвижимость',
			'singular_name'      => 'Недвижимость',
			'add_new'            => 'Добавить',
			'add_new_item'       => 'Добавление новой недвижимости',
			'edit_item'          => 'Редактирование Недвижимости',
			'new_item'           => 'Новая Недвижимость',
			'view_item'          => 'Просмотреть Недвижимость',
			'search_items'       => 'Найти Недвижимость',
			'not_found'          => 'Не найдено',
			'not_found_in_trash' => 'Не найдено в корзине',
			'parent_item_colon'  => '',
			'menu_name'          => 'Недвижимость',
		],
		'description'            => '',
		'public'                 => true,
		'show_in_rest'           => true,
		'menu_icon'              => 'dashicons-admin-multisite',
		'hierarchical'           => false,
		'supports'               => [ 'title', 'editor', 'thumbnail', 'revisions'],
		'taxonomies'             => ['type_of_estate'],
		'has_archive'            => false,
		'rewrite'                => true,
		'query_var'              => true,
	] );

	// Регистрация нового типа поста Город
	register_post_type( 'city', [
		'label'  => null,
		'labels' => [
			'name'               => 'Города',
			'singular_name'      => 'Город',
			'add_new'            => 'Добавить Город',
			'add_new_item'       => 'Добавление нового Города',
			'edit_item'          => 'Редактирование Города',
			'new_item'           => 'Новый Город',
			'view_item'          => 'Просмотреть Город',
			'search_items'       => 'Найти Город',
			'not_found'          => 'Не найдено',
			'not_found_in_trash' => 'Не найдено в корзине',
			'parent_item_colon'  => '',
			'menu_name'          => 'Города',
		],
		'description'            => '',
		'public'                 => true,
		'show_in_rest'           => true,
		'menu_icon'              => 'dashicons-admin-site-alt',
		'hierarchical'           => false,
		'supports'               => [ 'title', 'editor', 'thumbnail', 'revisions'],
		'taxonomies'             => [],
		'has_archive'            => false,
		'rewrite'                => true,
		'query_var'              => true,
	] );
}

// Добавим метабокс выбора города к недвижимости
add_action('add_meta_boxes', function () {
	add_meta_box( 'estate_city', 'Город', 'estate_city_metabox', 'real_estate', 'side', 'low'  );
}, 1);

// метабокс с селектом города
function estate_city_metabox( $post ){
	$cities = get_posts(array( 'post_type'=>'city', 'posts_per_page'=>-1, 'orderby'=>'post_title', 'order'=>'ASC' ));

	if( $cities ){
		echo '<select name="post_parent" id="" style="width: 100%;box-sizing: border-box;">';
		echo '<option value="">Город нахождения</option>';
		foreach( $cities as $city ){
			echo '<option value="'. $city->ID .'" '. selected($city->ID, $post->post_parent, 0) .'>'. esc_html($city->post_title) .'</option>';
		}
		echo '</select>';
	}
	else
		echo 'Городов нет...';
}

// Обработчик ajax-формы
add_action( 'wp_ajax_ajax_form_handler', 'form_handler' );
add_action( 'wp_ajax_nopriv_ajax_form_handler', 'form_handler' );

function form_handler(){
	if (empty($_POST[ 'name' ])) return;

	$post_data = [
		'post_title'    => $_POST[ 'name' ],
		'post_status'   => 'publish',
		'post_type'     => 'real_estate',
	];

	$post_id = wp_insert_post(wp_slash( $post_data ), true);

	update_field('re_square', $_POST[ 'square' ], $post_id);
	update_field('re_price', $_POST[ 'price' ], $post_id);
	update_field('re_address', $_POST[ 'address' ], $post_id);
	update_field('re_living_space', $_POST[ 'living_space' ], $post_id);
	update_field('re_floor', $_POST[ 'floor' ], $post_id);

	$args = array(
		'post_type'      => 'real_estate',
		'post_status'    => 'publish',
		'posts_per_page' => 10,
		'orderby'        => 'date',
		'order'          => 'DESC'
	);

	$query = new WP_Query( $args );

	ob_start();
	if( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'loop-templates/content', 'estate' );
		}
	}
	$content = ob_get_contents();
	ob_end_clean();
	wp_send_json( $content );

}