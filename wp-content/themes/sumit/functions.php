<?php
/**
 * sumit functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package sumit
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function sumit_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on sumit, use a find and replace
	 * to change 'sumit' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('sumit', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'sumit'),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'sumit_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'sumit_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function sumit_content_width()
{
	$GLOBALS['content_width'] = apply_filters('sumit_content_width', 640);
}
add_action('after_setup_theme', 'sumit_content_width', 0);

function prd($data)
{
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function sumit_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'sumit'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'sumit'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'sumit_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function sumit_scripts()
{
	wp_enqueue_style('sumit-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('sumit-style', 'rtl', 'replace');

	wp_enqueue_script('sumit-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'sumit_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}


/* =====================
   Custom Post Type: Property
   ===================== */

function register_property_post_type()
{
	register_post_type('property', [
		'labels' => [
			'name' => 'Properties',
			'singular_name' => 'Property',
			'add_new' => 'Add New',
			'add_new_item' => 'Add New Property',
			'edit_item' => 'Edit Property',
			'new_item' => 'New Property',
			'view_item' => 'View Property',
			'search_items' => 'Search Properties',
			'not_found' => 'No properties found',
			'not_found_in_trash' => 'No properties found in Trash',
		],
		'public' => true,
		'has_archive' => true,
		'rewrite' => ['slug' => 'properties'],
		'menu_icon' => 'dashicons-admin-home',
		'supports' => ['title', 'editor', 'thumbnail'],
		'show_in_rest' => true,
	]);
}
add_action('init', 'register_property_post_type');

/* =====================
   Custom Taxonomy: Property Type
   ===================== */

function register_property_taxonomy()
{
	register_taxonomy('property_type', 'property', [
		'labels' => [
			'name' => 'Property Types',
			'singular_name' => 'Property Type',
		],
		'hierarchical' => true,
		'public' => true,
		'rewrite' => ['slug' => 'property-type'],
		'show_in_rest' => true,
	]);
}
add_action('init', 'register_property_taxonomy');

/* =====================
   ACF Fields for Property Post Type
   ===================== */

if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group(array(
		'key' => 'group_property_fields',
		'title' => 'Property Details',
		'fields' => array(
			array(
				'key' => 'field_property_id',
				'label' => 'Property ID',
				'name' => 'property_id',
				'type' => 'text',
			),
			array(
				'key' => 'field_address',
				'label' => 'Address',
				'name' => 'address',
				'type' => 'text',
			),
			array(
				'key' => 'field_status',
				'label' => 'Status',
				'name' => 'status',
				'type' => 'select',
				'choices' => array(
					'Active' => 'Active',
					'Pending' => 'Pending',
					'Sold' => 'Sold',
				),
				'default_value' => 'Active',
				'return_format' => 'value',
			),
			array(
				'key' => 'field_price',
				'label' => 'Price',
				'name' => 'price',
				'type' => 'number',
				'prepend' => '$',
			),
			array(
				'key' => 'field_beds',
				'label' => 'Beds',
				'name' => 'beds',
				'type' => 'number',
			),
			array(
				'key' => 'field_baths',
				'label' => 'Baths',
				'name' => 'baths',
				'type' => 'number',
			),
			array(
				'key' => 'field_area',
				'label' => 'Area (Sq.Ft.)',
				'name' => 'area',
				'type' => 'number',
			),
			array(
				'key' => 'property_image',
				'label' => 'Image',
				'name' => 'image',
				'type' => 'image',
				'instructions' => 'Upload a property image.',
				'return_format' => 'array',
				'preview_size' => 'medium',
				'library' => 'all',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'property',
				),
			),
		),
	));
}

function enqueue_property_tabs_script()
{
	wp_enqueue_script(
		'property-tabs',
		get_template_directory_uri() . '/js/property-tabs.js',
		[],
		'1.0',
		true
	);

	wp_localize_script('property-tabs', 'ajax_params', [
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('load_more_nonce'),
	]);
}
add_action('wp_enqueue_scripts', 'enqueue_property_tabs_script');

/* =====================
   load_properties AJAX handler (functions.php)
   ===================== */

add_action('wp_ajax_load_properties', 'ajax_load_properties');
add_action('wp_ajax_nopriv_load_properties', 'ajax_load_properties');

function ajax_load_properties()
{
	check_ajax_referer('load_more_nonce', 'nonce');

	$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
	$term_id = isset($_POST['term_id']) ? intval($_POST['term_id']) : 0;

	$args = [
		'post_type' => 'property',
		'posts_per_page' => 6,
		'offset' => $offset,
	];

	if ($term_id) {
		$args['tax_query'] = [
			[
				'taxonomy' => 'property_type',
				'field' => 'term_id',
				'terms' => $term_id,
			],
		];
	}

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			get_template_part('template-parts/content', 'property');
		}
	} else {
		echo 'No more properties found.';
	}
	wp_reset_postdata();

	wp_die();
}

add_action('wp_enqueue_scripts', function () {
	wp_enqueue_script('property-loadmore');
	wp_localize_script('property-loadmore', 'ajax_params', [
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('load_more_nonce')
	]);
});


if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group(array(
		'key' => 'group_flexible_sections',
		'title' => 'Flexible Page Sections',
		'fields' => array(
			array(
				'key' => 'field_flexible_content',
				'label' => 'Page Sections',
				'name' => 'page_sections',
				'type' => 'flexible_content',
				'layouts' => array(
					'layout_hero' => array(
						'key' => 'layout_hero',
						'name' => 'hero_section',
						'label' => 'Hero Section',
						'display' => 'block',
						'sub_fields' => array(
							array(
								'key' => 'field_hero_title_repeater',
								'label' => 'Core value',
								'name' => 'hero_titles',
								'type' => 'repeater',
								'sub_fields' => array(
									array(
										'key' => 'field_hero_title',
										'label' => 'Title',
										'name' => 'title',
										'type' => 'text',
									),
								),
								'min' => 1,
								'layout' => 'table',
								'button_label' => 'Add more',
							),
							array(
								'key' => 'field_hero_subtitle',
								'label' => 'Subtitle',
								'name' => 'subtitle',
								'type' => 'text',
							),
							array(
								'key' => 'field_hero_background',
								'label' => 'Background Image',
								'name' => 'background_image',
								'type' => 'image',
							),
						),
					),
					'layout_properties' => array(
						'key' => 'layout_properties',
						'name' => 'property_section',
						'label' => 'Property List Section',
						'display' => 'block',
						'sub_fields' => array(
							array(
								'key' => 'field_section_title',
								'label' => 'Section Title',
								'name' => 'section_title',
								'type' => 'text',
							),
						),
					),
				),
				'button_label' => 'Add Section',
				'min' => '',
				'max' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-flexible.php',
				),
			),
		),
	));
}



/* =====================
   Header/Footer Theme Options (ACF)
   ===================== */

if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' => 'Theme General Settings',
		'menu_title' => 'Theme Settings',
		'menu_slug' => 'theme-general-settings',
		'capability' => 'edit_posts',
		'redirect' => false
	));

	acf_add_local_field_group(array(
		'key' => 'group_theme_options',
		'title' => 'Header/Footer Settings',
		'fields' => array(
			array(
				'key' => 'field_logo',
				'label' => 'Logo',
				'name' => 'logo',
				'type' => 'image',
				'return_format' => 'url',
			),
			array(
				'key' => 'field_footer_text',
				'label' => 'Footer Text',
				'name' => 'footer_text',
				'type' => 'text',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'theme-general-settings',
				),
			),
		),
	));
}

/**
 * Enqueue custom CSS file.
 */
function sumit_enqueue_custom_css()
{
	wp_enqueue_style(
		'sumit-custom-style',
		get_template_directory_uri() . '/custom.css',
		array(),
		_S_VERSION
	);
}
add_action('wp_enqueue_scripts', 'sumit_enqueue_custom_css');
