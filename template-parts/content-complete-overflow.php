          <!-- DataTales Example -->
          <?php
       

          $user_id = get_current_user_id();

          global $transactions;
          global $trans_obj;
 
       

          if (property_exists($transactions, 'posts')) {
            $transactions_count = count($transactions->posts);
            $current_month = date("m");
            $current_year = date("Y");
           
            $current_quarter = ceil($current_month / 3);
            $current_date_range = $current_quarter . '/' .$current_year;

            $next_quarter_invest_return = 0;
            foreach ($trans_obj->data_arrays as $data_array){
              if (array_key_exists($current_date_range,$data_array['data_array'])){
                $next_quarter_invest_return += $data_array['data_array'][$current_date_range];
              } else {
                $next_quarter_invest_return += 0;
              }
          
            }

            
           $next_invest_return = $trans_obj->get_next_return( $user_id, $transactions->posts);

            $next_pay_out = $trans_obj->get_next_pay_out_date($current_month);
            $count_projects = $trans_obj->count_projects($transactions);
            $complete_invest =  $transactions->complete_invest;
         //   var_dump($transactions->payouts_now_complete);
          
            $avg_rendite = $trans_obj->get_avg_return( $complete_invest, $next_invest_return);

          }


          ?>



          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable_overflow" width="100%" cellspacing="0">
              <tr>
                <td> Investitionsvolumen </td>
                <td class="text-xs-right text-right"><span class="h5 mb-0 font-weight-bold text-gray-800"><?php echo add_thousand_sep($complete_invest); ?> €</td>
              </tr>
              <tr>
                <td> Beteiligte Projekte </td>
                <td class="text-xs-right text-right"><span class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_projects; ?></td>
              </tr>
              <tr>
                <td> Einzelne Investments </td>
                <td class="text-xs-right text-right"><span class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $transactions_count; ?></td>
              </tr>

              <tr>
                <td> Ø monatliche Rendite  </td>
           
                <td class="text-xs-right text-right"><span class="h5 mb-0 font-weight-bold text-gray-800"><?php echo round ($avg_rendite, 2)?> %</span></td>
              </tr>

              <tr>
                <td> Bisher ausgezahlt </td>
                <td class="text-xs-right text-right"><span class="h5 mb-0 font-weight-bold text-gray-800"><?php echo add_thousand_sep($transactions->payouts_now_complete); ?> €</span></td>
              </tr>
              <tr>
                <td> Nächste Auszahlung </td>
                <td class="text-xs-right text-right"><span class="h5 mb-0 font-weight-bold text-gray-800"><?php echo add_thousand_sep($next_quarter_invest_return); ?> €</span></td>
              </tr>
              <tr>
                <td> Datum nächster Auszahlung </td>
                <td class="text-xs-right text-right">
                  <span class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $next_pay_out; ?></span></td>
              </tr>

            </table>

          </div>