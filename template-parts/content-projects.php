<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Interface
 */


?>
<?php
// Example foo.php template.
global $project;
$project_obj = new wp_project();

$project = $project_obj->get_count_transactions_of_project(get_the_ID());

?>
<?php if (is_singular()) : ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <?php the_title('<h1 class="m-0 h4 ">', '</h1>'); ?>
            </div>
            <div class="card-body">
            <div class="row">
                <div class="col-12 col-xl-6 col-md-4 ">
                    <?php interface_post_thumbnail('medium'); ?>
                   <p> <?php the_excerpt(); ?></p>
                    <a href="<?php the_field('domain') ?>">zur Website</a>
                </div>

                <div class="col-12 col-xl-6 col-md-4 p-4">
                    <?php get_template_part('template-parts/content', 'data-table'); ?>
                    <?php get_template_part('template-parts/content', 'progressbar'); ?>
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <?php get_template_part('template-parts/content', 'call-to-action') ?>
                        </div>
                        <div class="col-12 col-md-3">
                            <?php get_template_part('template-parts/content', 'contact-modal') ?>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>



        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-md-6 mb-4">
                        <?php the_content(); ?>
                    </div>
                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="chart-pie">
                            <canvas id="chasflow_earnings"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </div>




        <?php if (have_rows('earnings')) : ?>
            <?php $labels = array(); ?>
            <?php $values = array(); ?>
            <?php while (have_rows('earnings')) : the_row(); ?>
                <?php if (get_row_layout() == 'cashflow_eranings') : ?>
                    <?php $labels[] = '"' . get_sub_field('cashflow_title') . '"'; ?>
                    <?php $values[] = get_sub_field('cashflow_earnings_procent'); ?>
                    <?php $colors[] = '"' . get_sub_field('cashflow_earnings_color') . '"'; ?>
                <?php endif; ?>

            <?php endwhile; ?>
        <?php else : ?>
            <?php // no layouts found 
            ?>
        <?php endif; ?>
        <?php // var_dump($values); 
        ?>
        <?php // var_dump($labels); 
        ?>

        <?php // echo implode(',' ,$values )
        ?>
        <script>
            var data = {
                datasets: [{
                    data: [<?php echo implode(',', $values) ?>],
                    backgroundColor: [<?php echo implode(',', $colors) ?>],

                }],
                labels: [<?php echo implode(',', $labels) ?>]


                // These labels appear in the legend and in the tooltips when hovering different arcs
                // 
                // ]
            };
        </script>
        <script>
            jQuery(document).ready(function() {
                var resizeId;
                option = {
                    responsive: true,
                    maintainAspectRatio: false,
                }

                // Pie Chart Example
                var ctx = document.getElementById("chasflow_earnings");
                var myDoughnutChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: option
                });

                jQuery(window).resize(function() {
                    clearTimeout(resizeId);
                    resizeId = setTimeout(afterResizing, 100);
                });

                afterResizing();

                function afterResizing() {
                    var canvaswidth = window.innerWidth

                    if (canvaswidth <= 600) {
                        myDoughnutChart.options.legend.maintainAspectRatio = false;
                        myDoughnutChart.options.legend.responsive = true;

                    } else {
                        myDoughnutChart.options.legend.maintainAspectRatio = true;
                        myDoughnutChart.options.legend.responsive = false;
                    }
                    myDoughnutChart.update();
                }
            });
        </script>





        <?php get_template_part('template-parts/content', 'project-documents') ?>





    </article><!-- #post-<?php the_ID(); ?> -->
<?php else : ?>

    <div class="col-xl-4 col-md-6 mb-4">

        <div class="card  shadow h-100">
            <div class="card-image">
                <?php interface_post_thumbnail('medium'); ?>
            </div>
            <div class="card-header">

                <div class=" font-weight-bold text-primary text-uppercase mb-1"><a href="<?php the_permalink(); ?>"><?php echo get_the_title($post->ID); ?></a> </div>
                <a href="<?php the_field('domain') ?>">zur Website</a>
            </div>



            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">

                        <?php get_template_part('template-parts/content', 'data-table'); ?>

                        <?php get_template_part('template-parts/content', 'progressbar'); ?>

                    </div>

                </div>

            </div>
            <a class="button btn bg-success text-white" href="<?php the_permalink(); ?>">zum Projekt</a>
        </div>

    </div>
<?php endif; ?>