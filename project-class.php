<?php 
class wpproject {

}
class wp_transactions {
 
    

function get_all_transaction_obj($user_id){
    global $wpdb;

    $querystr = "
    SELECT $wpdb->posts.ID,$wpdb->postmeta.meta_value AS user
    FROM $wpdb->posts, $wpdb->postmeta
    WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
    AND $wpdb->postmeta.meta_key = 'user' 
    AND $wpdb->postmeta.meta_value = $user_id 
    AND $wpdb->posts.post_status = 'publish' 
    AND $wpdb->posts.post_type = 'transaction'
    ORDER BY $wpdb->posts.post_date DESC
 ";
$pageposts = $wpdb->get_results($querystr, OBJECT);
$transactions  = new stdClass();
$complete_invest = 0;

foreach($pageposts as $post){
    $invest = get_post_meta($post->ID, 'invest', true);
    $rendite =  get_post_meta($post->ID, 'rendite', true);
    $post->project_id = get_post_meta($post->ID, 'projects', true);
    $post->invest = $invest;
    $complete_invest += $invest; 
    if (empty($rendite)):
        $rendite = get_post_meta($post->project_id, 'rendite', true);
    endif;
    $post->rendite = $rendite;

    $post->start_date = get_field('start_date', $post->ID);
    $post->end_date = get_field('end_date', $post->ID);

$transactions->posts[] = $post;
}

$transactions->complete_invest = $complete_invest; 

return $transactions;

}

function count_projects($transactions){
  
    $project_ids  = array_column($transactions->posts, 'project_id');
    return count(array_unique ($project_ids));

}

/* Earnings ist pro Invest und inkludiert den Monat */
function get_earnings($invest,$rendite){
	return ($invest / 100 *  $rendite);

}

function get_timeline($transactions){
    $first_transaction = $transactions->posts[count($transactions->posts)-1];
    $last_transaction = $transactions->posts[0];
    $quartals = get_quartals_between_dates($first_transaction->start_date,$last_transaction->end_date);
    $date1 = $first_transaction->start_date;
    $date2 = $last_transaction->end_date;
    $d1=new DateTime($date2); 
    $d2=new DateTime($date1);                                  
    $Months = $d2->diff($d1); 
    $howeverManyMonths = (($Months->y) * 12) + ($Months->m);
   // var_dump($howeverManyMonths);
}
    
function get_avg_return($user_id ,$complete_invests, $next_invest_return){        
    $avg_return = ($next_invest_return/$complete_invests)* 100;
    return $avg_return;
    }
    

    function get_next_pay_out_date($current_month){
        $year = date("Y"); 


        $dt = strtotime($year."-01-10");

        if($current_month>=1 && $current_month<=3)
        {
            $dt = strtotime($year."-04-10");

        }
        else  if($current_month>=4 && $current_month<=6)
        {
            $dt = strtotime($year."-07-10");
            $pay_out_date = date("d/m/Y", strtotime( $dt));
        }
        else  if($current_month>=7 && $current_month<=9)
        {
            $dt = strtotime($year."-04-10");
            $pay_out_date = date("d/m/Y", strtotime( $dt));
            
        }
        else  if($current_month>=10 && $current_month<=12)
        {
            $pay_out_date = date("d/m/Y", strtotime("1 year", $dt));
    }
    return $pay_out_date;
    }


function get_between($var, $start, $end){
    if($var == $start){
        return 3;
    }
    elseif ($var == $end){
        return 1;

    }
    else {
        return 2;
    }

}



    function get_pay_out_by_quarters($now, $post){
  
        $start_date_obj = new DateTime($post->start_date);
        $end_date_obj = new DateTime($post->end_date);
          
        if ($now > $end_date_obj) return 0;

          else {
         $quarters = $this->get_quartals_between_dates($post->start_date, $post->end_date);

         $complete_earnings = 0;  
          
          
        $first_q = array_shift($quarters);

        $period_start =new DateTime($first_q->period_start);
        $period_end = new DateTime($first_q->period_end);
          
        $period_start = $period_start->format('m');
        $period_end = $period_end->format('m');
        $multiplikator = $this->get_between($start_date_obj->format('m'), $period_start, $period_end);
        $complete_earnings += $multiplikator * $this->get_earnings($post->invest,$post->rendite);


$last_q = array_pop($quarters);


$period_start =new DateTime($last_q->period_start);
$period_end = new DateTime($last_q->period_end);
  
$period_start = $period_start->format('m');
$period_end = $period_end->format('m');

$multiplikator = $this->get_between($start_date_obj->format('m'), $period_start, $period_end);
$complete_earnings += $multiplikator * $this->get_earnings($post->invest,$post->rendite);

foreach ($quarters as $quarter){

//var_dump($quarters);
$complete_earnings += $this->get_earnings($post->invest,$post->rendite)*3;
            }
  
          }
    
        

    }

    function get_transaction_range($post){
        $format = "d/m/Y";
        $d1 = DateTime::createFromFormat($format, $post->start_date);
        $d2 = DateTime::createFromFormat($format, $post->end_date);

                                         
        $Months = $d2->diff($d1); 
       // var_dump(  $Months);
        $range_array = array();
        $m_diff = (($Months->y) * 12) + ($Months->m);
      
        $i = 0;

        while ($i < $m_diff){
         $c_date =   $d1->modify('+1 month');
         $month_earnings = $this->get_earnings($post->invest, $post->rendite);
         $range_array[$c_date->format('d/m/Y') ] =  $month_earnings ;
         
            $i +=1;
        }
        
        return $range_array;

    }

    function get_date_range($transactions){
        $last_transaction = $transactions->posts[count($transactions->posts)-1];
        $first_transaction = $transactions->posts[0];
        $date1 = $first_transaction->start_date;
        $date2 = $last_transaction->end_date;
        $format = "d/m/Y";
        $date1 = DateTime::createFromFormat($format, $date1);
        $date2 = DateTime::createFromFormat($format, $date2);
                                       
        $Months = $date2->diff($date1); 
        $range_array = array();
        $m_diff = (($Months->y) * 12) + ($Months->m);

        $i = 0;

        while ($i < $m_diff){
         $c_date = $date1->modify('+1 month');

         $range_array[] =  '"'.$c_date->format('d/m/Y').'"' ;    
            $i +=1;
        }
        return $range_array;

    }



function get_quartals_between_dates($start_date, $end_date){
    //var_dump($start_date, $end_date);
    $quarters = $this->get_quarters($start_date, $end_date);
    //var_dump($quarters);
    return ($quarters);
    
    }
    
    // get month name from number
    function month_name($month_number){
        return date('F', mktime(0, 0, 0, $month_number, 10));
    }
    
    
    // get get last date of given month (of year)
    function month_end_date($year, $month_number){
        return date("t", strtotime("$year-$month_number-0"));
    }
    
    // return two digit month or day, e.g. 04 - April
    function zero_pad($number){
        if($number < 10)
            return "0$number";
        
        return "$number";
    }
    
    // Return quarters between tow dates. Array of objects
    function get_quarters($start_date, $end_date){
        
        $quarters = array();
        
        $start_month = date( 'm', strtotime($start_date) );
        $start_year = date( 'Y', strtotime($start_date) );
        
        $end_month = date( 'm', strtotime($end_date) );
        $end_year = date( 'Y', strtotime($end_date) );
        
        $start_quarter = ceil($start_month/3);
        $end_quarter = ceil($end_month/3);
    
        $quarter = $start_quarter; // variable to track current quarter
        
        // Loop over years and quarters to create array
        for( $y = $start_year; $y <= $end_year; $y++ ){
            if($y == $end_year)
                $max_qtr = $end_quarter;
            else
                $max_qtr = 4;
            
            for($q=$quarter; $q<=$max_qtr; $q++){
                
                $current_quarter = new stdClass();
                
                $end_month_num = zero_pad($q * 3);
                $start_month_num = ($end_month_num - 2);
    
                $q_start_month = month_name($start_month_num);
                $q_end_month = month_name($end_month_num);
                
            //    $current_quarter->period = "Qtr $q ($q_start_month - $q_end_month) $y";
                $current_quarter->period_start = "$y-$start_month_num-01";      // yyyy-mm-dd    
                $current_quarter->period_end = "$y-$end_month_num-" . month_end_date($y, $end_month_num);
                
                $quarters[] = $current_quarter;
                unset($current_quarter);
            }
    
            $quarter = 1; // reset to 1 for next year
        }
        
        return $quarters;
        
    }
}
    
 