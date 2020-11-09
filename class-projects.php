<?php
class wp_project
{

  function  get_count_transactions_of_project($project_id)
  {
    global $wpdb;

    $querystr = "
    SELECT $wpdb->posts.ID,$wpdb->postmeta.meta_value AS transactions
    FROM $wpdb->posts, $wpdb->postmeta
    WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
    AND $wpdb->postmeta.meta_key = 'projects' 
    AND $wpdb->postmeta.meta_value = $project_id
    AND $wpdb->posts.post_status = 'publish' 
    AND $wpdb->posts.post_type = 'transaction'
    ORDER BY $wpdb->posts.post_date DESC
 ";
    $pageposts = $wpdb->get_results($querystr, OBJECT);

    $project  = new stdClass();
    $project->ID = $project_id;
    $complete_invest = 0;
    $project->invests = 0;
    $project->trans_complete = 0;
    $project->user_complete = 0;
    $project->open_invest = get_field('complete_invest', $project_id);
    $project_volumne = get_field('complete_invest', $project_id);
    if ($pageposts) :
      foreach ($pageposts as $post) {
        $invest = get_post_meta($post->ID, 'invest', true);
        $post->user = get_post_meta($post->ID, 'user', true);

        $post->invest = $invest;
        $complete_invest += $invest;



        $post->start_date = get_field('start_date', $post->ID);
        $post->end_date = get_field('end_date', $post->ID);

        $project->posts[] = $post;
      }

      $project->invests = $complete_invest;

      $project->user_complete = $this->count_user($project);
      $project->trans_complete = count($project->posts);

      $project->open_invest = $project_volumne - $project->invests;
    endif;
    $project->docs = array();
    $project->docs = $this->get_documents_of_project($project_id);
    return $project;
  }


  function count_user($project)
  {

    $user_ids  = array_column($project->posts, 'user');
    return count(array_unique($user_ids));
  }

  function  get_documents_of_project($project_id)
  {
    $rd_args = array(

      'post_type' => 'attachment',
      'meta_query'  => array(
        'relation'    => 'AND',
        array(
          'key'     => 'projects',
          'value'      => $project_id,
          'compare'   => '=',
        ),
        array(
          'key'      => 'access_by_user',
          'value'      => '0',
          'compare'   => '=',
        ),
      ),


    );
    //$rd_query = new WP_Query( $rd_args );

    $rd_query = get_posts($rd_args); #	$projects_ids[]
    $docs = get_field('docs', $project_id);
    return   $docs;
  }
}
