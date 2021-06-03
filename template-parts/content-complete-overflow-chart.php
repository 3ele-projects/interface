<?php
$current_month = date("m");
$user_id = get_current_user_id();
$trans_obj = new wp_transactions();
global $trans_obj;

$transactions = $trans_obj->get_all_transaction_obj($user_id);
global $transactions;

/* */
$start_month = 1;
//echo 'Startmonth';
//var_dump($trans_obj->get_next_pay_out_date($start_month));
//var_dump($trans_obj->get_next_pay_out_date($current_month));
$d1 = new DateTime($trans_obj->get_next_pay_out_date($current_month));
$d2 = new DateTime($trans_obj->get_next_pay_out_date($start_month));
$dt = strtotime($trans_obj->get_next_pay_out_date($current_month));
//var_dump($d1);
$next_pay_out = $trans_obj->get_next_pay_out_date($current_month);
$before_pay_out = $trans_obj->get_before_pay_out_date($current_month);

$range = $trans_obj->get_date_range($transactions);
$range = array_flip($range);
$range = array_map(function ($val) {
    return 0;
}, $range);
//$transactions->payouts_now_complete = 0;
$data_arrays = array();

foreach ($transactions->posts as $post) {



    $transactions_array['post_title'] = get_the_title($post->project_id);
    $transactions_array['data_array'] = build_quarter_array(array_merge($range, $trans_obj->get_transaction_range($post)));
    $data_arrays[] = $transactions_array;
}






$arrayKeys = array_keys($data_arrays);
// Fetch last array key
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



    var option = {
        responsive: true,

        layout: {
            padding: {
                left: 10,
                right: 0,
                top: 0,
                bottom: 20
            },
        },
        legend: {
            position: 'top',
        },
        title: {
            display: false,

        },
        "scales": {
            "yAxes": [{
                "stacked": true,

                "ticks": {
                    "beginAtZero": true
                }
            }],
            "xAxes": [{
                "stacked": true,

            }],

        }
    };
</script>



<div class="card complete-overflow-chart shadow">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo _e('Auszahlungsverlauf',  'interface') ?></h6>

    </div>
    <!-- Card Body -->
    <div class="card-body">
        <div class="chart-area2">
            <?php $all_transactions = get_transactions($user_id); ?>



            <canvas id="chartjs-1"></canvas>



            <script>
                jQuery(document).ready(function() {
                    var resizeId;
                    var chart1 = new Chart(document.getElementById("chartjs-1"), {
                        "type": "bar",
                        "data": data,
                        "options": option
                    });

                    jQuery(window).resize(function() {
                        clearTimeout(resizeId);
                        resizeId = setTimeout(afterResizing, 100);
                    });

                    afterResizing();

                    function afterResizing() {
                        var canvaswidth = window.innerWidth

                        if (canvaswidth <= 600) {
                            chart1.options.legend.display = false;
                        } else {
                            chart1.options.legend.display = true;
                        }
                        chart1.update();
                    }

                });
            </script>
        </div>
    </div>
</div>