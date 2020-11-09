<?php

/**
 * Template Name: My Invest
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Interface
 */

get_header(); ?>

<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">


        <!-- Begin Page Content -->
        <div class="container-fluid">
            <?php

            function build_quarter_array($array)
            {
                $accumulated = [];

                foreach ($array as $date => $value) {
                    $formattedDate = \DateTime::createFromFormat('d/m/Y', $date);

                    $year = $formattedDate->format('Y');
                    $quarter = ceil($formattedDate->format('m') / 3);
             

                    if (!isset($accumulated[$quarter . '/' . $year])) {
                        $accumulated[$quarter . '/' . $year] = 0;
                    }

                    $accumulated[$quarter . '/' . $year] += $value;
                }

                return $accumulated;
            }




            $user_id = get_current_user_id();
            $trans_obj = new wp_transactions();
            global $trans_obj;

            $transactions = $trans_obj->get_all_transaction_obj($user_id);
            global $transactions;
            if (property_exists($transactions, 'posts')) :
                $current_month = date("m");
                //var_dump($transactions);

                $complete_invest = $transactions->complete_invest;
                if (property_exists($transactions, 'posts')) {
                    $count_projects = $trans_obj->count_projects($transactions);

                    $next_pay_out = $trans_obj->get_next_pay_out_date($current_month);
                    $before_pay_out = $trans_obj->get_before_pay_out_date($current_month);
                    $now = date("d/m/Y");


                    $now = new DateTime();
           
                    $range = $trans_obj->get_date_range($transactions);
                    $range = array_flip($range);
                    $range = array_map(function ($val) {
                        return 0;
                    }, $range);
                    $transactions->payouts_now_complete = 0;
                    $data_arrays = array();

                    foreach ($transactions->posts as $post) {
                        $transactions->payouts_now_complete += $trans_obj->get_complete_pay_out_from_user_from_date($before_pay_out, $post);


                        $transactions_array['post_title'] = get_the_title($post->project_id);
                        $transactions_array['data_array'] = build_quarter_array(array_merge($range, $trans_obj->get_transaction_range($post)));
                        $data_arrays[] = $transactions_array;
                    }
                }

                $arrayKeys = array_keys($data_arrays);
                $lastArrayKey = array_pop($arrayKeys);

            ?>

                <script>
                    function getColor(index) {
                        let colors = ['#5271FF', '#38B6FF', '#5CE1E6', '#00C2CB', '#03989E']


                        index = index % colors.length

                        return colors[index];
                    }

                    var data = {
                        datasets: [
                            <?php $i = 0;
                            foreach ($data_arrays as $k => $data_array) { ?>


                                {
                                    data: [<?php echo implode(',', $data_array['data_array']) ?>],
                                    backgroundColor: getColor(<?php echo $i ?>),
                                    label: '<?php echo $data_array['post_title'] ?>'
                                }
                                <?php if (!($k == $lastArrayKey)) {
                                    echo ',';
                                } ?>




                            <?php $i++;
                            } ?>
                        ],
                        labels: [<?php
                                    $arrayKeys = array_keys($data_array);
                                    // Fetch last array key
                                    $lastArrayKey = array_pop($arrayKeys);

                                    foreach ($data_array['data_array'] as $key => $label) {
                                        echo '"' . $key . '"';
                                        if (!($key == $lastArrayKey)) {
                                            echo ',';
                                        }
                                    } ?>]

                    };
                </script>


                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1><?php echo _e('Hallo ',  'interface') . $current_user->display_name ?> </h1>

                </div>




                <div class="row row-eq-height mb-4">

                    <!-- Area Chart -->
                    <div class="col-xl-8 col-lg-7">
                        <?php get_template_part('template-parts/content', 'complete-overflow-chart'); ?>
   
                    </div>

                    <!-- Pie Chart -->
                    <div class="col-xl-4 col-lg-5">

                        <div class="card shadow h-100">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Übersicht</h6>

                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <?php if ($transactions->posts) { ?>
                                    <?php get_template_part('template-parts/content', 'complete-overflow'); ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php get_template_part('template-parts/content', 'transaction'); ?>
                <?php get_template_part('template-parts/content', 'myprojects'); ?>
                <?php get_template_part('template-parts/content', 'my-documents'); ?>
            <?php else : ?>
                <?php echo 'Du hast keine Investitionen'; ?>
            <?php endif; ?>


        </div>
        <!-- /.container-fluid -->
    </div>

</div>
<!-- End of Main Content -->



<?php get_footer();
