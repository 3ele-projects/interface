<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Interface
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?> INVEST :<?php echo get_the_invest(get_current_user_id(), get_the_ID()); ?>
	</header><!-- .entry-header -->
	<!-- Project Card Example -->
	<div class="row">
		<div class="col-xl-9 col-md-6 mb-4">

			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">INVEST :<?php echo get_the_invest(get_current_user_id(), get_the_ID()); ?></h6>

				</div>
				<div class="card-body">
					<h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
					<div class="progress mb-4">
						<div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
					<div class="progress mb-4">
						<div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
					<div class="progress mb-4">
						<div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
					<div class="progress mb-4">
						<div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
					<div class="progress">
						<div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-md-6 mb-4">

			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary">
							Rendite: <?php the_field('rendite') ?></h6>
					</div>

				</div>
				<div class="card-body">
					<h6 class="m-0 font-weight-bold text-primary">
						Rendite: <?php the_field('rendite') ?></h6>
					<div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>

				</div>
			</div>
		</div>
	</div>

	<?php interface_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();
		the_permalink();
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__('Pages:', 'interface'),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if (get_edit_post_link()) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__('Edit <span class="screen-reader-text">%s</span>', 'interface'),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post(get_the_title())
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->


<script>
	// Set new default font family and font color to mimic Bootstrap's default styling
	Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
	Chart.defaults.global.defaultFontColor = '#858796';

	// Pie Chart Example
	var ctx = document.getElementById("myPieChart");
	var myPieChart = new Chart(ctx, {
		type: 'doughnut',
		data: {
			labels: ["Direct", "Referral", "Social"],
			datasets: [{
				data: [55, 30, 15],
				backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
				hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
				hoverBorderColor: "rgba(234, 236, 244, 1)",
			}],
		},
		options: {
			maintainAspectRatio: false,
			tooltips: {
				backgroundColor: "rgb(255,255,255)",
				bodyFontColor: "#858796",
				borderColor: '#dddfeb',
				borderWidth: 1,
				xPadding: 15,
				yPadding: 15,
				displayColors: false,
				caretPadding: 10,
			},
			legend: {
				display: false
			},
			cutoutPercentage: 80,
		},
	});
</script>