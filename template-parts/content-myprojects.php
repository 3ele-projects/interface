       <?php global $transactions; ?>
       <?php global $project; ?>
       <?php // var_dump($transactions->projects);
        ?>
       <!-- Content Row -->
       <div class="row mb-5">
           <?php foreach ($transactions->projects as $project_id) : ?>
               <?php

                $project_obj = new wp_project();
                $project = $project_obj->get_count_transactions_of_project($project_id);
                ?>

               <div class="col-xl-12 col-md-12 mb-3">
                   <div class="card  shadow h-100 py-2">

                       <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                           <h6 class="m-0 font-weight-bold text-primary"><a href="<?php the_permalink($project_id); ?>">Projektdaten:
                                   <?php echo get_the_title($project_id); ?></a>

                           </h6>

                       </div>

                       <div class="card-body">
                           <div class="row">
                               <div class="col col-12  col-xl-6 col-md-12">
                                   <img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id($project_id)); ?>" />
                                   <?php interface_post_thumbnail('medium'); ?>

                                   <p class="mt-5">
                                       <?php echo get_the_excerpt($project_id); ?>
                                   </p>


                               </div>




                               <div class="col col-sm-12  col-xl-6 ml-auto col-md-6">

                                   <?php get_template_part('template-parts/content', 'data-table'); ?>
                                   <?php get_template_part('template-parts/content', 'progressbar'); ?>
                                   <div class="row">
                                       <?php get_template_part('template-parts/content', 'call-to-action') ?>
                                   </div>
                                   <div class="row">
                                       <div class="col-6 col-xl-6">
                                           <a class="button btn bg-success float-left text-white" href="<?php the_permalink($project_id); ?>">zum Projekt</a>
                                       </div>
                                       <div class="col-6 col-xl-6">
                                           <?php get_template_part('template-parts/content', 'contact-modal') ?>

                                       </div>
                                   </div>

                               </div>
                           </div>
                           <div class="row">
                               <div class="col col-12 col-xl-6 col-md-12"> <a target="_blank" href="<?php the_field('domain', $project_id) ?>">zur
                                       Website</a>
                               </div>

                           </div>

                       </div>

                   </div>
               </div>
           <?php endforeach;
            wp_reset_postdata(); ?>




       </div>