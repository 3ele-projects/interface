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
                $current_month = date("n");           
                $complete_invest = $transactions->complete_invest;
                if (property_exists($transactions, 'posts')) {
                    $count_projects = $trans_obj->count_projects($transactions);
                    $next_pay_out = $trans_obj->get_next_pay_out_date($current_month);       
                    $before_pay_out = $trans_obj->get_before_pay_out_date($current_month);
                    $now = new DateTime(); 
                    $range = $trans_obj->get_date_range($transactions);
                  //  $first_date =$range[0]; 
                    $range = array_flip($range);
                    $range = array_map(function ($val) {
                        return 0;
                    }, $range);
                    $transactions->payouts_now_complete = 0;
                    $data_arrays = array();

             
              
                 /*   if ($first_date >= $before_pay_out) {
                        $before_pay_out = $first_date;
                    }
*/
            
         
                  
                    /*
                    Wenn das Startdatum der Investition in selben Quartal ist, wie die erste Auszahlung, dann gibt es keine Auszahlungen?
                    Wenn zwischen Startdatum der Investition und jetzt kein Quartal dazwischen liegt, dann gibt es keine Auzahlungen?
                    
                    Infos, die wir haben:

                    Startdatum der Investition
                    Zeitpunkt JETZT.

                    Fixe Zeitpunkte: 10.01. 10.04. 10.07. 10.10. 

                    Wieviele Auszahlungen gab es zwischen Startdatum und 
                    Jetzt WENN die Auszahlungsdaten immer rückwirkend pro Quartal am 10. ist?
                    
                    Bsp.: Startdatum 11.01.2021 || 10.01 ???
                    JETZT: 02.06.2021 
                    Ergebnis 1


                    */
        

          
                   // var_dump($payout_date->modify('-3 month')->format('d/m/Y'));
               
                
               $i = 0;
             
               foreach ($transactions->posts as $post) {
                $first_date = DateTime::createFromFormat('d/m/Y', $post->start_date);
                $payout_date = $trans_obj->get_next_pay_out_date($before_pay_out->format('n'));
                //   var_dump( $payout_date);
                   $payout_date = DateTime::createFromFormat('d/m/Y',  $payout_date);

                $year1 =  $first_date->format('Y');
                $year2 =  $payout_date->format('Y');
                $month1 =$first_date->format('m');
                $month2 = $payout_date->format('m');
              
                $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
              //  var_dump($trans_obj->get_quartals_between_dates($first_date->format('d/m/Y'), $payout_date));
             
               $n = ceil($diff / 3 -1);
     
   
       
                if ($n > 0) {
                    $last_payment_out = $payout_date->modify('-3 month');
               //     var_dump($trans_obj);
            
                $transactions->payouts_now_complete += $trans_obj->get_complete_pay_out_from_user_from_date($last_payment_out , $post);
            };
                    


                   

                        $transactions_array['post_title'] = get_the_title($post->project_id);
                        $transactions_array['data_array'] = build_quarter_array(array_merge($range, $trans_obj->get_transaction_range($post)));
                        $data_arrays[] = $transactions_array;
                    }
                }

                $arrayKeys = array_keys($data_arrays);
                $lastArrayKey = array_pop($arrayKeys);
                $trans_obj->data_arrays = $data_arrays;

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
