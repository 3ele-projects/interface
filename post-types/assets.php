<?php

/**
 * Registers the `assets` post type.
 */
function assets_init()
{
	register_post_type('assets', array(
		'labels'                => array(
			'name'                  => __('Assets', 'interface'),
			'singular_name'         => __('Assets', 'interface'),
			'all_items'             => __('All Assets', 'interface'),
			'archives'              => __('Assets Archives', 'interface'),
			'attributes'            => __('Assets Attributes', 'interface'),
			'insert_into_item'      => __('Insert into assets', 'interface'),
			'uploaded_to_this_item' => __('Uploaded to this assets', 'interface'),
			'featured_image'        => _x('Featured Image', 'assets', 'interface'),
			'set_featured_image'    => _x('Set featured image', 'assets', 'interface'),
			'remove_featured_image' => _x('Remove featured image', 'assets', 'interface'),
			'use_featured_image'    => _x('Use as featured image', 'assets', 'interface'),
			'filter_items_list'     => __('Filter assets list', 'interface'),
			'items_list_navigation' => __('Assets list navigation', 'interface'),
			'items_list'            => __('Assets list', 'interface'),
			'new_item'              => __('New Assets', 'interface'),
			'add_new'               => __('Add New', 'interface'),
			'add_new_item'          => __('Add New Assets', 'interface'),
			'edit_item'             => __('Edit Assets', 'interface'),
			'view_item'             => __('View Assets', 'interface'),
			'view_items'            => __('View Assets', 'interface'),
			'search_items'          => __('Search assets', 'interface'),
			'not_found'             => __('No assets found', 'interface'),
			'not_found_in_trash'    => __('No assets found in trash', 'interface'),
			'parent_item_colon'     => __('Parent Assets:', 'interface'),
			'menu_name'             => __('Assets', 'interface'),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
		'has_archive'           => true,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_position'         => null,
		'menu_icon'             => 'dashicons-admin-post',
		'show_in_rest'          => true,
		'rest_base'             => 'assets',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	));
}
add_action('init', 'assets_init');

/**
 * Sets the post updated messages for the `assets` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `assets` post type.
 */
function assets_updated_messages($messages)
{
	global $post;

	$permalink = get_permalink($post);

	$messages['assets'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf(__('Assets updated. <a target="_blank" href="%s">View assets</a>', 'interface'), esc_url($permalink)),
		2  => __('Custom field updated.', 'interface'),
		3  => __('Custom field deleted.', 'interface'),
		4  => __('Assets updated.', 'interface'),
		/* translators: %s: date and time of the revision */
		5  => isset($_GET['revision']) ? sprintf(__('Assets restored to revision from %s', 'interface'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
		/* translators: %s: post permalink */
		6  => sprintf(__('Assets published. <a href="%s">View assets</a>', 'interface'), esc_url($permalink)),
		7  => __('Assets saved.', 'interface'),
		/* translators: %s: post permalink */
		8  => sprintf(__('Assets submitted. <a target="_blank" href="%s">Preview assets</a>', 'interface'), esc_url(add_query_arg('preview', 'true', $permalink))),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf(
			__('Assets scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview assets</a>', 'interface'),
			date_i18n(__('M j, Y @ G:i', 'interface'), strtotime($post->post_date)),
			esc_url($permalink)
		),
		/* translators: %s: post permalink */
		10 => sprintf(__('Assets draft updated. <a target="_blank" href="%s">Preview assets</a>', 'interface'), esc_url(add_query_arg('preview', 'true', $permalink))),
	);

	return $messages;
}
add_filter('post_updated_messages', 'assets_updated_messages');
