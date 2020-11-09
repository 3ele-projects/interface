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
            <div class="row">
                <?php
                if (have_posts()) : while (have_posts()) : the_post();
                        get_template_part('template-parts/content', 'projects');

                    endwhile;
                endif;
                ?>


            </div>

        </div>
    </div>

</div>
<?php get_footer();
