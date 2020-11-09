<?php

class Rational_Meta_Box
{
	private $screens = array(
		'projects'
	);



	private $fields = array(
		array(
			'id' => 'invest',
			'label' => 'invest',
			'type' => 'number',
		),
		array(
			'id' => 'user_id',
			'label' => 'User_ID',
			'type' => 'number',
		),

	);

	/**
	 * Class construct method. Adds actions to their respective WordPress hooks.
	 */
	public function __construct()
	{
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'save_post'));
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 * Goes through screens (post types) and adds the meta box.
	 */
	public function add_meta_boxes()
	{
		foreach ($this->screens as $screen) {
			add_meta_box(
				'projects',
				__('Übersicht Transactionen pro Projekt', 'projects_for_user'),
				array($this, 'add_meta_box_callback'),
				$screen,
				'advanced',
				'high'
			);
		}
	}

	/**
	 * Generates the HTML for the meta box
	 * 
	 * @param object $post WordPress post object
	 */
	public function add_meta_box_callback($post)
	{
		wp_nonce_field('projects_data', 'projects_nonce');
		$this->get_transaction($post);

		$this->get_user();
	}

	/**
	 * Generates the field's HTML for the meta box.
	 */

	public function get_user()
	{
		$users = get_users(array("roles" => "subscriber"));
	}



	public function get_transaction($post)
	{
		$rd_args = array(
			'meta_key' => 'projects',
			'meta_value' => $post->ID,
			'post_type' => 'transaction'
		);


		$rd_query = get_posts($rd_args);
		$output = '';

		foreach ($rd_query as $transaction) :
			$label = '<label for="' . $transaction->post_title . '">' . $transaction->post_title  . '</label>';
			$user = get_user_by('ID', get_field('user', $transaction->ID));
			$td = sprintf(
				'<td><input %s id="%s" name="%s" type="%s" value="%s" readonly></td>',
				$transaction->post_title,

				$transaction->post_title,
				$transaction->post_title,
				'number',
				get_field('invest', $transaction->ID)
			);

			$td = sprintf(
				'<td><input %s id="%s" name="%s" type="%s" value="%s" readonly></td>',

				$transaction->post_title,
				$transaction->post_title,
				'projects',
				'text',
				$user->data->user_login


			);
			$td .= sprintf(
				'<td><input %s id="%s" name="%s" type="%s" value="%s" readonly></td>',
				$transaction->post_title,

				$transaction->post_title,
				$transaction->post_title,
				'number',
				get_field('invest', $transaction->ID)
			);

			$output .= $this->row_format($label, $td);
		endforeach;
		echo '<table class="form-table">  <thead><tr>
	<th>Transaction </th>
	<th>User</th>
	<th>Invest</th>
  </tr></thead><tbody>' . $output . '</tbody></table>';
	}

	public function generate_fields($post)
	{

		$output = '';
		foreach ($this->fields as $key => $field) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = get_post_meta($post->ID, 'projects_' . $field['id'], true);
			switch ($field['type']) {
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$field['type'] !== 'color' ? 'class="regular-text"' : '',
						$field['id'],
						$key,
						$field['type'],
						$db_value
					);
			}
			$output .= $this->row_format($label, $input);
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	/**
	 * Generates the HTML for table rows.
	 */
	public function row_format($label, $input)
	{
		return sprintf(
			'<tr><th scope="row">%s</th>%s</tr>',
			$label,
			$input
		);
	}
	/**
	 * Hooks into WordPress' save_post function
	 */
	public function save_post($post_id)
	{
		if (!isset($_POST['projects_nonce']))
			return $post_id;

		$nonce = $_POST['projects_nonce'];
		if (!wp_verify_nonce($nonce, 'projects_data'))
			return $post_id;

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $post_id;

		foreach ($this->fields as $field) {
			if (isset($_POST[$field['id']])) {
				switch ($field['type']) {
					case 'email':
						$_POST[$field['id']] = sanitize_email($_POST[$field['id']]);
						break;
					case 'text':
						$_POST[$field['id']] = sanitize_text_field($_POST[$field['id']]);
						break;
				}
				update_post_meta($post_id, 'projects_' . $field['id'], $_POST[$field['id']]);
			} else if ($field['type'] === 'checkbox') {
				update_post_meta($post_id, 'projects_' . $field['id'], '0');
			}
		}
	}
}
new Rational_Meta_Box;
