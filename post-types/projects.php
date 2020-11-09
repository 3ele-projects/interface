<?php

/**
 * Registers the `projects` post type.
 */
function projects_init()
{
	register_post_type('Projects', array(
		'labels'                => array(
			'name'                  => __('Projects', 'interface'),
			'singular_name'         => __('Project', 'interface'),
			'all_items'             => __('All projects', 'interface'),
			'archives'              => __('projects Archives', 'interface'),
			'attributes'            => __('projects Attributes', 'interface'),
			'insert_into_item'      => __('Insert into projects', 'interface'),
			'uploaded_to_this_item' => __('Uploaded to this projects', 'interface'),
			'featured_image'        => _x('Featured Image', 'projects', 'interface'),
			'set_featured_image'    => _x('Set featured image', 'projects', 'interface'),
			'remove_featured_image' => _x('Remove featured image', 'projects', 'interface'),
			'use_featured_image'    => _x('Use as featured image', 'projects', 'interface'),
			'filter_items_list'     => __('Filter projects list', 'interface'),
			'items_list_navigation' => __('projects list navigation', 'interface'),
			'items_list'            => __('projects list', 'interface'),
			'new_item'              => __('New projects', 'interface'),
			'add_new'               => __('Add New', 'interface'),
			'add_new_item'          => __('Add New projects', 'interface'),
			'edit_item'             => __('Edit projects', 'interface'),
			'view_item'             => __('View projects', 'interface'),
			'view_items'            => __('View projects', 'interface'),
			'search_items'          => __('Search projects', 'interface'),
			'not_found'             => __('No projects found', 'interface'),
			'not_found_in_trash'    => __('No projects found in trash', 'interface'),
			'parent_item_colon'     => __('Parent projects:', 'interface'),
			'menu_name'             => __('Projects', 'interface'),
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
		'rest_base'             => 'projects',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	));
}
add_action('init', 'projects_init');

/**
 * Sets the post updated messages for the `projects` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `projects` post type.
 */
function projects_updated_messages($messages)
{
	global $post;

	$permalink = get_permalink($post);

	$messages['projects'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf(__('projects updated. <a target="_blank" href="%s">View projects</a>', 'interface'), esc_url($permalink)),
		2  => __('Custom field updated.', 'interface'),
		3  => __('Custom field deleted.', 'interface'),
		4  => __('projects updated.', 'interface'),
		/* translators: %s: date and time of the revision */
		5  => isset($_GET['revision']) ? sprintf(__('projects restored to revision from %s', 'interface'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
		/* translators: %s: post permalink */
		6  => sprintf(__('projects published. <a href="%s">View projects</a>', 'interface'), esc_url($permalink)),
		7  => __('projects saved.', 'interface'),
		/* translators: %s: post permalink */
		8  => sprintf(__('projects submitted. <a target="_blank" href="%s">Preview projects</a>', 'interface'), esc_url(add_query_arg('preview', 'true', $permalink))),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf(
			__('projects scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview projects</a>', 'interface'),
			date_i18n(__('M j, Y @ G:i', 'interface'), strtotime($post->post_date)),
			esc_url($permalink)
		),
		/* translators: %s: post permalink */
		10 => sprintf(__('projects draft updated. <a target="_blank" href="%s">Preview projects</a>', 'interface'), esc_url(add_query_arg('preview', 'true', $permalink))),
	);

	return $messages;
}
add_filter('post_updated_messages', 'projects_updated_messages');
