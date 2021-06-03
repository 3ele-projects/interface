<?php

/**
 * Interface functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Interface
 */




function add_theme_scripts()
{

	wp_enqueue_script('jquery');


	wp_enqueue_script('bootstrap-js', '//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js', array('jquery'), true); // all the bootstrap javascript goodness

	wp_enqueue_script('j-easing', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js', array('jquery'), 1.1, true);
	wp_enqueue_script('chart', 'https://cdn.jsdelivr.net/npm/chart.js@2.8.0', array('jquery'), 1.1, true);
	wp_enqueue_script('sb-admin', get_template_directory_uri() . '/js/sb-admin-2.js', array('jquery'), 1.1, true);
}
add_action('wp_enqueue_scripts', 'add_theme_scripts');

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('interface_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function interface_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Interface, use a find and replace
		 * to change 'interface' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('interface', get_template_directory() . '/languages');

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
				'menu-1' => esc_html__('Primary', 'interface'),
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
				'interface_custom_background_args',
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
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action('after_setup_theme', 'interface_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function interface_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'interface'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'interface'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'interface_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function interface_scripts()
{
	$modificated = date('YmdHi', filemtime(get_stylesheet_directory() . '/style.css'));
	wp_enqueue_style('interface-style', get_stylesheet_uri(), array(), $modificated);
	wp_style_add_data('interface-style', 'rtl', 'replace');

	wp_enqueue_script('interface-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'interface_scripts');

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

require get_template_directory() . '/post-types/transactions.php';
require get_template_directory() . '/post-types/projects.php';
require get_template_directory() . '/inc/acf.php';
require get_template_directory() . '/inc/admin_fields.php';
require get_template_directory() . '/class-projects.php';
require get_template_directory() . '/class-transactions.php';





function get_all_transactions($project_id)
{

	$meta_query = array(
		'relation' => 'AND', /* <-- here */
		array(
			'key' => 'end_date',
			'value' => date('Ymd'),
			'type' => 'DATE',
			'compare' => '>='
		),
		array(
			'meta_key' => 'projects',
			'meta_value' => $project_id,
			'compare' => '='
		),
	);



	$rd_args = array(

		'post_type' => 'transaction',
		'meta_query' => $meta_query


	);
	//$rd_query = new WP_Query( $rd_args );

	$rd_query = get_posts($rd_args); #	$projects_ids[]


	//var_dump($rd_query);
	$complete_invest = 0;
	foreach ($rd_query as $post) :
		$complete_invest	= $complete_invest + get_field('invest', $post->ID);
	//var_dump($post);
	endforeach;
	return $complete_invest;
}

function get_the_first_invest_time_obj($project_id)
{

	$meta_query = array(
		'relation' => 'AND', /* <-- here */
		array(
			'key' => 'end_date',
			'value' => date('Ymd'),
			'type' => 'DATE',
			'compare' => '>='
		),
		array(
			'meta_key' => 'projects',
			'meta_value' => $project_id,
			'compare' => '='
		),
	);



	$rd_args = array(

		'post_type' => 'transaction',
		'meta_query' => $meta_query,
		'meta_key'			=> 'end_date',
		'orderby'			=> 'meta_value',
		'order'				=> 'ASC',
		'posts_per_page'	=> 1,


	);
	//$rd_query = new WP_Query( $rd_args );

	$rd_query = get_posts($rd_args); #	$projects_ids[]


	$complete_invest = 0;
	foreach ($rd_query as $post) :
		$end_date = get_field('end_date', $post->ID);
	//var_dump($post);
	endforeach;
	return $rd_query[0];
}

function get_the_first_invest_time_user($user_id)
{

	$meta_query = array(
		'relation' => 'AND', /* <-- here */
		array(
			'key' => 'end_date',
			'value' => date('Ymd'),
			'type' => 'DATE',
			'compare' => '>='
		),
		array(
			'meta_key' => 'users',
			'meta_value' => $user_id,
			'compare' => '='
		),
	);



	$rd_args = array(

		'post_type' => 'transaction',
		'meta_query' => $meta_query,
		'meta_key'			=> 'end_date',
		'orderby'			=> 'meta_value',
		'order'				=> 'ASC',
		'posts_per_page'	=> -1,


	);
	//$rd_query = new WP_Query( $rd_args );

	$rd_query = get_posts($rd_args); #	$projects_ids[]


	$complete_invest = 0;
	return $rd_query[0];
}


function get_earnings($invest, $rendite)
{
	return ($invest / 100 *  $rendite);
}

function get_complete_invests($user_id)
{
	$all_transactions = get_transactions($user_id);
	$complete_invest = 0;
	foreach ($all_transactions as $trans) {
		$complete_invest +=	get_field('invest', $trans->ID);
	}
	return $complete_invest;
}




function get_next_date($user_id)
{
	$all_transactions = get_transactions($user_id);
	$complete_invest = 0;
	foreach ($all_transactions as $trans) {
		$invest = get_field('invest', $trans->ID);
		$projects = get_field('projects', $trans->ID);
		$project_id = $projects->ID;
		$rendite = get_field('rendite', $project_id);

		return get_earnings($invest, $rendite);
	}
	return $complete_invest;
}

function get_last_date($user_id)
{
	$all_transactions = get_transactions($user_id);
	$complete_invest = 0;
	foreach ($all_transactions as $trans) {
		$invest = get_field('invest', $trans->ID);
		$projects = get_field('projects', $trans->ID);
		$project_id = $projects->ID;
		$rendite = get_field('rendite', $project_id);

		return get_earnings($invest, $rendite);
	}
	return $complete_invest;
}

function get_progress_bar($invest, $complete_invest)
{
	$progress = $invest / ($complete_invest / 100);

?>
	<div class="progress" style="height: 20px;">
		<div class="progress-bar" role="progressbar" style="width: <?php echo $progress ?>%;" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $progress; ?> %
		</div>
	</div>
<?php }

function get_the_invest($user_id, $project_id)
{
	$meta_query_args = array(
		'relation' => 'AND', // Optional, defaults to "AND"
		array(
			'key'     => 'projects',
			'value'   => $project_id,
			'compare' => '='
		),
		array(
			'relation' => 'AND',
			array(
				'key'     => 'user',
				'value'   => $user_id,
				'compare' => '='
			)
		)
	);
	$meta_query = new WP_Meta_Query($meta_query_args);

	$rd_args = array(
		'meta_key' => 'user',
		'meta_value' => $user_id,
		'post_type' => 'transaction',
		'meta_query' => $meta_query_args
	);
	//$rd_query = new WP_Query( $rd_args );

	$rd_query = get_posts($rd_args);
	$sum = 0;
	foreach ($rd_query as $transaction) {
		$sum = $sum + get_field('invest', $transaction->ID);
	}
	return $sum;
}

function get_projects($user_id)
{

	$rd_args = array(
		'meta_key' => 'user',
		'meta_value' => $user_id,
		'post_type' => 'transaction',



	);
	//$rd_query = new WP_Query( $rd_args );

	$rd_query = get_posts($rd_args); #	$projects_ids[]
	$projects_ids = array();


	foreach ($rd_query as $post) :
		$projects_ids[] = get_field('projects', $post->ID);
	endforeach;
	$result = $projects_ids;

	$final  = array();

	foreach ($result as $current) {

		if (!in_array($current, $final)) {
			$final[] = $current;
		}
	}

	return $final;
}

function get_docs($user_id)
{

	$rd_args = array(
		'meta_key' => 'user',
		'meta_value' => $user_id,
		'post_type' => 'attachment',


	);
	//$rd_query = new WP_Query( $rd_args );

	$rd_query = get_posts($rd_args); #	$projects_ids[]

	return $rd_query;
}

function get_transaction($user_id)
{

	$rd_args = array(
		'meta_key' => 'user',
		'meta_value' => $user_id,
		'post_type' => 'transaction'



	);
	//$rd_query = new WP_Query( $rd_args );

	$rd_query = get_posts($rd_args); #	$projects_ids[]
	return $rd_query;
}

function get_transactions($user_id)
{

	$rd_args = array(
		'meta_key' => 'user',
		'meta_value' => $user_id,
		'post_type' => 'transaction',


	);
	//$rd_query = new WP_Query( $rd_args );

	$rd_query = get_posts($rd_args); #	$projects_ids[]

	return $rd_query;
}

add_action('admin_menu', 'dashboard_remove_menu_pages');
function dashboard_remove_menu_pages()
{
	remove_menu_page('edit.php');
	remove_menu_page('edit-comments.php');
}
add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
function my_acf_settings_show_admin($show_admin)
{
//	return false;
return true;
}

function add_additional_class_on_li($classes, $item, $args)
{
	if (isset($args->add_li_class)) {
		$classes[] = $args->add_li_class;
	}
	return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

function special_nav_class($classes, $item)
{
	if (is_home()) {
		$classes[] = "special-class";
	}
	return $classes;
}
add_filter('nav_menu_css_class', 'special_nav_class', 10, 2);

//Step 3 :  Add this function to functions.php file to apply .mdl-navigation__link to each a element 

function add_menuclass($ulclass)
{
	return preg_replace('/<a/', '<a class="nav-link"', $ulclass, -1);
}
add_filter('wp_nav_menu', 'add_menuclass');


register_activation_hook(__FILE__, 'wpse43054_activation');
function wpse43054_activation()
{
	$role = get_role('subscriber');
	if ($role) $role->remove_cap('read');
}

register_deactivation_hook(__FILE__, 'wpse43054_deactivation');
function wpse43054_deactivation()
{
	$role = get_role('subscriber');
	if ($role) $role->add_cap('read');
}

add_action('init', 'wpse43054_maybe_redirect');
function wpse43054_maybe_redirect()
{
	if (is_admin() && !current_user_can('read')) {
		wp_redirect(home_url(), 302);
		exit();
	}
}

add_filter('get_user_metadata', 'wpse43054_hijack_admin_bar', 10, 3);
function wpse43054_hijack_admin_bar($null, $user_id, $key)
{
	if ('show_admin_bar_front' != $key) return null;
	if (!current_user_can('read')) return 0;
	return null;
}

function login_redirect($redirect_to, $request, $user)
{
	return home_url();
}
add_filter('login_redirect', 'login_redirect', 10, 3);


add_action('init', 'fb_init');
function fb_init()
{
	// this in a function for init-hook


}

function en_redirect_attachment_page()
{
	if (is_attachment()) {
		global $post;
		if ($post && $post->post_parent) {
			wp_redirect(esc_url(get_permalink($post->post_parent)), 301);
			exit;
		} else {
			wp_redirect(esc_url(home_url('/')), 301);
			exit;
		}
	}
}
add_action('template_redirect', 'en_redirect_attachment_page');


add_filter('acf/fields/relationship/query/key=field_5fa148a75bf71', 'my_acf_fields_relationship_query', 10, 3);
function my_acf_fields_relationship_query($args, $field, $post_id)
{

	$args = array(
		'post_type' => 'attachment',
		'post_status' => 'inherit',
		'post_mime_type' => ['application/pdf'],
		'meta_query'	=> 	 array(
			array(
				'key'	  	=> 'access_by_user',
				'compare' 	=> 'NOT EXISTS'
			)
		)
	);

	return $args;
}


function add_thousand_sep($int)
{
	return number_format($int,  2, ',', '.');
}
