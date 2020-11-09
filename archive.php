<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Interface
 */

get_header();


?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">
		<!-- Begin Page Content -->
		<div class="container-fluid">



			<!-- Page Heading -->
			<!--
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
	  <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
	</div>
-->
			<!-- Content Row -->
			<div class="row">
				<?php
				// Set the arguments for the query
				$args = array(
					'numberposts'		=> -1, // -1 is for all
					'post_type'		=> 'projects', // or 'post', 'page'
					'orderby' 		=> 'title', // or 'date', 'rand'
					'order' 		=> 'ASC', // or 'DESC'

				);

				// Get the posts
				$myposts = get_posts($args);

				// If there are posts
				if ($myposts) :
					// Loop the posts
					foreach ($myposts as $mypost) :

						$project = new wp_project($mypost);

						global $project_obj;


						$project_obj = $project->get_count_transactions_of_project($mypost->ID);

				?>
						<?php get_template_part('template-parts/content', 'projects'); ?>




					<?php endforeach;
					wp_reset_postdata(); ?>
				<?php endif; ?>



			</div>

		</div>

	</div>
	<!-- End of Main Content -->